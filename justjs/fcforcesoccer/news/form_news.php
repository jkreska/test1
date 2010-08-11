<?php
/* formulaire des newss */

$page=array();
$page['value_id']="";


$nb_erreur=0;
$page['template']="";
$page['value_id']="";
$page['value_idurl']="";
$page['value_subhead']="";
$page['value_title']="";
$page['value_subtitle']="";
$page['value_summary']="";
$page['value_text']="";
$page['value_ps']="";
$page['value_keyword']="";
$page['value_release']=convert_date(date('Y-m-d'),$lang['news']['format_date_form']);
$page['value_release_time']=date('H:i');
$page['value_lang']="";
$page['value_news_traduction']="";
$page['value_sport']="";
$page['value_url']="";
$page['value_status']="";

$page['L_message']="";
$page['erreur']=array();

if($right_user['add_news'] OR $right_user['edit_news']) {
	$page['show_form']=1; 
}
else {
	$page['show_form']='';
	$page['L_message']=$lang['general']['acces_reserve_admin'];
}


if(isset($_GET['v2']) AND $_GET['v2']!="") { $page['value_id']=$_GET['v2']; }

$page['form_action']=convert_url("index.php?r=".$lang['general']['idurl_news']."&v1=form_news&v2=".$page['value_id']);
$page['link_image']=convert_url("index.php?r=".$lang['general']['idurl_file']."&v1=image_manager&fen=pop");

/* modification ou add */
if(isset($_POST['submit']) AND !empty($_POST['submit']))
{
 
 /* we format datas */
 if(isset($_POST['subhead'])) $_POST['subhead']=format_txt($_POST['subhead']);
 if(isset($_POST['idurl'])) $_POST['idurl']=format_txt($_POST['idurl']);
 if(isset($_POST['title'])) $_POST['title']=format_txt($_POST['title']);
 if(isset($_POST['subtitle'])) $_POST['subtitle']=format_txt($_POST['subtitle']);
 if(isset($_POST['keyword'])) $_POST['keyword']=format_txt($_POST['keyword']);
 if(isset($_POST['summary'])) $_POST['summary']=addslashes($_POST['summary']);
 if(isset($_POST['text'])) $_POST['text']=addslashes($_POST['text']);
 if(isset($_POST['ps'])) $_POST['ps']=format_txt($_POST['ps']);
  
 /* verification des infos */
 if(!isset($_POST['status']) OR $_POST['status']=="") { $page['erreur'][$nb_erreur]['message']=$lang['news']['E_empty_status']; $nb_erreur++; }
  if(!isset($_POST['title']) OR $_POST['title']=="") { $page['erreur'][$nb_erreur]['message']=$lang['news']['E_empty_title']; $nb_erreur++; }
 if(!isset($_POST['idurl']) OR $_POST['idurl']=="") { $page['erreur'][$nb_erreur]['message']=$lang['news']['E_empty_idurl']; $nb_erreur++; }
 else # we check if it does not already exist
 {
   $sgbd = sql_connect();
   $sql_verif_news = sql_replace($sql['news']['verif_news'],$_POST);
   $res = sql_query($sql_verif_news);
   $nb_res = sql_num_rows($res);
   sql_free_result($res);
   sql_close($sgbd);
   if($nb_res!="0") { $page['erreur'][$nb_erreur]['message']=$lang['news']['E_exist_news']; $nb_erreur++; }
 }

 if(!isset($_POST['summary']) OR $_POST['summary']=="") { $page['erreur'][$nb_erreur]['message']=$lang['news']['E_empty_summary']; $nb_erreur++; }
 if(!isset($_POST['text']) OR $_POST['text']=="") { $page['erreur'][$nb_erreur]['message']=$lang['news']['E_empty_text']; $nb_erreur++; }


 /* date */
 if(!isset($_POST['release']) OR $_POST['release']=="") { $page['erreur'][$nb_erreur]['message']=$lang['news']['E_empty_release']; $nb_erreur++; }
 elseif(!check_date($_POST['release'])) { $page['erreur'][$nb_erreur]['message']=$lang['news']['E_invalid_release']; $nb_erreur++; }

 if(isset($_POST['release_time']) AND !empty($_POST['release_time']) AND !check_hour($_POST['release_time'])) { $page['erreur'][$nb_erreur]['message']=$lang['news']['E_invalid_release_time']; $nb_erreur++; }

 $_POST['member']=$_SESSION['session_member_id'];

 if($nb_erreur==0)
 {
  if(empty($_POST['release_time'])) $_POST['release_time']='00:00';
  
  $_POST['release']=convert_date_sql($_POST['release']);
  $_POST['release'].=" ".$_POST['release_time'];
 
  /* cas d'un premier add */
  if(empty($_POST['id']) AND $right_user['add_news'])
  {
   $sgbd = sql_connect();
   $sql_add = sql_replace($sql['news']['insert_news'],$_POST);
   if(sql_query($sql_add) != false) { $page['L_message']=$lang['news']['form_news_add_1']; }
   else { $page['L_message']=$lang['news']['form_news_add_0']; }
   $page['value_id']=sql_insert_id($sgbd);
   sql_close($sgbd);
  }
  /* cas d'une mise a day */
  elseif($right_user['edit_news'])
  {
   $sql_edit=sql_replace($sql['news']['edit_news'],$_POST);
   $sgbd = sql_connect();
   if(sql_query($sql_edit) != false) { $page['L_message']=$lang['news']['form_news_edit_1']; }
   else { $page['L_message']=$lang['news']['form_news_edit_0']; }
   sql_close($sgbd);
  }
 }
 /* on affiche les erreurs et on reaffiche le formulaire */
 else
 {
 $page['value_id']=$_POST['id'];
 $page['value_idurl']=$_POST['idurl'];
 $page['value_subhead']=$_POST['subhead'];
 $page['value_title']=$_POST['title'];
 $page['value_subtitle']=$_POST['subtitle'];
 $page['value_summary']=stripslashes($_POST['summary']);
 $page['value_text']=stripslashes($_POST['text']);
 $page['value_ps']=$_POST['ps'];
 $page['value_keyword']=$_POST['keyword'];
 $page['value_release']=$_POST['release'];
 $page['value_release_time']=$_POST['release_time'];
 $page['value_status']=$_POST['status'];
 }
}


if(isset($page['value_id']) AND $page['value_id']!="" AND $nb_erreur==0)
{
 /* on recupere les infos sur le news */
 $var['id']=$page['value_id'];
 $sql_details=sql_replace($sql['news']['select_news_details'],$var);

 $sgbd = sql_connect();
 $res = sql_query($sql_details);
 $ligne = sql_fetch_array($res);
 sql_free_result($res);
 sql_close($sgbd);

 $page['value_idurl']=$ligne['news_idurl'];
 $page['value_subhead']=$ligne['news_subhead'];
 $page['value_title']=$ligne['news_title'];
 $page['value_subtitle']=$ligne['news_subtitle'];
 $page['value_summary']=$ligne['news_summary'];
 $page['value_summary']=stripslashes($ligne['news_summary']);
 $page['value_text']=$ligne['news_text'];
 $page['value_text']=stripslashes($ligne['news_text']);
 $page['value_ps']=$ligne['news_ps'];
 $page['value_keyword']=$ligne['news_keyword'];
 $page['value_status']=$ligne['news_status'];
 $page['value_release']=convert_date($ligne['news_release'],$lang['news']['format_date_form']);
 $page['value_release_time']=convert_date($ligne['news_release'],$lang['news']['format_time_form']);
 if($page['value_release_time']=='00:00') $page['value_release_time']='';
}



/* status */
$page['status']['0']['id']="0";
$page['status']['0']['name']=$lang['news']['supprime'];
$page['status']['0']['selected']="";
$page['status']['1']['id']="1";
$page['status']['1']['name']=$lang['news']['en_attente'];
$page['status']['1']['selected']="";
$page['status']['2']['id']="2";
$page['status']['2']['name']=$lang['news']['valid'];
$page['status']['2']['selected']="";

if($page['value_status']=="0") { $page['status']['0']['selected']="selected"; }
elseif($page['value_status']=="1") { $page['status']['1']['selected']="selected"; }
elseif($page['value_status']=="2") { $page['status']['2']['selected']="selected"; }
/* end status */


# links
if($right_user['delete_news'] AND !empty($page['value_id']))
{
 $page['link_delete']=convert_url("index.php?r=".$lang['general']['idurl_news']."&v1=news_list&v2=delete&v3=".$page['value_id']);
}
else
{
 $page['link_delete']="";
}
 $page['link_list']=convert_url("index.php?r=".$lang['general']['idurl_news']."&v1=news_list");

# text
$page['L_idurl']=$lang['news']['idurl'];
$page['L_subhead']=$lang['news']['subhead'];
$page['L_title_news']=$lang['news']['title'];
$page['L_subtitle']=$lang['news']['subtitle'];
$page['L_summary']=$lang['news']['summary'];
$page['L_text']=$lang['news']['text'];
$page['L_ps']=$lang['news']['ps'];
$page['L_keyword']=$lang['news']['keyword'];
$page['L_release']=$lang['news']['date_release'];
$page['L_format_date']=$lang['news']['format_date'];
$page['L_release_time']=$lang['news']['time_release'];
$page['L_format_time']=$lang['news']['format_time'];
$page['L_idurl_auto']=$lang['news']['idurl_auto'];


/* elements de text */
if(empty($page['value_id'])) { $page['L_title']=$lang['news']['form_news_add']; }
else { $page['L_title']=$lang['news']['form_news_edit']; }


$page['L_valider']=$lang['news']['submit'];
$page['L_delete']=$lang['news']['delete']; 
$page['L_back_list']=$lang['news']['back_list']; 

$page['L_status']=$lang['news']['status'];
$page['L_choose_status']=$lang['news']['choose_status'];
$page['L_erreur']=$lang['general']['E_erreur'];
$page['L_field_required']=$lang['general']['field_required'];

$page['lang']=LANG;
$page['meta_title']=$page['L_title'];
$page['meta_url']=ROOT_URL;
$page['meta_charset']=$lang['general']['charset'];

$page['template']=$tpl['news']['form_news'];

?>