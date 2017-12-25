@extends('index')

@section('title', $title)

@section('container')
<div class="ui attached message">
	<h1 class="header">
		<span>{{ $title }}</span>
		<span><a class="ui right floated basic icon button" href="#" data-tooltip="Ajouter un utilisateur"><i class="user add icon"></i></a></span>
	</h1>
</div>
<div class="ui attached fluid segment">
	<div class="ui grid">
		<div class="six wide column">
			<h4 class="ui dividing header">Détails</h4>
			@if( $errors->any() )
				{!! sendMessages('error', $errors->all(), ['header_message' => 'Erreurs']) !!}
			@endif
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
									<td class="collapsing"><input class="ui button teal" type="submit" name="edit_member" value="Editer" /></td>
									<td class="collapsing"><input class="ui button red" type="submit" name="expulse_member" value="Expulser" /></td>
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
	<form class="ui form" method="POST">
		{{ csrf_field() }}
		<input name="_method" type="hidden" value="DELETE" />
		<input type="submit" class="ui button red" value="Supprimer cette liste !">
	</form>
</div>
@endsection
