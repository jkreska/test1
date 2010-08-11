<?php
# define the rights of a member

$right_user=array();

# we get the member group
if(MEMBER_ID==0) { $var['group']=1; } // it is a simple visitor
else { $var['group']=$_SESSION['session_status']; } 

# we get the corresponding rights for this group
if(!isset($_SESSION['session_user_right']) OR empty($_SESSION['session_user_right'])) {
	$sql_right_group=sql_replace($sql['member']['select_group_right'],$var);
	$sgbd=sql_connect();
	$res_right=sql_query($sql_right_group);
	while($ligne=sql_fetch_array($res_right)) {
		$id=$ligne['right_id'];
		$right_user[$id]=$ligne['value'];
	}
	sql_close($sgbd);
	$_SESSION['session_user_right']=$right_user;
}

$right_user=$_SESSION['session_user_right'];

$affichage=1;
/* Define the access of the files by everybody (defaut) members (0), admin (1) and super admin (2)*/
/*$droit_defaut=array("view","member_list",
"news_list","view_news",
"club_list","view_club",
"competition_list","view_competition",
"team_list","view_team","coach_list","player_list",
"page_list",
"field_list",
"match_list","statistique_match","standings","stats_player","mini_standings",
"member_list","manager_list","registration","activation","forgot_pass",
"login","logout",
"forum_list",
"image_manager");

$droit_admin_0=array("home_member","profile");
$droit_admin_1=array();
$droit_admin_2=array(
"configuration","admin",
"form_news",
"form_club", "import_club",
"form_competition","season_list",
"form_team","team_name_list","position_list",
"form_page",
"form_field",
"form_match","action_list","field_state_list","weather_list","period_list","stats_list", "stats_player_list",
"form_member","position_list","level_list","country_list","sex_list","job_list","import_member","registration_list","registration_validation",
"form_forum");

# we add the files of the several plugins
if(isset($plugin_admin) AND !empty($plugin_admin)) {
 $droit_admin_2=array_merge($droit_admin_2,$plugin_admin);
}



$affichage=1;
if(isset($_GET['v1']) AND $_GET['v1']!="")
{
 if(in_array($_GET['v1'],$droit_admin_0) AND (!isset($_SESSION['session_status']) OR $_SESSION['session_status']<"0"))
 {
  $page['L_title']=$lang['general']['acces_reserve'];
  $affichage=0;
  $page['template']=$tpl['general']['message'];
  $page['L_message']=$lang['general']['acces_reserve_member'];
  $page['erreur']=array();
 }
 if(in_array($_GET['v1'],$droit_admin_1) AND (!isset($_SESSION['session_status']) OR $_SESSION['session_status']<"1"))
 {
  $page['L_title']=$lang['general']['acces_reserve'];
  $affichage=0;
  $page['template']=$tpl['general']['message'];
  $page['L_message']=$lang['general']['acces_reserve_admin'];
  $page['erreur']=array();
 }
 if(in_array($_GET['v1'],$droit_admin_2) AND (!isset($_SESSION['session_status']) OR $_SESSION['session_status']<"2"))
 {
  $page['L_title']=$lang['general']['acces_reserve'];
  $affichage=0;
  $page['template']=$tpl['general']['message'];
  $page['L_message']=$lang['general']['acces_reserve_admin'];
  $page['erreur']=array();
 }
}


if(isset($_GET['v2']) AND $_GET['v2']=="message" AND (!isset($_SESSION['session_status']) OR $_SESSION['session_status']<"0"))
{
 $page['L_title']=$lang['general']['acces_reserve'];
 $affichage=0;
 $page['template']=$tpl['general']['message'];
 $page['L_message']=$lang['general']['acces_reserve_member'];
 $page['erreur']=array();
}

*/


?>