<?php
##################################
# position 
##################################

# variables
$page['L_message']="";
$page['form_action']=convert_url("index.php?r=".$lang['general']['idurl_team']."&v1=position_list");
$nb_erreur="0";
$page['erreur']=array();
$page['position']=array();

# form values
$page['value_id']="";
$page['value_name']="";
$page['value_order']="";

# cas d'une suppression 
if($right_user['position_list'] AND isset($_GET['v2']) AND isset($_GET['v3']) AND $_GET['v3']=="delete" AND (!isset($included) OR $included==0))
{
 $var['id']=$_GET['v2'];
 $sql_verif=sql_replace($sql['team']['verif_position'],$var); 
 $sgbd = sql_connect();
 
 # verification
 if(sql_num_rows(sql_query($sql_verif))!="0") { 
 	$page['erreur'][$nb_erreur]['message']=$lang['team']['E_exist_position_team']; $nb_erreur++;
 }
 
 if($nb_erreur==0)
 {
  # we get the position order
  $sql_order=sql_replace($sql['team']['select_position_details'],$var);    
  $sgbd = sql_connect();
  $res_order=sql_query($sql_order);
  $ligne_order=sql_fetch_array($res_order);
  $var['order_min']=$ligne_order['position_order'];
  
  # we delete the position
  $sql_sup=sql_replace($sql['team']['sup_position'],$var);
  if(sql_query($sql_sup)) { $page['L_message']=$lang['team']['form_position_sup_1']; }
  else { $page['L_message']=$lang['team']['form_position_sup_0']; }  
  
  # we update the order
  $var['signe']="-";
  $var['order_max']="999";
  $sql_reorder=sql_replace($sql['team']['edit_position_order_edit'],$var);
  sql_query($sql_reorder);
  sql_close($sgbd);
 }
}

# case of add or edit
if($right_user['position_list'] AND isset($_POST) AND !empty($_POST) AND (!isset($included) OR $included==0))
{
 # we format datas
 if(isset($_POST['name'])) $_POST['name']=format_txt($_POST['name']);

 # we check datas
 if(!isset($_POST['name']) OR $_POST['name']=="") { $page['erreur'][$nb_erreur]['message']=$lang['team']['E_empty_name_position']; $nb_erreur++; }
 else
 {
  # we check if it does not already exist
   $sgbd = sql_connect();
   $sql_verif = sql_replace($sql['team']['verif_presence_position'],$_POST);
   $res_verif = sql_query($sql_verif);
   $nb_res = sql_num_rows($res_verif);
   sql_free_result($res_verif);
   sql_close($sgbd);
   if($nb_res!="0") { $page['erreur'][$nb_erreur]['message']=$lang['team']['E_exist_position']; $nb_erreur++; }
 }

 # there is no error in submited datas
 if($nb_erreur==0)
 {
  # case : new item to add
  if(!isset($_POST['id']) OR empty($_POST['id']))
  {
   $sql_add=sql_replace($sql['team']['insert_position'],$_POST);
   $sgbd = sql_connect();
   if(sql_query($sql_add) != false) { $page['L_message']=$lang['team']['form_position_add_1']; }
   else { $page['L_message']=$lang['team']['form_position_add_0']; }
   sql_close($sgbd);
  }
  # case : item to modify
  else
  {
   $sql_modification=sql_replace($sql['team']['edit_position'],$_POST);
   $sgbd = sql_connect();
   if(sql_query($sql_modification) != false) { $page['L_message']=$lang['team']['form_position_edit_1']; }
   else { $page['L_message']=$lang['team']['form_position_edit_0']; }
   sql_close($sgbd);
  }
 }
 else
 {
  # there is some errors: we show the datas again
  if(isset($_POST['id'])) $page['value_id']=$_POST['id'];
  if(isset($_POST['name'])) $page['value_name']=$_POST['name'];
 }
}


# we organize the position (order)
if($right_user['position_list'] AND isset($_GET['v2']) AND $_GET['v2']=="organize" AND isset($_GET['v3']) AND isset($_GET['v4']) AND !empty($_GET['v4']) AND isset($_GET['v5']) AND (!isset($included) OR $included==0))
{
 $var['mode']=$_GET['v2'];
 $var['action']=$_GET['v3'];
 $var['order']=$_GET['v4'];
 $var['id']=$_GET['v5'];
 
  $sgbd = sql_connect();  
  $res=sql_query($sql['team']['select_position_nb']);
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
    $sql_new_order=sql_replace($sql['team']['edit_position_new_order'],$var);
	$sql_order=sql_replace($sql['team']['edit_position_order'],$var);	
	sql_query($sql_new_order);
	sql_query($sql_order);
   }
   sql_close($sgbd);
   unset($var);
}



# positions list
$sql_liste=$sql['team']['select_position'];
$sgbd = sql_connect();
$res_liste = sql_query($sql_liste);
$nb_ligne=sql_num_rows($res_liste);
$page['value_order']=$nb_ligne+1;
$i="0";
while($ligne = sql_fetch_array($res_liste))
{
	$page['position'][$i]['id']=$ligne['position_id'];
	$page['position'][$i]['name']=$ligne['position_name'];
	$page['position'][$i]['order']=$ligne['position_order'];
		
	$page['position'][$i]['link_up']='';
	$page['position'][$i]['link_down']='';
	
	if($ligne['position_order']!="1") {
		$page['position'][$i]['link_up']=convert_url("index.php?r=".$lang['general']['idurl_team']."&v1=position_list&v2=organize&v3=up&v4=".$ligne['position_order']."&v5=".$ligne['position_id']);
	}
	
	if($ligne['position_order']!=$nb_ligne) {
		$page['position'][$i]['link_down']=convert_url("index.php?r=".$lang['general']['idurl_team']."&v1=position_list&v2=organize&v3=down&v4=".$ligne['position_order']."&v5=".$ligne['position_id']);
	}
  
	$page['position'][$i]['form_action']=$page['form_action'];
	$page['position'][$i]['link_modification']=convert_url("index.php?r=".$lang['general']['idurl_team']."&v1=form_position&v2=".$ligne['position_id']);
	$page['position'][$i]['link_suppression']=convert_url("index.php?r=".$lang['general']['idurl_team']."&v1=position_list&v2=".$ligne['position_id']."&v3=delete");
	$page['position'][$i]['L_edit']=$lang['team']['edit'];
	$page['position'][$i]['L_delete']=$lang['team']['delete'];
	$i++;
}
sql_free_result($res_liste);
sql_close($sgbd);

# text
$page['L_title']=$lang['team']['position_list'];
$page['L_liste']=$lang['team']['position_list'];
$page['L_add']=$lang['team']['add_position'];
$page['L_valider']=$lang['team']['submit'];
$page['L_erreur']=$lang['general']['E_erreur'];
$page['L_field_required']=$lang['general']['field_required'];

$page['meta_title']=$lang['team']['position_list'];
$page['template']=$tpl['team']['position_list'];
?>