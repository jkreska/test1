<?php
# view du match
$page['L_message']="";


if($right_user['view_match']) {
	$page['show_view']=1; 
}
else {
	$page['show_view']='';
	$page['L_message']=$lang['general']['acces_reserve_admin'];
}

# we get the ID
$page['id']=$_GET['v2'];

# we get the information on the match
if(isset($page['id']) AND $page['id']!="")
{
 $sql_details=sql_replace($sql['match']['select_match_details'],$page);

 $sgbd = sql_connect();
 $res = sql_query($sql_details);
 $ligne = sql_fetch_array($res);
 sql_free_result($res);
 sql_close($sgbd);

 $page['id']=$ligne['match_id'];
 $page['club_visitor']=$ligne['club_visitor_name'];
 $page['club_home']=$ligne['club_home_name'];
 $page['club_visitor_id']=$ligne['club_visitor_id'];
 $page['club_home_id']=$ligne['club_home_id'];  
 $page['team_visitor']="";
 $page['team_home']=""; 
 if($ligne['team_visitor_name']!=NULL) $page['team_visitor']=$ligne['team_visitor_name'];
 if($ligne['team_home_name']!=NULL) $page['team_home']=$ligne['team_home_name'];
 $page['sex_visitor']=$ligne['sex_visitor_name'];
 $page['sex_home']=$ligne['sex_home_name'];
 $page['sex_visitor_abbreviation']=$ligne['sex_visitor_abbreviation'];
 $page['sex_home_abbreviation']=$ligne['sex_home_abbreviation'];
 
 $page['group']=$ligne['match_group'];
 $page['day']=$ligne['match_day']; 
 $page['penality_home']=$ligne['match_penality_home']; 
 $page['penality_visitor']=$ligne['match_penality_visitor'];
  
 $page['competition']="";
 $page['round']="";   
 $page['field_state']="";
 $page['field']="";
 $page['weather']="";
 $page['date_sql']=$ligne['match_date'];
 $page['date']=convert_date($ligne['match_date'],$lang['match']['format_date_php']);
 $page['hour']=convert_date($ligne['match_date'],$lang['match']['format_hour_php']);
 if($page['hour']=="00:00") $page['hour']="";
 $page['score_visitor']=$ligne['match_score_visitor'];
 $page['score_home']=$ligne['match_score_home'];
 if($ligne['match_spectators']!=NULL) $page['spectators']=$ligne['match_spectators'];
 else $page['spectators']="";
 $page['comment']=nl2br($ligne['match_comment']);
 
  $page['link_club_home']=convert_url("index.php?r=".$lang['general']['idurl_club']."&v1=view&v2=".$ligne['club_home_id']); 
    $page['link_club_visitor']=convert_url("index.php?r=".$lang['general']['idurl_club']."&v1=view&v2=".$ligne['club_visitor_id']); 
  $page['link_team_home']=convert_url("index.php?r=".$lang['general']['idurl_team']."&v1=view&v2=".$ligne['team_home_id']); 
    $page['link_team_visitor']=convert_url("index.php?r=".$lang['general']['idurl_team']."&v1=view&v2=".$ligne['team_visitor_id']); 	  
 
 # competition
 if(!empty($ligne['competition_id'])) {
  include_once(create_path("competition/sql_competition.php"));
  $var['id']=$ligne['competition_id'];
  $sgbd = sql_connect();
  $sql_competition=sql_replace($sql['competition']['select_competition_details'],$var);
  $res_competition = sql_query($sql_competition);
  $ligne_competition = sql_fetch_array($res_competition);
  sql_free_result($res_competition);
  $page['competition']=$ligne_competition['competition_name'];
  $page['link_competition']=convert_url("index.php?r=".$lang['general']['idurl_competition']."&v1=view&v2=".$ligne['competition_id']);  
 }
 
 # round
 if(!empty($ligne['round_id'])) {
  include_once(create_path("competition/sql_competition.php"));
  $var['id']=$ligne['round_id'];
  $sgbd = sql_connect();
  $sql_round=sql_replace($sql['competition']['select_round_details'],$var);
  $res_round = sql_query($sql_round);
  $ligne_round = sql_fetch_array($res_round);
  sql_free_result($res_round);
  $page['round']=$ligne_round['round_name'];
  $page['link_round']=convert_url("index.php?r=".$lang['general']['idurl_competition']."&v1=view&v2=".$ligne['competition_id']."&v3=".$ligne['round_id']."&v4=".$ligne['season_id']);  
 } 
 
  # weather
 if(!empty($ligne['weather_id'])) {
  $var['id']=$ligne['weather_id'];
  $sgbd = sql_connect();
  $sql_weather=sql_replace($sql['match']['select_weather_details'],$var);
  $res_weather = sql_query($sql_weather);
  $ligne_weather = sql_fetch_array($res_weather);
  sql_free_result($res_weather);
  $page['weather']=$ligne_weather['weather_name'];
 }

 # field_state
 if(!empty($ligne['field_state_id'])) {
  $var['id']=$ligne['field_state_id'];
  $sgbd = sql_connect();
  $sql_field_state=sql_replace($sql['match']['select_field_state_details'],$var);
  $res_field_state = sql_query($sql_field_state);
  $ligne_field_state = sql_fetch_array($res_field_state);
  sql_free_result($res_field_state);
  $page['field_state']=$ligne_field_state['field_state_name'];
 }
  
 # field
 if(!empty($ligne['field_id'])) {
  include_once(create_path("field/sql_field.php"));
  $var['id']=$ligne['field_id'];
  $sgbd = sql_connect();
  $sql_field=sql_replace($sql['field']['select_field_details'],$var);
  $res_field = sql_query($sql_field);
  $ligne_field = sql_fetch_array($res_field);
  sql_free_result($res_field);
  $page['field']=$ligne_field['field_name'];
  $page['link_field']=convert_url("index.php?r=".$lang['general']['idurl_field']."&v1=view&v2=".$ligne_field['field_id']);
;
 } 
 sql_close($sgbd);
 
 # On determine la season dans laquelle se joue le match
 /*
 $var['date']=convert_date($page['date_sql'],$lang['match']['format_date_sql']);
 include_once(create_path("competition/sql_competition.php"));
 $sql_season=sql_replace($sql['competition']['select_season_date'],$var);
 $sgbd = sql_connect();
 $res_season = sql_query($sql_season);
 $ligne_season = sql_fetch_array($res_season);
 sql_free_result($res_season);
 sql_close($sgbd);
 $page['season']=$ligne_season['season_id']; 
 */
 $page['season']=$ligne['season_id']; 
 
 # period
 $page['match_period']=array();
 $page['aff_match_period']="";
 if(!empty($page['score_visitor']) OR !empty($page['score_home'])) 
 {
  // on affiche de details des scores que s'il existe
	$var['match']=$page['id'];
	$sql_period=sql_replace($sql['match']['select_match_period'],$var);
	
	$sgbd = sql_connect();
	$res_period = sql_query($sql_period);
	$nb_ligne=sql_num_rows($res_period);
	
	if($nb_ligne!="0")
	{
	 $i="0";
	 while($ligne = sql_fetch_array($res_period))
	 {

	  if(isset($ligne['score_home']) AND $ligne['score_home']=='NULL') { $ligne['score_home']=""; }	  
	  if($ligne['score_home']!="") { $page['aff_match_period']="1"; }
	  if(isset($ligne['score_visitor']) AND $ligne['score_visitor']=='NULL') { $ligne['score_visitor']=""; }	  
	  if($ligne['score_visitor']!="") { $page['aff_match_period']="1"; }	  
	  
	  // si la period est required ou qu'il y a un score alors on l'affiche
	  if($ligne['period_required']==1 OR $ligne['score_home']!=""  OR $ligne['score_visitor']!="")
	  {	  	   
	    $page['match_period'][$i]['id']=$ligne['period_id'];
	    $page['match_period'][$i]['name']=$ligne['period_name'];
	    $page['match_period'][$i]['duration']=$ligne['period_length'];
	    $page['match_period'][$i]['required']=$ligne['period_required'];
	    $page['match_period'][$i]['score_home']=$ligne['score_home'];
	    $page['match_period'][$i]['score_visitor']=$ligne['score_visitor'];
  
	  }
	  $i++;
	 }
	}
	sql_free_result($res_period);
	sql_close($sgbd);
	if($page['aff_match_period']=="") { $page['match_period']=array(); }
	
	$page['L_details_period']=$lang['match']['details_period'];
  }	
 
}
else
{
 $page['L_message']=$lang['match']['E_erreur_presence_match'];
}


# liste des referees du match
$page['match_referee']=array();
$page['nb_referee']="0";
$var['match']=$page['id'];
$sql_match_referee=sql_replace($sql['match']['select_match_referee'],$var);

$sgbd = sql_connect();
$res_match_referee = sql_query($sql_match_referee);
$nb_ligne=sql_num_rows($res_match_referee);
$i="0";
if($nb_ligne!="0")
{
 while($ligne = sql_fetch_array($res_match_referee))
 {
  $page['match_referee'][$i]['referee_id']=$ligne['member_id'];
  $page['match_referee'][$i]['referee_firstname']=$ligne['member_firstname'];
  $page['match_referee'][$i]['referee_name']=$ligne['member_lastname'];
  $i++;
 }
}
$page['nb_referee']=$i;
sql_free_result($res_match_referee);
sql_close($sgbd);

$page['L_referee']=$lang['match']['match_referee'];


# liste des players du match 
$page['player_visitor_match_player']=array();
$page['player_visitor_substitute']=array();
$page['player_home_match_player']=array();
$page['player_home_substitute']=array();

$visitor_match_player=array();
$var['match']=$page['id'];
$var['season']=$page['season'];
$sql_player_match_player=sql_replace($sql['match']['select_match_player'],$var);

$sgbd = sql_connect();
$res_player_match_player = sql_query($sql_player_match_player);
$nb_ligne=sql_num_rows($res_player_match_player);
$i="0";
$ir="0";
$j="0";
$jr="0";
$page['nb_match_player_visitor']=0;
$page['nb_substitute_visitor']=0;
$page['nb_match_player_home']=0;
$page['nb_substitute_home']=0;
if($nb_ligne!="0")
{
 while($ligne = sql_fetch_array($res_player_match_player))
 {
  // si le player est in a t=0, alors c un match_player sinon c un substitute
  if($ligne['minute_in']==0) {
   // visitor
   if($ligne['club_id']==$page['club_visitor_id']) {
    $page['player_visitor_match_player'][$i]['i']=$i;
    $page['player_visitor_match_player'][$i]['id']=$ligne['player_in_id'];
    $page['player_visitor_match_player'][$i]['firstname']=$ligne['player_in_firstname'];
    $page['player_visitor_match_player'][$i]['name']=$ligne['player_in_name'];
	$page['player_visitor_match_player'][$i]['number']=$ligne['player_in_number'];
	$page['player_visitor_match_player'][$i]['position']=$ligne['player_in_position'];
	$page['player_visitor_match_player'][$i]['captain']=$ligne['player_in_captain'];	
    if($ligne['player_in_captain']==0) { $page['player_visitor_match_player'][$i]['captain']=""; }
    else { $page['player_visitor_match_player'][$i]['captain']=$lang['match']['yes']; }
  	
	$page['player_visitor_match_player'][$i]['link_view']=convert_url("index.php?r=".$lang['general']['idurl_member']."&v1=view&v2=".$ligne['player_in_id']);
	
	$page['player_visitor_match_player'][$i]['mod']=$i%2;
	
    $visitor_match_player[]=$ligne['player_in_id'];
    $i++;
   }
   elseif($ligne['club_id']==$page['club_home_id']) 
   {
    // home
    $page['player_home_match_player'][$ir]['i']=$ir;
    $page['player_home_match_player'][$ir]['id']=$ligne['player_in_id'];
    $page['player_home_match_player'][$ir]['firstname']=$ligne['player_in_firstname'];
    $page['player_home_match_player'][$ir]['name']=$ligne['player_in_name'];
	$page['player_home_match_player'][$ir]['number']=$ligne['player_in_number'];
	$page['player_home_match_player'][$ir]['position']=$ligne['player_in_position'];
	$page['player_home_match_player'][$ir]['captain']=$ligne['player_in_captain'];
    if($ligne['player_in_captain']==0) { $page['player_home_match_player'][$ir]['captain']=""; }
    else { $page['player_home_match_player'][$ir]['captain']=$lang['match']['yes']; }
	
	$page['player_home_match_player'][$ir]['link_view']=convert_url("index.php?r=".$lang['general']['idurl_member']."&v1=view&v2=".$ligne['player_in_id']);	
	$page['player_home_match_player'][$ir]['mod']=$ir%2;
	
    $home_match_player[]=$ligne['player_in_id'];
    $ir++;   
   }
  }
  else
  {
   if($ligne['club_id']==$page['club_visitor_id']) {
    // visitor
    $page['player_visitor_substitute'][$j]['i']=$j;
    $page['player_visitor_substitute'][$j]['minute']=$ligne['minute_in'];
    $page['player_visitor_substitute'][$j]['player_out']=$ligne['player_out_id'];   
    $page['player_visitor_substitute'][$j]['player_out_text']=$ligne['player_out_firstname']." ".$ligne['player_out_name'];
    $page['player_visitor_substitute'][$j]['player_in']=$ligne['player_in_id'];   
    $page['player_visitor_substitute'][$j]['player_in_text']=$ligne['player_in_firstname']." ".$ligne['player_in_name'];  
	$page['player_visitor_substitute'][$j]['player_in_number']=$ligne['player_in_number'];
	$page['player_visitor_substitute'][$j]['player_in_position']=$ligne['player_in_position'];
	$page['player_visitor_substitute'][$j]['player_in_captain']=$ligne['player_in_captain'];
	$page['player_visitor_substitute'][$j]['link_view_in']=convert_url("index.php?r=".$lang['general']['idurl_member']."&v1=view&v2=".$ligne['player_in_id']);
	
	$page['player_visitor_substitute'][$j]['player_out_number']=$ligne['player_out_number'];
	$page['player_visitor_substitute'][$j]['player_out_position']=$ligne['player_out_position'];
	$page['player_visitor_substitute'][$j]['player_out_captain']=$ligne['player_out_captain'];	
	$page['player_visitor_substitute'][$j]['link_view_out']=convert_url("index.php?r=".$lang['general']['idurl_member']."&v1=view&v2=".$ligne['player_out_id']);	
	$page['player_visitor_substitute'][$j]['mod']=$j%2;
	
    $j++;
   }
   elseif($ligne['club_id']==$page['club_home_id']) 
   {
    // home
    $page['player_home_substitute'][$jr]['i']=$jr;
    $page['player_home_substitute'][$jr]['minute']=$ligne['minute_in'];
    $page['player_home_substitute'][$jr]['player_out']=$ligne['player_out_id'];   
    $page['player_home_substitute'][$jr]['player_out_text']=$ligne['player_out_firstname']." ".$ligne['player_out_name'];
    $page['player_home_substitute'][$jr]['player_in']=$ligne['player_in_id'];   
    $page['player_home_substitute'][$jr]['player_in_text']=$ligne['player_in_firstname']." ".$ligne['player_in_name'];  

	$page['player_home_substitute'][$jr]['player_in_number']=$ligne['player_in_number'];
	$page['player_home_substitute'][$jr]['player_in_position']=$ligne['player_in_position'];
	$page['player_home_substitute'][$jr]['player_in_captain']=$ligne['player_in_captain'];
	$page['player_home_substitute'][$jr]['link_view_in']=convert_url("index.php?r=".$lang['general']['idurl_member']."&v1=view&v2=".$ligne['player_in_id']);
	
	$page['player_home_substitute'][$jr]['player_out_number']=$ligne['player_out_number'];
	$page['player_home_substitute'][$jr]['player_out_position']=$ligne['player_out_position'];
	$page['player_home_substitute'][$jr]['player_out_captain']=$ligne['player_out_captain'];	
	$page['player_home_substitute'][$jr]['link_view_out']=convert_url("index.php?r=".$lang['general']['idurl_member']."&v1=view&v2=".$ligne['player_out_id']);
	$page['player_home_substitute'][$jr]['mod']=$jr%2;
    $jr++;   
   }
  }  
 }
}
$page['nb_match_player_visitor']=$i;
$page['nb_match_player_home']=$ir;
$page['nb_substitute_visitor']=$j;
$page['nb_substitute_home']=$jr;
sql_free_result($res_player_match_player);
sql_close($sgbd);

// on affiche ou non les compositions des teams
$page['aff_composition']="";
$page['aff_composition_home']="";
$page['aff_composition_visitor']="";
if(!empty($page['nb_match_player_home']) OR !empty($page['nb_substitute_home']))
{
 $page['aff_composition_home']="1";
 $page['aff_composition']="1";
}
if(!empty($page['nb_match_player_visitor']) OR !empty($page['nb_substitute_visitor']))
{
 $page['aff_composition_visitor']="1";
 $page['aff_composition']="1";
}


# liste de tous les players qui jouent le match du cote home (pour les actions_match)
$page['player_home']=array();
$player_home=array();
for($i=0; $i < $page['nb_match_player_home']; $i++)
{
 $page['player_home'][$i]['id']=$page['player_home_match_player'][$i]['id'];
 $page['player_home'][$i]['text']=$page['player_home_match_player'][$i]['firstname']." ".$page['player_home_match_player'][$i]['name'];
 $player_home[]=$page['player_home_match_player'][$i]['id'];
}
$nb_player_home=sizeof($player_home);
for($i=0; $i < $page['nb_substitute_home']; $i++)
{
 if(!in_array($page['player_home_substitute'][$i]['player_in'],$player_home)) {
  $page['player_home'][$nb_player_home]['id']=$page['player_home_substitute'][$i]['player_in'];
  $page['player_home'][$nb_player_home]['text']=$page['player_home_substitute'][$i]['player_in_text'];
  $player_home[]=$page['player_home_substitute'][$i]['player_in'];
  $nb_player_home++;
 }
}

# liste de tous les players qui jouent le match du cote visitor (pour les actions_match)
$page['player_visitor']=array();
$player_visitor=array();
for($i=0; $i < $page['nb_match_player_visitor']; $i++)
{
 $page['player_visitor'][$i]['id']=$page['player_visitor_match_player'][$i]['id'];
 $page['player_visitor'][$i]['text']=$page['player_visitor_match_player'][$i]['firstname']." ".$page['player_visitor_match_player'][$i]['name'];
 $player_visitor[]=$page['player_visitor_match_player'][$i]['id'];
}
$nb_player_visitor=sizeof($player_visitor);
for($i=0; $i < $page['nb_substitute_visitor']; $i++)
{
 if(!in_array($page['player_visitor_substitute'][$i]['player_in'],$player_visitor)) {
  $page['player_visitor'][$nb_player_visitor]['id']=$page['player_visitor_substitute'][$i]['player_in'];
  $page['player_visitor'][$nb_player_visitor]['text']=$page['player_visitor_substitute'][$i]['player_in_text'];
  $player_visitor[]=$page['player_visitor_substitute'][$i]['player_in'];
  $nb_player_visitor++;
 }
}


# actions du match
$page['L_action_match']=$lang['match']['action_match'];
$page['L_minute']=$lang['match']['minute'];
$page['L_action']=$lang['match']['action'];
$page['L_player']=$lang['match']['player'];
$page['L_comment']=$lang['match']['comment'];
$page['L_player']=$lang['match']['player'];

$page['action_match_home']=array();
$page['action_match_visitor']=array();

$var['match']=$page['id'];
$var['season']=$page['season'];
$sql_action_match=sql_replace($sql['match']['select_action_match'],$var);

$sgbd = sql_connect();
$res_action_match = sql_query($sql_action_match);
$nb_ligne=sql_num_rows($res_action_match);
if($nb_ligne!="0")
{
 $i="0";
 $j="0";
 while($ligne = sql_fetch_array($res_action_match))
 {
  # home
  if(in_array($ligne['player_id'],$player_home)) {
   $page['action_match_home'][$i]['i']=$i;
   $page['action_match_home'][$i]['minute_action']=$ligne['minute_action'];
   $page['action_match_home'][$i]['action']=$ligne['action_id'];
   $page['action_match_home'][$i]['action_text']=$ligne['action_name'];
   $page['action_match_home'][$i]['player']=$ligne['player_id'];
   $page['action_match_home'][$i]['player_text']=$ligne['member_firstname']." ".$ligne['member_lastname'];
   $page['action_match_home'][$i]['comment_action']=$ligne['comment_action'];
   $page['action_match_home'][$i]['mod']=$i%2;
   $i++;
  }
  elseif(in_array($ligne['player_id'],$player_visitor)){
   $page['action_match_visitor'][$j]['i']=$j;
   $page['action_match_visitor'][$j]['minute_action']=$ligne['minute_action'];
   $page['action_match_visitor'][$j]['action']=$ligne['action_id'];
   $page['action_match_visitor'][$j]['action_text']=$ligne['action_name'];
   $page['action_match_visitor'][$j]['player']=$ligne['player_id'];
   $page['action_match_visitor'][$j]['player_text']=$ligne['member_firstname']." ".$ligne['member_lastname'];
   $page['action_match_visitor'][$j]['comment_action']=$ligne['comment_action'];
   $page['action_match_visitor'][$i]['mod']=$j%2;
   $j++;  
  }
 
 }
 $page['nb_action_home']=$i;
 $page['nb_action_visitor']=$j;
}
sql_free_result($res_action_match);
sql_close($sgbd);


# team STATS
$page['match_stats']=array();
$page['match_period_display']="none";
$var['match']=$page['id'];

$sgbd = sql_connect();
$sql_stats=sql_replace($sql['match']['select_match_stats'],$var);
$res_stats = sql_query($sql_stats);
$nb_ligne=sql_num_rows($res_stats); 
if($nb_ligne==0) {
 $sql_stats=$sql['match']['select_stats'];   
}
else {
 $sql_stats=sql_replace($sql['match']['select_match_stats'],$var);
}
$res_stats = sql_query($sql_stats);
$nb_ligne=sql_num_rows($res_stats);
$stats_id=array();
$i="0";
if($nb_ligne!="0")
{

 while($ligne = sql_fetch_array($res_stats))
 {
   if($ligne['stats_formula']=="") {
   $stats_id[]=$ligne['stats_id'];
   $page['match_stats'][$i]['id']=$ligne['stats_id'];
   $page['match_stats'][$i]['name']=$ligne['stats_name'];
   $page['match_stats'][$i]['abbreviation']=$ligne['stats_abbreviation'];
   $page['match_stats'][$i]['formula']=$ligne['stats_formula'];
   $page['match_stats'][$i]['value_home']="";
   $page['match_stats'][$i]['value_visitor']="";
   
   if(isset($ligne['value_home']) AND $ligne['value_home']=='NULL') { $ligne['value_home']=""; }
   if(isset($ligne['value_visitor']) AND $ligne['value_visitor']=='NULL') { $ligne['value_visitor']="";  }
  
    if(isset($ligne['value_home'])) $page['match_stats'][$i]['value_home']=$ligne['value_home'];
    if(isset($ligne['value_visitor'])) $page['match_stats'][$i]['value_visitor']=$ligne['value_visitor'];
     
   $i++;
   }
 }
}
sql_free_result($res_stats);
sql_close($sgbd);

# stats_player
$page['stats_player']=array();
$stats_player_id=array();
$stats_player_code=array();
$sql_stats_player=sql_replace($sql['match']['select_stats_player'],$var);
$sgbd = sql_connect();
$res_stats_player = sql_query($sql_stats_player);
$nb_ligne=sql_num_rows($res_stats_player); 
if($nb_ligne!=0) {
 $i=0;
 while($ligne=sql_fetch_array($res_stats_player)) {
  if($ligne['stats_player_formula']=="") {
   $page['stats_player'][$i]['i']=$i;
   $page['stats_player'][$i]['id']=$ligne['stats_player_id'];
   $page['stats_player'][$i]['name']=$ligne['stats_player_name'];
   $page['stats_player'][$i]['abbreviation']=$ligne['stats_player_abbreviation'];    
   $stats_player_id[$i]=$ligne['stats_player_id'];
   $stats_player_code[$i]=$ligne['stats_player_code'];
   $i++;
  }
 }
}
sql_free_result($res_stats_player);
sql_close($sgbd);


# match_stats_player_home
$page['stats_player_home']=array();
$page['stats_player_visitor']=array();
$var['match']=$page['id'];
if(!empty($page['id'])) {
 $sql_stats_player=sql_replace($sql['match']['select_match_stats_player'],$var);
 $sgbd = sql_connect();
 $res_stats_player = sql_query($sql_stats_player);
 $nb_ligne=sql_num_rows($res_stats_player);
 if($nb_ligne!="0")
 {
  while($ligne = sql_fetch_array($res_stats_player))
  {
   $member=$ligne['member_id'];
   $stats_player=$ligne['stats_player_id'];  
   $match_stats_player[$member][$stats_player]=$ligne['value'];
  }
 }
 sql_free_result($res_stats_player);
 sql_close($sgbd);
}


$nb_stats_player=sizeof($stats_player_id);

# home
for($i=0; $i<$nb_player_home; $i++) {
 $player=$page['player_home'][$i]['id'];
 $page['stats_player_home'][$i]['i']=$i;
 $page['stats_player_home'][$i]['player']=$page['player_home'][$i]['text'];
 $page['stats_player_home'][$i]['club']=$page['player_home'][$i]['text'];
 $page['stats_player_home'][$i]['stats_player']=array();
 
 for($j=0; $j<$nb_stats_player; $j++) {
  $stats_player=$stats_player_id[$j];  
  if(isset($match_stats_player[$player][$stats_player])) {
   $page['stats_player_home'][$i]['stats_player'][$j]['value']=$match_stats_player[$player][$stats_player];
  }
 }
}

# visitor
for($i=0; $i<$nb_player_visitor; $i++) {
 $player=$page['player_visitor'][$i]['id'];
 $page['stats_player_visitor'][$i]['i']=$i;
 $page['stats_player_visitor'][$i]['player']=$page['player_visitor'][$i]['text'];
 $page['stats_player_visitor'][$i]['stats_player']=array();

 for($j=0; $j<$nb_stats_player; $j++) {
 $stats_player=$stats_player_id[$j];
  $page['stats_player_visitor'][$i]['stats_player'][$j]['value']="";  
  if(isset($match_stats_player[$player][$stats_player])) {
   $page['stats_player_visitor'][$i]['stats_player'][$j]['value']=$match_stats_player[$player][$stats_player];
  }
 }
}

$page['stats_player_home_display']="none";
$page['stats_player_visitor_display']="none";
if(sizeof($page['stats_player_home'])>0) $page['stats_player_home_display']="block";
if(sizeof($page['stats_player_visitor'])>0) $page['stats_player_visitor_display']="block";



# modification
$page['link_edit']="";
$page['link_delete']="";
if($right_user['edit_match'])
{
 $page['link_edit']=convert_url("index.php?r=".$lang['general']['idurl_match']."&v1=form_match&v2=".$page['id']);

}
if($right_user['delete_match'])
{
 $page['link_delete']=convert_url("index.php?r=".$lang['general']['idurl_match']."&v1=match_list&v2=delete&v3=".$page['id']);
}


# text
$page['L_title']=$lang['match']['view_match'];
$page['L_match']=$lang['match']['match'];
$page['L_home']=$lang['match']['home'];
$page['L_visitor']=$lang['match']['visitor'];
$page['L_details']=$lang['match']['details'];
$page['L_competition']=$lang['match']['competition'];
$page['L_field_state']=$lang['match']['field_state'];
$page['L_field']=$lang['match']['field'];
$page['L_weather']=$lang['match']['weather'];
$page['L_date']=$lang['match']['date'];
$page['L_hour']=$lang['match']['hour'];
$page['L_score']=$lang['match']['score'];
$page['L_spectators']=$lang['match']['spectators'];
$page['L_comment']=$lang['match']['comment'];

$page['L_composition_team']=$lang['match']['composition_team'];
$page['L_match_player']=$lang['match']['match_player'];
$page['L_substitute']=$lang['match']['substitute'];
$page['L_minute']=$lang['match']['minute'];
$page['L_number']=$lang['mem']['number'];
$page['L_position']=$lang['match']['position'];
$page['L_captain']=$lang['match']['captain'];
$page['L_player_in']=$lang['match']['player_in'];
$page['L_player_out']=$lang['match']['player_out'];

$page['L_stats']=$lang['match']['stats'];
$page['L_group']=$lang['match']['group'];
$page['L_day']=$lang['match']['day'];
$page['L_penality']=$lang['match']['penality'];

$page['L_stats_player']=$lang['match']['stats_player'];

$page['L_edit']=$lang['match']['edit'];
$page['L_delete']=$lang['match']['delete'];


# meta
$page['meta_title']=$lang['match']['view_match'];

$page['template']=$tpl['match']['view_match'];
?>