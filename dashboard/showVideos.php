<?php require_once('../../../../Connections/mctarant_assignment_2012.php'); ?>
<?php include("../includes/authorisation.incl.php") ?>
<?php 
	mysql_select_db($database_mctarant_assignment_2012, $mctarant_assignment_2012);
	$query_rsImages = "SELECT * FROM images WHERE videoFile IS NOT NULL ORDER BY videoFile, videoType ASC";
	$rsImages = mysql_query($query_rsImages, $mctarant_assignment_2012) or die("An error has occurred. Please contact the webmaster. Thank you.");
	$row_rsImages = mysql_fetch_assoc($rsImages);
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="style/dashboard.css">
<title>Directory of Large images</title><p id="logout"><small><a href="../login/logout.php">Logout</a></small></p>
</head>

<body>
	<div id="container">
      <h1>Directory of Videos</h1><p id="logout"><small><a href="../login/logout.php">Logout</a></small></p>
      <p class="miniTxt">(images displayed at half actual size)</p>
      <?php do{ ?>
		<div style="float:left; margin:20px 20px 0 0;">
         <video width="350" controls>
         	<source src="../images/video/<?php echo $row_rsImages['videoFile']; ?>.<?php echo $row_rsImages['videoType']; ?>" type="video/<?php echo $row_rsImages['videoType']; ?>" >
          	Your Browser cannot display videos.
            </video><br />
            <strong><?php echo $row_rsImages['videoFile']; ?>.<?php echo $row_rsImages['videoType']; ?></strong>
        </div>
      <?php } while ($row_rsImages = mysql_fetch_assoc($rsImages)); ?>
		<div style="clear:both; padding:30px 0;">
		<p><a href="dbdIndex.php">Return to the dashboard</a></p>
        </div>
	<!-- end of container--></div>
</body>
</html>
