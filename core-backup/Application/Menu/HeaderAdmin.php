<?php
if (!isset($_SESSION)) {
    session_start();
}
if ($_SESSION['user_id'] == "" || $_SESSION['user_id'] == NULL || $_SESSION['user_name'] == "" || $_SESSION['user_name'] == NULL || $_SESSION['user_category'] == "" || $_SESSION['user_category'] == NULL) {
    header("location:index.php");
}
include_once("../php/SpitechDB.php");
include_once("../php/SpitechUtility.php");
include_once("../php/SpitechPagination.php");
include_once("../php/SpitechJS.php");
include_once("../Menu/Define.php");
include_once("../php/MailFunction.php");
include_once("../php/ExportFunction.php");
$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();

if (strtoupper($_SESSION['user_category']) != "ADMIN") {
    ?>
    <style>
        .Delete, #Delete, .delete, #delete { display:none; visibility:hidden; } 
        .Action, #Action { display:none; visibility:hidden;}
    </style>
<?php } ?>

<title><?php echo site_heading ?></title>
<link rel="shortcut icon" href="../SpitechLogo/icon.png" />
<link rel="icon" href="../SpitechLogo/icon.png" />


<?php if (strpos($_SERVER["HTTP_USER_AGENT"], 'MSIE')) { ?><link href="../css/SpitechMenuIE.css" rel="stylesheet" type="text/css" />  
<?php } else { ?><link href="../css/SpitechMenu.css" rel="stylesheet" type="text/css" /><?php } ?>  
<link href="../css/SpitechStyle.css" rel="stylesheet" type="text/css" />  
<script type="text/javascript" src="../SpitechDTP/DTP.js"></script>
</head>

<body>
    <?php

    function Menu($SelectedMenu) {
        $DBOBJ = new DataBase();
        $DBOBJ->ConnectDatabase();
        $USER_ROW = $DBOBJ->GetRow("tbl_admin_user", "user_id", $_SESSION['user_id']);

        //=======================( DVR )===============================================
        $DVR_Q = "SELECT dvr_id from tbl_advisor_dvr where remind_date <= '" . date('Y-m-d') . "' and status='Enable' ";
        $DVR_Q = @mysqli_query($_SESSION['CONN'], $DVR_Q);
        $DVR = $DVR_Q = @mysqli_num_rows($DVR_Q);

        if ($DVR_Q > 0) {
            $DVR_Q = "<blink>(<font color='red'>" . $DVR_Q . "</font>)</blink>";
        } else {
            $DVR_Q = "";
        }

        //===============================================================================	
        //=======================(ENQUIRY)===============================================
        $ENQ_Q = "SELECT enquiry_id from tbl_enquiry where remind_date <= '" . date('Y-m-d') . "' and status='Enable'";
        $ENQ_Q = @mysqli_query($_SESSION['CONN'], $ENQ_Q);
        $ENQ_Q = @mysqli_num_rows($ENQ_Q);

        $DVR_ENQ = $ENQ_Q + $DVR;

        if ($DVR_ENQ > 0) {
            $DVR_ENQ = "(<font color='red'>" . $DVR_ENQ . "</font>)";
            $ENQ_Q = "(<font color='red'>" . $ENQ_Q . "</font>)";
        } else {
            $ENQ_Q = $DVR_ENQ = "";
        }

        //===============================================================================	

        function SelectedMenu($Selected, $Menu) {
            if ($Selected == $Menu) {
                echo ' id="Selected" ';
            }
        }
        ?>

        <table width="100%" border="0" cellspacing="0" cellpadding="0" id="TopMenu">  
            <tr style="background:url(../SpitechImages/Top.png) repeat-x WHITE;">
                <td width="475" height="53" style="height:53px;">
                    <div id="MyAccount">
                        <h3 style="color:red; text-shadow:1px 1px black;">&nbsp;&nbsp;<?php echo site_company_name ?></h3>
                        <span class="UserName"><?php echo $USER_ROW['user_name']; ?></span>, 
                        <br />            
                        <span class="UserName">ID :</span> 
                        <span class="UserID"><?php echo $_SESSION['user_id'] ?>, <?php echo $_SESSION['user_category'] ?></span>,
                        <span class="UserName">Mob. :</span> 
                        <span class="UserID"><?php echo $USER_ROW['user_mobile']; ?></span>
                        <?php
                        $ACTUAL_PHOTO = "../SpitechUploads/admin/profile_photo/" . $USER_ROW['user_photo'];
                        $exist = file_exists($ACTUAL_PHOTO);
                        if ($exist != 1 || $USER_ROW['user_photo'] == "") {
                            $ACTUAL_PHOTO = "../SpitechImages/Default.png";
                        }
                        ?>
                        <img src="<?php echo $ACTUAL_PHOTO; ?>" style="float:right; margin-left:20px;">
                    </div>
                </td>

                <td width="598" id="MainMenu">
                    <!--===================================( Initialize Sub Menu Here : )================================================================-->
                    <script type="text/javascript" >

                        renderTime();

                        function MenuHover(menu)
                        {
                            var MyMenuArray = ["Home", "Project", "Advisor", "Customer", "Expense", "User", "Settings", "Approval", "Reports", "Enquiry"];
                            for (var i = 0; i < parseInt(MyMenuArray.length); i++)
                            {
                                var MyID = MyMenuArray[i];
                                document.getElementById(MyID).style.display = "none";
                            }
                            document.getElementById(menu).style.display = "block";
                        }
                    </script>
                    <!--===================================( End of Initialize Sub Menu )==========================================================-->
                    <ul style="width:700px; margin-bottom:-5px;">      

                        <li <?php
                        if ($SelectedMenu != 'Home') {
                            echo ' id="First" ';
                        } Hover('Home');
                        SelectedMenu($SelectedMenu, "Home");
                        ?>>					
                            <a href="Default.php">Home</a>
                        </li>


                        <li <?php
                        Hover('Project');
                        SelectedMenu($SelectedMenu, "Project");
                        ?>>			
                            <a href="Projects.php">Project</a>
                        </li>

                        <li <?php
                        Hover('Advisor');
                        SelectedMenu($SelectedMenu, "Advisor");
                        ?>>			
                            <a href="Advisor.php"><?php echo advisor_title ?></a>
                        </li>

                        <li <?php
                        Hover('Customer');
                        SelectedMenu($SelectedMenu, "Customer");
                        ?>>			
                            <a href="Customer.php">Customer</a>
                        </li>


                        <li <?php
                        Hover('Expense');
                        SelectedMenu($SelectedMenu, "Expense");
                        ?>>			
                            <a href="Expenses.php">Expense</a>
                        </li>







                        <li <?php
                        Hover('Enquiry');
                        SelectedMenu($SelectedMenu, "Enquiry");
                        ?>>
                            <a href="Enquiry_Reminder.php">Enquiry<?php echo $DVR_ENQ ?></a>
                        </li> 

                        <li <?php
                        Hover('Reports');
                        SelectedMenu($SelectedMenu, "Reports");
                        ?>>			
                            <a href="Reports.php">Reports</a>
                        </li>

                        <?php
                        if (strtoupper($_SESSION['user_id']) == "ADMIN" && strtoupper($_SESSION['user_category']) == "ADMIN") {
                            ?>
                            <li <?php
                            Hover('Settings');
                            SelectedMenu($SelectedMenu, "Settings");
                            ?>>			
                                <a href="Settings.php">Settings</a>
                            </li>
                            <?php
                            $APP_Q = "SELECT booking_id  from tbl_property_booking where approved!='1' union all
		        SELECT payment_id  from tbl_property_booking_payments where approved!='1' union all
				SELECT payment_id  from tbl_advisor_payment where approved!='1'  ";
                            $APP_Q = @mysqli_query($_SESSION['CONN'], $APP_Q);
                            $APP_COUNT = mysqli_num_rows($APP_Q);

                            if ($APP_COUNT > 0) {
                                $APP = "<font class='rounded' style='color:AQUA; text-decoration:blink'><BLINK>(" . $APP_COUNT . ")</BLINK></font>";
                            }
                            ?>

                            <li <?php
                            Hover('Approval');
                            SelectedMenu($SelectedMenu, "Approval");
                            ?> style="width:90px;" >	

                                <a href="Approval.php">Approval&nbsp;<?php echo $APP ?></a>
                            </li>


                        <?php } ?>

                        <li <?php
                        if ($SelectedMenu != 'User') {
                            echo ' id="Last" ';
                        } Hover('User');
                        SelectedMenu($SelectedMenu, "User");
                        ?>>
                            <a href="User.php">User</a>
                        </li> 
                    </ul>

                </td>
                <td width="37" id="Export" style="vertical-align:middle;"><?php echo ExportPrintLink() ?></td>
                <td width="270" style="line-height:14px;">

                    <div style="width:170px;">
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
                <td colspan="4" style="height:60px;">       
                    <style>
                        #SubMenu #<?php echo $SelectedMenu; ?> { display:block; } 
                        #SubMenu div { display:none; }
                    </style>

                    <div id="Home" style="padding-left:50px; text-align:center;">        
                        <a href="Default.php"><img src="../SpitechImages/AwakenIcon.png"/>Token Payment Reminder</a> 
                        <a href="Report_Next_Payment_Date_Reminder.php"><img src="../SpitechImages/PaymentReminder.png"/>Next Payment Reminder</a> 
                        <a href="Home.php"><img src="../SpitechImages/BirthDay.png"/>Birthday Reminder</a>  
                        <a href="Home_Anniversary.php"><img src="../SpitechImages/Anniversary.png"/>Anniversary Reminder</a>          
                    </div>

                    <div id="Project" style="padding-left:50px; text-align:center;">           

                        <a href="Projects.php" ><img src="../SpitechImages/Project.png"/>Projects</a>

                        <a <?php Modal("Project_New.php", "700px", "1000px", "300px", "100px"); ?>>
                            <img src="../SpitechImages/NewProject.png"/>New Project</a> 

                        <a href="Project_Property_List.php" ><img src="../SpitechImages/Property.png"/>Property List</a>        
                        <a href="Project_Property_Booking.php" ><img src="../SpitechImages/PropertyBook.png"/>Book Property</a> 
                        <a href="Project_Booking_List.php" ><img src="../SpitechImages/PropertyBooked.png"/>Bookings</a>          
                        <a href="Project_Booking_Receive_Payment.php" ><img src="../SpitechImages/ReceivePayment.png"/>Receive Payment</a>    

                        <a href="Project_Booking_Deleted.php"><img src="../SpitechImages/BookingDeleted.png"/>Deleted Bookings</a>
                        <a href="Project_Booking_Cancelled.php"><img src="../SpitechImages/BookingCancelled.png"/>Cancelled Bookings</a>         
                    </div>


                    <div id="Advisor" style=" text-align:center;">
                        <a href="Advisor.php"><img src="../SpitechImages/Advisor.png"/><?php echo advisor_title ?> List</a>
                        <a href="Advisor_New.php"><img src="../SpitechImages/AdvisorNew.png"/>New <?php echo advisor_title ?></a>
                        <a href="Advisor_Tree.php"><img src="../SpitechImages/AdvisorTree.png"/>Tree</a>
                        <a href="Advisor_Payment_Entry.php"><img src="../SpitechImages/AdvisorPayment.png"/>Pay Commission</a>

                        <a href="Advisor_Commission_Status.php"><img src="../SpitechImages/AdvisorPayment.png"/>Commission Payment Status</a>

                        <a href="Advisor_Commission_Total_Commission.php"><img src="../SpitechImages/TotalCommission.png"/>Total Commission</a>
                        <a href="Advisor_Commission_All_Commission.php"><img src="../SpitechImages/AllCommission.png"/>All Commission</a>
                        <a href="Advisor_Commission_Project_And_Property.php"><img src="../SpitechImages/PropertyWiseCommission.png"/>Project/Property Wise Commission</a>


                    </div>

                    <div id="Customer" style=" text-align:center;">               
                        <a href="Customer.php"><img src="../SpitechImages/Customer.png">Customer List</a>
                        <a href="Customer_New.php"><img src="../SpitechImages/CustomerNew.png">New Customer</a>
                    </div>

                    <div id="Expense" style=" text-align:center;">
                        <a href="Expenses.php"><img src="../SpitechImages/Expense.png"/>Expenses</a>
                        <a <?php Modal("Expense_Entry.php", "510px", "510px", "200px", "100px"); ?>><img src="../SpitechImages/ExpenseAdd.png"/>Expense Entry</a>
                        <a href="Expense_Category.php"><img src="../SpitechImages/Expense.png"/>Expense Category</a>

                    </div>


                    <div id="Settings" style=" text-align:center;"></div>

                    <div id="Enquiry" style="padding-left:50px; text-align:center;">             
                        <a <?php Modal("Enquiry_New.php", "950px", "500px", "1000px", "100px"); ?>><img src="../SpitechImages/EnquiryNew.png"/>New Enquiry</a>  
                        <a href="Enquiry.php"><img src="../SpitechImages/Enquiry.png"/>Enquiry</a>   
                        <a href="Enquiry_Reminder.php"><img src="../SpitechImages/EnquiryReminder.png"/>Enquiry Reminder <?php echo $ENQ_Q ?></a> 

                        <a href="DVR.php"><img src="../SpitechImages/DVR.png"/>DVR List</a>   
                        <a href="DVR_Reminder.php"><img src="../SpitechImages/DVR_Reminder.png"/>DVR Reminder <?php echo $DVR_Q ?></a>     
                    </div>


                    <div id="Reports" style=" text-align:center;"></div>

                    <div align="center" id="User">
                        <script>ShowModal("ChangePassword", "700px", "User_Change_Password.php", "Change Password");</script>  
                        <a id="ChangePassword"><img src="../SpitechImages/ChangePassword.png"/>Change Password</a>


                        <a href="User.php" id="UserProfile"><img src="../SpitechImages/Default1.png"/>User Profile</a>

                        <?php if (strtoupper($_SESSION['user_id']) == "ADMIN" && strtoupper($_SESSION['user_category']) == "ADMIN") { ?>
                            <a href="User_Manage_User.php"><img src="../SpitechImages/Users.png"/>Manage User</a>

                            <a id="CreateNewUser"  <?php Modal("User_Create_User.php", "700px", "400px", "300px", "200px") ?> ><img src="../SpitechImages/AddCustomer.png" width="99"/>Create New User</a>
                            <a href="User_Daily_Activity.php"><img src="../SpitechImages/UsersActivity.png"/>User Activity</a>
                            <a href="User_Advisor_Daily_Activity.php"><img src="../SpitechImages/AdvisorActivity.png"/>Advisor Activity</a>


                        <?php } ?>

                    </div>
                    <div id="Approval"></div>
                </td>
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
                <img src="../SpitechLogo/Logo.png" style="height:40px; margin:5px 10px 5px 10px; margin-bottom:-10px; "><?php echo site_company_name ?></span>
            <span style="float:right; margin-right:20px; margin-top:25px; font-weight:bolder; color:maroon;">Date : <?php echo date('d-M-Y') . ", " . IndianTime(); ?></span>
        </DIV>

    <?php } ?>



    <?php

    function Hover($Menu) {
        echo " onmouseover=\"MenuHover('" . $Menu . "'); \" ";
    }

//Menu('Project');
    ?>