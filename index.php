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
// ... (rest of the code remains unchanged)

// Print the template to the screen
$tpl->printToScreen();
