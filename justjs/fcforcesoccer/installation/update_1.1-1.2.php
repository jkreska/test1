<?php
# mise a jour de la version 1.1 a 1.2
# - Standings
# - Player stats
# - Competition and round management
# - Image/file manager


# la mise a jour se fait en plusieurs etapes:
# 1. l'utilisateur doit sauvegarder son fichier include/conf.php en local
# 2. suppression des fichiers du serveur
# 3. ajout des nouveaux fichiers
# 4. copie du fichier include/conf.php
# 5. Assistant de mise a jour


# base de donnees
$filename="update_1.1-1.2.txt";
$content=implode("",file($filename));
$content=text_replace($content,$lang['installation']);
$req_insertion_data=explode(";",$content);
$nb_req_insertion_data=sizeof($req_insertion_data);
$var['nb_table_ok']=0;
$var['nb_table_pbm']=0;
$nb_table=0;
$db = sql_connect();
for($i=0; $i<$nb_req_insertion_data-1; $i++) {
 if(sql_query($req_insertion_data[$i])) { $var['nb_table_ok']++; }   
 else { $var['nb_table_pbm']++; } 
 $sql_update_database="";  
 $nb_table++;
}

if($var['nb_table_pbm'] != 0) { 
 $page['erreur'][$nb_erreur]['message']=$lang['installation']['E_update_database'];
 $nb_erreur++; 
}
else
{
 $page['message'][$nb_message]['message']=$lang['installation']['update_database_ok']; 
 $nb_message++;
}



# creation of .htaccess file
if(URL_REWRITE==1)
{
 $fichier_htaccess="htaccess.txt";
 $fichier_htaccess_site="../.htaccess";
 $contenu_htaccess=implode("",file($fichier_htaccess));

 @chmod($fichier_htaccess_site, 0777);
 if ($fd = @fopen($fichier_htaccess_site, "w"))
 {
  // création du fichier
  @fwrite($fd, $contenu_htaccess);
  @fclose($fd);
  $_SESSION['creation_htaccess']=1;  
 }
 else
 {
  $page['erreur'][$nb_erreur]['message']=$lang['installation']['E_creation_htaccess'];
  $nb_erreur++;
 }
 @chmod($fichier_htaccess_site, 0755); 
}

# creation of the new file conf.php
if($nb_erreur==0)
{
 $fichier_conf="conf.txt";
 $fichier_conf_site="../include/conf.php";
 $var['root']=ROOT;
 $var['url']=ROOT_URL; 
 $var['title']=SITE_TITLE;
 $var['club']=CLUB;
 $var['host']=SGBD_HOST;
 $var['user_base']=SGBD_USER;
 $var['pass_base']=SGBD_PWD;
 $var['name_base']=SGBD_NAME;
 $var['version']=VERSION_SITE;
 $var['max_file_size']=MAX_FILE_SIZE;
 $var['url_rewrite']=URL_REWRITE;
 $var['email']=SENDER_EMAIL;
 $var['sender_name']=SENDER_NAME;
 $var['nb_player']=NB_MAX_PLAYER;
 $var['template']="defaut";
 $var['avatar_folder']="avatar";
 #$var['site_open']=SITE_OUVERT;
 $var['lang']=LANG;

 $contenu_conf=implode("",file($fichier_conf));
 $contenu_conf=text_replace($contenu_conf,$var); 

 @chmod("../include/", 0777);
 @chmod($fichier_conf_site, 0777);
 if ($fd = @fopen($fichier_conf_site, "w"))
 {
  // mise a jour du fichier de connection
  @fwrite($fd, $contenu_conf);
  @fclose($fd);
  @chmod($fichier_conf_site, 0755);  
  @chmod("../include/", 0755);
  $page['message'][$nb_message]['message']=$lang['installation']['update_conf_ok'];
  $nb_message++;
 }
 else
 {
  $page['erreur'][$nb_erreur]['message']=$lang['installation']['E_update_conf'];
  $nb_erreur++; 
 }
}

?>