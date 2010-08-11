<?php
##################################
# team_name 
##################################

# variables
$page['L_message']="";
$page['form_action']=convert_url("index.php?r=".$lang['general']['idurl_team']."&v1=team_name_list");
$nb_erreur="0";
$page['erreur']=array();
$page['team_name']=array();
$page['pop']="";

# form values
$page['value_id']="";
$page['value_name']="";
$page['value_ordre']="";

# modification de l'ordre
if($right_user['team_name_list'] AND isset($_GET['v2']) AND $_GET['v2']=="order" AND isset($_GET['v3']) AND isset($_GET['v4']) AND !empty($_GET['v4']) AND (!isset($included) OR $included==0))
{
 $var['mode']=$_GET['v2'];
 $var['action']=$_GET['v3'];
 $var['id']=$_GET['v4'];
 /* on selectionne l'ordre correspondant à l'identifiant */
 $sql_ordre=sql_replace($sql['team']['select_team_name_details'],$var);
 $sgbd = sql_connect();
 $res = sql_query($sql_ordre);

 if($res!=false)
 {
  $result = sql_fetch_array($res);
  $var['ordre']=$result['team_name_order'];

  sql_free_result($res);

  /* on selectionne l'ordre le plus grand et le plus petit */
  $sql_max=$sql['team']['select_team_name_order'];
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
    $sql_ordre_nouveau=sql_replace($sql['team']['edit_team_name_order'],$var);

    sql_query($sql_ordre_nouveau);
    $sql_ordre=sql_replace($sql['team']['edit_team_name_order_id'],$var);
    sql_query($sql_ordre);
   }
  sql_close($sgbd);
 }
 header("location:".$page['form_action']);
 exit;
}

# cas d'une suppression 
if($right_user['team_name_list'] AND isset($_GET['v2']) AND isset($_GET['v3']) AND $_GET['v3']=="delete" AND (!isset($included) OR $included==0))
{
 $var['id']=$_GET['v2'];
 $sql_verif=sql_replace($sql['team']['verif_team_name'],$var);
 $sql_sup=sql_replace($sql['team']['sup_team_name'],$var);
 $sgbd = sql_connect();
 
 # verification
 if(sql_num_rows(sql_query($sql_verif))!="0") { $page['erreur'][$nb_erreur]['message']=$lang['team']['E_exist_team_name_team']; $nb_erreur++; }
 
 if($nb_erreur==0)
 {
  if(sql_query($sql_sup) != false) { $page['L_message']=$lang['team']['form_team_name_sup_1'];  }
  else { $page['L_message']=$lang['team']['form_team_name_sup_0']; }
 }
 else { $page['L_message']=$lang['team']['form_team_name_sup_0']; }
 sql_close($sgbd);
}

# case of add or edit
if($right_user['team_name_list'] AND isset($_POST) AND !empty($_POST) AND (!isset($included) OR $included==0))
{
 # we format datas
 if(isset($_POST['name'])) $_POST['name']=format_txt($_POST['name']);

 # we check datas
 if(!isset($_POST['name']) OR $_POST['name']=="") { $page['erreur'][$nb_erreur]['message']=$lang['team']['E_empty_name_team_name']; $nb_erreur++; }
 else
 {
  # we check if it does not already exist
   $sgbd = sql_connect();
   $sql_verif = sql_replace($sql['team']['verif_presence_team_name'],$_POST);
   $res_verif = sql_query($sql_verif);
   $nb_res = sql_num_rows($res_verif);
   sql_free_result($res_verif);
   sql_close($sgbd);
   if($nb_res!="0") { $page['erreur'][$nb_erreur]['message']=$lang['team']['E_exist_team_name']; $nb_erreur++; }
 }

 # there is no error in submited datas
 if($nb_erreur==0)
 {
  # case : new item to add
  if(!isset($_POST['id']) OR empty($_POST['id']))
  {
   # on recupere l'ordre max
   $sql_ordre_max=$sql['team']['select_team_name_order'];
   $sgbd = sql_connect();
   $res_ordre_max=sql_query($sql_ordre_max);
   $ligne_ordre_max=sql_fetch_array($res_ordre_max);
   $_POST['ordre']=$ligne_ordre_max['max']+1;
  
   $sql_add=sql_replace($sql['team']['insert_team_name'],$_POST);
   $sgbd = sql_connect();
   $execution=sql_query($sql_add);
   if($execution) { $page['L_message']=$lang['team']['form_team_name_add_1']; }
   else { $page['L_message']=$lang['team']['form_team_name_add_0']; }
   $page['value_id']=sql_insert_id($sgbd);
   sql_close($sgbd);
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
  else
  {
   $sql_modification=sql_replace($sql['team']['edit_team_name'],$_POST);
   $sgbd = sql_connect();
   if(sql_query($sql_modification) != false) { $page['L_message']=$lang['team']['form_team_name_edit_1']; }
   else { $page['L_message']=$lang['team']['form_team_name_edit_0']; }
   sql_close($sgbd);
  }
 }
 else
 {
  # there is some errors: we show the datas again
  if(isset($_POST['id'])) $page['value_id']=$_POST['id'];
  if(isset($_POST['name'])) $page['value_name']=$_POST['name'];
  if(isset($_POST['ordre'])) $page['value_ordre']=$_POST['ordre'];
 }
}


# listes des team_name
$sql_liste=$sql['team']['select_team_name'];
$sgbd = sql_connect();
$res_liste = sql_query($sql_liste);
$nb_ligne = sql_num_rows($res_liste);
$i="0";
while($ligne = sql_fetch_array($res_liste))
{
 $page['team_name'][$i]['id']=$ligne['team_name_id'];
 $page['team_name'][$i]['name']=$ligne['team_name_name'];
 
 $page['team_name'][$i]['form_action']=$page['form_action'];
 $page['team_name'][$i]['link_modification']=convert_url("index.php?r=".$lang['general']['idurl_team']."&v1=form_team_name&v2=".$ligne['team_name_id']);
  $page['team_name'][$i]['link_suppression']=convert_url("index.php?r=".$lang['general']['idurl_team']."&v1=team_name_list&v2=".$ligne['team_name_id']."&v3=delete");
  $page['team_name'][$i]['L_edit']=$lang['team']['edit'];
  $page['team_name'][$i]['L_delete']=$lang['team']['delete'];
  
  # ordre
  $page['team_name'][$i]['L_up']=$lang['team']['up'];
  $page['team_name'][$i]['L_down']=$lang['team']['down'];
  $page['team_name'][$i]['link_up']="";
  $page['team_name'][$i]['link_down']="";

  if($i=="0")
  {
   $page['team_name'][$i]['link_down']=convert_url("index.php?r=".$lang['general']['idurl_team']."&v1=team_name_list&v2=order&v3=down&v4=".$ligne['team_name_id']);
  }
  elseif($i==$nb_ligne-1)
  {
   $page['team_name'][$i]['link_up']=convert_url("index.php?r=".$lang['general']['idurl_team']."&v1=team_name_list&v2=order&v3=up&v4=".$ligne['team_name_id']);  
  }
  else
  {  
   $page['team_name'][$i]['link_up']=convert_url("index.php?r=".$lang['general']['idurl_team']."&v1=team_name_list&v2=order&v3=up&v4=".$ligne['team_name_id']);
   $page['team_name'][$i]['link_down']=convert_url("index.php?r=".$lang['general']['idurl_team']."&v1=team_name_list&v2=order&v3=down&v4=".$ligne['team_name_id']);
  }  
    
 $i++;
}
sql_free_result($res_liste);
sql_close($sgbd);


$page['L_title']=$lang['team']['team_name_list'];
$page['L_liste']=$lang['team']['team_name_list'];
$page['L_add']=$lang['team']['add_team_name'];
$page['L_valider']=$lang['team']['submit'];
$page['L_erreur']=$lang['general']['E_erreur'];
$page['L_field_required']=$lang['general']['field_required'];

$page['meta_title']=$lang['team']['team_name_list'];
$page['template']=$tpl['team']['team_name_list'];
?>