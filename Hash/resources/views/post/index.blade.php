@extends('theme.base')
@section('title', 'Landing')
@section('content')
@php /** @var Illuminate\Pagination\LengthAwarePaginator|App\Entities\User[] $pag */@endphp

	<div class="container">

		@foreach($pag as $user)
			{{$user->username}}
		@endforeach
	</div>
{{$pag->links()}}
@endsection