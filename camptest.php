<?php

$arrayCampModel = array();
$arrayCampProvince = array();
$arrayCampDistrict = array();
$arrayCampSchool = array();

$xml=simplexml_load_file("camp.xml") or die("Error: Cannot create object");
echo "<br>----------------------------------------<br>";

foreach($xml->children() as $camp) {
  if($camp['campId']=='1'){
    echo $camp['title'];
    echo "<br>";
    array_push($arrayCampModel,$camp['title']);
    foreach($camp->children() as $province) {
      echo $province['title'];
      echo "<br>";
      array_push($arrayCampProvince,$province['title']);
      foreach($province->children() as $district) {
        echo $district['title'];
        echo "<br>";
        array_push($arrayCampDistrict,$district['title']);
        foreach($district->children() as $school) {
          echo $school['title'];
          echo "<br>";
          array_push($arrayCampSchool,$school['title']);
        }      
      }
    }
  }
}
print_r($arrayCampModel);
echo "<br>----------------------------------------<br>";
print_r($arrayCampProvince);
echo "<br>----------------------------------------<br>";
print_r($arrayCampDistrict);
echo "<br>----------------------------------------<br>";
print_r($arrayCampSchool);
echo "<br>----------------------------------------<br>";

// echo '<div data-hover="false" data-delay="0" class="dropdown_province w-dropdown" style="margin-bottom:0;">
//             <div class="drp_campep w-dropdown-toggle">
//               <div class="w-icon-dropdown-toggle"></div>
//               <div class="drp_camp_text" id="drp_camp_text_model">รุ่นที่</div>
//             </div>
//             <nav class="drp_campyep w-dropdown-list">
//               '.implode('', $arrayCampModel).'
//             </nav>
//           </div>';




?>