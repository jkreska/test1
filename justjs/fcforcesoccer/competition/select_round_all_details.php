<?php
if(!isset($var['header']) OR $var['header']!=0) {
 header('Content-type: text/html; charset='.$lang['general']['charset']); 
}

$page['show_group']="";
$page['show_day']="";

$var['group']=array();
$var['day']="";

if(!isset($page['value_competition'])) $page['value_competition']="";
if(!isset($page['value_round'])) $page['value_round']="";
if(!isset($page['value_group'])) $page['value_group']=array();
if(!isset($page['value_day'])) $page['value_day']="";
if(!isset($page['value_season'])) $page['value_season']="";

if(isset($_POST['competition']) AND !empty($_POST['competition'])) { $page['value_competition']=$_POST['competition']; }
if(isset($_POST['round']) AND !empty($_POST['round'])) { $page['value_round']=$_POST['round']; }
if(isset($_POST['group']) AND !empty($_POST['group'])) { $page['value_group']=$_POST['group']; }
if(isset($_POST['day']) AND !empty($_POST['day'])) { $page['value_day']=$_POST['day']; }
if(isset($_POST['season']) AND !empty($_POST['season'])) { $page['value_season']=$_POST['season']; }

if(!empty($page['value_group']) AND !is_array($page['value_group'])) { $page['value_group']=array($page['value_group']); }
if($page['value_group']=="all") $page['value_group']=array();
if($page['value_day']=="all") $page['value_day']="";

$var['id']=$page['value_round'];
$sql_round=sql_replace($sql['competition']['select_round_details'],$var);
$sgbd = sql_connect();
$res_round = sql_query($sql_round);
$nb_ligne=sql_num_rows($res_round);
if($nb_ligne!="0")
{
 $ligne = sql_fetch_array($res_round);
 if($ligne['round_group']!=0) { $page['show_group']="1"; }
 if($ligne['round_day']!=0) { $page['show_day']="1"; }
}  


# group
$page['group']=array();
$j="A";
if(isset($ligne['round_group']) AND !empty($ligne['round_group'])) {
 for($i=0; $i < $ligne['round_group']; $i++) {
  $page['group'][$i]['name']=$j;
  $page['group'][$i]['selected']="";
  $page['group'][$i]['checked']="";
  if(!empty($page['value_group']) AND in_array($j,$page['value_group'])) {
   $page['group'][$i]['selected']="selected";
   $page['group'][$i]['checked']="checked";
  }
  $j++;
 }
}
# day
$page['day']=array();
if(isset($ligne['round_day']) AND !empty($ligne['round_day'])) {
 for($i=0; $i < $ligne['round_day']; $i++) {
  $page['day'][$i]['name']=$i+1;
  $page['day'][$i]['selected']="";
  $page['day'][$i]['checked']="";
  if($page['value_day']==($i+1)) {
   $page['day'][$i]['selected']="selected";
   $page['day'][$i]['checked']="checked";
  }
 } 
}

$page['L_group']=$lang['competition']['group'];
$page['L_day']=$lang['competition']['day'];
if(!isset($var['header']) OR $var['header']!=0) {
 $page['fen']="ajax";
 $page['template']=$tpl['competition']['select_round_all_details'];
}

?>