<?php require_once('../../../Connections/mctarant_assignment_2012.php'); ?>
<?php include("includes/cartSession.incl.php") ?>
<?php 
	if(isset($_SESSION['cartSessionID']) && $_SESSION['orderNumber'] > 0){
		
		$orderDate = date('Y-m-d H:i:s');	
		$orderNumber = $_SESSION['orderNumber'];
		$orderTotal = $_SESSION['orderTotal'];
		
		// update the DB for this order 
		mysql_select_db($database_mctarant_assignment_2012, $mctarant_assignment_2012);
		
		$sql = "UPDATE orders SET 
						orderDate = '$orderDate', 
						orderNumber = '$orderNumber', 
						orderTotal = '$orderTotal' 
						WHERE cartSessionID = '$cartSessionID'"; 
		
		if (@mysql_query($sql)) { 
			header("Location:PPsuccessClear.php"); 
		} 	
	}
?>