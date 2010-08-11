<?php
header('Content-type: text/html; charset='.$lang['general']['charset']);

$page['select_name']="";
$page['div']="";
$page['team']=array();
$page['aff']="";
$page['nb_max_match_player']=NB_MAX_PLAYER;


// test des POST emis
if(isset($_POST['id']) && !empty($_POST['id']) ){
	$page['select_name']=$_POST['select'];
	$page['club']="";
	$page['div']="";
	if($_POST['div']=="team_home") { $page['div']="match_player_list_home"; $page['club']="club_home"; }
	if($_POST['div']=="team_visitor") { $page['div']="match_player_list_visitor"; $page['club']="club_visitor"; }
	
    $sgbd=sql_connect();
	$var['condition']=" WHERE e.club_id='".$_POST['id']."'";
	$var['order']=" ORDER BY ne.team_name_order ";
	$var['limit']="";

	$req=sql_replace($sql['team']['select_team_condition'],$var);	
    $result=sql_query($req);
	$nb_ligne=sql_num_rows($result);
	if($nb_ligne!="0")
	{
     $page['aff']="1";
	 $i=0;
      while ($ligne=sql_fetch_array($result))
      { 	
       $page['team'][$i]['id']=$ligne['team_id'];
	   $page['team'][$i]['name']=$ligne['team_name_name'];
	   $page['team'][$i]['sex']=$ligne['sex_abbreviation'];
	   $i++;
      } 
	}
}

$page['link_select_player']=convert_url("index.php?r=".$lang['general']['idurl_member']."&v1=select_member");

$page['L_choose_team']=$lang['team']['choose_team'];
$page['fen']="ajax";
$page['template']=$tpl['team']['select_team_club'];
?>