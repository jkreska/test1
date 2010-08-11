<?php

include_once(create_path("team/sql_team.php"));
include_once(create_path("team/tpl_team.php"));
include_once(create_path("team/lg_team_".LANG.".php"));


if(!isset($_GET['v1']))
{
 include(create_path("team/team_list.php"));
}
else
{
 switch($_GET['v1']) {
 case "form_team" :  include(create_path("team/form_team.php")); break;
 case "view" :  include(create_path("team/view_team.php")); break;
 case "team_list" :  include(create_path("team/team_list.php")); break;
 case "coach_list" :  include(create_path("team/team_coach_list.php")); break;
 case "player_list" :  include(create_path("team/team_player_list.php")); break;
 case "position_list" :  include(create_path("team/position_list.php")); break;
 case "team_name_list" :  include(create_path("team/team_name_list.php")); break;
 case "select_team_club" :  include(create_path("team/select_team_club.php")); break;
 default : include(create_path("team/team_list.php"));
 }
}

?>