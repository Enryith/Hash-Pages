@extends('theme.base')
@section('title', $user->getUsername())
@section('content')



	<div class="row">
		<div class="col-md-auto">
			<img class="img-fluid profile" style="border-radius: 50%" src="{{ url($user->getPicture() ? $user->getPicturePublic() : "/img/default.jpg") }}" alt="Profile Picture" title="{{ $user->getName() }}">
		</div>
		<div class="col">
			<h1>
				{{$user->getUsername()}}
				<small class="text-muted">{{$user->getName()}}</small>
			</h1>
			@markdown($user->getBio())
		</div>
	</div>

@endsection
