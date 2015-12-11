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
					Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam semper molestie enim, id mollis mi venenatis nec. 
					Phasellus id turpis justo. Curabitur ut felis tristique, sodales lorem egestas, tempus quam. Donec vehicula nunc in lobortis 
					consequat. Morbi sed suscipit lacus. Cras ac feugiat tellus. Ut tellus ipsum, consequat sit amet ornare nec, hendrerit ut felis.
					Phasellus hendrerit turpis vitae nibh tincidunt congue. Donec eros quam, cursus eget sapien id, sagittis consectetur orci.
					Aenean varius nunc nibh, et ultrices ligula faucibus ut. Phasellus iaculis condimentum nibh eget tristique. 
					Pellentesque mollis bibendum dui vel condimentum. Sed consectetur suscipit elit, in tempus metus mollis quis.
					<p>
					Ut nec pretium justo, sit amet egestas lorem. Nunc at enim ut metus vulputate porta sit amet eget elit. Aenean sed tortor 
					accumsan, scelerisque nisi id, vehicula diam. Donec sed augue sit amet mauris tincidunt molestie sed ac nunc. Cras id felis
					id dui euismod ornare vitae pharetra enim. Nam magna turpis, blandit a erat et, fermentum tincidunt nibh. Mauris id dictu
					m mauris, sit amet lobortiswer ywehew5y w yw y5 ywsre yaeryh ewh aesr yhareh wre herth wre hwr drel, pretium purus. Pellen
					tesque iaculis, magna eu sagittis venenatis, mauris ipsum porttitor od
					Ut nec pretium justo, sit amet egestas lorem. Nunc at enim ut metus vulputate porta sit amet eget elit. Aenean sed tortor 
					accumsan, scelerisque nisi id, vehicula diam. Donec sed augue sit amet mauris tincidunt molestie sed ac nunc. Cras id felis
					id dui euismod ornare vitae pharetra enim. Nam magna turpis, blandit a erat et, fermentum tincidunt nibh. Mauris id dictu
					m mauris, sit amet lobortiswer ywehew5y w yw y5 ywsre yaeryh ewh aesr yhareh wre herth wre hwr drel, pretium purus. Pellen
					tesque iaculis, magna eu sagittis venenatis, mauris ipsum porttitor od
					</p>
					hasellus metus elit, laoreet id scelerisque vitae, bibendum luctus nisl. Duis id tempor ipsum, vel ullamcorper lectus. Phas
					ellus aliquam mauris a leo sagittis, et consequat diam lobortis. Nam ultricies est eu lacus adipiscing adipiscing.
					is ligula, ac sagittis elit. Nullam ornare ipsum a lectus gravida, vel aliquam elit rutrum. In aliquet libero vel tortor eui
					smod ornare. Pellentesque bibendum rhoncus arcu, in pharetra risus volutpat ut.
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
