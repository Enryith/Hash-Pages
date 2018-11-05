@php /** @var $comments \App\Entities\Comment[] **/ @endphp
@php $indentation = isset($indentation) ? $indentation : 0 @endphp
@foreach($comments as $comment)
	<div style="margin-left: {{$indentation * 30}}px">
		<strong><a href="{{ action('User@view', ['username' => $post->getAuthor()->getUsername()]) }}">{{"@" . $comment->getAuthor()->getUsername() }}</a></strong><br>
		<span>{{ $comment->getComment() }}</span>
	</div>

	@if($comment->getChildren()->count() > 0)
		@php /** RECURSION????????? **/ @endphp
		@component("main.comments")
			@slot("comments", $comment->getChildren())
			@slot("indentation", $indentation + 1)
		@endcomponent
	@endif
@endforeach
