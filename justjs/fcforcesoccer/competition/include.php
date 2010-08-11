<?php
include_once(create_path("competition/sql_competition.php"));
include_once(create_path("competition/tpl_competition.php"));
include_once(create_path("competition/lg_competition_".LANG.".php"));

if(!isset($_GET['v1']))
{
 include(create_path("competition/competition_list.php"));
}
else
{
 switch($_GET['v1']) {
  case "form_competition" :  include(create_path("competition/form_competition.php")); break;
  case "view" :  include(create_path("competition/view_competition.php")); break;
  case "competition_list" :  include(create_path("competition/competition_round_list.php")); break;
  case "season_list" :  include(create_path("competition/season_list.php")); break;
  case "select_round" :  include(create_path("competition/select_round.php")); break;
  case "select_round_details" :  include(create_path("competition/select_round_details.php")); break;
  case "select_round_all_details" :  include(create_path("competition/select_round_all_details.php")); break;
  default : include(create_path("competition/competition_round_list.php"));
 }
}
?>