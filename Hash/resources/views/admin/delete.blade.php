@php /** @var $form Collective\Html\FormBuilder */ @endphp
@inject('form', 'Collective\Html\FormBuilder')
@extends('theme.base')
@section('title', 'Delete Comment')
@section('content')

	<h2>
		Who is the admin you want to add?
	</h2>

{{ $form->open(["autocomplete" => 'off'])}}

	@component("form.text")
		@slot('form', $form)
		@slot('id', 'user')
		@slot('label', "Username:")
	@endcomponent

	@component("form.submit")
		@slot('form', $form)
		@slot('label', "Submit")
	@endcomponent

{{ $form->close() }}

@endsection
