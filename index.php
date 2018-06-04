<?php require_once('../../../Connections/mctarant_assignment_2012.php'); ?>
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
<?php					
	// How many adjacent pages should be shown on each side?
	$adjacents = 3;
	/* 
	   First get total number of rows in data table. 
	   If you have a WHERE clause in your query, make sure you mirror it here.
	*/
	
	mysql_select_db($database_mctarant_assignment_2012, $mctarant_assignment_2012);

	$query = "SELECT COUNT(*) as num FROM recipes, images WHERE recipes.imageID = images.imageID";
	$total_pages = mysql_fetch_array(mysql_query($query, $mctarant_assignment_2012));
	$total_pages = $total_pages[num];
	
	/* Setup vars for query. */
	//your file name  (the name of this file)
	$targetpage = "index.php"; 	
	$limit = 2;
	
	//how many items to show per page
	$page = $_GET['page'];
	if($page) 
		$start = ($page - 1) * $limit; 			//first item to display on this page
	else
		$start = 0;								//if no page var is given, set start to 0
	
	/* Get data. */
	mysql_select_db($database_mctarant_assignment_2012, $mctarant_assignment_2012);

	$query_rsRecipes = "SELECT * FROM recipes, images WHERE recipes.imageID = images.imageID ORDER BY recipeID DESC LIMIT $start, $limit"; 
	 
	$rsRecipes = mysql_query($query_rsRecipes, $mctarant_assignment_2012) or die("An error has occurred. Please contact the webmaster. Thank you."); 
	
	$row_rsRecipes = mysql_fetch_assoc($rsRecipes);
	
	/* Setup page vars for display. */
	if ($page == 0) $page = 1;					//if no page var is given, default to 1.
	$prev = $page - 1;							//previous page is page - 1
	$next = $page + 1;							//next page is page + 1
	$lastpage = ceil($total_pages/$limit);		//lastpage is = total pages / items per page, rounded up.
	$lpm1 = $lastpage - 1;						//last page minus 1
	
	/* 
		Now we apply our rules and draw the pagination object. 
		We're actually saving the code to a variable in case we want to draw it more than once.
	*/
	$pagination = "";
	if($lastpage > 1)
	{	
		$pagination .= "<ul id=\"pagi\">";
		//previous button
		if ($page > 1) 
			$pagination.= "<li><a href=\"$targetpage?page=$prev\"> &laquo; previous</a></li>";
		else
			$pagination.= "<li><span class=\"disabled\"> &laquo; previous</span></li>";	
		
		//pages	
		if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
		{	
			for ($counter = 1; $counter <= $lastpage; $counter++)
			{
				if ($counter == $page)
					$pagination.= "<li><span class=\"current\">$counter</span></li>";
				else
					$pagination.= "<li><a href=\"$targetpage?page=$counter\">$counter</a></li>";					
			}
		}
		elseif($lastpage > 5 + ($adjacents * 2))	//enough pages to hide some
		{
			//close to beginning; only hide later pages
			if($page < 1 + ($adjacents * 2))		
			{
				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
				{
					if ($counter == $page)
						$pagination.= "<li><span class=\"current\">$counter</span></li>";
					else
						$pagination.= "<li><a href=\"$targetpage?page=$counter\">$counter</a></li>";					
				}
				$pagination.= "...";
				$pagination.= "<li><a href=\"$targetpage?page=$lpm1\">$lpm1</a></li>";
				$pagination.= "<li><a href=\"$targetpage?page=$lastpage\">$lastpage</a></li>";		
			}
			//in middle; hide some front and some back
			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
			{
				$pagination.= "<li><a href=\"$targetpage?page=1\">1</a></li>";
				$pagination.= "<li><a href=\"$targetpage?page=2\">2</a></li>";
				$pagination.= "...";
				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<li><span class=\"current\">$counter</span></li>";
					else
						$pagination.= "<li><a href=\"$targetpage?page=$counter\">$counter</a></li>";					
				}
				$pagination.= "...";
				$pagination.= "<li><a href=\"$targetpage?page=$lpm1\">$lpm1</a></li>";
				$pagination.= "<li><a href=\"$targetpage?page=$lastpage\">$lastpage</a></li>";		
			}
			//close to end; only hide early pages
			else
			{
				$pagination.= "<li><a href=\"$targetpage?page=1\">1</a></li>";
				$pagination.= "<li><a href=\"$targetpage?page=2\">2</a></li>";
				$pagination.= "...";
				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<li><span class=\"current\">$counter</span></li>";
					else
						$pagination.= "<li><a href=\"$targetpage?page=$counter\">$counter</a></li>";					
				}
			}
		}
		
		//next button
		if ($page < $counter - 1) 
			$pagination.= "<li><a href=\"$targetpage?page=$next\">next &raquo; </a></li>";
		else
			$pagination.= "<li><span class=\"disabled\">next &raquo; </span></li>";
		$pagination.= "</ul>\n";		
	}
?>
<?php include("includes/headerHTML.incl.php") ?>
    	<?php do{ ?>        
		<article>
			<div class="heading">
				<h2><a href="recipe.php?recipeID=<?php echo $row_rsRecipes['recipeID']; ?>"><?php echo stripslashes($row_rsRecipes['recipeTitle']); ?></a></h2>
			</div>
			<div class="content">
				<img src="./images/large/<?php echo $row_rsRecipes['imageFile']; ?>" width="300px" />
				<?php echo stripslashes($row_rsRecipes['recipeDescription']); ?>
				<p class="more"><a class="button" href="recipe.php?recipeID=<?php echo $row_rsRecipes['recipeID']; ?>">Read more</a></p>
			</div>
		</article>
        <?php } while($row_rsRecipes = mysql_fetch_assoc($rsRecipes)); ?>
			
		<section>
			<?php echo $pagination; ?>
		</section>
<?php include("includes/footerHTML.incl.php"); ?>