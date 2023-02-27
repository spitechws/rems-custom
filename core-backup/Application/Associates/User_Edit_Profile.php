<?php
session_start();
include_once("../php/Conn.php");
include_once("../php/SpitechDB.php");
include_once("../php/SpitechUtility.php");
include_once("../php/SpitechJS.php");
include_once("../SpitechMailer/SpitechMailer.php");
include_once("../Menu/HeaderCommon.php");
$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();

$USER_ROW=$DBOBJ->GetRow("tbl_advisor","advisor_id",$_SESSION["advisor_id"]);	

if(isset($_POST['Save']))
{
                 $advisor_photo=FileUpload($_FILES['advisor_photo'],"../SpitechUploads/advisor/profile_photo/","1");				 
				
				//=================( Checking ADVISOR's Photo )==============================================================
				  if(($advisor_photo=="" || $advisor_photo==NULL) && $_SESSION['advisor_id']>0 )
				  {
					  $advisor_photo=$USER_ROW['advisor_photo'];
				  }
				  if($_SESSION['advisor_id']>0 && $advisor_photo!=$USER_ROW['advisor_photo'])
				  {
				    @unlink("../SpitechUploads/advisor/profile_photo/".$USER_ROW['advisor_photo']);
				  }
				
 	
	  $FIELDS=array("advisor_sex" ,					
					"advisor_address" ,
					"advisor_mobile" ,
					"advisor_phone" ,
					"advisor_email" ,
					"advisor_bg" ,
					"advisor_dob" ,					
					"advisor_qualification" ,
					"advisor_occupation" ,
					"advisor_pan_no" ,
					"advisor_photo" ,									
					"edited_details");	
				   
	  $VALUES=array($_POST["advisor_sex"] ,					
					$_POST["advisor_address"] ,
					$_POST["advisor_mobile"] ,
					$_POST["advisor_phone"] ,
					$_POST["advisor_email"] ,
					$_POST["advisor_bg"] ,
					ReceiveDate("advisor_dob","POST") ,					
					$_POST["advisor_qualification"] ,
					$_POST["advisor_occupation"] ,
					$_POST["advisor_pan_no"] ,
					$advisor_photo,
					$_SESSION['advisor_code'].",Naman,".date('Y-m-d').",".IndianTime().",".GetIP()); 
					
		$DBOBJ->Update("tbl_advisor",$FIELDS,$VALUES,"advisor_id",$_SESSION['advisor_id'],0);			
		
		//=============( ENTRY IN ACTION TABLE )=======================================================
		$DBOBJ->UserAdvisorAction(advisor_title." PROFILE EDITED", " ID NO: ".$_SESSION['advisor_id'].", NAME : ".$_SESSION['advisor_name']);
			
			//=================(Message Body)===================================================================================
			    $title="Your profile of <b>".site_company_name."</b> account has successfully edited. Your profile details as follows :";
				$Message=AdvisorMail($_SESSION['advisor_id'],"...",$title)	;		
				@SendDirectMail($USER_ROW["advisor_email"],$Message,site_company_name." Application : Profile Edited",site_company_name);
			//====================================================================================================================
				
		$Message=advisor_title." PROFILE EDITED SUCCESSFULLY.";	
        header("location:User.php?Message".$Message);
}
?>
<link href="../css/SpitechStyle.css" rel="stylesheet" type="text/css" />
  
       <form name="AdvisorForm" id="AdvisorForm" method="post" enctype="multipart/form-data" action="User_Edit_Profile.php" >
        <table width="600" border="0" cellspacing="0" cellpadding="5" id="CommonTable" style="border:0px; margin-top:0px;">
         
            <tr>
              <td>&nbsp;</td>
              <td>id code ( user id ) </td>
              <td colspan="2" style="color:RED; font-size:16PX;"><?php echo $USER_ROW['advisor_code']?></td>
              <td></td>
            </tr>
         
           
            <tr>
              <td width="11">&nbsp;</td>
              <td width="179">name</td>
              <td colspan="2" style="font-size:13px; color:blue;"><?php echo $USER_ROW['advisor_title']." ".$USER_ROW['advisor_name'];?></td>
              <td width="11"></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>father's name</td>
              <td id="Value"><?php echo $USER_ROW['advisor_fname']; ?></td>
              <td width="73" rowspan="7" style="vertical-align:top;">
			  <?php $ACTUAL_PHOTO="../SpitechUploads/advisor/profile_photo/".$USER_ROW['advisor_photo'];
		  $exist=file_exists($ACTUAL_PHOTO);
		  if($exist!="1" || $USER_ROW['advisor_photo']=="") { $ACTUAL_PHOTO="../SpitechImages/Advisor.png"; }
		  
		 ?>
                <img src="<?php echo $ACTUAL_PHOTO; ?>" alt="Photo" width="124" height="130" id="imgBorder"/></td>
              <td></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>sex <b class="Required">&nbsp;<b class="Required">*</b></b></td>
              <td ><select id="advisor_sex" name="advisor_sex">
                <option value="MALE" <?php SelectedSelect("MALE", $USER_ROW['advisor_sex']); ?>>MALE</option>
                <option value="FEMALE" <?php SelectedSelect("FEMALE", $USER_ROW['advisor_sex']); ?>>FEMALE</option>
              </select></td>
              <td></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td style="line-height:13px; text-align:justify;">photo</td>
              <td width="227" style="vertical-align:top;" id="Value"><input type="file" name="advisor_photo" id="advisor_photo"  value="" /></td>
              <td></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td style="line-height:13px; text-align:justify;">BLOOD GROUP</td>
              <td style="vertical-align:top;"><input type="text" name="advisor_bg" id="advisor_bg" placeholder="BLOOD GROUP" value="<?php echo $USER_ROW['advisor_bg']; ?>" maxlength="25"/></td>
              <td></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td style="line-height:13px; text-align:justify;">mobile no&nbsp;<b class="Required">*</b></td>
              <td style="vertical-align:top;"><input type="text" name="advisor_mobile" id="advisor_mobile" placeholder="MOBILE NO" required="required" value="<?php echo $USER_ROW['advisor_mobile']; ?>" maxlength="10" <?php OnlyNumber(); ?>/></td>
              <td></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td style="line-height:13px; text-align:justify;">phone no</td>
              <td style="vertical-align:top;"><input type="text" name="advisor_phone" id="advisor_phone" placeholder="PHONE NO" value="<?php echo $USER_ROW['advisor_phone']; ?>" maxlength="12" <?php OnlyNumber(); ?>/></td>
              <td></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td style="line-height:13px; text-align:justify;">email id&nbsp;<b class="Required">*</b></td>
              <td style="vertical-align:top;"><input type="email" name="advisor_email" id="advisor_email" placeholder="EMAIL ID" required="required" value="<?php echo $USER_ROW['advisor_email']; ?>" maxlength="50" /></td>
              <td></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td style="line-height:13px; text-align:justify;">PAN NO</td>
              <td colspan="2" style="vertical-align:top;"><input type="text" name="advisor_pan_no" id="advisor_pan_no" placeholder="PAN NO" value="<?php echo $USER_ROW['advisor_pan_no']; ?>" maxlength="25" /></td>
              <td></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td style="line-height:13px; text-align:justify;">OCCUPATION&nbsp;<b class="Required">*</b></td>
              <td colspan="2" style="vertical-align:top;"><input type="text" name="advisor_occupation" id="advisor_occupation" placeholder="OCCUPATION" required="required" value="<?php echo $USER_ROW['advisor_occupation']; ?>" maxlength="50"/></td>
              <td></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td style="line-height:13px; text-align:justify;">educational&nbsp;qualification&nbsp;<b class="Required">*</b></td>
              <td colspan="2" style="vertical-align:top;"><input type="text" name="advisor_qualification" id="advisor_qualification" placeholder="QUALIFICATION" required="required" value="<?php echo $USER_ROW['advisor_qualification']; ?>" maxlength="50"/></td>
              <td></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td style="line-height:13px; text-align:justify;">address&nbsp;<b class="Required">*</b></td>
              <td colspan="2" style="vertical-align:top;">
              <textarea name="advisor_address" id="advisor_address" placeholder="ADDRESS"  maxlength="50" style="height:40px;"><?php echo $USER_ROW['advisor_address']; ?></textarea></td>
              <td></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td style="line-height:13px; text-align:justify;">date of BIRTH &nbsp;<b class="Required">*</b></td>
              <td colspan="2" class="Date" style="vertical-align:top;"><?php DateInput("advisor_dob",$USER_ROW['advisor_dob']);?></td>
              <td></td>
            </tr>
            
            <tr>
              <td colspan="5" style="text-align:RIGHT">
              <input type="submit" name="Save" id="Save" value="Save Profile" <?php Confirm("Are You Sure ? Save Profile Details ?"); ?>/>
              <input type="button" name="Cancel" id="Cancel" value="Cancel" onclick="window.location='User.php';" /></td>
            </tr>
         
        </table>
 </form>

