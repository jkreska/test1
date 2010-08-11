<?php
# we define the rights available for fields
include_once(create_path("field/lg_field_".LANG.".php"));

$right['field']=array(
array('id'=>'view_field','name'=>$lang['field']['view_field'],'default'=>1),
array('id'=>'field_list','name'=>$lang['field']['field_list'],'default'=>1),
array('id'=>'add_field','name'=>$lang['field']['add_field'],'default'=>0),
array('id'=>'edit_field','name'=>$lang['field']['edit_field'],'default'=>0),
array('id'=>'delete_field','name'=>$lang['field']['delete_field'],'default'=>0)
);

?>