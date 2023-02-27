<?php
include_once("../Menu/HeaderCommon.php");
$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();
?>
<link rel="stylesheet" href="../css/SpitechStyle.css">
<style>
    .table { background:url(../SpitechImages/AdminLoginBG.png) center repeat-y; height:auto; width:400px; margin-top:60px; padding:3px; border:2px solid #615D5C}
    body { background:url(../SpitechImages/AdminLoginBodyBG.png); }
    #CommonTable { width:320px; height:180px; border:0px solid #009AD0; margin-top:50px; color:white; text-transform:uppercase;}
    #CommonTable tr td { background:none;color:white; text-transform:uppercase; font-weight:bolder; font-size:13px; }
    h3 { line-height:80px; font-size:18px; font-variant:bolder;color:#3F6;text-shadow:2px 2px black; }

    #new_password, #new_password_repeat { color:#006090; background:white url(../SpitechImages/UserLoginPWD.png) right no-repeat;padding-right:30px; padding-left:10px;}

    h3 { line-height:80px; font-size:18px; font-variant:bolder;color:#3F6;text-shadow:2px 2px black; }
</style>
<body style=" margin:0px; padding:0px;">

<center>
    <div style="height:80px; border-bottom:5px solid #DDBB72; text-align:center; margin:0px; background:#fff;">
        <a onClick="window.location = '../index.php'"><img src="../SpitechLogo/Logo.png" height="100" style="margin-top:5px; opacity:1;border:2px solid #DDBB72;background:#BAE9FA; "/></a></div>
    <div class="table">
        <?php
        if (isset($_GET[md5("reset_user_id")]) && isset($_GET[md5("expiry_date")])) {
            $USER_ROW = $DBOBJ->GetRow("tbl_admin_user", "md5(user_id)", $_GET[md5("reset_user_id")]);
            $user_id = $USER_ROW['user_id'];
            $Error = "";

            if ($user_id == "") {
                $Error .= "Invalid user id. ";
            }

            if ($_GET[md5("expiry_date")] < strtotime(date('Y-m-d H:i:s'))) {
                $Error .= "Session expired. ";
            }

            if ($Error == "") {


                if (isset($_POST['ChangePassword'])) {

                    if ($_POST['new_password'] == $_POST['new_password_repeat']) {

                        $FIELDS = array("user_password");
                        $VALUES = array(md5($_POST["new_password"]));
                        $UPDATE = $DBOBJ->Update("tbl_admin_user", $FIELDS, $VALUES, "user_id", $user_id, 0);

                        $title = 'Your password of ' . site_company_name . ' account has changed with following details :';
                        $Message = UserMail($user_id, $_POST["new_password"], $title);

                        SendDirectMail($USER_ROW['user_email_id'], $Message, site_company_name . " Application : Password Changed", site_company_name);

                        header("location:index.php?Message=Your+password+has+changed.");
                    } else {
                        header("location:" . $_SERVER['PHP_SELF'] . "?" . $_SERVER['QUERY_STRING'] . "&Error=New Password And Repeat Password Does Not Match");
                    }
                }
                ?>
                <form name="form1" id="form1" method="post">
                    <table width="98%" border="0" cellspacing="0" cellpadding="2" id="CommonTable" style="margin-top:0px;">
                        <tr>
                            <td height="22" style="text-align:center">USER Change Password : 
                                <hr/></td>
                        </tr>
                        <tr>
                            <td height="22"><?php ErrorMessage(); ?></td>
                        </tr>
                        <tr>
                            <td>LOGIN ID : 
                                <font color="#AB0B08"><?php echo $USER_ROW['user_id'] ?></font></td>
                        </tr>

                        <tr>
                            <td>NEW&nbsp;PASSWORD</td>
                        </tr>
                        <tr>
                            <td width="154"><input type="password" name="new_password" id="new_password" placeholder="NEW PASSWORD" style="width:100%" required/></td>
                        </tr>
                        <tr>
                            <td>REPEAT&nbsp;NEW&nbsp;PASSWORD</td>
                        </tr>
                        <tr>
                            <td><input type="password" name="new_password_repeat" id="new_password_repeat" placeholder="REPEAT NEW PASSWORD" style="width:100%" required/></td>
                        </tr>
                        <tr>
                            <td style="text-align:RIGHT">
                                <input type="submit" name="ChangePassword" id="ChangePassword" class="Button" value="Change Password" <?php Confirm("Are You Sure ? Change Password ?"); ?>/></td>
                        </tr>
                    </table>
                </form>
                <?php
            } else {
                ?>
                <div class="Error"><?php echo $Error ?></div>
                <?php
            }
        } else {
            ?>
            <div class="Error">Invalid entry.</div>
            <?php
        }
        ?>
    </div></center></body>