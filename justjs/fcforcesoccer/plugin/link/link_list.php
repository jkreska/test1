<?php
$nb_max="20"; // number of link per page

$page['link']=array();
$page['link_first_page']="";
$page['link_previous_page']="";
$page['link_last_page']="";
$page['link_next_page']="";
$page['L_message']="";

# suppression
if($right_user['delete_link'] AND isset($_GET['v2']) AND $_GET['v2']=="delete" AND isset($_GET['v3']) AND !empty($_GET['v3'])) 
{
 $var['id']=$_GET['v3'];
 $sql_sup=sql_replace($sql['link']['sup_link'],$var);
 $sgbd = sql_connect();

 if(sql_query($sql_sup) != false) { $page['L_message']=$lang['link']['form_link_sup_1']; }
 else { $page['L_message']=$lang['link']['form_link_sup_0']; }

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
if(!isset($var['order']))
{
 switch($tri) {
  case "name" : $var['order']=" ORDER BY link_name ".$sens." "; break;
  default : $var['order']=" ORDER BY link_name ".$sens." ";
 }
}

$page['page']=array();
if(!isset($var['limit']))
{
 /* we get the number of link */
 $sql_nb=sql_replace($sql['link']['select_link_nb'],$var);
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

 $url="index.php?r=".$plugin_idurl."&v1=page_";
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


$sql_link=sql_replace($sql['link']['select_link_condition'],$var);

$sgbd = sql_connect();
$res_link = sql_query($sql_link);
$nb_ligne=sql_num_rows($res_link);
if(!$right_user['link_list']) {
	$page['L_message_club']=$lang['general']['acces_reserve_admin'];
}
elseif($nb_ligne=="0")
{
 $page['L_message']=$lang['link']['E_link_not_found'];
}
else
{
 $i="0";
 while($ligne = sql_fetch_array($res_link))
 {
  $page['link'][$i]['id']=$ligne['link_id'];
  $page['link'][$i]['name']=$ligne['link_name'];
  $page['link'][$i]['url']=$ligne['link_url'];
  $page['link'][$i]['description']=$ligne['link_description'];  
  $page['link'][$i]['mod']=$i%2;

  $page['link'][$i]['L_show_view']=$lang['link']['show_view'];
  $page['link'][$i]['link_view']=convert_url("index.php?r=".$plugin_idurl."&v1=view&v2=".$ligne['link_id']);

 if(isset($var['value_link']) AND $var['value_link']==$ligne['link_id']) { $page['link'][$i]['selected']="selected"; } else { $page['link'][$i]['selected']=""; }
   
  $page['link'][$i]['link_edit']="";
  $page['link'][$i]['link_delete']="";
   if($right_user['edit_link'])
  {
   $page['link'][$i]['link_edit']=convert_url("index.php?r=".$plugin_idurl."&v1=form_link&v2=".$ligne['link_id']); 
  }
  if($right_user['delete_link'])
  {
   $page['link'][$i]['link_delete']=convert_url("index.php?r=".$plugin_idurl."&v1=link_list&v2=delete&v3=".$ligne['link_id']);
  }
  $i++;
 }
}
sql_free_result($res_link);
sql_close($sgbd);

if($right_user['add_link'])
 {
  $page['link_add']=convert_url("index.php?r=".$plugin_idurl."&v1=form_link");
  $page['admin']="1";
 }
else
{
 $page['link_add']="";
 $page['admin']="";
}

# text
$page['link_link']=convert_url("index.php?r=".$plugin_idurl."&v1=link_list");
$page['link_tri_name']=convert_url("index.php?r=".$plugin_idurl."&v1=page_".$page_num."_name_".$sens_inv);
$page['link_tri_city']=convert_url("index.php?r=".$plugin_idurl."&v1=page_".$page_num."_city_".$sens_inv);
$page['link_tri_place']=convert_url("index.php?r=".$plugin_idurl."&v1=page_".$page_num."_place_".$sens_inv);


$page['L_order']=$lang['link']['order_by'];
$page['L_name']=$lang['link']['name'];
$page['L_url']=$lang['link']['url'];

$page['L_first_page']=$lang['link']['first_page'];
$page['L_previous_page']=$lang['link']['previous_page'];
$page['L_next_page']=$lang['link']['next_page'];
$page['L_last_page']=$lang['link']['last_page'];

$page['L_add']=$lang['link']['add_link'];
$page['L_title']=$lang['link']['link_list'];

# meta
$page['meta_title']=$lang['link']['link_list'];
$page['template']=$tpl['link']['link_list'];


?>