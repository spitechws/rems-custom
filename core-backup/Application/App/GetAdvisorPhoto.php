<?php
session_start();
include_once("../php/SpitechDB.php");
include_once("../php/SpitechUtility.php");
include_once("../Menu/Define.php");

//include_once("../php/SpitechJS.php");

	$DBOBJ = new DataBase();
	$DBOBJ->ConnectDatabase();
	$advisor_photo=$DBOBJ->ConvertToText("tbl_advisor","advisor_id","advisor_photo",$_GET["advisor_id"]);
    $ACTUAL_PHOTO="../SpitechUploads/advisor/profile_photo/".$advisor_photo;
		  $exist=file_exists($ACTUAL_PHOTO);
		  if($exist!="1" || $advisor_photo=="") { $ACTUAL_PHOTO="../SpitechImages/Advisor.png"; }?>
          <img src="<?php echo $ACTUAL_PHOTO;?>" alt="<?php echo advisor_title?>" width="107" height="107" id="imgBorder"/><br />
         <?php echo $DBOBJ->ConvertToText("tbl_advisor","advisor_id","advisor_name",$_GET['advisor_id']);?>	



 