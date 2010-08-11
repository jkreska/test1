<?php
# view du field
$page['L_message']="";


if($right_user['view_field']) {
	$page['show_view']=1; 
}
else {
	$page['show_view']='';
	$page['L_message']=$lang['general']['acces_reserve_admin'];
}


# we get the ID
$page['id']=$_GET['v2'];

# we get the information on the field
if(isset($page['id']) AND $page['id']!="")
{
 $sql_details=sql_replace($sql['field']['select_field_details'],$page);

 $sgbd = sql_connect();
 $res = sql_query($sql_details);
 $ligne = sql_fetch_array($res);
 sql_free_result($res);
 sql_close($sgbd);

 $page['id']=$ligne['field_id'];
 $page['name']=$ligne['field_name'];
 $page['address']=nl2br($ligne['field_address']);
 $page['post_code']=$ligne['field_post_code'];
 $page['city']=$ligne['field_city'];
 $page['number_place']=$ligne['field_number_seat'];
 $page['photo']=$ligne['field_photo']; if($page['photo']==NULL) $page['photo']="";
 $page['size']=$ligne['field_size']; if($page['size']==NULL) $page['size']="";
}
else
{
 $page['L_message']=$lang['field']['E_erreur_presence_field'];
}


# liste des matchs a venir dans ce field
include_once(create_path("match/sql_match.php"));
include_once(create_path("match/lg_match_".LANG.".php"));
include_once(create_path("match/tpl_match.php"));
$var['condition']=" WHERE m.match_date >= NOW() AND m.field_id='".$page['id']."' ";
$var['order']=" ORDER BY m.match_date ASC ";
$var['limit']=" LIMIT 15 ";
$included=1;
include(create_path("match/match_list.php"));
unset($included);

$page['next_matches']=$page['match'];
$page['L_message_next_matches']=$page['L_message_match'];
$page['L_next_matches']=$lang['match']['next_matches'];



# modification
$page['link_edit']="";
$page['link_delete']="";
if($right_user['edit_club']) {
	$page['link_edit']=convert_url("index.php?r=".$lang['general']['idurl_field']."&v1=form_field&v2=".$page['id']);
}
if($right_user['delete_club']) {
	$page['link_delete']=convert_url("index.php?r=".$lang['general']['idurl_field']."&v1=field_list&v2=delete&v3=".$page['id']);
}


# text
$page['L_title']=$page['name'];
$page['L_field']=$lang['field']['field'];
$page['L_details']=$lang['field']['details'];
$page['L_name']=$lang['field']['name'];
$page['L_address']=$lang['field']['address'];
$page['L_post_code']=$lang['field']['post_code'];
$page['L_city']=$lang['field']['city'];
$page['L_number_place']=$lang['field']['number_place'];
$page['L_photo']=$lang['field']['photo'];
$page['L_size']=$lang['field']['size'];

$page['L_edit']=$lang['field']['edit'];
$page['L_delete']=$lang['field']['delete'];


# meta
$page['meta_title']=$page['name'];
$page['template']=$tpl['field']['view_field'];
?>