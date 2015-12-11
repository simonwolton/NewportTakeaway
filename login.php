<?php
session_start();
if (isset($_SESSION['loggedInUserID']))
	die("You're already logged in!");
// define variables and set to empty values
$firstNameErr = $lastNameErr = $generalErr = $emailErr = $passwordErr = "";
$firstName = $lastName = $email = $password = "";
$validationPassed = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") // If anything was posted here, do this...
{
	$validationPassed = true;
	   
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
	/*if ($validationPassed == true)
	{
		echo "validation passed :)";
	}
	else
	{
		echo "validation didn't pass :(";
	}*/

	
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
if($validationPassed == true)
{
	
	$connection = mysql_connect("exampleDBaddress", "exampleDBusername", "exampleDBpassword");
	mysql_select_db("newport_takeaway")or die("cannot select DB");

	$result = mysql_query("SELECT UserID, FirstName,LastName,EmailAddr,Password FROM users WHERE EmailAddr = '$email' AND Password = '" . md5($password) . "'");
	
	if(mysql_num_rows($result) == 0)
		$generalErr = "<span style='color:red;'>Incorrect Username or Password</span>";
	else
	{
		$row = mysql_fetch_row($result);

		$_SESSION['loggedInUserID']=$row[0];
		header("Location:index.php" );
	}
}

$sendToSelf = htmlspecialchars($_SERVER["PHP_SELF"]);
$formContents = <<< EOPAGE
	<form name="loginForm" method="post" action="$sendToSelf"> 
		$generalErr
		<div class="align">
			<label for="email">E-mail:</label>
			<input class="inputalign" type="text" id="email" name="email" value="$email"/><span class="error">$emailErr</span>
		</div>
		<div class="align">
			<label for="password">Password:</label>
			<input class="inputalign" type="password" id="password" name="password"/><span class="error">$passwordErr</span>
		</div>
		<div id="button">
			<input type="submit" value="Login">
		</div>
	</form>
EOPAGE;
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
