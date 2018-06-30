$(() => {
	var a = $("a[href='#anchor']");
	var posts = [];
	$(document).on("mouseenter", "a[href='#anchor']", function(e) {
		var anchor = $(this).text().substr(2);
		var thread = $(this).parents(".thread-body").find(".post-body");
		var post = $(thread[anchor - 1]).clone()
			.addClass("post-appended")
			.addClass("notriangle");
		posts.push(post);
		$(this).prepend(post);
	});
	a.on("mouseleave", function(e){
		posts.forEach(function(v){
			v.remove();
		});
	});
})
