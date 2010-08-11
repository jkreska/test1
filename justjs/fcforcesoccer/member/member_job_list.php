<?php

$page['member_job']=array();
$page['L_message_member_job']="";

if(isset($_POST['season']) AND !empty($_POST['season'])) { $var['value_season']=$_POST['season']; }
if(isset($_POST['club']) AND !empty($_POST['club'])) { $var['value_club']=$_POST['club']; }

# mode club 
$page['aff_club']="1";
if(CLUB!=0) {
$var['value_club']=CLUB;
$page['aff_club']="";
}

# liste des seasons
$page['season']=array();
include_once(create_path("competition/sql_competition.php"));
include_once(create_path("competition/lg_competition_".LANG.".php"));
include_once(create_path("competition/tpl_competition.php"));
$included=1;
include(create_path("competition/season_list.php"));
unset($included);
$page['season']=$page['season'];

if(!isset($page['season']['0']['id']) OR empty($page['season']['0']['id'])) { $var['value_season']=""; }
elseif(!isset($var['value_season']) OR empty($var['value_season'])) { $var['value_season']=$page['season']['0']['id']; }


$var['condition']=" WHERE mf.season_id='".$var['value_season']."' ";
if(isset($var['value_club']) AND !empty($var['value_club']))
$var['condition'].=" AND mc.club_id='".$var['value_club']."' AND mc.season_id='".$var['value_season']."' ";
$var['order']=" ORDER BY f.job_name ASC";
$var['limit']="";

$sql_member=sql_replace($sql['member']['select_member_job_club'],$var);

$sgbd = sql_connect();
$res_member = sql_query($sql_member);
$nb_ligne=sql_num_rows($res_member);
if(!$right_user['member_job_list']) {
	$page['L_message_member_job']=$lang['general']['acces_reserve_admin'];
}
elseif($nb_ligne=="0")
{
 $page['L_message_member_job']=$lang['member']['E_member_not_found']; 
}
else
{
 $i="-1";
 $j="0";
 $tmp="";
 while($ligne = sql_fetch_array($res_member))
 {
  if($tmp!=$ligne['job_name']) {
   $i++;
   $page['member_job'][$i]['job']=$ligne['job_name'];
   $page['member_job'][$i]['member']=array();
   $page['member_job'][$i]['mod']=$i%2;
   $j="0"; 
   $tmp=$ligne['job_name']; 
  }  
  
  $page['member_job'][$i]['member'][$j]['id']=$ligne['member_id'];
  $page['member_job'][$i]['member'][$j]['name']=$ligne['member_lastname'];
  $page['member_job'][$i]['member'][$j]['firstname']=$ligne['member_firstname'];
  $page['member_job'][$i]['member'][$j]['email']=$ligne['member_email'];
  $page['member_job'][$i]['member'][$j]['sex']=$ligne['sex_name'];
  $page['member_job'][$i]['member'][$j]['sex_abbreviation']=$ligne['sex_abbreviation']; 
  $page['member_job'][$i]['member'][$j]['comment']=$ligne['member_comment'];
  $page['member_job'][$i]['member'][$j]['club']=$ligne['club_name'];
  $page['member_job'][$i]['member'][$j]['aff_club_liste']=$page['aff_club'];

  $page['member_job'][$i]['member'][$j]['link_view']=convert_url("index.php?r=".$lang['general']['idurl_member']."&v1=view&v2=".$ligne['member_id']); 

  $page['member_job'][$i]['member'][$j]['link_edit']="";
  $page['member_job'][$i]['member'][$j]['link_delete']="";
    
  if($right_user['edit_member'])
  {
   $page['member_job'][$i]['member'][$j]['link_edit']=convert_url("index.php?r=".$lang['general']['idurl_member']."&v1=form_member&v2=".$ligne['member_id']);   
  }
  if($right_user['delete_member'])
  {
	$page['member_job'][$i]['member'][$j]['link_delete']=convert_url("index.php?r=".$lang['general']['idurl_member']."&v1=member_list&v2=delete&v3=".$ligne['member_id']);
  }
    
  //if($tmp!=$ligne['job_name']) { $i++; }  
    
  $j++;
 }
}
sql_free_result($res_member);
sql_close($sgbd);

# liste des clubs
$page['club']=array();
if($page['aff_club']==1)
{
include_once(create_path("club/sql_club.php"));
include_once(create_path("club/lg_club_".LANG.".php"));
include_once(create_path("club/tpl_club.php"));
$var['condition']="";
$var['order']="";
$var['limit']="";
$included=1;
include(create_path("club/club_list.php"));
unset($included);
$page['club']=$page['club'];
}


$page['form_action']=convert_url("index.php?r=".$lang['general']['idurl_member']."&v1=manager_list");
if($right_user['add_member']) {
  $page['link_add']=convert_url("index.php?r=".$lang['general']['idurl_member']."&v1=form_member");
 }
else {
 $page['link_add']="";
}

$page['L_add']=$lang['member']['add_member'];
$page['L_choose_season']=$lang['member']['choose_season'];
$page['L_dirigeant']=$lang['member']['dirigeant'];
$page['L_job']=$lang['member']['job'];

$page['L_choose_club']=$lang['member']['choose_club'];

$page['L_title']=$lang['member']['member_job_list'];
$page['meta_title']=$lang['member']['member_job_list'];

$page['template']=$tpl['member']['member_job_list']; 

?>