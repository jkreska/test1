<?php

/***************************/
# MENU ADMIN
/***************************/

$index['link_admin_home']='';
$index['link_admin']='';
$index['link_admin_configuration']='';

if($right_user['home']) $index['link_admin_home']=convert_url("index.php?r=".$lang['general']['idurl_admin']);
if($right_user['admin']) $index['link_admin']=convert_url("index.php?r=".$lang['general']['idurl_admin']."&v1=admin");
if($right_user['configuration']) $index['link_admin_configuration']=convert_url("index.php?r=".$lang['general']['idurl_admin']."&v1=configuration");


# text
$index['L_administration']=$lang['general']['administration'];
$index['L_admin_home']=$lang['general']['admin_home'];
$index['L_admin']=$lang['general']['admin'];
$index['L_configuration']=$lang['general']['configuration'];

?>