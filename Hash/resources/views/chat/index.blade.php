@php
	/** @var Illuminate\Pagination\LengthAwarePaginator|App\Entities\Chat[] $table */
	/** @var $form Collective\Html\FormBuilder */
@endphp
@inject('form', 'Collective\Html\FormBuilder')
@extends('theme.base')
@section('title', 'Chat with Users')
@section('content')
	<h4 class="mb-3">Choose a group to chat with</h4>

	<div class="list-group">
	@foreach ($table as $chat)
		<a class="list-group-item list-group-item-action" href="{{ action("Chat@view", ["id" => $chat->getId()]) }}">
			{{ $chat->getTitle() }}
			<div class="text-muted">
				@foreach($chat->getUsers() as $user)
					<span class="mr-2"> {{ '@' . $user->getUsername() }} </span>
				@endforeach
			</div>
		</a>
	@endforeach

	@if($table->count() == 0)
		<div class="list-group-item text-muted">We've come up empty! Start a conversation below.</div>
	@endif
	</div>

	{{ $table->links() }}

	<h4 class="mb-3 mt-3">Or start a new conversation</h4>

	{{ $form->open(array('url' => 'chat')) }}

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

	{{ $form->close() }}

@endsection