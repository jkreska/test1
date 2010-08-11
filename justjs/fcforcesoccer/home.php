<?php
/*
* phpMySport : website for team sport clubs and leagues
*
* Copyright (C) 2006-2009 Jerome PLACE. All rights reserved.
*
* Email           : djayp [at] users.sourceforge.net
* Website         : http://phpmysport.sourceforge.net
* Version         : 1.4
* Last update     : 4 march 2009
*
* This program is free software; you can redistribute it and/or
* modify it under the terms of the GNU General Public License
* as published by the Free Software Foundation; either version 2
* of the License, or (at your option) any later version.
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
*
*/


/************************/
/* Last news            */
/************************/
$var['condition']="";
$var['limit']=" LIMIT 0,".HOME_NB_NEWS." ";
$var['order']=" ORDER BY news_release DESC ";

$page['news']=array();
$included=1;
include_once(create_path("news/sql_news.php"));
include_once(create_path("news/tpl_news.php"));
include_once(create_path("news/lg_news_".LANG.".php"));

include(create_path("news/news_list.php"));
$page['last_news']=$page['news'];
$page['L_news']=$lang['news']['home_news'];
$page['L_last_news']=$lang['news']['last_news'];
$page['L_view_news_list']=$lang['news']['view_list'];
$page['link_news']=convert_url("index.php?r=".$lang['general']['idurl_news']."&v1=news_list");
$page['L_message_last_news']=$page['L_message_news'];

/************************/
/* information          */
/************************/
$var['condition']="";
$var['limit']=" ";
$var['order']=" ORDER BY page_order DESC ";

$page['information']=array();
include_once(create_path("information/sql_information.php"));
include_once(create_path("information/tpl_information.php"));
include_once(create_path("information/lg_information_".LANG.".php"));

include(create_path("information/page_list.php"));
$page['information']=$page['page'];
$page['L_information']=$lang['information']['information_home'];


# Next matches list
include_once(create_path("match/sql_match.php"));
include_once(create_path("match/lg_match_".LANG.".php"));
include_once(create_path("match/tpl_match.php"));
$var['condition']=" WHERE m.match_date >= NOW() ";
$var['order']=" ORDER BY m.match_date ASC ";
$var['limit']=" LIMIT 0,".HOME_NB_MATCH." ";
include(create_path("match/match_list.php"));
$page['next_matches']=$page['match'];
$page['L_message_next_matches']=$page['L_message_match'];

# Last matches list
include_once(create_path("match/sql_match.php"));
include_once(create_path("match/lg_match_".LANG.".php"));
include_once(create_path("match/tpl_match.php"));
$var['condition']=" WHERE m.match_date < NOW() AND m.match_score_visitor IS NOT NULL ";
$var['order']=" ORDER BY m.match_date DESC ";
$var['limit']=" LIMIT 0,".HOME_NB_MATCH." ";
include(create_path("match/match_list.php"));
unset($included);


# Mini-standings
$page['mini_standings']='';
if(MS_SHOW=='home') {
	$page['mini_standings']=$_SESSION['session_mini_standings'];
}

# text
$page['last_matches']=$page['match'];
$page['L_message_last_matches']=$page['L_message_match'];

$page['L_match']=$lang['match']['match'];
$page['L_match_home']=$lang['match']['home'];
$page['L_match_visitor']=$lang['match']['visitor'];
$page['L_next_matches']=$lang['match']['next_matches'];
$page['L_last_matches']=$lang['match']['last_matches'];

$page['L_view_match_list']=$lang['match']['view_list'];
$page['link_match']=convert_url("index.php?r=".$lang['general']['idurl_match']."&v1=match_list");

$page['title']=$lang['general']['home'];

$page['meta_title']=$lang['general']['home'];
$page['template']=$tpl['general']['home'];

?>