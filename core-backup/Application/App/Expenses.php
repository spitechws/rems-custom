<?php
session_start();
 include_once("../Menu/HeaderAdmin.php");
 Menu("Expense");
	$DBOBJ = new DataBase();
	$DBOBJ->ConnectDatabase();

	$s_date=date('2000-01-01');	
	$e_date=date('Y-m-d');	
	if(isset($_GET['Search']))
	{
		$s_date=$_GET['s_date']; 	
	    $e_date=$_GET['e_date'];	
	}
	
?>
<link href="../css/SpitechStyle.css" rel="stylesheet" type="text/css" /> 

<h1><img src="../SpitechImages/Expense.png" />Expense : <span>Expense List </span>
 <div id="AddNew"><a <?php Modal("Expense_Entry.php","510px", "510px", "200px", "100px"); ?> >Add Expense</a></div>
    

</h1>

<table width="100%" border="0" align="center" cellspacing="0" cellpadding="0" id="Content">
  <tr>
    <td >
    <?php ErrorMessage(); ?>
    <form name="FindForm" id="FindForm" method="get" >
    <style>#CommonTable tr td { margin-right:0px; margin-left:0px; padding-right:0px; padding-left:1px; }</style>
      <table width="98%" border="0" cellspacing="0" cellpadding="0" id="SearchTable" class="SearchTable" style="margin-top:5px;">
        <tr>
          
          <td width="5%">category</td>
          <td width="13%">
          
          <select id="category_id" name="category_id" required='' onchange="GetPage('GetExpenseSubCategory.php?category_id='+this.value+'&amp;sub_category_id=<?php echo $EDIT_ROW['expense_sub_category_id']?>','sub');" style="width:120px;">
            <option value="All">ALL EXPENSE CATEGORY...</option>
            <?php $Q=@mysqli_query($_SESSION['CONN'],"SELECT * FROM tbl_expense_category order by category_name");
		   while($CAT_ROWS=@mysqli_fetch_assoc($Q)) { ?>
            <option value="<?php echo $CAT_ROWS['category_id']; ?>" <?php SelectedSelect($CAT_ROWS['category_id'],$_GET['category_id']); ?>>
              <?php echo $CAT_ROWS['category_name'];?>
              </option>
            <?php } ?>
          </select></td>
          <td width="10%">sub&nbsp;category</td>
          <td width="11%">
          <div id="sub">
    <select id="sub_category_id" name="sub_category_id" required=''  style="width:120px;">
    <option value="All">All Sub Category...</option>
      <?php $Q=@mysqli_query($_SESSION['CONN'],"SELECT * FROM tbl_expense_sub_category where category_id='".$_GET['category_id']."' order by sub_category_name");
		   while($CAT_ROWS=@mysqli_fetch_assoc($Q)) { ?>
      <option value="<?php echo $CAT_ROWS['sub_category_id']; ?>" <?php SelectedSelect($CAT_ROWS['sub_category_id'],$_GET['sub_category_id']); ?>>
        <?php echo $CAT_ROWS['sub_category_name'];?>
        </option>
      <?php } ?>
    </select>
    </div>
    </td>
     <td width="12%">PARTY</td>
     <td width="10%">
          <select id="expense_party" name="expense_party" required='' style="width:120px;">
            <option value="All">All Party...</option>
            <?php $Q=@mysqli_query($_SESSION['CONN'],"SELECT expense_party FROM tbl_expense group by expense_party order by expense_party ");
		   while($PARTY_ROWS=@mysqli_fetch_assoc($Q)) { ?>
            <option value="<?php echo $PARTY_ROWS['expense_party']; ?>" <?php SelectedSelect($PARTY_ROWS['expense_party'],$_GET['expense_party']); ?>>
              <?php echo $PARTY_ROWS['expense_party'];?>
              </option>
            <?php } ?>
          </select></td>
          <td width="5%">FROM</td>
          <td width="5%" class="Date"><script>DateInput('s_date', true, 'yyyy-mm-dd','<?php echo $s_date; ?>');</script></td>
          <td width="3%">TO</td>
          <td width="10%" class="Date"><script>DateInput('e_date', true, 'yyyy-mm-dd','<?php echo $e_date; ?>');</script></td>
          <td width="12%"><input type="submit" name="Search" value=" " id="Search" /></td>
          <td width="4%"><input type="button" name="All" value="All" class="Button" onclick="window.location='Expenses.php';" /></td>
        </tr>
      </table>
    </form>
    <table width="98%" border="0" cellspacing="1" cellpadding="0" id="Data-Table">
        <tr>
          <th width="2%">#</th>
          <th width="7%">date</th>
          <th width="14%">against&nbsp;party</th>
          <th width="13%">sub category</th>
          <th width="14%">category</th>
          <th width="8%">amount</th>
          <th width="7%">type</th>
          <th width="14%">details</th>
          <th width="15%">remark</th>
          <th width="6%">ACTION</th>
        </tr>
        <?php

		$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);	
		if(isset($_GET["limit"]))	{ $limit = $_GET["limit"];	}	else	{	$limit = 100;	}
		$startpoint = ($page * $limit) - $limit;		
		if(isset($_GET["page"])) { $k=($page-1)*($limit)+1; }	else $k=1;
		//----------------------------------------------------------		
		$EXPENSES_QUERY="select * from tbl_expense where 1 ";
	
		if(isset($_GET['Search']))
		{
			
			if($_GET['category_id']!="All") 		{ $EXPENSES_QUERY.=" and expense_category_id ='".$_GET['category_id']."'"; 			}		
			if($_GET['sub_category_id']!="All") 	{ $EXPENSES_QUERY.=" and expense_sub_category_id='".$_GET['sub_category_id']."'";	 }	
			if($_GET['expense_party']!="All") 	  { $EXPENSES_QUERY.=" and expense_party='".$_GET['expense_party']."'";				 }		
			
			$EXPENSES_QUERY.=" and expense_date between '".$_GET['s_date']."' and '".$_GET['e_date']."' ";	
		}
	    
		$PAGINATION_QUERY=$EXPENSES_QUERY."  order by expense_date  desc, expense_party asc ";
		$EXPENSES_QUERY=$PAGINATION_QUERY."  LIMIT {$startpoint} , {$limit}";	
		$EXPENSES_QUERY=@mysqli_query($_SESSION['CONN'],$EXPENSES_QUERY);	  
		$RECORD_FOUND=@mysqli_num_rows($EXPENSES_QUERY);

while($EXPENSES_ROWS=@mysqli_fetch_assoc($EXPENSES_QUERY)) 
{
	
?>
        <tr>
          <td><div align="center"><?php echo $k++;?>.</div></td>
          <td><div align="center" style="width:80px;"><?php echo date('d-M-Y',strtotime($EXPENSES_ROWS['expense_date'])); ?></div></td>
          <td><?php echo $EXPENSES_ROWS['expense_party'];?></td>
          <td><?php echo $DBOBJ->ConvertToText("tbl_expense_sub_category","sub_category_id","sub_category_name",$EXPENSES_ROWS['expense_sub_category_id']);?></td>
          <td><?php echo $DBOBJ->ConvertToText("tbl_expense_category","category_id","category_name",$EXPENSES_ROWS['expense_category_id']);?></td>
          <td><div align="right"><?php echo @number_format($EXPENSES_ROWS['expense_amount'],2); $total_amount+=$EXPENSES_ROWS['expense_amount'];?></div></td>
          <td style="text-align:center"><?php echo $EXPENSES_ROWS['payment_mode'];?></td>
          <td>
              <div align="left">
              <?php if($EXPENSES_ROWS['payment_mode']=="CASH") {?>
                  <?php echo $EXPENSES_ROWS['payment_no']; ?>, 
                  <?php echo $EXPENSES_ROWS['payment_bank']; ?>, 
                  <?php echo date('d-M-Y',strtotime($EXPENSES_ROWS['payment_mode_date'])); ?>
               <?php } ?>   
              </div>
          </td>
          <td><?php echo $EXPENSES_ROWS['expense_note'];?></td>
          <td>
            <div align="center" style="width:70px;">        
            
             <?php if(strtoupper($_SESSION['user_category'])=="ADMIN"){	?>
              <A id="Edit" <?php Modal("Expense_Entry.php?".md5("edit_id")."=".$EXPENSES_ROWS['expense_id'],"820px", "900px", "150px", "100px"); ?> title="Edit  Expense Details">&nbsp;</A>
              <?php } ?>
              
            <A id="Delete" href="Expenses.php?<?php echo md5("expense_delete_id")."=".$EXPENSES_ROWS['expense_id']; ?>" <?php Confirm("Are You Sure ? Delete This Expense Entry ? "); ?>  title="Delete Expense ">&nbsp;</A></div>
          </td>
        </tr>
      
        <?php } ?>
          <tr>
          <th colspan="5"><div align="right">tOTAL</div></th>
          <th style="text-align:right;"><?php echo @number_format($total_amount,2);?></th>
          <th colspan="4"><div align="right" style="color:maroon;"></div></th>
        </tr>
      </table>
      
     
      
       <div align="right" class="paginate"><?php pagination($PAGINATION_QUERY,$limit,$page, url('Expenses.php'));  ?></div>
           
      </td>
  </tr>
</table>
<?php 
if($_GET[md5("expense_delete_id")]>0)
{
    NoAdmin();
	$DELETE_ROW=$DBOBJ->GetRow("tbl_expense","expense_id",$_GET[md5("expense_delete_id")]);	
	
	@mysqli_query($_SESSION['CONN'],"Delete From tbl_expense where expense_id='".$_GET[md5("expense_delete_id")]."' ");	
	
	//=============( ENTRY IN ACTION TABLE )=======================================================
	 $DBOBJ->UserAction("EXPENSE DELETED", "AMOUNT : ".$DELETE_ROW['expense_amount']);
			  
	header("location:Expenses.php?Message=Selected Expense Have Been Deleted Successfully.");	
}
include("../Menu/Footer.php"); 

?>
