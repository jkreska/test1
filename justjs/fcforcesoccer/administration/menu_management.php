<?php
	
$nb_erreur="0";
$page['erreur']=array();
$page['L_message']="";

if($right_user['menu_management']) {
	$page['show_form']=1; 
}
else {
	$page['show_form']='';
	$page['L_message']=$lang['general']['acces_reserve_admin'];
}


$file=ROOT."/menu.csv"; # file containing the website menu

# menu links list
/*
- Title
- URL (internal or external)
- Level (parent or child)
- Image : to replace the text
*/


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


# if changed we save the menu in a file
if($right_user['menu_management']) {
	if(isset($_POST['action_menu']) AND $_POST['action_menu']=='reset') {
		$fp = fopen($file, 'w+');
		fwrite($fp,'');
		fclose($fp);
		clearstatcache();

	}
	elseif(isset($_POST['action_menu']) AND $_POST['action_menu']=='cancel') {
		# we do not change anything
	}
	elseif(isset($_POST['action_menu']) AND $_POST['action_menu']=='save') {
		$fp = fopen($file, 'w+');
		foreach($_POST['level'] AS $id => $value) {
			if($_POST['level'][$id]!='') {
				//if(!isset($_POST['target'][$id])) $_POST['target'][$id]='';
				$line=array($_POST['level'][$id],$_POST['title'][$id],eregi_replace(ROOT_URL.'/','',$_POST['url'][$id]),$_POST['class'][$id],$_POST['target'][$id]);
				fputcsv($fp, $line, ";");
			}	
		}
		fclose($fp);
		clearstatcache();
	}
}
 
# we load the menu
# if the menu file is empty, we load the default menu
if(file_exists($file) AND $fp=fopen($file, 'r') AND filesize($file)!=0) {
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

# table containg all the url of the menu
$url_list=array();
foreach($website_menu AS $id => $value) {
 array_push($url_list,$value['url']);
}


# we add other pages such as the team list, the club list, the information pages 

$page['default_pages']=array();
$page['team']=array();
$page['club']=array();
$page['information']=array();
$page['forum']=array();
$page['competition']=array();
$page['menu']=array();
$page['plugin']=array();
$page['nb_page']='';

if($page['show_form']) {
	# default pages
	$page['default_pages']=$default_pages;
	$nb_default_page=sizeof($page['default_pages']);
	
	for($i=0; $i<$nb_default_page;$i++) {
		$page['default_pages'][$i]['i']=$i;	
		
		# if already present in the menu, we dont display it	
		if(in_array($page['default_pages'][$i]['url'],$url_list)) {
			$page['default_pages'][$i]['hide']='hidden';
		}
		else {
			$page['default_pages'][$i]['hide']='';
		}
	}

	# team
	if(CLUB!=0) {
		$var['condition']="";
		$var['limit']="";
		$var['order']=" ORDER BY e.sex_id, ne.team_name_name ASC";
		$included=1;
		include_once(create_path("team/sql_team.php"));
		include_once(create_path("team/tpl_team.php"));
		include_once(create_path("team/lg_team_".LANG.".php"));
		include(create_path("team/team_list.php"));
		unset($included);
		$page['team']=$page['team'];
		$page['L_team']=$lang['team']['team_list'];
		
		for($i=0; $i<$nb_ligne;$i++) {
			# if already present in the menu, we dont display it
			$page['team'][$i]['link_view']=unconvert_url($page['team'][$i]['link_view']);
			if(in_array(eregi_replace(ROOT_URL."/","",$page['team'][$i]['link_view']),$url_list)) {
				$page['team'][$i]['hide']='hidden';
			}
			else {
				$page['team'][$i]['hide']='';
			}
		}
	}
	
	# club
	include_once(create_path("club/sql_club.php"));
	include_once(create_path("club/lg_club_".LANG.".php"));
	include_once(create_path("club/tpl_club.php"));
	$var['condition']=" ";
	$var['order']=" ";
	$var['limit']=" ";
	$included=1;
	include(create_path("club/club_list.php"));
	unset($included);
	$page['club']=$page['club'];
	$page['L_club']=$lang['club']['club_list'];
	
	for($i=0; $i<$nb_ligne;$i++) {
		# if already present in the menu, we dont display it
		$page['club'][$i]['link_view']=unconvert_url($page['club'][$i]['link_view']);
		if(in_array(eregi_replace(ROOT_URL."/","",$page['club'][$i]['link_view']),$url_list)) {
			$page['club'][$i]['hide']='hidden';
		}
		else {
			$page['club'][$i]['hide']='';
		}
	}
	
	# information
	$var['condition']="";
	$var['limit']="";
	$var['order']="";
	$included=1;
	include_once(create_path("information/sql_information.php"));
	include_once(create_path("information/tpl_information.php"));
	include_once(create_path("information/lg_information_".LANG.".php"));
	include(create_path("information/page_list.php"));
	unset($included);
	$page['information']=$page['page'];
	$page['L_information']=$lang['information']['page_list'];
	
	for($i=0; $i<$nb_ligne;$i++) {
		# if already present in the menu, we dont display it
		$page['information'][$i]['link']=unconvert_url($page['information'][$i]['link']);
		if(in_array(eregi_replace(ROOT_URL."/","",$page['information'][$i]['link']),$url_list)) {
			$page['information'][$i]['hide']='hidden';
		}
		else {
			$page['information'][$i]['hide']='';
		}
	}
	
	# forum
	$var['condition']="";
	$var['limit']="";
	$var['order']="";
	$included=1;
	include_once(create_path("forum/sql_forum.php"));
	include_once(create_path("forum/tpl_forum.php"));
	include_once(create_path("forum/lg_forum_".LANG.".php"));
	include(create_path("forum/forum_list.php"));
	unset($included);
	$page['L_forum']=$lang['forum']['forum_list'];
	
	for($i=0; $i<$nb_ligne;$i++) {
		# if already present in the menu, we dont display it
		$page['forum'][$i]['link_forum']=unconvert_url($page['forum'][$i]['link_forum']);
		if(in_array(eregi_replace(ROOT_URL."/","",$page['forum'][$i]['link_forum']),$url_list)) {
			$page['forum'][$i]['hide']='hidden';
		}
		else {
			$page['forum'][$i]['hide']='';
		}
	}
	
	# competition
	$var['condition']="";
	$var['limit']="";
	$var['order']="";
	$included=1;
	include_once(create_path("competition/sql_competition.php"));
	include_once(create_path("competition/tpl_competition.php"));
	include_once(create_path("competition/lg_competition_".LANG.".php"));
	include(create_path("competition/competition_list.php"));
	unset($included);
	$page['L_competition']=$lang['competition']['competition_list'];
	
	for($i=0; $i<$nb_ligne;$i++) {
		# if already present in the menu, we dont display it
		$page['competition'][$i]['link_view']=unconvert_url($page['competition'][$i]['link_view']);
		if(in_array(eregi_replace(ROOT_URL."/","",$page['competition'][$i]['link_view']),$url_list)) {
			$page['competition'][$i]['hide']='hidden';
		}
		else {
			$page['competition'][$i]['hide']='';
		}
	}
	
	# plugin
	$page['plugin']=array();
	if(isset($plugin)) {
		$nb_plugin=sizeof($plugin);
		
		$i=0;
		foreach($plugin AS $value) {
			if($value['active']) { // only active plugin
				$page['plugin'][$i]['id']=$i;
				$page['plugin'][$i]['name']=$value['name'];
				$page['plugin'][$i]['link']="index.php?r=".$value['idurl'];
			
				# if already present in the menu, we dont display it	
				if(in_array(eregi_replace(ROOT_URL."/","",$value['link']),$url_list)) {
					$page['plugin'][$i]['hide']='hidden';
				}
				else {
					$page['plugin'][$i]['hide']='';
				}
				$i++;
			}
		}
	}
	$page['L_plugin']=$lang['administration']['plugin_list'];
	
	# we create the menu
	$k=0;
	$i=-1;
	foreach($website_menu AS $value) {
		if(!isset($value['target']) OR $value['target']=='') {
			$value['target']='';
			$value['target_name']=$lang['administration']['same_window'];
		}
		else { 
			$value['target_name']=$lang['administration']['new_window'];
		} 
		
		# external pages
		if(!eregi(ROOT_URL,$value['url']) AND eregi('http',$value['url'])) {
			$value['external']='1';
		}
		else {
			$value['external']='';
		}
		$value['L_delete']=$lang['administration']['delete'];
		
		if($value['level']=='parent') {
			$i++;	
			$j=0;
			$page['menu'][$i]=$value;
			$page['menu'][$i]['i']=$k;
			$page['menu'][$i]['submenu']=array();
		}
		else {
			$page['menu'][$i]['submenu'][$j]=$value;
			$page['menu'][$i]['submenu'][$j]['i']=$k;
			$j++;
		}
		$k++;
	}
	$page['nb_page']=$k;
}


# link
$page['form_action']=convert_url("index.php?r=".$lang['general']['idurl_admin']."&v1=menu-management");


# text
$page['L_title']=$lang['administration']['menu_management'];

$page['L_website_menu']=$lang['administration']['website_menu'];
$page['L_available_pages']=$lang['administration']['available_pages'];

$page['L_default_pages']=$lang['administration']['default_pages'];
$page['L_internal_pages']=$lang['administration']['internal_pages'];
$page['L_external_pages']=$lang['administration']['external_pages'];
$page['L_page_title']=$lang['administration']['page_title'];
$page['L_page_url']=$lang['administration']['page_url'];
$page['L_page_target']=$lang['administration']['page_target'];
$page['L_same_window']=$lang['administration']['same_window'];
$page['L_new_window']=$lang['administration']['new_window'];
$page['L_add_page']=$lang['administration']['add_page'];
$page['L_no_title']=$lang['administration']['E_no_title'];

$page['L_menu_management_info']=$lang['administration']['menu_management_info'];

$page['L_reset_menu']=$lang['administration']['reset_menu'];
$page['L_class_css']=$lang['administration']['page_css'];

$page['L_erreur']=$lang['administration']['erreur'];
$page['L_save']=$lang['administration']['save'];
$page['L_cancel']=$lang['administration']['cancel'];
$page['L_delete']=$lang['administration']['delete'];

$page['meta_title']=$lang['administration']['menu_management'];
$page['template']=$tpl['administration']['menu_management'];

?>