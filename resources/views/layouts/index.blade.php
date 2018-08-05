@extends('base')

@section('layouts')
    <header class="ui attached stackable menu inverted">
        <div class="ui container">
            <a href="{{ route('todo.index') }}" class="ui item"><i class="list icon"></i>Afficher mes listes</a>
            <div class="right menu">
                @auth
                    <div class="ui dropdown icon item">
                        <span><i class="user circle outline icon"></i>{{ Auth::user()->name }}<i class="dropdown icon"></i></span>
                        <div class="menu">
                            <p class="item">Connecté en tant que <strong>{{ Auth::user()->name }}</strong></p>
                            <div class="divider"></div>
                            <a href="#" class="item"><i class="settings icon"></i>Mon compte</a>
                            <div class="divider"></div>
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="item"><i class="sign out icon"></i>Déconnexion</a>
                        </div>
                    </div>
                @endauth
            </div>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
        </div>
    </header>
    <main class="ui container">
        @yield('container')
    </main>
    <footer class="ui inverted vertical footer segment">
        <div class="ui center aligned container">Framework PHP Laravel 5.5 | Framework CSS Semantic-UI</div>
    </footer>
@endsection