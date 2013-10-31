<?php

/**
 * This is the model base class for the table "organization".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Organization".
 *
 * Columns in table "organization" available as properties of the model,
 * followed by relations of table "organization" available as properties of the model.
 *
 * @property integer $id
 * @property string $name
 * @property string $name_h1
 * @property string $slug
 * @property string $address
 * @property string $phone
 * @property string $email
 * @property string $site
 * @property string $anonse
 * @property string $descr
 * @property string $regime
 * @property float $rating
 * @property integer $geocoder
 * @property integer $geoexact
 * @property double $geolat
 * @property double $geolon
 * @property string $options
 * @property string $created_at
 * @property string $updated_at
 * @property integer $checked
 * @property integer $id_owner
 * @property integer $idcatprimary
 * @property string $seo_title
 * @property string $seo_keywords
 * @property string $seo_description
 * @property integer $views
 * @property integer $image_id
 * @property integer $reviewsCount
 *
 * @property Category[] $categories
 * @property Category $mainCategory
 * @property File[] $files
 * @property File $image
 * @property Tag[] $tags
 * @property Review[] $reviews
 */
abstract class BaseOrganization extends CActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'organization';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Organization|Organizations', $n);
	}

	public static function representingColumn() {
		return 'name';
	}

	public function rules() {
		
		return array(
			array('name, name_h1, slug, address, descr', 'required'),
			array('geocoder, geoexact, checked, id_owner, idcatprimary, views, image_id', 'numerical', 'integerOnly'=>true),
			array('geolat, geolon', 'numerical'),
			array('name, name_h1, slug, regime', 'length', 'max'=>255),
			array('slug', 'unique'),
			array('address, phone, seo_title, seo_keywords', 'length', 'max'=>256),
			array('email, site', 'length', 'max'=>128),
			array('anonse, options', 'length', 'max'=>1024),
			array('seo_description', 'safe'),
			array('phone, email, site, regime, geocoder, geoexact, geolat, geolon, options, checked, id_owner, idcatprimary, seo_title, seo_keywords, seo_description, views, image_id', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, name, name_h1, slug, address, phone, email, site, anonse, descr, geocoder, geoexact, geolat, geolon, options, created_at, updated_at, checked, id_owner, idcatprimary, seo_title, seo_keywords, seo_description, views, image_id', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'categories' => array(self::MANY_MANY, 'Category', 'org_category(idorg, idcat)'),
			'files' => array(self::MANY_MANY, 'File', 'org_file(org_id, file_id)'),
			'image' => array(self::BELONGS_TO, 'File', 'image_id'),
			'mainCategory' => array(self::BELONGS_TO, 'Category', 'idcatprimary'),
			'tags' => array(self::MANY_MANY, 'Tag', 'org_tag(org_id, tag_id)'),
			'reviews' => array(self::MANY_MANY, 'Review', 'org_review(org_id, review_id)'),
			'reviewsCount' => array(self::STAT, 'Review', 'org_review(org_id, review_id)'),
		);
	}

	public function pivotModels() {
		return array(
			'categories' => 'OrgCategory',
		);
	}

	public function attributeLabels() {
		return array(
			'id' => 'ID',
			'name' => 'Название',
			'name_h1' => 'Название для H1',
			'slug' => 'Url-фрагмент',
			'address' => 'Адрес',
			'phone' => 'Телефон',
			'phones' => 'Телефоны',
			'email' => 'Email',
			'site' => 'Сайт',
			'anonse' => 'Анонс',
			'regime' => 'Режим работы',
			'rating' => 'Рейтинг',
			'descr' => 'Описание',
			'geocoder' => 'Geocoder',
			'geoexact' => 'Geoexact',
			'geolat' => 'Широта',
			'geolon' => 'Долгота',
			'options' => 'Options',
			'created_at' => 'Создана',
			'updated_at' => 'Изменена',
			'checked' => 'Проверена',
			'id_owner' => 'Id Owner',
			'idcatprimary' => 'Основная категория',
			'seo_title' => 'Seo заголовок',
			'seo_keywords' => 'Seo ключевые слова',
			'seo_description' => 'Seo описание',
			'views' => 'Просмотров',
			'image_id' => 'id изображения',
			'categories' => 'Категории',
			'image' => 'Главное изображение',
			'files' => 'Галерея',
			'tags' => 'Теги',
			'tagsText' => 'Теги',
			'reviews' => 'Отзывы',
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('name_h1', $this->name_h1, true);
		$criteria->compare('slug', $this->slug, true);
		$criteria->compare('address', $this->address, true);
		$criteria->compare('phone', $this->phone, true);
		$criteria->compare('email', $this->email, true);
		$criteria->compare('site', $this->site, true);
		$criteria->compare('anonse', $this->anonse, true);
		$criteria->compare('descr', $this->descr, true);
		$criteria->compare('geocoder', $this->geocoder);
		$criteria->compare('geoexact', $this->geoexact);
		$criteria->compare('geolat', $this->geolat);
		$criteria->compare('geolon', $this->geolon);
		$criteria->compare('options', $this->options, true);
		$criteria->compare('created_at', $this->created_at, true);
		$criteria->compare('updated_at', $this->updated_at, true);
		$criteria->compare('checked', $this->checked);
		$criteria->compare('id_owner', $this->id_owner);
		$criteria->compare('idcatprimary', $this->idcatprimary);
		$criteria->compare('seo_title', $this->seo_title, true);
		$criteria->compare('seo_keywords', $this->seo_keywords, true);
		$criteria->compare('seo_description', $this->seo_description, true);
		$criteria->compare('views', $this->views);
		$criteria->compare('image_id', $this->image_id);
		
		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'sort' => array(
				'defaultOrder' => array(
					'id' => CSort::SORT_DESC,
				)
			),
		));
	}
}