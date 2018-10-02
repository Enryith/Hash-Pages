@php /** @var $user App\Entities\User */ @endphp
@php /** @var $auth Illuminate\Contracts\Auth\Guard */ @endphp
@php /** @var $errors Illuminate\Support\ViewErrorBag */ @endphp
@inject('auth', 'Illuminate\Contracts\Auth\Guard')
@php($user = $auth->user())
<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="/css/global.css" rel="stylesheet">
	<link href="https://stackpath.bootstrapcdn.com/bootswatch/4.1.3/lumen/bootstrap.min.css"
	      integrity="sha384-DfbCiBdRiiNWvRTbHe5X9IfkezKzm0pCrZSKc7EM9mmSl/OyckwbYk3GrajL8Ngy"
	      rel="stylesheet"
	      crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.3.1.min.js"
	        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
	        crossorigin="anonymous">
	</script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
	        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
	        crossorigin="anonymous">
	</script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
	        integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
	        crossorigin="anonymous">
	</script>
	<title>HashPages - @yield('title')</title>
</head>
<body>

<nav class="navbar navbar-expand-md navbar-dark bg-primary fixed-top">
	<div class="container">
		<a class="navbar-brand" href="/">Hash Pages</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-nav">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="main-nav">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item">
					<a class="nav-link" href="{{url("/all")}}">All</a>
				</li>
			</ul>
			<form class="form-inline">
				<ul class="navbar-nav mr-auto">
					@auth
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" role="button" data-toggle="dropdown">
								{{ $user->getEmail() }}
							</a>
							<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
								<a class="dropdown-item" href="{{url("/post")}}">Post</a>
								<a class="dropdown-item" href="#">My Profile</a>
								<a class="dropdown-item" href="{{url("/settings")}}">Settings</a>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="{{url("/auth/logout")}}">Logout</a>
							</div>
						</li>
					@else
						<li class="nav-item">
							<a class="nav-link" href="{{url("/auth/login")}}">Login</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="{{url("/register")}}">Register</a>
						</li>
					@endauth
				</ul>
			</form>
		</div>
	</div>
</nav>

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
</div>
</body>
</html>