<?php
# view de competition
$page['L_message']="";
$group="";
$day="0";

# we get the ID
$page['id']=$_GET['v2'];

if(!isset($page['value_round'])) $page['value_round']="";
if(!isset($page['value_group'])) $page['value_group']="all";
if(!isset($page['value_day'])) $page['value_day']="all";
if(!isset($page['value_season'])) $page['value_season']="";

if(isset($_GET['v3']) AND !empty($_GET['v3'])) { $page['value_round']=$_GET['v3']; }
if(isset($_GET['v4']) AND !empty($_GET['v4'])) { $page['value_season']=$_GET['v4']; }
if(isset($_GET['v5']) AND !empty($_GET['v5'])) { $page['value_group']=$_GET['v5']; }
if(isset($_GET['v6']) AND !empty($_GET['v6'])) { $page['value_day']=$_GET['v6']; }

if(isset($_POST['season']) AND !empty($_POST['season'])) { $page['value_season']=$_POST['season']; }

if($right_user['view_competition']) {
	$page['show_view']=1; 
}
else {
	$page['show_view']='';
	$page['L_message']=$lang['general']['acces_reserve_admin'];
}

# season
$page['season']=array();
$var['season']=$page['value_season'];
$included=1;
include(create_path("competition/season_list.php"));
unset($included);
if(empty($page['value_season'])) {
	$page['value_season']=$var['value_season'];
}


# we get the information on the competition
if(isset($page['id']) AND $page['id']!="")
{
 $sql_details=sql_replace($sql['competition']['select_competition_details'],$page);

 $sgbd = sql_connect();
 $res = sql_query($sql_details);
 $ligne = sql_fetch_array($res);
 sql_free_result($res);

 $page['id']=$ligne['competition_id'];
 $page['name']=$ligne['competition_name'];
 
 # we get information on rounds
 $page['round']=array();
 $var['competition']=$page['id'];
 $sql_round=sql_replace($sql['competition']['select_round'],$var);
 $res_round = sql_query($sql_round);
 $nb_round=sql_num_rows($res_round);
 if($nb_round!=0) {
  $i="0";
  while($ligne_round=sql_fetch_array($res_round)) {
   $page['round'][$i]['name']=$ligne_round['round_name'];
   $page['round'][$i]['link_view']=convert_url("index.php?r=".$lang['general']['idurl_competition']."&v1=view&v2=".$page['id']."&v3=".$ligne_round['round_id']."&v4=".$page['value_season']);
   $page['round'][$i]['class']="";
   
   # if there is non round by default, then we take the first one
   if($page['value_round']=="" AND $i==0) { 
    $page['value_round']=$ligne_round['round_id'];
	$page['round'][$i]['class']="on";
	$group=$ligne_round['round_group'];
    $day=$ligne_round['round_day'];	
   }
   elseif($page['value_round']==$ligne_round['round_id']) {
    $page['round'][$i]['class']="on";
	$group=$ligne_round['round_group'];
    $day=$ligne_round['round_day'];
   }
   $i++;
  } 
 }
 sql_free_result($res_round);
 sql_close($sgbd);
 }
else
{
 $page['L_message']=$lang['competition']['E_erreur_presence_competition'];
}

$page['link_standings']=convert_url("index.php?r=".$lang['general']['idurl_match']."&v1=standings&v2=".$page['id']."&v3=".$page['value_round']."&v4=".$page['value_season']."&v5=".$page['value_group']."&v6=".$page['value_day']);
$page['link_stats_player']=convert_url("index.php?r=".$lang['general']['idurl_match']."&v1=stats_player&v2=".$page['id']."&v3=".$page['value_round']."&v4=".$page['value_season']."&v5=".$page['value_group']."&v6=".$page['value_day']);

# group
$page['group']=array();
$j="A";
for($i=0; $i < $group; $i++) {
 $page['group'][$i]['name']=$j;
 $page['group'][$i]['link_view']=convert_url("index.php?r=".$lang['general']['idurl_competition']."&v1=view&v2=".$page['id']."&v3=".$page['value_round']."&v4=".$page['value_season']."&v5=".$j."&v6=".$page['value_day']);
 $page['group'][$i]['class']="";
 if($page['value_group']==$j) {
  $page['group'][$i]['class']="on";
 }
 $j++;
}

$page['link_view_group_all']=convert_url("index.php?r=".$lang['general']['idurl_competition']."&v1=view&v2=".$page['id']."&v3=".$page['value_round']."&v4=".$page['value_season']."&v5=all&v6=".$page['value_day']);

$page['class_group_all']="";
if($page['value_group']=="" OR $page['value_group']=="all") {
 $page['class_group_all']="on";
}

# day
$page['day']=array();
for($i=0; $i < $day; $i++) {
 $page['day'][$i]['name']=$i+1;
 $page['day'][$i]['link_view']=convert_url("index.php?r=".$lang['general']['idurl_competition']."&v1=view&v2=".$page['id']."&v3=".$page['value_round']."&v4=".$page['value_season']."&v5=".$page['value_group']."&v6=".($i+1));
 $page['day'][$i]['class']="";
 if($page['value_day']==($i+1)) {
  $page['day'][$i]['class']="on";
 }
}

$page['link_view_day_all']=convert_url("index.php?r=".$lang['general']['idurl_competition']."&v1=view&v2=".$page['id']."&v4=".$page['value_round']."&v4=".$page['value_season']."&v5=".$page['value_group']."&v6=all");

$page['class_day_all']="";
if($page['value_day']=="" OR $page['value_day']=="all") {
 $page['class_day_all']="on";
}

if($page['value_group']=="all") $page['value_group']="";
if($page['value_day']=="all") $page['value_day']="";


# liste des matchs a venir dans cette competition
include_once(create_path("match/sql_match.php"));
include_once(create_path("match/lg_match_".LANG.".php"));
include_once(create_path("match/tpl_match.php"));
$_GET=array();
$page['value_competition']=$page['id'];
$page['value_round']=$page['value_round'];
if(empty($page['value_group'])) $page['value_group']=array();
else  $page['value_group']=array($page['value_group']);
$page['value_day']=$page['value_day'];
$included=1;
$var['limit']=' ';
include(create_path("match/match_list.php"));
unset($included);
$page['match']=$page['match'];
$page['L_message_match']=$page['L_message_match'];
$page['L_match']=$lang['match']['match_list'];


# standings
$page['show_form']="";
if(empty($page['value_group'])) $page['value_group']=array();
else  $page['value_group']=array($page['value_group']);
$included=1;
include(create_path("match/standings.php"));
unset($included);
$tmp=$page['stats'];
$page['standings']=$page['standings'];
$page['L_message_standings']=$page['L_message_standings'];
$page['L_standings']=$lang['match']['standings'];
$page['L_show_standings']=$lang['match']['show_standings'];

# stats_player
$page['show_form']="";
$page['value_limit']=" LIMIT 30 ";
if(empty($page['value_group'])) $page['value_group']=array();
else  $page['value_group']=array($page['value_group']);
$included=1;
include(create_path("match/stats_player.php"));
unset($included);
$page['match_stats_player']=$page['stats_player'];
$page['stats_player']=$page['stats'];
$page['L_stats_player']=$lang['match']['stats_player'];
$page['L_show_stats_player']=$lang['match']['show_stats_player'];
$page['stats']=$tmp;


# modification
$page['link_edit']="";
$page['link_delete']="";
if($right_user['edit_competition']) {
	$page['link_edit']=convert_url("index.php?r=".$lang['general']['idurl_competition']."&v1=form_competition&v2=".$page['id']);
}
if($right_user['edit_competition']) {
	$page['link_delete']=convert_url("index.php?r=".$lang['general']['idurl_competition']."&v1=competition_list&v2=delete&v3=".$page['id']);
}

# link
$end_form_action='';
if($page['value_day']!='') {
	if(empty($page['value_group'])) $page['value_group']='all';
	else  $page['value_group']=$page['value_group'];
	$end_form_action="&v5=".$page['value_group']."&v6=".$page['value_day'];
}
$page['form_action']=convert_url("index.php?r=".$lang['general']['idurl_competition']."&v1=view&v2=".$page['id']."&v3=".$page['value_round']."&v4=".$page['value_season'].$end_form_action);


# text
$page['L_title']=$page['name'];
$page['L_competition']=$lang['competition']['competition'];
$page['L_details']=$lang['competition']['details'];
$page['L_name']=$lang['competition']['name'];
$page['L_day']=$lang['competition']['day'];
$page['L_all']=$lang['competition']['all'];

$page['L_edit']=$lang['competition']['edit'];
$page['L_delete']=$lang['competition']['delete'];


# meta
$page['meta_title']=$page['name'];
$page['template']=$tpl['competition']['view_competition'];
?>