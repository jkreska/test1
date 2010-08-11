<?php
##################################
# group 
##################################

# variables
if(!isset($included) OR $included==0) {
	$page['L_message']="";
	$page['form_action']=convert_url("index.php?r=".$lang['general']['idurl_member']."&v1=group_list");
	$nb_erreur="0";
	$page['erreur']=array();
	$page['group']=array();

	# form values
	$page['value_id']="";
	$page['value_name']="";
	$page['value_description']="";
}

# cas d'une suppression 
if($right_user['group_list'] AND isset($_GET['v2']) AND isset($_GET['v3']) AND $_GET['v3']=="delete" AND (!isset($included) OR $included==0))
{
 $var['id']=$_GET['v2'];
 $sql_verif=sql_replace($sql['member']['verif_group'],$var);
 $sql_sup=sql_replace($sql['member']['sup_group'],$var);
 $sql_sup_right=sql_replace($sql['member']['sup_group_right'],$var);
 $sgbd = sql_connect();


 if(in_array($var['id'],array('1','2','3','4'))) {
 	$page['erreur'][$nb_erreur]['message']=$lang['member']['E_cant_delete_default_group']; $nb_erreur++;
 }
  
 # verification
 if(sql_num_rows(sql_query($sql_verif))!="0") { $page['erreur'][$nb_erreur]['message']=$lang['member']['E_exist_group_member']; $nb_erreur++; }
 
 if($nb_erreur==0)
 {
  if(sql_query($sql_sup) != false) { 
  	sql_query($sql_sup_right); // we delete also the corresponding rights
  	$page['L_message']=$lang['member']['form_group_sup_1'];
  }
  else { $page['L_message']=$lang['member']['form_group_sup_0']; }
  
 }
 sql_close($sgbd);
}

# case of add or edit
if($right_user['group_list'] AND isset($_POST) AND !empty($_POST) AND (!isset($included) OR $included==0))
{
 # we format datas
 if(isset($_POST['name'])) $_POST['name']=format_txt($_POST['name']);
 if(isset($_POST['description'])) $_POST['description']=format_txt($_POST['description']);

 # we check datas
 if(!isset($_POST['name']) OR empty($_POST['name'])) { $page['erreur'][$nb_erreur]['message']=$lang['member']['E_empty_name_group']; $nb_erreur++; }
 else
 {
  # we check if it does not already exist
   $sgbd = sql_connect();
   $sql_verif = sql_replace($sql['member']['verif_presence_group'],$_POST);
   $res_verif = sql_query($sql_verif);
   $nb_res = sql_num_rows($res_verif);
   sql_free_result($res_verif);
   sql_close($sgbd);
   if($nb_res!="0") { $page['erreur'][$nb_erreur]['message']=$lang['member']['E_exist_group']; $nb_erreur++; }
 }
 
 # there is no error in submited datas
 if($nb_erreur==0)
 {
  # case : new item to add
  if(!isset($_POST['id']) OR empty($_POST['id']))
  {
   $sql_add=sql_replace($sql['member']['insert_group'],$_POST);
   $sgbd = sql_connect();
   if(sql_query($sql_add) != false) { $page['L_message']=$lang['member']['form_group_add_1']; }
   else { $page['L_message']=$lang['member']['form_group_add_0']; }
   sql_close($sgbd);
  }
  # case : item to modify
  else
  {
   $sql_modification=sql_replace($sql['member']['edit_group'],$_POST);
   $sgbd = sql_connect();
   if(sql_query($sql_modification) != false) { $page['L_message']=$lang['member']['form_group_edit_1']; }
   else { $page['L_message']=$lang['member']['form_group_edit_0']; }
   sql_close($sgbd);
  }
 }
 else
 {
  # there is some errors: we show the datas again
  if(isset($_POST['id'])) $page['value_id']=$_POST['id'];
  if(isset($_POST['name'])) $page['value_name']=$_POST['name'];
  if(isset($_POST['description'])) $page['value_description']=$_POST['description'];
 }
}


# listes des groupes
$sql_liste=$sql['member']['select_group'];
$sgbd = sql_connect();
$res_liste = sql_query($sql_liste);
$i="0";
while($ligne = sql_fetch_array($res_liste))
{
 $page['group'][$i]['id']=$ligne['group_id'];
 $page['group'][$i]['name']=$ligne['group_name'];
 $page['group'][$i]['description']=$ligne['group_description'];
 
 $page['group'][$i]['selected']='';
 $page['group'][$i]['checked']='';
 if(isset($page['value_member_group']) AND $page['value_member_group']==$ligne['group_id']) {
 	$page['group'][$i]['selected']='selected';
 	$page['group'][$i]['checked']='checked="checked"';
 }
 
 $page['group'][$i]['form_action']=convert_url("index.php?r=".$lang['general']['idurl_member']."&v1=group_list");
 $page['group'][$i]['link_edit']=convert_url("index.php?r=".$lang['general']['idurl_member']."&v1=form_group&v2=".$ligne['group_id']);
  $page['group'][$i]['link_delete']=convert_url("index.php?r=".$lang['general']['idurl_member']."&v1=group_list&v2=".$ligne['group_id']."&v3=delete");
  $page['group'][$i]['L_edit']=$lang['member']['edit'];
  $page['group'][$i]['L_delete']=$lang['member']['delete'];
 $i++;
}
sql_free_result($res_liste);
sql_close($sgbd);

# link
$page['link_right_management']='';
if($right_user['right_management']) { 
	$page['link_right_management']=convert_url("index.php?r=".$lang['general']['idurl_admin']."&v1=right-management");
}

# text
if(!isset($included) OR $included==0) {
	$page['L_title']=$lang['member']['group_list'];
	$page['L_liste']=$lang['member']['group_list'];
	$page['L_add']=$lang['member']['add_group'];
	$page['L_submit']=$lang['member']['submit'];
	$page['L_erreur']=$lang['general']['E_erreur'];
	$page['L_field_required']=$lang['general']['field_required'];
	$page['L_name']=$lang['member']['name'];
	$page['L_description']=$lang['member']['description'];
	
	$page['L_right_management']=$lang['member']['right_management'];
	
	$page['meta_title']=$lang['member']['group_list'];
	$page['template']=$tpl['member']['group_list'];
}
?>