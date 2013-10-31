<?php

Yii::import('spravka.models._base.BaseOrganization');

class Organization extends BaseOrganization
{	
	public $csIds = false;
	
	public function behaviors(){
		return array(
				'CTimestampBehavior' => array(
						'class' => 'zii.behaviors.CTimestampBehavior',
						'createAttribute' => 'created_at',
						'updateAttribute' => 'updated_at',
						'setUpdateOnCreate' => true,
				),
				'attachFiles' => array(
						'class' => 'ext.attachment.CAttachmentBehavior',
						'hostModelAttr' => 'files',
						'fileTypes' => 'image/gif,image/png,image/jpeg,image/jpg,image/svg',
				),
		
				'taggable' => array(
						'class' => 'ext.yiiext-taggable.ETaggableBehavior',
						'tagTable' => 'tag',
						'tagBindingTable' => 'org_tag',
						'modelTableFk' => 'org_id',
						'tagTablePk' => 'id',
						'tagTableName' => 'name',
						// Имя поля счетчика тега
						// Если устанвовлено в null (по умолчанию), то не сохраняется в базе
						//'tagTableCount' => 'count',
						'tagBindingTableTagId' => 'tag_id',
						// ID компонента, реализующего кеширование. Если false кеширование не происходит.
						// По умолчанию ID равен false.
						//'cacheID' => 'cache',
						// Создавать несуществующие теги автоматически.
						// При значении false сохранение выкидывает исключение если добавляемый тег не существует.
						'createTagsAutomatically' => true,
				),
				
				//'advancedAr' => array( 'class' => 'ext.CAdvancedArBehavior' ),
		        'withRelated' => array( 'class'=>'ext.WithRelatedBehavior', ),
				'activerecord-relation' => array( 'class'=>'ext.EActiveRecordRelationBehavior', ),
				
				'commentable' => array(
						'class' => 'common.extensions.comment-module.behaviors.CommentableBehavior',
						'commentModelClass' => 'comment.models.Review',
						'mapTable' => 'org_review',
						'mapRelatedColumn' => 'org_id',
						'mapCommentColumn' => 'review_id',
				),				
		);
	}

	public function rules() {
		return array_merge(
				array(
					array('slug', 'filter', 'filter' => array($this, 'slugFilter')),
					array('regime', 'filter', 'filter' => array($this, 'regimeFilter')),
					array('categoriesIds', 'safe'),
					array('categories', 'categoriesValidator'),
					//array('categories', 'filter', 'filter' => array($this, 'categoriesFilter')),
					array('phone', 'unsafe'), // setting via phones
					array('phones, tagsText, mainPhotoIndex', 'safe'),
				),
				parent::rules(),
				array(
				)
		);
	}
	
	/**
	 * ЧПУ
	 */
	public function slugFilter($slug)
	{
		if (empty($slug)) {
			return Utils::translitForUrl($this->name);
		} else {
			return $slug;
		}
	}
	
	public function regimeFilter($regime)
	{
		$data = $this->getRegimeData($regime);
		$regime = $this->getRegimeFromData($data);
		return $regime;
	}
	
	// режим из строки в массив, с валидацией
	/*
	 		return array( 
			'days' => array(
				'pn' => array('label' => 'пн', 'on' => true, 's' => '08:00', 'e' => '17:00', 'vo' => true, 'os' => '13:00', 'oe' => '14:00'),
				'vt' => array('label' => 'вт', 'on' => false, 's' => '09:00', 'e' => '18:00', 'vo' => false, 'os' => '', 'oe' => ''),
				...
	 */
	public function getRegimeData($regime=null) {
		$regime = $regime ?: $this->regime;
		$ddayEmpty = array('on' => false, 's'=>'', 'e'=>'', 'vo'=>false, 'os'=>'', 'oe'=>'');
		$data = array(
			'days' => array(
				'pn' => array('label' => 'пн',),
				'vt' => array('label' => 'вт',),
				'sr' => array('label' => 'ср',),
				'ch' => array('label' => 'чт',),
				'pt' => array('label' => 'пт',),
				'sb' => array('label' => 'сб',),
				'vs' => array('label' => 'вс',),
			)
		);
		
		$tdays = explode('|', $regime);
		if (count($tdays) != 7) $tdays = array_fill(0, 7, '');
		
		$codes = array_keys($data['days']);
		foreach ($tdays as $i => $tday) {
			$code = $codes[$i];
			if (!preg_match('#^(?<s>\d{2}:\d{2})-(?<e>\d{2}:\d{2})(?:\((?<os>\d{2}:\d{2})-(?<oe>\d{2}:\d{2})\))?#i', $tday, $ms)) {
				$day = $ddayEmpty;
			} else {
				$day = array_merge(
						$ddayEmpty, 
						array_intersect_key($ms, array_flip(array('s', 'e', 'os', 'oe'))));
				$day['on'] = true;
				$day['vo'] = !empty($day['os']);
			}
			$data['days'][$code] = array_merge($data['days'][$code], $day);
		}
		
		return $data;
	}
	
	// режим из массива в строку
	public function getRegimeFromData($data, $setEmpty=true) {
		$days = array();
		foreach ($data['days'] as $dday) {
			if (!$dday['on']) {
				$day = '';
			} else {
				$day = sprintf('%s-%s%s', 
						$dday['s'], $dday['e'], (@$dday['vo'] ? "({$dday['os']}-{$dday['oe']})" : '') ); 
			}
			$days[] = $day;
		}
		$rstring = implode('|', $days);
		if ($setEmpty && $rstring == '||||||')
			$rstring = null;
		return $rstring;
	}
	
	public function categoriesValidator($attr, $params)
	{
		if (empty($this->categories)) {
			$this->addError($attr, "Должна быть выбрана хотя бы одна категория");
		} elseif (count($this->categories) > 5) {
			$this->addError($attr, "Максимальное количество категорий - 5");
		}
	}
	
	public function getCategoriesIds() {
		return array_map(function($c){ return $c->id; }, $this->categories);
	}
	
	public function setCategoriesIds($ids) {
		$this->categories = Category::model()->findAllByPk($ids);
	}
	
	public function getPhones() {
		return explode("\n", $this->phone);
	}
	
	/**
	 * @param array $v
	 */
	public function setPhones($v) {
		$this->phone = is_array($v) ? implode("\n", array_filter($v)) : null;
	}
	
	public function getTagsText() {
		return implode(', ', $this->tags);
	}
	
	public function setTagsText($v) {
		$this->setTags($v);
	}
	
	// из ид в индекс
	public function getMainPhotoIndex() {
		$i = array_search($this->image_id, array_map(function($f){ return $f->id; }, $this->files));
		return intval($i);
	}
	
	// индекс в ид
	public function setMainPhotoIndex($v) {
		$image = @$this->files[$v] ?: @$this->files[0];
		$this->image_id = $image ? $image->id : null;
	}
	
	public function afterFind()
	{
		parent::afterFind();
		
	}
	
	/**
	 * @return Organization
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
	
	/**
	 * named-scope
	 * @return Organization
	 */
	public function checked()
	{
		$this->getDbCriteria()->addColumnCondition(array('t.checked' => true));
		return $this;
	}
	
	public function getSiteEncoded()
	{
		if (!$this->site) 
			return $this-site;
		$site = (strpos($this->site, 'http')!==0) ? 'http://'.$this->site : $this->site;
		require_once(Yii::getPathOfAlias('system.vendors.idna_convert').DIRECTORY_SEPARATOR.'idna_convert.class.php');
		$c = new idna_convert();
		return $c->encode_uri($site);
	}

	public function getLink($params=null) {
		return CHtml::link($this->name, $this->getUrlData($params));
	}
	
	public function getUrlData($params=null) {
		$data = array('sprav/org', 'slug' => $this->slug);
		return empty($params) ? $data : array_merge($data, $params);
	}
		
	public function getBreadcrumbsData($selfLink=true) {
		$data = array();
		if ($c = $this->mainCategory)
			$data = $c->getBreadcrumbsData();
		$data[] = $this->name;
		return $data;
	}
	
	public function ratingRecalc() {
		$count = count($this->reviews);
		if (empty($count)) {
			$this->rating = null;
		} else {
			$sum = 0;
			foreach ($this->reviews as $r) {
				/* @var $r Review */
				$sum += $r->rating;
			}
			$this->rating = $sum / $count;
		}
		$this->saveAttributes(array('rating'));
	}
	
	/**
	 * @param CommentEvent $event
	 */
	public function onUpdateComment($event) {
		$this->ratingRecalc();
	}
	
	public function onDeleteComment($event) {
		$this->ratingRecalc();
	}
	
	
}