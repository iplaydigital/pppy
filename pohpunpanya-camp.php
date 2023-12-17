<?php error_reporting(E_ALL ^ E_NOTICE);

include_once("./include/config.inc.php");
include_once("./include/class.inc.php");
include_once("./include/class.TemplatePower.inc.php");
include_once("./include/function.inc.php");



$tpl = new TemplatePower("./template/_tp_master.html");
$tpl->assignInclude("body", "./template/_tp_pohpunpanya-camp.html");
$tpl->prepare();


##########
if(isset($_POST['language'])){$_SESSION['lag'] = $_POST['language'];}
elseif(!isset($_SESSION['lag'])){$_SESSION['lag'] = '1';}
else{}
FRONTLANGUAGE($_SESSION['lag']);
##########


/////////////////////////////////////////////////
$arrayCampModel = array();
$query = "SELECT * FROM `$tableCampModel` WHERE `STATUS` = 'Show' ORDER BY `ORDER` ASC ";
$result = $conn->query($query);
while($line = $result->fetch_assoc()){
		array_push($arrayCampModel, '<a href="#" class="drp_province_list top w-dropdown-link" onclick="chooseModal('.$line['ID'].')" >รุ่นที่ '.$line['ID'].'/2566</a>');
}
$tpl->assign("_ROOT.arrayCampModel",implode('', $arrayCampModel));

/////////////////////////////////////////////////
$arrayCampProvince = array();
	$query = "SELECT main.*,a.*
	FROM `$tableCampProvince` as main 
	LEFT JOIN `$tableCampProvinceDetail` as a ON a.ID_PROVINCE = main.ID";
	$query .= " WHERE main.STATUS = 'Show' AND main.ID_MODEL = '1' AND a.LAG = '".$_SESSION['lag']."' ORDER BY main.ORDER ASC ";
	$result = $conn->query($query);
	while($line = $result->fetch_assoc()){
		array_push($arrayCampProvince, '<a href="#" id="province'.$line['ID_PROVINCE'].'" data-title="'.$line['TITLE'].'" class="drp_province_list top w-dropdown-link" onclick="chooseCity('.$line['ID_PROVINCE'].')" >'.$line['TITLE'].'</a>');

		$query2 = "SELECT main.*,a.*
		FROM `$tableCampDistrict` as main 
		LEFT JOIN `$tableCampDistrictDetail` as a ON a.ID_DISTRICT = main.ID";
		$query2 .= " WHERE main.ID_MODEL = '1' AND main.ID_PROVINCE = '".$line['ID']."' AND a.LAG = '".$_SESSION['lag']."' AND  main.STATUS = 'Show' ORDER BY main.ORDER ASC ";
		$result2 = $conn->query($query2);
		while($line2 = $result2->fetch_assoc()){
			$query3 = "SELECT * FROM `$tableCampSchool` WHERE `STATUS` = 'Show' AND `ID_MODEL` = '1' AND `ID_PROVINCE` = '".$line['ID_PROVINCE']."' AND `ID_DISTRICT` = '".$line2['ID_DISTRICT']."' ";
			$result3 = $conn->query($query3);
			if($result3->num_rows > '1'){
				array_push($arrayCampProvince, '<a href="#" id="district'.$line2['ID_DISTRICT'].'" data-title="'.$line2['TITLE'].'" class="drp_province_list  w-dropdown-link" onclick="chooseDistrict('.$line2['ID_DISTRICT'].')" >'.$line2['TITLE'].'<span style="float: right;">'.$result3->num_rows.' โรงเรียน <strong>▸</strong></span></a>');
			}else{
				array_push($arrayCampProvince, '<a href="#" id="district'.$line2['ID_DISTRICT'].'" data-title="'.$line2['TITLE'].'" class="drp_province_list  w-dropdown-link" onclick="chooseDistrict('.$line2['ID_DISTRICT'].')" >'.$line2['TITLE'].'<span style="float: right;padding-right:20px;">'.$result3->num_rows.' โรงเรียน </span></a>');
			}
			
		}

	}
$tpl->assign("_ROOT.arrayCampProvince",implode('', $arrayCampProvince));
/////////////////////////////////////////////////
	$arrayCampSchool = array();
	$arrayCampSchoolDetail = array();
	$query = "SELECT main.*,a.*
	FROM `$tableCampSchool` as main 
	LEFT JOIN `$tableCampSchoolDetail` as a ON a.ID_SCHOOL = main.ID";
	$query .= " WHERE main.STATUS = 'Show' AND main.ID_MODEL = '1' AND a.LAG = '".$_SESSION['lag']."' ORDER BY main.ORDER ASC ";
	$result = $conn->query($query);
	while($line = $result->fetch_assoc()){
		array_push($arrayCampSchool, '<a href="school-detail.php?id='.$line['ID_SCHOOL'].'" class="drp_school_list w-dropdown-link" onmouseover="viewSchool('.$line['ID_SCHOOL'].');" onmouseout="closeViewSchhol();" style="display: block;">'.$line['TITLE'].'</a>');
		// array_push($arrayCampSchoolDetail, '<div class="tree treeModel'.$line['ID_MODEL'].' treeCity'.$line['ID_PROVINCE'].' treeDistrict'.$line['ID_DISTRICT'].' treeSchool'.$line['ID_SCHOOL'].'" id="tree'.$line['ID_SCHOOL'].'" data-modal="'.$line['ID_MODEL'].'" data-district="'.$line['ID_DISTRICT'].'" onmouseover="viewSchool('.$line['ID_SCHOOL'].');">
    //       <div class="treeImg"><img src="images/tree.png"><span>'.$line['ID_SCHOOL'].'</span></div>
    //       <div class="treeView treeViewSchool'.$line['ID_SCHOOL'].'">
    //         <img src="images/tree_view.png"><span>'.$line['ID_SCHOOL'].'</span>
    //         <h4>'.$line['TITLE'].'</h4>
    //         <p>'.$line['DESC'].'<a href="'.$line['LINK'].'">เพิ่มเติม</a></p>
    //       </div>
    //     </div>');

	}
$tpl->assign("_ROOT.arrayCampSchool",implode('', $arrayCampSchool));

/////////////////////////////////////////////////
$arrayCampMapMobile = array();
$arrayCampMapTablet = array();
$arrayCampMapPc = array();
$no='0';
$query = "SELECT * FROM `$tableCampSchool` as main 
LEFT JOIN `$tableCampSchoolDetail` as a ON a.ID_SCHOOL = main.ID";
$query .= " WHERE main.STATUS = 'Show' AND a.LAG = '".$_SESSION['lag']."' ORDER BY main.ORDER ASC ";
$result = $conn->query($query);
while($line = $result->fetch_assoc()){
	$no++;
	array_push($arrayCampMapMobile, '#tree'.$no.' {top: 0;left: 0;margin: '.$line['MAP_MOBILE'].';}');
	array_push($arrayCampMapTablet, '#tree'.$no.' {top: 0;left: 0;margin: '.$line['MAP_TABLET'].';}');
	array_push($arrayCampMapPc, '#tree'.$no.' {top: 0;left: 0;margin: '.$line['MAP_PC'].';}');
}
$tpl->assign("_ROOT.arrayCampMapMobile",implode('', $arrayCampMapMobile));
$tpl->assign("_ROOT.arrayCampMapTablet",implode('', $arrayCampMapTablet));
$tpl->assign("_ROOT.arrayCampMapPc",implode('', $arrayCampMapPc));

/////////////////////////////////////////////////

$arrayNewsCategory = array();
$query = "SELECT * FROM `$tableNewsCategory` ORDER BY `ORDER` ASC ";
$result = $conn->query($query);
while($line = $result->fetch_assoc()){

	array_push($arrayNewsCategory, '<a href="'.$line['URL'].'" class="nag-button w-button">'.$line['TITLE_'.$_SESSION['lagText']].'</a>');
}

$tpl->assign("_ROOT.arrayNewsCategory",implode('', $arrayNewsCategory));


$query = "SELECT main.*,a.TITLE_".$_SESSION['lagText']." as TITLECAT
FROM `$tableNews` as main 
LEFT JOIN `$tableNewsCategory` as a ON a.ID = main.ID_NEWS_CAT";
$query .= " ORDER BY main.DAY DESC, main.ID DESC LIMIT 0,3 ";
$result = $conn->query($query);
while($line = $result->fetch_assoc()){
	$tpl->newBlock("LISTNEWS");
	$tpl->assign("titlecat",$line['TITLECAT']);
	$tpl->assign("title",nl2br($line['TITLE_'.$_SESSION['lagText']]));
	$tpl->assign("desc",nl2br($line['DESC_'.$_SESSION['lagText']]));
	$tpl->assign("img",$url_main.'/upload/news/'.$line['FULLIMG']);
	$tpl->assign("id",$line['SLUG']);

	if($_SESSION['lag']=='2'){
		$tpl->assign("date",EngDateLong($line['DAY'],'false'));
	}else{
		$tpl->assign("date",ThaiDateShort($line['DAY'],'false'));
	}


	
	
}




FRONTPAGESEO('3',$_SESSION['lag']);
$tpl->printToScreen();

