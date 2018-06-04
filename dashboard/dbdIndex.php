<?php require_once('../../../../Connections/mctarant_assignment_2012.php'); ?>
<?php include("../includes/authorisation.incl.php") ?>
<?php if(isset($_POST['salesDept'])){
	header("location:salesDept.php");
} ?>
<?php 
	if(isset($_POST['submitPage']))
	{
		header("Location:editPage.php?pageID=".$_POST['pageID']."");
	}
?>
<?php 
	if(isset($_POST['submitRecipe']))
	{
		header("Location:editRecipe.php?recipeID=".$_POST['recipeID']."");
	}
?>
<?php 
if(isset($_POST['newPage']))
	{
		//tell PHP where to take the user when they click on the 'Add a new page' button
		header("Location:newPage.php");
	} 
else if(isset($_POST['newRecipe']))
	{
		header("Location:newRecipe.php");
	}
else if(isset($_POST['newImage']))
	{
		header("Location:newImage.php");
	}
else if(isset($_POST['newThumb']))
	{
		header("Location:newThumb.php");
	}
else if(isset($_POST['newVideo']))
	{
		header("Location:newVideo.php");
	}
else if(isset($_POST['showImages']))
	{
		header("Location:showImages.php");
	}
else if(isset($_POST['showThumbs']))
	{
		header("Location:showThumbs.php");
	}
else if(isset($_POST['showVideos']))
	{
		header("Location:showVideos.php");
	}
?>
<?php 
	mysql_select_db($database_mctarant_assignment_2012, $mctarant_assignment_2012);
	
	$query_rsPages = "SELECT * FROM pages ORDER BY pageTitle ASC";
	
	$rsPages = mysql_query($query_rsPages, $mctarant_assignment_2012) or die("An error has occurred. Please contact the webmaster. Thank you.");
	
	$row_rsPages = mysql_fetch_assoc($rsPages);
?>
<?php 
	mysql_select_db($database_mctarant_assignment_2012, $mctarant_assignment_2012);
	
	$query_rsRecipes = "SELECT * FROM recipes ORDER BY recipeTitle ASC";
	
	$rsRecipes = mysql_query($query_rsRecipes, $mctarant_assignment_2012) or die("An error has occurred. Please contact the webmaster. Thank you.");
	
	$row_rsRecipes = mysql_fetch_assoc($rsRecipes);
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
  <form action="" method="post">
    <fieldset>
      <legend>Recipesjack Dashboard</legend>
      <p id="logout"><small><a href="../login/logout.php">Logout</a></small></p>
      <div id="category">
        <h2>Sales Dept</h2>
        <div class="selection">
          <label for="salesDept">&nbsp;</label>
          <input name="salesDept" class="button" type="submit" value="go to Sales">
        </div>
        <!-- end category--></div>
      <div id="category">
        <h2>Pages</h2>
        <div class="selection">
          <label for="pageID">Edit page</label>
          <select name="pageID">
            <?php do {?>
            <option value="<?php echo $row_rsPages['pageID']?>"><?php echo $row_rsPages['pageTitle']?></option>
            <?php } while($row_rsPages = mysql_fetch_assoc($rsPages));?>
          </select>
          <input name="submitPage" class="button" type="submit" value="edit this page">
          <!-- end selection--></div>
        <div class="selection">
          <label for="newPage">Add a new page</label>
          <input name="newPage" class="button" type="submit" value="add a new page">
        </div>
        <!-- end category--></div>
      <div id="category">
        <h2>Recipes</h2>
        <div class="selection">
          <label for="recipeID">Edit recipe details</label>
          <select name="recipeID">
            <?php do {?>
            <option value="<?php echo $row_rsRecipes['recipeID']?>"><?php echo $row_rsRecipes['recipeTitle']?></option>
            <?php } while($row_rsRecipes = mysql_fetch_assoc($rsRecipes));?>
          </select>
          <input name="submitRecipe" class="button" type="submit" value="edit this recipe">
          <!-- end selection--></div>
        <div class="selection">
          <label for="newRecipe">Add a new recipe</label>
          <input name="newRecipe" class="button" type="submit" value="add a new recipe">
        </div>
        <!-- end category--></div>
      <div id="category">
        <h2>Images</h2>
        <div class="selection">
          <label for="showImages">Show all images</label>
          <input name="showImages" class="button" type="submit" value="Show all images">
        </div>
        <div class="selection">
          <label for="newImage">Upload a new image</label>
          <input name="newImage" class="button" type="submit" value="Upload a new image">
        </div>
        <div class="selection">
          <label for="showVideos">Show all videos</label>
          <input name="showVideos" class="button" type="submit" value="Show all videos">
        </div>
        <div class="selection">
          <label for="newVideo">Upload a new video</label>
          <input name="newVideo" class="button" type="submit" value="Upload a new video">
        </div>
        <div class="selection">
          <label for="showThumbs">Show all thumbnail</label>
          <input name="showThumbs" class="button" type="submit" value="Show all thumbnails">
        </div>
        <div class="selection">
          <label for="newThumb">Upload a new thumbnail</label>
          <input name="newThumb" class="button" type="submit" value="Upload a new thumbnail">
        </div>
        <!-- end category--></div>
      <div id="category">&nbsp; 
        <!-- end category--></div>
    </fieldset>
  </form>
  <!-- end of container--></div>
</body>
</html>
