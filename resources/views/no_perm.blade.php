@extends('index')

@section('title', 'Permission non accordé')

@section('container')
	{!! sendMessage('error', "Vous n'avez pas la permission d'effectuer cette action", ['header_message' => 'Permission non accordé']) !!}
@endsection
