@extends('index')

@section('title', 'Mes listes')

@section('container')
<div class="ui attached message">
	<h1 class="header">
		<span>Vos listes</span>
		<span><a class="ui right floated basic icon button" href="{{ route('todo.create') }}" data-tooltip="Ajouter une liste"><i class="add icon"></i></a></span>
	</h1>
</div>
<div class="ui attached fluid segment">
	@if( !$todos->isEmpty() )
		<div class="ui three column stackable grid">
			@foreach( $todos as $todo )
				<?php
				$members = count( $todo->todo->todos_users );
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
									<a href="{{ route('todo.edit', ['todoId' => $todo->todo->id]) }}" class="ui basic button purple"><i class="options icon"></i>Détails</a>
									<a href="{{ route('task.browse', ['todoId' => $todo->todo->id]) }}" class="ui basic button blue">Afficher<i class="arrow right icon"></i></a>
								</div>
							</div>
						</div>
					</div>
				</div>
			@endforeach
		</div>
	@else
		vide
	@endif
</div>
@endsection
