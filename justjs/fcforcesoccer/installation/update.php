<?php
# update
$update_list=array('1.0-1.1','1.1-1.2','1.2-1.3','1.3-1.4'); # available updates

$nb_erreur=0;
$page['erreur']=array();
$page['form_action']="index.php?lg=".LANG."&r=update";
$page['L_message']="";

$nb_message="0";
$page['message']=array();

# if we have to do an update
if(isset($_POST['update']) AND in_array($_POST['update'],$update_list))
{
 include("update_".$_POST['update'].".php");
 if($nb_erreur=="0") {
  $var['root_url']=ROOT_URL;
  $page['L_message']=text_replace($lang['installation']['update_ok'],$var);
 }
}

# list of  avaibable updates
$nb_update=sizeof($update_list);
$page['update_list']=array();
$j=0;
for($i=0; $i < $nb_update; $i++)
{
 $version=explode("-", $update_list[$i]);
 $version=$version['0'];
 
 # we show only updates not already done
 if(VERSION_SITE > $version && VERSION_SITE > VERSION && VERSION <= $version) 
 {
  $page['update_list'][$j]['value']=$update_list[$i];
  $page['update_list'][$j]['name']=eregi_replace("-"," => ",$update_list[$i]);
  
  $page['update_list'][$j]['L_update']=$lang['installation']['update'];
  
  # we active only the oldest update
  $j!=0 ? $page['update_list'][$j]['disabled']="disabled=\"disabled\"" : $page['update_list'][$j]['disabled']="";
  
  $j++;
 }
}

# the website is up to date
if($j==0 AND $page['L_message']=="") { $page['L_message']=$lang['installation']['no_update']; }


$page['L_erreur']=$lang['installation']['erreur'];
$page['L_update']=$lang['installation']['update'];
$page['L_available_update']=$lang['installation']['available_update'];
$page['L_submit']=$lang['installation']['submit'];

$page['template']="tpl/update.html";

?>