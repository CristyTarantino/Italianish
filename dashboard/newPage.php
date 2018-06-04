<?php require_once('../../../../Connections/mctarant_assignment_2012.php'); ?>
<?php include("../includes/authorisation.incl.php") ?>
<?php 
if(isset($_POST['newPage']))
	{
		$pageTitle = mysql_real_escape_string($_POST['pageTitle']);
		$pageType = mysql_real_escape_string($_POST['pageType']);
		$pageText = mysql_real_escape_string($_POST['pageText']);
		$imageID = mysql_real_escape_string($_POST['imageID']);
		
		$SQL = "INSERT INTO pages SET pageTitle = '$pageTitle', pageText = '$pageText', pageType = '$pageType', imageID = '$imageID'";
							 
		mysql_select_db($database_mctarant_assignment_2012, $mctarant_assignment_2012);							  
									  
		$result = mysql_query($SQL, $mctarant_assignment_2012) or die("An error has occurred. Please contact the webmaster. Thank you.");
		
		header("Location:dbdIndex.php");	
	}
?>	
<?php
	mysql_select_db($database_mctarant_assignment_2012, $mctarant_assignment_2012);
	
	$query_rsImages = "SELECT * FROM images ORDER BY imageFile";
	
	$rsImages = mysql_query($query_rsImages, $mctarant_assignment_2012) or die("An error has occurred. Please contact the webmaster. Thank you.");
	
	$row_rsImages = mysql_fetch_assoc($rsImages);
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="style/dashboard.css">
<title>Add a new page</title>
</head>

<body>
	<div id="container">
		<form method="post" name="form1" action="">
        	<fieldset>
            	<legend>Add a new page</legend>
                <p id="logout"><small><a href="../login/logout.php">Logout</a></small></p>
            	<label for="pageTitle">Page Title:</label>
            		<input type="text" name="pageTitle" value="" placeholder="add new page title"><br><br>
          		<label for="pageType">Page type:</label>
                	<select name="pageType">
                    	<option value="text">Text</option>
                    	<option value="gallery">Gallery</option>
                    	<option value="contact">Contact</option>
                    	<option value="recipe">Recipe</option>
                    </select><br><br>
          		<label for="imageID">Page image:</label>
          			<select name="imageID">
                    <?php do { 
								if($row_rsImages['videoType'] != NULL) { $row_rsImages['imageFile'] = $row_rsImages['videoFile'] . '.' . $row_rsImages['videoType']; }?>
						<option value="<?php echo $row_rsImages['imageID'] ?>"><?php echo $row_rsImages['imageFile'] ?></option>
                        <?php } while($row_rsImages = mysql_fetch_assoc($rsImages)); ?>
                    </select><br><br>
                <label for="pageText">Page text:</label>
                    <textarea name="pageText" placeholder="add text for the page"></textarea><br><br>
                <label for="submit">&nbsp;</label>
                	<input name="newPage" type="submit" class="button" value="Add new page">
			</fieldset>
        </form>
      <p><a href="dbdIndex.php">Return to the dashboard</a></p>
	</div>
</body>
</html>
