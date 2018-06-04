<?php require_once('../../../Connections/mctarant_assignment_2012.php'); ?>
<?php include("cartSession.incl.php"); ?>
<?php include("errorMessage.incl.php"); ?>
<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html lang="en">
<!--<![endif]-->
<head>
<!-- Basic Page Needs  ================================================== -->
<meta charset="utf-8">
<title>Recipesjack - Italian about recipes, English about ingredients</title>
<meta name="description" content="Recipes from Italy with English ingredients">
<meta name="author" content="www.mctarantino.com">
<!-- Mobile Specific Metas ================================================== -->
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<!-- CSS ================================================== -->
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/responsive.css">
<!--[if lt IE 8]>
       <div style=' clear: both; text-align:center; position: relative;'>
         <a href="http://windows.microsoft.com/en-US/internet-explorer/products/ie/home?ocid=ie6_countdown_bannercode">
           <img src="http://storage.ie6countdown.com/assets/100/images/banners/warning_bar_0000_us.jpg" border="0" height="42" width="820" alt="You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today." />
        </a>
      </div>
    <![endif]-->
<!--[if lt IE 9]>
		<script src="js/html5.js"></script>
	<![endif]-->
<link href='./images/favicon.ico' rel='icon' type='image/x-icon'/>
</head>
<body>
<?php  
		mysql_select_db($database_mctarant_assignment_2012, $mctarant_assignment_2012);
	$query_rsCart = "SELECT * FROM cartItems, recipes, administration
					 WHERE cartItems.cartSessionID = '$cartSessionID'
					 AND boxQty > 0
					 AND recipes.recipeID = cartItems.recipeID";
	
 	$rsCart = mysql_query($query_rsCart, $mctarant_assignment_2012) or die("An error has occurred. Please contact the webmaster. Thank you.");
	$row_rsCart = mysql_fetch_assoc($rsCart);
	
	//returns the number of rows of data returned in the query
	$totalRows_rsCart = mysql_num_rows($rsCart);
?>
<?php 
	$qtyItems = 0;
	$basketSubTotal = 0;
	$basketTotal = 0;
?>
<?php 
	do{ 
		//if it has been chosen giftwrap then multiply the number of items selected for this product by the cot of the gift wrapping service 
		if($row_rsCart['printedRecipe'] == 'Y')
			$itemPrintTotal = $row_rsCart['recipeRate'] * $row_rsCart['boxQty'];
		else		
			$itemPrintTotal = 0;
				
		$itemTotal = $row_rsCart['recipePrice'] * $row_rsCart['boxQty'];
		
		$basketSubTotal = $basketSubTotal + $itemTotal + $itemPrintTotal;		
		$qtyItems = $qtyItems + $row_rsCart['boxQty'];		
		$basketTotal = $basketSubTotal + $row_rsCart['deliveryRate'];	
	}	
	while($row_rsCart = mysql_fetch_assoc($rsCart)); 
?>
<!--------------Header--------------->
<header>
  <div id="shoppingBag"> 
  <img src="images/thumbs/WhiteBagOnBlack.png" align="left" width="100" height="80">
    <div id="cartSummary"><strong>My Shopping Bag</strong><br>
      <?php
		if($qtyItems > 0)
		{ 	
			echo $qtyItems . ' items, ';
			echo '&pound;' . number_format($basketTotal, 2, '.', ',');
		}
	  ?>
      <br>
      <a href="basket.php"><strong>&raquo;</strong> Proceed to Checkout</a>
    </div>
  </div>
  <div id="logo"><a href="index.php"><img src="./images/logo.png"/></a></div>
</header>
<!--------------Navigation--------------->
<nav>
  <ul class="menu">
    <li><a href="index.php">Home</a></li>
    <li><a href="about.php?pageID=3">About</a></li>
    <li><a href="contact.php?pageID=4">Contact</a></li>
    <li><a href="firstAssignment.php?pageID=5">Assignment I</a></li>
    <li><a href="secondAssignment.php?pageID=6">Assignment II</a></li>
  </ul>
  <div class="minimenu">
    <div>MENU</div>
    <select onchange="location=this.value">
      <option></option>
      <option value="index.php">Home</option>
      <option value="about.php?pageID=3">About</option>
      <option value="contact.php?pageID=4">Contact</option>
      <option value="firstAssignment.php.php?pageID=5">Assignment I</option>
      <option value="secondAssignment.php.php?pageID=6">Assignment II</option>
    </select>
  </div>
</nav>
<!--------------Content--------------->
<section id="content">
<div id="main-content">
