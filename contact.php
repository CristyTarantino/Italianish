<?php require_once('../../../Connections/mctarant_assignment_2012.php'); ?>
<?php 
	if(isset($_GET['pageID']))
	  {
		$pageID = $_GET['pageID'];
		
		mysql_select_db($database_mctarant_assignment_2012, $mctarant_assignment_2012);
	
		$query_rsPages = "SELECT * FROM pages, images WHERE pageID = '$pageID' AND pages.imageID = images.imageID"; 
		 
		$rsPages = mysql_query($query_rsPages, $mctarant_assignment_2012) or die("An error has occurred. Please contact the webmaster. Thank you."); 
		
		$row_rsPages = mysql_fetch_assoc($rsPages);
	  }
?>
<?php include("includes/headerHTML.incl.php") ?>
<article id="fullsize">
			<div class="heading">
				<h1><?php echo $row_rsPages['pageTitle']; ?></h1>
			</div>
			<div class="content">
            	<div>
				<img src="./images/large/<?php echo $row_rsPages['imageFile']; ?>" width="300px" />
				<p><?php echo stripslashes(nl2br($row_rsPages['pageText'])); ?></p>
                </div>    
                <div id="formbox" class="comment">
		<section>
        <?php if($_SERVER['REQUEST_METHOD']=='GET') { ?>
			<form action="" method="post" name="contactForm">
            	<label for="name">*Name:</label>
                <input name="name" type="text" placeholder="name">
            	<label for="email">*Email:</label>
                <input name="email" type="text" placeholder="email address (required)">
                <textarea name="enquiry" placeholder="type your enquiry here and press the button below"></textarea>
                <input id="submit" name="submit" type="submit" value="Make contact">
            </form>
		<?php } else { ?>
        <?php 
			$error = 0;
			$name = addslashes(htmlentities($_POST['name']));
			$email = addslashes(htmlentities($_POST['email']));
			$enquiry = addslashes(htmlentities($_POST['enquiry']));		
			
			/* explode splits the string into an array using the regulat ezpression of @
			 * to decide where to make the split. The array is then assigning variable names to the two parts of the array.
			 * The function checkdnsrr() checks, via the internet, what the DNS settings are
			 * for the domain represented by the variable $mailDomain.
			 * If one of those settings is MX that means that a mail exchange facility is present
			 * on that domain and the'if' return TRUE, if thee is no MX then the 'if' returns FALSE.
			 */
			if(strlen($email) == 0 || $email == NULL || empty($email)){
				$error++;
				$emailPresent = 'False';
			}
			else{
				$emailPresent = 'True';
				
				$tempEmail = $email;
				
				list($userName, $mailDomain) = split("@", $tempEmail);
				if(checkdnsrr($mailDomain, "MX")){
					$emailValid = 'True';
				}
				else
				{
					$error++;
					$emailValid = 'False';
				};
			};
			
			if(strlen($name) == 0 || $name == NULL || empty($name)){
				$error++;
				$namePresent = 'False';
			}
			else{
				$namePresent = 'True';
			};
			
			if(strlen($enquiry) == 0 || $enquiry == NULL || empty($enquiry)){
				$error++;
				$enquiryPresent = 'False';
			}
			else{
				$enquiryPresent = 'True';
			};
		 ?>
            <form action="" method="post" name="contactForm">
            <?php
					if($error == 0){
						echo "<p>Thank you for your enquiry, we shall be in contact very shortly.</p>";
						include("includes/sendMail2Recipesjack.incl.php");
						include("includes/sendMail2Visitor.incl.php");		
					}
					else
					{
						$errorMessage = "<p class=\"errorText\">";						
						
						if($emailPresent == 'False' || $emailValid == 'False')		
							$errorMessage = $errorMessage . 'Please enter a <b>valid email address</b> so that I may contact you.<br/>';						
						
						if($namePresent == 'False')
							$errorMessage = $errorMessage . 'Please enter your <b>Full Name</b>.<br/>';	
								
						if($enquiryPresent == 'False')
							$errorMessage = $errorMessage . 'Please enter a message so I can answer to your enquiry.<br/>';	
						
						$errorMessage = $errorMessage . '</p><br />';
							
						echo $errorMessage;
					}
			?>
            	<label for="name">*Name:</label>
                <input name="name" type="text" placeholder="Please enter your name" value="<?php echo stripslashes(html_entity_decode(stripslashes($name))) ?>">
            	<label for="email">*Email:</label>
                <input name="email" type="text" placeholder="Please enter your email address" value="<?php echo stripslashes(html_entity_decode(stripslashes($email))) ?>">
                <textarea name="enquiry" placeholder="Please type your enquiry here and press the button below"><?php echo stripslashes(html_entity_decode(stripslashes($enquiry))) ?></textarea>
                <?php if($error != 0) { ?>
                <input id="submit" name="submit" type="submit" value="Make contact">
                <?php } ?>
            </form>
		<?php }; ?>
        <!-- end of contactForm--></section>
	</div>
            </div>
		</article>	
</div>
	<div class="clear"></div>
</section>        
<?php include("includes/simpleFooterHTML.incl.php") ?>