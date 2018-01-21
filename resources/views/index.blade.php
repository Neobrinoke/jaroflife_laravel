<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<title>@yield('title')</title>
		<link rel="stylesheet" href="{{ mix('css/app.css') }}">
	</head>
	<body>
		<header class="ui attached stackable menu inverted">
			<div class="ui container">
				<a href="{{ route('todo.index') }}" class="ui item"><i class="list icon"></i>Afficher mes listes</a>
				<div class="right menu">
					<div class="ui dropdown icon item">
						<span><i class="user circle outline icon"></i>{{ Auth::user()->name }}<i class="dropdown icon"></i></span>
						<div class="menu">
							<p class="item">Connecté en tant que <strong>{{ Auth::user()->name }}</strong></p>
							<div class="divider"></div>
							<a href="/user/account/" class="item"><i class="settings icon"></i>Mon compte</a>
							<div class="divider"></div>
							<a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="item"><i class="sign out icon"></i>Déconnexion</a>
						</div>
					</div>
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
		<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
		<script src="http://code.jquery.com/jquery-latest.min.js"></script>
		<script src="{{ mix('js/app.js') }}"></script>
	</body>
</html>