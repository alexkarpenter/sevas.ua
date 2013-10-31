<?php
/* @var $this SiteController */
$this->pageTitle = Yii::app ()->name . ' - mfp';
?>
<h1>Debug</h1>

<style>
<!--
.mfp-type2 {
}

.mfp-type2 .mfp-content {
margin-top: 2em;
background-color: white;
padding:10px;
}

.mfp-type2 .mfp-figure:after {
box-shadow:none;
-webkit-box-shadow:none;
-moz-box-shadow:none;
background: inherit;
}

.mfp-type2 .mfp-bottom-bar {
color:#2e2e2e;
}

.mfp-type2 .mfp-bottom-bar .mfp-title {
color:#2e2e2e;
}

.mfp-type2 .mfp-image-holder .mfp-close {
width:44px;
height:20px;
line-height:20px;
color:black;
}

.mfp-type2 img.mfp-img {
padding: 20px 0 40px;
}

-->
</style>

<?

?>

<link rel="stylesheet" type="text/css" href="/js/magnific-popup.css" />
<link rel="stylesheet" type="text/css"
	href="/assets/f573a34e/listview/styles.css" />
<link rel="stylesheet" type="text/css" href="/css/sprav.css" />
<script type="text/javascript" src="/assets/5a57b740/jquery.js"></script>
<script type="text/javascript"
	src="/assets/5a57b740/jui/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="/assets/5a57b740/jquery.metadata.js"></script>
<script type="text/javascript" src="/js/jquery.magnific-popup.js"></script>

<div class="mfp-bg mfp-ready"></div>
<div
	class="mfp-type2 mfp-wrap  mfp-gallery mfp-close-btn-in mfp-auto-cursor mfp-ready"
	tabindex="-1" style="overflow-y: auto; overflow-x: hidden;">
	<div class="mfp-container mfp-s-ready mfp-image-holder">
		<div class="mfp-content">
			<div class="mfp-figure" style="visibility: visible;">
				<button title="Close (Esc)" type="button" class="mfp-close">×</button>
				<img class="mfp-img"
					src="/upload/organization/22333/10067636464_a2e9aeba9f.jpg"
					style="max-height: 631px;">
				<div class="mfp-bottom-bar">
					<div class="mfp-title">lake321</div>
					<div class="mfp-counter">1 of 4</div>
				</div>
			</div>
			
			<div class="mfp-comments mfp-prevent-close"
				style="visibility: visible;">
				<div class="comment-list">

					<div id="yw0" class="list-view">

						<div class="items">
							<div class="ext-comment" id="ext-comment-11">

								<div class="avatar-cell">
									<img class="avatar" alt="" src="http://placehold.it/30x30">
								</div>

								<div class="content-cell">
									<div class="comment-info">
										<span class="author-name">testuser1</span> <span
											class="ext-comment-date"> 01:56 17 октября </span> <span
											class="ext-comment-options"> <a id="delete-comment-11"
											href="#">delete</a> | <a id="ext-comment-edit-11" href="#">edit</a>
										</span>

									</div>
									<div class="clear"></div>

									<p class="comment-text">peacefull</p>

								</div>

								<div class="clear"></div>
							</div>
							<div class="ext-comment" id="ext-comment-13">

								<div class="avatar-cell">
									<img class="avatar" alt="" src="http://placehold.it/30x30">
								</div>

								<div class="content-cell">
									<div class="comment-info">
										<span class="author-name">testuser1</span> <span
											class="ext-comment-date"> 12:22 17 октября </span> <span
											class="ext-comment-options"> <a id="delete-comment-13"
											href="#">delete</a> | <a id="ext-comment-edit-13" href="#">edit</a>
										</span>

									</div>
									<div class="clear"></div>

									<p class="comment-text">daaaaa</p>

								</div>

								<div class="clear"></div>
							</div>
							<div class="ext-comment" id="ext-comment-16">

								<div class="avatar-cell">
									<img class="avatar" alt="" src="http://placehold.it/30x30">
								</div>

								<div class="content-cell">
									<div class="comment-info">
										<span class="author-name">testuser1</span> <span
											class="ext-comment-date"> 12:23 17 октября </span> <span
											class="ext-comment-options"> <a id="delete-comment-16"
											href="#">delete</a> | <a id="ext-comment-edit-16" href="#">edit</a>
										</span>

									</div>
									<div class="clear"></div>

									<p class="comment-text">asdfasdfasdfasdfasdfasdf
										asdfhweuihfwuifhusaidhf ua ashdfu iashdui fahsdiuf hasdifh
										asduf asdf wer 23asdfasdfs</p>

								</div>

								<div class="clear"></div>
							</div>
						</div>
						<div class="keys" style="display: none"
							title="/sprav/commentList?type=File&amp;id=31">
							<span>11</span><span>13</span><span>14</span><span>15</span><span>16</span><span>17</span><span>18</span>
						</div>
					</div>
					<div id="ext-comment-form-new" class="form">

						<form id="ext-comment-form" action="/comment/comment/create"
							method="post">
							<input type="hidden" value="Comment" name="commentModel"
								id="commentModel"><input type="hidden" value="File"
								name="commentableModel" id="commentableModel">
							<div class="row">
								<label for="Comment_message" class="required">Комментарий <span
									class="required">*</span></label>
								<textarea rows="6" cols="50" name="Comment[message]"
									id="Comment_message"></textarea>

							</div>
							<div class="row buttons">
								<input name="Comment[type]" id="Comment_type" type="hidden"
									value="file"><input name="Comment[key]" id="Comment_key"
									type="hidden" value="31"><input
									id="ext-comment-submit1382003439" type="submit" name="yt0"
									value="Отправить">
							</div>

						</form>
					</div>
					<!-- form -->

				</div>

			</div>
			
		</div>
		<div class="mfp-preloader">Loading...</div>
		<button title="Previous (Left arrow key)" type="button"
			class="mfp-arrow mfp-arrow-left mfp-prevent-close"></button>
		<button title="Next (Right arrow key)" type="button"
			class="mfp-arrow mfp-arrow-right mfp-prevent-close"></button>
	</div>
</div>
