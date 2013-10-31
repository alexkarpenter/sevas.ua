<?php
/* @var $this CommentsWidget */
/* @var $data Comment */
$data = isset($data) ? $data : $this->comment; // can be called from CListView or from CommentsWidget
?>
<div class="ext-comment" id="ext-comment-<?php echo $data->id; ?>">

	<div class="avatar-cell">
		<img class="avatar" alt="" src="http://placehold.it/60x60" >
	</div>

	<div class="content-cell">
		<div class="user-rating">
		<?
		$this->widget('CStarRatingX',
				array('value' => $data->rating, 'name' => "user_rating_{$data->id}", 'minRating' => 1, 'maxRating' => 5, 'readOnly' => true,
						'htmlOptions' => array('class' => 'user-rating') ));
		?>
		</div>
		<div class="comment-info">
			<span class="author-name"><?php echo CHtml::encode($data->userName); ?></span>
			<span class="ext-comment-date">
				<?php echo Yii::app()->dateFormatter->format( "HH:mm dd MMMM", $data->createDate ); ?>
			</span>
			
			<span class="ext-comment-options">
			<?php if (!Yii::app()->user->isGuest && (Yii::app()->user->id == $data->userId)) {
				///////// deleting
			    echo CHtml::ajaxLink(
					'delete', 
					array('/comment/comment/delete',), 
					array(
					'data' => array('id'=>$data->id, 'commentModel' => get_class($data), 'commentableModel' => $this->commentableType),
					'success'=>'function(){ $("#ext-comment-'.$data->id.'").remove(); }',
				    'type'=>'POST',
			    ), array(
				    'id'=>'delete-comment-'.$data->id, 'live' => false,
				    'confirm'=>'Удалить?',
			    ));
				echo " | ";
				////////// editing
				echo CHtml::ajaxLink(
					'edit', 
					array('/comment/comment/update'), 
					array(
					'data' => array('id'=>$data->id, 'commentModel' => get_class($data), 'commentableModel' => $this->commentableType),
					'replace'=>'#ext-comment-'.$data->id,
					'type'=>'GET',
				), array(
					'id'=>'ext-comment-edit-'.$data->id, 'live' => false,
				));
			} ?>
			</span>
			
		</div>
		<div class="clear"></div>
	
		<p class="comment-text"><?php echo nl2br(CHtml::encode($data->message)); ?></p>
		
	</div>

	<div class="clear"></div>
</div>
