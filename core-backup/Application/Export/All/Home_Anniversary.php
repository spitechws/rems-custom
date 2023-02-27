<?php 
include_once('../php/Excel.php'); ExportExcel(); 
$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();	
$s_date=date('Y-m-d');
$e_date=date('Y-m-d',strtotime(date("Y-m-d", strtotime($s_date)). "+7 day"));
if(isset($_GET['Search'])) { $s_date=$_GET['s_date']; $e_date=$_GET['e_date'];}

$S_M=date('m',strtotime($s_date));
$S_D=date('d',strtotime($s_date));
$E_M=date('m',strtotime($e_date));
$E_D=date('d',strtotime($e_date));
?>
<center>
<h1>Home  : <span>Anniversary Reminder (<font>Upcomming Anniversary</font>) </span></h1>
  <table width="99%" id="ExportTable" cellspacing="0" cellpadding="0" border="1" > 
	<tr id="TH">
        <th width="33"><div align="center">#</div></th>
        <th width="82">ANN. DATE</th>
        <th width="318"><?php echo advisor_title?> NAME</th>
        <th width="91">ID</th>
        <th width="135">MOBILE NO</th>
        <th width="119">PHONE NO</th>
        <th width="354">E-MAIL ADDRESS</th>
        <th width="110">CURRENT LEVEL</th>
    </tr>
	 <?php 
	 	$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);	
		if(isset($_GET["limit"]))	{ $limit = $_GET["limit"];	}	else	{	$limit = 100;	}
		$startpoint = ($page * $limit) - $limit;		
		if(isset($_GET["page"])) { $k=($page-1)*($limit)+1; }	else $k=1;
		//----------------------------------------------------------		
		$ADVISOR_QUERY="SELECT * FROM tbl_advisor where month(advisor_anniversary_date) between '$S_M' and '$E_M' AND day(advisor_anniversary_date) between '$S_D' and '$E_D' ";
		$PAGINATION_QUERY=$ADVISOR_QUERY."  order by advisor_anniversary_date desc ";
		$ADVISOR_QUERY=$PAGINATION_QUERY."  LIMIT {$startpoint} , {$limit}";	
		$ADVISOR_QUERY=@mysqli_query($_SESSION['CONN'],$ADVISOR_QUERY);	  
		$RECORD_FOUND=@mysqli_num_rows($ADVISOR_QUERY);
	
		while($ADVISOR_ROWS=@mysqli_fetch_assoc($ADVISOR_QUERY)) 
		{
			
			if(date('d-M',strtotime($ADVISOR_ROWS['advisor_anniversary_date']))==date('d-M')) 
			{ 
			  echo "<style>#Data-Table #Today td { background:lightgreen; color:maroon; text-decoration:blink; font-style:italic; } </style>";
			}
     ?>   
    <tr id="Today">
            <td style="text-align:center;"><?php echo ++$j?>.</td>
            <td style="text-align:center"><?php echo date('d-M-Y',strtotime($ADVISOR_ROWS['advisor_anniversary_date']))?></td>
            <td><?php echo $ADVISOR_ROWS['advisor_name']?></td>
            <td style="text-align:center"><?php echo $ADVISOR_ROWS['advisor_code']?></td>
            <td style="text-align:center"><?php echo $ADVISOR_ROWS['advisor_mobile']?></td>
            <td style="text-align:center"><?php echo $ADVISOR_ROWS['advisor_phone']?></td>
            <td><?php echo $ADVISOR_ROWS['advisor_email']?></td>
            <td style="text-align:center"><?php echo $DBOBJ->ConvertToText("tbl_setting_advisor_level","level_id","level_name",$ADVISOR_ROWS['advisor_level_id'])?></td>
    </tr>
    <?php } ?>
 

</table>
<br />

    <table width="99%" id="ExportTable" cellspacing="0" cellpadding="0" border="1" >
      <tr id="TH">
        <th width="33"><div align="center">#</div></th>
        <th width="82">ANN. DATE</th>
        <th width="318">CUSTOMER NAME</th>
        <th width="91">ID</th>
        <th width="135">MOBILE NO</th>
        <th width="119">PHONE NO</th>
        <th width="354">E-MAIL ADDRESS</th>
        <th width="110">CURRENT LEVEL</th>
      </tr>
      <?php 
	 	$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);	
		if(isset($_GET["limit"]))	{ $limit = $_GET["limit"];	}	else	{	$limit = 100;	}
		$startpoint = ($page * $limit) - $limit;		
		if(isset($_GET["page"])) { $k=($page-1)*($limit)+1; }	else $k=1;
		//----------------------------------------------------------		
		$CUSTOMER_QUERY="SELECT * FROM tbl_customer where month(customer_anniversary_date) between '$S_M' and '$E_M' AND day(customer_anniversary_date) between '$S_D' and '$E_D' ";
		$PAGINATION_QUERY=$CUSTOMER_QUERY."  order by customer_anniversary_date desc ";
		$CUSTOMER_QUERY=$PAGINATION_QUERY."  LIMIT {$startpoint} , {$limit}";	
		$CUSTOMER_QUERY=@mysqli_query($_SESSION['CONN'],$CUSTOMER_QUERY);	  
		$RECORD_FOUND=@mysqli_num_rows($CUSTOMER_QUERY);
	
		while($CUSTOMER_ROWS=@mysqli_fetch_assoc($CUSTOMER_QUERY)) 
		{
			
			if(date('d-M',strtotime($CUSTOMER_ROWS['customer_anniversary_date']))==date('d-M')) 
			{ 
			  echo "<style>#Data-Table #Today td { background:lightgreen; color:maroon; text-decoration:blink; font-style:italic; } </style>";
			}
     ?>
      <tr id="Today2">
        <td style="text-align:center;"><?php echo ++$j?>
          .</td>
        <td style="text-align:center"><?php echo date('d-M-Y',strtotime($CUSTOMER_ROWS['customer_anniversary_date']))?></td>
        <td><?php echo $CUSTOMER_ROWS['customer_name']?></td>
        <td style="text-align:center"><?php echo $CUSTOMER_ROWS['customer_code']?></td>
        <td style="text-align:center"><?php echo $CUSTOMER_ROWS['customer_mobile']?></td>
        <td style="text-align:center"><?php echo $CUSTOMER_ROWS['customer_phone']?></td>
        <td><?php echo $CUSTOMER_ROWS['customer_email']?></td>
        <td style="text-align:center"><?php echo $DBOBJ->ConvertToText("tbl_setting_advisor_level","level_id","level_name",$CUSTOMER_ROWS['advisor_level_id'])?></td>
      </tr>
      <?php } ?>
  </table>
</center>