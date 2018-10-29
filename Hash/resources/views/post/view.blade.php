@extends('theme.base')
@section('title', 'Login')
@section('content')
	<h1>{{$post->getTitle()}}</h1>

	@if($post->getLink())
		<a href="{{ $post->getLink() }}">{{ $post->getLink() }}</a>
	@else
		<em>Text Post</em>
	@endif

	<div class="text-muted">{{$post->getAuthor()->getUsername()}}</div>
	<p>{{$post->getBody()}}</p>
@endsection