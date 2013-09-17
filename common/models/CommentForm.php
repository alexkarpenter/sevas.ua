<?php

/*
 * Model Coment for News
 */

/*
 * @author Alex
 */
class CommentForm extends CFormModel 
{
	public $comment;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			// comment are required
			array('comment', 'required')
		);
	}
	
}

?>
