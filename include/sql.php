<?php error_reporting(E_ALL ^ E_NOTICE);

include_once("include/config.inc.php");
include_once("include/class.inc.php");
include_once("include/class.TemplatePower.inc.php");
include_once("include/function.inc.php");




if(isset($_POST['language'])){$_SESSION['lag'] = $_POST['language'];}
elseif(!isset($_SESSION['lag'])){$_SESSION['lag'] = '1';}




?>