<?php
include_once("../Menu/HeaderAdvisor.php");
include_once("../php/SpitechDB.php");
include_once("../php/SpitechUtility.php");
include_once("../php/SpitechPagination.php");
Menu("Home");
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
<link href="../css/SpitechStyle.css" rel="stylesheet" type="text/css" />
<h1><img src="../SpitechImages/Home.png" />Home  : <span>Birthday Reminder (<font>Upcomming Birthday</font>) </span>
<A style="float:right; margin-right:30px;" onclick="<?php ShowHide("FindForm","block"); ?>">
<img src="../SpitechImages/FindIcon.png" />Search</A>
</h1>
<table width="100%" border="0" align="center" cellspacing="0" cellpadding="0" id="Content">
  <tr>
    <td>
    
    <form name="FindForm" id="FindForm" method="get" style="display:<?php if(isset($_GET['Search'])) { echo "block;"; } else { echo "none;"; };?>">
      <table width="98%" border="0" cellspacing="0" cellpadding="0" id="SearchTable" style="margin-top:5px;">
        <tr>
          <td width="4%">from</td>
          <td width="8%" class="Date"><script>DateInput('s_date',true, 'yyyy-mm-dd','<?php echo $s_date?>');</script></td>
          <td width="6%" class="Date">TO</td>
          <td width="10%" class="Date"><script>DateInput('e_date',true, 'yyyy-mm-dd','<?php echo $e_date?>');</script></td>
          <td width="72%"><input type="submit" name="Search" value=" " id="Search" />
            <input type="button" name="ShowAll" value="Show All" id="ShowAll" class="Button"  onclick="window.location='Home.php'" style="width:80px;"/></td>
        </tr>
      </table>
    </form>
    <table width="99%" id="Data-Table" cellspacing="1" cellpadding="0" > 
	<tr>
        <th width="33"><div align="center">#</div></th>
        <th width="101">dob</th>
        <th width="299"><?php echo advisor_title?> NAME</th>
        <th width="91">ID</th>
        <th width="135">MOBile no</th>
        <th width="119">phone no</th>
        <th width="354">E-MAIL ADDRESS</th>
        <th width="110">CURRENT LEVEL</th>
        </tr>
	 <?php 
	 	$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);	
		if(isset($_GET["limit"]))	{ $limit = $_GET["limit"];	}	else	{	$limit = 100;	}
		$startpoint = ($page * $limit) - $limit;		
		if(isset($_GET["page"])) { $k=($page-1)*($limit)+1; }	else $k=1;
		//----------------------------------------------------------		
		$ADVISOR_QUERY="SELECT * FROM tbl_advisor where month(advisor_dob) between '$S_M' and '$E_M' AND day(advisor_dob) between '$S_D' and '$E_D' and advisor_id in (".$_SESSION['advisor_team'].") ";
		$PAGINATION_QUERY=$ADVISOR_QUERY."  order by advisor_dob desc ";
		$ADVISOR_QUERY=$PAGINATION_QUERY."  LIMIT {$startpoint} , {$limit}";	
		$ADVISOR_QUERY=@mysqli_query($_SESSION['CONN'],$ADVISOR_QUERY);	  
		$RECORD_FOUND=@mysqli_num_rows($ADVISOR_QUERY);
	
		while($ADVISOR_ROWS=@mysqli_fetch_assoc($ADVISOR_QUERY)) 
		{
			
			if(date('d-M',strtotime($ADVISOR_ROWS['advisor_dob']))==date('d-M')) 
			{ 
			  echo "<style>#Data-Table #Today td { background:lightgreen; color:maroon; text-decoration:blink; font-style:italic; } </style>";
			}
     ?>   
    <tr id="Today">
            <td style="text-align:center;"><?php echo ++$j?>.</td>
            <td style="text-align:center"><div align="center" style="width:90px;"><?php echo date('d-M-Y',strtotime($ADVISOR_ROWS['advisor_dob']))?></div></td>
            <td><?php echo $ADVISOR_ROWS['advisor_name']?></td>
            <td style="text-align:center"><?php echo $ADVISOR_ROWS['advisor_code']?></td>
            <td style="text-align:center"><?php echo $ADVISOR_ROWS['advisor_mobile']?></td>
            <td style="text-align:center"><?php echo $ADVISOR_ROWS['advisor_phone']?></td>
            <td><?php echo $ADVISOR_ROWS['advisor_email']?></td>
            <td style="text-align:center"><?php echo $DBOBJ->ConvertToText("tbl_setting_advisor_level","level_id","level_name",$ADVISOR_ROWS['advisor_level_id'])?></td>
        </tr>
    <?php } ?>
 

</table>
    <div class="paginate" align="center" ><?php pagination($PAGINATION_QUERY,$limit,$page, url());  ?></div><br />



    <table width="99%" id="Data-Table" cellspacing="1" cellpadding="0" >
      <tr>
        <th width="33"><div align="center">#</div></th>
        <th width="82">dob</th>
        <th width="318">CUSTOMER NAME</th>
        <th width="91">ID</th>
        <th width="135">MOBile no</th>
        <th width="119">phone no</th>
        <th width="354">E-MAIL ADDRESS</th>
        <th width="110">CURRENT LEVEL</th>
      </tr>
      <?php 
	 	$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);	
		if(isset($_GET["limit"]))	{ $limit = $_GET["limit"];	}	else	{	$limit = 100;	}
		$startpoint = ($page * $limit) - $limit;		
		if(isset($_GET["page"])) { $k=($page-1)*($limit)+1; }	else $k=1;
		//----------------------------------------------------------		
		$CUSTOMER_QUERY="SELECT * FROM tbl_customer where month(customer_dob) between '$S_M' and '$E_M' AND day(customer_dob) between '$S_D' and '$E_D' and customer_id in(select booking_customer_id from tbl_property_booking where booking_advisor_id in(".$_SESSION['advisor_team'].") group by booking_customer_id) ";
		$PAGINATION_QUERY=$CUSTOMER_QUERY."  order by customer_dob desc ";
		$CUSTOMER_QUERY=$PAGINATION_QUERY."  LIMIT {$startpoint} , {$limit}";	
		$CUSTOMER_QUERY=@mysqli_query($_SESSION['CONN'],$CUSTOMER_QUERY);	  
		$RECORD_FOUND=@mysqli_num_rows($CUSTOMER_QUERY);
	
		while($CUSTOMER_ROWS=@mysqli_fetch_assoc($CUSTOMER_QUERY)) 
		{
			
			if(date('d-M',strtotime($CUSTOMER_ROWS['customer_dob']))==date('d-M')) 
			{ 
			  echo "<style>#Data-Table #Today td { background:lightgreen; color:maroon; text-decoration:blink; font-style:italic; } </style>";
			}
     ?>
      <tr id="Today2">
        <td style="text-align:center;"><?php echo ++$j?>
          .</td>
        <td style="text-align:center"><?php echo date('d-M-Y',strtotime($CUSTOMER_ROWS['customer_dob']))?></td>
        <td><?php echo $CUSTOMER_ROWS['customer_name']?></td>
        <td style="text-align:center"><?php echo $CUSTOMER_ROWS['customer_code']?></td>
        <td style="text-align:center"><?php echo $CUSTOMER_ROWS['customer_mobile']?></td>
        <td style="text-align:center"><?php echo $CUSTOMER_ROWS['customer_phone']?></td>
        <td><?php echo $CUSTOMER_ROWS['customer_email']?></td>
        <td style="text-align:center"><?php echo $DBOBJ->ConvertToText("tbl_setting_advisor_level","level_id","level_name",$CUSTOMER_ROWS['advisor_level_id'])?></td>
      </tr>
      <?php } ?>
  </table>
<div class="paginate" ><?php pagination($PAGINATION_QUERY,$limit,$page, url());  ?></div></td>
  </tr>
</table>
<?php include("../Menu/FooterAdvisor.php"); ?>
