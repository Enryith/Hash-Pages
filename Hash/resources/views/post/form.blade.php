@php /** @var $form Collective\Html\FormBuilder */ @endphp
@inject('form', 'Collective\Html\FormBuilder')
@extends('theme.base')
@section('title', 'New Post')
@section('content')

{{ $form->open(["autocomplete" => 'off'])}}

@component("form.text")
	@slot('form', $form)
	@slot('id', 'title')
	@slot('label', 'Title:')
@endcomponent

@component("form.text")
	@slot('form', $form)
	@slot('id', 'link')
	@slot('label', 'Link (Optional):')
@endcomponent

@component("form.textarea")
	@slot('form', $form)
	@slot('id', 'body')
	@slot('label', 'Body:')
	@slot('help', "The main body of your post. Everyone will see this!")
@endcomponent

@component("form.complete")
	@slot('form', $form)
	@slot('id', 'tag')
	@slot('uri', '/ajax/tags')
	@slot('label', "Master Tag:")
	@slot('help', "You'll be able to add more tags later.")
@endcomponent

@component("form.submit")
	@slot('form', $form)
	@slot('label', "Share")
@endcomponent

{{ $form->close() }}

@endsection
