<?php
include_once("../Menu/HeaderAdmin.php");
include_once("../php/SpitechDB.php");
include_once("../php/SpitechUtility.php");
include_once("../php/SpitechPagination.php");
include_once("../php/SpitechJS.php");
Menu("Advisor");
NoUser();
RefreshPage(3);
$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();

?>
<link href="../css/SpitechStyle.css" rel="stylesheet" type="text/css" />
<center>
<h1><img src="../SpitechImages/Advisor.png" width="31" height="32" /><?php echo advisor_title?>  : <span> Comission Payment Status</span>
<A style="float:right; margin-right:30px;" onclick="<?php ShowHide("FindForm","block"); ?>" ><img src="../SpitechImages/FindIcon.png" />Search</A>
</h1>
<table width="100%" border="0" cellspacing="0" cellpadding="0" id="Content">
  <tr>
    <td>
    <center>
     <?php ErrorMessage(); ?>
     <form name="FindForm" id="FindForm" method="get" style="display:<?php if(isset($_GET['Search'])) { echo "block;"; } else { echo "none;"; };?>">
      <table width="98%" border="0" cellspacing="0" cellpadding="0" id="SearchTable" style="margin-top:5px;">
      <tr>
      <TD><?php echo advisor_title?></TD>
        <td width="16%">
          <select name="advisor_id" id="advisor_id" >
            <option value="All">All <?php echo advisor_title?>...</option> 
            <?php 
			   $SPONSOR_Q="SELECT advisor_id, advisor_code, advisor_name FROM tbl_advisor ORDER BY advisor_name";
			   $SPONSOR_Q=@mysqli_query($_SESSION['CONN'],$SPONSOR_Q);
			   while($SPONSOR_ROWS=@mysqli_fetch_assoc($SPONSOR_Q)) {?>
            <option value="<?php echo $SPONSOR_ROWS['advisor_id'];?>" <?php SelectedSelect($SPONSOR_ROWS['advisor_id'], $_GET['advisor_id']); ?>>
              <?php echo $SPONSOR_ROWS['advisor_name']." [".$SPONSOR_ROWS['advisor_code']." ]";?>
              </option>
            <?php } ?>       
          </select></td>
        <td width="4%">LEVEL</td>
        <td width="33%">
        
          
        <select name="advisor_level_id" id="advisor_level_id" style="width:100px;">
          <option value="All">All Lavel...</option>
          <?php 
			   $LEVEL_Q="SELECT level_id, level_name FROM tbl_setting_advisor_level ORDER BY level_id";
			   $LEVEL_Q=@mysqli_query($_SESSION['CONN'],$LEVEL_Q);
			   while($LEVEL_ROWS=@mysqli_fetch_assoc($LEVEL_Q)) {?>
           <option value="<?php echo $LEVEL_ROWS['level_id'];?>" <?php SelectedSelect($LEVEL_ROWS['level_id'], $_GET['advisor_level_id']); ?>>
           <?php echo $LEVEL_ROWS['level_name'];?> </option>
           <?php } ?>
        </select></td>
        <td width="23%">
        <input type="submit" name="Search" value=" " id="Search" /></td>
        <td width="24%">
        <input type="button" name="ShowAll" value="Show All" id="ShowAll" class="Button"  onclick="window.location='Advisor_Commission_Status.php'" style="width:80px;"/></td>
      
      </tr>
     
      </table>

  </form>
    <table width="98%" border="0" cellspacing="1" cellpadding="0" id="Data-Table" >
      <tr>
    <th width="2%" rowspan="2">#</th>
    <th width="3%" rowspan="2"><div align="center" style="width:70px;">ID&nbsp;CODE</div></th>
    <th width="17%" rowspan="2">NAME</th>
    <th width="7%" rowspan="2">LEVEL</th>
    <th colspan="2">SPONSOR</th>
    <th colspan="3">CONTACT DETAILS</th>
    <th width="7%" rowspan="2">commission till&nbsp;now</th>
    <th width="7%" rowspan="2">paid till&nbsp;now</th>
    <th width="7%" rowspan="2">balance till&nbsp;now</th>
  </tr>
      <tr>
        <th width="16%">NAME</th>
        <th width="7%">ID&nbsp;CODE</th>
        <th width="4%">MOBILE</th>
        <th width="4%">PHONE</th>
        <th width="16%">EMAIL</th>
      </tr>
  <?php

		$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);	
		if(isset($_GET["limit"]))	{ $limit = $_GET["limit"];	}	else	{	$limit = 50;	}
		$startpoint = ($page * $limit) - $limit;		
		if(isset($_GET["page"])) { $k=($page-1)*($limit)+1; }	else $k=1;
		//----------------------------------------------------------		
		$ADVISOR_QUERY="select * from tbl_advisor where 1 ";
		if(isset($_GET['Search']))
		{
			if($_GET['advisor_id']!="All") 		     { $ADVISOR_QUERY.=" and advisor_id like '".$_GET['advisor_id']."' ";       }			
			if($_GET['advisor_level_id']!="All")	{ $ADVISOR_QUERY.=" and advisor_level_id ='".$_GET['advisor_level_id']."' "; }
		}
	    
		$PAGINATION_QUERY=$ADVISOR_QUERY."  order by advisor_name ";
		$ADVISOR_QUERY=$PAGINATION_QUERY."  LIMIT {$startpoint} , {$limit}";	
		$ADVISOR_QUERY=@mysqli_query($_SESSION['CONN'],$ADVISOR_QUERY);	  
		$RECORD_FOUND=@mysqli_num_rows($ADVISOR_QUERY);

while($ADVISOR_ROWS=@mysqli_fetch_assoc($ADVISOR_QUERY)) 
{
	$ADVISOR_ID=$ADVISOR_ROWS['advisor_id'];
	
	$NETT_COM=$DBOBJ->AdvisorNetCommission($ADVISOR_ID,"1970-01-01",date('Y-m-d'));
	$PAID=$DBOBJ->AdvisorTotalPaid($ADVISOR_ID,"1970-01-01",date('Y-m-d'));
	$BAL=$NETT_COM-$PAID;
	
	//==============( TOTAL CALCULATION )=================
	$TOTAL_NETT_COM+=$NETT_COM;
	$TOTAL_PAID+=$PAID;
	$TOTAL_BAL+=$BAL;
?>
  <tr>
    <td><div align="center"><?php echo $k++;?>.</div></td>
    <td ><div align="center"><?php echo $ADVISOR_ROWS['advisor_code']; ?></div></td>
    <td ><div align="left"  style="width:200PX;"><?php echo $ADVISOR_ROWS['advisor_name']; ?></div></td>
    <td >
    <div align="center" style="width:80PX;">
	   <?php echo $DBOBJ->ConvertToText("tbl_setting_advisor_level","level_id","level_name",$ADVISOR_ROWS['advisor_level_id']); ?>
    </div>
    </td>
    <td >
    <div align="LEFT" style="width:200PX;">
	<?php echo $DBOBJ->ConvertToText("tbl_advisor","advisor_id","advisor_name",$ADVISOR_ROWS['advisor_sponsor']); ?>
    </div>
    </td>
    <td >
    <div align="center" style="width:80PX;">
	<?php echo $DBOBJ->ConvertToText("tbl_advisor","advisor_id","advisor_code",$ADVISOR_ROWS['advisor_sponsor']); ?>
    </div>
    </td>
    <td><div align="center"><?php echo $ADVISOR_ROWS['advisor_mobile']; ?></div></td>
    <td><div align="center"><?php echo $ADVISOR_ROWS['advisor_phone']; ?></div></td>
    <td><div align="left" style="text-transform:none;"><?php echo $ADVISOR_ROWS['advisor_email']; ?></div></td>
    <td><div align="right"><?php echo @number_format($NETT_COM,2);?></div></td>
    <td><div align="right"><?php echo @number_format($PAID,2);?></div></td>
    <td><div align="right"><?php echo @number_format($BAL,2);?></div></td>
  </tr>
 
  <?php } ?>  
<tr><th colspan="9"><div align="right">TOTAL CALCULATION</div></th>
  <th style="text-align:right;"><?php echo @number_format($TOTAL_NETT_COM,2);?></th>
  <th style="text-align:right;"><?php echo @number_format($TOTAL_PAID,2);?></th>
  <th style="text-align:right;"><?php echo @number_format($TOTAL_BAL,2);?></th>
</tr>
</table>
 <div class="paginate" ><?php pagination($PAGINATION_QUERY,$limit,$page, url());  ?></div>

</center>
    </td>
  </tr>
</table>
</center>
<?php 
if(isset($_GET[md5("advisor_delete_id")]) && $_GET[md5("advisor_delete_id")]!="1")
{
	NoAdmin();
	$DELETE_ROW=$DBOBJ->GetRow("tbl_advisor","advisor_id",$_GET[md5("advisor_delete_id")]);	
	
	$Fields=array("advisor_sponsor");
	$Values=array($DELETE_ROW['advisor_sponsor']);
	$UPDATE=$DBOBJ->Update("tbl_advisor",$Fields,$Values,"advisor_id",$_GET[md5("advisor_delete_id")],"0");
    
	 //====================( UPDATING PROPERTY STATUS )==========================================================
		$FIELDS=array("property_status");
		$FIELDS=array("Available");
		$Q="UPDATE tbl_property SET property_status='Available' WHERE 
			property_id IN(SELECT booking_property_id FROM tbl_property_booking 
				WHERE booking_advisor_id='".$_GET[md5("advisor_delete_id")]."'
				AND booking_cancel_status!='Yes')";
		@mysqli_query($_SESSION['CONN'],$Q);				
    //====================( END UPDATING PROPERTY STATUS )=====================================================
	
	@mysqli_query($_SESSION['CONN'],"Delete From tbl_advisor where advisor_id='".$_GET[md5("advisor_delete_id")]."'");	
	@mysqli_query($_SESSION['CONN'],"Delete From tbl_property_booking where booking_advisor_id='".$_GET[md5("advisor_delete_id")]."'");	
	@mysqli_query($_SESSION['CONN'],"Delete From tbl_property_booking_cancelled where booking_advisor_id='".$_GET[md5("advisor_delete_id")]."'");	
	@mysqli_query($_SESSION['CONN'],"Delete From tbl_property_booking_deleted where booking_advisor_id='".$_GET[md5("advisor_delete_id")]."'");	
	@mysqli_query($_SESSION['CONN'],"Delete From tbl_property_booking_payments where  payment_advisor_id='".$_GET[md5("advisor_delete_id")]."'");
	@mysqli_query($_SESSION['CONN'],"Delete From tbl_advisor_commission where commission_advisor_id='".$_GET[md5("advisor_delete_id")]."'");
	@mysqli_query($_SESSION['CONN'],"Delete From tbl_advisor_commission where commission_by_advisor_id='".$_GET[md5("advisor_delete_id")]."'");
	@mysqli_query($_SESSION['CONN'],"Delete From tbl_advisor_payment where payment_advisor_id='".$_GET[md5("advisor_delete_id")]."'");
 
    @unlink('../SpitechUploads/advisor/advisor_photo/'.$DELETE_ROW['advisor_photo']);
	

	$DBOBJ->UserAction("ADVISOR DELETED","ID=".$_GET[md5("advisor_delete_id")].", NAME : ".$DELETE_ROW['advisor_name']);	
	header("location:Advisor.php?Message=Associate : ".$DELETE_ROW['advisor_name']." Deleted.");	
}
include("../Menu/Footer.php"); 
?>
