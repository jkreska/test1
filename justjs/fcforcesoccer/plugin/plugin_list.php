<?php
# plugin list
$plugin=array();
$plugin_admin=array();
$i=0;

# we look at the directory "plugin" to see if we have some plugins
$rep = ROOT."/plugin/";
$dir = opendir($rep);

while ($f = readdir($dir)) {

 if(is_dir($rep.$f) AND $f!="." AND $f!="..")
 {
  require($rep.$f."/conf.php");  
  $plugin[$i]['name']=$plugin_name;
  $plugin[$i]['idurl']=$plugin_idurl;
  $plugin_list[]=$plugin_idurl;
  $plugin[$i]['root']=$plugin_root;
  $plugin[$i]['lang']=$plugin_lang;
  $plugin[$i]['install']=$plugin_install;
  $plugin[$i]['active']=$plugin_active;  
  $plugin[$i]['link_install']=convert_url("index.php?r=".$plugin_idurl."&v1=install");
  $plugin[$i]['link']=convert_url("index.php?r=".$plugin_idurl);
  $plugin[$i]['class']="";
  $plugin_admin=array_merge($plugin_admin,$plugin_page_admin);
  $i++;
 }
}
closedir($dir);

?>