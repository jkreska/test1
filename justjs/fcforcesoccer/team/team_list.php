<?php
# liste team
$nb_max=NB_TEAM; // number team par page

$page['team']=array();
$page['link_first_page']="";
$page['link_previous_page']="";
$page['link_last_page']="";
$page['link_next_page']="";
$page['L_message_team']="";

if(!isset($page['value_club'])) $page['value_club']="";
if(isset($_POST['club']) AND !empty($_POST['club'])) { $page['value_club']=$_POST['club']; }


# mode club 
$page['aff_club']="1";
if(CLUB!=0) {
$page['value_club']=CLUB;
$page['aff_club']="";
}

# suppression
if($right_user['delete_team'] AND  isset($_GET['v2']) AND $_GET['v2']=="delete" AND isset($_GET['v3']) AND !empty($_GET['v3']) AND (!isset($included) OR $included==0)) 
{
  $var['id']=$_GET['v3'];
  // on supprime l'team
 $sql_verif=sql_replace($sql['team']['verif_team'],$var);
 $sql_sup=sql_replace($sql['team']['sup_team'],$var);
 $var['team']=$_GET['v3']; 
 $sql_sup_coach=sql_replace($sql['team']['sup_team_coach'],$var); // on supprime les coachs de l'team
 $sql_sup_player=sql_replace($sql['team']['sup_team_player'],$var); // on supprime les players de l'team
  
 $sgbd = sql_connect();

 if(sql_num_rows(sql_query($sql_verif))=="0") # we can delete
 {
  $execution=sql_query($sql_sup);
  if($execution) {
   $page['L_message_team']=$lang['team']['form_team_sup_1'];
   sql_query($sql_sup_coach);
   sql_query($sql_sup_player);   
  }
  else { $page['L_message_team']=$lang['team']['form_team_sup_0']; }  
 }
 else # we can not delete
 {
  $page['L_message_team']=$lang['team']['form_team_sup_0'];
 }
 sql_close($sgbd);
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

 if(isset($page['value_club']) AND !empty($page['value_club'])) {
  array_push($condition," c.club_id='".$page['value_club']."' ");
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
if(!isset($var['order']) OR empty($var['order']))
{
 switch($tri) {
  case "name" : $var['order']=" ORDER BY ne.team_name_order ".$sens." "; break;
  case "club" : $var['order']=" ORDER BY c.club_name ".$sens." "; break;
  case "sex" : $var['order']=" ORDER BY e.sex_id ".$sens." "; break;
  default : $var['order']=" ORDER BY c.club_name ".$sens." ";
 }
}


if(!isset($var['limit']) OR empty($var['limit']))
{
 /* on recupere le nb d'team */
 $sql_nb=sql_replace($sql['team']['select_team_nb'],$var);
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


$sql_team=sql_replace($sql['team']['select_team_condition'],$var);

$sgbd = sql_connect();
$res_team = sql_query($sql_team);
$nb_ligne=sql_num_rows($res_team);
if(!$right_user['team_list']) {
	$page['L_message_team']=$lang['general']['acces_reserve_admin'];
}
elseif($nb_ligne=="0")
{
 $page['L_message_team']=$lang['team']['E_team_not_found'];
}
else
{
 $i="0";
 while($ligne = sql_fetch_array($res_team))
 {
  $page['team'][$i]['id']=$ligne['team_id'];
  $page['team'][$i]['team_name']=$ligne['team_name_name'];
  $page['team'][$i]['club']=$ligne['club_name'];
  $page['team'][$i]['sex']=$ligne['sex_name'];
  $page['team'][$i]['sex_abbreviation']=$ligne['sex_abbreviation'];
  $page['team'][$i]['link_view']=convert_url("index.php?r=".$lang['general']['idurl_team']."&v1=view&v2=".$ligne['team_id']);
  $page['team'][$i]['link_club']=convert_url("index.php?r=".$lang['general']['idurl_club']."&v1=view&v2=".$ligne['club_id']); 
  $page['team'][$i]['link_match']=convert_url("index.php?r=".$lang['general']['idurl_match']."&v1=match_list&v2=team_".$ligne['club_id']."_".$ligne['team_id']);  
  
 if(isset($var['value_team']) AND $var['value_team']==$ligne['team_id']) { $page['team'][$i]['selected']="selected"; } else { $page['team'][$i]['selected']=""; }
 
  $page['team'][$i]['aff_club_liste']=$page['aff_club'];
  $page['team'][$i]['L_view_match']=$lang['team']['view_match'];
  $page['team'][$i]['L_edit']=$lang['team']['edit'];
  $page['team'][$i]['L_delete']=$lang['team']['delete'];
  $page['team'][$i]['mod']=$i%2;

  $page['team'][$i]['link_edit']="";
  $page['team'][$i]['link_delete']="";

  if($right_user['edit_team'])
  {
   $page['team'][$i]['link_edit']=convert_url("index.php?r=".$lang['general']['idurl_team']."&v1=form_team&v2=".$ligne['team_id']);
   
  }
  if($right_user['delete_team'])
  {
   $page['team'][$i]['link_delete']=convert_url("index.php?r=".$lang['general']['idurl_team']."&v1=team_list&v2=delete&v3=".$ligne['team_id']);

  }
  $i++;
 }
}
sql_free_result($res_team);
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
 $var['value_club']=$page['value_club'];
 $included=1;
 include(create_path("club/club_list.php"));
 unset($included);
 $page['club']=$page['club'];
}

if($right_user['add_team'])
 {
  $page['link_add']=convert_url("index.php?r=".$lang['general']['idurl_team']."&v1=form_team");
  $page['admin']="1";
 }
else
{
 $page['link_add']="";
 $page['admin']="";
}

# text
$page['link_team']=convert_url("index.php?r=".$lang['general']['idurl_team']."&v1=team_list");
$page['link_tri_name']=convert_url("index.php?r=".$lang['general']['idurl_team']."&v1=page_1_name_".$sens_inv);
$page['link_tri_club']=convert_url("index.php?r=".$lang['general']['idurl_team']."&v1=page_1_club_".$sens_inv);
$page['link_tri_sex']=convert_url("index.php?r=".$lang['general']['idurl_team']."&v1=page_1_sex_".$sens_inv);

$page['form_action']=convert_url("index.php?r=".$lang['general']['idurl_team']."&v1=team_list");

$page['L_choose_club']=$lang['team']['choose_club'];
$page['L_valider']=$lang['team']['submit'];


$page['L_order']=$lang['team']['order_by'];
$page['L_name']=$lang['team']['team_name'];
$page['L_club']=$lang['team']['club'];
$page['L_sex']=$lang['team']['sex'];
$page['L_team']=$lang['team']['team'];

$page['L_first_page']=$lang['team']['first_page'];
$page['L_previous_page']=$lang['team']['previous_page'];
$page['L_next_page']=$lang['team']['next_page'];
$page['L_last_page']=$lang['team']['last_page'];

$page['L_add']=$lang['team']['add_team'];
$page['L_title']=$lang['team']['team_list'];

# meta
$page['meta_title']=$lang['team']['team_list'];
$page['template']=$tpl['team']['team_list'];


?>