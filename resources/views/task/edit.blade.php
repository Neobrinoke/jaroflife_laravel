@extends('index')

@section('title', $title)

@section('container')
<div class="ui attached message">
    <h1 class="header">{{ $title }}</h1>
</div>
<div class="ui attached fluid segment">
	<form class="ui form" action="" method="POST">
        {{ csrf_field() }}
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
			<textarea name="description" id="description">{{ $task->description }}</textarea>
		</div>
		<input class="ui fluid submit button teal" type="submit" value="Créer" name="createTask">
	</form>
</div>
@endsection