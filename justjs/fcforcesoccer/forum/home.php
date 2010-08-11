<?php
/*****************************/
/* Derniers topics du forum  */
/*****************************/
$var['condition']=" ";
$var['limit']=" LIMIT 5 ";
$var['order']=" ORDER BY message_date_add DESC ";

$page['last_topic']=array();
$included=1;
include(create_path("forum/topic_list.php"));
unset($included);
$page['last_topic']=$page['topic'];
$page['L_message_topic']=$page['L_message'];
unset($var);


/************************/
/* liste des forums     */
/************************/
$page['forum']=array();
$included=1;
include(create_path("forum/forum_list.php"));
unset($included);
$page['forum']=$page['forum'];
$page['L_message_forum']=$page['L_message'];


/************************/
/* statistics         */
/************************/
$page['nb_connecte']=$_SESSION['session_nb_connecte'];

/****************************************/
/* Element de text
/****************************************/

$page['L_title']=$lang['general']['forum'];
$page['L_dernier_topic']=$lang['forum']['last_topic'];
$page['L_statistics']=$lang['forum']['statistics'];
$page['L_forum_list']=$lang['forum']['forum_list'];

$page['L_forum']=$lang['forum']['forum'];
$page['L_topic']=$lang['forum']['topic'];
$page['L_member']=$lang['forum']['author'];
$page['L_date']=$lang['forum']['date'];

$page['L_connecte']=$lang['general']['connecte'];


$page['link_forum']=convert_url("index.php?r=".$lang['general']['idurl_forum']."&v1=forum_list");


# meta
$page['meta_title']=$lang['general']['forum'];
$page['meta_description']=$lang['forum']['meta_description'];
$page['meta_keyword']=$lang['forum']['meta_keyword'];

$page['template']=$tpl['forum']['home'];

?>