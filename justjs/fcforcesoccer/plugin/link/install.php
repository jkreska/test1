<?php
# plugin installation

$page['show_form']=""; # by default we do not show the installation form

$page['L_message']="";
$page['erreur']=array();;
$nb_erreur=0;
$nb_message=0;

if(isset($_POST['install']) AND $_POST['install']==1)
{
 # we try to create the database table(s)
 $filename=$plugin_root."/bdd.txt";
 if ($fd = fopen($filename, "r"))
 {
  $sql_install="";
  $var['nb_table_ok']=0;
  $var['nb_table_pbm']=0;
  $nb_table=0;
  $db = sql_connect();
  while (!feof($fd))
  {
   $ligne=fgets ($fd, 4096);
   $sql_install.=$ligne;
 
   if(eregi(";",$ligne))
   {
     $sql_install=eregi_replace(";","",$sql_install);
     if(sql_query($sql_install)) { $var['nb_table_ok']++; }   
     else { $var['nb_table_pbm']++; } 
     $sql_install="";  
     $nb_table++;
   }
  }  
  @fclose ($fd);
   
  if($var['nb_table_pbm'] != 0) { 
   $page['erreur'][$nb_erreur]['message']=$lang['link']['E_install_plugin'];
   $nb_erreur++; 
  }
 }
 
 # we activate the plugin
 # $plugin_install (in conf.php file) must be set to 1
 if($nb_erreur==0)
 {
  $file_conf=$plugin_root."\conf.php";
  $install=0;
  $ligne=file($file_conf);
  $nb_ligne=sizeof($ligne);
  for($i=0;$i<$nb_ligne;$i++)
  {
    if($install==0 AND eregi("plugin_install",$ligne[$i])) { $ligne[$i]=eregi_replace("0","1",$ligne[$i]);  $install=1; }
	if($install==1 AND eregi("plugin_active",$ligne[$i])) { $ligne[$i]=eregi_replace("0","1",$ligne[$i]); }
  }
  $ligne=implode("",$ligne); 
 
  if($install==1)
  { 
   @chmod($file_conf, 0777);
   if ($fd = @fopen($file_conf, "w"))
   {
    // création du fichier
    @fwrite($fd, $ligne);
    @fclose($fd);
   }
   @chmod($file_conf, 0755);  
  } 

  if($install == 0) { 
    $page['erreur'][$nb_erreur]['message']=$lang['link']['E_install_plugin'];
    $nb_erreur++; 
  }
  else
  {
   $page['L_message']=$lang['link']['install_plugin_ok']; 
   $nb_message++;
  }
 }
}
else
{
 # we ask if the user want to install the plugin
 $page['show_form']="1";

}

# text 
$page['L_title']=$lang['link']['installation'];
$page['L_install_plugin']=$lang['link']['install_plugin'];
$page['L_yes']=$lang['general']['yes'];
$page['L_no']=$lang['general']['no'];
$page['L_submit']=$lang['general']['submit'];
$page['form_action']=convert_url("index.php?r=".$plugin_idurl."&v1=install");
$page['L_erreur']=$lang['general']['E_erreur'];

$page['template']=$tpl['link']['install'];

?>