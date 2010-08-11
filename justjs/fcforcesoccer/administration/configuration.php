<?php
	
$nb_erreur="0";
$page['erreur']=array();
$page['L_message']="";
$page['form_action']=convert_url("index.php?r=".$lang['general']['idurl_admin']."&v1=configuration");

$page['value_title']=SITE_TITLE;
$page['value_url']=ROOT_URL;
$page['value_root']=ROOT;
$page['value_email']=SENDER_EMAIL;
$page['value_sender_name']=SENDER_NAME;
$page['value_host']=SGBD_HOST;
$page['value_user_base']=SGBD_USER;
$page['value_name_base']=SGBD_NAME;
$page['value_pass_base']=SGBD_PWD;
$page['value_prefix']=SGBD_PREFIX;
$page['value_url_rewrite']=URL_REWRITE;
$page['value_nb_player']=NB_MAX_PLAYER;
$page['value_website_status']=SITE_OPEN;
$page['value_template']=TPL_DOSSIER;
$page['value_avatar_folder']=AVATAR_FOLDER;
$page['value_language']=LANG;

$page['value_mail']=MAIL;

$page['value_nb_news']=NB_NEWS;
$page['value_nb_club']=NB_CLUB;
$page['value_nb_team']=NB_TEAM;
$page['value_nb_member']=NB_MEMBER;
$page['value_nb_match']=NB_MATCH;
$page['value_nb_competition']=NB_COMPETITION;
$page['value_nb_field']=NB_FIELD;
$page['value_nb_forum_topic']=NB_FORUM_TOPIC;
$page['value_nb_forum_message']=NB_FORUM_MESSAGE;
$page['value_home_nb_news']=HOME_NB_NEWS;
$page['value_home_nb_match']=HOME_NB_MATCH;

$page['value_ms_show']=MS_SHOW;
$page['value_ms_nb_club_max']=MS_NB_CLUB_MAX;
$page['value_ms_column']=$ms_column;
$page['value_ms_season']=MS_SEASON;
$page['value_ms_competition']=MS_COMPETITION;
$page['value_ms_round']=MS_ROUND;
$page['value_ms_show_form']=MS_SHOW_FORM;
$page['checked_ms_show_form']='';

$page['value_registration']=REGISTRATION;
$page['value_registration_mail']=REGISTRATION_MAIL;


if($right_user['configuration']) {
	$page['show_form']=1; 
}
else {
	$page['show_form']='';
	$page['L_message']=$lang['general']['acces_reserve_admin'];
}


# functions that are disabled un php.ini
if(isset($_POST) AND !empty($_POST) AND $right_user['configuration'])
{
	if(!isset($_POST['title']) OR $_POST['title']=="") { 
		$page['erreur'][$nb_erreur]['message']=$lang['administration']['E_empty_title']; $nb_erreur++;
	}
	
	if(!isset($_POST['url']) OR $_POST['url']=="") { 
		$page['erreur'][$nb_erreur]['message']=$lang['administration']['E_empty_url']; $nb_erreur++;
	}
/*	elseif(!fopen($_POST['url']."/index.php","r")) { 
		$page['erreur'][$nb_erreur]['message']=$lang['administration']['E_invalid_url']; $nb_erreur++;
	}
*/		
	if(!isset($_POST['root']) OR $_POST['root']=="") { 
		$page['erreur'][$nb_erreur]['message']=$lang['administration']['E_empty_root']; $nb_erreur++;
	}
	elseif(!file_exists($_POST['root']."/index.php")) { 
		$page['erreur'][$nb_erreur]['message']=$lang['administration']['E_invalid_root']; $nb_erreur++;
	}
	
	if(isset($_POST['email']) AND !empty($_POST['email']) AND !check_email($_POST['email'])) { 
		$page['erreur'][$nb_erreur]['message']=$lang['administration']['E_invalid_email']; $nb_erreur++;
	}
		
	if(isset($_POST['mail']) AND $_POST['mail']==1 AND eregi('mail',ini_get('disable_functions'))) {
		$page['erreur'][$nb_erreur]['message']=$lang['administration']['E_disable_mail']; $nb_erreur++; 
	}
	elseif(isset($_POST['mail']) AND $_POST['mail']==0 AND isset($_POST['registration_mail']) AND $_POST['registration_mail']==1) {
		$page['erreur'][$nb_erreur]['message']=$lang['administration']['E_invalid_registration_mail']; $nb_erreur++; 
	}
	
	if(isset($_POST['mail']) AND $_POST['mail']==1 AND (empty($_POST['email']) OR empty($_POST['sender_name']))) {
		$page['erreur'][$nb_erreur]['message']=$lang['administration']['E_invalid_sender_name']; $nb_erreur++; 
	}
	
	if(!isset($_POST['host']) OR $_POST['host']=="") { 
		$page['erreur'][$nb_erreur]['message']=$lang['administration']['E_empty_host']; $nb_erreur++;
	}
	if(!isset($_POST['user_base']) OR $_POST['user_base']=="") {
		$page['erreur'][$nb_erreur]['message']=$lang['administration']['E_empty_user_base']; $nb_erreur++;
	} 
	if(!isset($_POST['name_base']) OR $_POST['name_base']=="") { 
		$page['erreur'][$nb_erreur]['message']=$lang['administration']['E_empty_name_base']; $nb_erreur++;
	}
 
	# we try to connect to the database server and to select the base
	if(!@mysql_connect($_POST['host'],$_POST['user_base'],$_POST['pass_base'])) {
		$page['erreur'][$nb_erreur]['message']=$lang['administration']['E_invalid_connection_base']; $nb_erreur++;
	}
	elseif(!mysql_select_db($_POST['name_base'])) { 
		$page['erreur'][$nb_erreur]['message']=$lang['administration']['E_invalid_selection_base']; $nb_erreur++;
	}
	
	# we check that content settings are numbers
	$content_settings=array('nb_news','nb_club','nb_team','nb_member','nb_match','nb_competition','nb_field',
	'nb_forum_topic','nb_forum_message','home_nb_news','home_nb_match');
	
	$nb_erreur_empty=0;
	$nb_erreur_integer=0;
	$nb_erreur_range=0;
	foreach($content_settings AS $id => $value) { 	
		if($_POST[$value]=='') { $nb_erreur_empty++; }
		elseif(!check_integer($_POST[$value])) { $nb_erreur_integer++; }
		elseif($_POST[$value] < 1 OR $_POST[$value] > 100) { $nb_erreur_range++; }	
	}
	if($nb_erreur_empty!=0) { 
		$page['erreur'][$nb_erreur]['message']=$lang['administration']['E_empty_content_settings']; $nb_erreur++;
	} 
	if($nb_erreur_integer!=0) { 
		$page['erreur'][$nb_erreur]['message']=$lang['administration']['E_invalid_content_settings_integer']; $nb_erreur++;
	}
	if($nb_erreur_range!=0) { 
		$page['erreur'][$nb_erreur]['message']=$lang['administration']['E_invalid_content_settings_range']; $nb_erreur++;
	} 
  
 
	if($nb_erreur==0)
	{
		# creation of the file conf.php
		$fichier_conf=ROOT."/administration/conf.txt";
		$fichier_conf_site=ROOT."/include/conf.php";
		$_POST['club']=CLUB;
		$_POST['version']=VERSION;
		if(!isset($_POST['pass_base']) OR empty($_POST['pass_base'])) $_POST['pass_base']=SGBD_PWD;
		$_POST['max_file_size']=return_bytes(ini_get('post_max_size'));
		
		
		if(isset($_POST['ms_column']) AND !empty($_POST['ms_column'])) {
			$_POST['ms_column']="'".implode("','",$_POST['ms_column'])."'";
		}
		else { 
			$_POST['ms_column']='';
		}
		if(!isset($_POST['ms_season'])) $_POST['ms_season']='';
		if(!isset($_POST['ms_competition'])) $_POST['ms_competition']='';
		if(!isset($_POST['ms_round'])) $_POST['ms_round']=''; 
		if(!isset($_POST['ms_show_form'])) $_POST['ms_show_form']=0;
  
		$_SESSION['session_mini_standings']=''; # we need a refresh of mini-standings
		
		$contenu_conf=implode('',file($fichier_conf));
		$contenu_conf=text_replace($contenu_conf,$_POST);
		
		@chmod($fichier_conf_site, 0777);
		if ($fd = @fopen($fichier_conf_site, "w"))
		{
			fwrite($fd, $contenu_conf);
			fclose($fd);
			$page['L_message']=$lang['administration']['configuration_ok'];
			chmod($fichier_conf_site, 0755);   
			header("location:".$page['form_action']);
			exit();
		}
		else
		{
			$page['erreur'][$nb_erreur]['message']=$lang['administration']['E_creation_conf']; $nb_erreur++; 
		}  
	}
	else
	{
		if(isset($_POST['title'])) $page['value_title']=$_POST['title'];
		if(isset($_POST['url'])) $page['value_url']=$_POST['url'];
		if(isset($_POST['root'])) $page['value_root']=$_POST['root'];
		if(isset($_POST['email'])) $page['value_email']=$_POST['email'];   
		if(isset($_POST['sender_name'])) $page['value_sender_name']=$_POST['sender_name'];   		
		
		if(isset($_POST['host'])) $page['value_host']=$_POST['host'];
		if(isset($_POST['user_base'])) $page['value_user_base']=$_POST['user_base'];
		if(isset($_POST['name_base'])) $page['value_name_base']=$_POST['name_base'];
		if(isset($_POST['pass_base'])) $page['value_pass_base']=$_POST['pass_base'];
		if(isset($_POST['prefix'])) $page['value_prefix']=$_POST['prefix'];
		if(isset($_POST['url_rewrite'])) $page['value_url_rewrite']=$_POST['url_rewrite']; 
		if(isset($_POST['website_status'])) $page['value_website_status']=$_POST['website_status'];
		if(isset($_POST['template'])) $page['value_template']=$_POST['template'];
		if(isset($_POST['avatar_folder'])) $page['value_avatar_folder']=$_POST['avatar_folder'];
		if(isset($_POST['language'])) $page['value_language']=$_POST['language'];
		if(isset($_POST['mail'])) $page['value_mail']=$_POST['mail'];
		
		if(isset($_POST['nb_news'])) $page['value_nb_news']=$_POST['nb_news'];
		if(isset($_POST['nb_club'])) $page['value_nb_club']=$_POST['nb_club'];
		if(isset($_POST['nb_team'])) $page['value_nb_team']=$_POST['nb_team'];
		if(isset($_POST['nb_member'])) $page['value_nb_member']=$_POST['nb_member'];
		if(isset($_POST['nb_match'])) $page['value_nb_match']=$_POST['nb_match'];
		if(isset($_POST['nb_competition'])) $page['value_nb_competition']=$_POST['nb_competition'];
		if(isset($_POST['nb_field'])) $page['value_nb_field']=$_POST['nb_field'];
		if(isset($_POST['nb_forum_topic'])) $page['value_nb_forum_topic']=$_POST['nb_forum_topic'];
		if(isset($_POST['nb_forum_message'])) $page['value_nb_forum_message']=$_POST['nb_forum_message'];
		if(isset($_POST['home_nb_news'])) $page['value_home_nb_news']=$_POST['home_nb_news'];
		if(isset($_POST['home_nb_match'])) $page['value_home_nb_match']=$_POST['home_nb_match'];
		
		if(isset($_POST['ms_show'])) $page['value_ms_show']=$_POST['ms_show'];
		if(isset($_POST['ms_column'])) $page['value_ms_column']=$_POST['ms_column'];
		if(isset($_POST['ms_nb_club_max'])) $page['value_ms_nb_club_max']=$_POST['ms_nb_club_max'];  
		if(isset($_POST['ms_season'])) $page['value_ms_season']=$_POST['ms_season'];
		if(isset($_POST['ms_competition'])) $page['value_ms_competition']=$_POST['ms_competition'];
		if(isset($_POST['ms_round'])) $page['value_ms_round']=$_POST['ms_round'];
		if(isset($_POST['ms_show_form'])) $page['value_ms_show_form']=$_POST['ms_show_form'];
		
		if(isset($_POST['registration'])) $page['value_registration']=$_POST['registration'];
		if(isset($_POST['registration_mail'])) $page['value_registration_mail']=$_POST['registration_mail'];
	}
}


# url_rewrite
$page['checked_url_rewrite_yes']="";
$page['checked_url_rewrite_no']="";
if(isset($page['value_url_rewrite']) AND $page['value_url_rewrite']==0) { $page['checked_url_rewrite_no']="checked=\"checked\""; }
else { $page['checked_url_rewrite_yes']="checked=\"checked\""; }

$page['aff_url_rewrite']="1";
// on verifie que le mod_rewrite est active
//if(in_array("rewrite",get_loaded_extensions())) { $page['aff_url_rewrite']=1; }

# website_status
$page['checked_site_closed']="";
$page['checked_site_open']="";
if(isset($page['value_website_status']) AND $page['value_website_status']==1) { $page['checked_site_open']="checked=\"checked\""; }
else { $page['checked_site_closed']="checked=\"checked\""; }

$page['lang']=array();
$page['template_list']=array();
$page['folder_list']=array();
$page['column']=array();
$page['ms_show']=array();
$page['season']=array();
$page['competition']=array();
$page['round']=array();	
	
if($page['show_form']) {
	# language
	$rep = ROOT."/include/";
	$tab_lang=array();
	chdir($rep);
	$dir = opendir(".");
	
	while ($f = readdir($dir)) { 
	 if($f!="." AND $f!=".." AND eregi("lg_general_",$f))
	 {
	  $tab_lang[]=eregi_replace("lg_general_|.php","",$f);
	 }
	}
	closedir($dir); 
	sort($tab_lang);
	$i="0";
	foreach($tab_lang as $f) 
	{ 
	 $page['lang'][$i]['name']=$f;
	 $page['lang'][$i]['selected']="";
	 if($page['value_language']==$f) {	 
	  $page['lang'][$i]['selected']="selected";
	 }  
	 $i++;  
	}
	
	# template	
	$rep = ROOT."/template/";
	$tab_template=array();
	chdir($rep);
	$dir = opendir(".");
	
	while ($f = readdir($dir)) { 
	 if($f!="." AND $f!=".." AND is_dir($rep.$f))
	 {
	  $tab_template[] = $f; 
	 }
	}
	closedir($dir); 
	
	sort($tab_template);
	$i="0";
	foreach($tab_template as $f) 
	{ 
	 $page['template_list'][$i]['name']=$f;
	 $page['template_list'][$i]['selected']=""; 
	 if($page['value_template']==$f) {	 
	  $page['template_list'][$i]['selected']="selected";
	 }  
	 $i++;  
	}
	
	# file (avatar_folder)	
	$rep = ROOT."/".FILE_FOLDER."/";
	$tab_folder=array();
	
	function get_folder($rep) {
	 $folder=array();
	 chdir($rep);
	 $dir = opendir(".");
	
	 while ($f = readdir($dir)) { 
	  if($f!="." AND $f!=".." AND is_dir($rep.$f))
	  {
	   $folder[] = $f;
	   $subfolder=get_folder($rep.$f."/");
	   if(!empty($subfolder)) {
		foreach($subfolder as $sub) {
		  $folder[] = $f."/".$sub;
		}
	   }
	  }
	 }
	 closedir($dir);
	 
	 return $folder;
	}
	
	$tab_folder=get_folder($rep);
	sort($tab_folder);
	$i="0";
	foreach($tab_folder as $f) 
	{ 
	 $page['folder_list'][$i]['name']=$f;
	 $page['folder_list'][$i]['selected']=""; 
	 if($page['value_avatar_folder']==$f) {	 
	  $page['folder_list'][$i]['selected']="selected";
	 }  
	 $i++;  
	}
	
	
	# mini_standings	
	$var['value_stats_array']=$page['value_ms_column'];
	include_once(ROOT.'/match/sql_match.php');
	include_once(ROOT.'/match/tpl_match.php');
	include_once(ROOT.'/match/lg_match_'.LANG.'.php');
	$included=1;
	include(ROOT.'/match/stats_list.php');
	unset($included);
	if(isset($page['stats'])) $page['column']=$page['stats'];
	
	$ms_show=array('all','home','none');
	$i=0;
	foreach($ms_show AS $value) {
		$page['ms_show'][$i]['value']=$value;
		$page['ms_show'][$i]['name']=$lang['administration']['ms_show_'.$value];	
		
		if($page['value_ms_show']==$value) $page['ms_show'][$i]['checked']='checked="checked"';
		else $page['ms_show'][$i]['checked']='';
		$i++;
	}
	
	if($page['value_ms_show_form']==1) { $page['checked_ms_show_form']='checked="checked"'; }
	
	
	# season
	include_once(create_path("competition/sql_competition.php"));
	include_once(create_path("competition/lg_competition_".LANG.".php"));
	include_once(create_path("competition/tpl_competition.php"));
	$var['order']="";
	$var['limit']="";
	$var['condition']="";
	$var['season']=$page['value_ms_season'];
	$included=1;
	include(create_path("competition/season_list.php"));
	unset($included);
	
	# competitions list
	$var['order']="";
	$var['limit']="";
	$var['condition']="";
	$var['value_competition']=$page['value_ms_competition'];
	$included=1;
	include_once(create_path("competition/competition_list.php"));
	unset($included);
	//$page['competition']=$page['competition'];
	
	# round
	$page['link_select_round']=convert_url("index.php?r=".$lang['general']['idurl_competition']."&v1=select_round");	
	$page['display_round']="";
	$var['header']=0;
	$var['condition']="";
	$var['order']="";
	$var['limit']="";
	$var['competition']=$page['value_ms_competition'];
	$var['value_round']=$page['value_ms_round'];
	$page['type_view']="all";
	$included=1;
	include(create_path("competition/select_round.php"));
	unset($included);
	if($page['show_round']==1) { $page['display_round']="block"; }
	//$page['round']=$page['round'];
	$page['L_group']=$lang['competition']['group'];
	$page['L_day']=$lang['competition']['day'];
	$page['L_season']=$lang['competition']['season'];
	$page['L_choose_season']=$lang['competition']['choose_season'];
	$page['L_competition']=$lang['competition']['competition'];
	$page['L_choose_competition']=$lang['match']['choose_competition'];	
}

# Mail
if($page['value_mail']==1) { 
	$page['checked_mail_yes']='checked="checked"';
	$page['checked_mail_no']='';
}
else { 
	$page['checked_mail_yes']='';
	$page['checked_mail_no']='checked="checked"';
}


# Registration
if($page['value_registration']==1) { 
	$page['checked_registration_yes']='checked="checked"';
	$page['checked_registration_no']='';
}
else { 
	$page['checked_registration_yes']='';
	$page['checked_registration_no']='checked="checked"';
}

if($page['value_registration_mail']==1) { 
	$page['checked_registration_mail_yes']='checked="checked"';
	$page['checked_registration_mail_no']='';
}
else { 
	$page['checked_registration_mail_yes']='';
	$page['checked_registration_mail_no']='checked="checked"';
}

# link
$page['form_action']=convert_url("index.php?r=".$lang['general']['idurl_admin']."&v1=configuration");


# text
$page['L_title']=$lang['administration']['parametre'];

$page['L_information_site']=$lang['administration']['information_site'];
$page['L_information_site_ab']=$lang['administration']['information_site_ab'];
$page['L_title_site']=$lang['administration']['title'];
$page['L_url']=$lang['administration']['url'];
$page['L_info_url']=$lang['administration']['info_url'];
$page['L_root']=$lang['administration']['root'];
$page['L_information_mail']=$lang['administration']['information_mail'];
$page['L_information_mail_ab']=$lang['administration']['information_mail_ab'];
$page['L_activate_mail']=$lang['administration']['activate_mail'];
$page['L_activate_mail_info']=$lang['administration']['activate_mail_info'];
$page['L_email']=$lang['administration']['email'];
$page['L_sender_name']=$lang['administration']['sender_name'];
$page['L_information_base']=$lang['administration']['information_base'];
$page['L_information_base_ab']=$lang['administration']['information_base_ab'];
$page['L_host']=$lang['administration']['host'];
$page['L_user']=$lang['administration']['user'];
$page['L_mot_de_passe']=$lang['administration']['password'];
$page['L_base']=$lang['administration']['base'];
$page['L_prefix']=$lang['administration']['prefix'];
$page['L_information_sport']=$lang['administration']['information_sport'];
$page['L_information_sport_ab']=$lang['administration']['information_sport_ab'];
$page['L_nb_player']=$lang['administration']['nb_player'];

$page['L_info_url']=$lang['administration']['info_url'];
$page['L_url_rewrite']=$lang['administration']['url_rewrite'];
$page['L_info_url_rewrite']=$lang['administration']['info_url_rewrite'];
$page['L_website_status']=$lang['administration']['website_status'];
$page['L_site_open']=$lang['administration']['site_open'];
$page['L_site_closed']=$lang['administration']['site_closed'];
$page['L_yes']=$lang['administration']['yes'];
$page['L_no']=$lang['administration']['no'];

$page['L_example']=$lang['administration']['example'];
$page['L_example_title']=$lang['administration']['example_title'];
$page['L_example_url']=$lang['administration']['example_url'];
$page['L_example_root']=$lang['administration']['example_root'];
$page['L_example_email']=$lang['administration']['example_email'];
$page['L_example_sender_name']=$lang['administration']['example_sender_name'];
$page['L_example_host']=$lang['administration']['example_host'];
$page['L_example_user']=$lang['administration']['example_user'];
$page['L_example_base']=$lang['administration']['example_base'];

$page['L_language']=$lang['administration']['language'];

$page['L_template']=$lang['administration']['template'];
$page['L_avatar_folder']=$lang['administration']['avatar_folder'];
$page['L_info_avatar_folder']=$lang['administration']['info_avatar_folder'];

$page['L_mini_standings']=$lang['administration']['mini_standings'];
$page['L_mini_standings_ab']=$lang['administration']['mini_standings_ab'];
$page['L_ms_show']=$lang['administration']['ms_show']; 
$page['L_ms_column']=$lang['administration']['ms_column'];
$page['L_ms_default_competition']=$lang['administration']['ms_default_competition'];
$page['L_ms_nb_club_max']=$lang['administration']['ms_nb_club_max'];
$page['L_ms_show_form']=$lang['administration']['ms_show_form'];

$page['L_content_settings']=$lang['administration']['content_settings'];
$page['L_content_settings_ab']=$lang['administration']['content_settings_ab'];
$page['L_nb_item_page']=$lang['administration']['nb_item_page'];
$page['L_nb_item_home_page']=$lang['administration']['nb_item_home_page'];
$page['L_news']=$lang['general']['news'];
$page['L_club']=$lang['general']['club'];
$page['L_team']=$lang['general']['team'];
$page['L_member']=$lang['general']['member'];
$page['L_match']=$lang['general']['match'];
$page['L_competition']=$lang['general']['competition'];
$page['L_field']=$lang['general']['field'];
$page['L_forum_topic']=$lang['general']['forum_topic'];
$page['L_forum_message']=$lang['general']['forum_message'];

$page['L_registration']=$lang['administration']['registration'];
$page['L_registration_ab']=$lang['administration']['registration_ab'];
$page['L_activate_registration']=$lang['administration']['activate_registration'];
$page['L_activate_registration_info']=$lang['administration']['activate_registration_info'];
$page['L_registration_mail']=$lang['administration']['registration_mail'];
$page['L_registration_mail_info']=$lang['administration']['registration_mail_info'];

$page['L_erreur']=$lang['administration']['erreur'];
$page['L_valider']=$lang['administration']['submit'];

$page['meta_title']=$lang['administration']['parametre'];
$page['template']=$tpl['administration']['configuration'];

?>