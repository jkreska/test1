<?php
# installation : welcome
$nb_erreur="0";
$page['erreur']=array();
$page['form_action']="index.php?lg=".LANG."&r=welcome";
$page['link_retour']="index.php";

if(isset($_POST) AND !empty($_POST))
{
/* if(!isset($_POST['accepter']) OR $_POST['accepter']=="") { $page['erreur'][$nb_erreur]['message']=$lang['installation']['E_empty_accepter_reglement']; $nb_erreur++; }
*/ 
 if($nb_erreur==0)
 {
  header("location:index.php?lg=".LANG."&r=licence");
  exit();
 }
}

$page['L_installation']=$lang['installation']['installation'];
$page['L_welcome']=$lang['installation']['welcome'];
$page['L_welcome_text']=$lang['installation']['welcome_text'];

$page['L_start_installation']=$lang['installation']['start_installation'];
$page['L_retour']=$lang['installation']['back'];

$page['L_erreur']=$lang['installation']['erreur'];

$page['template']="tpl/welcome.html";

?>
