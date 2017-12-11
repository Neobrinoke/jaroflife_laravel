@extends('index')

@section('title', $title)

@section('container')
<div class="ui attached message">
	<h1 class="header">
		<span>{{ $title }}</span>
		<span><a class="ui right floated basic icon button" href="{{ route('task.create', ['todoId' => $todo->id]) }}" data-tooltip="Ajouter une tâche"><i class="add icon"></i></a></span>
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
				</tr>
			</thead>
			<tbody>
				@foreach( $todo->tasks as $task )
					<tr>
						<td onclick="location.href='/task/read/{{ $todo->id }}/{{ $task->id }}/'" style="cursor: pointer;">{{ $task->name }}</td>
						<td onclick="location.href='/task/read/{{ $todo->id }}/{{ $task->id }}/'" style="cursor: pointer;">{{ $task->description }}</td>
						<td onclick="location.href='/task/read/{{ $todo->id }}/{{ $task->id }}/'" style="cursor: pointer;">{{ $task->priority }}</td>
						<td onclick="location.href='/task/read/{{ $todo->id }}/{{ $task->id }}/'" style="cursor: pointer;">{{ $task->user->name }}</td>
						<td onclick="location.href='/task/read/{{ $todo->id }}/{{ $task->id }}/'" style="cursor: pointer;">{{ $task->created_at }}</td>
						<td class="collapsing"><a class="ui icon button red" onclick="onConfirmNotif('Voulez-vous vraiment supprimer cette tâche ?', '/task/delete/{{ $todo->id }}/{{ $task->id }}/')" data-tooltip="Supprimer la tâche"><i class="trash icon"></i></a></td>
					</tr>
				@endforeach
			</tbody>
		</table>
	@else
		{!! sendMessage('warning', 'Aucune tâche disponible') !!}
	@endif
</div>
@endsection