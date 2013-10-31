<?php
/**
 * 
 * CStarRating с учетом дробных средних значений 
 *
 */
class CStarRatingX extends CStarRating
{
	protected function renderStars($id, $name) {
		$inputCount=(int)(($this->maxRating-$this->minRating)/$this->ratingStepSize+1);
		$starSplit=(int)($inputCount/$this->starCount);
		if($this->hasModel())
		{
			$attr=$this->attribute;
			CHtml::resolveName($this->model,$attr);
			$selection=$this->model->$attr;
		}
		else
			$selection=$this->value;

		// set number to descreet steps
		$selection = round($selection / $this->ratingStepSize) * $this->ratingStepSize;
		
		$options=$starSplit>1 ? array('class'=>"{split:{$starSplit}}") : array();
		for($value=$this->minRating, $i=0;$i<$inputCount; ++$i, $value+=$this->ratingStepSize)
		{
			$options['id']=$id.'_'.$i;
			$options['value']=$value;
			if(isset($this->titles[$value]))
				$options['title']=$this->titles[$value];
			else
				unset($options['title']);
			echo CHtml::radioButton($name,!strcmp($value,$selection),$options) . "\n";
		}
		
	}
}