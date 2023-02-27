<?php

include_once("Conn.php");

Class DataBase {

    function ConnectDatabase() {
        $_SESSION['CONN'] = mysqli_connect(HOST, USER, PASSWORD) OR die("Can Not Connect To Mysqli.");
        mysqli_select_db($_SESSION['CONN'], DATABASE) OR die("Can Not Connect To Database Now. ");
        @mysqli_query($_SESSION['CONN'], "SET GLOBAL sql_mode = 'NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION'");
        @mysqli_query($_SESSION['CONN'], "SET SESSION sql_mode = 'NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION'");
    }

    /* ==================================( Insert Into Table )=============================================================== */

    function Insert($Tablename, $Fields, $Values, $PrintQuery) {


        $SQL .= "INSERT INTO " . $Tablename . " ";

        $fieldnames .= "(";
        if (is_array($Fields)) {
            for ($i = 0; $i < sizeof($Fields); $i++) {
                $fieldnames .= trim($Fields[$i]);
                if ($i < sizeof($Fields) - 1)
                    $fieldnames .= ", ";
            }
            $fieldnames .= ") ";

            $Value .= " VALUES (";
            if (sizeof($Values) > 0) {
                for ($i = 0; $i < sizeof($Values); $i++) {
                    $Value .= "'" . @trim($Values[$i]) . "'";
                    if ($i < sizeof($Values) - 1)
                        $Value .= ", ";
                }
            }
            $Value .= ")";
        }
        else {
            $fieldnames .= $Fields . ')';
            $Value = " VALUES " . "('" . $Values . "')";
        }
        $query = $SQL . $fieldnames . $Value;
        if ($PrintQuery) {
            echo $query;
        }

        $result = @mysqli_query($_SESSION['CONN'], $query) or die(mysqli_error($_SESSION['CONN']));
        return mysqli_insert_id($_SESSION['CONN']);
    }

    /* ==================================( End Of Insert Into Table )=============================================================== */


    /* ==================================( Update Into Table )=============================================================== */

    function UpDate($Table, $sf, $sv, $WhichField, $WhichValue, $PrintQuery=0) {
        $query = " UPDATE " . $Table . " SET ";

        /* Here updating fields and values are composed */

        if (is_array($sf)) {
            if (sizeof($sf) > 0) {
                for ($j = 0; $j < sizeof($sf); $j++) {
                    $Value = @trim($sv[$j]);
                    $update_vars .= " $sf[$j] = '$Value' ";

                    if ($j < sizeof($sf) - 1)
                        $update_vars .= ", ";
                }
            }
        }
        else {
            $update_vars .= " $sf = '$sv' ";
        }

        $query .= $update_vars;

        /* Here condition is created */

        if (is_array($WhichField)) {
            if (sizeof($WhichField) > 0) {
                for ($k = 0; $k < sizeof($WhichField); $k++) {
                    $condition .= " $WhichField[$k] = '$WhichValue[$k]' ";

                    if ($k < sizeof($WhichField) - 1)
                        $condition .= " and ";
                }
            }
        }
        else {
            if ($WhichField)
                $condition = $WhichField . " = '$WhichValue' ";
            else
                $condition = "1";
        }
        $query .= " WHERE $condition ";
        if ($PrintQuery == 1) {
            echo $query;
        }
        $result = @mysqli_query($_SESSION['CONN'], $query) or die(mysqli_error($_SESSION['CONN']));
        return $result;
    }

    /* ==================================( End Of Update Into Table )=============================================================== */


    /* ==================================( Delete From Table )=============================================================== */

    function Delete($Table, $WhichField, $WhichValue, $PrintQuery = 0) {
        $query .= " DELETE FROM  " . $Table;
        if (is_array($WhichField)) {
            if (sizeof($WhichField) > 0) {
                for ($j = 0; $j < sizeof($WhichField); $j++) {
                    $condition .= " $WhichField[$j] = '$WhichValue[$j]'";
                    if ($j < sizeof($WhichField) - 1)
                        $condition .= " and";
                }
            }
        }
        else {
            $condition = "$WhichField = '$WhichValue'";
        }
        $query .= " WHERE $condition ";
        if ($PrintQuery) {
            echo $query;
            exit;
        }
        $result = @mysqli_query($_SESSION['CONN'], $query) or die(mysqli_error($_SESSION['CONN']));
        return $result;
    }

    /* ==================================( End Of Delete From Table )=============================================================== */

    /* ==========================( Convert To Text )======================================== */

    function ConvertToText($Table, $Field, $FieldToConvert, $FieldValue) {
        $SQL = "select " . $FieldToConvert . " from " . $Table . " where " . $Field . " = '" . $FieldValue . "'";
        $table = @mysqli_query($_SESSION['CONN'], $SQL);
        $tabledata = @mysqli_fetch_array($table);
        return $tabledata[0];
    }

    /* ==========================( Get Row )======================================== */

    function GetRow($Table, $Field, $FieldValue, $print_qry = 0) {
        $SQL = "select * from " . $Table . " where " . $Field . " = '" . $FieldValue . "'";
        if ($print_qry) {
            echo $SQL;
        }
        $table = @mysqli_query($_SESSION['CONN'], $SQL);
        $tabledata = @mysqli_fetch_array($table);
        return $tabledata;
    }

    function MaxID($Table, $Field) {
        $SQL = "select max(" . $Field . ") as max_id from " . $Table;
        $table = @mysqli_query($_SESSION['CONN'], $SQL);
        $tabledata = @mysqli_fetch_assoc($table);
        return $tabledata['max_id'];
    }

    /* ==========================( Exist )======================================== */

    function Exist($Table, $Field, $FieldValue) {
        $SQL = "select * from " . $Table . " where " . $Field . " = '" . $FieldValue . "'";
        $table = @mysqli_query($_SESSION['CONN'], $SQL);
        $num_rows = @mysqli_num_rows($table);
        return $num_rows;
    }

    /* ==========================( Exist Row )======================================== */

    function ExistRow($Table) {
        $SQL = "select * from " . $Table;
        $table = @mysqli_query($_SESSION['CONN'], $SQL);
        $num_rows = @mysqli_num_rows($table);
        return $num_rows;
    }

    /* ==========================( User Last Access Time Entry )======================================== */

    function UserLastAccessTimeEntry() {
        $DBOBJ = new DataBase();
        $DBOBJ->ConnectDatabase();
        $FIELDS = array("user_last_access_date", "user_last_access_time", "user_last_access_ip");
        $VALUES = array(date('Y-m-d'), IndianTime(), GetIP());
        $DBOBJ->UpDate("tbl_admin_user", $FIELDS, $VALUES, "user_id", $_SESSION['user_id'], 0);
    }

    function UserAdvisorLastAccessTimeEntry() {
        $DBOBJ = new DataBase();
        $DBOBJ->ConnectDatabase();
        $FIELDS = array("last_access_details");
        $VALUES = array(date('Y-m-d') . ", " . IndianTime() . ", " . GetIP());
        $DBOBJ->UpDate("tbl_advisor", $FIELDS, $VALUES, "advisor_id", $_SESSION['advisor_id'], 0);
    }

    function UserCustomerLastAccessTimeEntry() {
        $DBOBJ = new DataBase();
        $DBOBJ->ConnectDatabase();
        $FIELDS = array("last_access_details");
        $VALUES = array(date('Y-m-d') . ", " . IndianTime() . ", " . GetIP());
        $DBOBJ->UpDate("tbl_customer", $FIELDS, $VALUES, "customer_id", $_SESSION['customer_id'], 0);
    }

    function UserAction($action_name, $action_on) {
        $DBOBJ = new DataBase();
        $DBOBJ->ConnectDatabase();
        $FIELDS = array("action_id",
            "action_name",
            "action_on",
            "action_user_category",
            "action_user_name",
            "action_user_date",
            "action_user_time",
            "action_user_ip");

        $VALUES = array(date('YmdHis') . RandomPassword(),
            $action_name,
            $action_on,
            $_SESSION['user_category'],
            $_SESSION['user_id'],
            date('Y-m-d'),
            IndianTime(),
            GetIP());
        $DBOBJ->Insert("tbl_admin_user_action", $FIELDS, $VALUES, 0);
    }

    function UserAdvisorAction($action_name, $action_on) {
        $DBOBJ = new DataBase();
        $DBOBJ->ConnectDatabase();

        $FIELDS = array("action_id",
            "action_name",
            "action_on",
            "action_user_id",
            "action_user_date",
            "action_user_time",
            "action_user_ip");

        $VALUES = array(date('YmdHis') . RandomPassword(),
            $action_name,
            $action_on,
            $_SESSION['advisor_code'],
            date('Y-m-d'),
            IndianTime(),
            GetIP());

        $DBOBJ->Insert("tbl_advisor_action", $FIELDS, $VALUES, 0);
    }

    function UserCustomerAction($action_name, $action_on) {
        $DBOBJ = new DataBase();
        $DBOBJ->ConnectDatabase();

        $FIELDS = array("action_id",
            "action_name",
            "action_on",
            "action_user_id",
            "action_user_date",
            "action_user_time",
            "action_user_ip");

        $VALUES = array(date('YmdHis') . RandomPassword(),
            $action_name,
            $action_on,
            $_SESSION['customer_code'],
            date('Y-m-d'),
            IndianTime(),
            GetIP());

        $DBOBJ->Insert("tbl_customer_action", $FIELDS, $VALUES, 0);
    }

    function GetAdvisorWelcomeLetter($advisor_id) {
        $DBOBJ = new DataBase();
        $DBOBJ->ConnectDatabase();

        $ADVISOR_ROW = $DBOBJ->GetRow("tbl_advisor", "advisor_id", $advisor_id);
        $id = $ADVISOR_ROW['advisor_code'];
        $name = $ADVISOR_ROW['advisor_title'] . " " . $ADVISOR_ROW['advisor_name'];
        $city = $ADVISOR_ROW['advisor_address'];
        $date = $ADVISOR_ROW['advisor_hire_date'];
        $Message = '
			<style>
			    table tr td, #table tr td { padding-left:20px; padding-right:20px;margin-left:20px; margin-right:20px; }				
			</style>
			
			<table id="table" width="96%" height="96%" border="0" style="font-size:16px; font-family:Calibri; border:0px  solid #731F19; max-width:900px; margin:2%;background:url(' . APPROOT . 'SpitechLogo/LetterPadBlank.jpg) center no-repeat;background-size:100% 100%; " align="center" cellpadding="0" cellspacing="0">
			  
			  <tr><td align="center" style=" height:150px;text-align:center;">&nbsp;</td></tr>
			  
			  <tr><td align="center" style="font-size:18px; text-align:center;" height="50"><b><u>WELCOME  LETTER</u></b></td></tr>
			  <tr><td align="right"><br/><br/><B>DATE : ' . date('d-m-Y', strtotime($date)) . '</B></td></tr>
			
			  <tr><td height="40">Dear ' . advisor_title . ',</td></tr>
			 
			  <tr><td height="40"><b>' . $name . '</b></td></tr>
			  <tr><td height="60"><b>' . $city . '</b></td></tr>
			 
			  <tr>
				<td>It  is our extreme pleasure to welcome and associate you in our company <b>' . site_company_name . '</b> as a Real Estate ' . advisor_title . '.</td>
			  </tr>
			
			  <tr><td height="70">Your  ID CODE No. is <b>' . $id . '</b></td></tr>
			
			  <tr>
				<td style="text-align:justify;">We are happy to share you that  <b>' . site_company_name . '</b> is working with a strong Core Purpose "<i><b>MAKING YOUR DREAM MORE SIMPLE</b></i>." We understand the potential within you and we assure that you can build Financial Freedom along with immense Personal Growth while working as ' . advisor_title . '. You will enjoy the grace of Real Estate business in professionalism, soon we are going to expand our business in different cities of chhattisgarh.</td>
			  </tr>
			 
			  <tr>
				<td height="80">Your co-operation and valuable business relationship with us will create a revolution in this Industry. We once again welcome you to <b>' . site_company_name . '</b> family.</td>
			  </tr>
			 
			  <tr><td><br/><br/>Thanking you. </td></tr>
			  <tr><td><br/><br/>With regards</td></tr>
			 
			  <tr><td><br/><br/><b>' . site_company_name . '</b></td></tr>
			  <tr><td><br/><br/>Chief Managing Director & Founder</td></tr>			 
			  <tr><td>&nbsp;</td></tr>
			</table>';
        return $Message;
    }

    /* ==========================( Total Booking Collection )======================================== */

    function TotalBookingCollection($payment_booking_id) {
        $DBOBJ = new DataBase();
        $DBOBJ->ConnectDatabase();
        $Q = @mysqli_query($_SESSION['CONN'], "select sum(payment_amount) as total_collection from tbl_property_booking_payments where payment_booking_id='$payment_booking_id' and approved='1' ");
        ;
        $ROW = @mysqli_fetch_assoc($Q);
        return $ROW['total_collection'];
    }

    /* ==========================( Total Booking Balance )======================================== */

    function TotalBookingBalance($payment_booking_id) {
        $DBOBJ = new DataBase();
        $DBOBJ->ConnectDatabase();
        $COLLECTION = $DBOBJ->TotalBookingCollection($payment_booking_id);
        $MRP = $DBOBJ->ConvertToText("tbl_property_booking", "booking_id", "booking_property_discounted_mrp", $payment_booking_id);
        return $MRP - $COLLECTION;
    }

    /* ==========================( Total Booking Balance )======================================== */

    function PropertyTypeName($property_id) {
        $DBOBJ = new DataBase();
        $DBOBJ->ConnectDatabase();
        $PROPERTY_TYPE_ID = $DBOBJ->ConvertToText("tbl_property", "property_id", "property_type_id", $property_id);
        $PROPERTY_TYPE = $DBOBJ->ConvertToText("tbl_setting_property_type", "property_type_id", "property_type", $PROPERTY_TYPE_ID);
        return $PROPERTY_TYPE;
    }

    function GetAdvisorTeam($PARENT) {
        $DBOBJ = new DataBase();
        $DBOBJ->ConnectDatabase();
        global $ADVISOR_TEAM;

//------------------------name of consulatant by introducer id 
        $ADV_Q = "select advisor_id from tbl_advisor where advisor_sponsor = '$PARENT' ";
        $ADV_Q = @mysqli_query($_SESSION['CONN'], $ADV_Q);
        while ($ADV_ROW = @mysqli_fetch_assoc($ADV_Q)) {
            $ADVISOR_TEAM = $ADVISOR_TEAM . "," . $ADV_ROW['advisor_id'];
            $DBOBJ->GetAdvisorTeam($ADV_ROW['advisor_id']);
        }
    }

    function GetAdvisorParents($CHIELD, $PROPERTY_TYPE, $PROJECT_ID) {
        $DBOBJ = new DataBase();
        $DBOBJ->ConnectDatabase();
        $CURRENT_ADVISOR = $CHIELD;
        $STRING['PATENT'] = "";
        $STRING['LEVEL'] = "";
        $STRING['PERCENT'] = "";
        $STRING['DIFF'] = "";

        $CHIELD_ADVISOR_LEVEL = $DBOBJ->ConvertToText("tbl_advisor", "advisor_id", "advisor_level_id", $CHIELD);
        $CHIELD_ADVISOR_PERCENT = $DBOBJ->ConvertToText("tbl_setting_advisor_level_with_property_type", "project_id='$PROJECT_ID' and level_id='$CHIELD_ADVISOR_LEVEL' AND property_type_id", "commission_percent", $PROPERTY_TYPE);
        $DIFF_PERCENT = $CHIELD_ADVISOR_PERCENT;
        while ($CURRENT_ADVISOR > 0) {
            $CURRENT_ADVISOR = $DBOBJ->ConvertToText("tbl_advisor", "advisor_id", "advisor_sponsor", $CHIELD);
            $CHIELD = $CURRENT_ADVISOR;

            if ($CURRENT_ADVISOR == "" || $CURRENT_ADVISOR == "0" || !$CURRENT_ADVISOR || $CURRENT_ADVISOR == NULL) {
                $CURRENT_ADVISOR = 0;
                break;
            } else {
                $ADVISOR_LEVEL = $DBOBJ->ConvertToText("tbl_advisor", "advisor_id", "advisor_level_id", $CURRENT_ADVISOR);
                $ADVISOR_PERCENT = $DBOBJ->ConvertToText("tbl_setting_advisor_level_with_property_type", "project_id='$PROJECT_ID' and  level_id='$ADVISOR_LEVEL' AND property_type_id", "commission_percent", $PROPERTY_TYPE);

                $DIFF_PERCENT = $ADVISOR_PERCENT - $CHIELD_ADVISOR_PERCENT;

                if ($DIFF_PERCENT > 0) {
                    //do nothing
                    $CHIELD_ADVISOR_PERCENT = $ADVISOR_PERCENT;
                } else {
                    $DIFF_PERCENT = 0;
                    $CHIELD_ADVISOR_PERCENT = $CHIELD_ADVISOR_PERCENT;
                }

                $ONE_STEP_ABOVE_PARENT = $DBOBJ->ConvertToText("tbl_advisor", "advisor_id", "advisor_sponsor", $CURRENT_ADVISOR);
                if ($ONE_STEP_ABOVE_PARENT > 0) {
                    $STRING['PARENT'] .= $CURRENT_ADVISOR . ",";
                    $STRING['LEVEL'] .= $ADVISOR_LEVEL . ",";
                    $STRING['PERCENT'] .= $ADVISOR_PERCENT . ",";
                    $STRING['DIFF'] .= $DIFF_PERCENT . ",";
                } else {
                    $STRING['PARENT'] .= $CURRENT_ADVISOR;
                    $STRING['LEVEL'] .= $ADVISOR_LEVEL;
                    $STRING['PERCENT'] .= $ADVISOR_PERCENT;
                    $STRING['DIFF'] .= $DIFF_PERCENT;
                }
            }
        }

        return $STRING;
    }

    function GetAdvisorTotalCollection($TEAM_STRING, $s_date, $e_date) {
        $DBOBJ = new DataBase();
        $DBOBJ->ConnectDatabase();
        $PAYMENT_Q = "SELECT SUM(payment_amount) AS COLLECTION						 
						  FROM tbl_property_booking_payments WHERE 
						  payment_advisor_id IN ($TEAM_STRING) AND
						  payment_date BETWEEN '$s_date' AND '$e_date' and 
						  approved='1' ";
        $PAYMENT_Q = @mysqli_query($_SESSION['CONN'], $PAYMENT_Q);
        $PAYMENT_ROW = @mysqli_fetch_assoc($PAYMENT_Q);

        return $PAYMENT_ROW['COLLECTION'];
    }

    function GetAdvisorSelfCollection($PARENT, $s_date, $e_date) {
        $DBOBJ = new DataBase();
        $DBOBJ->ConnectDatabase();
        //echo "<br>";
        $PAYMENT_Q = "SELECT SUM(payment_amount) AS COLLECTION 						 
						  FROM tbl_property_booking_payments WHERE 
						  payment_advisor_id = '$PARENT' AND
						  payment_date BETWEEN '$s_date' AND '$e_date' and 
						  approved='1' ";
        $PAYMENT_Q = @mysqli_query($_SESSION['CONN'], $PAYMENT_Q);
        $PAYMENT_ROW = @mysqli_fetch_assoc($PAYMENT_Q);

        return $PAYMENT_ROW['COLLECTION'];
    }

    function ValidateCustomer($AdvisorTeam, $CustomerId) {
        $DBOBJ = new DataBase();
        $DBOBJ->ConnectDatabase();
        $CUST_Q = "select booking_customer_id from tbl_property_booking where booking_advisor_id in($AdvisorTeam) and booking_customer_id='$CustomerId' group by  booking_customer_id";
        $CUST_Q = @mysqli_query($_SESSION['CONN'], $CUST_Q);
        $exist = @mysqli_num_rows($CUST_Q);

        if ($exist > 0) {
            
        } else {
            header("location:Customer.php?Error=Invalid Customer Selection.");
        }
    }

    function ValidateAdvisor($AdvisorTeam, $AdvisorId) {
        $DBOBJ = new DataBase();
        $DBOBJ->ConnectDatabase();
        $ADV_Q = "select advisor_id from tbl_advisor where advisor_id in($AdvisorTeam) and advisor_id='" . $AdvisorId . "'";
        $ADV_Q = @mysqli_query($_SESSION['CONN'], $ADV_Q);
        $exist = @mysqli_num_rows($ADV_Q);

        if ($exist > 0) {
            
        } else {
            header("location:Advisor.php?Error=Invalid Advisor Selection.");
        }
    }

    function AdvisorNetCommission($Advisor, $s_date, $e_date) {
        $DBOBJ = new DataBase();
        $DBOBJ->ConnectDatabase();
        $COM_Q = "select SUM(commission_nett_amount) AS COM from tbl_advisor_commission where commission_advisor_id='$Advisor' and commission_date BETWEEN '$s_date' AND '$e_date' and approved='1'  ";
        $COM_Q = @mysqli_query($_SESSION['CONN'], $COM_Q);
        $COM_ROWS = @mysqli_fetch_assoc($COM_Q);
        return $COM_ROWS['COM'];
    }

    function AdvisorTotalPaid($Advisor, $s_date, $e_date) {
        $DBOBJ = new DataBase();
        $DBOBJ->ConnectDatabase();
        $PAID_Q = "select SUM(payment_amount) AS PAID from tbl_advisor_payment where payment_advisor_id='$Advisor' and payment_date BETWEEN '$s_date' AND '$e_date'  and approved='1' ";
        $PAID_Q = @mysqli_query($_SESSION['CONN'], $PAID_Q);
        $PAID_ROWS = @mysqli_fetch_assoc($PAID_Q);
        return $PAID_ROWS['PAID'];
    }

}

?>
