<ul class="article-list">
<?php foreach ($model as $news) { ?>
	<li>
		<div class='news_title'>
			<a href="/news/<?php echo $news->url; ?>"><?php echo $news->name; ?></a>
		</div>
	</li>
<?php } ?>
</ul>
