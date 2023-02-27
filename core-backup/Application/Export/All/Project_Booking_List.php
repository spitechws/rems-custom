<?php 
include_once('../php/Excel.php'); ExportExcel(); 
$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();

$s_date="2000-01-01";
$e_date=date('Y-m-d');
if(isset($_GET['Search'])) { $s_date=$_GET['s_date']; $e_date=$_GET['e_date'];}
?>
<center>
<h1>Project  : <span> Property Booking List</span></h1>
    <table  width="100%"  cellspacing="0" border="1" id="ExportTable" style="margin:0PX; width:100%; padding:0px;">
      <tr id="TH">
        <th width="2%" height="27" rowspan="2" >#</th>
        <th width="3%" rowspan="2" >ORDER</th>
        <th colspan="2" >&nbsp;DATE</th>
        <th width="9%" rowspan="2" >PROJECT&nbsp;NAME </th>
        <th width="2%" rowspan="2" >TYPE</th>
        <th width="2%" rowspan="2" >PROP&nbsp;NO</th>
        <th colspan="2" >CUSTOMER&nbsp;DETAILS</th>
        <th colspan="2" >BOOKED&nbsp;BY&nbsp;<?php echo advisor_title?></th>
        <th width="2%" rowspan="2" >MRP</th>
        <th width="4%" rowspan="2" >DISCOUNT</th>
        <th width="2%" rowspan="2" >DISC MRP</th>
        <th width="4%" rowspan="2" >RECEIVD</th>
        <th width="5%" rowspan="2" >BALANCE</th>
        <th width="11%" rowspan="2" >STATUS</th>
        <th width="3%" rowspan="2" >REG.</th>
        <th width="3%" rowspan="2" >DISP</th>
      </tr>
      <tr id="TH">
        <th width="5%" >BOOKING</th>
        <th width="5%" >EXPIRY</th>
        <th width="10%" >NAME</th>
        <th width="6%" >ID</th>
        <th width="10%" >NAME</th>
        <th width="5%" >ID</th>
      </tr>
      <?php      	$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);	
		if(isset($_GET["limit"]))	{ $limit = $_GET["limit"];	}	else	{	$limit = 100;	}
		$startpoint = ($page * $limit) - $limit;		
		if(isset($_GET["page"])) { $k=($page-1)*($limit)+1; }	else $k=1;
		//----------------------------------------------------------		
		$BOOKING_QUERY="select * from tbl_property_booking where approved='1' ";
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
				$BOOKING_QUERY.=" and booking_date between '$s_date' and '$e_date' ";	
				
			if($_GET['booking_type']!="All") 	    		{ $BOOKING_QUERY.=" and booking_type ='".$_GET['booking_type']."' "; 	  					}
			if($_GET['booking_cancel_status']!="All") 	   { $BOOKING_QUERY.=" and booking_cancel_status ='".$_GET['booking_cancel_status']."' "; 	  }	
		}
	    
		$PAGINATION_QUERY=$BOOKING_QUERY."  order by booking_id desc ";
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
      <tr >
        <td height="22" ><div align="center"><?php echo $k++ ; ?></div></td>
        <td><div align="center"><?php echo $BOOKING_ROWS['booking_order_no'];?></div></td>
        <td><div align="center" style="width:60px;"><?php echo date('d-m-Y',strtotime($BOOKING_ROWS['booking_date']));?></div></td>
       
        <td style="background:<?php echo $BG?>;color:<?php echo $color?>"><div align="center" style="width:60px;"><?php echo $EXP_DATE;?> </div></td>
        
        <td><div align="left" style="width:120px;"><?php echo $DBOBJ->ConvertToText("tbl_project","project_id","project_name",$BOOKING_ROWS['booking_project_id']);?></div></td>
        <td><div align="center"><?php echo $DBOBJ->PropertyTypeName($BOOKING_ROWS['booking_property_id']);?></div></td>
        <td><div align="center"><?php echo $DBOBJ->ConvertToText("tbl_property","property_id","property_no",$BOOKING_ROWS['booking_property_id']);?></div></td>
        <td><div align="left" style="width:130px;"><?php echo $DBOBJ->ConvertToText("tbl_customer","customer_id","customer_name",$BOOKING_ROWS['booking_customer_id']);?>
        </div></td>
        <td><div align="center" style="width:70px;"><?php echo $DBOBJ->ConvertToText("tbl_customer","customer_id","customer_code",$BOOKING_ROWS['booking_customer_id']);?></div></td>
        <td><div align="left" style="width:130px;"><?php echo $DBOBJ->ConvertToText("tbl_advisor","advisor_id","advisor_name",$BOOKING_ROWS['booking_advisor_id']);?>
        </div></td>
        <td><div align="center" style="width:60px;"><?php echo $DBOBJ->ConvertToText("tbl_advisor","advisor_id","advisor_code",$BOOKING_ROWS['booking_advisor_id']);?></div></td>
        <td><div align="right"><?php echo @number_format($BOOKING_ROWS['booking_property_mrp'],2);$TOTAL_MRP+=$BOOKING_ROWS['booking_property_mrp'];?></div></td>
        <td><div align="right"><?php echo @number_format($BOOKING_ROWS['booking_property_discount_amount'],2);$TOTAL_DISCOUNT+=$BOOKING_ROWS['booking_property_discount_amount'];?></div></td>
        <td><div align="right"><?php echo @number_format($BOOKING_ROWS['booking_property_discounted_mrp'],2);$TOTAL_DESCOUNTED_MRP+=$BOOKING_ROWS['booking_property_discounted_mrp'];?></div></td>
        <td><div align="right"><?php $COLLECTION=$DBOBJ->TotalBookingCollection($BOOKING_ROWS['booking_id']); echo @number_format($COLLECTION,2); $TOTAL_COLLECTION+=$COLLECTION;?></div></div></td>
        <td><div align="right"><?php $BALANCE=$DBOBJ->TotalBookingBalance($BOOKING_ROWS['booking_id']); echo @number_format($BALANCE,2); $TOTAL_BALANCE+=$BALANCE; ?></div></td>
        <td <?php if($BOOKING_ROWS['booking_cancel_status']=="Yes") { $BG="RED"; $COL="WHITE"; $STATUS="Cancelled"; } else { $BG="GREEN"; $COL="WHITE";$STATUS="Active";} ?> style="background:<?php echo $BG?>;COLOR:<?php echo $COL?>; text-align:center;"><?php echo $STATUS?></td>
        <td style="text-align:center;" title="Registered Or Not">
        <?php  if($BOOKING_ROWS['booking_registry_status']=="Registered") { echo "<font color=green><b>&#x2713;</b></font>"; } else { echo "<font color=red><b>X</b></font>"; } ?>
        </td>
        <td style="text-align:center;" title="Dispached Or Not">
        <?php  if($BOOKING_ROWS['booking_dispached_status']=="Registered") { echo "<font color=green><b>&#x2713;</b></font>"; } else { echo "<font color=red><b>X</b></font>"; } ?>
        </td>
        </tr>
      <?php 

 
  }?>
      <tr  >
        <th height="22" colspan="11" ><div align="right">TOTAL</div></th>
        <th height="22" ><div align="right"><?php echo @number_format($TOTAL_MRP,2);?></div></th>
        <th height="22" ><div align="right"><?php echo @number_format($TOTAL_DISCOUNT,2);?></div></th>
        <th height="22" ><div align="right"><?php echo @number_format($TOTAL_DESCOUNTED_MRP,2);?></div></th>
        <th height="22" ><div align="right"><?php echo @number_format($TOTAL_COLLECTION,2);?></div></th>
        <th height="22" ><div align="right"><?php echo @number_format($TOTAL_BALANCE,2);?></div></th>
        <th colspan="3" >&nbsp;</th>
        </tr>
     
    </table>
   </center>