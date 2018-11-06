@php /** @var App\Entities\Chat $chat */@endphp
@extends('theme.base')
@section('title', $chat->getTitle())
@section('content')
	<h1>{{ $chat->getTitle() }}</h1>

	@foreach ($chat->getMessages() as $message)
		{{ $message->getUser()->getUsername() }}: {{ $message->getMessage() }}
		<br>
	@endforeach

	<div class="form-group ">
		<label for="message" class="form-control-label">Enter Message:</label>
		<input class="form-control " name="message" type="text" id="message">
	</div>

@endsection