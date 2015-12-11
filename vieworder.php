<?php
session_start();
if (isset($_SESSION['loggedInUserID']))
{
	$UID = $_SESSION['loggedInUserID'];
	$connection = mysql_connect("exampleDBaddress", "exampleDBusername", "exampleDBpassword");
	mysql_select_db("newport_takeaway")or die("cannot select DB");

	$result = mysql_query("SELECT Admin FROM users WHERE UserID = '$UID'");

	$row = mysql_fetch_assoc($result);

	if ($row['Admin'] == 1)
		$isAdmin = true;
	else $isAdmin = false;
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
					if (isset($_GET['ID']) && isset($isAdmin))
					{
						$connection = mysql_connect("exampleDBaddress", "exampleDBusername", "exampleDBpassword");
						mysql_select_db("newport_takeaway")or die("No such database");
						$isYouQR = mysql_query("SELECT userID,orderPrice FROM `orders` WHERE orderID = $_GET[ID]");
						$isYou = mysql_fetch_assoc($isYouQR);
						if ($isAdmin == true || $isYou['userID'] == $_SESSION['loggedInUserID'])
						{
							$allItemsQR = mysql_query("SELECT * FROM `orderitems` WHERE orderID = $_GET[ID]");
							if (!(mysql_num_rows($allItemsQR) == 0))
							{
								echo "<table id=\"basicTable\" style=\"margin:0 auto;width:800px;\" >";
								echo "<tr>";
								echo "<th>Name</th>";	
								echo "<th>Description</th>";
								echo "<th style='width:100px;'>Price (&pound;)</th>";
								echo "</tr>";
								$totalPrice = 0.00;

								while($allItemsArray = mysql_fetch_assoc($allItemsQR))
								{
									$result = mysql_query("SELECT * FROM `items` WHERE itemID = $allItemsArray[itemID] ORDER BY itemName ASC;"); // Needs more queries!
									$row = mysql_fetch_assoc($result);
									echo "<tr>";
									echo "<td> " . $row["itemName"] . "</td>";
									echo "<td> " . $row["itemDescription"] . "</td>";
									echo "<td> <span style='color:green;display:block;text-align:right;'>" . number_format($row["itemPrice"],2) . "</td>";
									echo "</tr>";
									$totalPrice += floatval($row["itemPrice"]);
								}
								echo "</table>";
								echo "<br />";
								echo "<div style='float:right;margin-right:55px;'>";
								echo "Total cost of the order: <span style='color:green;'>&pound;";
								if (!($isYou['orderPrice']  == false))
									echo $isYou['orderPrice'];
								else echo number_format($totalPrice,2); // shows two decimal places
								echo "</span></div>";
							}
							else echo "Order not found";
							
						}
						else echo "Order not found";
						
					}
					else echo "You can't do that!";
					

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
