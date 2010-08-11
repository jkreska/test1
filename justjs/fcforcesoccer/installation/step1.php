<?php
# installation : step 1
$nb_erreur="0";
$page['erreur']=array();
$page['form_action']="index.php?lg=".LANG."&r=step1";
$page['link_retour']="index.php?lg=".LANG."&r=verification";
$page['value_mode']="";
$page['value_club_name']="";
$page['value_sport']="";

if(isset($_SESSION['mode'])) $page['value_mode']=$_SESSION['mode'];
if(isset($_SESSION['club_name'])) $page['value_club_name']=$_SESSION['club_name'];
if(isset($_SESSION['sport'])) $page['value_sport']=$_SESSION['sport'];

if(isset($_POST) AND !empty($_POST))
{
 if(!isset($_POST['mode']) OR $_POST['mode']=="") { $page['erreur'][$nb_erreur]['message']=$lang['installation']['E_empty_mode']; $nb_erreur++; }
 elseif($_POST['mode']=="club" AND (!isset($_POST['club_name']) OR empty($_POST['club_name']))) { $page['erreur'][$nb_erreur]['message']=$lang['installation']['E_empty_club_name']; $nb_erreur++; }
 
 if(!isset($_POST['sport']) OR $_POST['sport']=="") { $page['erreur'][$nb_erreur]['message']=$lang['installation']['E_empty_sport']; $nb_erreur++; } 
 
 if($nb_erreur==0)
 {
  $_SESSION['mode']=$_POST['mode'];
  if(isset($_POST['club_name'])) $_SESSION['club_name']=$_POST['club_name'];
  else $_SESSION['club_name']="";
  $_SESSION['sport']=$_POST['sport'];
  
  header("location:index.php?lg=".LANG."&r=step2");
  exit();
 }
 else
 {
  if(isset($_POST['mode'])) $page['value_mode']=$_POST['mode'];
  if(isset($_POST['club_name'])) $page['value_club_name']=$_POST['club_name'];
  if(isset($_POST['sport'])) $page['value_sport']=$_POST['sport'];
 }
}

# mode
$page['checked_club']="";
$page['checked_comite']="";
$page['style_club_name']="none";

switch($page['value_mode']) {
 case "club" : $page['checked_club']="checked=\"checked\""; $page['style_club_name']="block"; break;
 case "comite" : $page['checked_comite']="checked=\"checked\""; break;
}

# sport
$page['sport']=array();
$nb_sport=sizeof($sport_supporte);
for($i=0; $i < $nb_sport; $i++)
{
 $page['sport'][$i]['value']=$sport_supporte[$i];
 $page['sport'][$i]['title']=$lang['installation'][$sport_supporte[$i]];
 
 if($page['value_sport']==$sport_supporte[$i]) { $page['sport'][$i]['checked']="checked=\"checked\""; }
 else { $page['sport'][$i]['checked']=""; } 
}

$page['L_installation']=$lang['installation']['installation'];
$page['L_step']=$lang['installation']['step'];
$page['nb_step']="1";

$page['L_mode']=$lang['installation']['mode'];
$page['L_mode_club']=$lang['installation']['mode_club'];
$page['L_mode_comite']=$lang['installation']['mode_comite'];
$page['L_club_name']=$lang['installation']['club_name'];

$page['L_sport']=$lang['installation']['sport'];

$page['L_erreur']=$lang['installation']['erreur'];
$page['L_continue']=$lang['installation']['continue'];
$page['L_retour']=$lang['installation']['back'];

$page['template']="tpl/step1.html";

?>
