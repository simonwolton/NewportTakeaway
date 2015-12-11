<?php
session_start();
if (isset($_SESSION['loggedInUserID']))
{
	$UID = $_SESSION['loggedInUserID'];
	$connection = mysql_connect("exampleDBaddress", "exampleDBusername", "exampleDBpassword");
	mysql_select_db("newport_takeaway")or die("cannot select DB");

	$result = mysql_query("SELECT Admin FROM users WHERE UserID = '$UID'");

	$row = mysql_fetch_assoc($result);

	if ($row['Admin'] == 0)
	{
		echo "You don't have permission to access this part of the site!";
		die;
	}
}
else if (!(isset($_SESSION['loggedInUserID'])))
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
					$connection = mysql_connect("exampleDBaddress", "exampleDBusername", "exampleDBpassword");
					mysql_select_db("newport_takeaway")or die("No such database");
					$allUsersQR = mysql_query("SELECT UserID,FirstName,LastName,AddressOne,AddressTwo,Postcode,EmailAddr,Admin FROM `users`");
					
					echo "<table id=\"basicTable\" style=\"margin:0 auto;width:800px;\" >";
					echo "<tr>";
					echo "<th>ID</th>";
					echo "<th>First Name</th>";	
					echo "<th>Last Name</th>";
					echo "<th>Address 1</th>";
					echo "<th>Address 2</th>";
					echo "<th>Postcode</th>";
					echo "<th>Email</th>";
					echo "<th>Make Admin</th>";
					echo "</tr>";

					while($user = mysql_fetch_array($allUsersQR))
					{
						echo "<tr>";
						echo "<td> " . $user["UserID"] . "</td>";
						echo "<td> " . $user["FirstName"] . "</td>";
						echo "<td> " . $user["LastName"] . "</td>";
						echo "<td> " . $user["AddressOne"] . "</td>";
						echo "<td> " . $user["AddressTwo"] . "</td>";
						echo "<td> " . $user["Postcode"] . "</td>";
						echo "<td> " . $user["EmailAddr"] . "</td>";
						echo "<td style='text-align:center;'>";
						if ($user["Admin"] == 0) echo "<a href='makeadmin.php?ID=$user[UserID]'><img src='images/add.png'/></a>";
						else echo "<a href='removeadmin.php?ID=$user[UserID]'><img src='images/delete.png'/></a>";
						echo "</td>";
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
