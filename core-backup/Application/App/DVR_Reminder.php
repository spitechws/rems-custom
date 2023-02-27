<?php
include_once("../Menu/HeaderAdmin.php");
Menu("Enquiry");
$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();

$s_date = date('2000-01-01');
$e_date = NextDate(date('Y-m-d'), +0);
if (isset($_GET['Search'])) {
    $s_date = $_GET['s_date'];
    $e_date = $_GET['e_date'];
}
?>
<link href="../css/SpitechStyle.css" rel="stylesheet" type="text/css" /> 
<style>
    #Data-Table #white td { background:#fff; }
    #Data-Table #red td { background:#CEFFE7; }	
</style>

<h1><img src="../SpitechImages/DVR_Reminder.png" />DVR : <span>Reminder</span></h1>

<table width="100%" border="0" align="center" cellspacing="0" cellpadding="0" id="Content">
    <tr>
        <td >
            <?php ErrorMessage(); ?>
            <form name="FindForm" id="FindForm" method="get" >

                <table width="98%" border="1" cellspacing="0" cellpadding="0" id="SearchTable" class="SearchTable" style="margin-top:5px;">
                    <tr>
                        <td><?php echo advisor_title ?></td>                        
                        <td width="10%" style="line-height:12px"> Mobile</td>
                        <td colspan="2" width="*">FROM --- To -- DATE</td>                        
                        <TD width="4%">STATUS</TD>
                        <td colspan="2" width="20%">Action</td>
                    </tr>
                    <tr>
                       <td>          
                            <select id="<?php echo md5('advisor_id'); ?>" name="<?php echo md5('advisor_id'); ?>">
                                <option value="All">All <?php echo advisor_title ?>...</option>
                                <?php
                                $ADVISOR_Q = "SELECT advisor_id, advisor_code, advisor_name FROM tbl_advisor ORDER BY advisor_name";
                                $ADVISOR_Q = @mysqli_query($_SESSION['CONN'], $ADVISOR_Q);
                                while ($ADVISOR_ROWS = @mysqli_fetch_assoc($ADVISOR_Q)) {
                                    ?>
                                    <option value="<?php echo $ADVISOR_ROWS['advisor_id']; ?>" <?php SelectedSelect($ADVISOR_ROWS['advisor_id'], $_GET[md5('advisor_id')]); ?>>
                                        <?php echo $ADVISOR_ROWS['advisor_name'] . " [" . $ADVISOR_ROWS['advisor_code'] . " ]"; ?></option>
                                <?php } ?>
                            </select>          
                        </td> 
                        <td>
                            <input type="text" name="mobile_no" id="mobile_no" placeholder="Mobile" value="<?php echo $_GET['mobile_no']; ?>" style="width:100px"/>
                        </td> 
                                             
                        <td width="3%" class="Date"><script>DateInput('s_date', true, 'yyyy-mm-dd', '<?php echo $s_date; ?>');</script></td>
                      
                        <td width="4%" class="Date"><script>DateInput('e_date', true, 'yyyy-mm-dd', '<?php echo $e_date; ?>');</script></td>
                       
                        <TD>
                            <select name="status" id="status" style="width:100px">
                                <option value="All">All Status...</option>
                                <option value="Enable" <?php SelectedSelect("Enable", $_GET['status']); ?>>Enabled</option>
                                <option value="Disable" <?php SelectedSelect("Disable", $_GET['status']); ?>>Disabled</option>
                                <option value="Booked" <?php SelectedSelect("Booked", $_GET['status']); ?>>Booked</option>
                            </select>
                        </TD>
                        <td width="8%"><input type="submit" name="Search" value=" " id="Search" /></td>
                        <td width="36%"><input type="button" name="All" value="Show All" class="Button" onclick="window.location = 'DVR_Reminder.php';" /></td>
                    </tr>
                </table>
            </form>
            <table width="98%" border="0" cellspacing="1" cellpadding="0" id="Data-Table">
                <tr>
                    <th width="23">#</th>
                    <th width="69">DATE</th>
                    <th width="69">REMIND&nbsp;ON</th>
                    <th colspan="2">advisor</th>
                    <th width="248">CUSTOMER</th>
                    <th>MOBILE</th>
                    <th>PROJECT</th>
                    <th>PROPERTY</th>
                    <th width="284">REMARKS</th>
                    <th width="62">Status</th>
                    <th width="52">ACTION</th>
                </tr>
                <?php
                $page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
                if (isset($_GET["limit"])) {
                    $limit = $_GET["limit"];
                } else {
                    $limit = 100;
                }
                $startpoint = ($page * $limit) - $limit;
                if (isset($_GET["page"])) {
                    $k = ($page - 1) * ($limit) + 1;
                } else
                    $k = 1;
                //----------------------------------------------------------		
                $DVR_QUERY = "select * from tbl_advisor_dvr where 1 ";

                if (!isset($_GET['Search'])) {
                    $DVR_QUERY .= " and status='Enable' ";
                }

                if (isset($_GET['Search'])) {
                    if ($_GET['status'] != "All") {
                        $DVR_QUERY .= " and status ='" . $_GET['status'] . "'";
                    }
                    if ($_GET['mobile_no'] != "") {
                        $DVR_QUERY .= " and mobile_no ='" . $_GET['mobile_no'] . "'";
                    }
                    if ($_GET[md5('advisor_id')] != "All") {
                        $DVR_QUERY .= " and advisor_id ='" . $_GET[md5('advisor_id')] . "'";
                    }
                }

                $DVR_QUERY .= " and remind_date between '" . $s_date . "' and '" . $e_date . "' ";
                $PAGINATION_QUERY = $DVR_QUERY . "  order by remind_date desc, dvr_id desc ";
                $DVR_QUERY = $PAGINATION_QUERY . "  LIMIT {$startpoint} , {$limit}";
                $DVR_QUERY = @mysqli_query($_SESSION['CONN'], $DVR_QUERY);
                $RECORD_FOUND = @mysqli_num_rows($DVR_QUERY);

                while ($DVR_ROWS = @mysqli_fetch_assoc($DVR_QUERY)) {

                    $id = 'red';

                    if ($DVR_ROWS['status'] == "Enable") {
                        $id = 'white';
                    } else if ($DVR_ROWS['status'] == "Booked") {
                        $id = 'yellow';
                    }
                    ?>
                    <tr id="<?php echo $id ?>">
                        <td><div align="center"><?php echo $k++; ?>.</div></td>
                        <td><div align="center" style="width:65px;"><?php echo date('d-M-Y', strtotime($DVR_ROWS['dvr_date'])); ?></div></td>
                        <td><div align="center" style="width:65px;"><?php echo date('d-M-Y', strtotime($DVR_ROWS['remind_date'])); ?></div></td>
                        <td width="184"><?php echo $DBOBJ->ConvertToText("tbl_advisor", "advisor_id", "advisor_name", $DVR_ROWS["advisor_id"]) ?></td>
                        <td width="39" style="text-align:center"><?php echo $DBOBJ->ConvertToText("tbl_advisor", "advisor_id", "advisor_code", $DVR_ROWS["advisor_id"]) ?></td>
                        <td><?php echo $DVR_ROWS['customer_name']; ?></td>
                        <td width="88" style="text-align:center"><?php echo $DVR_ROWS['mobile_no']; ?></td>
                        <td width="93" style="text-align:left"><?php echo $DBOBJ->ConvertToText("tbl_project", "project_id", "project_name", $DVR_ROWS["project_id"]) ?></td>
                        <td width="57" style="text-align:center"><?php echo $DBOBJ->ConvertToText("tbl_property", "property_id", "property_no", $DVR_ROWS["property_id"]) ?></td>
                        <td width="284"><?php echo $DVR_ROWS['remarks']; ?></td>
                        <td width="62" style="text-align:center"><?php echo $DVR_ROWS['status']; ?></td>
                        <td>
                            <div align="center" style="width:50px;">

                                <a id="Report" <?php Modal("DVR_View.php?" . md5("edit_id") . "=" . $DVR_ROWS['dvr_id'], "950px", "500px", "500px", "100px"); ?> title="View  DVR Details">&nbsp;&nbsp;</a>

                                <a id="Delete" href="DVR.php?<?php echo md5("dvr_delete_id") . "=" . $DVR_ROWS['dvr_id']; ?>" <?php Confirm("Are You Sure ? Delete This Expense Entry ? "); ?>  title="Delete DVR ">&nbsp;</a>
                            </div>        
                        </td>
                    </tr>
                <?php } ?>
            </table>    <div align="right" class="paginate"><?php pagination($PAGINATION_QUERY, $limit, $page, url('DVR_Reminder.php')); ?></div>

        </td>
    </tr>
</table>
<?php
if ($_GET[md5("dvr_delete_id")] > 0) {
    NoAdmin();
    $DELETE_ROW = $DBOBJ->GetRow("tbl_advisor_dvr", "dvr_id", $_GET[md5("dvr_delete_id")]);

    @mysqli_query($_SESSION['CONN'], "Delete From tbl_advisor_dvr where dvr_id='" . $_GET[md5("dvr_delete_id")] . "' ");
    $DBOBJ->UserUserAction("DVR DELETED BY ADMIN", " ID : " . $_GET[md5("dvr_delete_id")] . ", CUSTOMER : " . $DELETE_ROW['customer_name']);
    header("location:DVR_Reminder.php?Message=Selected DVR Have Been Deleted Successfully.");
}
include("../Menu/Footer.php");
?>
