<?php
##################################
# period 
##################################

# variables
$page['L_message']="";
$page['form_action']=convert_url("index.php?r=".$lang['general']['idurl_match']."&v1=period_list");
$nb_erreur="0";
$page['erreur']=array();
$page['period']=array();

# form values
$page['value_id']="";
$page['value_name']="";
$page['value_ordre']="";
$page['value_duration']="";
$page['value_required']="";
$page['choix_yes']="";
$page['choix_no']=""; 


# modification de l'ordre
if($right_user['period_list'] AND isset($_GET['v2']) AND $_GET['v2']=="order" AND isset($_GET['v3']) AND isset($_GET['v4']) AND !empty($_GET['v4']) AND (!isset($included) OR $included==0))
{
 $var['mode']=$_GET['v2'];
 $var['action']=$_GET['v3'];
 $var['id']=$_GET['v4'];

 /* on selectionne l'ordre correspondant à l'identifiant */
 $sql_ordre=sql_replace($sql['match']['select_period_details'],$var);
 $sgbd = sql_connect();
 $res = sql_query($sql_ordre);

 if($res!=false)
 {
  $result = sql_fetch_array($res);
  $var['ordre']=$result['period_order'];

  sql_free_result($res);

  /* on selectionne l'ordre le plus grand et le plus petit */
  $sql_max=$sql['match']['select_period_order'];
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
    $sql_ordre_nouveau=sql_replace($sql['match']['edit_period_order'],$var);

    sql_query($sql_ordre_nouveau);
    $sql_ordre=sql_replace($sql['match']['edit_period_order_id'],$var);
    sql_query($sql_ordre);
   }
  sql_close($sgbd);
 }
 header("location:".$page['form_action']);
 exit;
}

# cas d'une suppression 
if($right_user['period_list'] AND isset($_GET['v2']) AND isset($_GET['v3']) AND $_GET['v3']=="delete" AND (!isset($included) OR $included==0))
{
 $var['id']=$_GET['v2'];
 $sql_verif=sql_replace($sql['match']['verif_period'],$var);
 $sql_sup=sql_replace($sql['match']['sup_period'],$var);
 $sgbd = sql_connect();
 
 # verification
 if(sql_num_rows(sql_query($sql_verif))!="0") { $page['erreur'][$nb_erreur]['message']=$lang['match']['E_exist_period_match']; $nb_erreur++; }
 
 if($nb_erreur==0)
 {
  if(sql_query($sql_sup) != false) { $page['L_message']=$lang['match']['form_period_sup_1'];  }
  else { $page['L_message']=$lang['match']['form_period_sup_0']; }
 }
 else { $page['L_message']=$lang['match']['form_period_sup_0']; }
 sql_close($sgbd);
}

# case of add or edit
if(isset($_POST) AND !empty($_POST) AND (!isset($included) OR $included==0) AND $right_user['period_list'])
{
 # we format datas
 if(isset($_POST['name'])) $_POST['name']=format_txt($_POST['name']);

 # we check datas
 if(!isset($_POST['name']) OR empty($_POST['name'])) { $page['erreur'][$nb_erreur]['message']=$lang['match']['E_empty_period_name']; $nb_erreur++; }
 else
 {
  # we check if it does not already exist
   $sgbd = sql_connect();
   $sql_verif = sql_replace($sql['match']['verif_presence_period'],$_POST);
   $res_verif = sql_query($sql_verif);
   $nb_res = sql_num_rows($res_verif);
   sql_free_result($res_verif);
   sql_close($sgbd);
   if($nb_res!="0") { $page['erreur'][$nb_erreur]['message']=$lang['match']['E_exist_period']; $nb_erreur++; }
 }

 # there is no error in submited datas
 if($nb_erreur==0)
 {
  # case : new item to add
  if(!isset($_POST['id']) OR empty($_POST['id']))
  {
   # on recupere l'ordre max
   $sql_ordre_max=$sql['match']['select_period_order'];
   $sgbd = sql_connect();
   $res_ordre_max=sql_query($sql_ordre_max);
   $ligne_ordre_max=sql_fetch_array($res_ordre_max);
   $_POST['ordre']=$ligne_ordre_max['max']+1;
      
   $sql_add=sql_replace($sql['match']['insert_period'],$_POST);

   if(sql_query($sql_add) != false) { $page['L_message']=$lang['match']['form_period_add_1']; }
   else { $page['L_message']=$lang['match']['form_period_add_0']; }
   sql_close($sgbd);
  }
  # case : item to modify
  else
  {
   $sql_modification=sql_replace($sql['match']['edit_period'],$_POST);
   $sgbd = sql_connect();
   if(sql_query($sql_modification) != false) { $page['L_message']=$lang['match']['form_period_edit_1']; }
   else { $page['L_message']=$lang['match']['form_period_edit_0']; }
   sql_close($sgbd);
  }
 }
 else
 {
  # there is some errors: we show the datas again
  if(isset($_POST['id'])) $page['value_id']=$_POST['id'];
  if(isset($_POST['name'])) $page['value_name']=$_POST['name'];
  if(isset($_POST['ordre'])) $page['value_ordre']=$_POST['ordre'];
  if(isset($_POST['duration'])) $page['value_duration']=$_POST['duration'];
  if(isset($_POST['required'])) $page['value_required']=$_POST['required'];
 }
}


if($page['value_required']==1) { $page['choix_yes']="checked"; }
else  { $page['choix_no']="checked"; }

# listes des period
$sql_liste=$sql['match']['select_period'];
$sgbd = sql_connect();
$res_liste = sql_query($sql_liste);
$nb_ligne = sql_num_rows($res_liste);
$i="0";
while($ligne = sql_fetch_array($res_liste))
{
 $page['period'][$i]['id']=$ligne['period_id'];
 $page['period'][$i]['name']=$ligne['period_name'];
 $page['period'][$i]['duration']=$ligne['period_length'];
 $page['period'][$i]['choix_yes']="";
 $page['period'][$i]['choix_no']="";
 if($ligne['period_required']==1) { $page['period'][$i]['choix_yes']="checked"; }
 else { $page['period'][$i]['choix_no']="checked"; };
 
 if(isset($var['value_period']) AND $var['value_period']==$ligne['period_id']) { $page['period'][$i]['selected']="selected"; } else { $page['period'][$i]['selected']=""; } 
 
 $page['period'][$i]['form_action']=$page['form_action'];
 $page['period'][$i]['link_modification']=convert_url("index.php?r=".$lang['general']['idurl_match']."&v1=form_period&v2=".$ligne['period_id']);
  $page['period'][$i]['link_suppression']=convert_url("index.php?r=".$lang['general']['idurl_match']."&v1=period_list&v2=".$ligne['period_id']."&v3=delete");
  $page['period'][$i]['L_edit']=$lang['match']['edit'];
  $page['period'][$i]['L_delete']=$lang['match']['delete'];
  $page['period'][$i]['L_yes']=$lang['match']['yes'];
  $page['period'][$i]['L_no']=$lang['match']['no'];
  
  # ordre
  $page['period'][$i]['L_up']=$lang['match']['up'];
  $page['period'][$i]['L_down']=$lang['match']['down'];
  $page['period'][$i]['link_up']="";
  $page['period'][$i]['link_down']="";

  if($i=="0")
  {
   $page['period'][$i]['link_down']=convert_url("index.php?r=".$lang['general']['idurl_match']."&v1=period_list&v2=order&v3=down&v4=".$ligne['period_id']);
  }
  elseif($i==$nb_ligne-1)
  {
   $page['period'][$i]['link_up']=convert_url("index.php?r=".$lang['general']['idurl_match']."&v1=period_list&v2=order&v3=up&v4=".$ligne['period_id']);  
  }
  else
  {
   $page['period'][$i]['link_up']=convert_url("index.php?r=".$lang['general']['idurl_match']."&v1=period_list&v2=order&v3=up&v4=".$ligne['period_id']);
   $page['period'][$i]['link_down']=convert_url("index.php?r=".$lang['general']['idurl_match']."&v1=period_list&v2=order&v3=down&v4=".$ligne['period_id']);
  }  
  
 $i++;
}
sql_free_result($res_liste);
sql_close($sgbd);


# text
$page['L_title']=$lang['match']['period_list'];
$page['L_liste']=$lang['match']['period_list'];
$page['L_name']=$lang['match']['name'];
$page['L_duration']=$lang['match']['duration'];
$page['L_format_duration']=$lang['match']['format_duration'];
$page['L_required']=$lang['match']['required'];
$page['L_yes']=$lang['match']['yes'];
$page['L_no']=$lang['match']['no'];
$page['L_add']=$lang['match']['add_period'];
$page['L_valider']=$lang['match']['submit'];
$page['L_erreur']=$lang['general']['E_erreur'];
$page['L_field_required']=$lang['general']['field_required'];

$page['meta_title']=$lang['match']['period_list'];
$page['template']=$tpl['match']['period_list'];
?>