<?php
/* @var $this CommentsWidget */
/* @var $model CActiveRecord - commentable model */
$model = $this->model;
?>

<div class="review-list">

<h3>Отзывы:</h3>

<?php 
/** @var CArrayDataProvider $comments */
$comments = $model->getCommentDataProvider();
$comments->setPagination(false);

$this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$comments,
	'itemView'=>'_viewReview',
	'template' => "{sorter}\n{items}",
	'emptyText' => !Yii::app()->user->isGuest ? 
		'Для данной организации пока нет отзывов, вы можете добавить свой' :
		'Для данной организации пока нет отзывов',
));

$this->render('_formReview');
?>
</div>

<script type="text/javascript">
<!--
var reviews = {
	setStarRating : function(rid, opts){
		$('#user_rating_'+rid+' > input').rating(opts || {readOnly:true});
	}
};
//-->
</script>