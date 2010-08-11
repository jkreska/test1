<?php
# we define the rights available for competitions
include_once(create_path("competition/lg_competition_".LANG.".php"));

$right['competition']=array(
array('id'=>'view_competition','name'=>$lang['competition']['view_competition'],'default'=>1),
array('id'=>'competition_list','name'=>$lang['competition']['competition_list'],'default'=>1),
array('id'=>'add_competition','name'=>$lang['competition']['add_competition'],'default'=>0),
array('id'=>'edit_competition','name'=>$lang['competition']['form_competition_edit'],'default'=>0),
array('id'=>'delete_competition','name'=>$lang['competition']['delete_competition'],'default'=>0),
array('id'=>'season_list','name'=>$lang['competition']['season_list'],'default'=>0)
);

?>