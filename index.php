<?php 
session_start(); 
ob_start();
include("phputils/conn.php");

function getMakeByID($id, $conn) {
	$query = "SELECT MAKE_NAME FROM MAKE WHERE MAKE_ID=".$id;
	$stmt = oci_parse($conn, $query);
	if(@oci_execute($stmt)) {
		return oci_fetch_array($stmt);
	} else {
		return "unable to fetch";
	}
}
function getModelByID($id, $conn) {
	$query = "SELECT MODEL_NAME FROM CMODEL WHERE MODEL_ID=".$id;
	$stmt = oci_parse($conn, $query);
	if(@oci_execute($stmt)) {
		return oci_fetch_array($stmt);
	} else {
		return "unable to fetch";
	}
}
function getCarImages($car_id) {
	$directory = 'vehicle_images/'.$car_id;
	if (file_exists($directory)) {
		$scanned_directory = array_diff(scandir($directory), array('..', '.'));
		return $scanned_directory;
	}
	return Array();
}
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
			display: block;
			margin-left: 10px;
		}
		input {
			margin-left: 10px;
		}
		.featureinput {
			margin-left: 10px;
		}
		.features h3 {
			display:inline-block;
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
						<li class="active"><a href="">About</a></li>
						<li class="active"><a href="">FAQ</a></li>
						<li class="active"><a href="">Contact</a></li>
						<li class="active"><a href="">Log-in/Register</a></li>
					</ul>
				</div>
			</div>
		</nav>
		<h1>Home</h1>
		
		 <?php 
			if (sizeof($_POST) > 0) {
				include_once("DAO_car.php");
				$cars = new DAO_Car($conn);
				$results = $cars->find($_POST);
				if($results)
				{
		?>
        		<table id="vehicles" class="display" cellspacing="0" width="100%">
				  	<thead>
				  		<th>Car ID</th>
				  		<th>Make</th>
				  		<th>Model</th>
				  		<th>Registration</th>
				  		<th>Features</th>
				  		<th>Body Type</th>
				  		<th>Transmission</th>
				  		<th>Year</th>
				  		<th>Colour</th>
				  		<th>Thumbnail</th>
				  	</thead>
				  	<tfoot>
				  		<th>Car ID</th>
				  		<th>Make</th>
				  		<th>Model</th>
				  		<th>Registration</th>
				  		<th>Features</th>
				  		<th>Body Type</th>
				  		<th>Transmission</th>
				  		<th>Year</th>
				  		<th>Colour</th>
				  		<th>Thumbnail</th>
				  	</tfoot>
				  	<?php 
						$counter = 0;
						for($i = 0; $i < $results->rowCount(); $i++) {
							$row = $results->getNext($cars, $i);		
				  	?>
				  		<tr>
							<td><?php echo $row->CAR_ID;?></td>
				  			<td><?php echo getMakeByID($row->MAKE_ID, $conn)["MAKE_NAME"];?></td>
				  			<td><?php echo getModelByID($row->MODEL_ID, $conn)["MODEL_NAME"];?></td>
				  			<td><?php echo $row->CAR_REG;?></td>
				  			<td>
				  				<?php
				  					include_once("DAO_CarFeatures.php");
									$carfeatures = new DAO_CarFeatures($conn);
									$cfresults = $carfeatures->find(array("CAR_ID" => $row->CAR_ID));
									if($cfresults) {
										for($j = 0; $j < $cfresults->rowCount(); $j++) {
											$cfrow = $cfresults->getNext($carfeatures, $j);
											echo $cfrow->FEATURE_NAME."<br>";
										}
									} else {
										echo "None";
									}
					  			?>
				  			</td>
				  			<td><?php echo $row->CAR_BODYTYPE;?></td>
				  			<td><?php echo $row->CAR_TRANSMISSION;?></td>
				  			<td><?php echo $row->CAR_YEAR;?></td>
				  			<td><?php echo $row->CAR_COLOUR;?></td>
				  			<td><!-- Car image thumbnail -->
				  				<?php
				  					$images = getCarImages($row->CAR_ID);
				  					if(sizeof($images) > 0) {
				  						$directory = "vehicle_images/".$row->CAR_ID."/".$images[2];
				  					} else {
				  						$directory = '';
				  					}
				  					// echo $directory;
				  					echo '<img src="' . $directory . '" width="300" height="225" alt="Car Image">';
								?>
				  			</td>
				  		</tr>
				  	<?php 
				  	} //end while
				  	?>
			  	</table>
				<div class="submitButtons">
						<a href="index.php" class="btn btn-lg btn-primary">Back</a>
				</div>
		<?php 
			} else { ?>
				<h1>No Results</h1>
				<div class="submitButtons">
						<a href="index.php" class="btn btn-lg btn-primary">Back</a>
				</div>
				<?php			
			} 
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
                	<h3>Features: </h3>
                 
                    <a class='addfeaturefield' href="javascript:void(0);" onClick="addFeatureField();">
                        <img src="assets/glyphicons_free/glyphicons/png/glyphicons-191-circle-plus.png">
                    </a>
                    <div class="featureinput">
                        <select name="feature_name_1">
                            <option value="-1">Select A Feature</option>
                            <?php
				        		include_once("DAO_Features.php");
								$features = new DAO_Features($conn);
								$results = $features->find(array());
								$counter = 0;
				        		for($i = 0; $i < $results-> rowCount(); $i++) {
				        			$row = $results->getNext($features, $i);			        	
				        	?>
				        		<option value = <?php echo $row->FEATURE_ID;?>><?php echo $row->FEATURE_NAME;?></option>
				        	<?php
				        		} 
				        	?>
                        </select>
                        <a href="javascript:void(0);" onClick="removeFeatureField(this)">
                            <img src="assets/glyphicons_free/glyphicons/png/glyphicons-193-circle-remove.png">
                        </a>
                    </div>
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
				    $('#vehicles').DataTable();
			});
			function addFeatureField (field) {
				/**
					Deprecated as the spec doesnt specify features on the vehicle page
				**/
				var lastfeature = $('.featureinput').last();
				var countfeature = ($('.featureinput').length)+1;

			    if(lastfeature.length == 0) {
			    	lastfeature = field;
			    }

			    featureField = $('.featureinput').first();
			    if(featureField.length == 0) {
			    	featureField = $(".addfeaturefield").data();
			    	$(featureField.outerHTML).insertAfter($('.addfeaturefield'));
			    } else {
		    		featureField.clone().insertAfter(lastfeature);
			    }
			    lastfeature = $('.featureinput select').last();
			    //var newName = lastfeature.attr("name");
			    //lastfeature.attr("name", "feature_name_"+countfeature);
				stabiliseFieldNumber();
			}
			function removeFeatureField (field) {
				/**
					Deprecated as the spec doesnt specify features on the vehicle page
				**/
				var countfeature = ($('.featureinput').length);
				if(countfeature == 1) {//we need to save the feature field to save the features or not have to load them again
					$(".addfeaturefield").data(field.closest('.featureinput'));
				}
				field.closest('.featureinput').remove();
				stabiliseFieldNumber();
			}
			function stabiliseFieldNumber() {
				var i = 0;
				$('.featureinput select').each( function( index, element ){
					$( this ).attr('name', 'feature_name_'+i);
					i+=1;
				});
			}
		</script>


	</body>

</html> 



