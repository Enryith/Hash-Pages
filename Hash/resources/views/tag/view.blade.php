@php
	/** @var Illuminate\Pagination\LengthAwarePaginator|App\Entities\Post[] $table */
	/** @var $tag \App\Entities\Tag */
@endphp

@extends('theme.base')
@section('title', $tag->getTag())
@section('content')

	@php($hasPosts=false)

	@foreach($table as $post)
		@if(!$post->isDeleted())
		@php($hasPosts=true)
		<h2>
			<a href="{{ action('Post@view', ["id" => $post->getId()]) }}">{{ $post->getTitle() }}</a>
			<small class="text-muted">By: <a href="{{ action('User@view', ['username' => $post->getAuthor()->getUsername()]) }}">{{ $post->getAuthor()->getUsername() }}</a></small>
		</h2>

		@if($post->getLink())
			<h4><a href="{{ $post->getLink() }}">{{ $post->getLink() }}</a></h4>
		@else
			<em>Text Post</em>
		@endif

		@markdown($post->getBody())

		<div class="btn-toolbar">
			@foreach($post->getDiscussions() as $d)
				@if(!$d->isDeleted())
				@component("ajax.tag")
					@slot("discussion", $d)
				@endcomponent
				@endif
			@endforeach
		</div>

		<hr>
		@endif
	@endforeach

	@if(!$hasPosts)
		<p class="js-init text-muted text-center">No Posts were found with related tag {{$tag->getTag()}}</p>
	@endif

@endsection