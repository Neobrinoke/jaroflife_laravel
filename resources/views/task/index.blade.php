@extends('index')

@section('title', $title)

@section('container')
<div class="ui attached message">
	<h1 class="header">
		<span>{{ $title }}</span>
		<span><a class="ui right floated basic icon button" href="{{ route('task.create', ['todo' => $todo]) }}" data-tooltip="Ajouter une tâche"><i class="add icon"></i></a></span>
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
						<td onclick="location.href='{{ route('task.show', ['todo' => $todo, 'task' => $task]) }}'" style="cursor: pointer;">{{ $task->name }}</td>
						<td onclick="location.href='{{ route('task.show', ['todo' => $todo, 'task' => $task]) }}'" style="cursor: pointer;">{{ $task->description }}</td>
						<td onclick="location.href='{{ route('task.show', ['todo' => $todo, 'task' => $task]) }}'" style="cursor: pointer;">{{ $task->priority }}</td>
						<td onclick="location.href='{{ route('task.show', ['todo' => $todo, 'task' => $task]) }}'" style="cursor: pointer;">{{ $task->user->name }}</td>
						<td onclick="location.href='{{ route('task.show', ['todo' => $todo, 'task' => $task]) }}'" style="cursor: pointer;">{{ $task->created_at }}</td>
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