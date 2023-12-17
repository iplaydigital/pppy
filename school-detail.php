<?php error_reporting(E_ALL ^ E_NOTICE);

include_once("./include/config.inc.php");
include_once("./include/class.inc.php");
include_once("./include/class.TemplatePower.inc.php");
include_once("./include/function.inc.php");

// echo $_SERVER['DOCUMENT_ROOT']."/template/_tp_master.html";

// $tpl = new TemplatePower("".$_SERVER['DOCUMENT_ROOT']."/template/_tp_master.html");

$tpl = new TemplatePower("./template/_tp_master.html");

if($_GET['id']=='chiang' || $_GET['id']=='chiangklang-prachapattana-school-numprik-samza'){
	$tpl->assignInclude("body", "./template/_tp_chiang-klang-pracha-pattana.html");
	$tpl->prepare();
	$tpl->assign("_ROOT.page_title", "โรงเรียนเชียงกลาง ประชาพัฒนา น่าน");
	$tpl->assign("_ROOT.logo_brand_alt", $Brand);
	$pageid=1;
}elseif($_GET['id']=='pratatpittayakom' || $_GET['id']=='pratatpittayakhom-school-mongdee-phee'){
	$tpl->assignInclude("body", "./template/_tp_pratatpittayakom.html");
	$tpl->prepare();
	$tpl->assign("_ROOT.page_title", "โรงเรียนพระธาตุพิทยาคม");
	$tpl->assign("_ROOT.logo_brand_alt", $Brand);
	$pageid=2;

}elseif($_GET['id']=='pitthayakhom' || $_GET['id']=='thawangphapittayakhom-school-kado'){
	$tpl->assignInclude("body", "./template/_tp_tha-wang-pha-pitthayakhom.html");
	$tpl->prepare();
	$tpl->assign("_ROOT.page_title", "โรงเรียนท่าวังผาพิทยาคม");
	$tpl->assign("_ROOT.logo_brand_alt", $Brand);
	$pageid=3;
}elseif($_GET['id']=='puaschool' || $_GET['id']=='pao-school-mamuen-butter'){
	$tpl->assignInclude("body", "./template/_tp_pua-school.html");
	$tpl->prepare();
	$tpl->assign("_ROOT.page_title", "โรงเรียนปัว");
	$tpl->assign("_ROOT.logo_brand_alt", $Brand);
	$pageid=4;
}elseif($_GET['id']=='srisawatwittayakarn' || $_GET['id']=='srisawatwittayakarn-school-lanala'){
	$tpl->assignInclude("body", "./template/_tp_Srisawatwittayakarn-School.html");
	$tpl->prepare();
	$tpl->assign("_ROOT.page_title", "โรงเรียนศรีสวัสดิ์วิทยาคาร");
	$tpl->assign("_ROOT.logo_brand_alt", $Brand);
	$pageid=5;
}elseif($_GET['id']=='saschool' || $_GET['id']=='sa-school-laam-ruay'){
	$tpl->assignInclude("body", "./template/_tp_sa-school.html");
	$tpl->prepare();
	$tpl->assign("_ROOT.page_title", "โรงเรียนสา");
	$tpl->assign("_ROOT.logo_brand_alt", $Brand);
	$pageid=6;
}elseif($_GET['id']=='orngeriiyn' || $_GET['id']=='rajaprajanugroh56-school-cookie-ten-bites'){
	$tpl->assignInclude("body", "./template/_tp_orngeriiyn-raachprachaanuekhraaah-56-cchanghwadnaan.html");
	$tpl->prepare();
	$tpl->assign("_ROOT.page_title", "โรงเรียนราชประชานุเคราะห์ 56 จังหวัดน่าน");
	$tpl->assign("_ROOT.logo_brand_alt", $Brand);
	$pageid=7;
}elseif($_GET['id']=='orngeriiynemuue' || $_GET['id']=='munglee-school-lina'){
	$tpl->assignInclude("body", "./template/_tp_muanglee-school.html");
	$tpl->prepare();
	$tpl->assign("_ROOT.page_title", "โรงเรียนเมืองลีประชาสามัคคี");
	$tpl->assign("_ROOT.logo_brand_alt", $Brand);
	$pageid=8;
}

##########
if(isset($_POST['language'])){$_SESSION['lag'] = $_POST['language'];}
elseif(!isset($_SESSION['lag'])){$_SESSION['lag'] = '1';}
else{}
FRONTLANGUAGE($_SESSION['lag']);
##########
FRONTSCHOOLSEO($pageid,$_SESSION['lag']);





$tpl->printToScreen();

