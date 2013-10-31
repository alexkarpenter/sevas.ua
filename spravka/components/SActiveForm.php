<?php

class SActiveForm extends CActiveForm
{
	public function textFieldArray($model,$attribute,$htmlOptions=array())
	{
		// todo: use templates for markup
		CHtml::resolveNameID($model, $attribute, $htmlOptions);
		$htmlOptions['name'] .= '[]';
		$values = $model->$attribute;
		$inputs = array();
		$num = count($values);
		foreach (array_values($values) as $i => $v) {
			$last = $i == ($num-1);
			$input = CHtml::textField($htmlOptions['name'], $v, $htmlOptions);
			$input = '<span class="input-item">'.$input.'<a class="input-remove"><i class="icon-remove"></i></a> </span>'.
				($last ? '<a class="input-add"><i class="icon-plus-sign"></i></a>' : '');
			$inputs[] = $input;
		}
		
		$script =<<<SCR
			var arr = $(".input-array");
			arr.on('click', '.input-remove', function(){
				var slot = $(this).closest('.input-item');
				if (slot.siblings('.input-item').length > 0) {
					slot.remove();
				} else {
					slot.find("input").val(""); // just clear
				}
			});
			arr.find(".input-add").click(function(){
				var slot = $(this).siblings('.input-item:last');
				//$('<br>').insertBefore(this);
				slot.clone().insertBefore(this).find('input').val('');
			});
SCR;
		Yii::app()->clientScript->registerScript('textFieldArray', $script, CClientScript::POS_READY);
		
		return '<span class="input-array">'.implode("\n", $inputs).'</span>';
	}

	public function textFieldArrayRow($model,$attribute,$htmlOptions=array())
	{
		return $this->formRow($model, $attribute, $htmlOptions, 
				$this->textFieldArray($model, $attribute, $htmlOptions));
	}

	public function textFieldRow($model,$attribute,$htmlOptions=array())
	{
		return $this->formRow($model, $attribute, $htmlOptions,
				parent::textField($model, $attribute, $htmlOptions));
	}

	public function urlFieldRow($model,$attribute,$htmlOptions=array())
	{
		return $this->formRow($model, $attribute, $htmlOptions,
				parent::urlField($model, $attribute, $htmlOptions));
	}
	
	public function textAreaRow($model,$attribute,$htmlOptions=array())
	{
		return $this->formRow($model, $attribute, $htmlOptions, 
				parent::textArea($model, $attribute, $htmlOptions));
	}

	public function checkBoxRow($model,$attribute,$htmlOptions=array())
	{
		return $this->formRow($model, $attribute, $htmlOptions,
				parent::checkBox($model, $attribute, $htmlOptions));
	}

	public function fileFieldRow($model,$attribute,$htmlOptions=array())
	{
		return $this->formRow($model, $attribute, $htmlOptions,
				parent::fileField($model, $attribute, $htmlOptions));
	}
	
	public function dropDownListRow($model,$attribute,$data,$htmlOptions=array())
	{
		return $this->formRow($model, $attribute, $htmlOptions, 
				parent::dropDownList($model, $attribute, $data, $htmlOptions));
	}
	
	public function formRow($model,$attribute,$htmlOptions=array(),$content='')
	{
		$label = $this->labelEx($model, $attribute);
		$error = $this->error($model, $attribute);
		$row = <<<ROW
		<div class="row">
			{$label}
			{$content}
			{$error}
		</div>
ROW;
		return $row;
	}
	
	public function formRowStart($model,$attribute,$htmlOptions=array())
	{
		$label = $this->labelEx($model, $attribute);
		$row = <<<ROW
		<div class="row">
			{$label}
ROW;
		return $row;
	}
	
	public function formRowEnd($model,$attribute,$htmlOptions=array())
	{
		$error = $this->error($model, $attribute);
		$row = <<<ROW
			{$error}
		</div>
ROW;
		return $row;
	}
}