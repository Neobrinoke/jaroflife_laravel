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
	<div class="ui grid">
		<div class="six wide column">
			<h4 class="ui dividing header">Détails</h4>
			<form class="ui form" method="POST">
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
							<form class="ui form" method="POST">
								{{ csrf_field() }}
								<input type="hidden" name="user_id" value="{{ $member->user->id }}">
								<tr>
									<td>{{ $member->user->name }}</td>
									<td>{{ $member->joined_at }}</td>
									<td class="collapsing">
										<div class="field">
											<!-- <select class="ui dropdown" name="authority_id"> -->
											<select name="authority_id">
												<option value="1" {{ $member->authority_id == 1 ? 'selected' : '' }}>Administrateur</option>
												<option value="2" {{ $member->authority_id == 2 ? 'selected' : '' }}>Modérateur</option>
												<option value="3" {{ $member->authority_id == 3 ? 'selected' : '' }}>Utlisateur</option>
											</select>
										</div>
									</td>
									<td class="collapsing"><input class="ui button teal" type="submit" name="edit_member" value="Editer" /></td>
									<td class="collapsing"><input class="ui button red" type="submit" name="expulse_member" value="Expulser" /></td>
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
		</div>
	</div>
	<h4 class="ui dividing header">Zone de danger</h4>
	<!-- <a class="ui button red" onclick="onConfirmNotif('Voulez-vous vraiment supprimer cette liste ?\nToutes les tâches correspondante serons aussi supprimer\nL\'action est irresversible', '/list/delete/<?= $todo->id ?>/')">Supprimer cette liste !</a> -->
	<form class="ui form" method="POST">
		{{ csrf_field() }}
		<input name="_method" type="hidden" value="DELETE" />
		<input type="submit" class="ui button red" value="Supprimer cette liste !">
	</form>
</div>
@endsection
