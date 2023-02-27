<?php
include_once("../Menu/HeaderCommon.php");
include_once("../php/SpitechDB.php");
include_once("../php/SpitechUtility.php");
include_once("../php/SpitechJS.php");
NoUser();

$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();
$CATEGORY_ID=$_GET['category_id'];
$SUB_CATEGORY_ID=$_GET['sub_category_id'];
?>
<div id="sub">

    <select id="sub_category_id" name="sub_category_id" required=''>
      <?php $Q=@mysqli_query($_SESSION['CONN'],"SELECT * FROM tbl_expense_sub_category where category_id='".$CATEGORY_ID."' order by sub_category_name");
		   while($CAT_ROWS=@mysqli_fetch_assoc($Q)) { ?>
      <option value="<?php echo $CAT_ROWS['sub_category_id']; ?>" <?php SelectedSelect($CAT_ROWS['sub_category_id'],$SUB_CATEGORY_ID); ?>>
        <?php echo $CAT_ROWS['sub_category_name'];?>
        </option>
      <?php } ?>
    </select>
  
</div>