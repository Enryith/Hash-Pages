@extends('theme.base')
@section('title', 'Landing')
@section('content')
	<div class="jumbotron">
		<h1>Hello, Laravel</h1>
		<p>
			Some words go inside this Jumbotron to make it look important. There really isn't anything interesting to
			read here, so you could probably just glance over it and be fine. This is one more sentence before I conclude
			this main header. Thanks and have a nice day.
		</p>
	</div>

	@auth

	@else
		<div class="jumbotron">
			<p>
				Consider registering for an account. You will be able to subscribe to tags, follow other users, and gain
				a following of your own.
			</p>
		</div>
	@endauth
@endsection
