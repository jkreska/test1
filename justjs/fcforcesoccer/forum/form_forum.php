<?php
##################################
# forum 
##################################

# variables
$page['L_message_forum']="";
$nb_erreur="0";
$page['erreur']=array();

# form values
$page['value_id']="";
$page['value_idurl']="";
$page['value_name']="";
//$page['value_lang']="";
$page['value_description']="";
$page['value_status']="";
$page['value_order']="";

# si l'identifiant du club est passe dans l'url (modification), on le recupere
if(isset($_GET['v2']) AND $_GET['v2']!="") {  $page['value_id']=$_GET['v2']; }
elseif(isset($_POST['id']) AND $_POST['id']!="") { $page['value_id']=$_POST['id']; }


if($right_user['add_forum'] OR $right_user['edit_forum']) {
	$page['show_form']=1; 
}
else {
	$page['show_form']='';
	$page['L_message']=$lang['general']['acces_reserve_admin'];
}

# case of add or edit
if(isset($_POST) AND !empty($_POST))
{
 # we format datas
 $_POST['idurl']=format_txt($_POST['idurl']);
 $_POST['name']=format_txt($_POST['name']);
 $_POST['description']=format_txt($_POST['description']);
  
 # we check datas
 if(!isset($_POST['name']) OR $_POST['name']=="") { $page['erreur'][$nb_erreur]['message']=$lang['forum']['E_empty_name']; $nb_erreur++; }
 if(!isset($_POST['idurl']) OR $_POST['idurl']=="") { $page['erreur'][$nb_erreur]['message']=$lang['forum']['E_empty_idurl']; $nb_erreur++; }
 else # we check if it does not already exist
 {
   $sgbd = sql_connect();
   $sql_verif_forum = sql_replace($sql['forum']['verif_forum'],$_POST);
   $res = sql_query($sql_verif_forum);
   $nb_res = sql_num_rows($res);
   sql_free_result($res);
   sql_close($sgbd);
   if($nb_res!="0") { $page['erreur'][$nb_erreur]['message']=$lang['forum']['E_exist_forum']; $nb_erreur++; }
 }

 $_POST['member']=$_SESSION['session_member_id'];

 # there is no error in submited datas
 if($nb_erreur==0)
 {
  # case : new item to add
  if(empty($_POST['id']) AND $right_user['add_forum'])
  {
   $sgbd = sql_connect();
   $_POST['order']=$_POST['order']+1;
   $sql_add = sql_replace($sql['forum']['insert_forum'],$_POST);

   if(sql_query($sql_add)) {
   		# we edit the order of next forums (we add +1)
		$page['L_message_forum']=$lang['forum']['form_forum_add_1'];
		$page['value_id']=sql_insert_id($sgbd);
		$var['id']=$page['value_id'];
		$var['order']=$_POST['order'];
		$sql_order=sql_replace($sql['forum']['edit_forum_order_insert'],$var);		
		sql_query($sql_order);		
	}
   else { $page['L_message_forum']=$lang['forum']['form_forum_add_0']; }
   sql_close($sgbd);
  }
  # cas d'une mise a jour
  elseif($right_user['edit_forum'])
  {
	/* on regarde si on doit modifier l'ordre des forums :
	- si le rang du forum n'a pas été modifié, pas de probleme on ne modifie rien
	- sinon, on doit modifier les rangs des forums situés entre le nouveau et l'ancien rang du forum	
	*/
	if($_POST['order']=="" OR $_POST['order']==$_POST['former_order']) { 
	 	$_POST['order']=$_POST['former_order'];
		$edit_order=0;
	}
	else {
	 	$edit_order=1;
	 	if($_POST['order']==0) { $_POST['order']="1"; }		
		$var['id']=$_POST['id'];
		
		if($_POST['order'] > $_POST['former_order']) {
			$var['order_min']=$_POST['former_order'];
			$var['order_max']=$_POST['order'];
			$var['signe']="-";
			$sql_order=sql_replace($sql['forum']['edit_forum_order_edit'],$var);
		}
		else {
			$var['order_min']=$_POST['order'];
			$var['order_max']=$_POST['former_order'];
			$var['signe']="+";
			$sql_order=sql_replace($sql['forum']['edit_forum_order_edit'],$var);			
		}	
 	}
	
	$sql_edit=sql_replace($sql['forum']['edit_forum'],$_POST);
	$sgbd = sql_connect();
	if(sql_query($sql_edit)) {
		$page['L_message_forum']=$lang['forum']['form_forum_edit_1'];
		# we edit the order
		if($edit_order==1) sql_query($sql_order);
	}
	else { $page['L_message_forum']=$lang['forum']['form_forum_edit_0']; }
	sql_close($sgbd);
  }
 }
 else
 {
  # il y a des erreurs : on reaffiche les donnee
  $page['value_id']=$_POST['id'];
  $page['value_name']=$_POST['name'];
  $page['value_idurl']=$_POST['idurl'];
  $page['value_description']=$_POST['description'];
  $page['value_order']=$_POST['order'];
 }
}


# if the ID is known, we get the datas to show them in the form
if(isset($page['value_id']) AND $page['value_id']!="" AND $nb_erreur==0)
{
 $var['id']=$page['value_id'];
 $sql_details=sql_replace($sql['forum']['select_forum_details'],$var);

 $sgbd = sql_connect();
 $res = sql_query($sql_details);
 $ligne = sql_fetch_array($res);
 sql_free_result($res);
 sql_close($sgbd);

 $page['value_name']=$ligne['forum_name'];
 $page['value_idurl']=$ligne['forum_idurl'];
 $page['value_description']=$ligne['forum_description'];
 $page['value_status']=$ligne['forum_status'];
 $page['value_order']=$ligne['forum_order'];
}



# other forum list (for the order)
$page['order']=array();
$sgbd = sql_connect();
$var['condition']="";
$var['limit']="";
$var['order']="ORDER BY forum_order";
$res = sql_query(sql_replace($sql['forum']['select_forum_condition'],$var));
$nb_ligne=sql_num_rows($res);
$page['nb_forum']=$nb_ligne;
if($nb_ligne!="0")
{
 $i="0";
 while($ligne = sql_fetch_array($res))
 {
  if($page['value_order']==$ligne['forum_order']) {
	  $page['order'][$i]['order']="";
	  $page['order'][$i]['name']=$lang['forum']['same_position'];
      $page['order'][$i]['selected']='selected="selected"';
  }
  else {
	  $page['order'][$i]['order']=$ligne['forum_order']-1;
	  $page['order'][$i]['name']=$lang['forum']['before']." ".$ligne['forum_name'];
	  $page['order'][$i]['selected']="";  
  }
  $i++;
 }
}
sql_free_result($res);
sql_close($sgbd);



# status
$page['status']=array();
$page['status']['0']['id']="0";
$page['status']['0']['name']=$lang['forum']['status_0'];
$page['status']['0']['info']=$lang['forum']['status_public_info'];
$page['status']['0']['checked']="";
$page['status']['1']['id']="1";
$page['status']['1']['name']=$lang['forum']['status_1'];
$page['status']['1']['info']=$lang['forum']['status_member_info'];
$page['status']['1']['checked']="";
$page['status']['2']['id']="2";
$page['status']['2']['name']=$lang['forum']['status_2'];
$page['status']['2']['info']=$lang['forum']['status_admin_info'];
$page['status']['2']['checked']="";
$page['status']['3']['id']="-1";
$page['status']['3']['name']=$lang['forum']['status_-1'];
$page['status']['3']['info']=$lang['forum']['status_closed_info'];
$page['status']['3']['checked']="";

switch($page['value_status']) {
 case "0" : $page['status']['0']['checked']="checked"; break;
 case "1" : $page['status']['1']['checked']="checked"; break;
 case "2" : $page['status']['2']['checked']="checked"; break;
 case "-1" : $page['status']['3']['checked']="checked"; break;
 default : $page['status']['0']['checked']="checked";
}

# links
$page['form_action']=convert_url("index.php?r=".$lang['general']['idurl_forum']."&v1=form_forum&v2=".$page['value_id']);
if($right_user['delete_forum'] AND !empty($page['value_id']))
{
 $page['link_delete']=convert_url("index.php?r=".$lang['general']['idurl_forum']."&v1=forum_list&v2=delete&v3=".$page['value_id']);
}
else
{
 $page['link_delete']="";
}

$page['link_list']=convert_url("index.php?r=".$lang['general']['idurl_forum']."&v1=forum_list");

# elements de text
if(empty($page['value_id'])) { $page['L_title']=$lang['forum']['form_forum_add']; }
else { $page['L_title']=$lang['forum']['form_forum_edit']; }
$page['L_valider']=$lang['forum']['submit'];
$page['L_delete']=$lang['forum']['delete'];
$page['L_back_list']=$lang['forum']['back_forum_list']; 
$page['L_erreur']=$lang['general']['E_erreur'];
$page['L_field_required']=$lang['general']['field_required'];

$page['L_idurl']=$lang['forum']['idurl'];
$page['L_name']=$lang['forum']['name'];
$page['L_idurl_auto']=$lang['forum']['idurl_auto'];
$page['L_description']=$lang['forum']['description'];
$page['L_order']=$lang['forum']['order'];
$page['L_first']=$lang['forum']['first'];
$page['L_last']=$lang['forum']['last'];
$page['L_status']=$lang['forum']['status'];
 
$page['meta_title']=$page['L_title'];
$page['meta_charset']=$lang['general']['charset'];
$page['template']=$tpl['forum']['form_forum'];
?>