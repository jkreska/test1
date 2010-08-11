<?php
##########################################
# member : validation of the registration
##########################################

# variables
$page['L_message']="";
$page['form_action']=convert_url("index.php?r=".$lang['general']['idurl_member']."&v1=registration_validation");
$nb_erreur="0";
$page['erreur']=array();
$page['member']=array();
$page['sex']=array();
$page['show_form']='1';
$page['show_confirm_mail']='';

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
$page['value_status']="";
$page['value_valid']="";
$page['value_member']="";
$page['value_date_registration']="";
$page['value_action']='';

$page['checked_add']='';
$page['checked_merge']='';
$page['checked_refuse']='';


$member_field=array(
"member_lastname"=>"name",
"member_firstname"=>"firstname",
"sex_id"=>"sex",
"member_date_birth"=>"date_birth",
"member_email"=>"email",
"member_login"=>"login",
"member_avatar"=>"avatar",
"member_description"=>"description",
"member_valid"=>"valid",
"member_key"=>"key",
"member_status"=>"status",
"member_date_registration"=>"date_registration"); 
			

# si l'identifiant du member est passe dans l'url (modification), on le recupere
if(isset($_GET['v2']) AND $_GET['v2']!="") { $page['value_id']=$_GET['v2']; }
elseif(isset($_POST['id']) AND $_POST['id']!="") { $page['value_id']=$_POST['id']; }

# case of add or edit
if(isset($_POST) AND !empty($_POST))
{
	# we format datas
	if(isset($_POST['name'])) $_POST['name']=format_txt($_POST['name']);
	if(isset($_POST['firstname'])) $_POST['firstname']=format_txt($_POST['firstname']);
	if(isset($_POST['email'])) $_POST['email']=trim($_POST['email']);
	if(isset($_POST['date_birth'])) $_POST['date_birth']=format_txt($_POST['date_birth']);
	if(isset($_POST['description'])) $_POST['description']=format_txt($_POST['description']);
	if(isset($_POST['login_member'])) $_POST['login']=format_txt($_POST['login_member']);
	
	# we check datas
	if(!isset($_POST['name']) OR $_POST['name']=="") { $page['erreur'][$nb_erreur]['message']=$lang['member']['E_empty_name']; $nb_erreur++; }
	if(!isset($_POST['firstname']) OR $_POST['firstname']=="") { $page['erreur'][$nb_erreur]['message']=$lang['member']['E_empty_firstname']; $nb_erreur++; } 
 
	if($nb_erreur==0)
	{
		# we check if it does not already exist
		if(isset($_POST['action']) AND $_POST['action']=='add') {
			$sgbd = sql_connect();
			$sql_verif = sql_replace($sql['member']['verif_presence_member'],$_POST);
			$res_verif = sql_query($sql_verif);
			$nb_res = sql_num_rows($res_verif);
			sql_free_result($res_verif);
			sql_close($sgbd);
			if($nb_res!="0") { $page['erreur'][$nb_erreur]['message']=$lang['member']['E_exist_member']; $nb_erreur++; }
		}
	}
	
	# email
	if(!isset($_POST['email']) OR empty($_POST['email'])) {
		$page['erreur'][$nb_erreur]['message']=$lang['member']['E_empty_email']; $nb_erreur++;
	}
	elseif(!check_email($_POST['email'])) { 
		$page['erreur'][$nb_erreur]['message']=$lang['member']['E_invalid_email']; $nb_erreur++;		
	}
 	elseif(isset($_POST['email']) AND !empty($_POST['email']))
	{
		# we check if a member as the same mail only if we want to add a new member
		if(isset($_POST['action']) AND $_POST['action']=='add') {
			$sgbd = sql_connect();
			$sql_verif_email = sql_replace($sql['member']['verif_member_email'],$_POST);
			$res = sql_query($sql_verif_email);
			$nb_res = sql_num_rows($res);
			sql_free_result($res);
			sql_close($sgbd);
			if($nb_res!="0") { $page['erreur'][$nb_erreur]['message']=$lang['member']['E_choisi_email']; $nb_erreur++; }
		}
	}
 
	if(isset($_POST['date_birth']) AND !empty($_POST['date_birth']) AND !check_date($_POST['date_birth'])) { $page['erreur'][$nb_erreur]['message']=$lang['member']['E_invalid_date_birth']; $nb_erreur++; } 
	
	# cas du super admin	
	if(isset($_POST['member']) AND $_POST['member']==1) {
		$page['erreur'][$nb_erreur]['message']=$lang['member']['E_modification_compte_administrateur']; $nb_erreur++; 
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
		if($nb_res!="0") { $page['erreur'][$nb_erreur]['message']=$lang['member']['E_choisi_login']; $nb_erreur++; }
 	}
 
	if(!isset($_POST['action']) OR empty($_POST['action'])) {
		$page['erreur'][$nb_erreur]['message']=$lang['member']['E_empty_action']; $nb_erreur++;
	}
	elseif($_POST['action']=='merge') 
	{ 
		if(!isset($_POST['member']) OR empty($_POST['member'])) {
			# no member are chosen
			$page['erreur'][$nb_erreur]['message']=$lang['member']['E_empty_member']; $nb_erreur++;
		}
		else
		{
			# we check that the existing member has an email
			$var_m['id']=$_POST['member'];
			$sql_details=sql_replace($sql['member']['select_member_details'],$var_m);
			$sgbd = sql_connect();
			$res = sql_query($sql_details);
			$ligne = sql_fetch_array($res);
			sql_free_result($res);
			sql_close($sgbd);			
			
			if((empty($ligne['member_email']) OR !check_email($ligne['member_email'])) AND (!isset($_POST['confirm_mail']) OR $_POST['confirm_mail']==0)) {
				$page['erreur'][$nb_erreur]['message']=$lang['member']['E_empty_email_merge']; $nb_erreur++;
				$page['show_confirm_mail']=1;
			}
			elseif($ligne['member_email']!=$_POST['email'] AND (!isset($_POST['confirm_mail']) OR $_POST['confirm_mail']==0)) {
				$page['erreur'][$nb_erreur]['message']=$lang['member']['E_different_email']; $nb_erreur++;
				$page['show_confirm_mail']=1;
			}			
			elseif(MAIL!=1 AND (!isset($_POST['confirm_mail']) OR $_POST['confirm_mail']==0)) {
				$page['erreur'][$nb_erreur]['message']=$lang['member']['E_inactive_mail']; $nb_erreur++;
				$page['show_confirm_mail']=1;
			}						
			else {
				$member_email=$ligne['member_email'];
				$member_lastname=$ligne['member_lastname'];
				$member_firstname=$ligne['member_firstname'];
			}
		}
	}
 
	# there is no error in submited datas
	if($nb_erreur==0)
	{
		$page['show_form']='';
		
		$_POST['date_birth']=convert_date_sql($_POST['date_birth']);
		if(!isset($_POST['sex'])) $_POST['sex']="";  
	
		if($_POST['action']=='add')
		{
			# it is new member : we active his account
			$_POST['valid']=1; # account is activated
			$_POST['statut']=0; # he is a simple user
			
			$sql_edit=sql_replace($sql['member']['edit_member_registration'],$_POST);   
			$sgbd = sql_connect();
			$execution=sql_query($sql_edit);
						
			if($execution) { $page['L_message']=$lang['member']['form_registration_validation_add_1']; }
			else { $page['L_message']=$lang['member']['form_registration_validation_0']; }
			sql_close($sgbd);			
		}
		elseif($_POST['action']=='merge')
		{
			# it is an existing member : we merge data and ask a confirmation by email						
			if(empty($member_email) OR MAIL!=1 OR REGISTRATION_MAIL!=1) { 
				# member mail is empty, mail function is not activated, or webmaster don't want to send registration mails
				# => it means we cannot ask for a confirmation by email so we activate the account
				$_POST['valid']=1;
			}
			else {
				# the member must confirm the activation of his account
				$_POST['valid']=-2; 
			}
			
			$_POST['status']=0; # he is a simple user
			$var['id']=$_POST['id']; # we keep the id for deleting the registration
			$_POST['id']=$_POST['member']; # we update the existing user			
			$_POST['key']=uniqid(rand());
  			$var['link_activation']=convert_url("index.php?r=".$lang['general']['idurl_member']."&v1=activation&v2=".$_POST['key'],2);
			
			# we create the sql request only with values that are not empty
			$field_value_list=array();
			foreach($member_field AS $id => $value) {
				if($_POST[$value]!='') {
					$field_value_list[]=$id."='".$_POST[$value]."'";
				}
			}				
			$var['field_value']=implode(", ",$field_value_list);	
			$var['id']=$_POST['id'];
			$page['value_id']=$_POST['id'];
				
			$sql_merge=sql_replace($sql['member']['merge_member'],$var);   
			$sgbd = sql_connect();
			$execution=sql_query($sql_merge);
			
			$execution=1;
			if($execution) { 
				$page['L_message']=$lang['member']['form_registration_validation_merge_1'];
				
				# we delete the registration				
				$sql_delete=sql_replace($sql['member']['sup_member'],$var);
				sql_query($sql_delete);

				# we send the email so that the member could activate his account
				if($_POST['valid']==-2 AND MAIL==1 AND REGISTRATION_MAIL==1) {
					//$var['link_activation']; # already define
					$var['firstname']=$member_firstname;
					$var['site_title']=SITE_TITLE;
					$var['site_url']=ROOT_URL;
					$var['sender_email']=SENDER_EMAIL;
					$var['sender_name']=SENDER_NAME;
					
					$subject=$lang['member']['mail_activation_subject'];
					$message=text_replace($lang['member']['mail_activation_message'],$var);
					$to=$member_email;
					
					if(send_mail(SITE_TITLE, SENDER_EMAIL, $to, $subject, $message, 'text/plain')) {
						$page['L_message'].=" ".$lang['member']['mail_activation_sent'];
					}
					else {
						$page['erreur'][$nb_erreur]['message']=$lang['member']['E_mail_activation_sent'];
						$nb_erreur++;
					}								
				}
			}
			else { 
				$page['L_message']=$lang['member']['form_registration_validation_0'];
			}
			sql_close($sgbd);		
		}
		elseif($_POST['action']=='refuse')
		{
			# we refuse the registration and block the account
			$_POST['valid']=0;
			$_POST['status']=-1;
			$sql_edit=sql_replace($sql['member']['edit_member_registration'],$_POST);   
			$sgbd = sql_connect();
			$execution=sql_query($sql_edit);			
			if($execution) { $page['L_message']=$lang['member']['form_registration_validation_refuse_1']; }
			else { $page['L_message']=$lang['member']['form_registration_validation_0']; }
			sql_close($sgbd);			
		}
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
		if(isset($_POST['status'])) $page['value_status']=$_POST['status'];
		if(isset($_POST['valid'])) $page['value_valid']=$_POST['valid'];
		if(isset($_POST['member'])) $page['value_member']=$_POST['member'];
		if(isset($_POST['date_registration'])) $page['value_date_registration']=$_POST['date_registration'];
		if(isset($_POST['action'])) $page['value_action']=$_POST['action'];				
	}
}


# if the ID is known, we get the datas to show them in the form
if(isset($page['value_id']) AND $page['value_id']!="" AND ($nb_erreur==0))
{
 # we get the item information
 $var['id']=$page['value_id'];
 $sql_details=sql_replace($sql['member']['select_member_details'],$var);

 $sgbd = sql_connect();
 $res = sql_query($sql_details);
 $ligne = sql_fetch_array($res);
 sql_free_result($res);
 sql_close($sgbd);

 $page['value_id']=$ligne['member_id'];
 $page['value_name']=$ligne['member_lastname'];
 $page['value_firstname']=$ligne['member_firstname'];
 $page['value_email']=$ligne['member_email'];
 $page['value_date_birth']=convert_date($ligne['member_date_birth'],$lang['member']['format_date_form']); 
 $page['value_sex']=$ligne['sex_id'];
 $page['value_login']=$ligne['member_login'];
 $page['value_description']=$ligne['member_description'];
 $page['value_avatar']=$ligne['member_avatar'];
 $page['value_status']=$ligne['member_status'];
 $page['value_date_registration']=$ligne['member_date_registration'];
 $page['value_valid']=$ligne['member_valid'];
 
 if($page['value_valid']==-1) {
 	$page['show_form']=1;
 }
 elseif($page['value_valid']==-2) {
 	$page['L_message']=$lang['member']['valid_-2'];
 }
 elseif($page['value_valid']==1) {
 	$page['erreur'][$nb_erreur]['message']=$lang['member']['E_registration_validation'];
	$page['L_message']=$lang['member']['valid_1'];
 }
 elseif($page['value_valid']==0) {
	$page['erreur'][$nb_erreur]['message']=$lang['member']['E_registration_validation'];
	$page['L_message']=$lang['member']['valid_0'];
 }
}


# sexs list
if($page['show_form']==1) {
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


	# member list
	$var['condition']="WHERE member_valid!='-1'";
	$var['order']="ORDER BY member_lastname ASC";
	$var['limit']=" ";
	
	$sql_member=sql_replace($sql['member']['select_member_condition'],$var);
	
	$sgbd = sql_connect();
	$res_member = sql_query($sql_member);
	$nb_ligne=sql_num_rows($res_member);
	if($nb_ligne!="0")
	{
	 $i="0";
	 while($ligne = sql_fetch_array($res_member))
	 {
	  $page['member'][$i]['id']=$ligne['member_id'];
	  $page['member'][$i]['firstname']=$ligne['member_firstname'];
	  $page['member'][$i]['lastname']=$ligne['member_lastname'];
	  $page['member'][$i]['email']=$ligne['member_email'];
	  
	  if(isset($page['value_member']) AND $page['value_member']==$ligne['member_id']) { $page['member'][$i]['selected']="selected"; } else { $page['member'][$i]['selected']=""; }
	  $i++;
	 }
	}
	sql_free_result($res_member);
	sql_close($sgbd);
}

if(!empty($page['value_date_registration'])) {
	$page['value_date_registration']=convert_date($page['value_date_registration'],$lang['member']['format_date_php']);
}

# action
switch($page['value_action']) {
	case 'add' : $page['checked_add']='checked="checked"'; break;
	case 'merge' : $page['checked_merge']='checked="checked"'; break;
	case 'refuse' : $page['checked_refuse']='checked="checked"'; break;		
}

# links
$page['link_list']=convert_url("index.php?r=".$lang['general']['idurl_member']."&v1=registration_list");
$page['link_view_member']=convert_url("index.php?r=".$lang['general']['idurl_member']."&v1=view&v2=",0);

$page['link_choose_avatar']=convert_url("index.php?r=".$lang['general']['idurl_file']."&v1=image_manager&parent_form=form_registration_validation&field_name=avatar&file_type=image&fen=pop&folder=".AVATAR_FOLDER,0);

# text
$page['L_title']=$lang['member']['form_registration_validation'];

$page['L_valider']=$lang['member']['submit'];
$page['L_delete']=$lang['member']['delete'];
$page['L_back_list']=$lang['member']['back_registration_list'];
$page['L_erreur']=$lang['general']['E_erreur'];
$page['L_field_required']=$lang['general']['field_required'];

$page['L_date_registration']=$lang['member']['date_registration'];

$page['L_name']=$lang['member']['name'];
$page['L_firstname']=$lang['member']['firstname'];
$page['L_date_birth']=$lang['member']['date_birth'];
$page['L_email']=$lang['member']['email'];
$page['L_sex']=$lang['member']['sex'];

$page['L_login']=$lang['member']['login'];
$page['L_description']=$lang['member']['description'];
$page['L_avatar']=$lang['member']['avatar'];
$page['L_choose_image']=$lang['member']['choose_image'];
$page['L_pass']=$lang['member']['pass'];
$page['L_explication_pass']=$lang['member']['explication_pass'];
$page['L_confirm_pass']=$lang['member']['confirm_pass'];

$page['L_choose_member']=$lang['member']['choose_member'];
$page['L_view_member']=$lang['member']['view_member'];

$page['L_action']=$lang['member']['action'];
$page['L_valid_registration']=$lang['member']['valid_registration'];
$page['L_add_registration']=$lang['member']['add_registration'];
$page['L_merge_registration']=$lang['member']['merge_registration'];
$page['L_refuse_registration']=$lang['member']['refuse_registration'];
$page['L_add_registration_info']=$lang['member']['add_registration_info'];
$page['L_merge_registration_info']=$lang['member']['merge_registration_info'];
$page['L_refuse_registration_info']=$lang['member']['refuse_registration_info'];

$page['L_yes']=$lang['general']['yes'];
$page['L_no']=$lang['general']['no'];

$page['L_comment']=$lang['member']['comment'];
$page['L_format_date']=$lang['member']['format_date'];

$page['meta_title']=$page['L_title'];
$page['template']=$tpl['member']['registration_validation'];
?>