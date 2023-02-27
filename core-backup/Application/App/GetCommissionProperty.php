<?php
session_start();
include_once("../php/SpitechDB.php");
include_once("../php/SpitechUtility.php");
include_once("../php/SpitechPagination.php");
include_once("../php/SpitechJS.php");

NoUser();
$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();


?>
<select id="commission_property_id" name="commission_property_id" style="width:100px;">
          <option value="All">ALL PROPERTY...</option>
          <?php 
             $PROPERTY_Q=@mysqli_query($_SESSION['CONN'],"select property_id, property_no  from tbl_property where property_project_id='".$_GET['project_id']."' and  property_id in(select commission_property_id from tbl_advisor_commission where approved='1' group by commission_property_id) order by  property_id, property_no  ");
             while($PROPERTY_ROWS=@mysqli_fetch_assoc($PROPERTY_Q)) 
             {?>
          <option value="<?php echo $PROPERTY_ROWS['property_id']?>"><?php echo $PROPERTY_ROWS['property_no']?></option>
          <?php } ?>
</select>