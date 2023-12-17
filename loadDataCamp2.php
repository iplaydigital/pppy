<?php error_reporting(E_ALL ^ E_NOTICE);

include_once("include/config.inc.php");

/////////////////////////////////////////////////
if($_POST['action']=='loadProvince'){
	$arrayCampModel = array();
	array_push($arrayCampModel, '<option value="">รายชื่อจังหวัด อำเภอ</option>');

	$query = "SELECT main.*,a.TITLE as subject
	FROM `$tableCampProvince` as main 
	LEFT JOIN `$tableCampProvinceDetail` as a ON a.ID_PROVINCE = main.ID";
	$query .= " WHERE main.STATUS = 'Show' AND main.ID_MODEL = '".$_POST['model']."' AND a.LAG = '".$_SESSION['lag']."' ORDER BY main.ORDER ASC ";
	$result = $conn->query($query);
	while($line = $result->fetch_assoc()){
		array_push($arrayCampModel, '<option value="'.$line['ID'].'">'.$line['subject'].'</option>');
	}

	$arrayCampSchool = array('<option value="">โรงเรียนทั้งหมดที่เข้าร่วมโครงการ</option>');
	$arrayCampSchoolDetail = array();
	$query = "SELECT main.*,a.*
	FROM `$tableCampSchool` as main 
	LEFT JOIN `$tableCampSchoolDetail` as a ON a.ID_SCHOOL = main.ID";
	$query .= " WHERE main.STATUS = 'Show' AND main.ID_MODEL = '".$_POST['model']."' AND a.LAG = '".$_SESSION['lag']."' ORDER BY main.ORDER ASC ";
	$result = $conn->query($query);
	while($line = $result->fetch_assoc()){
		array_push($arrayCampSchool, '<option value="'.$line['ID_SCHOOL'].'">'.$line['TITLE'].'</option>');
		array_push($arrayCampSchoolDetail, '<div class="tree treeModel'.$line['ID_MODEL'].' treeCity'.$line['ID_PROVINCE'].' treeDistrict'.$line['ID_DISTRICT'].' treeSchool'.$line['ID_SCHOOL'].'" id="tree'.$line['ID_SCHOOL'].'" data-modal="'.$line['ID_MODEL'].'" data-district="'.$line['ID_DISTRICT'].'" onmouseover="viewSchool('.$line['ID_SCHOOL'].');" onmouseout="closeViewSchool();">
          <div class="treeImg"><img src="images/tree.png"><span>'.$line['ID_SCHOOL'].'</span></div>
          <div class="treeView treeViewSchool'.$line['ID_SCHOOL'].'">
            <img src="images/tree_view.png"><span>'.$line['ID_SCHOOL'].'</span>
            <h4>'.$line['TITLE'].'</h4>
            <p>'.$line['DESC'].'<a href="'.$line['LINK'].'">เพิ่มเติม</a></p>
          </div>
        </div>');
	}

	echo implode('', $arrayCampModel)."|".implode('', $arrayCampSchool)."|".implode('', $arrayCampSchoolDetail);

}elseif($_POST['action']=='loadSchoolCity'){
	$arrayCampModel = array('<option value="">โรงเรียนทั้งหมดที่เข้าร่วมโครงการ</option>');
	$query = "SELECT main.*,a.*
	FROM `$tableCampSchool` as main 
	LEFT JOIN `$tableCampSchoolDetail` as a ON a.ID_SCHOOL = main.ID";
	$query .= " WHERE main.STATUS = 'Show' AND main.ID_PROVINCE = '".$_POST['province']."' AND a.LAG = '".$_SESSION['lag']."' ORDER BY main.ORDER ASC ";
	$result = $conn->query($query);
	while($line = $result->fetch_assoc()){
		// array_push($arrayCampModel, '<a href="school-detail.php?id='.$line['ID_SCHOOL'].'" class="drp_school_list w-dropdown-link" onmouseover="viewSchool('.$line['ID_SCHOOL'].');" onmouseout="closeViewSchhol();">'.$line['TITLE'].'</a>');
		array_push($arrayCampModel, '<option value="'.$line['ID_SCHOOL'].'">'.$line['TITLE'].'</option>');

	}
	echo implode('', $arrayCampModel);

}elseif($_POST['action']=='loadSchool'){
	$arrayCampModel = array();
	$query = "SELECT main.*,a.*
	FROM `$tableCampSchool` as main 
	LEFT JOIN `$tableCampSchoolDetail` as a ON a.ID_SCHOOL = main.ID";
	$query .= " WHERE main.STATUS = 'Show' AND main.ID_DISTRICT = '".$_POST['district']."' AND a.LAG = '".$_SESSION['lag']."' ORDER BY main.ORDER ASC ";
	$result = $conn->query($query);
	while($line = $result->fetch_assoc()){
		array_push($arrayCampModel, '<a href="school-detail.php?id='.$line['ID_SCHOOL'].'" class="drp_school_list w-dropdown-link" onmouseover="viewSchool('.$line['ID_SCHOOL'].');" onmouseout="closeViewSchhol();">'.$line['TITLE'].'</a>');

	}
	echo implode('', $arrayCampModel);

}

/////////////////////////////////////////////////



	