<?php
/**********/
/* EQUIPE */
/**********/

# position
$sql['team']['select_position']="SELECT position_id,position_name,position_order FROM ".T_position." ORDER BY position_order ASC";
$sql['team']['select_position_details']="SELECT * FROM ".T_position."  WHERE position_id='{id}' ";
$sql['team']['select_position_nb']="SELECT COUNT(*) AS nb FROM ".T_position." ";

$sql['team']['insert_position']="INSERT INTO ".T_position." (position_name,position_order) VALUES ('{name}','{order}')";

$sql['team']['edit_position']="UPDATE ".T_position." SET position_name='{name}', position_order='{order}' WHERE position_id='{id}';";

$sql['team']['edit_position_new_order']="UPDATE ".T_position." SET position_order='{order}' WHERE position_order='{new_order}' ";
$sql['team']['edit_position_order']="UPDATE ".T_position." SET position_order='{new_order}' WHERE position_id='{id}'";
$sql['team']['edit_position_order_insert']="UPDATE ".T_position." SET position_order=position_order+1 WHERE position_order >= '{order}' AND position_id!='{id}' ";
$sql['team']['edit_position_order_edit']="UPDATE ".T_position." SET position_order=position_order {signe} 1 WHERE position_order >= '{order_min}' AND position_order <= '{order_max}' AND position_id!='{id}' ";

$sql['team']['verif_position']="SELECT player_id FROM `".T_player."` WHERE position_id='{id}' UNION
SELECT team_id FROM `".T_team_player."` WHERE position_id='{id}'";
$sql['team']['verif_presence_position']="SELECT position_id FROM ".T_position." WHERE position_name='{name}' AND position_id!='{id}'";
$sql['team']['sup_position']="DELETE FROM ".T_position." WHERE position_id='{id}'";

# team_name
$sql['team']['select_team_name']="SELECT * FROM ".T_team_name." ORDER BY team_name_order ASC";
$sql['team']['select_team_name_details']="SELECT * FROM ".T_team_name." WHERE team_name_id='{id}' ";
$sql['team']['insert_team_name']="INSERT INTO ".T_team_name." (team_name_name,team_name_order) VALUES ('{name}','{ordre}');";
$sql['team']['edit_team_name']="UPDATE ".T_team_name." SET team_name_name='{name}' WHERE team_name_id='{id}'";
$sql['team']['verif_team_name']="SELECT team_id FROM `".T_team."` WHERE team_name_id='{id}'";
$sql['team']['verif_presence_team_name']="SELECT team_name_id FROM ".T_team_name." WHERE team_name_name='{name}' AND team_name_id!='{id}'";
$sql['team']['sup_team_name']="DELETE FROM ".T_team_name." WHERE team_name_id='{id}'";
$sql['team']['select_team_name_order']="SELECT max(team_name_order) AS max, min(team_name_order) as min FROM ".T_team_name."  ";
$sql['team']['edit_team_name_order']="UPDATE ".T_team_name." SET team_name_order='{ordre}' WHERE team_name_order='{ordre_nouveau}' ";
$sql['team']['edit_team_name_order_id']="UPDATE ".T_team_name." SET team_name_order='{ordre_nouveau}' WHERE team_name_id='{id}'";

# team
$sql['team']['select_team']="SELECT * FROM ".T_team." ";
$sql['team']['select_team_nb']="SELECT COUNT(e.team_id) AS nb
FROM ".T_team." AS e 
INNER JOIN ".T_team_name." AS ne ON e.team_name_id=ne.team_name_id
INNER JOIN ".T_club." AS c ON e.club_id=c.club_id
{condition} ";

$sql['team']['select_team_condition']="SELECT e.team_id, c.club_name, c.club_id, ne.team_name_name, ne.team_name_name, s.sex_id,s.sex_name,s.sex_abbreviation
FROM ".T_team." AS e 
INNER JOIN ".T_team_name." AS ne ON e.team_name_id=ne.team_name_id
INNER JOIN ".T_club." AS c ON e.club_id=c.club_id
LEFT JOIN ".T_sex." AS s ON e.sex_id=s.sex_id
{condition} {order} {limit} ";

$sql['team']['select_club_team_condition']="SELECT e.team_id, c.club_name, c.club_id, ne.team_name_name, ne.team_name_name, s.sex_id,s.sex_name,s.sex_abbreviation
FROM ".T_club." AS c 
LEFT JOIN ((".T_team." AS e 
INNER JOIN ".T_team_name." AS ne ON e.team_name_id=ne.team_name_id) 
LEFT JOIN ".T_sex." AS s ON e.sex_id=s.sex_id )
ON e.club_id=c.club_id ";

$sql['team']['select_team_details']="SELECT * FROM ".T_team." WHERE team_id='{id}'";
$sql['team']['insert_team']="INSERT INTO ".T_team." (team_name_id,club_id,sex_id) VALUES ('{team_name}','{club}','{sex}')";
$sql['team']['edit_team']="UPDATE ".T_team." SET team_name_id='{team_name}',club_id='{club}',sex_id='{sex}' WHERE team_id='{id}';";
$sql['team']['verif_team']="SELECT match_id FROM `".T_match."` WHERE team_visitor_id='{id}' OR team_home_id='{id}'";
$sql['team']['verif_presence_team']="SELECT team_id FROM ".T_team." WHERE team_name_id='{team_name}' AND club_id='{club}' AND sex_id='{sex}' AND team_id!='{id}'";
$sql['team']['sup_team']="DELETE FROM ".T_team." WHERE team_id='{id}'";

# team_coach
$sql['team']['select_team_coach']="SELECT s.season_name,s.season_abbreviation,m.member_id, m.member_lastname, m.member_firstname, ee.season_id, en.team_name_name, e.team_id, c.club_name, c.club_id
FROM ".T_member." AS m
INNER JOIN ".T_team_coach." AS ee  ON ee.member_id=m.member_id
INNER JOIN ".T_season." AS s ON s.season_id=ee.season_id
INNER JOIN ".T_team." AS e  ON e.team_id=ee.team_id
INNER JOIN ".T_team_name." AS en ON e.team_name_id=en.team_name_id
INNER JOIN ".T_club." AS c ON c.club_id=e.club_id
{condition} {order} {limit}";

$sql['team']['select_team_coach_nb']="SELECT COUNT(*) AS nb FROM ".T_team_coach." AS ee {condition}";

$sql['team']['insert_team_coach']="INSERT INTO ".T_team_coach." (team_id,member_id,season_id) VALUES {values} ";
$sql['team']['sup_team_coach']="DELETE FROM ".T_team_coach." WHERE team_id='{team}' ";

# team_player
$sql['team']['select_team_player']="SELECT s.season_name,s.season_abbreviation,m.member_id, m.member_lastname, m.member_firstname, ej.player_number, ej.season_id,  ej.player_captain, p.position_name, p.position_id, en.team_name_name, e.team_id, c.club_name, c.club_id
FROM ".T_team_player." AS ej 
INNER JOIN ".T_season." AS s ON s.season_id=ej.season_id
INNER JOIN ".T_member." AS m ON ej.member_id=m.member_id
INNER JOIN ".T_position." AS p ON ej.position_id=p.position_id
INNER JOIN ".T_team." AS e  ON e.team_id=ej.team_id
INNER JOIN ".T_team_name." AS en ON e.team_name_id=en.team_name_id
INNER JOIN ".T_club." AS c ON c.club_id=e.club_id
{condition} {order} {limit}";

$sql['team']['select_team_player_nb']="SELECT COUNT(*) AS nb FROM ".T_team_player." AS ej {condition}";

$sql['team']['insert_team_player']="INSERT INTO ".T_team_player." (team_id,position_id,member_id,season_id,player_number,player_captain) VALUES {values} ";

$sql['team']['sup_team_player']="DELETE FROM ".T_team_player." WHERE team_id='{team}' ";

# team_photo
$sql['team']['select_team_photo']="SELECT * FROM ".T_team_photo." {condition} ";

$sql['team']['insert_team_photo']="INSERT INTO ".T_team_photo." (team_id,season_id,photo,description) VALUES {values} ";
$sql['team']['sup_team_photo']="DELETE FROM ".T_team_photo." WHERE team_id='{team}' ";


?>