<?php
$nb_max=NB_NEWS; // number d'news par page

$page['news']=array();
$page['page']=array();
$page['link_first_page']="";
$page['link_previous_page']="";
$page['link_last_page']="";
$page['link_next_page']="";
$page['L_message_news']="";

/* suppression */
if($right_user['delete_news'] AND isset($_GET['v2']) AND $_GET['v2']=="delete" AND isset($_GET['v3']) AND !empty($_GET['v3']) AND (!isset($included) OR $included==0))
{
 $var['id']=$_GET['v3'];
 $sql_sup=sql_replace($sql['news']['sup_news'],$var);
 $sgbd = sql_connect();
 if(sql_query($sql_sup) != false) { $page['L_message_news']=$lang['news']['form_news_sup_1']; }
 else { $page['L_message_news']=$lang['news']['form_news_sup_0']; }
 sql_close($sgbd);
}

/************************/
/* START CONDITIONS  */
/************************/

if(!isset($var['condition']) OR $var['condition']=="")
{
 $condition=array();

 /* par defaut */
 if(!$right_user['edit_news']) { array_push($condition," news_release  <= NOW() "); }

 /* admin */
 if(!$right_user['edit_news']) { array_push($condition," news_status='2' "); }

 # creation of conditions list
 $nb_condition=sizeof($condition);
 if($nb_condition==0) { $var['condition']=""; }
 elseif($nb_condition=="1") { $var['condition']="WHERE ".$condition['0']; }
 else { $var['condition']="WHERE ".implode(" AND ",$condition); }
}
/**********************/
/* END OF CONDITIONS    */
/**********************/

# ORDER
if(!isset($var['order'])) { $var['order']=" ORDER BY news_release DESC "; }

# LIMIT
if(!isset($var['limit'])) {

 # PAGINATION
 # on recupere le nb d'news
 $sql_nb=sql_replace($sql['news']['select_nb_news'],$var);
 $sgbd = sql_connect();
 $res_nb = sql_query($sql_nb);
 $ligne=sql_fetch_array($res_nb);
 $nb=$ligne['nb'];
 sql_free_result($res_nb);
 sql_close($sgbd);

 # number of the current page
 if(!isset($_GET['v2']) OR $_GET['v2']=="" OR !ereg("page",$_GET['v2'])) { $page_num="1"; }
 else  { $page_num=explode("_",$_GET['v2']); $page_num=$page_num['1']; }

 $var['limit']="LIMIT ".($page_num-1)*$nb_max.",".$nb_max;

 $nb_page=ceil($nb/$nb_max); # number de page au total

 $url="index.php?r=".$lang['general']['idurl_news']."&v1=news_list&v2=page_";

 $page['page']=generate_pagination($url, $nb_page,$page_num);

 # previous page (except on the first one)
 if($page_num!=1)
 {
  $page['link_first_page']=convert_url($url."1");
  $page['link_previous_page']=convert_url($url.($page_num - 1));
 }
 # next page (except on the last one)
 if($page_num!=$nb_page)
 {
  $page['link_last_page']=convert_url($url.$nb_page);
  $page['link_next_page']=convert_url($url.($page_num + 1));
 }

}



$sql_news=sql_replace($sql['news']['select_news_condition'],$var);

$sgbd = sql_connect();
$res_news = sql_query($sql_news);
$nb_ligne=sql_num_rows($res_news);
if(!$right_user['news_list']) {
	$page['L_message_news']=$lang['general']['acces_reserve_admin'];
}
elseif($nb_ligne=="0")
{
 $page['L_message_news']=$lang['news']['E_news_not_found'];
}
else
{
 $i="0";
 while($ligne = sql_fetch_array($res_news))
 {
  $page['news'][$i]['id']=$ligne['news_id'];
  $page['news'][$i]['news']=$ligne['news_title'];
  $i=="0" ? $page['news'][$i]['premier']="1" : $page['news'][$i]['premier']="";
  $page['news'][$i]['summary']=stripslashes($ligne['news_summary']);
  $page['news'][$i]['release']=convert_date($ligne['news_release'],$lang['news']['format_date_php']);
  $page['news'][$i]['release_time']=convert_date($ligne['news_release'],$lang['news']['format_time_php']);
  if(convert_date($ligne['news_release'],$lang['news']['format_time_form'])=='00:00') $page['news'][$i]['release_time']='';
  $page['news'][$i]['lire']=$lang['news']['read_news'];
  $page['news'][$i]['status']=$ligne['news_status'];
  $page['news'][$i]['L_edit']=$lang['news']['edit'];  
  $page['news'][$i]['L_delete']=$lang['news']['delete'];

  $page['news'][$i]['link_edit']="";
  $page['news'][$i]['link_delete']="";
  $page['news'][$i]['aff_status']="";
  
  if($right_user['edit_news']) {
  	$page['news'][$i]['link_edit']=convert_url("index.php?r=".$lang['general']['idurl_news']."&v1=form_news&v2=".$ligne['news_id']);
	$page['news'][$i]['aff_status']="1";
  }
  
  if($right_user['delete_news']) {
	$page['news'][$i]['link_delete']=convert_url("index.php?r=".$lang['general']['idurl_news']."&v1=news_list&v2=delete&v3=".$ligne['news_id']);
   
  }  

   $page['news'][$i]['link_news']=convert_url("index.php?r=".$lang['general']['idurl_news']."&v1=".$ligne['news_idurl']);


  /* selection de l'image si elle existe 
  if($ligne['image_id']!="" AND $ligne['image_id']!="0")
  {
    $var['id']=$ligne['image_id'];
    $sql_image=sql_replace($sql['image']['select_image_details'],$var);
    $sgbd = sql_connect();
    $res_image = sql_query($sql_image);
    $ligne_image = sql_fetch_array($res_image);
    sql_free_result($res_image);
    $page['news'][$i]['image_url']=ROOT_URL."/".IMG_DOSSIER."/".$ligne_image['image_dossier']."/".$ligne_image['image_url'];
    $page['news'][$i]['image_largeur']=$ligne_image['image_largeur'];
    $page['news'][$i]['image_hauteur']=$ligne_image['image_hauteur'];
    $page['news'][$i]['vignette_url']=ROOT_URL."/".IMG_DOSSIER."/".$ligne_image['vignette_dossier']."/".$ligne_image['vignette_url'];
    $page['news'][$i]['vignette_largeur']=$ligne_image['vignette_largeur'];
    $page['news'][$i]['vignette_hauteur']=$ligne_image['vignette_hauteur'];
  }
  else
  {
    $page['news'][$i]['image_url']="";
  }
  */

  $i++;
 }
}
sql_free_result($res_news);
sql_close($sgbd);

if($right_user['add_news']) {
  $page['link_add']=convert_url("index.php?r=".$lang['general']['idurl_news']."&v1=form_news");
 }
else {
 $page['link_add']="";
}


$page['L_add']=$lang['news']['add_news'];
$page['L_title']=$lang['news']['news_list'];

$page['L_first_page']=$lang['news']['first_page'];
$page['L_previous_page']=$lang['news']['previous_page'];
$page['L_next_page']=$lang['news']['next_page'];
$page['L_last_page']=$lang['news']['last_page'];


# meta
$page['meta_title']=$lang['news']['news_list'];
if(isset($page['news'][0]['summary']))
{
 $page['meta_description']=$page['news'][0]['summary'];
 $page['meta_keyword']=$page['news'][0]['summary'];
 $page['meta_date']=$page['news'][0]['release'];
}

$page['template']=$tpl['news']['news_list'];


?>