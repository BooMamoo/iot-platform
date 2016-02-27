<!doctype html>

<html>
	<head>
		<base href="/">

		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="keywords" content="iot platform">
		<meta name="description" content="The project is about creating an IoT platform for connecting many devices into one point which we can easily manage or get the data.">

		<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.96.1/css/materialize.min.css">	 -->
		<!-- <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"> -->
		<link rel="stylesheet" href="css/fonts.css">
		<link rel="stylesheet" href="css/materialize.min.css">
		<link rel="stylesheet" href="css/template.css">

		<script src="js/jquery.min.js"></script>
		<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.96.1/js/materialize.min.js"></script>	 -->
		<script src="js/materialize.min.js"></script> 
		<script src="js/angular.js"></script> 
		<script src="js/angular-route.js"></script> 
		<script src="js/app.js"></script>

		<script src="js/Controller/RegisterController.js"></script>
		<script src="js/Controller/ListController.js"></script>
		<script src="js/Controller/DeviceInfoController.js"></script>
		<script src="js/Controller/DeviceEditController.js"></script>

		<script src="js/Directive/RepeatDirective.js"></script>

		<title> IoT PAS </title>
		<link rel="shortcut icon" href="../picture/icon-web.png" type="image/png">
	</head>

	<body ng-app="app">
		<div class="navbar-fixed">
			<nav>
			    <div class="nav-wrapper">
					<a href="{{ url('/') }}" class="brand-logo space"><img src="../picture/text.png" alt="Text" height="41" width="111.11"></a>

					<ul class="right hide-on-med-and-down space valign-wrapper">
						@if(!Auth::guest())
							<li><a href="{{ url('/device/register') }}"> Registration </a></li>
							<li><a href="{{ url('/device/list') }}"> Device </a></li>
							<li><a class="dropdown-button" href="" data-activates="dropdown1"> {{ Auth::user()->name }} <i class="mdi-navigation-arrow-drop-down right"></i></a></li>
							<ul id="dropdown1" class="dropdown-content">
								<li><a href="{{ url('/auth/logout') }}" target="_self">Logout</a></li>
							</ul>
						@endif
					</ul>

					@if(!Auth::guest())
						<ul id="nav-mobile" class="side-nav pink lighten-4">
							<li><a href="{{ url('/device/register') }}" class="blue-grey-text darken-4-text"> Registration </a></li>
							<li><a href="{{ url('/device/list') }}" class="blue-grey-text darken-4-text"> Device </a></li>	
							<li><a href="{{ url('/auth/logout') }}" class="blue-grey-text darken-4-text" target="_self">Logout</a></li>
						</ul>

						<a href="#" data-activates="nav-mobile" class="button-collapse space right"><i class="material-icons">menu</i></a>
					@endif
				</div>
			</nav>
		</div>


		<div>

			@yield('content')

		</div>

		<footer class="page-footer transparent">	
		    <div class="footer-copyright red lighten-1">
				<div class="space right">
				    By Boo Mamoo :)
				</div>
		    </div>
		</footer>

		<script>
			$(document).ready(function() {
 
 				$('.button-collapse').sideNav({
						edge: 'right'
					}
				);

 				$('select').material_select();
 				$('.modal-trigger').leanModal();

				@yield('script')

			});
		</script>
	</body>

</html>