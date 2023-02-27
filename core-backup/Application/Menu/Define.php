<?php
$DBOBJ = new DataBase();
$DBOBJ->ConnectDatabase();
$SITE_ROW=$DBOBJ->GetRow("tbl_site_settings","1","1");

define("site_name",$SITE_ROW['site_name']);
define("site_heading",$SITE_ROW['site_heading']);
define("site_icon",$SITE_ROW['site_icon']);
define("site_logo",$SITE_ROW['site_logo']);
define("site_url_home",$SITE_ROW['site_url_home']);
define("site_application_url",$SITE_ROW['site_application_url']);
define("site_company_name",$SITE_ROW['site_company_name']);
define("site_iso",$SITE_ROW['site_iso']);
define("site_copyright",$SITE_ROW['site_copyright']);
define("advisor_title",$SITE_ROW['advisor_title']);
define("id_prefix",$SITE_ROW['id_prefix']);
define("email",$SITE_ROW['email']);
define("phone",$SITE_ROW['phone']);
define("mobile",$SITE_ROW['mobile']);
define("address",$SITE_ROW['address']);

?>