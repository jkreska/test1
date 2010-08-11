<?php

include_once(create_path("club/lg_club_".LANG.".php"));
include_once(create_path("competition/lg_competition_".LANG.".php"));
include_once(create_path("team/lg_team_".LANG.".php"));
include_once(create_path("field/lg_field_".LANG.".php"));
include_once(create_path("match/lg_match_".LANG.".php"));
include_once(create_path("member/lg_member_".LANG.".php"));
include_once(create_path("news/lg_news_".LANG.".php"));
include_once(create_path("information/lg_information_".LANG.".php"));
include_once(create_path("forum/lg_forum_".LANG.".php"));
include_once(create_path("file/lg_file_".LANG.".php"));


# club
$page['link_club']='';
$page['link_import_club']='';
if($right_user['club_list']) $page['link_club']=convert_url("index.php?r=".$lang['general']['idurl_club']."&v1=club_list");
if($right_user['import_club']) $page['link_import_club']=convert_url("index.php?r=".$lang['general']['idurl_club']."&v1=import_club");
$page['L_club']=$lang['club']['club'];
$page['L_club_list']=$lang['club']['club_list'];
$page['L_import_club']=$lang['club']['import_club'];

# competition
$page['link_competition']='';
$page['link_season']='';
if($right_user['competition_list']) $page['link_competition']=convert_url("index.php?r=".$lang['general']['idurl_competition']."&v1=competition_list");
if($right_user['season_list']) $page['link_season']=convert_url("index.php?r=".$lang['general']['idurl_competition']."&v1=season_list");
$page['L_competition']=$lang['competition']['competition'];
$page['L_competition_list']=$lang['competition']['competition_list'];
$page['L_season_list']=$lang['competition']['season_list'];

# team
$page['link_team']='';
$page['link_position']='';
$page['link_team_name']='';
if($right_user['team_list']) $page['link_team']=convert_url("index.php?r=".$lang['general']['idurl_team']."&v1=team_list");
if($right_user['position_list']) $page['link_position']=convert_url("index.php?r=".$lang['general']['idurl_team']."&v1=position_list");
if($right_user['team_name_list']) $page['link_team_name']=convert_url("index.php?r=".$lang['general']['idurl_team']."&v1=team_name_list");
$page['L_team']=$lang['team']['team'];
$page['L_team_list']=$lang['team']['team_list'];
$page['L_position_list']=$lang['team']['position_list'];
$page['L_team_name_list']=$lang['team']['team_name_list'];

# field
$page['link_field']='';
if($right_user['field_list']) $page['link_field']=convert_url("index.php?r=".$lang['general']['idurl_field']."&v1=field_list");
$page['L_field']=$lang['field']['field'];
$page['L_field_list']=$lang['field']['field_list'];


# match
$page['link_match']='';
$page['link_action']='';
$page['link_field_state']='';
$page['link_weather']='';
$page['link_period']='';
$page['link_stats']='';
$page['link_stats_player']='';
if($right_user['match_list']) $page['link_match']=convert_url("index.php?r=".$lang['general']['idurl_match']."&v1=match_list");
if($right_user['action_list']) $page['link_action']=convert_url("index.php?r=".$lang['general']['idurl_match']."&v1=action_list");
if($right_user['field_state_list']) $page['link_field_state']=convert_url("index.php?r=".$lang['general']['idurl_match']."&v1=field_state_list");
if($right_user['weather_list']) $page['link_weather']=convert_url("index.php?r=".$lang['general']['idurl_match']."&v1=weather_list");
if($right_user['period_list']) $page['link_period']=convert_url("index.php?r=".$lang['general']['idurl_match']."&v1=period_list");
if($right_user['stats_list']) $page['link_stats']=convert_url("index.php?r=".$lang['general']['idurl_match']."&v1=stats_list");
if($right_user['stats_player_list']) $page['link_stats_player']=convert_url("index.php?r=".$lang['general']['idurl_match']."&v1=stats_player_list");
$page['L_match']=$lang['match']['match'];
$page['L_match_list']=$lang['match']['match_list'];
$page['L_action_list']=$lang['match']['action_list'];
$page['L_field_state_list']=$lang['match']['field_state_list'];
$page['L_weather_list']=$lang['match']['weather_list'];
$page['L_period_list']=$lang['match']['period_list'];
$page['L_stats_list']=$lang['match']['stats_list'];
$page['L_stats_player_list']=$lang['match']['stats_player_list'];

# member
$page['link_member']='';
$page['link_sex']='';
$page['link_country']='';
$page['link_level']='';
$page['link_job']='';
$page['link_import_member']='';
$page['link_registration']='';
$page['link_group']='';
$page['link_right_management']='';
if($right_user['member_list']) $page['link_member']=convert_url("index.php?r=".$lang['general']['idurl_member']."&v1=member_list");
if($right_user['sex_list']) $page['link_sex']=convert_url("index.php?r=".$lang['general']['idurl_member']."&v1=sex_list");
if($right_user['country_list']) $page['link_country']=convert_url("index.php?r=".$lang['general']['idurl_member']."&v1=country_list");
if($right_user['level_list']) $page['link_level']=convert_url("index.php?r=".$lang['general']['idurl_member']."&v1=level_list");
if($right_user['job_list']) $page['link_job']=convert_url("index.php?r=".$lang['general']['idurl_member']."&v1=job_list");
if($right_user['import_member']) $page['link_import_member']=convert_url("index.php?r=".$lang['general']['idurl_member']."&v1=import_member");
if($right_user['registration_list']) $page['link_registration']=convert_url("index.php?r=".$lang['general']['idurl_member']."&v1=registration_list");
if($right_user['group_list']) $page['link_group']=convert_url("index.php?r=".$lang['general']['idurl_member']."&v1=group_list");
if($right_user['right_management']) $page['link_right_management']=convert_url("index.php?r=".$lang['general']['idurl_admin']."&v1=right-management");

$page['L_member']=$lang['member']['member'];
$page['L_member_list']=$lang['member']['member_list'];
$page['L_sex_list']=$lang['member']['sex_list'];
$page['L_country_list']=$lang['member']['country_list'];
$page['L_level_list']=$lang['member']['level_list'];
$page['L_job_list']=$lang['member']['job_list'];
$page['L_import_member']=$lang['member']['import_member'];
$page['L_registration_list']=$lang['member']['registration_list'];
$page['L_group_list']=$lang['member']['group_list'];
$page['L_right_management']=$lang['member']['right_management'];

# news
$page['link_news']='';
if($right_user['news_list']) $page['link_news']=convert_url("index.php?r=".$lang['general']['idurl_news']."&v1=news_list");
$page['L_news']=$lang['news']['news'];
$page['L_news_list']=$lang['news']['news_list'];

# information
$page['link_information']='';
if($right_user['information_list']) $page['link_information']=convert_url("index.php?r=".$lang['general']['idurl_information']."&v1=page_list");
$page['L_information']=$lang['information']['information'];
$page['L_liste_information']=$lang['information']['page_list'];

# forum
$page['link_forum']='';
if($right_user['forum_list']) $page['link_forum']=convert_url("index.php?r=".$lang['general']['idurl_forum']."&v1=forum_list");
$page['L_forum']=$lang['forum']['forum'];
$page['L_forum_list']=$lang['forum']['forum_list'];

# file
$page['link_file']='';
if($right_user['add_file']) $page['link_file']=convert_url("index.php?r=".$lang['general']['idurl_file']."&v1=file_manager&fen=pop");
$page['L_file']=$lang['file']['file'];
$page['L_file_list']=$lang['file']['file_list'];

# admin
$page['link_menu_management']='';
if($right_user['menu_management']) $page['link_menu_management']=convert_url("index.php?r=".$lang['general']['idurl_admin']."&v1=menu-management");
$page['L_administration']=$lang['administration']['administration'];
$page['L_menu_management']=$lang['administration']['menu_management'];


# plugin
# plugins
$page['plugin']=array();
$nb_plugin=sizeof($plugin);
$j=0;
for($i=0; $i< $nb_plugin; $i++)
{
 if(in_array(LANG,$plugin[$i]['lang'])) { 
  $page['plugin'][$j]['name']=$plugin[$i]['name'];
  $page['plugin'][$j]['link']=$plugin[$i]['link'];
  $page['plugin'][$j]['active']=$plugin[$i]['active'];
  $j++;
 }
}
$page['L_plugin']=$lang['administration']['plugin'];


# text
$page['L_title']=$lang['administration']['administration_zone'];
$page['meta_title']=$lang['administration']['administration_zone'];

$page['template']=$tpl['administration']['admin'];
?>