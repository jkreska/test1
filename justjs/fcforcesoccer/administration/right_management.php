<?php
# management of users rights
	
$nb_erreur="0";
$page['erreur']=array();
$page['L_message']="";

$page['right']=array();
$page['group']=array();

if($right_user['right_management']) {
	$page['show_form']=1; 
}
else {
	$page['show_form']='';
	$page['L_message']=$lang['general']['acces_reserve_admin'];
}


# list of available rights
$right=array();
include_once(create_path("news/right_news.php"));
include_once(create_path("information/right_information.php"));
include_once(create_path("forum/right_forum.php"));
include_once(create_path("club/right_club.php"));
include_once(create_path("team/right_team.php"));
include_once(create_path("competition/right_competition.php"));
include_once(create_path("match/right_match.php"));
include_once(create_path("field/right_field.php"));
include_once(create_path("member/right_member.php"));
include_once(create_path("administration/right_administration.php"));
include_once(create_path("file/right_file.php"));


# we update the group right
if($right_user['right_management'] AND isset($_POST) AND !empty($_POST)) {
	# first we delete all the group right
	$sql_delete=$sql['member']['sup_group_right_all'];

	# then we save the new values
	$values=array();
	foreach($_POST['group'] AS $id_group => $value_right) {
		foreach($right AS $id => $organ) {
			foreach($organ AS $value) {
				$id_right=$value['id'];
				if($id_group==4) { $value_sql=1; } // the super admin has all rights
				elseif(isset($value_right[$id_right])) $value_sql=1;
				else $value_sql=0;
				$values[]="('".$id_group."','".$id_right."','".$value_sql."')";
			}
		}
	}
	$var['values']=implode(', ',$values);
	$sql_insert=sql_replace($sql['member']['insert_group_right'], $var);
	
	# we execute the sql requests
	$sgbd = sql_connect();
	sql_query($sql_delete);
	if(sql_query($sql_insert)) { $page['L_message']=$lang['member']['form_group_right_edit_1']; }
	else { $page['L_message']=$lang['member']['form_group_right_edit_0']; }
	sql_close($sgbd);
}


# list of users group
# there are 4 groups by default : 1 visitor, 2 member, 3 admin, 4 super admin (all rights)

$sql_list=$sql['member']['select_group_right_all'];
$sgbd = sql_connect();
$res_list = sql_query($sql_list);
$i="0";
$tmp='';
$group_list=array();
while($ligne = sql_fetch_array($res_list))
{
	$id=$ligne['group_id'];
	if($tmp!=$id) {
		array_push($group_list,$id);
		$page['group'][$i]['id']=$ligne['group_id'];
		$page['group'][$i]['name']=$ligne['group_name'];
		$page['group'][$i]['description']=$ligne['group_description'];
		$i++;
	}	
	$tmp=$id;
	# rights of the group
	$id_right=$ligne['right_id'];
	$right_group[$id][$id_right]=$ligne['value'];
}
sql_free_result($res_list);
sql_close($sgbd);

# we create the form
$i=0;
$tmp='';
foreach($right AS $id => $organ) {
	foreach($organ AS $value) {
		$id_right=$value['id'];
		$page['right'][$i]=$value;
		
		if($tmp!=$id) $page['right'][$i]['organ_name']=$lang['general'][$id];
		else $page['right'][$i]['organ_name']='';	
		
		$page['right'][$i]['mod']=$i%2;
		$page['right'][$i]['group_right']=array();
		
		$j=0;
		foreach($group_list AS $id_group) {		 
			$page['right'][$i]['group_right'][$j]['group_id']=$id_group;
			$page['right'][$i]['group_right'][$j]['right_id']=$id_right;
			
			$page['right'][$i]['group_right'][$j]['checked']='';
			if(isset($right_group[$id_group][$id_right]) AND $right_group[$id_group][$id_right]) {
				$page['right'][$i]['group_right'][$j]['checked']='checked="checked"';
			}			
			$j++;
		}
		$i++;
		$tmp=$id;		
	}
	
	
}

if(!$right_user['right_management']) {
	$page['right']=array();
	$page['group']=array();
}

# link
$page['form_action']=convert_url("index.php?r=".$lang['general']['idurl_admin']."&v1=right-management");
$page['link_group_list']='';
if($right_user['group_list']) { 
	$page['link_group_list']=convert_url("index.php?r=".$lang['general']['idurl_member']."&v1=group_list");
}


# text
$page['L_title']=$lang['administration']['right_management'];

$page['L_right']=$lang['administration']['right'];
$page['L_valid']=$lang['administration']['submit'];

$page['L_group_list']=$lang['administration']['group_list'];

$page['meta_title']=$lang['administration']['right_management'];
$page['template']=$tpl['administration']['right_management'];

?>