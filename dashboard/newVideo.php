<?php require_once('../../../../Connections/mctarant_assignment_2012.php'); ?>
<?php include("../includes/authorisation.incl.php") ?>
<?php 
	if(isset($_POST['uploadVideo']))
	{
		if((($_FILES["file"]["type"] == "video/mp4") 
		|| ($_FILES["file"]["type"] == "video/ogg"))		
		&& ($_FILES["file"]["size"] <= 5120000))
		{
			if($_FILES['file']['error'] > 0)
			{
				$status = "Return Code: " . $_FILES['file']['error'] . "<br>";
			}
			else
			{
				$status = "Upload file: " . $_FILES['file']['name'] . "<br>";
				$status = $status . "Type: " . $_FILES['file']['type'] . "<br>";
				$status = $status . "Size: " . round(($_FILES['file']['size'] / 1024), 2) . "Kb<br><br>";
			}
			if(file_exists("../images/video/" . $_FILES['file']['name']))
			{
				$status = $status . "<span class=\"warning\">" . $_FILES['file']['name'] . " already exists.</span><br><br>"; 
			}
			else
			{
				move_uploaded_file($_FILES['file']['tmp_name'],"../images/video/".$_FILES['file']['name']);
				$status = $status . "Stored in: " . "../images/video/" . $_FILES['file']['name']. "<br><br><br>";
				
				//splits the file name depending on the delimiter in substrings
				$video = explode('.', $_FILES['file']['name']);
				
				$insertSQL = "INSERT INTO images SET videoFile = '$video[0]', videoType = '$video[1]'";
				mysql_select_db($database_mctarant_assignment_2012, $mctarant_assignment_2012);
				
				$Result = mysql_query($insertSQL, $mctarant_assignment_2012);
			}
			
			$status = $status . "<a href=\"newImage.php\">Upload another video?</a><br><br>";
		}
		else
		{
			$error = "Unable to upload file: " . $_FILES['file']['name'] . "<br>
					  File type: " . $_FILES['file']['type'] . "<br>";
					  
			if($_FILES['file']['size']>5120000)
			{
				$error = $error . round(($_FILES['file']['size'] / 1024), 2) . "Kb - exceeds allowed size";
			}
		}
	}
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="style/dashboard.css">
<title>Upload a new video</title>
</head>

<body>
	<div id="container">
        <form action="" method="post" enctype="multipart/form-data" name="fileUploader">
        	<fieldset>
            	<legend>Upload a new video</legend>
                <p id="logout"><small><a href="../login/logout.php">Logout</a></small></p>
                <p id="explain">This facility accepts videos up to 5MB and loads them to the 'video' folder.</p>
                <label for="file">Video file to upload</label>
                	<input name="file" type="file" id="file"><br><br>
                <label for="submit"></label>
                    <input name="uploadVideo" type="submit" class="button" value="upload the video">
            </fieldset>
        </form>
        <p class="status"><?php echo $status ?></p>
        <p class="warning"><?php echo $error ?></p>
        <p><a href="dbdIndex.php">Return to the dashboard</a></p>
    <!-- end of container--></div>
</body>
</html>