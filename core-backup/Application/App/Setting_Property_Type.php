<?php
include_once("../Menu/HeaderAdmin.php");
include_once("../php/SpitechDB.php");
include_once("../php/SpitechUtility.php");
include_once("../php/SpitechPagination.php");
include_once("../php/SpitechJS.php");
Menu("Settings");NoAdmin();NoUser();
$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();

if(isset($_GET[md5('edit_id')]))
{
  $EDIT_ROW=$DBOBJ->GetRow("tbl_setting_property_type","property_type_id",$_GET[md5('edit_id')]);
}

if(isset($_POST['Save']))
	 { 	  		
		          $FIELDS=array("property_type" ,								
								"created_details",
								"edited_details");									  
				  $VALUES=array($_POST["property_type"] ,								
								$Mess=CreatedEditedByUserMessage(),
								$Mess);				
							
				if(isset($_GET[md5("edit_id")]))
				{ 	
					$Update=$DBOBJ->Update("tbl_setting_property_type",$FIELDS,$VALUES,"property_type_id",$_GET[md5("edit_id")],0);
					$DBOBJ->UserAction("PROPERTY TYPE EDITED", " ID : ".$_GET[md5("edit_id")].", OLD : ".$EDIT_ROW['property_type']." NEW : ".$_POST["property_type"]);
					$Message="PROPERTY TYPE EDITED SUCCESSFULLY.";
				}
				else
				{
					$INSERT=$DBOBJ->Insert("tbl_setting_property_type",$FIELDS,$VALUES,0);	
					
					$DBOBJ->UserAction("PROPERTY TYPE CREATED", " ID : ".$INSERT=$DBOBJ->MaxID("tbl_setting_property_type","property_type_id").", TYPE : ".$_POST['property_type']);
					$Message="PROPERTY TYPE CREATED SUCCESSFULLY.";
				}
      header("location:Setting_Property_Type.php?Message=".$Message);
	}	
?>
<link href="../css/SpitechStyle.css" rel="stylesheet" type="text/css" />
<center>
<h1><img src="../SpitechImages/Settings.png" width="31" height="32" />Settings  : <span>Property Type</span>
<span id="AddNew"><a onclick="<?php ShowHide("FormPropertyType","block"); ?>">New Property Type</a></span>
</h1>
<table width="100%" border="0" align="center" cellspacing="0" cellpadding="0" id="Content">
  <tr>
    <td align="center">
    <center>
    <?php ErrorMessage(); ?>
    <form name="FormPropertyType" id="FormPropertyType" method="post" style="display:<?php if(isset($_GET[md5('edit_id')])) { echo "block;"; } else { echo "none;"; };?>" >
    <fieldset style="width:400px; height:200px;"><legend>Property Type Entry/Edit :</legend>
<table width="300" border="0" cellspacing="0" cellpadding="0" id="CommonTable" style="border:0px;" align="center">
  <tr>
    <td width="69">&nbsp;</td>
    <td width="131">&nbsp;</td>
    <td width="100">&nbsp;</td>
  </tr>
  <tr>
    <td>Property&nbsp;Type</td>
    <td><input type="text" name="property_type" id="property_type" value="<?php echo $EDIT_ROW['property_type'];?>" placeholder="PROPERTY TYPE" REQUIRED=""/></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">
      <div align="right">
        <input type="submit" name="Save" id="Save" class="Button" value=" Save " <?php Confirm("Are You Sure ? Save Property Type ?"); ?>/>
        <input type="button" name="Cancel" id="Cancel" value="Cancel" onClick="window.location='Setting_Property_Type.php';" />
      </div></td>
    <td>&nbsp;</td>
  </tr>
</table>

    </fieldset>
    </form>
    
    <table width="98%" border="0" cellspacing="1" cellpadding="0" id="Data-Table" style="width:600px;" align="center">
  <tr>
    <th width="4%">#</th>
    <th width="86%">PROPERTY TYPE</th>
    <th width="10%" class="Action">ACTION</th>
  </tr>
  <?php

		$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);	
		if(isset($_GET["limit"]))	{ $limit = $_GET["limit"];	}	else	{	$limit = 50;	}
		$startpoint = ($page * $limit) - $limit;		
		if(isset($_GET["page"])) { $k=($page-1)*($limit)+1; }	else $k=1;
		//----------------------------------------------------------		
		$PROPERTY_TYPE_QUERY="select * from tbl_setting_property_type ";
		
	    
		$PAGINATION_QUERY=$PROPERTY_TYPE_QUERY."  order by property_type_id ";
		$PROPERTY_TYPE_QUERY=$PAGINATION_QUERY."  LIMIT {$startpoint} , {$limit}";	
		$PROPERTY_TYPE_QUERY=@mysqli_query($_SESSION['CONN'],$PROPERTY_TYPE_QUERY);	  
		$RECORD_FOUND=@mysqli_num_rows($PROPERTY_TYPE_QUERY);

while($PROPERTY_TYPE_ROWS=@mysqli_fetch_assoc($PROPERTY_TYPE_QUERY)) {
?>
  <tr>
    <td><div align="center"><?php echo $k++;?>.</div></td>
    <td ><div align="left"><?php echo $PROPERTY_TYPE_ROWS['property_type']; ?></div></td>
    <td class="Action"><div align="center" style="width:100px;"> 
      
      <a id="Edit" href="Setting_Property_Type.php?<?php echo md5('edit_id')."=".$PROPERTY_TYPE_ROWS['property_type_id'];?>" title="Edit Property Type : <?php echo $PROPERTY_TYPE_ROWS['property_type']; ?>">&nbsp;</a> 
      
      <a id="Delete" href="Setting_Property_Type.php?<?php echo md5("property_type_delete_id")."=".$PROPERTY_TYPE_ROWS['property_type_id']; ?>" <?php Confirm("Are You Sure ? Delete Property Type :  ".$PROPERTY_TYPE_ROWS['property_type']." ? "); ?>  title="Delete Property Type : <?php echo $PROPERTY_TYPE_ROWS['property_type']; ?>">&nbsp;</a></div></td>
  </tr>
  <?php } ?>
</table>
 <div class="paginate" style="width:600px;"><?php pagination($PAGINATION_QUERY,$limit,$page, url());  ?></div>

</center>
    </td>
  </tr>
</table>
</center>
<?php 
if(isset($_GET[md5("property_type_delete_id")]) && $_SESSION['user_category']=="admin" && $_SESSION['user_id']=='admin' )
{
	NoAdmin();
	$DELETE_ROW=$DBOBJ->GetRow("tbl_setting_property_type","property_type_id",$_GET[md5("property_type_delete_id")]);	
	
	@mysqli_query($_SESSION['CONN'],"Delete From tbl_setting_property_type where property_type_id='".$_GET[md5("property_type_delete_id")]."'");	
	
	$DBOBJ->UserAction("PROPERTY TYPE DELETED","ID=".$_GET[md5("property_type_delete_id")].", PROPERTY TYPE : ".$DELETE_ROW['property_type']);	
	header("location:Setting_Property_Type.php?Message=Property Type : ".$DELETE_ROW['property_type']." Deleted.");	
}
include("../Menu/Footer.php"); 
?>
