@extends('index')

@section('title', $title)

@section('container')
	<div class="ui attached message">
		<h1 class="header">
			<span><a class="ui left floated basic icon button" href="{{ url()->previous() }}" data-tooltip="Retour en arrière"><i class="arrow left icon"></i></a></span>
			<span>{{ $title }}</span>
			<span><a class="ui right floated basic icon button" onclick="$('#add_task_modal').modal('show');" data-tooltip="Ajouter une tâche"><i class="add icon"></i></a></span>
		</h1>
	</div>
	<div class="ui attached fluid segment">
		@if( !$todo->tasks->isEmpty() )
			<table class="ui celled sortable selectable table teal">
				<thead>
					<tr>
						<th>Nom</th>
						<th>Description</th>
						<th>Priorité</th>
						<th>Auteur</th>
						<th>Ajouté le ...</th>
						<th></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					@foreach( $todo->tasks as $task )
						<tr>
							<td>{{ $task->name }}</td>
							<td>{{ $task->description }}</td>
							<td>{{ $task->priority }}</td>
							<td>{{ $task->user->name }}</td>
							<td>{{ $task->created_at }}</td>
							<td class="collapsing">
								<button class="ui icon button teal" onclick="$('#edit_task_{{ $task->id }}_modal').modal('show');" data-tooltip="Editer la tâche"><i class="edit icon"></i></button>
							</td>
							<td class="collapsing">
								<button class="ui icon button red" onclick="$('#delete_task_{{ $task->id }}_modal').modal('show');" data-tooltip="Supprimer la tâche"><i class="trash icon"></i></button>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		@else
			{!! sendMessage('warning', 'Aucune tâche disponible') !!}
		@endif
	</div>
	<div class="ui modal {{ $errors->any() && old('task_id') == null ? 'error' : '' }}" id="add_task_modal">
		<i class="close icon"></i>
		<div class="header">Ajouter une tâche</div>
		<div class="content">
			<form class="ui form {{ $errors->any() && old('task_id') == null ? 'error' : '' }}" id="add_task_form" method="POST" action="{{ route('task.store', [$todo]) }}">
				{!! sendMessages('error', $errors->all(), ['header_message' => 'Erreurs']) !!}
				{{ csrf_field() }}
				<div class="field">
					<div class="two fields">
						<div class="field">
							<label>Nom</label>
							<input type="text" name="name" id="name" value="{{ old('name') }}">
						</div>
						<div class="field">
							<label>Priorité</label>
							<select class="ui dropdown" name="priority" id="priority">
								<option value="1" {{ old('priority') == 1 ? 'selected' : '' }}>Basse</option>
								<option value="2" {{ old('priority') == 2 ? 'selected' : '' }}>Moyenne</option>
								<option value="3" {{ old('priority') == 3 ? 'selected' : '' }}>Haute</option>
							</select>
						</div>
					</div>
				</div>
				<div class="field">
					<label>Description</label>
					<textarea name="description" id="description" cols="30" rows="5">{{ old('description') }}</textarea>
				</div>
			</form>
		</div>
		<div class="actions">
			<button class="ui button teal" type="submit" name="create_task" onclick="$('#add_task_form').submit();">Créer une nouvelle tâche</button>
		</div>
	</div>
	@foreach( $todo->tasks as $task )
		<div class="ui modal" id="delete_task_{{ $task->id }}_modal">
			<i class="close icon"></i>
			<div class="header">Supprimer une tâche</div>
			<div class="content">
				<p>Voulez-vous vraiment supprimer cette tâche ? L'action est irreversible !</p>
				<form class="ui form" id="delete_task_{{ $task->id }}_form" method="POST" action="{{ route('task.destroy', ['todo' => $todo, 'task' => $task]) }}">
					{{ csrf_field() }}
				</form>
			</div>
			<div class="actions">
				<button class="ui negative left labeled icon button"><i class="close icon"></i>Non</button>
				<button class="ui positive right labeled icon button" onclick="$('#delete_task_{{ $task->id }}_form').submit();">Oui<i class="checkmark icon"></i></button>
			</div>
		</div>
		<div class="ui modal {{ $errors->any() && $task->id == old('task_id') ? 'error' : '' }}" id="edit_task_{{ $task->id }}_modal">
			<i class="close icon"></i>
			<div class="header">Editer une tâche</div>
			<div class="content">
				<form class="ui form {{ $errors->any() && $task->id == old('task_id') ? 'error' : '' }}" id="edit_task_{{ $task->id }}_form" method="POST"  action="{{ route('task.update', ['todo' => $todo, 'task' => $task]) }}">
					{!! sendMessages('error', $errors->all(), ['header_message' => 'Erreurs']) !!}
					{{ csrf_field() }}
					<input type="hidden" name="task_id" value="{{ $task->id }}">
					<div class="field">
						<div class="two fields">
							<div class="field">
								<label>Nom</label>
								<input type="text" name="name" id="name" value="{{ $task->name }}">
							</div>
							<div class="field">
								<label>Priorité</label>
								<select class="ui dropdown" name="priority" id="priority">
									<option value="1" {{ $task->priority == 1 ? 'selected' : '' }}>Basse</option>
									<option value="2" {{ $task->priority == 2 ? 'selected' : '' }}>Moyenne</option>
									<option value="3" {{ $task->priority == 3 ? 'selected' : '' }}>Haute</option>
								</select>
							</div>
						</div>
					</div>
					<div class="field">
						<label>Description</label>
						<textarea name="description" id="description" cols="30" rows="5">{{ $task->description }}</textarea>
					</div>
				</form>
			</div>
			<div class="actions">
				<button class="ui button teal" type="submit" name="edit_task" onclick="$('#edit_task_{{ $task->id }}_form').submit();">Sauvegarder les modifications</button>
			</div>
		</div>
	@endforeach
@endsection