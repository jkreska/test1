<?php
if(!isset($var['header']) OR $var['header']!=0) {
 header('Content-type: text/html; charset='.$lang['general']['charset']); 
}

$page['show_standings']="";
$page['show_group']="";
$page['show_day']="";

if(!isset($var['group'])) $var['group']="";
if(!isset($var['day'])) $var['day']="";
if(isset($_POST['competition'])) $var['competition']=$_POST['competition'];
if(isset($_POST['round'])) $var['id']=$_POST['round'];

$sql_round=sql_replace($sql['competition']['select_round_details'],$var);
$sgbd = sql_connect();
$res_round = sql_query($sql_round);
$nb_ligne=sql_num_rows($res_round);

if($nb_ligne!="0")
{
 $ligne = sql_fetch_array($res_round);
 if($ligne['round_standings']!=0) { $page['show_standings']="1"; }
 if($ligne['round_group']!=0) { $page['show_group']="1"; }
 if($ligne['round_day']!=0) { $page['show_day']="1"; }
}  

# group
$page['group']=array();
$j="A";
for($i=0; $i < $ligne['round_group']; $i++) {
 $page['group'][$i]['name']=$j;
 $page['group'][$i]['selected']="";
 $page['group'][$i]['checked']="";
 if($var['group']==$j) {
  $page['group'][$i]['selected']="selected";
  $page['group'][$i]['checked']="checked";
 }
 $j++;
}

# day
$page['day']=array();
for($i=0; $i < $ligne['round_day']; $i++) {
 $page['day'][$i]['name']=$i+1;
 $page['day'][$i]['selected']="";
 $page['day'][$i]['checked']="";
 if($var['day']==($i+1)) {
  $page['day'][$i]['selected']="selected";
  $page['day'][$i]['checked']="checked";
 }
}


$page['L_penality']=$lang['competition']['penality'];
$page['L_home']=$lang['competition']['home'];
$page['L_visitor']=$lang['competition']['visitor'];
$page['L_group']=$lang['competition']['group'];
$page['L_day']=$lang['competition']['day'];
if(!isset($var['header']) OR $var['header']!=0) {
 $page['fen']="ajax";
 $page['template']=$tpl['competition']['select_round_details'];
}

?>