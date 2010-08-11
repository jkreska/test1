<?php
# liste team player
$nb_max="20"; // number team par page

$page['team_player']=array();
$page['link_first_page']="";
$page['link_previous_page']="";
$page['link_last_page']="";
$page['link_next_page']="";

$page['L_message_team_player']="";

if(isset($_POST['season']) AND !empty($_POST['season'])) { $var['value_season']=$_POST['season']; }

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

# mode club 
$page['aff_club']="1";
if(CLUB!=0) {
$page['value_club']=CLUB;
$page['aff_club']="";
}

# TRI
# $_GET['v1'] is a variable like : page_1_name_asc
if(isset($_GET['v1']) AND eregi("page",$_GET['v1']))
{
 $v=explode("_",$_GET['v1']);
 $page_num=$v['1'];
 $tri=$v['2'];
 $ordre=$v['3'];
}
elseif(isset($_POST['page']) AND !empty($_POST['page']))
{
 $page_num=$_POST['page'];
 $tri=$_POST['tri'];
 $ordre=$_POST['ordre'];
}
else
{
 $page_num=1; // number of the page
 $tri="club"; // tri par defaut
 $ordre="asc"; // ordre par defaut
}

# ORDRE (sens)
if($ordre=="desc") { $sens="desc"; $sens_inv="asc"; }
else { $sens="asc"; $sens_inv="desc"; }
$page['value_tri']=$tri;
$page['value_ordre']=$sens;
$page['ordre']=$sens_inv;

/************************/
/* START CONDITIONS  */
/************************/
if(!isset($var['condition']) OR $var['condition']=="")
{
 $condition=array();

 /* season */
 if(isset($var['value_season']) AND !empty($var['value_season'])) {
  $condition[]=" ej.season_id='".$var['value_season']."' ";
 }

 # creation of conditions list
 $nb_condition=sizeof($condition);
 if($nb_condition==0) { $var['condition']=""; }
 elseif($nb_condition=="1") { $var['condition']="WHERE ".$condition['0']; }
 else { $var['condition']="WHERE ".implode(" AND ",$condition); }
}
/**********************/
/* END OF CONDITIONS    */
/**********************/


/**********************/
/* ORDER (tri) */
/**********************/
if(!isset($var['order']))
{
 switch($tri) {
  case "name" : $var['order']=" ORDER BY team_name_name ".$sens." "; break;
  case "club" : $var['order']=" ORDER BY club_name ".$sens." "; break;
  case "position" : $var['order']=" ORDER BY position_name ".$sens." "; break;
  default : $var['order']=" ORDER BY club_name ".$sens." ";
 }
}


if(!isset($var['limit']))
{
 /* on recupere le nb d'team */
 $sql_nb=sql_replace($sql['team']['select_team_player_nb'],$var);
 $sgbd = sql_connect();
 $res_nb = sql_query($sql_nb);
 $ligne=sql_fetch_array($res_nb);
 $nb=$ligne['nb'];
 sql_free_result($res_nb);
 sql_close($sgbd);


 /***************/
 /* PAGINATION */
 /**************/
 $page['first_page']="";
 $page['previous_page']="";
 $page['next_page']="";
 $page['last_page']="";
  
 # number of the current page
 $var['limit']="LIMIT ".($page_num-1)*$nb_max.",".$nb_max;
 $nb_page=ceil($nb/$nb_max);

 $url="index.php?r=".$lang['general']['idurl_team']."&v1=page_";
 $end_url="_".$tri."_".$sens;

 $page['page']=generate_pagination($url, $nb_page,$page_num,$end_url);

 # previous page (except on the first one)
 if($page_num!=1)
 {
  $page['link_first_page']=convert_url($url."1".$end_url);
  $page['link_previous_page']=convert_url($url.($page_num - 1).$end_url);
  $page['first_page']="1";
  $page['previous_page']=$page_num - 1;
 }
 # next page (except on the last one)
 if($page_num!=$nb_page)
 {
  $page['link_last_page']=convert_url($url.$nb_page.$end_url);
  $page['link_next_page']=convert_url($url.($page_num + 1).$end_url);
  $page['next_page']=$page_num + 1;
  $page['last_page']=$nb_page;  
 }
 /******************/
 /* END PAGINATION */
 /******************/

}

$sql_team=sql_replace($sql['team']['select_team_player'],$var);

$sgbd = sql_connect();
$res_team = sql_query($sql_team);
$nb_ligne=sql_num_rows($res_team);
if(!$right_user['team_player_list']) {
	$page['L_message_team_player']=$lang['general']['acces_reserve_admin'];
}
elseif($nb_ligne=="0")
{
 $page['L_message_team_player']=$lang['team']['E_team_player_not_found'];
}
else
{
 $i="0";
 while($ligne = sql_fetch_array($res_team))
 {
  $page['team_player'][$i]['season']=$ligne['season_name'];
  $page['team_player'][$i]['member_lastname']=$ligne['member_lastname'];
  $page['team_player'][$i]['member_firstname']=$ligne['member_firstname'];
  $page['team_player'][$i]['team_name']=$ligne['team_name_name'];
  $page['team_player'][$i]['team_id']=$ligne['team_id'];
  $page['team_player'][$i]['club']=$ligne['club_name'];
  $page['team_player'][$i]['position']=$ligne['position_name'];
  $page['team_player'][$i]['number']=$ligne['player_number'];
  $page['team_player'][$i]['L_show_view']=$lang['team']['show_view'];  
  
  if($ligne['player_captain']==0) { $page['team_player'][$i]['captain']=""; }
  else { $page['team_player'][$i]['captain']=$lang['team']['yes']; }
  
   $page['team_player'][$i]['aff_club_liste']=$page['aff_club'];
   $page['team_player'][$i]['mod']=$i%2;

  $page['team_player'][$i]['link_team']=convert_url("index.php?r=".$lang['general']['idurl_team']."&v1=view&v2=".$ligne['team_id']);
  
 $page['team_player'][$i]['link_member']=convert_url("index.php?r=".$lang['general']['idurl_member']."&v1=view&v2=".$ligne['member_id']); 
 
 $page['team_player'][$i]['link_club']=convert_url("index.php?r=".$lang['general']['idurl_club']."&v1=view&v2=".$ligne['club_id']); 
  
  $i++;
 }
}
sql_free_result($res_team);
sql_close($sgbd);

if($right_user['add_member'])
 {
  $page['link_add']=convert_url("index.php?r=".$lang['general']['idurl_member']."&v1=form_member");
  $page['admin']="1";
 }
else
{
 $page['link_add']="";
 $page['admin']="";
}

$page['form_action']=convert_url("index.php?r=".$lang['general']['idurl_team']."&v1=player_list");


# text
$page['link_team_player_list']=convert_url("index.php?r=".$lang['general']['idurl_team']."&v1=player_list");
$page['link_tri_name']=convert_url("index.php?r=".$lang['general']['idurl_team']."&v1=page_1_name_".$sens_inv);
$page['link_tri_club']=convert_url("index.php?r=".$lang['general']['idurl_team']."&v1=page_1_club_".$sens_inv);
$page['link_tri_position']=convert_url("index.php?r=".$lang['general']['idurl_team']."&v1=page_1_position_".$sens_inv);


$page['L_order']=$lang['team']['order_by'];
$page['L_player']=$lang['team']['player'];
$page['L_team']=$lang['team']['team_name'];
$page['L_number']=$lang['team']['number'];
$page['L_position']=$lang['team']['position'];
$page['L_captain']=$lang['team']['captain'];
$page['L_club']=$lang['team']['club'];
$page['L_position']=$lang['team']['position'];
$page['L_season']=$lang['team']['season'];

$page['L_first_page']=$lang['team']['first_page'];
$page['L_previous_page']=$lang['team']['previous_page'];
$page['L_next_page']=$lang['team']['next_page'];
$page['L_last_page']=$lang['team']['last_page'];

$page['L_add']=$lang['team']['add_player'];
$page['L_choose_season']=$lang['team']['choose_season'];
$page['L_title']=$lang['team']['team_player_list'];

# meta
$page['meta_title']=$lang['team']['team_player_list'];
$page['template']=$tpl['team']['team_player_list'];


?>