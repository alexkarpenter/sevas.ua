<?php

Yii::import('application.models._base.BaseFile');

class File extends BaseFile
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
	
	public function behaviors()
	{
		return array(
				'commentable' => array(
						'class' => 'comment.behaviors.CommentableBehavior',
						'commentModelClass' => 'comment.models.Comment',
						'mapTable' => 'file_comment',
						'mapRelatedColumn' => 'file_id',
						'mapCommentColumn' => 'comment_id',
				),
		);
	}
}