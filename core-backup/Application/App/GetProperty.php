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
<select id="<?php echo md5("property_id"); ?>" name="<?php echo md5("property_id"); ?>" >
          <option value="All">ALL PROPERTY...</option>
          <?php 
             $PROPERTY_Q=@mysqli_query($_SESSION['CONN'],"select property_id, property_no  from tbl_property where property_project_id='".$_GET['project_id']."' order by  property_id, property_no  ");
             while($PROPERTY_ROWS=@mysqli_fetch_assoc($PROPERTY_Q)) 
             {?>
          <option value="<?php echo $PROPERTY_ROWS['property_id']?>"><?php echo $PROPERTY_ROWS['property_no']?></option>
          <?php } ?>
</select>