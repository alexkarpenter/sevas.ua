<?php

class SearchController extends Controller
{
	
	public function actionIndex($search=null, $page=1)
	{
		$api = Yii::getPathOfAlias('common.libs.sphinx').'/sphinxapi.php';
		require $api;
		
		$pageSize =  5;
		
		$cl = new SphinxClient();
		$cl->SetArrayResult ( true );
		//$cl->SetWeights ( array ( 100, 1 ) );
		$cl->SetMatchMode ( SPH_MATCH_ALL );
// 		if ( count($filtervals) )	$cl->SetFilter ( $filter, $filtervals );
// 		if ( $groupby )				$cl->SetGroupBy ( $groupby, SPH_GROUPBY_ATTR, $groupsort );
// 		if ( $sortby )				$cl->SetSortMode ( SPH_SORT_EXTENDED, $sortby );
// 		if ( $sortexpr )			$cl->SetSortMode ( SPH_SORT_EXPR, $sortexpr );
// 		if ( $distinct )			$cl->SetGroupDistinct ( $distinct );
// 		if ( $select )				$cl->SetSelect ( $select );
// 		if ( $limit )				$cl->SetLimits ( 0, $limit, ( $limit>1000 ) ? $limit : 1000 );
// 		$cl->SetRankingMode ( $ranker );
		$cl->SetLimits(($page-1)*$pageSize, $pageSize);
		$res = $cl->Query ( $search, 'spravka' );
		
		$pages = new CPagination($res['total']);
		$pages->pageSize = $pageSize;
		
		$oids = array_map(function($v){ return $v['id']; }, @$res['matches'] ?: array());
		$orgs = Organization::model()->findAllByPk($oids);
				
		$this->render('index', array('search' => $search, 'res' => $res, 'pages' => $pages, 'orgs' => $orgs));
	}
}

?>
