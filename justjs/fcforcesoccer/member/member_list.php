<?php
$nb_max=NB_MEMBER; // number de member par page

$page['member']=array();
$page['link_first_page']="";
$page['link_previous_page']="";
$page['link_last_page']="";
$page['link_next_page']="";
$page['L_message']="";

$page['ajax']=""; # est on en train d'effectuer une search 
if(isset($_POST['fen']) AND $_POST['fen']=="ajax") { $page['ajax']=1;}

$page['value_member_lastname']="";
$page['value_member_sex']="";
if(!isset($var['value_name'])) $var['value_name']="";
if(!isset($var['value_sex'])) $var['value_sex']="";
if(!isset($var['value_group'])) $var['value_group']="";
if(isset($_POST['name']) AND !empty($_POST['name'])) { $var['value_name']=$_POST['name']; $page['value_member_lastname']=$_POST['name']; }
if(isset($_POST['sex']) AND !empty($_POST['sex'])) { $var['value_sex']=$_POST['sex']; $page['value_member_sex']=$_POST['sex']; }
if(isset($_POST['group']) AND !empty($_POST['group'])) { $var['value_group']=$_POST['group']; $page['value_member_group']=$_POST['group']; }

# suppression
if($right_user['delete_member'] AND isset($_GET['v2']) AND $_GET['v2']=="delete" AND isset($_GET['v3']) AND !empty($_GET['v3']) AND (!isset($included) OR $included==0)) 
{
 $var['id']=$_GET['v3'];
 # on n'autorise pas la suppression de l'administrateur principal (id=1)
 if($var['id']==1)
 {
  $page['L_message']=$lang['member']['E_suppression_member_administrateur'];
 }
 elseif($var['id']==$_SESSION['session_member_id'])
 {
  $page['L_message']=$lang['member']['E_suppression_member_connecte'];
 }
 else
 {
  $sql_verif=sql_replace($sql['member']['verif_member'],$var);
  $sql_sup=sql_replace($sql['member']['sup_member'],$var);
  $sgbd = sql_connect();
  
  $var['member']=$var['id'];
  $sql_sup_club=sql_replace($sql['member']['sup_member_club'],$var); // member_club
  $sql_sup_job=sql_replace($sql['member']['sup_member_job'],$var); // member_job

  if(sql_num_rows(sql_query($sql_verif))=="0") # we can delete
  {
   $execution=sql_query($sql_sup);
   if($execution) { 
    $page['L_message']=$lang['member']['form_member_sup_1'];
	sql_query($sql_sup_club);
	sql_query($sql_sup_job);
   }
   else { $page['L_message']=$lang['member']['form_member_sup_0']; }
  }
  else # we can not delete
  {
   $page['L_message']=$lang['member']['form_member_sup_0'];
  }
  sql_close($sgbd);
 }
}


# TRI
# $_GET['v1'] is a variable like : page_1_name_asc
if(isset($_GET['v1']) AND eregi("page",$_GET['v1']))
{
 $v=explode("_",$_GET['v1']);
 $page_num=$v['1'];
 $tri=$v['2'];
 $ordre=$v['3'];
}
elseif(isset($_POST['page']) AND !empty($_POST['page']))
{
 $page_num=$_POST['page'];
 $tri=$_POST['tri'];
 $ordre=$_POST['ordre'];
}
else
{
 $page_num=1; // number of the page
 $tri="name"; // tri par defaut
 $ordre="asc"; // ordre par defaut
}

# ORDRE (sens)
if($ordre=="desc") { $sens="desc"; $sens_inv="asc"; }
else { $sens="asc"; $sens_inv="desc"; }

$page['value_tri']=$tri;
$page['value_ordre']=$sens;
$page['ordre']=$sens_inv;



/************************/
/* START CONDITIONS  */
/************************/
if(!isset($var['condition']) OR $var['condition']=="")
{
 $condition=array();
 $join="";
 /*  blocked member only for admin */
 if($right_user['edit_member']) { array_push($condition," member_status != '1' "); }

 /* par defaut */
// array_push($condition," lang_id=".LANG_ID." ");

 if((isset($var['value_club']) AND !empty($var['value_club'])) OR (isset($var['value_club2']) AND !empty($var['value_club2']))) 
 { 
  if(!isset($var['value_referee']) OR $var['value_referee']==0) 
  {
   $join.=" INNER JOIN ".T_member_club." AS mc ON mc.member_id=m.member_id "; 
   $club=array();
   if(isset($var['value_club']) AND !empty($var['value_club'])) { array_push($club,"'".$var['value_club']."'"); }
   if(isset($var['value_club2']) AND !empty($var['value_club2'])) { array_push($club,"'".$var['value_club2']."'"); }  
   if(sizeof($club)!=0) { 
   $club=implode(",",$club);
   array_push($condition," mc.club_id IN (".$club.") "); }
  }   
 }
 
 if(isset($var['value_team']) AND !empty($var['value_team']))
 {
  $join.=" INNER JOIN ".T_team_player." AS ej ON ej.member_id=m.member_id ";
  array_push($condition," ej.team_id = '".$var['value_team']."' "); 
 }
 
 if(isset($var['value_season']) AND !empty($var['value_season'])) 
 { 	
	array_push($condition," mc.season_id='".$var['value_season']."' ");
 } 

 if(isset($var['value_date_start']) AND check_date($var['value_date_start'])) 
 { 	
	$join.=" INNER JOIN ".T_season." AS s ON s.season_id=mc.season_id ";
	if(isset($var['value_team']) AND !empty($var['value_team'])) $join.=" AND s.season_id=ej.season_id ";
	
	$var['value_date_start']=convert_date_sql($var['value_date_start']);
	array_push($condition," (s.season_date_start <='".$var['value_date_start']."' AND s.season_date_end >= '".$var['value_date_start']."') ");
 }
 if(isset($var['value_referee']) AND $var['value_referee']==1) 
 { 	
	array_push($condition," m.level_id!='0' ");
 } 
 
 if(isset($var['value_member']) AND !empty($var['value_member'])) 
 { 	
	array_push($condition," m.member_id NOT IN (".$var['value_member'].") ");
 }
 
 if(isset($var['value_member_in']) AND !empty($var['value_member_in'])) 
 { 	
	array_push($condition," m.member_id IN (".$var['value_member_in'].") ");
 } 
 
 if(isset($var['value_group']) AND !empty($var['value_group'])) 
 { 	
	array_push($condition," m.member_status='".$var['value_group']."' ");
 }  

 if(isset($var['value_name']) AND !empty($var['value_name']))
 {
  array_push($condition," m.member_lastname LIKE '%".$var['value_name']."%' OR m.member_firstname LIKE '%".$var['value_name']."%' "); 
 }
 
 if(isset($var['value_sex']) AND !empty($var['value_sex']))
 {
  if(is_array($var['value_sex'])) $var_sex=implode(",",$var['value_sex']);
  else $var_sex=$var['value_sex'];
  array_push($condition," m.sex_id IN (".$var_sex.") ");   
 }
 # creation of conditions list
 $nb_condition=sizeof($condition);
 if($nb_condition==0) { $var['condition']=""; }
 elseif($nb_condition=="1") { $var['condition']="WHERE ".$condition['0']; }
 else { $var['condition']="WHERE ".implode(" AND ",$condition); }
 
 $var['condition']=$join." ".$var['condition'];
}
/**********************/
/* END OF CONDITIONS    */
/**********************/




/**********************/
/* ORDER (tri) */
/**********************/
if(!isset($var['order']) OR empty($var['order']))
{
 switch($tri) {
  case "name" : $var['order']=" ORDER BY member_lastname ".$sens." "; break;
  case "firstname" : $var['order']=" ORDER BY member_firstname ".$sens." "; break;
  case "sex" : $var['order']=" ORDER BY s.sex_name ".$sens." "; break;
  case "date" : $var['order']=" ORDER BY member_date_birth ".$sens." "; break;
  default : $var['order']=" ORDER BY member_lastname ".$sens." ";
 }
}


$page['page']=array();
if(!isset($var['limit']))
{
 /* on recupere le nb d'member */
 $sql_nb=sql_replace($sql['member']['select_member_nb'],$var);
 $sgbd = sql_connect();
 $res_nb = sql_query($sql_nb);
 $ligne=sql_fetch_array($res_nb);
 $nb=$ligne['nb'];
 sql_free_result($res_nb);
 sql_close($sgbd);

 /***************/
 /* PAGINATION */
 /**************/
 $page['first_page']="";
 $page['previous_page']="";
 $page['next_page']="";
 $page['last_page']="";
  
 # number of the current page
 $var['limit']="LIMIT ".($page_num-1)*$nb_max.",".$nb_max;
 $nb_page=ceil($nb/$nb_max);

 $url="index.php?r=".$lang['general']['idurl_member']."&v1=page_";
 $end_url="_".$tri."_".$sens;

 $page['page']=generate_pagination($url, $nb_page,$page_num,$end_url);

 # previous page (except on the first one)
 if($page_num!=1)
 {
  $page['link_first_page']=convert_url($url."1".$end_url);
  $page['link_previous_page']=convert_url($url.($page_num - 1).$end_url);
  $page['first_page']="1";
  $page['previous_page']=$page_num - 1;
 }
 # next page (except on the last one)
 if($page_num!=$nb_page)
 {
  $page['link_last_page']=convert_url($url.$nb_page.$end_url);
  $page['link_next_page']=convert_url($url.($page_num + 1).$end_url);
  $page['next_page']=$page_num + 1;
  $page['last_page']=$nb_page;  
 }
 /******************/
 /* END PAGINATION */
 /******************/

}

$sql_member=sql_replace($sql['member']['select_member_condition'],$var);

$sgbd = sql_connect();
$res_member = sql_query($sql_member);
$nb_ligne=sql_num_rows($res_member);
$page['nb_member']=$nb_ligne;
if(!$right_user['member_list']) {
	$page['L_message']=$lang['general']['acces_reserve_admin'];
}
elseif($nb_ligne=="0")
{
 $page['L_message']=$lang['member']['E_member_not_found'];
}
else
{
 $i="0";
 while($ligne = sql_fetch_array($res_member))
 {
  $page['member'][$i]['mod']=$i%2;
  
  $page['member'][$i]['id']=$ligne['member_id'];
  $page['member'][$i]['name']=$ligne['member_lastname'];
  $page['member'][$i]['firstname']=$ligne['member_firstname'];
  $page['member'][$i]['email']=$ligne['member_email'];  
  if($ligne['sex_name']!=NULL) {
  	$page['member'][$i]['sex']=$ligne['sex_name'];
	$page['member'][$i]['sex_abbreviation']=$ligne['sex_abbreviation'];
  }
  else { 
  	$page['member'][$i]['sex']='';
	$page['member'][$i]['sex_abbreviation']='';
  } 
  
  $page['member'][$i]['date_birth']=convert_date($ligne['member_date_birth'],$lang['member']['format_date_php']);  
  $page['member'][$i]['comment']=$ligne['member_comment'];
  $page['member'][$i]['valid']=$ligne['member_valid'];
  $page['member'][$i]['status']=$ligne['member_status'];
  
  $page['member'][$i]['date_registration']=convert_date($ligne['member_date_registration'],$lang['member']['format_date_php']);
  
  # text
  $page['member'][$i]['L_edit']=$lang['member']['edit'];
  $page['member'][$i]['L_check']=$lang['member']['check'];
  $page['member'][$i]['L_delete']=$lang['member']['delete'];
  $page['member'][$i]['L_show_view']=$lang['member']['show_view'];
  $page['member'][$i]['L_valid']=$lang['member']['valid_'.$ligne['member_valid']];
  //$page['member'][$i]['L_status']=$lang['member']['status_'.$ligne['member_status']];

  # link
  $page['member'][$i]['link_view']=convert_url("index.php?r=".$lang['general']['idurl_member']."&v1=view&v2=".$ligne['member_id']); 
  
 if(isset($var['value_member']) AND $var['value_member']==$ligne['member_id']) { $page['member'][$i]['selected']="selected"; } else { $page['member'][$i]['selected']=""; }    
  
  $page['member'][$i]['link_edit']='';
  $page['member'][$i]['link_validation']='';
  $page['member'][$i]['link_delete']='';    
  if($right_user['edit_member'])
  {
   $page['member'][$i]['link_edit']=convert_url("index.php?r=".$lang['general']['idurl_member']."&v1=form_member&v2=".$ligne['member_id']);  
  }
  if($right_user['delete_member'])
  {
	$page['member'][$i]['link_delete']=convert_url("index.php?r=".$lang['general']['idurl_member']."&v1=member_list&v2=delete&v3=".$ligne['member_id']);
  }
  if($right_user['registration_validation']) {
  $page['member'][$i]['link_validation']=convert_url("index.php?r=".$lang['general']['idurl_member']."&v1=registration_validation&v2=".$ligne['member_id']);
  }
  $i++;
 }
}
sql_free_result($res_member);
sql_close($sgbd);


# liste des sexs
$page['sex']=array();
$sql_sex=$sql['member']['select_sex'];
$sgbd = sql_connect();
$res_sex = sql_query($sql_sex);
$nb_ligne=sql_num_rows($res_sex);
if($nb_ligne!="0")
{
 $i="0";
 while($ligne = sql_fetch_array($res_sex))
 {
  $page['sex'][$i]['id']=$ligne['sex_id'];
  $page['sex'][$i]['name']=$ligne['sex_name'];
  $page['sex'][$i]['abbreviation']=$ligne['sex_abbreviation'];
  if(isset($page['value_member_sex']) AND !empty($page['value_member_sex']) AND is_array($page['value_member_sex']) AND in_array($ligne['sex_id'],$page['value_member_sex'])) { $page['sex'][$i]['checked']="checked"; } else { $page['sex'][$i]['checked']=""; }
  
  $page['sex'][$i]['link_select_member']=convert_url("index.php?r=".$lang['general']['idurl_member']."&v1=member_list");

  $i++;
 }
}
sql_free_result($res_sex);
sql_close($sgbd);

# liste des groupes
$page['group']=array();
$page['L_group']=$lang['member']['choose_group'];
if($right_user['group_list']) {
	$included=1;
	include(create_path('member/group_list.php'));
	unset($included);
}


# links
 $page['link_add']="";
 $page['link_import_member']='';
 $page['admin']="";
if($right_user['add_member']) {
  $page['link_add']=convert_url("index.php?r=".$lang['general']['idurl_member']."&v1=form_member");
  $page['admin']="1";
}
if($right_user['add_member']) {
  $page['link_import_member']=convert_url("index.php?r=".$lang['general']['idurl_member']."&v1=import_member");
}
$page['link_select_member']=convert_url("index.php?r=".$lang['general']['idurl_member']."&v1=member_list");
$page['form_action']=convert_url("index.php?r=".$lang['general']['idurl_member']."&v1=member_list");

  
$page['link_member']=convert_url("index.php?r=".$lang['general']['idurl_member']."&v1=member_list");
$page['link_tri_name']=convert_url("index.php?r=".$lang['general']['idurl_member']."&v1=page_1_name_".$sens_inv);
$page['link_tri_firstname']=convert_url("index.php?r=".$lang['general']['idurl_member']."&v1=page_1_firstname_".$sens_inv);
$page['link_tri_sex']=convert_url("index.php?r=".$lang['general']['idurl_member']."&v1=page_1_sex_".$sens_inv);
$page['link_tri_date']=convert_url("index.php?r=".$lang['general']['idurl_member']."&v1=page_1_date_".$sens_inv);

# text
$page['L_title']=$lang['member']['member_list'];

$page['L_order']=$lang['member']['order_by'];
$page['L_name']=$lang['member']['name'];
$page['L_firstname']=$lang['member']['firstname'];
$page['L_sex']=$lang['member']['sex'];
$page['L_email']=$lang['member']['email'];
$page['L_date_birth']=$lang['member']['date_birth'];
$page['L_date_registration']=$lang['member']['date_registration'];

$page['L_first_page']=$lang['member']['first_page'];
$page['L_previous_page']=$lang['member']['previous_page'];
$page['L_next_page']=$lang['member']['next_page'];
$page['L_last_page']=$lang['member']['last_page'];

$page['L_search']=$lang['member']['search'];
$page['L_valider']=$lang['member']['submit'];

$page['L_add']=$lang['member']['add_member'];
$page['L_import_member']=$lang['member']['import_member'];


# meta
$page['meta_title']=$lang['member']['member_list'];

if($page['ajax']==1) { $page['template']=$tpl['member']['member_list_search']; $page['fen']="ajax"; }
else { $page['template']=$tpl['member']['member_list']; }

?>