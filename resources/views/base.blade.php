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
		@yield('layouts')
		<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
		<script src="http://code.jquery.com/jquery-latest.min.js"></script>
		<script src="{{ mix('js/app.js') }}"></script>
	</body>
</html>