<?php 
if (!isset($_SESSION)) {
session_start();
$_SESSION['cartSessionID'] = session_id();
$cartSessionID = $_SESSION['cartSessionID'];
}
?>