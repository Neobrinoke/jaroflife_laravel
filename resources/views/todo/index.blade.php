@extends('index')

@section('title', 'Mes listes')

@section('container')
<div class="ui attached message">
	<h1 class="header">
		<span>Mes listes</span>
		<span><a class="ui right floated basic icon button" onclick="$('#add_todo_modal').modal({blurring: true}).modal('show');" data-tooltip="Ajouter une liste"><i class="add icon"></i></a></span>
	</h1>
</div>
<div class="ui attached fluid segment">
	@if( $todos->isNotEmpty() )
		<div class="ui three column stackable grid">
			@foreach( $todos as $todo )
				<?php
				$members = count( $todo->todo->members ) + 1;
				$tasks = count( $todo->todo->tasks );

				$members .= $members > 1 ? ' Membres' : ' Membre';
				$tasks .= $tasks > 1 ? ' Tâches' : ' Tâche';
				?>
				<div class="column">
					<div class="ui cards">
						<div class="card">
							<div class="content">
								<div class="header">{{ $todo->todo->name }}</div>
								<div class="description">{{ $todo->todo->description }}</div>
							</div>
							<div class="extra content">
								<span><i class="user icon"></i>{{ $members }}</span>
								<span class="right floated"><i class="browser icon"></i>{{ $tasks }}</span>
							</div>
							<div class="extra content">
								<span><i class="calendar icon"></i>Rejoins le {{ $todo->joined_at }}</span>
							</div>
							<div class="extra content">
								<div class="ui two buttons">
									<a href="{{ route('todo.edit', ['todo' => $todo->todo]) }}" class="ui basic button purple"><i class="options icon"></i>Détails</a>
									<a href="{{ route('todo.show', ['todo' => $todo->todo]) }}" class="ui basic button blue">Afficher<i class="arrow right icon"></i></a>
								</div>
							</div>
						</div>
					</div>
				</div>
			@endforeach
		</div>
	@else
		{!! sendMessage('warning', 'Aucune liste disponible') !!}
	@endif
</div>
<div class="ui modal {{ $errors->any() ? 'error' : '' }}" id="add_todo_modal">
	<i class="close icon"></i>
	<div class="header">Ajouter une liste</div>
	<div class="content">
		<form class="ui form {{ $errors->any() ? 'error' : '' }}" id="add_todo_form" method="POST" action="{{ route('todo.store') }}">
			{!! sendMessages('error', $errors->all(), ['header_message' => 'Erreurs']) !!}
			{{ csrf_field() }}
			<div class="field">
				<label for="name">Nom</label>
				<input type="text" name="name" id="name" value="{{ old('name') }}" placeholder="Nom de la liste">
			</div>
			<div class="field">
				<label for="description">Description</label>
				<textarea name="description" id="description" cols="30" rows="5" placeholder="Ecrivez votre description ici">{{ old('description') }}</textarea>
			</div>
		</form>
	</div>
	<div class="actions">
		<button class="ui button teal" type="submit" name="create_todo" onclick="$('#add_todo_form').submit();">Créer une nouvelle liste</button>
	</div>
</div>
@endsection
