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
	<meta name="csrf-token" content="{{ csrf_token() }}" />
	<link href="/css/global.css" rel="stylesheet">
	<link rel="preload" href="{{url("/js/manifest.js")}}" as="script">
	<link rel="preload" href="{{url("/js/vendor.js")}}" as="script">
	<link rel="preload" href="/js/app.js" as="script">
	<link rel="preload" href="/js/hash.js" as="script">
	<link href="https://stackpath.bootstrapcdn.com/bootswatch/4.1.3/sandstone/bootstrap.min.css"
	      integrity="sha384-CfCAYEgrdtRrpvjGKxoaRy5ge1ggMbxNSpEkY+XqdfdRTUkRrYZVB2z99E7BsEDZ"
	      crossorigin="anonymous"
	      rel="stylesheet">
	<title>HashPages - @yield('title')</title>
	<script type="text/javascript">
		//look, an easter egg!
	</script>
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
			<ul class="navbar-nav">
				@auth
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" role="button" data-toggle="dropdown">
							{{ $user->getUsername() }}
						</a>
						<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
							<a class="dropdown-item" href="{{url("/post")}}">New Post</a>
							<a class="dropdown-item" href="{{url("/user")}}">My Profile</a>
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

	<script src="{{url("/js/manifest.js")}}"></script>
	<script src="{{url("/js/vendor.js")}}"></script>
	<script src="/js/app.js"></script>
	<script src="/js/hash.js"></script>
	@stack('scripts')
</div>
</body>
</html>