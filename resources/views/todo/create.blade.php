@extends('index')

@section('title', 'Créer une liste')

@section('container')
<div class="ui attached message">
    <h1 class="header">Créer une liste</h1>
</div>
<div class="ui attached fluid segment">
    <form class="ui form" action="" method="POST">
        {{ csrf_field() }}
        <div class="field">
            <label for="name">Nom</label>
            <input type="text" name="name" id="name" placeholder="Nom de la liste">
        </div>
        <div class="field">
            <label for="description">Description</label>
            <textarea name="description" id="description" cols="30" rows="5" placeholder="Ecrivez votre description ici"></textarea>
        </div>
        <input class="ui fluid submit button teal" type="submit" value="Créer" name="createTodo">
    </form>
</div>
@endsection
