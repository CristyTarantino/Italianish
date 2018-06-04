<!--------------Sidebar--------------->
</div>
	<div id="sidebar">
		<section>
			<div class="heading"><h2>Popular Post</h2></div>
			<div class="content">
            <?php do { ?>
				<div class="post">
					<img src="./images/thumbs/<?php echo $row_rsThumbs['thumbFile']; ?>" width="50px" height="50px" />
					<h4><a href="recipe.php?recipeID=<?php echo $row_rsThumbs['recipeID']; ?>"><?php echo stripslashes($row_rsThumbs['recipeTitle']); ?></a></h4>
				</div>
            <?php } while($row_rsThumbs = mysql_fetch_assoc($rsThumbs)); ?>
			</div>
		</section>
	</div>
	<div class="clear"></div>
</section>
<!--------------Footer--------------->
<footer>
	<p>Copyright © 2012 - <a href="http://www.mctarantino.com" target="_blank">M Cristina Tarantino</a></p>
</footer>
</body></html>