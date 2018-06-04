<?php require_once('../../../../Connections/mctarant_assignment_2012.php'); ?>
<?php include("../includes/authorisation.incl.php") ?>
<?php 
	if(isset($_POST['return']))
	{
		header("Location:editPage.php?pageID=".$_GET['pageID']."");
	}
?>
<?php 
	if(isset($_POST['deletePage']))
	{
		$pageID = $_GET['pageID'];
		
		$delete_SQL = "DELETE FROM pages WHERE pageID ='$pageID'";
		
		mysql_select_db($database_mctarant_assignment_2012, $mctarant_assignment_2012);
		
		$result = mysql_query($delete_SQL, $mctarant_assignment_2012) or die("An error has occurred. Please contact the webmaster. Thank you.");
		
		header("Location:dbdIndex.php");
		  
	}
?>
<?php 
	if(isset($_GET['pageID']))
	{
		$pageID = $_GET['pageID'];
		
		$query_rsPage = "SELECT pageTitle FROM pages WHERE pageID ='$pageID'";
		
		mysql_select_db($database_mctarant_assignment_2012, $mctarant_assignment_2012);
		
		$rsPage = mysql_query($query_rsPage, $mctarant_assignment_2012) or die("An error has occurred. Please contact the webmaster. Thank you.");
		
		$row_rsPage = mysql_fetch_assoc($rsPage);
		  
	}
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="style/dashboard.css">
<title>Confirm deletion</title>
</head>

<body>
	<div id="container">
        <form action="" method="post">
        	<fieldset>
                <legend>Delete Page</legend>
                <p id="logout"><small><a href="../login/logout.php">Logout</a></small></p>
                <p id="explain">Are you sure that you want to delete the <?php echo $row_rsPage['pageTitle'] ?> page.</p>
                <label for="deletePage">&nbsp;</label>
                <input type="hidden" name="pageID" value="">
                <input name="deletePage" class="button" type="submit" value="Delete <?php echo $row_rsPage['pageTitle'] ?>" style="width:auto">
                &nbsp;&nbsp;      
                <input name="return" class="button" type="submit" value="CANCEL DELETE">
         	</fieldset>         
        </form>
      	<p><a href="dbdIndex.php">Return to the dashboard</a></p>
    </div>
</body>
</html>
