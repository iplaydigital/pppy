<?php error_reporting(E_ALL ^ E_NOTICE);

include_once("./include/config.inc.php");
include_once("./include/class.inc.php");
include_once("./include/class.TemplatePower.inc.php");
include_once("./include/function.inc.php");



$tpl = new TemplatePower("./template/_tp_master.html");
$tpl->assignInclude("body", "template/_tp_contactus.html");
$tpl->prepare();


if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['g-recaptcha-response'])) {

        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $secret = '6Ld98KIoAAAAAA2sOcliwan8MXDxtDCTJKGKN70R';
        $res = $_POST['g-recaptcha-response'];
        // $res = $_POST['res'];
        
        $v = file_get_contents($url . '?secret=' . $secret . '&response=' . $res);
        $v = json_decode($v);
        
        if( isset( $v->score ) ) {
            if ( $v->score >= 0.5 ) {
                // var_dump( $v );
                // echo "<div>การใช้งานถูกต้อง recaptcha ทำงาน</div>";

                if($_POST['email']!=''){

					$fname = $_POST['fname'];
					$lname = $_POST['lname'];
					$email = $_POST['email'];
					$phone = $_POST['phone'];
					$detail = $_POST['detail'];
					

					$arrData = array();
					$arrData['FNAME'] = $fname;
					$arrData['LNAME'] = $lname;
					$arrData['EMAIL'] = $email;
					$arrData['PHONE'] = $phone;
					$arrData['MESSAGE'] = $detail;
					$arrData['DAY'] = date("Y-m-d H:i:s");
					$sql = sqlCommandInsert($tableMailMessage,$arrData);
					$query = $conn->query($sql);

					$from = "".$email;
					$to = "info@pohpunpanyafoundation.org";
					$subject = "Contact from pohpunpanyafoundation.org";
					$message = "".$detail;
					$headers = "From:" . $email;
					mail($to,$subject,$message, $headers);
				}
            } else {
                // echo "การใช้งานไม่ถูกต้อง";
            }   
        }     
    }



##########
if(isset($_POST['language'])){$_SESSION['lag'] = $_POST['language'];}
elseif(!isset($_SESSION['lag'])){$_SESSION['lag'] = '1';}
else{}
FRONTLANGUAGE($_SESSION['lag']);
##########



FRONTPAGESEO('5',$_SESSION['lag']);
$tpl->printToScreen();

