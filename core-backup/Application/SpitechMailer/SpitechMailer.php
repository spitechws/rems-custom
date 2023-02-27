<?php	
require("PHPMailer_5.2.0/class.phpmailer.php");
function SendDirectMail($tomail,$Message="",$Subject=site_company_name,$DisplayName=site_company_name,$ReplyTo="info@siddhibuildcon.in")
{


	if(APPTYPE!="LOCAL")
	{        
	    
	            $headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				
				// Additional headers
				$headers .= 'To: <'.$tomail.'>' . "\r\n";
				$headers .= 'From: '.$DisplayName.' <'.$ReplyTo.'>' . "\r\n";
				$headers .= 'Cc: '.$ReplyTo."\r\n";
				$headers .= 'Bcc: '.email."\r\n";
				
				//Mail it
				
				if(mail($tomail, $Subject,$Message, $headers)) 
				{ 
				   echo "Mail sent";
				}
				else
				{
					 echo "No sent";
				}
	}
	else
	{
		
		//=======================================( SENDING BY PHP MAILER CLASS )=============================================
			$mail = new PHPMailer();
			$mail->SMTPKeepAlive = true;  
			$mail->Mailer = "smtp"; 
			$mail->Port='465'; 
			$mail->SMTPSecure = "ssl"; 
			$mail->SMTPAuth   = true;   // enable SMTP authentication  
			$mail->CharSet = 'utf-8';  
			$mail->SMTPDebug  = 0;  
			$mail->IsSMTP();
			$mail->Host = "mail.spitech.co.in";  // specify main and backup server
			$mail->SMTPAuth = true;     // turn on SMTP authentication			
			/////////////////////////////////( USER NAME AND PASSWORD )///////////////////////////// 
			$email = "info@spitech.co.in";
			$mail->Username = $email;  // SMTP username
			$mail->Password ="info#123"; // SMTP password
			$mail->From = $email;
			$mail->AddReplyTo($email,$DisplayName);
			// below we want to set the email address we will be sending our email to.
			 $mail->AddAddress($tomail, $tomail);
			// set word wrap to 50 characters
			$mail->WordWrap = 50;
			// set email format to HTML
			$mail->IsHTML(true);			 
			$mail->Subject = $Subject;			
			$mail->Body    = $Message;			
			$mail->AltBody =$Message;			
			$mail->Subject =  $Subject;			
			$mail->FromName =$DisplayName;
		
				if(!$mail->Send())
				{  
					$rr= $mail->ErrorInfo;
					exit;
				}
		}
   
}

?>



