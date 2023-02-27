<?php
include_once("../Menu/HeaderCommon.php");
include_once("../php/SpitechDB.php");
include_once("../php/SpitechUtility.php");
include_once("../php/SpitechPagination.php");
include_once("../php/SpitechJS.php");

NoUser();
$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();

	
	$enquiry_date=date('Y-m-d');
	$remind_date=date('Y-m-d');
	$edited_edited=$created_details=CreatedEditedByUserMessage();
	
	$EDIT_ROW=$DBOBJ->GetRow("tbl_enquiry","enquiry_id",$_GET[md5("edit_id")]);
	
	if(isset($_GET[md5("edit_id")]))
	{
		$enquiry_date=$EDIT_ROW['enquiry_date'];
	    $remind_date=$EDIT_ROW['remind_date'];
		$created_details=$EDIT_ROW['created_details'];
	}
	
	if(isset($_POST['Submit']))
	{			
		$FIELDS=array('project_id' ,
						'property_id' ,
						'customer_name' ,
						'mobile_no' ,
						'occupation' ,
						'city' ,
						'address' ,
						'response1' ,
						'response2' ,
						'response3' ,
						'response4' ,
						'response5' ,
						'remarks' ,
						'status' ,
						'enquiry_date' ,
						'remind_date' ,
						'created_details' ,
						'edited_details');				  
				  $VALUES=array($_POST['project_id'] ,
						$_POST['property_id'] ,
						$_POST['customer_name'] ,
						$_POST['mobile_no'] ,
						$_POST['occupation'] ,
						$_POST['city'] ,
						$_POST['address'] ,
						$_POST['response1'] ,
						$_POST['response2'] ,
						$_POST['response3'] ,
						$_POST['response4'] ,
						$_POST['response5'] ,
						$_POST['remarks'] ,
						$_POST['status'] ,
						$_POST['enquiry_date'] ,
						$_POST['remind_date'] ,
						$created_details ,
						$edited_details);		
						
				    if(isset($_GET[md5("edit_id")]))
					{
						$MAX_ID=$DBOBJ->Update("tbl_enquiry",$FIELDS,$VALUES,"enquiry_id",$_GET[md5("edit_id")],1);
						//=============( ENTRY IN ACTION TABLE )=======================================================
		                $DBOBJ->UserAction("ENQUIRY EDITED", " ID : ".$MAX_ID.", CUSTOMER : ".$_POST['customer_name']);
						
					}
					else
					{
						$MAX_ID=$DBOBJ->Insert("tbl_enquiry",$FIELDS,$VALUES,0);	
						//=============( ENTRY IN ACTION TABLE )=======================================================
						$DBOBJ->UserAction("ENQUIRY ADDED", " ID : ".$MAX_ID.", CUSTOMER : ".$_POST['customer_name']);
					}						
						
				UnloadMe();			
	}
	
	 
	
?><head><title>Enquiry Entry</title>
<link href="../css/SpitechStyle.css" rel="stylesheet" type="text/css" />
<style>
#CommonTable #BRDR td { border-bottom:1px solid silver; padding-bottom:5px;padding-top:5px;} 
#CommonTable #BRDR td td {border-bottom:0px solid silver;}
#SmallTable TR TD input { width:100%; }
</style>


    <center>
   
   <form name="EnquiryForm" id="EnquiryForm" method="post" enctype="multipart/form-data" >
    <?php MessageError(); ?>
    <table width="900" border="0" cellspacing="0" cellpadding="5" id="CommonTable"> 
  <tr>
    <th colspan="2">Enquiry Entry</th>
    <th width="10" rowspan="4" style="background:silver; width:10px;">&nbsp;</th>
    <th colspan="2">RESPONSE</th>
    </tr>
  <tr>
    <td colspan="2">
    <table width="98%" border="0" cellspacing="2" cellpadding="0" style="margin-top:0PX;">
      <tr>
        <td width="38%"><div align="left">Name <b id="Required">*</b></div></td>
        <td width="62%"><div align="left">
          <input type="text" name="customer_name" id="customer_name" placeholder="FULL NAME OF CUSTOMER" required="required" value="<?php echo $EDIT_ROW['customer_name']; ?>" maxlength="50"/>
        </div></td>
        </tr>
      <tr>
        <td><div align="left">Mobile <b id="Required">*</b></div></td>
        <td><div align="left">
          <input type="text" name="mobile_no" id="mobile_no" placeholder="MOBILE NO" required="required" value="<?php echo $EDIT_ROW['mobile_no']; ?>" maxlength="10" <?php OnlyNumber(); ?>/>
        </div></td>
        </tr>
      <tr>
        <td><div align="left">Occupation</div></td>
        <td><div align="left"><input type="text" name="occupation" id="occupation" placeholder="OCCUPATION" value="<?php echo $EDIT_ROW['occupation']; ?>"/>
        </div></td>
        </tr>
      <tr>
        <td><div align="left">City <b id="Required">*</b></div></td>
        <td><div align="left">
          <input type="text" name="city" id="city" placeholder="CITY"  value="<?php echo $EDIT_ROW['city']; ?>" maxlength="50"/>
        </div></td>
        </tr>
      <tr>
        <td style="vertical-align:top"><div align="left">Address</div></td>
        <td><div align="left">
          <textarea id="address" name="address" placeholder="PERMANENT ADDRESS"><?php echo $EDIT_ROW['address']; ?></textarea>
        </div></td>
        </tr>
      <tr>
        <td><div align="left">Date <b id="Required">*</b></div></td>
        <td class="Date"><div align="left"><script>DateInput('enquiry_date', true, 'yyyy-mm-dd', '<?php echo $enquiry_date; ?>');</script></div></td>
      </tr>
      <tr>
        <td><div align="left">Next Remind Date <b id="Required">*</b></div></td>
        <td class="Date"><div align="left"><script>DateInput('remind_date', true, 'yyyy-mm-dd', '<?php echo $remind_date; ?>');</script></div></td>
      </tr>
      </table>
      <hr />
      </td>
    <td colspan="2" style="vertical-align:top">
      <H2>RESPONSE</H2>
      <table width="98%" border="0" cellspacing="1" cellpadding="0" id="SmallTable" style="margin-top:0PX;">
        <tr>
          <th width="7%">#</th>
          <th width="93%">RESPONSE</th>
          </tr>
        <tr>
          <td><div align="center">1.</div></td>
          <td><input type="text" name="response1" id="response1" placeholder="RESPONSE" value="<?php echo $EDIT_ROW['response1']; ?>"/></td>
          </tr>
        <tr>
          <td><div align="center">2.</div></td>
          <td><input type="text" name="response2" id="response2" placeholder="RESPONSE" value="<?php echo $EDIT_ROW['response2']; ?>"/></td>
          </tr>
        <tr>
          <td><div align="center">3.</div></td>
          <td><input type="text" name="response3" id="response3" placeholder="RESPONSE" value="<?php echo $EDIT_ROW['response3']; ?>"/></td>
          </tr>
        <tr>
          <td><div align="center">4.</div></td>
          <td><input type="text" name="response4" id="response4" placeholder="RESPONSE" value="<?php echo $EDIT_ROW['response4']; ?>"/></td>
          </tr>
        <tr>
          <td><div align="center">5.</div></td>
          <td><input type="text" name="response5" id="response5" placeholder="RESPONSE" value="<?php echo $EDIT_ROW['response5']; ?>"/></td>
          </tr>
        <tr>
          <th>STATUS</th>
          <th style="text-align:left">
          <select name="status" id="status">
            <option value="Enable" <?php SelectedSelect("Enable",$EDIT_ROW['status']); ?>>Enable</option>
            <option value="Disable" <?php SelectedSelect("Disable",$EDIT_ROW['status']); ?>>Disable</option>
            <option value="Booked" <?php SelectedSelect("Booked",$EDIT_ROW['status']); ?>>Booked</option>           
          </select>
          </th>
        </tr>
        </table>
      
      
      </td>
  </tr>
  <tr>
    <td width="74">Project</td>
    <td width="296">
  
    <select id="project_id" name="project_id" onchange="GetPage('GetPropertyForEnquiry.php?project_id='+this.value,'property');">
      <option value="">SELECT A PROJECT...</option>
      <?php 
             $PROJECT_Q=@mysqli_query($_SESSION['CONN'],"select project_id, project_name from tbl_project ");
             while($PROJECT_ROWS=@mysqli_fetch_assoc($PROJECT_Q)) 
             {?>
      <option value="<?php echo $PROJECT_ROWS['project_id']?>" <?php SelectedSelect($PROJECT_ROWS['project_id'],$EDIT_ROW["project_id"]);?>>
        <?php echo $PROJECT_ROWS['project_name']?>
        </option>
      <?php } ?>
    </select>
    
    </td>
    <td width="63" rowspan="2" style="vertical-align:top"><div align="left">Remarks</div></td>
    <td width="407" rowspan="2"><span class="Date">
      <textarea id="remarks" name="remarks" placeholder="REMARKS" style="width:100%;"><?php echo $EDIT_ROW['remarks']; ?></textarea>
    </span></td>
  </tr>
  <tr>
    <td>Property</td>
    <td width="296">
    <div id="property">
    <select name="property_id" id="property_id">
      <option value="">SELECT APROPERTY...</option>
      	<?php  if($EDIT_ROW['property_id']>0) {  ?>
          <option value="<?php echo $EDIT_ROW['property_id']?>" selected="selected">
		  <?php echo $DBOBJ->ConvertToText("tbl_property","property_id","property_no",$EDIT_ROW['property_id'])?>
          </option>
		  <?php } ?>
          
          <?php 
             $PROPERTY_Q=@mysqli_query($_SESSION['CONN'],"select property_id, property_no  from tbl_property where 
			  property_project_id='".$EDIT_ROW['project_id']."' and
			  property_status='Available' and 
			  property_id!='".$EDIT_ROW['property_id']."' order by  property_id, property_no  ");
             while($PROPERTY_ROWS=@mysqli_fetch_assoc($PROPERTY_Q)) 
             {?>
          <option value="<?php echo $PROPERTY_ROWS['property_id']?>"><?php echo $PROPERTY_ROWS['property_no']?></option>
          <?php } ?>
         </select>
    </div>
    </td>
  </tr>
  <tr>
    <th colspan="5" style="text-align:center">
      <input type="submit" name="Submit" id="Submit" class="Submit" value="Save Enquiry Details" <?php Confirm("Are You Sure ? Save Enquiry Details ?"); ?>/>
      <input type="button" name="Cancel" id="Cancel" value="Close" onClick="window.close();" />
      </th>
  </tr>

</table></form>

</center>


