<?php

/* PROFIL des members */
$page=array();
/* information */
$form_login_invalid=0;
$form_pass_invalid=0;
$page['value_id']=$_SESSION['session_member_id'];
$page['form_action_info']=convert_url("index.php?r=".$lang['general']['idurl_member']."&v1=profile");
$page['form_action_pass']=convert_url("index.php?r=".$lang['general']['idurl_member']."&v1=profile");
$page['template']="";
$form_invalid=0;          
$page['erreur']=array();
$page['value_login']="";
$page['value_email']="";
$page['value_name']="";
$page['value_firstname']="";
$page['value_description']="";
$page['value_avatar']="";
$page['L_message']="";
$mode="";

if(isset($_POST['mode']) AND $_POST['mode']=="info")
{
 if(isset($_POST) AND !empty($_POST))
 {
  $_POST['id']=$page['value_id'];
  
  # we format datas 
  $_POST['login']=trim($_POST['login']);
  $_POST['email']=trim($_POST['email']);
  $_POST['description']=format_txt($_POST['description']);  
  $_POST['avatar']=trim($_POST['avatar']);

  /* verification des infos */
  $nb_erreur="0";
  /* 1 - login */
  if(!isset($_POST['login']) OR empty($_POST['login'])) { $form_login_invalid=1; $page['erreur'][$nb_erreur]['message']=$lang['member']['E_empty_login']; $nb_erreur++; }
  elseif(!check_login($_POST['login'])) { $form_login_invalid=1; $page['erreur'][$nb_erreur]['message']=$lang['member']['E_invalid_login']; $nb_erreur++; }
  else
  {
    $sgbd = sql_connect();
    $sql_verif_login = sql_replace($sql['member']['verif_member_login'],$_POST);
    $res = sql_query($sql_verif_login);
    $nb_res = sql_num_rows($res);
    sql_free_result($res);
    sql_close($sgbd);
    if($nb_res!="0") { $form_login_invalid=1; $page['erreur'][$nb_erreur]['message']=$lang['member']['E_choisi_login']; $nb_erreur++; }
  }

  /* 2 - email */
  if(!isset($_POST['email']) OR empty($_POST['email'])) { $form_login_invalid=1; $page['erreur'][$nb_erreur]['message']=$lang['member']['E_empty_email']; $nb_erreur++; }
  elseif(!check_email($_POST['email'])) { $form_login_invalid=1; $page['erreur'][$nb_erreur]['message']=$lang['member']['E_invalid_email']; $nb_erreur++; }
  else
  {
    $sgbd = sql_connect();
    $sql_verif_email = sql_replace($sql['member']['verif_member_email'],$_POST);
    $res = sql_query($sql_verif_email);
    $nb_res = sql_num_rows($res);
    sql_free_result($res);
    sql_close($sgbd);
    if($nb_res!="0") { $form_login_invalid=1; $page['erreur'][$nb_erreur]['message']=$lang['member']['E_choisi_email']; $nb_erreur++; }
  }

  /* 3 - autres */

  if($form_login_invalid==0)
  {
   /* cas d'une mise a day */
   $sql_edit=sql_replace($sql['member']['edit_member_profile'],$_POST);
   $sgbd = sql_connect();
   if(sql_query($sql_edit) != false) { $page['L_message']=$lang['member']['form_member_edit_1']; }
   else { $page['L_message']=$lang['member']['form_member_edit_0']; }
   sql_close($sgbd);
  }
  /* on affiche les erreurs et on reaffiche le formulaire */
  else
  {
   $page['value_login']=$_POST['login'];
   $page['value_email']=$_POST['email'];
   $page['value_description']=$_POST['description'];
   $page['value_avatar']=$_POST['avatar'];
  }
 }

}
elseif(isset($_POST['mode']) AND $_POST['mode']=="pass")
{
 if(isset($_POST) AND !empty($_POST))
 {
  /* verification des infos */
  $nb_erreur="0";

  /* 2 - mots de passe */
  if($_POST['ancien_pass']=="") { $form_pass_invalid=1; $page['erreur'][$nb_erreur]['message']=$lang['member']['E_empty_ancien_pass']; $nb_erreur++; }
  else
  {
   /* on verifie que le mot de passe est correct */
   $var['pass']=md5($_POST['ancien_pass']);
   $var['id']=$page['value_id'];
   $sgbd = sql_connect();
   $sql_verif_pass = sql_replace($sql['member']['verif_member_pass'],$var);
   $res_verif_pass=sql_query($sql_verif_pass);
   $nb_res=sql_num_rows($res_verif_pass);
   if($nb_res!="1") { $form_pass_invalid=1; $page['erreur'][$nb_erreur]['message']=$lang['member']['E_invalid_ancien_pass']; $nb_erreur++; }
   sql_close($sgbd);
  }
  if($_POST['nouveau_pass']=="") { $form_pass_invalid=1; $page['erreur'][$nb_erreur]['message']=$lang['member']['E_empty_nouveau_pass']; $nb_erreur++; }
  elseif($_POST['confirm_pass']=="") { $form_pass_invalid=1; $page['erreur'][$nb_erreur]['message']=$lang['member']['E_empty_confirm_pass']; $nb_erreur++; }
  elseif(check_login($_POST['nouveau_pass'])==false) { $form_pass_invalid=1; $page['erreur'][$nb_erreur]['message']=$lang['member']['E_invalid_pass']; $nb_erreur++; }
  elseif($_POST['nouveau_pass']!=$_POST['confirm_pass']) { $form_pass_invalid=1; $page['erreur'][$nb_erreur]['message']=$lang['member']['E_pass_different']; $nb_erreur++; }

  /* we format datas */
  $_POST['pass_md5']=md5($_POST['nouveau_pass']);
  $_POST['id']=$page['value_id'];

  if($form_pass_invalid==0)
  {
   $sgbd = sql_connect();
   $sql_edit_pass = sql_replace($sql['member']['edit_member_pass'],$_POST);
   if(sql_query($sql_edit_pass) != false)
   {
    $page['L_message']=$lang['member']['form_pass_edit_1'];
   }
   else
   {
    $page['L_message']=$lang['member']['form_pass_edit_0'];
   }
   sql_close($sgbd);
  }
 }
}
/* end traitement */


if(isset($page['value_id']) AND $page['value_id']!="" AND $form_login_invalid==0)
{
 /* on recupere les infos sur le member */
 $var['id']=$page['value_id'];
 $sql_details=sql_replace($sql['member']['select_member_details'],$var);
 $sgbd = sql_connect();
 $res = sql_query($sql_details);
 $ligne = sql_fetch_array($res);
 sql_free_result($res);
 sql_close($sgbd);

 $page['value_login']=$ligne['member_login'];
 $page['value_email']=$ligne['member_email'];
 $page['value_description']=$ligne['member_description'];
 $page['value_avatar']=$ligne['member_avatar'];
}

# link
$page['link_choose_avatar']=convert_url("index.php?r=".$lang['general']['idurl_file']."&v1=image_manager&parent_form=form_information&field_name=avatar&file_type=image&fen=pop&folder=".AVATAR_FOLDER,0);


/* elements de text */
$page['L_login']=$lang['member']['login'];
$page['L_email']=$lang['member']['email'];
$page['L_description']=$lang['member']['description'];
$page['L_avatar']=$lang['member']['avatar'];
$page['L_choose_image']=$lang['member']['choose_image'];
$page['L_member_information']=$lang['member']['information'];

$page['L_form_pass']=$lang['member']['form_pass'];
$page['L_ancien_pass']=$lang['member']['ancien_pass'];
$page['L_nouveau_pass']=$lang['member']['nouveau_pass'];
$page['L_confirm_pass']=$lang['member']['confirm_pass'];

$page['L_valider']=$lang['member']['submit'];
$page['L_erreur']=$lang['general']['E_erreur'];
$page['L_field_required']=$lang['general']['field_required'];


$page['L_title']=$lang['member']['profile'];
$page['template']=$tpl['member']['profile'];
?>