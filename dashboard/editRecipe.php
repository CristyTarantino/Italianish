<?php require_once('../../../../Connections/mctarant_assignment_2012.php'); ?>
<?php include("../includes/authorisation.incl.php") ?>
<?php
	if(isset($_POST['submit'])){
		
		$imageID = mysql_real_escape_string($_POST['imageID']);
		$thumbID = mysql_real_escape_string($_POST['thumbID']);
		$recipeTitle = mysql_real_escape_string($_POST['recipeTitle']);
		$recipeID = mysql_real_escape_string($_POST['recipeID']);
		$recipeDescription = mysql_real_escape_string($_POST['recipeDescription']);
		$recipeIngredients = mysql_real_escape_string($_POST['recipeIngredients']);
        $recipePreparation = mysql_real_escape_string($_POST['recipePreparation']);
		$recipePrice = mysql_real_escape_string($_POST['price']);
		
		
		$SQL = "UPDATE recipes SET recipeID = '$recipeID', 
								   imageID = '$imageID', 
								   thumbID = '$thumbID', 
								   recipeTitle = '$recipeTitle', 
								   recipeDescription = '$recipeDescription', 
								   recipeIngredients = '$recipeIngredients', 
								   recipePreparation = '$recipePreparation',
								   recipePrice = '$recipePrice'
								   WHERE recipeID = $recipeID";
							 
		mysql_select_db($database_mctarant_assignment_2012, $mctarant_assignment_2012);							  
									  
		$result = mysql_query($SQL, $mctarant_assignment_2012) or die("An error has occurred. Please contact the webmaster. Thank you.");
		
		header("Location:dbdIndex.php");							 
	}
?>
<?php 
	if(isset($_GET['recipeID']))
	{
		$recipeID = $_GET['recipeID'];
		
		$query_rsRecipe = "SELECT * FROM recipes, thumbs, images WHERE recipes.recipeID = '$recipeID' AND recipes.imageID = images.imageID AND recipes.thumbID = thumbs.thumbID";
								  
		mysql_select_db($database_mctarant_assignment_2012, $mctarant_assignment_2012);
								   
		$rsRecipe = mysql_query($query_rsRecipe, $mctarant_assignment_2012) or die("An error has occurred. Please contact the webmaster. Thank you.");
		
		$row_rsRecipe = mysql_fetch_assoc($rsRecipe);
		
		$query_rsImages = "SELECT * FROM images WHERE imageFile IS NOT NULL ORDER BY imageFile";
		
		$rsImages = mysql_query($query_rsImages, $mctarant_assignment_2012) or die("An error has occurred. Please contact the webmaster. Thank you.");
		
		//mysql_fetch_assoc returns an associative array that corresponds to the fetched row and moves the internal data pointer ahead.
		$row_rsImages = mysql_fetch_assoc($rsImages);
		
		$query_rsThumbs = "SELECT * FROM thumbs";
		
		$rsThumbs = mysql_query($query_rsThumbs, $mctarant_assignment_2012) or die("An error has occurred. Please contact the webmaster. Thank you.");
		
		//mysql_fetch_assoc returns an associative array that corresponds to the fetched row and moves the internal data pointer ahead.
		$row_rsThumbs = mysql_fetch_assoc($rsThumbs);
	}
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="style/dashboard.css">
<title>Edit recipe details</title>
</head>

<body>
	<div id="container">
      <form method="post" name="form1" action="">
        	<fieldset>
            	<legend>Edit recipe details</legend> 
                <p id="logout"><small><a href="../login/logout.php">Logout</a></small></p>
                <label for="recipeTitle">Title</label>
                <input name="recipeTitle" id="recipeTitle" type="text" value="<?php echo $row_rsRecipe['recipeTitle'] ?>"><br><br>
                <img id="recipeImg" src="../images/large/<?php echo $row_rsRecipe['imageFile'] ?>" alt="" width="500" height="380">&nbsp;
                <img id="recipeThumb" src="../images/thumbs/<?php echo $row_rsRecipe['thumbFile'] ?>" alt="">
                        <label for="imageID">Recipe image:</label>
                            <select name="imageID">
                                <option value="<?php echo $row_rsRecipe['imageID'] ?>"><?php echo $row_rsRecipe['imageFile'] ?></option>
                            <?php do { if($row_rsImages['imageID'] == $row_rsRecipe['imageID']) continue; ?>
                                <option value="<?php echo $row_rsImages['imageID'] ?>"><?php echo $row_rsImages['imageFile'] ?></option>
                            <?php } while ($row_rsImages = mysql_fetch_assoc($rsImages)); ?>
                            </select><br><br>
                        <label for="thumbID">Recipe thumbnail:</label>
                            <select name="thumbID">
                                <option value="<?php echo $row_rsRecipe['thumbID'] ?>"><?php echo $row_rsRecipe['thumbFile'] ?></option>
                            <?php do { if($row_rsThumbs['thumbID'] == $row_rsRecipe['thumbID'] ) continue; ?>
                                <option value="<?php echo $row_rsThumbs['thumbID'] ?>"><?php echo $row_rsThumbs['thumbFile'] ?></option>
                            <?php } while ($row_rsThumbs = mysql_fetch_assoc($rsThumbs)); ?>
                            </select><br><br>       
                <label for="recipeDescription">Recipe Description:</label>
                    <textarea name="recipeDescription" placeholder="add recipe description"><?php echo stripslashes($row_rsRecipe['recipeDescription']); ?></textarea><br><br>
                    
                <label for="recipeIngredients">Recipe Ingredients:</label>
                    <textarea name="recipeIngredients" placeholder="add recipe ingredients"><?php echo stripslashes($row_rsRecipe['recipeIngredients']); ?></textarea><br><br>
                    
				<label for="recipePreparation">Recipe Preparation</label>
                	<textarea name="recipePreparation"><?php echo stripslashes($row_rsRecipe['recipePreparation']); ?></textarea><br><br>    
                <label>Recipe Price:</label>
                <input type="number" id="price" name="price" value="<?php echo $row_rsRecipe['recipePrice']; ?>"><br><br>                                
                <label for="update">&nbsp;</label>
                <input type="submit" class="button" name="submit" value="Update record">
                <input type="hidden" name="MM_update" value="form1">
                <input type="hidden" name="recipeID" value="<?php echo $recipeID; ?>">
                </fieldset>
        </form>
        <p><a href="dbdIndex.php">Return to the dashboard</a></p>
    </div>
</body>
</html>
