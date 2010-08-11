<?php
# installation : welcome
$nb_erreur="0";
$page['erreur']=array();
$page['form_action']="index.php?lg=".LANG."&r=licence";
$page['link_retour']="index.php?lg=".LANG."&r=welcome";

if(isset($_POST) AND !empty($_POST))
{
/* if(!isset($_POST['accepter']) OR $_POST['accepter']=="") { $page['erreur'][$nb_erreur]['message']=$lang['installation']['E_empty_accepter_reglement']; $nb_erreur++; }
*/ 
 if($nb_erreur==0)
 {
  header("location:index.php?lg=".LANG."&r=verification");
  exit();
 }
}

$page['L_installation']=$lang['installation']['installation'];
$page['L_reglement']=$lang['installation']['reglement'];
$page['L_text_reglement']=$lang['installation']['text_reglement'];

$page['L_erreur']=$lang['installation']['erreur'];
$page['L_continue']=$lang['installation']['continue'];
$page['L_retour']=$lang['installation']['back'];

$page['template']="tpl/licence.html";

?>
