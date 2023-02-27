<?php
include_once("../Menu/HeaderAdmin.php");
include_once("../php/SpitechDB.php");
include_once("../php/SpitechUtility.php");
include_once("../php/SpitechPagination.php");
include_once("../php/SpitechJS.php");
Menu("Project");
NoUser();

$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();
NoUser();

$s_date="2000-01-01";
$e_date=date('Y-m-d');
if(isset($_GET['Search'])) { $s_date=$_GET['s_date']; $e_date=$_GET['e_date'];}
?>
<link href="../css/SpitechStyle.css" rel="stylesheet" type="text/css" />
<center>
<h1><img src="../SpitechImages/BookingCancelled.png" width="31" height="32" />
Project  : <span> Property Booking Cancelled Report</span>
<A style="float:right; margin-right:30px;" onclick="<?php ShowHide("FindForm","block"); ?>"><img src="../SpitechImages/FindIcon.png" />Search</A>
</h1>
<table width="100%" border="0" cellspacing="0" cellpadding="0" id="Content">
  <tr>
    <td>
     <form name="FindForm" id="FindForm" method="get" style="display:<?php if(isset($_GET['Search'])) { echo "block;"; } else { echo "none;"; };?>">
      <table width="98%" border="0" cellspacing="0" cellpadding="0" id="SearchTable" style="margin-top:5px;">
      <tr>
        <td width="4%">PROJECT</td>
        <td width="15%">
        <select id="booking_project_id" name="booking_project_id" onchange="GetPage('GetBookedProperty.php?project_id='+this.value,'property');" >
          <option value="All">ALL PROJECT...</option>
          <?php 
             $PROJECT_Q=@mysqli_query($_SESSION['CONN'],"select project_id, project_name from tbl_project ");
             while($PROJECT_ROWS=@mysqli_fetch_assoc($PROJECT_Q)) 
             {?>
          <option value="<?php echo $PROJECT_ROWS['project_id']?>" <?php SelectedSelect($PROJECT_ROWS['project_id'],$_GET['booking_project_id']);?>>
            <?php echo $PROJECT_ROWS['project_name']?>
            </option>
          <?php } ?>
        </select></td>
        <td width="4%">PROPERTY</td>
        <td width="15%">
       <div id="property">
        <select id="booking_property_id" name="booking_property_id" >
          <option value="All">ALL PROPERTY...</option>
          <?php 
		  $PROPERTY_Q="select property_id, property_no  from tbl_property where property_project_id='".$_GET['booking_project_id']."'  and property_status!='Available' and property_status!='Hold' order by  property_id, property_no  ";
             $PROPERTY_Q=@mysqli_query($_SESSION['CONN'],$PROPERTY_Q);
             while($PROPERTY_ROWS=@mysqli_fetch_assoc($PROPERTY_Q)) 
             {?>
          <option value="<?php echo $PROPERTY_ROWS['property_id']?>" <?php SelectedSelect($PROPERTY_ROWS['property_id'],$_GET['booking_property_id'] ); ?>>
		  <?php echo $PROPERTY_ROWS['property_no']?></option>
          <?php } ?>
</select>
</div></td>
        <td width="2%">type</td>
        <td colspan="3">
          
          <select id="property_type_id" name="property_type_id" style="width:100px;">
            <option value="All">All Property Type...</option>
            <?php 
             $TYPE_Q=@mysqli_query($_SESSION['CONN'],"select property_type_id, property_type from tbl_setting_property_type ");
             while($TYPE_ROWS=@mysqli_fetch_assoc($TYPE_Q)) 
             {?>
            <option value="<?php echo $TYPE_ROWS['property_type_id']?>" <?php SelectedSelect($TYPE_ROWS['property_type_id'],$_GET['property_type_id'] ); ?>>
              <?php echo $TYPE_ROWS['property_type']?>
              </option>
            <?php } ?>
            </select>
            
            STATUS	<select name="booking_type" id="booking_type" style="width:100px;">
                      <option value="All">All Status...</option>
                      <option value="Permanent" <?php SelectedSelect("Permanent", $_GET['booking_type']); ?>>Permanent</option>
                      <option value="Temporarily" <?php SelectedSelect("Temporary", $_GET['booking_type']); ?>>Temporary</option>
                    </select>
		Cancelled
		<select name="booking_cancel_status" id="booking_cancel_status" style="width:100px;">
            <option value="All">All Status...</option>            
            <option value="" <?php SelectedSelect("", $_GET['booking_cancel_status']); ?>>Active</option>
            <option value="Yes" <?php SelectedSelect("Yes", $_GET['booking_cancel_status']); ?>>Cancelled</option>
        </select>  
              </td>
        <td width="7%"><input type="submit" name="Search" value=" " id="Search" /></td>
        </tr>
      <tr>
        <td>from</td>
        <td class="Date"><script>DateInput('s_date',true, 'yyyy-mm-dd','<?php echo $s_date?>');</script></td>
        <td class="Date">TO</td>
        <td class="Date"><script>DateInput('e_date',true, 'yyyy-mm-dd','<?php echo $e_date?>');</script></td>
        <td class="Date"><div align="right">customer</div></td>
        <td width="8%" class="Date">
        
        <select id="booking_customer_id" name="booking_customer_id" >
          <option value="All">ALL CUSTOMER...</option>
          <?php   $CUSTOMER_Q="SELECT customer_id, customer_code, customer_name FROM tbl_customer ORDER BY customer_name";
			   $CUSTOMER_Q=@mysqli_query($_SESSION['CONN'],$CUSTOMER_Q);
			   while($CUSTOMER_ROWS=@mysqli_fetch_assoc($CUSTOMER_Q)) {?>
          <option value="<?php echo $CUSTOMER_ROWS['customer_id'];?>" <?php SelectedSelect($CUSTOMER_ROWS['customer_id'], $_GET['booking_customer_id']); ?> > <?php echo $CUSTOMER_ROWS['customer_name']." [".$CUSTOMER_ROWS['customer_code']." ]";?></option>
          <?php } ?>
        </select></td>
        <td width="3%"><?php echo advisor_title?></td>
        <td width="8%">
          <select id="booking_advisor_id" name="booking_advisor_id" >
            <option value="All">ALL <?php echo advisor_title?>...</option>
            <?php 		$ADVISOR_Q="SELECT advisor_id, advisor_code, advisor_name FROM tbl_advisor ORDER BY advisor_name";
			    $ADVISOR_Q=@mysqli_query($_SESSION['CONN'],$ADVISOR_Q);
			   while($ADVISOR_ROWS=@mysqli_fetch_assoc($ADVISOR_Q)) {?>
            <option value="<?php echo $ADVISOR_ROWS['advisor_id'];?>" <?php SelectedSelect($ADVISOR_ROWS['advisor_id'], $_GET['booking_advisor_id']); ?>> <?php echo $ADVISOR_ROWS['advisor_name']." [".$ADVISOR_ROWS['advisor_code']." ]";?></option>
            <?php } ?>
            </select>
        </td>
        <td><input type="button" name="ShowAll" value="Show All" id="ShowAll" class="Button"  onclick="window.location='Project_Booking_List.php'" style="width:80px;"/></td>
        </tr>
     
      </table>

  </form>
  <?php ErrorMessage();?>
    <table  width="100%"  cellspacing="1" id="Data-Table" style="margin:0PX; width:100%; padding:0px;">
      <tr  >
        <th width="2%" height="27" rowspan="2" >#</th>
        <th width="4%" rowspan="2" >ORDER</th>
        <th colspan="2" >&nbsp;DATE</th>
        <th width="12%" rowspan="2" >PROJECT&nbsp;NAME </th>
        <th width="3%" rowspan="2" >TYPE</th>
        <th width="5%" rowspan="2" >PROP&nbsp;NO</th>
        <th >CUSTOMER&nbsp;details</th>
        <th >BOOKED&nbsp;BY&nbsp;<?php echo advisor_title?></th>
        <th width="2%" rowspan="2" >MRP</th>
        <th width="5%" rowspan="2" >DISCOUNT</th>
        <th width="3%" rowspan="2" >DISC MRP</th>
        <th width="4%" rowspan="2" >RECEIVD</th>
        <th width="6%" rowspan="2" >BALANCE</th>
        <th width="15%" rowspan="2" >CANCELLED&nbsp;DETASILS</th>
        <th width="6%" rowspan="2" class="Action">ACTION</th>
      </tr>
      <tr  >
        <th width="5%" >BOOKING</th>
        <th width="4%" >expiry</th>
        <th width="12%" >name</th>
        <th width="12%" >name</th>
        </tr>
      <?php      	$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);	
		if(isset($_GET["limit"]))	{ $limit = $_GET["limit"];	}	else	{	$limit = 100;	}
		$startpoint = ($page * $limit) - $limit;		
		if(isset($_GET["page"])) { $k=($page-1)*($limit)+1; }	else $k=1;
		//----------------------------------------------------------		
		$CANCEL_QUERY="select * from tbl_property_booking_cancelled where 1 ";
		if(isset($_GET['Search']))
		{
			if($_GET['booking_project_id']!="All") 		{ $CANCEL_QUERY.=" and booking_project_id='".$_GET['booking_project_id']."'";		}
			if($_GET['booking_property_id']!="All") 	   { $CANCEL_QUERY.=" and booking_property_id ='".$_GET['booking_property_id']."' "; 	}
			if($_GET['booking_customer_id']!="All") 	   { $CANCEL_QUERY.=" and booking_customer_id ='".$_GET['booking_customer_id']."' "; 	}
			if($_GET['booking_advisor_id']!="All") 	    { $CANCEL_QUERY.=" and booking_advisor_id ='".$_GET['booking_advisor_id']."' "; 	  }	
			if($_GET['property_type_id']!="All") 	      
			{ 
				$CANCEL_QUERY.=" and booking_property_id in ( select property_id from tbl_property 
									where property_type_id='".$_GET['property_type_id']."') "; 	  
			}		
				$CANCEL_QUERY.=" and booking_date between '$s_date' and '$e_date' ";	
				
			if($_GET['booking_type']!="All") 	    		{ $CANCEL_QUERY.=" and booking_type ='".$_GET['booking_type']."' "; 	  					}
			if($_GET['booking_cancel_status']!="All") 	   { $CANCEL_QUERY.=" and booking_cancel_status ='".$_GET['booking_cancel_status']."' "; 	  }	
		}
	    
		$PAGINATION_QUERY=$CANCEL_QUERY."  order by booking_id desc ";
		$CANCEL_QUERY=$PAGINATION_QUERY."  LIMIT {$startpoint} , {$limit}";	
		$CANCEL_QUERY=@mysqli_query($_SESSION['CONN'],$CANCEL_QUERY);	  
		$RECORD_FOUND=@mysqli_num_rows($CANCEL_QUERY);

while($CANCEL_ROWS=@mysqli_fetch_assoc($CANCEL_QUERY)) 
{
	$CANCEL_TYPE=$CANCEL_ROWS['booking_type'];
	$PROPERTY_STATUS_TYPE=$DBOBJ->ConvertToText("tbl_property","property_id","property_status",$CANCEL_ROWS['booking_property_id']);
	if($CANCEL_TYPE=="Temporarily" && $PROPERTY_STATUS_TYPE=="Temp") 
	{ 
	 $BG="RED";$color="white;";
	 $EXP_DATE=date('d-m-Y',strtotime($CANCEL_ROWS['booking_token_exp_date']));
	}
	else
	{
		$EXP_DATE=date('d-m-Y',strtotime($CANCEL_ROWS['booking_token_exp_date']));
		$BG="none";$color="black;";
	}
	
?>
      <tr >
        <td height="22" ><div align="center"><?php echo $k++ ; ?></div></td>
        <td><div align="center"><?php echo $CANCEL_ROWS['booking_order_no'];?></div></td>
        <td><div align="center" style="width:70px;"><?php echo date('d-m-Y',strtotime($CANCEL_ROWS['booking_date']));?></div></td>
       
        <td style="background:<?php echo $BG?>;color:<?php echo $color?>"><div align="center" style="width:70px;"><?php echo $EXP_DATE;?> </div></td>
        
        <td><div align="left" style="width:150px;"><?php echo $DBOBJ->ConvertToText("tbl_project","project_id","project_name",$CANCEL_ROWS['booking_project_id']);?></div></td>
        <td><div align="center"><?php echo $DBOBJ->PropertyTypeName($CANCEL_ROWS['booking_property_id']);?></div></td>
        <td><div align="center"><?php echo $DBOBJ->ConvertToText("tbl_property","property_id","property_no",$CANCEL_ROWS['booking_property_id']);?></div></td>
        <td><div align="left" style="width:150px;"><?php echo $DBOBJ->ConvertToText("tbl_customer","customer_id","customer_name",$CANCEL_ROWS['booking_customer_id']);?>
        </div></td>
        <td><div align="left" style="width:150px;"><?php echo $DBOBJ->ConvertToText("tbl_advisor","advisor_id","advisor_name",$CANCEL_ROWS['booking_advisor_id']);?>
        </div></td>
        <td><div align="right"><?php echo @number_format($CANCEL_ROWS['booking_property_mrp'],2);$TOTAL_MRP+=$CANCEL_ROWS['booking_property_mrp'];?></div></td>
        <td><div align="right"><?php echo @number_format($CANCEL_ROWS['booking_property_discount_amount'],2);$TOTAL_DISCOUNT+=$CANCEL_ROWS['booking_property_discount_amount'];?></div></td>
        <td><div align="right"><?php echo @number_format($CANCEL_ROWS['booking_property_discounted_mrp'],2);$TOTAL_DESCOUNTED_MRP+=$CANCEL_ROWS['booking_property_discounted_mrp'];?></div></td>
        <td><div align="right"><?php $COLLECTION=$DBOBJ->TotalBookingCollection($CANCEL_ROWS['booking_id']); echo @number_format($COLLECTION,2); $TOTAL_COLLECTION+=$COLLECTION;?></div></div></td>
        <td><div align="right"><?php $BALANCE=$DBOBJ->TotalBookingBalance($CANCEL_ROWS['booking_id']); echo @number_format($BALANCE,2); $TOTAL_BALANCE+=$BALANCE; ?></div></td>
        <td style="font-size:9px; line-height:10px;"><?php echo $CANCEL_ROWS['booking_cancel_details'];?></td>
        <td style="text-align:center" class="Action">
          <div align="center"> 
            <a title="View Account" href="Project_Property_Booking_Accounts.php?<?php echo md5('booking_id')."=".$CANCEL_ROWS['booking_id'];?>">Account</a></div>
        </td>
        </tr>
      <?php 

 
  }?>
      <tr  >
        <th height="22" colspan="9" ><div align="right">TOTAL</div></th>
        <th height="22" ><div align="right"><?php echo @number_format($TOTAL_MRP,2);?></div></th>
        <th height="22" ><div align="right"><?php echo @number_format($TOTAL_DISCOUNT,2);?></div></th>
        <th height="22" ><div align="right"><?php echo @number_format($TOTAL_DESCOUNTED_MRP,2);?></div></th>
        <th height="22" ><div align="right"><?php echo @number_format($TOTAL_COLLECTION,2);?></div></th>
        <th height="22" ><div align="right"><?php echo @number_format($TOTAL_BALANCE,2);?></div></th>
        <th >&nbsp;</th>
        <th height="22" class="Action">&nbsp;</th>
        </tr>
     
    </table>
   
     <div class="paginate" ><?php pagination($PAGINATION_QUERY,$limit,$page, url());  ?></div>
   
    </td>
  </tr>
</table>
</center>
<?php include("../Menu/Footer.php"); ?>
