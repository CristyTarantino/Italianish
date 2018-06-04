<?php require_once('../../../../Connections/mctarant_assignment_2012.php'); ?>
<?php include("../includes/authorisation.incl.php") ?>
<?php 
	$imgLimit = 50000;
	$path = "../images/thumbs/";
	if(isset($_POST['uploadThumb']))
	{
		if( (($_FILES["file"]["type"] == "image/gif")
			|| ($_FILES["file"]["type"] == "image/png")
			|| ($_FILES["file"]["type"] == "image/x-png")
			|| ($_FILES["file"]["type"] == "image/jpg")
			|| ($_FILES["file"]["type"] == "image/jpeg")
			|| ($_FILES["file"]["type"] == "image/pjpeg")) 
			
			&& ($_FILES["file"]["size"] <= $imgLimit))
		{
			//check status report
			if($_FILES["file"]["error"] > 0)
			{
				$status = "Return Code: " . $_FILES["file"]["error"] . "<br />";
			}
			else
			{
				$status = "Upload file: " . $_FILES['file']['name'] . "<br />";
				$status = $status . "Type: " . $_FILES['file']['type'] . "<br />";
				$status = $status . "Size: " . round(($_FILES['file']['size'] / 1024), 2) . "Kb<br /><br />";
				
				if(file_exists($path . $_FILES['file']['name']))
				{
					$status = $status . '<span class="warning">' . $_FILES['file']['name'] . 
										" already exists . </span><br /><br />";
				}
				else
				{
					move_uploaded_file($_FILES['file']['tmp_name'], $path . $_FILES['file']['name']);
					$status = $status . "Stored in: " . $path . $_FILES['file']['name'] . "<br /><br /><br />";
					
					$thumbFile = $_FILES['file']['name'];
					
					$insertSQL = "INSERT INTO thumbs SET thumbFile = '$thumbFile'";
					mysql_select_db($database_mctarant_assignment_2012, $mctarant_assignment_2012);
					$Result1 = mysql_query($insertSQL, $mctarant_assignment_2012) or die("An error has occurred. Please contact the webmaster. Thank you.");
				}
			}
			$status = $status . "<a href=\"newThumb.php\">Upload another thumb image?</a><br /><br />";
		}
		else
		{
			$error = "Unable to upload file:" . $_FILES["file"]["name"] . "<br />
					 File type: " . $_FILES["file"]["type"] . "<br />";
					 
			if($_FILES["file"]["size"] > $imgLimit)
			$error = $error . round(($_FILES["file"]["size"] / 1024), 2) . "Kb - exceeds allowed size";
		}
	}
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="style/dashboard.css">
<title>Upload a new thumbnail</title>
</head>

<body>
	<div id="container">
        <form action="" method="post" enctype="multipart/form-data" name="fileUploader">
        	<fieldset>
            	<legend>Upload a new thumbnail</legend>
                <p id="logout"><small><a href="../login/logout.php">Logout</a></small></p>
                <p id="explain">This facility expects thumbnail images no larger than 50Kb and loads them to the 'thumbs' folder.</p>
                <label for="file">Thumbnail to upload</label>
                    <input name="file" type="file" id="file"><br><br>
                <label for="submit">&nbsp;</label>
                    <input name="uploadThumb" type="submit" class="button" value="upload thumbnail">
            </fieldset>
        </form>
        <p class="status"><?php echo $status; ?></p>
        <p class="warning"><?php echo $error; ?></p>
		<p><a href="dbdIndex.php">Return to the dashboard</a></p>
    <!-- end of container--></div>
</body>
</html>
