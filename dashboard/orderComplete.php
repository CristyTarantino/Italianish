<?php require_once('../../../Connections/mctarant_assignment_2012.php'); ?>
<?php include("../includes/authorisation.incl.php") ?>
<?php if(isset($_GET['orderID'])){
		$orderID = $_GET['orderID'];
	   }
?>
<?php 
	// get cartSessionID and customerID for this order from the DB
	mysql_select_db($database_mctarant_assignment_2012, $mctarant_assignment_2012);
	
	$query_rsOrder = "SELECT * FROM orders
						WHERE orderNumber = '$orderID'";
	$rsOrder = mysql_query($query_rsOrder, $mctarant_assignment_2012) or die("An error has occurred. Please contact the webmaster. Thank you.");
	$row_rsOrder = mysql_fetch_assoc($rsOrder);
	$cartSessionID = $row_rsOrder['cartSessionID'];
	$customerID = $row_rsOrder['customerID'];
?>
<?php 
	// get items with this cartSessionID from the DB
	mysql_select_db($database_mctarant_assignment_2012, $mctarant_assignment_2012);
	$query_rsCart = "SELECT * FROM cartItems, recipes, administration
						WHERE cartItems.cartSessionID = '$cartSessionID'
						AND boxQty > 0
						AND recipes.recipeID = cartItems.recipeID";
	$rsCart = mysql_query($query_rsCart, $mctarant_assignment_2012) or die("An error has occurred. Please contact the webmaster. Thank you.");
	$row_rsCart = mysql_fetch_assoc($rsCart);
	$totalRows_rsCart = mysql_num_rows($rsCart);
?>
<?php 
	// get customer details for this order from the DB
	mysql_select_db($database_mctarant_assignment_2012, $mctarant_assignment_2012);
	$query_rsCustomer = "SELECT * FROM customers
							WHERE customerID = '$customerID'";
	$rsCustomer = mysql_query($query_rsCustomer, $mctarant_assignment_2012) or die("An error has occurred. Please contact the webmaster. Thank you.");
	$row_rsCustomer = mysql_fetch_assoc($rsCustomer);
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="style/dashboard.css">
<title>Order Complete</title>
</head>

<body>
<div id="container">
  <div class="dbdReport">
    <h1>Order Completed and Despatched</h1>
    <p id="logout"><small><a href="../login/logout.php">Logout</a></small></p>
    <h2>Order: <?php echo $orderID ?></h2>
    <?php 
	$qtyItems = 0; 			//to keep track of how many items are in the bag
	$itemsCount = 0;		//to keep track of what is the current item coming from the database
	$basketSubTotal = 0;	//to keep track of the running total of the itames in the bag (with the delivery charge)
	$basketTotal = 0;		//to contain the value of the total sale with delivery
	$itemGiftTotal = 0;
	$itemTotal = 0;
?>
    <?php do { ?>
      <?php
	$deliveryRate = $row_rsCart['deliveryRate'];
	$vatRate = $row_rsCart['vatRate'];
	//if it has been chosen printedRecipe then multiply the number of items selected for this product by the cot of the Recipe Printed Version - Special Editionping service 
	if($row_rsCart['printedRecipe'] == 'Y') {
		$itemGiftTotal = ($row_rsCart['recipeRate'] * $row_rsCart['boxQty']);
	} else {		
		$itemGiftTotal = 0;
	}
			
	$itemTotal = ($row_rsCart['recipePrice']) * ($row_rsCart['boxQty']);
		
	$basketSubTotal = $basketSubTotal + $itemTotal + $itemGiftTotal;		
?>
      <div class="itemRow">
        <div class="productTitle"><?php echo $row_rsCart['productTitle']; ?></div>
        <div class="totalPrice">&pound;<?php echo number_format($itemTotal, 2, '.', ','); ?></div>
        <div class="qty"><?php echo $row_rsCart['boxQty']; ?></div>
        <div class="itemPrice">&pound;<?php echo number_format($row_rsCart['recipePrice'], 2, '.', ','); ?></div>
        <div class="productDescr"><?php echo $row_rsCart['productDescription']; ?></div>
        <?php
		  		if($row_rsCart['printedRecipe'] == 'Y'){
					echo ' 
					  <div class="serviceDescr">Recipe Printed Version - Special Edition
						<div class="serviceTotal">&pound;'.number_format($itemGiftTotal, 2, '.',',').'</div>
						<div class="serviceQty">'.$row_rsCart['boxQty'].'</div>
						<div class="servicePrice">&pound;'.number_format($row_rsCart['recipeRate'], 2, '.',',').'</div>
					  </div>';
				}    
		  ?>
        <?php
	$itemsCount++; 											//increment the counter $itemsCount
	$qtyItems = $qtyItems + $row_rsCart['boxQty'];		//increase the $qtyItems by the quantity of the item currently being displayed
?>
      </div>
      <?php } while($row_rsCart = mysql_fetch_assoc($rsCart)); ?>
    <div id="endItems">&nbsp;</div>
    
    <div class="botmLineRow">
      <div class="totalPrice">&pound;<?php echo number_format($basketSubTotal, 2, '.', ','); ?></div>
      <div class="itemTitle">Item(s) Subtotal:</div>
    </div>
    <div class="botmLineRow">
      <div class="totalPrice">&pound;<?php echo number_format($deliveryRate, 2, '.', ','); ?></div>
      <div class="itemTitle">Delvery and Insurance:</div>
    </div>
    <?php
        	$basketTotal = $basketSubTotal + $deliveryRate;
			$VAT = $basketTotal - ($basketTotal/((100 + $vatRate) / 100));
		?>
    <div class="botmLineRow">
        <div class="totalPrice" id="total">&pound;<?php echo number_format($basketTotal, 2, '.', ','); ?></div>
        <!-- to check discrepancies between the order total and the amount paid -->
        <?php 
			if($row_rsOrder['orderTotal'] != $basketTotal) { ?>
				<div class="botmLineRow">
					<div class="totalPrice" id="total">&pound;<?php echo number_format($row_rsOrder['orderTotal'], 2, '.', ','); ?></div>
					<div class="itemTitle">Payment received:</div>
				</div>
		<?php }?>
        <div class="itemTitle">Total for this order:</div>
    </div>
    
    <div class="address">
          <strong>Deliver to:</strong><br>
          <div class="addressLine">
          <?php echo $row_rsOrder['shippingFirstName'] . "&nbsp;" . $row_rsOrder['shippingLastName']; ?><br>
          <?php echo $row_rsOrder['shippingAddress1']; ?><br>
          <?php if (strlen($row_rsOrder['shippingAddress2']) !== 0) { 
				echo $row_rsOrder['shippingAddress2'].'<br>'; 
		  } ?>
          <?php echo $row_rsOrder['shippingCity']; ?><br>
          <?php echo $row_rsOrder['shippingCounty']; ?><br>
          <?php echo $row_rsOrder['shippingPostCode']; ?><br>
          <?php echo $row_rsOrder['shippingPhone']; ?>
          </div>
        </div>
    <form action="" method="post">
      <input class="button" id="print" type="button" onclick="window.print()" value="Print Order">
    </form>
  </div>
  <p id="return"><a href="dbdIndex.php">Return to the dashboard</a></p>
  <!-- end of container--></div>
<p>&nbsp;</p>
</body>
</html>