
<link rel="stylesheet" href="../Modal/Demo.css" type="text/css" media="screen" title="no title" charset="utf-8">
<link rel="stylesheet" href="../Modal/SimpleModal.css" type="text/css" media="screen" title="no title" charset="utf-8">
<script src="../Modal/MooToolsCore_1.3.1.js" type="text/javascript" charset="utf-8"></script>
<script src="../Modal/MooToolsMore_1.3.1.1.js" type="text/javascript" charset="utf-8"></script>
<script src="../Modal/SimpleModal.js" type="text/javascript" charset="utf-8"></script>
<script src="../Modal/ModalFunction1s.js" type="text/javascript" charset="utf-8"></script> 

<?php
/* ==============================================( Javascript Based Functions Php & Javascript Both )====================================================
  ====================================================================================================================================================== */

function Alert($Message, $Location = "") {
    if (!$Location) {
        echo "<script language='javascript'>alert($Message);</script>";
    } else {
        echo "<script language='javascript'>alert('$Message');</script>";
        echo "<script language='javascript'>window.location='$Location';</script>";
    }
}

function Location($Location) {
    echo "<script language='javascript'>window.location='$Location';</script>";
}

function Confirm($Message) {
    echo " onclick=\"if(confirm('" . $Message . "'))  return true;  else  return false;\" ";
}

function onlyFloat() {
    echo ' onkeypress="return check_float(event)" ';
}

function onlyNumber() {
    echo ' onkeypress="return check_number(event)" ';
}

function onlyPercent() {
    echo ' onkeypress="return checkPercent(event)" ';
}

function onlyEmail() {
    echo ' onkeypress="validateEmail(this);" ';
}
?>
<script type="text/javascript">

    function GoToGpage(url, w, h, Reload)
    {
        var popupWindow = null;
        var left = (screen.width / 2) - parseInt(w / 2);
        var top = (screen.height / 2) - (h / 2);


        popupWindow = window.open(url, 'BedFord', 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=no, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);
        popupWindow.focus();

    }
</script>

<?php

function Modal($OpenPage = '', $Width = '700px', $Height = '500px') {
    echo " onclick=\"MyModal('$OpenPage','$Width','$Height');\" ";
}
?>
<script>
    function MyModal(OpenPage, Width, Height)
    {
        var Left = (screen.width / 2) - parseInt(Width / 2);
        var Top = (screen.height / 2) - (Height / 2);

        if (isNaN(Left))
        {
            Left = "300px";

        }
        if (isNaN(Top))
        {
            Top = "100px";
        }

        var hh, h;
        if (typeof (window.showModalDialog) == "undefined")
        {
            popupWindow = window.open(OpenPage, 'SpiTech', 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=no, width=' + Width + ', height=' + Height + ', top=' + Top + ', left=' + Left);
            popupWindow.focus();
        } else
        {
            showModalDialog(OpenPage, hh, 'dialogWidth:' + Width + ';dialogHeight:' + Height + ';dialogLeft:' + Left + ';dialogTop:' + Top + ';');
            window.opener.location.reload();
        }
    }

</script>        
<?php

function PopUp($OpenPage = '', $Width = '700px', $Height = '500px', $Left = '0px', $Top = '0px') {
    $Reload = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
    echo "<script>showModalDialog('$OpenPage','','dialogWidth:$Width;dialogHeight:$Height;dialogLeft:$Left;dialogTop:$Top;'); window.location='$Reload'; </script>";
}

function SelectedSelect($left, $right) {
    if ($left == $right) {
        echo " selected='selected' style='background:lightgreen; ' ";
    }
}

function unloadMe() {
    echo "<script>window.opener.location.reload();window.close();</script>";
}

function unload() {
    echo "window.opener.location.reload();window.close();";
}

function ShowHide($id = 'me', $display_style = 'block') {
    echo "
	if(document.getElementById('" . $id . "').style.display!='none') { document.getElementById('" . $id . "').style.display='none' } else { document.getElementById('" . $id . "').style.display='" . $display_style . "' } ; 
	";
}
?>

<script type="text/javascript">
    var checked = false;
    var frmname = '';
    function CheckedAll(frmname)
    {
        var valus = document.getElementById(frmname);
        if (checked == false)
        {
            checked = true;
        } else
        {
            checked = false;
        }
        for (var i = 0; i < valus.elements.length; i++)
        {
            valus.elements[i].checked = checked;
        }
    }
</script>


<script type="text/javascript">
    var checked = false;
    var frmname = '';
    function UnCheckedAll(frmname)
    {
        var valus = document.getElementById(frmname);
        if (checked == true)
        {
            checked = false;
        } else
        {
            checked = false;
        }
        for (var i = 0; i < valus.elements.length; i++)
        {
            valus.elements[i].checked = false;
        }
    }
</script>


<script>

    function getXMLHTTP()
    {
        var xmlhttp = false;
        try
        {
            xmlhttp = new XMLHttpRequest();
        } catch (e)
        {
            try
            {
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            } catch (e)
            {
                try
                {
                    xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
                } catch (e1)
                {
                    xmlhttp = false;
                }
            }
        }
        return xmlhttp;
    }

    function GetPage(strURL, ID)
    {
        if (ID != "Timer" && ID != "UserAct")
        {
            document.getElementById(ID).innerHTML = "<img src='../SpitechImages/Loader.gif' style='width:50px !important; height:12px !important; ' >";
        }
        var req = getXMLHTTP();
        if (req)
        {
            req.onreadystatechange = function ()
            {
                if (req.readyState == 4)
                {
                    if (req.status == 200)
                    {
                        //document.getElementById(ID).innerHTML=req.responseText;
                        //alert(req.responseText);
                        if (req.responseText == '1')
                        {
                            //window.location="../StudentCorner.php?Message=101";		
                        } else
                        {
                            document.getElementById(ID).innerHTML = req.responseText;
                        }
                    } else
                    {
                        //alert("Page : "+strURL+" Can No Be Loaded\n" + req.statusText);
                        document.getElementById(ID).innerHTML = "<blink><font color='red'>Error...</font></blink>";
                        //document.getElementById(ID).innerHTML="<img src='../SpitechImages/Loader.gif' style='width:12px !important;; height:12px !important; ' >";
                    }
                }
            }
            req.open("GET", strURL, true);
            req.send(null);
        }

    }
</script>	

<script language="javascript" type="text/javascript">

    function NumberFormat(rnum, rlength, field)
    {
        var newnumber = Math.round(rnum * Math.pow(10, rlength)) / Math.pow(10, rlength);
        return parseFloat(newnumber);
    }

    function getElementByAttributeValue(attribute, value)
    {
        var allElements = document.getElementsByTagName('*');
        for (var i = 0; i < allElements.length; i++)
        {
            if (allElements[i].getAttribute(attribute) == value)
            {
                allElements[i].class = "fValidate['required']";
            }
        }
    }


    function check_float(evt)
    {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 46 || charCode > 57))
            return false;

        return true;
    }

    function check_number(evt)
    {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

        return true;
    }

    function checkEmail(emailField)
    {
        var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;

        if (reg.test(emailField.value) == false)
        {
            alert('Invalid Email Address');
            return false;
        }

        return true;

    }

    function checkPercent(evt)
    {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode != '37')
            return false;

        return true;
    }
</script>
<script>
    function ShowModal(ID, Width, UrlToLoad, Heading)
    {
        window.addEvent("domready", function (e)
        {

            $(ID).addEvent("click", function (e)
            {
                e.stop();
                var SM = new SimpleModal({"btn_ok": "Confirm button", "width": Width});
                //SM.addButton("Cancel", "btn");      
                SM.show({"model": "modal-ajax", "title": Heading, "param": {"url": UrlToLoad, "onRequestComplete": function () { }}
                });
            });
        });

    }
</script>

<script>
    function ShowModalImage(ID, Width, UrlToLoad, Heading)
    {
        window.addEvent("domready", function (e)
        {
            $(ID).addEvent("click", function (e)
            {
                e.stop();
                var SM = new SimpleModal({"btn_ok": "Confirm button", "width": Width});
                //SM.addButton("Cancel", "btn");      
                SM.show({"model": "modal-ajax", "title": Heading, "param": {"url": UrlToLoad, "onRequestComplete": function () { }}
                });
            });
        });

    }
</script>
<?php

function RefreshPage($IntervalInMinuts = 0.5) {
    $IntervalInMicroSeconds = $IntervalInMinuts * 60000;
    echo "<script> setInterval('window.location.reload()', $IntervalInMicroSeconds);</script>";
}

function SpitechPleaseWait() {
    ?>
    <div id="PleaseWaitMe" style="background:black; background-size:cover; height:100%; width:100%; top:0px; left:0px; margin:0px; padding:0px; display:none; overflow:hidden; position:absolute; opacity: 0.7;filter: alpha(opacity=70); min-height:10000px;" align="center">

        <div style="top:250px; left:45%; color:white; font-weight:bolder; position:absolute; font-size:30px; text-decoration:blink;"><blink>Please Wait...</blink></div>

    </div>

    <script>
        function SpitechPleaseWait()
        {
            document.getElementsByTagName('body')[0].setAttribute('onunload', 'FormPleaseWait();');

            var body = document.body,
                    html = document.documentElement;
            //===================(Setting Height/Width)================================================
            var height = Math.max(body.scrollHeight, body.offsetHeight,
                    html.clientHeight, html.scrollHeight, html.offsetHeight);
            document.getElementById("PleaseWaitMe").style.height = height;

            var width = Math.max(body.scrollWidth, body.offsetWidth,
                    html.clientWidth, html.scrollWidth, html.offsetWidth);
            document.getElementById("PleaseWaitMe").style.width = width;
            document.getElementById("PleaseWaitMe").style.zIndex = '99999';
            //===================(Setting Height/Width)================================================	


        }
        function FormPleaseWait()
        {
            document.getElementById('PleaseWaitMe').style.display = 'block';
        }
        SpitechPleaseWait();
    </script>
    <?php
}

function FileImageInput($Name = "FileInput", $Default = "../SpitechImages/Default.png", $MaxSize = '100', $required = "", $Onchange = "", $Width = "200", $Type = "image/*") {
    ?>
    <input type="file" name="<?php echo $Name ?>" id="<?php echo $Name ?>" <?php echo $required ?>  onchange=" FileInfo(event); <?php echo $Onchange ?>" value="" style="width:<?php echo $Width ?>px !important"  accept='<?php echo $Type ?>'/>
    <div id="FileDetails<?php echo $Name ?>" style="color:#009EDF; font-size:9px; text-transform:none; line-height:10px; padding-right:40px"></div>
    <span id="TempPhoto<?php echo $Name ?>"></span>
    <div id="Error<?php echo $Name ?>" style="display:<?php echo none ?>; color:red; margin-top:2px;line-height:10px; font-size:9px; text-transform:none;">&nbsp;</div>
    <script>
        function FileInfo(evt)
        {

            var files = evt.target.files; // FileList object

            f = files[0];

            var NAME = f.name;
            var TYPE = f.type;
            var SIZE = f.size / 1024;

            var TYPE1 = TYPE.split("/");


            var Error = document.getElementById('Error<?php echo $Name ?>');
            var img = document.getElementById('img<?php echo $Name ?>');

            //==============(CHECK FILE TYPE)==========================
            if (TYPE1[0] != 'image')
            {

                //button.type='button'; button.style.display='none';  
                Error.style.display = 'block';
                Error.innerHTML = 'Please Select Image File Only : Jpg, Gif, PNG, BMP etc.';
            } else if (SIZE ><?php echo $MaxSize ?>)
            {
                //button.style.display='none'; button.type='button'; 
                Error.style.display = 'block';
                Error.innerHTML = 'Max Image Size : <font color=#009EDF><?php echo $MaxSize ?>KB</font>, Selected File Size : <font color=#009EDF>' + SIZE.toFixed(2) + 'KB</font>';
            } else
            {
                //button.style.display='inline-block'; button.type='submit'; 
                Error.innerHTML = '';
                Error.style.display = 'none';
            }



            if (img)
            {
                BrowseImage('<?php echo $Name ?>', 'img<?php echo $Name ?>', '<?php echo $Default ?>');
            } else
            {
                var imgTemp = "<img width='40' height='40' src='<?php echo $Default ?>' alt='Image' id='img<?php echo $Name ?>' style='margin-top:-25px; border:1px solid #444; background:white; float:right' />";
                document.getElementById('TempPhoto<?php echo $Name ?>').innerHTML = imgTemp;
            }


            document.getElementById('FileDetails<?php echo $Name ?>').innerHTML = "Type : " + TYPE + ", Size : " + SIZE.toFixed(2) + "KB "

            BrowseImage('<?php echo $Name ?>', 'img<?php echo $Name ?>', '<?php echo $Default ?>');



        }

        //---------------------------- SHOW IMAGE ------------------------------
        function BrowseImage(FileControlId, ImageId, DefaultSrc)
        {
            var input = document.getElementById(FileControlId);
            var fReader = new FileReader();
            fReader.readAsDataURL(input.files[0]);
            fReader.onloadend = function (event)
            {
                var img = document.getElementById(ImageId);
                var s = event.target.result;
                if (s != "" && s != null)
                {
                    img.src = event.target.result;
                } else
                {
                    img.src = DefaultSrc;
                }

            }
        }

    </script>	 
<?php }
?>
 
