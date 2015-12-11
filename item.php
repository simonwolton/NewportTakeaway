<?php
session_start();
include "colourapply.php";
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
		.flashyhr 
		{
		    border: 0;
		    height: 1px;
		    background-image: -webkit-linear-gradient(left, rgba(0,0,0,0), rgba(0,0,0,0.75), rgba(0,0,0,0)); 
		    background-image:    -moz-linear-gradient(left, rgba(0,0,0,0), rgba(0,0,0,0.75), rgba(0,0,0,0)); 
		    background-image:     -ms-linear-gradient(left, rgba(0,0,0,0), rgba(0,0,0,0.75), rgba(0,0,0,0)); 
		    background-image:      -o-linear-gradient(left, rgba(0,0,0,0), rgba(0,0,0,0.75), rgba(0,0,0,0)); 
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
				<div id="content" style="width:90%">
					<?php

					if (!($_GET))
						echo "An error occured, which item were you looking for? Why not visit the menu?";
					else
					{
						$connection = mysql_connect("exampleDBaddress", "exampleDBusername", "exampleDBpassword");
						mysql_select_db("newport_takeaway")or die("cannot select DB");
						$result = mysql_query("SELECT * FROM items WHERE itemID = '" . $_GET['ID'] . "' ");
						$row = mysql_fetch_assoc($result);
						mysql_close($connection);
						if (!($row === FALSE))
						{
							echo "<div><h2>$row[itemName]</h2>";
							if (isset($isAdmin) && $isAdmin == true)
							{
								echo "<a href='deletemenuitem.php?ID=$row[itemID]' style='float:right;'><img src=\"images/delete.png\" /></a>";
								echo "<a href='editmenuitem.php?ID=$row[itemID]'style='float:right;'><img src=\"images/edit.png\" /></a>";
							}
								
							echo "</div>";
							echo "<hr class='flashyhr' style='width:35%;float:left;'><br />";
							echo "<p><div style='width:90%;'>$row[itemDescription]</p></div>";
							echo "<span style='float:right;color:green;'>&pound; " . number_format($row['itemPrice'],2) . "</span><br />";
							
							if (isset($_SESSION['loggedInUserID']))
							{
								echo '
								<form name="addtobasket" method="post" action="basket.php">
									<input type="hidden" id="itemID" name="itemID" value="' . $row['itemID'] . '"/>
									<div id="button">
										<input type="submit" value="Add to Basket" style="float:right;"/>
									</div>
								</form>';
							}
						}
						else echo "Item not found!";					
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
