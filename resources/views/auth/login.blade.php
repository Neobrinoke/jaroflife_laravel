@extends('layouts.guest')

@section('title', 'Connexion')

@section('container')
<form class="ui form stacked segment {{ $errors->any() ? 'error' : '' }}" method="POST" action="{{ route('login') }}">
	{{ csrf_field() }}
	{!! sendMessages('error', $errors->all(), ['header_message' => 'Erreurs']) !!}
	<div class="field {{ $errors->has('email') ? 'error' : '' }}">
		<div class="ui left icon input">
			<i class="mail icon"></i>
			<input type="text" name="email" id="email" placeholder="Adresse email" value="{{ old('email') }}">
		</div>
	</div>
	<div class="field {{ $errors->has('password') ? 'error' : '' }}">
		<div class="ui left icon input">
			<i class="lock icon"></i>
			<input type="password" name="password" id="password" placeholder="Mot de passe">
		</div>
	</div>
	<div class="field">
		<div class="ui checkbox">
			<input type="checkbox" tabindex="0" class="hidden" name="remember" {{ old('remember') ? 'checked' : '' }}>
			<label>Se souvenir de moi</label>
		</div>
	</div>
	<button type="submit" class="ui fluid large teal submit button">Connexion</button>
</form>
<div class="ui floating message">
	<span>Mot de passe oublié ? <a href="{{ route('password.request') }}">Paniquez-pas cliquez ici !</a></span>
	<br>
	<br>
	<span>Nouveau ? <a href="{{ route('register') }}">Enregistrez-vous</a></span>
</div>
@endsection
