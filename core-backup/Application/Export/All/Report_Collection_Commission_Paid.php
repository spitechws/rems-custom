<?php 
include_once('../php/Excel.php'); ExportExcel(); 
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
<center>
<h1>Reports  : <span> Project Wise Total Collection-Commission-TDS</span></h1>
   
     <table width="100%" border="1" cellspacing="0" cellpadding="0" id="ExportTable" style="width:700PX;">
       <tr id="TH">
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
      
  Commission  And TDS of The 
    <?php echo advisor_title?> 
     <b>
	 	<?php echo $DBOBJ->ConvertToText("tbl_advisor","advisor_id","advisor_name",1)?>
     </b>, 
     ( <b><?php echo $DBOBJ->ConvertToText("tbl_advisor","advisor_id","advisor_code",1)?></b>)
      Not Included In This Report Because He is the <b>Company</b> Or <b>Owner</b> of company And All Remaining Commission Goes To Company
     
 
  </td>
  </tr>
</table>
</center>

