import Echo from "laravel-echo";

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */
let echo = new Echo({
	broadcaster: 'socket.io',
	host: window.location.hostname + ':6001'
});

echo.channel('message').listen('.message', (e) => {
	console.log(e);
});