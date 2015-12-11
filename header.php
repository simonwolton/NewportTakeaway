<?php
if (isset($_SESSION['loggedInUserID']))
{
	$UID = $_SESSION['loggedInUserID'];
	$connection = mysql_connect("exampleDBaddress", "exampleDBusername", "exampleDBpassword");
	mysql_select_db("newport_takeaway")or die("cannot select DB");

	$result = mysql_query("SELECT FirstName,LastName,Admin FROM users WHERE UserID = '$UID'");

	$row = mysql_fetch_assoc($result);

	echo "Hello " . $row['FirstName'] . " " . $row['LastName'] . " <a href=\"logout.php\" style=\"color:#CDCDCD;\">Logout</a><br />";
	if ($row['Admin'] == 1)
	{
		echo "<a href=\"adminconsole.php\" style=\"color:#CDCDCD\">Admin Console</a> | ";
		$isAdmin = true;
	}
	else $isAdmin = false;
	echo "<a href=\"account.php\" style=\"color:#CDCDCD\">Account</a><br />";
}
else
{
	echo '<a href="login.php" style="color:#CDCDCD;">Login</a> or <a href="createaccount.php" style="color:#CDCDCD;">Create Account</a><br />';
}
?>