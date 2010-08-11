<?php
$nb_max=NB_FORUM_TOPIC; // number of topics per page

$page['template']="";
$page['topic']=array();
$page['page']=array();
$page['link_first_page']="";
$page['link_previous_page']="";
$page['link_last_page']="";
$page['link_next_page']="";
$page['L_message_topic']="";
$page['L_message_add']="";
$page['form_display']="none";
$nb_erreur="0";
$spam=0;


if(isset($forum['forum_id']))
{
 $var['forum']=$forum['forum_id'];
 $var['id']=$forum['forum_id'];
 $var['topic']="0";
 /* on recupere les infos sur le forum */
 $sql_forum=sql_replace($sql['forum']['select_forum_details'],$var);
 $sql_nb_topic=sql_replace($sql['forum']['select_nb_message'],$var);
 $sgbd = sql_connect();
 $res_forum = sql_query($sql_forum);
 $ligne=sql_fetch_array($res_forum);
 $page['forum_name']=$ligne['forum_name'];
 $page['forum_description']=$ligne['forum_description'];
 sql_free_result($res_forum);
 sql_close($sgbd);
}


# formulaire d'add de message
$page['value_title']="";
$page['value_text']="";
$page['value_id']="";
$page['value_topic']="";
$page['erreur']=array();

$page['form_action']=convert_url("index.php?r=".$lang['general']['idurl_forum']."&v1=".$forum['forum_idurl']);

/* modification ou add */
if(isset($_POST) AND !empty($_POST))
{
 /* we format datas */
 $_POST['title']=format_txt($_POST['title']);
 $_POST['text']=trim($_POST['text']);

 /* verification des infos */
 if(!isset($_POST['title']) OR $_POST['title']=="") { $page['erreur'][$nb_erreur]['message']=$lang['forum']['E_empty_title']; $nb_erreur++; }
 if(!isset($_POST['text']) OR trim(html2txt($_POST['text']))=="") { $page['erreur'][$nb_erreur]['message']=$lang['forum']['E_empty_message']; $nb_erreur++; }


 /* we format datas */
 if(isset($_SESSION['session_member_id']) AND !empty($_SESSION['session_member_id']))
 { $_POST['member']=$_SESSION['session_member_id']; }
 else { $_POST['member']=0; }
 $_POST['forum']=$forum['forum_id'];
 $_POST['ip']=$_SERVER['REMOTE_ADDR'];

 if(!isset($_POST['topic']) OR $_POST['topic']=="") { $_POST['topic']="0"; }
 
 # the field email must not be filled in otherwise it mey be a spam robot
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
  /* cas d'une mise a day */
  else //if($right_user['edit_message'])
  {
   $sql_edit=sql_replace($sql['forum']['edit_message'],$_POST);
   $sgbd = sql_connect();
   if(sql_query($sql_edit) != false) { $page['L_message_add']=$lang['forum']['form_message_edit_1']; }
   else { $page['L_message_add']=$lang['forum']['form_message_edit_0']; }
   sql_close($sgbd);


   if($_POST['topic']!="0") { $url_redirection=convert_url("index.php?r=".$lang['general']['idurl_forum']."&v1=".$forum['forum_idurl']."&v2=topic_".$_POST['topic']); }
   else  { $url_redirection=convert_url("index.php?r=".$lang['general']['idurl_forum']."&v1=".$forum['forum_idurl']."&v2=topic_".$_POST['id']); }


   header("location:".$url_redirection);
   exit();
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


/**********************/
/* LIMIT              */
/**********************/

if(!isset($var['limit']))
{
 /* on recupere le nb d'element */
 $sql_nb=sql_replace($sql_nb_topic,$var);
 $sgbd = sql_connect();
 $res_nb = sql_query($sql_nb);
 $ligne=sql_fetch_array($res_nb);
 $nb=$ligne['nb_message'];
 sql_free_result($res_nb);
 sql_close($sgbd);


 /***************/
 /* PAGINATION */
 /**************/
 if(!isset($_GET['v2']) OR $_GET['v2']=="" OR !ereg("page",$_GET['v2'])) { $page_num="1"; }
 else { $page_num=explode("_",$_GET['v2']); $page_num=$page_num['1']; }

 # number of the current page
 $var['limit']="LIMIT ".($page_num-1)*$nb_max.",".$nb_max;
 $nb_page=ceil($nb/$nb_max);

 $url="index.php?r=".$lang['general']['idurl_forum']."&v1=".$forum['forum_idurl']."&v2=page_";
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

/************************/
/* START CONDITIONS  */
/************************/

$condition=array();

/* si un forum est selectionne, on choisi les topics du forum */
if(isset($forum['forum_id'])) {  array_push($condition," m.forum_id='".$forum['forum_id']."' "); }

/* par defaut */
//array_push($condition," lang_id='".LANG_ID."' ");
array_push($condition," m.message_parent_id='0' "); /* les topics n'ont pas de message parent*/

# creation of conditions list
$nb_condition=sizeof($condition);
if($nb_condition==0) { $var['condition']=""; }
elseif($nb_condition=="1") { $var['condition']="WHERE ".$condition['0']; }
else { $var['condition']="WHERE ".implode(" AND ",$condition); }

/**********************/
/* END OF CONDITIONS    */
/**********************/
if(!isset($var['order'])) { $var['order']=" ORDER BY dm.message_date_add DESC ";}


$sql_topic=sql_replace($sql['forum']['select_topic'],$var);

$sgbd = sql_connect();
$res_message = sql_query($sql_topic);
$nb_ligne=sql_num_rows($res_message);
if($nb_ligne=="0")
{
 $page['L_message_topic']=$lang['forum']['E_message_not_found'];
}
else
{
 $i="0";
 while($ligne = sql_fetch_array($res_message))
 {
  $page['topic'][$i]['forum']=$ligne['forum_name'];
  $page['topic'][$i]['id']=$ligne['message_id'];
  $page['topic'][$i]['title']=$ligne['message_title'];
  $page['topic'][$i]['title_court']=text_tronquer($ligne['message_title'],30);
  $page['topic'][$i]['message']=$ligne['message_text'];
  $page['topic'][$i]['login']=$ligne['member_login'];
  $page['topic'][$i]['link_member']=convert_url("index.php?r=".$lang['general']['idurl_member']."&v1=view&v2=".$ligne['member_id']);
  
  $page['topic'][$i]['L_guest']="";  
  if($ligne['member_login']==NULL) $page['topic'][$i]['L_guest']= $lang['forum']['guest'];


  $page['topic'][$i]['date']=convert_date($ligne['message_date_add'],$lang['forum']['format_date_php']);
  $page['topic'][$i]['visit']=$ligne['message_visit'];
  $page['topic'][$i]['reponse']=$ligne['message_nb_reply'];
  $page['topic'][$i]['login_last']=$ligne['member_login_last'];
  $page['topic'][$i]['L_last_guest']="";  
  if($ligne['member_login_last']==NULL) $page['topic'][$i]['L_last_guest']= $lang['forum']['guest'];

  $page['topic'][$i]['date_dernier_message']=$ligne['dernier_message_date'];
  
  
  # calcul du number de day depuis le dernier message
   $ecart=ecartDate($ligne['dernier_message_date'],date("Y-m-d H:i:s"));
   
   if( $ecart < (60*60)) { $ecart=floor($ecart / (60)); $unite=$lang['general']['minute']; }
   elseif( $ecart < (60*60*24)) { $ecart = floor($ecart / (60*60)); $unite=$lang['general']['hour']; }
   elseif( $ecart < (60*60*24*(365/12))) { $ecart = floor($ecart / (60*60*24)); $unite=$lang['general']['day']; }
   elseif( $ecart < (60*60*24*365)) { $ecart = floor($ecart / (60*60*24*(365/12))); $unite=$lang['general']['month']; }
   else { $ecart = floor($ecart / (60*60*24*365)); $unite=$lang['general']['year']; }

   $page['topic'][$i]['date_dernier_message']=$ecart;
   $page['topic'][$i]['date_dernier_message_unite']=$unite;
   $page['topic'][$i]['L_il_y_a']=$lang['forum']['il_y_a'];

  
  
  $page['topic'][$i]['link_forum']=convert_url("index.php?r=".$lang['general']['idurl_forum']."&v1=".$ligne['forum_idurl']);
  $page['topic'][$i]['link_topic']=convert_url("index.php?r=".$lang['general']['idurl_forum']."&v1=".$ligne['forum_idurl']."&v2=topic_".$ligne['message_id']);
  $page['topic'][$i]['L_view']=$lang['forum']['view'];

  $page['topic'][$i]['mod']=$i%2;

  if(isset($_SESSION['session_date_connection']) AND $_SESSION['session_date_connection'] < $ligne['message_date_add'])
  {
   $page['topic'][$i]['nouveau']="1";
  }
  else
  {
   $page['topic'][$i]['nouveau']="";
  }

  $i++;
 }
}
sql_free_result($res_message);
sql_close($sgbd);


# text
$page['L_title']=$lang['forum']['forum'];

$page['L_title_message']=$lang['forum']['title'];
$page['L_message']=$lang['forum']['message'];
$page['L_add']=$lang['forum']['add_message'];
$page['L_reduire']=$lang['forum']['hide'];

$page['L_topic_list']=$lang['forum']['topic_list'];
$page['L_topic']=$lang['forum']['topic'];
$page['L_member']=$lang['forum']['author'];
$page['L_date']=$lang['forum']['date'];
$page['L_lecture']=$lang['forum']['views'];
$page['L_reponse']=$lang['forum']['replies'];
$page['L_dernier_message']=$lang['forum']['last_message'];
$page['L_page']=$lang['forum']['page'];

$page['L_valider']=$lang['forum']['submit'];
$page['L_erreur']=$lang['general']['E_erreur'];

$page['L_first_page']=$lang['forum']['first_page'];
$page['L_previous_page']=$lang['forum']['previous_page'];
$page['L_next_page']=$lang['forum']['next_page'];
$page['L_last_page']=$lang['forum']['last_page'];


$page['template']=$tpl['forum']['topic_list'];
?>