<?php
session_start();
if($_SESSION['customer_id']=="" || $_SESSION['customer_id']==NULL || $_SESSION['customer_name']=="" || $_SESSION['customer_name']==NULL) 
{ 
   header("location:index.php"); 
}
include_once("../php/SpitechDB.php");
include_once("../php/SpitechUtility.php");
include_once("../php/SpitechPagination.php");
include_once("../php/SpitechJS.php");
include_once("../Menu/Define.php");
include_once("../php/MailFunction.php");

$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();		
$SITE_ROW=@mysqli_fetch_assoc(@mysqli_query($_SESSION['CONN'],"select * from tbl_site_settings "));

?>

<title><?php echo site_heading?></title>
<link rel="shortcut icon" href="../SpitechLogo/icon.png" />
<link rel="icon" href="../SpitechLogo/icon.png" />


<?php if(strpos($_SERVER["HTTP_USER_AGENT"], 'MSIE')) { ?><link href="../css/SpitechMenuIE.css" rel="stylesheet" type="text/css" />  
<?php } else {?><link href="../css/SpitechMenu.css" rel="stylesheet" type="text/css" /><?php } ?>  
<link href="../css/SpitechStyle.css" rel="stylesheet" type="text/css" />   

<script type="text/javascript" src="../SpitechDTP/DTP.js"></script>
</head>

<body>
<?php function Menu($SelectedMenu)
{
	$DBOBJ = new DataBase();
	$DBOBJ->ConnectDatabase();	
	$USER_ROW=$DBOBJ->GetRow("tbl_customer","customer_id",$_SESSION['customer_id']);
	
	function SelectedMenu($Selected,$Menu)
	{
		if($Selected==$Menu) { echo ' id="Selected" '; }
	}
?>

<table width="100%" border="0" cellspacing="0" cellpadding="0" id="TopMenu">  
  <tr style="background:url(../SpitechImages/Top.png) repeat-x WHITE;">
    <td width="639" height="53" style="height:53px;">
    <div id="MyAccount" style="width:400px;">
        <h3 style="color:red; text-shadow:1px 1px black;">&nbsp;&nbsp;<?php echo site_company_name?></h3>
            <span class="UserName"><?php echo $_SESSION['customer_name']; ?></span>, 
            <br />            
            <span class="UserName">ID :</span> 
            <span class="UserID"><?php echo $_SESSION['customer_code']?></span>,
            <span class="UserName">Mob. :</span> 
            <span class="UserID"><?php echo $USER_ROW['customer_mobile'];?></span>
            <?php  
			  $ACTUAL_PHOTO="../SpitechUploads/customer/profile_photo/".$USER_ROW['customer_photo'];
			  $exist=file_exists($ACTUAL_PHOTO);
			  if($exist!=1 || $USER_ROW['customer_photo']=="") { $ACTUAL_PHOTO="../SpitechImages/Advisor.png";}
			?>
              
            <img src="<?php echo $ACTUAL_PHOTO; ?>" style="float:right; margin-left:100px; background:white;">
    </div>
    </td>
    
    <td width="402" id="MainMenu">
    <!--===================================( Initialize Sub Menu Here : )================================================================-->
    <script type="text/javascript" >
		function MenuHover(menu)
		{
			var MyMenuArray=["Home","User"];		
			for(var i=0; i<parseInt(MyMenuArray.length); i++)	
			{
				var MyID=MyMenuArray[i];
				document.getElementById(MyID).style.display="none";
			}		
			document.getElementById(menu).style.display="block";		
		}	
	</script>
   <!--===================================( End of Initialize Sub Menu )==========================================================-->
    <ul style="width:650px; margin-bottom:-5px;">      
       
        <li <?php if($SelectedMenu!='Home') { echo ' id="First" '; } Hover('Home'); 	SelectedMenu($SelectedMenu,"Home");?>>					
        	<a href="Default.php">Home</a>
        </li>
                    
        <li <?php  Hover('User'); SelectedMenu($SelectedMenu,"User");?>>
        	<a href="User.php">User</a>
        </li> 
        
        <li <?php if($SelectedMenu!='User') { echo ' id="Last" '; }?>>
        	<a href="LogOut.php">Log Out</a>
        </li>             
      
    </ul>
    
    </td>
    <td width="309" style="line-height:14px;">
<div style="width:150px;">
     <span style="color:#004080">Today : &nbsp;<font color="#66FF00"><?php echo date('d-M-Y'); ?></font></span><br>
     <span style="color:#004080">Time&nbsp;&nbsp;&nbsp;:&nbsp; 
     	<span  id="Timer" align="left" class="clockStyle UserName"  style="color:#0FF; font-weight:bolder;">&nbsp;</span>
     </span><br>
     <span  style="color:#004080">IP&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <font color="#66FF00">&nbsp;<?php echo GetIP(); ?></font></span>
</div>     

    </td>
  </tr>
  <tr id="SubMenu" style="height:52px;">
    <td colspan="3" style="height:60px;">       
        <style>
			#SubMenu #<?php echo $SelectedMenu; ?> { display:block; } 
			#SubMenu div { display:none; }
        </style>
     
          <div id="Home" style="padding-left:50px; text-align:center;"></div>
      <div align="center" id="User">
        <script>ShowModal("ChangePassword","700px","User_Change_Password.php","Change Password");</script>    
       	<a id="ChangePassword"><img src="../SpitechImages/ChangePassword.png"/>Change Password</a>      
        <a href="User.php" id="UserProfile"><img src="../SpitechImages/Customer.png"/>User Profile</a>       
  </div></td>
  </tr>
 
</table> 
 <!--<div style="1background:url(../SpitechImages/Top.png) repeat-x; height:5px; margin-top:-30px;"></div>-->
 
<style>
#PrintHeading { display:none; }
@media print 
{ 
 #PrintHeading { display:block; }
}
</style> 
<DIV id="PrintHeading" style="height:50px; width:100%; margin:0px; padding:0px; text-align:left;">
 <span style="font-size:18px; font-family:Times; font-weight:bolder; color:#D90000;">
 <img src="../SpitechLogo/Logo.png" style="height:40px; margin:5px 10px 5px 10px; margin-bottom:-10px; "><?php echo site_company_name?></span>
 <span style="float:right; margin-right:20px; margin-top:25px; font-weight:bolder; color:maroon;">Date : <?php echo date('d-M-Y').", ".IndianTime();?></span>
</DIV>
<?php } ?>



<?php function Hover($Menu)
{
	echo " onmouseover=\"MenuHover('".$Menu."'); \" ";
}
//Menu('Project');
?>