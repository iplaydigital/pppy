<?php error_reporting(E_ALL ^ E_NOTICE);
/*****************************************************************
Created :01/10/2021
Author : worapot bhilarbutra (pros.ake)
E-mail : worapot.bhi@gmail.com
Website : https://www.vpslive.com
Copyright (C) 2021-2025, VPS Live Digital togethers all rights reserved.
 *****************************************************************/


// Setting
$Brand 		= "มูลนิธิเพาะพันธุ์ปัญญา";
$Copyright 	= "Play digital Co.,Ltd.";
$Powerby 	= "อ.พี่เอก";

// Database 
$db_config = array(
	"host" => "localhost",
	"user" => "pohpun_web",
	"pass" => "x@8Vk99c4",
	"dbname" => "pohpun_web",
	"charset" => "utf8"
);



//SET Time //////////////////////////////
date_default_timezone_set("Asia/Bangkok");
$strDateTime  = date("Y-m-d h:i:s");
$tnow          = date("h:i:s");
$url_main = 'https://dev.pohpunpanyafoundation.org';


$iPod = stripos($_SERVER['HTTP_USER_AGENT'], "iPod");
$iPhone = stripos($_SERVER['HTTP_USER_AGENT'], "iPhone");
$iPad = stripos($_SERVER['HTTP_USER_AGENT'], "iPad");
$Android = stripos($_SERVER['HTTP_USER_AGENT'], "Android");
$webOS = stripos($_SERVER['HTTP_USER_AGENT'], "webOS");
$status = true;

if ($iPod || $iPhone) {
	$status = false;
	//were an iPhone/iPod touch -- do something here
} else if ($iPad) {
	$status = false;
	//were an iPad -- do something here
} else if ($Android) {
	$status = false;
	//were an Android device -- do something here
} else if ($webOS) {
	$status = false;
	//were a webOS device -- do something here
}
if ($status == true) {
	//	header( 'Location: https://pppy.uarea.in/office/' ) ;
}

// Display Error ,0=none display,1=display
@ini_set('display_errors', '0');
@set_time_limit(0);

// MySQL Table
$tableLag 							= 	"tb_lag";
$tableAdmin 						= 	"tb_admin_user";
$tableAdminMenu 					= 	"tb_admin_menu";

$tableNewsCategory					=	"tb_news_category";
$tableNews							=	"tb_news";
$tablePage 							= 	"tb_page";
$tablePageDetail 					= 	"tb_page_detail";
$tableSchool 						= 	"tb_school";
$tableSchoolDetail 					= 	"tb_school_detail";

$tableCampModel 					= 	"tb_camp_model";
$tableCampProvince 					= 	"tb_camp_province";
$tableCampProvinceDetail			= 	"tb_camp_province_detail";
$tableCampDistrict 					= 	"tb_camp_district";
$tableCampDistrictDetail			= 	"tb_camp_district_detail";
$tableCampSchool 					= 	"tb_camp_school";
$tableCampSchoolDetail				= 	"tb_camp_school_detail";

$tableSetting						= 	"tb_setting";


$tableIndexSlide					= 	"tb_index_main_slide";
$tableIndexSlideDetail				= 	"tb_index_main_slide_detail";
$tableIndexSlideVdo					= 	"tb_index_main_slide_vdo";
$tableIndexSlideVdoDetail				= 	"tb_index_main_slide_vdo_detail";
$tableIndexSlideCamp					= 	"tb_index_main_slide_camp";
$tableIndexSlideCampDetail				= 	"tb_index_main_slide_camp_detail";




$tableMessage 						= 	"tb_message";
$tableMember 						= 	"tb_member";
$tableMembersLogin					= 	"tb_members_login"; //ตารางสมาชิกที่เข้าสู่ระบบทั้งหมด
$tableMemberAddress					= 	"tb_member_address";
$tableMailMessage 					= 	"tb_mail_message";
$tableWebMil 						= 	"tb_mail_message";
$tableWebMenu 						= 	"tb_web_menu";

$tableLog							=   "tb_linelog";
$tableOrders						=	"tb_orders";
$tableTask							=   "tb_task";


$tableContents 						= 	"tb_contents_detail";
$tableCustomers						= 	"tb_customers";
$tableAgents						= 	"tb_agents";


$tableProvince						=	"tb_province";
$tableAmphur						=	"tb_amphur";
$tableDistrict						=	"tb_district";




$tableProducts						=	"tb_products";
$tableAgent							=	"tb_agent";
$tableBotAction						=	"tb_bot_action";


$tableHelpSupport					=	"tp_help_support";

// All config
$cfgDefaultPerPage = 5;
$cfgOtherRowPerPage = 15;


// Session
if (substr_count($_SERVER["SCRIPT_NAME"], "/") == 1) {
	session_name("pppy");
}

session_start();


// if (empty($_SESSION['file_upload'])) {$_SESSION['file_upload'] = array();}

// Connect MySQL
$conn = @new mysqli($db_config["host"], $db_config["user"], $db_config["pass"], $db_config["dbname"]);
//$conn->set_charset($db_config["charset"]);

