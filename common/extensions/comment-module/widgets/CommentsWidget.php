<?php

class CommentsWidget extends CWidget 
{
	/**
	 * commentable model
	 * @var CActiveRecord
	 */
	public $model;
	
	/**
	 * @var Comment
	 */
	public $comment;
	
	/**
	 * @var string class name of $model
	 */
	public $commentableType;
	
	/**
	 * @var string class name of $comment
	 */
	public $commentType;
	
	
	public $view = 'commentList';
	
	public function init()
	{
		if ($this->model)
			$this->commentableType = get_class($this->model);
		elseif ($this->commentableType)
			$this->model = Yii::createComponent($this->commentableType);
			
		if ($this->comment)
			$this->commentType = get_class($this->comment);
		
		if (!$this->comment && !$this->commentType) {
			$b = $this->getCommentableBehavior();
			$this->commentType = $b->commentModelClass;
			$this->comment = $this->model->commentInstance;
		}
	}
	
	/**
	 * @return CommentableBehavior
	 */
	public function getCommentableBehavior() {
		return $this->model->commentable;
	}
	
	public function run()
	{
		$this->render($this->view, array());
	}
	
}