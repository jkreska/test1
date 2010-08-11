<?php
$nb_max=NB_FORUM_MESSAGE; // number de messages par page

$page['page']=array();
$page['link_first_page']="";
$page['link_previous_page']="";
$page['link_last_page']="";
$page['link_next_page']="";
$page['L_message_message']="";
$page['L_message_add']="";
$page['form_display']="none";
$form_invalid="0";
$nb_erreur="0";
$spam=0;

# formulaire d'add de message
$page['value_title']="";
$page['value_text']="";
$page['value_id']="";
$page['value_topic']=$forum['topic_id'];
$page['erreur']=array();

$page['form_action']=convert_url("index.php?r=".$lang['general']['idurl_forum']."&v1=".$forum['forum_idurl']."&v2=topic_".$forum['topic_id']);


/* modification ou add d'un message */
if(isset($_POST) AND !empty($_POST))
{
 /* we format datas */
 $_POST['title']=format_txt($_POST['title']);
 $_POST['text']=trim($_POST['text']);

 /* verification des infos */ 
 if(!isset($_POST['title']) OR $_POST['title']=="") { $form_invalid=1; $page['erreur'][$nb_erreur]['message']=$lang['forum']['E_empty_title']; $nb_erreur++; }
 if(!isset($_POST['text']) OR trim(html2txt($_POST['text']))=="") { $form_invalid=1; $page['erreur'][$nb_erreur]['message']=$lang['forum']['E_empty_message']; $nb_erreur++; }


 /* we format datas */
 if(isset($_SESSION['session_member_id']) AND !empty($_SESSION['session_member_id']))
 { $_POST['member']=$_SESSION['session_member_id']; }
 else { $_POST['member']=0; }
 $_POST['forum']=$forum['forum_id'];
 $_POST['ip']=$_SERVER['REMOTE_ADDR'];

 if(!isset($_POST['topic']) OR $_POST['topic']=="") { $_POST['topic']="0"; }
 
 # the field email must not be filled in otherwise it is a spam robot
 if(!isset($_POST['email']) OR !empty($_POST['email'])) { $spam=1; } 
  
 if($nb_erreur==0)
 {
  $_POST['text']=addslashes($_POST['text']);

  if($spam==1) {
  	# if the message is a potential spam, we do as if everything worked but nothing is saved
  	$page['L_message_add']=$lang['forum']['form_message_add_1'];	
  }
  elseif(empty($_POST['id']))
  {
	# new message to add
	$sgbd = sql_connect();
	$_POST['last_child']="0";
	$sql_add = sql_replace($sql['forum']['insert_message'],$_POST);
	if(sql_query($sql_add) != false) { $page['L_message_add']=$lang['forum']['form_message_add_1']; }
	else { $page['L_message_add']=$lang['forum']['form_message_add_0']; }
	$id_topic=sql_insert_id($sgbd);
	
	$_POST['last_child']=$id_topic;
   
	/* Si c'est un nouveau topic, on lui indique que c'est lui son propre dernier message, si c'est un reponse, alors on augmente le number de reponse au topic */
	if($_POST['topic']!="0")
	{    
		$sql_nb_reply=sql_replace($sql['forum']['edit_message_reponse'],$_POST);
		sql_query($sql_nb_reply);
	}
	else
	{
		$_POST['topic']=$id_topic;
		$sql_nb_reply=sql_replace($sql['forum']['edit_message_reponse'],$_POST);
		// astuce pour ne pas le comptabiliser comme reponse 
		$sql_nb_reply_sup=sql_replace($sql['forum']['edit_message_reponse_sup'],$_POST);
		sql_query($sql_nb_reply);
		sql_query($sql_nb_reply_sup);	  
	}
	sql_close($sgbd);

  }
  else //if($right_user['edit_message'])
  {
  	# update of the message
   $sql_edit=sql_replace($sql['forum']['edit_message'],$_POST);
   $sgbd = sql_connect();
   if(sql_query($sql_edit) != false) { $page['L_message_add']=$lang['forum']['form_message_edit_1']; }
   else { $page['L_message_add']=$lang['forum']['form_message_edit_0']; }
   sql_close($sgbd);

   if($_POST['topic']!="0") { $url_redirection=convert_url("index.php?r=".$lang['general']['idurl_forum']."&v1=".$forum['forum_idurl']."&v2=topic_".$_POST['topic']); }
   else  { $url_redirection=convert_url("index.php?r=".$lang['general']['idurl_forum']."&v1=".$forum['forum_idurl']."&v2=topic_".$_POST['id']); }


  }
 }
 /* on affiche les erreurs et on reaffiche le formulaire */
 else
 {
  $page['value_id']=$_POST['id'];
  $page['value_topic']=$_POST['topic'];
  $page['value_title']=$_POST['title'];
  $page['value_text']=StripSlashes($_POST['text']);
  $page['form_display']="block";
 }
}


/* suppression */
if($right_user['delete_message'] AND isset($_GET['v4']) AND isset($_GET['v3']) AND $_GET['v3']=="delete")
{
 $var['id']=$_GET['v4'];
 /* on verifie que l'on peut bien delete */
 $sql_verif_sup=sql_replace($sql['forum']['verif_sup_message'],$var);
 $sgbd = sql_connect();
 $res_verif=sql_query($sql_verif_sup);
 $nb_ligne=sql_num_rows($res_verif);

 if($nb_ligne !="0")
 {
  $page['L_message_message']=$lang['forum']['form_message_sup_0'];
 }
 else
 {
  
  $sql_sup=sql_replace($sql['forum']['sup_message'],$var);
  $var['topic']=$forum['topic_id'];
  
  # we decremente the message and get the last message of the topic 
  $var2['condition']=" WHERE m.message_parent_id='".$forum['topic_id']."' OR m.message_id='".$forum['topic_id']."' ";
  $var2['limit']=" LIMIT 1";   
  $var2['order']=" ORDER BY m.message_date_add DESC";      
  $sql_last_message=sql_replace($sql['forum']['select_topic_message_condition'],$var2);
   
  $sgbd = sql_connect();
  if(sql_query($sql_sup)) { $page['L_message_message']=$lang['forum']['form_message_sup_1']; }
  else { $page['L_message_message']=$lang['forum']['form_message_sup_0']; }

  $res=sql_query($sql_last_message);
  $ligne=sql_fetch_array($res);
  $var['last_child']=$ligne['message_id'];  
  $sql_sup_reply=sql_replace($sql['forum']['edit_message_reponse_sup'],$var);
  
  sql_query($sql_sup_reply);
  sql_close($sgbd);
  

  if($var['id']==$forum['topic_id'])
  {
   $url_redirection=convert_url("index.php?r=".$lang['general']['idurl_forum']."&v1=".$forum['forum_idurl']);
   header("location:".$url_redirection);
   exit();
  }

 }
}


$page['template']="";
$page['message']=array();

$var['id']=$forum['forum_id'];
$var['topic']=$forum['topic_id'];


/**********************/
/* LIMIT              */
/**********************/

if(!isset($var['limit']))
{
 /* on recupere le nb d'element */
 $sql_nb_message=sql_replace($sql['forum']['select_nb_message'],$var);
 $sql_nb=sql_replace($sql_nb_message,$var);
 $sgbd = sql_connect();
 $res_nb = sql_query($sql_nb);
 $ligne=sql_fetch_array($res_nb);
 $nb=$ligne['nb_message'];
 sql_free_result($res_nb);
 sql_close($sgbd);


 /***************/
 /* PAGINATION */
 /**************/
 if(!isset($_GET['v3']) OR $_GET['v3']=="" OR !ereg("page",$_GET['v3'])) { $page_num="1"; }
 else { $page_num=explode("_",$_GET['v3']); $page_num=$page_num['1']; }

 # number of the current page
 $var['limit']="LIMIT ".($page_num-1)*$nb_max.",".$nb_max;
 $nb_page=ceil($nb/$nb_max);

 $url="index.php?r=".$lang['general']['idurl_forum']."&v1=".$forum['forum_idurl']."&v2=topic_".$var['topic']."&v3=page_";
 $end_url="";

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



$sql_message=sql_replace($sql['forum']['select_topic_message'],$var);

$sgbd = sql_connect();
$res_message = sql_query($sql_message);
$nb_ligne=sql_num_rows($res_message);
sql_free_result($sql_message);


if($nb_ligne=="0")
{
 $page['L_message_message']=$lang['forum']['E_message_not_found'];
}
else
{
 $i="0";
 while($ligne = sql_fetch_array($res_message))
 {
  if($i=="0") { $page['title']=$ligne['message_title']; 
  if(empty($page['value_title'])) $page['value_title']=$page['title'];
  }
  $page['message'][$i]['id']=$ligne['message_id'];
  $page['message'][$i]['topic']=$ligne['message_parent_id'];
  $page['message'][$i]['title']=$ligne['message_title'];
  $page['message'][$i]['ip']="";
  if($right_user['delete_message']) { $page['message'][$i]['ip']=$ligne['member_ip']; }
  $page['message'][$i]['message']=nl2br(stripslashes($ligne['message_text']));
  $page['message'][$i]['value_message']=stripslashes($ligne['message_text']);

  $page['message'][$i]['date']=convert_date($ligne['message_date_add'],$lang['forum']['format_date_php']);
  $page['message'][$i]['login']=$ligne['member_login'];
  $page['message'][$i]['avatar']="";
  if($ligne['member_avatar']!=NULL) $page['message'][$i]['avatar']=$ligne['member_avatar'];
  $page['message'][$i]['L_guest']="";
  
  if($ligne['member_login']==NULL) $page['message'][$i]['L_guest']= $lang['forum']['guest'];
  
  $page['message'][$i]['link_delete']="";
  $page['message'][$i]['link_view']=convert_url("index.php?r=".$lang['general']['idurl_member']."&v1=view&v2=".$ligne['member_id']);
  
  $page['message'][$i]['mod']=$i%2;

  $page['message'][$i]['form_action']=convert_url("index.php?r=".$lang['general']['idurl_forum']."&v1=".$forum['forum_idurl']."&v2=topic_".$forum['topic_id']);
  $page['message'][$i]['form_display']="none";
  $page['message'][$i]['L_title_message']=$lang['forum']['title'];
  $page['message'][$i]['L_message']=$lang['forum']['message'];
  $page['message'][$i]['L_ip']=$lang['forum']['ip'];
  $page['message'][$i]['L_reduire']=$lang['forum']['hide'];
  $page['message'][$i]['L_valider']=$lang['forum']['submit'];
  
  
  if((isset($_SESSION['session_member_id']) AND $_SESSION['session_member_id']==$ligne['member_add_id']) OR $right_user['edit_message'])
  {
   $page['message'][$i]['link_edit']=convert_url("index.php?r=".$lang['general']['idurl_forum']."&v1=".$forum['forum_idurl']."&v2=message&v3=topic_".$forum['topic_id']."&v4=".$ligne['message_id']);

   if($right_user['delete_message'])
   {
    $page['message'][$i]['link_delete']=convert_url("index.php?r=".$lang['general']['idurl_forum']."&v1=".$forum['forum_idurl']."&v2=topic_".$forum['topic_id']."&v3=delete&v4=".$ligne['message_id']);
   }
  }
  else
  {
   $page['message'][$i]['link_edit']="";
  }
  $page['message'][$i]['L_edit']=$lang['forum']['editer'];
  $page['message'][$i]['L_delete']=$lang['forum']['delete'];

  $i++;
 }
}

/* on incremente le number de visit du topic */
$sql_visit=sql_replace($sql['forum']['edit_message_visit'],$var);
sql_query($sql_visit);

sql_free_result($res_message);
sql_close($sgbd);



# Elements de text
$page['L_title_message']=$lang['forum']['title'];
$page['L_message']=$lang['forum']['message'];
$page['L_reduire']=$lang['forum']['hide'];
$page['L_repondre']=$lang['forum']['reply'];
$page['L_valider']=$lang['forum']['submit'];
$page['L_erreur']=$lang['general']['E_erreur'];

$page['L_topic']=$lang['forum']['topic'];
$page['L_member']=$lang['forum']['author'];
$page['L_page']=$lang['forum']['page'];
$page['L_topic_list']=$lang['forum']['topic_list'];

$page['L_first_page']=$lang['forum']['first_page'];
$page['L_previous_page']=$lang['forum']['previous_page'];
$page['L_next_page']=$lang['forum']['next_page'];
$page['L_last_page']=$lang['forum']['last_page'];


$page['meta_title']=$page['title'];
$page['meta_description']="";
$page['meta_keyword']=$page['title'];
$page['meta_date']=$page['message'][0]['date'];
$page['template']=$tpl['forum']['message_list'];
?>