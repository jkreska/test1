<?php
header('Content-type: text/html; charset='.$lang['general']['charset']); 

$page['select_name']="";
$page['member']=array();
$page['aff']="1";

$var['condition']="";
$var['order']="";
$var['limit']="";

if(CLUB!=0) $var['value_club']=CLUB;

if(isset($_POST['club'])) $var['value_club']=$_POST['club'];
if(isset($_POST['club2'])) $var['value_club2']=$_POST['club2'];
if(isset($_POST['team'])) $var['value_team']=$_POST['team'];
if(isset($_POST['team2'])) $var['value_team2']=$_POST['team2'];
if(isset($_POST['date_start'])) $var['value_date_start']=$_POST['date_start'];
if(isset($_POST['season'])) $var['value_season']=$_POST['season'];
if(isset($_POST['member'])) $var['value_member']=$_POST['member'];

if(isset($_POST['sex'])) $var['value_sex']=$_POST['sex'];

if(isset($_POST['referee'])) $var['value_referee']=1;

$included=1;
include(create_path("member/member_list.php"));
unset($included);

$page['member']=$page['member'];

$page['select_name']=$_POST['select'];
if(isset($_POST['size'])) {
$page['size']=$_POST['size'];
}

$page['L_choose_member']=utf8_encode($lang['member']['choose_member']);
$page['fen']="ajax";

if(isset($_POST['type'])) {
 switch($_POST['type']) {
 case "multiple" : $page['template']=$tpl['member']['select_member_multiple']; break;
 default : $page['template']=$tpl['member']['select_member'];
 }
}
else
{
 $page['template']=$tpl['member']['select_member'];
}


?>