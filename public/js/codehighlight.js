$(() => {
	$('pre code').each(function(i, block) {
		console.log(block.innerText);
		block.innerText = decodeHtmlEntities(block.innerText);
		console.log(block.innerText);
		hljs.highlightBlock(block);
	});

	function decodeHtmlEntities(text, proc) {
		var entities = [
			['&amp;', '&'],
			['&apos;', "'"],
			['&lt;', '<'],
			['&gt;', '>'],
			['&quot;', '"']
		];
		for (var i = 0, max = entities.length; i < max; i++) {
			var reg = new RegExp(entities[i][0], 'g');
			text = text.replace(reg, entities[i][1]);
		}
		return text;
	}
});
