<?php

include_once(create_path("match/sql_match.php"));
include_once(create_path("match/tpl_match.php"));
include_once(create_path("match/lg_match_".LANG.".php"));

if(!isset($_GET['v1']))
{
 include(create_path("match/match_list.php"));
}
else
{
 switch($_GET['v1']) {
 case "form_action_match" :  include(create_path("match/form_action_match.php")); break;
 case "form_referee_match" :  include(create_path("match/form_referee_match.php")); break;
 case "form_field" :  include(create_path("match/form_field.php")); break;
 case "form_match" :  include(create_path("match/form_match.php")); break;
 case "import_match" :  include(create_path("match/import_match.php")); break;
 case "view" :  include(create_path("match/view_match.php")); break;
 case "action_list" :  include(create_path("match/action_list.php")); break;
 case "field_state_list" :  include(create_path("match/field_state_list.php")); break;
 case "field_list" :  include(create_path("match/field_list.php")); break;
 case "weather_list" :  include(create_path("match/weather_list.php")); break;
 case "period_list" :  include(create_path("match/period_list.php")); break;
 case "match_list" :  include(create_path("match/match_list.php")); break; 
 case "stats_list" :  include(create_path("match/stats_list.php")); break;
 case "stats_player_list" :  include(create_path("match/stats_player_list.php")); break;
 case "standings" :  include(create_path("match/standings.php")); break; 
 case "mini_standings" :  include(create_path("match/mini_standings.php")); break; 
 case "stats_player" :  include(create_path("match/stats_player.php")); break;
 default : include(create_path("match/match_list.php"));
 }
}

?>