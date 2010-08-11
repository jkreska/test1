<?php
##################################
# stats_player
##################################

# variables
$page['L_message_stats_player']="";
$page['show_stats_player']="";
$nb_erreur="0";
$page['erreur']=array();
$page['season']=array();

$member_id=array();
$member_list=array(); # club list
$stat_player=array();
$select_stats=array();

if(!isset($page['show_form'])) $page['show_form']="1";

if(!isset($page['value_competition'])) $page['value_competition']="";
if(!isset($page['value_round'])) $page['value_round']="";
if(!isset($page['value_group'])) $page['value_group']="";
if(!isset($page['value_day'])) $page['value_day']="";
if(!isset($page['value_club'])) $page['value_club']="";
if(!isset($page['value_team'])) $page['value_team']="";
if(!isset($page['value_season'])) $page['value_season']="";
if(!isset($page['value_order'])) $page['value_order']="";
if(!isset($page['value_limit'])) $page['value_limit']="";

if(isset($_POST['competition']) AND !empty($_POST['competition'])) { $page['value_competition']=$_POST['competition']; }
if(isset($_POST['round']) AND !empty($_POST['round'])) { $page['value_round']=$_POST['round']; }
if(isset($_POST['group']) AND !empty($_POST['group'])) { $page['value_group']=$_POST['group']; }
if(isset($_POST['day']) AND !empty($_POST['day'])) { $page['value_day']=$_POST['day']; }
if(isset($_POST['club']) AND !empty($_POST['club'])) { $page['value_club']=$_POST['club']; }
if(isset($_POST['team']) AND !empty($_POST['team'])) { $page['value_team']=$_POST['team']; }
if(isset($_POST['season']) AND !empty($_POST['season'])) { $page['value_season']=$_POST['season']; }
if(isset($_POST['order']) AND !empty($_POST['order'])) { $page['value_order']=$_POST['order']; }

if(isset($_GET['v2']) AND !empty($_GET['v2'])) { $page['value_competition']=$_GET['v2']; }
if(isset($_GET['v3']) AND !empty($_GET['v3'])) { $page['value_round']=$_GET['v3']; }
if(isset($_GET['v4']) AND !empty($_GET['v4'])) { $page['value_season']=$_GET['v4']; }
if(isset($_GET['v5']) AND !empty($_GET['v5']) AND $_GET['v5']!="all") { $page['value_group']=array($_GET['v5']); }
if(isset($_GET['v6']) AND !empty($_GET['v6']) AND $_GET['v6']!="all") { $page['value_day']=$_GET['v6']; }

# mode club 
$page['aff_club']="1";
if(CLUB!=0) {
$page['value_club']=CLUB;
$page['aff_club']="";
}

# seasons list
$page['season']=array();
include_once(create_path("competition/sql_competition.php"));
include_once(create_path("competition/lg_competition_".LANG.".php"));
include_once(create_path("competition/tpl_competition.php"));
$var['order']="";
$var['limit']="";
$var['condition']="";
$var['value_season']=$page['value_season'];
$included=1;
include(create_path("competition/season_list.php"));
unset($included);
$page['value_season']=$var['value_season'];
$page['season']=$page['season'];

$stats=array();
$stats_id=array();
$stats_name=array();
$stats_code=array();
$stats_abbreviation=array();
$stats_order=array();
$stats_formula=array();

# listes des stats disponibles
$var['condition']="";
$var['order']=" ORDER BY stats_player_formula ASC ";
$sql_liste=sql_replace($sql['match']['select_stats_player_condition'],$var);
$sgbd = sql_connect();
$res_liste = sql_query($sql_liste);
$nb_ligne = sql_num_rows($res_liste);
$i="0";
$nb_stats="0";
$nb_stats_var="0";
while($ligne = sql_fetch_array($res_liste))
{
 $page['stats'][$i]['id']=$ligne['stats_player_id'];
 $page['stats'][$i]['name']=$ligne['stats_player_name'];
 $page['stats'][$i]['abbreviation']=$ligne['stats_player_abbreviation'];

 $stats_id[$i]=$ligne['stats_player_id'];
 $stats_name[$i]=$ligne['stats_player_name'];
 $stats_abbreviation[$i]=$ligne['stats_player_abbreviation'];
 $stats_code[$i]=$ligne['stats_player_code'];
 $stats_order[$i]=$ligne['stats_player_order']; 
 $stats_formula[$i]=$ligne['stats_player_formula'];
 
 $stats[] = array('code'=>$ligne['stats_player_code'],'order'=>$ligne['stats_player_order'],'formula'=>$ligne['stats_player_formula']); 
 
 if(empty($ligne['stats_player_formula']) OR $ligne['stats_player_formula']==NULL) {  
  $select_stats[$nb_stats_var]=" sum(CASE WHEN sp.stats_player_code='".$ligne['stats_player_code']."' THEN ms.value ELSE 0 END) AS ".$ligne['stats_player_code']." ";
  $nb_stats_var++;
 }
 
 $i++;
}
sql_free_result($res_liste);
sql_close($sgbd);

$nb_stats=sizeof($stats_id);

if(!empty($select_stats)) $select_stats = implode(",", $select_stats);


/************************/
/* START CONDITIONS  */
/************************/
if(!isset($var['condition']) OR $var['condition']=="")
{
 $condition=array();
 # by default
 array_push($condition, " m.match_score_home IS NOT NULL AND m.match_score_visitor IS NOT NULL"); 
 
 # other 
 if(isset($page['value_club']) AND !empty($page['value_club'])) {
  array_push($condition," c.club_id='".$page['value_club']."' ");
 }
 
 if(isset($page['value_team']) AND !empty($page['value_team'])) {
  array_push($condition," t.team_id='".$page['value_team']."' ");
 }
   
 if(isset($page['value_competition']) AND !empty($page['value_competition'])) {
  array_push($condition," m.competition_id='".$page['value_competition']."' ");
 }
 
 if(isset($page['value_round']) AND !empty($page['value_round'])) { 
  array_push($condition," m.round_id='".$page['value_round']."'");
 }

 if(isset($page['value_group']) AND !empty($page['value_group'])) {
  $page['value_group']=implode("','",$page['value_group']);
  array_push($condition," m.match_group IN ('".$page['value_group']."')");
 } 

 if(isset($page['value_day']) AND !empty($page['value_day'])) { 
  array_push($condition," m.match_day <= '".$page['value_day']."'");
 }

 if(isset($page['value_season']) AND !empty($page['value_season'])) { 
  array_push($condition," m.season_id='".$page['value_season']."'");
  array_push($condition," mc.season_id='".$page['value_season']."'");
  array_push($condition," tp.season_id='".$page['value_season']."'");  
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



# limit
$var['limit']=$page['value_limit'];

# Stats player
$page['stats_player']=array();
$stats_player=array();
$member_id=array();

if($right_user['stats_player']) {
	$sgbd = sql_connect();
	$var['select']="";
	if(!empty($select_stats)) $var['select']=" , ".$select_stats;
	$res_stats_player = sql_query(sql_replace($sql['match']['stats_player'],$var));
	
	
	$nb_ligne = sql_num_rows($res_stats_player);
	$i="0";
	$j="0";
	
	while($ligne = sql_fetch_array($res_stats_player))
	{ 
	 $member=$ligne['member_id'];
	 $member_id[]=$ligne['member_id'];
	 $member_list[]=$ligne['member_id']; 
	 $stats_player[$member]['lastname']=$ligne['member_lastname'];
	 $stats_player[$member]['firstname']=$ligne['member_firstname']; 
	 $stats_player[$member]['nb_match']=$ligne['nb_match'];
	 
	 $stats_player[$member]['nb_win']=$ligne['nb_win'];
	 $stats_player[$member]['nb_tie']=$ligne['nb_tie'];
	 $stats_player[$member]['nb_defeat']=$ligne['nb_defeat'];
	  
	 if($ligne['club_abbreviation']!="") $stats_player[$member]['club']=$ligne['club_abbreviation']; 
	 else $stats_player[$member]['club']=$ligne['club_name'];
	 $stats_player[$member]['team']=$ligne['team_name_name'];
	 $stats_player[$member]['sex']=$ligne['sex_name'];
	 $stats_player[$member]['sex_abbreviation']=$ligne['sex_abbreviation'];
	 
	 $stats_regex=array("'PLAY'","'WIN'","'TIE'","'DEFEAT'");
	 $stats_replace=array($ligne['nb_match'],$ligne['nb_win'],$ligne['nb_tie'],$ligne['nb_defeat']);
	 $k=0; 
	 for($j=0; $j < $nb_stats; $j++) {
	  if($stats_formula[$j]!="") { 
	   $formula[$k]=preg_replace($stats_regex,$stats_replace,$stats_formula[$j]);
	   @eval("\$test=(".$formula[$k].");");
	   $stats_player[$member][$stats_code[$j]]=round($test,1);
	   $k++;
	  }
	  else {
	   $stats_regex[]="'".$stats_code[$j]."'";
	   $stats_replace[]=$ligne[$stats_code[$j]];
	   $stats_player[$member][$stats_code[$j]]=$ligne[$stats_code[$j]];
	  }
	  $player[$stats_code[$j]][$i] = $stats_player[$member][$stats_code[$j]];
	 }
	 
	 $player['id'][$i] = $member;
	 $player['lastname'][$i] = $stats_player[$member]['lastname'];
	 $player['nb_match'][$i] = $stats_player[$member]['nb_match'];
	 $player['nb_win'][$i] = $stats_player[$member]['nb_win'];
	 $player['nb_tie'][$i] = $stats_player[$member]['nb_tie'];
	 $player['nb_defeat'][$i] =  $stats_player[$member]['nb_defeat'];
	 
	 $i++;
	}
	sql_free_result($res_stats_player);
	sql_close($sgbd);
}

if(!empty($stats_player)) {
 if(empty($page['value_order'])) {
  # by default we order by lastname
  array_multisort($player['lastname'], SORT_ASC, $player['id'], SORT_ASC, $member_id); 
 }
 else {
  $order=$page['value_order'];
  array_multisort($player[$order], SORT_DESC, $player['id'], SORT_ASC, $member_id); 
 } 
}


foreach($stats as $key => $row)
{
   $stats_code[$key]  = $row['code'];
   $stats_order[$key] = $row['order'];
   $stats_formula[$key] = $row['formula'];
}
array_multisort($stats_order, SORT_ASC, $stats_code, SORT_ASC, $stats_formula, SORT_ASC, $stats);


# view player stats
$page['stats_player']=array();
$nb_member=sizeof($member_id);
for($i="0"; $i < $nb_member; $i++)
{
 $k=$member_id[$i];
 $page['stats_player'][$i]['mod']=$i%2;
 $page['stats_player'][$i]['lastname']=$stats_player[$k]['lastname'];
 $page['stats_player'][$i]['firstname']=$stats_player[$k]['firstname']; 
 $page['stats_player'][$i]['club']=$stats_player[$k]['club'];
 $page['stats_player'][$i]['team']=$stats_player[$k]['team'];
 $page['stats_player'][$i]['sex']=$stats_player[$k]['sex']; 
 $page['stats_player'][$i]['sex_abbreviation']=$stats_player[$k]['sex_abbreviation']; 
 $page['stats_player'][$i]['place']=$i+1;
 $page['stats_player'][$i]['stats']=array(); 
 for($j=0; $j < $nb_stats; $j++) {
  $code=$stats_code[$j];
  $page['stats_player'][$i]['stats'][$j]['value']=$stats_player[$k][$code];
 }
}



if($nb_member==0) {
 $page['L_message_stats_player']=$lang['match']['E_unavailable_standings'];
}
else {
 $page['show_stats_player']="1";
}


# STATS LIST (BY ORDER)
$page['stats']=array();
$var['condition']="";
$var['order']=" ORDER BY stats_player_order ASC ";
$sql_liste=sql_replace($sql['match']['select_stats_player_condition'],$var);
$sgbd = sql_connect();
$res_liste = sql_query($sql_liste);
$nb_ligne = sql_num_rows($res_liste);
$i="0";
if($nb_ligne!=0 AND $page['show_stats_player']=="1") {
 while($ligne = sql_fetch_array($res_liste))
 {
  $page['stats'][$i]['id']=$ligne['stats_player_id'];
  $page['stats'][$i]['name']=$ligne['stats_player_name'];
  $page['stats'][$i]['code']=$ligne['stats_player_code'];
  $page['stats'][$i]['formula']=$ligne['stats_player_formula'];  
  $page['stats'][$i]['abbreviation']=$ligne['stats_player_abbreviation'];
  $i++;
 }
} 
sql_free_result($res_liste);
sql_close($sgbd);



if($page['show_form']=="1") {

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

# competitions list
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

# round
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
 include(create_path("competition/select_round_all_details.php")); 
 $page['group']=$page['group'];
 $page['day']=$page['day'];  
 if($page['show_group']==1) { $page['display_group']="block"; }
 if($page['show_day']==1) { $page['display_day']="block"; }
}
}

# links
$page['form_action']=convert_url("index.php?r=".$lang['general']['idurl_match']."&v1=stats_player");

# text element
$page['L_title']=$lang['match']['stats_player'];
$page['L_club']=$lang['match']['club'];
$page['L_choose_club']=$lang['match']['choose_club'];
$page['L_club']=$lang['match']['club'];
$page['L_team']=$lang['match']['team'];
if(CLUB!=0) $page['L_club']=$page['L_team'];
$page['L_choose_team']=$lang['match']['choose_team'];
$page['L_season']=$lang['match']['season'];
$page['L_competition']=$lang['match']['competition'];
$page['L_choose_season']=$lang['match']['choose_season'];
$page['L_choose_competition']=$lang['match']['choose_competition'];
$page['L_submit']=$lang['match']['submit'];

$page['L_place']=$lang['match']['place'];
$page['L_player']=$lang['match']['player'];


$page['L_erreur']=$lang['general']['E_erreur'];
$page['meta_title']=$page['L_title'];
$page['template']=$tpl['match']['stats_player'];
?>