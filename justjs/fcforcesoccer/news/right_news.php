<?php
# we define the rights available for news
include_once(create_path("news/lg_news_".LANG.".php"));

$right['news']=array(
array('id'=>'view_news','name'=>$lang['news']['view_news'],'default'=>1),
array('id'=>'news_list','name'=>$lang['news']['news_list'],'default'=>1),
array('id'=>'add_news','name'=>$lang['news']['add_news'],'default'=>0),
array('id'=>'edit_news','name'=>$lang['news']['edit_news'],'default'=>0),
array('id'=>'delete_news','name'=>$lang['news']['delete_news'],'default'=>0)
);

?>