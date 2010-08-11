<?php
/* view de la page */
$page['L_message']='';

if($right_user['view_information']) {
	$page['show_view']=1; 
}
else {
	$page['show_view']='';
	$page['L_message']=$lang['general']['acces_reserve_admin'];
}

/* on recupere les infos sur la page */
$var['idurl']=$_GET['v1'];

$sql_details=sql_replace($sql['information']['select_page_details_idurl'],$var);
$sgbd = sql_connect();
$res = sql_query($sql_details);
$ligne = sql_fetch_array($res);
sql_free_result($res);
sql_close($sgbd);


$page['page_id']=$ligne['page_id'];
$page['page_parent']=$ligne['page_parent'];
$page['title']=$ligne['page_title'];
$page['keyword']=$ligne['page_keyword'];
$page['summary']=stripslashes($ligne['page_summary']);
$page['text']=stripslashes($ligne['page_text']);
//$page['text']=nl2br($page['text']);
$page['date_edit']=$ligne['page_date_edit'];

$page['image']=$ligne['image_id'];

/* selection des sous pages */
$page['souspage']=array();
$var['condition']="WHERE page_parent='".$ligne['page_id']."' AND page_status='1'";
$sql_sous_page=sql_replace($sql['information']['select_page_condition'],$var);
$sgbd = sql_connect();
$res_sous_page = sql_query($sql_sous_page);
$nb_sous_page=sql_num_rows($res_sous_page);
$i="0";
if($nb_sous_page!="0")
{
 while($ligne_sous_page = sql_fetch_array($res_sous_page))
 {
  $page['souspage'][$i]['title']=$ligne_sous_page['page_title'];
  $page['souspage'][$i]['link']=convert_url("index.php?r=".$lang['general']['idurl_information']."&v1=".$ligne_sous_page['page_idurl']);
  $i++;
 }
}
sql_free_result($res_sous_page);
sql_close($sgbd);

# modification
$page['link_edit']="";
$page['link_delete']="";
if($right_user['edit_information'])
{
	$page['link_edit']=convert_url("index.php?r=".$lang['general']['idurl_information']."&v1=form_page&v2=".$page['page_id']);
}

if($right_user['delete_information'])
{
	$page['link_delete']=convert_url("index.php?r=".$lang['general']['idurl_information']."&v1=page_list&v2=delete&v3=".$page['page_id']);
}



/* add de la visit */
$var['id']=$page['page_id'];
$sql_visit=sql_replace($sql['information']['edit_page_visit'],$var);
$sgbd = sql_connect();
$res_visit = sql_query($sql_visit);
sql_free_result($res_visit);
sql_close($sgbd);
/* end add visit */

# text
$page['L_page']=$lang['information']['information'];
$page['L_date']=$lang['information']['date_edit'];
$page['L_author']=$lang['information']['author'];

$page['L_edit']=$lang['information']['edit'];
$page['L_delete']=$lang['information']['delete'];


# meta
$page['meta_title']=$page['title'];
$page['meta_description']=html2txt($page['summary']);
$page['meta_keyword']=html2txt($page['keyword']);
$page['meta_date']=$page['date_edit'];

$page['template']=$tpl['information']['view_page'];
?>