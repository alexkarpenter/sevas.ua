<?php
/* @var $this CommentsWidget */
$comment = $this->comment;
$commentableModel = $this->commentableType;
?>
<?php if (Yii::app()->user->isGuest) {
?><div class="ext-comment-not-loggedin">
</div><?php } else { ?>
<div id="ext-comment-form-<?php echo $comment->isNewRecord ? 'new' : 'edit-'.$comment->id; ?>" class="form">

<?php $form = $this->beginWidget('SActiveForm', array(
	'id'=>'ext-comment-form',
    'action'=>array('/comment/comment/create'),
	'enableAjaxValidation'=>false
)); ?>

	<?php /* @var $form SActiveForm */
	echo $form->errorSummary($comment);
	echo CHtml::hiddenField('commentModel', get_class($comment));
	echo CHtml::hiddenField('commentableModel', @$commentableModel);
	?>
	
	<?php echo $form->textAreaRow($comment,'message',array('rows'=>6, 'cols'=>50)); ?>

	<div class="row buttons">
	    <?php if ($comment->isNewRecord) {
	    	echo $form->hiddenField($comment, 'type');
	    	echo $form->hiddenField($comment, 'key');
	    	
			echo CHtml::ajaxSubmitButton('Отправить',
                array('/comment/comment/create'),
		        array(
                    'replace'=>'#ext-comment-form-new',
                    'error'=>"function(){
                        $('#Comment_message').css('border-color', 'red');
                        $('#Comment_message').css('background-color', '#fcc');
                    }"
		        ),
		        array('id'=>'ext-comment-submit' . (Yii::app()->request->isAjaxRequest ? time() : ''), 'live' => false,)
		    );
		} else {
			echo $form->hiddenField($comment, 'type');
			echo CHtml::ajaxSubmitButton('Изменить',
				array('/comment/comment/update', 
					'id'=>$comment->id, 'commentModel' => get_class($comment), 'commentableModel' => @$commentableModel),
				array(
					'replace'=>'#ext-comment-form-edit-'.$comment->id,
					'complete' => 'function(){ reviews.setStarRating("'.$comment->id.'") }',
					'error'=>"function(){}"
		        ),
		        array('id'=>'ext-comment-submit' . (Yii::app()->request->isAjaxRequest ? time() : ''), 'live' => false,)
	        );
		}
		?>
	</div>

<?php $this->endWidget() ?>

</div><!-- form -->
<?php } ?>