@extends('index')

@section('title', $title)

@section('container')
<div class="ui attached message">
    <h1 class="header">
		<span>{{ $title }}</span>
		<span><a class="ui right floated basic icon button" href="{{ route('task.edit', ['todo' => $todo, 'task' => $task]) }}" data-tooltip="Modifier une tâche"><i class="edit icon"></i></a></span>
	</h1>
</div>
<div class="ui attached fluid segment">
	<div class="ui items">
		<div class="item">
			<div class="description">
				<p>{{ $task->description }}</p>
			</div>
		</div>
	</div>
</div>
@endsection