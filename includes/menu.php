<?php
session_start();
error_reporting(0);
if ($_SESSION['login']!=1) die();
require_once("page.php");
echo getSidebar();

?>
