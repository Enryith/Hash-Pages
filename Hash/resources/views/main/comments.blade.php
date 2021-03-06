@php
/** @var $comments \App\Entities\Comment[] **/
/** @var $form Collective\Html\FormBuilder */
$maxDepth = 10;
$indent = 6;
$css = [
	"border-left: ${indent}px solid rgb(" . getRGB(($depth * 36) % 360, 80, 95) . ");",
	"margin-left: " . ($depth * $indent) . "px;",
	"padding-left: 10px;",
	"padding-top: 8px;",
	"overflow: auto;"
];
@endphp

@foreach($comments as $comment)
	<div style="{{ implode(" ", $css) }}">
		@if($comment->isDeleted())
			<strong>
				[Deleted]
			</strong>
		@else
			<strong>
				<a href="{{ action('User@view', ['username' => $comment->getAuthor()->getUsername()]) }}">
					{{"@" . $comment->getAuthor()->getUsername() }}
				</a>
			</strong>

			@auth
				@if($depth < $maxDepth - 1)
					<a href="#collapse-reply-{{$comment->getId()}}" data-toggle="collapse" >reply</a>
				@endif
			@endauth
		@endif

		@can('modify-comment', $comment)
			@php /**do not remove*/ @endphp
			@php $action = 'Comment@form' @endphp
			<a href="{{ action("{$action}", [strtolower(explode('@', $action)[0]) => $comment->getId()]) }}">delete</a>
			<a href="#collapse-edit-{{$comment->getId()}}" data-toggle="collapse" >edit</a>
		@endcan

		@if($comment->isDeleted())
			<p>[Deleted]</p>
		@else
			@markdown($comment->getComment())
		@endif

		@auth
			@if($depth < $maxDepth -1)
				@php
					$id = "reply-{$comment->getId()}";
					$has = $errors->has($id);
					$show = $has ? "show" : "";
					$invalid = $has ? "is-invalid" : "";
					$danger = $has ? "has-danger" : ""
				@endphp
				<div class="collapse {{ $show }}" id="collapse-reply-{{ $comment->getId() }}">
					<!--For performance reasons, render manually-->
					<form method="post" action="{{ action('Comment@reply', ["id" => $comment->getId()]) }}" accept-charset="UTF-8">
						@csrf
						<div class="form-group {{ $danger }}">
							<textarea title="Edit Comment" name="{{ $id }}" class="form-control {{ $invalid }}" rows="3">{{ old($id)}}</textarea>
							@if($has)
								<div class="invalid-feedback">{{ $errors->first($id) }}</div>
							@endif
						</div>
						<div class="form-group">
							<input class="btn btn-primary" type="submit" value="Reply">
						</div>
					</form>
				</div>
			@endif
		@endauth

		@can("modify-comment", $comment)
			@php
				$id = "edit-{$comment->getId()}";
				$has = $errors->has($id);
				$show = $has ? "show" : "";
				$invalid = $has ? "is-invalid" : "";
				$danger = $has ? "has-danger" : ""
			@endphp
			<div class="collapse {{ $show }}" id="collapse-edit-{{ $comment->getId() }}">
				<!--For performance reasons, render manually-->
				<form method="post" action="{{ action('Comment@edit', ["id" => $comment->getId()]) }}" accept-charset="UTF-8">
					@csrf
					<div class="form-group {{ $danger }}">

						<textarea title="Edit Comment" name="{{ $id }}" class="form-control {{ $invalid }}" rows="3">@if(old($id)){{
							old($id)
						}}@else{{
							$comment->getComment()
						}}@endif</textarea>

						@if($has)
							<div class="invalid-feedback">{{ $errors->first($id) }}</div>
						@endif
					</div>
					<div class="form-group">
						<input class="btn btn-primary" type="submit" value="Edit">
					</div>
				</form>
			</div>
		@endcan
	</div>

	@if($depth < $maxDepth - 1 && $comment->getChildren()->count() > 0)
		@php /** RECURSION????????? **/ @endphp
		@component("main.comments")
			@slot("comments", $comment->getChildren())
			@slot("depth", $depth + 1)
		@endcomponent
	@endif

@endforeach
