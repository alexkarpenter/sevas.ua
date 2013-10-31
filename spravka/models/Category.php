<?php

Yii::import('spravka.models._base.BaseCategory');

class Category extends BaseCategory
{
	/**
	 * @var Category[]
	 */
	public $childs = array();
	
	public $imgFile;
	
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
	
	public function behaviors()
	{
		return array(
				'CTimestampBehavior' => array(
						'class' => 'zii.behaviors.CTimestampBehavior',
						'createAttribute' => 'created_at',
						'updateAttribute' => 'updated_at',
						'setUpdateOnCreate' => true,
				),
				'tree'=>array(
						'class'=>'ext.nested-set-behavior.NestedSetBehavior',
						'hasManyRoots' => true,
				),
				'imgBehavior' => array(
						'class' => 'common.extensions.uploaderbehavior.FileARBehavior',
						'attribute' => 'imgFile', 
						'extension' => 'png, gif, jpg', // possible extensions, comma separated
						'prefix' => 'category_',
						'relativeWebRootFolder' => 'upload/cs', // this folder must exist
						'defaultName' => 'ibox',
				)				
		);
	}
	
	public function rules() {
		return array_merge(
				parent::rules(),
				array(
						array('imgFile', 'file', 'allowEmpty' => true),
				)
		);
	}
	
	public static $_findedCategories = array();
	public static function getFindedCategory($id) {
		return @self::$_findedCategories[$id];
	}
	
	public function afterFind()
	{
		self::$_findedCategories[$this->id] = $this;
		parent::afterFind();
	}
	
	public function beforeSave()
	{
		$r = parent::beforeSave();
	
		/*
		 * определить полный путь с учетом вложенности
		*/
		if ($this->idcatparent) {
			$p = self::model()->findByPk($this->idcatparent);
			$pathfull = $p->detectFullPath().'/'.$this->path;
		} else {
			$pathfull = $this->path;
		}
		$this->pathfull = $pathfull;
	
		return $r;
	}
	
	public function detectFullPath()
	{
		$as = $this->ancestors()->findAll();
		$as = array_reverse($as);
		$paths = array();
		foreach ($as as $a) {
			$paths[] = $a->path;
		} 
		$paths[] = $this->path;
		return implode('/', $paths);
	}
	
	/**
	 * named scope: корневые узлы дерева отсортированы по весу и алфавиту
	 * @return Category
	 */
	public function sortedRoots()
	{
		$this->getDbCriteria()->join = 'INNER JOIN category cr ON t.root=cr.id';
		$this->getDbCriteria()->order = 'cr.weight, cr.name, lft';
		return $this;
	}
	
	public function getDeepName($levelSymb='»')
	{
		//return @str_repeat("-", ($this->level-1)*2)."&nbsp;".$this->name;
		return @str_repeat($levelSymb, ($this->level-1))."\x20\x20".$this->name;
	}
	
	/**
	 * Список всех категорий в иерархическом порядке
	 */
	public static function getTreeList($notSelectedText=false)
	{
		$cs = CHtml::listData(self::model()->sortedRoots()->findAll(), 'id', 'deepName');
		if ($notSelectedText)
			$cs = CMap::mergeArray(array(''=>$notSelectedText), $cs);
		return $cs;
	}
	
	/**
	 * Выборка сформированная в виде дерева 
	 * @param int $id
	 */
	public static function getTree($id=false)
	{
		$cs = self::model()->sortedRoots()->findAll(array('index' => 'id'));
		self::makeTree($cs);
		return !$id ? array_filter( $cs, function($c){ return !$c->idcatparent; } ) : array( @$cs[$id] ); // return only roots, or by id
	}
	
	/**
	 * Формирование дерева из массива
	 * @param Category[] $cs - indexed by ids
	 */
	public static function makeTree($cs, $returnRoots=true)
	{
		foreach ($cs as $c) {
			if ($c->idcatparent) {
				$cs[$c->idcatparent]->childs[$c->id] = $c;
			}
		}
		if ($returnRoots)
		{
			$topLevel = 100; 
			foreach ($cs as $c) {
				$topLevel = $c->level < $topLevel ? $c->level : $topLevel;
			}
			return array_filter( $cs, function($c)use($topLevel){ return $c->level == $topLevel; } );
		}
		else {
			return $cs;
		}
	}

	private $_ancestors;
	
	public function findAncestors()
	{
		if ($this->_ancestors) return $this->_ancestors;
		$this->_ancestors = $this->ancestors()->findAll();
		return $this->_ancestors;
	}
	
	public static function findAncestorsAll($cs)
	{
		$cr = new CDbCriteria();
		foreach ($cs as $c) {
			$ccr = $c->ancestors()->getDbCriteria();
			$cr->mergeWith($ccr, 'OR');
		}
		$ascs = Category::model()->findAll($cr);
		return $ascs;
	}
	
	public function getInheritanceChain()
	{
		$chain = array();
		for ($c=$this; $c!=false; $c=self::getFindedCategory($c->idcatparent)) {
			$chain[] = $c;
		}
		return array_reverse($chain);
	}
	
	public function getOrgCriteria()
	{
		$cr = new CDbCriteria();

		$cr->join = "left outer join org_category oc on t.id=oc.idorg left outer join category cc on cc.id=oc.idcat";
		$cr->addCondition('cc.lft >= :catlft AND cc.rgt <= :catrgt AND cc.root = :catroot');
		$cr->params[':catlft'] = $this->lft;
		$cr->params[':catrgt'] = $this->rgt;
		$cr->params[':catroot'] = $this->root;
		
		return $cr;
	}
	
	public static function loadAllCached()
	{
		$cs = self::model()->sortedRoots()->cache(600)->findAll();
		return $cs;
	}
	
	public function getLink() {
		return CHtml::link($this->name, $this->getUrlData());
	}
	
	public function getUrlData() {
		return array('sprav/category', 'slug' => $this->pathfull);
	}
	
	public function getBreadcrumbsData($selfLink=true) {
		$this->findAncestors();
		$cs = $this->getInheritanceChain();
		$data = array();
		foreach ($cs as $c) {
			if (!$selfLink && $c === $this) {
				$data[] = $c->name;
			} else { 
				$data[$c->name] = $c->getUrlData();
			}
		}
		return $data;
	}
	
}
