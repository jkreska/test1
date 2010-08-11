<?php

# liste des teams actuelles du member
// on recupere le club et l'team actuelle du member (player)
include_once(create_path("team/sql_team.php"));
include_once(create_path("team/lg_team_".LANG.".php"));
include_once(create_path("team/tpl_team.php"));
$var['condition']=" WHERE m.member_id='".$_SESSION['session_member_id']."' AND s.season_date_start <= NOW() AND s.season_date_end >= NOW() ";
$var['order']=" ORDER BY s.season_date_start DESC ";
$var['limit']="";
$included=1;
include(create_path("team/team_player_list.php"));
unset($included);
$page['team_player']=$page['team_player'];
$page['L_team_player']=$lang['member']['team_player'];

// on recupere l'team qu'entraine le member

# liste des prochains matchs du members
if(!empty($page['team_player'])) {
$nb_team_player=sizeof($page['team_player']);
$team_player=array();
for($i=0; $i < $nb_team_player; $i++)
{
  $team_player[]=$page['team_player'][$i]['team_id'];
}
$team_player=implode("','",$team_player);
} else $team_player="";


include_once(create_path("match/sql_match.php"));
include_once(create_path("match/lg_match_".LANG.".php"));
include_once(create_path("match/tpl_match.php"));
$var['condition']=" WHERE m.match_date >= NOW() AND (m.team_home_id IN ('".$team_player."') OR m.team_visitor_id IN ('".$team_player."')) ";
$var['order']=" ORDER BY m.match_date ASC ";
$var['limit']=" ";
$included=1;
include(create_path("match/match_list.php"));
unset($included);
$page['next_matches']=$page['match'];
$page['L_message_next_matches']=$page['L_message_match'];




# link
$page['link_profile']='';
if($right_user['profile']) $page['link_profile']=convert_url("index.php?r=".$lang['general']['idurl_member']."&v1=profile");


if($right_user['admin']) {
 $page['link_admin']=convert_url("index.php?r=".$lang['general']['idurl_admin']);
}  
else $page['link_admin']="";




# text
$page['L_title']=$lang['member']['home_member'];
$page['L_profile']=$lang['member']['profile'];
$page['L_admin']=$lang['member']['administration'];
$page['L_member_team']=$lang['member']['member_team'];
$page['L_member_next_matches']=$lang['member']['member_next_matches'];

$page['template']=$tpl['member']['home_member'];

?>