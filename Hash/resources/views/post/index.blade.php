@extends('theme.base')
@section('title', 'Landing')
@section('content')
@php /** @var Illuminate\Pagination\LengthAwarePaginator|App\Entities\Post[] $table */ @endphp
	<div class="container">
		@foreach($table as $post)
			<h2>
				<a href="/post/{{$post->getId()}}">{{ $post->getTitle() }}</a>
				<small class="text-muted">By: {{ $post->getAuthor()->getUsername() }}</small>
			</h2>

			@component("ajax.scores")
				@slot("scores", $post->getScores())
			@endcomponent

			@if($post->getLink())
				<a href="{{ $post->getLink() }}">{{ $post->getLink() }}</a>
			@else
				<em>Text Post</em>
			@endif

			<p>{{ $post->getBody() }}</p>

			<hr>
		@endforeach
		{{ $table->links() }}
	</div>
@endsection