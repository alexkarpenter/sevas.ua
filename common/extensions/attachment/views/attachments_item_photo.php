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
		<% } if (file.state == 'error') { %>
			<label class="bage">error: <%=file.error%></label>
		<% } %>
		</div>

		<div class="file-slot-cell2">
		<input type="hidden" name="<%=data.hostType%>[<%=data.attr%>][id][]" value="<%=file.id%>" >
		<input type="text" name="<%=data.hostType%>[<%=data.attr%>][title][]" class="file-title" value="<%=file.title%>" data-field="title" placeholder="название" >
		<input type="radio" name="<%=data.hostType%>[mainImageIndex]" value="<%=index%>" title="главное фото" onclick="$(&quot;#Organization_mainPhotoIndex&quot;).val(this.value)" 
			<% if ($("#Organization_mainPhotoIndex").val() == index) { %> checked="checked" <% } %> >
		</div>

		<a class="file-remover"><i class="icon-remove"></i></a>
		<div class="clear"></div>
	</div>

