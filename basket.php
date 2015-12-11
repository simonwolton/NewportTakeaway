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
						$activeOrderArray = mysql_fetch_assoc($activeOrderQR);
						if ($activeOrderArray === FALSE) // If no basket is available...
						{
							mysql_query("INSERT INTO `orders` (userID) VALUES ('$_SESSION[loggedInUserID]');"); // Create one!
							$activeOrderQR = mysql_query("SELECT orderID  FROM `orders` WHERE userID = $_SESSION[loggedInUserID] AND date IS NULL;"); // Then get it's ID
							$activeOrderArray = mysql_fetch_array($activeOrderQR);
						}

						if ($_SERVER["REQUEST_METHOD"] == "POST") // If anything was posted here, do this...
						{
							$postInsertQR = mysql_query("INSERT INTO `orderitems` (orderID,itemID) VALUES ($activeOrderArray[orderID],$_POST[itemID]);");
							if ($postInsertQR === FALSE)
								echo "<br /><br /><br />No such item!<br /><br /><br />";
						}
						else if (isset($_GET['ID']))
						{
							$getInsertQR = mysql_query("INSERT INTO `orderitems` (orderID,itemID) VALUES ($activeOrderArray[orderID],$_GET[ID]);");
							if ($getInsertQR === FALSE)
								echo "<br /><br /><br />No such item!<br /><br /><br />";
						}	

						$allItemsQR = mysql_query("SELECT * FROM `orderitems` WHERE orderID = $activeOrderArray[orderID];"); // Get all items within the order.
						
						if ($allItemsQR === FALSE || mysql_num_rows($allItemsQR) == 0) // If query returned nothing...
							echo "Your basket is empty!<br />Want to visit the <a href='menu.php' style='text-decoration:underline;'>menu</a>?";
						else // If something returned, display it in a table recursively (all the items and their values)
						{
							echo "<table id=\"basicTable\" style=\"margin:0 auto;width:800px;\" >";
							echo "<tr>";
							echo "<th>Name</th>";	
							echo "<th>Description</th>";
							echo "<th style='width:100px;'>Price (&pound;)</th>";
							echo "<th>Options</th>";
							echo "</tr>";
							$totalPrice = 0.00;

							while($allItemsArray = mysql_fetch_assoc($allItemsQR))
							{
								$result = mysql_query("SELECT * FROM `items` WHERE itemID = $allItemsArray[itemID] ORDER BY itemName ASC;"); // Needs more queries!
								$row = mysql_fetch_assoc($result);
								echo "<tr>";
								echo "<td> " . $row["itemName"] . "</td>";
								echo "<td> " . $row["itemDescription"] . "</td>";
								echo "<td> " . number_format($row["itemPrice"],2) . "</td>";
								echo "<td> <a href='removefrombasket.php?ID=$row[itemID]'><img src=\"images/delete.png\" /></a></td>";
								echo "</tr>";
								$totalPrice += $row["itemPrice"];
							}
							echo "</table>";
							echo "<br />";
							echo "<div style='float:right;margin-right:55px;'>";
							echo "Total cost of your order: <span style='color:green;display:block;text-align:right;'>&pound;" .  number_format($totalPrice,2); // shows two decimal places
							echo "</span></div>";
							mysql_close($connection);

							echo '<form name="checkout" method="post" action="' . htmlspecialchars('checkout.php') .'">
								<div>
									<input type="hidden" id="orderID" name="orderID" value="' . $activeOrderArray["orderID"] . '"/>
									<input type="hidden" id="orderPrice" name="orderPrice" value="' . number_format($totalPrice,2) . '"/>
								</div>	
								<br />
								<div id="button">
									<input type="submit" value="Checkout" style="float:right;margin-right:40px;">
								</div>
							</form>';
						}
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
