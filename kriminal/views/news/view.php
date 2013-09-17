<?
/**
 * Отображение новости
 * @var $this Controller
 */
?>

<?php
	echo 'Soderzimoe novosti:<br>';
	echo $model->name;
?>	

	<div class="form">

<?
	if(!Yii::app()->user->isBlocked() && !Yii::app()->user->isGuest)
		$this->renderPartial( 'common.views.news._add_comment', array(
																	'commentForm' => $commentForm, 
																	'url'=>$url 
																));
	else
		echo '<a href="'.$this->createUrl('user/register').'">Зарегистрируйтесь, чтобы оставлять комментарии</a>';
?>

</div>

<div id="comment_wrap">
	<?php foreach ($model->comments as $comment) { ?>		

	<div class="comment" style="border: 1px solid; margin-bottom: 2px;">
		<?= "Дата: ".date( "Y-m-d", $comment->create_date); ?><br>
		<?= "Пользователь: ".$comment->user->name; ?><br>
		<img src="<?= $comment->user->avatarurl; ?>">
		<?= "Пользователь: ".$comment->user->avatarurl; ?><br>
		<?= "Текст комментария: $comment->text"; ?><br>
		
		<? if(Yii::app()->user->checkRole('admin')) { ?>
			<a href="<?= $this->createUrl('news/deletecomment',array('id_comment'=>$comment->id, 'back_url'=>$comment->news->url)) ?>">Удалить комментарий</a>
		<? } ?>
			
	</div>
		
	<?php } ?>
</div>
