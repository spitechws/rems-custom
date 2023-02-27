<?php
//======================( ADMIN USER MAIL )==========================
function UserMail($user_id,$password="...",$title="")
{
	if($title=="") { $title="Your login details of <b>'.site_company_name.' Account</b> as follows :"; }

	$DBOBJ = new DataBase();
    $DBOBJ->ConnectDatabase();	
	 $USER_ROW=$DBOBJ->GetRow("tbl_admin_user","user_id",$user_id);	
	 $ACTUAL_PHOTO="../SpitechUploads/admin/profile_photo/".$USER_ROW['user_photo'];
	
	 $address="";
	 if(address!="") 		{	$address.=address.", "; 	 }
	 if(mobile!="")  		 {	$address.="<br/>Mob : ".mobile.", ";    }
	 if(phone!="")   		  {	$address.="Phone : ".phone.",";  		  }
	 if(email!="")   		  {	$address.="<br/>Email : ".email.", ";   }
	 if(site_url_home!="")  {	$address.="Web : ".site_url_home;  		}
	 
	
	
	 $path="http://".site_application_url."SpitechUploads/admin/profile_photo/".$USER_ROW['user_photo'];
	 $exist=file_exists($ACTUAL_PHOTO);
	 if($exist!=1 || $USER_ROW['user_photo']=="") { $path= $path="http://".site_application_url."SpitechImages/Default.png";}	
$Message='
<table width="600" border="0" cellspacing="0" cellpadding="3" style="font-size:11px; font-family:Arial; border:5px solid #00933D;color:#035A9A" align="center">
  <tr bgcolor="#00933D">
     <th colspan="2" style=" margin:0px; padding:0px; text-align:center;border-bottom:5px solid #00933D;">
    <img src="http://'.site_application_url.'SpitechLogo/Logo.png" style="margin:0px;" height="60" width="200" />
    </th>
    <th colspan="2" style="color:white; text-shadow:1px 1px black; text-align:justify; vertical-align:top;padding-left:15px;">
    <font color=aqua style="font-size:16px; line-height:18px; ">'.site_company_name.'</font><br />
    <span style="font-size:10px;  line-height:11px;">'.$address.'</span>
    </th>
  </tr>
   <tr bgcolor="#C4FFC4">
    <td colspan="4" style="color:maroon; font-size:13px; border-bottom:5PX SOLID #00933D"><b>Login details of '.site_company_name.' account</b></td>
  </tr>
  
  <tr bgcolor="#EEEEEE">
    <td colspan="3" style="border-bottom:1px solid silver;">Date : <b>'.date('d/M/Y').'</b> <br> Time : <b>'.IndianTime().'</b></td>
    <td rowspan="3" style="text-align:right;border-bottom:1px solid #00933D;border-left:1px solid #00933D; background:#00933D; padding-top:0px; padding-right:0px;">
    <img src="'.$path.'" style="margin:0px; background:WHITE; padding-top:0px;" width="85" height="96" alt="PHOTO" />    </td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td width="20">&nbsp;</td>
    <td colspan="2">Dear User,<br>
      <b style="color:blue; margin-left:50px;">'.$USER_ROW["user_id"].'</b>,<br>
      <span style="margin-left:50px; color:MAROON">'.$USER_ROW["user_name"].'</span>,
      
    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3">'.$title.'</td>
  </tr>
  <tr>
    <td rowspan="5">&nbsp;</td>
    <td width="149" style="padding-left:40px;">Login Id    </td>
    <td colspan="2" style="width:450PX"><b style="color:blue;">'.$USER_ROW["user_id"].'</b></td>
  </tr>
  <tr>
    <td style="padding-left:40px;">Password</td>
    <td colspan="2"><b style="color:red;">'.$password.'</b></td>
  </tr>
  <tr>
    <td style="padding-left:40px;">Reg. Mobile No</td>
    <td colspan="2" style=" color:MAROON">'.$USER_ROW["user_mobile"].'</td>
  </tr>
  <tr>
    <td style="padding-left:40px;">Reg. Email Id</td>
    <td colspan="2" style=" color:MAROON">'.$USER_ROW["user_email_id"].'</td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3">Now you can change to manage your account : <a href="http://'.site_application_url.'App/" title="Go To Manage Account">Click Here...</a></td>
  </tr>
  <tr>
    <td colspan="4" style="border-bottom:1PX SOLID SILVER">&nbsp;</td>
  </tr>
 
  
  <tr bgcolor="#EEEEEE">
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td width="356" style="text-align:center;height:40px">Thanks!<br><b>'.site_company_name.'.</b></td>
    <td width="82"></td>
  </tr>
  
  </tr>
  <tr bgcolor="#00933D">
    <td colspan="4" style="text-align:right; font-size:9px; color:#eee">
     You are receiving this message because your are registered to <b>'.site_company_name.'. </b>
     This is an automatic generated email so don`t reply.
    </td>
  </tr>
</table>';

return $Message;

}




//======================( ADVISOR MAIL )==========================
function AdvisorMail($advisor_id,$password="...",$title="")
{
	$DBOBJ = new DataBase();
    $DBOBJ->ConnectDatabase();	
	
	if($title=="") { $title="Your login details of <b>'.site_company_name.' Account</b> as follows :"; }
	
	 $ADVISOR_ROW=$DBOBJ->GetRow("tbl_advisor","advisor_id",$advisor_id);	
	 $ACTUAL_PHOTO="../SpitechUploads/advisor/profile_photo/".$ADVISOR_ROW['advisor_photo'];
	 $level=$DBOBJ->ConvertToText("tbl_setting_advisor_level","level_id","level_name",$ADVISOR_ROW['advisor_level_id']);
	 
	 $address="";
	 if(address!="") 		{	$address.=address.", "; 	 }
	 if(mobile!="")  		 {	$address.="<br/>Mob : ".mobile.", ";    }
	 if(phone!="")   		  {	$address.="Phone : ".phone.",";  		  }
	 if(email!="")   		  {	$address.="<br/>Email : ".email.", ";   }
	 if(site_url_home!="")  {	$address.="Web : ".site_url_home;  		}
	 
	
	
	 $path="http://".site_application_url."SpitechUploads/advisor/profile_photo/".$ADVISOR_ROW['advisor_photo'];
	 $exist=file_exists($ACTUAL_PHOTO);
	 if($exist!=1 || $ADVISOR_ROW['advisor_photo']=="") { $path= $path="http://".site_application_url."SpitechImages/Advisor.png";}	
$Message='
<table width="600" border="0" cellspacing="0" cellpadding="3" style="font-size:11px; font-family:Arial; border:5px solid #00933D;color:#035A9A" align="center">
  <tr bgcolor="#00933D">
     <th colspan="2" style=" margin:0px; padding:0px; text-align:center;border-bottom:5px solid #00933D;">
    <img src="http://'.site_application_url.'SpitechLogo/Logo.png" style="margin:0px;" height="60" width="200" />
    </th>
    <th colspan="2" style="color:white; text-shadow:1px 1px black; text-align:justify; vertical-align:top;padding-left:15px;">
    <font color=aqua style="font-size:16px; line-height:18px; ">'.site_company_name.'</font><br />
    <span style="font-size:10px;  line-height:11px;">'.$address.'</span>
    </th>
  </tr>
   <tr bgcolor="#C4FFC4">
    <td colspan="4" style="color:maroon; font-size:13px; border-bottom:5PX SOLID #00933D"><b>Login details of '.site_company_name.' account</b></td>
  </tr>
  
  <tr bgcolor="#EEEEEE">
    <td colspan="3" style="border-bottom:1px solid silver;">Date : <b>'.date('d/M/Y').'</b> <br> Time : <b>'.IndianTime().'</b></td>
    <td rowspan="3" style="text-align:right;border-bottom:1px solid #00933D;border-left:1px solid #00933D; background:#00933D; padding-top:0px; padding-right:0px;">
    <img src="'.$path.'" style="margin:0px; background:WHITE; padding-top:0px;" width="85" height="96" alt="PHOTO" />    </td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td width="20">&nbsp;</td>
    <td colspan="2">Dear '.advisor_title.',<br>
      <b style="color:blue; margin-left:50px;">'.$ADVISOR_ROW["advisor_code"].'</b>,<br>
      <span style="margin-left:50px; color:MAROON">'.$ADVISOR_ROW["advisor_name"].' (<font color=blue>'.$level.'</font>) </span>,
      
    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3">'.$title.'</td>
  </tr>
  <tr>
    <td rowspan="5">&nbsp;</td>
    <td width="149" style="padding-left:40px;">Login Id    </td>
    <td colspan="2" style="width:450PX"><b style="color:blue;">'.$ADVISOR_ROW["advisor_code"].'</b></td>
  </tr>
  <tr>
    <td style="padding-left:40px;">Password</td>
    <td colspan="2"><b style="color:red;">'.$password.'</b></td>
  </tr>
  <tr>
    <td style="padding-left:40px;">Reg. Mobile No</td>
    <td colspan="2" style=" color:MAROON">'.$ADVISOR_ROW["advisor_mobile"].'</td>
  </tr>
  <tr>
    <td style="padding-left:40px;">Reg. Email Id</td>
    <td colspan="2" style=" color:MAROON">'.$ADVISOR_ROW["advisor_email"].'</td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3">Now you can change to manage your account : <a href="http://'.site_application_url.'Associates/" title="Go To Manage Account">Click Here...</a></td>
  </tr>
  <tr>
    <td colspan="4" style="border-bottom:1PX SOLID SILVER">&nbsp;</td>
  </tr>
 
  
  <tr bgcolor="#EEEEEE">
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td width="356" style="text-align:center;height:40px">Thanks!<br><b>'.site_company_name.'.</b></td>
    <td width="82"></td>
  </tr>
  
  </tr>
  <tr bgcolor="#00933D">
    <td colspan="4" style="text-align:right; font-size:9px; color:#eee">
     You are receiving this message because your are registered to <b>'.site_company_name.'. </b>
     This is an automatic generated email so don`t reply.
    </td>
  </tr>
</table>';

return $Message;

}

//======================( CUSTOMER MAIL )==========================
function CustomerMail($customer_id,$password="...",$title="")
{
	$DBOBJ = new DataBase();
    $DBOBJ->ConnectDatabase();	
	
	if($title=="") { $title="Your login details of <b>'.site_company_name.' Account</b> as follows :"; }
	
	 $CUSTOMER_ROW=$DBOBJ->GetRow("tbl_customer","customer_id",$customer_id);	
	 $ACTUAL_PHOTO="../SpitechUploads/customer/profile_photo/".$CUSTOMER_ROW['customer_photo'];
	
	 
	 $address="";
	 if(address!="") 		{	$address.=address.", "; 	 }
	 if(mobile!="")  		 {	$address.="<br/>Mob : ".mobile.", ";    }
	 if(phone!="")   		  {	$address.="Phone : ".phone.",";  		  }
	 if(email!="")   		  {	$address.="<br/>Email : ".email.", ";   }
	 if(site_url_home!="")  {	$address.="Web : ".site_url_home;  		}
	 
	
	
	 $path="http://".site_application_url."SpitechUploads/customer/profile_photo/".$CUSTOMER_ROW['customer_photo'];
	 $exist=file_exists($ACTUAL_PHOTO);
	 if($exist!=1 || $CUSTOMER_ROW['customer_photo']=="") { $path= $path="http://".site_application_url."SpitechImages/Customer.png";}	
$Message='
<table width="600" border="0" cellspacing="0" cellpadding="3" style="font-size:11px; font-family:Arial; border:5px solid #00933D;color:#035A9A" align="center">
  <tr bgcolor="#00933D">
     <th colspan="2" style=" margin:0px; padding:0px; text-align:center;border-bottom:5px solid #00933D;">
    <img src="http://'.site_application_url.'SpitechLogo/Logo.png" style="margin:0px;" height="60" width="200" />
    </th>
    <th colspan="2" style="color:white; text-shadow:1px 1px black; text-align:justify; vertical-align:top;padding-left:15px;">
    <font color=aqua style="font-size:16px; line-height:18px; ">'.site_company_name.'</font><br />
    <span style="font-size:10px;  line-height:11px;">'.$address.'</span>
    </th>
  </tr>
   <tr bgcolor="#C4FFC4">
    <td colspan="4" style="color:maroon; font-size:13px; border-bottom:5PX SOLID #00933D"><b>Login details of '.site_company_name.' account</b></td>
  </tr>
  
  <tr bgcolor="#EEEEEE">
    <td colspan="3" style="border-bottom:1px solid silver;">Date : <b>'.date('d/M/Y').'</b> <br> Time : <b>'.IndianTime().'</b></td>
    <td rowspan="3" style="text-align:right;border-bottom:1px solid #00933D;border-left:1px solid #00933D; background:#00933D; padding-top:0px; padding-right:0px;">
    <img src="'.$path.'" style="margin:0px; background:WHITE; padding-top:0px;" width="85" height="96" alt="PHOTO" />    </td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td width="20">&nbsp;</td>
    <td colspan="2">Dear Customer,<br>
      <b style="color:blue; margin-left:50px;">'.$CUSTOMER_ROW["customer_code"].'</b>,<br>
      <span style="margin-left:50px; color:MAROON">'.$CUSTOMER_ROW["customer_name"].'</span>,
      
    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3">'.$title.'</td>
  </tr>
  <tr>
    <td rowspan="5">&nbsp;</td>
    <td width="149" style="padding-left:40px;">Login Id    </td>
    <td colspan="2" style="width:450PX"><b style="color:blue;">'.$CUSTOMER_ROW["customer_code"].'</b></td>
  </tr>
  <tr>
    <td style="padding-left:40px;">Password</td>
    <td colspan="2"><b style="color:red;">'.$password.'</b></td>
  </tr>
  <tr>
    <td style="padding-left:40px;">Reg. Mobile No</td>
    <td colspan="2" style=" color:MAROON">'.$CUSTOMER_ROW["customer_mobile"].'</td>
  </tr>
  <tr>
    <td style="padding-left:40px;">Reg. Email Id</td>
    <td colspan="2" style=" color:MAROON">'.$CUSTOMER_ROW["customer_email"].'</td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3">Now you can change to manage your account : <a href="http://'.site_application_url.'Customer/" title="Go To Manage Account">Click Here...</a></td>
  </tr>
  <tr>
    <td colspan="4" style="border-bottom:1PX SOLID SILVER">&nbsp;</td>
  </tr>
 
  
  <tr bgcolor="#EEEEEE">
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td width="356" style="text-align:center;height:40px">Thanks!<br><b>'.site_company_name.'.</b></td>
    <td width="82"></td>
  </tr>
  
  </tr>
  <tr bgcolor="#00933D">
    <td colspan="4" style="text-align:right; font-size:9px; color:#eee">
     You are receiving this message because your are registered to <b>'.site_company_name.'. </b>
     This is an automatic generated email so don`t reply.
    </td>
  </tr>
</table>';

return $Message;

}

?>