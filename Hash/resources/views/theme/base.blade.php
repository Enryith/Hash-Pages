@php /** @var $errors Illuminate\Support\ViewErrorBag */ @endphp
<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="/css/global.css" rel="stylesheet">
	<link href="https://stackpath.bootstrapcdn.com/bootswatch/3.3.7/lumen/bootstrap.min.css"
	      integrity="sha384-gv0oNvwnqzF6ULI9TVsSmnULNb3zasNysvWwfT/s4l8k5I+g6oFz9dye0wg3rQ2Q"
	      rel="stylesheet"
	      crossorigin="anonymous">
	<title>HashPages - @yield('title')</title>
</head>
<body>

<div class="navbar navbar-default navbar-fixed-top">
	<div class="container">
		<div class="navbar-header">
			<a href="/" class="navbar-brand">Hash Pages</a>
			<button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
		</div>
		<div class="navbar-collapse collapse" id="navbar-main">
			<ul class="nav navbar-nav">
				<li><a href="#">Link</a></li>
			</ul>

			<ul class="nav navbar-nav navbar-right">
				@auth
					<li><a href="{{url("/auth/logout")}}">Logout</a></li>
				@else
					<li><a href="{{url("/auth/login")}}">Login</a></li>
					<li><a href="{{url("/register")}}">Register</a></li>
				@endauth
			</ul>
		</div>
	</div>
</div>

<div class="container main">
	<div class="flash-message">
		@foreach (['danger', 'warning', 'success', 'info'] as $msg)
			@if(session()->has('alert-' . $msg))
				<div class="alert alert-{{ $msg }}">
					{{ session()->get('alert-' . $msg) }}
				</div>
			@endif
		@endforeach
	</div>

	@yield('content')

	<script src="https://code.jquery.com/jquery-3.3.1.min.js"
	        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
	        crossorigin="anonymous">
	</script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
	        integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
	        crossorigin="anonymous">
	</script>
</div>
</body>
</html>