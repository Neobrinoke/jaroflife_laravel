@extends('index')

@section('title', $title)

@section('container')
<div class="ui attached message">
	<h1 class="header">
		<span>{{ $title }}</span>
		<span><a class="ui right floated basic icon button" onclick="$('#add_task_modal').modal('show');" data-tooltip="Ajouter une tâche"><i class="add icon"></i></a></span>
	</h1>
</div>
<div class="ui modal" id="add_task_modal">
	<div class="header">Ajouter une tâche</div>
	<div class="content">
		<form class="ui form" action="" method="POST">
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
			<textarea name="description" id="description" cols="30" rows="2" ></textarea>
		</div>
		<input class="ui fluid submit button teal" type="submit" value="Créer une nouvelle tâche" name="create_task">
		</form>
	</div>
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
						<form class="ui form" method="POST">
							{{ csrf_field() }}
							<input type="hidden" name="task_id" value="{{ $task->id }}">
							<td class="field">
								<input type="text" name="name" id="name" value="{{ $task->name }}">
							</td>
							<td class="field">
								<input type="text" name="description" id="description" value="{{ $task->description }}">
							</td>
							<td class="field">
								<select name="priority" id="priority">
									<option value="1" {{ $task->priority == 1 ? 'selected' : '' }}>Basse</option>
									<option value="2" {{ $task->priority == 2 ? 'selected' : '' }}>Moyenne</option>
									<option value="3" {{ $task->priority == 3 ? 'selected' : '' }}>Haute</option>
								</select>
							</td>
							<td class="collapsing">{{ $task->user->name }}</td>
							<td class="collapsing">{{ $task->created_at }}</td>
							<td class="collapsing">
								<button type="submit" class="ui icon button teal" data-tooltip="Editer la tâche"><i class="edit icon"></i></button>
								<button type="submit" class="ui icon button green" name="edit_task" data-tooltip="Sauvegarder la modification"><i class="save icon"></i></button>
							</td>
						</form>
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
@endsection