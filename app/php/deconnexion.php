<?php
session_start();
$_SESSION = [];
session_destroy();
header("Location:  /app/views/home.php");
exit;