<?php
include_once("../Menu/HeaderAdmin.php");
include_once("../php/SpitechDB.php");
include_once("../php/SpitechUtility.php");
include_once("../php/SpitechPagination.php");
include_once("../php/SpitechJS.php");
Menu("Settings");NoAdmin();NoUser();
$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();

$EDIT_Q=@mysqli_query($_SESSION['CONN'],"SELECT * FROM tbl_setting_tds");
$EDIT_ROW=@mysqli_fetch_assoc($EDIT_Q);
$COUNT=@mysqli_num_rows($EDIT_Q);
if($COUNT<1)
{
	@mysqli_query($_SESSION['CONN']," TRUNCATE TABLE tbl_setting_tds");
	$FIELDS=array("tds","created_details","edited_details");									  
	$VALUES=array("10",$Mess=CreatedEditedByUserMessage(),$Mess);				
	$INSERT=$DBOBJ->Insert("tbl_setting_tds",$FIELDS,$VALUES,0);	
}
if(isset($_POST['Save']))
	 { 	  		
	                @mysqli_query($_SESSION['CONN']," TRUNCATE TABLE tbl_setting_tds");
		         	$FIELDS=array("tds","created_details","edited_details");									  
					$VALUES=array($_POST["tds"],$Mess=CreatedEditedByUserMessage(),$Mess);				
					$INSERT=$DBOBJ->Insert("tbl_setting_tds",$FIELDS,$VALUES,0);	
					
					$DBOBJ->UserAction("TDS SETTING EDITED",$_POST['tds']."%");
					$Message="TDS EDITED SUCCESSFULLY.";
			
      header("location:Setting_TDS.php?Message=".$Message);
	}	
?>
<link href="../css/SpitechStyle.css" rel="stylesheet" type="text/css" />
<center>
<h1><img src="../SpitechImages/Settings.png" width="31" height="32" />Settings  : <span>TDs Percent</span></h1>
<table width="100%" border="0" align="center" cellspacing="0" cellpadding="0" id="Content">
  <tr>
    <td align="center">
    <center>
    <?php ErrorMessage(); ?>
    <form name="FormPropertyType" id="FormPropertyType" method="post"  >
    <fieldset style="width:400px; height:200px;"><legend>TDS Entry/Edit :</legend>
<table width="300" border="0" cellspacing="0" cellpadding="0" id="CommonTable" style="border:0px;" align="center">
  <tr>
    <td width="69">&nbsp;</td>
    <td width="131">&nbsp;</td>
    <td width="100">&nbsp;</td>
  </tr>
  <tr>
    <td>tds</td>
    <td><input type="text" name="tds" id="tds" value="<?php echo $EDIT_ROW['tds'];?>" placeholder="TDS" REQUIRED="" <?php OnlyFloat(); ?> max="10" /></td>
    <td>%</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">
      <div align="right">
        <input type="submit" name="Save" id="Save" class="Button" value=" Save " <?php Confirm("Are You Sure ? Save TDS Setting ?"); ?>/>
        <input type="button" name="Cancel" id="Cancel" value="Cancel" onClick="window.location='Settings.php';" />
      </div></td>
    <td>&nbsp;</td>
  </tr>
</table>

    </fieldset>
    </form>
    </center>
    </td>
  </tr>
</table>
</center>
<?php 
include("../Menu/Footer.php"); 
?>
