<?php
##################################
# season 
##################################

# variables
$page['season']=array();

if(!isset($included) OR $included==0) {
	$page['L_message']="";	
	$nb_erreur="0";
	$page['erreur']=array();
	
	# form values
	$page['value_id']="";
	$page['value_name']="";
	$page['value_abbreviation']="";
	$page['value_date_start']="";
	$page['value_date_end']="";	
}

# cas d'une suppression 
if($right_user['season_list'] AND isset($_GET['v2']) AND isset($_GET['v3']) AND $_GET['v3']=="delete" AND (!isset($included) OR $included==0))
{
 $var['id']=$_GET['v2'];
 $sql_verif=sql_replace($sql['competition']['verif_season'],$var);
 $sql_sup=sql_replace($sql['competition']['sup_season'],$var);
 $sgbd = sql_connect();
 
 # verification
 if(sql_num_rows(sql_query($sql_verif))!="0") { $page['erreur'][$nb_erreur]['message']=$lang['competition']['E_exist_season']; $nb_erreur++; }
 
 if($nb_erreur==0)
 {
  if(sql_query($sql_sup) != false) { $page['L_message']=$lang['competition']['form_season_sup_1'];  }
  else { $page['L_message']=$lang['competition']['form_season_sup_0']; }
 }
 else { $page['L_message']=$lang['competition']['form_season_sup_0']; }
 sql_close($sgbd);
}

# case of add or edit
if(isset($_POST) AND !empty($_POST) AND (!isset($included) OR $included==0) AND $right_user['season_list'])
{
 # we format datas
 if(isset($_POST['name'])) $_POST['name']=format_txt($_POST['name']);
 if(isset($_POST['abbreviation'])) $_POST['abbreviation']=format_txt($_POST['abbreviation']);
 if(isset($_POST['date_start'])) $_POST['date_start']=format_txt($_POST['date_start']);
 if(isset($_POST['date_end'])) $_POST['date_end']=format_txt($_POST['date_end']);

 # we check datas
 if(!isset($_POST['name']) OR empty($_POST['name'])) { $page['erreur'][$nb_erreur]['message']=$lang['competition']['E_empty_name_season']; $nb_erreur++; }
 else
 {
  # we check if it does not already exist
   $sgbd = sql_connect();
   $sql_verif = sql_replace($sql['competition']['verif_presence_season'],$_POST);
   $res_verif = sql_query($sql_verif);
   $nb_res = sql_num_rows($res_verif);
   sql_free_result($res_verif);
   sql_close($sgbd);
   if($nb_res!="0") { $page['erreur'][$nb_erreur]['message']=$lang['competition']['E_exist_season']; $nb_erreur++; }
 }
 if(!isset($_POST['date_start']) OR empty($_POST['date_start'])) { $page['erreur'][$nb_erreur]['message']=$lang['competition']['E_empty_date_start']; $nb_erreur++; } 
 elseif(!check_date($_POST['date_start'])) { $page['erreur'][$nb_erreur]['message']=$lang['competition']['E_invalid_date_start']; $nb_erreur++; } 
 
 if(!isset($_POST['date_end']) OR empty($_POST['date_end'])) { $page['erreur'][$nb_erreur]['message']=$lang['competition']['E_empty_date_end']; $nb_erreur++; } 
 elseif(!check_date($_POST['date_end'])) { $page['erreur'][$nb_erreur]['message']=$lang['competition']['E_invalid_date_end']; $nb_erreur++; } 
 
 if(isset($_POST['date_start']) AND isset($_POST['date_end']) AND !empty($_POST['date_start']) AND !empty($_POST['date_end']) AND convert_date_sql($_POST['date_start']) > convert_date_sql($_POST['date_end'])) {
  $page['erreur'][$nb_erreur]['message']=$lang['competition']['E_invalid_dates']; $nb_erreur++;
 }
  
 # there is no error in submited datas
 if($nb_erreur==0)
 {
  $_POST['date_start']=convert_date_sql($_POST['date_start']);
  $_POST['date_end']=convert_date_sql($_POST['date_end']);
 
  # case : new item to add
  if(!isset($_POST['id']) OR empty($_POST['id']))
  {     
   $sql_add=sql_replace($sql['competition']['insert_season'],$_POST);
   $sgbd = sql_connect();
   if(sql_query($sql_add) != false) { $page['L_message']=$lang['competition']['form_season_add_1']; }
   else { $page['L_message']=$lang['competition']['form_season_add_0']; }
   sql_close($sgbd);
  }
  # case : item to modify
  else
  {
   $sql_modification=sql_replace($sql['competition']['edit_season'],$_POST);
   $sgbd = sql_connect();
   if(sql_query($sql_modification) != false) { $page['L_message']=$lang['competition']['form_season_edit_1']; }
   else { $page['L_message']=$lang['competition']['form_season_edit_0']; }
   sql_close($sgbd);
  }
 }
 else
 {
  # there is some errors: we show the datas again
  if(isset($_POST['id'])) $page['value_id']=$_POST['id'];
  if(isset($_POST['name'])) $page['value_name']=$_POST['name'];
  if(isset($_POST['abbreviation'])) $page['value_abbreviation']=$_POST['abbreviation'];
  if(isset($_POST['date_start'])) $page['value_date_start']=$_POST['date_start'];
  if(isset($_POST['date_end'])) $page['value_date_end']=$_POST['date_end'];
 }
}


# listes des season
$sql_liste=$sql['competition']['select_season'];
$sgbd = sql_connect();
$res_liste = sql_query($sql_liste);
$nb_ligne = sql_num_rows($res_liste);
$i="0";
while($ligne = sql_fetch_array($res_liste))
{
 $page['season'][$i]['id']=$ligne['season_id'];
 $page['season'][$i]['name']=$ligne['season_name'];
 $page['season'][$i]['abbreviation']=$ligne['season_abbreviation'];
 $page['season'][$i]['date_start']=convert_date($ligne['season_date_start'],$lang['competition']['format_date_form']);
 $page['season'][$i]['date_end']=convert_date($ligne['season_date_end'],$lang['competition']['format_date_form']);

 if(isset($var['value_season']) AND $var['value_season']==$ligne['season_id']) { $page['season'][$i]['selected']="selected"; $var['value_season']=$ligne['season_id']; }
 elseif((!isset($var['value_season']) OR empty($var['value_season'])) AND ($ligne['season_date_start']<=date("Y-m-d") AND $ligne['season_date_end']>date("Y-m-d"))) { $page['season'][$i]['selected']="selected"; $var['value_season']=$ligne['season_id'];  }
 else { $page['season'][$i]['selected']=""; } 
 
 
 $page['season'][$i]['form_action']=convert_url("index.php?r=".$lang['general']['idurl_competition']."&v1=season_list");
 $page['season'][$i]['link_modification']=convert_url("index.php?r=".$lang['general']['idurl_competition']."&v1=form_season&v2=".$ligne['season_id']);
  $page['season'][$i]['link_suppression']=convert_url("index.php?r=".$lang['general']['idurl_competition']."&v1=season_list&v2=".$ligne['season_id']."&v3=delete");
 $page['season'][$i]['L_edit']=$lang['competition']['edit'];
 $page['season'][$i]['L_delete']=$lang['competition']['delete']; 
  
 $i++;
}
sql_free_result($res_liste);
sql_close($sgbd);


# link
$page['form_action']=convert_url("index.php?r=".$lang['general']['idurl_competition']."&v1=season_list");

# text
$page['L_title']=$lang['competition']['season_list'];
$page['L_liste']=$lang['competition']['season_list'];
$page['L_name']=$lang['competition']['name'];
$page['L_abbreviation']=$lang['competition']['abbreviation'];
$page['L_date_start']=$lang['competition']['date_start'];
$page['L_date_end']=$lang['competition']['date_end'];
$page['L_format_date']=$lang['competition']['format_date'];
$page['L_add']=$lang['competition']['add_season'];
$page['L_valider']=$lang['competition']['submit'];
$page['L_erreur']=$lang['general']['E_erreur'];

$page['meta_title']=$lang['competition']['season_list'];
$page['template']=$tpl['competition']['season_list'];
?>