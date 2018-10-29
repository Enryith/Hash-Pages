<div class="btn-toolbar">
	@foreach($scores as $score)
		@php /** @var $score App\Entities\Score */ @endphp
		<div class="btn-group mr-2" role="group" aria-label="Second group">
			<a type="button" class="btn btn-secondary" href="#">+</a>
			<a type="button" class="btn btn-secondary" href="#">{{ $score->getTag()->getTag() }}</a>
			<a type="button" class="btn btn-secondary" href="#">-</a>
		</div>
	@endforeach
</div>