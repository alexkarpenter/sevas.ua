(function($){

	var ItemState = {
			'empty' : 0,
			'loading' : 1,
			'loaded' : 2,
			'error' : -1,
	}
		
	function Attachment(cont, data) {
		this.cont = cont;
		this.data = data;
		this.data.html5upload = window.FormData ? true : false;
	}
	
	Attachment.prototype.render = function() {
		var self = this;
		$.each(this.data.files, function(i, file){
			file.parent = self.data; // backref
		});
		var h = tmpl('attachments_templ', {data:this.data});
		this.cont.html(h);
		
		this.cont.find('a.file-appender').click(function(){
			this.addItem();
			this.render();
		}.bind(this));
		
		this.cont.find('a.file-remover').click(function(e){
			this.removeItem(e.target);
			this.render();
		}.bind(this));
		
		this.cont.find('.file-uploader').change(function(e){
			if (this.data.fileMultiSelect && this.data.html5upload)
				this.uploadViaH5(e.target);
			else
				this.upload(e.target);
			this.render();
		}.bind(this));
		
		this.cont.find(':input').not(':file').change(function(e){ 
			this.inputChanged(e.target);
		}.bind(this));
	}
	
	Attachment.prototype.getSlot = function(input) {
		return $(input).closest('.file-slot');
	}
	
	Attachment.prototype.getSlotIndex = function(slot) {
		var index = this.cont.find('.file-slot').index(slot);
		return index;
	}
	
	Attachment.prototype.getFile = function(input) {
		var slot = this.getSlot(input);
		var index = this.getSlotIndex(slot);
		return this.data.files[index];
	}
	
	Attachment.prototype.addItem = function() {
		if (this.data.files.length == this.data.maxFiles) return;
		this.data.files.push( $.extend({},this.data.emptyModel) );
	}
	
	Attachment.prototype.removeItem = function(btn) {
		var slot = this.getSlot(btn);
		if (!this.data.multiple) {
			// clear single slot
			this.data.files = [ $.extend({}, {state:'empty'}, this.data.emptyModel) ];
		} else {
			var index = this.getSlotIndex(slot);
			this.data.files.splice(index, 1); // remove element
		}
	}
	
	Attachment.prototype.inputChanged = function(input){
		// databinding
		var file = this.getFile(input);
		var attr = $(input).attr('data-field');
		if (attr !== undefined)
			file[attr] = $(input).val();
	}
	
	Attachment.prototype.upload = function(chooser) {
		var slot = this.getSlot(chooser);
		var file = this.getFile(chooser);
		var index = this.getSlotIndex(slot);
		file.state = 'loading';
		var self = this;
		var uploadUrl = $.param.querystring( this.data.uploadUrl, 
				{hostId:this.data.hostId, index:index} );
		$.ajaxFileUpload({
				url:uploadUrl, 
				secureuri:false,
				fileElementId:chooser.id,
				dataType: 'json',
				success: function (data, status)
				{
					if (data.res) {
						file.state = "loaded";
						for (p in data.file) 
							if (data.file[p] === null)
								data.file[p] = undefined; // undefined not overrides values in $.extend
						$.extend(file, data.file);
					} else {
						// error
						file.state = "error";
						file.error = data.message;
					}
					this.render();
				}.bind(this),
				error: function (data, status, e)
				{
					file.state = "error";
					file.error = "ошибка загрузки";
					this.render();
				}.bind(this)
		});
	}

	Attachment.prototype.uploadViaH5 = function(chooser) {
		var file = this.getFile(chooser);
		var index = this.data.files.indexOf(file);
		this.data.files.splice(index, 1); // delete current slot data
		
		var $chooser = $(chooser).hide();
		$chooser.attr({ 'name':'', 'id':'chooser'+(new Date()).getTime() }).appendTo(this.cont); // file input relocation
		var userFiles = $(chooser).get(0).files;
		var allowedFiles = userFiles.length+this.data.files.length < this.data.maxFiles ? userFiles.length : this.data.maxFiles - this.data.files.length;
		var baseIndex = this.data.files.length;
		for (var index=0; index<allowedFiles; index++) {
			this.addItem(); // new file slots
		}
		
		var self = this;
		function uploadFileByIndex(index) {
			if (index >= allowedFiles) return;
			var userFile = userFiles[index];
			var file = self.data.files[baseIndex+index];
			self.uploadFileViaH5(index, userFile, file, baseIndex+index, function(index){ // finished callback
				uploadFileByIndex(index+1);
			});
		}
		uploadFileByIndex(0);
	}

	Attachment.prototype.uploadFileViaH5 = function(index, userFile, file, fileIndex, onFinished) {

		file.state = 'loading';
		var self = this;
		var uploadUrl = $.param.querystring( this.data.uploadUrl, 
				{hostId:this.data.hostId, index:fileIndex} );

		var xhr = new XMLHttpRequest();
	    xhr.open("POST", uploadUrl, true);
	    $.each($.fn.attachments.postHeaders,function(key,val){
	        val = typeof(val) == "function" ? val(userFile) : val; // resolve value
	        if (val === false) return true; // if resolved value is boolean false, do not send this header
	        xhr.setRequestHeader(key, val);
	    });

        var form = new FormData();
        form.append('file', userFile);

        xhr.onload = function(load) {
            if (xhr.status == 200) {
            	
            	file.state = 'loaded';
            	var data = $.parseJSON(xhr.responseText);
            	if (!data || !data.res)
            	{
					// error
					file.state = "error";
					file.error = data ? data.message : 'error';
            		
            	}
            	else
            	{
            		// file loaded successfully
            		
					for (p in data.file) 
						if (data.file[p] === null)
							data.file[p] = undefined; // undefined not overrides values in $.extend
					$.extend(file, data.file);
	
					if (data.res) {
						file.state = "loaded";
						for (p in data.file) 
							if (data.file[p] === null)
								data.file[p] = undefined; // undefined not overrides values in $.extend
						$.extend(file, data.file);
					}
					
            	}
				
            } else {
            	file.state = 'error';
            	file.error = xhr.statusText;
            }
        };
        xhr.onabort = function() {
        	file.state = 'error';
        	file.error = xhr.statusText;
        };
        xhr.onerror = function(e) {
        	file.state = 'error';
        	file.error = xhr.statusText;
        };
        xhr.onloadend = function() {
        	// after all
        	onFinished(index);
        	self.render();
        };
        
        xhr.send(form);
	}

	
	$.fn.attachments = function(data){
		
		//$(this).each(function(){
			
			if ($(this).hasClass('attachment-container')) {
				var $cont = $(this);
				if (!$cont.data('attachment')) {
					var a = new Attachment($cont, data);
					$cont.data('attachment', a);
					a.render();
				}
			} else {
				
				if (data == 'getAttach') {
					var $cont = $(this).closest('.attachment-container');
					var a = $cont.data('attachment');
					return a;
				}
			}
			
		//});
		return this;
	}

	$.fn.attachments.postHeaders = {
        "Cache-Control":"no-cache",
        "X-Requested-With":"XMLHttpRequest",
        "X-File-Name": function(file){return file.name || file.fileName },
        "X-File-Size": function(file){return file.size || file.fileSize },
        "X-CSRF-Token": $('meta[name="csrf-token"]').attr("content"),
        //"Content-Type": 'multipart/form-data'
    }
	
})(jQuery);
