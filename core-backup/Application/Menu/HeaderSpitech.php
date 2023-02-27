<?php
session_start();
if($_SESSION['spitech_user_id']=="" || $_SESSION['spitech_user_id']==NULL || $_SESSION['spitech_user_name']=="" || $_SESSION['spitech_user_name']==NULL) 
{ 
   header("location:index.php"); 
}
include_once("../php/SpitechDB.php");
include_once("../php/SpitechUtility.php");
include_once("../php/SpitechPagination.php");
include_once("../php/SpitechJS.php");

$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();		



$SITE_ROW=@mysqli_fetch_assoc(@mysqli_query($_SESSION['CONN'],"select * from tbl_site_settings "));

?>

<title>Spitech Real Estate Marketting Application : </title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="../SpitechLogo/SpitechLogo.png" />
<link rel="icon" href="../SpitechLogo/SpitechLogo.png" />
<link href="../css/SpitechMenu.css" rel="stylesheet" type="text/css" />
<link href="../css/SpitechStyle.css" rel="stylesheet" type="text/css" />   
<?php if(strpos($_SERVER["HTTP_USER_AGENT"], 'MSIE')) { ?>
<style>
  h1 { padding-left:1%; width:100%;}
  h2 a { float:right; margin-right:20px; color:#0FF; margin-top:-30px; }
</style> 
<?php } else {?>
<style>
	h1   { padding-left:1%; width:99%;	 }
	h2 a { float:right; margin-right:20px; color:#0FF; }
</style>
<?php } ?>  
<script type="text/javascript" src="../SpitechDTP/DTP.js"></script>
</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0" id="TopMenu" >  
  <tr style="background:url(../SpitechImages/Top.png) repeat-x WHITE;">
    <td width="490" height="53" style="height:53px;">
    <div id="MyAccount">
        <h3 style="color:red; text-shadow:1px 1px black;">&nbsp;&nbsp;Spitech Pvt. Ltd.</h3>
            <span class="UserName"><?php echo $_SESSION['spitech_user_name']; ?></span>, 
            <br />            
            <span class="UserName">ID :</span> 
           <span class="UserID"><?php echo $_SESSION['spitech_user_id']?></span>,
            <span class="UserName">Mob. :</span> 
            <span class="UserID"><?php echo $USER_ROW['spitech_user_mobile'];?></span>
          
    </div>
    </td>
    
    <td width="663">&nbsp;</td>
   
    <td width="197" style="line-height:14px;">

<div style="width:150px;">
     <span style="color:#004080">Today : &nbsp;<font color="#000"><?php echo date('d-M-Y'); ?></font></span><br>
     <span style="color:#004080">Time&nbsp;&nbsp;&nbsp;:&nbsp; 
     	<span  id="Timer" align="left" class="clockStyle UserName"  style="color:#000; font-weight:bolder;">&nbsp;</span>
        <span id="UserAct"></span>
     </span><br>
     <span  style="color:#004080">IP&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <font color="#000">&nbsp;<?php echo GetIP(); ?></font></span>
</div>    

<a href="LogOut.php" style="float:right; margin-top:-40px;" title="Log Out"><img src="../SpitechImages/LogOut.png"></a>
    </td>
  </tr>
  
 
</table> 
