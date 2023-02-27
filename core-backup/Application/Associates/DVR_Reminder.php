<?php
 include_once("../Menu/HeaderAdvisor.php");
 Menu("DVR");
	$DBOBJ = new DataBase();
	$DBOBJ->ConnectDatabase();

	$s_date=date('2000-01-01');	
	$e_date=NextDate(date('Y-m-d'),+0);	
	if(isset($_GET['Search']))
	{
		$s_date=$_GET['s_date']; 	
	    $e_date=$_GET['e_date'];	
	}
	
?>
<link href="../css/SpitechStyle.css" rel="stylesheet" type="text/css" /> 
 <style>
	 #Data-Table #white td { background:#fff; }
	 #Data-Table #red td { background:#CEFFE7; }	
	</style>

<h1><img src="../SpitechImages/DVR_Reminder.png" />DVR : <span>Reminder</span></h1>

<table width="100%" border="0" align="center" cellspacing="0" cellpadding="0" id="Content">
  <tr>
    <td >
    <?php ErrorMessage(); ?>
    <form name="FindForm" id="FindForm" method="get" >
   
      <table width="98%" border="0" cellspacing="0" cellpadding="0" id="SearchTable" class="SearchTable" style="margin-top:5px;">
        <tr>
          
          <td width="4%">FROM</td>
          <td width="3%" class="Date"><script>DateInput('s_date', true, 'yyyy-mm-dd','<?php echo $s_date; ?>');</script></td>
          <td width="3%">TO</td>
          <td width="4%" class="Date"><script>DateInput('e_date', true, 'yyyy-mm-dd','<?php echo $e_date; ?>');</script></td>
          <TD width="4%">STATUS</TD>
          <TD width="16%">
          <select name="status" id="status">
            <option value="All">All Status...</option>
            <option value="Enable" <?php SelectedSelect("Enable",$_GET['status']); ?>>Enable</option>
            <option value="Disable" <?php SelectedSelect("Disable",$_GET['status']); ?>>Disable</option>
            <option value="Booked" <?php SelectedSelect("Booked",$_GET['status']); ?>>Booked</option>
          </select>
          </TD>
          <td width="8%"><input type="submit" name="Search" value=" " id="Search" /></td>
          <td width="36%"><input type="button" name="All" value="Show All" class="Button" onclick="window.location='DVR_Reminder.php';" /></td>
        </tr>
      </table>
    </form>
    <table width="98%" border="0" cellspacing="1" cellpadding="0" id="Data-Table">
      <tr>
        <th width="21">#</th>
        <th width="67">DATE</th>
        <th width="67">REMIND&nbsp;ON</th>
        <th>CUSTOMER</th>
        <th>MOBILE</th>
        <th>PROJECT</th>
        <th>PROPERTY</th>
        <th width="437">REMARKS</th>
        <th width="41">Status</th>
        <th width="52">ACTION</th>
      </tr>
      <?php

		$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);	
		if(isset($_GET["limit"]))	{ $limit = $_GET["limit"];	}	else	{	$limit = 100;	}
		$startpoint = ($page * $limit) - $limit;		
		if(isset($_GET["page"])) { $k=($page-1)*($limit)+1; }	else $k=1;
		//----------------------------------------------------------		
		$ENQ_QUERY="select * from tbl_advisor_dvr where advisor_id='".$_SESSION['advisor_id']."' ";
	    
		if(!isset($_GET['Search'])) { $ENQ_QUERY.=" and status='Enable' "; }
		
		if(isset($_GET['Search']))		{			
			
			if($_GET['status']!="All") 		   { $ENQ_QUERY.=" and status ='".$_GET['status']."'"; 	            }				
		}
		
	    $ENQ_QUERY.=" and remind_date between '".$s_date."' and '".$e_date."' ";	
        $PAGINATION_QUERY=$ENQ_QUERY."  order by remind_date desc, dvr_id desc ";
		$ENQ_QUERY=$PAGINATION_QUERY."  LIMIT {$startpoint} , {$limit}";	
		$ENQ_QUERY=@mysqli_query($_SESSION['CONN'],$ENQ_QUERY);	  
		$RECORD_FOUND=@mysqli_num_rows($ENQ_QUERY);

while($ENQ_ROWS=@mysqli_fetch_assoc($ENQ_QUERY)) 
{
	
			$id='red';
		
			if($ENQ_ROWS['status']=="Enable")
			{
				$id='white';
			}
			else if($ENQ_ROWS['status']=="Booked")
			{
				$id='yellow';
			}
?>
      <tr id="<?php echo $id?>">
        <td><div align="center"><?php echo $k++;?>.</div></td>
        <td><div align="center" style="width:65px;"><?php echo date('d-M-Y',strtotime($ENQ_ROWS['dvr_date'])); ?></div></td>
        <td><div align="center" style="width:65px;"><?php echo date('d-M-Y',strtotime($ENQ_ROWS['remind_date'])); ?></div></td>
        <td width="252"><?php echo $ENQ_ROWS['customer_name'];?></td>
        <td width="64" style="text-align:center"><?php echo $ENQ_ROWS['mobile_no'];?></td>
        <td width="187" style="text-align:left"><?php echo $DBOBJ->ConvertToText("tbl_project","project_id","project_name",$ENQ_ROWS["project_id"])?></td>
        <td width="82" style="text-align:center"><?php echo $DBOBJ->ConvertToText("tbl_property","property_id","property_no",$ENQ_ROWS["property_id"])?></td>
        <td width="437"><?php echo $ENQ_ROWS['remarks'];?></td>
        <td width="41" style="text-align:center"><?php echo $ENQ_ROWS['status'];?></td>
        <td><div align="center" style="width:50px;">
       
        <a id="Report" <?php Modal("DVR_View.php?".md5("dvr_id")."=".$ENQ_ROWS['dvr_id'],"950px", "500px", "500px", "100px"); ?> title="View  DVR Details">&nbsp;&nbsp;</a>
       
        <a id="Edit" <?php Modal("DVR_New.php?".md5("edit_id")."=".$ENQ_ROWS['dvr_id'],"1000px", "700px", "350px", "100px"); ?> title="Edit  DVR Details">&nbsp;</a>
        
       <!-- <a id="Delete" href="DVR.php?<?php echo md5("dvr_delete_id")."=".$ENQ_ROWS['dvr_id']; ?>" <?php Confirm("Are You Sure ? Delete This Expense Entry ? "); ?>  title="Delete DVR ">&nbsp;</a>-->
       
       </div>
        
        </td>
      </tr>
      <?php } ?>
    </table>    <div align="right" class="paginate"><?php pagination($PAGINATION_QUERY,$limit,$page, url('DVR_Reminder.php'));  ?></div>
           
      </td>
  </tr>
</table>
<?php 
if($_GET[md5("dvr_delete_id")]>0)
{
	CheckAdvisor("tbl_advisor_dvr","dvr_id",$_GET[md5("dvr_delete_id")]);
    $DELETE_ROW=$DBOBJ->GetRow("tbl_advisor_dvr","dvr_id",$_GET[md5("dvr_delete_id")]);
	
	//@mysqli_query($_SESSION['CONN'],"Delete From tbl_advisor_dvr where dvr_id='".$_GET[md5("dvr_delete_id")]."' ");	
    //$DBOBJ->UserAdvisorAction("DVR DELETED", " ID : ".$_GET[md5("dvr_delete_id")].", CUSTOMER : ".$DELETE_ROW['customer_name']);
	//header("location:DVR_Reminder.php?Message=Selected DVR Have Been Deleted Successfully.");	
}
include("../Menu/Footer.php"); 

?>
