@php /** @var Illuminate\Pagination\LengthAwarePaginator|App\Entities\Tag[] $table */ @endphp
@extends('theme.base')
@section('title', 'All Tags')
@section('content')
	<h4 class="mb-3">Choose a tag to view it's activity</h4>
	@foreach($table as $tag)
		<h4>
			<a href="/tag/{{$tag->getTag()}}">{{ "#".$tag->getTag() }}</a>
		</h4>
	@endforeach
@endsection