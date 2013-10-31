<?php

class SpravController extends SpravBaseController
{

	public function actionIndex()
	{

		$cs = Category::model()->sortedRoots()->findAll(array('index' => 'id'));
		$cs = Category::makeTree($cs);
		
		
		$this->render('index', array('cs' => $cs));
	}

	public function actionCategory($slug)
	{
		/* @var $c Category */
		if (!$c = Category::model()->findByAttributes(array('pathfull' => $slug)))
			throw new Exception(null, 404);

		$cr = $c->getOrgCriteria();
		$cr->with = array('mainCategory', 'reviewsCount');
		$provider = new CActiveDataProvider('Organization', array(
			'criteria' => $cr,
		));
		
		$this->render('category', array('c' => $c, 'provider' => $provider));
	}
	

	public function actionOrg($slug)
	{
		/* @var $o Organization */
		if (!$o = Organization::model()->findByAttributes(array('slug' => $slug)))
			throw new Exception(null, 404);

		// files with comments count
		$cr = new CDbCriteria();
		$cr->distinct = true;
		$cr->join = "INNER JOIN org_file of ON t.id=of.file_id";
		$cr->condition = "of.org_id = :oid";
		$cr->params = array('oid' => $o->id);
		$files = File::model()->with(array('commentsCount'))->findAll($cr);
		
		$this->render('org', array(
				'o'=>$o, 'files' => $files,
		));
	}
	
	public function actionSearch($query)
	{
		$cr = new CDbCriteria();
		$cr->distinct = true;
		//$cr->select = 't.id';
		$cr->addSearchCondition('t.name', $query);
		$cr->addSearchCondition('t.address', $query, true, 'OR');
		$cr->join = 'INNER JOIN org_category oc ON oc.idorg=t.id INNER JOIN category c ON c.id=oc.idcat';
		$cr->addSearchCondition('c.name', $query, true, 'OR');
		
		$provider = new CActiveDataProvider('Organization', array(
				'criteria' => $cr
		));
		
		$this->render('search', array('query' => $query, 'provider' => $provider));
	}
	
	/**
	 * подсказки при поиске
	 * @param string $query
	 */
	public function actionSearchHints($query)
	{

		$cr = new CDbCriteria();
		$cr->limit = 10;
		$cr->distinct = true;
		$cr->select = 't.id, t.name, t.address, t.slug';
		$cr->addSearchCondition('t.name', $query);
		$cr->addSearchCondition('t.address', $query, true, 'OR');
		$cr->join = 'INNER JOIN org_category oc ON oc.idorg=t.id INNER JOIN category c ON c.id=oc.idcat';
		$cr->addSearchCondition('c.name', $query, true, 'OR');
		
		$os = Organization::model()->findAll($cr);
		
		$os = array_map(function($o){ 
			return array(
					'id' => $o->id, 
					'name' => $o->name, 
					'address' => $o->address, 
					'url' => CHtml::normalizeUrl($o->getUrlData())
			); 
		}, $os);
		print json_encode($os, JSON_NUMERIC_CHECK);
		Yii::app()->end();
	}
	
	/**
	 * Html-список комментариев
	 * @param int $id
	 * @param string $type
	 * @throws CException
	 */
	public function actionCommentList($id, $type)
	{
		if (!class_exists($type))
			throw new CException();
		$o = new $type;
		if (!$o instanceof CActiveRecord)
			throw new CException();
		$o = $o::model()->findByPk((int)$id);
		
		$comments = $this->widget('comment.widgets.CommentsWidget', 
				array('model' => $o, 'view' => 'commentList'), true);
		Yii::app()->clientScript->renderBodyEnd($comments);
		print $comments;
		Yii::app()->end();
	}
	
}