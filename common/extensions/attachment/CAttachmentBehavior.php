<?php
/**
 * CAttachmentBehavior class file.
 *
 */

class CAttachmentBehavior extends CActiveRecordBehavior
{
	/**
	 * type of host model 
	 * @var string
	 */
	public $hostModelType;

	/**
	 * name of relation in host model
	 * @var string
	 */
	public $hostModelAttr;
	
	/**
	 * relation item type
	 * @var string
	 */
	public $modelType = 'File';
	
	/**
	 * upload restriction (comma separated mime types for input[@accept]) 
	 * @var string
	 */
	public $fileTypes;

	/**
	 * @var Callable
	 */
	public $thumbnailGeneratorFunc = 'thumbnailGenerate';
	
	public $useTempDir = true;
	public $uploadTempDir = 'webroot.upload.temp';
	public $uploadDir = 'webroot.upload';
	public $uploadEntityDir;
	public $uploadEntityDirTemplate = '{$this->uploadDir}/{$this->hostModelType}/{$this->getOwner()->id}'; // like a '/var/www/upload/org/1' 
	
	public $input;
	
	public $sessionKeyFormat = '{$this->hostModelType}_{$this->getOwner()->id}_{$this->hostModelAttr}';
	public $sessionKey; // entity/user specific key, will be like this 'Entity_1_files'
	
	public $reTemplateString = '#\{(?=\$)([^\}]+)\}#e';

	const stFileEmpty = 'empty';
	const stFileLoading = 'loading';
	const stFileLoaded = 'loaded';
	const stFileError = 'error';
	
	public function init()
	{
		$this->hostModelType = get_class($this->getOwner());
		$this->uploadDir = Yii::getPathOfAlias($this->uploadDir);
		$this->uploadTempDir = Yii::getPathOfAlias($this->uploadTempDir);
		$this->uploadEntityDir = strtolower( preg_replace( $this->reTemplateString, '\1', $this->uploadEntityDirTemplate ) );
		$this->sessionKey = preg_replace( $this->reTemplateString, '\1', $this->sessionKeyFormat );
	}
	
	public function attach($owner)
	{
		parent::attach($owner);
		$this->init();
	}

	/**
	 * @see CBehavior::getOwner()
	 * @return CActiveRecord
	 */
	public function getOwner()
	{
		return parent::getOwner();
	}
	
	/**
	 * Сохранение во временном каталоге, 
	 * создание файловой модели, сохранение в сессии
	 * @param CUploadedFile $file
	 * @param int $index
	 * @return CActiveRecord
	 */
	public function saveUploadedFileTemp($file, $index=0)
	{
		$path = $this->uploadTempDir.'/'.$file->name;
		$file->saveAs($path, false);
		
		/* @var $model CActiveRecord */
		$model = new $this->modelType;
		$model->id = $this->generateTmpId();
		$model->name = $file->name;
		$model->path = $this->convertPath2Rel($path);
		$model->type = $file->type;
		$model->size = $file->size;
		
		$this->fileToState($model, $index);
		return $model;
	}
	
	public function generateTmpId() {
		$tmpId = Yii::app()->user->getState('tmpId', 0);
		Yii::app()->user->setState('tmpId', ++$tmpId);
		return -$tmpId;
	}
	
	/**
	 * сохранение в сессии файлов загруженных через ajax
	 * @param CActiveRecord $file
	 * @param number $index
	 */
	public function fileToState($file, $index=0) 
	{
		$fs = $this->filesFromState();
		$fs[$index] = $this->modelSerialize($file);
		Yii::app()->user->setState($this->sessionKey, $fs);
	}
	
	/**
	 * очистка кеша ajax-файлов после успешного сохранения
	 */
	public function clearState()
	{
		Yii::app()->user->setState($this->sessionKey, null);
	}
	
	/**
	 * временное сессионное хранилище сериализованных моделей, для текущей сущности и текущего поля 
	 * @return CActiveRecord[]
	 */
	public function filesFromState()
	{
		$fsdata = Yii::app()->user->getState($this->sessionKey, array());
		$self = $this;
		$fs = array_map(function($fdata)use($self){ return $self->modelDeserialize($fdata); }, $fsdata);
		return $fs;
	}

	/**
	 * Массив моделей файлов с учетом пользовательского POST
	 * @return array
	 */
	public function filesWithUserInput()
	{
		$v = $this->getRelation();
		$currents = is_array($v) ? $v : (is_null($v) ? array() : array($v));
		$currentsById = $this->entitesById($currents);
		
		if ($this->input === null) {
			// нет поста - отдать то, что есть в БД
			return $currentsById;
		}
		
		$newsViaAjax = $this->filesFromState(); // File[]
		$newsViaAjaxById = $this->entitesById($newsViaAjax);
		
		$files = array();
		foreach ($this->input as $id => $filePost) {
			if (empty($id)) continue;
			if (!($file = ($id > 0 ? @$currentsById[$id] : @$newsViaAjaxById[$id]))) continue;
			$file->attributes = $filePost;
			$files[$id] = $file;
		}
		return $files;
	}
	
	public function modelSerialize($model) {
		$attrs = $model->attributes;
		$attrs['state'] = empty($model->id) ? self::stFileEmpty : self::stFileLoaded;
		if (!empty($this->thumbnailGeneratorFunc))
		{
			$func = $this->thumbnailGeneratorFunc;
			if (is_string($func) && (is_callable(array($this, $func))))
				$func = array($this, $func);
			$attrs['pathPreview'] = call_user_func($func, $model, $this);
		}
		return $attrs;
	}
	
	public function modelDeserialize($data) {
		/* @var $model CActiveRecord */
		$model = new $this->modelType;
		foreach ($data as $k => $v) {
			if ($model->hasAttribute($k))
				$model->$k = $v;
		}
		return $model;
	}
	
	public function convertPath2Rel($path, $rootAlias='webroot') {
		$root = Yii::getPathOfAlias($rootAlias);
		return str_replace($root, '', $path);
	}
	
	public function convertPath2Abs($path, $rootAlias='webroot') {
		$root = Yii::getPathOfAlias($rootAlias);
		return $root.$path;
	}

	public function convertRelTempPath2Permanent($path) {
		$name = basename($path);
		return $this->uploadEntityDir.'/'.$name;
	}
	
	public function beforeSave($event)
	{
		return;
	}
	
	/**
	 * Сбор и переформатирование табличного ввода пользователя 
	 * Нужно вызывать в контроллере, для каждого аттачмента
	 * @param array $post
	 */
	public function collectUserInput($post)
	{
		if (!$input = @$post[$this->hostModelAttr]) return;
		$fields = array_keys($input);
		$ff = $fields[0];
		$modelCount = count($input[$ff]);
		$models = array();
		for ($i=0; $i<$modelCount; $i++) {
			$model = array();
			foreach ($fields as $f) {
				$model[$f] = $input[$f][$i];
			}
			$models[$model['id']] = $model;
		}
		$this->input = $models;
		return;
	}
	
	/**
	 * Обновление аттачмента
	 */
	public function updateRelation()
	{
		if ($this->input === null)
			return;
		if ($this->isMultiple())
			$this->updateRelationMultiple();
		else
			$this->updateRelationSingle();
	}
	
	public function getRelation() 
	{
		$owner = $this->getOwner();
		return $owner->{$this->hostModelAttr};
	}
	
	public function setRelation($v)
	{
		$owner = $this->getOwner();
		$owner->{$this->hostModelAttr} = $v;
	}
	
	public function updateRelationSingle()
	{
		$current = $this->getRelation(); // File
		$fs = $this->filesFromState();
		$newViaAjax = empty($fs) ? null : reset($fs); // File
		$newViaPost = reset($this->input); // array

		$model = null;
		if ($newViaPost['id'] > 0) {
			if (!$current || $current->id != $newViaPost['id']) return;
			$model = $current;
		} elseif ($newViaPost['id'] < 0) {
			if (!$newViaAjax || $newViaAjax->id != $newViaPost['id']) return;
			$model = $newViaAjax;
			$model->id = null;
			if ($current) {
				$this->deleteAfterSave[] = $current; // record replaced
			}
		} else {
			if ($current) {
				$this->deleteAfterSave[] = $current; // record deleted
				$this->setRelation(null);
			}
			return;
		}
		$model->attributes = $newViaPost;
		$this->saveFileModel($model);
		$this->setRelation($model);
	}

	public function updateRelationMultiple() 
	{
		$currents = $this->getRelation(); // File[]
		$newsViaAjax = $this->filesFromState(); // File[]
		$newsViaPost = $this->input; // array()
		
		$currentsById = $this->entitesById($currents);
		$newsViaPostById = $this->entitesById($newsViaPost);
		$newsViaAjaxById = $this->entitesById($newsViaAjax);
		
		// detect droped entities
		$currentsToDelete = array_diff_key($currentsById, $newsViaPostById);
		if (!empty($currentsToDelete)) 
			$this->deleteAfterSave = array_merge($this->deleteAfterSave, $currentsToDelete);
		
		$models = array(); // updated models array
		foreach ($newsViaPostById as $id => $newViaPost)
		{
			if (empty($id)) continue; // posted empty slot
			if ($id > 0) { 
				// updating persisted
				if (!$model = @$currentsById[$id]) continue; // wrong input
				$model->attributes = $newViaPost; // update posted attributes
			} else {
				// create new
				if (!$newViaAjax = $model = @$newsViaAjaxById[$id]) continue; // wrong input
				$model->id = null;
				$model->attributes = $newViaPost; // set posted attributes
			}
			$this->saveFileModel($model);
			$models[] = $model;
		}
		
		$this->setRelation($models);
	}

	/**
	 * Сохранение модели, и перенос файла из временного каталога в постоянный
	 * @param CActiveRecord $file
	 */
	private function saveFileModel($file)
	{
		if (!$file->id) {
			// move files
			$pathTmpAbs = $this->convertPath2Abs($file->path);
			$pathPermAbs = $this->convertRelTempPath2Permanent($file->path);
			$this->fileRename($pathTmpAbs, $pathPermAbs); // delayed file rename
			$newPath = $this->convertPath2Rel($pathPermAbs);
			$file->path = $newPath; // file relocation
		}
		$file->save(false);
	}
	
	private function entitesById($es) {
		$es2 = array();
		foreach ($es as $e) {
			$id = is_object($e) ? $e->id : $e['id'];
			$es2[$id] = $e;
		}
		return $es2;
	}
	
	/**
	 * entities must be deleted
	 * @var array
	 */
	public $deleteAfterSave = array();
	
	public function afterSave($event)
	{
		foreach ($this->deleteAfterSave as $model) {
			$model->delete();
			$this->fileUnlink($this->convertPath2Abs($model->path));
		}
		
		$this->runFileOperations();
		
		$this->clearState();
		
		return;
	}
	
	public function isMultiple()
	{
		$rs = $this->getOwner()->relations();
		$related = $rs[$this->hostModelAttr];
		return in_array($related[0], array(CActiveRecord::HAS_MANY, CActiveRecord::MANY_MANY));
	}
	
	/**
	 * запланированные файловые операции в виде
	 * array(
	 * 		array('rename', 'path1', 'path2'),
	 * )
	 * @var array
	 */
	public $fileOps = array();
	
	protected function fileUnlink($path) {
		$this->fileOps[] = array('unlink', $path);
	} 
	
	protected function fileRename($pathOld, $pathNew) {
		$this->fileOps[] = array('rename', $pathOld, $pathNew);
	}
	
	public function runFileOperations()
	{
		foreach ($this->fileOps as $item)
		{
			$fop = $item[0];
			$params = array_slice($item, 1);
			foreach ($params as $path) {
				if (strncmp($this->uploadDir, $path, strlen($this->uploadDir))) {
					$this->setHostError('file operation outside of uploadDir: '.$path);
					continue;
				}
			}
			
			if ($fop == 'rename') {
				$newDirPath = dirname($params[1]);
				if (!file_exists($newDirPath)) {
					mkdir($newDirPath, 0777, true);
				}
			}
			$res = @call_user_func_array($fop, $params);
			if (!$res) {
				$err = sprintf("file operation error %s(%s)", $fop, implode(',', $params));
				if (in_array($fop, array('rename'))) {
					$this->setHostError($err);
				} else {
					$this->log($err, 'warning');
				}
			}
		}
	}
	
	public $errors = array();
	
	public function hasErrors() {
		return !empty($this->errors);
	}
	
	public function setHostError($err)
	{
		$this->log($err);
		$this->errors[] = $err;
		$this->getOwner()->addError($this->hostModelAttr, $err);
	}
	
	public function thumbnailGenerate($model, $behavior) {
		return $model->path;
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
