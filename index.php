<?php 
session_start(); 
ob_start();
include("phputils/logincheck.php");
?>
<html>
	<head>
		<meta charset="UTF-8"> <meta http-equiv="X-UA-Compatible" content="IE=edge">
		<!-- mobile optimise the page. Set the width to follow the screen width of the device -->
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Cyrils Classic Cars</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	</head>
	<style type="text/css">
		.buttons {
			width: 100%;
			height: 100%;
		}
		.buttons a {
			display: block;

			margin:auto;
		}
	</style>

	<body>
		<nav class="jumbotron navbar navbar-default">
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle"
					data-toggle="collapse" data-target="#myNavbar">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="#">Cyril's Classic Cars</a>
				</div>
				<div class="collapse navbar-collapse" id="myNavbar">
					<ul class="nav navbar-nav">
						<li class="active"><a href="index.php">Home</a></li>
						<li class="active"><a href="vehicles.php">Vehicles</a></li>
						<li class="active"><a href="clients.php">Clients</a></li>
						<li class="active"><a href="makes.php">Makes</a></li>
						<li class="active"><a href="models.php">Models</a></li>
						<li class="active"><a href="features.php">Features</a></li>
						<li class="active"><a href="images.php">Images</a></li>
						<li class="active"><a href="logout.php">Log-out</a></li>
					</ul>
				</div>
			</div>
		</nav>
		<h1>Home</h1>
		<div class="buttons">
			<a class="btn btn-lg btn-primary" href="vehicles.php"><h2>View/Update/Edit/Delete Vehicles</h2></a>
			<a class="btn btn-lg btn-primary" href="clients.php"><h2>View/Update/Edit/Delete Clients</h2></a>
			<a class="btn btn-lg btn-primary" href="makes.php"><h2>View/Update/Edit/Delete Makes</h2></a>
			<a class="btn btn-lg btn-primary" href="models.php"><h2>View/Update/Edit/Delete Models</h2></a>
			<a class="btn btn-lg btn-primary" href="features.php"><h2>View/Update/Edit/Delete Features</h2></a>
			<a class="btn btn-lg btn-primary" href="images.php"><h2>Manage Vehicle Images</h2></a>
			<a class="btn btn-lg btn-primary" href="documentation.php"><h2>View Documentation</h2></a>
		</div>
		</div>
		
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

	</body>

</html> 



