<?php
session_start();
session_destroy();
echo '<a href="index.php" style="color:#CDCDCD;">Click here</a> if you are not automatically redirected';
header( "Location:index.php" );
?>