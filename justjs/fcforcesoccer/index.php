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

if(file_exists("my_code/index.php") AND !isset($included_index)) {
	$included_index=1;
	include("my_code/index.php");
	exit();
}

/****************/
/* PHP SESSIONS */
/****************/
session_start();

/***************************/
/* VARIABLES et CONSTANTES */
/***************************/
define("VERSION_SITE","1.4"); # script version
$page=array();
$index=array();
/***************************/

# create the path of a file
if(!function_exists('create_path')) {
	function create_path($file) {
		# we check if a customize file exists	
		if(file_exists(ROOT."/my_code/".$file)) {
			return ROOT."/my_code/".$file;
		}
		else {
			return ROOT."/".$file;
		}	
	}
}

/*******************/
/* REQUIRED FILES  */
/*******************/
@include_once("include/conf.php");

if(!defined("SITE_OPEN")) define("SITE_OPEN","1");
if(!defined("SITE_TITLE")) define("SITE_TITLE","");
if(!defined("ROOT")) define("ROOT",".");
if(!defined("ROOT_URL")) define("ROOT_URL",".");

if(!defined("CONF_INCLUDED")) { header("location:installation/"); exit(); }
#elseif(SITE_OPEN==0) { $var=""; }
elseif(VERSION_SITE==VERSION && file_exists(ROOT."/installation/index.php"))
{
 header("location:".ROOT_URL."/installation/index.php?lg=".LANG."&r=message"); 
 exit();
}
elseif(VERSION_SITE!=VERSION)
{
 header("location:".ROOT_URL."/installation/index.php?lg=".LANG."&r=update"); 
 exit();
}

require_once(create_path("include/form.php"));
require_once(create_path("include/sgbd.php"));
include_once(create_path("include/fonction.php"));

/* fichiers communs */
/*
require_once(create_path("image/sql_image.php"));
include_once(create_path("include/image.php"));
include_once(create_path("include/search.php"));
*/

/***************************/

/************************/
/* LANGUAGE MANAGEMENT  */
/************************/
if(!@include_once(create_path("include/lg_general_".LANG.".php")))
{
 echo "ERREUR : Language not supported/Langue non supportée";
 exit();
}

setlocale(LC_ALL, $lang['general']['setlocale_parameters']); # define local language
/*************************/


/*************************/
/* TEMPLATES MANAGEMENT  */
/*************************/
include(create_path("include/template.php"));
/*************************/

require_once(create_path("member/sql_member.php"));
require_once(create_path("member/lg_member_".LANG.".php"));

if(isset($_SESSION['session_member_id'])) { define("MEMBER","1",1); define("MEMBER_ID",$_SESSION['session_member_id'],1); }
else { define("MEMBER","0",1); define("MEMBER_ID","0",1); }
/* END SESSIONS */


/* AUTO CONNEXION
si il y a un cookie valid, que le member n'est pas
deja connecte et qu'on est pas deja sur la page de connection,
on redirige vers la page de connection
*/
/*
if(isset($_COOKIE['auto_connection']) AND $_COOKIE['auto_connection']==1
AND (!isset($_SESSION['session_member_id']) OR $_SESSION['session_member_id']==0)
AND (!isset($_GET['v1']) OR $_GET['v1']!="login"))
{
 $url_redirection=convert_url("index.php?lg=".LANG."&s=".SECTION."&r=".$lang['general']['idurl_member']."&v1=login");
 header("location:".$url_redirection);
 exit();
}
*/

/********************************/
/* PLUGIN MANAGEMENT   */
/********************************/
include_once(create_path("plugin/plugin_list.php"));

/********************************/
/* USER RIGHTS AND PERMISSIONS */
/********************************/
include_once(create_path("member/group_right.php"));

/***************************/
/* SIGN IN FORM            */
/***************************/
$index['menu_member']="";
$index['form_connection']="";

if(!isset($_SESSION['session_login']))
{
 include_once(create_path("member/form_connection.php"));
 $index['form_connection']="1";
} 
else
{
 include_once(create_path("member/menu_member.php"));
 $index['menu_member']="1";
}

/****************************/
/* MINI STANDINGS           */
/****************************/
$index['mini_standings']="";
if(!isset($_SESSION['session_mini_standings']) OR empty($_SESSION['session_mini_standings'])) {
	if(MS_SHOW!='none') {
		include_once(ROOT.'/match/sql_match.php');
		include_once(ROOT.'/match/tpl_match.php');
		include_once(ROOT.'/match/lg_match_'.LANG.'.php');
		$included_mini_standings=1;
		include(ROOT.'/match/mini_standings.php');
		unset($included_mini_standings);
		//$_SESSION['session_mini_standings']=parse_template(TPL_URL.$page['template'],$page);
	}	
}

if(MS_SHOW=='all') {
	$index['mini_standings']=$_SESSION['session_mini_standings'];
}


/****************************/
/* MENUS                    */
/****************************/
include_once(create_path("menu.php"));

// menu admin
$index['menu_admin']="";

if($right_user['home'] OR $right_user['admin'] OR $right_user['configuration']) {
 include_once(create_path("administration/menu_admin.php"));
 $index['menu_admin']="1";
}

// we check if the site is open
if(SITE_OPEN!=1 AND (!isset($_GET['v1']) OR $_GET['v1']!="login") AND (!isset($_SESSION['session_status']) OR $_SESSION['session_status']<"2"))
{
 $page['L_title']=$lang['general']['site_construction'];
 $affichage=0;
 $page['template']=$tpl['general']['message'];
 $page['L_message']=$lang['general']['site_construction_text'];
 $page['erreur']=array();
}

/********************************/
/* PAGE TO INCLUDE MANAGEMENT   */
/********************************/
/*
Important : l'url de la page est de type : index.php?lg=XX&r=xxxxxx&v1=xxxxx
selon l'url, on regarde dans quelle rubrique on est (variable $_GET['r'])
puis eventuellement dans quelle sous-rubrique  $_GET['v1']
*/

$index['class_home']="";
$index['class_news']="";
$index['class_information']="";
$index['class_club']="";
$index['class_match']="";
$index['class_member']="";
$index['class_image']="";
$index['class_team']="";
$index['class_forum']="";
$index['class_competition']="";
$index['class_field']="";
$index['class_forum']="";

$in_plugin=0;

/* if the page can be included */
if($affichage==1)
{
/* we look at the section (rubrique) */
 if(isset($_GET['r']) AND $_GET['r']!="")
 {
 /* rubrique administration */
 switch($_GET['r']) {
  case $lang['general']['idurl_admin'] : require_once(create_path("administration/include.php")); $index['class_home']='on'; break;
  case $lang['general']['idurl_news'] : require_once(create_path("news/include.php")); $index['class_news']='on'; break;
  case $lang['general']['idurl_information'] : require_once(create_path("information/include.php")); $index['class_information']='on'; break;
  case $lang['general']['idurl_club'] : require_once(create_path("club/include.php")); $index['class_club']='on'; break;
  case $lang['general']['idurl_match'] : require_once(create_path("match/include.php")); $index['class_match']='on'; break;
  case $lang['general']['idurl_member'] : require_once(create_path("member/include.php")); $index['class_member']='on'; break;
  case $lang['general']['idurl_file'] : require_once(create_path("file/include.php")); $index['class_file']=''; break;
  case $lang['general']['idurl_team'] : require_once(create_path("team/include.php")); $index['class_team']='on'; break;
  case $lang['general']['idurl_forum'] : require_once(create_path("forum/include.php")); $index['class_forum']='on'; break;
  case $lang['general']['idurl_competition'] : require_once(create_path("competition/include.php")); $index['class_competition']='on'; break;
  case $lang['general']['idurl_field'] : require_once(create_path("field/include.php")); $index['class_field']='on'; break;
  case $lang['general']['idurl_forum'] : require_once(create_path("forum/include.php")); $index['class_forum']='on'; break;
  case $lang['general']['idurl_file'] : require_once(create_path("file/include.php"));  break;   
  default : 
   # if plugin
   if(in_array($_GET['r'],$plugin_list))
   {
    $key=array_search($_GET['r'], $plugin_list); # we search for the key corresponding to the value	
	$plugin[$key]['class']='on';
	require_once($plugin[$key]['root']."/include.php");
	$in_plugin=1;
   }
   else { require_once(create_path("home.php")); $index['class_home']='on'; }
  }
 }
 else
 {
  require_once(create_path("home.php")); $index['class_home']='on';
 }
 
 if(CLUB!=0){

  if(isset($_GET['r']) AND $_GET['r']==$lang['general']['idurl_club'] AND isset($_GET['v2']) AND $_GET['v2']==CLUB) 
  { 
   $index['class_information']='on';
   $index['class_club']="";
  }
 }
}
/***************************/



/**********************/
/* Text elements   */
/**********************/
$index['L_realisation']=$lang['general']['realisation'];
$index['L_confirmation']=$lang['general']['confirmation_suppression'];
$index['link_choose_file']=convert_url("index.php?r=".$lang['general']['idurl_file']."&v1=image_manager&fen=pop",0);


/******************************************/
/* META : TITLE, DESCRIPTION AND KEYWORDS */
/******************************************/
/*
we look if there is a title, a description and keywword if the included page.
If there is not, we add the default information 
*/

$index['meta_lang']=LANG;
$index['meta_charset']=$lang['general']['charset'];

/* title */
if(isset($page['meta_title']) AND $page['meta_title']!="") { $index['meta_title']=SITE_TITLE." &gt; ".$page['meta_title']; }
else { $index['meta_title']=SITE_TITLE; }

/* description */
if(isset($page['meta_description']) AND $page['meta_description']!="") { $index['meta_description']=$page['meta_description']; }
else { $index['meta_description']=$lang['general']['meta_description']; }

/* mots cles */
if(isset($page['meta_keyword']) AND $page['meta_keyword']!="") { $index['meta_keyword']=$page['meta_keyword']; }
else { $index['meta_keyword']=$lang['general']['meta_keyword']; }

/* url */
$index['meta_url']=ROOT_URL;
$index['page_url']=ROOT_URL;
if(isset($_SERVER['QUERY_STRING']) AND $_SERVER['QUERY_STRING']!="")
{ $index['page_url']=convert_url("index.php?".$_SERVER['QUERY_STRING']); }

/*****************************************/


/**********************/
/* PAGE MAIN CONTENT  */
/**********************/
/* on cherche si le contenu a un template declare */
/* si ce n'est pas le cas, erreur, sinon on charge le contenu */
if(!isset($page['template']))
{
 $page['template']=$tpl['general']['message'];
 $page['L_message']="Template non trouvé";
 $page['erreur']=array();
}

if($in_plugin==1) { $index['contenu']=parse_template(ROOT."/plugin/".$page['template'],$page); }
else { $index['contenu']=parse_template(TPL_URL.$page['template'],$page); }
/**********************/


/***********************/
/* PAGE CREATION       */
/***********************/
/*
 choix du template principal :
 page normale (par defaut), pop-up ou page pour impression
*/
if(eregi("fen_pop",$_SERVER['QUERY_STRING'])) $page['fen']="pop";
if(eregi("fen_impression",$_SERVER['QUERY_STRING'])) $page['fen']="impression";

if(isset($page['fen']) AND $page['fen']=="pop")
{
 $template=$tpl['general']['pop']; 
 $html_code=parse_template(TPL_URL.$template,$index);
}
elseif(isset($_GET['fen']) AND $_GET['fen']=="pop")
{
 $template=$tpl['general']['pop'];
 $html_code=parse_template(TPL_URL.$template,$index);
}
elseif(isset($page['fen']) AND $page['fen']=="ajax")
{
 $html_code=$index['contenu'];
}
elseif(isset($page['fen']) AND $page['fen']=="impression")
{
 $template=$tpl['general']['imprime'];
 $html_code=parse_template(TPL_URL.$template,$index);
}
else
{
 $template=$tpl['general']['index'];
 $html_code=parse_template(TPL_URL.$template,$index);
}

echo $html_code;

/***********************/
?>