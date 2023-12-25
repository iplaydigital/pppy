<?php error_reporting (E_ALL ^ E_NOTICE);
/*****************************************************************
Created :01/10/2021
Author : worapot bhilarbutra (pros.ake)
E-mail : worapot.bhi@gmail.com
Website : https://www.vpslive.com
Copyright (C) 2021-2025, VPS Live Digital togethers all rights reserved.
*****************************************************************/

///////COUNTLANGUAGE////////////////////////////////////////////////
function COUNTLANGUAGE($id){
	global $tpl;
	global $tableLag;
	global $conn;

	$sql = "SELECT * FROM `$tableLag` WHERE `STATUS` = 'Show' ORDER BY `ID`";
	$query = $conn->query($sql) or die($conn->error);
	$total = $query->num_rows;
	return $total;
}
///////FRONTLANGUAGE////////////////////////////////////////////////
function FRONTLANGUAGE($lag)
{
	global $tpl;
	global $url_main;

	if($lag=='2'){
	    $tpl->assign("_ROOT.language",'
		<img loading="lazy" src="'.$url_main.'/images/th_flag.png" alt="" class="flag flag_en" style="cursor: pointer;">
		<img loading="lazy" src="'.$url_main.'/images/en_flag.png" alt="" class="flag_th">
		<img loading="lazy" src="'.$url_main.'/images/cn_flag.png" alt="" class="flag flag_en">
		<img loading="lazy" src="'.$url_main.'/images/ln_flag.png" alt="" class="flag flag_en">
		<input type="hidden" name="language" value="1">');
	    $_SESSION['lagText'] = "EN";
	}else{
	    $tpl->assign("_ROOT.language",'
		<img loading="lazy" src="'.$url_main.'/images/th_flag.png" alt="" class="flag_th">
		<img loading="lazy" src="'.$url_main.'/images/en_flag.png" alt="" class="flag flag_en" style="cursor: pointer;">
		<img loading="lazy" src="'.$url_main.'/images/cn_flag.png" alt="" class="flag flag_en">
		<img loading="lazy" src="'.$url_main.'/images/ln_flag.png" alt="" class="flag flag_en">
		<input type="hidden" name="language" value="2">');
	    $_SESSION['lagText'] = "TH";
	}
	$tpl->assign("_ROOT.url_main",$url_main);
}
///////////////////////////////////////////////////////////////////
///////BACKLANGUAGE////////////////////////////////////////////////
function BACKLANGUAGE($lag)
{
	global $tpl;
	// global $url_main;

	if($lag=='2'){
	    $tpl->assign("_ROOT.officelanguage1",'<span class="avatar avatar-sm" style="background-image: url(../dist/img/flags/us.svg);height: 18px;"></span><span class="">EN</span>');
	    $tpl->assign("_ROOT.officelanguage2",'<input type="hidden" name="language" value="1"><input type="submit" value="" class="avatar avatar-sm" style="background-image: url(../dist/img/flags/th.svg);height: 18px;border:0;"><span class="">TH</span>');
	    $_SESSION['lagText'] = "EN";
	}else{
	    $tpl->assign("_ROOT.officelanguage1",'<span class="avatar avatar-sm" style="background-image: url(../dist/img/flags/th.svg);height: 18px;"></span><span class="">TH</span>');
	    $tpl->assign("_ROOT.officelanguage2",'<input type="hidden" name="language" value="2"><input type="submit" value="" class="avatar avatar-sm" style="background-image: url(../dist/img/flags/us.svg);height: 18px;border:0;"><span class="">EN</span>');
	    $_SESSION['lagText'] = "TH";
	}
	// $tpl->assign("_ROOT.url_main",$url_main);
}
//////////////////////////////////////////////////////////////////////

function ReferGroup($lag, $type = null) {
    global $tpl;

    $query = "SELECT * FROM `tb_refer_type_detail` WHERE `LAG`='$lag' ORDER BY `ORDER`,`ID`";
    $result = mysql_query($query);

    while ($line = mysql_fetch_array($result)) {
        $type_id = $line["ID"];
        $query2 = "SELECT * FROM `tb_refer_detail` WHERE `LAG`='$lag' AND `TYPE_ID`='$type_id' ";
        $result2 = mysql_query($query2);
        $num_type = mysql_num_rows($result2);
        $tpl->newBlock("CATZ");

        if ($num_type > 0) {
            $tpl->assign("url", "index.php?type=" . $type_id);
        }
        
        if ($num_type == 0) {
            $tpl->assign("url", "#12");
        }

        $tpl->assign("title", $line["NAME"]);

        if ($type !== null && $type == $type_id) {
            $tpl->assign("title", "<strong>" . $line["NAME"] . "</strong>");
        }

        //$tpl->assign("_ROOT.gtitle","<h2>".$line["NAME"]."</h2>");
    }
}



// Check User /////////////////////////////
function CheckLogin($user=null){
global $tpl;
if($user==""){
$tpl->newBlock("LOGIN");
}else{
$tpl->newBlock("LOGON");
$tpl->assign("fname",$_SESSION['sfname']);
$tpl->assign("lname",$_SESSION['slname']);
}
}



// Slide Front /////////////////////////
function SLIDE_FRONT($table,$lag){
global $tpl;

	$query	= "SELECT * FROM `tb_front_slide_detail` WHERE `STATUS`='Show'  AND `LAG`='$lag' ORDER BY `SORT` ASC";
	$result	= mysql_query($query);
	while($line = mysql_fetch_array($result)) {
	$tpl->newBlock("SLIDE");
	$tpl->assign("img",$line["THUMB"]);
	$tpl->assign("url",$line["URL"]);
	}

}


// 
// function HILIGHT_UPDATE($table,$lag){
// global $tpl;

// $path1="../uploads/";
// 	$query	= "SELECT * FROM `$table` WHERE `ID`='5' AND `STATUS`='Show'  AND `LAG`='$lag'";
// 	$result	= mysql_query($query);
// 	while($line = mysql_fetch_array($result)) {
// 	$tpl->newBlock("HILIGHT1");
// 	$tpl->assign("url",$line["URL"]);
// 	$tpl->assign("title",$line["TITLE"]);
// 	$tpl->assign("img",$path1."hilight/".$line["THUMB"]);
// 	}

// 	$query	= "SELECT * FROM `$table` WHERE `ID`='6' AND `STATUS`='Show'  AND `LAG`='$lag'";
// 	$result	= mysql_query($query);
// 	while($line = mysql_fetch_array($result)) {
// 	$tpl->newBlock("HILIGHT2");
// 	$tpl->assign("url",$line["URL"]);
// 	$tpl->assign("title",$line["TITLE"]);
// 	$tpl->assign("img",$path1."hilight/".$line["THUMB"]);
// 	}

// 	$query	= "SELECT * FROM `$table` WHERE `ID`='7' AND `STATUS`='Show'  AND `LAG`='$lag'";
// 	$result	= mysql_query($query);
// 	while($line = mysql_fetch_array($result)) {
// 	$tpl->newBlock("HILIGHT3");
// 	$tpl->assign("url",$line["URL"]);
// 	$tpl->assign("title",$line["TITLE"]);
// 	$tpl->assign("img",$path1."hilight/".$line["THUMB"]);
// 	}

// }



// function HILIGHT_PRODUCTS($table,$lag){
// global $tpl;

// $nno=1;
// $path1="../uploads/";
// $str1="";
// $img2="";
// $img3="";

// $query = "SELECT * FROM `$table` WHERE  `LAG`='$lag'
// AND `STATUS`='Show' ";
// 	$result = mysql_query($query);
// 	while($line=mysql_fetch_array($result)){
// 		if($nno==1){$tpl->newBlock("HIPRODUCT");
// 		$nno=4;
// 		 	}
// 		 $tpl->newBlock("HIPRODUCT_1");

// 			$img=$path1."hilight/".$line['THUMB'];
// 			if($img2=="") $img2=$path1."hilight/".$line['IMG'];
// 			if($line['THUMB']!="") $tpl->assign("IMG",$img);
// 			$img2=$path1."hilight/".$line['IMG'];
// 			if($line['IMG']!="") $tpl->assign("IMG2",$img2);
// 			$tpl->assign("TITLE",$line['TITLE']);
// 			$tpl->assign("LINK",$line['URL']);
// 			if($str1==""){
// 			$str1=$line['TITLE'];
// 			$img3=$img2;
// 			}
// 			$nno--;
// 		}
// 		$tpl->assign("_ROOT.DF_TITLE_HIPRO",$str1);
// 		$tpl->assign("_ROOT.DF_IMG_HIPRO",$img3);
// }






///////FRONTPAGESEO////////////////////////////////////////////////

function FRONTPAGESEO($pages,$lag){

global $tpl;
global $tablePageDetail;
global $url_main;
global $conn;
//global $lag;

	$query	= "SELECT * FROM `$tablePageDetail` WHERE `ID`='$pages' and `LAG`='$lag'";
	$result	= $conn->query($query);
	while($line = $result->fetch_assoc()) {
	
		if(is_file("upload/pages/".$line['KEYIMG'])){
			$tpl->assign("_ROOT.keyimg","<img src='upload/pages/".$line['KEYIMG']."'>");
			$tpl->assign("_ROOT.linkkeyimg","upload/pages/".$line['KEYIMG']);
		}

		// $tpl->newBlock("META");
		$tpl->assign("_ROOT.id",$line["ID"]);
		
		
		if(isset($line["KEYWORD"])){
			$tpl->assign("_ROOT.page_keyword",nl2br($line["KEYWORD"]));
		}
		if(isset($line["TITLE"])){
			$tpl->assign("_ROOT.page_title",nl2br($line["TITLE"]));
		}
		if(isset($line["DESCRIPTION"])){
			$tpl->assign("_ROOT.page_description",nl2br($line["DESCRIPTION"]));
		}
		if(isset($line["GOTITLE"])){
			$tpl->assign("_ROOT.gotitle",nl2br($line["GOTITLE"]));
		}
		if(isset($line["GOSITENAME"])){
			$tpl->assign("_ROOT.gositename",nl2br($line["GOSITENAME"]));
		}
		if(isset($line["GOTYPE"])){
			$tpl->assign("_ROOT.gotype",nl2br($line["GOTYPE"]));
		}
		if(isset($line["OGURL"])){
			$tpl->assign("_ROOT.gourl",nl2br($line["OGURL"]));
		}

		if(isset($line["GOIMG"])){
			if(is_file("upload/school/".$line['GOIMG'])){
				$tpl->assign("_ROOT.og_image",$url_main."/upload/school/".$line['GOIMG']."");
			}
		}

	}

}


///////FRONTSCHOOLSEO////////////////////////////////////////////////

function FRONTSCHOOLSEO($pages,$lag){

	global $tpl;
	global $tableSchoolDetail;
	global $url_main;
	global $conn;
	//global $lag;
	
		$query	= "SELECT * FROM `$tableSchoolDetail` WHERE `ID`='$pages' and `LAG`='$lag'";
		$result	= $conn->query($query);
		while($line = $result->fetch_assoc()) {
		
			if(is_file("upload/school/".$line['KEYIMG'])){
				$tpl->assign("_ROOT.keyimg","<img src='upload/school/".$line['KEYIMG']."'>");
				$tpl->assign("_ROOT.linkkeyimg","upload/school/".$line['KEYIMG']);
			}
	
			// $tpl->newBlock("META");
			$tpl->assign("_ROOT.id",$line["ID"]);
			// $tpl->assign("_ROOT.page_keyword",nl2br($line["KEYWORD"]));
			// $tpl->assign("_ROOT.page_title",nl2br($line["TITLE"]));
			// $tpl->assign("_ROOT.page_description",nl2br($line["DESCRIPTION"]));
			// $tpl->assign("_ROOT.gotitle",nl2br($line["GOTITLE"]));
			// $tpl->assign("_ROOT.gositename",nl2br($line["GOSITENAME"]));
			// $tpl->assign("_ROOT.gotype",nl2br($line["GOTYPE"]));
			// $tpl->assign("_ROOT.gourl",nl2br($line["OGURL"]));

			if(isset($line["KEYWORD"])){
				$tpl->assign("_ROOT.page_keyword",nl2br($line["KEYWORD"]));
			}
			if(isset($line["TITLE"])){
				$tpl->assign("_ROOT.page_title",nl2br($line["TITLE"]));
			}
			if(isset($line["DESCRIPTION"])){
				$tpl->assign("_ROOT.page_description",nl2br($line["DESCRIPTION"]));
			}
			if(isset($line["GOTITLE"])){
				$tpl->assign("_ROOT.gotitle",nl2br($line["GOTITLE"]));
			}
			if(isset($line["GOSITENAME"])){
				$tpl->assign("_ROOT.gositename",nl2br($line["GOSITENAME"]));
			}
			if(isset($line["GOTYPE"])){
				$tpl->assign("_ROOT.gotype",nl2br($line["GOTYPE"]));
			}
			if(isset($line["OGURL"])){
				$tpl->assign("_ROOT.gourl",nl2br($line["OGURL"]));
			}

			if(isset($line["GOIMG"])){
				if(is_file("upload/school/".$line['GOIMG'])){
					$tpl->assign("_ROOT.og_image",$url_main."/upload/school/".$line['GOIMG']."");
				}
			}

			
	
		}
	
	}



///////FRONTSETTING////////////////////////////////////////////////
function FRONTSETTING($lag){
global $tpl;
global $tableSetting;
global $lag;

$query_set = "SELECT * FROM `$tableSetting` WHERE `LAG`='$lag' ";
	$result_set = mysql_query($query_set) or die($query_set);
	while($line_set=mysql_fetch_array($result_set)){

		$tpl->assign("_ROOT.setting_name",$line_set['NAME']);
		$tpl->assign("_ROOT.setting_time",$line_set['TIME']);
		$tpl->assign("_ROOT.setting_tel",$line_set['TEL']);
		$tpl->assign("_ROOT.setting_fax",$line_set['FAX']);

		$MOBILE = explode("|",$line_set['MOBILE']);
		$tpl->assign("_ROOT.setting_mobile1",$MOBILE[0]);
		$tpl->assign("_ROOT.setting_mobile2",$MOBILE[1]);
		$tpl->assign("_ROOT.setting_mobile3",$MOBILE[2]);

		$tpl->assign("_ROOT.setting_email",$line_set['EMAIL']);
		$tpl->assign("_ROOT.setting_email2",$line_set['EMAIL2']);
		$tpl->assign("_ROOT.setting_line",$line_set['LINE']);
		$tpl->assign("_ROOT.setting_facebook",$line_set['FACEBOOK']);
		$tpl->assign("_ROOT.setting_youtube",$line_set['YOUTUBE']);
		$tpl->assign("_ROOT.setting_twitter",$line_set['TWITTER']);
		$tpl->assign("_ROOT.setting_instagram",$line_set['INSTAGRAM']);
		$tpl->assign("_ROOT.setting_copyright",$line_set['COPYRIGHT']);
		$tpl->assign("_ROOT.setting_js",$line_set['JS']);
		$tpl->assign("_ROOT.setting_piwik",$line_set['PIWIK']);

		if($line_set['LOGO']!=""){
			if(is_file("upload/setting/full/img/".$line_set['LOGO'])){
			$tpl->assign("_ROOT.setting_logo","<img src='upload/setting/full/img/".$line_set['LOGO']."'>");
			}
		}
		if($line_set['LOGO2']!=""){
			if(is_file("upload/setting/full/img/".$line_set['LOGO2'])){
			$tpl->assign("_ROOT.setting_logo2","<img src='upload/setting/full/img/".$line_set['LOGO2']."'>");
			}
		}
		if($line_set['LOGO_THUMB']!=""){
			if(is_file("upload/setting/full/img/".$line_set['LOGO_THUMB'])){
			$tpl->assign("_ROOT.setting_logo_thumb","<img src='upload/setting/full/img/".$line_set['LOGO_THUMB']."' alt='logo' class='logo-default' style='margin:0px;'>");
			$tpl->assign("_ROOT.xsetting_logo_thumb","upload/setting/full/img/".$line_set['LOGO_THUMB']);
		
		
		
		}
		}
		if($line_set['FAVICON']!=""){
			if(is_file("upload/setting/full/img/".$line_set['FAVICON'])){
			$tpl->assign("_ROOT.setting_favicon","upload/setting/full/img/".$line_set['FAVICON']."");
			}
		}
	}
}


///////FRONTSLIDE////////////////////////////////////////////////

function FRONTSLIDE($lag){
global $tpl;
global $tableHomeSlide;
global $tableHomeSlideDetail;
global $lag;

$no=0;

	$query = "SELECT * FROM `$tableHomeSlide` WHERE `DEL`='0' and `STATUS`='Show' order by `ORDER` desc LIMIT 0,5";
	$result = mysql_query($query) or die ($query);
	while($line = mysql_fetch_array($result)){
		$tpl->newBlock("SLIDE");
		$tpl->assign("id",$line['ID']);
		$tpl->assign("imgslide","upload/slide/full/".$line['THUMB']);
		$tpl->assign("url",$line['URL']);
		$tpl->assign("title",$line['TITLE']);
		$tpl->assign("desc",$line['DESC']);
		$tpl->assign("urltitle",$line['URLTITLE']);

		$query2 = "SELECT * FROM `$tableHomeSlideDetail` WHERE `LAG`='$lag' and `ID`='".$line['ID']."' ";
		$result2 = mysql_query($query2) or die ($query2);
		while($line2 = mysql_fetch_array($result2)){
			$tpl->assign("title",$line2['TITLE']);
			$tpl->assign("desc",$line2['DESC']);
		}

		$tpl->newBlock("SLIDE_THUMB");
		$tpl->assign("no",$no);
		$tpl->assign("imgslide","upload/slide/full/".$line['THUMB']);
		$no++;
	}

}

///////FRONTCONTACT////////////////////////////////////////////////
function FRONTCONTACT($lag){
global $tpl;
global $tableContactUs;
global $lag;

$query_set = "SELECT * FROM `$tableContactUs` WHERE `LAG`='$lag' ";
	$result_set = mysql_query($query_set) or die($query_set);
	while($line_set=mysql_fetch_array($result_set)){

		$tpl->assign("_ROOT.setting_contact_name",$line_set['NAME']);
		$tpl->assign("_ROOT.setting_contact_address",$line_set['ADDRESS']);
		$tpl->assign("_ROOT.setting_contact_detail",$line_set['DETAIL']);
		$tpl->assign("_ROOT.setting_contact_detail2",$line_set['DETAIL2']);
		$tpl->assign("_ROOT.setting_contact_latitude",$line_set['LATITUDE']);
		$tpl->assign("_ROOT.setting_contact_longtitude",$line_set['LONGTITUDE']);

		$tpl->assign("_ROOT.setting_contact_gmap","var myLatlng = new google.maps.LatLng(".$line_set['LATITUDE'].",".$line_set['LONGTITUDE'].");");




		if($line_set['IMG']!=""){
			if(is_file("upload/contact/full/img/".$line_set['IMG'])){
			$tpl->assign("_ROOT.setting_contact_map","upload/contact/full/img/".$line_set['IMG']);
			}
		}

	}
}


// FRONTQUESTION /////////////////////////////////////////////////////
function FRONTQUESTION($lag){
global $tpl;
global $tableQuestion;
global $lag;

	$query = "SELECT * FROM `$tableQuestion` WHERE `LAG`='$lag'";
	$result = mysql_query($query);
	while ($line = mysql_fetch_array($result)) {
		$tpl->newBlock("QUESTION");
		$tpl->assign("SETQUESTION",$line['QUESTION']);
		$tpl->assign("SETANSWER",$line['ANSWER']);
	}

}


///////MENUPRODUCT////////////////////////////////////////////////
function MENUPRODUCT($lag){
global $tpl;
global $tableProductCatelogDetail;
global $tableProductTypeDetail;
global $tableProductToolsDetail;
global $lag;

		$query = "SELECT * FROM `$tableProductCatelogDetail` WHERE `LAG`='$lag' ORDER BY `ORDER` ASC";
		$result = mysql_query($query);
		while($line = mysql_fetch_array($result)) {
			$tpl->newBlock("PRODUCT_CATALOG");
			$tpl->assign("CATALOG_ID",$line["ID"]);
			$tpl->assign("CATALOG_TITLE",$line["TITLE"]);

			// $query2 = "SELECT * FROM `$tableProductTypeDetail` WHERE `ID_CAT`='".$line["ID"]."' AND `LAG`='$lag' ORDER BY `ORDER` ASC";
			// $result2 = mysql_query($query2);
			// while($line2 = mysql_fetch_array($result2)) {
			// 	$tpl->assign("TYPE_ID2",$line2["ID"]);
			// 	$tpl->assign("TYPE_TITLE2",$line2["TITLE"]);
			// 	if(is_file("upload/product/type/".$line2['THUMB'])){
			// 		$tpl->assign("img","upload/product/type/".$line2['THUMB']."");
			// 	 }

			// 	$tpl->newBlock("PRODUCT_TYPE");
			// 	$tpl->assign("TYPE_ID",$line2["ID"]);
			// 	$tpl->assign("TYPE_TITLE",$line2["TITLE"]);

			// 	$tpl->assign("CATALOG_ID",$line["ID"]);

			// 		$query3 = "SELECT * FROM `$tableProductToolsDetail` WHERE `ID_CAT`='".$line["ID"]."' AND `ID_TYPE`='".$line2["ID"]."' AND `LAG`='$lag' ORDER BY `ORDER` ASC";
			// 		$result3 = mysql_query($query3);
			// 		while($line3 = mysql_fetch_array($result3)) {
			// 			$tpl->newBlock("PRODUCT_TOOLS");
			// 			$tpl->assign("TOOLS_ID",$line3["ID"]);
			// 			$tpl->assign("TOOLS_TITLE",$line3["TITLE"]);

			// 			$tpl->assign("CATALOG_ID",$line["ID"]);
			// 			$tpl->assign("TYPE_ID",$line2["ID"]);

			// 		}
			// }

		}
}

/////////////////////////////////////////////////////

function FRONTNEWS($table,$lag){
global $tpl;

$path1="../uploads/";

$query = "SELECT * FROM `$table` WHERE `ID`='1' AND `LAG`='$lag' ";
	$result = mysql_query($query);
	while($line=mysql_fetch_array($result)){
		$tpl->newBlock("FRONTNEWS1");
		/*
		<a href="#"><img src="images/pic-tn-news-01.jpg" /></a>
		<a href="#">50 »ÕÊÕàºàÂÍÃì ¾Ñ²¹Ò¹ÇÑµ¡ÃÃÁÊÕà¾×èÍ·Ø¡ªÕÇÔµ</a>
		*/

		$img=$path1."frontnews/".$line['IMG'];
		$link=$line['LINK'];
		if($line['IMG']!="") $tpl->assign("IMG","<a href=\"$link\"><img src=\"$img\" /></a>");
		$tpl->assign("TITLE","<a href=\"$link\">".$line['TITLE']."</a>");
		$tpl->assign("DETAIL",$line['DETAIL']);
	}
//++++++++++++++++++++++++++++++++++++++++++++++++
$query = "SELECT * FROM `$table` WHERE `ID`='2' AND `LAG`='$lag' ";
	$result = mysql_query($query);
	while($line=mysql_fetch_array($result)){
		$tpl->newBlock("FRONTNEWS2");
		$img=$path1."frontnews/".$line['IMG'];
		$link=$line['LINK'];
		if($line['IMG']!="") $tpl->assign("IMG","<a href=\"$link\"><img src=\"$img\" /></a>");
		$tpl->assign("TITLE","<a href=\"$link\">".$line['TITLE']."</a>");
		$tpl->assign("DETAIL",$line['DETAIL']);
	}
//++++++++++++++++++++++++++++++++++++++++++++++++
$query = "SELECT * FROM `$table` WHERE `ID`='3' AND `LAG`='$lag' ";
	$result = mysql_query($query);
	while($line=mysql_fetch_array($result)){
		$tpl->newBlock("FRONTNEWS3");
		$img=$path1."/frontnews/".$line['IMG'];
		$link=$line['LINK'];
		if($line['IMG']!="") $tpl->assign("IMG","<a href=\"$link\"><img src=\"$img\" /></a>");
		$tpl->assign("TITLE","<a href=\"$link\">".$line['TITLE']."</a>");
		$tpl->assign("DETAIL",$line['DETAIL']);
	}
//++++++++++++++++++++++++++++++++++++++++++++++++
}




function ChangeOrder($table,$referr){
global $id;
global $order;

for($i=0;$i<count($id);$i++){
	if($id[$i]!=""){
		$idx=$id[$i];
		$orderx=$order[$i];
		$arrData = array();
		$arrData['SORT'] = $orderx;
		$query = sqlCommandUpdate($table,$arrData,"`ID`='$idx'");
		$result = mysql_query($query);
		}
	}
			header("Location: $referr ");
			exit;
}




function AddSEO($id){
global $tpl;
	$query = "SELECT * FROM `tb_page` WHERE `ID`='$id' AND `LAG`='1' ";
	$result = mysql_query($query);
	$line = mysql_fetch_array($result);
	$tpl->newBlock("SEO_UPDATE");
$tpl->assign("TITLE",$line['TITLE']);
$tpl->assign("HEADER",$line['HEADER']);
$tpl->assign("NAMESITE",$line['NAMESITE']);
$tpl->assign("KEYWORD",$line['KEYWORD']);
$tpl->assign("DESCRIPTION",$line['DESCRIPTION']);
$tpl->assign("CANOICAL",$line['CANOICAL']);
$tpl->assign("GOOGLESITE",$line['GOOGLESITE']);
$tpl->assign("YKEY",$line['YKEY']);
$tpl->assign("MSVALIDATE",$line['MSVALIDATE']);
$tpl->assign("OGTITLE",$line['OGTITLE']);
$tpl->assign("OGSITENAME",$line['OGSITENAME']);
$tpl->assign("OGSITEDESCRIPTION",$line['OGSITEDESCRIPTION']);
$tpl->assign("OGIMAGE",$line['OGIMAGE']);
$tpl->assign("OGURL",$line['OGURL']);
$tpl->assign("CSS",$line['CSS']);
$tpl->assign("JS",$line['JS']);

}

/*
# Function sqlInsert
# Example

$arrData = array();
$arrData['A'] = "aaaa";
$arrData['B'] = "bbbb";
$arrData['C'] = "cccc";
sqlCommandInsert("table",$arrData);
*/


function sqlCommandInsert($strTableName,$arrFieldValue){

	$arrFieldTmp = array();
	$arrValueTmp = array();

	$strFieldTmp = array();
	$strValueTmp = array();

	foreach ($arrFieldValue as $key => $value) {
		$arrFieldTmp[] = "`$key`";
		$arrValueTmp[] = "'$value'";
	}

	$strFieldTmp = implode(",", $arrFieldTmp);
	$strValueTmp = implode(",", $arrValueTmp);

	$strSql = "INSERT INTO `$strTableName`($strFieldTmp) VALUES($strValueTmp)";

	return $strSql;
}

/*
# Function sqlCommandUpdate
# Example

$arrData = array();
$arrData['A'] = "aaaa";
$arrData['B'] = "bbbb";
$arrData['C'] = "cccc";
sqlCommandUpdate("table",$arrData,"`ID`='1'");
*/

function sqlCommandUpdate($strTableName,$arrFieldValue,$strWhere){

	$arrFieldValueTmp = array();
	$strFieldValueTmp = array();

	foreach ($arrFieldValue as $key => $value) {
		$arrFieldValueTmp[] = "`$key`='$value'";
	}

	$strFieldValueTmp = implode(",", $arrFieldValueTmp);

	$strSql = "UPDATE `$strTableName` SET $strFieldValueTmp WHERE $strWhere";

	return $strSql;
}



/*
# Function ThaiDateLong
# Example

ThaiDateLong("YYYY-mm-dd hh:ii:ss",false);
*/

function ThaiDateLong($strDateTime,$booTime){
	$arrThaiMonth = array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");

	list($strYMD, $strTime) = explode(" ", $strDateTime);
	list($intY, $intM, $intD) = explode("-", $strYMD);

	$intY = $intY + 543;
	$strM = $arrThaiMonth[$intM*1];
	$intD = $intD * 1;

	if($booTime) $strShowTime = $strTime;

	return "$intD $strM $intY $strShowTime";
}

/*
# Function ThaiDateShort
# Example

ThaiDateShort("YYYY-mm-dd hh:ii:ss",false);
*/

function ThaiDateShort($strDateTime,$booTime){
	$arrThaiMonth = array("","ม.ค.","ก.พ.","มี.ค.","เม.ษ.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");

	// list($strYMD, $strTime) = explode(" ", $strDateTime);
	// list($intY, $intM, $intD) = explode("-", $strYMD);

	$DateTime = explode(" ", $strDateTime);
	$strYMD = $DateTime[0];
	if(isset($DateTime[1])){
		$strTime = $DateTime[1];
	}else{
		$strTime = '';
	}

	$YMD = explode("-", $strYMD);
	$intY = $YMD[0];
	$intM = $YMD[1];
	$intD = $YMD[2];

	$intY = $intY + 543;
	$strM = $arrThaiMonth[$intM*1];
	$intD = $intD * 1;

	if($booTime) $strShowTime = $strTime;

	return "$intD $strM $intY $strShowTime";
}

/*
# Function EngDateLong
# Example

EngDateLong("YYYY-mm-dd hh:ii:ss",false);
*/



function EngDateLong($strDateTime,$booTime){
	$arrThaiMonth = array("","January","February","March","April","May","June","July","August","September","October","November","December");

	// list($strYMD, $strTime) = explode(" ", $strDateTime);
	// list($intY, $intM, $intD) = explode("-", $strYMD);

	$DateTime = explode(" ", $strDateTime);
	$strYMD = $DateTime[0];
	if(isset($DateTime[1])){
		$strTime = $DateTime[1];
	}else{
		$strTime = '';
	}

	$YMD = explode("-", $strYMD);
	$intY = $YMD[0];
	$intM = $YMD[1];
	$intD = $YMD[2];

	$intY = $intY;
	$strM = $arrThaiMonth[$intM*1];
	$intD = $intD * 1;

	if($booTime) $strShowTime = $strTime;

	return "$intD $strM $intY $strShowTime";
}

/*
# Function EngDateShort
# Example

EngDateShort("YYYY-mm-dd hh:ii:ss",false);
*/

function EngDateShort($strDateTime,$booTime){
	$arrThaiMonth = array("","Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");

	list($strYMD, $strTime) = explode(" ", $strDateTime);
	list($intY, $intM, $intD) = explode("-", $strYMD);

	$intY = $intY;
	$strM = $arrThaiMonth[$intM*1];
	$intD = $intD * 1;

	if($booTime) $strShowTime = $strTime;

	return "$intD $strM $intY $strShowTime";
}

/*
# Function SplitExtension
# Example

SplitExtension("strFileName");
*/

function SplitExtension($strFileName){
   $arrSplit = explode(".", $strFileName);

   return strtolower($arrSplit[count($arrSplit)-1]);
}

/*
# Function SplitText
# Example

SplitText("strText",intLength);
*/

function SplitText($strMessage,$intLength){

	$arrMessage = explode(" ", $strMessage);
	$strNewMessage = $arrMessage[0];

	for($i=1;$i<count($arrMessage);$i++){
		if(strlen($strNewMessage.$arrMessage[$i]) > $intLength){
			break;
		}else{
			$strNewMessage = $strNewMessage." ".$arrMessage[$i];
		}
	}

   return $strNewMessage;
}

/*
# Function ReplaceHtmlTag
# Example

ReplaceHtmlTag("strText",$arrRudeWord);
*/
function ReplaceHtmlTag($strHtmlOld){
	$strHtmlNew = str_replace("<", "&lt;", $strHtmlOld);
	$strHtmlNew = str_replace(">", "&gt;", $strHtmlNew);
	$strHtmlNew = str_replace("\n", "<br>\n", $strHtmlNew);

	return $strHtmlNew;
}

/*
# Function GetMessage
# Example

GetMessage($intId);
*/




function GetMessage($intId){
	global $tableMessage;
	global $conn;

	$sql   = "SELECT * FROM `$tableMessage` WHERE `ID`='$intId'";
	$query = $conn->query($sql) or die($conn->error);
	$line  = $query->fetch_assoc();
	return nl2br($line['MESSAGE']);
}


/*
# Function SaveUploadImg
# Example

$strNewFileName = SaveUploadImg($arrFile,$strPath);

*/

function SaveUploadImg1M($arrFile,$strPath){

	$strFileNameTmp = "";
	if(SplitExtension($arrFile['name']) == "jpg" || SplitExtension($arrFile['name']) == "gif" ){
		$strFileNameTmp = date("Ymdhis")."-".sprintf("%05d",rand()).".".SplitExtension($arrFile['name']);
		if($arrFile['size'] < 1000000){ move_uploaded_file($arrFile['tmp_name'],$strPath.$strFileNameTmp);
		}else{
		$strFileNameTmp = "Over";
		}
	}else{
	$strFileNameTmp = "Over";
	}

	return $strFileNameTmp;
}


function SaveUploadImg100K($arrFile,$strPath){

	$strFileNameTmp = "";
	if(SplitExtension($arrFile['name']) == "jpg" || SplitExtension($arrFile['name']) == "gif" ){
		$strFileNameTmp = date("Ymdhis")."-".sprintf("%05d",rand()).".".SplitExtension($arrFile['name']);
		if($arrFile['size'] < 100000){ move_uploaded_file($arrFile['tmp_name'],$strPath.$strFileNameTmp);
		}else{
		$strFileNameTmp = "Over";
		}
	}else{
	$strFileNameTmp = "Over";
	}

	return $strFileNameTmp;
}

function SaveUploadImg($arrFile,$strPath){

	$strFileNameTmp = "";
	if(SplitExtension($arrFile['name']) == "jpg" || SplitExtension($arrFile['name']) == "gif" || SplitExtension($arrFile['name']) == "png" || SplitExtension($arrFile['name']) == "ico"){
		$strFileNameTmp = date("Ymdhis")."-".sprintf("%05d",rand()).".".SplitExtension($arrFile['name']);
		move_uploaded_file($arrFile['tmp_name'],$strPath.$strFileNameTmp);
	}

	return $strFileNameTmp;
}

/*
# Function SaveUploadFile
# Example

$strNewFileName = SaveUploadFile($arrFile,$strPath);
*/

function SaveUploadFile($arrFile,$strPath){

	$strFileNameTmp = "";
	if(SplitExtension($arrFile['name']) != ""){
		$strFileNameTmp = date("Ymdhis")."-".sprintf("%05d",rand()).".".SplitExtension($arrFile['name']);
		move_uploaded_file($arrFile['tmp_name'],$strPath.$strFileNameTmp);
	}

	return $strFileNameTmp;
}


/*
# Function GetMenuAdmin
# Example

GetMenuAdmin();
*/




function SocialElements(){
	global $tpl;
	global $conn;

	$query = "SELECT * FROM `tb_social` WHERE `ID`='1'";
	$result = mysql_query($query);
	$line = mysql_fetch_array($result);
	if($line["FACEBOOK"]!=""){
	$tpl->newBlock("FACEBOOK_LINK");
	$tpl->assign("url",$line['FACEBOOK']);
	}
	if($line["YOUTUBE"]!=""){
	$tpl->newBlock("YOUTUBE_LINK");
	$tpl->assign("url",$line['YOUTUBE']);
	}
	if($line["EMAIL"]!=""){
	$tpl->newBlock("EMAIL_LINK");
	$tpl->assign("url",$line['EMAIL']);
	}


}


function FirstBanner(){
	global $tpl;
	$query = "SELECT * FROM `tb_banner` WHERE `ID`='1'";
	$result = mysql_query($query);
	$line = mysql_fetch_array($result);
	if($line["PAGE1"]!=""){
	$tpl->newBlock("FIRST_BANNER");
	$tpl->assign("img",$line['PAGE1']);
	$tpl->assign("url",$line['URL1']);
	}
}

function Banner_All(){
	global $tpl;
	$query = "SELECT * FROM `tb_banner` WHERE `ID`='1'";
	$result = mysql_query($query);
	$line = mysql_fetch_array($result);
	if($line["PAGE2_1"]!=""){
	$tpl->newBlock("BANNER1");
	$tpl->assign("img",$line['PAGE2_1']);
	$tpl->assign("url",$line['URL2']);
	}
	if($line["PAGE2_2"]!=""){
	$tpl->newBlock("BANNER2");
	$tpl->assign("img",$line['PAGE2_2']);
	$tpl->assign("url",$line['URL3']);
	}
}

function MenuProblemCAT($lag,$cat){
	global $tpl;
	$query = "SELECT * FROM `tb_problem_gtype_detail` WHERE `LAG`='$lag' ORDER BY `ID`";
	$result = mysql_query($query);

	while ($line = mysql_fetch_array($result)) {
	$tpl->newBlock("CAT_PROBLEM");
	$tpl->assign("id",$line['ID']);
	$tpl->assign("title",$line['NAME']);
		if($line['ID']==$cat){
		$tpl->assign("active1"," style='background: none repeat scroll 0 0 #75AD31;'");
		$tpl->assign("active2"," style='color: #FFFFFF;'");
		}
	}
return true;
}




function GetMenuLAG($page_lang,$key,$group,$id){
	global $tpl;
	global $tableLag;
	global $id;
	global $conn;

		//unset($_SESSION["page_lag"]);
		$_SESSION['page_lag']=$page_lang;
		if($key!="" ||  $group!="" || $id!=""){
			$tpl->newBlock("MENU_KEY");
			$tpl->assign("key",$key);
			$tpl->assign("group",$group);
			$tpl->assign("id",$id);
			}

	$sql = "SELECT * FROM `$tableLag` ORDER BY `ID`";
	$query = $conn->query($sql) or die($conn->error);
	$total = $query->num_rows;
	
	while ($line = $query->fetch_assoc()) {

		$tpl->newBlock("MENU_LAG");

		$tpl->assign("ID",$_SERVER['REQUEST_URI']."?&page_lag=".$line['ID']);

		//$tpl->assign("ID_B","../home/index.php?page_lag=".$line['ID']);
		//$tpl->assign("ID_B",$_SERVER['REQUEST_URI']);

		 $pos = strrpos($_SERVER['REQUEST_URI'],"?");
			 if ($pos === false) {
				 $tpl->assign("ID_B",$_SERVER['REQUEST_URI']."?page_lag=".$line['ID']);
				 if($_GET['id']){$tpl->assign("Page_ID","&id=".$_GET['id']);}


			 }
			 else {
				 $tpl->assign("ID_B","?page_lag=".$line['ID']);
				 if($_GET['id']){$tpl->assign("Page_ID","&id=".$_GET['id']);}

			 }

		$tpl->assign("LAG",$line['LAG']);
		$tpl->assign("NAME",$line['NAME']);

	}
			$tpl->newBlock("MENU_LAG2");
		if($page_lang=="1"){
			$tpl->assign("LAG","th");
			$tpl->assign("NAME","Thai");
		}elseif($page_lang=="2"){
			$tpl->assign("LAG","eng");
			$tpl->assign("NAME","English");
		}
	return true;
}





function GetMenuAdmin($menu2){

	global $tpl;
	global $tableAdminMenu;
	global $tableSetting;
	global $conn;

	$tpl->assign("_ROOT.login_name",$_SESSION['USERNAME']);
	$tpl->assign("_ROOT.last_login",$_SESSION['LAST_LOGIN']);
	$tpl->assign("_ROOT.user_id",$_SESSION['ID']);


	if(is_file("../upload/user/".$_SESSION['THUMB'])){
		$tpl->assign("_ROOT.login_thumb","../upload/user/".$_SESSION['THUMB']."");
	}

////////////////////////////////////////
	// check menu subid
	$sql = "SELECT * FROM `$tableAdminMenu` WHERE `ID` = '".$menu2."' AND `SHOW` = '0' ";
	$query = $conn->query($sql) or die($conn->error);
	while ($line = $query->fetch_assoc()) {
		$subId = $line['SUB_ID'];
	}
////////////////////////////////////////
	$sql = "SELECT * FROM `$tableAdminMenu` WHERE `ID` IN({$_SESSION['PRIVILEGES']}) AND `SHOW` = '0' AND `SUB_ID` = '0' ORDER BY `ORDER` ASC";
	$query = $conn->query($sql) or die($conn->error);
	$total = $query->num_rows;

	while ($line = $query->fetch_assoc()) {
		$tpl->newBlock("MENUBACKEND");
		$tpl->assign("menu",$line['MENU']);
		$tpl->assign("url",$line['URL']);
		$tpl->assign("active",$line['ACTIVE']);
		$tpl->assign("open",$line['OPEN']);
		$tpl->assign("icon",$line['ICON']);
		$tpl->assign("title",$line['TITLE']);

		if($line['ID']==$menu2){
			$tpl->assign("active","active");
		}elseif($line['ID']==$subId){
			$tpl->assign("active","active");
		}else{
			$tpl->assign("active","");
		}

		if($line['SUB']=='1'){
			$tpl->assign("dropdown",'dropdown');
			$tpl->assign("class",'nav-link dropdown-toggle');
			$tpl->assign("url",'href="#navbar-base" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false"');
			$listdropdown = array();
			array_push($listdropdown,'<div class="dropdown-menu"><div class="dropdown-menu-columns"><div class="dropdown-menu-column">');
			$sql2 = "SELECT * FROM `$tableAdminMenu` WHERE `ID` IN({$_SESSION['PRIVILEGES']}) AND `SHOW` = '0' AND `SUB_ID` = '".$line['ID']."' ORDER BY `ORDER` ASC";
			$query2 = $conn->query($sql2) or die($conn->error);
			while ($line2 = $query2->fetch_assoc()) {                          
                array_push($listdropdown,'<a class="dropdown-item" href="'.$line2['URL'].'">'.$line2['MENU'].'</a>');			
            }
			array_push($listdropdown,'</div></div></div>');
			$tpl->assign("listdropdown",implode('', $listdropdown));
		}else{
			$tpl->assign("dropdown",'');
			$tpl->assign("class",'nav-link');
			$tpl->assign("url",'href="'.$line['URL'].'"');
		}

		// if($line['ICON']==""){$tpl->assign("sub","style='padding-left:25px;'");}
	}
//////////////////////////////////////////////////////////////////
//setting
	$sql_set = "SELECT * FROM `$tableSetting` WHERE `LAG` = '1'";
	$query_set = $conn->query($sql_set) or die($conn->error);
	
	while ($line_set = $query_set->fetch_assoc()) {
		$tpl->assign("_ROOT.setting_name",$line_set['NAME']);
		$tpl->assign("_ROOT.setting_time",$line_set['TIME']);
		$tpl->assign("_ROOT.setting_tel",$line_set['TEL']);
		$tpl->assign("_ROOT.setting_fax",$line_set['FAX']);
		$tpl->assign("_ROOT.setting_mobile",$line_set['MOBILE']);
		$tpl->assign("_ROOT.setting_email",$line_set['EMAIL']);
		$tpl->assign("_ROOT.setting_email2",$line_set['EMAIL2']);
		$tpl->assign("_ROOT.setting_line",$line_set['LINE']);
		$tpl->assign("_ROOT.setting_facebook",$line_set['FACEBOOK']);
		$tpl->assign("_ROOT.setting_youtube",$line_set['YOUTUBE']);
		$tpl->assign("_ROOT.setting_twitter",$line_set['TWITTER']);
		$tpl->assign("_ROOT.setting_instagram",$line_set['INSTAGRAM']);
		$tpl->assign("_ROOT.setting_copyright",$line_set['COPYRIGHT']);
		$tpl->assign("_ROOT.setting_js",$line_set['JS']);
		$tpl->assign("_ROOT.setting_piwik",$line_set['PIWIK']);

		if($line_set['LOGO']!=""){
			if(is_file("../upload/setting/full/img/".$line_set['LOGO'])){
			$tpl->assign("_ROOT.setting_logo","<img src='../upload/setting/full/img/".$line_set['LOGO']."' height='50'>");
			$tpl->assign("_ROOT.xsetting_logo","../upload/setting/full/img/".$line_set['LOGO']);		
			}
		}

		if($line_set['LOGO2']!=""){
			if(is_file("../upload/setting/full/img/".$line_set['LOGO2'])){
			$tpl->assign("_ROOT.setting_logo2","<img src='../upload/setting/full/img/".$line_set['LOGO2']."' height='50'>");
			$tpl->assign("_ROOT.xsetting_logo2","../upload/setting/full/img/".$line_set['LOGO2']);		
			}
		}




		if($line_set['LOGO_THUMB']!=""){
			if(is_file("../upload/setting/full/img/".$line_set['LOGO_THUMB'])){
			$tpl->assign("_ROOT.setting_logo_thumb","<img src='../upload/setting/full/img/".$line_set['LOGO_THUMB']."' height='46' alt='logo' class='logo-default' style='margin:0px;'>");
			$tpl->assign("_ROOT.xssetting_logo_thumb","../upload/setting/full/img/".$line_set['LOGO_THUMB']);	
		
		}
		}

	

		if($line_set['FAVICON']!=""){
			if(is_file("../upload/setting/full/img/".$line_set['FAVICON'])){
			$tpl->assign("_ROOT.setting_favicon","../upload/setting/full/img/".$line_set['FAVICON']."");
			}
		}
	}

	return true;
}
//////////////////////////////////////////////////////////////////////


/*
# Function GetMenuMember
# Example

GetMenuMember();
*/

function GetMenuMember(){
	global $tpl;

	return true;
}

function DropDownMenu1(){
	global $tpl;

$query = "SELECT * FROM `tb_refer_type` WHERE `LAG`='1'  ORDER BY `ORDER` ASC";
	$result = mysql_query($query);
	while ($line2 = mysql_fetch_array($result)) {
	$tpl->newBlock("MENU_REFERENCES");
		$tpl->assign("title",$line2["NAME"]);
		$name=str_replace("<br/>","",$line2["NAME_TH"]);

		$tpl->assign("title2",$name);
		$tpl->assign("url","/references/index.php?type=".$line2["ID"]);
	}

$query = "SELECT * FROM `tb_newstype_detail` WHERE `LAG`='1'  ORDER BY `NAME` ASC";
	$result = mysql_query($query);
	while ($line2 = mysql_fetch_array($result)) {
	$tpl->newBlock("MENU_NEWS_EVENTS");
		$tpl->assign("title",$line2["NAME"]);
		$name=str_replace("<br/>","",$line2["NAME_TH"]);
		$tpl->assign("title2",$name);
		$id3=$line2["ID"];
		$tpl->assign("url","/news-events/?key=".$id3);
	}


	$query = "SELECT * FROM `tb_group` WHERE `LAG`='1' AND `GROUP`='0' ORDER BY `ORDER` ASC";
	$result = mysql_query($query);
	while ($line2 = mysql_fetch_array($result)) {
		$tpl->newBlock("MENU_PRODUCT");
		$tpl->assign("title",$line2["NAME"]);
		$name=str_replace("<br/>","",$line2["NAME_TH"]);
		$tpl->assign("title2",$name);
		$id3=$line2["ID"];
		$query2 = "SELECT * FROM `tb_product_detail` WHERE `ID`='$id3' OR `GROUP`='$id3'";
		$result2 = mysql_query($query2);
		$numsg2 = mysql_num_rows($result2);
		$tpl->assign("url","/products/group_detail.php?id=".$id3);
		if($numsg2==0) $tpl->assign("url","#12");

	// Select Sub Data

		/*	$query_sub = "SELECT * FROM `tb_group` WHERE `LAG`='1' AND `GROUP`='".$line2["ID"]."' ORDER BY `ORDER` ASC";
			$result_sub = mysql_query($query_sub);
			while ($line_sub = mysql_fetch_array($result_sub)) {
				$tpl->newBlock("MENU_PRODUCT");
				//$tpl->assign("intGroupID",$line_sub["ID"]);
				$tpl->assign("title","&nbsp;&nbsp;".$line_sub["NAME"]);
				$id3=$line_sub["ID"];
				$tpl->assign("url","/products/group_detail.php?id=".$id3);
		}*/
	}

}

function SelectProduct(){
	global $tpl;
	$query = "SELECT * FROM `tb_group` WHERE `GROUP`='0' ORDER BY `ORDER` ASC";
	$result = mysql_query($query);
	while ($line = mysql_fetch_array($result)) {
		$tpl->newBlock("SELECT_PRODUCT");
		$tpl->assign("title",$line["NAME"]);
		$tpl->assign("id",$line["ID"]);
	}
}




function MenuDropDownProductEbook($lag){
global $tpl;

$query = "SELECT * FROM `tb_group` WHERE `LAG`='$lag' AND `GROUP`='0' ORDER BY `ORDER`";
	$result = mysql_query($query);
	while ($line = mysql_fetch_array($result)) {
	$tpl->newBlock("MENUDROP2");
	$tpl->assign("id",$line['ID']);
	$tpl->assign("name",$line['NAME']);

	$query_sub = "SELECT * FROM `tb_group` WHERE `LAG`='$lag' AND `GROUP`='".$line["ID"]."' ORDER BY `ORDER` ASC";
			$result_sub = mysql_query($query_sub);
			while ($line_sub = mysql_fetch_array($result_sub)) {
				$tpl->newBlock("MENUDROP2");
				$tpl->assign("id",$line_sub['ID']);
				$tpl->assign("name","&nbsp;&nbsp; - ".$line_sub['NAME']);
		}
	}
}


// Drop Down Menu
function DropDownMenu(){
	global $tpl;
	global $tableGroup;

$query = "SELECT * FROM `$tableGroup` WHERE `GROUP`='0' ORDER BY `ORDER` ASC";
$result = mysql_query($query);
$intNo = 0;
while ($line = mysql_fetch_array($result)) {
	$tpl->newBlock("DROPMENU");
		if (($line["ID"]!="1") &&($line["ID"]!="14") &&($line["ID"]!="16") &&($line["ID"]!="17") && ($line["ID"]!="39")){
			$tpl->assign("mlink","ahstoday_products_list.php?group=".$line["ID"]);
		}else{
			$tpl->assign("mlink","#");
		}
	$tpl->assign("strName",$line["NAME"]);
	// Sub Data
	$query_sub = "SELECT * FROM `$tableGroup` WHERE `GROUP`='".$line["ID"]."' ORDER BY `ORDER` ASC";
	$result_sub = mysql_query($query_sub);
	$no =1;
	while ($line_sub = mysql_fetch_array($result_sub)) {
		if($no==1){$tpl->assign("fly","class='fly'");
		$tpl->newBlock("DROPSUBX");
		}
		$no++;
		$tpl->newBlock("DROPSUBMENU");

		$tpl->assign("slink","ahstoday_products_list.php?group=".$line_sub["ID"]);
		$tpl->assign("strName",$line_sub["NAME"]);



	}
}

}
// Drop Down Menu
function MenuProduct_Left2($lag){
global $tpl;
$query	= "SELECT * FROM `tb_group` WHERE LAG='$lag' AND `GROUP`='0'  ORDER BY `ORDER` ASC";
	$result	= mysql_query($query);
	$no1=1;
	while($line = mysql_fetch_array($result)) {
	//$tpl->assign("id",$line["ID"]);
	//$tpl->assign("title",$line["NAME"]);
	$id=$line["ID"];
	$title=$line["NAME"];
	$title2=$line["NAME_TH"];
	$str.='<li><a  title="'.$title2.'" href="javascript:onOffMenu(chap'.$no1.','.$no1.','.$id.')">'.$title.'<b></b></a></li>
	';
//++++++++++++++++++Product
	$str.='<div id="chap'.$no1.'" class="off">Please a moment</div>';
	$no1++;
	}
$tpl->newBlock("CAT");
$tpl->assign("str",$str);
}

//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

function MenuProduct_Left3($lag,$cid,$no_selected1,$no_selected2=""){
global $tpl;
$query	= "SELECT * FROM `tb_group` WHERE LAG='$lag' AND `GROUP`='0'  ORDER BY `ORDER`";
	$result	= mysql_query($query);
	$no1=1;
	while($line = mysql_fetch_array($result)) {
	//$tpl->assign("id",$line["ID"]);
	//$tpl->assign("title",$line["NAME"]);

	$id=$line["ID"];
	$title=$line["NAME"];
	$title2=$line["NAME_TH"];
	$str.='<li><a  title="'.$titl2e.'" href="javascript:onOffMenu(chap'.$no1.','.$no1.','.$id.')">'.$title.'<b></b></a></li>
	';
//++++++++++++++++++Product
	/*if($no1!=$no_selected1){
	$str.='<div id="chap'.$no1.'" class="off">Please a moment </div>';
	$no1++;
	}else{
		*/
		$no2=1;

		//if($no1==$no_selected1){
		//	$str.='<div id="chap'.$no1.'" class="on">';
		//}else{

		//}
		$str.='<div id="chap'.$no1.'" class="off">';

		//++++++++++++++++++++ Menu Group
		$query8 = "SELECT * FROM `tb_product_detail` WHERE LAG='1' AND `GROUP`='$id' AND `SHOW`='Yes' AND `KAKA`='No' ORDER BY `SORT`";
		$result8 = mysql_query($query8);
		$numresult8 = mysql_num_rows($result8);
		if($numresult8>0){
			//if($no1==$no_selected1){

			//$str.='<ul>';
		while ($line8 = mysql_fetch_array($result8)) {
		//+++++++++++++++++++++++++++++++++

		$str.='<li><table cellpadding="10" border="0" width="200"><tr><td valign="top" align="right">-&nbsp;&nbsp;</td><td valign="top"   width="190" style="line-height: 16px;" >
		<a href="../products/product_detail.php?id='.$line8["ID"].'&cat='.$id.'&no='.$no1.'"
		title="'.$line8["NAME"].'" onclick="onOff(chap'.$no1.')">'.$line8["NAME"].'</a></td></tr></table></li>
		';

		//+++++++++++++++++++++++++++++++++
							}
	 		//$str.='</ul>';
			//					}
		}
		//++++++++++++++++++++ Menu Group
		//++++++++++++++++++++ Sub Group
		$query3	= "SELECT * FROM `tb_group` WHERE LAG='1' AND `GROUP`='$id'  ORDER BY `ORDER` ASC";
		$result3	= mysql_query($query3);
		$grp_num=mysql_num_rows($result3);

		if($grp_num>0){
			//$str.='<ul>';
			//++++++++++++++++
			while($line3 = mysql_fetch_array($result3)) {
				//++++++++++++++
				$sub_id=$line3["ID"];
				$title=$line3["NAME"];
				$title2=$line3["NAME_TH"];
				if($no1==$no_selected1){
				$str.='<li><table cellpadding="5" border="0" width="200"><tr><td valign="top" align="right">&nbsp;[+]</td><td valign="top"   width="190" style="line-height: 16px;" ><a  title="'.$title2.'" href="javascript:onOff(chap'.$no1.'_'.$no2.')"  >&nbsp;'.$title.'</a></td></tr></table></li>
	';
				}
					//++++++++++++++++++++Menu Sub Group
						//++++++++++++++++++++++++++++++++++++++++++++++++++
							$query1	= "SELECT * FROM `tb_product_detail` WHERE LAG='1' AND `GROUP`='$sub_id' AND `SHOW`='Yes' AND `KAKA`='No'  ORDER BY `SORT`";
							$result1	= mysql_query($query1);
							$pro_num=mysql_num_rows($result1);

							if($pro_num>0){
								if($no2==$no_selected2 && $no1==$no_selected1){
									$str.='<div id="chap'.$no1.'_'.$no2.'" class="on"><ul>';
								}else{
									$str.='<div id="chap'.$no1.'_'.$no2.'" class="off"><ul>';
								}
								//+++++++++++++++
								while($line2 = mysql_fetch_array($result1)){
								if($no1==$no_selected1){
								$str.='<li><table cellpadding="10" border="0" width="200"><tr><td valign="top" align="right">-&nbsp;&nbsp;</td><td valign="top"   width="190" style="line-height: 16px;" ><a href="../products/product_detail.php?id='.$line2["ID"].'&cat='.$sub_id.'&no='.$no1.'&no2='.$no2.'" title="'.$line2["NAME_TH"].'" onclick="onOff(chap'.$no1.')" >'.$line2["NAME"].'</a></td></tr></table></li>
		';
									}

								}
								$str.='</ul></div>';
								//+++++++++++++++
							}
							$no2++;
					//++++++++++++++++++++Menu Sub Group
				//++++++++++++++
			}
			//$str.='</ul>';
			//++++++++++++++++
		}
		//++++++++++++++++++++ Sub Group

	$str.='</div>';



	$no1++;
	}
$tpl->newBlock("CAT");
$tpl->assign("str",$str);
}


//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

function MenuProduct_Left($lag){
global $tpl;
//++++++++++++++++++++++CAT MENU
$str='';
$no1=1;
$query	= "SELECT * FROM `tb_group` WHERE LAG='$lag' AND `GROUP`='0'  ORDER BY `ORDER` ASC";
	$result	= mysql_query($query);
	while($line = mysql_fetch_array($result)) {
	//$tpl->assign("id",$line["ID"]);
	//$tpl->assign("title",$line["NAME"]);
	$id=$line["ID"];
	$title=$line["NAME"];
	$title2=$line["NAME_TH"];
	$str.='<li><a  title="'.$title2.'" href="javascript:onOff(chap'.$no1.')">'.$title.'<b></b></a></li>
	';
//++++++++++++++++++Product
	$query1	= "SELECT * FROM `tb_product_detail` WHERE LAG='$lag' AND `GROUP`='$id'  ORDER BY `NAME` ASC";
	$result1	= mysql_query($query1);
	$pro_num=mysql_num_rows($result1);
	$str.='<div id="chap'.$no1.'" class="off"><ul>';
	if($pro_num>0){
		while($line2 = mysql_fetch_array($result1)){
		$str.='<li><a href="../products/product_detail.php?id='.$line2["ID"].'" title="'.$line2["NAME_TH"].'" onclick="onOff(chap'.$no1.')">&nbsp;&nbsp;  - '.$line2["NAME"].'</a></li>
		';
		}
		$str.='</ul>';
	}

//++++++++++++++++++Product
//----------------------------Sub Group
$query3	= "SELECT * FROM `tb_group` WHERE LAG='$lag' AND `GROUP`='$id'  ORDER BY `ORDER` ASC";
	$result3	= mysql_query($query3);
	$grp_num=mysql_num_rows($result3);
	//$str.='<div id="chap'.$no1.'" class="off"><ul>';
	//$str.='<ul>';
	if($grp_num>0){
	$no2=1;
	while($line3 = mysql_fetch_array($result3)) {
	$sub_id=$line3["ID"];
	$title=$line3["NAME"];
	$title2=$line3["NAME_TH"];
	$str.='<li><a  title="'.$title2.'" href="javascript:onOff(chap'.$no1.'_'.$no2.')">&nbsp;&nbsp;[+] '.$title.'</a></li>
	';

	//++++++++++++++++++Sub Group Product
	$query1	= "SELECT * FROM `tb_product_detail` WHERE LAG='1' AND `GROUP`='$sub_id'  ORDER BY `NAME` ASC";
	$result1	= mysql_query($query1);
	$pro_num=mysql_num_rows($result1);
	if($pro_num>0){
		$str.='<div id="chap'.$no1.'_'.$no2.'" class="off"><ul>';
		while($line2 = mysql_fetch_array($result1)){
		$str.='<li><a href="../products/product_detail.php?id='.$line2["ID"].'" title="'.$line2["NAME_TH"].'" onclick="onOff(chap'.$no1.')">&nbsp;&nbsp;&nbsp;&nbsp;  - '.$line2["NAME"].'</a></li>
		';
		}
		//$str.='</ul></div></ul>';
		$str.='</ul></div>';
	}

//++++++++++++++++++Sub Group Product


	$no2++;
	}
}
//----------------------------Sub Group
		$no1++;
		$str.='</div>';
	}
$str.='</ul>';
$tpl->newBlock("CAT");
$tpl->assign("str",$str);
//++++++++++++++++++++++CAT MENU
}

function MenuDropDownProblem($lag){
global $tpl;

$query = "SELECT * FROM `tb_problem_gtype_detail` WHERE `LAG`='$lag' ORDER BY `NAME`";
	$result = mysql_query($query);
	while ($line = mysql_fetch_array($result)) {
	$tpl->newBlock("MENU_DROP_PROBLEM");
	$tpl->assign("id",$line['ID']);
	$tpl->assign("name",$line['NAME']);
	}

$str='';
$query = "SELECT * FROM `tb_problem_gtype_detail` WHERE `LAG`='$lag' ORDER BY `NAME`";
	$result = mysql_query($query);
	while ($line = mysql_fetch_array($result)) {
	$group_id=$line['ID'];
	$str.='if (chosen == "'.$group_id.'") {';
	$str.='selbox.options[selbox.options.length] = new Option(\'\',\'\');';
	//$str.= iconv('TIS-620','UTF-8','selbox.options[selbox.options.length] = new Option(\'·Ñé§ËÁ´\',\'\');');
$query1 = "SELECT * FROM `tb_problem_detail` WHERE `LAG`='$lag' AND `TID`='$group_id' ORDER BY `TITLE`";
	$result1 = mysql_query($query1);
	while ($line1 = mysql_fetch_array($result1)) {
$product_id=$line1['ID'];
$name=$line1['TITLE'];
$str.='selbox.options[selbox.options.length] = new Option(\''.$name.'\',\''.$product_id.'\');';

								}
								$str.='}';
							}
$tpl->newBlock("MENU_JS_PROBLEM");
$tpl->assign("code1",$str);
}

function MenuDropDownProduct2($lag){
global $tpl;

$query = "SELECT * FROM `tb_group` WHERE `LAG`='$lag' AND `GROUP`='0' ORDER BY `ORDER`";
	$result = mysql_query($query);
	while ($line = mysql_fetch_array($result)) {
	$tpl->newBlock("MENUX_DROP1");
	$tpl->assign("id",$line['ID']);
	$tpl->assign("name",$line['NAME']);

	$query_sub = "SELECT * FROM `tb_group` WHERE `LAG`='$lag' AND `GROUP`='".$line["ID"]."' ORDER BY `ORDER` ASC";
			$result_sub = mysql_query($query_sub);
			while ($line_sub = mysql_fetch_array($result_sub)) {
				$tpl->newBlock("MENUX_DROP1");
				$tpl->assign("id",$line_sub['ID']);
				$tpl->assign("name","&nbsp;&nbsp; - ".$line_sub['NAME']);
		}
	}

$str='';
$query = "SELECT * FROM `tb_group` WHERE `LAG`='$lag' ORDER BY `NAME`";
	$result = mysql_query($query);
	while ($line = mysql_fetch_array($result)) {
	$group_id=$line['ID'];
	$str.='if (chosen == "'.$group_id.'") {';
	$str.='selbox.options[selbox.options.length] = new Option(\'\',\'\');';
$query1 = "SELECT * FROM `tb_product_detail` WHERE `LAG`='$lag' AND `GROUP`='$group_id' ORDER BY `NAME`";
	$result1 = mysql_query($query1);
	while ($line1 = mysql_fetch_array($result1)) {
$product_id=$line1['ID'];
$name=$line1['NAME'];
$str.='selbox.options[selbox.options.length] = new Option(\''.$name.'\',\''.$product_id.'\');';

								}
								$str.='}';
							}
$tpl->newBlock("MENU_JS");
$tpl->assign("code1",$str);
}

function MenuDropDownProduct($lag){
global $tpl;

$query = "SELECT * FROM `tb_group` WHERE `LAG`='$lag' AND `GROUP`='0' ORDER BY `ORDER`";
	$result = mysql_query($query);
	while ($line = mysql_fetch_array($result)) {
	$tpl->newBlock("MENU_DROP1");
	$tpl->assign("id",$line['ID']);
	$tpl->assign("name",$line['NAME']);

	$query_sub = "SELECT * FROM `tb_group` WHERE `LAG`='$lag' AND `GROUP`='".$line["ID"]."' ORDER BY `ORDER` ASC";
			$result_sub = mysql_query($query_sub);
			while ($line_sub = mysql_fetch_array($result_sub)) {
				$tpl->newBlock("MENU_DROP1");
				$tpl->assign("id",$line_sub['ID']);
				$tpl->assign("name","&nbsp;&nbsp; - ".$line_sub['NAME']);
		}
	}

$str='';
$query = "SELECT * FROM `tb_group` WHERE `LAG`='$lag' ORDER BY `NAME`";
	$result = mysql_query($query);
	while ($line = mysql_fetch_array($result)) {
	$group_id=$line['ID'];
	$str.='if (chosen == "'.$group_id.'") {';
	$str.='selbox.options[selbox.options.length] = new Option(\'\',\'\');';
$query1 = "SELECT * FROM `tb_product_detail` WHERE `LAG`='$lag' AND `GROUP`='$group_id' ORDER BY `NAME`";
	$result1 = mysql_query($query1);
	while ($line1 = mysql_fetch_array($result1)) {
$product_id=$line1['ID'];
$name=$line1['NAME'];
$str.='selbox.options[selbox.options.length] = new Option(\''.$name.'\',\''.$product_id.'\');';

								}
								$str.='}';
							}
$tpl->newBlock("MENU_JS");
$tpl->assign("code1",$str);
}

// Function for AHStoday Only
function GetFooter(){
	global $tpl;
	global $tableAboutUs;
	global $tableCustomerCare;
	global $tableContactUs;

	// About us
	$query = "SELECT * FROM `$tableAboutUs` WHERE `STATUS`='Show' ORDER BY `ID` ASC";
	$result = mysql_query($query);

	while ($line = mysql_fetch_array($result)) {
		$tpl->newBlock("ABOUTAHS");
		$tpl->assign("id",$line['ID']);
		$tpl->assign("title",$line['TITLE']);
	}

    //  Customer Care
	$query = "SELECT * FROM `$tableCustomerCare` WHERE `STATUS`='Show' ORDER BY `ID` ASC";
	$result = mysql_query($query);

	while ($line = mysql_fetch_array($result)) {
		$tpl->newBlock("CUSTOMER_CARE");
		$tpl->assign("id",$line['ID']);
		$tpl->assign("title",$line['TITLE']);
	}

	// Contact Us

	$query = "SELECT * FROM `$tableContactUs` WHERE `STATUS`='Show' ORDER BY `ID` ASC";
	$result = mysql_query($query);

	while ($line = mysql_fetch_array($result)) {
		$tpl->newBlock("CONTACTUS");
		$tpl->assign("id",$line['ID']);
		$tpl->assign("title",$line['TITLE']);
	}


	return true;
}




// key page
function Keypage($pid){
	global $tpl;
	global $tablePage;
$query = "SELECT * FROM `$tablePage` WHERE `ID`='$pid'";
$result = mysql_query($query);
while($line = mysql_fetch_array($result)){
	$no++;
	$tpl->newBlock("KEY");

	// Check file
	if(is_file("upload/pages/".sprintf("%010d",$pid)."_1.jpg")){$file=1;$img="upload/pages/".sprintf("%010d",$pid)."_1.jpg";}
	if(is_file("upload/pages/".sprintf("%010d",$pid)."_1.png")){$file=1;$img="upload/pages/".sprintf("%010d",$pid)."_1.png";}
	if($file=="1"){
	$tpl->assign("img",$img);
	}else{
	$tpl->assign("img","images/slide/slide1.png");
	}
}

	return true;
	}


////////// Shopping //////////////////////////
function NUMCART($lag){
global $tpl;
global $lag;
global $tableProductDetail;

	if(isset($_COOKIE['les_cart']) && count($_COOKIE['les_cart'])>0){
		$rs = unserialize(base64_decode($_COOKIE['les_cart']));
		$tpl->assign('_ROOT.num_cart',count($rs));
	}else{
		$tpl->assign('_ROOT.num_cart',"0");
	}

	if(isset($_COOKIE['les_cart']) && count($_COOKIE['les_cart'])>0){
		$data = unserialize(base64_decode($_COOKIE['les_cart']));
		$setId = array();
		if($data)
		foreach($data as $k => $v){
			$setId[] = (int)intval($k);

		}

	$no=1;
		if(count($setId)>0){
			$sql = "select * from `$tableProductDetail` where `ID` in('".implode("','",$setId)."') and `LAG`='".$lag."' ";
			$result = mysql_query($sql) or die($sql);

			while($line   = mysql_fetch_assoc($result)){
				$tpl->newBlock("SHORT_CARTLIST");
				$id = $line["ID"];
				if(is_file("upload/product/img/thumb/".$line["THUMB"])){
					$tpl->assign("img","<img src='upload/product/img/thumb/".$line["THUMB"]."' border='1' width='100'>");
				}

				$tpl->assign("title",$line["TITLE"]);

				$tpl->assign("num",$data[$id]);


			}

		}
	}

}


/*
function getPromotion($lag="1", $auth_data, $type = null){
	$where = ' and CON ="1" ';
	if(is_array($auth_data) && isset($auth_data['auth_mode']) && $auth_data['auth_mode']=='store'){
		$where = ' and CUS ="1" ';
	}
	// $sql = 'select RELATED from tb_promotion_detail where LAG="'.mysql_real_escape_string($lag).'" and STARTDATE<="'.date('Y-m-d').'" and ENDDATE>="'.date('Y-m-d').'" and STATUS="Show" '.$where.' order by SUB desc';
	// $result = mysql_query($sql);
	// $rs = mysql_fetch_assoc($result);
	// $data = explode(',',$rs['RELATED']);
	// if(is_array($data) && count($data)>0){
	// 	foreach($data as $key => $val){
	// 		$data[$key] = trim($val);
	// 	}
	// }
	return $data;
}
*/


function getPromotion($auth_data, $lag = "1", $type = null) {
    $where = ' and CON ="1" ';

    if (is_array($auth_data) && isset($auth_data['auth_mode']) && $auth_data['auth_mode'] == 'store') {
        $where = ' and CUS ="1" ';
    }


    return $data;
}


function sumPoint($product_set, $promotion_arr, $auth_mode=false, $lag = 1){
	$setId = array();
	foreach($product_set as $k => $v){
		$setId[] = (int)intval($k);
	}

	if(count($setId)>0){
		$point = 0;
		$sum_price = 0;
		$sql = 'select ID, PRICES from tb_product_detail where LAG="'.mysql_real_escape_string($lag).'" and ID in("'.implode('","',$setId).'") ';
		$result = mysql_query($sql);
		while($product_data = mysql_fetch_assoc($result)){
			if(($auth_mode=='normal' && $product_data["CON_POINT"]==1) || ($auth_mode=='store' && $product_data["CUS_POINT"]==1)) {
				$price = $product_data['CON_PRICE'];
				if($auth_mode && $auth_mode=='store'){
					$price = $product_data['CUS_PRICE'];
				}
				$num = $product_set[$product_data['ID']];

				$vat_rate = number_format(($price*7/100), 2, '.', '');

				$price = $price + $vat_rate;
				$sum_price = $sum_price+($price*$num);
				if(isset($product_data['ID']) && is_array($promotion_arr) && in_array($product_data['ID'], $promotion_arr)){
					$promotion_data = getPromotionData($lag,$auth_mode);
					if(isset($promotion_data['SPOINT']) && $promotion_data['SPOINT']>0)
						$point = $point + ($num*$promotion_data['SPOINT']);
				}

			}
		}
		//echo $point; exit();
		$point = $point + floor($sum_price/100);

		return $point;
	}
}

function productPoint($product_id, $num, $promotion_arr,$auth_mode=false, $lag = 1){
	$data = array(
		'normal_point' => 0,
		'extra_point' => 0,
		'point' => 0
	);

	$sql = 'select ID, PRICES from tb_product_detail where LAG="'.mysql_real_escape_string($lag).'" and ID ="'.mysql_real_escape_string($product_id).'" ';
	$result = mysql_query($sql);
	$product_data = mysql_fetch_assoc($result);
	if(($auth_mode=='normal' && $product_data["CON_POINT"]==1) || ($auth_mode=='store' && $product_data["CUS_POINT"]==1)) {
		$price = $product_data['CON_PRICE'];
		if($auth_mode && $auth_mode=='store'){
			$price = $product_data['CUS_PRICE'];
		}

		$vat_rate = number_format(($price*7/100), 2, '.', '');
		$price = $price + $vat_rate;
		$data['normal_point'] = ($price*$num)/100;
		if(isset($product_data['ID']) && is_array($promotion_arr) && in_array($product_data['ID'], $promotion_arr)){
			$promotion_data = getPromotionData($lag,$auth_mode);
			if(isset($promotion_data['SPOINT']) && $promotion_data['SPOINT']>0)
				$data['extra_point'] = $num*$promotion_data['SPOINT'];
		}

		$data['point'] = $data['normal_point'] + $data['extra_point'];

	}

	return $data;
}

function orderType($id=''){
	$data = array(
		"tranfer" => "โอนเงิน"
	);
	$return = $data;
	if($id!='') $return = $data[$id];
	return $return;
}

function orderStatus($id=''){
	$data = array(
		"new" => "สั่งซื้อใหม่",
		"wait" =>"รอตรวจสอบ",
		"cancel" =>"ยกเลิกใบสั่งซื้อ",
		"keep" =>"เก็บใบสั่งซื้อไว้ ",
		"payment" =>"ชำระเงินแล้ว",
		"delivery" =>"ส่งของ",
		"completed" =>"ได้รับของแล้ว"
	);
	$return = $data;
	if($id!='') $return = $data[$id];
	return $return;
}
