<?php
session_start();
include_once("../Menu/HeaderAdmin.php");
include_once("../php/SpitechDB.php");
include_once("../php/SpitechUtility.php");
include_once("../php/SpitechPagination.php");
include_once("../php/SpitechJS.php");

Menu("Project");
NoUser();
$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();


if(isset($_POST['Save']))
{
	if(isset($_GET[md5("project_id")]) && isset($_GET[md5("Rows")]) && isset($_GET[md5("Open")])  ) 
	{ 
	
	   $FIELDS=array("property_project_id" ,
						"property_type_id" ,
						"property_no" ,
						"property_status",
						"property_plot_area" ,
						"property_built_up_area" ,
						"property_super_built_up_area" ,
						"property_khasra_no" ,
						"property_remarks" ,						
						"created_details" ,
						"edited_details");	
	   $j=0;
	   for($j=1;$j<=$_GET[md5("Rows")];$j++) 
	   {	
	   
	   		if( ($_POST["property_plot_area".$j]!="" && $_POST["property_plot_area".$j]!="0")||($_POST["property_built_up_area".$j]!="" && $_POST["property_built_up_area".$j]!="0")||($_POST["property_super_built_up_area".$j]!="" && $_POST["property_super_built_up_area".$j]!="0"))
			{	
			 if($_POST["property_no".$j]!="0" && $_POST["property_no".$j]!="") 
			 {
				 
				$VALUES=array($_GET[md5("project_id")] ,
								$_POST["property_type_id".$j] ,
								$_POST["property_no".$j] ,
								$_POST["property_status".$j],
								$_POST["property_plot_area".$j] ,
								$_POST["property_built_up_area".$j] ,
								$_POST["property_super_built_up_area".$j] ,
								$_POST["property_khasra_no".$j] ,
								$_POST["property_remarks".$j] ,									
								$mess=CreatedEditedByUserMessage(),
								$mess);
							
				$DBOBJ->Insert("tbl_property",$FIELDS,$VALUES,0);	
				$S++;
			 }
			}
	   }
		$project_name=$DBOBJ->ConvertToText("tbl_project","project_id","project_name",$_GET[md5("project_id")]);
		$DBOBJ->UserAction("PROPERTY ADDED","ON PROJECT : ".$_GET[md5("project_id")].", NAME : ".$project_name.", No Of Properties : ".$S);
	}
	header("location:Project_Property_List.php?".md5("property_project_id")."=".$_GET[md5("project_id")]."&".md5("property_id")."=All&".md5("property_type_id")."=All&".md5("property_status")."=All&Search=+");
}
?>
<link href="../css/SpitechStyle.css" rel="stylesheet" type="text/css" />
<center>
<h1><img src="../SpitechImages/PropertyNew.png" width="31" height="32" />Project  : <span>Add Property To Project</span></h1>
<table width="100%" border="0" cellspacing="0" cellpadding="0" id="Content">
  <tr>
    <td>
    <center>
     <?php ErrorMessage(); ?>
  <form name="RowForm" id="RowForm" method="get">
   <table width="98%" border="0" cellspacing="0" cellpadding="0" id="CommonTable" style="width:1000px; height:40px;">
  <tr>
    <td width="88">&nbsp;</td>
    <td width="88">PROJECT</td>
    <td width="220">
    <select id="<?php echo md5("project_id"); ?>" name="<?php echo md5("project_id"); ?>" required="">
    <option VALUE="">SELECT A PROJECT...</option>
           <?php 
             $PROJECT_Q=@mysqli_query($_SESSION['CONN'],"select project_id, project_name from tbl_project ");
             while($PROJECT_ROWS=@mysqli_fetch_assoc($PROJECT_Q)) 
             {?>
           <option value="<?php echo $PROJECT_ROWS['project_id']?>" <?php SelectedSelect($PROJECT_ROWS['project_id'],$_GET[md5("project_id")]);?>>
		   <?php echo $PROJECT_ROWS['project_name']?>
           </option>
           <?php } ?>
         </select>
    </td>
    <td width="126">HOW&nbsp;MANEY&nbsp;ROW</td>
    <td width="123">
    
    <select id="<?php echo md5("Rows"); ?>" name="<?php echo md5("Rows"); ?>" required="" style="width:100px;">
     <option VALUE="">NO OF ROWS...</option>
     <?php for($k=1;$k<20;$k++){?>
      <option value="<?php echo $k?>" <?php SelectedSelect($k,$_GET[md5("Rows")]); ?>><?php echo $k?></option>
      <?php } ?>
    </select></td>
    <td width="353">
      <input type="submit" name="<?php echo md5("Open")?>" id="<?php echo md5("Open")?>" value="Open" />
    </td>
  </tr>
</table>
</form>

<?php if(isset($_GET[md5("project_id")]) && isset($_GET[md5("Rows")]) && isset($_GET[md5("Open")])  ) 
{ 

?>
  <form name="RowForm" id="RowForm" method="post">
     <table width="100" border="0" cellspacing="1" cellpadding="0" id="Data-Table" style="width:1000px;">
       <tr>
         <th width="7%" scope="col">NO</th>
         <th width="25%" scope="col">PROPERTY&nbsp;TYPE</th>
         <th width="25%" scope="col">PROPERTY NO/NAME</th>
         <th scope="col">PLOT&nbsp;AREA</th>
         <th scope="col">Built&nbsp;Up&nbsp;Area </th>
         <th scope="col">Super&nbsp;Built Up Area </th>
         <th scope="col">status</th>
         <th scope="col">Khasra</th>
         <th scope="col">REMARKS</th>
       </tr>
       <?php 
	   $i=0;
	   for($j=1;$j<=$_GET[md5("Rows")];$j++) {?>
       <tr>
         <td width="7%"><div align="center"><?php echo ++$i?>.</div></td>
         <td width="25%">
           <div align="center">
             <select id="property_type_id<?php echo $i?>" name="property_type_id<?php echo $i?>" required="" style="width:100px;">
               <?php 
             $TYPE_Q=@mysqli_query($_SESSION['CONN'],"select property_type_id, property_type from tbl_setting_property_type where property_type_id in(select project_property_type_id from tbl_project_details where project_id='".$_GET[md5("project_id")]."') ");
             while($TYPE_ROWS=@mysqli_fetch_assoc($TYPE_Q)) 
             {?>
               <option value="<?php echo $TYPE_ROWS['property_type_id']?>">
                 <?php echo $TYPE_ROWS['property_type']?>
                 </option>
               <?php } ?>
             </select>
           </div></td>
         <td width="25%"><div align="center">
           <input type="text" name="property_no<?php echo $i?>" id="property_no<?php echo $i?>" placeholder="NO" style="width:100px;" value="0" required=""/>
         </div></td>
         <td><input type="text" name="property_plot_area<?php echo $i?>" id="property_plot_area<?php echo $i?>" placeholder="PLOT AREA" style="width:100px;" value="0" required="" <?php OnlyFloat();?>/></td>
         <td>
         <input type="text" name="property_built_up_area<?php echo $i?>" id="property_built_up_area<?php echo $i?>" placeholder="BUILT UP AREA" style="width:100px;" value="0" required="" <?php OnlyFloat();?>/>
         </td>
         <td><input type="text" name="property_super_built_up_area<?php echo $i?>" id="property_super_built_up_area<?php echo $i?>" placeholder="SUPER BUILT UP AREA" style="width:100px;" value="0" required="" <?php OnlyFloat();?>/></td>
         <td>
         <select name="property_status<?php echo $i?>" id="property_status<?php echo $i?>" style="width:100px;">          
           <option value="Available">Available</option>         
           <option value="Hold">Hold</option>
         </select>
         </td>
         <td><input type="text" name="property_khasra_no<?php echo $i?>" id="property_khasra_no<?php echo $i?>" placeholder="KHASRA NO" /></td>
         <td><input type="text" name="property_remarks<?php echo $i?>" id="property_remarks<?php echo $i?>" placeholder="REMARKS" />
           <div align="left"></div></td>
       </tr>
      
       <?php } ?> 
       <tr>
         <th colspan="9"><span style="text-align:RIGHT">
           <input type="submit" name="Save" id="Save" value="Save Property Details" <?php Confirm("Are You Sure ? Save Property Details ?"); ?>/>
           <input type="button" name="Cancel" id="Cancel" value="Cancel" onclick="window.location='Projects.php';" />
         </span></th>
       </tr>
     </table>
     </form>
     <?php } ?>
    </center>
</td></tr></table></center>