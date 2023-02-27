<?php 
function SendSMS($MobileNo,$Message)
{
$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();
$request = "";
if($MobileNo!="" || $MobileNo!=" " || $MobileNo!="0" || $MobileNo!=NULL || $Message!="" || $Message!=" " || $Message!="0" || $Message!=NULL )
{
	
	//=======UNCOMMENT HERE================	
	/*$MobileNo1="91".$MobileNo;
	$param["username"] = "spitechweb"; 
	$param["password"] = "micro#123"; 
	$param["to"] = $MobileNo1;
	$param["message"] = $Message;
	$param["unicode"] = "0";
	$param["sender"] ="SPTWEB"; 
	$param["reqid"] = "1";
	$param["msgtype"]="unicode";
	$url = "http://www.smssigma.com/API/WebSMS/Http/v1.0a/index.php";*/
	
	
	//==============(SET PARAMETER FROM DATABASE)============================
		$row=$DBOBJ->GetRow("tbl_spitech_sms_server","1","1");
		
		//===========(FIXED PARAMETER)==============
		$url = $row['sms_url']; 
		$MobileNo1=$row['mobile_prefix'].$MobileNo;
		$param[$row['mobile_parameter']] = $MobileNo1;
		$param[$row['message_parameter']] = $Message;
	
	    //===========(DYNAMIC PARAMETER)==============
		for($i=1;$i<6;$i++)
		{
			if($row['parameter'.$i]!="") { $param[$row['parameter'.$i]]=$row['value'.$i];  }
		}
	
	foreach($param as $key=>$val)
	{
		$request.= $key."=".urlencode($val);
		$request.= "&";
	}
	
	$request = substr($request, 0, strlen($request)-1); 
	
	//die($url."?".$request);
	//==========()====================
		if($row['sms']>0)
		{
			if($url=="") { echo "<script>alert('Please Set SMS Variables.');</script>"; }
			else
			{
				$ch = curl_init($url);
				curl_setopt($ch, CURLOPT_URL, $url); //set the url
				curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); //return as a variable
				curl_setopt($ch, CURLOPT_POST, 1); //set POST method
				curl_setopt($ch, CURLOPT_POSTFIELDS, $request); //set the POST variables
				$response = curl_exec($ch); //run the whole process and return the response
				curl_close($ch); //close the curl handle
				return $response;
			}
		}
	
	//=====================================
	
	}
}?>
