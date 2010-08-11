<?php
# we define the rights available for informations
include_once(create_path("information/lg_information_".LANG.".php"));

$right['information']=array(
array('id'=>'view_information','name'=>$lang['information']['view_page'],'default'=>1),
array('id'=>'information_list','name'=>$lang['information']['page_list'],'default'=>1),
array('id'=>'add_information','name'=>$lang['information']['add_page'],'default'=>0),
array('id'=>'edit_information','name'=>$lang['information']['edit_page'],'default'=>0),
array('id'=>'delete_information','name'=>$lang['information']['delete_page'],'default'=>0)
);

?>