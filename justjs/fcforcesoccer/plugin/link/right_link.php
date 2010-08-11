<?php
# we define the rights available for links
include_once(create_path("link/lg_link_".LANG.".php"));

$right['link']=array(
array('id'=>'link_list','name'=>$lang['link']['link_list'],'default'=>1),
array('id'=>'add_link','name'=>$lang['link']['add_link'],'default'=>0),
array('id'=>'edit_link','name'=>$lang['link']['edit_link'],'default'=>0),
array('id'=>'delete_link','name'=>$lang['link']['delete_link'],'default'=>0),
);

?>