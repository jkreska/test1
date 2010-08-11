<?php

/* Déclaration des variables du formulaire */
$form_invalid=0;
$erreur="";
$page['form_action']=convert_url("index.php?r=".$lang['general']['idurl_member']."&v1=member_list");
$value_name="";
$value_firstname="";
$value_year=date("Y",time());
$checked_sex_f="";
$checked_sex_m="";

$value_valider=$lang['member']['submit'];
$value_annuler=$lang['member']['cancel'];

/* declaration des elements constituants de la page */
$page['L_member_lastname']=$lang['member']['name'];
$page['L_member_firstname']=$lang['member']['firstname'];
$page['L_member_sex']=$lang['member']['sex'];
$page['L_member_sex_f']=$lang['member']['sex_f'];
$page['L_member_sex_m']=$lang['member']['sex_m'];
$page['L_member_year']=$lang['member']['year'];

$page['value_year']=$value_year;
$page['value_valider']=$value_valider;
$page['value_annuler']=$value_annuler;

$page['L_member_search_member']= $lang['member']['search_member'];

$page['title']=$lang['member']['search_member'];
$page['template']=$tpl['member']['search_member'];

?>