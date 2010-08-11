<?php
if(!isset($included_mini_standings) OR $included_mini_standings==0) {
	header('Content-type: text/html; charset='.$lang['general']['charset']);
}

$show_stats=$ms_column;
$nb_club_max=MS_NB_CLUB_MAX;

$page['ms_show_form']=MS_SHOW_FORM;

if(!isset($_POST['season']) AND MS_SEASON!='') $page['value_season']=MS_SEASON;
if(!isset($_POST['competition']) AND MS_COMPETITION!='') $page['value_competition']=MS_COMPETITION;
if(!isset($_POST['round']) AND MS_ROUND!='') $page['value_round']=MS_ROUND;

$included=1;
include(create_path("match/standings.php"));
unset($included);

if($page['ms_show_form']==0) {
	$page['season']=array();
	$page['competition']=array();
	$page['round']=array();
}

# link
$page['form_action']=convert_url("index.php?r=".$lang['general']['idurl_match']."&v1=mini_standings");
$page['link_standings']=convert_url("index.php?r=".$lang['general']['idurl_match']."&v1=standings&v2=".$page['value_competition']."&v3=".$page['value_round']."&v4=".$page['value_season']);

# text
$page['L_place']=$lang['match']['place_ab'];
$page['L_show_standings']=$lang['match']['show_standings'];

# template
if(!isset($included_mini_standings) OR $included_mini_standings==0) { $page['fen']="ajax"; }
$page['template']=$tpl['match']['mini_standings'];

$_SESSION['session_mini_standings']=parse_template(TPL_URL.$page['template'],$page);
?>