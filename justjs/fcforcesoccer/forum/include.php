<?php

include_once(create_path("forum/sql_forum.php"));
include_once(create_path("forum/tpl_forum.php"));
include_once(create_path("forum/lg_forum_".LANG.".php"));

if(!isset($_GET['v1']) OR $_GET['v1']=="")
{
 /* on est sur la page d'home des forums */
 include(create_path("forum/forum_list.php"));
}
else
{
 switch($_GET['v1'])
 {
   case "form_forum" : include(create_path("forum/form_forum.php")); break;
   case "forum_list" : include(create_path("forum/forum_list.php")); break;
   default : include(create_path("forum/view_forum.php"));
 }
}

?>