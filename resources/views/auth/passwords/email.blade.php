@extends('guest')

@section('title', 'Mot de passe oublié')

@section('container')
<?php
$classcss = '';
if( $errors->has('email') != false ) {
	$classcss = 'error';
} else if( session('status') != null ) {
	$classcss = 'success';
}
?>
<form class="ui form stacked segment {{ $classcss }}" method="POST" action="{{ route('password.email') }}">
	{{ csrf_field() }}
	<div class="ui error message">
		<i class="close icon"></i>
		<div class="header">Erreur</div>
		<ul class="list">
			<li>{{ $errors->first('email') }}</li>
		</ul>
	</div>
	<div class="ui success message">
		<i class="close icon"></i>
		<div class="header">Succès</div>
		<p>{{ session('status') }}</p>
	</div>
	<div class="field {{ $errors->has('email') ? 'error' : '' }}">
		<div class="ui left icon input">
			<i class="mail icon"></i>
			<input type="text" name="email" id="email" placeholder="Adresse email" value="{{ old('email') }}">
		</div>
	</div>
	<button type="submit" class="ui fluid large teal submit button">Envoyer la demande</button>
</form>
@endsection
