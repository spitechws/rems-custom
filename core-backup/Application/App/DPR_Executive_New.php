<?php include_once("../Menu/HeaderAdmin.php");
include_once("../php/SpitechDB.php");
include_once("../php/SpitechUtility.php");
include_once("../php/SpitechPagination.php");
include_once("../php/SpitechJS.php");
Menu("DPR");
NoUser();
$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();

$title="Register New Executive"; 
$date=date('Y-m-d');	

if(isset($_GET[md5('edit_id')]))
{
  $EDIT_ROW=$DBOBJ->GetRow("tbl_dpr_executive","id",$_GET[md5('edit_id')]);
  $title="Edit ".title." Profile"; 
  $date=$EDIT_ROW['date'];
}

if(isset($_POST['Save']))
{	
	
	  $photo=FileUpload($_FILES['photo'],"../SpitechUploads/executive/","1");		 
	
	//=================( Checking Student's Photo )==============================================================
	  if(($photo=="" || $photo==NULL) && $_GET[md5("edit_id")]>0 )
	  {
		  $photo=$EDIT_ROW['photo'];
	  }
	  if($_GET[md5("edit_id")]>0 && $photo!=$EDIT_ROW['photo'])
	  {
		  @unlink("../SpitechUploads/advisor/profile_photo/".$EDIT_ROW['photo']);
	  }
				
	
  	if(isset($_GET[md5("edit_id")]))
	{ 	
			$Error="";
			
			if(trim($_POST['mobile'])=="" || $_POST['mobile']==0)
			{
				$Error.="Invalid mobile number.<br/>";
			}
			if(trim($_POST['email'])=="" || $_POST['email']==0)
			{
				$Error.="Invalid email ID.<br/>";
			}
		
		//=================(CHECKING EXIST)======================
			$Q="SELECT id from tbl_dpr_executive where id!='".$_GET[md5("edit_id")]."' and email='".$_POST['email']."' ";
			$Q=@mysqli_query($_SESSION['CONN'],$Q);
			$EXIST_ROW=@mysqli_fetch_assoc($Q);
			$EXIST=$EXIST_ROW['id'];
			if($EXIST>0)
			{
				$Error.="Email ID already registered.<br/>";
			}		
			echo $Error;
			
			die($_POST['email']);
			
			if($Error=="")
			{
			  $FIELDS=array("title",
							"name",			
							"designation",				
							"address",
							"mobile",					
							"email",
							"whatsapp_no",					
							"date",					
							"photo",	
							"status",				
							"edited_details");	
						   
			  $VALUES=array($_POST["title"],
							$_POST["name"] ,	
							$_POST["designation"],						
							$_POST["address"] ,
							$_POST["mobile"] ,					
							$_POST["email"] ,
							$_POST["whatsapp_no"],					
							$_POST["date"] ,					
							$photo ,	
							$_POST["status"],			
							CreatedEditedByUserMessage());
						
			 $DBOBJ->Update("tbl_dpr_executive",$FIELDS,$VALUES,"id",$_GET[md5("edit_id")],0);
			 $MAX_ID=$_GET[md5("edit_id")];			
			 //=============( ENTRY IN ACTION TABLE )=======================================================
			 $DBOBJ->UserAction("EXECUTIVE PROFILE EDITED", "ID : ".$MAX_ID.", NAME : ".$_POST['name']);
					
			 $Message="EXECUTIVE PROFILE EDITED SUCCESSFULLY.";			
			 header("location:DPR_Executive.php?Message=".$Message);
		}
		else
		{
			header("location:DPR_Executive_New.php?".md5("edit_id")."=".$_GET[md5("edit_id")]."&Error=".$Error);
		}
	}
	else
	{
		
		//=================(CHECKING EXIST)======================
		    $Error="";
			$Q="SELECT id from tbl_dpr_executive where email='".$_POST['email']."' ";
			
			$Q=@mysqli_query($_SESSION['CONN'],$Q);
			$EXIST_ROW=@mysqli_fetch_assoc($Q);
			$EXIST=$EXIST_ROW['id'];
			if($EXIST>0)
			{
				$Error.="Email ID already registered.<br/>";
			}
			if($Error=="")
			{
				$FIELDS=array("title" ,
								"name" ,	
								"password",
								"designation",						
								"address",
								"mobile",					
								"email",
								"whatsapp_no",					
								"date" ,					
								"photo",	
								"status",		
								"created_details",
								"edited_details",
								"last_access_details");	
								
				$VALUES=array($_POST["title"],
								$_POST["name"] ,	
								md5($_POST["password"]),
								$_POST["designation"],						
								$_POST["address"],
								$_POST["mobile"],					
								$_POST["email"],
								$_POST["whatsapp_no"],					
								$_POST["date"],					
								$photo,	
								$_POST["status"],	
								$Mess=CreatedEditedByUserMessage(),
								$Mess,
								"");	
				$MAX_ID=$DBOBJ->Insert("tbl_dpr_executive",$FIELDS,$VALUES,0);		
			
				//=============( ENTRY IN ACTION TABLE )=======================================================
				$DBOBJ->UserAction("NEW EXECUTIVE REGISTERED", " ID : ".$MAX_ID.", NAME : ".$_POST['name']);		
				$Message="EXECUTIVE REGISTERED SUCCESSFULLY.";		
				header("location:DPR_Executive_New_Next.php?".md5("executive_id")."=".$MAX_ID."&".md5("password")."=".$_POST['password']."&Send=Yes");
			}
			else
			{
				header("location:DPR_Executive_New.php?Error=".$Error);
			}
	 }
}
?>
<link href="../css/SpitechStyle.css" rel="stylesheet" type="text/css" />
<center>
<h1><img src="../SpitechImages/ExecutiveNew.png" width="31" height="32" />DPR  : <span>New Executive Entry/Edit</span></h1>
<table width="100%" border="0" align="center" cellspacing="0" cellpadding="0" id="Content">
  <tr>
    <td align="center">
    <center>
      <script type="text/javascript" src="../SpitechDTP/DTP.js"></script>
    <center>
    <fieldset style="width:550px; margin:0px; padding:0px;">
   <legend><?php echo $title;?></legend>
    <?php MessageError(); ?>
<table width="500" border="0" cellspacing="0" cellpadding="5" id="CommonTable" style="border:0px; margin-top:0px;">
  
  <form name="AdvisorForm" id="AdvisorForm" method="post" enctype="multipart/form-data" >
    <?php  if(!isset($_GET[md5('edit_id')])) { ?>
    <tr>
      <td>&nbsp;</td>
      <td>PASSWORD &nbsp;<b class="Required">*</b></td>
      <td colspan="2">
      <input type="text" name="password" id="password" placeholder="PASSWORD" required="required" value="<?php echo RandomPassword(); ?>" maxlength="50"/>
      </td>
      <td></td>
    </tr>
    <?php } ?>
    
    <tr>
      <td width="11">&nbsp;</td>
      <td width="179">name <b class="Required">*</b></td>
      <td colspan="2">
        <div align="left" style="width:300PX;">
          <select id="title" name="title" style="width:60PX;">
            <option value="MR." <?php SelectedSelect("MR.", $EDIT_ROW['title']); ?>>MR.</option>
            <option value="MRS." <?php SelectedSelect("MRS.", $EDIT_ROW['title']); ?>>MRS.</option>
            <option value="MISS" <?php SelectedSelect("MISS", $EDIT_ROW['title']); ?>>MISS</option>
            <option value="ER." <?php SelectedSelect("ER.", $EDIT_ROW['title']); ?>>ER.</option>
            <option value="DR." <?php SelectedSelect("DR.", $EDIT_ROW['title']); ?>>DR.</option>
            </select>
          <input type="text" name="name" id="name" placeholder="FULL NAME" required="required" value="<?php echo $EDIT_ROW['name']; ?>" maxlength="50"/>
          </div>
        </td>
      <td width="11"></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>DESIGNATION&nbsp;<b class="Required">*</b></td>
      <td style="vertical-align:top;"><input type="text" name="designation" id="designation" placeholder="DESIGNATION" required="required" value="<?php echo $EDIT_ROW['designation']; ?>" maxlength="50"/></td>
      <td width="73" rowspan="6" style="vertical-align:top;">
        <?php $ACTUAL_PHOTO="../SpitechUploads/advisor/profile_photo/".$EDIT_ROW['photo'];
		  $exist=file_exists($ACTUAL_PHOTO);
		  if($exist!="1") { $ACTUAL_PHOTO="../SpitechImages/Advisor.png"; }
		  if(!isset($_GET[md5('edit_id')]) || $EDIT_ROW['photo']=="") { $ACTUAL_PHOTO="../SpitechImages/Advisor.png"; }
		 ?><img src="<?php echo $ACTUAL_PHOTO; ?>" alt="Photo" width="124" height="130" id="imgphoto" style="border:1px solid maroon"/>      </td>
      <td></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>photo</td>
      <td width="227" style="vertical-align:top;">
        
        <?php         FileImageInput("photo",$ACTUAL_PHOTO,100)
		?>
        
      </td>
      <td></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>mobile no&nbsp;<b class="Required">*</b></td>
      <td style="vertical-align:top;">
        <input type="text" name="mobile" id="mobile" placeholder="MOBILE NO" required="required" value="<?php echo $EDIT_ROW['mobile']; ?>" maxlength="10" <?php OnlyNumber(); ?>/>
        </td>
      <td></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Whats&nbsp;app&nbsp;no</td>
      <td style="vertical-align:top;">
        <input type="text" name="whatsapp_no" id="whatsapp_no" placeholder="WHATS APP NO" value="<?php echo $EDIT_ROW['whatsapp_no']; ?>" maxlength="10" <?php OnlyNumber(); ?>/>
        </td>
      <td></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td style="line-height:12px">email id&nbsp;<b class="Required">*</b>
      Will be used as login ID
      </td>
      <td style="vertical-align:top;">
        <input type="email" name="email" id="email" placeholder="EMAIL ID" required="required" value="<?php echo $EDIT_ROW['email']; ?>" maxlength="50" />
        </td>
      <td></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Address</td>
      <td style="vertical-align:top;">
        <textarea name="address" id="address" placeholder="ADDRESS"  maxlength="200"><?php echo $EDIT_ROW['address']; ?></textarea>
      </td>
      <td></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>HIRE DATE &nbsp;<b class="Required">*</b></td>
      <td colspan="2" class="Date" style="vertical-align:top;"><script>DateInput('date', true, 'yyyy-mm-dd', '<?php echo $date; ?>');</script></td>
      <td></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>status</td>
      <td colspan="2" style="color:RED;">
        <select id="status" name="status" <?php SelectedSelect("1", $EDIT_ROW['status']); ?>>
          <option value="1" <?php SelectedSelect("1", $EDIT_ROW['status']); ?>>ACTIVE</option>
          <option value="0" <?php SelectedSelect("0", $EDIT_ROW['status']); ?>>INACTIVE</option>
          </select>
        </td>
      <td>&nbsp;</td>
    </tr>
   
    <tr>
      <td colspan="5" style="text-align:RIGHT">
        <input type="submit" name="Save" id="Save" value="Save Details" <?php Confirm("Are You Sure ?\\n Save Details ?"); ?>/>
        <input type="button" name="Cancel" id="Cancel" value="Cancel" onClick="window.close();" />
        </td>
    </tr>
</form>

</table>
</fieldset>
</center>
</center></td></tr></table></center>
<?php include("../Menu/Footer.php"); ?>