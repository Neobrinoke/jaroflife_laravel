@extends('index')

@section('title', $title)

@section('container')
	<div class="ui attached message">
		<h1 class="header">
			<span><a class="ui left floated basic icon button" href="{{ url()->previous() }}" data-tooltip="Retour en arrière"><i class="arrow left icon"></i></a></span>
			<span>{{ $title }}</span>
			<span><a class="ui right floated basic icon button" onclick="$('#add_collab_modal').modal('show');" data-tooltip="Ajouter un utilisateur"><i class="user add icon"></i></a></span>
		</h1>
	</div>
	<div class="ui attached fluid segment">
		<div class="ui grid">
			<div class="six wide column">
				<h4 class="ui dividing header">Détails</h4>
				<form class="ui form {{ $errors->any() ? 'error' : '' }}" method="POST" action="{{ route('todo.update', [$todo]) }}">
					{!! sendMessages('error', $errors->all(), ['header_message' => 'Erreurs']) !!}
					{{ csrf_field() }}
					<div class="field">
						<label for="name">Nom</label>
						<input type="text" name="name" id="name" value="{{ $todo->name }}">
					</div>
					<div class="field">
						<label for="description">Description</label>
						<textarea name="description" id="description" cols="30" rows="2">{{ $todo->description }}</textarea>
					</div>
					<input class="ui fluid button teal" type="submit" name="edit_todo" value="Modifier les détails de la liste">
				</form>
			</div>
			<div class="ten wide column">
				<h4 class="ui dividing header">Collaborateurs</h4>
				@if( $todo->members->isNotEmpty() )
					<table class="ui celled structured selectable table">
						<thead>
							<tr>
								<th>Nom</th>
								<th>Rejoins le</th>
								<th>Rang</th>
								<th></th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							@foreach( $todo->members as $member )
								<form class="ui form" method="POST" action="{{ route('todo.editCollab', [$todo]) }}">
									{{ csrf_field() }}
									<input type="hidden" name="user_id" value="{{ $member->user->id }}">
									<tr>
										<td>{{ $member->user->name }}</td>
										<td>{{ $member->joined_at }}</td>
										<td class="collapsing">
											<div class="field">
												<div class="ui selection dropdown">
													<input type="hidden" name="authority_id" value="{{ $member->authority_id }}">
													<i class="dropdown icon"></i>
													<div class="default text">Grade du membre</div>
													<div class="menu">
														<div class="item" data-value="1">Administrateur</div>
														<div class="item" data-value="2">Modérateur</div>
														<div class="item" data-value="3">Utlisateur</div>
													</div>
												</div>
											</div>
										</td>
										<td class="collapsing">
											<input class="ui button teal" type="submit" name="edit_member" value="Editer" />
										</td>
										<td class="collapsing">
											<input class="ui button red" type="submit" name="expulse_member" value="Expulser" />
										</td>
									</tr>
								</form>
							@endforeach
						</tbody>
					</table>
				@else
					{!! sendMessage('warning', 'Vous êtes seul dans cette liste') !!}
				@endif
			</div>
		</div>
		<h4 class="ui dividing header">Zone de danger</h4>
		<button class="ui button red" onclick="$('#remove_todo_modal').modal('show');">Supprimer cette liste !</button>
	</div>
	<div class="ui tiny modal" id="remove_todo_modal">
		<i class="close icon"></i>
		<div class="header">Supprimer une liste</div>
		<div class="content">
			<p>Voulez-vous vraiment supprimer cette liste ? L'action est irreversible !</p>
			<p>Toutes les tâches attribué à cette liste, ainsi que tous ses collaborateurs, seront supprimé.</p>
			<form class="ui form" id="remove_todo_form" method="POST" action="{{ route('todo.destroy', [$todo]) }}">
				{{ csrf_field() }}
			</form>
		</div>
		<div class="actions">
			<button class="ui negative left labeled icon button"><i class="close icon"></i>Non</button>
			<button class="ui positive right labeled icon button" onclick="$('#remove_todo_form').submit();">Oui<i class="checkmark icon"></i></button>
		</div>
	</div>
	<div class="ui tiny modal" id="add_collab_modal">
		<i class="close icon"></i>
		<div class="header">Ajouter un collaborateur</div>
		<div class="content">
			<p>Pour ajouter un collaborateur vous pouvez parcourir la liste ci-dessous afin de trouver la personne que vous voulez !</p>
			<form class="ui form" id="add_collab_form" method="POST" action="{{ route('todo.addCollab', [$todo]) }}">
				{{ csrf_field() }}
				<div class="ui fluid multiple search selection dropdown">
					<input type="hidden" name="users">
					<i class="dropdown icon"></i>
					<div class="default text">Utilisateurs</div>
					<div class="menu">
						@foreach( $users as $user )
							<div class="item" data-value="{{ $user->id }}">{{ $user->name }}</div>
						@endforeach
					</div>
				</div>
			</form>
		</div>
		<div class="actions">
			<button class="ui negative left labeled icon button"><i class="close icon"></i>Non</button>
			<button class="ui positive right labeled icon button" onclick="$('#add_collab_form').submit();">Ajouter<i class="add icon"></i></button>
		</div>
	</div>
@endsection
