<?php
 include_once("../Menu/HeaderCommon.php");
 include_once("../php/SpitechDB.php");
 include_once("../php/SpitechUtility.php"); 
 include_once("../php/SpitechBulkSMS.php");
if($_SESSION['spitech_user_id']!="" || $_SESSION['spitech_user_id']!=NULL || $_SESSION['spitech_user_name']!="" || $_SESSION['spitech_user_name']!=NULL) 
{ 
   header("location:LogOut.php"); 
}
?>
<link rel="stylesheet" href="../css/SpitechStyle.css">
<style>
.table { background:url(../SpitechImages/AdminLoginBG.png) center repeat-y; height:auto; width:400px; margin-top:60px; padding:3px; border:2px solid #09F}
body { background:url(../SpitechImages/AdminLoginBodyBG.png); }
#CommonTable { width:320px; height:180px; border:0px solid #009AD0; margin-top:50px; color:white; text-transform:uppercase;}
#CommonTable tr td { background:none;color:white; text-transform:uppercase; font-weight:bolder; font-size:13px; }
h3 { line-height:80px; font-size:18px; font-variant:bolder;color:#3F6;text-shadow:2px 2px black; }
#user_id { color:#006090; border-radius:5px; background:white url(../SpitechImages/UserLoginBG.png) right no-repeat; padding-right:30px; padding-left:10px;}
#user_password { color:#006090; border-radius:5px; background:white url(../SpitechImages/UserLoginPWD.png) right no-repeat;padding-right:30px; padding-left:10px;}

h3 { line-height:80px; font-size:18px; font-variant:bolder;color:#3F6;text-shadow:2px 2px black; }
h5 { color:#8F1D0C; font-size:24px; font-family:Times; font-weight:bolder; margin:0px; margin-bottom:5px; }
</style>
<body style=" margin:0px; padding:0px;">

<center>
<div style="height:140px; width:100%;  margin:0px; padding:0px; margin-top:00px; background:#fff; border-bottom:5px double #AD6301">
<a onClick="window.location='index.php'">
<img src="../SpitechLogo/SpitechLogo.png" width="150" height="100" style="margin-top:5px; margin-bottom:0px;"/>

<h5>Spitech Personal Login</h5>
</a>

</div>
<div class="table">
<form name="LoginForm" id="LoginForm" method="post" action="LoginCheck.php" style="margin:0px;">
  <table width="98%" border="0" cellspacing="0" cellpadding="2" id="CommonTable" style="margin-top:0px;">
  <tr>
    <td height="22" colspan="2"><?php echo LoginError();?></td>
    </tr>
    <tr>
    <td width="81" height="22">User Name</td>
    <td width="56">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">
      <input type="text" name="user_id" id="user_id" placeholder="User ID" style="width:300px;"  required=""/>
      <script>user_id.focus();</script>
    </td>
    </tr>
  <tr>
    <td>password</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><input type="password" name="user_password" id="user_password" placeholder="Password" style="width:300px;" required/></td>
    </tr>
  <?php 
  if($_SESSION['spitech_captcha_attempt']>2) {
  ?>  
     <tr>
       <td colspan="2">

<table width="100" border="0" cellspacing="0" cellpadding="2" style="margin-top:3px;">

 <tr>
    <td colspan="4" style="text-align:left;">Enter&nbsp;security code</td>
    </tr>
    
    
  <tr>
    <td width="102" >
    <img id="siimage" style="border:1px solid#000; width:100px; height:30px;" src="../SpitechCaptcha/securimage_show.php?sid=<?php echo md5(uniqid()) ?>" alt="CAPTCHA Image" align="left">
    </td>
    
    
    <td width="20">
     <object type="application/x-shockwave-flash" data="../SpitechCaptcha/securimage_play.swf?bgcol=#ffffff&amp;icon_file=../SpitechCaptcha/images/audio_icon.png&amp;audio_file=../SpitechCaptcha/securimage_play.php" style="width:20px; height:20px;">
    <param name="movie" value="../SpitechCaptcha/securimage_play.swf?bgcol=#ffffff&amp;icon_file=../SpitechCaptcha/images/audio_icon.png&amp;audio_file=../SpitechCaptcha/securimage_play.php" />
    </object>
    </td>
    
    
    <td width="59" style="text-align:left">
    <a tabindex="-1" style="border-style: none;" href="#" title="Refresh Image" onClick="document.getElementById('siimage').src = '../SpitechCaptcha/securimage_show.php?sid=' + Math.random(); this.blur(); return false">
    <img src="../SpitechCaptcha/images/refresh.png" alt="Reload Image" onClick="this.blur()" align="bottom" border="0" style=" width:20px; height:20px;">
    </a>
    </td>
    <td width="59" style="text-align:left"><input type="text" name="user_captcha" id="user_captcha" size="12" maxlength="16" placeholder="Enter Code You See" style="width:140px;" required=''/></td>
  </tr>
  
 
</table>
       </td>
     </tr>
  <?php } ?>
  <tr>
    <td colspan="2">
      <div align="right">
         <input type="submit" name="Login" id="Login" value="Login" />
      </div>
    </td>
    </tr>
</table>
</form>
</div>

</center></body>