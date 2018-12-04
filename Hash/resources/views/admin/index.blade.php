@php /** @var Illuminate\Pagination\LengthAwarePaginator|App\Entities\User[] $table */ @endphp
@inject('form', 'Collective\Html\FormBuilder')
@extends('theme.base')
@section('title', 'Admin Page')
@section('content')
<div class="container">
	<h1>Administrators</h1>
	@foreach($table as $user)
		@if($user->isAdmin() or $user->getId() == 1)
			<h4>
				<a href="/user/{{$user->getUsername()}}">{{ "@".$user->getUsername() }}</a>
				<a href="{{ action('Admin@removeAdmin', ['user' => $user->getId()]) }}">Remove</a>
				<br>
			</h4>
		@endif
	@endforeach
</div>
<br>

<h4>
	Add Admin
</h4>

{{ $form->open(["autocomplete" => 'off'])}}

@component("form.text")
	@slot('form', $form)
	@slot('id', 'user')
	@slot('label', "Username:")
@endcomponent

@component("form.submit")
	@slot('form', $form)
	@slot('label', "Add")
@endcomponent

{{ $form->close() }}

@endsection