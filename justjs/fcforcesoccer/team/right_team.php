<?php
# we define the rights available for team
include_once(create_path("team/lg_team_".LANG.".php"));

$right['team']=array(
array('id'=>'view_team','name'=>$lang['team']['view_team'],'default'=>1),
array('id'=>'team_list','name'=>$lang['team']['team_list'],'default'=>1),
array('id'=>'add_team','name'=>$lang['team']['add_team'],'default'=>0),
array('id'=>'edit_team','name'=>$lang['team']['edit_team'],'default'=>0),
array('id'=>'delete_team','name'=>$lang['team']['delete_team'],'default'=>0),
array('id'=>'team_coach_list','name'=>$lang['team']['team_coach_list'],'default'=>1),
array('id'=>'team_player_list','name'=>$lang['team']['team_player_list'],'default'=>1),
array('id'=>'position_list','name'=>$lang['team']['position_list'],'default'=>0),
array('id'=>'team_name_list','name'=>$lang['team']['team_name_list'],'default'=>0)
);

?>