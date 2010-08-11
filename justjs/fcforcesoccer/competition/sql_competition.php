<?php
/****************/
/* COMPETITIONS */
/****************/
/* selection (liste)*/
$sql['competition']['select_competition']="SELECT competition_id,competition_name FROM ".T_competition." ORDER BY competition_name ASC";
$sql['competition']['select_competition_condition']="SELECT * FROM ".T_competition." {condition} {order} {limit}";
$sql['competition']['select_competition_round_condition']="SELECT r.*,c.* FROM ".T_competition." AS c LEFT JOIN ".T_round." AS r ON r.competition_id=c.competition_id  {condition} {order} {limit}";

$sql['competition']['select_competition_nb']="SELECT COUNT(*) AS nb FROM ".T_competition." ";
$sql['competition']['select_competition_details'] = "SELECT * FROM ".T_competition." WHERE competition_id='{id}'";
$sql['competition']['insert_competition']="INSERT INTO ".T_competition." (competition_name) VALUES ('{name}');";
$sql['competition']['edit_competition']="UPDATE ".T_competition." SET competition_name='{name}' WHERE competition_id='{id}';";
$sql['competition']['verif_competition']="SELECT match_id FROM ".T_match." WHERE competition_id='{id}'";
$sql['competition']['verif_presence_competition']="SELECT competition_id FROM ".T_competition." WHERE competition_name='{name}' AND competition_id!='{id}'";
$sql['competition']['sup_competition']="DELETE FROM ".T_competition." WHERE competition_id='{id}'";

# season
$sql['competition']['select_season']="SELECT * FROM ".T_season." ORDER BY season_date_start DESC";
$sql['competition']['select_season_date']="SELECT * FROM ".T_season." WHERE season_date_start <= '{date}' AND season_date_end > '{date}' ";
$sql['competition']['select_season_details']="SELECT * FROM ".T_season." WHERE season_id='{id}'";
$sql['competition']['insert_season']="INSERT INTO ".T_season." (season_name,season_abbreviation,season_date_start,season_date_end) VALUES ('{name}','{abbreviation}','{date_start}','{date_end}');";
$sql['competition']['edit_season']="UPDATE ".T_season." SET season_name='{name}',season_abbreviation='{abbreviation}',season_date_start='{date_start}',season_date_end='{date_end}' WHERE season_id='{id}';";
$sql['competition']['verif_season']="SELECT competition_id FROM ".T_competition." WHERE season_id='{id}'";
$sql['competition']['verif_presence_season']="SELECT season_id FROM ".T_season." WHERE season_name='{name}' AND season_id!='{id}'";
$sql['competition']['sup_season']="DELETE FROM ".T_season." WHERE season_id='{id}'";

# round
$sql['competition']['select_round']="SELECT * FROM ".T_round." WHERE competition_id='{competition}' ORDER BY round_order ASC";
$sql['competition']['select_round_count_match']="SELECT r.*, count(m.match_id) AS nb_match FROM ".T_round." AS r 
LEFT JOIN ".T_match." AS m ON m.round_id=r.round_id
WHERE r.competition_id='{competition}' 
GROUP BY r.round_id
ORDER BY r.round_order ASC";
$sql['competition']['select_first_round']="SELECT * FROM ".T_round." WHERE competition_id='{competition}' ORDER BY round_order ASC LIMIT 1";
$sql['competition']['select_round_details']="SELECT * FROM ".T_round." WHERE round_id='{id}' ";
$sql['competition']['insert_round']="INSERT INTO ".T_round." (competition_id,round_name, round_order, round_standings, point_win_at_home, point_win_away, point_tie_at_home, point_tie_away, point_defeat_at_home, point_defeat_away, order_team, order_team_egality, round_group, round_day) VALUES {values}";

$sql['competition']['edit_round']="UPDATE ".T_round." SET round_name='{name}', round_order='{order}', round_standings='{standings}', point_win_at_home='{point_win_at_home}', point_win_away='{point_win_away}', point_tie_at_home='{point_tie_at_home}', point_tie_away='{point_tie_away}', point_defeat_at_home='{point_defeat_at_home}', point_defeat_away='{point_defeat_away}', order_team='{order_team}', order_team_egality='{order_team_egality}', round_group='{group}', round_day='{day}' WHERE round_id='{id}' ";

$sql['competition']['delete_round']="DELETE FROM ".T_round." WHERE competition_id='{competition}'";
$sql['competition']['delete_round_notin']="DELETE FROM ".T_round." WHERE competition_id='{competition}' AND round_id NOT IN ('{round_id_list}')";

?>