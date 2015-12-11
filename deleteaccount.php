<?php
session_start();
if (!(isset($_SESSION['loggedInUserID'])))
{
	echo "You don't have permission to access this part of the site!";
	die;
}

include "colourapply.php";
?>
<!DOCTYPE html>
<html>
	<head>
		<?php
    		echo '<link rel="shortcut icon" href="images/favicon.ico?t=' . time() . '" />';
    		echo '<link href="styles/style.css?t=' . time() . '" rel="stylesheet" type="text/css">';
		?>
		<script src="javascript/javascript.js"></script>
		<title>Newport Takeaway</title>
		<style>
		
		#main{position:relative;}
		h3
		{
			top: 20px;
			width: 100%;
			margin:0 auto;
			text-align: center;
		}
		.centeredContent
		{
			position: relative;
			margin: 0 auto;
			text-decoration:underline;
			width:40%;
			text-align: center;

		}
		.centeredContent img
		{
			vertical-align: middle;
			margin-right:10px;
		}
		<?php 
		if(isset($CSSbody))
		{
			echo $CSSbody;
			echo $CSScontent;
			echo $CSSsearch;
			echo $CSSfooters;
			echo $CSSproducts;
		}
		?>
		</style>
	</head>
	<body>

		<div id="wrapper">
			<div id="header">
				<a href="index.php"><div id="logo"><img src="images/logo.png" alt="logo" style="border:none;"> <!--IE fix-->
					<span id="logotext">NewportTakeaway</span>
				</div></a>
				<div id="search">
					<div id="centeraligned">
						<?php
						include "header.php";
						?>
						
						<span id="whiteText">Change colour scheme:</span><br />
						<a href=javascript:void(0) onClick="colourChange('75C7E0','blue')"><div class="colorChangeButtons" id="blue"></div></a>
						<a href=javascript:void(0) onClick="colourChange('E07582','red')"><div class="colorChangeButtons" id="red"></div></a>
						<a href=javascript:void(0) onClick="colourChange('75E093','green')"><div class="colorChangeButtons" id="green"></div></a>
						<a href=javascript:void(0) onClick="colourChange('E0A475','orange')"><div class="colorChangeButtons" id="orange"></div></a>
						<a href=javascript:void(0) onClick="colourChange('BAE075','lime')"><div class="colorChangeButtons" id="lime"></div></a>
						<a href=javascript:void(0) onClick="colourChange('8675E0','purple')"><div class="colorChangeButtons" id="purple"></div></a>
						<a href=javascript:void(0) onClick="defaultify()"><div class="colorChangeButtons" id="default" style="background-color:#596772;"></div></a>
					</div>
					<form name="searchForm" method="post" action="<?php echo htmlspecialchars('searchresults.php');?>">
						<input type="text" name="searchBox"><input type="submit" value="Search">
					</form>
				</div>
				<?php include "navbar.php"; ?>
			</div>
			<div id="main">
				<div id="content">
					<?php

					if ($isAdmin == false)
					{
						if (!($_SERVER["REQUEST_METHOD"] == "POST"))
						echo '<form name="deleteAccountForm" class="centeredContent" style="text-decoration:none;margin-top:200px"method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '">
								<input type="hidden" id="userID" name="userID" value="$_SESSION[loggedInUserID]"/>
								Are you sure you want delete your account?<br />This cannot be undone!
								<div id="button">
									<input type="submit" value="Delete account">
								</div>
							</form>';
						else
						{
							mysql_query("DELETE FROM `users` WHERE UserID = $_SESSION[loggedInUserID]");
							$_SESSION['loggedInUserID'] = "";
							header( "refresh:2;url=index.php" );
							session_destroy();
							echo "You account has been deleted Bye-bye!";
						}
					}
					else echo "<div class='centeredContent' style='text-decoration:none;'>An admin cannot delete their own account! <br />
						This is to protect against a scenario whereby the system has no administrators.
						<br />You may create an account, promote it to admin, then use it to delete this one.</div>";

					
					?>
				</div>
				<div id="footer">
					<div id="footerleft">
						<strong>Customer Services</strong>
						<p><a href="help.php">Help</a><br />
						<a href="contact.php">Contact us</a><br />
						<a href="sitemap.php">Sitemap</a></p>
					</div>
					<div id="footermiddle">
						<strong>Corporate Info</strong>
						<p><a href="index.php">Home</a><br />
						<a href="index.php">About us</a></p>
					</div>
					<div id="footerright">
						<strong>Policies</strong>
						<p><a href="terms.php">Terms and Conditions</a><br />
						<a href="faq.php">FAQ</a></p>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
