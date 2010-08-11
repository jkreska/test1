<?php
$nb_max=NB_COMPETITION; // number of competition per page

$page['competition']=array();
if(!isset($page['page'])) {
$page['link_first_page']="";
$page['link_previous_page']="";
$page['link_last_page']="";
$page['link_next_page']="";
}
$page['L_message_competition']="";


# suppression
if($right_user['delete_competition'] AND isset($_GET['v2']) AND $_GET['v2']=="delete" AND isset($_GET['v3']) AND !empty($_GET['v3']) AND (!isset($included) OR $included==0)) 
{
 $var['id']=$_GET['v3'];
 $sql_verif=sql_replace($sql['competition']['verif_competition'],$var);
 $sql_sup=sql_replace($sql['competition']['sup_competition'],$var);
 $sgbd = sql_connect();

 if(sql_num_rows(sql_query($sql_verif))=="0") # we can delete
 {
  $execution=sql_query($sql_sup);
  if($execution) { $page['L_message_competition']=$lang['competition']['form_competition_sup_1']; }
  else { $page['L_message_competition']=$lang['competition']['form_competition_sup_0']; }
  
  # we delete associated rounds
  $var['competition']=$var['id'];
  $sql_delete_round=sql_replace($sql['competition']['delete_round'],$var);
  if($execution) sql_query($sql_delete_round);
   
 }
 else # we can not delete
 {
  $page['L_message_competition']=$lang['competition']['form_competition_sup_0'];
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
  case "name" : $var['order']=" ORDER BY competition_name ".$sens." , round_order ASC "; break;
  default : $var['order']=" ORDER BY competition_name ".$sens.", round_order  ASC ";
 }
}


if(!isset($var['limit']) AND !isset($page['page']))
{
 /* we get the number of competition */
 $sql_nb=sql_replace($sql['competition']['select_competition_nb'],$var);
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

 $url="index.php?r=".$lang['general']['idurl_competition']."&v1=page_";
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


$sql_competition=sql_replace($sql['competition']['select_competition_round_condition'],$var);
$sgbd = sql_connect();
$res_competition = sql_query($sql_competition);
$nb_ligne=sql_num_rows($res_competition);
if(!$right_user['competition_list']) {
	$page['L_message_competition']=$lang['general']['acces_reserve_admin'];
}
elseif($nb_ligne=="0")
{
 $page['L_message_competition']=$lang['competition']['E_competition_not_found'];
}
else
{
 $i="-1";
 $tmp="";
 while($ligne = sql_fetch_array($res_competition))
 {
  if($tmp!=$ligne['competition_id']) { 
   $i++;
   $j="0";
   $page['competition'][$i]['id']=$ligne['competition_id'];
   $page['competition'][$i]['name']=$ligne['competition_name'];
   $page['competition'][$i]['L_show_view']=$lang['competition']['show_view'];
   $page['competition'][$i]['L_show_standings']=$lang['competition']['show_stats'];
   $page['competition'][$i]['link_view']="";
   $page['competition'][$i]['link_standings']="";
   if($ligne['round_name']=="") {
     $page['competition'][$i]['link_view']=convert_url("index.php?r=".$lang['general']['idurl_competition']."&v1=view&v2=".$ligne['competition_id']); 
     $page['competition'][$i]['link_standings']=convert_url("index.php?r=".$lang['general']['idurl_match']."&v1=standings&v2=".$ligne['competition_id']); 	  
   }  
  
  if(isset($var['value_competition']) AND $var['value_competition']==$ligne['competition_id']) { $page['competition'][$i]['selected']="selected"; } else { $page['competition'][$i]['selected']=""; }
 
  $page['competition'][$i]['mod']=$i%2;
  $page['competition'][$i]['L_edit']=$lang['competition']['edit'];
  $page['competition'][$i]['L_delete']=$lang['competition']['delete'];
  $page['competition'][$i]['link_edit']="";
  $page['competition'][$i]['link_delete']="";  
  if($right_user['edit_competition'])
  {
   $page['competition'][$i]['link_edit']=convert_url("index.php?r=".$lang['general']['idurl_competition']."&v1=form_competition&v2=".$ligne['competition_id']);
  }
  if($right_user['delete_competition'])
  {
	$page['competition'][$i]['link_delete']=convert_url("index.php?r=".$lang['general']['idurl_competition']."&v1=competition_list&v2=delete&v3=".$ligne['competition_id']);
  }
  
   # rounds
   $page['competition'][$i]['round']=array();
  }
  
  if($ligne['round_name']!="")
  {
   $page['competition'][$i]['round'][$j]['mod']=$j%2;
   $page['competition'][$i]['round'][$j]['name']=$ligne['round_name'];
   $page['competition'][$i]['round'][$j]['L_show_standings']="";     
   $page['competition'][$i]['round'][$j]['link_standings']=convert_url("index.php?r=".$lang['general']['idurl_match']."&v1=standings&v2=".$ligne['competition_id']."&v3=".$ligne['round_id']);
   if($ligne['round_standings']==1) {
    $page['competition'][$i]['round'][$j]['L_show_standings']=$lang['competition']['show_standings'];    
   }
   else {
    $page['competition'][$i]['round'][$j]['L_show_standings']=$lang['competition']['show_stats'];  
   }
  
   $page['competition'][$i]['round'][$j]['L_show_view']=$lang['competition']['show_view'];
   $page['competition'][$i]['round'][$j]['link_view']=convert_url("index.php?r=".$lang['general']['idurl_competition']."&v1=view&v2=".$ligne['competition_id']."&v3=".$ligne['round_id']);  
  }
  $j++;
  $tmp=$ligne['competition_id'];
 }
}
sql_free_result($res_competition);
sql_close($sgbd);

if($right_user['add_competition'])
{
  $page['link_add']=convert_url("index.php?r=".$lang['general']['idurl_competition']."&v1=form_competition");
  $page['admin']="1";
 }
else
{
 $page['link_add']="";
 $page['admin']="";
}

# text
$page['link_competition']=convert_url("index.php?r=".$lang['general']['idurl_competition']."&v1=competition_list");
$page['link_tri_name']=convert_url("index.php?r=".$lang['general']['idurl_competition']."&v1=page_1_name_".$sens_inv);

$page['L_order']=$lang['competition']['order_by'];
$page['L_name']=$lang['competition']['name'];

$page['L_first_page']=$lang['competition']['first_page'];
$page['L_previous_page']=$lang['competition']['previous_page'];
$page['L_next_page']=$lang['competition']['next_page'];
$page['L_last_page']=$lang['competition']['last_page'];

$page['L_add']=$lang['competition']['add_competition'];
$page['L_title']=$lang['competition']['competition_list'];

$page['meta_title']=$lang['competition']['competition_list'];
$page['template']=$tpl['competition']['competition_list'];
?>