<?php error_reporting(E_ALL ^ E_NOTICE);

include_once("./include/config.inc.php");
include_once("./include/class.inc.php");
include_once("./include/class.TemplatePower.inc.php");
include_once("./include/function.inc.php");


$tpl = new TemplatePower("./template/_tp_master.html");
$tpl->assignInclude("body", "./template/_tp_blog.html");
$tpl->prepare();


##########
if(isset($_POST['language'])){$_SESSION['lag'] = $_POST['language'];}
elseif(!isset($_SESSION['lag'])){$_SESSION['lag'] = '1';}
else{}
FRONTLANGUAGE($_SESSION['lag']);
##########




if($_SESSION['lagText']=="EN"){
	$arrayNewsCategory = array('<a href="'.$url_main.'/news" class="nag-button w-button">News</a>','<a href="'.$url_main.'/blog" class="nag-button w-button active">Blog</a>','<a href="'.$url_main.'/gallery" class="nag-button w-button">Gallery</a>');
}else{
	$arrayNewsCategory = array('<a href="'.$url_main.'/ข่าวสารกิจกรรม" class="nag-button w-button">ข่าวสาร</a>','<a href="'.$url_main.'/บทความ" class="nag-button w-button active">บทความ</a>','<a href="'.$url_main.'/แกลลอรี่" class="nag-button w-button">แกลลอรี่</a>');
}

$tpl->assign("_ROOT.arrayNewsCategory",implode('', $arrayNewsCategory));

$no='0';
$query = "SELECT main.*,a.TITLE_".$_SESSION['lagText']." as TITLECAT
FROM `$tableNews` as main 
LEFT JOIN `$tableNewsCategory` as a ON a.ID = main.ID_NEWS_CAT";
$query .= " ORDER BY main.DAY DESC, main.ID DESC LIMIT 0,3 ";
$result = $conn->query($query);
while($line = $result->fetch_assoc()){
	$no++;
    if($line['ID_NEWS_CAT']=="2"){

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
	

	
	
}




FRONTPAGESEO('4',$_SESSION['lag']);
$tpl->printToScreen();


