@extends('guest')

@section('title', 'Mot de passe oublié')

@section('container')
<?php
$classcss = '';
if( $errors->any() != false ) {
	$classcss = 'error';
} else if( session('status') != null ) {
	$classcss = 'success';
}
?>
<form class="ui form stacked segment {{ $classcss }}" method="POST" action="{{ route('password.email') }}">
	{{ csrf_field() }}
	{!! sendMessages('error', $errors->all(), ['header_message' => 'Erreurs']) !!}
	{!! sendMessage('success', session('status'), ['header_message' => 'Succès']) !!}
	<div class="field {{ $errors->has('email') ? 'error' : '' }}">
		<div class="ui left icon input">
			<i class="mail icon"></i>
			<input type="text" name="email" id="email" placeholder="Adresse email" value="{{ old('email') }}">
		</div>
	</div>
	<button type="submit" class="ui fluid large teal submit button">Envoyer la demande</button>
</form>
@endsection
