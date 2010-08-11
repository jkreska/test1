<?php
/* forum */

/* on recupere les infos sur le forum */
$var['idurl']=$_GET['v1'];

$sql_details=sql_replace($sql['forum']['select_forum_details_idurl'],$var);
$sgbd = sql_connect();
$res = sql_query($sql_details);
$ligne = sql_fetch_array($res);
sql_free_result($res);
sql_close($sgbd);

$forum['forum_id']=$ligne['forum_id'];
$forum['forum_idurl']=$ligne['forum_idurl'];
$page['name']=$ligne['forum_name'];
$page['description']=$ligne['forum_description'];
$forum['forum_status']=$ligne['forum_status'];


$page['link_list']=convert_url("index.php?r=".$lang['general']['idurl_forum']."&v1=forum_list");

# modification
$page['link_edit_forum']="";
$page['link_delete_forum']="";
if($right_user['edit_forum'])
{
 $page['link_edit_forum']=convert_url("index.php?r=".$lang['general']['idurl_forum']."&v1=form_forum&v2=".$forum['forum_id']);
}
if($right_user['delete_forum'])
{
 $page['link_delete_forum']=convert_url("index.php?r=".$lang['general']['idurl_forum']."&v1=forum_list&v2=delete&v3=".$forum['forum_id']);

}



$page['L_erreur_forum']="";
$page['aff_form']="1";



// on verifie que le member peut bien acceder a ce forum
if( ($forum['forum_status']==2 AND (!isset($_SESSION['session_status']) OR !in_array($_SESSION['session_status'],array('3','4')))) OR ($forum['forum_status']==1 AND MEMBER!=1))
{
 $page['L_erreur_forum']=$lang['forum']['E_forum_private'];
 $page['contenu']="";
 $page['aff_form']="";
}
else
{
 if($forum['forum_status']==-1) $page['aff_form']="";
 
 $page['link_home']=convert_url("index.php?r=".$lang['general']['idurl_forum']."&v1=".$ligne['forum_idurl']);

/*
if(isset($_GET['v2']) AND $_GET['v2']=="message") // formulaire d'add de message
{
 if(isset($_GET['v3']) AND $_GET['v3']!="")
 {
  $topic=explode("_",$_GET['v3']);
  $forum['topic_id']=$topic['1'];
 }
 else
 {
  $forum['topic_id']="";
 }
 include(create_path("forum/form_message.php"));
 
 $page['contenu']=parse_template(TPL_URL."/".$page['template'],$page);
}
else
*/

if(isset($_GET['v2']) AND $_GET['v2']!="") /* liste des messages du topic */
{
 if(ereg("page",$_GET['v2'])) // il s'agit d'une page de la liste de topics
 {
  include(create_path("forum/topic_list.php"));
  $page['contenu']=parse_template(TPL_URL."/".$page['template'],$page);
 }
 else // on affiche la liste des message
 {
  $topic=explode("_",$_GET['v2']);
  $forum['topic_id']=$topic['1'];
  include(create_path("forum/message_list.php"));
  $page['contenu']=parse_template(TPL_URL."/".$page['template'],$page);
 }
}
else /* liste des topics */
{
 include(create_path("forum/topic_list.php"));
 $page['contenu']=parse_template(TPL_URL."/".$page['template'],$page);
}
}


$page['lang']=LANG;
$page['meta_url']=ROOT_URL;

# text
$page['L_forum']=$lang['forum']['forum'];
$page['L_back_list']=$lang['forum']['back_forum_list']; 
$page['L_edit']=$lang['forum']['edit'];
$page['L_delete']=$lang['forum']['delete'];

$page['meta_title']=$lang['forum']['forum']." > ".$page['name'];
$page['meta_description']=$page['name']." ".$page['description'];
$page['meta_keyword']=html2txt($page['name']." ".$page['description']);;
$page['meta_date']="";

$page['template']=$tpl['forum']['view_forum'];
?>