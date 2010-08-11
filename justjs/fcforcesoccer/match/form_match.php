<?php

##################################
# match 
##################################

# variables
$page['L_message_match']="";
$nb_erreur="0";
$page['erreur']=array();
$page['match']=array();

# form values
$page['value_id']="";
$page['value_club_visitor']="";
$page['value_club_home']="";
$page['value_team_visitor']="";
$page['value_team_home']="";
$page['value_competition']="";
$page['value_round']="";
$page['value_penality_home']="";
$page['value_penality_visitor']="";
$page['value_group']="";
$page['value_day']="";
$page['value_field_state']="";
$page['value_field']="";
$page['value_weather']="";
$page['value_date']="";
$page['value_hour']="";
$page['value_score_visitor']="";
$page['value_score_home']="";
$page['value_spectators']="";
$page['value_comment']="";

$duration_match=0;

# elements du formulaire
$page['competition']=array();
$page['field_state']=array();
$page['field']=array();
$page['weather']=array();

# si l'identifiant du match est passe dans l'weather (modification), on le recupere
if(isset($_GET['v2']) AND $_GET['v2']!="") { $page['value_id']=$_GET['v2']; }
elseif(isset($_POST['id']) AND $_POST['id']!="") { $page['value_id']=$_POST['id']; }

if($right_user['add_match'] OR $right_user['edit_match']) {
	$page['show_form']=1; 
}
else {
	$page['show_form']='';
	$page['L_message']=$lang['general']['acces_reserve_admin'];
}

# case of add or edit
if(isset($_POST) AND !empty($_POST))
{
 # we format datas
 if(isset($_POST['comment'])) $_POST['comment']=format_txt($_POST['comment']);
 if(isset($_POST['score_visitor'])) $_POST['score_visitor']=format_txt($_POST['score_visitor']);
 if(isset($_POST['score_home'])) $_POST['score_home']=format_txt($_POST['score_home']);
 if(isset($_POST['date'])) $_POST['date']=format_txt($_POST['date']);
 if(isset($_POST['hour'])) $_POST['hour']=format_txt($_POST['hour']);
 if(isset($_POST['spectators'])) $_POST['spectators']=format_txt($_POST['spectators']);
 

 # we check datas
 if(!isset($_POST['club_home']) OR $_POST['club_home']=="") { $page['erreur'][$nb_erreur]['message']=$lang['match']['E_empty_club_home_match']; $nb_erreur++; }
 if(!isset($_POST['club_visitor']) OR $_POST['club_visitor']=="") { $page['erreur'][$nb_erreur]['message']=$lang['match']['E_empty_club_visitor_match']; $nb_erreur++; }
 
 # mode club
 /*
 if(CLUB!=0 AND ((isset($_POST['club_home']) AND $_POST['club_home']!=CLUB) AND (isset($_POST['club_visitor']) AND $_POST['club_visitor']!=CLUB)))
 {
  $page['erreur'][$nb_erreur]['message']=$lang['match']['E_invalid_club_defaut']; $nb_erreur++;
 }
 */
 
 # si les teams sont identiques
  if(isset($_POST['team_visitor']) AND isset($_POST['team_home']) AND $_POST['team_visitor']!="" AND $_POST['team_home']!="" AND $_POST['team_visitor']==$_POST['team_home']) { $page['erreur'][$nb_erreur]['message']=$lang['match']['E_team_same']; $nb_erreur++; }
 
 if(!isset($_POST['date']) OR empty($_POST['date'])) { $page['erreur'][$nb_erreur]['message']=$lang['match']['E_empty_date']; $nb_erreur++; }
 elseif(!check_date($_POST['date'])) { $page['erreur'][$nb_erreur]['message']=$lang['match']['E_invalid_date']; $nb_erreur++; }
 else
 {
  # on verifie qu'une season correspond a cette date, et on la recupere
  include_once(create_path("competition/sql_competition.php"));
  $var['date']=convert_date_sql($_POST['date']);
  $sql_season=sql_replace($sql['competition']['select_season_date'],$var);
  $sgbd = sql_connect();
  $res_season=sql_query($sql_season);
  $nb_season=sql_num_rows($res_season);
  if($nb_season==0) {
   $var['link_season']=convert_url("index.php?r=".$lang['general']['idurl_competition']."&v1=season_list&fen=pop");   
   $page['erreur'][$nb_erreur]['message']=text_replace($lang['match']['E_empty_season'],$var);
   $nb_erreur++; 
  }
  else
  {
   $ligne_season=sql_fetch_array($res_season); 
   $_POST['season']=$ligne_season['season_id']; // on stocke la season
  } 
  sql_free_result($res_season);  
 }
 
 if(isset($_POST['hour']) AND !empty($_POST['hour']) AND !check_hour($_POST['hour'])) { $page['erreur'][$nb_erreur]['message']=$lang['match']['E_invalid_hour']; $nb_erreur++; }
 if(isset($_POST['spectators']) AND !empty($_POST['spectators']) AND !check_integer($_POST['spectators'])) { $page['erreur'][$nb_erreur]['message']=$lang['match']['E_invalid_spectators']; $nb_erreur++; }
 
 # on verifie qu'il n'est pas deja present
 if($nb_erreur==0)
 {  
  $_POST['date_hour']=convert_date_sql($_POST['date'])." ".$_POST['hour'];

   $sgbd = sql_connect();
   $sql_verif = sql_replace($sql['match']['verif_presence_match'],$_POST);
   $res_verif = sql_query($sql_verif);
   $nb_res = sql_num_rows($res_verif);
   sql_free_result($res_verif);
   sql_close($sgbd);
   if($nb_res!="0") { $page['erreur'][$nb_erreur]['message']=$lang['match']['E_exist_match']; $nb_erreur++; }
 } 

 # there is no error in submited datas
 if($nb_erreur==0)
 {
  if(!isset($_POST['team_home'])) $_POST['team_home']="";
  if(!isset($_POST['team_visitor'])) $_POST['team_visitor']="";
  if(!isset($_POST['score_visitor']) OR $_POST['score_visitor']=="") { $_POST['score_visitor']="NULL"; }
  if(!isset($_POST['score_home']) OR $_POST['score_home']=="") { $_POST['score_home']="NULL"; }
  if(!isset($_POST['spectators']) OR $_POST['spectators']=="") { $_POST['spectators']="NULL"; }
  if(!isset($_POST['round'])) $_POST['round']="";
  if(!isset($_POST['group'])) $_POST['group']="";
  if(!isset($_POST['day'])) $_POST['day']="";
  if(!isset($_POST['penality_home'])) $_POST['penality_home']="";
  if(!isset($_POST['penality_visitor'])) $_POST['penality_visitor']="";
     
  # case : new item to add
  if(!isset($_POST['id']) OR empty($_POST['id']) AND $right_user['add_match'])
  {
   $sql_add=sql_replace($sql['match']['insert_match'],$_POST);
   $sgbd = sql_connect();
   $execution=sql_query($sql_add);
   if($execution)  { $page['L_message_match']=$lang['match']['form_match_add_1']; }
   else { $page['L_message_match']=$lang['match']['form_match_add_0']; }   
   $page['value_id']=sql_insert_id($sgbd);
   sql_close($sgbd);
  
   # match_referee 
   $values=array();
   if($execution AND isset($_POST['referee']) AND !empty($_POST['referee']))
   {
    $tab_referee=array_keys($_POST['referee']); 
    foreach($tab_referee as $key => $value)
 	{
	 $values[]="('".$page['value_id']."','".$_POST['referee'][$value]."')";
	}	
	$var['values']=implode(", ",$values);
	$sql_add=sql_replace($sql['match']['insert_match_referee'],$var);
	$sgbd = sql_connect();
	sql_query($sql_add);
	sql_close($sgbd);
   }
   
   # match_period
   $values=array();
   if($execution AND isset($_POST['period']) AND !empty($_POST['period']))
   {
    $tab_period=array_keys($_POST['period']); 
    foreach($tab_period as $key => $value)
 	{
	  if($_POST['period_score_home'][$value]=="") $score_home='NULL'; else $score_home=$_POST['period_score_home'][$value];
	  if($_POST['period_score_visitor'][$value]=="") $score_visitor='NULL'; else $score_visitor=$_POST['period_score_visitor'][$value];
	  
	  $values[]="('".$page['value_id']."','".$_POST['period'][$value]."',".$score_home.",".$score_visitor.") ";
	  
	  // on calcule la duration du match
	  if($_POST['period_required'][$value]==1 || $_POST['period_score_visitor'][$value]!="" || $_POST['period_score_home'][$value]!="") {
	   $duration_match+=$_POST['period_length'][$value];
	  }
	}	
	$var['values']=implode(", ",$values);
	$sql_add=sql_replace($sql['match']['insert_match_period'],$var);
	$sgbd = sql_connect();
	sql_query($sql_add);
	sql_close($sgbd);
   }
   
   # match_stats
   $values=array();
   if($execution AND isset($_POST['stats']) AND !empty($_POST['stats']))
   {
    $tab_stats=array_keys($_POST['stats']); 
    foreach($tab_stats as $key => $value)
 	{
	  if($_POST['stats_value_home'][$value]=="") $value_home='NULL'; else $value_home=$_POST['stats_value_home'][$value];
	  if($_POST['stats_value_visitor'][$value]=="") $value_visitor='NULL'; else $value_visitor=$_POST['stats_value_visitor'][$value];
	  
	  $values[]="('".$page['value_id']."','".$_POST['stats'][$value]."',".$value_home.",".$value_visitor.") ";	  	  
	}	
	$var['values']=implode(", ",$values);
	$sql_add=sql_replace($sql['match']['insert_match_stats'],$var);
	$sgbd = sql_connect();
	sql_query($sql_add);
	sql_close($sgbd);
   }
   
   # match_stats_player
   $values=array();
   if($execution AND isset($_POST['player_id']) AND !empty($_POST['player_id']))
   {
    $tab_player=array_keys($_POST['player_id']); 
	foreach($tab_player as $key => $value)
 	{
	 $player_id=$_POST['player_id'][$value];
	 $tab_stats_player=array_keys($_POST['stats_player'][$player_id]);
	 	 
	 foreach($tab_stats_player as $key => $value)
	 {
	  $values[]="('".$page['value_id']."','".$_POST['stats_player'][$player_id][$value]."','".$player_id."','".$_POST['stats_player_value'][$player_id][$value]."') ";
	 }	 
	}
	$var['values']=implode(", ",$values);
	$sql_add=sql_replace($sql['match']['insert_match_stats_player'],$var);
	$sgbd = sql_connect();
	sql_query($sql_add);
	sql_close($sgbd);	
   } 
      

    # match_player    
    //on regroupe les donnees
    if(isset($_POST['player_match_player_visitor']) && isset($_POST['player_match_player_home'])) {
     $_POST['player_match_player']=array_merge($_POST['player_match_player_visitor'],$_POST['player_match_player_home']); }
    elseif(isset($_POST['player_match_player_visitor'])) { $_POST['player_match_player']=$_POST['player_match_player_visitor']; }
    elseif(isset($_POST['player_match_player_home'])) { $_POST['player_match_player']=$_POST['player_match_player_home']; }
      
    if($execution AND isset($_POST['player_match_player']) AND !empty($_POST['player_match_player']))
    {
    
	 $tab_player=array_keys($_POST['player_match_player']); 
	 $values=array();
     foreach($tab_player as $key => $value)
 	 {
	  $values[]="('".$page['value_id']."','".$_POST['player_match_player'][$value]."','0','0','".$duration_match."')";
	 }	
	 $var['values']=implode(", ",$values);
	 $sql_add=sql_replace($sql['match']['insert_match_player'],$var);
	
	 $sgbd = sql_connect();
	 sql_query($sql_add);
  	 sql_close($sgbd);
    }
   
    # substitute
    // on regroupe les donnees
    if(isset($_POST['player_visitor_in']) && isset($_POST['player_home_in']) &&
    is_array($_POST['player_visitor_in']) && is_array($_POST['player_home_in'])) {
     $_POST['player_in']=array_merge($_POST['player_visitor_in'],$_POST['player_home_in']);
     $_POST['player_out']=array_merge($_POST['player_visitor_out'],$_POST['player_home_out']);
     $_POST['minute_substitute']=array_merge($_POST['substitute_visitor_minute'],$_POST['substitute_home_minute']);
    }
    elseif(isset($_POST['player_visitor_in']) &&
    is_array($_POST['player_visitor_in']) ) { 
     $_POST['player_in']=$_POST['player_visitor_in'];
     $_POST['player_out']=$_POST['player_visitor_out'];
     $_POST['minute_substitute']=$_POST['substitute_visitor_minute'];
    }
    elseif(isset($_POST['player_home_in']) && is_array($_POST['player_home_in'])) {
     $_POST['player_in']=$_POST['player_home_in'];
     $_POST['player_out']=$_POST['player_home_out'];
     $_POST['minute_substitute']=$_POST['substitute_home_minute'];	
    }	
   
    if($execution AND isset($_POST['player_in']) AND !empty($_POST['player_in'])) 
    { 	
	 $tab_player=array_keys($_POST['player_in']); 
	 $values=array();
	 $cpt=0;
	
     foreach($tab_player as $key => $value)
 	 {
	  $values[]="('".$page['value_id']."','".$_POST['player_in'][$value]."','".$_POST['player_out'][$value]."','".$_POST['minute_substitute'][$value]."','".$duration_match."')"; # minute max de release ??? (duration totale du match)
	 	 
	  # il faut mettre a day la minute de release des players qui sortent
	  # on verifie que le player n'a pas deja joue
	  $var['minute_in']="0";
	  if(in_array($_POST['player_out'][$value],$_POST['player_in']))
	  {
	  // on parcours la liste des substitutes pour recuperer la derniere minute ou le player est in
	   for($i = "0"; $i < $cpt; $i++) {	   
	    if($_POST['player_out'][$value]==$_POST['player_in'][$i]) 
	    {
	  	$var['minute_in']=$_POST['minute_substitute'][$i];
	    }
	   }
	  }	 
	 
	  $var['match']=$page['value_id'];
	  $var['player_in']=$_POST['player_out'][$value];
	  $var['minute_out']=$_POST['minute_substitute'][$value];	 
	  $edit[]=sql_replace($sql['match']['edit_match_player'],$var);
	  $cpt++;
	 }	
	 $var['values']=implode(", ",$values);	
	 $sql_add=sql_replace($sql['match']['insert_match_player'],$var);
	 	
	 $sgbd = sql_connect();
	 sql_query($sql_add);
	 for($i=0; $i < sizeof($edit); $i++) { sql_query($edit[$i]); }
	 sql_close($sgbd);	
    }

  
    # match_action
    // on regroupe les donnees
    if(isset($_POST['action_visitor']) && isset($_POST['action_home']) &&
    is_array($_POST['action_visitor']) && is_array($_POST['action_home'])) {
     $_POST['player']=array_merge($_POST['player_visitor'],$_POST['player_home']);
     $_POST['action']=array_merge($_POST['action_visitor'],$_POST['action_home']);
     $_POST['minute_action']=array_merge($_POST['minute_action_visitor'],$_POST['minute_action_home']);
	 $_POST['comment_action']=array_merge($_POST['comment_action_visitor'],$_POST['comment_action_home']);
    }
    elseif(isset($_POST['action_visitor']) && is_array($_POST['action_visitor']) ) { 
     $_POST['player']=$_POST['player_visitor'];
     $_POST['action']=$_POST['action_visitor'];
     $_POST['minute_action']=$_POST['minute_action_visitor'];
	 $_POST['comment_action']=$_POST['comment_action_visitor'];
    }
    elseif(isset($_POST['action_home']) && is_array($_POST['action_home'])) {
     $_POST['player']=$_POST['player_home'];
     $_POST['action']=$_POST['action_home'];
     $_POST['minute_action']=$_POST['minute_action_home'];
	 $_POST['comment_action']=$_POST['comment_action_home'];	
    }
		
    if($execution AND isset($_POST['action']) AND !empty($_POST['action']))   	
	{
	 $tab_action=array_keys($_POST['action']); 
	 $values=array();
	 $cpt=0;
	
     foreach($tab_action as $key => $value)
 	 {
	  $values[]="('".$page['value_id']."','".$_POST['player'][$value]."','".$_POST['action'][$value]."','".$_POST['minute_action'][$value]."','".$_POST['comment_action'][$value]."')"; 	
	 }
	 $var['values']=implode(", ",$values);
	 $sql_add=sql_replace($sql['match']['insert_action_match'],$var);
	 	
	 $sgbd = sql_connect();
	 sql_query($sql_add);
	 sql_close($sgbd);		 	 
	}     
  }
  # case : item to modify
  elseif($right_user['edit_match'])
  {
   $sql_modification=sql_replace($sql['match']['edit_match'],$_POST);
   
   $sgbd = sql_connect();
   $execution=sql_query($sql_modification);
   if($execution != false)  { $page['L_message_match']=$lang['match']['form_match_edit_1']; }
   else { $page['L_message_match']=$lang['match']['form_match_edit_0']; }  
   sql_close($sgbd);
   
    
   if($execution)
   {  
    
    # on supprime tous les elements
	$var['match']=$page['value_id'];
	$sql_sup_referee=sql_replace($sql['match']['sup_match_referee'],$var);
	$sql_sup_period=sql_replace($sql['match']['sup_match_period'],$var);
	$sql_sup_stats=sql_replace($sql['match']['sup_match_stats'],$var);	
	$sql_sup_stats_player=sql_replace($sql['match']['sup_match_stats_player'],$var);	 
	$sgbd = sql_connect();
	sql_query($sql_sup_referee);
	sql_query($sql_sup_period);
	sql_query($sql_sup_stats);
	sql_query($sql_sup_stats_player);
	sql_close($sgbd);
	
	# match_referee
    if(isset($_POST['referee']) AND !empty($_POST['referee']))
    {
	   
     $tab_referee=array_keys($_POST['referee']); 
     foreach($tab_referee as $key => $value)
   	 { 
 	  $values[]="('".$page['value_id']."','".$_POST['referee'][$value]."')";
	 }	
	 $var['values']=implode(", ",$values);
	 $sql_add=sql_replace($sql['match']['insert_match_referee'],$var);
	
	 $sgbd = sql_connect();
	 sql_query($sql_add);
	 sql_close($sgbd);	
    }
	
    # match_period
    if($execution AND isset($_POST['period']) AND !empty($_POST['period']))
    {
     $tab_period=array_keys($_POST['period']); 
   	 $values=array();
     foreach($tab_period as $key => $value)
 	 {
	  if($_POST['period_score_home'][$value]=="") $score_home='NULL'; else $score_home=$_POST['period_score_home'][$value];
	  if($_POST['period_score_visitor'][$value]=="") $score_visitor='NULL'; else $score_visitor=$_POST['period_score_visitor'][$value];
	  
	  $values[]="('".$page['value_id']."','".$_POST['period'][$value]."',".$score_home.",".$score_visitor.") ";

	  // on calcule la duration du match
	  if($_POST['period_required'][$value]==1 || $_POST['period_score_visitor'][$value]!="" || $_POST['period_score_home'][$value]!="") {
	   $duration_match+=$_POST['period_length'][$value];
	  }
	  	  
	 }	
	 $var['values']=implode(", ",$values);
	 $sql_add=sql_replace($sql['match']['insert_match_period'],$var);

     $sgbd = sql_connect();
	 sql_query($sql_add);
	 sql_close($sgbd);
    }
	
    # match_stats
	$values=array();
   if($execution AND isset($_POST['stats']) AND !empty($_POST['stats']))
   {
    $tab_stats=array_keys($_POST['stats']); 
    foreach($tab_stats as $key => $value)
 	{
	 if($_POST['stats_value_home'][$value]=="") { $value_home='NULL'; } else { $value_home=$_POST['stats_value_home'][$value]; }
	 if($_POST['stats_value_visitor'][$value]=="") { $value_visitor='NULL'; } else { $value_visitor=$_POST['stats_value_visitor'][$value]; }
	 
	  $values[]="('".$page['value_id']."','".$_POST['stats'][$value]."',".$value_home.",".$value_visitor.") ";
	}	
	$var['values']=implode(", ",$values);
	$sql_add=sql_replace($sql['match']['insert_match_stats'],$var);
	$sgbd = sql_connect();
	sql_query($sql_add);
	sql_close($sgbd);
   } 
   
   # match_stats_player
   $values=array();
   if($execution AND isset($_POST['player_id']) AND !empty($_POST['player_id']))
   {
    $tab_player=array_keys($_POST['player_id']); 
	foreach($tab_player as $key => $value)
 	{
	 $player_id=$_POST['player_id'][$value];
	 $tab_stats_player=array_keys($_POST['stats_player'][$player_id]);
	 	 
	 foreach($tab_stats_player as $key => $value)
	 {
	  $values[]="('".$page['value_id']."','".$_POST['stats_player'][$player_id][$value]."','".$player_id."','".$_POST['stats_player_value'][$player_id][$value]."') ";
	 }	 
	}
	$var['values']=implode(", ",$values);
	$sql_add=sql_replace($sql['match']['insert_match_stats_player'],$var);
	$sgbd = sql_connect();
	sql_query($sql_add);
	sql_close($sgbd);	
   }   
	
    # match_player 
    // on supprime tous les elements
	$var['match']=$page['value_id'];
	$sql_sup_player=sql_replace($sql['match']['sup_match_player'],$var);	 
	$sgbd = sql_connect();
	sql_query($sql_sup_player);
	sql_close($sgbd);   
      
    # match_player
    //on regroupe les donnees
    if(isset($_POST['player_match_player_visitor']) && isset($_POST['player_match_player_home'])) {
     $_POST['player_match_player']=array_merge($_POST['player_match_player_visitor'],$_POST['player_match_player_home']); }
    elseif(isset($_POST['player_match_player_visitor'])) { $_POST['player_match_player']=$_POST['player_match_player_visitor']; }
    elseif(isset($_POST['player_match_player_home'])) { $_POST['player_match_player']=$_POST['player_match_player_home']; }
      
    if($execution AND isset($_POST['player_match_player']) AND !empty($_POST['player_match_player']))
    {
    
	 $tab_player=array_keys($_POST['player_match_player']); 
	 $values=array();
     foreach($tab_player as $key => $value)
 	 {
	  $values[]="('".$page['value_id']."','".$_POST['player_match_player'][$value]."','0','0','".$duration_match."')";
	 }	
	 $var['values']=implode(", ",$values);
	 $sql_add=sql_replace($sql['match']['insert_match_player'],$var);
	
	 $sgbd = sql_connect();
	 sql_query($sql_add);
  	 sql_close($sgbd);
    }
   
    # substitute
    // on regroupe les donnees
    if(isset($_POST['player_visitor_in']) && isset($_POST['player_home_in']) &&
    is_array($_POST['player_visitor_in']) && is_array($_POST['player_home_in'])) {
     $_POST['player_in']=array_merge($_POST['player_visitor_in'],$_POST['player_home_in']);
     $_POST['player_out']=array_merge($_POST['player_visitor_out'],$_POST['player_home_out']);
     $_POST['minute_substitute']=array_merge($_POST['substitute_visitor_minute'],$_POST['substitute_home_minute']);
    }
    elseif(isset($_POST['player_visitor_in']) &&
    is_array($_POST['player_visitor_in']) ) { 
     $_POST['player_in']=$_POST['player_visitor_in'];
     $_POST['player_out']=$_POST['player_visitor_out'];
     $_POST['minute_substitute']=$_POST['substitute_visitor_minute'];
    }
    elseif(isset($_POST['player_home_in']) && is_array($_POST['player_home_in'])) {
     $_POST['player_in']=$_POST['player_home_in'];
     $_POST['player_out']=$_POST['player_home_out'];
     $_POST['minute_substitute']=$_POST['substitute_home_minute'];	
    }	
   
    if($execution AND isset($_POST['player_in']) AND !empty($_POST['player_in'])) 
    { 	
	 $tab_player=array_keys($_POST['player_in']); 
	 $values=array();
	 $cpt=0;
	
     foreach($tab_player as $key => $value)
 	 {
	  $values[]="('".$page['value_id']."','".$_POST['player_in'][$value]."','".$_POST['player_out'][$value]."','".$_POST['minute_substitute'][$value]."','".$duration_match."')"; # minute max de release ??? (duration totale du match)
	 	 
	  # il faut mettre a day la minute de release des players qui sortent
	  # on verifie que le player n'a pas deja joue
	  $var['minute_in']="0";
	  if(in_array($_POST['player_out'][$value],$_POST['player_in']))
	  {
	  // on parcours la liste des substitutes pour recuperer la derniere minute ou le player est in
	   for($i = "0"; $i < $cpt; $i++) {	   
	    if($_POST['player_out'][$value]==$_POST['player_in'][$i]) 
	    {
	  	$var['minute_in']=$_POST['minute_substitute'][$i];
	    }
	   }
	  }	 
	 
	  $var['match']=$page['value_id'];
	  $var['player_in']=$_POST['player_out'][$value];
	  $var['minute_out']=$_POST['minute_substitute'][$value];	 
	  $edit[]=sql_replace($sql['match']['edit_match_player'],$var);
	  $cpt++;
	 }	
	 $var['values']=implode(", ",$values);	
	 $sql_add=sql_replace($sql['match']['insert_match_player'],$var);
	 	
	 $sgbd = sql_connect();
	 sql_query($sql_add);
	 for($i=0; $i < sizeof($edit); $i++) { sql_query($edit[$i]); }
	 sql_close($sgbd);	
    }
   
    # match_action
    // on supprime tous les elements
	$var['match']=$page['value_id'];
	$sql_sup_action=sql_replace($sql['match']['sup_action_match'],$var);	 
	$sgbd = sql_connect();
	sql_query($sql_sup_action);
	sql_close($sgbd); 
		
    // on regroupe les donnees
    if(isset($_POST['action_visitor']) && isset($_POST['action_home']) &&
    is_array($_POST['action_visitor']) && is_array($_POST['action_home'])) {
     $_POST['player']=array_merge($_POST['player_visitor'],$_POST['player_home']);
     $_POST['action']=array_merge($_POST['action_visitor'],$_POST['action_home']);
     $_POST['minute_action']=array_merge($_POST['minute_action_visitor'],$_POST['minute_action_home']);
	 $_POST['comment_action']=array_merge($_POST['comment_action_visitor'],$_POST['comment_action_home']);
    }
    elseif(isset($_POST['action_visitor']) && is_array($_POST['action_visitor']) ) { 
     $_POST['player']=$_POST['player_visitor'];
     $_POST['action']=$_POST['action_visitor'];
     $_POST['minute_action']=$_POST['minute_action_visitor'];
	 $_POST['comment_action']=$_POST['comment_action_visitor'];
    }
    elseif(isset($_POST['action_home']) && is_array($_POST['action_home'])) {
     $_POST['player']=$_POST['player_home'];
     $_POST['action']=$_POST['action_home'];
     $_POST['minute_action']=$_POST['minute_action_home'];
	 $_POST['comment_action']=$_POST['comment_action_home'];	
    }
		
    if($execution AND isset($_POST['action']) AND !empty($_POST['action']))   	
	{
	 $tab_action=array_keys($_POST['action']); 
	 $values=array();
	 $cpt=0;
	
     foreach($tab_action as $key => $value)
 	 {
	  $values[]="('".$page['value_id']."','".$_POST['player'][$value]."','".$_POST['action'][$value]."','".$_POST['minute_action'][$value]."','".$_POST['comment_action'][$value]."')"; 	
	 }
	 $var['values']=implode(", ",$values);
	 $sql_add=sql_replace($sql['match']['insert_action_match'],$var);
	 	
	 $sgbd = sql_connect();
	 sql_query($sql_add);
	 sql_close($sgbd);		 	 
	}    	
   }  
  }
 }
 else
 {
  # there is some errors: we show the datas again
  if(isset($_POST['id'])) $page['value_id']=$_POST['id'];
  if(isset($_POST['club_visitor'])) $page['value_club_visitor']=$_POST['club_visitor'];
  if(isset($_POST['club_home'])) $page['value_club_home']=$_POST['club_home'];
  if(isset($_POST['team_visitor'])) $page['value_team_visitor']=$_POST['team_visitor'];
  if(isset($_POST['team_home'])) $page['value_team_home']=$_POST['team_home'];
  if(isset($_POST['competition'])) $page['value_competition']=$_POST['competition'];
  if(isset($_POST['round'])) $page['value_round']=$_POST['round'];
  if(isset($_POST['penality_home'])) $page['value_penality_home']=$_POST['penality_home'];
  if(isset($_POST['penality_visitor'])) $page['value_penality_visitor']=$_POST['penality_visitor'];    
  if(isset($_POST['group'])) $page['value_group']=$_POST['group'];
  if(isset($_POST['day'])) $page['value_day']=$_POST['day'];
  if(isset($_POST['field_state'])) $page['value_field_state']=$_POST['field_state'];
  if(isset($_POST['field'])) $page['value_field']=$_POST['field'];
  if(isset($_POST['weather'])) $page['value_weather']=$_POST['weather'];
  if(isset($_POST['date'])) $page['value_date']=$_POST['date'];
  if(isset($_POST['hour'])) $page['value_hour']=$_POST['hour'];
  if(isset($_POST['score_visitor'])) $page['value_score_visitor']=$_POST['score_visitor'];
  if(isset($_POST['score_home'])) $page['value_score_home']=$_POST['score_home'];
  if(isset($_POST['spectators'])) $page['value_spectators']=$_POST['spectators'];
  if(isset($_POST['comment'])) $page['value_comment']=$_POST['comment'];
  
  if(isset($_POST['minute'])) $page['minute']=$_POST['minute'];
  if(isset($_POST['player'])) $page['player']=$_POST['player'];
  if(isset($_POST['player_text'])) $page['player_text']=$_POST['player_text'];
  if(isset($_POST['action'])) $page['action']=$_POST['action'];
  if(isset($_POST['action_text'])) $page['action_text']=$_POST['action_text']; 
  if(isset($_POST['comment_action'])) $page['comment_action']=$_POST['comment_action']; 
 }
}

# if the ID is known, we get the datas to show them in the form
if(isset($page['value_id']) AND $page['value_id']!="" AND $nb_erreur==0)
{
 # we get the item information
 $var['id']=$page['value_id'];
 $sql_details=sql_replace($sql['match']['select_match_details'],$var);

 $sgbd = sql_connect();
 $res = sql_query($sql_details);
 $ligne = sql_fetch_array($res);
 sql_free_result($res);
 sql_close($sgbd);

 $page['value_id']=$ligne['match_id'];
 $page['value_club_visitor']=$ligne['club_visitor_id'];
 $page['value_club_home']=$ligne['club_home_id'];
 $page['value_team_visitor']=$ligne['team_visitor_id'];
 $page['value_team_home']=$ligne['team_home_id'];
 $page['value_competition']=$ligne['competition_id'];
 $page['value_round']=$ligne['round_id'];
 $page['value_penality_home']=$ligne['match_penality_home'];
 $page['value_penality_visitor']=$ligne['match_penality_visitor'];
 $page['value_group']=$ligne['match_group'];  
 $page['value_day']=$ligne['match_day'];
 $page['value_field_state']=$ligne['field_state_id'];
 $page['value_field']=$ligne['field_id'];
 $page['value_weather']=$ligne['weather_id'];
 $page['value_date']=convert_date($ligne['match_date'],$lang['match']['format_date_form']);
 $page['value_hour']=convert_date($ligne['match_date'],$lang['match']['format_hour_form']);
 if($page['value_hour']=="00:00") $page['value_hour']="";
 $page['value_score_visitor']=$ligne['match_score_visitor'];
 $page['value_score_home']=$ligne['match_score_home'];
 $page['value_spectators']=$ligne['match_spectators'];
 $page['value_comment']=$ligne['match_comment'];
}

# On determine la season dans laquelle se joue le match
$var['date']=convert_date_sql($page['value_date']);
include_once(create_path("competition/sql_competition.php"));
$sql_season=sql_replace($sql['competition']['select_season_date'],$var);
$sgbd = sql_connect();
$res_season = sql_query($sql_season);
$ligne_season = sql_fetch_array($res_season);
sql_free_result($res_season);
sql_close($sgbd);
$page['value_season']=$ligne_season['season_id'];

# liste des clubs
include_once(create_path("club/sql_club.php"));
include_once(create_path("club/lg_club_".LANG.".php"));
include_once(create_path("club/tpl_club.php"));
$var['condition']="";
$var['order']="";
$var['limit']="";
$var['value_club']=$page['value_club_home'];
$included=1;
include(create_path("club/club_list.php"));
unset($included);
$page['club_home']=$page['club'];

$var['value_club']=$page['value_club_visitor'];
$included=1;
include(create_path("club/club_list.php"));
unset($included);
$page['club_visitor']=$page['club'];

# liste des teams
$page['link_select_team_club']=convert_url("index.php?r=".$lang['general']['idurl_team']."&v1=select_team_club");

$page['team_home']=array();
$page['team_visitor']=array();
if(!empty($page['value_team_home']) OR !empty($page['value_team_visitor']))
{
include_once(create_path("team/sql_team.php"));
include_once(create_path("team/lg_team_".LANG.".php"));
include_once(create_path("team/tpl_team.php"));
$var['order']="";
$var['limit']="";

# home
if(!empty($page['value_team_home'])){
$var['condition']=" WHERE e.club_id='".$page['value_club_home']."'";
$var['value_team']=$page['value_team_home'];
$included=1;
include(create_path("team/team_list.php"));
unset($included);
$page['team_home']=$page['team'];
}

# visitor
if(!empty($page['value_team_visitor'])) {
$var['condition']=" WHERE e.club_id='".$page['value_club_visitor']."'";
$var['value_team']=$page['value_team_visitor'];
$included=1;
include(create_path("team/team_list.php"));
unset($included);
$page['team_visitor']=$page['team'];
}

}


# liste des players
$page['link_select_player']=convert_url("index.php?r=".$lang['general']['idurl_member']."&v1=select_member");


# liste des referees du match
$page['match_referee']=array();
$page['nb_referee']="0";
if($nb_erreur==0) {
$var['match']=$page['value_id'];
$sql_match_referee=sql_replace($sql['match']['select_match_referee'],$var);
$sgbd = sql_connect();
$res_match_referee = sql_query($sql_match_referee);
$nb_ligne=sql_num_rows($res_match_referee);
$i="0";
if($nb_ligne!="0")
{
 while($ligne = sql_fetch_array($res_match_referee))
 {
  $page['match_referee'][$i]['i']=$i;
  $page['match_referee'][$i]['referee_id']=$ligne['member_id'];
  $page['match_referee'][$i]['referee_text']=$ligne['member_firstname']." ".$ligne['member_lastname'];
  $page['match_referee'][$i]['L_delete']=$lang['match']['delete'];
  $i++;
 }
}
$page['nb_referee']=$i;
sql_free_result($res_match_referee);
sql_close($sgbd);
}

# liste des referees envoyes via le formulaire
if(isset($_POST['referee']) AND !empty($_POST['referee']))
{
 $tab=array_keys($_POST['referee']); 
 $i=0;
 foreach($tab as $key => $value)
 {
  $page['match_referee'][$i]['i']=$i;
  $page['match_referee'][$i]['referee_id']=$_POST['referee'][$value];
  $page['match_referee'][$i]['referee_text']=$_POST['referee_text'][$value];
  $page['match_referee'][$i]['L_delete']=$lang['match']['delete'];    
  $i++;
 }
 $page['nb_referee']=$i;
}

$page['L_referee']=$lang['match']['referee'];
$page['L_match_referee']=$lang['match']['match_referee'];
$page['L_choose_referee']=$lang['match']['choose_referee'];
$page['L_erreur_referee']=$lang['match']['E_empty_match_referee'];

# liste des referees
// on recupere d'abord la liste des referees deja presents pour ne pas les mettre dans cette liste
$referee=array();
for($i=0; $i < $page['nb_referee']; $i++) {
 $referee[]=$page['match_referee'][$i]['referee_id'];
}

if(sizeof($referee) > 0) { $referee="'".implode("','",$referee)."'"; }
else $referee="";

$page['referee']=array();
$page['link_select_referee']=convert_url("index.php?r=".$lang['general']['idurl_member']."&v1=select_member");
include_once(create_path("member/sql_member.php"));
include_once(create_path("member/lg_member_".LANG.".php"));
include_once(create_path("member/tpl_member.php"));
$var['condition']="";
$var['order']="";
$var['limit']="";
$var['value_date_start']="";
$var['value_club']="";
$var['value_club2']="";
$var['value_team']="";
$var['value_team2']="";
if($referee!="") { $var['value_member']=$referee; }
$var['value_referee']=1;
$included=1;
include(create_path("member/member_list.php"));
unset($included);
$page['referee']=$page['member'];

# TITULAIRE
$page['nb_max_match_player']=NB_MAX_PLAYER;
$page['nb_max_match_player_choice']=NB_MAX_PLAYER*2;

# liste des players du match 
$page['player_visitor_match_player']=array();
$page['player_visitor_substitute']=array();
$page['player_home_match_player']=array();
$page['player_home_substitute']=array();
$page['nb_match_player_visitor']=0;
$page['nb_substitute_visitor']=0;
$page['nb_match_player_home']=0;
$page['nb_substitute_home']=0;
$visitor_match_player=array();
if($nb_erreur==0) {
$var['match']=$page['value_id'];
$var['season']=$page['value_season'];
$sql_player_match_player=sql_replace($sql['match']['select_match_player'],$var);




$sgbd = sql_connect();
$res_player_match_player = sql_query($sql_player_match_player);
$nb_ligne=sql_num_rows($res_player_match_player);
$i="0";
$ir="0";
$j="0";
$jr="0";

if($nb_ligne!="0")
{
 while($ligne = sql_fetch_array($res_player_match_player))
 {
  // si le player est in a t=0, alors c un match_player sinon c un substitute
  if($ligne['minute_in']==0) {
   // visitor
   if($ligne['club_id']==$page['value_club_visitor'])
   {
    $page['player_visitor_match_player'][$i]['i']=$i;
    $page['player_visitor_match_player'][$i]['id']=$ligne['player_in_id'];
    $page['player_visitor_match_player'][$i]['firstname']=$ligne['player_in_firstname'];
    $page['player_visitor_match_player'][$i]['name']=$ligne['player_in_name'];
    $visitor_match_player[]=$ligne['player_in_id'];
    $i++;
   }
   elseif($ligne['club_id']==$page['value_club_home']) 
   {
    // home
    $page['player_home_match_player'][$ir]['i']=$ir;
    $page['player_home_match_player'][$ir]['id']=$ligne['player_in_id'];
    $page['player_home_match_player'][$ir]['firstname']=$ligne['player_in_firstname'];
    $page['player_home_match_player'][$ir]['name']=$ligne['player_in_name'];
    $home_match_player[]=$ligne['player_in_id'];
    $ir++;   
   }
  }
  else
  {
   if($ligne['club_id']==$page['value_club_visitor']) {
    // visitor
    $page['player_visitor_substitute'][$j]['i']=$j;
    $page['player_visitor_substitute'][$j]['minute']=$ligne['minute_in'];
    $page['player_visitor_substitute'][$j]['player_out']=$ligne['player_out_id'];   
    $page['player_visitor_substitute'][$j]['player_out_text']=$ligne['player_out_firstname']." ".$ligne['player_out_name'];
    $page['player_visitor_substitute'][$j]['player_in']=$ligne['player_in_id'];   
    $page['player_visitor_substitute'][$j]['player_in_text']=$ligne['player_in_firstname']." ".$ligne['player_in_name'];  
    $page['player_visitor_substitute'][$j]['L_delete']=$lang['match']['delete'];
    $j++;
   }
   elseif($ligne['club_id']==$page['value_club_home']) 
   {
    // home
    $page['player_home_substitute'][$jr]['i']=$jr;
    $page['player_home_substitute'][$jr]['minute']=$ligne['minute_in'];
    $page['player_home_substitute'][$jr]['player_out']=$ligne['player_out_id'];   
    $page['player_home_substitute'][$jr]['player_out_text']=$ligne['player_out_firstname']." ".$ligne['player_out_name'];
    $page['player_home_substitute'][$jr]['player_in']=$ligne['player_in_id'];   
    $page['player_home_substitute'][$jr]['player_in_text']=$ligne['player_in_firstname']." ".$ligne['player_in_name'];  
    $page['player_home_substitute'][$jr]['L_delete']=$lang['match']['delete'];
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

}
else
{
 # there was an error while submitting the form, we get the player from $_POST
 if(isset($_POST['player_match_player_visitor']) AND !empty($_POST['player_match_player_visitor']))
 {
  include_once(create_path("member/sql_member.php"));
  include_once(create_path("member/lg_member_".LANG.".php"));
  include_once(create_path("member/tpl_member.php"));
  $var['condition']="";
  $var['order']="";
  $var['limit']="";
  $var['value_club']="";
  $var['value_club2']="";
  $var['value_team']="";
  $var['value_team2']="";
  $var['value_season']="";
  $var['value_date_start']="";
  $var['value_referee']="";
  $var['value_member']="";
  $var['value_member_in']="'".implode("','",$_POST['player_match_player_visitor'])."'";
  $included=1;
  include(create_path("member/member_list.php"));
  unset($included);
  $var['value_member_in']="";
  $page['player_visitor_match_player']=$page['member'];
  $page['nb_match_player_visitor']=sizeof($page['player_visitor_match_player']);
  $i=0;
  for($i=0;$i<$page['nb_match_player_visitor'];$i++)
  {
   $visitor_match_player[]=$page['player_visitor_match_player'][$i]['id'];
   $i++;
  }
 }
 
 if(isset($_POST['player_match_player_home']) AND !empty($_POST['player_match_player_home']))
 {
  include_once(create_path("member/sql_member.php"));
  include_once(create_path("member/lg_member_".LANG.".php"));
  include_once(create_path("member/tpl_member.php"));
  $var['condition']="";
  $var['order']="";
  $var['limit']="";
  $var['value_club']="";
  $var['value_club2']="";
  $var['value_team']="";
  $var['value_team2']="";
  $var['value_season']="";
  $var['value_date_start']="";
  $var['value_referee']="";
  $var['value_member']="";
  $var['value_member_in']="'".implode("','",$_POST['player_match_player_home'])."'";
  $included=1;
  include(create_path("member/member_list.php"));
  unset($included);
  $var['value_member_in']="";
  $page['player_home_match_player']=$page['member'];
  $page['nb_match_player_home']=sizeof($page['player_home_match_player']);
  $i=0;
  for($i=0;$i<$page['nb_match_player_home'];$i++)
  {
   $home_match_player[]=$page['player_home_match_player'][$i]['id'];
   $i++;
  }
 }

 # substitutes visitor
 if(isset($_POST['player_visitor_in']) AND !empty($_POST['player_visitor_in'])) { 
  $tab=array_keys($_POST['player_visitor_in']);
  $j=0;
  foreach($tab AS $key => $value) {
    $page['player_visitor_substitute'][$j]['i']=$j;
    $page['player_visitor_substitute'][$j]['minute']=$_POST['substitute_visitor_minute'][$value];
    $page['player_visitor_substitute'][$j]['player_out']=$_POST['player_visitor_out'][$value];   
    $page['player_visitor_substitute'][$j]['player_out_text']=$_POST['player_visitor_out_text'][$value];
    $page['player_visitor_substitute'][$j]['player_in']=$_POST['player_visitor_in'][$value];   
    $page['player_visitor_substitute'][$j]['player_in_text']=$_POST['player_visitor_in_text'][$value];  
    $page['player_visitor_substitute'][$j]['L_delete']=$lang['match']['delete'];
	$j++;
  } 
  $page['nb_substitute_visitor']=$j;
 }

 # substitutes home
 if(isset($_POST['player_home_in']) AND !empty($_POST['player_home_in'])) { 
  $tab=array_keys($_POST['player_home_in']);
  $j=0;
  foreach($tab AS $key => $value) {
    $page['player_home_substitute'][$j]['i']=$j;
    $page['player_home_substitute'][$j]['minute']=$_POST['substitute_home_minute'][$value];
    $page['player_home_substitute'][$j]['player_out']=$_POST['player_home_out'][$value];   
    $page['player_home_substitute'][$j]['player_out_text']=$_POST['player_home_out_text'][$value];
    $page['player_home_substitute'][$j]['player_in']=$_POST['player_home_in'][$value];   
    $page['player_home_substitute'][$j]['player_in_text']=$_POST['player_home_in_text'][$value];  
    $page['player_home_substitute'][$j]['L_delete']=$lang['match']['delete'];
	$j++;
  }
  $page['nb_substitute_home']=$j; 
 }
 
}

# liste des players disponibles pour team visitor
$page['match_player_visitor']=array();
$page['link_select_match_player']=convert_url("index.php?r=".$lang['general']['idurl_member']."&v1=select_member");
include_once(create_path("member/sql_member.php"));
include_once(create_path("member/lg_member_".LANG.".php"));
include_once(create_path("member/tpl_member.php"));
$var['condition']="";
$var['order']="";
$var['limit']="";
$var['value_club']=$page['value_club_visitor'];
$var['value_club2']="";
$var['value_team']=$page['value_team_visitor'];
$var['value_team2']="";
$var['value_season']=$page['value_season'];
$var['value_date_start']=$page['value_date'];
$var['value_referee']="";
$var['value_member']="";
if(!empty($visitor_match_player)) {
$visitor_match_player="'".implode("','",$visitor_match_player)."'";
$var['value_member']=$visitor_match_player;
}
$included=1;
include(create_path("member/member_list.php"));
unset($included);
$page['match_player_visitor']=$page['member'];

# liste des players disponibles pour team home
$page['match_player_home']=array();
$page['link_select_match_player']=convert_url("index.php?r=".$lang['general']['idurl_member']."&v1=select_member");
include_once(create_path("member/sql_member.php"));
include_once(create_path("member/lg_member_".LANG.".php"));
include_once(create_path("member/tpl_member.php"));
$var['condition']="";
$var['order']="";
$var['limit']="";
$var['value_club']=$page['value_club_home'];
$var['value_club2']="";
$var['value_team']=$page['value_team_home'];
$var['value_team2']="";
$var['value_season']=$page['value_season'];
$var['value_date_start']=$page['value_date'];
$var['value_referee']="";
$var['value_member']="";
if(!empty($home_match_player)) {
$home_match_player="'".implode("','",$home_match_player)."'";
$var['value_member']=$home_match_player;
}
$included=1;
include(create_path("member/member_list.php"));
unset($included);
$page['match_player_home']=$page['member'];


# liste des players substitute visitor
$page['player_visitor_out']=array();
$page['player_visitor_in']=array();
$page['link_select_player_visitor_out']=convert_url("index.php?r=".$lang['general']['idurl_member']."&v1=select_member");
$page['player_visitor_out']=$page['player_visitor_match_player'];
$page['player_visitor_in']=$page['match_player_visitor'];

# liste des players substitute home
$page['player_home_out']=array();
$page['player_home_in']=array();
$page['link_select_player_home_out']=convert_url("index.php?r=".$lang['general']['idurl_member']."&v1=select_member");
$page['player_home_out']=$page['player_home_match_player'];
$page['player_home_in']=$page['match_player_home'];

$page['L_substitute']=$lang['match']['substitute'];
$page['L_player_in']=$lang['match']['player_in'];
$page['L_player_out']=$lang['match']['player_out'];
$page['L_erreur_substitute']=$lang['match']['E_empty_substitute'];
$page['L_add_substitute']=$lang['match']['add'];



# on verrouille certains champs du formulaire : la date ne peut pas etre editiee si des players sont deja choisis
$page['date_disabled']="";
$page['club_visitor_disabled']="";
$page['team_visitor_disabled']="";
$page['player_match_player_visitor_disabled']="";
if($page['nb_match_player_visitor']!=0 || $page['nb_substitute_visitor']!=0) {
 $page['date_disabled']="disabled=\"disabled\"";
 $page['club_visitor_disabled']="disabled=\"disabled\"";
 $page['team_visitor_disabled']="disabled=\"disabled\"";
}
if($page['nb_substitute_visitor']!=0) { $page['player_match_player_visitor_disabled']="disabled=\"disabled\""; }

$page['club_home_disabled']="";
$page['team_home_disabled']="";
$page['player_match_player_home_disabled']="";
if($page['nb_match_player_home']!=0 || $page['nb_match_player_home']!=0) {
 $page['date_disabled']="disabled=\"disabled\"";
 $page['club_home_disabled']="disabled=\"disabled\"";
 $page['team_home_disabled']="disabled=\"disabled\"";
}
if($page['nb_substitute_home']!=0) { $page['player_match_player_home_disabled']="disabled=\"disabled\""; }

// on affiche ou non les compositions des teams
if(isset($page['team_home']) AND !empty($page['team_home'])){ $page['composition_home_display']="block"; } 
else { $page['composition_home_display']="none"; }
if(isset($page['team_visitor']) AND !empty($page['team_visitor'])){ $page['composition_visitor_display']="block"; } 
else { $page['composition_visitor_display']="none"; }

$page['L_match_player']=$lang['match']['match_player'];
$page['L_player_available']=$lang['match']['player_available'];
$page['L_erreur_match_player_visitor']=$lang['match']['E_empty_match_player'];
$page['L_erreur_nb_match_player']=$lang['match']['E_invalid_nb_match_player'];
$page['L_add_match_player']=$lang['match']['add'];

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


# action match
$page['L_action_match']=$lang['match']['action_match'];
$page['L_minute']=$lang['match']['minute'];
$page['L_action']=$lang['match']['action'];
$page['L_player']=$lang['match']['player'];
$page['L_comment']=$lang['match']['comment'];
$page['L_player']=$lang['match']['player'];
$page['L_add']=$lang['match']['add'];
$page['L_delete']=$lang['match']['delete'];
$page['L_choose_action']=$lang['match']['choose_action'];
$page['L_choose_player']=$lang['match']['choose_player'];
$page['L_add_action']=$lang['match']['add'];
$page['L_erreur_action']=$lang['match']['E_empty_action_match'];

$page['nb_action_home']=0;
$page['nb_action_visitor']=0;
$page['action_match_home']=array();
$page['action_match_visitor']=array();
$page['action']=array();

# liste des actions
$sql_action=$sql['match']['select_action'];
$sgbd = sql_connect();
$res_action = sql_query($sql_action);
$nb_ligne=sql_num_rows($res_action);
if($nb_ligne!="0")
{
 $i="0";
 while($ligne = sql_fetch_array($res_action))
 {
  $page['action'][$i]['id']=$ligne['action_id'];
  $page['action'][$i]['name']=$ligne['action_name'];
  $i++;
 }
}
sql_free_result($res_action);
sql_close($sgbd);

# liste des action match existant
if($nb_erreur==0) {
$var['match']=$page['value_id'];
$var['season']=$page['value_season'];
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
   $page['action_match_home'][$i]['L_delete']=$lang['match']['delete'];
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
   $page['action_match_visitor'][$i]['L_delete']=$lang['match']['delete'];
   $j++;  
  }
 
 }
 $page['nb_action_home']=$i;
 $page['nb_action_visitor']=$j;
}
sql_free_result($res_action_match);
sql_close($sgbd);
}

# liste des action match envoyees via le formulaire
/*if(isset($_POST['minute']) AND !empty($_POST['minute']))
{
 $tab=array_keys($_POST['minute']); 
 $i=0;
 foreach($tab as $key => $value)
 {
  $page['action_match'][$i]['i']=$i;
  $page['action_match'][$i]['minute']=$_POST['minute'][$value];
  $page['action_match'][$i]['action']=$_POST['action'][$value];
  $page['action_match'][$i]['action_text']=$_POST['action_text'][$value];
  $page['action_match'][$i]['player']=$_POST['player'][$value];
  $page['action_match'][$i]['player_text']=$_POST['player_text'][$value];
  $page['action_match'][$i]['comment_action']=$_POST['comment_action'][$value];
  $page['action_match'][$i]['L_delete']=$lang['match']['delete'];    
  $i++;
 }
 $page['nb_action']=$i;
}*/



# period
$page['match_period']=array();
$page['match_period_display']="none";
$var['match']=$page['value_id'];

$sgbd = sql_connect();
if(empty($page['value_id'])) { $sql_period=$sql['match']['select_period']; }
else { 
 $sql_period=sql_replace($sql['match']['select_match_period'],$var);
 $res_period = sql_query($sql_period);
 $nb_ligne=sql_num_rows($res_period); 
 if($nb_ligne==0) {
  $sql_period=$sql['match']['select_period'];   
 }
 else {
  $sql_period=sql_replace($sql['match']['select_match_period'],$var);
 }
}

$res_period = sql_query($sql_period);
$nb_ligne=sql_num_rows($res_period);

if($nb_ligne!="0")
{
 $i="0";
 while($ligne = sql_fetch_array($res_period))
 {
   $page['match_period'][$i]['id']=$ligne['period_id'];
   $page['match_period'][$i]['name']=$ligne['period_name'];
   $page['match_period'][$i]['duration']=$ligne['period_length'];
   $page['match_period'][$i]['required']=$ligne['period_required'];      
   $page['match_period'][$i]['score_home']="";
   $page['match_period'][$i]['score_visitor']="";
   
   if(isset($ligne['score_home']) AND $ligne['score_home']=='NULL') $ligne['score_home']="";  
   if(isset($ligne['score_home']) AND $ligne['score_home']!="") { $page['match_period_display']="block"; }
   if(isset($ligne['score_visitor']) AND $ligne['score_visitor']=='NULL') $ligne['score_visitor']="";  
   if(isset($ligne['score_visitor']) AND $ligne['score_visitor']!="") { $page['match_period_display']="block"; }

    if(isset($ligne['score_home'])) $page['match_period'][$i]['score_home']=$ligne['score_home'];
    if(isset($ligne['score_visitor'])) $page['match_period'][$i]['score_visitor']=$ligne['score_visitor'];
     
  $i++;
 }
}
sql_free_result($res_period);
sql_close($sgbd);

$page['L_details_period']=$lang['match']['details_period'];


# liste des match_period envoyes via le formulaire
if(isset($_POST['period']) AND !empty($_POST['period']))
{
$page['match_period']=array();
 $tab=array_keys($_POST['period']); 
 $i="0";
 foreach($tab as $key => $value)
 {  
  $page['match_period'][$i]['id']=$_POST['period'][$value];
  $page['match_period'][$i]['score_home']=$_POST['period_score_home'][$value];
  $page['match_period'][$i]['score_visitor']=$_POST['period_score_visitor'][$value];
  $page['match_period'][$i]['name']=$_POST['period_name'][$value];
  $page['match_period'][$i]['duration']=$_POST['period_length'][$value];
  $page['match_period'][$i]['required']=$_POST['period_required'][$value];    
  $i++;
 }

}


# stats
$page['match_stats']=array();
$page['match_period_display']="none";
$var['match']=$page['value_id'];

$sgbd = sql_connect();
if(empty($page['value_id'])) { $sql_stats=$sql['match']['select_stats']; }
else { 
 $sql_stats=sql_replace($sql['match']['select_match_stats'],$var);
 $res_stats = sql_query($sql_stats);
 $nb_ligne=sql_num_rows($res_stats); 
 if($nb_ligne==0) {
  $sql_stats=$sql['match']['select_stats'];   
 }
 else {
  $sql_stats=sql_replace($sql['match']['select_match_stats'],$var);
 }
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

# if the user added some new stats (in stats table), we need to check if they are registered for the match
if(!empty($stats_id))
{
 $stats_id=implode("','",$stats_id);
 $var['condition']=" WHERE stats_id NOT IN ('".$stats_id."') ";
 $sql_stats=sql_replace($sql['match']['select_stats_condition'],$var);

 $sgbd = sql_connect();
 $res_stats = sql_query($sql_stats);
 $nb_ligne=sql_num_rows($res_stats);
 if($nb_ligne!=0)
 {
   while($ligne = sql_fetch_array($res_stats))
   {
    if($ligne['stats_formula']=="") {
    $page['match_stats'][$i]['id']=$ligne['stats_id'];
    $page['match_stats'][$i]['name']=$ligne['stats_name'];
    $page['match_stats'][$i]['abbreviation']=$ligne['stats_abbreviation'];
    $page['match_stats'][$i]['formula']=$ligne['stats_formula'];
    $page['match_stats'][$i]['value_home']="";
    $page['match_stats'][$i]['value_visitor']="";
	$i++;
	}
   }     
 }
 sql_free_result($res_stats);
 sql_close($sgbd);
} 


# liste des match_stats envoyes via le formulaire
if(isset($_POST['stats']) AND !empty($_POST['stats']))
{
$page['match_stats']=array();
 $tab=array_keys($_POST['stats']); 
 $i="0";
 foreach($tab as $key => $value)
 {  
  $page['match_stats'][$i]['id']=$_POST['stats'][$value];
  $page['match_stats'][$i]['value_home']=$_POST['stats_value_home'][$value];
  $page['match_stats'][$i]['value_visitor']=$_POST['stats_value_visitor'][$value];
  $page['match_stats'][$i]['name']=$_POST['stats_name'][$value];
  $page['match_stats'][$i]['abbreviation']=$_POST['stats_abbreviation'][$value];
  $page['match_stats'][$i]['formula']=$_POST['stats_formula'][$value];    
  $i++;
 }

}



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


# match_stats_player
$page['stats_player_home']=array();
$page['stats_player_visitor']=array();
$var['match']=$page['value_id'];
if(!empty($page['value_id'])) {
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
$nb_player="0";
# home
for($i=0; $i<$nb_player_home; $i++) {
 $player=$page['player_home'][$i]['id'];
 $page['stats_player_home'][$i]['i']=$nb_player;
 $page['stats_player_home'][$i]['id']=$page['player_home'][$i]['id'];
 $page['stats_player_home'][$i]['player']=$page['player_home'][$i]['text'];
 $page['stats_player_home'][$i]['stats_player']=array();
 
 for($j=0; $j<$nb_stats_player; $j++) {
  $stats_player=$stats_player_id[$j];  
  $page['stats_player_home'][$i]['stats_player'][$j]['j']=$j;
  $page['stats_player_home'][$i]['stats_player'][$j]['id']=$stats_player_id[$j];
  $page['stats_player_home'][$i]['stats_player'][$j]['player_id']=$player;
  $page['stats_player_home'][$i]['stats_player'][$j]['value']="";  
  if(isset($match_stats_player[$player][$stats_player])) {
   $page['stats_player_home'][$i]['stats_player'][$j]['value']=$match_stats_player[$player][$stats_player];
  }
 }
 $nb_player++;
}

# visitor
for($i=0; $i<$nb_player_visitor; $i++) {
 $player=$page['player_visitor'][$i]['id'];
 $page['stats_player_visitor'][$i]['i']=$nb_player;
 $page['stats_player_visitor'][$i]['id']=$page['player_visitor'][$i]['id'];
 $page['stats_player_visitor'][$i]['player']=$page['player_visitor'][$i]['text'];
 $page['stats_player_visitor'][$i]['stats_player']=array();
 
 for($j=0; $j<$nb_stats_player; $j++) {
  $stats_player=$stats_player_id[$j];  
  $page['stats_player_visitor'][$i]['stats_player'][$j]['j']=$j;
  $page['stats_player_visitor'][$i]['stats_player'][$j]['id']=$stats_player_id[$j];
  $page['stats_player_visitor'][$i]['stats_player'][$j]['player_id']=$player;
  $page['stats_player_visitor'][$i]['stats_player'][$j]['value']="";  
  if(isset($match_stats_player[$player][$stats_player])) {
   $page['stats_player_visitor'][$i]['stats_player'][$j]['value']=$match_stats_player[$player][$stats_player];
  }
 }
 $nb_player++;
}

# liste des match_stats_player envoyes via le formulaire
if(isset($_POST['player_id']) AND !empty($_POST['player_id']))
{ 
 $page['stats_player_home']=array();
 $page['stats_player_visitor']=array();
 $tab=array_keys($_POST['player_id']); 
 $i="0";
 $k="0";
 $nb_player="0";
 foreach($tab as $key => $value)
 {
  $player_id=$_POST['player_id'][$value];
  if($player_id!="playerid") {
   if(in_array($player_id,$player_home)) {
    $page['stats_player_home'][$i]['i']=$nb_player;
    $page['stats_player_home'][$i]['id']=$player_id;
    $page['stats_player_home'][$i]['player']=$_POST['player_name'][$value];
    $page['stats_player_home'][$i]['stats_player']=array();  
  
    $tab_stats=array_keys($_POST['stats_player'][$player_id]); 

    $j=0;
    foreach($tab_stats as $key => $value)
    {
     if($player_id!="playerid") {
	  $page['stats_player_home'][$i]['stats_player'][$j]['j']=$j;
      $page['stats_player_home'][$i]['stats_player'][$j]['id']=$_POST['stats_player'][$player_id][$key];
      $page['stats_player_home'][$i]['stats_player'][$j]['player_id']=$player_id;
      $page['stats_player_home'][$i]['stats_player'][$j]['value']=$_POST['stats_player_value'][$player_id][$key];   
      $j++;
	 } 
    } 
    $i++;
   }
   else
   {
    $page['stats_player_visitor'][$k]['i']=$nb_player;
    $page['stats_player_visitor'][$k]['id']=$player_id;
    $page['stats_player_visitor'][$k]['player']=$_POST['player_name'][$value];
    $page['stats_player_visitor'][$k]['stats_player']=array();  
  
    $tab_stats=array_keys($_POST['stats_player'][$player_id]); 

    $j=0;
    foreach($tab_stats as $key => $value)
    {
     if($player_id!="playerid") {
	  $page['stats_player_visitor'][$k]['stats_player'][$j]['j']=$j;
      $page['stats_player_visitor'][$k]['stats_player'][$j]['id']=$_POST['stats_player'][$player_id][$key];
      $page['stats_player_visitor'][$k]['stats_player'][$j]['player_id']=$player_id;
      $page['stats_player_visitor'][$k]['stats_player'][$j]['value']=$_POST['stats_player_value'][$player_id][$key];   
      $j++;
	 } 
    } 
    $k++;  
   }
   $nb_player++;
  }
 }
}

$page['stats_player_home_display']="none";
$page['stats_player_visitor_display']="none";
if(sizeof($page['stats_player_home'])>0) $page['stats_player_home_display']="block";
if(sizeof($page['stats_player_visitor'])>0) $page['stats_player_visitor_display']="block";


# competition
$page['competition']=array();
include_once(create_path("competition/sql_competition.php"));
include_once(create_path("competition/lg_competition_".LANG.".php"));
include_once(create_path("competition/tpl_competition.php"));
$var['condition']="";
$var['order']="";
$var['limit']="";
$var['value_competition']=$page['value_competition'];
$included=1;
include(create_path("competition/competition_list.php"));
unset($included);
$page['competition']=$page['competition'];
$page['link_form_competition']=convert_url("index.php?r=".$lang['general']['idurl_competition']."&v1=form_competition&fen=pop",0);
$page['L_add_competition']=$lang['competition']['add_competition'];

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
$included=1;
include(create_path("competition/select_round.php"));
unset($included);
if($page['show_round']==1) { $page['display_round']="block"; }
$page['round']=$page['round'];

$page['L_group']=$lang['competition']['group'];
$page['L_day']=$lang['competition']['day'];
$page['L_penality']=$lang['competition']['penality'];

# round details
$page['group']=array();
$page['day']=array();

if(isset($page['value_round']) AND $page['value_round']!="0")
{
 $var['header']=0;
 $var['id']=$page['value_round'];
 $var['day']=$page['value_day'];
 $var['group']=$page['value_group'];
 include(create_path("competition/select_round_details.php")); 
}


# field
$page['field']=array();
include_once(create_path("field/sql_field.php"));
include_once(create_path("field/lg_field_".LANG.".php"));
include_once(create_path("field/tpl_field.php"));
$var['condition']="";
$var['order']="";
$var['limit']="";
$var['value_field']=$page['value_field'];
$included=1;
include(create_path("field/field_list.php"));
unset($included);
$page['field']=$page['field'];
$page['link_form_field']=convert_url("index.php?r=".$lang['general']['idurl_field']."&v1=form_field&fen=pop",0);
$page['L_add_field']=$lang['field']['add_field'];


# weather
$page['weather']=array();
$sql_weather=$sql['match']['select_weather'];
$sgbd = sql_connect();
$res_weather = sql_query($sql_weather);
$nb_ligne=sql_num_rows($res_weather);
if($nb_ligne!="0")
{
 $i="0";
 while($ligne = sql_fetch_array($res_weather))
 {
  $page['weather'][$i]['id']=$ligne['weather_id'];
  $page['weather'][$i]['name']=$ligne['weather_name'];

  if($page['value_weather']==$ligne['weather_id']) { $page['weather'][$i]['selected']="selected"; } 
  else { $page['weather'][$i]['selected']=""; }
  $i++;
 }
}
sql_free_result($res_weather);
sql_close($sgbd);

# field_state
$page['field_state']=array();
$sql_field_state=$sql['match']['select_field_state'];
$sgbd = sql_connect();
$res_field_state = sql_query($sql_field_state);
$nb_ligne=sql_num_rows($res_field_state);
if($nb_ligne!="0")
{
 $i="0";
 while($ligne = sql_fetch_array($res_field_state))
 {
  $page['field_state'][$i]['id']=$ligne['field_state_id'];
  $page['field_state'][$i]['name']=$ligne['field_state_name'];

  if($page['value_field_state']==$ligne['field_state_id']) { $page['field_state'][$i]['selected']="selected"; } 
  else { $page['field_state'][$i]['selected']=""; }
  $i++;
 }
}
sql_free_result($res_field_state);
sql_close($sgbd);


# links
if($right_user['delete_match'] AND !empty($page['value_id']))
{
 $page['link_delete']=convert_url("index.php?r=".$lang['general']['idurl_match']."&v1=match_list&v2=delete&v3=".$page['value_id']);
}
else
{
 $page['link_delete']="";
}
$page['link_list']=convert_url("index.php?r=".$lang['general']['idurl_match']."&v1=match_list");

$page['form_action']=convert_url("index.php?r=".$lang['general']['idurl_match']."&v1=form_match");


# text
if(empty($page['value_id'])) { $page['L_title']=$lang['match']['form_match_add']; }
else { $page['L_title']=$lang['match']['form_match_edit']; }

$page['L_valider']=$lang['match']['submit'];
$page['L_delete']=$lang['match']['delete'];
$page['L_back_list']=$lang['match']['back_list'];

$page['L_erreur']=$lang['general']['E_erreur'];
$page['L_field_required']=$lang['general']['field_required'];

$page['L_details']=$lang['match']['details'];
$page['L_home']=$lang['match']['home'];
$page['L_visitor']=$lang['match']['visitor'];
$page['L_competition']=$lang['match']['competition'];
$page['L_field_state']=$lang['match']['field_state'];
$page['L_field']=$lang['match']['field'];
$page['L_weather']=$lang['match']['weather'];
$page['L_date']=$lang['match']['date'];
$page['L_hour']=$lang['match']['hour'];
$page['L_score']=$lang['match']['score'];
$page['L_spectators']=$lang['match']['spectators'];
$page['L_comment']=$lang['match']['comment'];

$page['L_format_date']=$lang['match']['format_date'];
$page['L_format_hour']=$lang['match']['format_hour'];
$page['L_choose_competition']=$lang['match']['choose_competition'];
$page['L_choose_field_state']=$lang['match']['choose_field_state'];
$page['L_choose_field']=$lang['match']['choose_field'];
$page['L_choose_weather']=$lang['match']['choose_weather'];

$page['L_choose_club_home']=$lang['match']['choose_club'];
$page['L_choose_club_visitor']=$lang['match']['choose_club'];
$page['L_choose_team_home']=$lang['match']['choose_team'];
$page['L_choose_team_visitor']=$lang['match']['choose_team'];

$page['L_composition_team']=$lang['match']['composition_team'];

$page['L_stats']=$lang['match']['stats'];
$page['L_stats_player']=$lang['match']['stats_player'];

$page['meta_title']=$page['L_title'];
$page['template']=$tpl['match']['form_match'];
?>
