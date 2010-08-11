<?php
/**********/
/* MATCHS */
/**********/


$sql['match']['select_match_stat']="SELECT match_score_team_club,match_score_team_adverse,match_domicile
FROM ".T_match."
WHERE (match_score_team_club!='-1' OR match_score_team_adverse!='-1') ";


/* selection (details) */
$sql['match']['select_match_details'] = "SELECT * FROM ".T_match." WHERE match_id='{id}'";
$sql['match']['select_weather_details'] = "SELECT weather_name FROM ".T_weather." WHERE weather_id='{id}'";
$sql['match']['select_field_state_details']="SELECT field_state_id,field_state_name FROM ".T_field_state." WHERE field_state_id='{id}'";
$sql['match']['select_action_details'] = "SELECT action_name FROM ".T_action." WHERE action_id='{id}'";

/* insertion */
$sql['match']['insert_action_match']="INSERT INTO ".T_action_match." (match_id,action_id,player_id,minute_action,comment_action)
VALUES ('{match}','{action}','{player}','{minute}','{comment}');";
$sql['match']['insert_referee_match']="INSERT INTO ".T_match_referee." (match_id,referee_id) VALUES ('{match}','{referee}');";

$sql['match']['import_match']="INSERT INTO ".T_match." ({field}) VALUES ({values}) ";
$sql['match']['merge_match']="UPDATE ".T_match." SET {field_value} WHERE match_id='{id}'";


/* verification */
$sql['match']['verif_match']="(SELECT action_id FROM ".T_action_match." WHERE match_id='{id}')
UNION (SELECT referee_id FROM ".T_match_referee." WHERE match_id='{id}')";

/* suppression */
$sql['match']['sup_match_action']="DELETE FROM ".T_action_match." WHERE match_id='{match}' ";
$sql['match']['sup_match']="DELETE FROM ".T_match." WHERE match_id='{id}'";


# action
$sql['match']['select_action'] = "SELECT action_id,action_name FROM ".T_action." ORDER BY action_name ASC";
$sql['match']['insert_action']="INSERT INTO ".T_action." (action_name) VALUES ('{name}') ";
$sql['match']['edit_action']="UPDATE ".T_action." SET action_name='{name}' WHERE action_id='{id}' ";
$sql['match']['verif_action']="SELECT match_id FROM ".T_action_match." WHERE action_id='{id}'";
$sql['match']['verif_presence_action']="SELECT action_id FROM ".T_action." WHERE action_name='{name}' AND action_id!='{id}'";
$sql['match']['sup_action']="DELETE FROM ".T_action." WHERE action_id='{id}'";

# match_referee
$sql['match']['select_match_referee'] = "SELECT m.member_id,m.member_lastname,m.member_firstname FROM ".T_member." AS m INNER JOIN ".T_match_referee." AS ma ON m.member_id=ma.member_id WHERE match_id='{match}' ORDER BY m.member_lastname ASC";
$sql['match']['insert_match_referee']="INSERT INTO ".T_match_referee." (match_id,member_id) VALUES  {values} ";
$sql['match']['sup_match_referee']="DELETE FROM ".T_match_referee." WHERE match_id='{match}' ";

# match_player
$sql['match']['select_match_player'] = "SELECT m.member_id AS player_in_id,m.member_lastname AS player_in_name,m.member_firstname AS player_in_firstname, ms.member_id AS player_out_id,ms.member_lastname AS player_out_name,ms.member_firstname AS player_out_firstname, mj.*, mc.*, 
ej.team_id AS team_player_in_id, ej.player_number AS player_in_number, ej.player_captain AS player_in_captain, p.position_name AS player_in_position,
ejs.team_id AS team_player_out_id, ejs.player_number AS player_out_number, ejs.player_captain AS player_out_captain, ps.position_name AS player_out_position

FROM ".T_member." AS m INNER JOIN ".T_match_player." AS mj ON m.member_id=mj.player_in_id 
INNER JOIN ".T_match." AS ma ON mj.match_id=ma.match_id
LEFT JOIN ".T_member." AS ms ON ms.member_id=mj.player_out_id
LEFT JOIN ".T_member_club." AS mc ON mc.member_id = m.member_id
LEFT JOIN ".T_team_player." AS ej ON (ej.member_id = mj.player_in_id AND (ma.team_home_id=ej.team_id OR ma.team_visitor_id=ej.team_id))
LEFT JOIN ".T_position." AS p ON p.position_id = ej.position_id
LEFT JOIN ".T_team_player." AS ejs ON (ejs.member_id = mj.player_out_id AND (ma.team_home_id=ejs.team_id OR ma.team_visitor_id=ejs.team_id))
LEFT JOIN ".T_position." AS ps ON ps.position_id = ejs.position_id
WHERE mj.match_id='{match}' AND mc.season_id = '{season}' AND (ej.season_id IS NULL OR ej.season_id = '{season}')
AND (ejs.season_id IS NULL OR ejs.season_id = '{season}')
ORDER BY mj.minute_in ASC";

$sql['match']['insert_match_player']="INSERT INTO ".T_match_player." (match_id,player_in_id,player_out_id,minute_in,minute_out) VALUES  {values} ";
$sql['match']['edit_match_player']="UPDATE ".T_match_player." SET minute_out='{minute_out}' WHERE match_id='{match}' AND player_in_id='{player_in}' AND minute_in='{minute_in}' ";
$sql['match']['sup_match_player']="DELETE FROM ".T_match_player." WHERE match_id='{match}' ";


# field_state
$sql['match']['select_field_state']="SELECT field_state_id,field_state_name FROM ".T_field_state." ORDER BY field_state_name ASC";
$sql['match']['insert_field_state']="INSERT INTO ".T_field_state." (field_state_name) VALUES ('{name}');";
$sql['match']['edit_field_state']="UPDATE ".T_field_state." SET field_state_name='{name}' WHERE field_state_id='{id}';";
$sql['match']['verif_field_state']="SELECT match_id FROM ".T_match." WHERE field_state_id='{id}'";
$sql['match']['verif_presence_field_state']="SELECT field_state_id FROM ".T_field_state." WHERE field_state_name='{name}' AND field_state_id!='{id}'";
$sql['match']['sup_field_state']="DELETE FROM ".T_field_state." WHERE field_state_id='{id}'";

# weather
$sql['match']['select_weather']="SELECT weather_id,weather_name FROM ".T_weather." ORDER BY weather_name ASC";
$sql['match']['insert_weather']="INSERT INTO ".T_weather." (weather_name) VALUES ('{name}');";
$sql['match']['edit_weather']="UPDATE ".T_weather." SET weather_name='{name}' WHERE weather_id='{id}';";
$sql['match']['verif_weather']="SELECT match_id FROM ".T_match." WHERE weather_id='{id}'";
$sql['match']['verif_presence_weather']="SELECT weather_id FROM ".T_weather." WHERE weather_name='{name}' AND weather_id!='{id}'";
$sql['match']['sup_weather']="DELETE FROM ".T_weather." WHERE weather_id='{id}'";

# period
$sql['match']['select_period']="SELECT * FROM ".T_period." ORDER BY period_order ASC";
$sql['match']['select_period_details']="SELECT * FROM ".T_period." WHERE period_id='{id}'";
$sql['match']['insert_period']="INSERT INTO ".T_period." (period_name,period_order,period_length,period_required) VALUES ('{name}','{ordre}','{duration}','{required}');";
$sql['match']['edit_period']="UPDATE ".T_period." SET period_name='{name}',period_length='{duration}',period_required='{required}' WHERE period_id='{id}';";
$sql['match']['verif_period']="SELECT match_id FROM ".T_match_period." WHERE period_id='{id}'";
$sql['match']['verif_presence_period']="SELECT period_id FROM ".T_period." WHERE period_name='{name}' AND period_id!='{id}'";
$sql['match']['sup_period']="DELETE FROM ".T_period." WHERE period_id='{id}'";

$sql['match']['select_period_order']="SELECT max(period_order) AS max, min(period_order) as min FROM ".T_period."  ";
$sql['match']['edit_period_order']="UPDATE ".T_period." SET period_order='{ordre}' WHERE period_order='{ordre_nouveau}' ";
$sql['match']['edit_period_order_id']="UPDATE ".T_period." SET period_order='{ordre_nouveau}' WHERE period_id='{id}'";

# match_period
$sql['match']['select_match_period']="SELECT p.period_id, p.period_name, p.period_length, p.period_required, mp.match_id,mp.score_home,mp.score_visitor FROM ".T_period." AS p LEFT JOIN ".T_match_period." AS mp ON p.period_id=mp.period_id WHERE mp.match_id='{match}' OR mp.match_id IS NULL ORDER BY p.period_order ASC";
$sql['match']['insert_match_period']="INSERT INTO ".T_match_period." (match_id,period_id,score_home,score_visitor) VALUES {values}
";
$sql['match']['sup_match_period']="DELETE FROM ".T_match_period." WHERE match_id='{match}'";

# stats
$sql['match']['select_stats']="SELECT * FROM ".T_stats." ORDER BY stats_order ASC";
$sql['match']['select_stats_condition']="SELECT * FROM ".T_stats." {condition} {order}";
$sql['match']['select_stats_details']="SELECT * FROM ".T_stats." WHERE stats_id='{id}'";
$sql['match']['insert_stats']="INSERT INTO ".T_stats." (stats_name,stats_order,stats_abbreviation,stats_code,stats_formula) VALUES ('{name}','{ordre}','{abbreviation}','{code}','{formula}');";
$sql['match']['edit_stats']="UPDATE ".T_stats." SET stats_name='{name}',stats_abbreviation='{abbreviation}',stats_code='{code}',stats_formula='{formula}' WHERE stats_id='{id}';";
$sql['match']['verif_stats']="SELECT match_id FROM ".T_match_stats." WHERE stats_id='{id}'";
$sql['match']['verif_presence_stats']="SELECT stats_id FROM ".T_stats." WHERE (stats_abbreviation='{abbreviation}' OR stats_code='{code}') AND stats_id!='{id}'";
$sql['match']['sup_stats']="DELETE FROM ".T_stats." WHERE stats_id='{id}'";

$sql['match']['select_stats_order']="SELECT max(stats_order) AS max, min(stats_order) as min FROM ".T_stats."  ";
$sql['match']['edit_stats_order']="UPDATE ".T_stats." SET stats_order='{ordre}' WHERE stats_order='{ordre_nouveau}' ";
$sql['match']['edit_stats_order_id']="UPDATE ".T_stats." SET stats_order='{ordre_nouveau}' WHERE stats_id='{id}'";


# match_stats
$sql['match']['select_match_stats']="SELECT s.stats_id, s.stats_name, s.stats_abbreviation, s.stats_formula, ms.match_id,ms.value_home,ms.value_visitor FROM ".T_stats." AS s LEFT JOIN ".T_match_stats." AS ms ON s.stats_id=ms.stats_id
 WHERE  ms.match_id='{match}'
 ORDER BY s.stats_order ASC"; 

$sql['match']['insert_match_stats']="INSERT INTO ".T_match_stats." (match_id,stats_id,value_home,value_visitor) VALUES {values}
";
$sql['match']['sup_match_stats']="DELETE FROM ".T_match_stats." WHERE match_id='{match}'";


# stats_player
$sql['match']['select_stats_player']="SELECT * FROM ".T_stats_player." ORDER BY stats_player_order ASC";
$sql['match']['select_stats_player_condition']="SELECT * FROM ".T_stats_player." {condition} {order}";
$sql['match']['select_stats_player_details']="SELECT * FROM ".T_stats_player." WHERE stats_player_id='{id}'";
$sql['match']['insert_stats_player']="INSERT INTO ".T_stats_player." (stats_player_name,stats_player_order,stats_player_abbreviation,stats_player_code,stats_player_formula) VALUES ('{name}','{ordre}','{abbreviation}','{code}','{formula}');";
$sql['match']['edit_stats_player']="UPDATE ".T_stats_player." SET stats_player_name='{name}',stats_player_abbreviation='{abbreviation}',stats_player_code='{code}',stats_player_formula='{formula}' WHERE stats_player_id='{id}';";
$sql['match']['verif_stats_player']="SELECT match_id FROM ".T_match_stats_player." WHERE stats_player_id='{id}'";
$sql['match']['verif_presence_stats_player']="SELECT stats_player_id FROM ".T_stats_player." WHERE (stats_player_abbreviation='{abbreviation}' OR stats_player_code='{code}') AND stats_player_id!='{id}'";
$sql['match']['sup_stats_player']="DELETE FROM ".T_stats_player." WHERE stats_player_id='{id}'";

$sql['match']['select_stats_player_order']="SELECT max(stats_player_order) AS max, min(stats_player_order) as min FROM ".T_stats_player."  ";
$sql['match']['edit_stats_player_order']="UPDATE ".T_stats_player." SET stats_player_order='{ordre}' WHERE stats_player_order='{ordre_nouveau}' ";
$sql['match']['edit_stats_player_order_id']="UPDATE ".T_stats_player." SET stats_player_order='{ordre_nouveau}' WHERE stats_player_id='{id}'";

# match_stats_player
$sql['match']['select_match_stats_player']="SELECT s.stats_player_id, s.stats_player_name, s.stats_player_abbreviation, s.stats_player_formula, ms.match_id,ms.member_id,ms.value, m.member_lastname, m.member_firstname FROM ".T_stats_player." AS s 
LEFT JOIN ".T_match_stats_player." AS ms ON s.stats_player_id=ms.stats_player_id
LEFT JOIN ".T_member." AS m ON m.member_id=ms.member_id
 WHERE  ms.match_id='{match}'
 ORDER BY m.member_id,s.stats_player_order ASC"; 

$sql['match']['insert_match_stats_player']="INSERT INTO ".T_match_stats_player." (match_id,stats_player_id,member_id,value) VALUES {values}
";
$sql['match']['sup_match_stats_player']="DELETE FROM ".T_match_stats_player." WHERE match_id='{match}'";


# action_match
$sql['match']['select_action_match']="SELECT am.*, m.member_lastname, m.member_firstname, a.action_name FROM ".T_action_match." AS am
INNER JOIN ".T_member." AS m ON m.member_id=am.player_id
INNER JOIN  ".T_action." AS a ON a.action_id=am.action_id
LEFT JOIN ".T_member_club." AS mc ON mc.member_id = m.member_id
WHERE match_id='{match}' AND mc.season_id = '{season}' 
ORDER BY am.minute_action ASC";
$sql['match']['insert_action_match']="INSERT INTO ".T_action_match." (match_id,player_id,action_id,minute_action,comment_action) VALUES {values} ";
$sql['match']['sup_action_match']="DELETE FROM ".T_action_match." WHERE match_id='{match}' ";

# match
$sql['match']['select_match_nb']="SELECT COUNT(*) AS nb FROM ".T_match." AS m {condition} ";

$sql['match']['select_match_condition']="SELECT m.*, co.competition_name, cr.club_name AS club_home_name, cr.club_abbreviation AS club_home_abbreviation, cv.club_name AS club_visitor_name, cv.club_abbreviation AS club_visitor_abbreviation, ner.team_name_name AS team_home_name, nev.team_name_name AS team_visitor_name, sr.sex_abbreviation AS sex_home_abbreviation, sr.sex_name AS sex_home_name, sv.sex_abbreviation AS sex_visitor_abbreviation, sv.sex_name AS sex_visitor_name FROM ".T_match." AS m
INNER JOIN ".T_club." AS cr ON cr.club_id=m.club_home_id
INNER JOIN ".T_club." AS cv ON cv.club_id=m.club_visitor_id
LEFT JOIN ".T_team." AS er ON er.team_id=m.team_home_id
LEFT JOIN ".T_team_name." AS ner ON ner.team_name_id=er.team_name_id
LEFT JOIN ".T_team." AS ev ON ev.team_id=m.team_visitor_id
LEFT JOIN ".T_team_name." AS nev ON nev.team_name_id=ev.team_name_id
LEFT JOIN ".T_sex." AS sr ON er.sex_id=sr.sex_id
LEFT JOIN ".T_sex." AS sv ON ev.sex_id=sv.sex_id
LEFT JOIN ".T_competition." AS co ON co.competition_id=m.competition_id
{condition} {order} {limit}";

$sql['match']['select_match_stat']="SELECT m.match_score_visitor,m.match_score_home,m.club_home_id,m.club_visitor_id FROM ".T_match." AS m
INNER JOIN ".T_club." AS cr ON cr.club_id=m.club_home_id
INNER JOIN ".T_club." AS cv ON cv.club_id=m.club_visitor_id
LEFT JOIN ".T_team." AS er ON er.team_id=m.team_home_id
LEFT JOIN ".T_team." AS ev ON ev.team_id=m.team_visitor_id
{condition} {order} {limit}";

$sql['match']['select_match_details']="SELECT m.*,cv.club_name AS club_visitor_name, cr.club_name AS club_home_name, ner.team_name_name AS team_home_name, nev.team_name_name AS team_visitor_name, sr.sex_abbreviation AS sex_home_abbreviation, sr.sex_name AS sex_home_name, sv.sex_abbreviation AS sex_visitor_abbreviation, sv.sex_name AS sex_visitor_name FROM ".T_match." AS m
INNER JOIN ".T_club." AS cr ON cr.club_id=m.club_home_id
INNER JOIN ".T_club." AS cv ON cv.club_id=m.club_visitor_id
LEFT JOIN ".T_team." AS er ON er.team_id=m.team_home_id
LEFT JOIN ".T_team_name." AS ner ON ner.team_name_id=er.team_name_id
LEFT JOIN ".T_team." AS ev ON ev.team_id=m.team_visitor_id
LEFT JOIN ".T_team_name." AS nev ON nev.team_name_id=ev.team_name_id
LEFT JOIN ".T_sex." AS sr ON er.sex_id=sr.sex_id
LEFT JOIN ".T_sex." AS sv ON ev.sex_id=sv.sex_id
WHERE m.match_id='{id}'";

$sql['match']['insert_match']="INSERT INTO ".T_match." (club_home_id,club_visitor_id,team_home_id,team_visitor_id,season_id,field_id,weather_id,field_state_id,competition_id,round_id,match_date,match_group,match_day,match_penality_home,match_penality_visitor,match_score_home,match_score_visitor,match_spectators,match_comment)
 VALUES ('{club_home}','{club_visitor}','{team_home}','{team_visitor}','{season}','{field}','{weather}','{field_state}','{competition}','{round}','{date_hour}','{group}','{day}','{penality_home}','{penality_visitor}',{score_home},{score_visitor},{spectators},'{comment}');";
$sql['match']['edit_match']="UPDATE ".T_match." 
SET club_home_id='{club_home}', club_visitor_id='{club_visitor}',  team_home_id='{team_home}', team_visitor_id='{team_visitor}', season_id='{season}', field_id='{field}', weather_id='{weather}', field_state_id='{field_state}', competition_id='{competition}', round_id='{round}', match_date='{date_hour}', match_group='{group}', match_day='{day}', match_penality_home='{penality_home}', match_penality_visitor='{penality_visitor}', match_score_home={score_home},  match_score_visitor={score_visitor}, match_spectators={spectators},  match_comment='{comment}' 
 WHERE match_id='{id}';";
 
$sql['match']['verif_presence_match']="SELECT match_id FROM ".T_match." WHERE club_home_id='{club_home}' AND club_visitor_id='{club_visitor}' AND match_date='{date}' AND field_id='{field}' AND match_id!='{id}'";

$sql['match']['select_group_round']="SELECT DISTINCT(match_group) AS match_group FROM ".T_match." WHERE match_group!='' AND season_id='{season}' AND competition_id='{competition}' AND round_id='{round}' ORDER BY match_group ASC ";
$sql['match']['select_day_round']="SELECT DISTINCT(match_day) AS match_day FROM ".T_match." WHERE match_day!='' AND season_id='{season}' AND competition_id='{competition}' AND round_id='{round}' ORDER BY match_day ASC ";


# standings
$sql['match']['standings_home']="SELECT 
c.club_id,c.club_name, t.team_id, tn.team_name_name, sex.sex_name, sex.sex_abbreviation,
COUNT(distinct(m.match_id)) AS nb_match,
sum(CASE WHEN m.match_score_home > m.match_score_visitor THEN 1 ELSE 0  END)/SUM(1)*COUNT(distinct(m.match_id)) AS nb_win,
sum(CASE WHEN m.match_score_home = m.match_score_visitor THEN 1 ELSE 0  END)/SUM(1)*COUNT(distinct(m.match_id)) AS nb_tie,
sum(CASE WHEN m.match_score_home < m.match_score_visitor THEN 1 ELSE 0  END)/SUM(1)*COUNT(distinct(m.match_id)) AS nb_defeat,
sum(match_score_home)/SUM(1)*COUNT(distinct(m.match_id)) AS nb_point_for,
sum(match_score_visitor)/SUM(1)*COUNT(distinct(m.match_id)) AS nb_point_against,
sum(match_score_home-match_score_visitor)/SUM(1)*COUNT(distinct(m.match_id)) AS goal_average,
sum(match_penality_home)/SUM(1)*COUNT(distinct(m.match_id)) AS penality
{select}
FROM 
".T_club." AS c
INNER JOIN ".T_match." AS m ON c.club_id=m.club_home_id
LEFT JOIN ".T_match_stats." AS ms ON m.match_id=ms.match_id
LEFT JOIN ".T_stats." AS s ON ms.stats_id=s.stats_id
LEFT JOIN ".T_team." AS t ON m.team_home_id=t.team_id
LEFT JOIN ".T_team_name." AS tn ON t.team_name_id=tn.team_name_id
LEFT JOIN ".T_sex." AS sex ON t.sex_id=sex.sex_id
{condition}
GROUP BY tn.team_name_name, c.club_name ";


$sql['match']['standings_visitor']="SELECT 
c.club_id,c.club_name, t.team_id, tn.team_name_name, sex.sex_name, sex.sex_abbreviation,
COUNT(distinct(m.match_id)) AS nb_match,
sum(CASE WHEN m.match_score_home < m.match_score_visitor THEN 1 ELSE 0  END)/SUM(1)*COUNT(distinct(m.match_id)) AS nb_win,
sum(CASE WHEN m.match_score_home = m.match_score_visitor THEN 1 ELSE 0  END)/SUM(1)*COUNT(distinct(m.match_id)) AS nb_tie,
sum(CASE WHEN m.match_score_home > m.match_score_visitor THEN 1 ELSE 0  END)/SUM(1)*COUNT(distinct(m.match_id)) AS nb_defeat,
sum(match_score_visitor)/SUM(1)*COUNT(distinct(m.match_id)) AS nb_point_for,
sum(match_score_home)/SUM(1)*COUNT(distinct(m.match_id)) AS nb_point_against,
sum(match_score_visitor-match_score_home)/SUM(1)*COUNT(distinct(m.match_id)) AS goal_average,
sum(match_penality_visitor)/SUM(1)*COUNT(distinct(m.match_id)) AS penality
{select}
FROM 
".T_club." AS c
INNER JOIN ".T_match." AS m ON c.club_id=m.club_visitor_id
LEFT JOIN ".T_match_stats." AS ms ON m.match_id=ms.match_id
LEFT JOIN ".T_stats." AS s ON ms.stats_id=s.stats_id
LEFT JOIN ".T_team." AS t ON m.team_visitor_id=t.team_id
LEFT JOIN ".T_team_name." AS tn ON t.team_name_id=tn.team_name_id
LEFT JOIN ".T_sex." AS sex ON t.sex_id=sex.sex_id
{condition}
GROUP BY tn.team_name_name, c.club_name";

# stats_player
$sql['match']['stats_player']="SELECT
me.member_id,me.member_lastname,me.member_firstname,c.club_id,c.club_name,c.club_abbreviation,tn.team_name_name,s.sex_abbreviation,s.sex_name,
COUNT(distinct(m.match_id)) AS nb_match,
sum(CASE WHEN m.match_score_home > m.match_score_visitor THEN 1 ELSE 0  END)/SUM(1)*COUNT(distinct(m.match_id)) AS nb_win,
sum(CASE WHEN m.match_score_home = m.match_score_visitor THEN 1 ELSE 0  END)/SUM(1)*COUNT(distinct(m.match_id)) AS nb_tie,
sum(CASE WHEN m.match_score_home < m.match_score_visitor THEN 1 ELSE 0  END)/SUM(1)*COUNT(distinct(m.match_id)) AS nb_defeat
{select}
FROM 
".T_member." AS me 
INNER JOIN ".T_member_club." AS mc ON mc.member_id=me.member_id
INNER JOIN ".T_club." AS c ON mc.club_id=c.club_id
INNER JOIN ".T_match." AS m ON (c.club_id=m.club_home_id OR c.club_id=m.club_visitor_id)
INNER JOIN ".T_match_stats_player." AS ms ON m.match_id=ms.match_id
INNER JOIN ".T_stats_player." AS sp ON (ms.stats_player_id=sp.stats_player_id AND ms.member_id=me.member_id) 
LEFT JOIN ".T_team_player." AS tp ON (tp.member_id = me.member_id AND (m.team_home_id=tp.team_id OR m.team_visitor_id=tp.team_id))
LEFT JOIN ".T_team." AS t ON tp.team_id=t.team_id
LEFT JOIN ".T_team_name." AS tn ON t.team_name_id=tn.team_name_id
LEFT JOIN ".T_sex." AS s ON t.sex_id=s.sex_id
{condition} 
GROUP BY me.member_id 
{limit} ";
?>