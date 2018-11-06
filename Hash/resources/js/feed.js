import Echo from "laravel-echo";

let echo = new Echo({
	broadcaster: 'socket.io',
	host: window.location.hostname + ':6001'
});

let mustache = new Writer();
let postTemp = $('#template-post').html();
let discTemp = $('#template-discussion').html();
let comTemp = $('#template-comment').html();

mustache.parse(postTemp);
mustache.parse(discTemp);
mustache.parse(comTemp);

echo.channel('feed').listen('.post', function (e) {
	console.log(e);
	$('#target').prepend(mustache.render(postTemp, e));
	$(".js-init").hide();
});

echo.channel('feed').listen('.discussion', function (e) {
	console.log(e);
	$('#target').prepend(mustache.render(discTemp, e));
	$(".js-init").hide();
});

echo.channel('feed').listen('.comment', function (e) {
	console.log(e);
	$('#target').prepend(mustache.render(comTemp, e));
	$(".js-init").hide();
});
