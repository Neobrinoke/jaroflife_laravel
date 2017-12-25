@extends('index')

@section('title', $title)

@section('container')
<div class="ui attached message">
	<h1 class="header">
		<span>{{ $title }}</span>
		<span><a class="ui right floated basic icon button" onclick="$('#add_task_modal').modal({blurring: true}).modal('show');" data-tooltip="Ajouter une tâche"><i class="add icon"></i></a></span>
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
							<button type="submit" class="ui icon button teal" onclick="$('#edit_task_{{ $task->id }}').modal({blurring: true}).modal('show');" data-tooltip="Editer la tâche"><i class="edit icon"></i></button>
						</td>
						<td class="collapsing">
							<form method="POST">
								{{ csrf_field() }}
								<input type="hidden" name="_method" value="DELETE"/>
								<input type="hidden" name="task_id" value="{{ $task->id }}"/>
								<button type="submit" class="ui icon button red" data-tooltip="Supprimer la tâche"><i class="trash icon"></i></button>
							</form>
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	@else
		{!! sendMessage('warning', 'Aucune tâche disponible') !!}
	@endif
</div>
<div class="ui modal" id="add_task_modal">
	<i class="close icon"></i>
	<div class="header">Ajouter une tâche</div>
	<div class="content">
		<form class="ui form" id="add_task_form" method="POST">
			{{ csrf_field() }}
			<input type="hidden" name="_method" value="PUT">
			<div class="field">
				<div class="two fields">
					<div class="field">
						<label>Nom</label>
						<input type="text" name="name" id="name">
					</div>
					<div class="field">
						<label>Priorité</label>
						<select class="ui dropdown" name="priority" id="priority">
							<option value="1">Basse</option>
							<option value="2">Moyenne</option>
							<option value="3">Haute</option>
						</select>
					</div>
				</div>
			</div>
			<div class="field">
				<label>Text</label>
				<textarea name="description" id="description" cols="30" rows="5" ></textarea>
			</div>
		</form>
	</div>
	<div class="actions">
		<button class="ui button teal" type="submit" name="create_task" onclick="$('#add_task_form').submit();">Créer une nouvelle tâche</button>
	</div>
</div>
@foreach( $todo->tasks as $task )
	<div class="ui modal" id="edit_task_{{ $task->id }}">
		<i class="close icon"></i>
		<div class="header">Editer une tâche</div>
		<div class="content">
			<form class="ui form" id="edit_task_{{ $task->id }}_form" method="POST">
				{{ csrf_field() }}
				<input type="hidden" name="task_id" value="{{ $task->id }}"/>
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
					<label>Text</label>
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