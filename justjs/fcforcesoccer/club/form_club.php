<?php
##################################
# club 
##################################

# variables
$page['L_message']="";
$page['form_action']=convert_url("index.php?r=".$lang['general']['idurl_club']."&v1=form_club");

$nb_erreur="0";
$page['erreur']=array();
$page['club']=array();
$page['pop']="";

# form values
$page['value_id']="";
$page['value_name']="";
$page['value_abbreviation']="";
$page['value_address']="";
$page['value_logo']="";
$page['value_color']="";
$page['value_color_alternative']="";
$page['value_telephone']="";
$page['value_fax']="";
$page['value_email']="";
$page['value_url']="";
$page['value_creation_year']="";
$page['value_comment']="";

# si l'identifiant du club est passe dans l'url (modification), on le recupere
if(isset($_GET['v2']) AND $_GET['v2']!="") { $page['value_id']=$_GET['v2']; }
elseif(isset($_POST['id']) AND $_POST['id']!="") { $page['value_id']=$_POST['id']; }


if($right_user['add_club'] OR $right_user['edit_club']) {
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
 if(isset($_POST['name'])) $_POST['name']=format_txt($_POST['name']);
 if(isset($_POST['abbreviation'])) $_POST['abbreviation']=format_txt($_POST['abbreviation']);
 if(isset($_POST['logo'])) $_POST['logo']=format_txt($_POST['logo']);
 if(isset($_POST['address'])) $_POST['address']=format_txt($_POST['address']);
 if(isset($_POST['color'])) $_POST['color']=format_txt($_POST['color']);
 if(isset($_POST['color_alternative'])) $_POST['color_alternative']=format_txt($_POST['color_alternative']);
 if(isset($_POST['telephone'])) $_POST['telephone']=format_txt($_POST['telephone']);
 if(isset($_POST['fax'])) $_POST['fax']=format_txt($_POST['fax']);
 if(isset($_POST['email'])) $_POST['email']=format_txt($_POST['email']);
 if(isset($_POST['url'])) $_POST['url']=format_txt($_POST['url']);
 if(isset($_POST['creation_year'])) $_POST['creation_year']=format_txt($_POST['creation_year']);
 if(isset($_POST['comment'])) $_POST['comment']=format_txt($_POST['comment']); 

 # we check datas
 if(!isset($_POST['name']) OR $_POST['name']=="") { $page['erreur'][$nb_erreur]['message']=$lang['club']['E_empty_club_name']; $nb_erreur++; }
 else
 {
  # we check if it does not already exist
   $sgbd = sql_connect();
   $sql_verif = sql_replace($sql['club']['verif_presence_club'],$_POST);
   $res_verif = sql_query($sql_verif);
   $nb_res = sql_num_rows($res_verif);
   sql_free_result($res_verif);
   sql_close($sgbd);
   if($nb_res!="0") { $page['erreur'][$nb_erreur]['message']=$lang['club']['E_exist_club']; $nb_erreur++; }
 }
 
 if(isset($_POST['logo']) AND !empty($_POST['logo']) AND !check_url($_POST['logo'])) { $page['erreur'][$nb_erreur]['message']=$lang['club']['E_invalid_logo_club']; $nb_erreur++; }
 
 if(isset($_POST['creation_year']) AND !empty($_POST['creation_year']) AND !check_date("01-01-".$_POST['creation_year'])) { $page['erreur'][$nb_erreur]['message']=$lang['club']['E_invalid_creation_year_club']; $nb_erreur++; }
 
 if(isset($_POST['email']) AND !empty($_POST['email']) AND !check_email($_POST['email'])) { $page['erreur'][$nb_erreur]['message']=$lang['club']['E_invalid_email_club']; $nb_erreur++; }
 if(isset($_POST['url']) AND !empty($_POST['url']) AND !check_url($_POST['url'])) { $page['erreur'][$nb_erreur]['message']=$lang['club']['E_invalid_url_club']; $nb_erreur++; }
 

 # there is no error in submited datas
 if($nb_erreur==0)
 {
  if(!isset($_POST['creation_year']) OR empty($_POST['creation_year'])) $_POST['creation_year']="NULL";
  
  # case : new item to add
  if(!isset($_POST['id']) OR empty($_POST['id']) AND $right_user['add_club'])
  {
   $sql_add=sql_replace($sql['club']['insert_club'],$_POST);
   $sgbd = sql_connect();
   $execution=sql_query($sql_add);
   if($execution) { $page['L_message']=$lang['club']['form_club_add_1']; }
   else { $page['L_message']=$lang['club']['form_club_add_0']; }   
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
  elseif($right_user['edit_club'])
  {
   $sql_modification=sql_replace($sql['club']['edit_club'],$_POST);
   $sgbd = sql_connect();
   if(sql_query($sql_modification) != false) { $page['L_message']=$lang['club']['form_club_edit_1']; }
   else { $page['L_message']=$lang['club']['form_club_edit_0']; }
   sql_close($sgbd);
  }
 }
 else
 {
  # there are some errors: we show the data again
  if(isset($_POST['id'])) $page['value_id']=$_POST['id'];
  if(isset($_POST['name'])) $page['value_name']=$_POST['name'];
  if(isset($_POST['abbreviation'])) $page['value_abbreviation']=$_POST['abbreviation'];
  if(isset($_POST['logo'])) $page['value_logo']=$_POST['logo'];
  if(isset($_POST['address'])) $page['value_address']=$_POST['address'];
  if(isset($_POST['color'])) $page['value_color']=$_POST['color'];
  if(isset($_POST['color_alternative'])) $page['value_color_alternative']=$_POST['color_alternative'];
  if(isset($_POST['telephone'])) $page['value_telephone']=$_POST['telephone'];
  if(isset($_POST['fax'])) $page['value_fax']=$_POST['fax'];
  if(isset($_POST['email'])) $page['value_email']=$_POST['email'];
  if(isset($_POST['url'])) $page['value_url']=$_POST['url'];
  if(isset($_POST['creation_year'])) $page['value_creation_year']=$_POST['creation_year'];
  if(isset($_POST['comment'])) $page['value_comment']=$_POST['comment'];
 }
}

# if the ID is known, we get the datas to show them in the form
if(isset($page['value_id']) AND $page['value_id']!="" AND $nb_erreur==0)
{
 # we get the item information
 $var['id']=$page['value_id'];
 $sql_details=sql_replace($sql['club']['select_club_details'],$var);

 $sgbd = sql_connect();
 $res = sql_query($sql_details);
 $ligne = sql_fetch_array($res);
 sql_free_result($res);
 sql_close($sgbd);

 $page['value_id']=$ligne['club_id'];
 $page['value_name']=$ligne['club_name'];
 $page['value_abbreviation']=$ligne['club_abbreviation'];
 $page['value_logo']=$ligne['club_logo'];
 $page['value_address']=$ligne['club_address'];
 $page['value_color']=$ligne['club_color'];
 $page['value_color_alternative']=$ligne['club_color_alternative'];
 $page['value_telephone']=$ligne['club_telephone'];
 $page['value_fax']=$ligne['club_fax'];
 $page['value_email']=$ligne['club_email'];
 $page['value_url']=$ligne['club_url'];
 $page['value_creation_year']=$ligne['club_creation_year'];
 $page['value_comment']=$ligne['club_comment'];
}

# links
if($right_user['delete_club'] AND !empty($page['value_id']))
{
 $page['link_delete']=convert_url("index.php?r=".$lang['general']['idurl_club']."&v1=club_list&v2=delete&v3=".$page['value_id']);
}
else
{
 $page['link_delete']="";
}
$page['link_list']=convert_url("index.php?r=".$lang['general']['idurl_club']."&v1=club_list");
$page['link_choose_image']=convert_url("index.php?r=".$lang['general']['idurl_file']."&v1=image_manager&parent_form=form_club&field_name=logo&file_type=image&fen=pop",0);


# text
if(empty($page['value_id'])) { $page['L_title']=$lang['club']['form_club_add']; }
else { $page['L_title']=$lang['club']['form_club_edit']; }
$page['L_valider']=$lang['club']['submit'];
$page['L_delete']=$lang['club']['delete'];
$page['L_back_list']=$lang['club']['back_list']; 
$page['L_erreur']=$lang['general']['E_erreur'];
$page['L_field_required']=$lang['general']['field_required'];

$page['L_name']=$lang['club']['name'];
$page['L_abbreviation']=$lang['club']['abbreviation'];
$page['L_creation_year']=$lang['club']['creation_year'];
$page['L_color']=$lang['club']['color'];
$page['L_color_alternative']=$lang['club']['color_alternative'];
$page['L_address']=$lang['club']['address'];
$page['L_telephone']=$lang['club']['telephone'];
$page['L_fax']=$lang['club']['fax'];
$page['L_email']=$lang['club']['email'];
$page['L_url']=$lang['club']['url'];
$page['L_comment']=$lang['club']['comment'];
$page['L_format_year']=$lang['club']['format_year'];

$page['L_logo']=$lang['club']['logo'];
$page['L_choose_image']=$lang['club']['choose_image'];

$page['meta_title']=$page['L_title'];
$page['template']=$tpl['club']['form_club'];
?>