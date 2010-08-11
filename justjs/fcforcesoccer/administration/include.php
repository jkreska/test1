<?php

include_once(create_path("administration/tpl_administration.php"));
include_once(create_path("administration/lg_administration_".LANG.".php"));

if(!isset($_GET['v1']))
{
 if(!$right_user['home']) { 
  header("location:".convert_url("index.php?r=".$lang['general']['idurl_member']."&v1=form_connection")."");
  exit();
 }
 else { include(create_path("administration/home.php")); }
}
else
{
 switch($_GET['v1']) {
  case "admin" :  include(create_path("administration/admin.php")); break;
  case "configuration" :  include(create_path("administration/configuration.php")); break;
  case "menu-management" :  include(create_path("administration/menu_management.php")); break;
  case "right-management" :  include(create_path("administration/right_management.php")); break;
 }
}

?>