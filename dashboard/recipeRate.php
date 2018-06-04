<?php require_once('../../../Connections/mctarant_assignment_2012.php'); ?>
<?php include("../includes/authorisation.incl.php") ?>
<?php 
	if(isset($_POST['print'])){
		if(filter_var($_POST['print'], FILTER_VALIDATE_FLOAT) && $_POST['print'] < 100 && $_POST['print'] > 0){
			$recipeRate = $_POST['print'];
			
			$SQL = "UPDATE administration SET recipeRate = '$recipeRate'";
			
			mysql_select_db($database_mctarant_assignment_2012, $mctarant_assignment_2012);
			
			$Result1 = mysql_query($SQL, $mctarant_assignment_2012) or die("An error has occurred. Please contact the webmaster. Thank you.");
			
			header("Location:salesDept.php");
		}
		else
			$error = "Please enter a valid number";	
	}
?>
<?php 
	
	$query = "SELECT recipeRate FROM administration";
	
	mysql_select_db($database_mctarant_assignment_2012, $mctarant_assignment_2012);
	
	$rsAdmin = mysql_query($query, $mctarant_assignment_2012) or die("An error has occurred. Please contact the webmaster. Thank you.");
	
	$row_rsAdmin = mysql_fetch_assoc($rsAdmin);

?>
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
      <legend>Printed Recipe</legend>
      <p id="logout"><small><a href="../login/logout.php">Logout</a></small></p>
      <p>Set the current rate for Printed Recipe</p>
      <br>
      <label for="pageTitle">Printed Recipe rate &pound;:</label>
      <input type="text" name="print" value="<?php echo $row_rsAdmin['recipeRate']; ?>">
      <br>
      <br>
      <label for="submit">&nbsp;</label>
      <input type="submit" class="button" value="Set Printed Recipe price" style="width:180px;">
    </fieldset>
    <p class="warning"><?php echo $error ?></p>
  </form>
  <p><a href="dbdIndex.php">Return to the dashboard</a></p>
  <p><a href="salesDept.php">Return to the Sales Department</a></p>
  <!-- end of container--> 
</div>
</body>
</html>
