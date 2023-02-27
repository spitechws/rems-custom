<?php
$FDBOBJ = new Database();
$FDBOBJ->ConnectDatabase();

function show404($msg = '') {
    $html = '<div style="text-align:center;background-color:white;">';
    $html .= '<h3>System Error: Content Not Avaialble</h3>';
    if ($msg != "") {
        $html .= '<h2>Message:' . $msg . '</h2>';
    }
    $html .= '</div>';
    echo $html;
    exit;
}

function permission_denied() {
    $html = '<div style="text-align:center;background-color:white;">';
    $html .= '<h3>System Error: Permission Denied: You are not allowed to change the url or this url is not exist.</h3>';
    $html .= '</div>';
    echo $html;
    exit;
}

function LoginError() {
    $Message = $_GET['Message'] . " " . $_GET['Error'];
    if ($_GET[md5("Mode")] == md5("Invalid User ID")) {
        echo "<div id='Error'>Invalid User ID $Message</div>";
    } elseif ($_GET[md5("Mode")] == md5("Expired")) {
        echo "<div id='Error'>Your Account Is Blocked $Message</div>";
    } elseif ($_GET[md5("Mode")] == md5("Incorrect Password")) {
        echo "<div id='Error'>Incorrect Password $Message</div>";
    } elseif ($_GET[md5("Mode")] == md5("Incorrect Security Code")) {
        echo "<div id='Error'>Incorrect Security Code $Message</div>";
    }
}

function GetBrowser() {
    $browser = array(
        'version' => '0.0.0',
        'majorver' => 0,
        'minorver' => 0,
        'build' => 0,
        'name' => 'unknown',
        'useragent' => ''
    );

    $browsers = array(
        'firefox', 'msie', 'opera', 'chrome', 'safari', 'mozilla', 'safari', 'seamonkey', 'konqueror', 'netscape',
        'gecko', 'navigator', 'mosaic', 'lynx', 'amaya', 'omniweb', 'avant', 'camino', 'flock', 'aol'
    );

    if (isset($_SERVER['HTTP_USER_AGENT'])) {
        $browser['useragent'] = $_SERVER['HTTP_USER_AGENT'];
        $user_agent = strtolower($browser['useragent']);
        foreach ($browsers as $_browser) {
            if (preg_match("/($_browser)[\/ ]?([0-9.]*)/", $user_agent, $match)) {
                $browser['name'] = $match[1];
                $browser['version'] = $match[2];
                $list = @list($browser['majorver'], $browser['minorver'], $browser['build']) = explode('.', $browser['version']);
                break;
            }
        }
    }
    return array($match[1], $match[2]);
}

function IndianTime() {
    date_default_timezone_set('Asia/Calcutta');
    return date('h:i:s A');
}

function IndianTimeLong() {
    date_default_timezone_set('Asia/Calcutta');
    return date('H:i:s');
}

function IndianDateTimeString() {
    date_default_timezone_set('Asia/Calcutta');
    return date('DymHis');
}

function DateDiff($start, $end) {
    $start_ts = strtotime($start);
    $end_ts = strtotime($end);
    $diff = $end_ts - $start_ts;
    return round($diff / 86400);
}

function ShowDate($date, $format = "d-M-Y", $IfNull = "-") {
    if ($date != "1900-01-01" && $date != "0000-00-00" && $date != "") {
        echo date($format, strtotime($date));
    } else {
        echo $IfNull;
    }
}

function GetIP() {
    $IP = $_SERVER['HTTP_FORWARDED_FOR'];
    if ($IP == "") {
        $IP = $_SERVER['REMOTE_ADDR'];
    }
    return $IP;
}

function GetPCNAME() {
    return php_uname('n');
}

function GetPhysicalAddress() {
    ob_start(); // Turn on output buffering
    system('ipconfig /all'); //Execute external program to display output
    $mycom = ob_get_contents(); // Capture the output into a variable
    ob_clean(); // Clean (erase) the output buffer

    $findme = "Physical";
    $pmac = strpos($mycom, $findme); // Find the position of Physical text
    $mac = substr($mycom, ($pmac + 36), 17); // Get Physical Address

    return $mac;
}

function ConvertToWord($no) {  //taking number as parameter
//creating array  of word for each digit
    $words = array('0' => 'Zero', '1' => 'one', '2' => 'two', '3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six', '7' => 'seven', '8' => 'eight', '9' => 'nine', '10' => 'ten', '11' => 'eleven', '12' => 'twelve', '13' => 'thirteen', '14' => 'fourteen', '15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen', '18' => 'eighteen', '19' => 'nineteen', '20' => 'twenty', '30' => 'thirty', '40' => 'forty', '50' => 'fifty', '60' => 'sixty', '70' => 'seventy', '80' => 'eighty', '90' => 'ninty', '100' => 'hundred', '1000' => 'thousand', '100000' => 'lakh', '10000000' => 'crore');


    //for decimal number taking decimal part

    $cash = (int) $no;  //take number wihout decimal
    $decpart = $no - $cash; //get decimal part of number

    $decpart = sprintf("%01.2f", $decpart); //take only two digit after decimal

    $decpart1 = substr($decpart, 2, 1); //take first digit after decimal
    $decpart2 = substr($decpart, 3, 1);   //take second digit after decimal  

    $decimalstr = '';

//if given no. is decimal than  preparing string for decimal digit's word

    if ($decpart > 0) {
        $decimalstr .= "Point " . $numbers[$decpart1] . " " . $numbers[$decpart2];
    }

    if ($no == 0)
        return ' ';
    else {
        $novalue = '';
        $highno = $no;
        $remainno = 0;
        $value = 100;
        $value1 = 1000;
        while ($no >= 100) {
            if (($value <= $no) && ($no < $value1)) {
                $novalue = $words["$value"];
                $highno = (int) ($no / $value);
                $remainno = $no % $value;
                break;
            }
            $value = $value1;
            $value1 = $value * 100;
        }
        if (array_key_exists("$highno", $words))  //check if $high value is in $words array
            return $words["$highno"] . " " . $novalue . " " . ConvertToWord($remainno) . $decimalstr;  //recursion
        else {
            $unit = $highno % 10;
            $ten = (int) ($highno / 10) * 10;
            return $words["$ten"] . " " . $words["$unit"] . " " . $novalue . " " . ConvertToWord($remainno) . $decimalstr; //recursion
        }
    }
}

function MaxID($Table, $Field) {
    $MaxRow = @mysqli_query($_SESSION['CONN'], "select max($Field) from $Table");
    $MaxRow = @mysqli_fetch_array($MaxRow);
    return $MaxRow['0'];
}

function getNextID($table) {
    $Q = "SELECT `AUTO_INCREMENT`
	FROM  INFORMATION_SCHEMA.TABLES
	WHERE TABLE_SCHEMA = '" . DATABASE . "'
	AND   TABLE_NAME   = '" . $table . "';";

    $Q = @mysqli_query($_SESSION['CONN'], $Q);
    $Q = @mysqli_fetch_array($Q);
    return $Q[0];
}

function NextDate($Date, $Day) {
    $new_date = strtotime(date("Y-m-d", strtotime($Date)) . "+" . $Day . " days");
    return date('Y-m-d', $new_date);
}

function NextMonth($Date, $Month) {
    $new_date = strtotime(date("Y-m-d", strtotime($Date)) . "+" . $Month . " months");
    return date('Y-m-d', $new_date);
}

function NextYear($Date, $Years) {
    $new_date = strtotime(date("Y-m-d", strtotime($Date)) . "+" . $Years . " years");
    return date('Y-m-d', $new_date);
}

/* =======================( File Upload )======================== */

function FileUpload($Original, $Folder, $FileName) {
    if ($Original['name'] !== "") {
        if ($FileName) {
            $ck = $Original['name'];
            $av = str_replace(" ", "_", $ck);
            $newname = date("Ymd_His") . $av;
        } else {
            $newname = $Original['name'];
        }

        $fullpath = $Folder . "/" . $newname;

        $cpy = copy($Original[tmp_name], $fullpath);

        if ($cpy)
            return $newname;
        else
            return 0;
    }
}

/* =======================( End Of File Upload )======================== */

//padding to one length numerics
function PadDigit($digit) {
    if ($digit <= 9)
        $digit = "0" . $digit;
    return $digit;
}

/* * ******************************************************************
  Remove Pad Ex 01 becomes 1
 * ****************************************************************** */

function RemovePad($digit) {
    if ($digit[0] == '0')
        $ret = $digit[1];
    else
        $ret = $digit;
    return $ret;
}

function RandomPassword() {
    $password = "";
    $possible = strtoupper("0123456789abcdefghijklmnopqrstuvwxyz");
    $i = 0;

    while ($i < 11) {
        $char = substr($possible, mt_rand(0, strlen($possible) - 1), 1);

        if (!strstr($password, $char)) {
            $password .= $char;
            $i++;
        }
    }
    return $password;
}

/* * ****************************************************************************************
  //calculate the age of the persons
 * **************************************************************************************** */

function GetAge($S_DATE, $E_DATE) {
    $ageparts = explode("-", $S_DATE);
    $today = $E_DATE;
    $todayparts = explode("-", $today);
    $age = $todayparts[0] - $ageparts[0];
    $Month = $todayparts[1] - $ageparts[1];
    $Day = $todayparts[2] - $ageparts[2];
    return floor($age + ($Month / 12) + ($Day / 365));
}

/* * ****************************************************************************************
  Encodes the IP Address
 * **************************************************************************************** */

function EncodeIP($DotIP) {
    $ip_sep = explode('.', $DotIP);
    return sprintf('%02x%02x%02x%02x', $ip_sep[0], $ip_sep[1], $ip_sep[2], $ip_sep[3]);
}

/* * ****************************************************************************************
  Encodes the IP Address
 * **************************************************************************************** */

function decode_ip($IntIP) {
    $hexipbang = explode('.', chunk_split($IntIP, 2, '.'));
    return hexdec($hexipbang[0]) . '.' . hexdec($hexipbang[1]) . '.' . hexdec($hexipbang[2]) . '.' . hexdec($hexipbang[3]);
}

/* * ****************************************************************************************
  // convert an input string into it's binary equivalent.
 * **************************************************************************************** */

function AscBin($inputString, $byteLength = 8) {
    $binaryOutput = '';
    $strSize = strlen($inputString);

    for ($x = 0; $x < $strSize; $x++) {
        $charBin = decbin(ord($inputString[$x]));
        $charBin = str_pad($charBin, $byteLength, '0', STR_PAD_LEFT);
        $binaryOutput .= $charBin;
    }

    return $binaryOutput;
}

/* * ****************************************************************************************
  // convert an binary to ascii string
 * **************************************************************************************** */

function Bin2Asc($binaryInput, $byteLength = 8) {
    if (strlen($binaryInput) % $byteLength) {
        return false;
    }

    // why run strlen() so many times in a loop? Use of constants = speed increase.
    $strSize = strlen($binaryInput);
    $origStr = '';

    // jump between bytes.
    for ($x = 0; $x < $strSize; $x += $byteLength) {
        // extract character's binary code
        $charBinary = substr($binaryInput, $x, $byteLength);
        $origStr .= chr(bindec($charBinary)); // conversion to ASCII.
    }
    return $origStr;
}

function ErrorMessage() {
    if (isset($_GET['Message'])) {
        echo "<div id='Message'>" . $_GET['Message'] . "</div>";
    }
    if (isset($_GET['Error'])) {
        echo "<div id='Error'>" . $_GET['Error'] . "</div>";
    }
}

function MessageError() {
    if (isset($_GET['Message'])) {
        echo "<div id='Message'>" . $_GET['Message'] . "</div>";
    }
    if (isset($_GET['Error'])) {
        echo "<div id='Error'>" . $_GET['Error'] . "</div>";
    }
}

function SelectSelected($Left, $Right) {
    if ($Left == $Right) {
        echo " selected='selected' ";
    }
}

function CheckedCheckbox($Left, $Right) {
    if ($Left == $Right) {
        echo " checked='checked' ";
    }
}

function CheckedRadio($Left, $Right) {
    if ($Left == $Right) {
        echo " checked='checked' ";
    }
}

function CreateList($STRING, $List_type = "ul", $Class = "", $ID = "") {
    $array = @explode(",", $STRING);
    $COUNT = count($array);

    if ($COUNT > 0) {
        if ($Class != "") {
            $NewClass = " class='$Class' ";
        }
        if ($ID != "") {
            $NewID = " id='$ID' ";
        }

        echo "<" . $List_type . " $NewClass $NewID >";
        for ($S = 0; $S < $COUNT; $S++) {
            if (trim($array[$S]) != "") {
                echo "<li>" . $array[$S] . "</li>";
            }
        }
        echo "</" . $List_type . ">";
    }
}

//========================(Date Input )=========================================
function DateInput($Name = "DateInput", $Default = "", $onchange = "") {
    if (trim($Default) == "" || $Default == NULL) {
        $Default = date('Y-m-d');
    }
    $YEAR = date('Y', strtotime($Default));
    $MONTH = date('m', strtotime($Default));
    $DAY = date('d', strtotime($Default));
    ?>
    <select id="<?php echo $Name . "_M"; ?>" name="<?php echo $Name . "_M"; ?>" style="width:auto;" onchange="<?php echo $onchange; ?>">
        <?php for ($M = 1; $M < 13; $M++) { ?>
            <option value="<?php echo $M = PadDigit($M); ?>" <?php
            if ($M == $MONTH) {
                echo " selected='selected'; ";
            }
            ?>>
                        <?php echo date('M', strtotime("2000-" . $M . "-01")); ?>
            </option><?php } ?>
    </select>

    <select  id="<?php echo $Name . "_D"; ?>" name="<?php echo $Name . "_D"; ?>" style="width:auto;" onchange="<?php echo $onchange; ?>">
        <?php for ($D = 1; $D < 32; $D++) { ?>
            <option value="<?php echo $D = PadDigit($D); ?>" <?php
            if ($D == $DAY) {
                echo " selected='selected'; ";
            }
            ?>><?php echo $D; ?></option>        
                <?php } ?>       
    </select>

    <select  id="<?php echo $Name . "_Y"; ?>" name="<?php echo $Name . "_Y"; ?>" style="width:auto;" onchange="<?php echo $onchange; ?>">
        <?php for ($Y = 1900; $Y < 2051; $Y++) { ?>
            <option value="<?php echo $Y; ?>"  <?php
            if ($Y == $YEAR) {
                echo " selected='selected'; ";
            }
            ?>><?php echo $Y; ?></option>
                <?php } ?>
    </select>
    <?php
}

function ReceiveDate($Name = "DateInput", $Method = "") {
    $new_date = date('Y-m-d');
    if (trim($Method) == "POST") {
        $new_date = $_POST[$Name . "_Y"] . "-" . $_POST[$Name . "_M"] . "-" . $_POST[$Name . "_D"];
    }
    if (trim($Method) == "GET") {
        $new_date = $_GET[$Name . "_Y"] . "-" . $_GET[$Name . "_M"] . "-" . $_GET[$Name . "_D"];
    } else {
        $new_date = $_REQUEST[$Name . "_Y"] . "-" . $_REQUEST[$Name . "_M"] . "-" . $_REQUEST[$Name . "_D"];
    }

    return $new_date;
}

function NoAdmin() {
    if (strtoupper($_SESSION['user_id']) != "ADMIN" && strtoupper($_SESSION['user_category']) != "ADMIN") {
        @header("location:LogOut.php");
        echo "<script>window.location='LogOut.php';</script>";
        die();
    }
}

function NoAdminCategory() {
    if (strtoupper($_SESSION['user_category']) != "ADMIN") {
        @header("location:LogOut.php");
        echo "<script>window.location='LogOut.php';</script>";
        die();
    }
}

function NoUser() {
    if ($_SESSION['user_id'] == "" || $_SESSION['user_category'] == "" || $_SESSION['user_id'] == NULL || $_SESSION['user_category'] == NULL) {
        @header("location:LogOut.php");
        echo "<script>window.location='LogOut.php';</script>";
        die();
    }
}

function NoAdvisor() {
    if ($_SESSION['advisor_id'] == "" || $_SESSION['advisor_id'] == NULL) {
        @header("location:LogOut.php");
        echo "<script>window.location='LogOut.php';</script>";
        die();
    }
}

function CheckAdvisor($table, $PrimaryKeyOfTable, $PrimaryValue, $GetField = "advisor_id") {
    $DBOBJ = new DataBase();
    $DBOBJ->ConnectDatabase();

    $advisor_id1 = $DBOBJ->ConvertToText($table, $PrimaryKeyOfTable, $GetField, $PrimaryValue);

    if ($advisor_id1 != $_SESSION['advisor_id']) {
        @header("location:LogOut.php");
        echo "<script>window.location='LogOut.php';</script>";
        die();
    }
}

function CreatedEditedByUserMessage() {
    $Message = $_SESSION['user_id'] . ", ";
    $Message .= $_SESSION['user_category'] . ", ";
    $Message .= date('Y-m-d') . ", ";
    $Message .= IndianTime() . ", ";
    $Message .= GetIP();
    return $Message;
}

function CreatedEditedByAdvisorMessage() {
    $Message = $_SESSION['advisor_code'] . ", ";
    $Message .= advisor_title . ", ";
    $Message .= date('Y-m-d') . ", ";
    $Message .= IndianTime() . ", ";
    $Message .= GetIP();
    return $Message;
}

function IsInternetConnection() {
    $connected = @fsockopen("www.google.com", 80);
    if ($connected) {
        $is_conn = true; //action when connected
        fclose($connected);
    } else {
        $is_conn = false; //action in connection failure
    }
    return $is_conn;
}

function PrintArray($ARRAY) {
    echo "<pre>";
    print_r($ARRAY);
    echo "</pre>";
}

//==============================(BIRTHDAY SMS AUTO)===========================================================================
function BirthDaySMS() {
    $DBOBJ = new DataBase();
    $DBOBJ->ConnectDatabase();
    $BCONFIRM = $DBOBJ->ConvertToText("tbl_sms_sent", "sms_birthday", "sms_birthday", date('Y-m-d'));

    $MESSAGE = ", " . site_company_name . " WISHES YOU A GREAT HAPPY BIRTHDAY . MAY THE COMMING DAYS & YEARS FILL YOUR LIFE WITH HAPPYNESS & PROSPERITY. " . site_company_name;

    if ($BCONFIRM != date('Y-m-d')) {
        //-----------------( CONSULTANT BIRTHDAY )-----------------------------
        $ADVISOR_QUERY = "SELECT advisor_title, advisor_name, advisor_mobile FROM tbl_advisor WHERE MONTH(advisor_dob) = MONTH(CURRENT_DATE) AND DAY(advisor_dob) = DAY(CURRENT_DATE) and advisor_dob!='1900-01-01'";
        $ADVISOR_QUERY = @mysqli_query($_SESSION['CONN'], $ADVISOR_QUERY);
        while ($ADVISOR_ROW = @mysqli_fetch_assoc($ADVISOR_QUERY)) {
            $SMS = "DEAR " . $ADVISOR_ROW['advisor_title'] . "  " . $ADVISOR_ROW['advisor_name'] . $MESSAGE;
            SendSMS($ADVISOR_ROW['advisor_mobile'], $SMS);
            //echo $ADVISOR_ROW['advisor_mobile'];			 
        }

        //-----------------( CUSTOMER BIRTHDAY )-----------------------------
        $CUSTOMER_QUERY = "SELECT customer_title, customer_name, customer_mobile FROM tbl_customer WHERE MONTH(customer_dob) = MONTH(CURRENT_DATE) AND DAY(customer_dob) = DAY(CURRENT_DATE) and customer_dob!='1900-01-01'";
        $CUSTOMER_QUERY = @mysqli_query($_SESSION['CONN'], $CUSTOMER_QUERY);
        while ($CUSTOMER_ROW = @mysqli_fetch_assoc($CUSTOMER_QUERY)) {
            $SMS = $CUSTOMER_ROW['customer_title'] . "  " . $CUSTOMER_ROW['customer_name'] . $MESSAGE;
            SendSMS($CUSTOMER_ROW['customer_mobile'], strtoupper($SMS));
            // echo $CUSTOMER_ROW['customer_mobile'];
        }
    }
    $DBOBJ->Update("tbl_sms_sent", "sms_birthday", date('Y-m-d'), "sms_id", "1", "0");
}

//==============================(ANNIVERSARY SMS AUTO)===========================================================================
function AnniversarySMS() {
    $DBOBJ = new DataBase();
    $DBOBJ->ConnectDatabase();
    $BCONFIRM = $DBOBJ->ConvertToText("tbl_sms_sent", "sms_anniversary", "sms_anniversary", date('Y-m-d'));

    $MESSAGE = ", " . site_company_name . " WISHES YOU A GREAT HAPPY BIRTHDAY . MAY THE COMMING DAYS & YEARS FILL YOUR LIFE WITH HAPPYNESS & PROSPERITY. " . site_company_name;

    if ($BCONFIRM != date('Y-m-d')) {
        //-----------------( CONSULTANT BIRTHDAY )-----------------------------
        $ADVISOR_QUERY = "SELECT advisor_title, advisor_name, advisor_mobile FROM tbl_advisor WHERE MONTH(advisor_anniversary_date) = MONTH(CURRENT_DATE) AND DAY(advisor_anniversary_date) = DAY(CURRENT_DATE) and advisor_anniversary_date!='1900-01-01'";
        $ADVISOR_QUERY = @mysqli_query($_SESSION['CONN'], $ADVISOR_QUERY);
        while ($ADVISOR_ROW = @mysqli_fetch_assoc($ADVISOR_QUERY)) {
            $SMS = "DEAR " . $ADVISOR_ROW['advisor_title'] . "  " . $ADVISOR_ROW['advisor_name'] . $MESSAGE;
            SendSMS($ADVISOR_ROW['advisor_mobile'], $SMS);
            //echo $ADVISOR_ROW['advisor_mobile'];			 
        }

        //-----------------( CUSTOMER BIRTHDAY )-----------------------------
        $CUSTOMER_QUERY = "SELECT customer_title, customer_name, customer_mobile FROM tbl_customer WHERE MONTH(customer_anniversary_date) = MONTH(CURRENT_DATE) AND DAY(customer_anniversary_date) = DAY(CURRENT_DATE) and customer_anniversary_date!='1900-01-01'";
        $CUSTOMER_QUERY = @mysqli_query($_SESSION['CONN'], $CUSTOMER_QUERY);
        while ($CUSTOMER_ROW = @mysqli_fetch_assoc($CUSTOMER_QUERY)) {
            $SMS = $CUSTOMER_ROW['customer_title'] . "  " . $CUSTOMER_ROW['customer_name'] . $MESSAGE;
            SendSMS($CUSTOMER_ROW['customer_mobile'], strtoupper($SMS));
            // echo $CUSTOMER_ROW['customer_mobile'];
        }
    }
    $DBOBJ->Update("tbl_sms_sent", "sms_anniversary", date('Y-m-d'), "sms_id", "1", "0");
}

//-----------------------------( BEFORE 2 DAY OF EXPIRY )---------------------------
function TokenExpiryBeforeSMS() {
    $DBOBJ = new DataBase();
    $DBOBJ->ConnectDatabase();
    $ACONFIRM = $DBOBJ->ConvertToText("tbl_sms_sent", "sms_token_expiry_pre", "sms_token_expiry_pre", date('Y-m-d'));
    if ($ACONFIRM != date('Y-m-d')) {
        $ExpiryDate1 = date('Y-m-d', strtotime($Date . ' + 1 days'));
        $ExpiryDate2 = date('Y-m-d', strtotime($Date . ' + 2 days'));
        $ExpiryDate3 = date('Y-m-d', strtotime($Date . ' + 3 days'));

        $XB_SQL = " SELECT b.booking_property_id , b. booking_token_exp_date, p.property_no, t.property_type, pj.project_name, cus.customer_mobile, cus.customer_name, cus.customer_title
			FROM tbl_property_booking b
			INNER JOIN tbl_customer cus ON b.booking_customer_id = cus.customer_id
			INNER JOIN tbl_property p ON b.booking_property_id = p.property_id
			INNER JOIN tbl_project pj ON b.booking_project_id = pj.project_id
			
			INNER JOIN tbl_setting_property_type t ON p.property_type_id = t.property_type_id 	
			
			AND ( b.booking_token_exp_date = '$ExpiryDate1' || b.booking_token_exp_date = '$ExpiryDate2' || b.booking_token_exp_date = '$ExpiryDate3')
			AND b. booking_cancel_status != 'Yes'
			AND b.booking_type = 'Temporary'
			AND p.property_status = 'TempBooked'";

        $XB_SQL = @mysqli_query($_SESSION['CONN'], $XB_SQL);
        while ($XB_ROWS = @mysqli_fetch_assoc($XB_SQL)) {
            $MESSEGE_X = "DEAR CUSTOMER " . $XB_ROWS['customer_title'] . " " . $XB_ROWS['customer_name'] . ", " . $XB_ROWS['property_type'] . " " . $XB_ROWS['property_no'] . " BOOKED BY YOU WITH TOKEN AMOUNT IN OUR PROJECT " . $XB_ROWS['project_name'] . " WILL BE EXPIRED ON " . date('d-M-Y', strtotime($XB_ROWS['booking_token_exp_date'])) . " PLEASE PAY YOUR DOWN PAYMENT ON OR BEFORE " . date('d-M-Y', strtotime($XB_ROWS['booking_token_exp_date'])) . ". PLEASE IGNORE IF ALREADY PAID. " . site_company_name;
            if ($XB_ROWS['customer_mobile'] != '0' || $XB_ROWS['customer_mobile'] != ' ' || $XB_ROWS['customer_mobile'] != '') {
                SendSMS($XB_ROWS['customer_mobile'], strtoupper($MESSEGE_X));
            }
        }

        $DBOBJ->Update("tbl_sms_sent", "sms_token_expiry_pre", date('Y-m-d'), "sms_id", "1", "0");
    }
}

//-----------------------------( ON EXPIRY DATE CURRENT )--------------------------------------------------------------------------------
function TokenExpiryTodaySMS() {
    $DBOBJ = new DataBase();
    $DBOBJ->ConnectDatabase();

    $ACONFIRM = $DBOBJ->ConvertToText("tbl_sms_sent", "sms_token_expiry_current", "sms_token_expiry_current", date('Y-m-d'));

    if ($ACONFIRM != date('Y-m-d')) {

        $ExpiryDate = date('Y-m-d');

        $XB_SQL = " SELECT b.booking_property_id , p.property_no, b. booking_token_exp_date, t.property_type, pj.project_name, cus.customer_mobile, cus.customer_name, cus.customer_title
			FROM tbl_property_booking b
			INNER JOIN tbl_customer cus ON b.booking_customer_id = cus.customer_id
			INNER JOIN tbl_property p ON b.booking_property_id = p.property_id
			INNER JOIN tbl_project pj ON b.booking_project_id = pj.project_id
			
			INNER JOIN tbl_setting_property_type t ON p.property_type_id = t.property_type_id 	
			
			AND b. booking_token_exp_date = '$ExpiryDate' 
			AND b. booking_cancel_status != 'Yes'
			AND b.booking_type = 'Temporary'
			AND p.property_status = 'TempBooked'";

        $XB_SQL = @mysqli_query($_SESSION['CONN'], $XB_SQL);

        while ($XB_ROWS = @mysqli_fetch_array($XB_SQL)) {

            $MESSEGE_X = "DEAR CUSTOMER " . $XB_ROWS['customer_title'] . " " . $XB_ROWS['customer_name'] . ", " . $XB_ROWS['property_type'] . " " . $XB_ROWS['property_no'] . " BOOKED BY YOU WITH TOKEN AMOUNT IN OUR PROJECT " . $XB_ROWS['project_name'] . " WILL BE EXPIRED TODAY PLEASE PAY YOUR DOWN PAYMENT TODAY. PLEASE IGNORE IF ALREADY PAID. " . site_company_name;

            if ($XB_ROWS['customer_mobile'] != '0' || $XB_ROWS['customer_mobile'] != ' ' || $XB_ROWS['customer_mobile'] != '') {
                SendSMS($XB_ROWS['customer_mobile'], strtoupper($MESSEGE_X));
            }
        }

        $DBOBJ->Update("tbl_sms_sent", "sms_token_expiry_current", date('Y-m-d'), "sms_id", "1", "0");
    }
}

//-----------------------------( AFTER 2 DAYS FROM EXPIRED )-------------------------------------------------------------------------------
function TokenExpiryAfterSMS() {
    $DBOBJ = new DataBase();
    $DBOBJ->ConnectDatabase();
    $ACONFIRM = $DBOBJ->ConvertToText("tbl_sms_sent", "sms_token_expiry_after", "sms_token_expiry_after", date('Y-m-d'));

    if ($ACONFIRM != date('Y-m-d')) {

        $ExpiryDate1 = date('Y-m-d', strtotime($Date . ' - 1 days'));
        $ExpiryDate2 = date('Y-m-d', strtotime($Date . ' - 2 days'));
        $XB_SQL = " SELECT b.booking_property_id ,b.booking_token_exp_date, p.property_no, t.property_type, pj.project_name, cus.customer_mobile, cus.customer_name, cus.customer_title
			FROM tbl_property_booking b
			INNER JOIN tbl_customer cus ON b.booking_customer_id = cus.customer_id
			INNER JOIN tbl_property p ON b.booking_property_id = p.property_id
			INNER JOIN tbl_project pj ON b.booking_project_id = pj.project_id
			
			INNER JOIN tbl_setting_property_type t ON p.property_type_id = t.property_type_id 	
			
			AND ( b.booking_token_exp_date = '$ExpiryDate1' || b.booking_token_exp_date = '$ExpiryDate2')
			AND b. booking_cancel_status != 'Yes'
			AND b.booking_type = 'Temporary'
			AND p.property_status = 'TempBooked'";

        $XB_SQL = @mysqli_query($_SESSION['CONN'], $XB_SQL);

        while ($XB_ROWS = @mysqli_fetch_array($XB_SQL)) {
            $MESSEGE_X = "DEAR CUSTOMER " . $XB_ROWS['customer_title'] . " " . $XB_ROWS['customer_name'] . ", " . $XB_ROWS['property_type'] . " " . $XB_ROWS['property_no'] . " BOOKED BY YOU WITH TOKEN AMOUNT IN OUR PROJECT " . $XB_ROWS['project_name'] . " HAS BEEN EXPIRED ON " . date('d-M-Y', strtotime($XB_ROWS['booking_token_exp_date'])) . " PLEASE PAY YOUR DOWN PAYMENT IMMEDIATELY. PLEASE IGNORE IF ALREADY PAID. " . site_company_name;

            if ($XB_ROWS['customer_mobile'] != '0' || $XB_ROWS['customer_mobile'] != ' ' || $XB_ROWS['customer_mobile'] != '') {
                SendSMS($XB_ROWS['customer_mobile'], strtoupper($MESSEGE_X));
            }
        }

        $DBOBJ->Update("tbl_sms_sent", "sms_token_expiry_after", date('Y-m-d'), "sms_id", "1", "0");
    }
}
?>



