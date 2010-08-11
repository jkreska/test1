<?php

/***************************/
# MENU MEMBER
/***************************/

$index['menu_member']="1";

$index['login']=$_SESSION['session_login'];

$index['link_profile']='';
$index['link_member_home']='';

$index['link_deconnection']=convert_url("index.php?r=".$lang['general']['idurl_member']."&v1=logout",0);
if($right_user['profile']) $index['link_profile']=convert_url("index.php?r=".$lang['general']['idurl_member']."&v1=profile");
if($right_user['home_member']) $index['link_member_home']=convert_url("index.php?r=".$lang['general']['idurl_member']);

/* si la personne est admin, on affiche le link admin */
if($right_user['admin'])
{
 $index['link_admin']=convert_url("index.php?r=".$lang['general']['idurl_admin']);
}
else
{
 $index['link_admin']="";
}

/* texts a afficher */
$index['L_member_home']=$lang['member']['home_member'];
$index['L_deconnection']=$lang['general']['deconnection'];
$index['L_profile']=$lang['general']['profile'];

?>