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


/****************************/
/* MENUS                    */
/****************************/
$file=ROOT."/menu.csv"; # file containing the website menu

# list of default pages
$default_pages=array(
array('level'=>'parent','title'=>$lang['general']['home'],'url'=>'index.php','class'=>'menu_home'),
array('level'=>'parent','title'=>$lang['general']['news'],'url'=>'index.php?r='.$lang['general']['idurl_news'].'&v1=news_list','class'=>''),
array('level'=>'parent','title'=>$lang['general']['information'],'url'=>'index.php?r='.$lang['general']['idurl_information'],'class'=>''),
array('level'=>'parent','title'=>$lang['general']['team_list'],'url'=>'index.php?r='.$lang['general']['idurl_team'].'&v1=team_list','class'=>''),
array('level'=>'parent','title'=>$lang['general']['member_list'],'url'=>'index.php?r='.$lang['general']['idurl_member'].'&v1=member_list','class'=>''),
array('level'=>'child','title'=>$lang['general']['member_list'],'url'=>'index.php?r='.$lang['general']['idurl_member'].'&v1=member_list','class'=>''),
array('level'=>'child','title'=>$lang['general']['player_list'],'url'=>'index.php?r='.$lang['general']['idurl_team'].'&v1=player_list','class'=>''),
array('level'=>'child','title'=>$lang['general']['manager_list'],'url'=>'index.php?r='.$lang['general']['idurl_member'].'&v1=manager_list','class'=>''),
array('level'=>'child','title'=>$lang['general']['coach_list'],'url'=>'index.php?r='.$lang['general']['idurl_team'].'&v1=coach_list','class'=>''),
array('level'=>'child','title'=>$lang['general']['referee_list'],'url'=>'index.php?r='.$lang['general']['idurl_member'].'&v1=referee_list','class'=>''),
array('level'=>'parent','title'=>$lang['general']['match_list'],'url'=>'index.php?r='.$lang['general']['idurl_match'],'class'=>''),
array('level'=>'child','title'=>$lang['general']['match_list'],'url'=>'index.php?r='.$lang['general']['idurl_match'].'&v1=match_list','class'=>''),
array('level'=>'child','title'=>$lang['general']['standings'],'url'=>'index.php?r='.$lang['general']['idurl_match'].'&v1=standings','class'=>''),
array('level'=>'child','title'=>$lang['general']['stats_player'],'url'=>'index.php?r='.$lang['general']['idurl_match'].'&v1=stats_player','class'=>''),
array('level'=>'parent','title'=>$lang['general']['competition_list'],'url'=>'index.php?r='.$lang['general']['idurl_competition'].'&v1=competition_list','class'=>''),
//array('order'=>'6.1','title'=>$lang['general']['statistics'],'url'=>'index.php?r='.$lang['general']['idurl_match'].'&v1=statistics','class'=>''),
//array('order'=>'8.0','title'=>$lang['general']['search_member'],'url'=>'index.php?r='.$lang['general']['idurl_member'].'&v1=search_member','class'=>''),
array('level'=>'parent','title'=>$lang['general']['club_list'],'url'=>'index.php?r='.$lang['general']['idurl_club'],'class'=>''),
array('level'=>'parent','title'=>$lang['general']['field_list'],'url'=>'index.php?r='.$lang['general']['idurl_field'],'class'=>''),
array('level'=>'parent','title'=>$lang['general']['forum_list'],'url'=>'index.php?r='.$lang['general']['idurl_forum'],'class'=>'')
);

$website_menu=array();

# we load the menu 
if(file_exists($file) AND $fp=fopen($file, "r") AND filesize($file)!=0) {
	$i=0;
	while (($data = fgetcsv($fp, 1000, ";")) !== FALSE) {
		$website_menu[$i]['level']=$data[0];
		$website_menu[$i]['title']=$data[1];
		$website_menu[$i]['url']=$data[2];
		$website_menu[$i]['class']=$data[3];
		$website_menu[$i]['target']=$data[4];
		$i++;
	}
	fclose($fp);
}
else {
	$website_menu=$default_pages;
}


$k=0;
$i=-1;
foreach($website_menu AS $value) {
	if(!isset($value['target'])) $value['target']='';

	if(!eregi("http",$value['url'])) {
		$value['url']=convert_url($value['url']);
	}
	
	if($value['level']=='parent') {
		$i++;	
		$j=0;
		$index['menu'][$i]=$value;
		$index['menu'][$i]['i']=$k;
		$index['menu'][$i]['submenu']=array();
	}
	else {
		$index['menu'][$i]['submenu'][$j]=$value;
		$index['menu'][$i]['submenu'][$j]['i']=$k;
		$j++;
	}
	$k++;
}




/*
# team of the club
$index['team']=array();
if(CLUB!=0) {
 if(!isset($_SESSION['menu_team'])) {
  $var['condition']="";
  $var['limit']="";
  $var['order']=" ORDER BY e.sex_id, ne.team_name_name ASC";
  $included=1;
  include_once(create_path("team/sql_team.php"));
  include_once(create_path("team/tpl_team.php"));
  include_once(create_path("team/lg_team_".LANG.".php"));
  include(create_path("team/team_list.php"));
  unset($included);
  $_SESSION['menu_team']=$page['team'];
 }
 $index['team']=$_SESSION['menu_team'];
}

#  information pages list
$index['information']=array();
if(!isset($_SESSION['menu_information'])) {
  $var['condition']="";
  $var['limit']="";
  $var['order']="";
  $included=1;
  include_once(create_path("information/sql_information.php"));
  include_once(create_path("information/tpl_information.php"));
  include_once(create_path("information/lg_information_".LANG.".php"));
  include(create_path("information/page_list.php"));
  unset($included);
  $_SESSION['menu_information']=$page['page'];
}
$index['information']=$_SESSION['menu_information'];

# forums list
$index['forum']=array();
if(!isset($_SESSION['menu_forum'])) {
  $var['condition']="";
  $var['limit']="";
  $var['order']="";
  $included=1;
  include_once(create_path("forum/sql_forum.php"));
  include_once(create_path("forum/tpl_forum.php"));
  include_once(create_path("forum/lg_forum_".LANG.".php"));
  include(create_path("forum/forum_list.php"));
  unset($included);
  $_SESSION['menu_forum']=$page['forum'];
}
$index['forum']=$_SESSION['menu_forum'];

# competition list
$index['competition']=array();
if(!isset($_SESSION['menu_competition'])) {
  $var['condition']="";
  $var['limit']="";
  $var['order']="";
  $included=1;
  include_once(create_path("competition/sql_competition.php"));
  include_once(create_path("competition/tpl_competition.php"));
  include_once(create_path("competition/lg_competition_".LANG.".php"));
  include(create_path("competition/competition_list.php"));
  unset($included);
  $_SESSION['menu_competition']=$page['competition'];
}
$index['competition']=$_SESSION['menu_competition'];



# plugins
$index['plugin']=array();
$nb_plugin=sizeof($plugin);
$j=0;
for($i=0; $i< $nb_plugin; $i++)
{
 if($plugin[$i]['active']==1) { 
  $index['plugin'][$j]['name']=$plugin[$i]['name'];
  $index['plugin'][$j]['link']=$plugin[$i]['link'];
  $index['plugin'][$j]['class']=$plugin[$i]['class'];
  $j++;
 }
}

#text
$index['L_home']=$lang['general']['home'];
$index['L_news']=$lang['general']['news'];
$index['L_information']=$lang['general']['information'];
$index['L_member']=$lang['general']['member'];
$index['L_member_list']=$lang['general']['member_list'];
$index['L_player_list']=$lang['general']['player_list'];
$index['L_manager_list']=$lang['general']['manager_list'];
$index['L_coach_list']=$lang['general']['coach_list'];
$index['L_referee_list']=$lang['general']['referee_list'];
$index['L_match']=$lang['general']['match'];
$index['L_match_list']=$lang['general']['match_list'];
$index['L_standings']=$lang['general']['standings'];
$index['L_stats_player']=$lang['general']['stats_player'];
$index['L_competition_list']=$lang['general']['competition_list'];
$index['L_team_list']=$lang['general']['team_list'];
$index['L_statistics']=$lang['general']['statistics'];
$index['L_search_member']=$lang['general']['search_member'];
$index['L_club_list']=$lang['general']['club_list'];
$index['L_view_club']=$lang['general']['view_club'];
$index['L_field_list']=$lang['general']['field_list'];
$index['L_forum_list']=$lang['general']['forum_list'];

*/

# mode club
$index['link_view_club']="";
$index['class_view_club']="";

if(CLUB!=0){
 $index['link_view_club']=convert_url("index.php?r=".$lang['general']['idurl_club']."&v1=view&v2=".CLUB);
 $index['L_club_list']=$lang['general']['club_opponent_list'];  
 $index['L_information']=$lang['general']['the_club'];
 
 if(isset($_GET['r']) AND $_GET['r']==$lang['general']['idurl_club'] AND isset($_GET['v2']) AND $_GET['v2']==CLUB) 
 { 
  $index['class_information']="on";
  $index['class_club']="";
 }
}
?>