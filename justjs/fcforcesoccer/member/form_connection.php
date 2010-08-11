<?php

$index['form_action']="";
$form_invalid=0;          
$index['erreur']=array();
$index['L_message']="";


/***************************/
/* FORMULAIRE DE CONNEXION */
/***************************/
$index['form_connection']="1";
$index['login']="";

# links
$index['link_forgot_pass']=convert_url("index.php?r=".$lang['general']['idurl_member']."&v1=forgot_pass");
$index['form_connection_action']=convert_url("index.php?r=".$lang['general']['idurl_member']."&v1=login",0);

if(REGISTRATION==1) {
	$index['link_registration']=convert_url("index.php?r=".$lang['general']['idurl_member']."&v1=registration");
}
else {
	$index['link_registration']='';
}

if(MAIL!=1 OR REGISTRATION!=1 OR REGISTRATION_MAIL!=1) {
	$index['link_forgot_pass']='';
}

# text
$index['L_form_connection']=$lang['general']['form_connection'];
$index['L_register']=$lang['general']['sign_up'];
$index['L_forgot_pass']=$lang['general']['forgot_pass'];
$index['L_login']=$lang['general']['login'];
$index['L_pass']=$lang['general']['pass'];
$index['L_auto_connection']=$lang['general']['auto_connection'];
$index['value_connecter']=$lang['general']['connection'];

?>