<?php
$apiId = 3842984; //vk
Yii::app()->clientScript->registerScriptFile('http://vk.com/js/api/openapi.js?98');
if (!defined('YII_DEBUG')) :
?>
<div class="share-vidjets">
	<!-- vkontakte.com-->
	<script type="text/javascript">
	VK.init({apiId: <?=$apiId?>, onlyWidgets: true});
	</script> 
	<div class="like_v"><div id="vk_like"></div></div>
	<script type="text/javascript">
	VK.Widgets.Like("vk_like", {type: "button", height: 18});
	</script>
	<!-- end vkontakte.com-->
	
	<!--facebook-->
	<div id="fb-root"></div>
	<script>(function(d, s, id) {
	var js, fjs = d.getElementsByTagName(s)[0];
	if (d.getElementById(id)) return;
	js = d.createElement(s); js.id = id;
	js.src = "//connect.facebook.net/ru_RU/all.js#xfbml=1";
	fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>
	<html xmlns:fb="http://ogp.me/ns/fb#">
	<fb:like href="" width="105" layout="button_count" action="recommend" show_faces="true" send="false" id="facebook1"></fb:like>
	<!--end facebook-->
	
	<!--tweet-->
	<a href="https://twitter.com/share" class="twitter-share-button">Tweet</a>
	<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
	<!-- end tweet-->
	
	<!-- myworld-->
	<div class="myworld"><a target="_blank" class="mrc__plugin_uber_like_button" href="http://connect.mail.ru/share" data-mrc-config="{'nt' : '1', 'cm' : '1', 'sz' : '20', 'st' : '1', 'tp' : 'mm'}">Нравится</a>
	<script src="http://cdn.connect.mail.ru/js/loader.js" type="text/javascript" charset="UTF-8"></script></div>
	<!--end myworld-->
	
	<!--odnoklass-->
	<div id="ok_shareWidget"></div>
	<script>
	!function (d, id, did, st) {
	var js = d.createElement("script");
	js.src = "http://connect.ok.ru/connect.js";
	js.onload = js.onreadystatechange = function () {
	if (!this.readyState || this.readyState == "loaded" || this.readyState == "complete") {
	if (!this.executed) {
	this.executed = true;
	setTimeout(function () {
	OK.CONNECT.insertShareWidget(id,did,st);
	}, 0);
	}
	}};
	d.documentElement.appendChild(js);
	}(document,"ok_shareWidget","","{width:100,height:30,st:'oval',sz:20,nt:1}");
	</script>
	<!--end odnoklass-->

	<!-- google plus-->
	<!-- Place this tag where you want the +1 button to render. -->
	<div id="plus">
	<div class="g-plusone" data-size="medium"></div>

	<!-- Place this tag after the last +1 button tag. -->
	<script type="text/javascript">
	(function() {
	var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
	po.src = 'https://apis.google.com/js/plusone.js';
	var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
	})();
	</script>
	</div>
	<!--end google plus-->
	<div class="clear"></div>
</div>

<? endif; // yii_debug ?>