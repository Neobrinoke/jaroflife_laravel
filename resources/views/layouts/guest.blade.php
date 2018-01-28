@extends('base')

@section('layouts')
	<main id="guest" class="ui middle aligned center aligned grid">
		<div class="column">
			<h2 class="ui teal header">
				<div class="content">@yield('title')</div>
			</h2>
			@yield('container')
		</div>
	</main>
@endsection