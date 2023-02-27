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
RefreshPage(5);
?>
<link href="../css/SpitechStyle.css" rel="stylesheet" type="text/css" />
<center>
<h1><img src="../SpitechImages/Project.png" width="31" height="32" />Project  : <span>Master List</span>
<A style="float:right; margin-right:30px;" onclick="<?php ShowHide("FindForm","block"); ?>" ><img src="../SpitechImages/FindIcon.png" />Search</A>
</h1>
<table width="100%" border="0" cellspacing="0" cellpadding="0" id="Content">
  <tr>
    <td>
    <center>
     <?php ErrorMessage(); ?>
     <form name="FindForm" id="FindForm" method="get" style="display:<?php if(isset($_GET['Search'])) { echo "block;"; } else { echo "none;"; };?>">
      <table width="98%" border="0" cellspacing="0" cellpadding="0" id="CommonTable" style="margin-top:5px;">
      <tr>
        <td width="7%">project&nbsp;Name</td>
        <td width="9%"><input type="text" id="project_name" name="project_name"  placeholder="NAME" maxlength="50"/></td>
        <td width="0%">&nbsp;</td>
        <td width="1%">&nbsp;</td>
        <td width="8%">
          <input type="submit" name="Search" value=" " id="Search" /></td>
        <td width="75%">
        <input type="button" name="ShowAll" value="Show All" id="ShowAll" class="Button"  onclick="window.location='Projects.php'" style="width:80px;"/></td>
      
      </tr>
     
      </table>

  </form>
    <table width="98%" border="0" cellspacing="1" cellpadding="0" id="Data-Table" >
      <tr>
        <th width="2%">#</th>
        <th width="16%">PROJECT NAME</th>
        <th width="18%">PHOTO</th>
        <th width="15%">ADDRESS</th>
        <th width="9%">MAUZA</th>
        <th width="8%">P.H. NO</th>
        <th width="21%">PROPERTY&nbsp;BOOKING&nbsp;STATUS</th>
        <th colspan="2" class="Action">ACTION</th>
      </tr>
  <?php

		$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);	
		if(isset($_GET["limit"]))	{ $limit = $_GET["limit"];	}	else	{	$limit = 10;	}
		$startpoint = ($page * $limit) - $limit;		
		if(isset($_GET["page"])) { $k=($page-1)*($limit)+1; }	else $k=1;
		//----------------------------------------------------------		
		$PROJECTS_QUERY="select * from tbl_project where 1 ";
		if(isset($_GET['Search']))
		{
			if($_GET['project_name']!="") 		{ $PROJECTS_QUERY.=" and project_name like '%".$_GET['project_name']."%' "; }			
		}
	    
		$PAGINATION_QUERY=$PROJECTS_QUERY."  order by project_name ";
		$PROJECTS_QUERY=$PAGINATION_QUERY."  LIMIT {$startpoint} , {$limit}";	
		$PROJECTS_QUERY=@mysqli_query($_SESSION['CONN'],$PROJECTS_QUERY);	  
		$RECORD_FOUND=@mysqli_num_rows($PROJECTS_QUERY);

while($PROJECTS_ROWS=@mysqli_fetch_assoc($PROJECTS_QUERY)) {
?>
  <tr>
    <td height="79"><div align="center"><?php echo $k++;?>.</div></td>
    <td ><div align="left"  style="width:200PX;"><?php echo $PROJECTS_ROWS['project_name']; ?></div></td>
    <td style="padding:0px; margin:0px; text-align:center">
       
	   <?php $ACTUAL_PHOTO="../SpitechUploads/project/project_photo/".$PROJECTS_ROWS['project_photo'];
		  $exist=file_exists($ACTUAL_PHOTO);
		  if($exist!="1" || $PROJECTS_ROWS['project_photo']=="") { $ACTUAL_PHOTO="../SpitechImages/Project.png"; }?>
         
       <script>ShowModalImage("img<?php echo $PROJECTS_ROWS['project_id']; ?>","600px","<?php echo $ACTUAL_PHOTO;?>","<?php echo $PROJECTS_ROWS['project_name']; ?>");</script>
       
         <a><img src="<?php echo $ACTUAL_PHOTO;?>" width="216" height="76" id="img<?php echo $PROJECTS_ROWS['project_id']; ?>" style="border:5px solid white; margin:0px; padding:0px; background:white;" alt="<?php echo $PROJECTS_ROWS['project_name']; ?>"/></a>	
    
    </td>
    <td ><?php echo $PROJECTS_ROWS['project_address']; ?></td>
    <td><div align="center"><?php echo $PROJECTS_ROWS['project_mouza']; ?></div></td>
    <td><div align="center"><?php echo $PROJECTS_ROWS['project_ph_no']; ?></div></td>
    <td style="margin:0PX; padding:0PX;" title="GO TO PROPERTY STATUS : MANAGE PROPERTY">
  
  <a href="Project_Property_List.php?59e44ca42d29905abb975e30629358a5=<?php echo $PROJECTS_ROWS['project_id']?>&6bb837ff883acdc4bdbb81bde53c90e8=All&aebbaf22d913e94823925981e463f9b6=All&8718fee4175fa7947c3f26d7025fea52=All&Search=+">
  <table width="98%" border="0" cellspacing="1" cellpadding="0" id="SmallTable" style="margin:5PX; width:200PX;;"> 
  <tr>
    <th width="10%">type</th>
    <th width="29%" style="background:GREEN">AVAILABLE</th>
    <th width="20%" style="background:RED">BOOKED</th>
    <th width="20%" style="background:ORANGE;color:BLACK">TEMP</th>
    <th width="21%" style="background:LIGHTGREEN; color:BLACK">HOLD</th>
    <th width="21%">total</th>
  </tr> 
 
    <?php 	$TOTAL_AVAILABLE=0;
	$TOTAL_BOOKED=0;
	$TOTAL_TEMP_BOOKED=0;
	$TOTAL_HOLD=0;
	$TOTAL_ROW_COUNT_TOTAL=0;
	
	$TYPE_Q=@mysqli_query($_SESSION['CONN'],"select property_type_id, property_type from tbl_setting_property_type where property_type_id in (select project_property_type_id from tbl_project_details where project_id='".$PROJECTS_ROWS['project_id']."')");
	 while($TYPE_ROWS=@mysqli_fetch_assoc($TYPE_Q)) 
	 {
		 //==============(AVAILABLE)========================
		 $AVAILABLE=@mysqli_query($_SESSION['CONN'],"SELECT COUNT(property_id) AS TOTAL_AVAILABLE FROM tbl_property where property_status='Available' and property_project_id='".$PROJECTS_ROWS['project_id']."' and property_type_id='".$TYPE_ROWS['property_type_id']."' ");
		 $AVAILABLE=@mysqli_fetch_assoc($AVAILABLE);
		 $AVAILABLE=$AVAILABLE['TOTAL_AVAILABLE'];$TOTAL_AVAILABLE+=$AVAILABLE;
		  //==============(TEMP BOOKED)========================
		 $TEMP_BOOKED=@mysqli_query($_SESSION['CONN'],"SELECT COUNT(property_id) AS TOTAL_TEMP_BOOKED FROM tbl_property where property_status='TempBooked' and property_project_id='".$PROJECTS_ROWS['project_id']."'  and property_type_id='".$TYPE_ROWS['property_type_id']."'");
		 $TEMP_BOOKED=@mysqli_fetch_assoc($TEMP_BOOKED);
		 $TEMP_BOOKED=$TEMP_BOOKED['TOTAL_TEMP_BOOKED'];$TOTAL_TEMP_BOOKED+=$TEMP_BOOKED;
		  //==============(BOOKED)========================
		 $BOOKED=@mysqli_query($_SESSION['CONN'],"SELECT COUNT(property_id) AS TOTAL_BOOKED FROM tbl_property where property_status='Booked' and property_project_id='".$PROJECTS_ROWS['project_id']."'  and property_type_id='".$TYPE_ROWS['property_type_id']."'");
		 $BOOKED=@mysqli_fetch_assoc($BOOKED);
		 $BOOKED=$BOOKED['TOTAL_BOOKED'];$TOTAL_BOOKED+=$BOOKED;
		  //==============(HOLD)========================
		 $HOLD=@mysqli_query($_SESSION['CONN'],"SELECT COUNT(property_id) AS TOTAL_HOLD FROM tbl_property where property_status='Hold' and property_project_id='".$PROJECTS_ROWS['project_id']."'  and property_type_id='".$TYPE_ROWS['property_type_id']."'");
		 $HOLD=@mysqli_fetch_assoc($HOLD);
		 $HOLD=$HOLD['TOTAL_HOLD']; $TOTAL_HOLD+=$HOLD;
		 //=================(every row total)=============================
		 $TOTAL_ROW_COUNT=$AVAILABLE+$BOOKED+$TEMP_BOOKED+$HOLD;
		 $TOTAL_ROW_COUNT_TOTAL+=$TOTAL_ROW_COUNT;
		 ?>
  <tr>
    <td><?php echo $TYPE_ROWS['property_type'];?></td>
    <td style="background:GREEN; color:WHITE;"><div align="center"><?php echo $AVAILABLE?></div></td>
    <td style="background:RED; color:WHITE;"><div align="center"><?php echo $BOOKED?></div></td>
    <td style="background:ORANGE"><div align="center"><?php echo $TEMP_BOOKED?></div></td>
    <td style="background:LIGHTGREEN"><div align="center"><?php echo $HOLD?></div></td>
    <td><div align="center"><?php echo $TOTAL_ROW_COUNT?></div></td>
  </tr>
  <?php } ?>
  <tr>
    <tH>TOTAL</tH>
    <tH style="background:GREEN"><div align="center"><?php echo $TOTAL_AVAILABLE?></div></tH>
    <tH style="background:RED"><div align="center"><?php echo $TOTAL_BOOKED?></div></tH>
    <tH style="background:ORANGE; color:BLACK"><div align="center"><?php echo $TOTAL_TEMP_BOOKED?></div></tH>
    <tH style="background:LIGHTGREEN; color:BLACK;"><div align="center"><?php echo $TOTAL_HOLD?></div></tH>
    <tH><div align="center"><?php echo $TOTAL_ROW_COUNT_TOTAL?></div></tH>
    </tr>
</table>
</a>
    </td>
    <td width="6%" class="Action"><div align="center" style="width:70px;"> 
      
      <a id="Edit" <?php Modal("Project_New.php?".md5('edit_id')."=".$PROJECTS_ROWS['project_id'],"700px", "1000px", "300px", "100px");?> title="Edit Project Details : <?php echo $PROJECTS_ROWS['project_name']; ?>">&nbsp;</a> 
      
     
      <a id="Delete" href="Projects.php?<?php echo md5("project_delete_id")."=".$PROJECTS_ROWS['project_id']; ?>" <?php Confirm("Are You Sure ? Delete Associate ? ".$PROJECTS_ROWS['project_name']." ? "); ?>  title="Delete Project Details : <?php echo $PROJECTS_ROWS['project_name']; ?>">&nbsp;</a></div>
     
    </td>
    <td width="5%" style="text-align:center" title="Add New Property To Project : <?php echo $PROJECTS_ROWS['project_name']; ?>" class="Action">
       
        <a href="<?php echo "Project_Property_Add.php?".md5("project_id")."=".$PROJECTS_ROWS['project_id']."&".md5("Rows")."=5&".md5("Open")."=".md5("Open");?>">
        <img src="../SpitechImages/PropertyNew.png" /> Add&nbsp;Property</a>
        
    </td>
  </tr>
  <?php } ?>
</table>
 <div class="paginate" ><?php pagination($PAGINATION_QUERY,$limit,$page, url());  ?></div>

</center>
    </td>
  </tr>
</table>
</center>
<?php 
if(isset($_GET[md5("project_delete_id")]))
{
	NoAdmin();
	$DELETE_ROW=$DBOBJ->GetRow("tbl_project","project_id",$_GET[md5("project_delete_id")]);	
	
	@mysqli_query($_SESSION['CONN'],"Delete From tbl_project where project_id='".$_GET[md5("project_delete_id")]."'");	
	@mysqli_query($_SESSION['CONN'],"Delete From tbl_project_details where project_id='".$_GET[md5("project_delete_id")]."'");	
	@mysqli_query($_SESSION['CONN'],"Delete From tbl_property where property_project_id='".$_GET[md5("project_delete_id")]."'");		
	@mysqli_query($_SESSION['CONN'],"Delete From tbl_project_property_type_rate where project_id='".$_GET[md5("project_delete_id")]."'");
	
	//==================( ENQUIRY  )=================================
	@mysqli_query($_SESSION['CONN'],"Delete From tbl_enquiry where project_id='".$_GET[md5("project_delete_id")]."'");
	@mysqli_query($_SESSION['CONN'],"Delete From tbl_advisor_dvr where project_id='".$_GET[md5("project_delete_id")]."'");
	
	//==================( COMMISSION  )==============================
	@mysqli_query($_SESSION['CONN'],"Delete From tbl_advisor_commission where commission_project_id='".$_GET[md5("project_delete_id")]."'");
	
	//==================( EXTRA CHARGE )=============================
	@mysqli_query($_SESSION['CONN'],"Delete From tbl_property_booking_extra_charge where
	              booking_id in(select booking_id from tbl_property_booking where booking_project_id='".$_GET[md5("project_delete_id")]."'");		
	@mysqli_query($_SESSION['CONN'],"Delete From tbl_property_booking_extra_charge_payment where
	              booking_id in(select booking_id from tbl_property_booking where booking_project_id='".$_GET[md5("project_delete_id")]."'");

	//==================( BOOKING )==================================
	@mysqli_query($_SESSION['CONN'],"Delete From tbl_property_booking where booking_project_id='".$_GET[md5("project_delete_id")]."'");	
	@mysqli_query($_SESSION['CONN'],"Delete From tbl_property_booking_cancelled where booking_project_id='".$_GET[md5("project_delete_id")]."'");	
	@mysqli_query($_SESSION['CONN'],"Delete From tbl_property_booking_deleted where booking_project_id='".$_GET[md5("project_delete_id")]."'");	
	@mysqli_query($_SESSION['CONN'],"Delete From tbl_property_booking_payments where payment_project_id='".$_GET[md5("project_delete_id")]."'");
	
	$DOC_Q="SELECT doc From tbl_property_booking_payments_doc where payment_id in (select payment_id from tbl_property_booking_payments where payment_project_id='".$_GET[md5("project_delete_id")]."' ) ";
	$DOC_Q=@mysqli_query($_SESSION['CONN'],$DOC_Q);
	
	while($DOC_Q=@mysqli_fetch_assoc($DOC_Q))
	{
		@unlink('../SpitechUploads/booking/'.$DELETE_ROW['doc']);
	}
	
	@mysqli_query($_SESSION['CONN'],"Delete From tbl_property_booking_payments_doc where payment_id in (select payment_id from tbl_property_booking_payments where payment_project_id='".$_GET[md5("project_delete_id")]."' ) ");
	
    @unlink('../SpitechUploads/project/project_photo/'.$DELETE_ROW['project_photo']);
	
	$DBOBJ->UserAction("PROJECT DELETED","ID=".$_GET[md5("project_delete_id")].", NAME : ".$DELETE_ROW['project_name']);	
	header("location:Projects.php?Message=Project : ".$DELETE_ROW['project_name']." Deleted.");	
}
include("../Menu/Footer.php"); 
?>
