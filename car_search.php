<?php 
session_start(); 
ob_start();
include("conn.php");

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
	<style>
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
    </style>
	</head>

	<body>
    <?php 
		if (isset($_POST["MAKE_NAME"])) {
			include_once("DAO_car.php");
			$dao = new DAO_Car($conn);
			$results = $dao->find($_POST);
			//the results are now available to put in a table
			print_r($results);
		} else {
	?>
    <form method="post" action="car_search.php">
    	<h3>Make: </h3><input type="text" value="" name="MAKE_NAME">
        <div>
            <input class="btn btn-lg btn-primary" type="submit" value="Submit">
            <input class="btn btn-lg btn-danger" type="Reset" value="Clear">
        </div>
    </form>
    <?php 
		}
	?>
	</body>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
		<script src="https://cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js"></script>
		<script src="libs/jquery-ui-1.11.4.custom/jquery-ui.min.js"></script>
	</body>

</html>