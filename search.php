<?php error_reporting(E_ALL ^ E_NOTICE);

include_once("../include/config.inc.php");
//include_once("../include/class.inc.php");
include_once("./include/class.TemplatePower.inc.php");
include_once("./include/function.inc.php");



$tpl = new TemplatePower("./template/_tp_master.html");
$tpl->assignInclude("body", "template/_tp_search.html");
$tpl->prepare();

##########

// if($_SESSION['lag']==''){$_SESSION['lag']=='1';}else{}
// if($_POST['language']!=""){$_SESSION['lag'] = $_POST['language'];}

// FRONTLANGUAGE($_SESSION['lag']);
// FRONTPAGESEO('1',$_SESSION['lag']);

/////////////////////////////////////////////////

$tpl->assign("_ROOT.page_title", "Search Results");
$tpl->assign("_ROOT.logo_brand_alt", $Brand);

$tpl->printToScreen();

10155.72