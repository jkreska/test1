<?php
include_once(create_path("file/tpl_file.php"));
include_once(create_path("file/lg_file_".LANG.".php"));
include_once(create_path("file/conf.php"));

if(!isset($_GET['v1']) OR $_GET['v1']=="")
{
 include(create_path("file/file_manager.php"));
}
else
{
 switch($_GET['v1'])
 {
   case "file_manager" : include(create_path("file/file_manager.php")); break;
   default : include(create_path("file/file_manager.php"));
 }
}

?>