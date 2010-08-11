<?php

include_once(create_path("plugin/link/tpl_link.php"));
include_once(create_path("plugin/link/lg_link_".LANG.".php"));
include_once(create_path("plugin/link/sql_link.php"));

include_once(create_path("plugin/link/conf.php"));

# we check if the plugin is installed
if($plugin_install!=1) 
{
 include(create_path("plugin/link/install.php"));
}
else
{
 if(!isset($_GET['v1']))
 {
  include(create_path("plugin/link/link_list.php"));
 }
 else
 {
  switch($_GET['v1']) {
   case "form_link" :  include(create_path("plugin/link/form_link.php")); break;
   case "link_list" :  include(create_path("plugin/link/link_list.php")); break;
   case "view" : include(create_path("plugin/link/view_link.php")); break;
   default : include(create_path("plugin/link/link_list.php"));
  }
 }
}
?>