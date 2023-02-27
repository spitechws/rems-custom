<?php include_once("../Menu/HeaderAdmin.php");
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
if(isset($_GET['Search'])) { $s_date=$_GET['s_date']; $e_date=$_GET['e_date'];}
?>
<link href="../css/SpitechStyle.css" rel="stylesheet" type="text/css" />
<center>
<h1><img src="../SpitechImages/Reports.png" width="31" height="32" />
Report  : <span> Daily Collection</span>
<A style="float:right; margin-right:30px;" onclick="<?php ShowHide("FindForm","block"); ?>"><img src="../SpitechImages/FindIcon.png" />Search</A>
</h1>
<table width="100%" border="0" cellspacing="0" cellpadding="0" id="Content">
  <tr>
    <td>
     <form name="FindForm" id="FindForm" method="get" style="display:<?php if(isset($_GET['Search'])) { echo "block;"; } else { echo "none;"; };?>">
      <table width="98%" border="0" cellspacing="0" cellpadding="0" id="SearchTable" style="margin-top:5px;">
      <tr>
        <td width="5%">PROJECT</td>
        <td width="17%">
          <select id="payment_project_id" name="payment_project_id" >
            <option value="All">ALL PROJECT...</option>
            <?php              $PROJECT_Q=@mysqli_query($_SESSION['CONN'],"select project_id, project_name from tbl_project ");
             while($PROJECT_ROWS=@mysqli_fetch_assoc($PROJECT_Q)) 
             {?>
            <option value="<?php echo $PROJECT_ROWS['project_id']?>" <?php SelectedSelect($PROJECT_ROWS['project_id'],$_GET['payment_project_id']);?>>
              <?php echo $PROJECT_ROWS['project_name']?>
              </option>
            <?php } ?>
            </select></td>
        <td width="7%"><?php echo advisor_title?></td>
        <td width="17%"><select id="payment_advisor_id" name="payment_advisor_id" >
          <option value="All">ALL
            <?php echo advisor_title?>
            ...</option>
          <?php 		$ADVISOR_Q="SELECT advisor_id, advisor_code, advisor_name FROM tbl_advisor ORDER BY advisor_name";
			    $ADVISOR_Q=@mysqli_query($_SESSION['CONN'],$ADVISOR_Q);
			   while($ADVISOR_ROWS=@mysqli_fetch_assoc($ADVISOR_Q)) {?>
          <option value="<?php echo $ADVISOR_ROWS['advisor_id'];?>" <?php SelectedSelect($ADVISOR_ROWS['advisor_id'], $_GET['payment_advisor_id']); ?>> <?php echo $ADVISOR_ROWS['advisor_name']." [".$ADVISOR_ROWS['advisor_code']." ]";?></option>
          <?php } ?>
          </select></td>
        <td width="4%">from</td>
        <td width="25%" class="Date"><script>DateInput('s_date',true, 'yyyy-mm-dd','<?php echo $s_date?>');</script></td>
        <td width="5%">TO</td>
        <td width="4%" class="Date"><script>DateInput('e_date',true, 'yyyy-mm-dd','<?php echo $e_date?>');</script></td>
        <td width="8%"><input type="submit" name="Search" value=" " id="Search" /></td>
        
        <td width="8%"><input type="button" name="ShowAll" value="Show All" id="ShowAll" class="Button"  onclick="window.location='Report_Collection_Daily.php'" style="width:80px;"/></td>
      </tr>
      </table>

  </form>
     <table  width="100%"  cellspacing="1" id="Data-Table" style="margin:0PX; width:100%; padding:0px;">
       <tr  >
        <th width="2%" height="27" rowspan="2" >#</th>
        <th width="6%" rowspan="2" >VOUCHER NO</th>
        <th width="6%" rowspan="2" >ORDER</th>
        <th width="6%" rowspan="2" >PARTICULAR</th>
        <th colspan="2" >&nbsp;DATE</th>
        <th width="10%" rowspan="2" >PROJECT&nbsp;NAME </th>
        <th colspan="2" rowspan="2" >PROPERTY</th>
        <th colspan="2" >CUSTOMER&nbsp;details</th>
        <th colspan="2" >BOOKED&nbsp;BY&nbsp;<?php echo advisor_title?></th>
        <th width="5%" rowspan="2" >COLLECTION</th>
        </tr>
      <tr  >
        <th width="5%" >PAYMENT</th>
        <th width="5%" >BOOKING</th>
        <th width="19%" >name</th>
        <th width="6%" >id</th>
        <th width="17%" >name</th>
        <th width="5%" >id</th>
      </tr>
      <?php      	$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);	
		if(isset($_GET["limit"]))	{ $limit = $_GET["limit"];	}	else	{	$limit = 100;	}
		$startpoint = ($page * $limit) - $limit;		
		if(isset($_GET["page"])) { $k=($page-1)*($limit)+1; }	else $k=1;
		//----------------------------------------------------------		
		$PAYMENT_QUERY="select * from tbl_property_booking_payments where approved='1' ";
		if(isset($_GET['Search']))
		{
			if($_GET['payment_project_id']!="All") 		{ $PAYMENT_QUERY.=" and payment_project_id='".$_GET['payment_project_id']."'";		}		
			if($_GET['payment_advisor_id']!="All") 	    { $PAYMENT_QUERY.=" and payment_advisor_id ='".$_GET['payment_advisor_id']."' "; 	  }		
			
		}
	    $PAYMENT_QUERY.=" and payment_date between '$s_date' and '$e_date' ";	
		$PAGINATION_QUERY=$PAYMENT_QUERY."  order by payment_date desc, payment_id desc ";
		$PAYMENT_QUERY=$PAGINATION_QUERY."  LIMIT {$startpoint} , {$limit}";	
		$PAYMENT_QUERY=@mysqli_query($_SESSION['CONN'],$PAYMENT_QUERY);	  
		$RECORD_FOUND=@mysqli_num_rows($PAYMENT_QUERY);

while($PAYMENT_ROWS=@mysqli_fetch_assoc($PAYMENT_QUERY)) 
{
	$BOOKING_ROWS=$DBOBJ->GetRow("tbl_property_booking","booking_id",$PAYMENT_ROWS["payment_booking_id"]);
	?>
      <tr >
        <td height="22" ><div align="center"><?php echo $k++ ; ?></div></td>
        <td><div align="center"><?php echo $PAYMENT_ROWS['payment_voucher_no'];?></div></td>
        <td><div align="center"><?php echo $PAYMENT_ROWS['payment_order_no'];?></div></td>
        <td><div align="center"><?php echo $PAYMENT_ROWS['payment_heading'];?></div></td>
        <td><div align="center" style="width:60px;"><?php echo date('d-m-Y',strtotime($PAYMENT_ROWS['payment_date']));?></div></td>       
        <td><div align="center" style="width:60px;"><?php echo date('d-m-Y',strtotime($BOOKING_ROWS['booking_date']));?></div></td>        
        <td><?php echo $DBOBJ->ConvertToText("tbl_project","project_id","project_name",$PAYMENT_ROWS['payment_project_id']);?></td>
        <td width="3%"><div align="center"><?php echo $DBOBJ->PropertyTypeName($PAYMENT_ROWS['payment_property_id']);?></div></td>
        <td width="5%"><div align="center"><?php echo $DBOBJ->ConvertToText("tbl_property","property_id","property_no",$PAYMENT_ROWS['payment_property_id']);?></div></td>
        <td><?php echo $DBOBJ->ConvertToText("tbl_customer","customer_id","customer_name",$PAYMENT_ROWS['payment_customer_id']);?></td>
        <td><div align="center" style="width:70px;"><?php echo $DBOBJ->ConvertToText("tbl_customer","customer_id","customer_code",$PAYMENT_ROWS['payment_customer_id']);?></div></td>
        <td><?php echo $DBOBJ->ConvertToText("tbl_advisor","advisor_id","advisor_name",$PAYMENT_ROWS['payment_advisor_id']);?></td>
        <td><div align="center" style="width:60px;"><?php echo $DBOBJ->ConvertToText("tbl_advisor","advisor_id","advisor_code",$PAYMENT_ROWS['payment_advisor_id']);?></div></td>
        <td><div align="right"><?php echo @number_format($PAYMENT_ROWS['payment_amount'],2); $TOTAL_COLLECTION+=$PAYMENT_ROWS['payment_amount'];?></div></td>
        </tr>
      <?php } ?>
      <tr  >
        <th height="22" colspan="13" ><div align="right">TOTAL</div></th>
        <th height="22" ><div align="right"><?php echo @number_format($TOTAL_COLLECTION,2);?></div></th>
        </tr>
     
</table>
   
     <div class="paginate" ><?php pagination($PAGINATION_QUERY,$limit,$page, url());  ?></div>
   
    </td>
  </tr>
</table>
</center>
<script>
function Calc()
{
	
	var bal=parseFloat(document.getElementById('Received').value)-parseFloat(document.getElementById('refund_amount').value);
	
	document.getElementById('not_refund').value=bal.toFixed(2);
	document.getElementById('Ref').innerHTML=-(parseFloat(document.getElementById('refund_amount').value)).toFixed(2);
	
}
</script>
<?php include("../Menu/Footer.php"); ?>
