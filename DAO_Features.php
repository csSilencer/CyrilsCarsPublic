
<?php 
	class DAO_Features {
		public $FEATURE_ID;
		public $FEATURE_NAME;

		function __construct($conn) {
			$this->_conn = $conn;	
		}
		
		public function find_feature_by_id($car_no) {
			$sql = 'SELECT * FROM FEATURE WHERE FEATURE_ID='.$car_no;
			$parse = oci_parse($this->_conn, $sql);
			oci_execute($parse);
			
			$result = oci_fetch_assoc($parse);
			
			if($result) {
				$this->FEATURE_ID = $result["FEATURE_ID"];
				$this->FEATURE_NAME = $result["FEATURE_NAME"];
				return true;
			} else {
				return false;
			}
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
			$sql = "SELECT * FROM FEATURE";
			
			$whereClause = array();
			
			foreach($where as $key => $value ) {
				$whereClause[] = $key."='".$value."'";
			}
			
			if(count($whereClause) > 0) {
				$sql.=" WHERE ".implode(' AND', $whereClause);				
			}

			$parse = oci_parse($this->_conn, $sql);
			oci_execute($parse);
			$numrows = oci_fetch_all($parse, $results, null, null, OCI_FETCHSTATEMENT_BY_ROW);
			if($numrows > 0) {
				echo $numrows." <=0";
				include_once('ReadOnlyResultsSet.php');
				return new ReadOnlyResultSet($results);
			} else {
				return false;	
			}
		}
	}
?>