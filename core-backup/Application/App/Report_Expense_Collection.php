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
      
     <table width="98%" border="0" cellspacing="0" cellpadding="0" style="margin-left:1%;">
       <tr>
         <th width="50%" style="vertical-align:top; ">
          <h2>EXPENSES</h2>
          <DIV style="height:250PX; overflow:scroll; width:98%; margin-left:1%; border:1PX SOLID SILVER;">
             <table width="100%" border="0" cellspacing="1" cellpadding="0" id="Data-Table" style="width:98%; ">
               <tr>
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
          </DIV>
          
          
         </th>
         <th style="vertical-align:top">
         <h2>COLLECTION</h2>
         <DIV style="height:250PX; overflow:scroll; width:98%; margin-left:1%; border:1PX SOLID SILVER;">
         <table width="100%" border="0" cellspacing="1" cellpadding="0" id="Data-Table" style="width:98%; ">
           <tr>
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
         </DIV>
         </th>
       </tr>
       <tr>
         <th style="vertical-align:top;">&nbsp;</th>
         <th style="vertical-align:top; text-align:right ">
         
         <table width="270" border="0" cellspacing="1" align="right" cellpadding="0" id="SmallTable" style="width:300PX">
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
               <th style="color:#005500"><div align="left">NETT COLLECTION</div></th>
               <td style="text-align:right;color:#005600"><?php echo @number_format($TOTAL_COLLECTION-$TOTAL_COMM,2)?></td>
             </tr>
             <tr>
               <th style="color:#660000"><div align="left">TOTAL EXPENSES</div></th>
               <td style="text-align:right;color:#FF0000"><?php echo @number_format($TOTAL_EXPENSE,2)?></td>
             </tr>
             <tr>
               <th style="color:#FFF; background:#060"><div align="left">BALANCE IN HAND</div></th>
               <td style="text-align:right;color:#FFF; background:#060"><?php echo @number_format($TOTAL_COLLECTION-$TOTAL_COMM-$TOTAL_EXPENSE,2)?></td>
             </tr>
             
         </table></th>
       </tr>
     </table></td>
  </tr>
</table>
</center>
<?php include("../Menu/Footer.php"); ?>
