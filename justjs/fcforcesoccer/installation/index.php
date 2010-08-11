<?php
# installation
define("VERSION_SITE","1.4"); # version de l'installation
$lang_supportee=array('fr','en');
$sport_supporte=array('football','rugby','basket','other_sport');


$type_installation="";

# create the path of a file
if(!function_exists('create_path')) {
	function create_path($file) {
		# we check if a customize file exists	
		if(file_exists(ROOT."/my_code/".$file)) {
			return ROOT."/my_code/".$file;
		}
		else {
			return ROOT."/".$file;
		}	
	}
}

if(file_exists("../include/conf.php"))
{
 # il s'agit d'une mise a jour
 $type_installation="update";
 include_once("../include/conf.php"); 
 
 if(!defined("ROOT")) define("ROOT","../");
 if(!defined("ROOT_URL")) define("ROOT_URL",".");
 if(!defined("LANG")) define("LANG","en"); 
 if(!defined("TPL_DOSSIER")) define("TPL_DOSSIER","defaut");
 if(!defined("SGBD_PREFIX")) define("SGBD_PREFIX","");
 
 include_once(create_path("installation/lg_installation_".LANG.".php"));
 include_once(create_path("include/lg_general_".LANG.".php"));  
}
else
{
 # c'est la premire installation
 $type_installation="installation";
 define("ROOT","../");
 define("ROOT_URL","");
 define("TPL_DOSSIER","defaut");
 define("URL_REWRITE",0); 
 define("VERSION",VERSION_SITE); 
 define("SGBD_PREFIX","");
 
 if(isset($_GET['lg']) AND in_array($_GET['lg'],$lang_supportee))
 {
  define("LANG",$_GET['lg']);
  include_once("lg_installation_".LANG.".php");
  include_once("../include/lg_general_".LANG.".php");
 }
 elseif(isset($_GET['r']) AND $_GET['r']!="home")
 {
  header("location:index.php");
  exit();
 }
}

include_once("../include/form.php");
include_once("../include/sgbd.php");
include_once("../include/fonction.php");
include_once("../include/template.php");

session_start();


if(isset($_GET['r']) AND $_GET['r']!="")
{
 switch($_GET['r']) {  
  case "home" : include_once("home.php"); break;
  case "welcome" : include_once("welcome.php"); break;
  case "licence" : include_once("licence.php"); break;
  case "verification" : include_once("verification.php"); break;
  case "step1" : include_once("step1.php"); break;
  case "step2" : include_once("step2.php"); break;
  case "step3" : include_once("step3.php"); break;
  case "message" : include_once("message.php"); break;
  case "update" : include_once("update.php"); break;  
  default : include_once("home.php");
  }
}
else
{
 include_once("lg_installation_fr.php");
 include_once("../include/lg_general_fr.php");
 if($type_installation=="update")  include_once("update.php"); 
 else include_once("home.php");
}

$index['version']=VERSION;

# text
$index['L_realisation']=$lang['general']['realisation'];
$index['L_version']=$lang['general']['version'];
if($type_installation=="update") { $index['L_installation']=$lang['installation']['update']; }
else { $index['L_installation']=$lang['installation']['installation']; } 


$index['contenu']=parse_template($page['template'],$page);

echo parse_template("tpl/index.html",$index);

?>