@extends('theme.base')
@section('title', 'Landing')
@section('content')
@php /** @var Illuminate\Pagination\LengthAwarePaginator|App\Entities\Post[] $table */ @endphp
	<div class="container">
		@foreach($table as $post)
			<a href="../post/{{$post->getId()}}"><h2>{{ $post->getTitle() }}</h2></a>
			<em>{{ $post->getLink() }}</em>
			<div class="text-muted">By: {{ $post->getAuthor()->getUsername() }}</div>
			<p>{{ $post->getBody() }}</p>
			<hr>
		@endforeach
		{{ $table->links() }}
	</div>
@endsection