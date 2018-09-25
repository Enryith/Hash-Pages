@extends('theme.base')
@section('title', 'Landing')
@section('content')
@php /** @var \Illuminate\Database\Query\Builder $users */@endphp
@php /** @var \Illuminate\Contracts\Pagination\LengthAwarePaginator $pag */@endphp

	<div class="container">
		@php dd($users, $pag) @endphp
	</div>

	{{ $users->links() }}

@endsection