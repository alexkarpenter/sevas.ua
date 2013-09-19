var countNews=0;

function addNews(){
	countNews +=1;
	outNews(countNews);
}

function outNews(count){
		$.ajax({
			url: "/news/index",
			type: "GET",
			data: {count:count},
			async: true,
			success: function(data){
				$('div.article-list').html(data);
			}
		});
}

