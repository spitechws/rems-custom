<?php
include_once("../Menu/HeaderCommon.php");
include_once("../php/SpitechDB.php");
include_once("../php/SpitechUtility.php");
include_once("../php/SpitechPagination.php");
include_once("../php/SpitechJS.php");

$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();
 NoAdmin();

	$edited_edited=CreatedEditedByUserMessage();	
	$EDIT_ROW=$DBOBJ->GetRow("tbl_advisor_dvr","dvr_id",$_GET[md5("edit_id")]);
	if(isset($_POST['Submit']))
	{			
		$FIELDS=array('remarks','status','edited_details');				  
		$VALUES=array($_POST['remarks'],$_POST['status'],$edited_details);					
				    
		$MAX_ID=$DBOBJ->Update("tbl_advisor_dvr",$FIELDS,$VALUES,"dvr_id",$_GET[md5("edit_id")],1);
		//=============( ENTRY IN ACTION TABLE )=======================================================
		$DBOBJ->UserAction("DVR EDITED BY ADMIN", " ID : ".$MAX_ID.", CUSTOMER : ".$_POST['customer_name']);
		
		UnloadMe();			
	}
	
	 
	
?><head><title>DVR Entry</title>
<link href="../css/SpitechStyle.css" rel="stylesheet" type="text/css" />
<style>
#CommonTable #BRDR td { border-bottom:1px solid silver; padding-bottom:5px;padding-top:5px;} 
#CommonTable #BRDR td td {border-bottom:0px solid silver;}
#SmallTable TR TD input { width:100%; }
</style>


    <center>
   
   <form name="DVRForm" id="DVRForm" method="post" enctype="multipart/form-data" >
    <?php MessageError(); ?>
    <table width="900" border="0" cellspacing="0" cellpadding="5" id="CommonTable"> 
  <tr>
    <th colspan="2">DVR DETAILS</th>
    <th width="10" rowspan="4" style="background:silver; width:10px;">&nbsp;</th>
    <th colspan="2">RESPONSE</th>
    </tr>
  <tr>
    <td colspan="2">
    <table width="98%" border="0" cellspacing="2" cellpadding="0" style="margin-top:0PX;">
      <tr>
        <td style="text-align:left">ADVISOR</td>
        <td class="Value" style="color:Maroon;text-align:left"><?php echo $DBOBJ->ConvertToText("tbl_advisor","advisor_id","advisor_name",$EDIT_ROW["advisor_id"])?></td>
      </tr>
      <tr>
        <td style="text-align:left">ID</td>
        <td class="Value" style="color:blue;text-align:left"><?php echo $DBOBJ->ConvertToText("tbl_advisor","advisor_id","advisor_code",$EDIT_ROW["advisor_id"])?></td>
      </tr>
      <tr>
        <td colspan="2" style="text-align:left"><hr /></td>
        </tr>
      <tr>
        <td width="30%"><div align="left">CUSTOMER</div></td>
        <td width="70%" class="Value" style="color:blue;"><div align="left">
          <?php echo $EDIT_ROW['customer_name']?>
        </div></td>
        </tr>
      <tr>
        <td><div align="left">Mobile</div></td>
        <td class="Value"><div align="left">
          <?php echo $EDIT_ROW['mobile_no']?>
        </div></td>
        </tr>
      <tr>
        <td><div align="left">Occupation</div></td>
        <td class="Value"><div align="left">
          <?php echo $EDIT_ROW['occupation']?>
        </div></td>
        </tr>
      <tr>
        <td><div align="left">City</div></td>
        <td class="Value"><div align="left">
          <?php echo $EDIT_ROW['city']?>
        </div></td>
        </tr>
      <tr>
        <td style="vertical-align:top"><div align="left">Address</div></td>
        <td class="Value"><div align="left">
          <?php echo $EDIT_ROW['address']?>
        </div></td>
        </tr>
      <tr>
        <td><div align="left">Date</div></td>
        <td class="Value"><div align="left">
          <?php echo date('d-M-Y',strtotime($EDIT_ROW['dvr_date']))?>
        </div></td>
        </tr>
      <tr>
        <td><div align="left">Next Remind Date</div></td>
        <td class="Value"><div align="left">
          <?php echo date('d-M-Y',strtotime($EDIT_ROW['remind_date']))?>
        </div></td>
        </tr>
      </table>
      <hr />
      </td>
    <td colspan="2" style="vertical-align:top">
      <H2>RESPONSE</H2>
      <table width="98%" border="0" cellspacing="1" cellpadding="0" id="SmallTable" style="margin-top:0PX;">
        <tr>
          <th width="6%">#</th>
          <th width="94%">RESPONSE</th>
          </tr>
        <tr>
          <td><div align="center">1.</div></td>
          <td class="Value"><div align="left">
            <?php echo $EDIT_ROW['response1']?>
          </div></td>
          </tr>
        <tr>
          <td><div align="center">2.</div></td>
          <td class="Value"><div align="left">
            <?php echo $EDIT_ROW['response2']?>
          </div></td>
          </tr>
        <tr>
          <td><div align="center">3.</div></td>
          <td class="Value"><div align="left">
            <?php echo $EDIT_ROW['response3']?>
          </div></td>
          </tr>
        <tr>
          <td><div align="center">4.</div></td>
          <td class="Value"><div align="left">
            <?php echo $EDIT_ROW['response4']?>
          </div></td>
          </tr>
        <tr>
          <td><div align="center">5.</div></td>
          <td class="Value"><div align="left">
            <?php echo $EDIT_ROW['response5']?>
          </div></td>
          </tr>
        </table>
      
      
      </td>
  </tr>
  <tr>
    <td width="74">Project</td>
    <td width="296" class="Value"><div align="left">
      <?php echo $DBOBJ->ConvertToText("tbl_project","project_id","project_name",$EDIT_ROW['project_id'])?>
    </div></td>
    <td width="63" rowspan="2" style="vertical-align:top"><div align="left">Remarks</div></td>
    <td width="407" rowspan="2" style="vertical-align:top" id="Value"><?php echo $EDIT_ROW['remarks']?></td>
  </tr>
  <tr>
    <td>Property</td>
    <td width="296" class="Value"><div align="left">
      <?php echo $DBOBJ->ConvertToText("tbl_property","property_id","property_no",$EDIT_ROW['property_id'])?>
    </div></td>
    </tr>
  <tr>
    <th style="text-align:left">STATUS</th>
    <th style="text-align:left">
      <select name="status" id="status">
        <option value="Enable" <?php SelectedSelect("Enable",$EDIT_ROW['status']); ?>>Enabled</option>
        <option value="Disable" <?php SelectedSelect("Disable",$EDIT_ROW['status']); ?>>Disabled</option>
        <option value="Booked" <?php SelectedSelect("Booked",$EDIT_ROW['status']); ?>>Booked</option>
      </select>
    </th>
    <th colspan="3" style="text-align:center"><input type="submit" name="Submit" id="Submit" class="Submit" value="Save DVR Details" <?php Confirm("Are You Sure ? Save DVR Details ?"); ?>/>      <input type="button" name="Cancel" id="Cancel" value="Close" onclick="window.close();" /></th>
    </tr>

</table></form>

</center>


