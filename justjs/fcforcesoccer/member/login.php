<?php

/* connection a l'espace member */
$page['erreur']=array();
$page['L_message']="";

$auto_connection=0;

if(isset($_COOKIE['auto_connection']) AND $_COOKIE['auto_connection']==1)
{
 $_POST['cle']=$_COOKIE['cle'];
 $auto_connection=1;
}

if((isset($_POST) AND $_POST!="") OR $auto_connection==1)
{
 $form_invalid=0;
 $nb_erreur="0";
 
 /* we format datas */
 if(isset($_POST['login'])) $_POST['login']=format_txt($_POST['login']);
 if(isset($_POST['pass'])) $_POST['pass']=format_txt($_POST['pass']);
 
 if((!isset($_POST['login']) OR $_POST['login']=="") AND $auto_connection==0) { $form_invalid=1; $page['erreur'][$nb_erreur]['message']=$lang['general']['E_empty_login']; $nb_erreur++; }
 if((!isset($_POST['pass']) OR $_POST['pass']=="") AND $auto_connection==0) { $form_invalid=1; $page['erreur'][$nb_erreur]['message']=$lang['general']['E_empty_pass']; $nb_erreur++; }
 if($form_invalid==0)
 {
  $_POST['pass_md5']=md5($_POST['pass']);
  if($auto_connection==0) {  $sql_verif = sql_replace($sql['member']['select_member_login'],$_POST); }
  else { $sql_verif = sql_replace($sql['member']['select_member_key'],$_POST); }

  $sgbd = sql_connect();
  $res = sql_query($sql_verif);
  $nb_res = sql_num_rows($res);
  $ligne=sql_fetch_array($res);

  if($nb_res=="1") // le member a ete trouve
  {
  /* on regarde s'il est administrateur */
  /* status :
  - -1 : bloque
  - 0 : simple member
  - 1 : administrateur
  - 2 : super admin
  */
  if($ligne['member_status']!="-1")
  {
   $date_day=date("Y-m-d h:m:s");
   $var['member']=$ligne['member_id'];


   /* on enregistre cette nouvelle connection */
   $var['id']=$ligne['member_id'];
   $sql_visit = sql_replace($sql['member']['edit_member_connection'],$var);
   $sgbd = sql_connect();
   $res = sql_query($sql_visit);
   sql_close($sgbd);

   /* on stocke les infos sur le member dans des variables de sessions*/
   $_SESSION['session_login']=$ligne['member_login'];
   $_SESSION['session_member_email']=$ligne['member_email'];
   $_SESSION['session_member_lastname']=$ligne['member_lastname'];
   $_SESSION['session_member_firstname']=$ligne['member_firstname'];
   $_SESSION['session_member_id']=$ligne['member_id'];
   $_SESSION['session_status']=$ligne['member_status'];
   $_SESSION['session_date_connection']=$ligne['member_date_connection'];

   $_SESSION['session_user_right']=array();; // we reinitialize user right
   
   # si l'user a cocher la case se souvenir de mes informations, on cree un cookie
   # ce cookie contient un identifiant unique (login + mot de passe crypte) qui sera analyse lors
   # de la venue du member sur le site
   if(isset($_POST['auto_connection']) AND $_POST['auto_connection']=="1")
   {
    $date_expiration=time()+(30*24*60*60); # le cookie expirera dans 30 days
    $path="/";  # cookie valable sur tout le site
    // setCookie(string $name, string $value, int $expire, string $path, string $domain, int $secure)
    setCookie("auto_connection","1",$date_expiration,$path);
    setCookie("cle",$ligne['member_key_validation'],$date_expiration,$path);
   }

   $url_redirection=convert_url("index.php?r=".$lang['general']['idurl_member'],0);

   header("location:".$url_redirection);
   exit();
  }
  else
  {
   $page['L_message']=$lang['general']['account_blocked'];
  }
 }
 else
 {
  $page['L_message']=$lang['general']['connection_pbm'];
 }
}
else
{
 $page['L_message']=$lang['general']['connection_pbm'];
}
}

# elements de text
$page['L_title']=$lang['general']['pbm_connection'];
$page['L_erreur']=$lang['general']['E_erreur'];
$page['template']=$tpl['general']['message'];

?>