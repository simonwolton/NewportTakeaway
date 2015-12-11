<?php
if (isset($_COOKIE['backgroundColoursCookie']))
{
	$allColours = $_COOKIE['backgroundColoursCookie'];
	
	preg_match_all("/rgb\([0-9]{2,3},[0-9]{2,3},[0-9]{2,3}\)/", $allColours, $allColours);
	$CSSbody = "body{background-color: ".$allColours[0][0] . "}";
	$CSScontent =  "#content{background-color: ".$allColours[0][1] . "}";
	$CSSsearch = "#search{background-color: ".$allColours[0][2] . "}";
	$CSSfooters = "#footerleft, #footermiddle, #footerright{background-color: ". $allColours[0][3] . "}";
	$CSSproducts = "#products{background-color:". $allColours[0][4] . "}";
	
}
?>