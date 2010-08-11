<?php
# send a new password to a member who asked
$page['L_message']="";
$page['erreur']=array();
$nb_erreur=0; 

$page['value_login']="";
$page['value_email']="";
$page['show_form']='1';

if(MAIL!=1 OR REGISTRATION_MAIL!=1) {
	$page['L_message']=$lang['member']['E_no_forgot_pass'];
	$page['show_form']='';
}

if(isset($_POST) AND !empty($_POST) AND MAIL==1 AND REGISTRATION_MAIL==1)
{
	if(isset($_POST['login'])) $_POST['login']=format_txt($_POST['login']);
	if(isset($_POST['email'])) $_POST['email']=format_txt($_POST['email']);	
	
	# we check data
	if(!isset($_POST['login']) OR empty($_POST['login'])) { 
		$page['erreur'][$nb_erreur]['message']=$lang['member']['E_empty_login']; $nb_erreur++;
	}
	elseif(!check_login($_POST['login'])) { 
		$page['erreur'][$nb_erreur]['message']=$lang['member']['E_invalid_login']; $nb_erreur++;
	}
	else
	{
		$_POST['id']='';		
		$sql_verif_login = sql_replace($sql['member']['verif_member_login'],$_POST);
		$sgbd = sql_connect();
		$res = sql_query($sql_verif_login);
		$nb_res = sql_num_rows($res);
		$ligne_login=sql_fetch_array($res);		
		sql_free_result($res);
		sql_close($sgbd);
		if($nb_res!="1") { $page['erreur'][$nb_erreur]['message']=$lang['member']['E_absent_login']; $nb_erreur++; }
	}

	if(!isset($_POST['email']) OR empty($_POST['email'])) { $page['erreur'][$nb_erreur]['message']=$lang['member']['E_empty_email']; $nb_erreur++; }
	elseif(!check_email($_POST['email'])) { $page['erreur'][$nb_erreur]['message']=$lang['member']['E_invalid_email']; $nb_erreur++; }
	else
	{
		$_POST['id']='';
		$sql_verif_email = sql_replace($sql['member']['verif_member_email'],$_POST);
		$sgbd = sql_connect();
		$res = sql_query($sql_verif_email);
		$nb_res = sql_num_rows($res);
		$ligne_email=sql_fetch_array($res);
		sql_free_result($res);
		sql_close($sgbd);
		if($nb_res!="1") { $page['erreur'][$nb_erreur]['message']=$lang['member']['E_absent_email']; $nb_erreur++; }
	}

	if(isset($ligne_login['member_id']) AND isset($ligne_email['member_id']) 
	AND $ligne_login['member_id']!=$ligne_email['member_id']) { 
		$page['erreur'][$nb_erreur]['message']=$lang['member']['E_absent_email']; $nb_erreur++;
	}

	if($nb_erreur==0)
	{
		# we create a new password, we save it and send it by email
		$_POST['pass']=create_pass();
		$_POST['pass_md5']=md5($_POST['pass']);
		
		$_POST['id']=$ligne_login['member_id'];
		$page['show_form']='';
		
		$sql_modif = sql_replace($sql['member']['edit_member_pass'],$_POST);		
		$sgbd = sql_connect();
		$execution=sql_query($sql_modif);

		if($execution)
		{
			$var['firstname']=$_POST['login'];
			$var['site_title']=SITE_TITLE;
			$var['site_url']=ROOT_URL;
			$var['sender_email']=SENDER_EMAIL;
			$var['sender_name']=SENDER_NAME;
			$var['login']=$_POST['login'];
			$var['pass']=$_POST['pass'];
			
			$message=text_replace($lang['member']['mail_forgot_pass_message'],$var);			
			
			if(send_mail(SITE_TITLE, SENDER_EMAIL,$_POST['email'],$lang['member']['mail_forgot_pass_subject'],$message,'text/plain')) {
				$page['L_message']=$lang['member']['forgot_pass_ok'];
			}
			else {
				$page['L_message']=$lang['member']['forgot_pass_pbm'];
			}			
		}
		else
		{
			$page['L_message']=$lang['member']['forgot_pass_pbm'];
		}
		sql_close($sgbd);
	}
	else {
		$page['value_login']=$_POST['login'];
		$page['value_email']=$_POST['email'];
	}
}

# link
$page['form_action']=convert_url("index.php?r=".$lang['general']['idurl_member']."&v1=forgot_pass");

# text
$page['L_form_forgot_pass']=$lang['member']['form_forgot_pass'];
$page['L_forgot_pass_info']=$lang['member']['forgot_pass_info'];

$page['L_login']=$lang['member']['login'];
$page['L_email']=$lang['member']['email'];
$page['L_submit']=$lang['member']['submit'];

$page['L_erreur']=$lang['general']['E_erreur'];
$page['L_field_required']=$lang['general']['field_required'];

$page['template']=$tpl['member']['forgot_pass'];

?>