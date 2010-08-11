<?php
$nb_max=NB_MATCH; // number de match par page

$page['match']=array();
if(!isset($page['page'])) {
$page['link_first_page']="";
$page['link_previous_page']="";
$page['link_last_page']="";
$page['link_next_page']="";
}
$page['L_message_match']="";

if(!isset($page['value_competition'])) $page['value_competition']="";
if(!isset($page['value_round'])) $page['value_round']="";
if(!isset($page['value_group'])) $page['value_group']="";
if(!isset($page['value_day'])) $page['value_day']="";
if(!isset($page['value_club'])) $page['value_club']="";
if(!isset($page['value_team'])) $page['value_team']="";
if(!isset($page['value_season'])) $page['value_season']="";

if(isset($_POST['competition']) AND !empty($_POST['competition'])) { $page['value_competition']=$_POST['competition']; }
if(isset($_POST['round']) AND !empty($_POST['round'])) { $page['value_round']=$_POST['round']; }
if(isset($_POST['group']) AND !empty($_POST['group'])) { $page['value_group']=$_POST['group']; }
if(isset($_POST['day']) AND !empty($_POST['day'])) { $page['value_day']=$_POST['day']; }
if(isset($_POST['club']) AND !empty($_POST['club'])) { $page['value_club']=$_POST['club']; }
if(isset($_POST['team']) AND !empty($_POST['team'])) { $page['value_team']=$_POST['team']; }
if(isset($_POST['season']) AND !empty($_POST['season'])) { $page['value_season']=$_POST['season']; }

if(isset($_GET['v2']))
{
 if(eregi("team",$_GET['v2'])) {
  $team=explode("_",$_GET['v2']);
  $page['value_club']=$team['1'];
  $page['value_team']=$team['2'];
 }
 elseif(eregi("club",$_GET['v2'])) {
  $club=explode("_",$_GET['v2']);
  $page['value_club']=$club['1']; 
 }
}

# mode club 
$page['aff_club']="1";
if(CLUB!=0) {
$page['value_club']=CLUB;
$page['aff_club']="";
}


# suppression
if($right_user['delete_match'] AND isset($_GET['v2']) AND $_GET['v2']=="delete" AND isset($_GET['v3']) AND !empty($_GET['v3']) AND (!isset($included) OR $included==0)) 
{
 $var['id']=$_GET['v3'];
 $sql_verif=sql_replace($sql['match']['verif_match'],$var);
 $sql_sup=sql_replace($sql['match']['sup_match'],$var);
 $sgbd = sql_connect();
 
 $var['match']=$_GET['v3'];
 $sql_sup_referee=sql_replace($sql['match']['sup_match_referee'],$var); // match_referee
 $sql_sup_player=sql_replace($sql['match']['sup_match_player'],$var); // match_player
 $sql_sup_period=sql_replace($sql['match']['sup_match_period'],$var); // match_period
 $sql_sup_action=sql_replace($sql['match']['sup_match_action'],$var); // action_match
 $sql_sup_stats=sql_replace($sql['match']['sup_match_stats'],$var); // stats
 $sql_sup_stats_player=sql_replace($sql['match']['sup_match_stats_player'],$var); // stats_player

 if(sql_num_rows(sql_query($sql_verif))=="0") # we can delete
 {
  $execution=sql_query($sql_sup);
  if($execution) { 
   $page['L_message_match']=$lang['match']['form_match_sup_1'];
   sql_query($sql_sup_referee);
   sql_query($sql_sup_player);
   sql_query($sql_sup_period);
   sql_query($sql_sup_action);
   sql_query($sql_sup_stats);
   sql_query($sql_sup_stats_player);
  }
  else { $page['L_message_match']=$lang['match']['form_match_sup_0']; }
 }
 else # we can not delete
 {
  $page['L_message_match']=$lang['match']['form_match_sup_0'];
 }
 sql_close($sgbd);
}


# liste des seasons
$page['season']=array();
include_once(create_path("competition/sql_competition.php"));
include_once(create_path("competition/lg_competition_".LANG.".php"));
include_once(create_path("competition/tpl_competition.php"));
$var['value_season']=$page['value_season'];
$included=1;
include(create_path("competition/season_list.php"));
unset($included);
$page['value_season']=$var['value_season'];
$page['season']=$page['season'];


# TRI
# $_GET['v1'] is a variable like : page_1_name_asc
if(isset($_GET['v1']) AND eregi("page",$_GET['v1']))
{
 $v=explode("_",$_GET['v1']);
 $page_num=$v['1'];
 $tri=$v['2'];
 $ordre=$v['3'];
}
elseif(isset($_POST['page']) AND !empty($_POST['page']))
{
 $page_num=$_POST['page'];
 $tri=$_POST['tri'];
 $ordre=$_POST['ordre'];
}
else
{
 $page_num=1; // number of the page
 $tri="date"; // tri par defaut
 $ordre="asc"; // ordre par defaut
}

# ORDRE (sens)
if($ordre=="desc") { $sens="desc"; $sens_inv="asc"; }
else { $sens="asc"; $sens_inv="desc"; }
$page['value_tri']=$tri;
$page['value_ordre']=$sens;
$page['ordre']=$sens_inv;



/************************/
/* START CONDITIONS  */
/************************/
if(!isset($var['condition']) OR $var['condition']=="")
{
 $condition=array();

 /* par defaut */
// array_push($condition," lang_id=".LANG_ID." ");
 if(isset($page['value_competition']) AND !empty($page['value_competition'])) {
  array_push($condition," m.competition_id='".$page['value_competition']."' ");
 }
 
 if(isset($page['value_round']) AND !empty($page['value_round'])) { 
  array_push($condition," round_id='".$page['value_round']."'");
 }

 if(isset($page['value_group']) AND !empty($page['value_group'])) {
  $page['value_group']=implode("','",$page['value_group']);
  array_push($condition," match_group IN ('".$page['value_group']."')");
 } 

 if(isset($page['value_day']) AND !empty($page['value_day'])) { 
  array_push($condition," match_day='".$page['value_day']."'");
 }
  
 if(isset($page['value_club']) AND !empty($page['value_club'])) {
  array_push($condition," (club_home_id='".$page['value_club']."' OR club_visitor_id='".$page['value_club']."')");
 }
 
 if(isset($page['value_team']) AND !empty($page['value_team'])) {
  array_push($condition," (team_home_id='".$page['value_team']."' OR team_visitor_id='".$page['value_team']."')");
 }
 
 if(isset($page['value_season']) AND !empty($page['value_season'])) { 
  array_push($condition," m.season_id='".$page['value_season']."'");
 }  
  
 # creation of conditions list
 $nb_condition=sizeof($condition);
 if($nb_condition==0) { $var['condition']=""; }
 elseif($nb_condition=="1") { $var['condition']="WHERE ".$condition['0']; }
 else { $var['condition']="WHERE ".implode(" AND ",$condition); }
}
/**********************/
/* END OF CONDITIONS    */
/**********************/


/**********************/
/* ORDER (tri) */
/**********************/
if(!isset($var['order']))
{
 switch($tri) {
  case "date" : $var['order']=" ORDER BY match_date ".$sens." "; break;
  default : $var['order']=" ORDER BY match_date ".$sens." ";
 }
}


if(!isset($var['limit']) AND !isset($page['page']))
{
 /* on recupere le nb d'match */
 $sql_nb=sql_replace($sql['match']['select_match_nb'],$var);
 $sgbd = sql_connect();
 $res_nb = sql_query($sql_nb);
 $ligne=sql_fetch_array($res_nb);
 $nb=$ligne['nb'];
 sql_free_result($res_nb);
 sql_close($sgbd);
 
 /***************/
 /* PAGINATION */
 /**************/
 $page['first_page']="";
 $page['previous_page']="";
 $page['next_page']="";
 $page['last_page']="";
  
 # number of the current page
 $var['limit']="LIMIT ".($page_num-1)*$nb_max.",".$nb_max;
 $nb_page=ceil($nb/$nb_max);

 $url="index.php?r=".$lang['general']['idurl_match']."&v1=page_";
 $end_url="_".$tri."_".$sens;

 $page['page']=generate_pagination($url, $nb_page,$page_num,$end_url);


 # previous page (except on the first one)
 if($page_num!=1)
 {
  $page['link_first_page']=convert_url($url."1".$end_url);
  $page['link_previous_page']=convert_url($url.($page_num - 1).$end_url);
  $page['first_page']="1";
  $page['previous_page']=$page_num - 1;
 }
 # next page (except on the last one)
 if($page_num!=$nb_page)
 {
  $page['link_last_page']=convert_url($url.$nb_page.$end_url);
  $page['link_next_page']=convert_url($url.($page_num + 1).$end_url);
  $page['next_page']=$page_num + 1;
  $page['last_page']=$nb_page;  
 } /******************/
 /* END PAGINATION */
 /******************/
}


$sql_match=sql_replace($sql['match']['select_match_condition'],$var);

$sgbd = sql_connect();
$res_match = sql_query($sql_match);
$nb_ligne=sql_num_rows($res_match);
$page['nb_match']=$nb_ligne;
if(!$right_user['match_list']) {
	$page['L_message_match']=$lang['general']['acces_reserve_admin'];
}
elseif($nb_ligne=="0")
{
 $page['L_message_match']=$lang['match']['E_match_not_found'];
}
else
{
 $i=0;
 $tmp_date='';
 while($ligne = sql_fetch_array($res_match))
 {
  $page['match'][$i]['id']=$ligne['match_id'];
  $page['match'][$i]['club_visitor']=$ligne['club_visitor_name'];
  $page['match'][$i]['club_home']=$ligne['club_home_name'];
  $page['match'][$i]['team_visitor']="";
  $page['match'][$i]['team_home']="";
  if($ligne['team_visitor_name']!=NULL) $page['match'][$i]['team_visitor']=$ligne['team_visitor_name'];
  if($ligne['team_home_name']!=NULL) $page['match'][$i]['team_home']=$ligne['team_home_name'];
  $page['match'][$i]['sex_visitor']=$ligne['sex_visitor_name'];
  $page['match'][$i]['sex_home']=$ligne['sex_home_name'];
  $page['match'][$i]['sex_visitor_abbreviation']=$ligne['sex_visitor_abbreviation'];
  $page['match'][$i]['sex_home_abbreviation']=$ligne['sex_home_abbreviation'];
  $page['match'][$i]['competition']=$ligne['competition_id'];
  $page['match'][$i]['competition_name']=$ligne['competition_name'];
  $page['match'][$i]['field_state']=$ligne['field_state_id'];
  $page['match'][$i]['field']=$ligne['field_id'];
  $page['match'][$i]['weather']=$ligne['weather_id'];
  $page['match'][$i]['date']=convert_date($ligne['match_date'],$lang['match']['format_date_php']);
  $page['match'][$i]['hour']=convert_date($ligne['match_date'],$lang['match']['format_hour_php']);
  if($page['match'][$i]['hour']=="00:00") $page['match'][$i]['hour']="";
  $page['match'][$i]['score_visitor']=$ligne['match_score_visitor'];
  $page['match'][$i]['score_home']=$ligne['match_score_home'];
  $page['match'][$i]['spectators']=$ligne['match_spectators'];
  $page['match'][$i]['comment']=$ligne['match_comment'];
  
  if($tmp_date!=$page['match'][$i]['date']) { $page['match'][$i]['show_date']='1'; }
  else { $page['match'][$i]['show_date']=''; }
  $tmp_date=$page['match'][$i]['date'];  
  
  $page['match'][$i]['L_details']=$lang['match']['show_view'];
  $page['match'][$i]['L_edit']=$lang['match']['edit'];
  $page['match'][$i]['L_delete']=$lang['match']['delete'];

  $page['match'][$i]['link_view']=convert_url("index.php?r=".$lang['general']['idurl_match']."&v1=view&v2=".$ligne['match_id']);
  $page['match'][$i]['link_club_home']=convert_url("index.php?r=".$lang['general']['idurl_club']."&v1=view&v2=".$ligne['club_home_id']); 
  $page['match'][$i]['link_club_visitor']=convert_url("index.php?r=".$lang['general']['idurl_club']."&v1=view&v2=".$ligne['club_visitor_id']); 
  $page['match'][$i]['link_team_home']=convert_url("index.php?r=".$lang['general']['idurl_team']."&v1=view&v2=".$ligne['team_home_id']); 
  $page['match'][$i]['link_team_visitor']=convert_url("index.php?r=".$lang['general']['idurl_team']."&v1=view&v2=".$ligne['team_visitor_id']); 	 
	
  $page['match'][$i]['mod']=$i%2;
	
  $page['match'][$i]['home_gagnant']="0";
  $page['match'][$i]['visitor_gagnant']="0";	
  if($ligne['match_score_home'] > $ligne['match_score_visitor']) { $page['match'][$i]['home_gagnant']="1";	}
  elseif($ligne['match_score_home'] < $ligne['match_score_visitor']) { $page['match'][$i]['visitor_gagnant']="1"; }

   $page['match'][$i]['link_edit']="";
   $page['match'][$i]['link_delete']="";

  if($right_user['edit_match'])
  {
   $page['match'][$i]['link_edit']=convert_url("index.php?r=".$lang['general']['idurl_match']."&v1=form_match&v2=".$ligne['match_id']);
  }
  if($right_user['delete_match'])
  {
   $page['match'][$i]['link_delete']=convert_url("index.php?r=".$lang['general']['idurl_match']."&v1=match_list&v2=delete&v3=".$ligne['match_id']);
  }
  $i++;
 }
}
sql_free_result($res_match);
sql_close($sgbd);


# liste des teams
$page['link_select_team']=convert_url("index.php?r=".$lang['general']['idurl_team']."&v1=select_team_club");

$page['team']=array();
if(!empty($page['value_team']) OR $page['aff_club']!="1")
{
 include_once(create_path("team/sql_team.php"));
 include_once(create_path("team/lg_team_".LANG.".php"));
 include_once(create_path("team/tpl_team.php"));
 $var['order']="";
 $var['limit']="";
 $var['condition']=" WHERE e.club_id='".$page['value_club']."'";
 $var['value_team']=$page['value_team'];
 $included=1;
 include(create_path("team/team_list.php"));
 unset($included);
 $page['team']=$page['team'];
}

# liste des clubs
$page['club']=array();
if($page['aff_club']==1)
{
include_once(create_path("club/sql_club.php"));
include_once(create_path("club/lg_club_".LANG.".php"));
include_once(create_path("club/tpl_club.php"));
$var['condition']="";
$var['order']="";
$var['limit']="";
$var['value_club']=$page['value_club'];
$included=1;
include(create_path("club/club_list.php"));
unset($included);
$page['club']=$page['club'];
}

$page['aff_club_team']="1";
if(empty($page['club']) AND empty($page['team'])) {
 $page['aff_club_team']="";
}

# liste des competitions
$page['competition']=array();
include_once(create_path("competition/sql_competition.php"));
include_once(create_path("competition/lg_competition_".LANG.".php"));
include_once(create_path("competition/tpl_competition.php"));
$var['order']="";
$var['limit']="";
$var['condition']="";
$var['value_competition']=$page['value_competition'];
include_once(create_path("competition/competition_list.php"));
$page['competition']=$page['competition'];

if($right_user['add_match'])
 {
  $page['link_add']=convert_url("index.php?r=".$lang['general']['idurl_match']."&v1=form_match");
  $page['admin']="1";
 }
else
{
 $page['link_add']="";
 $page['admin']="";
}

# round
if(!isset($page['round']) OR empty($page['round'])) {
 $page['link_select_round']=convert_url("index.php?r=".$lang['general']['idurl_competition']."&v1=select_round");
 $page['round']=array();
 $page['display_round']="";
 $var['header']=0;
 $var['condition']="";
 $var['order']="";
 $var['limit']="";
 $var['competition']=$page['value_competition'];
 $var['value_round']=$page['value_round'];
 $page['type_view']="all";
 $included=1;
 include(create_path("competition/select_round.php"));
 unset($included);
 if($page['show_round']==1) { $page['display_round']="block"; }
 $page['round']=$page['round'];
}
$page['L_group']=$lang['competition']['group'];
$page['L_day']=$lang['competition']['day'];

# round details
$page['display_group']="none";
$page['display_day']="none";

if(isset($var['value_round']) AND $var['value_round']!="0")
{
 $var['header']=0;
 $var['id']=$page['value_round'];
 $var['competition']=$page['value_competition'];
 $var['season']=$page['value_season'];
 $var['group']=$page['value_group'];
 $var['day']=$page['value_day']; 
 $included=1;
 include(create_path("competition/select_round_all_details.php")); 
 unset($included);
 $page['group']=$page['group'];
 $page['day']=$page['day'];  
 if($page['show_group']==1) { $page['display_group']="block"; }
 if($page['show_day']==1) { $page['display_day']="block"; }
}

# links
$page['link_match']=convert_url("index.php?r=".$lang['general']['idurl_match']."&v1=match_list");
$page['link_tri_date']=convert_url("index.php?r=".$lang['general']['idurl_match']."&v1=page_".$page_num."_date_".$sens_inv);

$page['form_action']=convert_url("index.php?r=".$lang['general']['idurl_match']."&v1=match_list");

$page['link_import_match']='';
if($right_user['add_match']) {
  $page['link_import_match']=convert_url("index.php?r=".$lang['general']['idurl_match']."&v1=import_match");
}


# text
$page['L_season']=$lang['match']['season'];
$page['L_competition']=$lang['match']['competition'];
$page['L_club']=$lang['match']['club'];
$page['L_team']=$lang['match']['team'];
if(CLUB!=0) $page['L_club']=$page['L_team'];
$page['L_choose_season']=$lang['match']['choose_season'];
$page['L_choose_competition']=$lang['match']['choose_competition'];
$page['L_choose_club']=$lang['match']['choose_club'];
$page['L_choose_team']=$lang['match']['choose_team'];
$page['L_submit']=$lang['match']['submit'];

$page['L_order']=$lang['match']['order_by'];
$page['L_date']=$lang['match']['date'];
$page['L_hour']=$lang['match']['hour'];
$page['L_home']=$lang['match']['home'];
$page['L_visitor']=$lang['match']['visitor'];
$page['L_score']=$lang['match']['score'];


$page['L_first_page']=$lang['match']['first_page'];
$page['L_previous_page']=$lang['match']['previous_page'];
$page['L_next_page']=$lang['match']['next_page'];
$page['L_last_page']=$lang['match']['last_page'];

$page['L_add']=$lang['match']['add_match'];
$page['L_import_match']=$lang['match']['import_match'];

$page['L_title']=$lang['match']['match_list'];

# meta
$page['meta_title']=$lang['match']['match_list'];
$page['template']=$tpl['match']['match_list'];
?>