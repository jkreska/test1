<?php
$nb_max=NB_FIELD; // number of field per page

$page['field']=array();
$page['link_first_page']="";
$page['link_previous_page']="";
$page['link_last_page']="";
$page['link_next_page']="";
$page['L_message']="";


# suppression
if($right_user['delete_field'] AND isset($_GET['v2']) AND $_GET['v2']=="delete" AND isset($_GET['v3']) AND !empty($_GET['v3']) AND (!isset($included) OR $included==0)) 
{
 $var['id']=$_GET['v3'];
 $sql_verif=sql_replace($sql['field']['verif_field'],$var);
 $sql_sup=sql_replace($sql['field']['sup_field'],$var);
 $sgbd = sql_connect();

 if(sql_num_rows(sql_query($sql_verif))=="0") # we can delete
 {
  if(sql_query($sql_sup) != false) { $page['L_message']=$lang['field']['form_field_sup_1']; }
  else { $page['L_message']=$lang['field']['form_field_sup_0']; }
 }
 else # we can not delete
 {
  $page['L_message']=$lang['field']['form_field_sup_0'];
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
  case "name" : $var['order']=" ORDER BY field_name ".$sens." "; break;
  case "city" : $var['order']=" ORDER BY field_city ".$sens." "; break;
  case "place" : $var['order']=" ORDER BY field_number_seat ".$sens." "; break;
  default : $var['order']=" ORDER BY field_name ".$sens." ";
 }
}

$page['page']=array();
if(!isset($var['limit']))
{
 /* we get the number of field */
 $sql_nb=sql_replace($sql['field']['select_field_nb'],$var);
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

 $url="index.php?r=".$lang['general']['idurl_field']."&v1=page_";
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


$sql_field=sql_replace($sql['field']['select_field_condition'],$var);

$sgbd = sql_connect();
$res_field = sql_query($sql_field);
$nb_ligne=sql_num_rows($res_field);
if(!$right_user['field_list']) {
	$page['L_message']=$lang['general']['acces_reserve_admin'];
}
elseif($nb_ligne=="0")
{
 $page['L_message']=$lang['field']['E_field_not_found'];
}
else
{
 $i="0";
 while($ligne = sql_fetch_array($res_field))
 {
  $page['field'][$i]['id']=$ligne['field_id'];
  $page['field'][$i]['name']=$ligne['field_name'];
  $page['field'][$i]['address']=$ligne['field_address'];
  $page['field'][$i]['post_code']=$ligne['field_post_code'];
  $page['field'][$i]['city']=$ligne['field_city'];
  $page['field'][$i]['number_place']=$ligne['field_number_seat'];  
  if($ligne['field_number_seat']==0) $page['field'][$i]['number_place']="";
  
  $page['field'][$i]['mod']=$i%2;

  $page['field'][$i]['L_show_view']=$lang['field']['show_view'];
  $page['field'][$i]['link_view']=convert_url("index.php?r=".$lang['general']['idurl_field']."&v1=view&v2=".$ligne['field_id']);

 if(isset($var['value_field']) AND $var['value_field']==$ligne['field_id']) { $page['field'][$i]['selected']="selected"; } else { $page['field'][$i]['selected']=""; }
   
   $page['field'][$i]['link_edit']="";
   $page['field'][$i]['link_delete']="";
  if($right_user['edit_field']) {
	$page['field'][$i]['link_edit']=convert_url("index.php?r=".$lang['general']['idurl_field']."&v1=form_field&v2=".$ligne['field_id']);
  }
  if($right_user['delete_field'])
  {
	$page['field'][$i]['link_delete']=convert_url("index.php?r=".$lang['general']['idurl_field']."&v1=field_list&v2=delete&v3=".$ligne['field_id']);
  }
  $i++;
 }
}
sql_free_result($res_field);
sql_close($sgbd);

if($right_user['add_field']) {
  $page['link_add']=convert_url("index.php?r=".$lang['general']['idurl_field']."&v1=form_field");
  $page['admin']="1";
}
else {
 $page['link_add']="";
 $page['admin']="";
}

# text
$page['link_field']=convert_url("index.php?r=".$lang['general']['idurl_field']."&v1=field_list");
$page['link_tri_name']=convert_url("index.php?r=".$lang['general']['idurl_field']."&v1=page_".$page_num."_name_".$sens_inv);
$page['link_tri_city']=convert_url("index.php?r=".$lang['general']['idurl_field']."&v1=page_".$page_num."_city_".$sens_inv);
$page['link_tri_place']=convert_url("index.php?r=".$lang['general']['idurl_field']."&v1=page_".$page_num."_place_".$sens_inv);


$page['L_order']=$lang['field']['order_by'];
$page['L_name']=$lang['field']['name'];
$page['L_city']=$lang['field']['city'];
$page['L_number_place']=$lang['field']['number_place'];

$page['L_first_page']=$lang['field']['first_page'];
$page['L_previous_page']=$lang['field']['previous_page'];
$page['L_next_page']=$lang['field']['next_page'];
$page['L_last_page']=$lang['field']['last_page'];

$page['L_add']=$lang['field']['add_field'];
$page['L_title']=$lang['field']['field_list'];

# meta
$page['meta_title']=$lang['field']['field_list'];
$page['template']=$tpl['field']['field_list'];


?>