<?php
session_start();
 include_once("../Menu/HeaderAdmin.php");
 Menu("Expense");
	$DBOBJ = new DataBase();
	$DBOBJ->ConnectDatabase();
	$EDIT_ROW=$DBOBJ->GetRow("tbl_expense_category","category_id",$_GET[md5("edit_id")]);	
	if(isset($_POST['Submit']))
	{				
		$FIELDS=array("category_name");
		$VALUES=array($_POST["category_name"]);
		if(isset($_GET[md5('edit_id')]))
		{
		  $UPDATE=$DBOBJ->Update("tbl_expense_category",$FIELDS,$VALUES,"category_id",$_GET[md5('edit_id')],0);
		  //=============( ENTRY IN ACTION TABLE )=======================================================
		  $DBOBJ->UserAction("EXPENSE CATEGORY EDITED", "OLD : ".$EDIT_ROW['category_name'].", NEW : ".$_POST['category_name']);
		}
		else
		{
		   $INSERT=$DBOBJ->Insert("tbl_expense_category",$FIELDS,$VALUES,0);
		   //=============( ENTRY IN ACTION TABLE )=======================================================
		  $DBOBJ->UserAction("EXPENSE CATEGORY ADDED", "NAME : ".$_POST['category_name']);
		}
		header("location:Expense_Category.php?Message=Expense Category Saved Successfully.");
	}

?>
<link href="../css/SpitechStyle.css" rel="stylesheet" type="text/css" /> 

<h1><img src="../SpitechImages/Expense.png" />Expense : <span>Category/Sub Category</span>

    <div id="AddNew">
        <a onclick="<?php ShowHide("PaymentForm","block"); ?>">Add New Category</a>
        <a <?php Modal("Expense_Subcategory.php","500px", "220px", "400px", "200px"); ?> >Add New Sub Category</a> 
    </div>
</h1>

<table width="100%" border="0" align="center" cellspacing="0" cellpadding="0" id="Content">
  <tr>
    <td > <center>
    <?php ErrorMessage(); ?>
    <form name="PaymentForm" id="PaymentForm" method="post" enctype="multipart/form-data" style="display:<?php if(isset($_GET[md5('edit_id')])) { echo "block;"; } else { echo "none;"; };?>" >
     
        <fieldset style="width:500px;">
          <legend>Expense Category Entry : </legend>
          <table width="350" border="0" cellspacing="0" cellpadding="5" id="CommonTable" style="border:0px; margin-top:0px;" align="center">
            <tr>
              <td colspan="4">&nbsp;</td>
            </tr>
            <tr>
              <td>CATEGORY&nbsp;</td>
              <td><input type="text" name="category_name" id="category_name" placeholder="EXPENSE CATEGORY" required="required" value="<?php echo $EDIT_ROW['category_name']; ?>"  /></td>
              <td><input type="submit" name="Submit" id="Submit" value="Save" <?php Confirm("Are You Sure ? Save Expense Category?"); ?>/></td>
              <td><input type="button" name="Cancel" id="Cancel" value="Cancel" onclick="window.location='Expense_Category.php';" /></td>
            </tr>
           
          
           
            <tr>
              <td colspan="4" style="text-align:RIGHT">&nbsp;</td>
            </tr>
          </table>
        </fieldset>
      
    </form>
    </center>
    
   
    <table width="98%" border="0" cellspacing="1" cellpadding="0" id="Data-Table">
        <tr>
          <th width="3%">#</th>
          <th width="35%">EXPENSE CATEGORY</th>
          <th width="49%">EXPENSE SUB CATEGORY</th>
          <th colspan="2">ACTION</th>
        </tr>
        <?php

		$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);	
		if(isset($_GET["limit"]))	{ $limit = $_GET["limit"];	}	else	{	$limit = 100;	}
		$startpoint = ($page * $limit) - $limit;		
		if(isset($_GET["page"])) { $k=($page-1)*($limit)+1; }	else $k=1;
		//----------------------------------------------------------		
		$EXPENSE_QUERY="select * from tbl_expense_category where 1 ";
	
		 
		$PAGINATION_QUERY=$EXPENSE_QUERY."  order by category_name ";
		$EXPENSE_QUERY=$PAGINATION_QUERY."  LIMIT {$startpoint} , {$limit}";	
		$EXPENSE_QUERY=@mysqli_query($_SESSION['CONN'],$EXPENSE_QUERY);	  
		$RECORD_FOUND=@mysqli_num_rows($EXPENSE_QUERY);

while($EXPENSE_ROWS=@mysqli_fetch_assoc($EXPENSE_QUERY)) 
{
	
?>
        <tr>
          <td><div align="center"><?php echo $k++;?>.</div></td>
          <td><?php echo $EXPENSE_ROWS['category_name'];?></td>
          <td>
<table width="300" border="0" cellspacing="1" cellpadding="0" id="SmallTable">
  <tr>
    <th width="6%">#</th>
    <th width="75%">SUB CATEGORY</th>
    <th width="19%">action</th>
  </tr>
   <?php $Q=@mysqli_query($_SESSION['CONN'],"SELECT * FROM tbl_expense_sub_category where category_id='".$EXPENSE_ROWS['category_id']."' order by sub_category_name");
	  while($SUB_ROWS=@mysqli_fetch_assoc($Q)) { ?>
  <tr>
    <td style="height:20px; text-align:center"><?php echo ++$s?></td>
    <td><?php echo $SUB_ROWS['sub_category_name'];?></td>
    <td>
     <div align="center" style="width:100px;">           
             
              <A id="Edit" title="Edit Expense Sub Category : <?php echo $SUB_ROWS['sub_category_name']; ?>" <?php Modal("Expense_Subcategory.php?".md5('edit_id')."=".$SUB_ROWS['sub_category_id'],"500px", "220px", "400px", "200px"); ?>>&nbsp;</A>
              
              <A id="Delete" href="Expense_Category.php?<?php echo md5("expense_sub_category_delete_id")."=".$SUB_ROWS['sub_category_id'];?>" <?php Confirm("Are You Sure ? Delete Expense Sub Category ? "); ?>  title="Delete Expense Sub Category : <?php echo $SUB_ROWS['sub_category_name'];?>">&nbsp;</A>            
              
               
            </div>
    </td>
  </tr>
  <?php } ?>
</table>

          
          </td>
          <td width="5%">
            <div align="center" style="width:60px;">           
             
              <A id="Edit" title="Edit Expense Category : <?php echo $EXPENSE_ROWS['category_name']; ?>" href="Expense_Category.php?<?php echo md5('edit_id')."=".$EXPENSE_ROWS['category_id']?>">&nbsp;</A>
              
              <A id="Delete" href="Expense_Category.php?<?php echo md5("expense_category_delete_id")."=".$EXPENSE_ROWS['category_id'];?>" <?php Confirm("Are You Sure ? Delete Expense Category ? "); ?>  title="Delete Expense Sub Category : <?php echo $EXPENSE_ROWS['category_name'];?>">&nbsp;</A>            
              
               
            </div>
          </td>
          <td width="8%" style="text-align:center">
           <a <?php Modal("Expense_Subcategory.php?category_id=".$EXPENSE_ROWS['category_id'],"500px", "220px", "400px", "200px"); ?>>Add&nbsp;Sub&nbsp;Category</a> 
          </td>
        </tr>
      
        <?php } ?>
          <tr>
          <th>&nbsp;</th>
          <th>&nbsp;</th>
          <th>&nbsp;</th>
          <th colspan="2">&nbsp;</th>
        </tr>
      </table>
      
     
      
       <div align="right" class="paginate"><?php pagination($PAGINATION_QUERY,$limit,$page, url('Expense_Category.php'));  ?></div>
           
      </td>
  </tr>
</table>
<?php 
if($_GET[md5("expense_category_delete_id")]>0)
{
	$DELETE_ROW=$DBOBJ->GetRow("tbl_expense_category","category_id",$_GET[md5("expense_category_delete_id")]);	
	
	@mysqli_query($_SESSION['CONN'],"Delete From tbl_expense_category where category_id='".$_GET[md5("expense_category_delete_id")]."' ");
	@mysqli_query($_SESSION['CONN'],"Delete From tbl_expense_sub_category where category_id='".$_GET[md5("expense_category_delete_id")]."' ");	
	@mysqli_query($_SESSION['CONN'],"Delete From tbl_expense where expense_category_id='".$_GET[md5("expense_category_delete_id")]."' ");
	
	$DBOBJ->UserAction("EXPENSE CATEGORY DELETED", "NAME : ".$DELETE_ROW['category_name']);
	
	header("location:Expense_Category.php?Message=Selected Expense Category Have Been Deleted Successfully.");	
}
if($_GET[md5("expense_sub_category_delete_id")]>0)
{	
   $DELETE_ROW=$DBOBJ->GetRow("tbl_expense_sub_category","sub_category_id",$_GET[md5("expense_sub_category_delete_id")]);	
   
   $DBOBJ->UserAction("EXPENSE SUB CATEGORY DELETED", "NAME : ".$DELETE_ROW['sub_category_name']);
   
	@mysqli_query($_SESSION['CONN'],"Delete From tbl_expense_sub_category where sub_category_id='".$_GET[md5("expense_sub_category_delete_id")]."' ");	
	@mysqli_query($_SESSION['CONN'],"Delete From tbl_expense where expense_sub_category_id='".$_GET[md5("expense_sub_category_delete_id")]."' ");
	
	header("location:Expense_Category.php?Message=Selected Expense Sub Category Have Been Deleted Successfully.");	
}
include("../Menu/Footer.php"); 

?>
