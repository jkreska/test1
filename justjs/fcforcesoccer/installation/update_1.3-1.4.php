<?php
# Update from version 1.3 a 1.4
# - Changes in database
#

# database
$filename="update_1.3-1.4.txt";
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
 $var['prefix']=SGBD_PREFIX;
 $var['version']=VERSION_SITE;
 $var['max_file_size']=MAX_FILE_SIZE;
 $var['url_rewrite']=URL_REWRITE;
 $var['email']=SENDER_EMAIL;
 $var['sender_name']=SENDER_NAME;
 $var['nb_player']=NB_MAX_PLAYER;
 $var['template']=TPL_DOSSIER;
 $var['avatar_folder']=AVATAR_FOLDER;
 $var['lang']=LANG;
 

 $contenu_conf=implode("",file($fichier_conf));
 $contenu_conf=text_replace($contenu_conf,$var); 

 @chmod("../include/", 0777);
 @chmod($fichier_conf_site, 0777);
 if ($fd = @fopen($fichier_conf_site, "w"))
 {  
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