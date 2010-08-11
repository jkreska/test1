<?php

# we check is the site is configue correctly
$page['show_configuration']="";
$page['L_configuration']=$lang['administration']['configuration'];
$page['L_configuration_text']=$lang['administration']['configuration_text'];


# the installation folder must be delete
$page['show_end_installation']="";
if(file_exists(ROOT."/installation/index.php"))
{
 $page['show_configuration']="1";
 $page['show_end_installation']="1";
 $page['L_end_installation']=$lang['administration']['end_installation'];
}

# the script has been updated
$page['show_maj']="";
if(VERSION_SITE > VERSION)
{
 $page['show_configuration']="1";
 $page['show_maj']="1";
 $page['L_maj']=$lang['administration']['update']; 
 $page['link_maj']=convert_url("installation/index.php?lg=".LANG."&r=maj");
 $page['L_mettre_a_day']=$lang['administration']['mettre_a_day']; 
}

# the site is not open
$page['show_website_status']="";
if(SITE_OPEN==0)
{
 $page['show_configuration']="1";
 $page['show_website_status']="1";
 $page['link_website_status']=convert_url("index.php?r=".$lang['general']['idurl_admin']."&v1=configuration");
 $page['L_site_closed']=$lang['administration']['site_closed'];
 $page['L_change_configuration']=$lang['administration']['change_configuration'];
}


# there is no club registered
$page['show_club_admin']="";
include_once(create_path("club/sql_club.php"));
include_once(create_path("club/lg_club_".LANG.".php"));
$sql_club=$sql['club']['select_club_nb'];
$sgbd = sql_connect();
$res_club = sql_query($sql_club);
$ligne_club = sql_fetch_array($res_club);
$nb_club = $ligne_club['nb'];
if($nb_club==0) {
 $page['show_configuration']="1";
 $page['show_club_admin']=1;
 $page['link_club']=convert_url("index.php?r=".$lang['general']['idurl_club']."&v1=form_club");
 $page['L_club_absent']=$lang['club']['E_club_not_found'];
 $page['L_add_club']=$lang['club']['add_club'];
}
sql_free_result($res_club);

# there is no competition registered
$page['show_competition']="";
include_once(create_path("competition/sql_competition.php"));
include_once(create_path("competition/lg_competition_".LANG.".php"));
$sql_competition=$sql['competition']['select_competition_nb'];
$sgbd = sql_connect();
$res_competition = sql_query($sql_competition);
$ligne_competition = sql_fetch_array($res_competition);
$nb_competition = $ligne_competition['nb'];
if($nb_competition==0) {
 $page['show_configuration']="1";
 $page['show_competition']=1;
 $page['link_competition']=convert_url("index.php?r=".$lang['general']['idurl_competition']."&v1=form_competition");
 $page['L_competition_absent']=$lang['competition']['E_competition_not_found'];
 $page['L_add_competition']=$lang['competition']['add_competition'];
}
sql_free_result($res_competition);

# there is no team registered
$page['show_team']="";
include_once(create_path("team/sql_team.php"));
include_once(create_path("team/lg_team_".LANG.".php"));
$var['condition']="";
$var['order']="";
$var['limit']="";
$sql_team=sql_replace($sql['team']['select_team_nb'],$var);
$sgbd = sql_connect();
$res_team = sql_query($sql_team);
$ligne_team = sql_fetch_array($res_team);
$nb_team = $ligne_team['nb'];
if($nb_team==0) {
 $page['show_configuration']="1";
 $page['show_team']=1;
 $page['link_team']=convert_url("index.php?r=".$lang['general']['idurl_team']."&v1=form_team");
 $page['L_team_absent']=$lang['team']['E_team_not_found'];
 $page['L_add_team']=$lang['team']['add_team'];
}
sql_free_result($res_team);

# there is no news registered
$page['show_news']="";
include_once(create_path("news/sql_news.php"));
include_once(create_path("news/lg_news_".LANG.".php"));
$var['condition']="";
$var['order']="";
$var['limit']="";
$sql_news=sql_replace($sql['news']['select_nb_news'],$var);
$sgbd = sql_connect();
$res_news = sql_query($sql_news);
$ligne_news = sql_fetch_array($res_news);
$nb_news = $ligne_news['nb'];
if($nb_news==0) {
 $page['show_configuration']="1";
 $page['show_news']=1;
 $page['link_news']=convert_url("index.php?r=".$lang['general']['idurl_news']."&v1=form_news");
 $page['L_news_absent']=$lang['news']['E_news_not_found'];
 $page['L_add_news']=$lang['news']['add_news'];
}
sql_free_result($res_news);
sql_close($sgbd);


# on verifie que le site est ouvert au public


# season : we check that the last season is not over
$page['show_season']=""; 
$var['date']=date("Y-m-d",time());
$sql_season=sql_replace($sql['competition']['select_season_date'],$var); 
$sgbd = sql_connect();
$res_season = sql_query($sql_season);
$ligne_season = sql_fetch_array($res_season);
$nb_season = sql_num_rows($res_season);
if($nb_season==0) {
 $page['show_configuration']="1";
 $page['show_season']=1;
 $page['link_season']=convert_url("index.php?r=".$lang['general']['idurl_competition']."&v1=season_list");
 $page['L_depassee_season']=$lang['competition']['E_over_season'];
 $page['L_add_season']=$lang['competition']['add_season'];
}
sql_free_result($res_season);
sql_close($sgbd);


/* Members conntected */
# to do

# list of the matches played but without any score
$page['show_match']="";
include_once(create_path("match/sql_match.php"));
include_once(create_path("match/lg_match_".LANG.".php"));
include_once(create_path("match/tpl_match.php"));
$var['condition']=" WHERE match_date < NOW() AND (match_score_home IS NULL OR match_score_visitor IS NULL) ";
$var['order']="";
$var['limit']="";
$included=1;
include(create_path("match/match_list.php"));
unset($included);
$page['match']=$page['match'];
if($page['nb_match']>0) {
 $page['L_match']=$lang['match']['match'];
 $page['L_match_sans_score']=$lang['match']['E_empty_score'];
 $page['show_match']="1";
}

# Registration to validate
$page['show_member']="";
$page['member']=array();
if(REGISTRATION) {
	include_once(create_path("member/sql_member.php"));
	include_once(create_path("member/lg_member_".LANG.".php"));
	include_once(create_path("member/tpl_member.php"));
	$included=1;
	include(create_path("member/registration_list.php"));
	unset($included);
	//$page['nb_member']=$page['nb_member'];
	//$page['member']=$page['member'];
	if($page['nb_registration']>0) {
	 $page['L_registration_list']=$lang['member']['registration_list'];
	 $page['L_registration_list_info']=$lang['member']['registration_list_info'];
	 $page['link_registration_list']=convert_url("index.php?r=".$lang['general']['idurl_member']."&v1=registration_list");
	 $page['L_member_a_activer']=$lang['member']['member_a_activer'];
	 $page['show_member']="1";
	}
}

# we check if there is some plugin available that need to be installed
$page['plugin']=array();
$page['show_plugin']="";

if($right_user['plugin_management']) {
	$nb_plugin=sizeof($plugin);
	$j=0;
	for($i=0; $i< $nb_plugin; $i++)
	{
	 if($plugin[$i]['install']!=1 AND in_array(LANG,$plugin[$i]['lang'])) { 
	  $page['plugin'][$j]['name']=$plugin[$i]['name'];
	  $page['plugin'][$j]['link_install']=$plugin[$i]['link_install'];
	  $page['plugin'][$j]['L_install']=$lang['administration']['plugin_install'];
	  $j++;
	  $page['show_plugin']="1";
	 }
	}
}
$page['L_plugin']=$lang['administration']['plugin_list'];
$page['L_plugin_to_install']=$lang['administration']['plugin_to_install'];


# link
$page['link_admin']=convert_url("index.php?r=".$lang['general']['idurl_admin']."&v1=admin");
$page['link_configuration']=convert_url("index.php?r=".$lang['general']['idurl_admin']."&v1=configuration");

# text
$page['L_title']=$lang['administration']['home_administration'];
$page['L_admin']=$lang['administration']['administration'];
$page['L_welcome']=$lang['administration']['welcome'];
$page['L_configuration']=$lang['administration']['configuration'];
$page['L_parametre']=$lang['administration']['parametre'];

$page['meta_title']=$lang['administration']['administration'];

$page['template']=$tpl['administration']['home_admin'];

?>