<?php
# view team
$page['L_message']="";

if($right_user['view_team']) {
	$page['show_view']=1; 
}
else {
	$page['show_view']='';
	$page['L_message']=$lang['general']['acces_reserve_admin'];
}

# we get the ID
$page['id']=$_GET['v2'];

# on recupere les infos sur team
if(isset($page['id']) AND $page['id']!="")
{
 $var['condition']=" WHERE e.team_id='".$page['id']."' ";
 $var['order']="";
 $var['limit']="";
 $sql_details=sql_replace($sql['team']['select_team_condition'],$var);

 $sgbd = sql_connect();
 $res = sql_query($sql_details);
 $ligne = sql_fetch_array($res);
 sql_free_result($res);
 sql_close($sgbd);

 $page['id']=$ligne['team_id'];
 $page['team_name']=$ligne['team_name_name'];
 $page['club']=$ligne['club_name'];
 $page['sex']=$ligne['sex_id'];
 
 $page['link_club']=convert_url("index.php?r=".$lang['general']['idurl_club']."&v1=view&v2=".$ligne['club_id']); 
 $page['link_match']=convert_url("index.php?r=".$lang['general']['idurl_match']."&v1=match_list&v2=team_".$ligne['club_id']."_".$ligne['team_id']); 

 # sex
 if(!empty($ligne['sex_id']))
 {
  $var['id']=$page['sex'];
  $sql_sex=sql_replace($sql['member']['select_sex_details'],$var);
  $sgbd = sql_connect();
  $res = sql_query($sql_sex);
  $ligne = sql_fetch_array($res); 
  $page['sex']=$ligne['sex_name'];
  $page['sex_abbreviation']=$ligne['sex_abbreviation']; 
  sql_free_result($res);
 }
 else { $page['sex']=""; } 
 
}
else
{
 $page['L_message']=$lang['team']['E_erreur_presence_team'];
}


# liste des seasons
$page['season_defaut']="";
$page['season']=array();
include_once(create_path("competition/sql_competition.php"));
include_once(create_path("competition/lg_competition_".LANG.".php"));
include_once(create_path("competition/tpl_competition.php"));
$sql_liste=$sql['competition']['select_season'];
$sgbd = sql_connect();
$res_liste = sql_query($sql_liste);
$nb_ligne_s = sql_num_rows($res_liste);
$is="0";
$page['nb_coach']=0;
$page['nb_player']=0;
$page['nb_photo']=0;
while($ligne = sql_fetch_array($res_liste))
{  
 
 # team_photo 
 $var['condition']=" WHERE team_id='".$page['id']."' AND season_id='".$ligne['season_id']."'";
 $sql_team_photo=sql_replace($sql['team']['select_team_photo'],$var);  
 $sgbd = sql_connect();
 $res_team_photo = sql_query($sql_team_photo);
 $nb_ligne_photo=sql_num_rows($res_team_photo); 
 if($nb_ligne_photo!=0) {
  	$ligne_photo = sql_fetch_array($res_team_photo); 
	$page['season'][$is]['L_photo']=$lang['team']['photo'];
	$page['season'][$is]['L_photo_description']=$lang['team']['photo_description'];
	$page['season'][$is]['photo']=$ligne_photo['photo'];
	$page['season'][$is]['photo_description']=$ligne_photo['description']; 
 	$page['nb_photo']++;
  }
  else {
	$page['season'][$is]['photo']='';
	$page['season'][$is]['photo_description']='';   
  }
 
 # team coach for the season
//  $page['season'][$is]['team_coach']=array();
  $var['condition']=" WHERE ee.team_id='".$page['id']."' AND ee.season_id='".$ligne['season_id']."'";
  $var['order']=" ORDER BY m.member_lastname ASC";
  $var['limit']="";
  $sql_team_coach=sql_replace($sql['team']['select_team_coach'],$var);
  
  $sgbd = sql_connect();
  $res_team_coach = sql_query($sql_team_coach);
  $nb_ligne_ee=sql_num_rows($res_team_coach);
  if($nb_ligne_ee!="0")
  {
  	 $j="0";
	 while($ligne_ee = sql_fetch_array($res_team_coach))
	 {
	  $page['season'][$is]['team_coach'][$j]['i']=$page['nb_coach'];
	  $page['season'][$is]['team_coach'][$j]['season']=$is;
	  $page['season'][$is]['team_coach'][$j]['coach']=$ligne_ee['member_id'];
	  $page['season'][$is]['team_coach'][$j]['coach_text']=$ligne_ee['member_firstname']." ".$ligne_ee['member_lastname'];
	  $page['season'][$is]['team_coach'][$j]['season_coach']=$ligne_ee['season_id'];
	  $page['season'][$is]['team_coach'][$j]['link_view']=convert_url("index.php?r=".$lang['general']['idurl_member']."&v1=view&v2=".$ligne_ee['member_id']);

	  $j++;
	  $page['nb_coach']++;
	 }
  }
  else
	{
	// $page['season'][$is]['team_coach']=array();	
	}  
  sql_free_result($res_team_coach);
    
 // players de l'team pour la season
	$var['condition']=" WHERE ej.team_id='".$page['id']."' AND ej.season_id='".$ligne['season_id']."'";
	$var['order']=" ORDER BY ej.player_number ASC";
	$var['limit']="";
	$sql_team_player=sql_replace($sql['team']['select_team_player'],$var);

	$sgbd = sql_connect();
	$res_team_player = sql_query($sql_team_player);
	$nb_ligne_ej=sql_num_rows($res_team_player);
	if($nb_ligne_ej!="0")
	{
	 $ij="0";
	 while($ligne_ej = sql_fetch_array($res_team_player))
	 {
	  $page['season'][$is]['team_player'][$ij]['i']=$page['nb_player'];
	  $page['season'][$is]['team_player'][$ij]['season']=$is;
	  $page['season'][$is]['team_player'][$ij]['player']=$ligne_ej['member_id'];
	  $page['season'][$is]['team_player'][$ij]['player_text']=$ligne_ej['member_firstname']." ".$ligne_ej['member_lastname'];
	  $page['season'][$is]['team_player'][$ij]['number_player']=$ligne_ej['player_number'];
	  $page['season'][$is]['team_player'][$ij]['position']=$ligne_ej['position_id'];
	  $page['season'][$is]['team_player'][$ij]['position_text']=$ligne_ej['position_name'];  
	  
      if($ligne_ej['player_captain']==0) { $page['season'][$is]['team_player'][$ij]['captain_player']=""; }
      else { $page['season'][$is]['team_player'][$ij]['captain_player']=$lang['team']['yes']; }
  	  
	  $page['season'][$is]['team_player'][$ij]['season_player']=$ligne_ej['season_id'];
	  $page['season'][$is]['team_player'][$ij]['link_view']=convert_url("index.php?r=".$lang['general']['idurl_member']."&v1=view&v2=".$ligne_ej['member_id']);
	  $page['season'][$is]['team_player'][$ij]['mod']=$ij%2;
	  $ij++;
	  $page['nb_player']++;
	 }
	}	
	else 
	{
	 //$page['season'][$is]['team_player']=array();	
	}
	sql_free_result($res_team_player);

 // s'il y a au moins un player ou un coach ou une photo, on affiche la season

 if($nb_ligne_ej!=0 OR $nb_ligne_ee!=0 OR $nb_ligne_photo!=0) {
	 $page['season'][$is]['i']=$is;
	 $page['season'][$is]['id']=$ligne['season_id'];
	 $page['season'][$is]['name']=$ligne['season_name'];
	 $page['season'][$is]['abbreviation']=$ligne['season_abbreviation'];
	 $page['season'][$is]['class']="";
	  
	 $page['season'][$is]['L_team_coach']=$lang['team']['team_coach'];
	 $page['season'][$is]['L_team_player']=$lang['team']['team_player'];
	 $page['season'][$is]['L_player']=$lang['team']['player'];
	 $page['season'][$is]['L_number']=$lang['team']['number'];
	 $page['season'][$is]['L_position']=$lang['team']['position'];
	 $page['season'][$is]['L_captain']=$lang['team']['captain'];
	
     if(($ligne['season_date_start']<=date("Y-m-d") AND $ligne['season_date_end']>date("Y-m-d")) OR ($page['season_defaut']=="" AND ($is+1)==$nb_ligne_s) ) { 
	 	$page['season'][$is]['display']="block";
		$page['season'][$is]['class']="on";
	 	$page['season_defaut']=$is; 
	 }
	 else { 
	 	$page['season'][$is]['display']="none";
	 } 
	 
	 if($nb_ligne_ee==0) $page['season'][$is]['team_coach']=array();
	 if($nb_ligne_ej==0) $page['season'][$is]['team_player']=array();	 
	 $is++;	 
 }

}
sql_free_result($res_liste);
sql_close($sgbd);

$page['nb_season']=$is;
$page['L_season']=$lang['competition']['season'];
$page['L_choose_season']=$lang['competition']['choose_season'];
$page['L_composition_team']=$lang['team']['composition_team'];

$page['aff_composition']="";
if($page['nb_player']!=0 OR $page['nb_coach']!=0 OR $page['nb_photo']!=0) {
$page['aff_composition']="1";
}
else { $page['season']=array(); }


# stats
## TO DO


# modification
$page['link_edit']="";
$page['link_delete']="";
if($right_user['edit_team']) {
 $page['link_edit']=convert_url("index.php?r=".$lang['general']['idurl_team']."&v1=form_team&v2=".$page['id']);
}
if($right_user['edit_team']) {
 $page['link_delete']=convert_url("index.php?r=".$lang['general']['idurl_team']."&v1=team_list&v2=delete&v3=".$page['id']);
}


# text
$page['L_title']=$page['club']." ".$page['team_name'];
$page['L_team']=$lang['team']['team'];
$page['L_team_name']=$lang['team']['team_name'];
$page['L_club']=$lang['team']['club'];
$page['L_sex']=$lang['team']['sex'];
$page['L_details']=$lang['team']['details'];
$page['L_view_match']=$lang['team']['view_match'];
$page['L_view_stats']=$lang['team']['view_stats'];

$page['L_edit']=$lang['team']['edit'];
$page['L_delete']=$lang['team']['delete'];


# meta
$page['meta_title']=$page['club']." ".$page['team_name'];

$page['template']=$tpl['team']['view_team'];
?>