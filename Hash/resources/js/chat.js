import Echo from "laravel-echo";

let echo = new Echo({
	broadcaster: 'socket.io',
	host: window.location.hostname + ':6001'
});

//set up data on page load
let mustache = new Writer();
let template = $('#template-chat').html();
let $html = $('html');
let $chat = $("#js-chat-form");
let $data = $("#js-chat-metadata");
let $messages = $("#js-chat-messages");
let username = $data.data("username");
let id = $data.data("id");
mustache.parse(template);

function scroll() {
	$html.scrollTop($html[0].scrollHeight);
}

scroll();

//Receive chat message from the server
echo.private('chat.' + id).listen('.message', function(e) {
	console.log(e);
	if (e.username === username) {
		console.log("Ignored self.");
	} else {
		let $template = $(mustache.render(template, e));
		$template.removeClass("text-muted");
		$messages.append($template);
		scroll();
	}
});

//Send chat message to the server
$chat.submit(function (e) {
	e.preventDefault();
	let $input = $chat.find(".js-chat-input");
	let message = $input.val();
	if (message.trim() === "") return;

	let $template = $(mustache.render(template, {
		username: username,
		message: message
	}));

	$input.val('');
	$messages.append($template);
	scroll();

	$.ajax({
		type:'POST',
		url:'/ajax/message',
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
		data: {
			id: id,
			message: message
		},
		success: function(data){
			console.log(data);
			$template.removeClass("text-muted");
			scroll();
		},
		error: function() {
			$template.removeClass("text-muted");
			$template.addClass("text-danger");
			scroll();
		}
	})
});


