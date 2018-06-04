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
<!-- Basic Page Needs
  ================================================== -->
<meta charset="utf-8">
<title>Recipesjack - Italian about recipes, English about ingredients</title>
<meta name="description" content="Recipes from Italy with English ingredients">
<meta name="author" content="www.mctarantino.com">

<!-- Mobile Specific Metas
  ================================================== -->
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

<!-- CSS
  ================================================== -->
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
<!--------------Header--------------->
<header>
  <div id="logo"><a href="index.php"><img src="./images/logo.png"/></a></div>
</header>
<!--------------Navigation--------------->
<nav>
  <ul class="checkoutMenu">
    	<?php
		if (preg_match('/basket.php/',$_SERVER['REQUEST_URI'])) {
    		echo '<li class="here">My Shopping Bag &raquo;</li>
				  <li>Sign-in &raquo;</li>
				  <li>delivery &raquo;</li>
            	  <li>confirm order &raquo;</li>
            	  <li>payment</li>';
		}
		?>
        <?php
		if (preg_match('/register.php/',$_SERVER['REQUEST_URI'])) {
    		echo '<li class="here">My Shopping Bag &raquo;&raquo;</li>
				  <li class="here">sign-in &raquo;</li>
				  <li>delivery &raquo;</li>
            	  <li>confirm order &raquo;</li>
            	  <li>payment</li>';
		}
		?>
        <?php 
		if (preg_match('/delivery.php/',$_SERVER['REQUEST_URI'])) {
    		echo '<li class="here">My Shopping Bag &raquo;&raquo;</li>
				  <li class="here">sign-in &raquo;&raquo;</li>
				  <li class="here">delivery &raquo;</li>
				  <li>confirm order &raquo;</li>
            	  <li>payment</li>';
		}
		?>
        <?php 
		if (preg_match('/confirm.php/',$_SERVER['REQUEST_URI'])) {
    		echo '<li class="here">My Shopping Bag &raquo;&raquo;</li>
				  <li class="here">sign-in &raquo;&raquo;</li>
				  <li class="here">delivery &raquo;&raquo;</li>
				  <li class="here">confirm order &raquo;</li>
            	  <li>payment</li>';
		}
		?>
  </ul>
  <div class="minimenu">
    <div>MENU</div>
    <select onchange="location=this.value">
      <option></option>
      <option value="basket.php">My Shopping Bag</option>
      <option value="register.php">Sign-in</option>
      <option value="delivery.php">Delivery</option>
      <option value="confirm.php">Confirm order</option>
      <option value="#">Payment</option>
    </select>
  </div>
</nav>
<!--------------Content--------------->
<section id="content">
<div id="main-content">
