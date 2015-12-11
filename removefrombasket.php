<?php
session_start();
if (!isset($_SESSION['loggedInUserID']))
	die("You don't have permission to access this part of the site!");

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
				<div id="content" style="text-align:center;">
					<?php
					{
						$connection = mysql_connect("exampleDBaddress", "exampleDBusername", "exampleDBpassword");
						mysql_select_db("newport_takeaway")or die("cannot select DB");


						$activeOrderQR = mysql_query("SELECT orderID  FROM `orders` WHERE userID = $_SESSION[loggedInUserID] AND date IS NULL;"); // Get active order (aka the basket of the user)
						$activeOrder = mysql_fetch_array($activeOrderQR);
						
						if ($activeOrder == false) // If no basket is available...
						{
							mysql_query("INSERT INTO `orders` (userID) VALUES '($_SESSION[loggedInUserID])';"); // Create one!
							$activeOrderQR = mysql_query("SELECT orderID  FROM `orders` WHERE userID = $_SESSION[loggedInUserID] AND date IS NULL;"); // Then get it's ID
							$activeOrder = mysql_fetch_array($activeOrderQR);
						}
						// 
						if ($_GET)
						{
							echo '
							<form style="margin-top:50px;text-align:center;"name="addtobasket" method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) .'">
								<div class="align">
									<label for="itemID">Are you sure?</label>
									<input type="hidden" id="itemID" name="itemID" value="' . $_GET['ID'] . '"/>
								</div>
								<div id="button">
									<input type="submit" value="Remove"/>
								</div>

							</form>';
						}
						else if ($_SERVER["REQUEST_METHOD"] == "POST") 
						{
							mysql_query("DELETE FROM `orderitems` WHERE orderID = $activeOrder[orderID] AND itemID = $_POST[itemID] limit 1");  
							// removes first instance of the selected item from the basket
							if (mysql_affected_rows() == 0)
								echo "<div class='align'>That item isn't in your basket</div>"; // If no rows affected, display friendly error
							else
							{
								echo "<div class='align' style='color:green;'>Item deleted</div>";
								header( 'refresh:1;url=basket.php' );
							}
						}
						else   header( 'refresh:0;url=menu.php' );
												
					}
					
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
