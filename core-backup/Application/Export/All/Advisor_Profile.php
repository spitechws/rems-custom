<?php 
include_once('../php/Excel.php'); ExportExcel(); 
$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();

$ADVISOR_ID=$_GET[md5('advisor_id')];
$ADVISOR_ROW=$DBOBJ->GetRow("tbl_advisor","advisor_id",$_GET[md5('advisor_id')]);
$NETT_COM=$DBOBJ->AdvisorNetCommission($ADVISOR_ID,"1970-01-01",date('Y-m-d'));
$PAID=$DBOBJ->AdvisorTotalPaid($ADVISOR_ID,"1970-01-01",date('Y-m-d'));
$BAL=$NETT_COM-$PAID;

?>
<center>
<h1><?php echo advisor_title?>  : <span>Profile</span></h1>

  <table border="1" cellspacing="0" cellpadding="5" id="ExportTable" style="border:0px; margin-top:0px;">  
      <tr id="TH">
     <td><div align="left">TOTAL COMMISSION</div></td>
     <td width="227" style="color:maroon;font-size:13px;"><div align="right">
       <?php echo @number_format($NETT_COM,2);?>
     </div></td>
    </tr>
   <tr>
     <td><div align="left">TOTAL PAID</div></td>
     <td style="color:green;font-size:13px;"><div align="right">
       <?php echo @number_format($PAID,2);?>
     </div></td>
    </tr>
   <tr>
     <td><div align="left">BALANCE</div></td>
     <td style="color:red; font-size:13px;"><div align="right">
       <?php echo @number_format($BAL,2);?>
     </div></td>
    </tr>
    <tr>
     <td colspan="2"><hr /></td>
     </tr>
   <tr>
      <td width="179">NAME</td>
      <td id="Value" style="color:red; font-size:13px;"><?php echo $ADVISOR_ROW['advisor_title']." ".$ADVISOR_ROW['advisor_name']?></td>
      </tr>
    <tr>
      <td>ID CODE</td>
      <td style="color:RED; font-size:12PX;" id="Value" ><?php echo $ADVISOR_ROW['advisor_code']; ?></td>
      </tr>
    <tr>
         <td>LEVEL</td>
         <td id="Value" style="color:blue"><?php echo $DBOBJ->ConvertToText("tbl_setting_advisor_level","level_id","level_name",$ADVISOR_ROW['advisor_level_id']);?></td>
         </tr>
   
   
    <tr>
      <td style="line-height:12px;">FATHER'S/HUSBAND'S NAME </td>
      <td width="227" id="Value" ><?php echo $ADVISOR_ROW['advisor_fname'];?></td>
      </tr>
    <tr>
      <td>SEX</td>
      <td id="Value" ><?php echo $ADVISOR_ROW['advisor_sex'];?></td>
      </tr>
    <tr>
      <td>MARITAL STATUS</td>
      <td id="Value" ><?php echo $ADVISOR_ROW['advisor_marital_status'];?></td>
      </tr>
    <tr>
      <td style="line-height:13px; text-align:justify;">BLOOD GROUP</td>
      <td id="Value" ><?php echo $ADVISOR_ROW['advisor_bg'];?></td>
      </tr>
    <tr>
      <td style="line-height:13px; text-align:justify;">MOBILE NO</td>
      <td id="Value" ><?php echo $ADVISOR_ROW['advisor_mobile'];?></td>
      </tr>
    <tr>
      <td style="line-height:13px; text-align:justify;">WHATS APP NO</td>
      <td id="Value" ><?php echo $ADVISOR_ROW['advisor_whatsapp_no'];?></td>
      </tr>
    <tr>
      <td style="line-height:13px; text-align:justify;">PHONE NO</td>
      <td id="Value" ><?php echo $ADVISOR_ROW['advisor_sex'];?></td>
      </tr>
    <tr>
      <td style="line-height:13px; text-align:justify;">EMAIL ID</td>
      <td id="Value" style="text-transform:none;"><?php echo $ADVISOR_ROW['advisor_email'];?></td>
      </tr>
    <tr>
      <td style="line-height:13px; text-align:justify;">PAN NO</td>
      <td id="Value" ><?php echo $ADVISOR_ROW['advisor_pan_no'];?></td>
      </tr>
    <tr>
      <td style="line-height:13px; text-align:justify;">OCCUPATION</td>
      <td id="Value" ><?php echo $ADVISOR_ROW['advisor_occupation'];?></td>
      </tr>
    <tr>
      <td style="line-height:13px; text-align:justify;">QUALIFICATION</td>
      <td id="Value" ><?php echo $ADVISOR_ROW['advisor_qualification'];?></td>
      </tr>
    <tr>
      <td style="line-height:13px; text-align:justify;">ADDRESS</td>
      <td id="Value" ><?php echo $ADVISOR_ROW['advisor_address'];?></td>
      </tr>
    <tr>
      <td style="line-height:13px; text-align:justify;">DOB</td>
      <td id="Value" ><?php echo ShowDate($ADVISOR_ROW['advisor_dob']);?></td>
      </tr>
    <tr>
      <td style="line-height:13px; text-align:justify;">ANNIVERSARY DATE</td>
      <td id="Value" ><?php echo ShowDate($ADVISOR_ROW['advisor_anniversary_date']);?></td>
    </tr>
    <tr>
      <td style="line-height:13px; text-align:justify;">JOINING DATE </td>
      <td id="Value" ><?php echo ShowDate($ADVISOR_ROW['advisor_hire_date']);?></td>
      </tr>
     <tr>
      <td>STATUS</td>
      <td style="background:<?php if($ADVISOR_ROW['advisor_status']) { echo "green"; $status="ACTIVE"; } else { echo "red"; $status="IN-ACTIVE "; }?>; color:white;" id="Value" ><?php echo $status?></td>
      </tr> 
       <tr>
      <td colspan="2"><H4>NAME PROPOSED BY (SPONSOR)</H4></td>
      </tr>
   
      
       <tr>
      <td>SPONSOR NAME <span style="line-height:13px; text-align:justify;"></span></td>
      <td id="Value" ><?php echo $DBOBJ->ConvertToText("tbl_advisor","advisor_id","advisor_title",$ADVISOR_ROW['advisor_sponsor'])." ".$DBOBJ->ConvertToText("tbl_advisor","advisor_id","advisor_name",$ADVISOR_ROW['advisor_sponsor']); ?>
      </td>
      </tr>
    <tr>
      <td>ID CODE</td>
      <td style="color:RED;" id="Value" ><?php echo $DBOBJ->ConvertToText("tbl_advisor","advisor_id","advisor_code",$ADVISOR_ROW['advisor_sponsor']); ?></td>
      </tr>
     <tr>
         <td>LEVEL</td>
         <td id="Value" ><?php echo $DBOBJ->ConvertToText("tbl_setting_advisor_level","level_id","level_name",$DBOBJ->ConvertToText("tbl_advisor","advisor_id","advisor_level_id",$ADVISOR_ROW['advisor_sponsor']));?></td>
         </tr>
   
   
</table>

</center>
