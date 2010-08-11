<?php
# Activate the account of a member
# The key has been sent by email

$page['L_message']="";

$page['erreur']=array();
$nb_erreur=0;

if(isset($_GET['v2']) AND $_GET['v2']!="")
{
 $var['key']=$_GET['v2'];
 $var['valid']="1";

 # we check that the key exists in the database
 $sql_verif = sql_replace($sql['member']['select_member_key'],$var);
 $sgbd = sql_connect();
 $res = sql_query($sql_verif);
 $nb_res = sql_num_rows($res);
 $ligne=sql_fetch_array($res);
 if($ligne['member_valid']=="1") 
 {
  # the account is already activated
  $page['L_message']=$lang['member']['activation_done'];
 }
 elseif($nb_res=="1")
 {
  $sql_activer = sql_replace($sql['member']['edit_member_key'],$var);
  if(sql_query($sql_activer)) {
   $page['L_message']=$lang['member']['activation_ok'];
  }
  else {
   $page['erreur'][$nb_erreur]['message']=$lang['member']['activation_pbm'];
  }
 }
 else {
  $page['erreur'][$nb_erreur]['message']=$lang['member']['activation_pbm'];
 }
 sql_close($sgbd);
}
else {
  $page['erreur'][$nb_erreur]['message']=$lang['member']['activation_pbm'];
}

# text
$page['L_title']=$lang['member']['activation'];
$page['L_erreur']=$lang['general']['E_erreur'];

$page['template']=$tpl['general']['message'];
?>