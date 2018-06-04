<?php require_once('../../../../Connections/mctarant_assignment_2012.php'); ?>
<?php include("../includes/authorisation.incl.php") ?>
<?php 
	if(isset($_POST['newRecipe']))
	{
		
		$imageID = mysql_real_escape_string($_POST['imageID']);
		$thumbID = mysql_real_escape_string($_POST['thumbID']);
		$recipeTitle = mysql_real_escape_string($_POST['recipeTitle']);
		$recipeID = mysql_real_escape_string($_POST['recipeID']);
		$recipeDescription = mysql_real_escape_string($_POST['recipeDescription']);
		$recipeIngredients = mysql_real_escape_string($_POST['recipeIngredients']);
        $recipePreparation = mysql_real_escape_string($_POST['recipePreparation']);
		$recipePrice = mysql_real_escape_string($_POST['price']);
		
		
		$SQL = "INSERT INTO recipes SET imageID = '$imageID',
										thumbID = '$thumbID',
										recipeTitle = '$recipeTitle',
								   		recipeDescription = '$recipeDescription', 
								   		recipeIngredients = '$recipeIngredients', 
								   		recipePreparation = '$recipePreparation',
										recipePrice = '$recipePrice'";
										
	  	mysql_select_db($database_mctarant_assignment_2012, $mctarant_assignment_2012);
	  
	  	$result = mysql_query($SQL, $mctarant_assignment_2012) or die("An error has occurred. Please contact the webmaster. Thank you.");
	  
	  	header("Location:dbdIndex.php");	
	} 
	
	$query_rsImages = "SELECT * FROM images WHERE imageFile IS NOT NULL ORDER BY imageFile ASC";
	$query_rsThumbs = "SELECT * FROM thumbs ORDER BY thumbFile ASC";
	
	mysql_select_db($database_mctarant_assignment_2012, $mctarant_assignment_2012);
	
	$rsImages = mysql_query($query_rsImages, $mctarant_assignment_2012) or die("An error has occurred. Please contact the webmaster. Thank you.");
	$rsThumbs = mysql_query($query_rsThumbs, $mctarant_assignment_2012) or die("An error has occurred. Please contact the webmaster. Thank you.");
	
	$row_rsImages = mysql_fetch_assoc($rsImages);
	$row_rsThumbs = mysql_fetch_assoc($rsThumbs);
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="style/dashboard.css">
<title>Add a new recipe</title>
</head>

<body>
	<div id="container">
		<form method="post" name="form1" action="">
        	<fieldset>
            	<p>&nbsp;</p>
            	<legend>Add a new recipe</legend>
                <p id="logout"><small><a href="../login/logout.php">Logout</a></small></p>
          		<label for="recipeTitle">Recipe Title:</label>
            		<input type="text" name="recipeTitle" value="" placeholder="add new recipe title"><br><br>
          		<label for="imageID">Recipe image:</label>
          			<select name="imageID">
						<?php do{ ?>
						<option value="<?php echo $row_rsImages['imageID'] ?>"><?php echo $row_rsImages['imageFile'] ?></option>
                        <?php } while($row_rsImages = mysql_fetch_assoc($rsImages));?>
                    </select><br><br>
                <label for="thumbID">Recipe thumbnail:</label>
                    <select name="thumbID">
						<?php do{ ?>
						<option value="<?php echo $row_rsThumbs['thumbID'] ?>"><?php echo $row_rsThumbs['thumbFile'] ?></option>
                        <?php } while($row_rsThumbs = mysql_fetch_assoc($rsThumbs));?>
                    </select><br><br>
                <label for="recipeDescription">Recipe Description:</label>
                    <textarea name="recipeDescription" placeholder="add recipe description"></textarea><br><br>
                    
                <label for="recipeIngredients">Recipe Ingredients:</label>
                    <textarea name="recipeIngredients" placeholder="add recipe ingredients"></textarea><br><br>
                    
               <label for="recipePreparation">Recipe Preparation</label>
                	<textarea name="recipePreparation" placeholder="add recipe preparation"></textarea><br><br>
                <label for="price">Recipe Price:</label>
              		<input type="number" id="price" name="price" value="" placeholder="add recipe price"><br><br>                    
                    
              <label for="submit">&nbsp;</label>
                	<input name="newRecipe" type="submit" class="button" value="Add new recipe">
                <input type="hidden" name="MM_insert" value="form1">
			</fieldset>
        </form>
      <p><a href="dbdIndex.php">Return to the dashboard</a></p>
	</div>
</body>
</html>
