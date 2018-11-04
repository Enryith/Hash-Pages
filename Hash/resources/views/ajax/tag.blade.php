@php
	use App\Entities\Vote;
	/** @var $discussion App\Entities\Discussion */
	$type = $discussion->hasVoted(auth()->user());
	$agree = $type == Vote::AGREE ? "active" : "";
	$disagree = $type == Vote::DISAGREE ? "active" : "";
@endphp

<div class="btn-group mr-2">
	@auth
		<button class="btn btn-outline-secondary js-vote js-agree pt-0 pb-0 {{$agree}}" data-discussion="{{ $discussion->getId() }}">
			<strong class="text-success text-lg-center js-agree-text vote">
				{{$discussion->getCachedAgree()}}
			</strong>
		</button>
	@else
		<div class="btn btn-outline-secondary no-hover disabled">
			<strong class="text-success vote">
				{{$discussion->getCachedAgree()}}
			</strong>
		</div>
	@endauth

	<a class="btn btn-secondary" href="{{ url("/tag/{$discussion->getTag()->getTag()}") }}">#{{ $discussion->getTag()->getTag() }}</a>

	@auth
		<button class="btn btn-outline-secondary js-vote js-disagree pt-0 pb-0 {{$disagree}}" data-discussion="{{ $discussion->getId() }}">
			<strong class="text-danger text-lg-center js-disagree-text vote">
				{{$discussion->getCachedDisagree()}}
			</strong>
		</button>
	@else
		<div class="btn btn-outline-secondary no-hover disabled">
			<strong class="text-danger vote">
				{{$discussion->getCachedDisagree()}}
			</strong>
		</div>
	@endauth
</div>