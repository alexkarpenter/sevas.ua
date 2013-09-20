<?php
class NewsForm extends CFormModel 
{
	public $name;
	public $text_description;
	public $text;
	public $title;
	public $keywords;
	public $name_category;
	public $h1;
	public $fl_block;
	public $file;

	public function rules()
	{
		return array(
			array('name, text_description, text title', 'required'),
			array('file', 'file',
                'allowEmpty' => true,
                'types'      => 'gif, jpg, jpeg, png',
                'mimeTypes'  => 'image/gif, image/jpeg, image/png',
                'maxSize'    => 500000,
                'maxFiles'   => 1,
            ),
		);
	}
	
	public function attributeLabels()
	{
		return array(
			'name'=>'Именование новости',
			'text_description'=>'Описание',
			'text'=>'Текст',
			'title'=>'Заголовок',
			'keywords'=>'Ключевые слова',
			'name_category'=>'Именование категории',
			'h1'=>'H1',
			'fl_block' => 'Публицировать'
		);
	}
	
}

?>