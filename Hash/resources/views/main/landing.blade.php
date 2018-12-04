@extends('theme.base')
@section('title', 'Landing')
@section('content')
	<div class="pt-2"></div>
	<div class="jumbotron pt-4 pb-4">
		<h1 class="display-3" style="font-family: 'Fredericka the Great', cursive;">Hash#<wbr>Pages</h1>
		<p class="lead">
			This is a media sharing site that is based around tags. Anyone can create a tag and then other
			users can apply those tags to their posts. This makes it so anyone can easily find and be a part of
			discussions on topics of interest.
		</p>
		<hr class="my-4" style="color:GREY">
		<p>
			We created this site using Laravel, Doctrine, Bootstrap, and Markdown as well as some JavaScript
			technologies including jQuery, Mustache, Socket.io, and WebPack. We are using Laravel Blade templates for
			rendering our views, Bootstrap for our CSS, and Doctrine for our database models. We are using
			<a href="https://github.com/GrahamCampbell">Graham Campbell's</a> implementation of markdown so that users
			can write in fancy <b>bold</b> or <i>italic</i> text. For our JavaScript technologies we are using jQuery
			for client-side scripting, Mustache to render templates dynamically sent from the server, Socket.io
			for the implementation of WebSockets, and Webpack so that we are able to use node modules.
		</p>
		<hr class="my-4" style="color:GREY">
		<p>
			If you would like to see the documentation click <a href="{{ url('/docs/api') }}">here.</a>
		</p>
	</div>
	<div class="card-group mb-5">
		<div class="card">
			<img class="card-img-top" src="/img/jhin.gif" alt="Card image cap">
			<div class="card-body">
				<h5 class="card-title">Andrew Peters</h5>
				<p class="card-text mb-5">Hey, I'm Andrew. I like playing video games and doing other fun computer stuff. My favorite games are Destiny and Monster Hunter.</p>
				<a href="https://github.com/Enryith" class="btn btn-primary anchor-bottom">GitHub</a>
			</div>
		</div>
		<div class="card" >
			<img class="card-img-top" src="/img/red.png" alt="Card image cap">
			<div class="card-body">
				<h5 class="card-title">Aaron Walter</h5>
				<p class="card-text mb-5">The Big Man Codester.</p>
				<a href="https://github.com/RedInquisitive" class="btn btn-primary anchor-bottom">GitHub</a>
			</div>
		</div>
		<div class="card">
			<img class="card-img-top" src="/img/shulk.png" alt="Card image cap">
			<div class="card-body">
				<h5 class="card-title">Dheepak Nalluri</h5>
				<pre class="card-text mb-5">E N T I T I E S.</pre>
			</div>
		</div>
		<div class="card">
			<img class="card-img-top" src="/img/dog.jpg" alt="Card image cap">
			<div class="card-body">
				<h5 class="card-title">Keyes Anderson</h5>
				<p class="card-text mb-5">33 commits in 2 days.</p>
				<a href="https://github.com/keyesa" class="btn btn-primary anchor-bottom">GitHub</a>
			</div>
		</div>
	</div>
@endsection
