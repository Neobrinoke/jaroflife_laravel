<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<title>@yield('title')</title>
		<link rel="stylesheet" href="{{ asset('css/app.css') }}">
	</head>
	<body id="guest">
		<div class="ui middle aligned center aligned grid">
			<div class="column">
				<h2 class="ui teal header">
					<div class="content">@yield('title')</div>
				</h2>
				@yield('container')
			</div>
		</div>
		<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
		<script src="http://code.jquery.com/jquery-latest.min.js"></script>
		<script src="{{ asset('js/tablesort.js') }}"></script>
		<script src="{{ asset('js/semantic.js') }}"></script>
		<script src="{{ asset('js/script.js') }}"></script>
	</body>
</html>