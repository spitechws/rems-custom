<?php
include_once("../Menu/HeaderAdvisor.php");
include_once("../php/SpitechDB.php");
include_once("../php/SpitechUtility.php");
include_once("../php/SpitechPagination.php");
include_once("../php/SpitechJS.php");
Menu("Project");
$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();
RefreshPage(1);
?>
<link href="../css/SpitechStyle.css" rel="stylesheet" type="text/css" />

<center>
<h1><img src="../SpitechImages/Property.png" width="31" height="32" />Project  : <span> Property Master List (<font>Manage Property</font>) </span>
<A style="float:right; margin-right:30px;" onclick="<?php ShowHide("FindForm","block"); ?>"><img src="../SpitechImages/FindIcon.png" />Search</A>
</h1>
<table width="100%" border="0" cellspacing="0" cellpadding="0" id="Content">
  <tr>
    <td>
    <center>
     <?php ErrorMessage(); ?>
     <form name="FindForm" id="FindForm" method="get" style="display:<?php if(isset($_GET['Search'])) { echo "block;"; } else { echo "none;"; };?>">
      <table width="98%" border="0" cellspacing="0" cellpadding="0" id="SearchTable" style="margin-top:5px;">
      <tr>
        <td width="5%">PROJECT</td>
        <td width="17%">
        <select id="<?php echo md5("property_project_id"); ?>" name="<?php echo md5("property_project_id"); ?>" onchange="GetPage('GetProperty.php?project_id='+this.value,'property');">
          <option value="All">ALL PROJECT...</option>
          <?php 
             $PROJECT_Q=@mysqli_query($_SESSION['CONN'],"select project_id, project_name from tbl_project ");
             while($PROJECT_ROWS=@mysqli_fetch_assoc($PROJECT_Q)) 
             {?>
          <option value="<?php echo $PROJECT_ROWS['project_id']?>" <?php SelectedSelect($PROJECT_ROWS['project_id'],$_GET[md5("property_project_id")]);?>>
            <?php echo $PROJECT_ROWS['project_name']?>
            </option>
          <?php } ?>
        </select></td>
        <td width="2%">PROPERTY</td>
        <td width="2%">
       <div id="property">
        <select id="<?php echo md5("property_id"); ?>" name="<?php echo md5("property_id"); ?>" >
          <option value="All">ALL PROPERTY...</option>
          <?php 
		  $PROPERTY_Q="select property_id, property_no  from tbl_property where property_project_id='".$_GET[md5('property_project_id')]."' order by  property_id, property_no  ";
             $PROPERTY_Q=@mysqli_query($_SESSION['CONN'],$PROPERTY_Q);
             while($PROPERTY_ROWS=@mysqli_fetch_assoc($PROPERTY_Q)) 
             {?>
          <option value="<?php echo $PROPERTY_ROWS['property_id']?>" <?php SelectedSelect($PROPERTY_ROWS['property_id'],$_GET[md5('property_id')] ); ?>>
		  <?php echo $PROPERTY_ROWS['property_no']?></option>
          <?php } ?>
</select>
</div></td>
        <td width="2%">type</td>
        <td width="2%">
             
             <select id="<?php echo md5("property_type_id"); ?>" name="<?php echo md5("property_type_id"); ?>" style="width:100px;">
             <option value="All">All Property Type...</option>
               <?php 
             $TYPE_Q=@mysqli_query($_SESSION['CONN'],"select property_type_id, property_type from tbl_setting_property_type ");
             while($TYPE_ROWS=@mysqli_fetch_assoc($TYPE_Q)) 
             {?>
               <option value="<?php echo $TYPE_ROWS['property_type_id']?>" <?php SelectedSelect($TYPE_ROWS['property_type_id'],$_GET[md5('property_type_id')] ); ?>>
                 <?php echo $TYPE_ROWS['property_type']?>
                 </option>
               <?php } ?>
             </select>
             
             </td>
        <td width="4%">STATUS</td>
        <td width="33%">         
        <select name="<?php echo md5("property_status"); ?>" id="<?php echo md5("property_status"); ?>" style="width:100px;">
          <option value="All">All Status...</option>          
           <option value="Available" <?php SelectedSelect("Available", $_GET[md5("property_status")]); ?>>Available</option>
           <option value="TempBooked" <?php SelectedSelect("TempBooked", $_GET[md5("property_status")]); ?>>TempBooked</option>
           <option value="Booked" <?php SelectedSelect("Booked", $_GET[md5("property_status")]); ?>>Booked</option>         
        </select>
        </td>
        <td width="20%">
        <input type="submit" name="Search" value=" " id="Search" /></td>
        <td width="21%">
        <input type="button" name="ShowAll" value="Show All" id="ShowAll" class="Button"  onclick="window.location='Project_Property_List.php'" style="width:80px;"/></td>
      
      </tr>
     
      </table>

  </form>
    <table width="98%" border="0" cellspacing="1" cellpadding="0" id="Data-Table">
      <tr>
    <th width="2%" rowspan="2">#</th>
    <th width="6%" rowspan="2">property no</th>
    <th width="13%" rowspan="2">project</th>
    <th colspan="3">area details (in square feet)</th>
    <th width="7%" rowspan="2">khasra</th>
    <th width="7%" rowspan="2">remarks</th>
    <th width="9%" rowspan="2">status</th>
    </tr>
      <tr>
        <th width="6%">plot&nbsp;area</th>
        <th width="7%">built up area</th>
        <th width="7%">super&nbsp;built up area</th>
        </tr>
  <?php

		$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);	
		if(isset($_GET["limit"]))	{ $limit = $_GET["limit"];	}	else	{	$limit = 50;	}
		$startpoint = ($page * $limit) - $limit;		
		if(isset($_GET["page"])) { $k=($page-1)*($limit)+1; }	else $k=1;
		//----------------------------------------------------------		
		$PROPERTY_QUERY="select * from tbl_property where 1 ";
		if(isset($_GET['Search']))
		{
			if($_GET[md5('property_project_id')]!="All")	{ $PROPERTY_QUERY.=" and property_project_id='".$_GET[md5('property_project_id')]."' "; }
			if($_GET[md5('property_type_id')]!="All") 	{ $PROPERTY_QUERY.=" and property_type_id ='".$_GET[md5('property_type_id')]."' "; }
			if($_GET[md5('property_id')]!="All") 		{ $PROPERTY_QUERY.=" and property_id ='".$_GET[md5('property_id')]."' "; }
			if($_GET[md5('property_status')]!="All") 	{ $PROPERTY_QUERY.=" and property_status ='".$_GET[md5('property_status')]."' "; }			
		}
	    
		$PAGINATION_QUERY=$PROPERTY_QUERY."  order by property_no+0, property_id ";
		$PROPERTY_QUERY=$PAGINATION_QUERY."  LIMIT {$startpoint} , {$limit}";	
		$PROPERTY_QUERY=@mysqli_query($_SESSION['CONN'],$PROPERTY_QUERY);	  
		$RECORD_FOUND=@mysqli_num_rows($PROPERTY_QUERY);

while($PROPERTY_ROWS=@mysqli_fetch_assoc($PROPERTY_QUERY)) 
{
	$BOOKING_ROW=$DBOBJ->GetRow('tbl_property_booking',"booking_cancel_status!='Yes' and approved='1' and booking_property_id",$PROPERTY_ROWS['property_id']);
	$CUSTOMER_NAME=$DBOBJ->ConvertToText("tbl_customer","customer_id","customer_name",$BOOKING_ROW['booking_customer_id']);
	$ADVISOR_NAME=$DBOBJ->ConvertToText("tbl_advisor","advisor_id","advisor_name",$BOOKING_ROW['booking_advisor_id']);
	
	$STATUS=$PROPERTY_ROWS['property_status'];
	$BG_COLOR='NONE';
	$COLOR='BLACK';
	if($STATUS=="Available") 
	{ 
		$BG_COLOR='GREEN';$COLOR='AQUA';
	} 
	elseif($STATUS=='TempBooked') 
	{
		$BG_COLOR='ORANGE'; 	
	} 
	elseif($STATUS=="Booked") 
	{ 
		$BG_COLOR='RED';$COLOR='YELLOW';
	}
?>
  <tr>
    <td><div align="center"><?php echo $k++;?>.</div></td>
    <td><div align="center"><?php echo $PROPERTY_ROWS['property_no']; ?></div></td>
    <td>
    <div align="left"  style="width:150PX;">
	<?php 
	echo $PROJECT_NAME=$DBOBJ->ConvertToText("tbl_project","project_id","project_name",$PROPERTY_ROWS['property_project_id']); 
	?>
    </div></td>
    <td><div align="center"><?php echo $PROPERTY_ROWS['property_plot_area']; ?></div></td>
    <td><div align="center"><?php echo $PROPERTY_ROWS['property_built_up_area']; ?></div></td>
    <td><div align="center"><?php echo $PROPERTY_ROWS['property_super_built_up_area']; ?></div></td>
    <td><div align="center"><?php echo $PROPERTY_ROWS['property_khasra_no']; ?></div></td>
    <td><div align="center"><?php echo $PROPERTY_ROWS['property_remarks']; ?></div></td>
    <td style="background:<?php echo $BG_COLOR?>; color:<?php echo $COLOR?>;"><div align="center"><?php echo $PROPERTY_ROWS['property_status']; ?></div></td>
    </tr>
  <?php } ?>
</table>
 <div class="paginate"><?php pagination($PAGINATION_QUERY,$limit,$page, url());  ?></div>

</center>
    </td>
  </tr>
</table>
</center>
<?php include("../Menu/FooterAdvisor.php"); ?>
