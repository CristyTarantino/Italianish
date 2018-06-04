<?php require_once('../../../Connections/mctarant_assignment_2012.php'); ?>
<?php include("includes/cartSession.incl.php"); ?>
<?php include("includes/errorMessage.incl.php"); ?>
<?php if(isset($_POST['recipeID']))
		{			
			if( is_numeric($_POST['recipeID']) && $_POST['recipeID'] > 0){
				$cartSessionID = $_SESSION['cartSessionID'];
				$recipeID = $_POST['recipeID'];
				$recipeTitle = $_POST['recipeTitle'];
				$printedRecipe = 'N';
				
				if($_POST['printedRecipe'] == 'on')
					$printedRecipe = 'Y';
				
				$SQL = "INSERT INTO cartItems SET
						cartSessionID = '$cartSessionID',
						recipeID = '$recipeID',
						printedRecipe = '$printedRecipe',
						boxQty = '1'";
				
				mysql_select_db($database_mctarant_assignment_2012, $mctarant_assignment_2012);
				$result = mysql_query($SQL, $mctarant_assignment_2012) or die("An error has occurred. Please contact the webmaster. Thank you.");
				$added = "The " . $productTitle . " recipe box has been added to your shopping basket.";					
			}
			else{
				$error = $errorMessage;
			}
		}
?>
<?php if(isset($_GET['recipeID']))
		{	
			$recipeID = $_GET['recipeID'];
			$query_rsRecipes = "SELECT imageFile, recipeTitle, recipeDescription, recipePreparation, recipeIngredients, recipePrice, recipeID
								FROM recipes, images
								WHERE recipes.recipeID = '$recipeID'
								AND recipes.imageID = images.imageID";
			mysql_select_db($database_mctarant_assignment_2012, $mctarant_assignment_2012);
			$rsRecipes = mysql_query($query_rsRecipes, $mctarant_assignment_2012) or die("An error has occurred. Please contact the webmaster. Thank you.");			
			$row_rsRecipes = mysql_fetch_assoc($rsRecipes);
		}
		$query = "SELECT COUNT(*) as num FROM recipes, images WHERE recipes.imageID = images.imageID";
		$total_pages = mysql_fetch_array(mysql_query($query, $mctarant_assignment_2012));
		$total_pages = $total_pages[num];
?>
<?php
	mysql_select_db($database_mctarant_assignment_2012, $mctarant_assignment_2012);
	$query_rsThumbs = "SELECT * FROM recipes, thumbs 
								WHERE (recipes.recipeTitle = 'Tiramisu' 
								OR	recipes.recipeTitle = 'Spaghetti alla Carbonara'
								OR	recipes.recipeTitle = 'Salted Crepes')
								AND recipes.thumbID = thumbs.thumbID"; 
	$rsThumbs = mysql_query($query_rsThumbs, $mctarant_assignment_2012) or die("An error has occurred. Please contact the webmaster. Thank you."); 	
	$row_rsThumbs = mysql_fetch_assoc($rsThumbs);
?>
<?php include("includes/headerHTML.incl.php"); ?>
    <article>
      <div class="heading">
        <h1><?php echo $row_rsRecipes['recipeTitle'] ?></h1>
      </div>
      <div class="content">
        <div> <img src="./images/large/<?php echo $row_rsRecipes['imageFile']; ?>" width="300px" />
          <p><?php echo stripslashes(nl2br(stripslashes($row_rsRecipes['recipeDescription']))); ?></p>
        </div>
        <div>
          <h2>Ingredients</h2>
          <p><?php echo stripslashes(nl2br(stripslashes($row_rsRecipes['recipeIngredients']))); ?></p>
        </div>
        <div>
          <h2>Preparation</h2>
          <p><?php echo stripslashes(nl2br(stripslashes($row_rsRecipes['recipePreparation']))); ?></p>
        </div>
        <div>
          <div>
            <form action="" method="post">
              <!-- We need an hidden input because we will need the productID posted from the form -->
              <fieldset>
                <legend id="legendPrice"><?php echo 'Recipe Box Price: &pound;' .number_format($row_rsRecipes['recipePrice'], 2, '.', ','); ?></legend>
                <input type="hidden" name="recipeID" value="<?php echo $row_rsRecipes['recipeID']; ?>" />
                <input type="hidden" name="recipeTitle" value="<?php echo $row_rsRecipes['recipeTitle']; ?>" />
                <div class="buyButtonWrap">
                  <p class="buyButtons">
                    <input class="button buy" id="add" type="submit" value="add to shopping bag">
                  </p>
                  <p class="buyButtons">
                    <label class="printCheckBox" for="printedRecipe">Recipe Printed Version - Special Edition?</label>
                    <input class="printCheckBox" name="printedRecipe" id="checkbox" type="checkbox">
                  </p>
                </div>
              </fieldset>
            </form>
          </div>
        </div>
        <div id="itemFeedback">
          <p><?php echo $added; ?></p>
          <p class="errorMessages"><?php echo $error; ?></p>
        </div>
      </div>
      <div class="bottomNav">
        <?php 
				$url = htmlspecialchars($_SERVER['HTTP_REFERER']); 
				echo "<p class='back'><a class='button' href='$url'> &laquo;  Back</a></p>"; 
			?>
        <?php 
				$prevRecipe = $_GET['recipeID']; 
				if($prevRecipe > 1){
					$prevRecipe--;
					echo "<p class='prev'><a class='button' href='recipe.php?recipeID=$prevRecipe'> &laquo; Previous Recipe</a></p>";
				}
			?>
        &nbsp;
        <?php 
				$nextRecipe = $_GET['recipeID']; 
				if($nextRecipe < $total_pages){
					$nextRecipe++;
					echo "<p class='more'><a class='button' href='recipe.php?recipeID=$nextRecipe'>Next Recipe &raquo; </a></p>";
				}
			?>
      </div>
    </article>
    <?php include("includes/footerHTML.incl.php") ?>