<?php
/**
 * User: Alex
 * Date: 23.10.13
 * Time: 15:38
 */

class Gallery extends BaseActiveRecord
{
    public static function model($className=__CLASS__){
        return parent::model($className);
    }

    public function tableName(){
        return 'gallery';
    }

    public function relations()
    {
        return array(
            'files' => array(self::MANY_MANY, 'File', 'files_gallery(gallery_id, file_id)'),
        );
    }
}
