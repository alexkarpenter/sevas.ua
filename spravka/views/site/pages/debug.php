<?php
/* @var $this SiteController */

if (@$_GET['type'] == 'upload') {

	echo json_encode($_FILES);

	Yii::app()->end();
}


$this->pageTitle = Yii::app()->name . ' - Debug';
$this->breadcrumbs=array(
	'Debug',
);
?>
<h1>upload</h1>

<? 


Yii::app()->clientScript->registerScriptFile('/js/jquery.html5_upload.js');

?>

<input id="file1", type="file" onchange="console.log($(this))" ><br>


<input id="file", type="file" multiple="multiple" ><br>

<input id="files", type="file" multiple="multiple" >

<script type="text/javascript">
<!--

function loadH5()
{
	var $f = $('#file');
	var files = $f.get(0).files;
	var url = '<?=$this->createUrl($this->route, array_merge($_GET, array('type' => 'upload')))?>';

	var xhr = new XMLHttpRequest();

	var options = {
            headers: {
                "Cache-Control":"no-cache",
                "X-Requested-With":"XMLHttpRequest",
                "X-File-Name": function(file){return file.name || file.fileName },
                "X-File-Size": function(file){return file.size || file.fileSize },
                "X-CSRF-Token": $('meta[name="csrf-token"]').attr("content"),
                //"Content-Type": 'multipart/form-data'
            },
	};

	function upload(fi) {
		var file = files[fi];
		if (!file) return;
	
	    xhr.open("POST", url, true);
	    $.each(options.headers,function(key,val){
	        val = typeof(val) == "function" ? val(file) : val; // resolve value
	        if (val === false) return true; // if resolved value is boolean false, do not send this header
	        xhr.setRequestHeader(key, val);
	    });

        var f = new FormData();
        f.append('ajaxFile', file);

        xhr.onload = function(load) {
            if (xhr.status != 200) {
            }
            else {
                //
                upload(fi+1);
            }
        };
        xhr.onabort = function() {
            //
        };
        xhr.onerror = function(e) {
            //
        };
        xhr.onloadend = function() {
        };
        
        xhr.send(f);
	}

	upload(0);
	
	for (var i=0; i<files.length; i++) {
		var file = files[i];
	}
	
}

$(function(){
	$('#files').html5_upload({
		url:'<?=$this->createUrl($this->route, array_merge($_GET, array('type' => 'upload')))?>',
		sendBoundary:true,
		fieldName:'ajaxFile',
	}).on('html5_upload.onFinishOne', function(){
		console.log('ofo', arguments);
	});
});
//-->
</script>

<?
/* 
// $fs = File::model()->with(array('commentsCount', 'comments'))->findAllByPk(array(58,59));
$cr = new CDbCriteria();
$cr->distinct = true;
$cr->join = "INNER JOIN org_file of ON t.id=of.file_id";
$cr->condition = "of.org_id = :oid";
$cr->params = array('oid' => 22333);
//$fs = File::model()->with(array('commentsCount'))->findAllByPk(array(58,59));
$fs = File::model()->with(array('commentsCount'))->findAll($cr);

foreach ($fs as $f) {
	CVarDumper::dump( $f, 3, true );
}

//$c = Comment::model()->findByPk(1);
*/
/* 
$f = File::model()->findByPk(58);
$this->widget('comment.widgets.CommentsWidget', array(
		'model' => $f,
));

 */
?>
<?

$s = Organization::model()->getTableSchema();
CVarDumper::dump($s, 4, true);

?>