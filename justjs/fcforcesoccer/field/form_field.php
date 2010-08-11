<?php
##################################
# field 
##################################

# variables
$page['L_message']="";
$page['form_action']=convert_url("index.php?r=".$lang['general']['idurl_field']."&v1=form_field");
$nb_erreur="0";
$page['erreur']=array();
$page['field']=array();

# form values
$page['value_id']="";
$page['value_name']="";
$page['value_address']="";
$page['value_post_code']="";
$page['value_city']="";
$page['value_number_place']="";
$page['value_photo']="";
$page['value_size']="";
$page['pop']="";


if($right_user['add_field'] OR $right_user['edit_field']) {
	$page['show_form']=1; 
}
else {
	$page['show_form']='';
	$page['L_message']=$lang['general']['acces_reserve_admin'];
}

# si l'identifiant du field est passe dans l'url (modification), on le recupere
if(isset($_GET['v2']) AND $_GET['v2']!="") { $page['value_id']=$_GET['v2']; }
elseif(isset($_POST['id']) AND $_POST['id']!="") { $page['value_id']=$_POST['id']; }

# case of add or edit
if(isset($_POST) AND !empty($_POST))
{
 # we format datas
 if(isset($_POST['name'])) $_POST['name']=format_txt($_POST['name']);
 if(isset($_POST['address'])) $_POST['address']=format_txt($_POST['address']);
 if(isset($_POST['post_code'])) $_POST['post_code']=format_txt($_POST['post_code']);
 if(isset($_POST['city'])) $_POST['city']=format_txt($_POST['city']);
 if(isset($_POST['number_place'])) $_POST['number_place']=format_txt($_POST['number_place']);
 if(isset($_POST['size'])) $_POST['size']=format_txt($_POST['size']);

 # we check datas
 if(!isset($_POST['name']) OR $_POST['name']=="") { $page['erreur'][$nb_erreur]['message']=$lang['field']['E_empty_name_field']; $nb_erreur++; }
 else
 {
  # we check if it does not already exist
   $sgbd = sql_connect();
   $sql_verif = sql_replace($sql['field']['verif_presence_field'],$_POST);
   $res_verif = sql_query($sql_verif);
   $nb_res = sql_num_rows($res_verif);
   sql_free_result($res_verif);
   sql_close($sgbd);
   if($nb_res!="0") { $page['erreur'][$nb_erreur]['message']=$lang['field']['E_exist_field']; $nb_erreur++; }
 }
 
 # there is no error in submited datas
 if($nb_erreur==0)
 {
  # case : new item to add
  if(!isset($_POST['id']) OR empty($_POST['id']) AND $right_user['add_field'])
  {
   $sql_add=sql_replace($sql['field']['insert_field'],$_POST);
   $sgbd = sql_connect();
   $execution=sql_query($sql_add);
   if($execution) { $page['L_message']=$lang['field']['form_field_add_1']; }
   else { $page['L_message']=$lang['field']['form_field_add_0']; }
   $page['value_id']=sql_insert_id($sgbd);
   sql_close($sgbd);
   # si l'add vient d'une page pop, c'est que l'on vient d'un autre formulaire.
   # on va donc renvoyer l'information au formulaire parent
   if($execution AND isset($_GET['fen']) AND $_GET['fen']=="pop")
   {
    $page['pop']="1";
	$page['nouveau_text']=$_POST['name'];
	$page['nouveau_id']=$page['value_id'];   
   }
  }
  # case : item to modify
  elseif($right_user['edit_field'])
  {
   $sql_modification=sql_replace($sql['field']['edit_field'],$_POST);
   $sgbd = sql_connect();
   if(sql_query($sql_modification) != false) { $page['L_message']=$lang['field']['form_field_edit_1']; }
   else { $page['L_message']=$lang['field']['form_field_edit_0']; }
   sql_close($sgbd);
  }
 }
 else
 {
  # there is some errors: we show the datas again
  if(isset($_POST['id'])) $page['value_id']=$_POST['id'];
  if(isset($_POST['name'])) $page['value_name']=$_POST['name'];
  if(isset($_POST['address'])) $page['value_address']=$_POST['address'];
  if(isset($_POST['post_code'])) $page['value_post_code']=$_POST['post_code'];
  if(isset($_POST['city'])) $page['value_city']=$_POST['city'];
  if(isset($_POST['number_place'])) $page['value_number_place']=$_POST['number_place'];
  if(isset($_POST['photo'])) $page['value_photo']=$_POST['photo'];
  if(isset($_POST['size'])) $page['value_city']=$_POST['size'];
 }
}

# if the ID is known, we get the datas to show them in the form
if(isset($page['value_id']) AND $page['value_id']!="" AND $nb_erreur==0)
{
 # we get the item information
 $var['id']=$page['value_id'];
 $sql_details=sql_replace($sql['field']['select_field_details'],$var);

 $sgbd = sql_connect();
 $res = sql_query($sql_details);
 $ligne = sql_fetch_array($res);
 sql_free_result($res);
 sql_close($sgbd);

 $page['value_id']=$ligne['field_id'];
 $page['value_name']=$ligne['field_name'];
 $page['value_address']=$ligne['field_address'];
 $page['value_post_code']=$ligne['field_post_code'];
 $page['value_city']=$ligne['field_city'];
 $page['value_number_place']=$ligne['field_number_seat'];
 if($page['value_number_place']==0) $page['value_number_place']="";
 $page['value_photo']=$ligne['field_photo'];
 $page['value_size']=$ligne['field_size'];
}

# links
if($right_user['delete_field'] AND !empty($page['value_id'])) {
	$page['link_delete']=convert_url("index.php?r=".$lang['general']['idurl_field']."&v1=field_list&v2=delete&v3=".$page['value_id']);
}
else {
 $page['link_delete']="";
}
$page['link_list']=convert_url("index.php?r=".$lang['general']['idurl_field']."&v1=field_list");
$page['link_choose_image']=convert_url("index.php?r=".$lang['general']['idurl_file']."&v1=image_manager&parent_form=form_field&field_name=photo&file_type=image&fen=pop",0);

# text
if(empty($page['value_id'])) { $page['L_title']=$lang['field']['form_field_add']; }
else { $page['L_title']=$lang['field']['form_field_edit']; }
$page['L_valider']=$lang['field']['submit'];
$page['L_delete']=$lang['field']['delete'];
$page['L_back_list']=$lang['field']['back_list'];

$page['L_erreur']=$lang['general']['E_erreur'];
$page['L_field_required']=$lang['general']['field_required'];

$page['L_name']=$lang['field']['name'];
$page['L_address']=$lang['field']['address'];
$page['L_post_code']=$lang['field']['post_code'];
$page['L_city']=$lang['field']['city'];
$page['L_number_place']=$lang['field']['number_place'];
$page['L_photo']=$lang['field']['photo'];
$page['L_choose_image']=$lang['field']['choose_image'];
$page['L_size']=$lang['field']['size'];

$page['meta_title']=$page['L_title'];
$page['template']=$tpl['field']['form_field'];
?>