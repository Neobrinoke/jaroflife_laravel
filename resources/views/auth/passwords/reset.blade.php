@extends('guest')

@section('title', 'Réinitialiser le mot de passe')

@section('container')
<form class="ui form stacked segment {{ $errors->has('email') || $errors->has('password') || $errors->has('password_confirmation') ? 'error' : '' }}" method="POST" action="{{ route('password.request') }}">
	{{ csrf_field() }}
    <input type="hidden" name="token" value="{{ $token }}">
	<div class="ui error message">
		<i class="close icon"></i>
		<div class="header">Erreur</div>
		<ul class="list">
            @if( $errors->has('email') )
                <li>{{ $errors->first('email') }}</li>
            @endif
			@if( $errors->has('password') )
				<li>{{ $errors->first('password') }}</li>
			@endif
			@if( $errors->has('password_confirmation') )
				<li>{{ $errors->first('password_confirmation') }}</li>
			@endif
		</ul>
	</div>
	<div class="field {{ $errors->has('email') ? 'error' : '' }}">
		<div class="ui left icon input">
			<i class="mail icon"></i>
			<input type="email" name="email" id="email" placeholder="Adresse email" value="{{ old('email') }}">
		</div>
	</div>
	<div class="field {{ $errors->has('password') ? 'error' : '' }}">
		<div class="ui left icon input">
			<i class="lock icon"></i>
			<input type="password" name="password" id="password" placeholder="Mot de passe">
		</div>
	</div>
	<div class="field {{ $errors->has('password') || $errors->has('password_confirmation') ? 'error' : '' }}">
		<div class="ui left icon input">
			<i class="lock icon"></i>
			<input type="password" name="password_confirmation" id="password_confirmation" placeholder="Mot de passe (confirmation)">
		</div>
	</div>
	<button type="submit" class="ui fluid large teal submit button">Réinitialiser le mot de passe</button>
</form>
@endsection
