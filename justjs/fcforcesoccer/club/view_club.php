<?php
# view du club
$page['L_message_club']="";
$page['team']=array(); 
# we get the ID
$page['id']=$_GET['v2'];

# mode club 
$page['aff_club']="1";
if(CLUB!=0) {
	$page['value_club']=CLUB;
	$page['aff_club']="";
}


if($right_user['view_club']) {
	$page['show_view']=1; 
}
else {
	$page['show_view']='';
	$page['L_message_club']=$lang['general']['acces_reserve_admin'];
}

# we get the information on the club
if(isset($page['id']) AND $page['id']!="")
{
 $sql_details=sql_replace($sql['club']['select_club_details'],$page);

 $sgbd = sql_connect();
 $res = sql_query($sql_details);
 $ligne = sql_fetch_array($res);
 sql_free_result($res);
 sql_close($sgbd);

 $page['id']=$ligne['club_id'];
 $page['name']=$ligne['club_name'];
 $page['abbreviation']=$ligne['club_abbreviation'];
 $page['logo']=$ligne['club_logo'];
 $page['address']=nl2br($ligne['club_address']);
 $page['color']=$ligne['club_color'];
 $page['color_alternative']=$ligne['club_color_alternative'];
 $page['telephone']=$ligne['club_telephone'];
 $page['fax']=$ligne['club_fax'];
 $page['email']=$ligne['club_email'];
 $page['url']=$ligne['club_url'];
 $page['creation_year']=$ligne['club_creation_year'];
 $page['comment']=nl2br($ligne['club_comment']);
 
 if($page['creation_year']==NULL) $page['creation_year']="";
 if($page['abbreviation']==NULL) $page['abbreviation']="";
 if($page['logo']==NULL) $page['logo']="";
 if($page['address']==NULL) $page['address']="";
 if($page['color']==NULL) $page['color']="";
 if($page['color_alternative']==NULL) $page['color_alternative']="";
 if($page['telephone']==NULL) $page['telephone']="";
 if($page['fax']==NULL) $page['fax']="";
 if($page['fax']==NULL) $page['fax']="";
 if($page['email']==NULL) $page['email']="";
 if($page['url']==NULL) $page['url']="";
 if($page['comment']==NULL) $page['comment']="" ;
}
else
{
 $page['L_message_club']=$lang['club']['E_erreur_presence_club'];
}

# team of the club list
if($right_user['view_club']) {
	$included=1;
	include_once(create_path("team/sql_team.php"));
	include_once(create_path("team/lg_team_".LANG.".php"));
	include_once(create_path("team/tpl_team.php"));
	$var['condition']=" WHERE e.club_id='".$page['id']."'";
	$var['order']=" ORDER BY ne.team_name_order ";
	$var['limit']="";
	include(create_path("team/team_list.php"));
	unset($included);
	$page['team']=$page['team'];
	$page['L_team']=$lang['team']['team_list'];
}
# managers of the club list
$page['season_defaut']="";
$page['season']=array();
include_once(create_path("competition/sql_competition.php"));
include_once(create_path("competition/lg_competition_".LANG.".php"));
include_once(create_path("member/sql_member.php"));
include_once(create_path("member/lg_member_".LANG.".php"));

include_once(create_path("competition/tpl_competition.php"));
$sql_liste=$sql['competition']['select_season'];
$sgbd = sql_connect();
$res_liste = sql_query($sql_liste);
$nb_ligne_s = sql_num_rows($res_liste);
$is="0";
$page['nb_dirigeant']=0;
while($ligne = sql_fetch_array($res_liste))
{  
  # manager for the season 
  $var['condition']=" WHERE mc.club_id='".$page['id']."' AND mc.season_id='".$ligne['season_id']."' AND mf.season_id='".$ligne['season_id']."'";
  $var['order']=" ORDER BY f.job_name ASC";
  $var['limit']="";
  $sql_dirigeant=sql_replace($sql['member']['select_member_job_club'],$var);
 
  
  $sgbd = sql_connect();
  $res_dirigeant = sql_query($sql_dirigeant);
  $nb_ligne_dirigeant=sql_num_rows($res_dirigeant);
  
  if($nb_ligne_dirigeant!="0")
  {
  	 $j="0";
	 while($ligne_dirigeant = sql_fetch_array($res_dirigeant))
	 {
	  $page['season'][$is]['dirigeant'][$j]['i']=$page['nb_dirigeant'];
	  $page['season'][$is]['dirigeant'][$j]['season']=$is;
	  $page['season'][$is]['dirigeant'][$j]['job']=$ligne_dirigeant['job_name'];
	  $page['season'][$is]['dirigeant'][$j]['dirigeant']=$ligne_dirigeant['member_id'];	  
	  $page['season'][$is]['dirigeant'][$j]['dirigeant_text']=$ligne_dirigeant['member_firstname']." ".$ligne_dirigeant['member_lastname'];
	  $page['season'][$is]['dirigeant'][$j]['season_dirigeant']=$ligne_dirigeant['season_id'];
	  $page['season'][$is]['dirigeant'][$j]['link_view']=convert_url("index.php?r=".$lang['general']['idurl_member']."&v1=view&v2=".$ligne_dirigeant['member_id']);
	  
	  $page['season'][$is]['dirigeant'][$j]['mod']=$j%2;

	  $j++;
	  $page['nb_dirigeant']++;
	 }

  sql_free_result($res_dirigeant);
    
  # if there is a list one manager, we can show the season
	 $page['season'][$is]['i']=$is;
	 $page['season'][$is]['id']=$ligne['season_id'];
	 $page['season'][$is]['name']=$ligne['season_name'];
	 $page['season'][$is]['abbreviation']=$ligne['season_abbreviation'];
	 $page['season'][$is]['class']="";
	  
	 $page['season'][$is]['L_dirigeant']=$lang['member']['dirigeant'];
	 $page['season'][$is]['L_job']=$lang['member']['job'];
	
	 if($is==0) { $page['season'][$is]['display']="block";
	 $page['season'][$is]['class']="on";
	  } else { $page['season'][$is]['display']="none"; } 

	 $is++;	 
 }

}
sql_free_result($res_liste);
sql_close($sgbd);

$page['nb_season']=$is;
$page['L_season']=$lang['competition']['season'];
$page['L_choose_season']=$lang['competition']['choose_season'];
$page['L_dirigeant']=$lang['member']['member_job_list'];

$page['aff_dirigeant']="";
if($page['nb_dirigeant']!=0) { $page['aff_dirigeant']="1"; }
else { $page['season']=array(); }

# link 
$page['link_match']=convert_url("index.php?r=".$lang['general']['idurl_match']."&v1=match_list&v2=club_".$page['id']); 


# modification
$page['link_edit']="";
$page['link_delete']="";

if($right_user['edit_club']) { 
 $page['link_edit']=convert_url("index.php?r=".$lang['general']['idurl_club']."&v1=form_club&v2=".$page['id']);
}
if($right_user['delete_club']) {
 $page['link_delete']=convert_url("index.php?r=".$lang['general']['idurl_club']."&v1=club_list&v2=delete&v3=".$page['id']);
}

# text
$page['L_title']=$page['name'];
$page['L_club']=$lang['club']['club'];
$page['L_name']=$lang['club']['name'];
$page['L_abbreviation']=$lang['club']['abbreviation'];
$page['L_creation_year']=$lang['club']['creation_year'];
$page['L_color']=$lang['club']['color'];
$page['L_color_alternative']=$lang['club']['color_alternative'];
$page['L_address']=$lang['club']['address'];
$page['L_telephone']=$lang['club']['telephone'];
$page['L_fax']=$lang['club']['fax'];
$page['L_email']=$lang['club']['email'];
$page['L_url']=$lang['club']['url'];
$page['L_comment']=$lang['club']['comment'];
$page['L_details']=$lang['club']['details'];

$page['L_view_match']=$lang['club']['view_match']; 
$page['L_edit']=$lang['club']['edit'];
$page['L_delete']=$lang['club']['delete'];


# meta
$page['meta_title']=$page['name'];

$page['template']=$tpl['club']['view_club'];
?>