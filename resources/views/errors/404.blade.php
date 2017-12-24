@extends('index')

@section('title', 'Page non trouvée')

@section('container')
	{!! sendMessage('error', "Impossible de trouver la page", ['header_message' => 'Page non trouvée']) !!}
@endsection