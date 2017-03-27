<?php
class DB {
	public function getName($table, $id, $return, $idColumn){
		
	    $query = "SELECT $return FROM $table WHERE $idColumn = '" . $id . "'";
	  $result = mysqli_query($conn, $query);
	$count = mysqli_num_rows($result);
	  if($count >= 1){
		  while($row = mysqli_fetch_assoc($result)) {
		foreach ( $row as $key => $value){
			return $value;
		}
    }
	}else{
		  return 0;
	  }
}
}
?>