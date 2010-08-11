<?php
##################################
# member 
##################################
include_once(create_path("club/sql_club.php"));

# variables
$page['L_message']="";
$page['form_action']=convert_url("index.php?r=".$lang['general']['idurl_member']."&v1=form_member");
$nb_erreur="0";
$page['erreur']=array();
$page['member']=array();
$details_member="0"; // mis a 1, force la recuperation des details du member

# form values
$page['value_id']="";
$page['value_name']="";
$page['value_firstname']="";
$page['value_email']="";
$page['value_date_birth']="";
$page['value_place_birth']="";
$page['value_size']="";
$page['value_weight']="";
$page['value_comment']="";
$page['value_sex']="";
$page['value_country']="";
$page['value_level']="";
$page['value_login']="";
$page['value_description']="";
$page['value_photo']="";
$page['value_avatar']="";
$page['value_status']="";
$page['value_valid']="0";

# si l'identifiant du member est passe dans l'url (modification), on le recupere
if(isset($_GET['v2']) AND $_GET['v2']!="") { $page['value_id']=$_GET['v2']; }
elseif(isset($_POST['id']) AND $_POST['id']!="") { $page['value_id']=$_POST['id']; }

# case of add or edit
if(isset($_POST) AND !empty($_POST))
{
 # we format datas
 if(isset($_POST['name'])) $_POST['name']=format_txt($_POST['name']);
 if(isset($_POST['firstname'])) $_POST['firstname']=format_txt($_POST['firstname']);
 if(isset($_POST['email'])) $_POST['email']=trim($_POST['email']);
 if(isset($_POST['comment'])) $_POST['comment']=format_txt($_POST['comment']);
 if(isset($_POST['description'])) $_POST['description']=format_txt($_POST['description']);
 if(isset($_POST['place_birth'])) $_POST['place_birth']=format_txt($_POST['place_birth']);
 if(isset($_POST['login_member'])) $_POST['login']=$_POST['login_member'];
 if(isset($_POST['size'])) $_POST['size']=$_POST['size'];

 # we check datas
 if(!isset($_POST['name']) OR $_POST['name']=="") { $page['erreur'][$nb_erreur]['message']=$lang['member']['E_empty_name']; $nb_erreur++; }
 if(!isset($_POST['firstname']) OR $_POST['firstname']=="") { $page['erreur'][$nb_erreur]['message']=$lang['member']['E_empty_firstname']; $nb_erreur++; } 
 
 if($nb_erreur==0)
 {
  # we check if it does not already exist
   $sgbd = sql_connect();
   $sql_verif = sql_replace($sql['member']['verif_presence_member'],$_POST);
   $res_verif = sql_query($sql_verif);
   $nb_res = sql_num_rows($res_verif);
   sql_free_result($res_verif);
   sql_close($sgbd);
   if($nb_res!="0") { $page['erreur'][$nb_erreur]['message']=$lang['member']['E_exist_member']; $nb_erreur++; }
 }
 
 # size et weight
  if(isset($_POST['size']) AND !empty($_POST['size']) AND !check_integer($_POST['size'])) { $page['erreur'][$nb_erreur]['message']=$lang['member']['E_invalid_size']; $nb_erreur++; }
 
 # email
 if(isset($_POST['email']) AND !empty($_POST['email']) AND !check_email($_POST['email'])) { $page['erreur'][$nb_erreur]['message']=$lang['member']['E_invalid_email']; $nb_erreur++; }
 elseif(isset($_POST['email']) AND !empty($_POST['email']))
 {
   $sgbd = sql_connect();
   $sql_verif_email = sql_replace($sql['member']['verif_member_email'],$_POST);
   $res = sql_query($sql_verif_email);
   $nb_res = sql_num_rows($res);
   sql_free_result($res);
   sql_close($sgbd);
   if($nb_res!="0") { $page['erreur'][$nb_erreur]['message']=$lang['member']['E_choisi_email']; $nb_erreur++; }
 }
 
 if(isset($_POST['date_birth']) AND !empty($_POST['date_birth']) AND !check_date($_POST['date_birth'])) { $page['erreur'][$nb_erreur]['message']=$lang['member']['E_invalid_date_birth']; $nb_erreur++; } 
 
 # cas du super admin
 if(isset($_POST['id']) AND $_POST['id']==1 AND ((!isset($_POST['status']) OR $_POST['status']!="2") OR (!isset($_POST['valid']) OR $_POST['valid']!="1"))) { $page['erreur'][$nb_erreur]['message']=$lang['member']['E_modification_member_administrateur']; $nb_erreur++; 
 $_POST['status']=2;
 $_POST['valid']=1; } 
 
 if(isset($_POST['id']) AND $_POST['id']==1 AND $_POST['id']!=$_SESSION['session_member_id']) {
  $page['erreur'][$nb_erreur]['message']=$lang['member']['E_modification_compte_administrateur']; $nb_erreur++; 
  $details_member="1";
 }
 
 # login 
 if(isset($_POST['valid']) AND $_POST['valid']!=0 AND (!isset($_POST['login_member']) OR empty($_POST['login_member']))) { $page['erreur'][$nb_erreur]['message']=$lang['member']['E_empty_login']; $nb_erreur++; }
 elseif(isset($_POST['valid']) AND $_POST['valid']!=0 AND !check_login($_POST['login_member'])) { $page['erreur'][$nb_erreur]['message']=$lang['member']['E_invalid_login']; $nb_erreur++; }
 elseif(isset($_POST['login']) AND !empty($_POST['login']))
 {
   $sgbd = sql_connect();
   $sql_verif_login = sql_replace($sql['member']['verif_member_login'],$_POST);
   $res = sql_query($sql_verif_login);
   $nb_res = sql_num_rows($res);
   sql_free_result($res);
   sql_close($sgbd);
   if($nb_res!="0") { $page['erreur'][$nb_erreur]['message']=$lang['member']['E_choisi_login']; $nb_erreur++; }
 }

 # mots de passe
 if(isset($_POST['pass_member']) AND !empty($_POST['pass_member'])) {
  if(!isset($_POST['confirm_pass']) OR empty($_POST['confirm_pass'])) { $page['erreur'][$nb_erreur]['message']=$lang['member']['E_empty_confirm_pass']; $nb_erreur++; }
  elseif(!check_login($_POST['pass_member'])) { $form_invalid=1; $page['erreur'][$nb_erreur]['message']=$lang['member']['E_invalid_pass']; $nb_erreur++; }
  elseif($_POST['pass_member']!=$_POST['confirm_pass']) { $form_invalid=1; $page['erreur'][$nb_erreur]['message']=$lang['member']['E_pass_different']; $nb_erreur++; }   
 }
 else
 {
  // si c'est la premiere activiation du compte, alors on demande un mot de passe !
  // autre solution : un mail contenant le pwd est envoyé au member, dans ce cas il faut un email...
 }

 
 # there is no error in submited datas
 if($nb_erreur==0)
 {
  $_POST['date_birth']=convert_date_sql($_POST['date_birth']);
  if(!isset($_POST['sex'])) $_POST['sex']="";
  if(!isset($_POST['size']) OR empty($_POST['size'])) $_POST['size']="NULL";
  if(!isset($_POST['weight']) OR empty($_POST['weight'])) $_POST['weight']="NULL";
    
  # case : new item to add
  if(!isset($_POST['id']) OR empty($_POST['id']))
  {
   $sql_add=sql_replace($sql['member']['insert_member'],$_POST);
   
   $sgbd = sql_connect();
   $execution=sql_query($sql_add);
   if($execution != false) { $page['L_message']=$lang['member']['form_member_add_1']; }
   else { $page['L_message']=$lang['member']['form_member_add_0']; }
   $page['value_id']=sql_insert_id($sgbd);
   sql_close($sgbd);
   
   # member_club 
   $values=array();
   if($execution AND isset($_POST['club']) AND !empty($_POST['club']) AND is_array($_POST['club']))
   {  
    $tab_club=array_keys($_POST['club']); 
    foreach($tab_club as $key => $value)
 	{
	 $values[]="('".$page['value_id']."','".$_POST['club'][$value]."','".$_POST['season_club'][$value]."')";
	}	
	$var['values']=implode(", ",$values);
	$sql_add=sql_replace($sql['member']['insert_member_club'],$var);
	
	$sgbd = sql_connect();
	sql_query($sql_add);
	sql_close($sgbd);	
   }
   
   
   # member_job 
   $values=array();
   if($execution AND isset($_POST['job']) AND !empty($_POST['job']))
   {  
    $tab_job=array_keys($_POST['job']); 
    foreach($tab_job as $key => $value)
 	{
	 $values[]="('".$page['value_id']."','".$_POST['job'][$value]."','".$_POST['season_job'][$value]."')";
	}	
	$var['values']=implode(", ",$values);
	$sql_add=sql_replace($sql['member']['insert_member_job'],$var);
	$sgbd = sql_connect();
	sql_query($sql_add);
	sql_close($sgbd);	
   }   
  }
  # case : item to modify
  else
  {
   $sql_modification=sql_replace($sql['member']['edit_member_admin'],$_POST);   
   $sgbd = sql_connect();
   $execution=sql_query($sql_modification);
   
   if($execution != false) { $page['L_message']=$lang['member']['form_member_edit_1']; }
   else { $page['L_message']=$lang['member']['form_member_edit_0']; }
   sql_close($sgbd);
   
   # mot de passe
   if(isset($_POST['pass_member']) AND !empty($_POST['pass_member'])) {
    $_POST['pass_md5']=md5($_POST['pass_member']);
    $sql_pass=sql_replace($sql['member']['edit_member_pass'],$_POST);
    $sgbd = sql_connect();
    sql_query($sql_pass);   
	sql_close($sgbd);
   }
   
   # member_club et member_job 
   if($execution)
   { 
    # on supprime tous les elements
	 $var['member']=$page['value_id'];
	 $sql_sup=sql_replace($sql['member']['sup_member_club'],$var);	 
	 $sgbd = sql_connect();
	 sql_query($sql_sup);
	 sql_close($sgbd);
	 
	$values=array();
	# si il a de nouveaux elements, on les ajoute
    if(isset($_POST['club']) AND !empty($_POST['club']) AND is_array($_POST['club']))
    { 
     $tab_club=array_keys($_POST['club']);
     foreach($tab_club as $key => $value)
  	 {
 	  $values[]="('".$page['value_id']."','".$_POST['club'][$value]."','".$_POST['season_club'][$value]."')";
 	 }
	 $var['values']=implode(", ",$values);
	 $sql_add=sql_replace($sql['member']['insert_member_club'],$var);
	
 	 $sgbd = sql_connect();
	 sql_query($sql_add);
	 sql_close($sgbd);	
    }
	
    # on supprime tous les elements
	 $var['member']=$page['value_id'];
	 $sql_sup=sql_replace($sql['member']['sup_member_job'],$var);	 
	 $sgbd = sql_connect();
	 sql_query($sql_sup);
	 sql_close($sgbd);
	 
	$values=array();
	# si il a de nouveaux elements, on les added
    if(isset($_POST['job']) AND !empty($_POST['job']))
    { 
     $tab_job=array_keys($_POST['job']); 
     foreach($tab_job as $key => $value)
  	 {
 	 $values[]="('".$page['value_id']."','".$_POST['job'][$value]."','".$_POST['season_job'][$value]."')";
 	 }	 
	 $var['values']=implode(", ",$values);
	 $sql_add=sql_replace($sql['member']['insert_member_job'],$var);
	
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
  if(isset($_POST['name'])) $page['value_name']=$_POST['name'];
  if(isset($_POST['firstname'])) $page['value_firstname']=$_POST['firstname'];
  if(isset($_POST['email'])) $page['value_email']=$_POST['email'];
  if(isset($_POST['date_birth'])) $page['value_date_birth']=$_POST['date_birth'];
  if(isset($_POST['place_birth'])) $page['value_place_birth']=$_POST['place_birth'];
  if(isset($_POST['size'])) $page['value_size']=$_POST['size'];
  if(isset($_POST['weight'])) $page['value_weight']=$_POST['weight'];
  if(isset($_POST['comment'])) $page['value_comment']=$_POST['comment'];
  if(isset($_POST['sex'])) $page['value_sex']=$_POST['sex'];
  if(isset($_POST['country'])) $page['value_country']=$_POST['country'];
  if(isset($_POST['level'])) $page['value_level']=$_POST['level'];
  
  if(isset($_POST['club'])) $page['club']=$_POST['club'];
  if(isset($_POST['club_text'])) $page['club_text']=$_POST['club_text'];
  if(isset($_POST['date_arrivee'])) $page['date_arrivee']=$_POST['date_arrivee'];
  if(isset($_POST['date_depart'])) $page['date_depart']=$_POST['date_depart'];
  
  if(isset($_POST['job'])) $page['job']=$_POST['job'];
  if(isset($_POST['job_text'])) $page['job_text']=$_POST['job_text'];
  if(isset($_POST['date_start'])) $page['date_start']=$_POST['date_start'];
  if(isset($_POST['date_end'])) $page['date_end']=$_POST['date_end'];
  
  if(isset($_POST['login_member'])) $page['value_login']=$_POST['login_member'];
  if(isset($_POST['description'])) $page['value_description']=$_POST['description']; 
  if(isset($_POST['photo'])) $page['value_photo']=$_POST['photo']; 
  if(isset($_POST['avatar'])) $page['value_avatar']=$_POST['avatar'];  
  if(isset($_POST['status'])) $page['value_status']=$_POST['status'];
  if(isset($_POST['valid'])) $page['value_valid']=$_POST['valid'];
 }
}

# if the ID is known, we get the datas to show them in the form
if(isset($page['value_id']) AND $page['value_id']!="" AND ($nb_erreur==0 OR $details_member==1))
{
 # we get the item information
 $var['id']=$page['value_id'];
 $sql_details=sql_replace($sql['member']['select_member_details'],$var);

 $sgbd = sql_connect();
 $res = sql_query($sql_details);
 $ligne = sql_fetch_array($res);
 sql_free_result($res);
 sql_close($sgbd);

 $page['value_id']=$ligne['member_id'];
 $page['value_name']=$ligne['member_lastname'];
 $page['value_firstname']=$ligne['member_firstname'];
 $page['value_email']=$ligne['member_email'];
 $page['value_date_birth']=convert_date($ligne['member_date_birth'],$lang['member']['format_date_form']); 
 $page['value_place_birth']=$ligne['member_place_birth'];
 $page['value_size']=$ligne['member_size'];
 $page['value_weight']=$ligne['member_weight'];
 $page['value_comment']=$ligne['member_comment'];
 $page['value_sex']=$ligne['sex_id'];
 $page['value_country']=$ligne['country_id'];
 $page['value_level']=$ligne['level_id'];
 $page['value_login']=$ligne['member_login'];
 $page['value_description']=$ligne['member_description'];
 $page['value_photo']=$ligne['member_photo'];
 $page['value_avatar']=$ligne['member_avatar'];
 $page['value_status']=$ligne['member_status'];
 $page['value_valid']=$ligne['member_valid'];
}

# sexs list
$page['sex']=array();
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
  if(isset($page['value_sex']) AND $page['value_sex']==$ligne['sex_id']) { $page['sex'][$i]['checked']="checked"; } else { $page['sex'][$i]['checked']=""; }
  $i++;
 }
}
sql_free_result($res_sex);
sql_close($sgbd);

# country list
$page['country']=array();
$sql_country=$sql['member']['select_country'];
$sgbd = sql_connect();
$res_country = sql_query($sql_country);
$nb_ligne=sql_num_rows($res_country);
if($nb_ligne!="0")
{
 $i="0";
 while($ligne = sql_fetch_array($res_country))
 {
  $page['country'][$i]['id']=$ligne['country_id'];
  $page['country'][$i]['name']=$ligne['country_name'];
  if(isset($page['value_country']) AND $page['value_country']==$ligne['country_id']) { $page['country'][$i]['selected']="selected"; } else { $page['country'][$i]['selected']=""; }
  $i++;
 }
}
sql_free_result($res_country);
sql_close($sgbd);
$page['link_form_country']=convert_url("index.php?r=".$lang['general']['idurl_member']."&v1=country_list&fen=pop",0);
$page['L_add_country']=$lang['member']['add_country'];


# level list
$page['level']=array();
$sql_level=$sql['member']['select_level'];
$sgbd = sql_connect();
$res_level = sql_query($sql_level);
$nb_ligne=sql_num_rows($res_level);
if($nb_ligne!="0")
{
 $i="0";
 while($ligne = sql_fetch_array($res_level))
 {
  $page['level'][$i]['id']=$ligne['level_id'];
  $page['level'][$i]['name']=$ligne['level_name'];
  if(isset($page['value_level']) AND $page['value_level']==$ligne['level_id']) { $page['level'][$i]['selected']="selected"; } else { $page['level'][$i]['selected']=""; }
  $i++;
 }
}
sql_free_result($res_level);
sql_close($sgbd);
 
# member_club
$page['L_member_club']=$lang['member']['member_club'];
$page['L_club']=$lang['member']['club'];
$page['L_choose_club']=$lang['member']['choose_club'];
$page['L_season']=$lang['member']['season'];
$page['L_choose_season']=$lang['member']['choose_season'];
$page['L_add']=$lang['member']['add'];
$page['L_delete']=$lang['member']['delete'];
$page['L_erreur_club']=$lang['member']['E_empty_member_club'];

$page['club_nb']=0;

$page['club']=array();
$page['member_club']=array();


# liste des clubs
$page['club']=array();
$sql_club=$sql['club']['select_club'];
$sgbd = sql_connect();
$res_club = sql_query($sql_club);
$nb_ligne=sql_num_rows($res_club);
if($nb_ligne!="0")
{
 $i="0";
 while($ligne = sql_fetch_array($res_club))
 {
  $page['club'][$i]['id']=$ligne['club_id'];
  $page['club'][$i]['name']=$ligne['club_name'];
  if(isset($_POST['club']) AND $_POST['club']==$ligne['club_id']) { $page['club'][$i]['selected']="selected"; } else { $page['club'][$i]['selected']=""; }
  $i++;
 }
}
sql_free_result($res_club);
sql_close($sgbd);

# liste des member_club
$season_club=array();
if($nb_erreur==0) {
$var['condition']=" WHERE mc.member_id='".$page['value_id']."' ";
$var['order']=" ORDER BY s.season_date_start DESC";
$var['limit']="";
$sql_member_club=sql_replace($sql['member']['select_member_club'],$var);
$sgbd = sql_connect();
$res_member_club = sql_query($sql_member_club);
$nb_ligne=sql_num_rows($res_member_club);
$page['club_nb']=$nb_ligne;
if($nb_ligne!="0")
{
 $i="0";
 while($ligne = sql_fetch_array($res_member_club))
 {
  $page['member_club'][$i]['i']=$i;
  $page['member_club'][$i]['club']=$ligne['club_id'];
  $page['member_club'][$i]['club_text']=$ligne['club_name'];
  $page['member_club'][$i]['season']=$ligne['season_id'];
  $page['member_club'][$i]['season_text']=$ligne['season_name'];
  $page['member_club'][$i]['L_delete']=$lang['member']['delete'];    
  $season_club[$i]=$ligne['season_id'];
  $i++;
 }
}
sql_free_result($res_member_club);
sql_close($sgbd);
}

# liste des clubs envoyes via le formulaire
if(isset($_POST['club']) AND !empty($_POST['club']) AND is_array($_POST['club']))
{
 $tab=array_keys($_POST['club']); 
 $i=0;
 foreach($tab as $key => $value)
 {
  $page['member_club'][$i]['i']=$i;
  $page['member_club'][$i]['club']=$_POST['club'][$value];
  $page['member_club'][$i]['club_text']=$_POST['club_text'][$value];
  $page['member_club'][$i]['season']=$_POST['season_club'][$value];
  $page['member_club'][$i]['season_text']=$_POST['season_club_text'][$value];
  $page['member_club'][$i]['L_delete']=$lang['member']['delete'];    
  $season_club[$i]=$_POST['season_club'][$value];
  $i++;
 }
 $page['club_nb']=$i;
}

# member_job
$page['L_member_job']=$lang['member']['member_job'];
$page['L_job']=$lang['member']['job'];
$page['L_choose_job']=$lang['member']['choose_job'];
$page['L_add']=$lang['member']['add'];
$page['L_delete']=$lang['member']['delete'];
$page['L_erreur_job']=$lang['member']['E_empty_member_job'];

$page['job_nb']=0;

$page['job']=array();
$page['member_job']=array();


# liste des jobs
$page['job']=array();

$sql_job=$sql['member']['select_job'];
$sgbd = sql_connect();
$res_job = sql_query($sql_job);
$nb_ligne=sql_num_rows($res_job);
if($nb_ligne!="0")
{
 $i="0";
 while($ligne = sql_fetch_array($res_job))
 {
  $page['job'][$i]['id']=$ligne['job_id'];
  $page['job'][$i]['name']=$ligne['job_name'];
  if(isset($_POST['job']) AND $_POST['job']==$ligne['job_id']) { $page['job'][$i]['selected']="selected"; } else { $page['job'][$i]['selected']=""; }
  $i++;
 }
}
sql_free_result($res_job);
sql_close($sgbd);


# liste des member_job
$season_job=array();
if($nb_erreur==0) {
$var['condition']=" WHERE mf.member_id='".$page['value_id']."' ";
$var['order']=" ORDER BY s.season_date_start DESC";
$var['limit']="";
$sql_member_job=sql_replace($sql['member']['select_member_job'],$var);
$sgbd = sql_connect();
$res_member_job = sql_query($sql_member_job);
$nb_ligne=sql_num_rows($res_member_job);
if($nb_ligne!="0")
{
 $i="0";
 while($ligne = sql_fetch_array($res_member_job))
 {
  $page['member_job'][$i]['i']=$i;
  $page['member_job'][$i]['job']=$ligne['job_id'];
  $page['member_job'][$i]['job_text']=$ligne['job_name'];
  $page['member_job'][$i]['season']=$ligne['season_id'];
  $page['member_job'][$i]['season_text']=$ligne['season_name'];
  $page['member_job'][$i]['L_delete']=$lang['member']['delete'];    
  $season_job[$i]=$ligne['season_id'];
  $i++;
 }
}
sql_free_result($res_member_job);
sql_close($sgbd);
}

# liste des jobs envoyees via le formulaire
if(isset($_POST['job']) AND !empty($_POST['job']))
{
 $tab=array_keys($_POST['job']); 
 $i=0;
 foreach($tab as $key => $value)
 {
  $page['member_job'][$i]['i']=$i;
  $page['member_job'][$i]['job']=$_POST['job'][$value];
  $page['member_job'][$i]['job_text']=$_POST['job_text'][$value];
  $page['member_job'][$i]['season']=$_POST['season_job'][$value];
  $page['member_job'][$i]['season_text']=$_POST['season_job_text'][$value];
  $page['member_job'][$i]['L_delete']=$lang['member']['delete'];    
  $season_job[$i]=$_POST['season_job'][$value];
  $i++;
 }
 $page['job_nb']=$i;
}

# liste des seasons pour le choix des clubs
$page['season_club']=array();
$page['season_job']=array();
include_once(create_path("competition/sql_competition.php"));
include_once(create_path("competition/lg_competition_".LANG.".php"));
include_once(create_path("competition/tpl_competition.php"));
$sql_liste=$sql['competition']['select_season'];
$sgbd = sql_connect();
$res_liste = sql_query($sql_liste);
$nb_ligne = sql_num_rows($res_liste);
$i="0";
$j="0";
while($ligne = sql_fetch_array($res_liste))
{
 if(!in_array($ligne['season_id'],$season_club)) {
  $page['season_club'][$i]['i']=$i;
  $page['season_club'][$i]['id']=$ligne['season_id'];
  $page['season_club'][$i]['name']=$ligne['season_name'];
  $page['season_club'][$i]['abbreviation']=$ligne['season_abbreviation'];
  $i++;
 }
 if(!in_array($ligne['season_id'],$season_job)) {
  $page['season_job'][$j]['i']=$j;
  $page['season_job'][$j]['id']=$ligne['season_id'];
  $page['season_job'][$j]['name']=$ligne['season_name'];
  $page['season_job'][$j]['abbreviation']=$ligne['season_abbreviation'];
  $j++;
 } 
}


# liste des groupes
$page['group']=array();
$page['value_member_group']=$page['value_status'];
$page['L_group']=$lang['member']['choose_group'];
if($right_user['group_list']) {
	$included=1;
	include(create_path('member/group_list.php'));
	unset($included);
}
$page['status']=$page['group'];

# status
/*
$page['status']=array();
$page['status']['0']['id']="0";
$page['status']['0']['name']=$lang['member']['status_0'];
$page['status']['0']['info']=$lang['member']['status_member_info'];
$page['status']['0']['checked']="";
$page['status']['1']['id']="1";
$page['status']['1']['name']=$lang['member']['status_1'];
$page['status']['1']['info']=$lang['member']['status_admin_info'];
$page['status']['1']['checked']="";
$page['status']['2']['id']="2";
$page['status']['2']['name']=$lang['member']['status_2'];
$page['status']['2']['info']=$lang['member']['status_super_admin_info'];
$page['status']['2']['checked']="";
$page['status']['3']['id']="-1";
$page['status']['3']['name']=$lang['member']['status_-1'];
$page['status']['3']['info']=$lang['member']['status_blocked_info'];
$page['status']['3']['checked']="";

switch($page['value_status']) {
 case "0" : $page['status']['0']['checked']="checked"; break;
 case "1" : $page['status']['1']['checked']="checked"; break;
 case "2" : $page['status']['2']['checked']="checked"; break;
 case "-1" : $page['status']['3']['checked']="checked"; break;
 default : $page['status']['0']['checked']="checked";
} 
*/
# valid
$page['valid']=array();
$valid=array('0','1','-1','-2');
/* 
- if member_valid = 0 : the account is not active
- if member_valid = 1 : the account is active
- if member_valid = -1 : the member ask for an activation of his account
- if member_valid = -2 : the member must confirm the activation (email sent)
 */
$nb_valid=sizeof($valid);
for($i=0; $i < $nb_valid; $i++) {
	$id=$valid[$i];
	$page['valid'][$i]['id']=$id;
	$page['valid'][$i]['name']=$lang['member']['valid_'.$id.''];
	$page['valid'][$i]['checked']="";
	if($page['value_valid']==$id) {
		$page['valid'][$i]['checked']='checked="checked"';
	}
}



# links
if($right_user['delete_member'] AND !empty($page['value_id']))
{
$page['link_delete']=convert_url("index.php?r=".$lang['general']['idurl_member']."&v1=member_list&v2=delete&v3=".$page['value_id']);

}
else
{
 $page['link_delete']="";
}
$page['link_list']=convert_url("index.php?r=".$lang['general']['idurl_member']."&v1=member_list");
$page['link_choose_image']=convert_url("index.php?r=".$lang['general']['idurl_file']."&v1=image_manager&parent_form=form_member&field_name=photo&file_type=image&fen=pop",0);
$page['link_choose_avatar']=convert_url("index.php?r=".$lang['general']['idurl_file']."&v1=image_manager&parent_form=form_member&field_name=avatar&file_type=image&fen=pop",0);


# text
if(empty($page['value_id'])) { $page['L_title']=$lang['member']['form_member_add']; }
else { $page['L_title']=$lang['member']['form_member_edit']; }

$page['L_valider']=$lang['member']['submit'];
$page['L_delete']=$lang['member']['delete'];
$page['L_back_list']=$lang['member']['back_list'];
$page['L_erreur']=$lang['general']['E_erreur'];
$page['L_field_required']=$lang['general']['field_required'];

$page['L_identity']=$lang['member']['identity'];
$page['L_name']=$lang['member']['name'];
$page['L_firstname']=$lang['member']['firstname'];
$page['L_date_birth']=$lang['member']['date_birth'];
$page['L_place_birth']=$lang['member']['place_birth'];
$page['L_email']=$lang['member']['email'];
$page['L_size']=$lang['member']['size'];
$page['L_size_unit']=$lang['member']['size_unit'];
$page['L_weight']=$lang['member']['weight'];
$page['L_weight_unite']=$lang['member']['weight_unite'];
$page['L_sex']=$lang['member']['sex'];
$page['L_country']=$lang['member']['nationality'];
$page['L_choose_country']=$lang['member']['choose_nationality'];
$page['L_referee']=$lang['member']['referee'];
$page['L_level']=$lang['member']['level'];
$page['L_choose_level']=$lang['member']['choose_level'];

$page['L_info_internaute']=$lang['member']['info_internaute'];
$page['L_login']=$lang['member']['login'];
$page['L_description']=$lang['member']['description'];
$page['L_photo']=$lang['member']['photo'];
$page['L_avatar']=$lang['member']['avatar'];
$page['L_choose_image']=$lang['member']['choose_image'];
$page['L_pass']=$lang['member']['pass'];
$page['L_explication_pass']=$lang['member']['explication_pass'];
$page['L_confirm_pass']=$lang['member']['confirm_pass'];
$page['L_status']=$lang['member']['status'];
$page['L_choose_status']=$lang['member']['choose_status'];
$page['L_valid']=$lang['member']['valid'];

$page['L_comment']=$lang['member']['comment'];
$page['L_format_date']=$lang['member']['format_date'];

$page['meta_title']=$page['L_title'];
$page['template']=$tpl['member']['form_member'];
?>