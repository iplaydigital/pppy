<?php error_reporting(E_ALL ^ E_NOTICE);

include_once("./include/config.inc.php");
include_once("./include/class.inc.php");
include_once("./include/class.TemplatePower.inc.php");
include_once("./include/function.inc.php");



$tpl = new TemplatePower("./template/_tp_master.html");
$tpl->assignInclude("body", "./template/_tp_gallery.html");
$tpl->prepare();


##########
if(isset($_POST['language'])){$_SESSION['lag'] = $_POST['language'];}
elseif(!isset($_SESSION['lag'])){$_SESSION['lag'] = '1';}
else{}
FRONTLANGUAGE($_SESSION['lag']);
##########

if($_SESSION['lagText']=="EN"){
	$arrayNewsCategory = array('<a href="'.$url_main.'/news" class="nag-button w-button">News</a>','<a href="'.$url_main.'/blog" class="nag-button w-button">Blog</a>','<a href="'.$url_main.'/gallery" class="nag-button w-button active">Gallery</a>');
}else{
	$arrayNewsCategory = array('<a href="'.$url_main.'/ข่าวสารกิจกรรม" class="nag-button w-button">ข่าวสาร</a>','<a href="'.$url_main.'/บทความ" class="nag-button w-button">บทความ</a>','<a href="'.$url_main.'/แกลลอรี่" class="nag-button w-button active">แกลลอรี่</a>');
}

$tpl->assign("_ROOT.arrayNewsCategory",implode('', $arrayNewsCategory));



FRONTPAGESEO('17',$_SESSION['lag']);
$tpl->printToScreen();
