<?php
if(!isset($var['header']) OR $var['header']!=0) {
 header('Content-type: text/html; charset='.$lang['general']['charset']); 
}
$page['select_name']="";
$page['round']=array();
$page['show_round']="1";
if(!isset($page['type_view'])) $page['type_view']="";

$var['condition']="";
$var['order']="";
$var['limit']="";

if(isset($_POST['competition'])) $var['competition']=$_POST['competition'];
if(isset($_POST['round']) AND !isset($var['value_round'])) $var['value_round']=$_POST['round'];
if(isset($_POST['select']))  $page['select_name']=$_POST['select'];
if(isset($_POST['type']))  $page['type_view']=$_POST['type'];


$sql_round=sql_replace($sql['competition']['select_round'],$var);

$sgbd = sql_connect();
$res_round = sql_query($sql_round);
$nb_ligne=sql_num_rows($res_round);
if($nb_ligne=="0")
{
 $page['show_round']="";
}
else
{
 $i="0";
 while($ligne = sql_fetch_array($res_round))
 {
   $page['round'][$i]['id']=$ligne['round_id'];
   $page['round'][$i]['name']=$ligne['round_name'];
   $page['round'][$i]['select_name']=$page['select_name'];
   if($page['type_view']=="all") {
    $page['round'][$i]['link_select_round_details']=convert_url("index.php?r=".$lang['general']['idurl_competition']."&v1=select_round_all_details");
   } else {
    $page['round'][$i]['link_select_round_details']=convert_url("index.php?r=".$lang['general']['idurl_competition']."&v1=select_round_details");
   }
  
  if(isset($var['value_round']) AND $var['value_round']==$ligne['round_id']) { 
   $page['round'][$i]['selected']="selected";
   $page['round'][$i]['checked']="checked";
  }
  else { 
   $page['round'][$i]['selected']="";
   $page['round'][$i]['checked']="";
  }
  $i++;
 }
}  



if(isset($_POST['size'])) {
$page['size']=$_POST['size'];
}

$page['link_select_round_details']=convert_url("index.php?r=".$lang['general']['idurl_competition']."&v1=select_round_details");
$page['L_choose_round']=utf8_encode($lang['competition']['choose_round']);

if(!isset($var['header']) OR $var['header']!=0) {
$page['fen']="ajax";
$page['template']=$tpl['competition']['select_round'];
}


?>