<?php
include_once("../Menu/HeaderAdmin.php");
include_once("../php/SpitechDB.php");
include_once("../php/SpitechUtility.php");
include_once("../php/SpitechPagination.php");
include_once("../php/SpitechJS.php");
Menu("Advisor");
NoUser();
$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();

$ADVISOR_ID=$_GET[md5('advisor_id')];
$ADVISOR_ROW=$DBOBJ->GetRow("tbl_advisor","advisor_id",$_GET[md5('advisor_id')]);
$NETT_COM=$DBOBJ->AdvisorNetCommission($ADVISOR_ID,"1970-01-01",date('Y-m-d'));
$PAID=$DBOBJ->AdvisorTotalPaid($ADVISOR_ID,"1970-01-01",date('Y-m-d'));
$BAL=$NETT_COM-$PAID;

?>
<link href="../css/SpitechStyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../SpitechDTP/DTP.js"></script>
<center>
<h1><img src="../SpitechImages/Advisor.png" width="31" height="32" /><?php echo advisor_title?>  : <span>Profile</span></h1>
<table width="100%" border="0" align="center" cellspacing="0" cellpadding="0" id="Content">
 
  <tr>
    <td width="508" rowspan="2"  align="center" style="width:400px; vertical-align:top;">
    <center>
    <h2 style="margin:0px; width:502px;"><?php echo advisor_title?> Profile</h2>
    <fieldset style="width:500px; margin:0px; padding:0px;">
      
      <?php MessageError(); ?>
  <table border="0" cellspacing="0" cellpadding="5" id="CommonTable" style="border:0px; margin-top:0px;">  
   <tr class="DontPrint">
     <td style="height:35px;"><?php echo advisor_title?></td>
     <td colspan="2" id="Value2" style="color:red; font-size:13px;">
     <form id="AdvisorForm" name="AdvisorForm" method="get" style="margin:0px; margin-top:3px;">
       <select name="<?php echo md5("advisor_id")?>" id="<?php echo md5("advisor_id")?>" onchange="AdvisorForm.submit();">
         <option value="">Select An <?php echo advisor_title?></option>
         <?php 
			   $ADVISOR_Q="SELECT advisor_id, advisor_code, advisor_name FROM tbl_advisor ORDER BY advisor_name";
			   $ADVISOR_Q=@mysqli_query($_SESSION['CONN'],$ADVISOR_Q);
			   while($ADVISOR_ROWS=@mysqli_fetch_assoc($ADVISOR_Q)) {?>
         <option value="<?php echo $ADVISOR_ROWS['advisor_id'];?>" <?php SelectedSelect($ADVISOR_ROWS['advisor_id'], $_GET[md5('advisor_id')]); ?>>
           <?php echo $ADVISOR_ROWS['advisor_name']." [".$ADVISOR_ROWS['advisor_code']." ]";?>
           </option>
         <?php } ?>
       </select>
     </form></td>
   </tr>
  
   <tr>
     <td colspan="3"><hr /></td>
     </tr>
   <tr>
     <td><div align="right">total commission</div></td>
     <td width="227" style="color:maroon;font-size:13px;"><div align="right">
       <?php echo @number_format($NETT_COM,2);?>
     </div></td>
     <td id="Value5" style="color:red; font-size:13px;">&nbsp;</td>
   </tr>
   <tr>
     <td><div align="right">tota paid</div></td>
     <td style="color:green;font-size:13px;"><div align="right">
       <?php echo @number_format($PAID,2);?>
     </div></td>
     <td id="Value4" style="color:red; font-size:13px;">&nbsp;</td>
   </tr>
   <tr>
     <td><div align="right">balance</div></td>
     <td style="color:red; font-size:13px;"><div align="right">
       <?php echo @number_format($BAL,2);?>
     </div></td>
     <td id="Value3" style="color:red; font-size:13px;">&nbsp;</td>
   </tr>
    <tr>
     <td colspan="3"><hr /></td>
     </tr>
   <tr>
      <td width="179">name</td>
      <td colspan="2" id="Value" style="color:red; font-size:13px;"><?php echo $ADVISOR_ROW['advisor_title']." ".$ADVISOR_ROW['advisor_name']?></td>
      </tr>
    <tr>
      <td>id code</td>
      <td style="color:RED; font-size:12PX;" id="Value" ><?php echo $ADVISOR_ROW['advisor_code']; ?></td>
      <td width="73" rowspan="8" style="color:RED; font-size:16PX; vertical-align:top; ">
        <?php $ACTUAL_PHOTO="../SpitechUploads/advisor/profile_photo/".$ADVISOR_ROW['advisor_photo'];
		  $exist=file_exists($ACTUAL_PHOTO);
		  if($exist!="1") { $ACTUAL_PHOTO="../SpitechImages/Advisor.png"; }
		  if(!isset($_GET[md5('advisor_id')])||$ADVISOR_ROW['advisor_photo']=="") { $ACTUAL_PHOTO="../SpitechImages/Advisor.png"; }
		 ?><img src="<?php echo $ACTUAL_PHOTO; ?>" alt="Photo" width="100" height="110" id="imgBorder"/>      </td>
      </tr>
    <tr>
         <td>LEVEL</td>
         <td id="Value" style="color:blue"><?php echo $DBOBJ->ConvertToText("tbl_setting_advisor_level","level_id","level_name",$ADVISOR_ROW['advisor_level_id']);?></td>
         </tr>
   
   
    <tr>
      <td style="line-height:12px;">father's/Husband's name </td>
      <td width="227" id="Value" ><?php echo $ADVISOR_ROW['advisor_fname'];?></td>
      </tr>
    <tr>
      <td>sex</td>
      <td id="Value" ><?php echo $ADVISOR_ROW['advisor_sex'];?></td>
      </tr>
    <tr>
      <td>Marital status</td>
      <td id="Value" ><?php echo $ADVISOR_ROW['advisor_marital_status'];?></td>
      </tr>
    <tr>
      <td style="line-height:13px; text-align:justify;">BLOOD GROUP</td>
      <td id="Value" ><?php echo $ADVISOR_ROW['advisor_bg'];?></td>
      </tr>
    <tr>
      <td style="line-height:13px; text-align:justify;">mobile no</td>
      <td id="Value" ><?php echo $ADVISOR_ROW['advisor_mobile'];?></td>
      </tr>
    <tr>
      <td style="line-height:13px; text-align:justify;">Whats app no</td>
      <td id="Value" ><?php echo $ADVISOR_ROW['advisor_whatsapp_no'];?></td>
      </tr>
    <tr>
      <td style="line-height:13px; text-align:justify;">phone no</td>
      <td id="Value" ><?php echo $ADVISOR_ROW['advisor_sex'];?></td>
      <td width="73" style="color:RED; font-size:16PX; vertical-align:top; ">&nbsp;</td>
      </tr>
    <tr>
      <td style="line-height:13px; text-align:justify;">email id</td>
      <td colspan="2" id="Value" style="text-transform:none;"><?php echo $ADVISOR_ROW['advisor_email'];?></td>
      </tr>
    <tr>
      <td style="line-height:13px; text-align:justify;">PAN NO</td>
      <td colspan="2" id="Value" ><?php echo $ADVISOR_ROW['advisor_pan_no'];?></td>
      </tr>
    <tr>
      <td style="line-height:13px; text-align:justify;">OCCUPATION</td>
      <td colspan="2" id="Value" ><?php echo $ADVISOR_ROW['advisor_occupation'];?></td>
      </tr>
    <tr>
      <td style="line-height:13px; text-align:justify;">qualification</td>
      <td colspan="2" id="Value" ><?php echo $ADVISOR_ROW['advisor_qualification'];?></td>
      </tr>
    <tr>
      <td style="line-height:13px; text-align:justify;">address</td>
      <td colspan="2" id="Value" ><?php echo $ADVISOR_ROW['advisor_address'];?></td>
      </tr>
    <tr>
      <td style="line-height:13px; text-align:justify;">dob</td>
      <td colspan="2" id="Value" ><?php echo ShowDate($ADVISOR_ROW['advisor_dob']);?></td>
      </tr>
    <tr>
      <td style="line-height:13px; text-align:justify;">ANNIVERSARY DATE</td>
      <td colspan="2" id="Value" ><?php echo ShowDate($ADVISOR_ROW['advisor_anniversary_date']);?></td>
    </tr>
    <tr>
      <td style="line-height:13px; text-align:justify;">jOIning date </td>
      <td colspan="2" id="Value" ><?php echo ShowDate($ADVISOR_ROW['advisor_hire_date']);?></td>
      </tr>
     <tr>
      <td>status</td>
      <td style="background:<?php if($ADVISOR_ROW['advisor_status']) { echo "green"; $status="ACTIVE"; } else { echo "red"; $status="IN-ACTIVE "; }?>; color:white;" id="Value" ><?php echo $status?></td>
      <td>&nbsp;</td>
      </tr> 
       <tr>
      <td colspan="3"><H4>NAME PROPOSED BY (SPONSOR)</H4></td>
      </tr>
   
      
       <tr>
      <td>SPONSOR NAME <span style="line-height:13px; text-align:justify;"></span></td>
      <td colspan="2" id="Value" ><?php echo $DBOBJ->ConvertToText("tbl_advisor","advisor_id","advisor_title",$ADVISOR_ROW['advisor_sponsor'])." ".$DBOBJ->ConvertToText("tbl_advisor","advisor_id","advisor_name",$ADVISOR_ROW['advisor_sponsor']); ?>
      </td>
      </tr>
    <tr>
      <td>ID CODE</td>
      <td colspan="2" style="color:RED;" id="Value" ><?php echo $DBOBJ->ConvertToText("tbl_advisor","advisor_id","advisor_code",$ADVISOR_ROW['advisor_sponsor']); ?></td>
      </tr>
     <tr>
         <td>LEVEL</td>
         <td colspan="2" id="Value" ><?php echo $DBOBJ->ConvertToText("tbl_setting_advisor_level","level_id","level_name",$DBOBJ->ConvertToText("tbl_advisor","advisor_id","advisor_level_id",$ADVISOR_ROW['advisor_sponsor']));?></td>
         </tr>
   
   


</table>
</fieldset>
</center>
</td>
  
    <td width="777" height="200" style="padding-bottom:0px;">
     <h2 style="margin-LEFT:1%; margin-top:0px; margin-bottom:0px;">Documents</h2>
     <iframe height="200px" width="100%" frameborder="0" src="Advisor_Profile_Docs.php?<?php echo md5('advisor_id')."=".$_GET[md5('advisor_id')]?>">
     </iframe>
     </td>
  </tr>
  <tr>
    <td style="height:98%; padding-bottom:0px;">
      <h2 style="margin-LEFT:1%; margin-top:0px; margin-bottom:0px;">PAYMENT RECEIVED DETAILS</h2>
      <iframe height="300px" width="100%" frameborder="0" src="Advisor_Profile_Payment_List.php?<?php echo md5('advisor_id')."=".$_GET[md5('advisor_id')]?>">
      </iframe>
      </td>
  </tr>
  <tr>
    <td colspan="3"  align="center" style="width:400px; vertical-align:top;">
    <h2 style="margin-top:0px;">Commission Statement</h2>
    <iframe height="500px" width="100%" frameborder="0" src="Advisor_Profile_Commission_Statement.php?<?php echo md5('advisor_id')."=".$_GET[md5('advisor_id')]?>">
      </iframe>
     </td>
    </tr>
</table>
</center>
<?php 

include("../Menu/Footer.php"); ?>