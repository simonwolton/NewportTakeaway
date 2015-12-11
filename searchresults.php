<?php
session_start();

include "colourapply.php";

function testInput($data)
{
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	$data = mysql_real_escape_string($data);
	return $data;
}
if ($_SERVER["REQUEST_METHOD"] == "POST") // If anything was posted here, do this...
{
	if (isset($_SESSION['loggedInUserID']))
	{
		$UID = $_SESSION['loggedInUserID'];
		$connection = mysql_connect("exampleDBaddress", "exampleDBusername", "exampleDBpassword");
		mysql_select_db("newport_takeaway")or die("cannot select DB");

		$result = mysql_query("SELECT Admin FROM users WHERE UserID = '$UID'");

		$isAdmin = mysql_fetch_assoc($result);
	}

	if (!(empty($_POST["searchBox"])))
	{
		$searchTerm = testInput($_POST["searchBox"]); // Use the testInput function below to strip any unwanted characters

		$connection = mysql_connect("exampleDBaddress", "exampleDBusername", "exampleDBpassword");
		mysql_select_db("newport_takeaway")or die("cannot select DB");

		$result = mysql_query("SELECT * FROM `items` WHERE itemName LIKE '%$searchTerm%' OR itemDescription LIKE '%$searchTerm%' ORDER BY itemName ASC;");
		
		$searchResults = "<table id=\"basicTable\" style=\"margin:0 auto;width:800px;\" >";
		$searchResults .= "<tr>";
		$searchResults .= "<th>Name</th>";	
		$searchResults .= "<th>Description</th>";
		$searchResults .= "<th>Price</th>";
		if (isset($_SESSION['loggedInUserID']))
		{
			$searchResults .= "<th>Add</th>";
			if (isset($isAdmin['Admin']) && ($isAdmin['Admin'] == 1))
			{	
				$searchResults .= "<th>Edit</th>";
				$searchResults .= "<th>Delete</th>";
			}
		}
	  	$searchResults .= "</tr>";

		while($row = mysql_fetch_array($result))
		{
			$searchResults .= "<tr onclick=\"window.location.href = 'item.php?ID=$row[itemID]';\">";
			$searchResults .= "<td> " . $row["itemName"] . "</td>";
			$searchResults .= "<td> " . $row["itemDescription"] . "</td>";
			$searchResults .= "<td> <span style='color:green;display:block;text-align:right;'>" . number_format($row["itemPrice"],2) . "</td>";
			if (isset($_SESSION['loggedInUserID']))
			{
				$searchResults .= "<td><a href='basket.php?ID=$row[itemID]'><img src=\"images/add.png\" /></a></td>";
				if (isset($isAdmin['Admin']) && ($isAdmin['Admin'] == 1))
				{	
					$searchResults .= "<td><a href='editmenuitem.php?ID=$row[itemID]'><img src=\"images/edit.png\" /></a></td>";
					$searchResults .= "<td><a href='deletemenuitem.php?ID=$row[itemID]'><img src=\"images/delete.png\" /></a></td>";
				}

			}
			$searchResults .= "</tr>";
		}
		$searchResults .= "</table>";
	}
	else 
		$searchResults = '<div style="text-align:center;">You did not search anything!<br /> <a style="text-decoration:underline;" href="index.php">Go home!</a></div>';
}
else 
	header("Location:index.php");
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
					<?php if(isset($searchResults))echo $searchResults; ?>
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
