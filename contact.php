<?php

session_start();
// define variables and set to empty values
$nameErr = $emailErr = $enquiryErr = "";
$name = $email = $enquiry = "";
$scts = $mailSent = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") // If anything was posted here, do this...
{
	$validationPassed = true;
	if (empty($_POST["name"]) || $_POST["name"] == " ") // Check if the posted name is empty, or is just a space
	{
		$nameErr = "Name is required"; // If so, error
		$validationPassed = false;
	}	
	else
	{
		$name = testInput($_POST["name"]); // Use the testInput function below to strip any unwanted characters
		if (!preg_match("/^[a-zA-Z ]*$/",$name))	// check if name only contains letters and whitespace
		{
			$nameErr = "Only letters and white space allowed"; 
			$validationPassed = false;
		}
		preg_replace("/\s{2,}/", " ", $_POST["name"]); //replace multiple spaces with a single space
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

	if (empty($_POST["enquiry"]))
	{
		$enquiryErr = "Enquiry is required";
		$validationPassed = false;
	}
	else
	{
		$enquiry = testInput($_POST["enquiry"]);
	}
	/*
	mail(
     'woltonsimon@gmail.com',
     'Works!',
     'An email has been generated from your localhost, congratulations!');*/
	if ($validationPassed == true)
	{
		require_once('PHPMailer-master/class.phpmailer.php');

		$mail = new PHPMailer(); // create a new object
		$mail->IsSMTP(); // enable SMTP
		$mail->SMTPDebug = 0; // debugging: 1 = errors and messages, 2 = messages only
		$mail->SMTPAuth = true; // authentication enabled
		$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
		$mail->Host = "smtp.gmail.com";
		$mail->Port = 465; // 465 or 587
		$mail->IsHTML(true);

		$mail->Username = "woltonsimon@gmail.com";
		$mail->Password = "15334683";

		$mail->AddAddress("woltonsimon@gmail.com");
		$mail->SetFrom($email, 'Site User');
		$mail->AddReplyTo($email, 'Site User');			
		$mail->Subject = "Customer Query";
		$mail->Body = "$enquiry <br /><br />From: $name<br /><br />Email: $email";

		$mail->Send();
		$mailSent = true;

		if (isset($_POST["scts"]))
		{
			$mail = new PHPMailer(); // create a new object
			$mail->IsSMTP(); // enable SMTP
			$mail->SMTPDebug = 0; // debugging: 1 = errors and messages, 2 = messages only
			$mail->SMTPAuth = true; // authentication enabled
			$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
			$mail->Host = "smtp.gmail.com";
			$mail->Port = 465; // 465 or 587
			$mail->IsHTML(true);

			$mail->Username = "woltonsimon@gmail.com";
			$mail->Password = "15334683";

			$mail->AddAddress($email);
			$mail->SetFrom('support@SolentTakeaway.co.uk', 'SolentTakeaway');
			$mail->AddReplyTo('support@SolentTakeaway.co.uk', 'SolentTakeaway');			
			$mail->Subject = "Customer Query to SolentTakeaway";
			$mail->Body = "Hi $name, <br /><br />You just sent this message to SolentTakeaway:<br /><br /> $enquiry <br /><br />We are aim to reply within 48 hours. If after 48 hours you have not recieved a reply, contact us. ";

			$mail->Send();
			$mailSent = true;
		}
	}
}

include "colourapply.php";

function testInput($data)
{
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
if($mailSent == true)
{
	$formContents = "<span style=\"margin-left:95px;color:green;\">An email has been sent!</span>";
}
else
{
$sendToSelf = htmlspecialchars($_SERVER["PHP_SELF"]);
$formContents = <<< EOPAGE
	<form name="contactForm" method="post" action="$sendToSelf"> 
		<div class="align">
			<label for="name">Name:</label>
			<input class="inputalign" type="text" id="name" name="name" value="$name"/><span class="error">$nameErr</span>
		</div>
		<div class="align">
			<label for="email">E-mail:</label>
			<input class="inputalign" type="text" id="email" name="email" value="$email"/><span class="error">$emailErr</span>
		</div>
		<div>
			<label for="enquiry">Enquiry:</label>
			<textarea id="enquiry" name="enquiry">$enquiry</textarea><span class="error">$enquiryErr</span>
		</div>
		<div class="align">
			<input id="scts" type="checkbox" value="Yes" name="scts" style="margin-left:92px;"><label for="scts" style="display:inline;width:auto;text-align:left;">Send copy to my email address</label>
			
		</div>
		<div id="button">
			<input type="submit" value="Create Email">
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
		#enquiry{margin-left:0px;}
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
				<div id="content">
					<p id="address">
						If you'd like to write, our address is:<br /><br />
						123 Newport Avenue<br />
						Newport<br />
						PO01 9AZ
					</p>
					<br />
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
