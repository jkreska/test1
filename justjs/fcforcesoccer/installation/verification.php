<?php
# installation : verification
$nb_erreur="0";
$page['erreur']=array();
$page['form_action']="index.php?lg=".LANG."&r=verification";
$page['link_retour']="index.php?lg=".LANG."&r=licence";


if(isset($_POST) AND !empty($_POST))
{
  header("location:index.php?lg=".LANG."&r=step1");
  exit();
}
 
 
# we verify that the configuration of PHP is compatible
# php version
$page['php_version']=phpversion();
$page['php_version_class']='ok';
if($page['php_version'] < 4.1) { 
	$page['php_version_class']='pbm';
}

# disable functions
$page['disable_functions_class']='ok';
$disable_functions=ini_get('disable_functions');
if(preg_match_all('`mail|fopen|fputs|fclose|exec|chmod`',$disable_functions,$matches)) { 
	if(!empty($matches)) {	
		$page['disable_functions']=implode(', ',$matches[0]);
		$page['disable_functions_class']='pbm';
	}
	else { 
		$page['disable_functions']=$lang['installation']['no_disable_functions'];
	}
}
else { 
	$page['disable_functions']=$lang['installation']['no_disable_functions'];
}

# file uploads
$page['file_uploads_class']='ok';
$page['file_uploads']=ini_get('file_uploads');
if($page['file_uploads']!='1' AND $page['file_uploads']!='on' AND $page['file_uploads']!='On' AND $page['file_uploads']!='ON') { 
	$page['file_uploads_class']='pbm';
}

# mysql
$page['mysql_class']='ok';
if(!function_exists('mysql_connect')) { 
	$page['mysql']=$lang['installation']['no'];
	$page['mysql_class']='pbm';
}
else {
	$page['mysql']=$lang['installation']['yes'];
}

# we verify the permissions on the different folder
$page['upload_folder_class']='ok';
if (@is_writable('../upload/')) { 
	$page['upload_folder']=$lang['installation']['writable'];
}
else { 
	$page['upload_folder']=$lang['installation']['no_permission'];
	$page['upload_folder_class']='pbm';
}

$page['include_folder_class']='ok';
if (@is_writable('../include/')) { 
	$page['include_folder']=$lang['installation']['writable'];
}
else { 
	$page['include_folder']=$lang['installation']['no_permission'];
	$page['include_folder_class']='pbm';
}

	

# text
$page['L_installation']=$lang['installation']['installation'];
$page['L_verification']=$lang['installation']['verification'];
$page['L_verification_info']=$lang['installation']['verification_info'];

$page['L_php_configuration']=$lang['installation']['php_configuration'];
$page['L_php_version']=$lang['installation']['php_version'];
$page['L_php_version_info']=$lang['installation']['php_version_info'];
$page['L_disable_functions']=$lang['installation']['disable_functions'];
$page['L_disable_functions_info']=$lang['installation']['disable_functions_info'];
$page['L_file_uploads']=$lang['installation']['file_uploads'];
$page['L_file_uploads_info']=$lang['installation']['file_uploads_info'];
$page['L_mysql']=$lang['installation']['mysql'];
$page['L_mysql_info']=$lang['installation']['mysql_info'];



$page['L_folder_permission']=$lang['installation']['folder_permission'];
$page['L_include_folder_info']=$lang['installation']['include_folder_info'];
$page['L_upload_folder_info']=$lang['installation']['upload_folder_info'];

$page['L_erreur']=$lang['installation']['erreur'];
$page['L_continue']=$lang['installation']['continue'];
$page['L_retour']=$lang['installation']['back'];

$page['template']="tpl/verification.html";

?>