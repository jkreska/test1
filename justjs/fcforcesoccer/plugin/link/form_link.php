<?php
##################################
# link 
##################################

# variables
$page['L_message']="";
$page['form_action']=convert_url("index.php?r=".$plugin_idurl."&v1=form_link");
$nb_erreur="0";
$page['erreur']=array();
$page['link']=array();

# form values
$page['value_id']="";
$page['value_name']="";
$page['value_url']="";
$page['value_description']="";


if($right_user['add_link'] OR $right_user['edit_link']) {
	$page['show_form']=1; 
}
else {
	$page['show_form']='';
	$page['L_message']=$lang['general']['acces_reserve_admin'];
}

# si l'identifiant du link est passe dans l'url (modification), on le recupere
if(isset($_GET['v2']) AND $_GET['v2']!="") { $page['value_id']=$_GET['v2']; }
elseif(isset($_POST['id']) AND $_POST['id']!="") { $page['value_id']=$_POST['id']; }

# case of add or edit
if(isset($_POST) AND !empty($_POST))
{
 # we format datas
 if(isset($_POST['name'])) $_POST['name']=format_txt($_POST['name']);

 # we check datas
 if(!isset($_POST['name']) OR $_POST['name']=="") { $page['erreur'][$nb_erreur]['message']=$lang['link']['E_empty_name_link']; $nb_erreur++; }
 
 if(!isset($_POST['url']) OR $_POST['url']=="") { $page['erreur'][$nb_erreur]['message']=$lang['link']['E_empty_url']; $nb_erreur++; }
 elseif(!check_url($_POST['url'])) { $page['erreur'][$nb_erreur]['message']=$lang['link']['E_invalid_url']; $nb_erreur++; }
 else
 {
  # we check if it does not already exist
   $sgbd = sql_connect();
   $sql_verif = sql_replace($sql['link']['verif_presence_link'],$_POST);
   $res_verif = sql_query($sql_verif);
   $nb_res = sql_num_rows($res_verif);
   sql_free_result($res_verif);
   sql_close($sgbd);
   if($nb_res!="0") { $page['erreur'][$nb_erreur]['message']=$lang['link']['E_exist_link']; $nb_erreur++; }
 }
 
 # there is no error in submited datas
 if($nb_erreur==0)
 {
  # case : new item to add
  if(!isset($_POST['id']) OR empty($_POST['id']) AND $right_user['add_link'])
  {
   $sql_add=sql_replace($sql['link']['insert_link'],$_POST);
   $sgbd = sql_connect();
   $execution=sql_query($sql_add);
   if($execution) { $page['L_message']=$lang['link']['form_link_add_1']; }
   else { $page['L_message']=$lang['link']['form_link_add_0']; }
   $page['value_id']=sql_insert_id($sgbd);
   sql_close($sgbd);
  }
  # case : item to modify
  else($right_user['edit_link'])
  {
   $sql_modification=sql_replace($sql['link']['edit_link'],$_POST);
   $sgbd = sql_connect();
   if(sql_query($sql_modification) != false) { $page['L_message']=$lang['link']['form_link_edit_1']; }
   else { $page['L_message']=$lang['link']['form_link_edit_0']; }
   sql_close($sgbd);
  }
 }
 else
 {
  # there is some errors: we show the datas again
  if(isset($_POST['id'])) $page['value_id']=$_POST['id'];
  if(isset($_POST['name'])) $page['value_name']=$_POST['name'];
  if(isset($_POST['url'])) $page['value_url']=$_POST['url'];
  if(isset($_POST['description'])) $page['value_description']=$_POST['description'];
 }
}

# if the ID is known, we get the datas to show them in the form
if(isset($page['value_id']) AND $page['value_id']!="" AND $nb_erreur==0)
{
 # we get the item information
 $var['id']=$page['value_id'];
 $sql_details=sql_replace($sql['link']['select_link_details'],$var);

 $sgbd = sql_connect();
 $res = sql_query($sql_details);
 $ligne = sql_fetch_array($res);
 sql_free_result($res);
 sql_close($sgbd);

 $page['value_id']=$ligne['link_id'];
 $page['value_name']=$ligne['link_name'];
 $page['value_url']=$ligne['link_url'];
 $page['value_description']=$ligne['link_description'];
}

# links
if($right_user['delete_link'] AND !empty($page['value_id']))
{
$page['link_delete']=convert_url("index.php?r=".$plugin_idurl."&v1=link_list&v2=delete&v3=".$page['value_id']);

}
else
{
 $page['link_delete']="";
}
$page['link_list']=convert_url("index.php?r=".$plugin_idurl."&v1=link_list");


# text
if(empty($page['value_id'])) { $page['L_title']=$lang['link']['form_link_add']; }
else { $page['L_title']=$lang['link']['form_link_edit']; }
$page['L_valider']=$lang['link']['submit'];
$page['L_delete']=$lang['link']['delete'];
$page['L_back_list']=$lang['link']['back_list'];

$page['L_erreur']=$lang['general']['E_erreur'];
$page['L_field_required']=$lang['general']['field_required'];

$page['L_name']=$lang['link']['name'];
$page['L_url']=$lang['link']['url'];
$page['L_description']=$lang['link']['description'];

$page['meta_title']=$page['L_title'];
$page['template']=$tpl['link']['form_link'];
?>