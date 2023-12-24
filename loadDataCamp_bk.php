<?php
error_reporting(E_ALL ^ E_NOTICE);

include_once("include/config.inc.php");

/////////////////////////////////////////////////
if ($_POST['action'] == 'loadProvince') {
    $arrayCampModel = array();
    $query = "SELECT main.*,a.*
	FROM `$tableCampProvince` as main 
	LEFT JOIN `$tableCampProvinceDetail` as a ON a.ID_PROVINCE = main.ID";
    $query .= " WHERE main.STATUS = 'Show' AND main.ID_MODEL = '" . $_POST['model'] . "' AND a.LAG = '" . $_SESSION['lag'] . "' ORDER BY main.ORDER ASC ";
    $result = $conn->query($query);
    while ($line = $result->fetch_assoc()) {
        array_push($arrayCampModel, '<a href="#" id="province' . $line['ID_PROVINCE'] . '" data-title="' . $line['TITLE'] . '" class="drp_province_list top w-dropdown-link" onclick="chooseCity(' . $line['ID_PROVINCE'] . ')" >' . $line['TITLE'] . '</a>');
        $query2 = "SELECT main.*,a.*
		FROM `$tableCampDistrict` as main 
		LEFT JOIN `$tableCampDistrictDetail` as a ON a.ID_DISTRICT = main.ID";
        $query2 .= " WHERE main.ID_MODEL = '" . $_POST['model'] . "' AND main.ID_PROVINCE = '" . $line['ID'] . "' AND a.LAG = '" . $_SESSION['lag'] . "' AND  main.STATUS = 'Show' ORDER BY main.ORDER ASC ";
        $result2 = $conn->query($query2);
        while ($line2 = $result2->fetch_assoc()) {
            $query3 = "SELECT * FROM `$tableCampSchool` WHERE `STATUS` = 'Show' AND `ID_MODEL` = '" . $_POST['model'] . "' AND `ID_PROVINCE` = '" . $line['ID_PROVINCE'] . "' AND `ID_DISTRICT` = '" . $line2['ID_DISTRICT'] . "' ";
            $result3 = $conn->query($query3);
            if ($result3->num_rows > '1') {
                array_push($arrayCampModel, '<a href="#" id="district' . $line2['ID_DISTRICT'] . '" data-title="' . $line2['TITLE'] . '" class="drp_province_list  w-dropdown-link" onclick="chooseDistrict(' . $line2['ID_DISTRICT'] . ')" >' . $line2['TITLE'] . '<span style="float: right;">' . $result3->num_rows . ' โรงเรียน <strong>▸</strong></span></a>');
            } else {
                array_push($arrayCampModel, '<a href="#" id="district' . $line2['ID_DISTRICT'] . '" data-title="' . $line2['TITLE'] . '" class="drp_province_list  w-dropdown-link" onclick="chooseDistrict(' . $line2['ID_DISTRICT'] . ')" >' . $line2['TITLE'] . '<span style="float: right;padding-right:20px;">' . $result3->num_rows . ' โรงเรียน </span></a>');
            }
        }
    }

    $arrayCampSchool = array();
    $arrayCampSchoolDetail = array();
    $query = "SELECT main.*,a.*
	FROM `$tableCampSchool` as main 
	LEFT JOIN `$tableCampSchoolDetail` as a ON a.ID_SCHOOL = main.ID";
    $query .= " WHERE main.STATUS = 'Show' AND main.ID_MODEL = '" . $_POST['model'] . "' AND a.LAG = '" . $_SESSION['lag'] . "' ORDER BY main.ORDER ASC ";
    $result = $conn->query($query);
    while ($line = $result->fetch_assoc()) {
        $ex = explode('=', $line['LINK']);
        array_push($arrayCampSchool, '<a href="' . $url_main . '/schools/' . $ex[1] . '" class="drp_school_list w-dropdown-link" onmouseover="viewSchool(' . $line['ID_SCHOOL'] . ');" onmouseout="closeViewSchhol();" style="display: block;">' . $line['TITLE'] . '</a>');
        array_push($arrayCampSchoolDetail, '<div class="tree treeModel' . $line['ID_MODEL'] . ' treeCity' . $line['ID_PROVINCE'] . ' treeDistrict' . $line['ID_DISTRICT'] . ' treeSchool' . $line['ID_SCHOOL'] . '" id="tree' . $line['ID_SCHOOL'] . '" data-modal="' . $line['ID_MODEL'] . '" data-district="' . $line['ID_DISTRICT'] . '" onmouseover="viewSchool(' . $line['ID_SCHOOL'] . ');">
          <div class="treeImg"><img src="images/tree.png"><span>' . $line['ID_SCHOOL'] . '</span></div>
          <div class="treeView treeViewSchool' . $line['ID_SCHOOL'] . '">
            <img src="images/tree_view.png"><span>' . $line['ID_SCHOOL'] . '</span>
            <h4>' . $line['TITLE'] . '</h4>
            <p>' . $line['DESC'] . '<a href="' . $url_main . '/schools/' . $ex[1] . '">เพิ่มเติม</a></p>
          </div>
        </div>');
    }

    echo implode('', $arrayCampModel) . "|" . implode('', $arrayCampSchool) . "|" . implode('', $arrayCampSchoolDetail);
} elseif ($_POST['action'] == 'loadSchoolCity') {
    $arrayCampModel = array();
    $query = "SELECT main.*,a.*
	FROM `$tableCampSchool` as main 
	LEFT JOIN `$tableCampSchoolDetail` as a ON a.ID_SCHOOL = main.ID";
    $query .= " WHERE main.STATUS = 'Show' AND main.ID_PROVINCE = '" . $_POST['province'] . "' AND a.LAG = '" . $_SESSION['lag'] . "' ORDER BY main.ORDER ASC ";
    $result = $conn->query($query);
    while ($line = $result->fetch_assoc()) {
        $ex = explode('=', $line['LINK']);
        array_push($arrayCampModel, '<a href="' . $url_main . '/schools/' . $ex[1] . '" class="drp_school_list w-dropdown-link" onmouseover="viewSchool(' . $line['ID_SCHOOL'] . ');" onmouseout="closeViewSchhol();">' . $line['TITLE'] . '</a>');
    }
    echo implode('', $arrayCampModel);
} elseif ($_POST['action'] == 'loadSchool') {
    $arrayCampModel = array();
    $query = "SELECT main.*,a.*
	FROM `$tableCampSchool` as main 
	LEFT JOIN `$tableCampSchoolDetail` as a ON a.ID_SCHOOL = main.ID";
    $query .= " WHERE main.STATUS = 'Show' AND main.ID_DISTRICT = '" . $_POST['district'] . "' AND a.LAG = '" . $_SESSION['lag'] . "' ORDER BY main.ORDER ASC ";
    $result = $conn->query($query);
    while ($line = $result->fetch_assoc()) {
        $ex = explode('=', $line['LINK']);
        array_push($arrayCampModel, '<a href="' . $url_main . '/schools/' . $ex[1] . '" class="drp_school_list w-dropdown-link" onmouseover="viewSchool(' . $line['ID_SCHOOL'] . ');" onmouseout="closeViewSchhol();">' . $line['TITLE'] . '</a>');
    }
    echo implode('', $arrayCampModel);
}
/////////////////////////////////////////////////
?>
