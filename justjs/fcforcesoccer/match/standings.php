<?php
##################################
# standings
##################################

# variables
$page['L_message_standings']="";
$page['show_standings']="";
$page['show_point']="";
$page['form_action']=convert_url("index.php?r=".$lang['general']['idurl_match']."&v1=standings");
$nb_erreur="0";
$page['erreur']=array();
$page['season']=array();

$stats_id=array();
$club_id=array();
$club_list=array(); # club list
$global=array();
$select_stats_home=array();
$select_stats_visitor=array();

if(!isset($page['show_form'])) $page['show_form']="1";

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

if(isset($_GET['v2']) AND !empty($_GET['v2'])) { $page['value_competition']=$_GET['v2']; }
if(isset($_GET['v3']) AND !empty($_GET['v3'])) { $page['value_round']=$_GET['v3']; }
if(isset($_GET['v4']) AND !empty($_GET['v4'])) { $page['value_season']=$_GET['v4']; }
if(isset($_GET['v5']) AND !empty($_GET['v5']) AND $_GET['v5']!="all") { $page['value_group']=array($_GET['v5']); }
if(isset($_GET['v6']) AND !empty($_GET['v6']) AND $_GET['v6']!="all") { $page['value_day']=$_GET['v6']; }

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


# listes des stats disponibles
$var['condition']="";
$var['order']=" ORDER BY stats_formula ASC ";
$sql_liste=sql_replace($sql['match']['select_stats_condition'],$var);
$sgbd = sql_connect();
$res_liste = sql_query($sql_liste);
$nb_ligne = sql_num_rows($res_liste);
$i="0";
$nb_stats="0";
$nb_stats_var="0";
while($ligne = sql_fetch_array($res_liste))
{
 $page['stats'][$i]['id']=$ligne['stats_id'];
 $page['stats'][$i]['name']=$ligne['stats_name'];
 $page['stats'][$i]['abbreviation']=$ligne['stats_abbreviation'];

 $stats_id[$i]=$ligne['stats_id'];
 $stats_name[$i]=$ligne['stats_name'];
 $stats_abbreviation[$i]=$ligne['stats_abbreviation'];
 $stats_code[$i]=$ligne['stats_code'];
 $stats_order[$i]=$ligne['stats_order']; 
 $stats_formula[$i]=$ligne['stats_formula'];
 
 $stats[] = array('code'=>$ligne['stats_code'],'order'=>$ligne['stats_order'],'formula'=>$ligne['stats_formula']); 
 
 if(empty($ligne['stats_formula']) OR $ligne['stats_formula']==NULL) {  
  $select_stats_home[$nb_stats_var]=" sum(CASE WHEN s.stats_code='".$ligne['stats_code']."' THEN ms.value_home ELSE 0 END) AS ".$ligne['stats_code']." ";
  $select_stats_visitor[$nb_stats_var]=" sum(CASE WHEN s.stats_code='".$ligne['stats_code']."' THEN ms.value_visitor ELSE 0 END) AS ".$ligne['stats_code']." ";
  $nb_stats_var++;
 }
 
 $i++;
}
sql_free_result($res_liste);
sql_close($sgbd);

$nb_stats=sizeof($stats_id);

if(!empty($select_stats_home)) $select_home = implode(",",$select_stats_home);
if(!empty($select_stats_visitor)) $select_visitor = implode(",",$select_stats_visitor);


/************************/
/* START CONDITIONS  */
/************************/
if(!isset($var['condition']) OR $var['condition']=="")
{
 $condition=array();
 # by default
 array_push($condition, " m.match_score_home IS NOT NULL AND m.match_score_visitor IS NOT NULL"); 
 
 # other
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




# STANDING HOME
$page['standings_home']=array();
$standings_home=array();
$sgbd = sql_connect();
$var['select']="";
if(!empty($select_home)) $var['select']=" , ".$select_home;
$res_standings = sql_query(sql_replace($sql['match']['standings_home'],$var));
$nb_ligne = sql_num_rows($res_standings);
$i="0";
$j="0";

while($ligne = sql_fetch_array($res_standings))
{ 
 if($ligne['team_id']==NULL) { 
  $ligne['team_id']="";
  $ligne['team_name_name']="";
  $ligne['sex']="";
  $ligne['sex_abbreviation']="";  
 }
 $club=$ligne['club_id']."-".$ligne['team_id'];
 $club_home_id[]=$ligne['club_id']."-".$ligne['team_id'];
 $club_list[]=$ligne['club_id']."-".$ligne['team_id'];
 $standings_home[$club]['club']=$ligne['club_name'];
 $standings_home[$club]['sex']=$ligne['sex_name'];
 $standings_home[$club]['sex_abbreviation']=$ligne['sex_abbreviation'];
 $standings_home[$club]['team']=$ligne['team_name_name'];
 $standings_home[$club]['nb_match']=$ligne['nb_match'];
 $standings_home[$club]['nb_win']=$ligne['nb_win'];
 $standings_home[$club]['nb_tie']=$ligne['nb_tie'];
 $standings_home[$club]['nb_defeat']=$ligne['nb_defeat'];
 $standings_home[$club]['nb_point_for']=$ligne['nb_point_for'];
 $standings_home[$club]['nb_point_against']=$ligne['nb_point_against'];
 $standings_home[$club]['goal_average']=$ligne['goal_average'];
 $standings_home[$club]['penality']=$ligne['penality'];
  
 $standings_home[$club]['club']=$ligne['club_name'];
 $stats_regex=array("'PLAY'","'WIN'","'TIE'","'DEFEAT'","'POINT_FOR'","'POINT_AGAINST'","'GOAL_AVERAGE'");
 $stats_replace=array($ligne['nb_match'],$ligne['nb_win'],$ligne['nb_tie'],$ligne['nb_defeat'],$ligne['nb_point_for'],$ligne['nb_point_against'],$ligne['goal_average']);
 $k=0; 
 for($j=0; $j < $nb_stats; $j++) {
  if($stats_formula[$j]!="") { 
   $formula[$k]=preg_replace($stats_regex,$stats_replace,$stats_formula[$j]);
   @eval("\$test=(".$formula[$k].");");
   $standings_home[$club][$stats_code[$j]]=round($test,1);
   $k++;
  }
  else {
   $stats_regex[]="'".$stats_code[$j]."'";
   $stats_replace[]=$ligne[$stats_code[$j]];
   $standings_home[$club][$stats_code[$j]]=$ligne[$stats_code[$j]];
  } 
 }
}
sql_free_result($res_standings);
sql_close($sgbd);


# STATS VISITOR
$page['standings_visitor']=array();
$standings_visitor=array();
$sgbd = sql_connect();
$var['select']="";
if(!empty($select_visitor)) $var['select']=" , ".$select_visitor;
$res_standings = sql_query(sql_replace($sql['match']['standings_visitor'],$var));
$nb_ligne = sql_num_rows($res_standings);
$i="0";
$j="0";

while($ligne = sql_fetch_array($res_standings))
{ 
 if($ligne['team_id']==NULL) { 
  $ligne['team_id']="";
  $ligne['team_name_name']="";
  $ligne['sex']="";
  $ligne['sex_abbreviation']="";
 }
 $club=$ligne['club_id']."-".$ligne['team_id'];
 $club_visitor_id[]=$ligne['club_id']."-".$ligne['team_id'];
 if(!in_array($club,$club_list)) array_push($club_list,$club);
  
 $standings_visitor[$club]['club']=$ligne['club_name'];
 $standings_visitor[$club]['team']=$ligne['team_name_name'];
 $standings_visitor[$club]['sex']=$ligne['sex_name'];
 $standings_visitor[$club]['sex_abbreviation']=$ligne['sex_abbreviation']; 
 $standings_visitor[$club]['nb_match']=$ligne['nb_match'];
 $standings_visitor[$club]['nb_win']=$ligne['nb_win'];
 $standings_visitor[$club]['nb_tie']=$ligne['nb_tie'];
 $standings_visitor[$club]['nb_defeat']=$ligne['nb_defeat'];
 $standings_visitor[$club]['nb_point_for']=$ligne['nb_point_for'];
 $standings_visitor[$club]['nb_point_against']=$ligne['nb_point_against'];
 $standings_visitor[$club]['goal_average']=$ligne['goal_average'];
 $standings_visitor[$club]['penality']=$ligne['penality'];
 
 $stats_regex=array("'PLAY'","'WIN'","'TIE'","'DEFEAT'","'POINT_FOR'","'POINT_AGAINST'","'GOAL_AVERAGE'");
 $stats_replace=array($ligne['nb_match'],$ligne['nb_win'],$ligne['nb_tie'],$ligne['nb_defeat'],$ligne['nb_point_for'],$ligne['nb_point_against'],$ligne['goal_average']);
 $k=0; 
 for($j=0; $j < $nb_stats; $j++) {
  if($stats_formula[$j]!="") { 
   $formula[$k]=preg_replace($stats_regex,$stats_replace,$stats_formula[$j]);
   @eval("\$test=(".$formula[$k].");");
   $standings_visitor[$club][$stats_code[$j]]=round($test,1);
   $k++;
  }
  else {
   $stats_regex[]="'".$stats_code[$j]."'";
   $stats_replace[]=$ligne[$stats_code[$j]];
   $standings_visitor[$club][$stats_code[$j]]=$ligne[$stats_code[$j]];
  } 
 }
}
sql_free_result($res_standings);
sql_close($sgbd);



# We check if we need to calculate points
if(!empty($page['value_round'])) {
 # we get the information on the round
 $var['id']=$page['value_round'];
 $sql_round=sql_replace($sql['competition']['select_round_details'],$var); 
 $sgbd = sql_connect();
 $res_round = sql_query($sql_round);
 $ligne_round=sql_fetch_array($res_round);
 if($ligne_round['round_standings']==1) {
  $page['show_point']="1";  
  $points_win_at_home=$ligne_round['point_win_at_home'];
  $points_win_away=$ligne_round['point_win_away'];
  $points_tie_at_home=$ligne_round['point_tie_at_home'];
  $points_tie_away=$ligne_round['point_tie_away'];
  $points_defeat_at_home=$ligne_round['point_defeat_at_home'];
  $points_defeat_away=$ligne_round['point_defeat_away'];
  $order_team=$ligne_round['order_team'];
  $order_team_egality=$ligne_round['order_team_egality'];
 }
 sql_free_result($res_round);
 sql_close($sgbd);
} 

# STANDINGS GLOBAL
$nb_club=sizeof($club_list);
for($i=0; $i < $nb_club; $i++)
{
 $club=$club_list[$i]; 
 
 if(isset($standings_home[$club]['club']) AND isset($standings_visitor[$club]['club'])) {
  $standings_global[$club]['club']=$standings_home[$club]['club'];
  $standings_global[$club]['team']=$standings_home[$club]['team'];
  $standings_global[$club]['sex']=$standings_home[$club]['sex'];
  $standings_global[$club]['sex_abbreviation']=$standings_home[$club]['sex_abbreviation'];
  $standings_global[$club]['nb_match']=$standings_home[$club]['nb_match']+$standings_visitor[$club]['nb_match'];  
  $standings_global[$club]['nb_win']=$standings_home[$club]['nb_win']+$standings_visitor[$club]['nb_win'];
  $standings_global[$club]['nb_tie']=$standings_home[$club]['nb_tie']+$standings_visitor[$club]['nb_tie'];
  $standings_global[$club]['nb_defeat']=$standings_home[$club]['nb_defeat']+$standings_visitor[$club]['nb_defeat'];
  $standings_global[$club]['nb_point_for']=$standings_home[$club]['nb_point_for']+$standings_visitor[$club]['nb_point_for'];
  $standings_global[$club]['nb_point_against']=$standings_home[$club]['nb_point_against']+$standings_visitor[$club]['nb_point_against'];
  $standings_global[$club]['goal_average'] =$standings_home[$club]['goal_average']+$standings_visitor[$club]['goal_average'];
  $standings_global[$club]['penality']=$standings_home[$club]['penality']+$standings_visitor[$club]['penality'];
  $standings_global[$club]['point']="0";
  if($page['show_point']=="1") {  
   $standings_global[$club]['point']= (($points_win_at_home*$standings_home[$club]['nb_win'])+ ($points_win_away*$standings_visitor[$club]['nb_win']) + ($points_tie_at_home*$standings_home[$club]['nb_tie']) + ($points_tie_away*$standings_visitor[$club]['nb_tie']) + ($points_defeat_at_home*$standings_home[$club]['nb_defeat']) + ($points_defeat_away*$standings_visitor[$club]['nb_defeat']) - $standings_global[$club]['penality']);
  }

  $stats_regex=array("'PLAY'","'WIN'","'TIE'","'DEFEAT'","'POINT_FOR'","'POINT_AGAINST'","'GOAL_AVERAGE'");
  $stats_replace=array($standings_global[$club]['nb_match'],$standings_global[$club]['nb_win'],$standings_global[$club]['nb_tie'],$standings_global[$club]['nb_defeat'],$standings_global[$club]['nb_point_for'],$standings_global[$club]['nb_point_against'],$standings_global[$club]['goal_average']);
  $k=0; 
  for($j=0; $j < $nb_stats; $j++) {
   if($stats_formula[$j]!="") { 
    $formula[$k]=preg_replace($stats_regex,$stats_replace,$stats_formula[$j]);
    @eval("\$test=(".$formula[$k].");");
    $standings_global[$club][$stats_code[$j]]=round($test,1);
    $k++;
   }
   else {
    $stats_regex[]="'".$stats_code[$j]."'";
    $stats_replace[]=$standings_home[$club][$stats_code[$j]]+$standings_visitor[$club][$stats_code[$j]];
    $standings_global[$club][$stats_code[$j]]=$standings_home[$club][$stats_code[$j]]+$standings_visitor[$club][$stats_code[$j]];	
   } 
  }  
 }
 elseif(isset($standings_home[$club]['club']) AND !isset($standings_visitor[$club]['club'])) { 
  $standings_global[$club]=$standings_home[$club];
  $standings_global[$club]['point']="0";
  
  if($page['show_point']=="1") {   
   $standings_global[$club]['point'] = (($points_win_at_home*$standings_home[$club]['nb_win'])+($points_tie_at_home*$standings_home[$club]['nb_tie']) + ($points_defeat_at_home*$standings_home[$club]['nb_defeat']) - $standings_global[$club]['penality']);     
  }
 }
 else
 {
  $standings_global[$club]=$standings_visitor[$club];
  $standings_global[$club]['point']="0";
  if($page['show_point']=="1") {
   $standings_global[$club]['point']= (($points_win_away*$standings_visitor[$club]['nb_win']) + ($points_tie_away*$standings_visitor[$club]['nb_tie']) + ($points_defeat_away*$standings_visitor[$club]['nb_defeat']) - $standings_global[$club]['penality']);  
  }
 }
 
 # we create arrays to sort the clubs properly
 $club_id[]=$club_list[$i];
 $global['id'][$i] = $club;
 $global['name'][$i] = $standings_global[$club]['club'];
 $global['nb_match'][$i] = $standings_global[$club]['nb_match'];
 $global['nb_win'][$i] = $standings_global[$club]['nb_win'];
 $global['nb_tie'][$i] = $standings_global[$club]['nb_tie'];
 $global['nb_defeat'][$i] =  $standings_global[$club]['nb_defeat'];
 $global['goal_average'][$i] =  $standings_global[$club]['goal_average'];
 $global['nb_point_for'][$i] = $standings_global[$club]['nb_point_for'];
 $global['point'][$i] =  $standings_global[$club]['point'];
}



if(!function_exists('get_sort')) {
function get_sort($order,$array) {
 switch($order) {
  case 0 : $tab = $array['point']; $option_1="SORT_DESC"; break;
  case 1 : $tab = $array['nb_match']; $option_1="SORT_DESC"; break;
  case 2 : $tab = $array['nb_win']; $option_1="SORT_DESC"; break;
  case 3 : $tab = $array['nb_tie']; $option_1="SORT_DESC"; break;
  case 4 : $tab = $array['nb_defeat']; $option_1="SORT_ASC"; break;
  case 5 : $tab = $array['goal_average']; $option_1="SORT_DESC"; break;
  case 6 : $tab = $array['nb_point_for']; $option_1="SORT_DESC"; break;
  default : $tab= $array['point']; $option_1="SORT_DESC";
 }
 return $tab;
}
}


if($page['show_point']==1) 
{
 # we have to sort the clubs id by points
 if(!empty($global)) {
  $tab_1=get_sort($order_team,$global);
  $tab_2=get_sort($order_team_egality,$global);
  array_multisort($tab_1, SORT_DESC, $tab_2, SORT_DESC, $global['id'], SORT_ASC, $club_id);
  
  /*$tab_1=get_sort($order_team,$global);
  $tab_2=get_sort($order_team_egality,$global);
  $tab_3=get_sort(6,$global);
  array_multisort($tab_1, SORT_DESC, $tab_2, SORT_DESC, $tab_3, SORT_DESC, $global['id'], SORT_ASC, $club_id);
  */
 } 
}
else
{
 # we sort the club list by name
 if(!empty($global)) {
  array_multisort($global['name'], SORT_ASC, $global['id'], SORT_ASC, $club_id); 
 } 
 
}

# date sort by nb_match //////////// to be change by points !!
/*if(!empty($home)) {
 foreach($home as $key => $row) {
   $id[$key]  = $row['id'];
   $name[$key]  = $row['name'];
   $nb_match[$key] = $row['nb_match'];
 }
 array_multisort($nb_match, SORT_DESC, $id, SORT_ASC, $home);
}*/


if(!empty($stats))
{
 foreach($stats as $key => $row)
 {
   $stats_code[$key]  = $row['code'];
   $stats_order[$key] = $row['order'];
   $stats_formula[$key] = $row['formula'];
 }
 array_multisort($stats_order, SORT_ASC, $stats_code, SORT_ASC, $stats_formula, SORT_ASC, $stats);
}

# view club global stats
$page['standings']=array();
$nb_club_global=sizeof($club_id);
$a=0; # home counter
$b=0; # visitor counter

if(isset($nb_club_max) AND $nb_club_max < $nb_club_global) {
	$nb_club_global=$nb_club_max; # we limit the number of clubs to display
}

for($i="0"; $i < $nb_club_global; $i++)
{
 $k=$club_id[$i];
 $page['standings'][$i]['mod']=$i%2;
 $page['standings'][$i]['club']=$standings_global[$k]['club'];
 $page['standings'][$i]['team']=$standings_global[$k]['team'];
 if($standings_global[$k]['team']!=NULL AND !empty($standings_global[$k]['team'])) {
	 $page['standings'][$i]['show_team']='';
 }
 else {
 	$page['standings'][$i]['show_team']=1;
 }
 $page['standings'][$i]['sex']=$standings_global[$k]['sex'];
 $page['standings'][$i]['sex_abbreviation']=$standings_global[$k]['sex_abbreviation'];
 $page['standings'][$i]['point']=$standings_global[$k]['point'];
 $page['standings'][$i]['show_point']=$page['show_point']; 
 $page['standings'][$i]['place']=$i+1;
 $standings_global[$k]['place']=$i+1;
 $page['standings'][$i]['stats']=array(); 
 for($j=0; $j < $nb_stats; $j++) {
  $code=$stats_code[$j];
  $page['standings'][$i]['stats'][$j]['value']=$standings_global[$k][$code];
  
  # show or not the stats
  if(isset($show_stats) AND in_array($code,$show_stats)) { $page['standings'][$i]['stats'][$j]['show']=1; }
  else { $page['standings'][$i]['stats'][$j]['show']=''; }  
 }
 
 if(in_array($k,$club_home_id)) {
  $page['standings_home'][$a]['mod']=$a%2;
  $page['standings_home'][$a]['club']=$standings_home[$k]['club'];
  $page['standings_home'][$a]['team']=$standings_home[$k]['team'];
  if($standings_home[$k]['team']!=NULL AND !empty($standings_home[$k]['team'])) {
	 $page['standings_home'][$a]['show_team']='';
  }
  else {
 	$page['standings_home'][$a]['show_team']=1;
  }  
  $page['standings_home'][$a]['sex']=$standings_home[$k]['sex'];
  $page['standings_home'][$a]['sex_abbreviation']=$standings_home[$k]['sex_abbreviation']; 
  $page['standings_home'][$a]['point']=$standings_global[$k]['point'];
  $page['standings_home'][$a]['show_point']=$page['show_point'];
  $page['standings_home'][$a]['place']=$standings_global[$k]['place'];
  $page['standings_home'][$a]['stats']=array(); 
  for($h=0; $h < $nb_stats; $h++) {
   $code=$stats_code[$h];
   $page['standings_home'][$a]['stats'][$h]['value']=$standings_home[$k][$code];
  }
  $a++;
 }

 if(in_array($k,$club_visitor_id)) {
  $page['standings_visitor'][$b]['mod']=$b%2;
  $page['standings_visitor'][$b]['club']=$standings_visitor[$k]['club'];
  $page['standings_visitor'][$b]['team']=$standings_visitor[$k]['team'];
  if($standings_visitor[$k]['team']!=NULL AND !empty($standings_visitor[$k]['team'])) {
	 $page['standings_visitor'][$b]['show_team']='';
  }
  else {
 	$page['standings_visitor'][$b]['show_team']=1;
  }  
  $page['standings_visitor'][$b]['sex']=$standings_visitor[$k]['sex'];
  $page['standings_visitor'][$b]['sex_abbreviation']=$standings_visitor[$k]['sex_abbreviation'];  
  $page['standings_visitor'][$b]['point']=$standings_global[$k]['point'];
  $page['standings_visitor'][$b]['show_point']=$page['show_point'];
  $page['standings_visitor'][$b]['place']=$standings_global[$k]['place'];
  $page['standings_visitor'][$b]['stats']=array(); 
  for($g=0; $g < $nb_stats; $g++) {
   $code=$stats_code[$g];
   $page['standings_visitor'][$b]['stats'][$g]['value']=$standings_visitor[$k][$code];
  }
  $b++;
 } 
}


if(!$right_user['standings']) {
	$page['standings']=array();
	$page['standings_home']=array();
	$page['standings_visitor']=array();
	$page['L_message_standings']=$lang['general']['acces_reserve_admin'];
	$page['show_standings']="";
}
else {
	if($nb_club_global==0) {
 	$page['L_message_standings']=$lang['match']['E_unavailable_standings'];
	}
	else {
	 $page['show_standings']="1";
	}
}

# STATS LIST (BY ORDER)
$page['stats']=array();
$var['condition']="";
$var['order']=" ORDER BY stats_order ASC ";
$sql_liste=sql_replace($sql['match']['select_stats_condition'],$var);
$sgbd = sql_connect();
$res_liste = sql_query($sql_liste);
$nb_ligne = sql_num_rows($res_liste);
$i="0";
if($nb_ligne!=0 AND $page['show_standings']=="1") {
 while($ligne = sql_fetch_array($res_liste))
 {
  $page['stats'][$i]['id']=$ligne['stats_id'];
  $page['stats'][$i]['name']=$ligne['stats_name'];
  $page['stats'][$i]['abbreviation']=$ligne['stats_abbreviation']; 
  
  if(isset($show_stats) AND in_array($ligne['stats_abbreviation'],$show_stats)) { $page['stats'][$i]['show']=1; }
  else { $page['stats'][$i]['show']=''; }  
  
  $i++;
 }
} 
sql_free_result($res_liste);
sql_close($sgbd);


if($page['show_form']=="1") {
$page['competition']=array();
# competitions list
include_once(create_path("competition/sql_competition.php"));
include_once(create_path("competition/lg_competition_".LANG.".php"));
include_once(create_path("competition/tpl_competition.php"));
$var['order']="";
$var['limit']="";
$var['condition']="";
$var['value_competition']=$page['value_competition'];
$included=1;
include_once(create_path("competition/competition_list.php"));
unset($included);
$page['competition']=$page['competition'];

$page['round']=array();
# round
$page['link_select_round']=convert_url("index.php?r=".$lang['general']['idurl_competition']."&v1=select_round");
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
 $included=1;
 include(create_path("competition/select_round_all_details.php")); 
 unset($included);
 $page['group']=$page['group'];
 $page['day']=$page['day'];  
 if($page['show_group']==1) { $page['display_group']="block"; }
 if($page['show_day']==1) { $page['display_day']="block"; }
}

}

# links
$page['form_action']=convert_url("index.php?r=".$lang['general']['idurl_match']."&v1=standings");

# text element
$page['L_title']=$lang['match']['standings'];

$page['L_season']=$lang['match']['season'];
$page['L_competition']=$lang['match']['competition'];
$page['L_choose_season']=$lang['match']['choose_season'];
$page['L_choose_competition']=$lang['match']['choose_competition'];
$page['L_submit']=$lang['match']['submit'];

$page['L_total']=$lang['match']['total'];
$page['L_home']=$lang['match']['at_home'];
$page['L_visitor']=$lang['match']['away'];
$page['L_place']=$lang['match']['place'];
$page['L_club']=$lang['match']['club'];
$page['L_point']=$lang['match']['nb_point_ab'];

$page['L_erreur']=$lang['general']['E_erreur'];
$page['meta_title']=$page['L_title'];
$page['template']=$tpl['match']['standings'];
?>