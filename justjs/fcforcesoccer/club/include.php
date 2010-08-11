<?php

include_once(create_path("club/sql_club.php"));
include_once(create_path("club/tpl_club.php"));
include_once(create_path("club/lg_club_".LANG.".php"));


if(!isset($_GET['v1']))
{
 include(create_path("club/club_list.php"));
}
else
{
 switch($_GET['v1']) {
 case "form_club" :  include(create_path("club/form_club.php")); break;
 case "import_club" :  include(create_path("club/import_club.php")); break;
 case "club_list" :  include(create_path("club/club_list.php")); break;
 case "view" :  include(create_path("club/view_club.php")); break;
 default : include(create_path("club/club_list.php"));
 }
}

?>