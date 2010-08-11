<?php

include_once(create_path("information/sql_information.php"));
include_once(create_path("information/lg_information_".LANG.".php"));
include_once(create_path("information/tpl_information.php"));

if(!isset($_GET['v1']) OR $_GET['v1']=="")
{
 include(create_path("information/page_list.php"));
}
else
{
 switch($_GET['v1']) {
 case "form_page" :  include(create_path("information/form_page.php")); break;
 case "page_list" :  include(create_path("information/page_list.php")); break;
 default : include(create_path("information/view_page.php"));
 }
}

?>