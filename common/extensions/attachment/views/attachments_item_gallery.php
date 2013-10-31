<? /* @var $this CAttachmentWidget */ ?>
<div class="file-slot">

    <div class="file-slot-cell1">
    <% if (file.state == 'empty') { %>
        <input type="file" id="<%=data.attr+index%>" class="file-uploader" accept="<%=data.fileTypes%>"
		<% if (data.fileMultiSelect && data.html5upload) { %> multiple="multiple" <% } %> >
	<% } if (file.state == 'loading') { %>
        <img src="<%=data.ajaxIndicatorUrl%>" >
    <% } if (file.state == 'loaded') { %>
        <img src="<%=file.path%>" height="50" width="60" >
		<?
		$this->widget('bootstrap.widgets.TbButtonGroup', array(
			'type'=>'', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
			'size'=>'small',
			'buttons'=>array(
				array('items'=>array(
					array('label'=>'Вставить в текст', 'url'=>'#', 'linkOptions'=>array('onclick'=>'addImageToRedactor("original",$(this));return false;')),
					array('label'=>'Вставить в текст с watermark', 'url'=>'#', 'linkOptions'=>array('onclick'=>'addImageToRedactor("watermark", $(this));return false;')),
				)),
			),
		));
		?>
    <% } if (file.state == 'error') { %>
        <label class="bage">error: <%=file.error%></label>
    <% } %>
    </div>

    <div class="file-slot-cell2">
        <input type="hidden" name="<%=data.hostType%>[<%=data.attr%>][id][]" value="<%=file.id%>" >
        <input type="text" name="<%=data.hostType%>[<%=data.attr%>][title][]" class="file-title" value="<%=file.title%>" data-field="title" placeholder="название" >
        <input type="text" name="<%=data.hostType%>[<%=data.attr%>][copyright][]" class="file-copyright" value="<%=file.copyright%>" data-field="copyright" placeholder="авторство" >
    </div>

    <a class="file-remover"><i class="icon-remove"></i></a>
</div>
<div class="clear"></div>