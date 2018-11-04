@php /** @var $comments \App\Entities\Comment[] **/ @endphp
@php $indentation = isset($indentation) ? $indentation : 0 @endphp
@foreach($comments as $comment)
	<div style="margin-left: {{$indentation * 10}}px">
		<strong>{{ "@" . $comment->getAuthor()->getUsername() }}</strong><br>
		<span>{{ $comment->getComment() }}</span>
	</div>

	@if($comment->getChildren()->count() > 0)
		@php /** RECURSION????????? **/ @endphp
		@component("main.comments")
			@slot("comments", $d->getComments())
			@slot("indentation", $indentation + 1)
		@endcomponent
	@endif
@endforeach
