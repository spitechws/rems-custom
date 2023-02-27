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

    <table width="98%" border="0" cellspacing="0" cellpadding="0" style="margin-left:1%;">
      <tr>
         <th width="50%" style="vertical-align:top; ">
          <h2>EXPENSES</h2>
        <table width="100%" border="1" cellspacing="0" cellpadding="0" id="ExportTable" style="width:98%; ">
               <tr id="TH">
                 <th width="3%">#</th>
                 <th width="63%">EXPENSE CATEGORY</th>
                 <th width="34%">EXPENSES</th>                 
                 </tr> 
           <?php 		  $EXPENSE_QUERY="select expense_category_id, sum(expense_amount) as expense_amount from tbl_expense where expense_date BETWEEN '$s_date' AND '$e_date' group by expense_category_id";
		   
		   $EXPENSE_QUERY=@mysqli_query($_SESSION['CONN'],$EXPENSE_QUERY);
		   while($EXPENSE_ROWS=@mysqli_fetch_assoc($EXPENSE_QUERY)) {
		   ?>      
                 <tr>
                   <td style="text-align:center;"><?php echo ++$j?>.</td>
                   <td><?php echo $DBOBJ->ConvertToText("tbl_expense_category","category_id","category_name",$EXPENSE_ROWS['expense_category_id']);?></td>
                   <td style="text-align:right"><?php echo @number_format($EXPENSE_ROWS['expense_amount'],2);$TOTAL_EXPENSE+=$EXPENSE_ROWS['expense_amount'];?></td>
                 </tr>
           <?php } ?>  
           
            <tr>
                 <th colspan="2"><div align="right">TOTAL</div></th>
                 <th width="34%"><div align="right">
                   <?php echo @number_format($TOTAL_EXPENSE,2);?>
                 </div></th>                 
                 </tr>     
                 </table>
                 
          
         </th>
         <th style="vertical-align:top">
         <h2>COLLECTION</h2>
       <table width="100%" border="1" cellspacing="0" cellpadding="0" id="ExportTable" style="width:98%; ">
           <tr id="TH">
             <th>#</th>
             <th>PROJECT</th>
             <th>COLLECTION</th>
             <th>COMMISSION</th>
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
			   $COMM_Q="SELECT   SUM(commission_amount) as COMMISSION 								
						FROM tbl_advisor_commission
						WHERE 
						commission_project_id='$project_id' AND 
						commission_date BETWEEN '$s_date' AND '$e_date' 
						and commission_advisor_id!='1' 
						and approved='1' ";
			   $COMM_Q=@mysqli_query($_SESSION['CONN'],$COMM_Q)	;
			   $COMM_ROW=@mysqli_fetch_assoc($COMM_Q);
			   
			   $COMM=$COMM_ROW['COMMISSION'];   	$TOTAL_COMM+=$COMM;
			 
	?>
           <tr>
             <td width="3%" style="text-align:center;"><?php echo $i++?>
               .</td>
             <td width="60%"><?php echo $PROJECT_ROWS['project_name']?></td>
             <td width="18%" style="text-align:right;"><?php echo @number_format($COLLECTION,2)?></td>
             <td width="19%" style="text-align:right;"><?php echo @number_format($COMM,2)?></td>
             </tr>
           <?php } ?>
           <tr>
             <th colspan="2"><div align="right">TOTAL</div></th>
             <th style="text-align:right;"><?php echo @number_format($TOTAL_COLLECTION,2)?></th>
             <th style="text-align:right;"><?php echo @number_format($TOTAL_COMM,2)?></th>
             </tr>
         </table>
         <tr>
         <th style="vertical-align:top;">&nbsp;</th>
         <th style="vertical-align:top; text-align:right ">
         
         <table width="270" border="1" cellspacing="0" align="right" cellpadding="0" id="ExportTable" style="width:300PX">
             <tr>
               <th colspan="2">NET CALCULATION</th>
               </tr>
             <tr>
               <th width="52%"><div align="left">TOTAL COLLECTION</div></th>
               <td width="48%" style="text-align:right;"><?php echo @number_format($TOTAL_COLLECTION,2)?></td>
             </tr>
             <tr>
               <th><div align="left">TOTAL COMMISSION</div></th>
               <td style="text-align:right;"><?php echo @number_format($TOTAL_COMM,2)?></td>
             </tr>
             <tr>
               <th style="color:#00FF00"><div align="left">NETT COLLECTION</div></th>
               <td style="text-align:right;color:#005600"><?php echo @number_format($TOTAL_COLLECTION-$TOTAL_COMM,2)?></td>
             </tr>
             <tr>
               <th style="color:#FFB366"><div align="left">TOTAL EXPENSES</div></th>
               <td style="text-align:right;color:#FF0000"><?php echo @number_format($TOTAL_EXPENSE,2)?></td>
             </tr>
             <tr>
               <th style="color:#FFF; background:#060"><div align="left">BALANCE IN HAND</div></th>
               <td style="text-align:right;color:#FFF; background:#060"><?php echo @number_format($TOTAL_COLLECTION-$TOTAL_COMM-$TOTAL_EXPENSE,2)?></td>
             </tr>
             
         </table></th>
       </tr>
   </table>
</center>
