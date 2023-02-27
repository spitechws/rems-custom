<?php 
include_once('../php/Excel.php'); ExportExcel(); 
$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();		
$s_date="2000-01-01";
$e_date=date('Y-m-d');
if(isset($_GET['Search'])) { $s_date=$_GET['s_date']; $e_date=$_GET['e_date'];}
?>
<center>
<h1>Home  : Token Expiry <span>Reminder</span></h1>
      <table  width="103%" cellspacing="0" border="1" id="ExportTable" style="width:100%; margin:0px; padding:0px;">
        <tr id="TH">
          <th width="2%" height="20">#</th>
          <th width="3%">ORDER</th>
          <th width="3%">&nbsp;DATE</th>
          <th width="15%">PROJECT&nbsp;</th>
          <th width="2%">TYPE</th>
          <th width="5%">PROPERTY</th>
          <th width="2%">&nbsp;ID</th>
          <th width="16%">CUSTOMER&nbsp;NAME </th>
          <th width="16%">BOOKED&nbsp;BY&nbsp;<?php echo advisor_title?> </th>
          <th width="3%">ID</th>
          <th width="3%">MRP</th>
          <th width="6%">DISCOUNTS</th>
          <th width="4%">DIS.&nbsp;MRP</th>
          <th width="6%">TOKEN&nbsp;MONEY</th>
          <th width="6%">EXPIRY&nbsp;DATE</th>
          <th width="4%">BALANCE</th>
          <th width="4%">DAYS&nbsp;FROM EXPIRY</th>
        </tr>
          <?php      	$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);	
		if(isset($_GET["limit"]))	{ $limit = $_GET["limit"];}	else	{	$limit = 100;	}
		$startpoint = ($page * $limit) - $limit;		
		if(isset($_GET["page"])) { $k=($page-1)*($limit)+1; }	else $k=1;
		//----------------------------------------------------------		
		$BOOKING_QUERY="select * from tbl_property_booking where booking_type='Temporary' and approved='1' and booking_cancel_status=''  ";
		if(isset($_GET['Search']))
		{
			if($_GET['booking_project_id']!="All") 		{ $BOOKING_QUERY.=" and booking_project_id='".$_GET['booking_project_id']."'";		}
			if($_GET['booking_property_id']!="All") 	   { $BOOKING_QUERY.=" and booking_property_id ='".$_GET['booking_property_id']."' "; 	}
			if($_GET['booking_customer_id']!="All") 	   { $BOOKING_QUERY.=" and booking_customer_id ='".$_GET['booking_customer_id']."' "; 	}
			if($_GET['booking_advisor_id']!="All") 	    { $BOOKING_QUERY.=" and booking_advisor_id ='".$_GET['booking_advisor_id']."' "; 	  }	
			if($_GET['property_type_id']!="All") 	      
			{ 
				$BOOKING_QUERY.=" and booking_property_id in ( select property_id from tbl_property 
									where property_type_id='".$_GET['property_type_id']."') "; 	  
			}		
				$BOOKING_QUERY.=" and booking_token_exp_date between '$s_date' and '$e_date' ";	
				
			
			if($_GET['booking_cancel_status']!="All") 	   { $BOOKING_QUERY.=" and booking_cancel_status ='".$_GET['booking_cancel_status']."' "; 	  }	
		}
	    
		$PAGINATION_QUERY=$BOOKING_QUERY."  order by booking_token_exp_date desc ";
		$BOOKING_QUERY=$PAGINATION_QUERY."  LIMIT {$startpoint} , {$limit}";	
		$BOOKING_QUERY=@mysqli_query($_SESSION['CONN'],$BOOKING_QUERY);	  
		$RECORD_FOUND=@mysqli_num_rows($BOOKING_QUERY);

while($BOOKING_ROWS=@mysqli_fetch_assoc($BOOKING_QUERY)) 
{
	$BOOKING_TYPE=$BOOKING_ROWS['booking_type'];
	$PROPERTY_STATUS_TYPE=$DBOBJ->ConvertToText("tbl_property","property_id","property_status",$BOOKING_ROWS['booking_property_id']);
	if($BOOKING_TYPE=="Temporary" && $PROPERTY_STATUS_TYPE=="Temp") 
	{ 
	 $BG="RED";$color="white;";
	 $EXP_DATE=date('d-m-Y',strtotime($BOOKING_ROWS['booking_token_exp_date']));
	}
	else
	{
		$EXP_DATE=date('d-m-Y',strtotime($BOOKING_ROWS['booking_token_exp_date']));
		$BG="none";$color="black;";
	}
	
?>
        <tr>
          <td><div align="center"><?php echo $k++;?>.</div></td>
          <td><div align="center"><?php echo $BOOKING_ROWS['booking_order_no'];?></div></td>
          <td><div align="center" style="width:70px;"><?php echo date('d-m-Y',strtotime($BOOKING_ROWS['booking_date']));?></div></td>
          <td><div align="center" style="width:120px;"><?php echo $DBOBJ->ConvertToText("tbl_project","project_id","project_name",$BOOKING_ROWS['booking_project_id']);?></div></td>
          <td><div align="center"><?php echo $DBOBJ->PropertyTypeName($BOOKING_ROWS['booking_property_id']); ?></div></td>
          <td><div align="center"><?php echo $DBOBJ->ConvertToText("tbl_property","property_id","property_no",$BOOKING_ROWS['booking_property_id']) ;?></div></td>
          <td><div align="center" style="width:70px;"><?php echo $DBOBJ->ConvertToText("tbl_customer","customer_id","customer_code",$BOOKING_ROWS['booking_customer_id']);?></div></td>
          <td><?php echo $DBOBJ->ConvertToText("tbl_customer","customer_id","customer_name",$BOOKING_ROWS['booking_customer_id']);?></td>
          <td><?php echo $DBOBJ->ConvertToText("tbl_advisor","advisor_id","advisor_name",$BOOKING_ROWS['booking_advisor_id']) ;?></td>
          <td><div align="center" style="width:80px;"><?php echo $DBOBJ->ConvertToText("tbl_advisor","advisor_id","advisor_code",$BOOKING_ROWS['booking_advisor_id']) ;?></div></td>
          <td><div align="right"><?php echo @number_format($BOOKING_ROWS['booking_property_mrp'],2);$TOTAL_MRP+=$BOOKING_ROWS['booking_property_mrp'];?></div></td>
          <td><div align="right"><?php echo @number_format($BOOKING_ROWS['booking_property_discount_amount'],2);$TOTAL_DISCOUNT+=$BOOKING_ROWS['booking_property_discount_amount'];?> </div></td>
          <td><div align="right"><?php echo @number_format($BOOKING_ROWS['booking_property_discounted_mrp'],2);$TOTAL_DISCOUNTED_MRP+=$BOOKING_ROWS['booking_property_discounted_mrp'];?> </div></td>
          <td><div align="right"><?php echo @number_format($TOKEN_AMOUNT=$DBOBJ->ConvertToText("tbl_property_booking_payments","payment_voucher_no","payment_amount",$BOOKING_ROWS['booking_voucher_no']),2);$TOTAL_TOKEN_AMOUNT+=$TOKEN_AMOUNT;?> </div></td>
          <td><div align="center"<?php if($BOOKING_ROWS['booking_token_exp_date']<date('Y-m-d')) { ?> style=" background:#8C0000; color:#FFFFFF; font-weight:bolder;" <?php } ?>>
    <?php 
	echo date('d-m-Y',strtotime($BOOKING_ROWS['booking_token_exp_date'])); 
	$ExDate=$BOOKING_ROWS['booking_token_exp_date'];
	$DateDiff=DateDiff($ExDate,date('Y-m-d'));
	?>
          </div></td>
          <td style="text-align:right">
		  <?php $BALANCE=$DBOBJ->TotalBookingBalance($BOOKING_ROWS['booking_id']);
		     echo @number_format($BALANCE,2);
		     $TOTAL_BAL+=$BALANCE;
		  ?></td>
          <td style="font-size:12px; font-weight:bolder; color:white; "><div align="center" style="background:<?php if($DateDiff<=5) { echo "green"; } elseif($DateDiff>5 && $DateDiff<=10) { echo "yellow; color:black"; }  else { echo "red"; }?>"><?php echo abs($DateDiff); ?></div></td>
        </tr>
      
        <?php }?>
        <tr>
          <th colspan="10">&nbsp;</th>
          <th style="text-align:right;"><?php echo @number_format($TOTAL_MRP,2);?></th>
          <th style="text-align:right;"><?php echo @number_format($TOTAL_DISCOUNT,2);?></th>
          <th style="text-align:right;"><?php echo @number_format($TOTAL_DISCOUNTED_MRP,2);?></th>
          <th style="text-align:right;"><?php echo @number_format($TOTAL_TOKEN_AMOUNT,2);?></th>
          <th>&nbsp;</th>
          <th style="text-align:right;"><?php echo @number_format($TOTAL_BAL,2);?></th>
          <th>&nbsp;</th>
        </tr>
      </table>
   </center>