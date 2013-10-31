<?php
/**
 * User: ivan
 * Date: 17.10.13
 * Time: 14:17
 * Class File
 */

class File extends CActiveRecord
{
    public $file;

    static public function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function tableName()
	{
		return 'file';
	}

    public function behaviors()
    {
        return array(
            'CTimestampBehavior'=>array(
                'class' => 'zii.behaviors.CTimestampBehavior',
                'createAttribute' => 'create_date',
                'updateAttribute' => null,
            ),
        );
    }

    public function rules()
    {
        return array(
            array('title, descr, copyright', 'safe'),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels()
    {
        return array(
            'file'=>'Загруженные файлы',
        );
    }

    public function getReadableFileSize($retstring = null) {
        // adapted from code at http://aidanlister.com/repos/v/function.size_readable.php
        $sizes = array('bytes', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');

        if ($retstring === null) { $retstring = '%01.2f %s'; }

        $lastsizestring = end($sizes);

        foreach ($sizes as $sizestring) {
            if ($this->size < 1024) { break; }
            if ($sizestring != $lastsizestring) { $this->size /= 1024; }
        }
        if ($sizestring == $sizes[0]) { $retstring = '%01d %s'; } // Bytes aren't normally fractional
        return sprintf($retstring, $this->size, $sizestring);
    }

    /**
     * A stub to allow overrides of thumbnails returned
     * @since 0.5
     * @author acorncom
     * @return string thumbnail name (if blank, thumbnail won't display)
     */
    public function getFileUrl() {
        return $this->path;
    }
}