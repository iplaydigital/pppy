<?php
error_reporting(E_ALL ^ E_NOTICE);

include_once("include/config.inc.php");
include_once("include/class.inc.php");
include_once("include/class.TemplatePower.inc.php");
include_once("include/function.inc.php");

$tpl = new TemplatePower("template/_tp_master.html");
$tpl->assignInclude("body", "template/_tp_index.html");
$tpl->prepare();

// Set language session variable
if (isset($_POST['language'])) {
    $_SESSION['lag'] = $_POST['language'];
} elseif (!isset($_SESSION['lag'])) {
    $_SESSION['lag'] = '1';
}

FRONTLANGUAGE($_SESSION['lag']);

// ... (rest of the code remains unchanged)

// Fixed: CampProvince SQL Injection | 21122023 by P'Ake
$arrayCampProvince = array();
$query = "SELECT main.*,a.*
    FROM `$tableCampProvince` as main 
    LEFT JOIN `$tableCampProvinceDetail` as a ON a.ID_PROVINCE = main.ID
    WHERE main.STATUS = 'Show' AND main.ID_MODEL = '1' AND a.LAG = ? 
    ORDER BY main.ORDER ASC";

// Use prepared statements
$stmt = $conn->prepare($query);

if ($stmt) {
    $stmt->bind_param("s", $_SESSION['lag']);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($line = $result->fetch_assoc()) {
        array_push($arrayCampProvince, '<a href="#" id="province' . $line['ID_PROVINCE'] . '" data-title="' . $line['TITLE'] . '" class="drp_province_list top w-dropdown-link" onclick="chooseCity(' . $line['ID_PROVINCE'] . ')" >' . $line['TITLE'] . '</a>');

        $query2 = "SELECT main.*,a.*
            FROM `$tableCampDistrict` as main 
            LEFT JOIN `$tableCampDistrictDetail` as a ON a.ID_DISTRICT = main.ID
            WHERE main.ID_MODEL = '1' AND main.ID_PROVINCE = ? AND a.LAG = ? AND  main.STATUS = 'Show' ORDER BY main.ORDER ASC";

        // Use another prepared statement
        $stmt2 = $conn->prepare($query2);

        if ($stmt2) {
            $stmt2->bind_param("ss", $line['ID'], $_SESSION['lag']);
            $stmt2->execute();
            $result2 = $stmt2->get_result();

            while ($line2 = $result2->fetch_assoc()) {
                $query3 = "SELECT * FROM `$tableCampSchool` WHERE `STATUS` = 'Show' AND `ID_MODEL` = '1' AND `ID_PROVINCE` = ? AND `ID_DISTRICT` = ?";
                
                // Another prepared statement
                $stmt3 = $conn->prepare($query3);

                if ($stmt3) {
                    $stmt3->bind_param("ss", $line['ID_PROVINCE'], $line2['ID_DISTRICT']);
                    $stmt3->execute();
                    $result3 = $stmt3->get_result();

                    if ($result3->num_rows > 1) {
                        array_push($arrayCampProvince, '<a href="#" id="district' . $line2['ID_DISTRICT'] . '" data-title="' . $line2['TITLE'] . '" class="drp_province_list  w-dropdown-link" onclick="chooseDistrict(' . $line2['ID_DISTRICT'] . ')" >' . $line2['TITLE'] . '<span style="float: right;">' . $result3->num_rows . ' โรงเรียน <strong>▸</strong></span></a>');
                    } else {
                        array_push($arrayCampProvince, '<a href="#" id="district' . $line2['ID_DISTRICT'] . '" data-title="' . $line2['TITLE'] . '" class="drp_province_list  w-dropdown-link" onclick="chooseDistrict(' . $line2['ID_DISTRICT'] . ')" >' . $line2['TITLE'] . '<span style="float: right;padding-right:20px;">' . $result3->num_rows . ' โรงเรียน </span></a>');
                    }
                }

                $stmt3->close();
            }

            $stmt2->close();
        }
    }

    $stmt->close();
}

$tpl->assign("_ROOT.arrayCampProvince", implode('', $arrayCampProvince));

/////////////////////////////////////////////////
$arrayCampSchool = array();
$arrayCampSchoolDetail = array();
$query = "SELECT main.*, a.*
FROM `$tableCampSchool` as main 
LEFT JOIN `$tableCampSchoolDetail` as a ON a.ID_SCHOOL = main.ID";
$query .= " WHERE main.STATUS = 'Show' AND main.ID_MODEL = '1' AND a.LAG = ? ORDER BY main.ORDER ASC ";

$stmt = $conn->prepare($query);
$stmt->bind_param('s', $_SESSION['lag']);
$stmt->execute();
$result = $stmt->get_result();

while ($line = $result->fetch_assoc()) {
    $ex = explode('=', $line['LINK']);
    array_push($arrayCampSchool, '<a href="' . $url_main . '/schools/' . $ex[1] . '" class="drp_school_list w-dropdown-link" onmouseover="viewSchool(' . $line['ID_SCHOOL'] . ');" onmouseout="closeViewSchhol();" style="display: block;">' . $line['TITLE'] . '</a>');
}

$tpl->assign("_ROOT.arrayCampSchool", implode('', $arrayCampSchool));
$stmt->close();
/////////////////////////////////////////////////

$arrayCampMapMobile = array();
$arrayCampMapTablet = array();
$arrayCampMapPc = array();
$noCampSchool = '0';
$query = "SELECT * FROM `$tableCampSchool` as main 
LEFT JOIN `$tableCampSchoolDetail` as a ON a.ID_SCHOOL = main.ID";
$query .= " WHERE main.STATUS = 'Show' AND a.LAG = ? ORDER BY main.ORDER ASC ";

$stmt = $conn->prepare($query);
$stmt->bind_param('s', $_SESSION['lag']);
$stmt->execute();
$result = $stmt->get_result();

while ($line = $result->fetch_assoc()) {
    $noCampSchool++;
    array_push($arrayCampMapMobile, '#tree' . $noCampSchool . ' {top: 0;left: 0;margin: ' . $line['MAP_MOBILE'] . ';}');
    array_push($arrayCampMapTablet, '#tree' . $noCampSchool . ' {top: 0;left: 0;margin: ' . $line['MAP_TABLET'] . ';}');
    array_push($arrayCampMapPc, '#tree' . $noCampSchool . ' {top: 0;left: 0;margin: ' . $line['MAP_PC'] . ';}');
}

$tpl->assign("_ROOT.arrayCampMapMobile", implode('', $arrayCampMapMobile));
$tpl->assign("_ROOT.arrayCampMapTablet", implode('', $arrayCampMapTablet));
$tpl->assign("_ROOT.arrayCampMapPc", implode('', $arrayCampMapPc));

$stmt->close();
/////////////////////////////////////////////////
$arraySlide = array();
$noSlide = '0';
$query = "SELECT main.*, a.*
          FROM `$tableIndexSlide` as main 
          LEFT JOIN `$tableIndexSlideDetail` as a ON a.ID_SLIDE = main.ID 
          WHERE main.DEL = '0' AND main.STATUS = 'Show' AND a.LAG = ? ORDER BY main.ORDER DESC ";

$stmt = $conn->prepare($query);
$stmt->bind_param('s', $_SESSION['lag']);
$stmt->execute();
$result = $stmt->get_result();

while ($line = $result->fetch_assoc()) {
    $noSlide++;
    array_push($arraySlide, '<div class="slide w-slide">
        <a href="' . $line['URL'] . '" class="sliderlink w-inline-block">
          <img src="' . $url_main . '/upload/slide/' . $line['BANNER_NAME'] . '" loading="lazy" height="" alt="' . $line['TITLE'] . '" 
          sizes="(max-width: 1920px) 100vw, 1920px" 
          srcset="' . $url_main . '/upload/slide/' . $line['BANNER_500'] . ' 500w, 
          ' . $url_main . '/upload/slide/' . $line['BANNER_800'] . ' 800w, 
          ' . $url_main . '/upload/slide/' . $line['BANNER_1080'] . ' 1080w, 
          ' . $url_main . '/upload/slide/' . $line['BANNER_1600'] . ' 1600w, 
          ' . $url_main . '/upload/slide/' . $line['BANNER_1920'] . ' 1920w" 
          class="slide_visual slide' . $noSlide . '"></a>
        <link rel="prerender" href="' . $line['URL'] . '">
      </div>');
}

$stmt->close();
$tpl->assign("_ROOT.arraySlide", implode('', $arraySlide));


/////////////////////////////////////////////////

	$arraySlideVdo = array();
	$SlideVdo = '0';





    $lag = settype($_SESSION['lag'], "integer");

	
	$query = "SELECT main.*,a.*
	FROM `$tableIndexSlideVdo` as main 
	LEFT JOIN `$tableIndexSlideVdoDetail` as a ON a.ID_SLIDE = main.ID ";
	$query .= " WHERE main.DEL = '0' AND main.STATUS = 'Show' AND a.LAG = '".$lag."' ORDER BY main.ORDER DESC ";


	
	$result = $conn->query($query);
	while($line = $result->fetch_assoc()){
		$SlideVdo++;
		array_push($arraySlideVdo, '<div class="pppy_slide1 w-slide">
            <a href="#" class="w-inline-block w-lightbox"><img src="'.$url_main.'/upload/slideVdo/'.$line['BANNER_NAME'].'" loading="lazy" sizes="(max-width: 479px) 100vw, (max-width: 767px) 96vw, (max-width: 991px) 92vw, (max-width: 1439px) 94vw, 940px" srcset="'.$url_main.'/upload/slideVdo/'.$line['BANNER_500'].' 500w, '.$url_main.'/upload/slideVdo/'.$line['BANNER_800'].' 800w, '.$url_main.'/upload/slideVdo/'.$line['BANNER_940'].'" alt="">
              <script type="application/json" class="w-json">{
  "items": [
    {
      "url": "https://www.youtube.com/watch?v='.$line['URL'].'",
      "originalUrl": "https://www.youtube.com/watch?v='.$line['URL'].'",
      "width": 940,
      "height": 528,
      "thumbnailUrl": "https://i.ytimg.com/vi/'.$line['URL'].'/hqdefault.jpg",
      "html": "'.str_replace('"','\"',$line['DETAIL']).'",
      "type": "video"
    }
  ],
  "group": ""
}</script>
            </a>
          </div>');
	}

$tpl->assign("_ROOT.arraySlideVdo",implode('', $arraySlideVdo));





if($_SESSION['lagText']=="EN"){
	$arrayNewsCategory = array('<a href="'.$url_main.'/news" class="nag-button w-button">News</a>','<a href="'.$url_main.'/blog" class="nag-button w-button">Blog</a>','<a href="'.$url_main.'/gallery" class="nag-button w-button">Gallery</a>');
}else{
	$arrayNewsCategory = array('<a href="'.$url_main.'/ข่าวสารกิจกรรม" class="nag-button w-button">ข่าวสาร</a>','<a href="'.$url_main.'/บทความ" class="nag-button w-button">บทความ</a>','<a href="'.$url_main.'/แกลลอรี่" class="nag-button w-button">แกลลอรี่</a>');
}

$tpl->assign("_ROOT.arrayNewsCategory",implode('', $arrayNewsCategory));


$query = "SELECT main.*,a.TITLE_".$_SESSION['lagText']." as TITLECAT
FROM `$tableNews` as main 
LEFT JOIN `$tableNewsCategory` as a ON a.ID = main.ID_NEWS_CAT";
$query .= " ORDER BY main.DAY DESC, main.ID DESC LIMIT 0,3 ";
$result = $conn->query($query);
while($line = $result->fetch_assoc()){
	// $no++;
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


FRONTPAGESEO('1',$_SESSION['lag']);
$tpl->printToScreen();












$tpl->printToScreen();
