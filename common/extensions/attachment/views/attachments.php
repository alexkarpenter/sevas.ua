<?php
/* @var $this CAttachmentWidget */

$cs = Yii::app()->clientScript; 
$cs->registerCoreScript('bbq');
$cs->registerScriptFile( $this->assetUrl.'/stempl.js' );
$cs->registerCssFile( $this->assetUrl.'/attachments.css' );
$cs->registerScriptFile( $this->assetUrl.'/attachments.js' );
$cs->registerScriptFile( $this->assetUrl.'/ajaxfileupload.js' );
$data = $this->getAttachmentData();
?>

<div id="<?=$this->id?>" class="attachment-container">
</div>

<? if (!isset($this->getController()->clips[$this->id.'attachments_templ'])): ?>
<? $this->getController()->beginClip($this->id.'attachments_templ') ?>
<script id="<?=$this->id?>_attachments_templ" type="text/javascript-templ">
	<% for (var index=0; index<data.files.length; index++) { %>
	<% var file = data.files[index]; %>
	<? $this->render($this->viewItem); ?>
	<% } %>
<% if (data.multiple) { %>
<div>
	<a class="file-appender"><i class="icon-plus-sign"></i>добавить</a>
</div>
<% } %>
</script>
<? $this->getController()->endClip(); ?>
<? echo $this->getController()->clips[$this->id.'attachments_templ']; ?>
<? endif; ?>

<script type="text/javascript">
var <?=$this->id?>_data = <?=json_encode($data, JSON_NUMERIC_CHECK)?>;

$(function(){
	$('#<?=$this->id?>').attachments(<?=$this->id?>_data);
});
</script>
