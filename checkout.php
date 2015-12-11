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
		/* Gradient transparent - color - transparent */
		
		.flashyhr 
		{
		    border: 0;
		    height: 1px;
		    background-image: -webkit-linear-gradient(left, rgba(0,0,0,0), rgba(0,0,0,0.75), rgba(0,0,0,0)); 
		    background-image:    -moz-linear-gradient(left, rgba(0,0,0,0), rgba(0,0,0,0.75), rgba(0,0,0,0)); 
		    background-image:     -ms-linear-gradient(left, rgba(0,0,0,0), rgba(0,0,0,0.75), rgba(0,0,0,0)); 
		    background-image:      -o-linear-gradient(left, rgba(0,0,0,0), rgba(0,0,0,0.75), rgba(0,0,0,0)); 
		}

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

						if ($_SERVER["REQUEST_METHOD"] == "POST") // If anything was posted here, do this...
						{
							$result = mysql_query("SELECT FirstName,LastName,EmailAddr,AddressOne,AddressTwo,Postcode FROM users WHERE UserID = $_SESSION[loggedInUserID]");
							echo "<h2>Invoice</h2><hr class='flashyhr'><br />";
							while($row = mysql_fetch_assoc($result))
							{
								echo "<table style='width:70%;margin:0 auto;'>";
								echo "<tr><td>Name:</td> <td>$row[FirstName] $row[LastName]</td></tr>";
								echo "<tr><td>Address line 1:</td> <td>$row[AddressOne]</td></tr>";
								echo "<tr><td>Address line 2:</td> <td>$row[AddressTwo]</td></tr>";
								echo "<tr><td>Postcode:</td> <td>$row[Postcode]</td></tr>";
								echo "<tr><td>Contact Email:</td> <td>$row[EmailAddr]</td></tr>";
								echo "</table><br /><br />";
								$allItems = mysql_query("SELECT * FROM `orderitems` WHERE orderID = $_POST[orderID];"); // Get all items within the order.
								if (mysql_num_rows($allItems) == 0) // If query returned nothing...
									echo "Your basket is empty!<br />Want to visit the <a href='menu.php' style='text-decoration:underline;'>menu</a>?";
								else // If something returned, display it in a table recursively (all the items and their values)
								{
									echo "<table id=\"basicTable\" style=\"margin:0 auto;width:70%;\" >";
									echo "<tr>";
									echo "<th>Name</th>";	
									echo "<th>Description</th>";
									echo "<th style='width:100px;'>Price (&pound;)</th>";
									echo "</tr>";
									$totalPrice = 0.00;

									while($row2 = mysql_fetch_assoc($allItems))
									{
										$result3 = mysql_query("SELECT * FROM `items` WHERE itemID = $row2[itemID] ORDER BY itemName ASC;"); // Needs more queries!
										$row3 = mysql_fetch_assoc($result3);
										echo "<tr>";
										echo "<td> " . $row3["itemName"] . "</td>";
										echo "<td> " . $row3["itemDescription"] . "</td>";
										echo "<td> " . number_format($row3["itemPrice"],2) . "</td>";
										echo "</tr>";

									}
									echo "</table>";
									echo "<br />";
									echo "<div style='float:right;margin-right:140px;'>";
									echo "Total cost of your order: <span style='color:green;display:block;text-align:right;'>&pound;" .  number_format($_POST['orderPrice'],2); // shows two decimal places
									echo "</span></div>";
									mysql_close($connection);

									echo '<form name="thankyou" method="post" action="' . htmlspecialchars('thankyou.php') .'">
										<div>
											<input type="hidden" id="orderID" name="orderID" value="' . $_POST['orderID'] . '"/>
											<input type="hidden" id="orderPrice" name="orderPrice" value="' . number_format($_POST['orderPrice'],2) . '"/>

										</div>	
										<br />
										<div id="button">
											<input type="submit" value="Submit Order" style="float:right;margin-right:130px;">
										</div>
									</form>';
								}							
							}
							
						}
						else echo "An error occurred, didn't you click the checkout button?";
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
