<?php
/* formulaire des pages */

$nb_erreur=0;
$page['template']="";
$page['value_id']="";
$page['value_idurl']="";
$page['value_title']="";
$page['value_summary']="";
$page['value_text']="";
$page['value_keyword']="";
$page['value_status']="";
$page['value_page_parent']="";

$page['L_message']="";
$page['erreur']=array();


if(isset($_GET['v2']) AND $_GET['v2']!="") { $page['value_id']=$_GET['v2']; }

$page['form_action']=convert_url("index.php?r=".$lang['general']['idurl_information']."&v1=form_page&v2=".$page['value_id']);
$page['link_image']=convert_url("index.php?r=".$lang['general']['idurl_admin']."&v1=image_manager&fen=pop");


if($right_user['add_information'] OR $right_user['edit_information']) {
	$page['show_form']=1; 
}
else {
	$page['show_form']='';
	$page['L_message']=$lang['general']['acces_reserve_admin'];
}

/* modification ou add */
if(isset($_POST['submit']) AND !empty($_POST['submit']))
{
 /* we format datas */
 if(isset($_POST['idurl'])) $_POST['idurl']=format_txt($_POST['idurl']);
 if(isset($_POST['title'])) $_POST['title']=format_txt($_POST['title']);
 if(isset($_POST['keyword'])) $_POST['keyword']=format_txt($_POST['keyword']);
 if(isset($_POST['summary'])) $_POST['summary']=addslashes($_POST['summary']);
 if(isset($_POST['text'])) $_POST['text']=addslashes($_POST['text']); 
 
 /* verification des infos */
 if(!isset($_POST['title']) OR $_POST['title']=="") { $page['erreur'][$nb_erreur]['message']=$lang['information']['E_empty_title']; $nb_erreur++; }
 if(!isset($_POST['status']) OR $_POST['status']=="") { $page['erreur'][$nb_erreur]['message']=$lang['information']['E_empty_status']; $nb_erreur++; }
 if(!isset($_POST['idurl']) OR $_POST['idurl']=="") { $page['erreur'][$nb_erreur]['message']=$lang['information']['E_empty_idurl']; $nb_erreur++; }
 else # we check if it does not already exist
 {
   $sgbd = sql_connect();
   $sql_verif_page = sql_replace($sql['information']['verif_page'],$_POST);
   $res = sql_query($sql_verif_page);
   $nb_res = sql_num_rows($res);
   sql_free_result($res);
   sql_close($sgbd);
   if($nb_res!="0") { $page['erreur'][$nb_erreur]['message']=$lang['information']['E_exist_page']; $nb_erreur++; }
 }

 if(!isset($_POST['summary']) OR $_POST['summary']=="") { $page['erreur'][$nb_erreur]['message']=$lang['information']['E_empty_summary']; $nb_erreur++; }
 if(!isset($_POST['text']) OR $_POST['text']=="") { $page['erreur'][$nb_erreur]['message']=$lang['information']['E_empty_text']; $nb_erreur++; }

 $_POST['member']=$_SESSION['session_member_id'];

 if($nb_erreur==0)
 {
  /* cas d'un premier add */
  if(empty($_POST['id']) AND $right_user['add_information'])
  {
   $sgbd = sql_connect();

   /* on recupere l'ordre max */
   $var['id']=$_POST['page_parent'];
   $sql_max=sql_replace($sql['information']['select_page_parent_ordre'],$var);
   $res=sql_query($sql_max);
   $ordre=sql_fetch_array($res);
   sql_free_result($res);
   $_POST['ordre']=$ordre['max']+1;


   $sql_add = sql_replace($sql['information']['insert_page'],$_POST);
   if(sql_query($sql_add) != false) { $page['L_message']=$lang['information']['form_page_add_1']; }
   else { $page['L_message']=$lang['information']['form_page_add_0']; }
   $page['value_id']=sql_insert_id($sgbd);
   sql_close($sgbd);
  }
  /* cas d'une mise a day */
  elseif($right_user['edit_information'])
  {
   $sql_edit=sql_replace($sql['information']['edit_page'],$_POST);
   $sgbd = sql_connect();
   if(sql_query($sql_edit) != false) { $page['L_message']=$lang['information']['form_page_edit_1']; }
   else { $page['L_message']=$lang['information']['form_page_edit_0']; }
   sql_close($sgbd);
  }
 }
 /* on affiche les erreurs et on reaffiche le formulaire */
 else
 {
 $page['value_id']=$_POST['id'];
 $page['value_idurl']=$_POST['idurl'];
 $page['value_title']=$_POST['title'];
 $page['value_summary']=StripSlashes($_POST['summary']);
 $page['value_text']=StripSlashes($_POST['text']);
 $page['value_keyword']=$_POST['keyword'];
 $page['value_status']=$_POST['status'];
 $page['value_page_parent']=$_POST['page_parent'];
 }
}


if(isset($page['value_id']) AND $page['value_id']!="" AND $nb_erreur==0) 
{
 /* on recupere les infos sur la page */
 $var['id']=$page['value_id'];
 $sql_details=sql_replace($sql['information']['select_page_details'],$var);

 $sgbd = sql_connect();
 $res = sql_query($sql_details);
 $ligne = sql_fetch_array($res);
 sql_free_result($res);
 sql_close($sgbd);

 $page['value_idurl']=$ligne['page_idurl'];
 $page['value_title']=$ligne['page_title'];
 // $page['value_summary']=$ligne['page_summary'];
 $page['value_summary']=stripslashes($ligne['page_summary']);
 // $page['value_text']=$ligne['page_text'];
 $page['value_text']=stripslashes($ligne['page_text']);
 $page['value_keyword']=$ligne['page_keyword'];
 $page['value_status']=$ligne['page_status'];
 $page['value_page_parent']=$ligne['page_parent'];
}


/* status */
$page['status']['0']['id']="0";
$page['status']['0']['name']=$lang['information']['private'];
$page['status']['0']['selected']="";
$page['status']['1']['id']="1";
$page['status']['1']['name']=$lang['information']['public'];
$page['status']['1']['selected']="";

if($page['value_status']=="0")
{
 $page['status']['0']['selected']="selected";
}
elseif($page['value_status']=="1")
{
 $page['status']['1']['selected']="selected";
}
/* end status */



/* liste des pages a la root de la hierarchie */
$sgbd = sql_connect();
$var['id']="0";

$res_page_parent = sql_query(sql_replace($sql['information']['select_page_parent'],$var));

$page['page_parent']=array();
$nb_ligne=sql_num_rows($res_page_parent);

if($nb_ligne!="0")
{
 $i="0";
 while($ligne = sql_fetch_array($res_page_parent))
 {
  /* on regarde si ce n'est pas la meme page*/
  if(isset($page['value_id']) AND $page['value_id']!=$ligne['page_id'])
  {
   $page['page_parent'][$i]['id']=$ligne['page_id'];
   $page['page_parent'][$i]['name']=$ligne['page_title'];

   $page['value_page_parent']==$ligne['page_id'] ? $page['page_parent'][$i]['selected']="selected" : $page['page_parent'][$i]['selected']="";
   $i++;
  }
 }
}
sql_free_result($res_page_parent);
sql_close($sgbd);

# links
if($right_user['delete_information'] AND !empty($page['value_id']))
{
$page['link_delete']=convert_url("index.php?r=".$lang['general']['idurl_information']."&v1=page_list&v2=delete&v3=".$page['value_id']);

}
else
{
 $page['link_delete']="";
}
$page['link_list']=convert_url("index.php?r=".$lang['general']['idurl_information']."&v1=page_list");


/* text */
if(empty($page['value_id'])) { $page['L_title']=$lang['information']['form_page_add']; }
else { $page['L_title']=$lang['information']['form_page_edit']; }

$page['L_idurl']=$lang['information']['idurl'];
$page['L_title_page']=$lang['information']['title'];
$page['L_summary']=$lang['information']['summary'];
$page['L_text']=$lang['information']['text'];
$page['L_keyword']=$lang['information']['keyword'];
$page['L_idurl_auto']=$lang['information']['idurl_auto'];
$page['L_page_parent']=$lang['information']['page_parent'];
$page['L_choose_page_parent']=$lang['information']['choose_page_parent'];
$page['L_status']=$lang['information']['status'];
$page['L_choose_status']=$lang['information']['choose_status'];
$page['L_valider']=$lang['information']['submit'];
$page['L_delete']=$lang['information']['delete'];
$page['L_back_list']=$lang['information']['back_list'];

$page['L_erreur']=$lang['general']['E_erreur'];
$page['L_field_required']=$lang['general']['field_required'];

$page['lang']=LANG;
$page['meta_url']=ROOT_URL;
$page['meta_charset']=$lang['general']['charset'];

$page['template']=$tpl['information']['form_page'];

?>