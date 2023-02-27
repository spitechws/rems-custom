<?php 
include_once('../php/Excel.php'); ExportExcel(); 
$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();

	$s_date=date('2000-01-01');	
	$e_date=date('Y-m-d');	
	if(isset($_GET['Search']))
	{
		$s_date=$_GET['s_date']; 	
	    $e_date=$_GET['e_date'];	
	}
	
?>
<center>
<h1>Expense : <span>Expense List </span></h1>

   <table width="98%" border="1" cellspacing="0" cellpadding="0" id="ExportTable">
       <tr id="TH">
         <th width="2%">#</th>
         <th width="7%">DATE</th>
         <th width="14%">AGAINST&nbsp;PARTY</th>
         <th width="13%">SUB CATEGORY</th>
         <th width="14%">CATEGORY</th>
         <th width="8%">AMOUNT</th>
         <th width="7%">TYPE</th>
         <th width="14%">DETAILS</th>
         <th width="15%">REMARKS</th>
       </tr>
       <?php

		$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);	
		if(isset($_GET["limit"]))	{ $limit = $_GET["limit"];	}	else	{	$limit = 100;	}
		$startpoint = ($page * $limit) - $limit;		
		if(isset($_GET["page"])) { $k=($page-1)*($limit)+1; }	else $k=1;
		//----------------------------------------------------------		
		$EXPENSES_QUERY="select * from tbl_expense where 1 ";
	
		if(isset($_GET['Search']))
		{
			
			if($_GET['category_id']!="All") 		{ $EXPENSES_QUERY.=" and expense_category_id ='".$_GET['category_id']."'"; 			}		
			if($_GET['sub_category_id']!="All") 	{ $EXPENSES_QUERY.=" and expense_sub_category_id='".$_GET['sub_category_id']."'";	 }	
			if($_GET['expense_party']!="All") 	  { $EXPENSES_QUERY.=" and expense_party='".$_GET['expense_party']."'";				 }		
			
			$EXPENSES_QUERY.=" and expense_date between '".$_GET['s_date']."' and '".$_GET['e_date']."' ";	
		}
	    
		$PAGINATION_QUERY=$EXPENSES_QUERY."  order by expense_date  desc, expense_party asc ";
		$EXPENSES_QUERY=$PAGINATION_QUERY."  LIMIT {$startpoint} , {$limit}";	
		$EXPENSES_QUERY=@mysqli_query($_SESSION['CONN'],$EXPENSES_QUERY);	  
		$RECORD_FOUND=@mysqli_num_rows($EXPENSES_QUERY);

while($EXPENSES_ROWS=@mysqli_fetch_assoc($EXPENSES_QUERY)) 
{
	
?>
       <tr>
         <td><div align="center"><?php echo $k++;?>.</div></td>
         <td><div align="center" style="width:80px;"><?php echo date('d-M-Y',strtotime($EXPENSES_ROWS['expense_date'])); ?></div></td>
         <td><?php echo $EXPENSES_ROWS['expense_party'];?></td>
         <td><?php echo $DBOBJ->ConvertToText("tbl_expense_sub_category","sub_category_id","sub_category_name",$EXPENSES_ROWS['expense_sub_category_id']);?></td>
         <td><?php echo $DBOBJ->ConvertToText("tbl_expense_category","category_id","category_name",$EXPENSES_ROWS['expense_category_id']);?></td>
         <td><div align="right"><?php echo @number_format($EXPENSES_ROWS['expense_amount'],2); $total_amount+=$EXPENSES_ROWS['expense_amount'];?></div></td>
         <td style="text-align:center"><?php echo $EXPENSES_ROWS['payment_mode'];?></td>
         <td>
             <div align="left">
              <?php if($EXPENSES_ROWS['payment_mode']=="CASH") {?>
                 <?php echo $EXPENSES_ROWS['payment_no']; ?>, 
                 <?php echo $EXPENSES_ROWS['payment_bank']; ?>, 
                 <?php echo date('d-M-Y',strtotime($EXPENSES_ROWS['payment_mode_date'])); ?>
               <?php } ?>   
             </div>
         </td>
         <td><?php echo $EXPENSES_ROWS['expense_note'];?></td>
       </tr>
      
       <?php } ?>
         <tr>
          <th colspan="5"><div align="right">TOTAL</div></th>
          <th style="text-align:right;"><?php echo @number_format($total_amount,2);?></th>
          <th colspan="3"><div align="right" style="color:maroon;"></div></th>
       </tr>
     </table>
     </center>