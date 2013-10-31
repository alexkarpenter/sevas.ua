<?php

/**
 * This is the model base class for the table "tag".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Tag".
 *
 * Columns in table "tag" available as properties of the model,
 * followed by relations of table "tag" available as properties of the model.
 *
 * @property integer $id
 * @property string $name
 *
 * @property OrgTag[] $orgTags
 */
abstract class BaseTag extends CActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'tag';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Tag|Tags', $n);
	}

	public static function representingColumn() {
		return 'name';
	}

	public function rules() {
		return array(
			array('name', 'required'),
			array('name', 'length', 'max'=>128),
			array('id, name', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'orgTags' => array(self::HAS_MANY, 'OrgTag', 'tag_id'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', 'ID'),
			'name' => Yii::t('app', 'Name'),
			'orgTags' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('name', $this->name, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}