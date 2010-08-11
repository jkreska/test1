<?php
/* view news */
$page['L_message']='';

if($right_user['view_news']) {
	$page['show_view']=1; 
}
else {
	$page['show_view']='';
	$page['L_message']=$lang['general']['acces_reserve_admin'];
}


/* on recupere les infos sur le news */
$var['idurl']=$_GET['v1'];

$sql_details=sql_replace($sql['news']['select_news_details_idurl'],$var);

$sgbd = sql_connect();
$res = sql_query($sql_details);
$ligne = sql_fetch_array($res);
sql_free_result($res);
sql_close($sgbd);

$news['news_id']=$ligne['news_id'];
$page['subhead']=$ligne['news_subhead'];
$page['title']=$ligne['news_title'];
$page['subtitle']=$ligne['news_subtitle'];
$page['keyword']=$ligne['news_keyword'];
$page['summary']=stripslashes($ligne['news_summary']);
$page['text']=stripslashes($ligne['news_text']);
$page['text']=nl2br($page['text']);
$page['ps']=stripslashes($ligne['news_ps']);
$page['release']=convert_date($ligne['news_release'],$lang['news']['format_date_php']);
$page['release_time']=convert_date($ligne['news_release'],$lang['news']['format_time_php']);
if(convert_date($ligne['news_release'],$lang['news']['format_time_form'])=='00:00') $page['release_time']='';

# author
$page['author_name']="";
$page['author_firstname']="";

include_once(create_path("member/sql_member.php"));
$var['id']=$ligne['member_add_id'];
$sql_author=sql_replace($sql['member']['select_member_details'],$var);
$sgbd = sql_connect();
$res_author = sql_query($sql_author);
$ligne_author = sql_fetch_array($res_author);
$page['author_name']=$ligne_author['member_lastname'];
$page['author_firstname']=$ligne_author['member_firstname'];

sql_free_result($res_author);
sql_close($sgbd);


$page['image']=$ligne['image_id'];

/* selection de l'image si elle existe */
/*
if($page['image']!="" AND $page['image']!="0")
{
  $var['id']=$page['image'];
  $sql_image=sql_replace($sql['image']['select_image_details'],$var);
  $sgbd = sql_connect();
  $res_image = sql_query($sql_image);
  $ligne_image = sql_fetch_array($res_image);
  sql_free_result($res_image);
  sql_close($sgbd);
  $page['image_url']=ROOT_URL."/".IMG_DOSSIER."/".$ligne_image['image_dossier']."/".$ligne_image['image_url'];
  $page['image_largeur']=$ligne_image['image_largeur'];
  $page['image_hauteur']=$ligne_image['image_hauteur'];
  $page['vignette_url']=ROOT_URL."/".IMG_DOSSIER."/".$ligne_image['vignette_dossier']."/".$ligne_image['vignette_url'];
  $page['vignette_largeur']=$ligne_image['vignette_largeur'];
  $page['vignette_hauteur']=$ligne_image['vignette_hauteur'];
}
else
{
  $page['image_url']="";
  $page['image_largeur']="";
  $page['image_hauteur']="";
  $page['vignette_url']="";
  $page['vignette_largeur']="";
  $page['vignette_hauteur']="";
}
*/

# modification
$page['link_edit']="";
$page['link_delete']="";

if($right_user['edit_news']) {
 $page['link_edit']=convert_url("index.php?r=".$lang['general']['idurl_news']."&v1=form_news&v2=".$news['news_id']);
}
if($right_user['delete_news']) {
 $page['link_delete']=convert_url("index.php?r=".$lang['general']['idurl_news']."&v1=news_list&v2=delete&v3=".$news['news_id']);
}



/* add de la visit */
$var['id']=$news['news_id'];
$sql_visit=sql_replace($sql['news']['edit_news_visit'],$var);
$sgbd = sql_connect();
$res_visit = sql_query($sql_visit);
sql_free_result($res_visit);
sql_close($sgbd);
/* end add visit */

# text
$page['L_news']=$lang['news']['news'];
$page['L_date']=$lang['news']['date_release'];
$page['L_author']=$lang['news']['author'];

$page['L_edit']=$lang['news']['edit'];
$page['L_delete']=$lang['news']['delete']; 

# meta
$page['meta_title']=$page['title'];
$page['meta_description']=$page['summary'];
$page['meta_keyword']=$page['keyword'];
$page['meta_date']=$page['release'];

$page['template']=$tpl['news']['view_news'];
?>