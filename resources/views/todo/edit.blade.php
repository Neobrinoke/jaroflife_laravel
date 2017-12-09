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
	<h4 class="ui dividing header">Détails</h4>
	<form class="ui form" method="POST">
		<div class="field">
			<label>Nom</label>
			<input type="text" name="name" id="name" value="{{ $todo->name }}">
		</div>
		<div class="field">
			<label>Description</label>
			<textarea name="description" id="description" cols="30" rows="2">{{ $todo->description }}</textarea>
		</div>
		<input class="ui fluid submit button teal" type="submit" value="Modifier" name="editTodo">
	</form>
	<h4 class="ui dividing header">Participants</h4>
	@if( sizeof( $todo->members ) > 1 )
		<table class="ui celled selectable table">
			<thead>
				<tr>
					<th>Nom</th>
					<th>Date de rejoins</th>
					<th>Authority level</th>
					<th></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				@foreach( $todo->members as $member )
					<form class="ui form" method="POST">
						<input type="hidden" name="user_id" value="{{ $member->user->id }}">
						<tr>
							<td>{{ $member->user->name }}</td>
							<td>{{ $member->joined_at }}</td>
							<td>
								<div class="field">
									<select name="authority_id">
										<option value="1" {{ $member->authority_id == 1 ? 'selected' : '' }}>Administrateur</option>
										<option value="2" {{ $member->authority_id == 2 ? 'selected' : '' }}>Modérateur</option>
										<option value="3" {{ $member->authority_id == 3 ? 'selected' : '' }}>Utlisateur</option>
									</select>
								</div>
							</td>
							<td class="collapsing"><input class="ui button teal" type="submit" name="edit" value="Editer" /></td>
							<td class="collapsing"><input class="ui button red" type="submit" name="expulse" value="Expulser" /></td>
						</tr>
					</form>
				@endforeach
			</tbody>
		</table>
	@else
		<div class="ui ignored warning message">
			<div class="header">Information</div>
			<p>Vous êtes seul dans cette liste</p>
		</div>
	@endif
	{{ $todo }}
</div>
@endsection
