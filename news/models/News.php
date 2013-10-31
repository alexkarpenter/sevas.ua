<?php
/**
 * Class News
 */

class News extends CActiveRecord
{
    public $display_in_category;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'news';
    }

    public function relations()
    {
        return array(
            'rating' => array(self::HAS_MANY, 'Rating', 'obj_id'),
            'relation_news' => array(self::HAS_MANY, 'RelationNews', 'news_id'),
            'coordinate_news' => array(self::HAS_ONE, 'CoordinateNews', 'news_id'),
            'comments' => array(self::HAS_MANY, 'Comment', 'news_id'),
            'user' => array(self::BELONGS_TO, 'User', 'author_id'),
            'categories' => array(self::MANY_MANY, 'Category', 'news_category_relation(news_id, category_id)'),
            'image' => array(self::BELONGS_TO, 'File', 'image_id'),
            'files' => array(self::MANY_MANY, 'File', 'news_file_relation(news_id, file_id)'),
        );
    }

    public function behaviors()
    {
        return array(
            'CTimestampBehavior'=>array(
                'class' => 'zii.behaviors.CTimestampBehavior',
                'createAttribute' => 'create_date',
                'updateAttribute' => 'update_date'
            ),
            'attachMainImage' => array(
                'class' => 'common.extensions.attachment.CAttachmentBehavior',
                'hostModelAttr' => 'image',
                'uploadTempDir' => 'webroot.uploads.temp',
                'uploadDir' => 'webroot.uploads',
				'fileTypes' => 'image/jpeg,image/jpg',
            ),
            'attachFiles' => array(
                'class' => 'common.extensions.attachment.CAttachmentBehavior',
                'hostModelAttr' => 'files',
                'uploadTempDir' => 'webroot.uploads.temp',
                'uploadDir' => 'webroot.uploads',
				'fileTypes' => 'image/jpeg,image/jpg',
            ),
            'withRelated' => array( 'class'=>'spravka.extensions.WithRelatedBehavior', ),
        );
    }

    public function rules()
    {
        return array(
            array('name, text_description, text, title, meta_keywords, name_bread, url', 'required'),
            array('status', 'safe')
        );
    }

    public function attributeLabels()
    {
        return array(
            'name'=>'Именование новости',
            'text_description'=>'Описание',
            'text'=>'Текст',
            'title'=>'Заголовок',
            'meta_keywords'=>'Ключевые слова',
            'name_h1'=>'Заголовок для H1',
            'status' => 'Статус',
            'image' => 'Главная картинка',
            'name_bread' => 'Хлебные крошки',
            'url' => 'ЧПУ',
            'User.name' => 'Автор',
            'create_date' => 'Дата создания',
            'File.copyright' => 'Дата',
            'display_in_category' => 'Отображать в категориях',
            'files' => 'Галерея картинок',
        );
    }

    public static function getIdByUrl($url)
    {
        $model=News::model()->find(array(
            'condition'=>'url=:urlID',
            'params'=>array(':urlID'=>$url),
        ));

        return (int)($model->id);
    }

    public function setRelationsWithFiles()
    {
        NewsFileRelation::model()->deleteAll("news_id = $this->id");
        foreach($this->files as $file)
        {
            $relation = new NewsFileRelation();
            $relation->news_id = $this->id;
            $relation->file_id = $file->id;
            $relation->save(false);
        }
        return ;
    }

    protected function afterSave()
    {
        parent::afterSave();
//        if ($this->image && strpos($this->imgBehavior->extension, $this->image->extensionName) !== FALSE) {
//            $path = $this->imgBehavior->getFolderPath().'/'.$this->id;
//
//            if(!is_dir($path))
//            {
//                mkdir($path, 0777, true);
//                chmod($path, 0777);
//            }
//            $fname = $this->getFileName();
//            $this->imgBehavior->deleteFile($path, $fname);
//            Controller::debug($this->image->extensionName);
//            $this->imgBehavior->saveFile($this->image, $path, $fname, $this->image->extensionName);
//            $this->updatebyPk($this->id, array('img' => $fname.'.'.$this->image->extensionName));
//        }
    }

//    public function getFiles()
//    {
//        return File::model()->findAll(array(
//            'alias' => 'f',
//            'condition' => 'g.type='.GalleryTypeEnum::GALLERY_NEWS.' AND g.obj_id='.$this->id,
//            'join' => 'INNER JOIN `files_gallery` AS fg ON f.id=fg.file_id
//                       INNER JOIN `gallery` AS g ON g.id = fg.gallery_id'
//        ));
//    }
}
