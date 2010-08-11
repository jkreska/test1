<?php
# installation : step 3
$nb_erreur="0";
$page['erreur']=array();
$page['form_action']="index.php?lg=".LANG."&r=step3";
$page['form_action_connection']="../index.php?r=".$lang['general']['idurl_member']."&v1=login";

$nb_message="0";
$page['message']=array();

$page['L_create_base']="";
$page['L_delete_table']="";
$page['L_installation_terminee']="";

if(!isset($_SESSION['host']) OR empty($_SESSION['host']))
{
 header("location:index.php?r=step2");
 exit();
}

# gestion des erreurs ignorees
if(isset($_POST['erreur']) AND !empty($_POST['erreur'])) {
 $_SESSION[$_POST['erreur']]=$_POST['action'];
}

# on regarde si la base de donnee existe, sinon on tente de la cree
$db = mysql_pconnect($_SESSION['host'],$_SESSION['user_base'],$_SESSION['pass_base']);
if(!mysql_select_db($_SESSION['name_base'],$db))
{
 if(isset($_POST['create_base']) AND $_POST['create_base']==1)
 {
  $req_creation="CREATE DATABASE `".$_SESSION['name_base']."` ";
  if(mysql_query($req_creation)) { $page['message'][$nb_message]['message']=$lang['installation']['creation_base_ok']; $nb_message++; 
  $_SESSION['creation_base']=1;
  }
  else { $page['erreur'][$nb_erreur]['message']=$lang['installation']['E_creation_base']; $nb_erreur++; 
  $page['value_erreur']="creation_base";
  }
 }
 else
 {
  # on propose de creer la base
  $page['L_create_base']=text_replace($lang['installation']['create_base'],$_SESSION);
 } 
}
else
{
 $page['message'][$nb_message]['message']=text_replace($lang['installation']['base_found'],$_SESSION);
 $nb_message++;
 $_SESSION['creation_base']=1;
}

# la base a ete trouvee ou creee, on continue
if(isset($_SESSION['creation_base']) AND $_SESSION['creation_base']==1 AND (!isset($_SESSION['table']) OR $_SESSION['table']!=1))
{
 # on verifie qu'il n'y a pas deja de tables installees
 $req_table=" SHOW TABLES";
 $res_table=mysql_query($req_table,$db);
 if($res_table!=false) $nb_table=mysql_num_rows($res_table);
 else $nb_table=0;
 
 if($nb_table!=0) {
  if(isset($_POST['delete_table']) AND $_POST['delete_table']=="1") 
  {
   # on delete les tables
   while($ligne_table=mysql_fetch_array($res_table)) {
   $liste_table[]="`".$ligne_table['0']."`";
   }
   $req_delete_table="DROP TABLE  ".implode(", ",$liste_table)." ";
   
   if(mysql_query($req_delete_table,$db)) { $page['message'][$nb_message]['message']=$lang['installation']['suppression_table_ok']; $nb_message++; 
   $_SESSION['table']=1;
   }
  else { $page['erreur'][$nb_erreur]['message']=$lang['installation']['E_suppression_table']." ".mysql_error($db)." "; $nb_erreur++; 
  }
   
  }
  elseif(isset($_POST['delete_table']) AND $_POST['delete_table']=="0")
  {
   # on ne delete pas les tables (????)
   $_SESSION['table']=1;
  }
  else
  { 
   # on propose de delete les tables existantes
   $var['nb_table']=$nb_table;
   $page['L_delete_table']=text_replace($lang['installation']['delete_table'],$var);
  } 
 }
 else
 {
  $_SESSION['table']=1;  
 }

}

// on cree les tables
if(isset($_SESSION['table']) AND $_SESSION['table']==1 AND (!isset($_SESSION['creation_table']) OR $_SESSION['creation_table']!=1))
{
  $filename="bdd.txt";
  if ($fd = fopen($filename, "r"))
  {
   $req_creation_table="";
   $var['name_table']="";
   $var['nb_table_ok']=0;
   $var['nb_table_pbm']=0;
   $nb_table=0;
   $db = mysql_pconnect($_SESSION['host'],$_SESSION['user_base'],$_SESSION['pass_base']);
   mysql_select_db($_SESSION['name_base'],$db);
   while (!feof($fd))
   {
    $ligne=fgets ($fd, 4096);
    $req_creation_table.=$ligne;
	if(eregi("CREATE TABLE",$ligne) OR eregi("INSERT INTO",$ligne)) { 
		$var['name_table']=explode("`",$ligne); 
		$var['name_table']=$var['name_table']['1'];
	}
 
    if(eregi(";",$ligne))
    {
      $req_creation_table=eregi_replace(";","",$req_creation_table);
	  # we add the prefix if needed
	  if($_SESSION['prefix']!='') {
		  $req_creation_table=eregi_replace("`".$var['name_table']."`","`".$_SESSION['prefix'].$var['name_table']."`",$req_creation_table);
		  $var['name_table']=$_SESSION['prefix'].$var['name_table'];
	  }
      if(mysql_query($req_creation_table)) { $var['nb_table_ok']++; }
	  else { $var['nb_table_pbm']++; } 
      $req_creation_table="";
	  $nb_table++;
    }
   }
   @fclose ($fd);
   
   if($var['nb_table_ok'] != 0) { $page['message'][$nb_message]['message']=text_replace($lang['installation']['creation_table_ok'],$var); $nb_message++; }
   if($var['nb_table_pbm'] != 0) { $page['erreur'][$nb_erreur]['message']=text_replace($lang['installation']['E_creation_table'],$var); $nb_erreur++; 
   $page['value_erreur']="creation_table";
   }
   
   if($nb_table!=0 AND $var['nb_table_ok']==$nb_table) { $_SESSION['creation_table']=1; }
  }
}

if(isset($_SESSION['creation_table']) AND $_SESSION['creation_table']==1) {
$page['message'][$nb_message]['message']=$lang['installation']['creation_tables_ok']; $nb_message++; 
}

# creation de l'user
if(isset($_SESSION['creation_table']) AND $_SESSION['creation_table']==1 AND (!isset($_SESSION['creation_user']) OR $_SESSION['creation_user']!=1))
{
 
 $req_creation_user="INSERT INTO `".$_SESSION['prefix']."member` (member_id,member_lastname,member_firstname,member_login,member_pass,member_valid,member_status) VALUES ('1','".$_SESSION['name_admin']."','".$_SESSION['firstname_admin']."','".$_SESSION['user_admin']."','".$_SESSION['pass_admin']."','1','4')";
 
   if(mysql_query($req_creation_user,$db)) { 
    $_SESSION['creation_user']=1;
   }
  else { 
   $page['erreur'][$nb_erreur]['message']=$lang['installation']['E_creation_user']." ".mysql_error($db)." "; $nb_erreur++; 
   $page['value_erreur']="creation_user";
   } 
}

if(isset($_SESSION['creation_user']) AND $_SESSION['creation_user']==1) {
 $page['message'][$nb_message]['message']=$lang['installation']['creation_user_ok']; $nb_message++; 
}

# insertion du club par defaut
if($_SESSION['mode']!="club")
{
 $_SESSION['club']="0";
}
elseif(isset($_SESSION['creation_table']) AND $_SESSION['creation_table']==1 AND (!isset($_SESSION['creation_club']) OR $_SESSION['creation_club']!=1))
{
 $req_creation_club="INSERT INTO `".$_SESSION['prefix']."club` (club_id,club_name) VALUES ('1','".$_SESSION['club_name']."')";
 
   if(mysql_query($req_creation_club,$db)) { 
    $_SESSION['creation_club']=1;
	$_SESSION['club']="1";
   }
  else { 
   $page['erreur'][$nb_erreur]['message']=$lang['installation']['E_creation_club']." ".mysql_error($db)." "; $nb_erreur++; 
   $page['value_erreur']="creation_club";
   } 
}

if(isset($_SESSION['creation_club']) AND $_SESSION['creation_club']==1) {
 $page['message'][$nb_message]['message']=$lang['installation']['creation_club_ok']; $nb_message++; 
}

# creation du fichier de configuration
if(isset($_SESSION['creation_user']) AND $_SESSION['creation_user']==1 AND (!isset($_SESSION['creation_conf']) OR $_SESSION['creation_conf']!=1))
{
 $fichier_conf="conf.txt";
 $fichier_conf_site="../include/conf.php";
 $_SESSION['lang']=$_GET['lg'];
 $_SESSION['version']=VERSION;
 $_SESSION['max_file_size']=return_bytes(ini_get('post_max_size'));
 $_SESSION['avatar_folder']="avatar";
 $_SESSION['template']="defaut";
 $_SESSION['nb_player']=$lang['installation']['nb_player_'.$_SESSION['sport']];
 $_SESSION['sender_name']=$_SESSION['title'];
 $contenu_conf=implode("",file($fichier_conf));
 $contenu_conf=text_replace($contenu_conf,$_SESSION);

  @chmod("../include/", 0777);
  @chmod($fichier_conf_site, 0777);
  if ($fd = @fopen($fichier_conf_site, "w"))
  {
   // création du fichier de connection
   @fwrite($fd, $contenu_conf);
   @fclose($fd);
   $_SESSION['creation_conf']=1;
  }
  else
  {
   $page['erreur'][$nb_erreur]['message']=$lang['installation']['E_creation_conf']; $nb_erreur++; 
   $page['value_erreur']="creation_conf";
  }
  @chmod($fichier_conf_site, 0755);  
  @chmod("../include/", 0755);
}

if(isset($_SESSION['creation_conf']) AND $_SESSION['creation_conf']==1) {
$page['message'][$nb_message]['message']=$lang['installation']['creation_conf_ok']; $nb_message++; 
}

# on insere les donnees pour le sport choisi
if(isset($_SESSION['creation_conf']) AND $_SESSION['creation_conf']==1 AND (!isset($_SESSION['insertion_data']) OR $_SESSION['insertion_data']!=1))
{
 $fichier_donnees="donnees_".$_SESSION['sport'].".txt";
 $contenu_donnees=implode("",file($fichier_donnees));
 $contenu_donnees=text_replace($contenu_donnees,$lang['installation']);
 
 $req_insertion_data=explode(";",$contenu_donnees);
 $nb_req_insertion_data=sizeof($req_insertion_data);
 $nb_req_ok=0;
 $nb_req_pbm=0;
 for($i=0; $i<$nb_req_insertion_data-1; $i++) {

	if($_SESSION['prefix']!='') {
		$var['name_table']=explode("`",$req_insertion_data[$i]); 
		$var['name_table']=$var['name_table']['1'];
		$req_insertion_data[$i]=eregi_replace("`".$var['name_table']."`","`".$_SESSION['prefix'].$var['name_table']."`",$req_insertion_data[$i]);		
	}
 	
	if(mysql_query($req_insertion_data[$i],$db)) { $nb_req_ok++; }
	else { $nb_req_pbm++; }
 }
 
 if($nb_req_ok==$nb_req_insertion_data-1) {
  $_SESSION['insertion_data']=1;
 }
 else
 {
   $page['erreur'][$nb_erreur]['message']=$lang['installation']['E_insertion_data']; $nb_erreur++;  
   $page['value_erreur']="insertion_data";
 }
}

if(isset($_SESSION['insertion_data']) AND $_SESSION['insertion_data']==1) {
  $page['message'][$nb_message]['message']=$lang['installation']['insertion_data_ok']; $nb_message++;  
}

# creation du fichier .htaccess
if(isset($_SESSION['url_rewrite']) AND $_SESSION['url_rewrite']==1 AND (!isset($_SESSION['creation_htaccess']) OR $_SESSION['creation_htaccess']!=1)) {
 $fichier_htaccess="htaccess.txt";
 $fichier_htaccess_site="../.htaccess";
 $contenu_htaccess=implode("",file($fichier_htaccess));

  @chmod($fichier_htaccess_site, 0777);
  if ($fd = @fopen($fichier_htaccess_site, "w"))
  {
   // création du fichier de connection
   @fwrite($fd, $contenu_htaccess);
   @fclose($fd);
   $_SESSION['creation_htaccess']=1;   
  }
  else
  {
   $page['erreur'][$nb_erreur]['message']=$lang['installation']['E_creation_htaccess']; $nb_erreur++; 
   $page['value_erreur']="creation_htaccess";
  }
  @chmod($fichier_htaccess_site, 0755);
}

if(isset($_SESSION['creation_htaccess']) AND $_SESSION['creation_htaccess']==1) {
  $page['message'][$nb_message]['message']=$lang['installation']['creation_htaccess_ok']; $nb_message++;  
}
 
if(isset($_SESSION['creation_table']) AND $_SESSION['creation_table']==1 AND isset($_SESSION['creation_user']) AND $_SESSION['creation_user']==1 AND isset($_SESSION['creation_conf']) AND $_SESSION['creation_conf']==1 AND isset($_SESSION['insertion_data']) AND $_SESSION['insertion_data']==1) {
 $page['L_installation_terminee']=$lang['installation']['installation_terminee'];
 
 unset($_SESSION['lang']);
}

if($nb_erreur!=0) { $page['aff_erreur']="1"; }
else { $page['aff_erreur']=""; }

$page['L_installation']=$lang['installation']['installation'];
$page['L_step']=$lang['installation']['step'];
$page['nb_step']="3";

$page['L_yes']=$lang['installation']['yes'];
$page['L_no']=$lang['installation']['no'];

$page['L_login']=$lang['installation']['login'];
$page['L_pass']=$lang['installation']['password'];
$page['L_connecter']=$lang['installation']['connecter'];
$page['L_connection']=$lang['installation']['connection'];
$page['L_try_again']=$lang['installation']['try_again'];
$page['L_ignore']=$lang['installation']['ignore'];

$page['L_erreur']=$lang['installation']['erreur'];
$page['L_continue']=$lang['installation']['continue'];

$page['template']="tpl/step3.html";

?>