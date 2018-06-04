<?php require_once('../../../Connections/mctarant_assignment_2012.php'); ?>
<?php include("includes/cartSession.incl.php"); ?>
<?php include("includes/errorMessage.incl.php"); ?>
<?php if( isset($_POST['checkout'])){ 
		header('Location:register.php'); 
} ?>
<?php if( isset($_POST['continue'])){ 
		header('Location:index.php');
} ?>
<?php if (isset($_POST['update'])) { 
			
			if (is_numeric($_POST['totalRows_rsCart']) && $_POST['totalRows_rsCart'] > 0) { 
				
				$rows = $_POST['totalRows_rsCart']; 
				$counter = 0; 
				
				while($counter < $rows) { 
					$boxQty = $_POST['qty'.$counter]; 
					$cartItemID = $_POST['cartItemID'.$counter]; 
					
						if (is_numeric($boxQty) && $boxQty >= 0 
							&& is_numeric($cartItemID) && $cartItemID > 0) { 
														
							mysql_select_db($database_mctarant_assignment_2012, $mctarant_assignment_2012);
							
							$sql = "UPDATE cartItems SET 
								boxQty = '$boxQty' 
								WHERE cartItemID = '$cartItemID' 
								AND cartSessionID = '$cartSessionID'"; 
							
							
							if (!@mysql_query($sql)) { 
								$error = $errorMessage; 
							} 
							} else { 
								$error = $errorMessage; 
							}							
							$counter++; 
						}
							} else { 
								$error = $errorMessage;
							}			
			header('Location:basket.php'); 
		} 
?>
<?php include("includes/headerCheckout.incl.php") ?>
<?php
	
	mysql_select_db($database_mctarant_assignment_2012, $mctarant_assignment_2012);
	
	$query_rsCart = "SELECT * FROM cartItems, recipes, thumbs, administration
						WHERE cartItems.cartSessionID = '$cartSessionID'
						AND boxQty > 0
						AND recipes.recipeID = cartItems.recipeID
						AND thumbs.thumbID = recipes.thumbID";
							
	
 	$rsCart = mysql_query($query_rsCart, $mctarant_assignment_2012) or die("An error has occurred. Please contact the webmaster. Thank you.");
	
	$row_rsCart = mysql_fetch_assoc($rsCart);
	
	//returns the number of rows of data returned in the query
	$totalRows_rsCart = mysql_num_rows($rsCart);
?>
		<article id="fullsize">
			<div class="heading">
				<h1>My Shopping Bag</h1>
			</div>
			<div class="content">
            	<div>
				<div id="progress"> &nbsp; </div>
    <div class="topBar"> Items in your Shopping Bag - ready to buy now
      <div class="totalPrice">Total</div>
      <div class="qty">Qty</div>
      <div class="itemPrice">Item price</div>
    </div>
 <?php 
	$qtyItems = 0; 			//to keep track of how many items are in the bag
	$itemsCount = 0;		//to keep track of what is the current item coming from the database
	$basketSubTotal = 0;	//to keep track of the running total of the itames in the bag (with the delivery charge)
	$VAT = 0;				//to contain the value that is the calculation of the VAT paid on the total price of the shopping bag (including deliver)
	$basketTotal = 0;		//to contain the value of the total sale with delivery
	$itemPrintTotal = 0;
	$itemTotal = 0;
?>
    <form action="" method="post">
      <?php do { ?>
        <?php
	$deliveryRate = $row_rsCart['deliveryRate'];
	$vatRate = $row_rsCart['vatRate'];
	//if it has been chosen printedRecipe then multiply the number of items selected for this product by the cot of the gift wrapping service 
	if($row_rsCart['printedRecipe'] == 'Y') {
		$itemPrintTotal = ($row_rsCart['recipeRate'] * $row_rsCart['boxQty']);
	} else {		
		$itemPrintTotal = 0;
	}
			
	$itemTotal = ($row_rsCart['recipePrice']) * ($row_rsCart['boxQty']);
		
	$basketSubTotal = $basketSubTotal + $itemTotal + $itemPrintTotal;		
?>
        <div class="itemRow">
          <div class="recipetImage"> <img src="images/thumbs/<?php echo $row_rsCart['thumbFile']; ?>" width="138" height="105"> </div>
          <div class="recipeTitle"><?php echo $row_rsCart['recipeTitle']; ?></div>
          <div class="totalPrice">&pound;<?php echo number_format($itemTotal, 2, '.', ','); ?></div>
          <div class="qty">
            <input name="cartItemID<?php echo $itemsCount; ?>" type="hidden" value="<?php echo $row_rsCart['cartItemID']; ?>">
            <input name="qty<?php echo $itemsCount; ?>" class="qty" type="number" value="<?php echo $row_rsCart['boxQty']; ?>" maxlength="2">
          </div>
          <div class="itemPrice">&pound;<?php echo number_format($row_rsCart['recipePrice'], 2, '.', ','); ?></div>
          <?php
		  		if($row_rsCart['printedRecipe'] == 'Y'){
					echo ' 
					  <div class="serviceDescr">Recipe Printed Version - Special Edition
						<div class="serviceTotal">&pound;'.number_format($itemPrintTotal, 2, '.',',').'</div>
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
      <p class="errorMessages"><?php echo $error; ?></p>
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
        <div class="itemTitle">Total for this order:</div>
      </div>
      <div class="VAT">
        <div class="totalPrice">&pound;<?php echo number_format($VAT, 2, '.', ','); ?></div>
        <div class="itemTitle">Includes VAT @
          <?php 
				if($vatRate - floor($vatRate) > 0)
					echo number_format($vatRate,1).'%;';
				elseif ($vatRate - floor($vatRate) <= 0)
					echo number_format($vatRate,0).'%;';
			?>
        </div>
      </div>
      <div id="buttonBlock">
      <input name="totalRows_rsCart" type="hidden" value="<?php echo $totalRows_rsCart; ?>">
      <input class="button" id="checkout" name="checkout" type="submit" value="Checkout">
      <input class="button" id="update" name="update" type="submit" value="Update Qty">
      <input class="button" id="continue" name="continue" type="submit" value="Continue Shopping">
        </div>
    </form>
                </div>       
            </div>
		</article>	
</div>
	<div class="clear"></div>
</section>
<?php include("includes/simpleFooterHTML.incl.php") ?>