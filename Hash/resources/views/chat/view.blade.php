@php
	/** @var App\Entities\Chat $chat */
	/** @var \App\Entities\User $user */
	$user = auth()->user();
	$username = $user->getUsername();
@endphp
@extends('theme.base')
@section('title', $chat->getTitle())
@section('content')
	@push('scripts')
		<script src="/js/chat.js"></script>
	@endpush

	<div id="js-chat-metadata" data-id="{{ $chat->getId() }}" data-username="{{ $user->getUsername() }}"></div>
	<p class="text-muted mb-2"><em>This is the beginning of <strong>{{ $chat->getTitle() }}</strong></em></p>
	<div id="js-chat-messages" class="chat-margin">
		<!-- Remember to update the template below too! -->
		@foreach ($chat->getLatest() as $message)
		<p class="mb-1">
			<strong>{{ "@" . $message->getUser()->getUsername() }}</strong>: {{ $message->getMessage() }}
		</p>
		@endforeach
	</div>

	<script id="template-chat" type="x-tmpl-mustache">
		<p class="mb-1 text-muted">
			<strong>@@{{ username }}</strong>: @{{ message }}
		</p>
	</script>

	<div class="chat-bar pt-4">
		<div class="container">
			<form id="js-chat-form" autocomplete="off" autocapitalize="on">
				<div class="input-group mb-1">
					<input class="form-control js-chat-input" name="message" type="text" id="message">
					<div class="input-group-append">
						<button class="btn btn-primary" type="submit">Send</button>
					</div>
				</div>
				<label for="message" class="form-control-label text-white">
					Send Message to <strong><em>{{ $chat->getTitle() }}</em></strong>
				</label>
			</form>
		</div>
	</div>
@endsection