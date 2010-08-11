<?php
$page['member']=array();
$page['L_message']="";

$var['condition']=" WHERE member_valid='-1' ";
$var['order']=' ORDER BY member_date_registration ASC ';
$var['limit']=' ';

$included=1;
include(ROOT.'/member/member_list.php');
unset($included);
$page['registration']=$page['member'];
$page['L_message_registration']=$page['L_message'];
$page['nb_registration']=$page['nb_member'];


# members who need to confirm their registration
$var['condition']=" WHERE member_valid='-2' ";
$var['order']=' ORDER BY member_date_registration ASC ';
$var['limit']=' ';
$included=1;
include(ROOT.'/member/member_list.php');
unset($included);
$page['confirmation']=$page['member'];
$page['L_message_confirmation']=$page['L_message'];
$page['nb_confirmation']=$page['nb_member'];

# link
$page['link_member']=convert_url("index.php?r=".$lang['general']['idurl_member']."&v1=member_list");

# text
$page['L_title']=$lang['member']['registration'];

$page['L_registration_list']=$lang['member']['registration_list'];
$page['L_confirmation_list']=$lang['member']['confirmation_list'];

$page['L_registration_list_info']=$lang['member']['registration_list_info'];

$page['L_name']=$lang['member']['name'];
$page['L_firstname']=$lang['member']['firstname'];
$page['L_sex']=$lang['member']['sex'];
$page['L_date_birth']=$lang['member']['date_birth'];
$page['L_date_registration']=$lang['member']['date_registration'];

# meta
$page['meta_title']=$page['L_title'];

# template
$page['template']=$tpl['member']['registration_list'];

?>