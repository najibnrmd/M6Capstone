<?php
session_start();
session_destroy();
header("Location:/capstone/public/landing.php");
?>