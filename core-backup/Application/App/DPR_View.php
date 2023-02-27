<?php include_once("../Menu/HeaderCommon.php");
include_once("../php/SpitechDB.php");
include_once("../php/SpitechUtility.php");
include_once("../php/SpitechPagination.php");
include_once("../php/SpitechJS.php");
	$DBOBJ = new DataBase();
	$DBOBJ->ConnectDatabase();
	NoAdmin();
	$DPR_ROW=$DBOBJ->GetRow("tbl_dpr","id",$_GET[md5("dvr_id")]); 
	$EXECUTIVE_ROW=$DBOBJ->GetRow("tbl_dpr_executive","id",$DPR_ROW['executive_id']); 
?><head><title>Enquiry View</title>
<link href="../css/SpitechStyle.css" rel="stylesheet" type="text/css" />
<center>    
     <table cellpadding="0" cellspacing="0" border="0" id="CommonTable" style="border:0PX" width="98%">
     <tr>
       <td colspan="6" style="font-size:25PX; text-align:center; line-height:30PX; padding-bottom:30px"><u>DAILY PROGRESS REPORT</u></td>
     </tr>
     <tr>
       <td width="8%">NAME</td>
       <td width="3%">:</td>
       <td width="63%" style="font-size:15px;"><?php echo $EXECUTIVE_ROW['name']?></td>
       <td width="4%">DATE</td>
       <td width="2%">:</td>
       <td width="20%" style="font-size:15px;"><?php echo date('d-M-Y',strtotime($DPR_ROW['date'])); ?></td>
     </tr>
     <tr>
       <td>DESIGNATION</td>
       <td>:</td>
        <td width="63%" style="font-size:15px;"><?php echo $EXECUTIVE_ROW['designation']?></td>
       <td>DAY</td>
       <td>:</td>
       <td><?php echo date('l',strtotime($DPR_ROW['date'])); ?></td>
     </tr>
     <tr>
     <td colspan="6">
     
        <table width="98%" border="0" cellspacing="1" cellpadding="0" id="Data-Table">
          <tr>
            <th>S.N.</th>
            <th>CALLING DETAILS</th>
            <th>NUMBERS</th>
            <th>REMARKS</th>
          </tr>
          <tr>
            <td width="5%">1</td>
            <td width="45%" style="text-align:left">TOTAL NO. OF FOLLOW-UP TAKEN</td>
            <td width="10%"><?php echo $DPR_ROW['follow_up']?></td>
            <td width="40%" style="text-align:justify"><?php echo $DPR_ROW['follow_up_remark']?></td>
          </tr>
          <tr>
            <td>2</td>
            <td style="text-align:left">TOTAL NO. OF NEW PERSONS, TO WHOM GIVEN INFORMATION</td>
            <td><?php echo $DPR_ROW['info_given']?></td>
            <td style="text-align:justify"><?php echo $DPR_ROW['info_given_remark']?></td>
          </tr>
          <tr>
            <td>3</td>
            <td style="text-align:left">TOTAL NO. OF CALLS DONE ( FOLLOW-UP + GIVEN INFORMATION )</td>
            <td><?php echo $DPR_ROW['total']?></td>
            <td style="text-align:justify"><?php echo $DPR_ROW['total_remark']?></td>
          </tr>
          <tr>
            <td>4</td>
            <td style="text-align:left">TOTAL NO. OF NEW PERSONS, WHO ARE INTERESTED</td>
            <td><?php echo $DPR_ROW['interested']?></td>
            <td style="text-align:justify"><?php echo $DPR_ROW['interested_remark']?></td>
          </tr>
          <tr>
            <td>5</td>
            <td style="text-align:left">TOTAL NO. OF NEW PERSONS, WHO GIVEN APPOINTMENT</td>
            <td><?php echo $DPR_ROW['appointment']?></td>
            <td style="text-align:justify"><?php echo $DPR_ROW['appointment_remark']?></td>
          </tr>
        </table>        
<?php 
$Q="SELECT * FROM tbl_dpr_details where dpr_id='".$_GET[md5("dvr_id")]."' order by id";
$Q=@mysqli_query($_SESSION['CONN'],$Q);
$count=@mysqli_num_rows($Q);
if($count>0) {?>       
        <table width="98%" border="0" cellspacing="1" cellpadding="0" id="Data-Table">
          <tr>
            <th colspan="9">DETAILS OF INTERESTED PERSONS</th>
          </tr>
          <tr>
            <th rowspan="2">S.N.</th>
            <th rowspan="2">NAME</th>
            <th rowspan="2">WHATSAPP NO.</th>
            <th rowspan="2">TYPE OF PROPERTY</th>
            <th rowspan="2">PREFERED LOCATION</th>
            <th rowspan="2">BUDGET</th>
            <th rowspan="2">SUGGESTED PROPERTY</th>
            <th colspan="2">REMARKS</th>
          </tr>
          <tr>
            <th>DATE</th>
            <th>TIME</th>
          </tr>
<?php 
while($ROWS=@mysqli_fetch_assoc($Q)) {?>         
          <tr>
            <td width="3%"><?php echo ++$i?>.</td>
            <td width="29%" style="text-align:left"><?php echo $ROWS['name']?></td>
            <td width="12%"><?php echo $ROWS['mobile']?></td>
            <td width="12%"><?php echo $ROWS['type']?></td>
            <td width="16%"><?php echo $ROWS['location']?></td>
            <td width="6%"><?php echo $ROWS['budget']?></td>
            <td width="10%"><?php echo $ROWS['property']?></td>
            <td width="6%"><?php echo date('d-M-Y',strtotime($ROWS['date'])); ?></td>
            <td width="6%"><?php echo date('h:i:s A',strtotime($ROWS['time'])); ?></td>
          </tr>
 <?php } ?>         
        </table>
        <?php }?>
        <div align="center" class="dontPrint">
          <input type="button" name="Print" id="Submit" value="Print" onclick="window.print();" />
          <input type="button" name="Cancel" id="Cancel" value="Close" onclick="window.close();" />          
        </div>
     </td></tr></table>
     
    </center>
<style>
#Data-Table tr td { height:25px; }
</style>    