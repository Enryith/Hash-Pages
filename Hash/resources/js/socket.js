import Echo from "laravel-echo";

let echo = new Echo({
	broadcaster: 'socket.io',
	host: window.location.hostname + ':6001'
});

echo.channel('message').listen('.message', (e) => {
	console.log(e);
});