var countNews=0;

$(document).ready(function(){
	$('button').click(function(){
		countNews +=1;
		outNews(countNews);
		//Sconsole.log(countNews);
	});
})
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

