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

if (isset($_GET[md5('edit_id')])) {
    $EDIT_ROW = $DBOBJ->GetRow("tbl_property_updates", "id", $_GET[md5('edit_id')]);
    $title = "Edit Property Photo";
} else {
    $title = "Add Property Photo";
}

$property_id = 0;
if (isset($_GET[md5('property_id')])) {
    $property_id = $_GET[md5('property_id')];
    $PROPERTY = $DBOBJ->GetRow('tbl_property', 'property_id', $property_id);
    if (isset($PROPERTY['property_id'])) {
        $PROJECT = $DBOBJ->GetRow('tbl_project', 'project_id', $PROPERTY['property_project_id']);
    } else {
        show404('This property not exist');
    }
} else {
    permission_denied();
}



if (isset($_POST['Save'])) {
    $image = FileUpload($_FILES['image'], "../SpitechUploads/project/proprty_update/", "1");
//=================( Checking Project's Photo )==============================================================
    if (($image == "" || $image == NULL) && $_GET[md5("edit_id")] > 0) {
        $image = $EDIT_ROW['image'];
    }
    if ($_GET[md5("edit_id")] > 0 && $image != $EDIT_ROW['image']) {
        @unlink("../SpitechUploads/project/proprty_update/" . $EDIT_ROW['image']);
    }
    $date = $_POST['date_Y'] . '-' . $_POST['date_M'] . '-' . $_POST['date_D'];
    $FIELDS = array(
        "property_id",
        "date",
        "remark",
        "image"
    );
    $VALUES = array(
        $property_id,
        $date,
        $_POST['remark'],
        $image,
        CreatedEditedByUserMessage());
    if (isset($_GET[md5("edit_id")])) {
        array_push($FIELDS, "edited_details");
        $DBOBJ->Update("tbl_property_updates", $FIELDS, $VALUES, "id", $_GET[md5("edit_id")], 0);
    } else {
        array_push($FIELDS, "created_details");
        $DBOBJ->Insert("tbl_property_updates", $FIELDS, $VALUES, 1);
    }
    $Message = "Poperty updates saved successfully";
    header("location:Project_Property_Updates.php?" . md5('property_id') . "=" . $property_id . "&Message=" . $Message);
}
?>
<link href="../css/SpitechStyle.css" rel="stylesheet" type="text/css" />
<div style="background-color:white;">
    <center>
        <h1><img src="../SpitechImages/Project.png" width="31" height="32" /><?php echo $PROJECT['project_name'] ?>  : <span><?php echo $PROPERTY['property_no'] ?></span>                
        </h1>
        <fieldset style="width:600px; margin:0px; padding:0px;">
            <legend><?php echo $title; ?></legend>
            <?php MessageError(); ?>
            <form name="form1" id="form1" method="post" enctype="multipart/form-data" >
                <?php if (!isset($_GET[md5('edit_id')])) { ?>

                <?php } ?>
                <table width="100%" border="0" cellspacing="10" cellpadding="5" id="CommonTable" style="border:0px; margin-top:0px;">

                    <tr>   
                        <td>Photo</td>
                        <td style="vertical-align:top;">
                            <?php
                            $ACTUAL_PHOTO = "../SpitechUploads/project/proprty_update/" . $EDIT_ROW['image'];
                            $exist = file_exists($ACTUAL_PHOTO);
                            if ($exist != "1" || $EDIT_ROW['image'] == "") {
                                $ACTUAL_PHOTO = "../SpitechImages/Project.png";
                            }
                            ?>
                            <img src="<?php echo $ACTUAL_PHOTO; ?>" alt="Photo" width="100" height="100" id="imgimage" style="border:1px solid maroon"/>
                        </td>
                        <td width="227" style="vertical-align:top;">
                            <?php FileImageInput("image", $ACTUAL_PHOTO, 250)
                            ?>
                        </td>
                    </tr>
                    <tr>                        
                        <td>Date</td>
                        <td colspan="2">
                            <?php
                            $DATE = ReceiveDate("date", "POST");
                            if (isset($EDIT_ROW['date'])) {
                                $DATE = $EDIT_ROW['date'];
                            } else {
                                $DATE = date('Y-m-d');
                            }
                            DateInput("date", $DATE, "form1.submit();");
                            ?>
                        </td>
                    </tr>
                    <tr>                       
                        <td width="20%">Details</td>
                        <td width="*" colspan="2">     
                            <?php 
                            $remark='';
                            if(isset($_POST['remark'])){
                                $remark=$_POST['remark'];
                            }else if(isset ($EDIT_ROW['remark'])){
                                $remark=$EDIT_ROW['remark'];
                            }
                            ?>
                            <textarea name="remark" id="remark" placeholder="Details of Photo Update"  style="width:100%;"><?php echo $remark; ?></textarea>

                        </td>
                    </tr>

                    <tr>
                        <td colspan="3" style="text-align:RIGHT">
                            <input type="submit" name="Save" id="Save" value="Save" <?php Confirm("Are you sure want to save the proprety update?"); ?>/>
                            <input type="button" name="Cancel" id="Cancel" value="Cancel" onClick="history.go(-1);" />
                        </td>
                    </tr>

                </table>
            </form>
        </fieldset>
    </center>
</div>
<?php
include("../Menu/Footer.php");
?>
