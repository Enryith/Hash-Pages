window.Echo = new Echo({
	broadcaster: 'socket.io',
	host: window.location.hostname + ':6001'
});

Echo.channel('message').listen('.message', (e) => {
	console.log(e);
});