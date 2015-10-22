<?php 
session_start(); 
ob_start();
include("phputils/conn.php");
?>
<html>
	<head>
		<meta charset="UTF-8"> <meta http-equiv="X-UA-Compatible" content="IE=edge">
		<!-- mobile optimise the page. Set the width to follow the screen width of the device -->
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Cyrils Classic Cars</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.9/css/jquery.dataTables.min.css">
		<link rel="stylesheet" type="text/css" href="libs/jquery-ui-1.11.4.custom/jquery-ui.min.css">
	</head>
	<style type="text/css">
		.tablebuttons {
			float:right;
			margin: 15px 10px 0px 0px;
			opacity: 0.5;
		}
		.submitButtons {
			padding-top: 10px;
			display:inline-block;
			margin: 0px 0px 0px 10px;
		}
		.edit {
			margin: 10px 10px 10px 0;
		}
		.delete {
			margin: 10px 0 10px 0;
		}
		.selected {
			border: 1px solid purple;
		}
		.clickable {
			opacity: 1;
		}
		.error {
			color: red;
			font-weight: bold;
		}
		h3 {
			display: inline-block;
		}
		.code {
			border-top: 1px solid black;
			width:100%;
		}
		.year-inline {
			display:inline;
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
						<li class="active"><a href="about.php">About</a></li>
						<li class="active"><a href="faq.php">FAQ</a></li>
						<li class="active"><a href="contact.php">Contact</a></li>
						<li class="active"><a href="logout.php">Log-in/Register</a></li>
					</ul>
				</div>
			</div>
		</nav>
		<h1>Home</h1>
		<p>The expectation of this assignment is to develop a web/database application for Cyril
		that will enable his clients to retrieve a list of cars that meet their entered search
		criteria. Clients should be able to search on year range, registration number (or part
		thereof), car make (or part thereof), car model (or part thereof) and one or more car
		features.</p>
		<p>There will be one textbox for each of the search attributes and checkboxes for the
		features. The search will assume an AND for the search criteria and an AND for the
		features. For example find all the cars in year range 1970-1980 AND Ford AND
		Falcon AND air-conditioning AND power steering AND power windows.</p>
		
		 <?php 
			if (isset($_POST["MAKE_NAME"])) {
				include_once("DAO_car.php");
				$dao = new DAO_Car($conn);
				$results = $dao->find($_POST);
				//the results are now available to put in a table
				print_r($results);
			} else {
		?>
		<div class="car-search">
			<form method="post" action="index.php">
		    	<h3>Make: </h3><input type="text" value="" name="MAKE_NAME">
		    	<h3>Model: </h3><input type="text" value="" name="MODEL_NAME">
		    	<h3>Registration: </h3><input type="text" value="" name="CAR_REG">
		    	<h3>Year: </h3>
		    	<div class="year">
					<input type="number" min="1850" max= <?php echo '"'.(date('Y') + 1).'"';?> value="1850" name="YEAR_LOWER">
			    	<span> to </span>
			    	<input type="number" min="1850" max= <?php echo '"'.(date('Y') + 1).'"';?> value= <?php echo '"'.(date('Y') + 1).'"';?> name="YEAR_UPPER">
		    	</div>
		    	<div class="features">
		    		<table id="features" class="display" cellspacing="0" width="100%">
				        <thead>
				            <tr>
				                <th>Feature Name</th>
				            </tr>
				        </thead>
				 
				        <tfoot>
				            <tr>
				                <th>Feature Name</th>
				            </tr>
				        </tfoot>

				        <tbody>
				        	<?php
				        		include_once("DAO_Features.php");
								$features = new DAO_Features($conn);
								$results = $features->find(array());
								print_r($results);
								$counter = 0;
				        		for($i = 0; $i < $results-> rowCount(); $i++) {
				        			$row = $results->getNext($features, $i);			        	
				        	?>
				        	<tr>
				        		<td><?php echo $row->FEATURE_NAME;?></td>
				        	</tr>
				        	<?php
				        		} 
				        	?>
				        </tbody>
					</table>
		    	</div>
		        <div>
		            <input class="btn btn-lg btn-primary" type="submit" value="Submit">
		            <input class="btn btn-lg btn-danger" type="Reset" value="Clear">
		        </div>
		    </form>
		</div>
		    
	    <?php 
			}
		?>
		</div>
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
		<script src="https://cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js"></script>
		<script src="libs/jquery-ui-1.11.4.custom/jquery-ui.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				    $('#features').DataTable();
			});
		</script>


	</body>

</html> 



