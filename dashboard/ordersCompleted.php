<?php require_once('../../../Connections/mctarant_assignment_2012.php'); ?>
<?php include("../includes/authorisation.incl.php") ?>
<?php 
	// get all the orders pending along with customer details
	mysql_select_db($database_mctarant_assignment_2012, $mctarant_assignment_2012); 
	
	$query_rsOrders = "SELECT *, DATE_FORMAT(orderDate, '%e/%c/%y') AS 'orderDate' 
						FROM orders, customers 
						WHERE orderStatus = 'complete' 
						AND orderNumber > 0 
						AND orders.customerID = customers.customerID 
						ORDER BY orderNumber ASC"; 
	$rsOrders = mysql_query($query_rsOrders, $mctarant_assignment_2012) or die("An error has occurred. Please contact the webmaster. Thank you."); 
	$row_rsOrders = mysql_fetch_assoc($rsOrders); 
	$totalRows_rsOrders = mysql_num_rows($rsOrders); 
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="style/dashboard.css">
<title>Orders Completed</title>
</head>

<body>
<div id="container">
        <div class="dbdReport">
        <h1>Orders Completed</h1>
        <p id="logout"><small><a href="../login/logout.php">Logout</a></small></p>
        <p>This report shows orders completed. Click on order number to view details.</p>
 <?php if($totalRows_rsOrders <= 0) { ?> 
		<blockquote>There are no orders in this category</blockquote> 
		<?php } else do { ?>
        <div class="orderItem"> 
        <span class="orderNumber">
        <a href="orderComplete.php?orderID=<?php echo $row_rsOrders['orderNumber']; ?>"> 
        	Order: <?php echo $row_rsOrders['orderNumber']; ?></a></span> 
        <span class="orderDate"><?php echo $row_rsOrders['orderDate']; ?> </span> 
        <span class="orderCustomer"><?php echo $row_rsOrders['customerFirstName'].' ' 
										        .$row_rsOrders['customerLastName'].', ' 
												.$row_rsOrders['customerAddress1'].', ' 
												.$row_rsOrders['customerCity'].', ' 
												.$row_rsOrders['customerPostCode'] ?></span> 
        <span class="orderValue">£<?php echo $row_rsOrders['orderTotal'] ?></span> 
        </div>
        <?php } while($row_rsOrders = mysql_fetch_assoc($rsOrders)); ?>
        </div>
		<p><a href="dbdIndex.php">Return to the dashboard</a></p>
    <!-- end of container--></div>
<p>&nbsp;</p>
</body>
</html>