<?php
# we define the rights available for match
include_once(create_path("match/lg_match_".LANG.".php"));

$right['match']=array(
array('id'=>'view_match','name'=>$lang['match']['view_match'],'default'=>1),
array('id'=>'match_list','name'=>$lang['match']['match_list'],'default'=>1),
array('id'=>'add_match','name'=>$lang['match']['add_match'],'default'=>0),
array('id'=>'edit_match','name'=>$lang['match']['edit_match'],'default'=>0),
array('id'=>'delete_match','name'=>$lang['match']['delete_match'],'default'=>0),
array('id'=>'import_match','name'=>$lang['match']['import_match'],'default'=>0),
array('id'=>'action_list','name'=>$lang['match']['action_list'],'default'=>0),
array('id'=>'field_state_list','name'=>$lang['match']['field_state_list'],'default'=>0),
array('id'=>'period_list','name'=>$lang['match']['period_list'],'default'=>0),
array('id'=>'weather_list','name'=>$lang['match']['weather_list'],'default'=>0),
array('id'=>'standings','name'=>$lang['match']['standings'],'default'=>1),
array('id'=>'stats_player','name'=>$lang['match']['stats_player'],'default'=>1),
array('id'=>'stats_list','name'=>$lang['match']['stats_list'],'default'=>0),
array('id'=>'stats_player_list','name'=>$lang['match']['stats_player_list'],'default'=>0)
);

?>