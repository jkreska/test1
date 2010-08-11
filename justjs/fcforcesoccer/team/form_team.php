<?php
##################################
# team 
##################################
include_once(create_path("member/sql_member.php"));

# variables
$page['L_message_team']="";
$nb_erreur="0";
$page['erreur']=array();

# form values
$page['value_id']="";
$page['value_team_name']="";
$page['value_club']="";
$page['value_sex']="";

# element du formulaire
$page['team_name']=array();
$page['club']=array();

# si l'identifiant du team est passe dans l'url (modification), on le recupere
if(isset($_GET['v2']) AND $_GET['v2']!="") { $page['value_id']=$_GET['v2']; }
elseif(isset($_POST['id']) AND $_POST['id']!="") { $page['value_id']=$_POST['id']; }

# mode club
$page['aff_club']="1";
if(CLUB!=0)
{
$page['value_club']=CLUB;
$page['aff_club']="";
}


if($right_user['add_team'] OR $right_user['edit_team']) {
	$page['show_form']=1; 
}
else {
	$page['show_form']='';
	$page['L_message_team']=$lang['general']['acces_reserve_admin'];
}

# case of add or edit
if(isset($_POST) AND !empty($_POST))
{
 # we format datas
 if(CLUB!=0) { $_POST['club']=CLUB; }

 # we check datas
 if(!isset($_POST['team_name']) OR $_POST['team_name']=="") { $page['erreur'][$nb_erreur]['message']=$lang['team']['E_empty_team_name']; $nb_erreur++; }
 if(!isset($_POST['club']) OR $_POST['club']=="") { $page['erreur'][$nb_erreur]['message']=$lang['team']['E_empty_club']; $nb_erreur++; }
  
 if(isset($_POST['team_name']) AND !empty($_POST['team_name']) AND isset($_POST['club']) AND !empty($_POST['club']))
 {
  /* on verifie que l'team n'est pas deja presente */
   $sgbd = sql_connect();
   $sql_verif = sql_replace($sql['team']['verif_presence_team'],$_POST);
   $res_verif = sql_query($sql_verif);
   $nb_res = sql_num_rows($res_verif);
   sql_free_result($res_verif);
   sql_close($sgbd);
   if($nb_res!="0") { $page['erreur'][$nb_erreur]['message']=$lang['team']['E_exist_team']; $nb_erreur++; }
 }
 
 # there is no error in submited datas
 if($nb_erreur==0)
 {
  if(!isset($_POST['sex']) OR empty($_POST['sex'])) $_POST['sex']="";
  
  # case : new item to add
  if(!isset($_POST['id']) OR empty($_POST['id']) AND $right_user['add_team'])
  {
   $sql_add=sql_replace($sql['team']['insert_team'],$_POST);
   $sgbd = sql_connect();
   $execution=sql_query($sql_add);
   $page['value_id']=sql_insert_id($sgbd);
   
   if($execution != false) { $page['L_message_team']=$lang['team']['form_team_add_1']; }
   else { $page['L_message_team']=$lang['team']['form_team_add_0']; }
   
   sql_close($sgbd);
   
   
   # team_coach 
   if($execution AND isset($_POST['coach']) AND !empty($_POST['coach']))
   {
    $values=array();  
    $tab_coach=array_keys($_POST['coach']); 
    foreach($tab_coach as $key => $value)
 	{
	 $values[]="('".$page['value_id']."','".$_POST['coach'][$value]."','".$_POST['season_coach'][$value]."')";
	}	
	$var['values']=implode(", ",$values);
	$sql_add=sql_replace($sql['team']['insert_team_coach'],$var);	
	$sgbd = sql_connect();
	sql_query($sql_add);
	sql_close($sgbd);	
   }
   
   # team_player 
    if($execution AND isset($_POST['player']) AND !empty($_POST['player']))
    {  
     $tab_player=array_keys($_POST['player']); 
	 $values=array();
     foreach($tab_player as $key => $value)
     {	
	 $values[]="('".$page['value_id']."','".$_POST['position'][$value]."','".$_POST['player'][$value]."','".$_POST['season_player'][$value]."','".$_POST['number_player'][$value]."','".$_POST['captain_player'][$value]."')";
	 }	
	 $var['values']=implode(", ",$values);
	 $sql_add=sql_replace($sql['team']['insert_team_player'],$var);
	 $sgbd = sql_connect();
	 sql_query($sql_add);
	 sql_close($sgbd);	
    }
	
	# team_photo  
   	if($execution AND isset($_POST['photo']) AND !empty($_POST['photo']))
	{
		$values=array();  
		$tab_photo=array_keys($_POST['photo']); 
		foreach($tab_photo as $key => $value)
		{
		 if(!empty($_POST['photo'][$value]) OR !empty($_POST['photo_description'][$value])) {
		 	$values[]="('".$page['value_id']."', '".$_POST['season'][$value]."', '".$_POST['photo'][$value]."', '".format_txt($_POST['photo_description'][$value])."')";
		 }
		}	
		$var['values']=implode(", ",$values);
		$sql_add=sql_replace($sql['team']['insert_team_photo'],$var);	
		$sgbd = sql_connect();
		sql_query($sql_add);
		sql_close($sgbd);
	}
   
  }
  # case : item to modify
  elseif($right_user['edit_team'])
  {
   $sql_modification=sql_replace($sql['team']['edit_team'],$_POST);
   $sgbd = sql_connect();
   $execution=sql_query($sql_modification);
   if($execution != false) { $page['L_message_team']=$lang['team']['form_team_edit_1']; }
   else { $page['L_message_team']=$lang['team']['form_team_edit_0']; }
   sql_close($sgbd);
   
   # team_coach 
   if($execution)
   { 
    # on supprime tous les elements
	$var['team']=$page['value_id'];
	$sql_sup_coach=sql_replace($sql['team']['sup_team_coach'],$var);
	$sql_sup_player=sql_replace($sql['team']['sup_team_player'],$var);
	$sql_sup_photo=sql_replace($sql['team']['sup_team_photo'],$var);	 
	$sgbd = sql_connect();
	sql_query($sql_sup_coach);
	sql_query($sql_sup_player);
	sql_query($sql_sup_photo);
	sql_close($sgbd);
		 	
	# si il a de nouveaux elements, on les added
    if(isset($_POST['coach']) AND !empty($_POST['coach']))
    { 
     $tab_coach=array_keys($_POST['coach']); 
	 $values=array();
     foreach($tab_coach as $key => $value)
  	 {
	  $values[]="('".$page['value_id']."','".$_POST['coach'][$value]."','".$_POST['season_coach'][$value]."')";
	 }	
	 $var['values']=implode(", ",$values);
	 $sql_add=sql_replace($sql['team']['insert_team_coach'],$var);
	 
	 $sgbd = sql_connect();
	 sql_query($sql_add);
	 sql_close($sgbd);	
    }
   
   # team_player 
    if(isset($_POST['player']) AND !empty($_POST['player']))
    {  
     $tab_player=array_keys($_POST['player']); 
	 $values=array();
     foreach($tab_player as $key => $value)
     {	
	 $values[]="('".$page['value_id']."','".$_POST['position'][$value]."','".$_POST['player'][$value]."','".$_POST['season_player'][$value]."','".$_POST['number_player'][$value]."','".$_POST['captain_player'][$value]."')";
	 }	
	 $var['values']=implode(", ",$values);
	 $sql_add=sql_replace($sql['team']['insert_team_player'],$var);
	 $sgbd = sql_connect();
	 sql_query($sql_add);
	 sql_close($sgbd);	
    }
	
	# team_photo  
   	if($execution AND isset($_POST['photo']) AND !empty($_POST['photo']))
	{
		$values=array();  
		$tab_photo=array_keys($_POST['photo']); 
		foreach($tab_photo as $key => $value)
		{
		 if(!empty($_POST['photo'][$value]) OR !empty($_POST['photo_description'][$value])) {
		 	$values[]="('".$page['value_id']."', '".$_POST['season'][$value]."', '".$_POST['photo'][$value]."', '".format_txt($_POST['photo_description'][$value])."')";
		 }
		}	
		$var['values']=implode(", ",$values);
		$sql_add=sql_replace($sql['team']['insert_team_photo'],$var);				
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
  if(isset($_POST['team_name'])) $page['value_team_name']=$_POST['team_name'];
  if(isset($_POST['club'])) $page['value_club']=$_POST['club'];
  if(isset($_POST['sex'])) $page['value_sex']=$_POST['sex'];
  
  if(isset($_POST['coach'])) $page['coach']=$_POST['coach'];
  if(isset($_POST['coach_text'])) $page['coach_text']=$_POST['coach_text'];
  
  if(isset($_POST['player'])) $page['player']=$_POST['player'];
  if(isset($_POST['player_text'])) $page['player_text']=$_POST['player_text'];
  if(isset($_POST['number_player'])) $page['number_player']=$_POST['number_player'];  
  if(isset($_POST['position'])) $page['position']=$_POST['position'];
  if(isset($_POST['position_text'])) $page['position_text']=$_POST['position_text'];
  if(isset($_POST['captain_player'])) $page['captain_player']=$_POST['captain_player'];
 }
}

# if the ID is known, we get the datas to show them in the form
if(isset($page['value_id']) AND $page['value_id']!="" AND $nb_erreur==0)
{
 # on recupere les infos sur l'team
 $var['id']=$page['value_id'];
 $sql_details=sql_replace($sql['team']['select_team_details'],$var);

 $sgbd = sql_connect();
 $res = sql_query($sql_details);
 $ligne = sql_fetch_array($res);
 sql_free_result($res);
 sql_close($sgbd);

 $page['value_id']=$ligne['team_id'];
 $page['value_team_name']=$ligne['team_name_id'];
 $page['value_club']=$ligne['club_id'];
 $page['value_sex']=$ligne['sex_id'];
 
}

# elements du formulaire
# liste des team_name
$sql_liste=$sql['team']['select_team_name'];
$sgbd = sql_connect();
$res_liste = sql_query($sql_liste);
$i="0";
while($ligne = sql_fetch_array($res_liste))
{
 $page['team_name'][$i]['id']=$ligne['team_name_id'];
 $page['team_name'][$i]['name']=$ligne['team_name_name'];

 if(isset($page['value_team_name']) AND $page['value_team_name']==$ligne['team_name_id'])
 { $page['team_name'][$i]['selected']="selected"; }
 else { $page['team_name'][$i]['selected']=""; }
 $i++;
}
sql_free_result($res_liste);
sql_close($sgbd);
$page['link_team_name_list']=convert_url("index.php?r=".$lang['general']['idurl_team']."&v1=team_name_list&fen=pop",0);
$page['L_add_team_name']=$lang['team']['add_team_name'];

# liste des clubs
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
$page['link_form_club']=convert_url("index.php?r=".$lang['general']['idurl_club']."&v1=form_club&fen=pop",0);
$page['L_add_club']=$lang['club']['add_club'];
}


# liste des seasons
$page['aff_season']="";
$page['season_defaut']="";
$page['season_id_defaut']="";
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
if($nb_ligne_s!=0)
{
 $page['aff_season']="1";
 while($ligne = sql_fetch_array($res_liste))
 {
  $page['season'][$is]['i']=$is;
  $page['season'][$is]['id']=$ligne['season_id'];
  $page['season'][$is]['name']=$ligne['season_name'];
  $page['season'][$is]['abbreviation']=$ligne['season_abbreviation'];
  $page['season'][$is]['class']="";
  
  $page['season'][$is]['L_team_coach']=$lang['team']['team_coach'];
  $page['season'][$is]['L_team_player']=$lang['team']['team_player'];
  
 // Choix de la season par defaut
 if(($ligne['season_date_start']<=date("Y-m-d") AND $ligne['season_date_end']>date("Y-m-d")) OR ($page['season_defaut']=="" AND ($is+1)==$nb_ligne_s) ) {
  // si une season correspond a la date du day, alors on la choisit par defaut
  // ou si c'est la derniere season et qu'il n'y a pas de season par defaut, alors on la choisit pour eviter un vide
  $page['season_id_defaut']=$ligne['season_id']; 
  $page['season_defaut']=$is;
  $page['season'][$is]['display']="block";
  $page['season'][$is]['class']="on";
 }
 else
  { $page['season'][$is]['display']="none"; }
  
  
 # team_photo
 $page['season'][$is]['photo']="";
 $page['season'][$is]['photo_description']=""; 
 $page['season'][$is]['L_photo']=$lang['team']['photo'];
 $page['season'][$is]['L_photo_description']=$lang['team']['photo_description'];
 $page['season'][$is]['link_choose_image']=convert_url("index.php?r=".$lang['general']['idurl_file']."&v1=image_manager&parent_form=form_team&field_name=photo[".$is."]&file_type=image&fen=pop",0);
 $page['season'][$is]['L_choose_image']=$lang['team']['choose_image'];
 $page['season'][$is]['display_photo']='none';
 
 if($nb_erreur==0) { 
  $var['condition']=" WHERE team_id='".$page['value_id']."' AND season_id='".$ligne['season_id']."'";
  $sql_team_photo=sql_replace($sql['team']['select_team_photo'],$var);
  $sgbd = sql_connect();
  $res_team_photo = sql_query($sql_team_photo);
  $nb_ligne_photo=sql_num_rows($res_team_photo);
  if($nb_ligne_photo!=0) {
  	$ligne_photo = sql_fetch_array($res_team_photo);
	$page['season'][$is]['photo']=$ligne_photo['photo'];
	$page['season'][$is]['photo_description']=$ligne_photo['description'];
	$page['season'][$is]['display_photo']='block';
  }  
 }
 else {
  	if(isset($_POST['photo'][$is])) { 
		$page['season'][$is]['photo']=$_POST['photo'][$is];
		$page['season'][$is]['display_photo']='block';
	}
	if(isset($_POST['photo_description'][$is])) { $page['season'][$is]['photo_description']=$_POST['photo_description'][$is]; }
	
 }
    
  
 # team coach for the season
 $page['season'][$is]['team_coach']=array();
 
 if($nb_erreur==0) {
  $var['condition']=" WHERE ee.team_id='".$page['value_id']."' AND ee.season_id='".$ligne['season_id']."'";
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
	  if($page['season'][$is]['id']==$page['season_id_defaut']) {
	  	 // we stock coach_id of the season to display
		 $team_coach[]=$ligne_ee['member_id'];
	  }	 
	  $page['season'][$is]['team_coach'][$j]['i']=$page['nb_coach'];
	  $page['season'][$is]['team_coach'][$j]['season']=$is;
	  $page['season'][$is]['team_coach'][$j]['coach']=$ligne_ee['member_id'];
	  $page['season'][$is]['team_coach'][$j]['coach_text']=$ligne_ee['member_firstname']." ".$ligne_ee['member_lastname'];
	  $page['season'][$is]['team_coach'][$j]['season_coach']=$ligne_ee['season_id'];
	  $page['season'][$is]['team_coach'][$j]['L_delete']=$lang['team']['delete'];    
	  $j++;
	  $page['nb_coach']++;
	 }
  }
  sql_free_result($res_team_coach);
 } 
 else // il y a des erreurs de formulaire
 {
  if(isset($_POST['coach']) AND !empty($_POST['coach']))
  {
    $tab=array_keys($_POST['coach']); 
	 $j="0";
	 foreach($tab as $key => $value)
	 {
	  if($_POST['season_coach'][$value]==$ligne['season_id']) {
		  if($page['season'][$is]['id']==$page['season_id_defaut']) {
			 // we stock coach_id of the season to display
			 $team_coach[]=$_POST['coach'][$value];
		  }		  
		  $page['season'][$is]['team_coach'][$j]['i']=$page['nb_coach'];
		  $page['season'][$is]['team_coach'][$j]['season']=$is;
		  $page['season'][$is]['team_coach'][$j]['coach']=$_POST['coach'][$value];
		  $page['season'][$is]['team_coach'][$j]['coach_text']=$_POST['coach_text'][$value];
		  $page['season'][$is]['team_coach'][$j]['season_coach']=$_POST['season_coach'][$value];
		  $page['season'][$is]['team_coach'][$j]['L_delete']=$lang['team']['delete'];    
		  $j++;
		  $page['nb_coach']++;
	  }
	 }
   }
  }	 
	  
 // players of the team for the season
 $page['season'][$is]['team_player']=array();
 if($nb_erreur==0) {
	$var['condition']=" WHERE ej.team_id='".$page['value_id']."' AND ej.season_id='".$ligne['season_id']."'";
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
	  if($page['season'][$is]['id']==$page['season_id_defaut']) {
	  	 // we stock player_id of the season to display
		 $team_player[]=$ligne_ej['member_id'];
	  }
	  $page['season'][$is]['team_player'][$ij]['i']=$page['nb_player'];
	  $page['season'][$is]['team_player'][$ij]['season']=$is;
	  $page['season'][$is]['team_player'][$ij]['player']=$ligne_ej['member_id'];
	  $page['season'][$is]['team_player'][$ij]['player_text']=$ligne_ej['member_firstname']." ".$ligne_ej['member_lastname'];
	  $page['season'][$is]['team_player'][$ij]['number_player']=$ligne_ej['player_number'];
	  $page['season'][$is]['team_player'][$ij]['position']=$ligne_ej['position_id'];
	  $page['season'][$is]['team_player'][$ij]['position_text']=$ligne_ej['position_name'];  
	  $page['season'][$is]['team_player'][$ij]['captain_player']=$ligne_ej['player_captain'];

      if($ligne_ej['player_captain']==0) { $page['season'][$is]['team_player'][$ij]['captain_player_text']=""; }
      else { $page['season'][$is]['team_player'][$ij]['captain_player_text']=$lang['team']['yes']; }
		  
	  $page['season'][$is]['team_player'][$ij]['season_player']=$ligne_ej['season_id'];
	  $page['season'][$is]['team_player'][$ij]['L_delete']=$lang['team']['delete'];    
	  $ij++;
	  $page['nb_player']++;
	 }
	}	
	sql_free_result($res_team_player);
 } 
 else // il y a des erreurs de formulaire
 {
  if(isset($_POST['player']) AND !empty($_POST['player']))
  {
    $tab=array_keys($_POST['player']); 
	 $ij="0";
	 foreach($tab as $key => $value)
	 {
	  if($_POST['season_player'][$value]==$ligne['season_id']) {
		  if($page['season'][$is]['id']==$page['season_id_defaut']) {
			 // we stock player_id of the season to display
			 $team_player[]=$_POST['player'][$value];
		  }	  	  
		  $page['season'][$is]['team_player'][$ij]['i']=$page['nb_player'];
		  $page['season'][$is]['team_player'][$ij]['season']=$is;
		  $page['season'][$is]['team_player'][$ij]['player']=$_POST['player'][$value];
		  $page['season'][$is]['team_player'][$ij]['player_text']=$_POST['player_text'][$value];
		  $page['season'][$is]['team_player'][$ij]['number_player']=$_POST['number_player'][$value];
		  $page['season'][$is]['team_player'][$ij]['position']=$_POST['position'][$value];
		  $page['season'][$is]['team_player'][$ij]['position_text']=$_POST['position_text'][$value]; 
		  $page['season'][$is]['team_player'][$ij]['captain_player']=$_POST['captain_player'][$value];
		  $page['season'][$is]['team_player'][$ij]['captain_player_text']=$_POST['captain_player_text'][$value]; 
		  $page['season'][$is]['team_player'][$ij]['season_player']=$_POST['season_player'][$value];
		  $page['season'][$is]['team_player'][$ij]['L_delete']=$lang['team']['delete'];    
		  $ij++;
		  $page['nb_player']++;
	  }
	 } 
   } 
  } 
  $is++;
 }
}
sql_free_result($res_liste);
sql_close($sgbd);

$page['nb_season']=$nb_ligne_s;
$page['L_season']=$lang['competition']['season'];
$page['L_choose_season']=$lang['competition']['choose_season'];
$page['L_composition_team']=$lang['team']['composition_team'];

# team_coach
$page['L_team_coach']=$lang['team']['team_coach'];
$page['L_coach']=$lang['team']['coach'];
$page['L_choose_coach']=$lang['team']['choose_coach'];
$page['L_add']=$lang['team']['add'];
$page['L_delete']=$lang['team']['delete'];
$page['L_erreur_coach']=$lang['team']['E_empty_team_coach'];

$page['coach']=array();
$page['team_coach']=array();
$page['player']=array();
$page['position']=array();
$page['team_player']=array();

if($page['aff_season']==1)
{
 # liste des coachs
 include_once(create_path("member/sql_member.php"));
 include_once(create_path("member/lg_member_".LANG.".php"));
 include_once(create_path("member/tpl_member.php"));
 $var['condition']="";
 $var['order']="";
 $var['limit']="";
 $var['value_member']="";
 if(!empty($team_coach)) $var['value_member']="'".implode("','",$team_coach)."'"; 
 $var['value_club']=$page['value_club'];
 $var['value_sex']="";
 $var['value_season']=$page['season_id_defaut'];
 $included=1;
 include(create_path("member/member_list.php"));
 unset($included);
 $page['coach']=$page['member'];

 # team_player
 $page['L_team_player']=$lang['team']['team_player'];
 $page['L_player']=$lang['team']['player'];
 $page['L_number']=$lang['team']['number'];
 $page['L_position']=$lang['team']['position'];
 $page['L_captain']=$lang['team']['captain'];
 $page['L_choose_player']=$lang['team']['choose_player'];
 $page['L_choose_position']=$lang['team']['choose_position'];
 $page['L_add_coach']=$lang['team']['add_coach'];
 $page['L_add_player']=$lang['team']['add_player'];
 $page['L_delete']=$lang['team']['delete'];
 $page['L_erreur_player']=$lang['team']['E_empty_team_player'];

 # liste des players
 include_once(create_path("member/sql_member.php"));
 include_once(create_path("member/lg_member_".LANG.".php"));
 include_once(create_path("member/tpl_member.php"));
 $var['condition']="";
 $var['order']="";
 $var['limit']="";
 $var['value_member']="";
 if(!empty($team_player)) $var['value_member']="'".implode("','",$team_player)."'";
 $var['value_club']=$page['value_club'];
 $var['value_sex']=$page['value_sex'];
 $var['value_season']=$page['season_id_defaut'];
 $included=1;
 include(create_path("member/member_list.php"));
 unset($included);
 $page['player']=$page['member'];

 # liste des positions
 $sql_liste=$sql['team']['select_position'];
 $sgbd = sql_connect();
 $res_liste = sql_query($sql_liste);
 $i="0";
 while($ligne = sql_fetch_array($res_liste))
 {
  $page['position'][$i]['id']=$ligne['position_id'];
  $page['position'][$i]['name']=$ligne['position_name'];

  if(isset($_POST['position']) AND $_POST['position']=$ligne['position_id'])
  { $page['position'][$i]['selected']="selected"; }
  else { $page['position'][$i]['selected']=""; }
  $i++;
 }
 sql_free_result($res_liste);
 sql_close($sgbd);
}

# liste des sexs
$page['sex']=array();
include_once(create_path("member/sql_member.php"));
$sql_sex=$sql['member']['select_sex'];
$sgbd = sql_connect();
$res_sex = sql_query($sql_sex);
$nb_ligne=sql_num_rows($res_sex);
if($nb_ligne!="0")
{
 $i="0";
 while($ligne = sql_fetch_array($res_sex))
 {
  $page['sex'][$i]['id']=$ligne['sex_id'];
  $page['sex'][$i]['name']=$ligne['sex_name'];
  if(isset($page['value_sex']) AND $page['value_sex']==$ligne['sex_id']) { $page['sex'][$i]['checked']="checked=\"checked\""; } else { $page['sex'][$i]['checked']=""; }
  $page['sex'][$i]['link_select_member']=convert_url("index.php?r=".$lang['general']['idurl_member']."&v1=select_member");

  $i++;
 }
}
sql_free_result($res_sex);
sql_close($sgbd);
$page['checked_mixte']="";
if(isset($page['value_sex']) AND empty($page['value_sex'])) { $page['checked_mixte']="checked=\"checked\""; }
$page['L_mixte']=$lang['team']['mixte'];


# links
$page['form_action']=convert_url("index.php?r=".$lang['general']['idurl_team']."&v1=form_team");
$page['link_select_member']=convert_url("index.php?r=".$lang['general']['idurl_member']."&v1=select_member");


if($right_user['delete_team'] AND !empty($page['value_id']))
{
 $page['link_delete']=convert_url("index.php?r=".$lang['general']['idurl_team']."&v1=team_list&v2=delete&v3=".$page['value_id']);
}
else
{
 $page['link_delete']="";
}
$page['link_list']=convert_url("index.php?r=".$lang['general']['idurl_team']."&v1=team_list");

# text
if(empty($page['value_id'])) { $page['L_title']=$lang['team']['form_team_add']; }
else { $page['L_title']=$lang['team']['form_team_edit']; }

$page['L_valider']=$lang['team']['submit'];
$page['L_delete']=$lang['team']['delete'];
$page['L_back_list']=$lang['team']['back_list'];
$page['L_erreur']=$lang['general']['E_erreur'];
$page['L_field_required']=$lang['general']['field_required'];
$page['L_yes']=$lang['team']['yes'];
$page['L_no']=$lang['team']['no'];

$page['L_team_name']=$lang['team']['team_name'];
$page['L_sex']=$lang['team']['sex'];
$page['L_choose_team_name']=$lang['team']['choose_team_name'];
$page['L_club']=$lang['team']['club'];
$page['L_choose_club']=$lang['team']['choose_club'];

$page['meta_title']=$page['L_title'];
$page['template']=$tpl['team']['form_team'];
?>