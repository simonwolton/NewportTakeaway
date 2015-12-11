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
					if ($_GET)
					{
						$connection = mysql_connect("exampleDBaddress", "exampleDBusername", "exampleDBpassword");
						mysql_select_db("newport_takeaway")or die("No such database");
						mysql_query("UPDATE `users` SET Admin = 1 WHERE UserID = $_GET[ID]");
						header("Location:viewallusers.php" );
					}
					else header("Location:adminconsole.php" );


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
