<?php require_once('../../../../Connections/mctarant_assignment_2012.php'); ?>
<?php include("../includes/authorisation.incl.php") ?>
<?php if(isset($_POST['pending'])){
	header("location:newOrders.php");
} ?>
<?php if(isset($_POST['paid'])){
	header("location:ordersForFulfilment.php");
} ?>
<?php if(isset($_POST['despatched'])){
	header("location:ordersCompleted.php");
} ?>
<?php if(isset($_POST['VAT'])){
	header("location:VATrate.php");
} ?>
<?php if(isset($_POST['print'])){
	header("location:recipeRate.php");
} ?>
<?php if(isset($_POST['delivery'])){
	header("location:deliveryRate.php");
} ?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="style/dashboard.css">
<title>Recipesjack Dashboard</title>
</head>

<body>
<div id="container">
  <form action="" method="post" class="miniForm">
    <fieldset>
      <legend>Sales Department</legend>
      <p id="logout"><small><a href="../login/logout.php">Logout</a></small></p>
      <div id="category">
        <h2>Orders</h2>
        <div class="selection">
          <label for="pending">&nbsp;</label>
          <input name="pending" class="button" type="submit" value="orders Pending">
        </div>
        <div class="selection">
          <label for="paid">&nbsp;</label>
          <input name="paid" class="button" type="submit" value="orders Paid">
        </div>
        <div class="selection">
          <label for="despatched">&nbsp;</label>
          <input name="despatched" class="button" type="submit" value="orders Despatched">
        </div>
        <!-- end category--></div>
      <div id="category">
        <h2>Administration</h2>
        <div class="selection">
          <label for="VAT">&nbsp;</label>
          <input name="VAT" class="button" type="submit" value="VAT">
        </div>
        <div class="selection">
          <label for="print">&nbsp;</label>
          <input name="print" class="button" type="submit" value="Printed Recipe">
        </div>
        <div class="selection">
          <label for="delivery">&nbsp;</label>
          <input name="delivery" class="button" type="submit" value="Delivery">
        </div>
        <!-- end category--></div>
    </fieldset>
  </form>
  <p><a href="dbdIndex.php">Return to the dashboard</a></p>
  <!-- end of container--></div>
</body>
</html>
