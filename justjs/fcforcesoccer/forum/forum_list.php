<?php
$page['template']="";
$page['forum']=array();
$page['L_message_forum']="";

/* suppression */
if($right_user['delete_forum'] AND isset($_GET['v2']) AND $_GET['v2']=="delete" AND isset($_GET['v3']) AND !empty($_GET['v3']))
{
 $var['id']=$_GET['v3'];
 /* on verifie que l'on peut bien suppprimer */
 $sql_verif_sup=sql_replace($sql['forum']['verif_sup_forum'],$var);
 $sgbd = sql_connect();
 $res_verif=sql_query($sql_verif_sup);
 $nb_ligne=sql_num_rows($res_verif);

 if($nb_ligne !="0")
 {
  $page['L_message_forum']=$lang['forum']['form_forum_sup_0'];
 }
 else
 {
  # we get the forum order
  $sql_order=sql_replace($sql['forum']['select_forum_order'],$var);    
  $sgbd = sql_connect();
  $res_order=sql_query($sql_order);
  $ligne_order=sql_fetch_array($res_order);
  $var['order_min']=$ligne_order['forum_order'];
  
  # we delete the forum
  $sql_sup=sql_replace($sql['forum']['sup_forum'],$var);  
  if(sql_query($sql_sup)) { $page['L_message_forum']=$lang['forum']['form_forum_sup_1']; }
  else { $page['L_message_forum']=$lang['forum']['form_forum_sup_0']; }  
  
  # we update the order
  $var['signe']="-";
  $var['order_max']="999";
  $sql_reorder=sql_replace($sql['forum']['edit_forum_order_edit'],$var);
  sql_query($sql_reorder);
  sql_close($sgbd);

  $url_redirection=convert_url("index.php?r=".$lang['general']['idurl_forum']);
  header("location:".$url_redirection);
  exit;
 }
}


# ORDONNER LES FORUMS
if($right_user['edit_forum'] AND isset($_GET['v2']) AND $_GET['v3']=="organize" AND isset($_GET['v4']) AND isset($_GET['v5']) AND (!isset($included) OR $included==0))
{
  $var['mode']=$_GET['v2'];
  $var['action']=$_GET['v3'];
  $var['order']=$_GET['v4'];
  $var['id']=$_GET['v5'];
  $sgbd = sql_connect();  
  $res=sql_query($sql['forum']['select_forum_nb']);
  $order=sql_fetch_array($res);
  sql_free_result($res);
  $max=$order['nb'];

   # we check that we can reorder
   $organize="";
   if($var['action']=="up" AND $var['order']!="1") {
    $organize="ok";
    $new_order=$var['order'] - 1;
   }
   elseif($var['action']=="down" AND $var['order']!=$max) {
    $organize="ok";
    $new_order=$var['order'] + 1;
   }

   if($organize=="ok") # we update the current line with the line having the same rank
   {
   	$var['new_order']=$new_order;
    $sql_new_order=sql_replace($sql['forum']['edit_forum_new_order'],$var);
	$sql_order=sql_replace($sql['forum']['edit_forum_order'],$var);	
	sql_query($sql_new_order);
	sql_query($sql_order);
   }
   sql_close($sgbd);
   unset($var);
}



/************************/
/* START CONDITIONS  */
/************************/

$condition=array();

$sql_forum=$sql['forum']['select_forum_condition'];

/* par defaut */
//array_push($condition," lang_id='".LANG_ID."' ");

/* admin */
if(MEMBER!=1) { array_push($condition," forum_status < '1' "); }
if(!isset($_SESSION['session_status']) OR !in_array($_SESSION['session_status'],array('3','4'))) { array_push($condition," forum_status < '2' "); }


# creation of conditions list
$nb_condition=sizeof($condition);
if($nb_condition==0) { $var['condition']=""; }
elseif($nb_condition=="1") { $var['condition']="WHERE ".$condition['0']; }
else { $var['condition']="WHERE ".implode(" AND ",$condition); }

/**********************/
/* END OF CONDITIONS    */
/**********************/

/**********************/
/* ORDER (tri) */
/**********************/
if(!isset($var['order']) OR $var['order']=="") { $var['order']=" ORDER BY forum_order ASC "; }

/**********************/
/* LIMIT              */
/**********************/
if(!isset($var['limit'])) { $var['limit']=""; }


$sql_forum=sql_replace($sql_forum,$var);

$sgbd = sql_connect();
$res_forum = sql_query($sql_forum);
$nb_ligne=sql_num_rows($res_forum);
if(!$right_user['forum_list']) {
	$page['L_message_forum']=$lang['general']['acces_reserve_admin'];
}
elseif($nb_ligne=="0")
{
 $page['L_message_forum']=$lang['forum']['E_forum_not_found'];
}
else
{
 $i="0";
 while($ligne = sql_fetch_array($res_forum))
 {
  $page['forum'][$i]['id']=$ligne['forum_id'];
  $page['forum'][$i]['name']=$ligne['forum_name'];
  $page['forum'][$i]['description']=$ligne['forum_description'];
  $page['forum'][$i]['link_forum']=convert_url("index.php?r=".$lang['general']['idurl_forum']."&v1=".$ligne['forum_idurl']);
  $page['forum'][$i]['L_edit']=$lang['forum']['edit'];
  
  
  if(isset($var['forum']) AND $var['forum']==$ligne['forum_id']) {
   $page['forum'][$i]['selected']='selected="selected"';
  } 
  else { $page['forum'][$i]['selected']=''; }
    
  $page['forum'][$i]['link_up']='';
  $page['forum'][$i]['link_down']='';
  
  
  if($right_user['edit_forum'] AND $ligne['forum_order']!="1") {
    $page['forum'][$i]['link_up']=convert_url("index.php?r=".$lang['general']['idurl_forum']."&v1=forum_list&v2=organize&v3=up&v4=".$ligne['forum_order']."&v5=".$ligne['forum_id']);
  }
	
  if($right_user['edit_forum'] AND $ligne['forum_order']!=$nb_ligne) {
	    $page['forum'][$i]['link_down']=convert_url("index.php?r=".$lang['general']['idurl_forum']."&v1=forum_list&v2=organize&v3=down&v4=".$ligne['forum_order']."&v5=".$ligne['forum_id']);
  }  
  

  $page['forum'][$i]['link_edit']="";
  $page['forum'][$i]['link_delete']="";
  if($right_user['edit_forum']) {
   $page['forum'][$i]['link_edit']=convert_url("index.php?r=".$lang['general']['idurl_forum']."&v1=form_forum&v2=".$ligne['forum_id']);
  }
  if($right_user['delete_forum']) {
   $page['forum'][$i]['link_delete']=convert_url("index.php?r=".$lang['general']['idurl_forum']."&v1=forum_list&v2=delete&v3=".$ligne['forum_id']);
  }
  $i++;
 }
}
sql_free_result($res_forum);
sql_close($sgbd);

if($right_user['add_forum']) {
 $page['link_add']=convert_url("index.php?r=".$lang['general']['idurl_forum']."&v1=form_forum");
}
else {
 $page['link_add']="";
}

$_SESSION['menu_forum']=$page['forum'];


$page['L_add']=$lang['forum']['add_forum'];
$page['L_forum_list']=$lang['forum']['forum_list'];

# meta
$page['meta_title']=$lang['forum']['forum_list'];
if(isset($page['forum'][0]['description'])) {
$page['meta_description']=html2txt($page['forum'][0]['description']);
$page['meta_keyword']=html2txt($page['forum'][0]['name']." ".$page['forum'][0]['description']);
}
$page['meta_date']="";


$page['template']=$tpl['forum']['forum_list'];

?>