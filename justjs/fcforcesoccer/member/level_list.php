<?php
##################################
# level 
##################################

# variables
$page['L_message']="";
$page['form_action']=convert_url("index.php?r=".$lang['general']['idurl_member']."&v1=level_list");
$nb_erreur="0";
$page['erreur']=array();
$page['level']=array();

# form values
$page['value_id']="";
$page['value_name']="";

# cas d'une suppression 
if($right_user['level_list'] AND isset($_GET['v2']) AND isset($_GET['v3']) AND $_GET['v3']=="delete" AND (!isset($included) OR $included==0))
{
 $var['id']=$_GET['v2'];
 $sql_verif=sql_replace($sql['member']['verif_level'],$var);
 $sql_sup=sql_replace($sql['member']['sup_level'],$var);
 $sgbd = sql_connect();
 
 # verification
 if(sql_num_rows(sql_query($sql_verif))!="0") { $page['erreur'][$nb_erreur]['message']=$lang['member']['E_exist_level_member']; $nb_erreur++; }
 
 if($nb_erreur==0)
 {
  if(sql_query($sql_sup) != false) { $page['L_message']=$lang['member']['form_level_sup_1'];  }
  else { $page['L_message']=$lang['member']['form_level_sup_0']; }
 }
 else { $page['L_message']=$lang['member']['form_level_sup_0']; }
 sql_close($sgbd);
}

# case of add or edit
if($right_user['level_list'] AND isset($_POST) AND !empty($_POST) AND (!isset($included) OR $included==0))
{
 # we format datas
 if(isset($_POST['name'])) $_POST['name']=format_txt($_POST['name']);

 # we check datas
 if(!isset($_POST['name']) OR empty($_POST['name'])) { $page['erreur'][$nb_erreur]['message']=$lang['member']['E_empty_name_level']; $nb_erreur++; }
 else
 {
  # we check if it does not already exist
   $sgbd = sql_connect();
   $sql_verif = sql_replace($sql['member']['verif_presence_level'],$_POST);
   $res_verif = sql_query($sql_verif);
   $nb_res = sql_num_rows($res_verif);
   sql_free_result($res_verif);
   sql_close($sgbd);
   if($nb_res!="0") { $page['erreur'][$nb_erreur]['message']=$lang['member']['E_exist_level']; $nb_erreur++; }
 }

 # there is no error in submited datas
 if($nb_erreur==0)
 {
  # case : new item to add
  if(!isset($_POST['id']) OR empty($_POST['id']))
  {
   $sql_add=sql_replace($sql['member']['insert_level'],$_POST);
   $sgbd = sql_connect();
   if(sql_query($sql_add) != false) { $page['L_message']=$lang['member']['form_level_add_1']; }
   else { $page['L_message']=$lang['member']['form_level_add_0']; }
   sql_close($sgbd);
  }
  # case : item to modify
  else
  {
   $sql_modification=sql_replace($sql['member']['edit_level'],$_POST);
   $sgbd = sql_connect();
   if(sql_query($sql_modification) != false) { $page['L_message']=$lang['member']['form_level_edit_1']; }
   else { $page['L_message']=$lang['member']['form_level_edit_0']; }
   sql_close($sgbd);
  }
 }
 else
 {
  # there is some errors: we show the datas again
  if(isset($_POST['id'])) $page['value_id']=$_POST['id'];
  if(isset($_POST['name'])) $page['value_name']=$_POST['name'];
 }
}


# listes des level
$sql_liste=$sql['member']['select_level'];
$sgbd = sql_connect();
$res_liste = sql_query($sql_liste);
$i="0";
while($ligne = sql_fetch_array($res_liste))
{
 $page['level'][$i]['id']=$ligne['level_id'];
 $page['level'][$i]['name']=$ligne['level_name'];
 
 $page['level'][$i]['form_action']=$page['form_action'];
 $page['level'][$i]['link_modification']=convert_url("index.php?r=".$lang['general']['idurl_member']."&v1=form_level&v2=".$ligne['level_id']);
  $page['level'][$i]['link_suppression']=convert_url("index.php?r=".$lang['general']['idurl_member']."&v1=level_list&v2=".$ligne['level_id']."&v3=delete");
  $page['level'][$i]['L_edit']=$lang['member']['edit'];
  $page['level'][$i]['L_delete']=$lang['member']['delete'];
 $i++;
}
sql_free_result($res_liste);
sql_close($sgbd);


$page['L_title']=$lang['member']['level_list'];
$page['L_liste']=$lang['member']['level_list'];
$page['L_add']=$lang['member']['add_level'];
$page['L_valider']=$lang['member']['submit'];
$page['L_erreur']=$lang['general']['E_erreur'];
$page['L_field_required']=$lang['general']['field_required'];

$page['meta_title']=$lang['member']['level_list'];
$page['template']=$tpl['member']['level_list'];
?>