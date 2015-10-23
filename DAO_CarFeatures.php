
<?php
	/**
	This DAO exposes a cars features and bridges the relationship between features and cars
	**/
	class DAO_CarFeatures {
		public $CAR_ID;
		public $FEATURE_ID;
		public $FEATURE_NAME;

		function __construct($conn) {
			$this->_conn = $conn;	
		}
		
		public function insert() {
			return true;
		}
		
		public function update() {
			return true;
		}
		
		public function delete() {
			return true;
		}
		
		public function find($where) {
			/**
				Its a bridging table so we cant really use the key-value iterator
			**/
			if(isset($where["CAR_ID"])) {
				$sql = "SELECT c.CAR_ID, f.* FROM FEATURE f, CAR_FEATURE cf, CAR c WHERE";
				$sql.= " c.CAR_ID =".$where["CAR_ID"]." AND ";
				$sql.= "cf.CAR_ID = c.CAR_ID AND f.FEATURE_ID = cf.FEATURE_ID";			
				$parse = oci_parse($this->_conn, $sql);
				oci_execute($parse);
				$numrows = oci_fetch_all($parse, $results, null, null, OCI_FETCHSTATEMENT_BY_ROW);
				if($numrows > 0) {
					include_once('ReadOnlyResultsSet.php');
					return new ReadOnlyResultSet($results);
				} else {
					return false;	
				}
			} else {
				return false;
			}
		}
	}
?>