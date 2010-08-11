<?php
##################################
# competition 
##################################

# variables
$page['L_message_competition']="";
$page['form_action']=convert_url("index.php?r=".$lang['general']['idurl_competition']."&v1=form_competition");
$nb_erreur="0";
$page['erreur']=array();
$page['pop']="";

# form values
$page['value_id']="";
$page['value_name']="";

if($right_user['add_competition'] OR $right_user['edit_competition']) {
	$page['show_form']=1; 
}
else {
	$page['show_form']='';
	$page['L_message']=$lang['general']['acces_reserve_admin'];
}

# si l'identifiant du competition est passe dans l'url (modification), on le recupere
if(isset($_GET['v2']) AND $_GET['v2']!="") { $page['value_id']=$_GET['v2']; }
elseif(isset($_POST['id']) AND $_POST['id']!="") { $page['value_id']=$_POST['id']; }


# case of add or edit
if(isset($_POST) AND !empty($_POST))
{
 # we format datas
 if(isset($_POST['name'])) $_POST['name']=format_txt($_POST['name']);

 # we check datas
 if(!isset($_POST['name']) OR $_POST['name']=="") { $page['erreur'][$nb_erreur]['message']=$lang['competition']['E_empty_name_competition']; $nb_erreur++; }
 else
 {
  # we check if it does not already exist
   $sgbd = sql_connect();
   $sql_verif = sql_replace($sql['competition']['verif_presence_competition'],$_POST);
   $res_verif = sql_query($sql_verif);
   $nb_res = sql_num_rows($res_verif);
   sql_free_result($res_verif);
   sql_close($sgbd);
   if($nb_res!="0") { $page['erreur'][$nb_erreur]['message']=$lang['competition']['E_exist_competition']; $nb_erreur++; }
 }
 
 if(isset($_POST['name_round']) AND !empty($_POST['name_round'])) {
  $name_erreur=0;
  $point_erreur=0;
  $group_erreur=0;
  $day_erreur=0;
  $value_round=array();
  
  # format and check round
  foreach($_POST['name_round'] as $key => $row) {
   $_POST['name_round'][$key]=format_txt($_POST['name_round'][$key]);
   $_POST['point_win_at_home'][$key]=format_txt($_POST['point_win_at_home'][$key]);
   $_POST['point_win_away'][$key]=format_txt($_POST['point_win_away'][$key]);
   $_POST['point_tie_at_home'][$key]=format_txt($_POST['point_tie_at_home'][$key]);
   $_POST['point_tie_away'][$key]=format_txt($_POST['point_tie_away'][$key]);
   $_POST['point_defeat_at_home'][$key]=format_txt($_POST['point_defeat_at_home'][$key]);
   $_POST['point_defeat_away'][$key]=format_txt($_POST['point_defeat_at_home'][$key]);   
   $_POST['group'][$key]=format_txt($_POST['group'][$key]);
   $_POST['day'][$key]=format_txt($_POST['day'][$key]);

   if($_POST['name_round'][$key]=="" AND $name_erreur==0) { 
	 $page['erreur'][$nb_erreur]['message']=$lang['competition']['E_empty_name_round']; $nb_erreur++;
	 $name_erreur=1;
   }
   
   if($_POST['standings'][$key]==1 AND (!check_integer($_POST['point_win_at_home'][$key]) OR
      !check_integer($_POST['point_win_away'][$key]) OR
	  !check_integer($_POST['point_tie_at_home'][$key]) OR
	  !check_integer($_POST['point_tie_away'][$key]) OR
	  !check_integer($_POST['point_defeat_at_home'][$key]) OR
	  !check_integer($_POST['point_defeat_away'][$key])) AND $point_erreur==0)
	{
	 $page['erreur'][$nb_erreur]['message']=$lang['competition']['E_invalid_point']; $nb_erreur++;
	 $point_erreur=1;
	}
	
	if(!empty($_POST['group'][$key]) AND !check_integer($_POST['group'][$key]) AND $group_erreur==0) { 
	 $page['erreur'][$nb_erreur]['message']=$lang['competition']['E_invalid_group']; $nb_erreur++;
	 $group_erreur=1;
	}
	
	if(!empty($_POST['day'][$key]) AND !check_integer($_POST['day'][$key]) AND $day_erreur==0) { 
	 $page['erreur'][$nb_erreur]['message']=$lang['competition']['E_invalid_day']; $nb_erreur++;
	 $day_erreur=1;
	}  
  }
 }
 
 # there is no error in submited datas
 if($nb_erreur==0)
 {
  # case : new item to add
  if(!isset($_POST['id']) OR empty($_POST['id']) AND $right_user['add_competition'])
  {
   $sql_add=sql_replace($sql['competition']['insert_competition'],$_POST);
   $sgbd = sql_connect();
   $execution=sql_query($sql_add);
   if($execution) { $page['L_message_competition']=$lang['competition']['form_competition_add_1']; }
   else { $page['L_message_competition']=$lang['competition']['form_competition_add_0']; }
   $page['value_id']=sql_insert_id($sgbd);
   
   # we add rounds
   if(isset($_POST['name_round'])) {
    foreach($_POST['name_round'] as $key => $row) {
     $value_round[]="('".$page['value_id']."','".$_POST['name_round'][$key]."','".($key+1)."','".$_POST['standings'][$key]."','".$_POST['point_win_at_home'][$key]."','".$_POST['point_win_away'][$key]."','".$_POST['point_tie_at_home'][$key]."','".$_POST['point_tie_away'][$key]."','".$_POST['point_defeat_at_home'][$key]."','".$_POST['point_defeat_away'][$key]."','".$_POST['order_team'][$key]."','".$_POST['order_team_egality'][$key]."','".$_POST['group'][$key]."','".$_POST['day'][$key]."')";
    }
	if(!empty($value_round)) {
     $var['values']=implode(",",$value_round); 
     $sql_add_round=sql_replace($sql['competition']['insert_round'],$var);
	 if($execution) sql_query($sql_add_round);
	}    
	sql_close($sgbd);
   }	
   
   # si l'add vient d'une page pop, c'est que l'on vient d'un autre formulaire.
   # on va donc renvoyer l'information au formulaire parent
   if($execution AND isset($_GET['fen']) AND $_GET['fen']=="pop")
   {
    $page['pop']="1";
	$page['nouveau_text']=$_POST['name'];
	$page['nouveau_id']=$page['value_id'];   
   }   
  }
  # case : item to modify
  elseif($right_user['edit_competition'])
  {
   $sql_modification=sql_replace($sql['competition']['edit_competition'],$_POST);
   $sgbd = sql_connect();
   $execution=sql_query($sql_modification);
   if($execution) { $page['L_message_competition']=$lang['competition']['form_competition_edit_1']; }
   else { $page['L_message_competition']=$lang['competition']['form_competition_edit_0']; }
   
   # we update rounds
   $var['round_id_list']=array();
   if(isset($_POST['name_round'])) {
    foreach($_POST['name_round'] as $key => $row) {
	 if(isset($_POST['id_round'][$key]) AND !empty($_POST['id_round'][$key])) {	
 	  $var['id']=$_POST['id_round'][$key];
	  array_push($var['round_id_list'],$_POST['id_round'][$key]);
	  $var['name']=$_POST['name_round'][$key];
	  $var['order']=($key+1);
	  $var['standings']=$_POST['standings'][$key];
	  $var['point_win_at_home']=$_POST['point_win_at_home'][$key];
	  $var['point_win_away']=$_POST['point_win_away'][$key];
	  $var['point_tie_at_home']=$_POST['point_tie_at_home'][$key];
	  $var['point_tie_away']=$_POST['point_tie_away'][$key];
	  $var['point_defeat_at_home']=$_POST['point_defeat_at_home'][$key];
	  $var['point_defeat_away']=$_POST['point_defeat_away'][$key];
	  $var['order_team']=$_POST['order_team'][$key];
	  $var['order_team_egality']=$_POST['order_team_egality'][$key];
	  $var['group']=$_POST['group'][$key];
	  $var['day']=$_POST['day'][$key];	 

      $sql_edit_round=sql_replace($sql['competition']['edit_round'],$var);
	  if($execution) sql_query($sql_edit_round);
	 }
	 else
	 {
	  $var['values']="('".$page['value_id']."','".$_POST['name_round'][$key]."','".($key+1)."','".$_POST['standings'][$key]."','".$_POST['point_win_at_home'][$key]."','".$_POST['point_win_away'][$key]."','".$_POST['point_tie_at_home'][$key]."','".$_POST['point_tie_away'][$key]."','".$_POST['point_defeat_at_home'][$key]."','".$_POST['point_defeat_away'][$key]."','".$_POST['order_team'][$key]."','".$_POST['order_team_egality'][$key]."','".$_POST['group'][$key]."','".$_POST['day'][$key]."')";
	  $sql_add_round=sql_replace($sql['competition']['insert_round'],$var);
	  if($execution) sql_query($sql_add_round);
	  $_POST['id_round'][$key]=sql_insert_id($sgbd);
	  array_push($var['round_id_list'],$_POST['id_round'][$key]);
	 } 
	}
   }
   # we delete other rounds
   $var['competition']=$_POST['id'];
   $var['round_id_list']=implode("','",$var['round_id_list']);
   $sql_delete_round=sql_replace($sql['competition']['delete_round_notin'],$var);
   sql_query($sql_delete_round);
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

# if the ID is known, we get the datas to show them in the form
if(isset($page['value_id']) AND $page['value_id']!="" AND $nb_erreur==0)
{
 # we get the item information
 $var['id']=$page['value_id'];
 $sql_details=sql_replace($sql['competition']['select_competition_details'],$var);

 $sgbd = sql_connect();
 $res = sql_query($sql_details);
 $ligne = sql_fetch_array($res);
 sql_free_result($res);
 sql_close($sgbd);

 $page['value_id']=$ligne['competition_id'];
 $page['value_name']=$ligne['competition_name'];
}

# order team by
$order_team=array(
"0"=>$lang['competition']['point'],
"1"=>$lang['competition']['nb_match'],
"2"=>$lang['competition']['nb_win'],
"3"=>$lang['competition']['nb_tie'],
"4"=>$lang['competition']['nb_defeat'],
"5"=>$lang['competition']['goal_average']);


# rounds
$page['round']=array();
$page['nb_round']="0";
if(!empty($page['value_id']))
{
 $var['competition']=$page['value_id'];
 $sql_round=sql_replace($sql['competition']['select_round_count_match'],$var);
 $sgbd = sql_connect();
 $res = sql_query($sql_round);
 $page['nb_round'] = sql_num_rows($res);
 $i="0";
 if($page['nb_round']!=0)
 {
  while($ligne = sql_fetch_array($res))
  {
   $page['round'][$i]['i']=$i;
   if($i==0) {
    $page['round'][$i]['display_round']="block"; 
	$page['round'][$i]['class']="on"; 
   }
   else {
    $page['round'][$i]['display_round']="none"; 
	$page['round'][$i]['class']=""; 
   }
   
   $page['round'][$i]['id']=$ligne['round_id'];
   $page['round'][$i]['name']=$ligne['round_name'];
   $page['round'][$i]['nb_match']=$ligne['nb_match'];
   $page['round'][$i]['order']=($i+1);
   $page['round'][$i]['standings']=$ligne['round_standings'];
   if($ligne['round_standings']==1) {
    $page['round'][$i]['display_point_system']="block"; 
    $page['round'][$i]['standings_checked_yes']="checked=\"checked\"";
    $page['round'][$i]['standings_checked_no']="";    
   } 
   else {
    $page['round'][$i]['display_point_system']="none";
    $page['round'][$i]['standings_checked_no']="checked=\"checked\"";
    $page['round'][$i]['standings_checked_yes']="";  
   }   
   $page['round'][$i]['point_win_at_home']=$ligne['point_win_at_home'];
   $page['round'][$i]['point_win_away']=$ligne['point_win_away'];
   $page['round'][$i]['point_tie_at_home']=$ligne['point_tie_at_home'];
   $page['round'][$i]['point_tie_away']=$ligne['point_tie_away'];
   $page['round'][$i]['point_defeat_at_home']=$ligne['point_defeat_at_home'];
   $page['round'][$i]['point_defeat_away']=$ligne['point_defeat_away'];      
   $page['round'][$i]['group']=$ligne['round_group'];
   $page['round'][$i]['day']=$ligne['round_day'];
   
   
   $page['round'][$i]['L_round_name']=$lang['competition']['round_name'];
   $page['round'][$i]['L_standings']=$lang['competition']['standings'];
   $page['round'][$i]['L_point_system']=$lang['competition']['point_system'];
   $page['round'][$i]['L_nb_group']=$lang['competition']['group'];
   $page['round'][$i]['L_nb_day']=$lang['competition']['day'];
   $page['round'][$i]['L_at_home']=$lang['competition']['at_home'];
   $page['round'][$i]['L_away']=$lang['competition']['away'];
   $page['round'][$i]['L_win']=$lang['competition']['win'];
   $page['round'][$i]['L_tie']=$lang['competition']['tie'];
   $page['round'][$i]['L_defeat']=$lang['competition']['defeat'];
   $page['round'][$i]['L_yes']=$lang['general']['yes'];
   $page['round'][$i]['L_no']=$lang['general']['no'];
   $page['round'][$i]['L_order_team']=$lang['competition']['order_team'];
   $page['round'][$i]['L_order_team_egality']=$lang['competition']['order_team_egality'];
   $page['round'][$i]['L_delete']=$lang['competition']['delete'];
   
   # order_team
   $page['round'][$i]['order_team']=array();
   $j="0";
   foreach($order_team as $key => $row) {
    $page['round'][$i]['order_team'][$j]['value']=$key;
    $page['round'][$i]['order_team'][$j]['name']=$row;
	$page['round'][$i]['order_team'][$j]['selected']="";
	$page['round'][$i]['order_team'][$j]['selected_egality']="";
	if($ligne['order_team']==$key) { $page['round'][$i]['order_team'][$j]['selected']="selected=\"selected\""; }
	if($ligne['order_team_egality']==$key) { $page['round'][$i]['order_team'][$j]['selected_egality']="selected=\"selected\""; }	
    $j++;
   }
	
   $i++;
  }
 } 
 sql_free_result($res);
 sql_close($sgbd);
}

# liste des round envoyes via le formulaire
if(isset($_POST['name_round']))
{
 $page['round']=array();
 $tab=array_keys($_POST['name_round']); 
 $i="0";
 foreach($tab as $key => $value)
 {
   $page['round'][$i]['i']=$i;
   if($i==0) {
    $page['round'][$i]['display_round']="block"; 
	$page['round'][$i]['class']="on"; 
   }
   else {
    $page['round'][$i]['display_round']="none"; 
	$page['round'][$i]['class']=""; 
   }
   
  $page['round'][$i]['id']=$_POST['id_round'][$value];
  $page['round'][$i]['name']=$_POST['name_round'][$value];
  $page['round'][$i]['nb_match']=$_POST['nb_match'][$value];
  $page['round'][$i]['order']=($i+1);
  if($_POST['standings'][$value]==1) {
   $page['round'][$i]['display_point_system']="block"; 
   $page['round'][$i]['standings_checked_yes']="checked=\"checked\"";
   $page['round'][$i]['standings_checked_no']="";    
  } 
  else {
   $page['round'][$i]['display_point_system']="none";
   $page['round'][$i]['standings_checked_no']="checked=\"checked\"";
   $page['round'][$i]['standings_checked_yes']="";  
  } 
  $page['round'][$i]['point_win_at_home']=$_POST['point_win_at_home'][$value];
  $page['round'][$i]['point_win_away']=$_POST['point_win_away'][$value];
  $page['round'][$i]['point_tie_at_home']=$_POST['point_tie_at_home'][$value];
  $page['round'][$i]['point_tie_away']=$_POST['point_tie_away'][$value];
  $page['round'][$i]['point_defeat_at_home']=$_POST['point_defeat_at_home'][$value];
  $page['round'][$i]['point_defeat_away']=$_POST['point_defeat_away'][$value];
  $page['round'][$i]['group']=$_POST['group'][$value];
  $page['round'][$i]['day']=$_POST['day'][$value];

   $page['round'][$i]['L_round_name']=$lang['competition']['round_name'];
   $page['round'][$i]['L_standings']=$lang['competition']['standings'];
   $page['round'][$i]['L_point_system']=$lang['competition']['point_system'];
   $page['round'][$i]['L_nb_group']=$lang['competition']['nb_group'];
   $page['round'][$i]['L_nb_day']=$lang['competition']['nb_day'];
   $page['round'][$i]['L_at_home']=$lang['competition']['at_home'];
   $page['round'][$i]['L_away']=$lang['competition']['away'];
   $page['round'][$i]['L_win']=$lang['competition']['win'];
   $page['round'][$i]['L_tie']=$lang['competition']['tie'];
   $page['round'][$i]['L_defeat']=$lang['competition']['defeat'];
   $page['round'][$i]['L_yes']=$lang['general']['yes'];
   $page['round'][$i]['L_no']=$lang['general']['no'];
   $page['round'][$i]['L_order_team']=$lang['competition']['order_team'];
   $page['round'][$i]['L_order_team_egality']=$lang['competition']['order_team_egality'];
   $page['round'][$i]['L_delete']=$lang['competition']['delete']; 
   
   # order_team
   $page['round'][$i]['order_team']=array();
   $j="0";
   foreach($order_team as $key => $row) {
    $page['round'][$i]['order_team'][$j]['value']=$key;
    $page['round'][$i]['order_team'][$j]['name']=$row;
	$page['round'][$i]['order_team'][$j]['selected']="";
	$page['round'][$i]['order_team'][$j]['selected_egality']="";
	if($_POST['order_team'][$value]==$key) { $page['round'][$i]['order_team'][$j]['selected']="selected=\"selected\""; }
	if($_POST['order_team_egality'][$value]==$key) { $page['round'][$i]['order_team'][$j]['selected_egality']="selected=\"selected\""; }	
    $j++;
   }   
   $i++;
 }
$page['nb_round']=$i;
}

# order_team 
$page['order_team']=array();
$j="0";
foreach($order_team as $key => $row) {
 $page['order_team'][$j]['value']=$key;
 $page['order_team'][$j]['name']=$row;
 $j++;
}

# links
if($right_user['delete_competition'] AND !empty($page['value_id']))
{
 $page['link_delete']=convert_url("index.php?r=".$lang['general']['idurl_competition']."&v1=competition_list&v2=delete&v3=".$page['value_id']);
}
else
{
 $page['link_delete']="";
}
$page['link_list']=convert_url("index.php?r=".$lang['general']['idurl_competition']."&v1=competition_list");

# text
if(empty($page['value_id'])) { $page['L_title']=$lang['competition']['form_competition_add']; }
else { $page['L_title']=$lang['competition']['form_competition_edit']; }
$page['L_submit']=$lang['competition']['submit'];
$page['L_delete']=$lang['competition']['delete'];
$page['L_back_list']=$lang['competition']['back_list']; 
$page['L_erreur']=$lang['general']['E_erreur'];
$page['L_field_required']=$lang['general']['field_required'];

$page['L_name']=$lang['competition']['name'];
$page['L_standings']=$lang['competition']['standings'];
$page['L_point_system']=$lang['competition']['point_system'];
$page['L_nb_group']=$lang['competition']['nb_group'];
$page['L_nb_day']=$lang['competition']['nb_day'];
$page['L_at_home']=$lang['competition']['at_home'];
$page['L_away']=$lang['competition']['away'];
$page['L_win']=$lang['competition']['win'];
$page['L_tie']=$lang['competition']['tie'];
$page['L_defeat']=$lang['competition']['defeat'];

$page['L_cant_delete_round']=$lang['competition']['E_cant_delete_round'];

$page['L_yes']=$lang['general']['yes'];
$page['L_no']=$lang['general']['no'];

$page['L_order_team']=$lang['competition']['order_team'];
$page['L_order_team_egality']=$lang['competition']['order_team_egality'];

$page['L_round_name']=$lang['competition']['round_name'];
$page['L_add_round']=$lang['competition']['add_round'];

$page['L_delete']=$lang['competition']['delete'];

$page['meta_title']=$page['L_title'];
$page['template']=$tpl['competition']['form_competition'];
?>