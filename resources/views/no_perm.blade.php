@extends('index')

@section('title', 'Permission non accordée')

@section('container')
	{!! sendMessage('error', "Vous n'avez pas la permission d'effectuer cette action", ['header_message' => 'Permission non accordée']) !!}
@endsection
