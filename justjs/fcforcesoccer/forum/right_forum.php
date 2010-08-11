<?php
# we define the rights available for forums
include_once(create_path("forum/lg_forum_".LANG.".php"));

$right['forum']=array(
array('id'=>'forum_list','name'=>$lang['forum']['forum_list'],'default'=>1),
array('id'=>'add_forum','name'=>$lang['forum']['add_forum'],'default'=>0),
array('id'=>'edit_forum','name'=>$lang['forum']['edit_forum'],'default'=>0),
array('id'=>'delete_forum','name'=>$lang['forum']['delete_forum'],'default'=>0),
array('id'=>'edit_message','name'=>$lang['forum']['edit_message'],'default'=>0),
array('id'=>'delete_message','name'=>$lang['forum']['delete_message'],'default'=>0)
);

?>