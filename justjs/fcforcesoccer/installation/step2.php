<?php
# installation : step 2
$nb_erreur="0";
$page['erreur']=array();
$page['form_action']="index.php?lg=".LANG."&r=step2";
$page['link_retour']="index.php?lg=".LANG."&r=step1";

$page['value_title']=$_SESSION['club_name'];
$page['value_url']="http://".$_SERVER["HTTP_HOST"].$_SERVER["PHP_SELF"];
$page['value_url']=eregi_replace("/installation/index.php","",$page['value_url']);
$page['value_root']="";
if(isset($_SERVER['DOCUMENT_ROOT'])) {
 $page['value_root']=$_SERVER['DOCUMENT_ROOT'].$_SERVER["PHP_SELF"];
 $page['value_root']=eregi_replace("/installation/index.php","",$page['value_root']);
 $page['value_root']=eregi_replace("program files","PROGRA~1",$page['value_root']);
}
$page['value_email']="";
$page['value_host']=$_SERVER['SERVER_NAME'];
$page['value_user_base']="";
$page['value_name_base']="";
$page['value_prefix']="pms_";
$page['value_user_admin']="";
$page['value_name_admin']="";
$page['value_firstname_admin']="";
$page['value_url_rewrite']="";

if(isset($_SESSION['title'])) $page['value_title']=$_SESSION['title'];
if(isset($_SESSION['url'])) $page['value_url']=$_SESSION['url'];
if(isset($_SESSION['root'])) $page['value_root']=$_SESSION['root'];
if(isset($_SESSION['email'])) $page['value_email']=$_SESSION['email'];
if(isset($_SESSION['host'])) $page['value_host']=$_SESSION['host'];
if(isset($_SESSION['user_base'])) $page['value_user_base']=$_SESSION['user_base'];
if(isset($_SESSION['name_base'])) $page['value_name_base']=$_SESSION['name_base'];
if(isset($_SESSION['prefix'])) $page['value_prefix']=$_SESSION['prefix'];
if(isset($_SESSION['user_admin'])) $page['value_user_admin']=$_SESSION['user_admin'];
if(isset($_SESSION['name_admin'])) $page['value_name_admin']=$_SESSION['name_admin'];
if(isset($_SESSION['firstname_admin'])) $page['value_firstname_admin']=$_SESSION['firstname_admin'];
if(isset($_SESSION['url_rewrite'])) $page['value_url_rewrite']=$_SESSION['url_rewrite'];


if(!isset($_SESSION['mode']) OR !isset($_SESSION['sport']) OR empty($_SESSION['mode']) OR empty($_SESSION['sport']))
{
 header("location:index.php?lg=".LANG."&r=step1");
 exit();
}

if(isset($_POST) AND !empty($_POST))
{
 if(!isset($_POST['title']) OR $_POST['title']=="") { $page['erreur'][$nb_erreur]['message']=$lang['installation']['E_empty_title']; $nb_erreur++; }
 if(!isset($_POST['url']) OR $_POST['url']=="") { $page['erreur'][$nb_erreur]['message']=$lang['installation']['E_empty_url']; $nb_erreur++; }
// elseif(!@fopen($_POST['url'],"r")) { $page['erreur'][$nb_erreur]['message']=$lang['installation']['E_invalid_url']; $nb_erreur++; }
 
 if(!isset($_POST['root']) OR $_POST['root']=="") { $page['erreur'][$nb_erreur]['message']=$lang['installation']['E_empty_root']; $nb_erreur++; }
 //elseif(!file_exists($_POST['root']."/index.php")) { $page['erreur'][$nb_erreur]['message']=$lang['installation']['E_invalid_root']; $nb_erreur++; }
 if(isset($_POST['email']) AND !empty($_POST['email']) AND !check_email($_POST['email'])) { $page['erreur'][$nb_erreur]['message']=$lang['installation']['E_invalid_email']; $nb_erreur++; }
  
 if(!isset($_POST['host']) OR $_POST['host']=="") { $page['erreur'][$nb_erreur]['message']=$lang['installation']['E_empty_host']; $nb_erreur++; }  
 if(!isset($_POST['user_base']) OR $_POST['user_base']=="") { $page['erreur'][$nb_erreur]['message']=$lang['installation']['E_empty_user_base']; $nb_erreur++; } 
 if(!isset($_POST['name_base']) OR $_POST['name_base']=="") { $page['erreur'][$nb_erreur]['message']=$lang['installation']['E_empty_name_base']; $nb_erreur++; }   
 if(!isset($_POST['user_admin']) OR $_POST['user_admin']=="") { $page['erreur'][$nb_erreur]['message']=$lang['installation']['E_empty_user_admin']; $nb_erreur++; } 
 
 if(!isset($_POST['pass_admin']) OR $_POST['pass_admin']=="") { $page['erreur'][$nb_erreur]['message']=$lang['installation']['E_empty_pass_admin']; $nb_erreur++;  }
 if(!isset($_POST['pass_2_admin']) OR $_POST['pass_2_admin']=="") { $page['erreur'][$nb_erreur]['message']=$lang['installation']['E_empty_pass_2_admin']; $nb_erreur++; }
 if($_POST['pass_admin']!=$_POST['pass_2_admin']) { $page['erreur'][$nb_erreur]['message']=$lang['installation']['E_invalid_pass_admin']; $nb_erreur++;  }
 
 # on essaie de se connecter au serveur
 if(!@mysql_connect($_POST['host'],$_POST['user_base'],$_POST['pass_base'])) { $page['erreur'][$nb_erreur]['message']=$lang['installation']['E_invalid_connection_base']; $nb_erreur++;  }

 
 if($nb_erreur==0)
 {
  $_SESSION['title']=$_POST['title'];
  $_SESSION['url']=$_POST['url'];
  $_SESSION['root']=$_POST['root'];
  $_SESSION['email']=$_POST['email'];
  $_SESSION['host']=$_POST['host'];
  $_SESSION['user_base']=$_POST['user_base'];
  $_SESSION['pass_base']=$_POST['pass_base'];
  $_SESSION['name_base']=$_POST['name_base'];
  $_SESSION['prefix']=$_POST['prefix'];
  $_SESSION['user_admin']=$_POST['user_admin'];
  $_SESSION['name_admin']=$_POST['name_admin'];
  $_SESSION['firstname_admin']=$_POST['firstname_admin'];
  $_SESSION['pass_admin']=md5($_POST['pass_admin']);
  $_SESSION['url_rewrite']=$_POST['url_rewrite'];
  
  header("location:index.php?lg=".LANG."&r=step3");
  exit();
 }
 else
 {
  if(isset($_POST['title'])) $page['value_title']=$_POST['title'];
  if(isset($_POST['url'])) $page['value_url']=$_POST['url'];
  if(isset($_POST['root'])) $page['value_root']=$_POST['root'];
  if(isset($_POST['email'])) $page['value_email']=$_POST['email'];
  if(isset($_POST['host'])) $page['value_host']=$_POST['host'];
  if(isset($_POST['user_base'])) $page['value_user_base']=$_POST['user_base'];
  if(isset($_POST['name_base'])) $page['value_name_base']=$_POST['name_base'];
  if(isset($_POST['prefix'])) $page['value_name_base']=$_POST['prefix'];
  if(isset($_POST['user_admin'])) $page['value_user_admin']=$_POST['user_admin'];
  if(isset($_POST['name_admin'])) $page['value_name_admin']=$_POST['name_admin'];
  if(isset($_POST['firstname_admin'])) $page['value_firstname_admin']=$_POST['firstname_admin'];
  if(isset($_POST['url_rewrite'])) $page['value_url_rewrite']=$_POST['url_rewrite']; 
 }
}

# url_rewrite
$page['checked_url_rewrite_yes']="";
$page['checked_url_rewrite_no']="";
if(isset($page['value_url_rewrite']) AND $page['value_url_rewrite']==0) { $page['checked_url_rewrite_no']="checked=\"checked\""; }
else { $page['checked_url_rewrite_yes']="checked=\"checked\""; }

$page['aff_url_rewrite']="1";
// on verifie que le mod_rewrite est active
//if(in_array("mod_rewrite",get_apache_modules())) { $page['aff_url_rewrite']=1; }

$page['L_installation']=$lang['installation']['installation'];
$page['L_step']=$lang['installation']['step'];
$page['nb_step']="2";

$page['L_mode']=$lang['installation']['mode'];
$page['mode']=$lang['installation']['mode_'.$_SESSION['mode']];

$page['L_sport']=$lang['installation']['sport'];
$page['sport']=$lang['installation'][$_SESSION['sport']];

$page['L_information_site']=$lang['installation']['information_site'];
$page['L_title']=$lang['installation']['title'];
$page['L_url']=$lang['installation']['url'];
$page['L_info_url']=$lang['installation']['info_url'];
$page['L_root']=$lang['installation']['root'];
$page['L_email']=$lang['installation']['email'];
$page['L_information_base']=$lang['installation']['information_base'];
$page['L_host']=$lang['installation']['host'];
$page['L_user']=$lang['installation']['user'];
$page['L_mot_de_passe']=$lang['installation']['password'];
$page['L_base']=$lang['installation']['base'];
$page['L_prefix']=$lang['installation']['prefix'];
$page['L_information_admin']=$lang['installation']['information_admin'];
$page['L_login']=$lang['installation']['login'];
$page['L_name']=$lang['installation']['name'];
$page['L_firstname']=$lang['installation']['firstname'];
$page['L_confirmation']=$lang['installation']['confirmation'];
$page['L_info_url']=$lang['installation']['info_url'];
$page['L_url_rewrite']=$lang['installation']['url_rewrite'];
$page['L_info_url_rewrite']=$lang['installation']['info_url_rewrite'];
$page['L_yes']=$lang['installation']['yes'];
$page['L_no']=$lang['installation']['no'];

$page['L_example']=$lang['installation']['example'];
$page['L_example_title']=$lang['installation']['example_title'];
$page['L_example_url']=$lang['installation']['example_url'];
$page['L_example_root']=$lang['installation']['example_root'];
$page['L_example_email']=$lang['installation']['example_email'];
$page['L_example_host']=$lang['installation']['example_host'];
$page['L_example_user']=$lang['installation']['example_user'];
$page['L_example_base']=$lang['installation']['example_base'];
$page['L_example_prefix']=$lang['installation']['example_prefix'];

$page['L_erreur']=$lang['installation']['erreur'];
$page['L_continue']=$lang['installation']['continue'];
$page['L_retour']=$lang['installation']['back'];

$page['template']="tpl/step2.html";

?>
