<?php 
session_start();
unset($_SESSION['user_id']);
header('location:http://localhost/hemant_proj/php/portal/');
?>