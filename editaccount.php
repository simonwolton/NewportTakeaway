<?php
session_start();
if (!(isset($_SESSION['loggedInUserID'])))
{
	die("You must be logged in to do that!");
}
// define variables and set to empty values
$firstNameErr = $lastNameErr = $emailErr = $passwordErr = $passwordReentryErr = $addressOneErr = $addressTwoErr = $postcodeErr = "";

$connection = mysql_connect("exampleDBaddress", "exampleDBusername", "exampleDBpassword"); // Connect to the database
mysql_select_db("newport_takeaway");
$userDataQR = mysql_query("SELECT * FROM users WHERE UserID = '$_SESSION[loggedInUserID])'");
mysql_close($connection);
while ($userDataArray = mysql_fetch_assoc($userDataQR))
{
	$firstName = $userDataArray['FirstName'];
	$lastName = $userDataArray['LastName'];
	$email = $userDataArray['EmailAddr'];
	$password = $userDataArray['Password'];
	$addressOne = $userDataArray['AddressOne'];
	$addressTwo = $userDataArray['AddressTwo'];
	$postcode = $userDataArray['Postcode'];
}

$validationPassed = false;
function testInput($data)
{
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	$data = mysql_real_escape_string($data);
	return $data;
}

function validate($postItem,$fName,$regex,$message)
{
	var_dump($_POST);
	if (empty($_POST[$postItem]) || $_POST[$postItem] == " ") // Check if the posted name is empty, or is just a space
	{
		$validationPassed = false;
		return $fName . " is required"; // If so, error
	}
	else
	{
		$data = testInput($_POST[$postItem]);
		if (!(preg_match($regex, $data)))
		{
			$validationPassed = false;
			return $message;
		}
		preg_replace("/\s{2,}/", " ", $_POST[$postItem]); //replace multiple spaces with a single space
		return $data;
	}
}
if ($_SERVER["REQUEST_METHOD"] == "POST") // If anything was posted here, do this...
{

	$validationPassed = true;
	if (empty($_POST["firstName"]) || $_POST["firstName"] == " ") // Check if the posted name is empty, or is just a space
	{
		$firstNameErr = "First name is required"; // If so, error
		$validationPassed = false;
	}	
	else
	{
		$firstName = testInput($_POST["firstName"]); // Use the testInput function below to strip any unwanted characters
		if (!preg_match("/^[a-zA-Z ]*$/",$firstName))	// check if name only contains letters and whitespace
		{
			$firstNameErr = "Only letters and white space allowed"; 
			$validationPassed = false;
		}
		preg_replace("/\s{2,}/", " ", $_POST["firstName"]); //replace multiple spaces with a single space
	}
	if (empty($_POST["lastName"]) || $_POST["lastName"] == " ") // Check if the posted name is empty, or is just a space
	{
		$lastNameErr = "Last name is required"; // If so, error
		$validationPassed = false;
	}	
	else
	{
		$lastName = testInput($_POST["lastName"]); // Use the testInput function below to strip any unwanted characters
		if (!preg_match("/^[a-zA-Z ]*$/",$lastName))	// check if name only contains letters and whitespace
		{
			$lastNameErr = "Only letters and white space allowed"; 
			$validationPassed = false;
		}
		preg_replace("/\s{2,}/", " ", $_POST["lastName"]); //replace multiple spaces with a single space
	}
	if (empty($_POST["email"]))
	{
		$emailErr = "Email is required";
		$validationPassed = false;
	}
	else
	{
		$email = testInput($_POST["email"]);
		// check if e-email address syntax is valid
		if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$email))
		{
			$emailErr = "Invalid email format"; 
			$validationPassed = false;
		}
	}
	if (empty($_POST["password"]))
	{
		$passwordErr = "Password is required";
		$validationPassed = false;
	}
	else
	{
		$password = testInput($_POST["password"]);
	}

	if (empty($_POST["addressOne"]) || $_POST["addressOne"] == " ") // Check if the posted name is empty, or is just a space
	{
		$addressOneErr = "Address is required"; // If so, error
		$validationPassed = false;
	}	
	else
	{
		$addressOne = testInput($_POST["addressOne"]); // Use the testInput function below to strip any unwanted characters
		if (!preg_match("/^[0-9a-zA-Z\,\. ]*$/",$addressOne))	// check if name only contains letters and whitespace
		{
			$addressOneErr = "Invalid address format."; 
			$validationPassed = false;
		}
		preg_replace("/\s{2,}/", " ", $_POST["addressOne"]); //replace multiple spaces with a single space
	}
	if (empty($_POST["addressTwo"]) || $_POST["addressTwo"] == " ") // Check if the posted name is empty, or is just a space
	{
		$addressTwoErr = "Address is required"; // If so, error
		$validationPassed = false;
	}	
	else
	{
		$addressTwo = testInput($_POST["addressTwo"]); // Use the testInput function below to strip any unwanted characters
		if (!preg_match("/^[0-9a-zA-Z\,\. ]*$/",$addressTwo))	// check if name only contains letters and whitespace
		{
			$addressTwoErr = "Invalid address format."; 
			$validationPassed = false;
		}
		preg_replace("/\s{2,}/", " ", $_POST["addressTwo"]); //replace multiple spaces with a single space
	}
	if (empty($_POST["postcode"]) || $_POST["postcode"] == " ") // Check if the posted name is empty, or is just a space
	{
		$postcodeErr = "Postcode is required"; // If so, error
		$validationPassed = false;
	}	
	else
	{
		$postcode = testInput($_POST["postcode"]); // Use the testInput function below to strip any unwanted characters
		$postcode = strtoupper($postcode);
		if (!preg_match("/^[A-Z]{1,2}[0-9][0-9A-Z]? ?[0-9][A-Z]{2}$/",$postcode))	// check if name only contains letters and whitespace
		{
			$postcodeErr = "Invalid postcode format"; 
			$validationPassed = false;
		}
		preg_replace("/\s{2,}/", " ", $_POST["postcode"]); //replace multiple spaces with a single space
	}
	/*if (empty($_POST["passwordReentry"]))
	{
		$passwordErr = "Re-Enter your password";
		$validationPassed = false;
	}
	else
	{
		$passwordReentry = testInput($_POST["passwordReentry"]);
		if (!($password == $passwordReentry))
		{
			$passwordReentryErr = "Passwords do not match!";
			$validationPassed = false;
		}
		else
		{
			$validationPassed = true;
		}
	}*/

	if ($validationPassed == true)
	{
		$connection = mysql_connect("exampleDBaddress", "exampleDBusername", "exampleDBpassword"); // Connect to the database
		mysql_select_db("newport_takeaway");
		mysql_query("UPDATE `users` SET 
			FirstName = '" . $firstName . "',
			LastName = '" . $lastName . "',
			EmailAddr = '" . $email . "',
			Password = '" . md5($password) . "',
			AddressOne = '" . $addressOne . "',
			AddressTwo = '" . $addressTwo . "',
			Postcode = '" . $postcode . "' WHERE UserID = $_SESSION[loggedInUserID]");		
		mysql_close($connection);
		$formContents = "<span style='color:green;'>Info updated!</span>";
		header( "refresh:1;url=account.php" );
	}

	include "colourapply.php";
}
if (!($validationPassed == true))
{
$sendToSelf = htmlspecialchars($_SERVER["PHP_SELF"]);
$formContents = <<< EOPAGE
	<form name="accountForm" method="post" action="$sendToSelf"> 
		<div class="align">
			<label for="firstName">First Name:</label>
			<input class="inputalign" type="text" id="firstName" name="firstName" value="$firstName"/><span class="error">$firstNameErr</span><br />
		
		<div class="align">
			<label for="lastName">Last Name:</label>
			<input class="inputalign" type="text" id="lastName" name="lastName" value="$lastName"/><span class="error">$lastNameErr</span>
		</div>
		<div class="align">
			<label for="email">E-mail:</label>
			<input class="inputalign" type="text" id="email" name="email" value="$email"/><span class="error">$emailErr</span>
		</div>
		<div class="align">
			<label for="password">Password:</label>
			<input class="inputalign" type="password" id="password" name="password" /><span class="error">$passwordErr</span>
		</div>
		<div class="align">
			<label for="addressOne">Address Line 1:</label>
			<input class="inputalign" type="addressOne" id="addressOne" name="addressOne" value="$addressOne"/><span class="error">$addressOneErr</span>
		</div>
		<div class="align">
			<label for="addressTwo">Address Line 2:</label>
			<input class="inputalign" type="addressTwo" id="addressTwo" name="addressTwo" value="$addressTwo"/><span class="error">$addressTwoErr</span>
		</div>
		<div class="align">
			<label for="postcode">Postcode:</label>
			<input class="inputalign" type="postcode" id="postcode" name="postcode" value="$postcode"/><span class="error">$postcodeErr</span>
		</div>
		<div id="button">
			<input type="submit" value="Edit Account">
		</div>
	</form>
EOPAGE;
}

?>
<!DOCTYPE html>
<html>
	<head>
		
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
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
		
		
		form div + div{margin-top: .5em;}
		label 
		{
			display: inline-block;
			width: 90px;
			text-align: right;
		}
		.inputalign{width: 200px;}
		p#address
		{
			padding-left:95px;
		}
		#button{padding-left: 90px;}
		textarea
		{
			height:60px;
			width:198px;
		}
		#password{margin-left:0px;}
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
		<script>
		function test()
		{

			if(document.getElementById("scts").checked)
			{
	  			document.getElementById('sctsHidden').disabled = true;
			}
			alert(document.getElementById("scts").checked);
		}
		</script>
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
