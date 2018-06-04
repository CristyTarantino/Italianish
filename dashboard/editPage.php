<?php require_once('../../../../Connections/mctarant_assignment_2012.php'); ?>
<?php include("../includes/authorisation.incl.php") ?>
<?php 
	if(isset($_POST['submit'])){
		
		$pageTitle = mysql_real_escape_string($_POST['pageTitle']);
		$pageText = mysql_real_escape_string($_POST['pageText']);
		$pageID = mysql_real_escape_string($_POST['pageID']);
		$imageID = mysql_real_escape_string($_POST['imageID']);
		
		$SQL = "UPDATE pages SET pageTitle = '$pageTitle', pageText = '$pageText', pageID = '$pageID', imageID = '$imageID'
							 WHERE pageID = $pageID";
							 
		mysql_select_db($database_mctarant_assignment_2012, $mctarant_assignment_2012);							  
									  
		$result = mysql_query($SQL, $mctarant_assignment_2012) or die("An error has occurred. Please contact the webmaster. Thank you.");
		
		header("Location:dbdIndex.php");							 
	}
?>
<?php 
	if(isset($_POST['deletePage'])){
		
		$pageID = mysql_real_escape_string($_POST['pageID']);
		
		header("Location:deleteConf.php?pageID=".$pageID."");							 
	}
?>
<?php 
	if(isset($_GET['pageID']))
	{
		$pageID = $_GET['pageID'];
		
		$query_rsPages = "SELECT * FROM pages, images 
							WHERE pages.pageID = '$pageID'
							AND pages.imageID = images.imageID";
								  
		mysql_select_db($database_mctarant_assignment_2012, $mctarant_assignment_2012);
								   
		$rsPages = mysql_query($query_rsPages, $mctarant_assignment_2012) or die("An error has occurred. Please contact the webmaster. Thank you.");
		
		$row_rsPages = mysql_fetch_assoc($rsPages);
		
		$query_rsImages = "SELECT * FROM images ORDER BY imageFile";
		
		$rsImages = mysql_query($query_rsImages, $mctarant_assignment_2012) or die("An error has occurred. Please contact the webmaster. Thank you.");
		
		//mysql_fetch_assoc returns an associative array that corresponds to the fetched row and moves the internal data pointer ahead.
		$row_rsImages = mysql_fetch_assoc($rsImages);
	}
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="style/dashboard.css">
<title>Edit Page</title>
</head>

<body>
<div id="container">
  <form method="post" action="">
    <fieldset>
      <legend>Edit page details</legend>
      <p id="logout"><small><a href="../login/logout.php">Logout</a></small></p>
      <label for="pageTitle">Title</label>
      <!-- stripslashes() removes "strips" the slashes introduced by the mysql_real_escapes_string() fn used to safely write data to the database -->
      <input type="text" name="pageTitle" value="<?php echo stripslashes($row_rsPages['pageTitle']) ?>">
      <br>
      <br>
      <?php if($row_rsPages['imageFile'] != NULL) { ?>
      <img id="productImg" src="../images/large/<?php echo $row_rsPages['imageFile']; ?>" width="500"><br>
      <br>
      <?php } else if($row_rsPages['videoType'] != NULL) { ?>
        <video width="500" id="productImg" controls>
        <source src="../images/video/<?php echo $row_rsPages['videoFile']; ?>.mp4" type="video/mp4"/>
        <source src="../images/video/<?php echo $row_rsPages['videoFile']; ?>.ogg" type="video/ogg"/>
        Your browser does not support videos
        </video>
      <br>
      <?php } ?>
      <label for="imageID">Main image</label>
      <select id="imageID" name="imageID">
        <option select="selected" value="<?php echo $row_rsPages['imageID'] ?>"><?php echo $row_rsPages['imageFile'] ?>
		<?php if($row_rsImages['videoType'] != NULL) echo $row_rsPages['videoFile'] . '.' . $row_rsPages['videoType'] ?></option>
        
        <?php do { if($row_rsImages['videoType'] != NULL) { $row_rsImages['imageFile'] = $row_rsImages['videoFile'] . '.' . $row_rsImages['videoType']; } if($row_rsImages['imageFile'] == $row_rsPages['imageFile']) continue;?>
        
						<option value="<?php echo $row_rsImages['imageID'] ?>"><?php echo $row_rsImages['imageFile'] ?></option>
                        <?php } while($row_rsImages = mysql_fetch_assoc($rsImages)); ?>
                    </select>
      <br>
      <br>
      <label for="pageText">Narrative</label>
      <textarea name="pageText"><?php echo stripslashes($row_rsPages['pageText']); ?></textarea>
      <br>
      <br>
      <label for="update">&nbsp;</label>
      <input name="submit" type="submit" class="button" value="Update <?php echo stripslashes($row_rsPages['pageTitle']); ?>" style="width:auto">
      <input name="deletePage" type="submit" class="button" value="Delete <?php echo stripslashes($row_rsPages['pageTitle']); ?>" style="width:auto">
      <input type="hidden" name="pageID" value="<?php echo $pageID; ?>">
    </fieldset>
  </form>
  <p><a href="dbdIndex.php">Return to the dashboard</a></p>
  <!-- end of container--></div>
</body>
</html>
