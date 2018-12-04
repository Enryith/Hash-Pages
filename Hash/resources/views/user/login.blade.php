@php /** @var $form Collective\Html\FormBuilder */ @endphp
@inject('form', 'Collective\Html\FormBuilder')
@extends('theme.base')
@section('title', 'Login')
@section('content')
<div class="p-4">
	<div class="card mx-auto" style="max-width: 400px">
		<h5 class="card-header">Welcome to Hash#Pages</h5>
		<div class="card-body">
			<h5 class="card-title">Please Sign In</h5>

			{{ $form->open()}}

			@component("form.text")
				@slot('form', $form)
				@slot('id', 'login')
				@slot('label', 'Username or Email:')
			@endcomponent

			@component("form.password")
				@slot('form', $form)
				@slot('id', 'password')
				@slot('label', 'Password:')
			@endcomponent

			@component("form.checkbox")
				@slot('form', $form)
				@slot('id', 'remember')
				@slot('label', 'Remember me')
			@endcomponent

			<hr>

			<div class="form-group">
				<div class="btn-group">
					<div class="btn btn-secondary disabled">
						<img src="/img/fa/lock-solid.svg" style="width: 16px">
					</div>
					<input class="btn btn-primary" name="submit" type="submit" value="Sign in with Account">
				</div>
			</div>

			{{ $form->close() }}

			<div class="btn-group">
				<div class="btn btn-secondary disabled">
					<img src="/img/fa/google-brands.svg" style="width: 16px">
				</div>
				<a class="btn btn-primary" name="submit" type="submit" href="{{ action("Auth@provider", "google") }}">Sign in with Google</a>
			</div>
		</div>
	</div>
</div>

@endsection
