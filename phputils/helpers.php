<?php
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