
(function(){
	
	var ymapsw = function(elem, opts) {
		this.elem=elem;
		this.opts=opts;
		ymaps.ready(this.ymapsready.bind(this));
	};
	
	ymapsw.prototype.ymapsready = function() {

		var opts = this.opts;
		var map = this.opts.map = new ymaps.Map(opts.id, { center:opts.center, zoom:opts.zoom });
		window[opts.id+"_data"].map = map;
		map.setZoom(opts.zoom, {checkZoomRange:true} ); 
		map.controls.add('mapTools').add('zoomControl', {top: 40}).add('typeSelector');
		map.behaviors.enable('scrollZoom');
		
		if (opts.address)
		{
			var gopts = {results:1};
			if (opts.boundedBy) { gopts.boundedBy = opts.boundedBy; gopts.strictBounds=true; }
			ymaps.geocode(opts.address, gopts).then(function (res) {
	        	var go = res.geoObjects.get(0);
	        	if (!go) return;
	        	var balloon = opts.balloon;
	        	if (go.properties.get('metaDataProperty.GeocoderMetaData.precision') != 'exact')
	        		balloon += " <i class=\'address-warning icon-exclamation-sign\' title=\'расположение определено не точно\'></i>";
	        	var pm = new ymaps.Placemark(go.geometry.getCoordinates(), { balloonContent:balloon }); 
	        	map.geoObjects.add(pm);
	        	map.panTo( go.geometry.getCoordinates(), { delay:100 } );
	        });
			
		} else {
			
		}
		
		
		if (opts.onready) {
			eval(opts.onready);
		}
		
		if (!opts.width) {
			$(window).on('resize', function(){ map.container.fitToViewport(); });
		}
	};
	
	$.fn.ymapsw = function(option){
	    return this.each(function () {
		      var $this = $(this)
		        , data = $this.data('ymapsw')
		        , opts = $.extend({}, $.fn.ymapsw.defaults, $this.data(), typeof option == 'object' && option);
		      if (!data) $this.data('ymapsw', (data = new ymapsw(this, opts)));
		      if (typeof option == 'string') data[option]();
		      else if (opts.show) data.show();
	    });
	};
	
	$.fn.ymapsw.defaults = {};
	
})();
