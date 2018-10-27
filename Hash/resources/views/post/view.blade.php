@extends('theme.base')
@section('title', 'Login')
@section('content')
	<h1>{{$post->getTitle()}}</h1>

	@if (filter_var($post->getLink(), FILTER_VALIDATE_URL))
		<a href="{{$post->getLink()}}">Link</a>
	@endif

	<div class="text-muted">{{$post->getAuthor()->getUsername()}}</div>
	<p>{{$post->getBody()}}</p>
@endsection