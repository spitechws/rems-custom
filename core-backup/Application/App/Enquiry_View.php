<?php
include_once("../Menu/HeaderCommon.php");
include_once("../php/SpitechDB.php");
include_once("../php/SpitechUtility.php");
include_once("../php/SpitechPagination.php");
include_once("../php/SpitechJS.php");
	$DBOBJ = new DataBase();
	$DBOBJ->ConnectDatabase();
	
	$ENQUIRY_ROW=$DBOBJ->GetRow("tbl_enquiry","enquiry_id",$_GET[md5("enquiry_id")]);

	 
	
?><head><title>Enquiry View</title>
<link href="../css/SpitechStyle.css" rel="stylesheet" type="text/css" />
    <center>
    
    <table width="900" border="0" cellspacing="0" cellpadding="5" id="CommonTable">
      <tr>
        <th colspan="2">Enquiry Details</th>
        <th width="10" rowspan="4" style="background:silver; width:10px;">&nbsp;</th>
        <th colspan="2">RESPONSE</th>
      </tr>
      <tr>
        <td colspan="2">
        <table width="98%" border="0" cellspacing="2" cellpadding="0" style="margin-top:0PX;">
          <tr>
            <td width="38%"><div align="left">Customer </div></td>
            <td width="62%" class="Value" style="color:blue;"><div align="left"><?php echo $ENQUIRY_ROW['customer_name']?></div></td>
          </tr>
          <tr>
            <td><div align="left">Mobile </div></td>
            <td class="Value"><div align="left"><?php echo $ENQUIRY_ROW['mobile_no']?></div></td>
          </tr>
          <tr>
            <td><div align="left">Occupation</div></td>
            <td class="Value"><div align="left"><?php echo $ENQUIRY_ROW['occupation']?></div></td>
          </tr>
          <tr>
            <td><div align="left">City </div></td>
            <td class="Value"><div align="left"><?php echo $ENQUIRY_ROW['city']?></div></td>
          </tr>
          <tr>
            <td style="vertical-align:top"><div align="left">Address</div></td>
            <td class="Value"><div align="left"><?php echo $ENQUIRY_ROW['address']?></div></td>
          </tr>
          <tr>
            <td><div align="left">Date </div></td>
            <td class="Value"><div align="left"><?php echo date('d-M-Y',strtotime($ENQUIRY_ROW['enquiry_date']))?></div></td>
          </tr>
          <tr>
            <td><div align="left">Next Remind Date </div></td>
            <td class="Value"><div align="left"><?php echo date('d-M-Y',strtotime($ENQUIRY_ROW['remind_date']))?></div></td>
          </tr>
        </table>
          <hr /></td>
        <td colspan="2" style="vertical-align:top"><h2>RESPONSE</h2>
          <table width="98%" border="0" cellspacing="1" cellpadding="0" id="SmallTable" style="margin-top:0PX;">
            <tr>
              <th width="7%">#</th>
              <th width="93%">RESPONSE</th>
            </tr>
            <tr>
              <td><div align="center">1.</div></td>
              <td class="Value"><div align="left"><?php echo $ENQUIRY_ROW['response1']?></div></td>
            </tr>
            <tr>
              <td><div align="center">2.</div></td>
              <td class="Value"><div align="left"><?php echo $ENQUIRY_ROW['response2']?></div></td>
            </tr>
            <tr>
              <td><div align="center">3.</div></td>
              <td class="Value"><div align="left"><?php echo $ENQUIRY_ROW['response3']?></div></td>
            </tr>
            <tr>
              <td><div align="center">4.</div></td>
              <td class="Value"><div align="left"><?php echo $ENQUIRY_ROW['response4']?></div></td>
            </tr>
            <tr>
              <td><div align="center">5.</div></td>
              <td class="Value"><div align="left"><?php echo $ENQUIRY_ROW['response5']?></div></td>
            </tr>
            <tr>
              <th>STATUS</th>
              <th style="text-align:left">&nbsp;</th>
            </tr>
          </table></td>
      </tr>
      <tr>
        <td width="74">Project</td>
        <td width="296" class="Value"><div align="left"><?php echo $DBOBJ->ConvertToText("tbl_project","project_id","project_name",$ENQUIRY_ROW['project_id'])?></div></td>
        <td width="63" rowspan="2" style="vertical-align:top"><div align="left">Remarks</div></td>
        <td width="407" rowspan="2" class="Value" style="vertical-align:top"><div align="left"><?php echo $ENQUIRY_ROW['remarks']?></div></td>
      </tr>
      <tr>
        <td>Property</td>
        <td width="296" class="Value"><div align="left"><?php echo $DBOBJ->ConvertToText("tbl_property","property_id","property_no",$ENQUIRY_ROW['property_id'])?></div></td>
      </tr>
      <tr>
        <th colspan="5" style="text-align:center"><input type="button" name="Cancel" id="Cancel" value="Close" onclick="window.close();" />
        </th>
      </tr>
    </table>
</center>