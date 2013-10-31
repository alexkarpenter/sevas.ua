<?php
/* @var $this CommentsWidget */
/* @var $model CActiveRecord - commentable model */
$model = $this->model;
?>

<div class="comment-list">

<?php

/** @var CArrayDataProvider $comments */
$comments = $model->getCommentDataProvider();
$comments->setPagination(false);

$this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$comments,
	'itemView'=>'_view',
	'template' => "{sorter}\n{items}",
	'emptyText' => 'Нет комментариев',
));

$this->render('_form');
?>

</div>