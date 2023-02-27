<?php
include_once("../Menu/HeaderAdmin.php");
include_once("../php/SpitechDB.php");
include_once("../php/SpitechUtility.php");
include_once("../php/SpitechPagination.php");
include_once("../php/SpitechJS.php");
Menu("Reports");
NoUser();
$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();

$s_date=date('Y-m-d');
$e_date=date('Y-m-d');
if(isset($_GET['Search']))
{
	$s_date=$_GET['s_date'];
	$e_date=$_GET['e_date'];
}
?>
<link href="../css/SpitechStyle.css" rel="stylesheet" type="text/css" />
<center>
<h1><img src="../SpitechImages/Reports.png" width="31" height="32" />Reports  : <span> Project Wise Total Collection-Commission-TDS</span>
<A style="float:right; margin-right:30px;" onclick="<?php ShowHide("FindForm","block"); ?>"><img src="../SpitechImages/FindIcon.png" />Search</A>
</h1>
<table width="100%" border="0" cellspacing="0" cellpadding="0" id="Content">
  <tr>
    <td>
    <center>
     <form name="FindForm" id="FindForm" method="get" style="display:<?php if(isset($_GET['Search'])) { echo "block;"; } else { echo "none;"; };?>; margin-top:-20px;" >
      <table width="98%" id="CommonTable"  cellspacing="0" class="DontPrint">       
          <tr >
            <td width="49" height="30">FROM</td>
            <td width="18" class="Date"><script>DateInput('s_date', true, 'yyyy-mm-dd','<?php echo $s_date?>')</script></td>
            <td width="32">TO</td>
            <td width="18" class="Date"><script>DateInput('e_date', true, 'yyyy-mm-dd','<?php echo $e_date?>')</script></td>
            <td colspan="2"><input type="submit" name="Search" id="Search" value="  "  /></td>
             <td width="106" id="Field">from&nbsp;date&nbsp;:</td>
    <td width="63" id="Value"><?php echo date('d-M-Y',strtotime($s_date))?></td>
    <td width="49">to&nbsp;:</td>
    <td width="784" id="Value"><?php echo date('d-M-Y',strtotime($e_date))?></td>
          </tr>       
      </table></form>
    
     <table width="100%" border="0" cellspacing="1" cellpadding="0" id="Data-Table" style="width:700PX;">
       <tr>
        <th>#</th>
        <th>PROJECT</th>
        <th>COLLECTION</th>
        <th>COMMISSION</th>
        <th>TDS</th>
        <th>NETT </th>
        </tr>
    <?php 	   $i=1;
	   $PROJECT_Q="SELECT project_id, project_name from tbl_project order by project_name";
	   $PROJECT_Q=@mysqli_query($_SESSION['CONN'],$PROJECT_Q);
	   while($PROJECT_ROWS=@mysqli_fetch_assoc($PROJECT_Q)) 
	   {
		   $project_id=$PROJECT_ROWS['project_id'];
		   //==================(COLLECTION)========================================
			   $COLL_Q="SELECT SUM(payment_amount) as COLLECTION FROM tbl_property_booking_payments
						WHERE payment_project_id='$project_id' AND payment_date BETWEEN '$s_date' AND '$e_date' and approved='1' ";
			   $COLL_Q=@mysqli_query($_SESSION['CONN'],$COLL_Q)	;
			   $COLL_ROW=@mysqli_fetch_assoc($COLL_Q);
			   
			   $COLLECTION=$COLL_ROW['COLLECTION'];	$TOTAL_COLLECTION+=$COLLECTION;
			
			 //==================(COMMISSION)========================================
			   $COMM_Q="SELECT   SUM(commission_amount) as COMMISSION,
								 SUM(commission_tds_amount) as TDS,
								 SUM(commission_nett_amount) as NETT
						FROM tbl_advisor_commission
						WHERE 
						commission_project_id='$project_id' AND 
						commission_date BETWEEN '$s_date' AND '$e_date' 
						and commission_advisor_id!='1' 
						and approved='1' ";
			   $COMM_Q=@mysqli_query($_SESSION['CONN'],$COMM_Q)	;
			   $COMM_ROW=@mysqli_fetch_assoc($COMM_Q);
			   
			   $COMM=$COMM_ROW['COMMISSION'];   	$TOTAL_COMM+=$COMM;
			   $TDS=$COMM_ROW['TDS'];      	        $TOTAL_TDS+=$TDS;
			   $NETT=$COMM_ROW['NETT'];             $TOTAL_NETT+=$NETT;
					
	?>    
      <tr>
        <td width="5%" style="text-align:center;"><?php echo $i++?>.</td>
        <td width="47%"><?php echo $PROJECT_ROWS['project_name']?></td>
        <td width="11%" style="text-align:right;"><?php echo @number_format($COLLECTION,2)?></td>
        <td width="13%" style="text-align:right;"><?php echo @number_format($COMM,2)?></td>
        <td width="11%" style="text-align:right;"><?php echo @number_format($TDS,2)?></td>
        <td width="13%" style="text-align:right;"><?php echo @number_format($NETT,2)?></td>
      </tr>
      <?php } ?>
      
     <tr>
        <th colspan="2"><div align="right">TOTAL</div></th>
        <th style="text-align:right;"><?php echo @number_format($TOTAL_COLLECTION,2)?></th>
        <th style="text-align:right;"><?php echo @number_format($TOTAL_COMM,2)?></th>
        <th style="text-align:right;"><?php echo @number_format($TOTAL_TDS,2)?></th>
        <th style="text-align:right;"><?php echo @number_format($TOTAL_NETT,2)?></th>
        </tr>
  </table>
  <DIV style="width:700PX; text-align:right;  " align="center" id="Hint">
    <img src="../SpitechImages/Hint.png" style="margin-bottom:-5px;"/> 
   
    Commission  And TDS of The <?php echo advisor_title?> 
     <b>
	 	<?php echo $DBOBJ->ConvertToText("tbl_advisor","advisor_id","advisor_name",1)?>
     </b>, 
     ( <b><?php echo $DBOBJ->ConvertToText("tbl_advisor","advisor_id","advisor_code",1)?></b>)
      Not Included In This Report Because He is the <b>Company</b> Or <b>Owner</b> of company And All Remaining Commission Goes To Company
     
  </DIV>
  </td>
  </tr>
</table>
</center>
<?php include("../Menu/Footer.php"); ?>
