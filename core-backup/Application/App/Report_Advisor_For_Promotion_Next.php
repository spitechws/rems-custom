<?php
session_start();
include_once("../Menu/HeaderCommon.php");
include_once("../php/SpitechDB.php");
include_once("../php/SpitechUtility.php");
include_once("../php/SpitechPagination.php");
include_once("../php/SpitechJS.php");
NoUser();
NoAdmin();
$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();
$advisor_id=$_GET[md5('advisor_id')];
$ADVISOR_ROW=$DBOBJ->GetRow("tbl_advisor","advisor_id",$advisor_id);

$level_id=$ADVISOR_ROW['advisor_level_id'];
$level=$DBOBJ->ConvertToText("tbl_setting_advisor_level","level_id","level_name",$ADVISOR_ROW['advisor_level_id']);

if(isset($_POST['Save']))
{
	
	
	//========================(PROMOTION TABLE)=======================
	    $FIELDS=array("advisor_id" ,
					"prev_level_id" ,
					"promoted_level_id" ,
					"promotion_date" ,
					"promotion_time" ,	
					"created_details",				
					"edited_details");	
				   
	    $VALUES=array($advisor_id ,
					  $level_id ,
					  $_POST["advisor_level_id"] ,
					  date('Y-m-d'),
					  IndianTimeLong() ,
					  $mess=CreatedEditedByUserMessage(),
					  $mess);
					
		$DBOBJ->Insert("tbl_advisor_promotion",$FIELDS,$VALUES,0);	
		
		//========================(CHANGING LEVEL)=======================
		 $FIELDS=array("advisor_level_id");					   
	     $VALUES=array($_POST["advisor_level_id"]);					
		 $DBOBJ->Update("tbl_advisor",$FIELDS,$VALUES,"advisor_id",$advisor_id,0);	
		
		//=============( ENTRY IN ACTION TABLE )=======================================================
		$new_level_name=$DBOBJ->ConvertToText("tbl_setting_advisor_level","level_id","level_name",$_POST["advisor_level_id"]);
		$DBOBJ->UserAction(advisor_title." PROMOTED ", " NAME : ".$ADVISOR_ROW['advisor_name'].", from : ".$level." to ".$new_level_name);
	
	 echo "<script>alert('".advisor_title." : ".$ADVISOR_ROW['advisor_name'].", Promoted From Level : ".$level."' To Level : ".$new_level_name.");</script>";
	 UnloadMe();
}
?>
<link href="../css/SpitechStyle.css" rel="stylesheet" type="text/css" />

    <center>

<table width="330" border="0" cellspacing="0" cellpadding="5" id="CommonTable">
  
  <form name="AdvisorForm" id="AdvisorForm" method="post" enctype="multipart/form-data" >
   
    <tr>
      <th colspan="3"><div align="left">Promot <?php echo advisor_title?></div></th>
      </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td id="Value2">&nbsp;</td>
    </tr>
    <tr>
      <td width="11">&nbsp;</td>
      <td width="97"><?php echo advisor_title?></td>
       <td width="192" id="Value"><?php echo $ADVISOR_ROW['advisor_name']?></td>
      </tr>
        <tr>
      <td width="11">&nbsp;</td>
      <td width="97">ID</td>
       <td width="192" id="Value"><?php echo $ADVISOR_ROW['advisor_code']?></td>
      </tr>
    <tr>
      <td>&nbsp;</td>
      <td>current&nbsp;level</td>
      <td width="192" id="Value"><?php echo $level?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td style="line-height:13px; text-align:justify;">promot to <b class="Required">*</b></td>
      <td>
      <select id="advisor_level_id" name="advisor_level_id" required="" style="width:100px;" >
        <?php 
			   $LEVEL_Q="SELECT level_id, level_name FROM tbl_setting_advisor_level ORDER BY level_id";
			   $LEVEL_Q=@mysqli_query($_SESSION['CONN'],$LEVEL_Q);
			   while($LEVEL_ROWS=@mysqli_fetch_assoc($LEVEL_Q)) {?>
        <option value="<?php echo $LEVEL_ROWS['level_id'];?>" <?php SelectedSelect($LEVEL_ROWS['level_id'], $level_id); ?>> 
		  <?php echo $LEVEL_ROWS['level_name'];?>
        </option>
        <?php } ?>
      </select></td>
      </tr>
    <tr>
      <td>&nbsp;</td>
      <td style="line-height:13px; text-align:justify;">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
      
   
    <tr>
      <th colspan="3" style="text-align:RIGHT">
        <input type="submit" name="Save" id="Save" value="Promot Now" <?php Confirm("Are You Sure ? Rromot ".advisor_title." ?"); ?>/>
        <input type="button" name="Cancel" id="Cancel" value="Cancel" onClick="window.close();" />
        </th>
    </tr>
</form>

</table>

</center>
