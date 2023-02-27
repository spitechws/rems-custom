<?php
session_start();
if($_SESSION['advisor_id']=="" || $_SESSION['advisor_id']==NULL || $_SESSION['advisor_name']=="" || $_SESSION['advisor_name']==NULL) 
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
	$USER_ROW=$DBOBJ->GetRow("tbl_advisor","advisor_id",$_SESSION['advisor_id']);
	
	//=======================(DVR)===============================================
		$DVR_Q="SELECT dvr_id from tbl_advisor_dvr where remind_date <= '".date('Y-m-d')."' and status='Enable' and advisor_id='".$_SESSION['advisor_id']."'";
		$DVR_Q=@mysqli_query($_SESSION['CONN'],$DVR_Q);
		$DVR_Q=@mysqli_num_rows($DVR_Q);
			
			if($DVR_Q>0)
			{
				$DVR_Q="<blink>(<font color='red'>".$DVR_Q."</font>)</blink>";
			}
			else
			{
				$DVR_Q="";
			}
	//===============================================================================	
	
	function SelectedMenu($Selected,$Menu)
	{
		if($Selected==$Menu) { echo ' id="Selected" '; }
	}
?>

<table width="100%" border="0" cellspacing="0" cellpadding="0" id="TopMenu">  
  <tr style="background:url(../SpitechImages/Top.png) repeat-x WHITE;">
    <td width="496" height="53" style="height:53px;">
    <div id="MyAccount" style="width:400px;">
        <h3 style="color:red; text-shadow:1px 1px black;">&nbsp;&nbsp;<?php echo site_company_name?></h3>
            <span class="UserName"><?php echo $_SESSION['advisor_name']; ?></span>, 
            <br />            
            <span class="UserName">ID :</span> 
            <span class="UserID"><?php echo $_SESSION['advisor_code']?></span>,
            <span class="UserName">Mob. :</span> 
            <span class="UserID"><?php echo $USER_ROW['advisor_mobile'];?></span>
            <?php  
			  $ACTUAL_PHOTO="../SpitechUploads/advisor/profile_photo/".$USER_ROW['advisor_photo'];
			  $exist=file_exists($ACTUAL_PHOTO);
			  if($exist!=1 || $USER_ROW['advisor_photo']=="") { $ACTUAL_PHOTO="../SpitechImages/Advisor.png";}
			 
		  ?>
            <img src="<?php echo $ACTUAL_PHOTO; ?>" style="float:right; margin-left:80px;">
    </div>
    </td>
    
    <td width="537" id="MainMenu">
    <!--===================================( Initialize Sub Menu Here : )================================================================-->
    <script type="text/javascript" >
		function MenuHover(menu)
		{
			var MyMenuArray=["Home","Project","Advisor","Customer","DVR","User"];		
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
        
        <li <?php Hover('Project');SelectedMenu($SelectedMenu,"Project");?>>			
        	<a href="Projects.php">Projects</a>
        </li>
        
         <li <?php Hover('Advisor');SelectedMenu($SelectedMenu,"Advisor");?>>			
        	<a href="Advisor.php"><?php echo advisor_title?></a>
        </li>
        
        <li <?php Hover('Customer');SelectedMenu($SelectedMenu,"Customer");?>>			
        	<a href="Customer.php">Customer</a>
        </li>   
      
        <li <?php Hover('DVR'); SelectedMenu($SelectedMenu,"DVR");?>>
        	<a href="DVR_Reminder.php">DVR<?php echo $DVR_Q?></a>
        </li> 
         
        <li <?php if($SelectedMenu!='User') { echo ' id="Last" '; } Hover('User'); SelectedMenu($SelectedMenu,"User");?>>
        	<a href="User.php">User</a>
        </li> 
      
      
    </ul>
    
    </td>
    <td width="300" style="line-height:14px;">
<div style="width:150px;">
     <span style="color:#004080">Today : &nbsp;<font color="#66FF00"><?php echo date('d-M-Y'); ?></font></span><br>
     <span style="color:#004080">Time&nbsp;&nbsp;&nbsp;:&nbsp; 
     	<span  id="Timer" align="left" class="clockStyle UserName"  style="color:#0FF; font-weight:bolder;">&nbsp;</span>
     </span><br>
     <span  style="color:#004080">IP&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <font color="#66FF00">&nbsp;<?php echo GetIP(); ?></font></span>
</div>     
<a href="LogOut.php" style="float:right; margin-top:-40px;" title="Log Out"><img src="../SpitechImages/LogOut.png"></a>
    </td>
  </tr>
  <tr id="SubMenu" style="height:52px;">
    <td colspan="3" style="height:60px;">       
        <style>
			#SubMenu #<?php echo $SelectedMenu; ?> { display:block; } 
			#SubMenu div { display:none; }
        </style>
     
          <div id="Home" style="padding-left:50px; text-align:center;">      
               <a href="Default.php"><img src="../SpitechImages/Home.png"/>Home</a>  
               <a href="Token_Reminder.php"><img src="../SpitechImages/AwakenIcon.png"/>Token Payment Reminder</a> 
               <a href="Home.php"><img src="../SpitechImages/BirthDay.png"/>Birthday Reminder</a>     
                <a href="Home_Anniversary.php"><img src="../SpitechImages/Anniversary.png"/>Anniversary Reminder</a>        
          </div>
     
       <div id="Project" style="padding-left:50px; text-align:center;">             
        <a href="Projects.php" ><img src="../SpitechImages/Project.png"/>Projects</a>            
        <a href="Project_Property_List.php" ><img src="../SpitechImages/Property.png"/>Property List</a>          
        <a href="Project_Booking_List.php" ><img src="../SpitechImages/PropertyBooked.png"/>Bookings</a>           
       </div>  
      
      <div id="Advisor" style=" text-align:center;">
       <a href="Advisor.php"><img src="../SpitechImages/Advisor.png"/><?php echo advisor_title?> List</a>      
       <a href="Advisor_Tree.php"><img src="../SpitechImages/AdvisorTree.png"/>Tree</a>
       <a href="Advisor_Commission_Total_Commission.php"><img src="../SpitechImages/TotalCommission.png"/>Total Commission</a>
       <a href="Advisor_Commission_All_Commission.php"><img src="../SpitechImages/AllCommission.png"/>All Commission</a>
       <a href="Advisor_Commission_Project_And_Property.php"><img src="../SpitechImages/PropertyWiseCommission.png"/>Project/Property Wise Commission</a>   
      </div>
      
        <div id="Customer" style=" text-align:center;">               
               <a href="Customer.php"><img src="../SpitechImages/Customer.png">Customer List</a>              
        </div>
        
        <div id="DVR" style="padding-left:50px; text-align:center;">             
                 <a <?php Modal("DVR_New.php","950px", "500px", "1000px", "100px"); ?>><img src="../SpitechImages/DVR_New.png"/>DVR Entry</a>  
                 <a href="DVR.php"><img src="../SpitechImages/DVR.png"/>DVR List</a>   
                 <a href="DVR_Reminder.php"><img src="../SpitechImages/DVR_Reminder.png"/>DVR Reminder <?php echo $DVR_Q?></a>   
         </div>
         
       <div align="center" id="User">
       <script>ShowModal("ChangePassword","700px","User_Change_Password.php","Change Password");</script>    
       	<a id="ChangePassword"><img src="../SpitechImages/ChangePassword.png"/>Change Password</a>      
        <a href="User.php" id="UserProfile"><img src="../SpitechImages/Default1.png"/>User Profile</a>       
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