$(() => {
	var a = $("a[href='#anchor']");
	var post;
	a.on("mouseenter", function(e) {
		var anchor = $(this).text().substr(2);
		var thread = $(this).parents(".thread-body").find(".post-body");
		post = $(thread[anchor - 1]).clone()
			.addClass("post-appended")
			.addClass("notriangle");
		$(this).prepend(post);
	});
	a.on("mouseleave", function(e){
		post.remove();
	});
	scrollBy(0,-60);
})
