<!doctype html>

<html>
	<head>
		<base href="/">

		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="keywords" content="iot platform">
		<meta name="description" content="The project is about creating an IoT platform for connecting many devices into one point which we can easily manage or get the data.">

		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.96.1/css/materialize.min.css">	
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<link rel="stylesheet" href="css/template.css">

		<script src="js/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.96.1/js/materialize.min.js"></script>	
		<script src="js/angular.js"></script> 
		<script src="js/angular-route.js"></script> 
		<script src="js/app.js"></script>
		<script src="js/RegisterController.js"></script>

		<title> IoT Platform </title>
	</head>

	<body class="grey lighten-3" ng-app="app">

		<nav>
		    <div class="nav-wrapper white">
				<a href="{{ url('/') }}" class="brand-logo space blue-grey-text darken-4-text"> IoT Platform </a>

				<ul id="nav-mobile" class="right hide-on-med-and-down space">

					@if(!Auth::guest())
						<li><a href="{{ url('/Registration') }}" class="blue-grey-text darken-4-text"> Registration </a></li>
					@endif

					@if (Auth::guest())
						<li><a href="{{ url('/auth/login') }}" target="_self" class="blue-grey-text darken-4-text">Login</a></li>
					@else
						<li><a class="dropdown-button" href="" data-activates="dropdown1" class="blue-grey-text darken-4-text"> {{ Auth::user()->name }} <i class="mdi-navigation-arrow-drop-down right"></i></a></li>
						<ul id="dropdown1" class="dropdown-content">
							<li><a href="{{ url('/auth/logout') }}" target="_self" class="blue-grey-text darken-4-text">Logout</a></li>
						</ul>
					@endif

				</ul>

		    </div>
		</nav>

		<div class="container content">

			@yield('content')

		</div>

		<footer class="page-footer transparent">	
		    <div class="footer-copyright grey lighten-1">
				<div class="space right white-text">
				    Boo Mamoo :)
				</div>
		    </div>
		</footer>

		<script>
			$(document).ready(function() {
 
 				$('select').material_select();
 				
				@yield('script')

			});
		</script>
	</body>

</html>