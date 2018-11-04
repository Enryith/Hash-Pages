@extends('theme.base')
@section('title', 'Landing')
@section('content')
@php /** @var Illuminate\Pagination\LengthAwarePaginator|App\Entities\Post[] $table */ @endphp
	<div class="container">
		<div id="target">

		</div>
		@foreach($table as $post)
			<h2>
				<a href="/post/{{$post->getId()}}">{{ $post->getTitle() }}</a>
				<small class="text-muted">By: {{ $post->getAuthor()->getUsername() }}</small>
			</h2>

			@if($post->getLink())
				<h4><a href="{{ $post->getLink() }}">{{ $post->getLink() }}</a></h4>
			@else
				<em>Text Post</em>
			@endif

			<p>{{ $post->getBody() }}</p>

			<div class="btn-toolbar">
				@foreach($post->getDiscussions() as $d)
					@component("ajax.tag")
						@slot("discussion", $d)
					@endcomponent
				@endforeach
			</div>

			<hr>
		@endforeach
		{{ $table->links() }}
	</div>
@endsection