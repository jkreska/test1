<?php
$nb_max=NB_CLUB; // number of club per page

$page['club']=array();
if(!isset($page['page'])) {
$page['link_first_page']="";
$page['link_previous_page']="";
$page['link_last_page']="";
$page['link_next_page']="";
}
$page['L_message_club']="";


# suppression
if($right_user['delete_club'] AND isset($_GET['v2']) AND $_GET['v2']=="delete" AND isset($_GET['v3']) AND !empty($_GET['v3']) AND (!isset($included) OR $included==0)) 
{
 $var['id']=$_GET['v3'];
 $sql_verif=sql_replace($sql['club']['verif_club'],$var);
 $sql_sup=sql_replace($sql['club']['sup_club'],$var);
 $sgbd = sql_connect();

 if(sql_num_rows(sql_query($sql_verif))=="0") // we can delete
 {
  if(sql_query($sql_sup) != false) { $page['L_message_club']=$lang['club']['form_club_sup_1']; }
  else { $page['L_message_club']=$lang['club']['form_club_sup_0']; }
 }
 else // it is impossible to delete
 {
  $page['L_message_club']=$lang['club']['form_club_sup_0'];
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
else
{
 $page_num=1; // number of the page
 $tri="name"; // tri par defaut
 $ordre="asc"; // ordre par defaut
}

# ORDRE (sens)
if($ordre=="desc") { $sens="desc"; $sens_inv="asc"; }
else { $sens="asc"; $sens_inv="desc"; }




/************************/
/* START CONDITIONS  */
/************************/
if(!isset($var['condition']) OR $var['condition']=="")
{
 $condition=array();

 /* mode club : on affiche pas le club par defaut */
 if(CLUB!=0 AND isset($_GET['r']) AND $_GET['r']==$lang['general']['idurl_club']) { array_push($condition," club_id!='".CLUB."' "); }

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
  case "name" : $var['order']=" ORDER BY club_name ".$sens." "; break;
  case "creation" : $var['order']=" ORDER BY club_creation_year ".$sens." "; break;
  case "abbreviation" : $var['order']=" ORDER BY club_abbreviation ".$sens." "; break;
  default : $var['order']=" ORDER BY club_name ".$sens." ";
 }
}


if(!isset($var['limit']) AND !isset($page['page']))
{
 /* we get the number of club */
 $sql_nb=sql_replace($sql['club']['select_club_nb'],$var);
 $sgbd = sql_connect();
 $res_nb = sql_query($sql_nb);
 $ligne=sql_fetch_array($res_nb);
 $nb=$ligne['nb'];
 sql_free_result($res_nb);
 sql_close($sgbd);


 /***************/
 /* PAGINATION */
 /**************/
 # number of the current page
 $var['limit']="LIMIT ".($page_num-1)*$nb_max.",".$nb_max;
 $nb_page=ceil($nb/$nb_max);

 $url="index.php?r=".$lang['general']['idurl_club']."&v1=page_";
 $end_url="_".$tri."_".$sens;

 $page['page']=generate_pagination($url, $nb_page,$page_num,$end_url);

 # previous page (except on the first one)
 if($page_num!=1)
 {
  $page['link_first_page']=convert_url($url."1".$end_url);
  $page['link_previous_page']=convert_url($url.($page_num - 1).$end_url);
 }
 # next page (except on the last one)
 if($page_num!=$nb_page)
 {
  $page['link_last_page']=convert_url($url.$nb_page.$end_url);
  $page['link_next_page']=convert_url($url.($page_num + 1).$end_url);
 }
 /******************/
 /* END PAGINATION */
 /******************/

}


$sql_club=sql_replace($sql['club']['select_club_condition'],$var);
$sgbd = sql_connect();
$res_club = sql_query($sql_club);
$nb_ligne=sql_num_rows($res_club);
if(!$right_user['club_list']) {
	$page['L_message_club']=$lang['general']['acces_reserve_admin'];
}
elseif($nb_ligne=="0")
{
 $page['L_message_club']=$lang['club']['E_club_not_found'];
}
else
{
 $i="0";
 while($ligne = sql_fetch_array($res_club))
 {
  $page['club'][$i]['id']=$ligne['club_id'];
  $page['club'][$i]['name']=$ligne['club_name'];
  $page['club'][$i]['abbreviation']=$ligne['club_abbreviation'];
  $page['club'][$i]['address']=nl2br($ligne['club_address']);
  $page['club'][$i]['color']=$ligne['club_color'];
  $page['club'][$i]['color_alternative']=$ligne['club_color_alternative'];
  $page['club'][$i]['telephone']=$ligne['club_telephone'];
  $page['club'][$i]['fax']=$ligne['club_fax'];
  $page['club'][$i]['email']=$ligne['club_email'];
  $page['club'][$i]['url']=$ligne['club_url'];
  if($page['club'][$i]['url']==NULL) $page['club'][$i]['url']="";
  $page['club'][$i]['creation_year']=$ligne['club_creation_year'];
  $page['club'][$i]['comment']=$ligne['club_comment'];
  
  $page['club'][$i]['L_show_view']=$lang['club']['show_view'];

  $page['club'][$i]['link_view']=convert_url("index.php?r=".$lang['general']['idurl_club']."&v1=view&v2=".$ligne['club_id']);
  
 $page['club'][$i]['link_team']=convert_url("index.php?r=".$lang['general']['idurl_team']."&v1=team_list_a&club=".$ligne['club_id']);
 $page['club'][$i]['link_match']=convert_url("index.php?r=".$lang['general']['idurl_match']."&v1=match_list&v2=club_".$ligne['club_id']); 
 $page['club'][$i]['L_view_team']=$lang['club']['view_team'];  
 $page['club'][$i]['L_view_match']=$lang['club']['view_match'];  

 if(isset($var['value_club']) AND $var['value_club']==$ligne['club_id']) { $page['club'][$i]['selected']="selected"; } else { $page['club'][$i]['selected']=""; }
  
  $page['club'][$i]['L_edit']=$lang['club']['edit'];
  $page['club'][$i]['L_delete']=$lang['club']['delete']; 
  $page['club'][$i]['mod']=$i%2;

  $page['club'][$i]['link_edit']="";
  $page['club'][$i]['link_delete']="";

  if($right_user['edit_club']) {
  	$page['club'][$i]['link_edit']=convert_url("index.php?r=".$lang['general']['idurl_club']."&v1=form_club&v2=".$ligne['club_id']);
  }
  if($right_user['delete_club']) {
    $page['club'][$i]['link_delete']=convert_url("index.php?r=".$lang['general']['idurl_club']."&v1=club_list&v2=delete&v3=".$ligne['club_id']);
  }
  $i++;
 }
}
sql_free_result($res_club);
sql_close($sgbd);

$page['link_add']="";
$page['link_import_club']='';
if($right_user['add_club']) {
	$page['link_add']=convert_url("index.php?r=".$lang['general']['idurl_club']."&v1=form_club");
}
if($right_user['import_club']) {
	$page['link_import_club']=convert_url("index.php?r=".$lang['general']['idurl_club']."&v1=import_club");
}

$page['link_club']=convert_url("index.php?r=".$lang['general']['idurl_club']."&v1=club_list");
$page['link_tri_name']=convert_url("index.php?r=".$lang['general']['idurl_club']."&v1=page_1_name_".$sens_inv);
$page['link_tri_creation_year']=convert_url("index.php?r=".$lang['general']['idurl_club']."&v1=page_1_creation_".$sens_inv);
$page['link_tri_abbreviation']=convert_url("index.php?r=".$lang['general']['idurl_club']."&v1=page_1_abbreviation_".$sens_inv);

# text
$page['L_title']=$lang['club']['club_list'];

$page['L_order']=$lang['club']['order_by'];
$page['L_name']=$lang['club']['name'];
$page['L_abbreviation']=$lang['club']['abbreviation'];
$page['L_address']=$lang['club']['address'];
$page['L_telephone']=$lang['club']['telephone'];
$page['L_email']=$lang['club']['email'];
$page['L_url']=$lang['club']['url'];
$page['L_creation_year']=$lang['club']['creation_year'];

$page['L_first_page']=$lang['club']['first_page'];
$page['L_previous_page']=$lang['club']['previous_page'];
$page['L_next_page']=$lang['club']['next_page'];
$page['L_last_page']=$lang['club']['last_page'];

$page['L_add']=$lang['club']['add_club'];
$page['L_import_club']=$lang['club']['import_club'];


if(CLUB!=0) {
$page['L_title']=$lang['club']['club_opponent_list'];
}

# meta
$page['meta_title']=$lang['club']['club_list'];
$page['template']=$tpl['club']['club_list'];


?>