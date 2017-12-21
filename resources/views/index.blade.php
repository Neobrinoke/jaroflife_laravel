<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<title>@yield('title')</title>
		<link rel="stylesheet" href="{{ asset('css/semantic.css') }}">
		<link rel="stylesheet" href="{{ asset('css/style.css') }}">
	</head>
	<body>
		<header class="ui attached stackable menu inverted" style="margin-bottom: 25px;">
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
		<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
		<script src="http://code.jquery.com/jquery-latest.min.js"></script>
		<script src="{{ asset('js/tablesort.js') }}"></script>
		<script src="{{ asset('js/semantic.js') }}"></script>
		<script src="{{ asset('js/script.js') }}"></script>
	</body>
</html>