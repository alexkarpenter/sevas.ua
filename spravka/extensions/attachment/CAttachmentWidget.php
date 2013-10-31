<?php
/**
 * CAttachmentWidget class file. 
 */

class CAttachmentWidget extends CWidget
{

	/**
	 * host model wich has relations (attachments)
	 * @var CActiveRecord
	 */
	public $model;
	
	/**
	 * name of relation with attachment(s)
	 * @var string
	 */
	public $attr;
	
	/**
	 * behavior id in model
	 * @var string
	 */
	public $attachId;
	
	public $maxFiles = 5;
	
	/**
	 * html5 input multiselection 
	 * @var bool
	 */
	public $fileMultiSelect = true;
	
	public $assetUrl;
	
	public $uploadAction = 'attachmentUpload';
	
	public $view = 'attachments';
	
	public $viewItem = 'attachments_item';
	
	public function init() 
	{
		$this->assetUrl = Yii::app()->assetManager->publish(__DIR__.'/assets', false, -1, defined('YII_DEBUG'));
		if ($this->attr === null)
			$this->attr = $this->getAttachBehavior()->hostModelAttr;
		if (!$this->isMultiple())
			$this->maxFiles = 1;
		$this->fileMultiSelect = !$this->isMultiple() ? false : $this->fileMultiSelect;
	}
	
	public function run() 
	{
		$this->render('attachments');
	}
	
	public function isMultiple() 
	{
		static $multiple;
		if ($multiple !== null) return $multiple;
		$rs = $this->model->relations();
		$related = $rs[$this->attr];
		return $multiple = in_array($related[0], array(CActiveRecord::HAS_MANY, CActiveRecord::MANY_MANY));
	}
	
	/**
	 * @return CAttachmentBehavior
	 */
	public function getAttachBehavior() {
		return $this->model->{$this->attachId};
	}
	
	/**
	 * @return array
	 */
	public function getFilesArray()
	{
		$ms = $this->getAttachBehavior()->filesWithUserInput();
		if (count($ms) < $this->maxFiles) {
			$ms[] = $this->getEmptyFileModel(); // empty slot
		}
		$self = $this;
		$ms = array_map(function($m)use($self){ 
			return $self->getAttachBehavior()->modelSerialize($m); 
		}, $ms); 
		return $ms;
	}
	
	/**
	 * @return CActiveRecord
	 */
	public function getEmptyFileModel() {
		$type = $this->getAttachBehavior()->modelType;
		return new $type;
	}
	
	/**
	 * @return array
	 */
	public function getAttachmentData() 
	{
		$data = array(
			'hostType' => get_class($this->model),
			'hostId' => $this->model->id,
			'attr' => $this->attr,
			'maxFiles' => $this->maxFiles,
			'fileTypes' => $this->getAttachBehavior()->fileTypes,
			'fileMultiSelect' => $this->fileMultiSelect,
			'multiple' => $this->isMultiple(),
			'uploadUrl' => $this->getController()->createUrl($this->uploadAction, array('attach' => $this->attachId)),
			'ajaxIndicatorUrl' => $this->assetUrl.'/ajax-loader.gif',
			'files' => array_values( $this->getFilesArray() ),
			'emptyModel' => $this->getAttachBehavior()->modelSerialize($this->getEmptyFileModel()),
		);
		return $data;
	}
/*

data = {
	multiple:true,
	uploadUrl:"...",
	files:[
		{
			id:1,
			title:"t1",
			path:"/url1",
			pathPreview:"/urlpreview1"
		},
		{
			id:2,
			title:"t2",
			path:"/url2",
			pathPreview:"/urlpreview2"
		},
	]
}

*/
}
