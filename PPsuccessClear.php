<?php require_once('../../../Connections/mctarant_assignment_2012.php'); ?>
<?php 
	session_start(); 
	session_destroy(); 
	setcookie(session_name(),'',0,'/'); 
?>
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
  <ul class="menu">
    <li><a href="index.php">Home</a></li>
    <li><a href="about.php?pageID=3">About</a></li>
    <li><a href="contact.php?pageID=4">Contact</a></li>
    <li><a href="assignment.php?pageID=5">Assignment</a></li>
  </ul>
  <div class="minimenu">
    <div>MENU</div>
    <select onchange="location=this.value">
      <option></option>
      <option value="index.php">Home</option>
      <option value="about.php?pageID=3">About</option>
      <option value="contact.php?pageID=4">Contact</option>
      <option value="assignment.php?pageID=5">Assignment</option>
    </select>
  </div>
</nav>
<!--------------Content--------------->
<section id="content">
  <div id="main-content">
    <article id="fullsize">
      <div class="heading">
        <h1>Checkout complete</h1>
      </div>
      <div class="content">
        <div>
          <p>Thank you for shopping at Recipejack, we shall be in contact very shortly.</p>
          <p>Maria Cristina Tarantino</p>
          <p><strong>Recipejack</strong></p>
          <a href="index.php">
          <input class="button" name="continue" type="button" value="Click to Continue Shopping">
          </a> </div>
      </div>
    </article>
  </div>
  <div class="clear"></div>
</section>
<?php include("includes/simpleFooterHTML.incl.php") ?>