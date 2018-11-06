@php /** @var Illuminate\Pagination\LengthAwarePaginator|App\Entities\Chat[] $table */ @endphp
@php /** @var $form Collective\Html\FormBuilder */ @endphp
@inject('form', 'Collective\Html\FormBuilder')
@extends('theme.base')
@section('title', 'Chat with Users')
@section('content')
	<p>Choose a user to chat with.</p>
	@foreach ($table as $chat)
		{{ $chat->getTitle() }}
		<br>
	@endforeach
	{{ $table->links() }}

	{{ Form::open(array('url' => 'chat')) }}


	@component("form.text")
		@slot('form', $form)
		@slot('id', 'title')
		@slot('label', "Title:")
	@endcomponent

	@component("form.multi")
		@slot('form', $form)
		@slot('id', 'users')
		@slot('uri', '/ajax/users')
		@slot('label', "Users:")
	@endcomponent

	@component("form.submit")
		@slot('form', $form)
		@slot('label', "Create a New Chat")
	@endcomponent

	{{ Form::close() }}

@endsection