<?php error_reporting(E_ALL ^ E_NOTICE);
include_once("include/config.inc.php");

// Example usage


if ($_POST['action'] == 'loadProvince') {
    $arrayCampModel = array();
    $query = "SELECT main.*, a.*
	FROM `$tableCampProvince` as main 
	LEFT JOIN `$tableCampProvinceDetail` as a ON a.ID_PROVINCE = main.ID";
    $query .= " WHERE main.STATUS = 'Show' AND main.ID_MODEL = ? AND a.LAG = ? ORDER BY main.ORDER ASC ";

    $stmt = $conn->prepare($query);
    $stmt->bind_param('ss', $_POST['model'], $_SESSION['lag']);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($line = $result->fetch_assoc()) {
        array_push($arrayCampModel, '<a href="#" id="province' . $line['ID_PROVINCE'] . '" data-title="' . $line['TITLE'] . '" class="drp_province_list top w-dropdown-link" onclick="chooseCity(' . $line['ID_PROVINCE'] . ')" >' . $line['TITLE'] . '</a>');
        // Handle nested queries for districts and schools (not provided in the snippet).
    }

    $stmt->close();

    // Rest of the code...
}



if ($_POST['action'] == 'loadSchoolCity') {
    $arrayCampModel = array();
    $query = "SELECT main.*, a.*
	FROM `$tableCampSchool` as main 
	LEFT JOIN `$tableCampSchoolDetail` as a ON a.ID_SCHOOL = main.ID";
    $query .= " WHERE main.STATUS = 'Show' AND main.ID_PROVINCE = ? AND a.LAG = ? ORDER BY main.ORDER ASC ";

    $stmt = $conn->prepare($query);
    $stmt->bind_param('ss', $_POST['province'], $_SESSION['lag']);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($line = $result->fetch_assoc()) {
        array_push($arrayCampModel, '<a href="' . $url_main . '/schools/' . $ex[1] . '" class="drp_school_list w-dropdown-link" onmouseover="viewSchool(' . $line['ID_SCHOOL'] . ');" onmouseout="closeViewSchhol();">' . $line['TITLE'] . '</a>');
    }

    $stmt->close();

    // Rest of the code...
}


if ($_POST['action'] == 'loadSchool') {
    $arrayCampModel = array();
    $query = "SELECT main.*, a.*
	FROM `$tableCampSchool` as main 
	LEFT JOIN `$tableCampSchoolDetail` as a ON a.ID_SCHOOL = main.ID";
    $query .= " WHERE main.STATUS = 'Show' AND main.ID_DISTRICT = ? AND a.LAG = ? ORDER BY main.ORDER ASC ";

    $stmt = $conn->prepare($query);
    $stmt->bind_param('ss', $_POST['district'], $_SESSION['lag']);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($line = $result->fetch_assoc()) {
        array_push($arrayCampModel, '<a href="' . $url_main . '/schools/' . $ex[1] . '" class="drp_school_list w-dropdown-link" onmouseover="viewSchool(' . $line['ID_SCHOOL'] . ');" onmouseout="closeViewSchhol();">' . $line['TITLE'] . '</a>');
    }

    $stmt->close();

    // Rest of the code...
}



?>