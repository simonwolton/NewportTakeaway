<?php
session_start();
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

					if (isset($_SESSION['loggedInUserID']))
					{
						$UID = $_SESSION['loggedInUserID'];
						$connection = mysql_connect("exampleDBaddress", "exampleDBusername", "exampleDBpassword");
						mysql_select_db("newport_takeaway")or die("cannot select DB");

						$result = mysql_query("SELECT Admin FROM users WHERE UserID = '$UID'");

						$isAdmin = mysql_fetch_assoc($result);
					}


					$connection = mysql_connect("exampleDBaddress", "exampleDBusername", "exampleDBpassword");

					mysql_select_db("newport_takeaway")or die("No such database");
					$result = mysql_query("SELECT * FROM items ORDER BY itemName ASC");
					echo "<table id=\"basicTable\" style=\"margin:0 auto;width:800px;\" >";
					echo "<tr>";
					echo "<th>Name</th>";	
					echo "<th>Description</th>";
					echo "<th style='width:100px;'>Price (&pound;)</th>";
					if (isset($_SESSION['loggedInUserID']))
					{
						echo "<th>Add</th>";
						if (isset($isAdmin['Admin']) && ($isAdmin['Admin'] == 1))
						{	
							echo "<th>Edit</th>";
							echo "<th>Delete</th>";
						}
					}
					echo "</tr>";

					while($row = mysql_fetch_assoc($result))
					{
						echo "<tr onclick=\"window.location.href = 'item.php?ID=$row[itemID]';\">";
						echo "<td> " . $row["itemName"] . "</td>";
						echo "<td> " . $row["itemDescription"] . "</td>";
						echo "<td> <span style='color:green;display:block;text-align:right;'>" . number_format($row["itemPrice"],2) . "</span</td>";
						if (isset($_SESSION['loggedInUserID']))
						{
							echo "<td><a href='basket.php?ID=$row[itemID]'><img src=\"images/add.png\" /></a></td>";
							if (isset($isAdmin['Admin']) && ($isAdmin['Admin'] == 1))
							{	
								echo "<td><a href='editmenuitem.php?ID=$row[itemID]'><img src=\"images/edit.png\" /></a></td>";
								echo "<td><a href='deletemenuitem.php?ID=$row[itemID]'><img src=\"images/delete.png\" /></a></td>";
							}
						}
						echo "</tr>";
					}
					echo "</table>";

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
