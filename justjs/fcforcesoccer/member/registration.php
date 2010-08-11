<?php
##################################
# member : registration
##################################
include_once(create_path("club/sql_club.php"));

# variables
$page['L_message']="";
$nb_erreur="0";
$page['erreur']=array();
$page['sex']=array();

# form values
$page['value_id']="";
$page['value_name']="";
$page['value_firstname']="";
$page['value_email']="";
$page['value_date_birth']="";
$page['value_sex']="";
$page['value_login']="";
$page['value_description']="";
$page['value_avatar']="";

$page['show_form']=1;


if(REGISTRATION==0) {
	$page['L_message']=$lang['member']['E_no_registration'];
	$page['show_form']='';
}

# case of add
if(REGISTRATION==1 AND isset($_POST) AND !empty($_POST))
{
	# we format datas
	if(isset($_POST['name'])) $_POST['name']=format_txt($_POST['name']);
	if(isset($_POST['firstname'])) $_POST['firstname']=format_txt($_POST['firstname']);
	if(isset($_POST['email'])) $_POST['email']=trim($_POST['email']);
	if(isset($_POST['date_birth'])) $_POST['date_birth']=format_txt($_POST['date_birth']);
	if(isset($_POST['description'])) $_POST['description']=format_txt($_POST['description']);
	if(isset($_POST['login_member'])) $_POST['login']=format_txt($_POST['login_member']);
	
	# we check datas
	if(!isset($_POST['name']) OR $_POST['name']=="") { 
		$page['erreur'][$nb_erreur]['message']=$lang['member']['E_empty_name']; $nb_erreur++;
	}
	if(!isset($_POST['firstname']) OR $_POST['firstname']=="") { 
		$page['erreur'][$nb_erreur]['message']=$lang['member']['E_empty_firstname']; $nb_erreur++;
	}
	
	# email
	if(!isset($_POST['email']) OR empty($_POST['email'])) {
		$page['erreur'][$nb_erreur]['message']=$lang['member']['E_empty_email']; $nb_erreur++;
	}
	elseif(!check_email($_POST['email'])) { 
		$page['erreur'][$nb_erreur]['message']=$lang['member']['E_invalid_email']; $nb_erreur++;
	}
	/*
	we don't check if a member have the same mail because the visitor who want to register can be an existing member
	with the same email who just wants to activate its account	
	 elseif(isset($_POST['email']) AND !empty($_POST['email']))
	{
		$sgbd = sql_connect();
		$sql_verif_email = sql_replace($sql['member']['verif_member_email'],$_POST);
		$res = sql_query($sql_verif_email);
		$nb_res = sql_num_rows($res);
		sql_free_result($res);
		sql_close($sgbd);
		if($nb_res!="0") { 
			$page['erreur'][$nb_erreur]['message']=$lang['member']['E_choisi_email']; $nb_erreur++;
		}
	}
 	*/
	
	# date of birth
	if(isset($_POST['date_birth']) AND !empty($_POST['date_birth']) AND !check_date($_POST['date_birth'])) { 
		$page['erreur'][$nb_erreur]['message']=$lang['member']['E_invalid_date_birth']; $nb_erreur++;
	} 
 
	# login 
	if(!isset($_POST['login_member']) OR empty($_POST['login_member'])) { 
		$page['erreur'][$nb_erreur]['message']=$lang['member']['E_empty_login']; $nb_erreur++;
	}
	elseif(!check_login($_POST['login_member'])) { 
		$page['erreur'][$nb_erreur]['message']=$lang['member']['E_invalid_login']; $nb_erreur++; 
	}
	elseif(isset($_POST['login']) AND !empty($_POST['login']))
	{
		$sgbd = sql_connect();
		$sql_verif_login = sql_replace($sql['member']['verif_member_login'],$_POST);
		$res = sql_query($sql_verif_login);
		$nb_res = sql_num_rows($res);
		sql_free_result($res);
		sql_close($sgbd);
		if($nb_res!="0") { 
			$page['erreur'][$nb_erreur]['message']=$lang['member']['E_choisi_login']; $nb_erreur++;
		}
	}

	# password
	if(!isset($_POST['pass_member']) OR empty($_POST['pass_member'])) {
		$page['erreur'][$nb_erreur]['message']=$lang['member']['E_empty_pass']; $nb_erreur++;
	}
	elseif(!check_login($_POST['pass_member'])) { 
		$page['erreur'][$nb_erreur]['message']=$lang['member']['E_invalid_pass']; $nb_erreur++;
	}
	elseif(!isset($_POST['confirm_pass']) OR empty($_POST['confirm_pass'])) { 
		$page['erreur'][$nb_erreur]['message']=$lang['member']['E_empty_confirm_pass']; $nb_erreur++;
	}
	elseif($_POST['pass_member']!=$_POST['confirm_pass']) { 
		$page['erreur'][$nb_erreur]['message']=$lang['member']['E_pass_different']; $nb_erreur++;   
	}
	
	# avatar
	if(isset($_POST['avatar']) AND !empty($_POST['avatar']) AND !check_url($_POST['avatar'])) { 
		$page['erreur'][$nb_erreur]['message']=$lang['member']['E_invalid_avatar']; $nb_erreur++;
	}

  
	# there is no error in submited datas
	if($nb_erreur==0)
	{
		$_POST['status']=0; // simple member
		$_POST['valid']=-1; // we ask for an activation
		
		if(isset($_POST['pass_member'])) $_POST['pass_md5']=md5($_POST['pass_member']);
		
		if(isset($_POST['date_birth']) AND !empty($_POST['date_birth'])) {
			$_POST['date_birth']=convert_date_sql($_POST['date_birth']);
		}
		if(!isset($_POST['sex'])) $_POST['sex']="";
	
		# we save data
		$sql_add=sql_replace($sql['member']['insert_member_registration'],$_POST);			
		$sgbd = sql_connect();
		$execution=sql_query($sql_add);
		
		if($execution) { 
			$page['L_message']=$lang['member']['form_registration_add_1'];
			$page['value_id']=sql_insert_id($sgbd);
			
			# we send an email
			if(MAIL==1 AND REGISTRATION_MAIL==1) {
				$var['firstname']=$_POST['login'];
				$var['site_title']=SITE_TITLE;
				$var['site_url']=ROOT_URL;
				$var['sender_email']=SENDER_EMAIL;
				$var['sender_name']=SENDER_NAME;
				$var['login']=$_POST['login'];
				$var['pass']=$_POST['pass_member'];
				$subject=text_replace($lang['member']['mail_registration_subject'],$var);
				$message=text_replace($lang['member']['mail_registration_message'],$var);
				send_mail(SITE_TITLE, SENDER_EMAIL,$_POST['email'],$subject,$message,'text/plain');
			}
		}
		else { 
			$page['L_message']=$lang['member']['form_registration_add_0'];
		}
		sql_close($sgbd);
		$page['show_form']="";	
	}
	else
	{
		# there is some errors: we show the datas again
		if(isset($_POST['id'])) $page['value_id']=$_POST['id'];
		if(isset($_POST['name'])) $page['value_name']=$_POST['name'];
		if(isset($_POST['firstname'])) $page['value_firstname']=$_POST['firstname'];
		if(isset($_POST['email'])) $page['value_email']=$_POST['email'];
		if(isset($_POST['date_birth'])) $page['value_date_birth']=$_POST['date_birth'];
		if(isset($_POST['sex'])) $page['value_sex']=$_POST['sex'];
		
		if(isset($_POST['login_member'])) $page['value_login']=$_POST['login_member'];
		if(isset($_POST['description'])) $page['value_description']=$_POST['description']; 
		if(isset($_POST['avatar'])) $page['value_avatar']=$_POST['avatar'];
		$page['show_form']="1";
	}
}


if($page['show_form']==1) {
	# sexs list	
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
	  if(isset($page['value_sex']) AND $page['value_sex']==$ligne['sex_id']) { $page['sex'][$i]['checked']="checked"; } else { $page['sex'][$i]['checked']=""; }
	  $i++;
	 }
	}
	sql_free_result($res_sex);
	sql_close($sgbd);
}

# links
$page['form_action']=convert_url("index.php?r=".$lang['general']['idurl_member']."&v1=registration");

$page['link_choose_avatar']=convert_url("index.php?r=".$lang['general']['idurl_file']."&v1=image_manager&parent_form=form_registration&field_name=avatar&file_type=image&fen=pop&folder=".AVATAR_FOLDER,0);


# text
$page['L_title']=$lang['member']['form_registration'];

$page['L_valider']=$lang['member']['submit'];
$page['L_delete']=$lang['member']['delete'];
$page['L_back_list']=$lang['member']['back_list'];
$page['L_erreur']=$lang['general']['E_erreur'];
$page['L_field_required']=$lang['general']['field_required'];

$page['L_identity']=$lang['member']['identity'];
$page['L_name']=$lang['member']['name'];
$page['L_firstname']=$lang['member']['firstname'];
$page['L_date_birth']=$lang['member']['date_birth'];
$page['L_place_birth']=$lang['member']['place_birth'];
$page['L_email']=$lang['member']['email'];
$page['L_size']=$lang['member']['size'];
$page['L_size_unit']=$lang['member']['size_unit'];
$page['L_weight']=$lang['member']['weight'];
$page['L_weight_unite']=$lang['member']['weight_unite'];
$page['L_sex']=$lang['member']['sex'];
$page['L_country']=$lang['member']['nationality'];
$page['L_choose_country']=$lang['member']['choose_nationality'];
$page['L_referee']=$lang['member']['referee'];
$page['L_level']=$lang['member']['level'];
$page['L_choose_level']=$lang['member']['choose_level'];

$page['L_registration_info']=$lang['member']['registration_info'];
$page['L_login']=$lang['member']['login'];
$page['L_description']=$lang['member']['description'];
$page['L_photo']=$lang['member']['photo'];
$page['L_avatar']=$lang['member']['avatar'];
$page['L_choose_image']=$lang['member']['choose_image'];
$page['L_pass']=$lang['member']['pass'];
$page['L_explication_pass']=$lang['member']['explication_pass'];
$page['L_confirm_pass']=$lang['member']['confirm_pass'];
$page['L_status']=$lang['member']['status'];
$page['L_choose_status']=$lang['member']['choose_status'];
$page['L_valid']=$lang['member']['valid'];

$page['L_comment']=$lang['member']['comment'];
$page['L_format_date']=$lang['member']['format_date'];

$page['meta_title']=$page['L_title'];
$page['template']=$tpl['member']['registration'];
?>