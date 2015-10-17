
<?php 
	class ReadOnlyResultSet {
		private $_results;
		
		function __construct($results) {
			$this->_results = $results;	
		}
		
		function getNext($dataObject, $counter) {
			$row = $this->_results[$counter];
			
			foreach($row as $name=>$value) {
				$dataObject->$name=$value;
			}
			
			return $dataObject;
		}
		
		function reset() {
			reset($this->_results);
		}
		
		function rowCount() {
			$nrows = sizeof($this->_results);
			return $nrows;	
		}
	}
?>