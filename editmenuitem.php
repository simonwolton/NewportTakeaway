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

$generalErr = $itemNameErr = $itemDescriptionErr = $itemPriceErr = "";
$itemName = $itemDescription = $itemPrice = "";
$validationPassed = true;
$done = false;




if ($_SERVER["REQUEST_METHOD"] == "POST") // If anything was posted here, do this...
{
	$decimalNumberRegex = "/^[0-9]+\.?[0-9]{0,2}$/";
	$stringRegex = "/^[a-zA-Z ,\.\"\']+$/";

	$itemID = $_POST["itemID"];
	$itemName = $_POST["itemName"];
	$itemDescription = $_POST["itemDescription"];
	$itemPrice = $_POST["itemPrice"];

	if (empty($itemName) || $itemName == " ") // Check if the posted name is empty, or is just a space
	{
		$itemNameErr = "Item name is required"; // If so, error
		$validationPassed = false;
	}	
	else
	{
		$itemName = testInput($itemName); // Use the testInput function below to strip any unwanted characters
		if (!preg_match($stringRegex,$itemName))	// check if name only contains letters and whitespace
		{
			$itemNameErr = "Only text, whitespace and quotes!"; 
			$validationPassed = false;
		}
		preg_replace("/\s{2,}/", " ", $itemName); //replace multiple spaces with a single space
	}
	if (empty($itemDescription) || $itemDescription == " ") // Check if the posted name is empty, or is just a space
	{
		$itemDescriptionErr = "Item description is required"; // If so, error
		$validationPassed = false;
	}	
	else
	{
		$itemDescription = testInput($itemDescription);
		if (!preg_match($stringRegex,$itemDescription))
		{
			$itemDescriptionErr = "Only text, whitespace and quotes!";
			$validationPassed = false;
		}
		preg_replace("/\s{2,}/", " ", $itemDescription);
	}
	if (empty($itemPrice) || $itemPrice == " ")
	{
		$itemPriceErr = "Item price is required"; // If so, error
		$validationPassed = false;
	}	
	else
	{
		$itemPrice = testInput($itemPrice);
		if (!preg_match($decimalNumberRegex,$itemPrice))
		{
			$itemPriceErr = "Incorrect format!"; 
			$validationPassed = false;
		}
		preg_replace("/\s{2,}/", " ", $itemPrice);
	}
	if($validationPassed == true)
	{
		$connection = mysql_connect("exampleDBaddress", "exampleDBusername", "exampleDBpassword");
		mysql_select_db("newport_takeaway")or die("cannot select DB");
		$result = mysql_query("UPDATE items SET itemName='" . $itemName . "',itemDescription='" . $itemDescription . "',itemPrice='" . $itemPrice . "' WHERE itemID='" . $itemID . "';");
		mysql_close($connection);
		$done = true;
	}
}
else if (isset($_GET['ID']))
{
	$ID = $_GET["ID"];
	$connection = mysql_connect("exampleDBaddress", "exampleDBusername", "exampleDBpassword");
	mysql_select_db("newport_takeaway")or die("cannot select DB");
	$result = mysql_query("SELECT * FROM items WHERE itemID = '$ID'");
	$row = mysql_fetch_assoc($result);
	if ($row === FALSE)
		die("No such item ID!");
	else
	{
		$itemID = $row['itemID'];
		$itemName = $row['itemName'];
		$itemDescription = $row['itemDescription'];
		$itemPrice = $row['itemPrice'];	
	}	
}
else
{
	if (!isset($_GET['ID']))
	{
		die("You need to use an ID!");
	}
}

include "colourapply.php";

function testInput($data)
{
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	$data = mysql_real_escape_string($data);
	return $data;
}
if ($done == true)
{
	$formContents = "<span style=\"margin-left:95px;color:green;\">Menu item edited!</span>";
	header( "refresh:2;url=menu.php" );
}
else
{
$sendToSelf = htmlspecialchars($_SERVER["PHP_SELF"]);
$formContents = <<< EOPAGE
	<form name="editMenuItemForm" method="post" action="$sendToSelf"> 
		$generalErr
		<input class="inputalign" type="hidden" id="itemID" name="itemID" value="$itemID"/>
		<div class="align">
			<label for="itemName">Item Name:</label>
			<input class="inputalign" type="text" id="itemName" name="itemName" value="$itemName"/><span class="error">$itemNameErr</span>
		</div>
		<div class="align">
			<label for="itemDescription">Item Description:</label>
			<textarea class="inputalign" type="itemDescription" id="itemDescription" name="itemDescription" style="width:300px;height:100px;">$itemDescription</textarea><span class="error">$itemDescriptionErr</span>
		</div>
		<div class="align">
			<label for="itemPrice">Item Price:</label>
			<input class="inputalign" type="itemPrice" id="itemPrice" name="itemPrice" value="$itemPrice" style="width:50px;"/><span class="error">$itemPriceErr</span>
		</div>

		<div id="button">
			<input type="submit" value="Edit Item">
		</div>
	</form>
EOPAGE;
}


?>
<!DOCTYPE html>
<html>
	<head>
		<link href="styles/style.css" rel="stylesheet" type="text/css">
		<?php
    		echo '<link rel="shortcut icon" href="images/favicon.ico?t=' . time() . '" />';
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
		.error {color: #FF0000; padding-left:5px;}
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
				<div id="content" style="text-align: center;padding-top: 30px;min-height:200px;">
					<?php echo $formContents ?>
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
