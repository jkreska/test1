<?php
# we define the rights available for administration
include_once(create_path("administration/lg_administration_".LANG.".php"));

$right['administration']=array(
array('id'=>'home','name'=>$lang['administration']['home_administration'],'default'=>0),
array('id'=>'admin','name'=>$lang['administration']['administration_zone'],'default'=>0),
array('id'=>'configuration','name'=>$lang['administration']['configuration'],'default'=>0),
array('id'=>'menu_management','name'=>$lang['administration']['menu_management'],'default'=>0),
array('id'=>'right_management','name'=>$lang['administration']['right_management'],'default'=>0),
array('id'=>'plugin_management','name'=>$lang['administration']['plugin_management'],'default'=>0)
);

?>