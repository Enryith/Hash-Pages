@php
	/** @var Illuminate\Pagination\LengthAwarePaginator|App\Entities\Post[] $table */
	/** @var $form Collective\Html\FormBuilder */
@endphp

@inject('form', 'Collective\Html\FormBuilder')
@extends('theme.base')
@section('title', 'hi')
@section('content')

	@foreach($table as $post)
		<h2>
			<a href="/post/{{$post->getId()}}">{{ $post->getTitle() }}</a>
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
				@component("ajax.tag")
					@slot("discussion", $d)
				@endcomponent
			@endforeach
		</div>

		<hr>
	@endforeach

@endsection