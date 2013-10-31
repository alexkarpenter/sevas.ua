<?php
/**
 * CAttachmentAction handles file upload
 */

class CAttachmentAction extends CAction
{

	public $hostModelType;
	
	/**
	 * @var CActiveRecord
	 */
	public $hostModel;
	
	/**
	 * @var string - host model id (from query)
	 */
	public $hostId;
	
	/**
	 * @var string -  
	 */
	public $id;
	
	/**
	 * @var integer - number of slot (from query)
	 */
	public $index;
	
	/**
	 * @var string - name of host model behavior (from query)
	 */
	public $attach;
	
	/**
	 * @var CAttachmentBehavior
	 */
	public $attachBehavior;
	
	public function init()
	{
		$this->hostId = Yii::app()->getRequest()->getParam('hostId', null);
		if ($this->hostId === null)
			$this->error("request");
		$this->attach = Yii::app()->getRequest()->getParam('attach');
		$this->index = Yii::app()->getRequest()->getParam('index', 0);
		
		$type = $this->hostModelType;
		$this->hostModel = $model = $this->hostId ? $type::model()->findByPk($this->hostId) : new $type;
		if (!$model)
			$this->error("not found");
		
		if (!$this->attachBehavior = @$model->{$this->attach})
			$this->error("not found 2");
	}
	
	public function run()
	{
		$this->init();
		
		if (!$file = CUploadedFile::getInstanceByName('file'))
			$this->error('request');

		if ($this->attachBehavior->fileTypes)
			if (strpos($this->attachBehavior->fileTypes, $file->type) === false)
				$this->error('неразрешенный тип файла');
		
		if ($file->hasError)
			$this->error($this->fileUploadError($file->getError()));

		if (!$fileModel = $this->attachBehavior->saveUploadedFileTemp($file, $this->index))
			$this->error('file save error');
			
		//header('Content-type: application/json');
		echo json_encode(array('res' => true, 'file' => $this->attachBehavior->modelSerialize($fileModel)));
		Yii::app()->end();
	}

	public function error($msg)
	{
		$r = array('res' => false, 'message' => $msg);
		echo json_encode($r);
		Yii::app()->end();
	}

	private function fileUploadError($code)
	{
		switch ($code) {
			case UPLOAD_ERR_INI_SIZE:
				$message = "The uploaded file exceeds the upload_max_filesize directive in php.ini";
				break;
			case UPLOAD_ERR_FORM_SIZE:
				$message = "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form";
				break;
			case UPLOAD_ERR_PARTIAL:
				$message = "The uploaded file was only partially uploaded";
				break;
			case UPLOAD_ERR_NO_FILE:
				$message = "No file was uploaded";
				break;
			case UPLOAD_ERR_NO_TMP_DIR:
				$message = "Missing a temporary folder";
				break;
			case UPLOAD_ERR_CANT_WRITE:
				$message = "Failed to write file to disk";
				break;
			case UPLOAD_ERR_EXTENSION:
				$message = "File upload stopped by extension";
				break;
	
			default:
				$message = "Unknown upload error";
				break;
		}
		return $message;
	}	
	
    /**
     * Logs a message.
     *
     * @param string $message Message to be logged
     * @param string $level Level of the message (e.g. 'trace', 'warning',
     * 'error', 'info', see CLogger constants definitions)
     */
    public static function log($message, $level='error')
    {
        Yii::log($message, $level, __CLASS__);
    }

    /**
     * Dumps a variable or the object itself in terms of a string.
     *
     * @param mixed variable to be dumped
     */
    protected function dump($var='dump-the-object',$highlight=true)
    {
        if ($var === 'dump-the-object') {
            return CVarDumper::dumpAsString($this,$depth=15,$highlight);
        } else {
            return CVarDumper::dumpAsString($var,$depth=15,$highlight);
        }
    }
}
