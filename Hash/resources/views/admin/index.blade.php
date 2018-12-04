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
				<br>
			</h4>
		@endif
	@endforeach
</div>
<br>

{{ $form->open(["autocomplete" => 'off'])}}

@component("form.submit")
	@slot('form', $form)
	@slot('label', "Add Admin")
@endcomponent

{{ $form->close() }}
@endsection