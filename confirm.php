<?php require_once('../../../Connections/mctarant_assignment_2012.php'); ?>
<?php include("includes/cartSession.incl.php"); ?>
<?php include("includes/errorMessage.incl.php"); ?>
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
<?php 
	// get items with this session ID from the DB
	mysql_select_db($database_mctarant_assignment_2012, $mctarant_assignment_2012);
	$query_rsOrder = "SELECT * FROM orders 
						WHERE orders.cartSessionID = '$cartSessionID'"; 
	$rsOrder = mysql_query($query_rsOrder, $mctarant_assignment_2012) or die("An error has occurred. Please contact the webmaster. Thank you."); 
	$row_rsOrder = mysql_fetch_assoc($rsOrder); 
	$totalRows_rsOrder = mysql_num_rows($rsOrder); 
	
	$orderNumber = 1000 + $row_rsOrder['orderID']; 
	$_SESSION['orderNumber'] = $orderNumber; 
?>
<?php include("includes/headerCheckout.incl.php") ?>
    <article id="fullsize">
      <div class="heading">
        <h1>Confirm your Order No. <?php echo $orderNumber; ?></h1>
      </div>
      <div class="content">
        <div>
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
          <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
            <?php do { ?>
              <?php
	$deliveryRate = $row_rsCart['deliveryRate'];
	$vatRate = $row_rsCart['vatRate'];
	//if it has been chosen giftwrap then multiply the number of items selected for this product by the cot of the gift wrapping service 
	if($row_rsCart['printedRecipe'] == 'Y') {
		$itemPrintTotal = ($row_rsCart['recipeRate'] * $row_rsCart['boxQty']);
	} else {		
		$itemPrintTotal = 0;
	}
			
	$itemTotal = ($row_rsCart['recipePrice']) * ($row_rsCart['boxQty']);
		
	$basketSubTotal = $basketSubTotal + $itemTotal + $itemPrintTotal;		
?>
              <div class="itemRow">
                <div class="productImage"> <img src="images/thumbs/<?php echo $row_rsCart['thumbFile']; ?>" width="138" height="105"> </div>
                <div class="productTitle"><?php echo $row_rsCart['recipeTitle']; ?></div>
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
						<div class="servicePrice">&pound;'.number_format($row_rsCart['giftWrapRate'], 2, '.',',').'</div>
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
			$_SESSION['orderTotal'] = $basketTotal;
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
            <div class="address"> <strong>Deliver to:</strong><br>
              <div class="addressLine"> <?php echo $row_rsOrder['shippingFirstName'] . "&nbsp;" . $row_rsOrder['shippingLastName']; ?><br>
                <?php echo $row_rsOrder['shippingAddress1']; ?><br>
                <?php if (strlen($row_rsOrder['shippingAddress2']) !== 0) { 
				echo $row_rsOrder['shippingAddress2'].'<br>'; 
		  } ?>
                <?php echo $row_rsOrder['shippingCity']; ?><br>
                <?php echo $row_rsOrder['shippingCounty']; ?><br>
                <?php echo $row_rsOrder['shippingPostCode']; ?><br>
                <?php echo $row_rsOrder['shippingPhone']; ?> </div>
            </div>
            <div id="buttonBlock">
              <input name="cmd" type="hidden" value="_cart">
              <input name="rm" type="hidden" value="2">
              <input name="upload" type="hidden" value="1">
              <input name="business" type="hidden" value="QLJQPLLR7JKSC">
              <input name="shopping_url" type="hidden"  
            value="http://mctarantino.com/projects/Recipejack/index.php">
              <input name="return" type="hidden"  
            value="http://mctarantino.com/projects/Recipejack/PPsuccess.php">
              <input name="cancel_return" type="hidden"  
            value="http://mctarantino.com/projects/Recipejack/PPcancel.php">
              <input name="currency_code" type="hidden" value="GBP">
              <input name="item_name_1" type="hidden" value="Order no: <?php echo $orderNumber; ?>">
              <input name="amount_1" type="hidden" value="<?php echo number_format($basketTotal, 2, '.', ','); ?>">
              <input class="button" id="checkout" name="checkout" type="submit" value="Confirm Order">
              <a href="index.php">
              <input class="button" id="continue" name="continue" type="button" value="Continue Shopping">
              </a>
              <input class="button" id="update" type="button" onclick="window.print()"
            value="Print Order">
            </div>
          </form>
        </div>
      </div>
    </article>
  </div>
  <div class="clear"></div>
</section>
<?php include("includes/simpleFooterHTML.incl.php") ?>