<?php
##################################
# stats_player 
##################################

# variables
$page['L_message']="";
$page['form_action']=convert_url("index.php?r=".$lang['general']['idurl_match']."&v1=stats_player_list");
$nb_erreur="0";
$page['erreur']=array();
$page['stats_player']=array();

# form values
$page['value_id']="";
$page['value_name']="";
$page['value_ordre']="";
$page['value_abbreviation']="";
$page['value_code']="";
$page['value_formula']="";


# modification de l'ordre
if($right_user['stats_player_list'] AND isset($_GET['v2']) AND $_GET['v2']=="order" AND isset($_GET['v3']) AND isset($_GET['v4']) AND !empty($_GET['v4']) AND (!isset($included) OR $included==0))
{
 $var['mode']=$_GET['v2'];
 $var['action']=$_GET['v3'];
 $var['id']=$_GET['v4'];

 /* on selectionne l'ordre correspondant à l'identifiant */
 $sql_ordre=sql_replace($sql['match']['select_stats_player_details'],$var);
 $sgbd = sql_connect();
 $res = sql_query($sql_ordre);

 if($res!=false)
 {
  $result = sql_fetch_array($res);
  $var['ordre']=$result['stats_player_order'];

  sql_free_result($res);

  /* on selectionne l'ordre le plus grand et le plus petit */
  $sql_max=$sql['match']['select_stats_player_order'];
  $res=sql_query($sql_max);
  $ordre=sql_fetch_array($res);
  sql_free_result($res);
  $max=$ordre['max'];
  $min=$ordre['min'];

   /* on verifie que l'on peut bien ordonner */
   $ordonner="";
   if($var['action']=="up" AND $var['ordre']!=$min)
   {
    $ordonner="ok";
    $var['ordre_nouveau']=$var['ordre'] - 1;
   }
   elseif($var['action']=="down" AND $var['ordre']!=$max)
   {
    $ordonner="ok";
    $var['ordre_nouveau']=$var['ordre'] + 1;
   }

   if($ordonner=="ok") /* on echange la ligne courrante avec la ligne ayant le meme ordre */
   {
    $sql_ordre_nouveau=sql_replace($sql['match']['edit_stats_player_order'],$var);

    sql_query($sql_ordre_nouveau);
    $sql_ordre=sql_replace($sql['match']['edit_stats_player_order_id'],$var);
    sql_query($sql_ordre);
   }
  sql_close($sgbd);
 }
 header("location:".$page['form_action']);
 exit;
}

# cas d'une suppression 
if($right_user['stats_player_list'] AND isset($_GET['v2']) AND isset($_GET['v3']) AND $_GET['v3']=="delete" AND (!isset($included) OR $included==0))
{
 $var['id']=$_GET['v2'];
 $sql_verif=sql_replace($sql['match']['verif_stats_player'],$var);
 $sql_sup=sql_replace($sql['match']['sup_stats_player'],$var);
 $sgbd = sql_connect();
 
 # verification
 if(sql_num_rows(sql_query($sql_verif))!="0") { $page['erreur'][$nb_erreur]['message']=$lang['match']['E_exist_stats_player_match']; $nb_erreur++; }
 
 if($nb_erreur==0)
 {
  if(sql_query($sql_sup) != false) { $page['L_message']=$lang['match']['form_stats_player_sup_1'];  }
  else { $page['L_message']=$lang['match']['form_stats_player_sup_0']; }
 }
 else { $page['L_message']=$lang['match']['form_stats_player_sup_0']; }
 sql_close($sgbd);
}

# case of add or edit
if($right_user['stats_player_list'] AND isset($_POST) AND !empty($_POST) AND (!isset($included) OR $included==0))
{
 # we format datas
 if(isset($_POST['name'])) $_POST['name']=format_txt($_POST['name']);
 if(isset($_POST['abbreviation'])) $_POST['abbreviation']=format_txt($_POST['abbreviation']);
 if(isset($_POST['code'])) $_POST['code']=format_txt($_POST['code']);
 if(isset($_POST['formula'])) $_POST['formula']=trim($_POST['formula']);

 # we check datas
 if(!isset($_POST['name']) OR empty($_POST['name'])) { $page['erreur'][$nb_erreur]['message']=$lang['match']['E_empty_stats_player_name']; $nb_erreur++; }
 else
 {
  # we check if it does not already exist
   $sgbd = sql_connect();
   $sql_verif = sql_replace($sql['match']['verif_presence_stats_player'],$_POST);
   $res_verif = sql_query($sql_verif);
   $nb_res = sql_num_rows($res_verif);
   sql_free_result($res_verif);
   sql_close($sgbd);
   if($nb_res!="0") { $page['erreur'][$nb_erreur]['message']=$lang['match']['E_exist_stats_player']; $nb_erreur++; }
 }
 
 if(!isset($_POST['abbreviation']) OR empty($_POST['abbreviation'])) { $page['erreur'][$nb_erreur]['message']=$lang['match']['E_empty_stats_player_abbreviation']; $nb_erreur++; } 
 if(!isset($_POST['code']) OR empty($_POST['code'])) { $page['erreur'][$nb_erreur]['message']=$lang['match']['E_empty_stats_player_code']; $nb_erreur++; } 
 if(isset($_POST['formula']) AND !check_formula($_POST['formula'])) { $page['erreur'][$nb_erreur]['message']=$lang['match']['E_invalid_stats_player_formula']; $nb_erreur++; } 


 # there is no error in submited datas
 if($nb_erreur==0)
 {
  # case : new item to add
  if(!isset($_POST['id']) OR empty($_POST['id']))
  {
   # on recupere l'ordre max
   $sql_ordre_max=$sql['match']['select_stats_player_order'];
   $sgbd = sql_connect();
   $res_ordre_max=sql_query($sql_ordre_max);
   $ligne_ordre_max=sql_fetch_array($res_ordre_max);
   $_POST['ordre']=$ligne_ordre_max['max']+1;
      
   $sql_add=sql_replace($sql['match']['insert_stats_player'],$_POST);

   if(sql_query($sql_add) != false) { $page['L_message']=$lang['match']['form_stats_player_add_1']; }
   else { $page['L_message']=$lang['match']['form_stats_player_add_0']; }
   sql_close($sgbd);
  }
  # case : item to modify
  else
  {
   $sql_modification=sql_replace($sql['match']['edit_stats_player'],$_POST);
   $sgbd = sql_connect();
   if(sql_query($sql_modification) != false) { $page['L_message']=$lang['match']['form_stats_player_edit_1']; }
   else { $page['L_message']=$lang['match']['form_stats_player_edit_0']; }
   sql_close($sgbd);
  }
 }
 else
 {
  # there is some errors: we show the datas again
  if(isset($_POST['id'])) $page['value_id']=$_POST['id'];
  if(isset($_POST['name'])) $page['value_name']=$_POST['name'];
  if(isset($_POST['ordre'])) $page['value_ordre']=$_POST['ordre'];
  if(isset($_POST['code'])) $page['value_code']=$_POST['code'];
  if(isset($_POST['abbreviation'])) $page['value_abbreviation']=$_POST['abbreviation'];
  if(isset($_POST['formula'])) $page['value_formula']=$_POST['formula'];
 }
}


if($page['value_formula']==1) { $page['choix_yes']="checked"; }
else  { $page['choix_no']="checked"; }

# listes des stats_player
$sql_liste=$sql['match']['select_stats_player'];
$sgbd = sql_connect();
$res_liste = sql_query($sql_liste);
$nb_ligne = sql_num_rows($res_liste);
$i="0";
while($ligne = sql_fetch_array($res_liste))
{
 $page['stats_player'][$i]['id']=$ligne['stats_player_id'];
 $page['stats_player'][$i]['name']=$ligne['stats_player_name']; 
 $page['stats_player'][$i]['abbreviation']=$ligne['stats_player_abbreviation'];
 $page['stats_player'][$i]['code']=$ligne['stats_player_code'];
 $page['stats_player'][$i]['formula']=$ligne['stats_player_formula'];
 
 if(isset($var['value_stats_player']) AND $var['value_stats_player']==$ligne['stats_player_id']) { $page['stats_player'][$i]['selected']="selected"; } else { $page['stats_player'][$i]['selected']=""; } 
 
 $page['stats_player'][$i]['form_action']=$page['form_action'];
 $page['stats_player'][$i]['link_modification']=convert_url("index.php?r=".$lang['general']['idurl_match']."&v1=form_stats_player&v2=".$ligne['stats_player_id']);
  $page['stats_player'][$i]['link_suppression']=convert_url("index.php?r=".$lang['general']['idurl_match']."&v1=stats_player_list&v2=".$ligne['stats_player_id']."&v3=delete");
  $page['stats_player'][$i]['L_edit']=$lang['match']['edit'];
  $page['stats_player'][$i]['L_delete']=$lang['match']['delete'];
  
  # ordre
  $page['stats_player'][$i]['L_up']=$lang['match']['up'];
  $page['stats_player'][$i]['L_down']=$lang['match']['down'];
  $page['stats_player'][$i]['link_up']="";
  $page['stats_player'][$i]['link_down']="";

  if($i=="0")
  {
   $page['stats_player'][$i]['link_down']=convert_url("index.php?r=".$lang['general']['idurl_match']."&v1=stats_player_list&v2=order&v3=down&v4=".$ligne['stats_player_id']);
  }
  elseif($i==$nb_ligne-1)
  {
   $page['stats_player'][$i]['link_up']=convert_url("index.php?r=".$lang['general']['idurl_match']."&v1=stats_player_list&v2=order&v3=up&v4=".$ligne['stats_player_id']);  
  }
  else
  {
   $page['stats_player'][$i]['link_up']=convert_url("index.php?r=".$lang['general']['idurl_match']."&v1=stats_player_list&v2=order&v3=up&v4=".$ligne['stats_player_id']);
   $page['stats_player'][$i]['link_down']=convert_url("index.php?r=".$lang['general']['idurl_match']."&v1=stats_player_list&v2=order&v3=down&v4=".$ligne['stats_player_id']);
  }  
  
 $i++;
}
sql_free_result($res_liste);
sql_close($sgbd);


$page['L_title']=$lang['match']['stats_player_list'];
$page['L_liste']=$lang['match']['stats_player_list'];
$page['L_name']=$lang['match']['name'];
$page['L_abbreviation']=$lang['match']['abbreviation'];
$page['L_code']=$lang['match']['code'];
$page['L_type']=$lang['match']['type'];
$page['L_value']=$lang['match']['value'];
$page['L_formula']=$lang['match']['formula'];
$page['L_explication_formula']=$lang['match']['explication_formula_player'];
$page['L_add']=$lang['match']['add_stats_player'];
$page['L_submit']=$lang['match']['submit'];
$page['L_erreur']=$lang['general']['E_erreur'];
$page['L_field_required']=$lang['general']['field_required'];

$page['meta_title']=$lang['match']['stats_player_list'];
$page['template']=$tpl['match']['stats_player_list'];
?>