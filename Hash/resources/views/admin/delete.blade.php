@php /** @var $form Collective\Html\FormBuilder */ @endphp
@inject('form', 'Collective\Html\FormBuilder')
@extends('theme.base')
@section('title', 'Remove Admin')
@section('content')

	<h2>
		Are you sure you want to remove this admin?
	</h2>

{{ $form->open(["autocomplete" => 'off'])}}

	@component("form.submit")
		@slot('form', $form)
		@slot('id', 'nope')
		@slot('label', "Go Back")
	@endcomponent

	@component("form.submit")
		@slot('form', $form)
		@slot('id', 'remove')
		@slot('label', "Remove")
	@endcomponent

{{ $form->close() }}

@endsection
