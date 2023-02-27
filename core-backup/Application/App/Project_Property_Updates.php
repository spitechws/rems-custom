<?php
include_once("../Menu/HeaderAdmin.php");
include_once("../php/SpitechDB.php");
include_once("../php/SpitechUtility.php");
include_once("../php/SpitechPagination.php");
include_once("../php/SpitechJS.php");

Menu("Project");
NoUser();
$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();
RefreshPage(5);

$property_id = 0;
if (isset($_GET[md5('property_id')])) {
    $property_id = $_GET[md5('property_id')];
    $PROPERTY = $DBOBJ->GetRow('tbl_property', 'property_id', $property_id);
    if (isset($PROPERTY['property_project_id'])) {
        $PROJECT = $DBOBJ->GetRow('tbl_project', 'project_id', $PROPERTY['property_project_id']);
    } else {
        show404('This property not exist');
    }
} else {
    permission_denied();
}
//debug($PROPERTY);
?>
<link href="../css/SpitechStyle.css" rel="stylesheet" type="text/css" />
<center>
    <h1><img src="../SpitechImages/Project.png" width="31" height="32" /><?php echo $PROJECT['project_name'] ?>  : <span><?php echo $PROPERTY['property_no'] ?></span>        
        <A style="float:right; margin-right:30px;" href="Project_Property_Updates_Form.php?<?php echo md5("property_id") . "=" . $PROPERTY['property_id']; ?>" ><img src="../SpitechImages/Add.png" />Add Photo</A>
    </h1>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" id="Content">
        <tr>
            <td>
        <center>
            <?php ErrorMessage(); ?>           
            <table  border="0" cellspacing="1" cellpadding="0" id="Data-Table" >
                <tr>
                    <th width="2%">#</th>
                    <th width="5%">DATE</th>
                    <th width="10%">PHOTO</th>
                    <th width="*">REMARK</th>                   
                    <th colspan="2" class="Action">ACTION</th>
                </tr>
                <?php
                $page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
                if (isset($_GET["limit"])) {
                    $limit = $_GET["limit"];
                } else {
                    $limit = 10;
                }
                $startpoint = ($page * $limit) - $limit;
                if (isset($_GET["page"])) {
                    $k = ($page - 1) * ($limit) + 1;
                } else
                    $k = 1;
                //----------------------------------------------------------		
                $PROJECTS_QUERY = "select * from tbl_property_updates where 1 and property_id=".$property_id;
                $PAGINATION_QUERY = $PROJECTS_QUERY . "  order by date desc";
                $PROJECTS_QUERY = $PAGINATION_QUERY . "  LIMIT {$startpoint} , {$limit}";
                $PROJECTS_QUERY = @mysqli_query($_SESSION['CONN'], $PROJECTS_QUERY);
                $RECORD_FOUND = @mysqli_num_rows($PROJECTS_QUERY);

                while ($UPDATE_ROWS = @mysqli_fetch_assoc($PROJECTS_QUERY)) {
                    $edit_url = "Project_Property_Updates_Form.php?" . md5('property_id') . "=" . $property_id . "&" . md5('edit_id') . "=" . $UPDATE_ROWS['id'];
                    $delete_url = "Project_Property_Updates.php?" . md5('property_id') . "=" . $property_id . "&" . md5('delete_id') . "=" . $UPDATE_ROWS['id'];
                    ?>
                    <tr>
                        <td height="79"><div align="center"><?php echo $k++; ?>.</div></td>
                        <td ><div align="left"><?php echo date('d/M/Y', strtotime($UPDATE_ROWS['date'])); ?></div></td>
                        <td style="padding:0px; margin:0px; text-align:center">
                            <?php
                            $ACTUAL_PHOTO = "../SpitechUploads/project/proprty_update/" . $UPDATE_ROWS['image'];
                            $exist = file_exists($ACTUAL_PHOTO);
                            if ($exist != "1" || $UPDATE_ROWS['image'] == "") {
                                $ACTUAL_PHOTO = "../SpitechImages/Project.png";
                            }
                            ?>
                            <img src="<?php echo $ACTUAL_PHOTO; ?>" height="90"/>
                        </td>
                        <td><?php echo $UPDATE_ROWS['remark']; ?></td>                        
                        <td width="6%" class="Action">
                            <div align="center" style="width:70px;"> 
                                <a id="Edit" href="<?php echo $edit_url ?>" title="Edit Details : <?php echo $UPDATE_ROWS['project_name']; ?>">&nbsp;</a> ;
                                <a id="Delete" href="<?php echo $delete_url ?>" <?php Confirm("Are you sure want to delete this update? " . $UPDATE_ROWS['remark'] . " ? "); ?>  title="Delete: <?php echo $UPDATE_ROWS['remark']; ?>">&nbsp;</a>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            </table>
            <div class="paginate" ><?php pagination($PAGINATION_QUERY, $limit, $page, url()); ?></div>

        </center>
        </td>
        </tr>
    </table>
</center>
<?php
if (isset($_GET[md5("delete_id")])) {
    NoAdmin();
    $DELETE_ROW = $DBOBJ->GetRow("tbl_property_updates", "id", $_GET[md5("delete_id")]);

    @mysqli_query($_SESSION['CONN'], "Delete from tbl_property_updates where id='" . $_GET[md5("delete_id")] . "'");

    @unlink('../SpitechUploads/project/proprty_update/' . $DELETE_ROW['image']);

    $DBOBJ->UserAction("PROPERTY UPDATES DELETED", "ID=" . $_GET[md5("delete_id")] . ", NAME : " . $DELETE_ROW['project_name']);
    $delete_url = "Project_Property_Updates.php?" . md5('property_id') . "=" . $DELETE_ROW['property_id'] . "&Message=Property update : " . $DELETE_ROW['remark'] . " Deleted.";
    header("location:".$delete_url);
}
include("../Menu/Footer.php");
?>
