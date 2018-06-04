<?php require_once('../../../../Connections/mctarant_assignment_2012.php'); ?>
<?php include("../includes/authorisation.incl.php") ?>
<?php 
	mysql_select_db($database_mctarant_assignment_2012, $mctarant_assignment_2012);
	$query_rsThumbs = "SELECT * FROM thumbs WHERE thumbFile IS NOT NULL ORDER BY thumbFile ASC";
	$rsThumbs = mysql_query($query_rsThumbs, $mctarant_assignment_2012) or die("An error has occurred. Please contact the webmaster. Thank you.");
	$row_rsThumbs = mysql_fetch_assoc($rsThumbs);
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="style/dashboard.css">
<title>Directory of thumbnail images</title>
</head>

<body>
	<div id="container">
      <h1>Directory of thumbnail images</h1><p id="logout"><small><a href="../login/logout.php">Logout</a></small></p>
        <?php do{ ?>
		<div style="float:left; margin:20px 20px 0 0; width:158px; height:130px;">
          	<img alt="thumbnail" src="../images/thumbs/<?php echo $row_rsThumbs['thumbFile']?>"><br>
          	<strong><?php echo $row_rsThumbs['thumbFile']?></strong>
        </div>
      <?php } while ($row_rsThumbs = mysql_fetch_assoc($rsThumbs)); ?>
		<div style="clear:both; padding:30px 0;">
		<p><a href="dbdIndex.php">Return to the dashboard</a></p>
        </div>
	<!-- end of container--></div>
</body>
</html>
