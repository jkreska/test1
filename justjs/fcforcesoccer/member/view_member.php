<?php
# view du member
$page['L_message']="";

# we get the ID
$page['id']=$_GET['v2'];

# we get the information on the member
if(isset($page['id']) AND $page['id']!="")
{
 $sql_details=sql_replace($sql['member']['select_member_details'],$page);

 $sgbd = sql_connect();
 $res = sql_query($sql_details);
 $ligne = sql_fetch_array($res);
 sql_free_result($res);

 $page['id']=$ligne['member_id'];
 $page['name']=$ligne['member_lastname'];
 $page['firstname']=$ligne['member_firstname'];
 $page['email']=$ligne['member_email'];
 $page['photo']=$ligne['member_photo'];
 if($page['photo']==NULL) $page['photo']="";
 $page['date_birth']=convert_date($ligne['member_date_birth'],$lang['member']['format_date_php']); 
 
 if($page['date_birth']!='') {
	$page['age']=calcul_age($ligne['member_date_birth']);
 }
 else { 
	$page['age']='';
 } 
 $page['place_birth']=$ligne['member_place_birth']; if($page['place_birth']==NULL) $page['place_birth']="";
 $page['size']=$ligne['member_size']; if($page['size']==NULL) $page['size']="";
 $page['weight']=$ligne['member_weight']; if($page['weight']==NULL) $page['weight']="";
 $page['comment']=nl2br($ligne['member_comment']);
 $page['sex']=$ligne['sex_id'];
 $page['country']=$ligne['country_id'];
 
 # sex
 $var['id']=$page['sex'];
 $sql_sex=sql_replace($sql['member']['select_sex_details'],$var);
 $res = sql_query($sql_sex);
 $ligne = sql_fetch_array($res); 
  if($ligne['sex_name']!=NULL) $page['sex']=$ligne['sex_name'];
  else $page['sex']="";
 $page['sex_abbreviation']=$ligne['sex_abbreviation']; 
 sql_free_result($res);
 
 # country
 $var['id']=$page['country'];
 $sql_country=sql_replace($sql['member']['select_country_details'],$var);
 $res = sql_query($sql_country);
 $ligne = sql_fetch_array($res); 
  if($ligne['country_name']!=NULL) $page['country']=$ligne['country_name'];
  else $page['country']="";     
 sql_free_result($res);
 sql_close($sgbd); 
}
else
{
 $page['L_message']=$lang['member']['E_erreur_presence_member'];
}

# member_club
$page['member_club']=array();
$var['condition']=" WHERE mc.member_id='".$page['id']."' ";
$var['order']=" ORDER BY s.season_date_start DESC";
$var['limit']="";
$sql_member_club=sql_replace($sql['member']['select_member_club'],$var);
$sgbd = sql_connect();
$res_member_club = sql_query($sql_member_club);
$nb_ligne=sql_num_rows($res_member_club);
if($nb_ligne!="0")
{
 $i="0";
 while($ligne = sql_fetch_array($res_member_club))
 {
  $page['member_club'][$i]['i']=$i;
  $page['member_club'][$i]['club']=$ligne['club_id'];
  $page['member_club'][$i]['club_text']=$ligne['club_name'];
  $page['member_club'][$i]['season']=$ligne['season_id'];
  $page['member_club'][$i]['season_text']=$ligne['season_name'];
  $page['member_club'][$i]['link_club']=convert_url("index.php?r=".$lang['general']['idurl_club']."&v1=view&v2=".$ligne['club_id']); 
  $page['member_club'][$i]['mod']=$i%2;

  $i++;
 }
}
sql_free_result($res_member_club);
sql_close($sgbd);


# member_job
$page['member_job']=array();
$var['condition']=" WHERE mf.member_id='".$page['id']."' ";
$var['order']=" ORDER BY s.season_date_start DESC";
$var['limit']="";
$sql_member_job=sql_replace($sql['member']['select_member_job'],$var);

$sgbd = sql_connect();
$res_member_job = sql_query($sql_member_job);
$nb_ligne=sql_num_rows($res_member_job);
if($nb_ligne!="0")
{
 $i="0";
 while($ligne = sql_fetch_array($res_member_job))
 {
  $page['member_job'][$i]['i']=$i;
  $page['member_job'][$i]['job']=$ligne['job_id'];
  $page['member_job'][$i]['job_text']=$ligne['job_name'];
  $page['member_job'][$i]['season']=$ligne['season_id'];
  $page['member_job'][$i]['season_text']=$ligne['season_name'];
  $page['member_job'][$i]['L_delete']=$lang['member']['delete'];    
  $page['member_job'][$i]['mod']=$i%2;
  $i++;
 }
}
sql_free_result($res_member_job);
sql_close($sgbd);

# team_player
include_once(create_path("team/sql_team.php"));
include_once(create_path("team/lg_team_".LANG.".php"));
include_once(create_path("team/tpl_team.php"));
$var['condition']=" WHERE m.member_id='".$page['id']."' ";
$var['order']=" ORDER BY s.season_date_start DESC ";
$var['limit']="";
$included=1;
include(create_path("team/team_player_list.php"));
unset($included);
$page['team_player']=$page['team_player'];
$page['L_team_player']=$lang['member']['team_player'];

# team_coach
$var['condition']=" WHERE m.member_id='".$page['id']."' ";
$var['order']=" ORDER BY s.season_date_start DESC ";
$var['limit']="";
$included=1;
include(create_path("team/team_coach_list.php"));
unset($included);
$page['team_coach']=$page['team_coach'];

$page['L_team_coach']=$lang['member']['team_coach'];

# player stat


# link
$page['link_edit']="";
$page['link_delete']="";
if($right_user['edit_member'])
{
 $page['link_edit']=convert_url("index.php?r=".$lang['general']['idurl_member']."&v1=form_member&v2=".$page['id']);
}
if($right_user['delete_member'])
{
 $page['link_delete']=convert_url("index.php?r=".$lang['general']['idurl_member']."&v1=member_list&v2=delete&v3=".$page['id']);
}

# text
$page['L_title']=$page['name'];
$page['L_member']=$lang['member']['member'];
$page['L_identity']=$lang['member']['identity'];
$page['L_name']=$lang['member']['name'];
$page['L_date_birth']=$lang['member']['date_birth'];
$page['L_place_birth']=$lang['member']['place_birth'];
$page['L_age']=$lang['member']['age'];
$page['L_age_unit']=$lang['member']['age_unit'];
$page['L_email']=$lang['member']['email'];
$page['L_size']=$lang['member']['size'];
$page['L_size_unit']=$lang['member']['size_unit'];
$page['L_weight']=$lang['member']['weight'];
$page['L_weight_unit']=$lang['member']['weight_unite'];
$page['L_sex']=$lang['member']['sex'];
$page['L_firstname']=$lang['member']['firstname'];
$page['L_comment']=$lang['member']['comment'];
$page['L_country']=$lang['member']['nationality'];

$page['L_member_club']=$lang['member']['member_club'];
$page['L_member_job']=$lang['member']['member_job'];

$page['L_club']=$lang['member']['club'];
$page['L_season']=$lang['member']['season'];
$page['L_job']=$lang['member']['job'];

$page['L_stats']=$lang['member']['stats'];


$page['L_edit']=$lang['member']['edit'];
$page['L_delete']=$lang['member']['delete'];


# meta
$page['meta_title']=$page['firstname']." ".$page['name'];

$page['template']=$tpl['member']['view_member'];
?>