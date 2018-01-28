@extends('layouts.guest')

@section('title', 'Inscription')

@section('container')
<form class="ui form stacked segment {{ $errors->any() ? 'error' : '' }}" method="POST" action="{{ route('register') }}">
	{{ csrf_field() }}
	{!! sendMessages('error', $errors->all(), ['header_message' => 'Erreurs']) !!}
	<div class="field {{ $errors->has('name') ? 'error' : '' }}">
		<div class="ui left icon input">
			<i class="user icon"></i>
			<input type="text" name="name" id="name" placeholder="Nom" value="{{ old('name') }}">
		</div>
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
	<div class="field {{ $errors->has('password') ? 'error' : '' }}">
		<div class="ui left icon input">
			<i class="lock icon"></i>
			<input type="password" name="password_confirmation" id="password_confirmation" placeholder="Mot de passe (confirmation)">
		</div>
	</div>
	<button type="submit" class="ui fluid large teal submit button">Inscription</button>
</form>
<div class="ui floating message">
	<span>Déjà un compte ? <a href="{{ route('login') }}">Connectez-vous</a></span>
</div>
@endsection
