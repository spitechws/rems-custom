<?php
session_start();
include_once("../Menu/HeaderCommon.php");
include_once("../php/SpitechDB.php");
include_once("../php/SpitechUtility.php");
include_once("../php/SpitechJS.php");

NoUser();
	$DBOBJ = new DataBase();
	$DBOBJ->ConnectDatabase();
	
	$EDIT_ROW=$DBOBJ->GetRow("tbl_expense_sub_category","sub_category_id",$_GET[md5("edit_id")]);	
	
	if(isset($_POST['Submit']))
	{			  
		
		$FIELDS=array("category_id","sub_category_name");				
		
		$VALUES=array($_POST["category_id"],$_POST["sub_category_name"]);
		
		if($_GET[md5("edit_id")]>0)
		{
		    $UPDATE=$DBOBJ->Update("tbl_expense_sub_category",$FIELDS,$VALUES,"sub_category_id",$_GET[md5("edit_id")],1);	
			//=============( ENTRY IN ACTION TABLE )=======================================================
		     $DBOBJ->UserAction("EXPENSE SUB CATEGORY EDITED", "OLD : ".$EDIT_ROW['sub_category_name'].", NEW : ".$_POST['sub_category_name']);			
		}
		else
		{
			$INSERT=$DBOBJ->Insert("tbl_expense_sub_category",$FIELDS,$VALUES,0);	
			//=============( ENTRY IN ACTION TABLE )=======================================================
		     $DBOBJ->UserAction("EXPENSE SUB CATEGORY ADDED", "NEW : ".$_POST['sub_category_name']);			
		}
		
	
		
		UnloadMe();
	}
	if(isset($_GET[md5('edit_id')]))
	{
		$category_id=$EDIT_ROW['category_id'];
	}
	else
	{
		$category_id=$_GET['category_id'];
	}
	
?><head><title> Expense Sub Category</title></head>

<link href="../css/SpitechStyle.css" rel="stylesheet" type="text/css" /> 

  <center>
<form name="SubCategoryForm" id="SubCategoryForm" method="post" enctype="multipart/form-data" >

    <center>
    <fieldset style="width:400px;"><legend>Expense Sub Category</legend>
    <table width="350" border="0" cellspacing="0" cellpadding="5" id="CommonTable" style="border:0px; margin-top:0px;" align="center">
  <tr>
    <td colspan="3">&nbsp;</td>
    </tr>
 
  <tr>
    <td>CATEGORY</td>
    <td colspan="2">
     <select id="category_id" name="category_id" required=''>
     	
        <?php $Q=@mysqli_query($_SESSION['CONN'],"SELECT * FROM tbl_expense_category order by category_name");
		   while($CAT_ROWS=@mysqli_fetch_assoc($Q)) { ?>
        <option value="<?php echo $CAT_ROWS['category_id']; ?>" <?php SelectedSelect($CAT_ROWS['category_id'],$category_id); ?>>
		  <?php echo $CAT_ROWS['category_name'];?>
        </option>
        <?php } ?>
     </select>
    </td>
    </tr>
  
  <tr>
    <td style="vertical-align:top;">SUB&nbsp;CATEGORY</td>
    <td colspan="2">
    <input type="text" name="sub_category_name" id="sub_category_name" placeholder="SUB CATEGORY" required="required" value="<?php echo $EDIT_ROW['sub_category_name']; ?>"/>
    </td>
  </tr>


  <tr>
    <td colspan="3" style="text-align:RIGHT">
      <input type="submit" name="Submit" id="Submit" value="Save Payment Details" <?php Confirm("Are You Sure ? Save Payment Details ?"); ?>/>
      <input type="button" name="Cancel" id="Cancel" value="Cancel" onClick="window.close();" />
      </td>
  </tr>

</table></fieldset></center></form></center>
<script>
function HidMe()
{
	if(document.getElementById('payment_mode').value!="CASH") 
	{ 
	   document.getElementById('hide').style.display='table-row';
	}
	else
	{
		document.getElementById('hide').style.display='none';
	}
}
</script>
