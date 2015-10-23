
<?php 
	class DAO_Car {
		public $CAR_ID;
		public $MAKE_ID;
		public $MODEL_ID;
		public $CAR_REG;
		public $CAR_BODYTYPE;
		public $CAR_TRANSMISSION;
		public $CAR_ODOMETER;
		public $CAR_YEAR;
		public $CAR_COLOUR;
		public $CAR_DOORS;
		public $CAR_SEATS;
		public $CAR_CYLINDERS;
		public $CAR_ENGINESIZE;
		public $CAR_FUELTYPE;
		public $CAR_FEATURE_ID;
		public $CAR_IMGDIR;
		/**
		CAR_ID NUMBER(7) NOT NULL,
		MAKE_ID NUMBER(7) NOT NULL,
		MODEL_ID NUMBER(7) NOT NULL,
		CAR_REG VARCHAR2(6) NOT NULL,
		CAR_BODYTYPE VARCHAR2(10) NOT NULL,
		CAR_TRANSMISSION VARCHAR2(10) NOT NULL,
		CAR_ODOMETER NUMBER(6) NOT NULL,
		CAR_YEAR NUMBER(4) NOT NULL,
		CAR_COLOUR VARCHAR2(20) NOT NULL,
		CAR_DOORS NUMBER(1) NOT NULL,
		CAR_SEATS NUMBER(1) NOT NULL,
		CAR_CYLINDERS NUMBER(2) NOT NULL,
		CAR_ENGINESIZE NUMBER(2) NOT NULL,
		CAR_FUELTYPE VARCHAR2(12) NOT NULL,
		CAR_DRIVETYPE VARCHAR2(30) NOT NULL,
		CAR_FEATURE_ID NUMBER(7),
		CAR_IMGDIR VARCHAR(50),
		CONSTRAINT CAR_PK PRIMARY KEY (CAR_ID)
		**/
		function __construct($conn) {
			$this->_conn = $conn;	
		}
		
		public function find_car_by_id($car_no) {
			$sql = 'SELECT * FROM CAR WHERE CAR_ID='.$car_no;
			$parse = oci_parse($this->_conn, $sql);
			oci_execute($parse);
			
			$result = oci_fetch_assoc($parse);
			
			if($result) {
				$this->CAR_MAKE_ID = $result["MAKE_ID"];
				$this->CAR_MODEL_ID = $result["MODEL_ID"];
				$this->CAR_REG = $result["CAR_REG"];
				$this->CAR_BODYTYPE = $result["CAR_BODYTYPE"];
				$this->CAR_TRANSMISSION = $result["CAR_TRANSMISSION"];
				$this->CAR_ODOMETER = $result["CAR_ODOMETER"];
				$this->CAR_YEAR = $result["CAR_YEAR"];
				$this->CAR_COLOUR = $result["CAR_COLOUR"];
				$this->CAR_DOORS = $result["CAR_DOORS"];
				$this->CAR_SEATS = $result["CAR_SEATS"];
				$this->CAR_CYLINDERS = $result["CAR_CYLINDERS"];
				$this->CAR_ENGINESIZE = $result["CAR_ENGINESIZE"];
				$this->CAR_FUELTYPE = $result["CAR_FUELTYPE"];
				$this->CAR_DRIVETYPE = $result["CAR_DRIVETYPE"];
				$this->CAR_FEATURE_ID = $result["CAR_FEATURE_ID"];
				$this->CAR_IMGDIR = $result["CAR_IMGDIR"];
				return true;
			} else {
				return false;
			}
		}
		
		public function insert() {
			/**
			$sql = "INSERT INTO CAR VALUES(SEQ_CAR_ID.nextval,'".
			$this->CAR_REG ."','".
			$this->CAR_MAKE_ID ."','".
			$this->CAR_MODEL_ID .",'".
			$this->CAR_REG ."','".
			$this->CAR_BODYTYPE ."','".
			$this->CAR_TRANSMISSION ."','".
			$this->CAR_ODOMETER ."','".
			$this->CAR_YEAR ."','".
			$this->CAR_COLOUR ."','".
			$this->CAR_DOORS ."','".
			$this->CAR_SEATS ."','".
			$this->CAR_CYLINDERS ."','".
			$this->CAR_ENGINESIZE ."','".
			$this->CAR_FUELTYPE ."','".
			$this->CAR_DRIVETYPE ."')";
			
			$parse = oci_parse($this->_conn, $sql);
			oci_execute($parse);
			
			$sql = "SELECT SEQ_CAR_ID.CURRVAL as seqVal from DUAL";
			$parse = oci_parse($this->_conn,$sql);
			
			oci_execute($parse);
			$result = oci_fetch_assoc($parse);
			$this->CAR_ID = $result["SEQVAL"];
			**/
			return true;
		}
		
		public function update() {
			return true;
		}
		
		public function delete() {
			return true;
		}
		
		public function getMakeIdByName($name) {
			$query = "SELECT MAKE_ID FROM MAKE WHERE MAKE_NAME='".$name."'";
			$stmt = oci_parse($this->_conn, $query);
			if(@oci_execute($stmt)) {
				return oci_fetch_array($stmt)["MAKE_ID"];
			} else {
				return "unable to fetch";
			}
		}
		public function getModelIDByName($name) {
			$query = "SELECT MODEL_ID FROM CMODEL WHERE MODEL_NAME='".$name."'";
			$stmt = oci_parse($this->_conn, $query);
			if(@oci_execute($stmt)) {
				return oci_fetch_array($stmt)["MODEL_ID"];
			} else {
				return "unable to fetch";
			}
		}
		
		public function find($where) {
			$sql = "SELECT * FROM CAR";
			
			$whereClause = array();
			
			foreach($where as $key => $value ) {
				if(!empty($value)) {
					switch($key) {
						case "MAKE_NAME":
							$whereClause[] = "MAKE_ID"." IN (SELECT MAKE_ID FROM MAKE WHERE MAKE_NAME LIKE '%".strtoupper($value)."%')";
							break;
						case "MODEL_NAME":
							$whereClause[] = "MODEL_ID"." IN (SELECT MODEL_ID FROM CMODEL WHERE MODEL_NAME LIKE '%".strtoupper($value)."%')";
							break;
						case "CAR_REG":
							$whereClause[] = "CAR_REG LIKE '%".strtoupper($value)."%'";
							break;
						case "YEAR_LOWER":
							$whereClause[] = "CAR_YEAR >= ".$value;
							break;
						case "YEAR_UPPER":
							$whereClause[] = "CAR_YEAR <= ".$value;
							break;
						default:
							//this case is reached by Features only
							//dont count the first selection
							if($value !== "-1") {
								$whereClause[] = "CAR_ID IN (SELECT CAR_ID FROM CAR_FEATURE WHERE FEATURE_ID=".$value.")";
							}
							break;
					}	
				}
			}
			
			if(count($whereClause) > 0) {
				$sql.=" WHERE ".implode(' AND ', $whereClause);				
			}
			$parse = oci_parse($this->_conn, $sql);
			oci_execute($parse);
			
			$numrows = oci_fetch_all($parse, $results, null, null, OCI_FETCHSTATEMENT_BY_ROW);
			if($numrows > 0) {
				include_once('ReadOnlyResultsSet.php');
				return new ReadOnlyResultSet($results);
			} else {
				return false;	
			}
		}
	}
?>