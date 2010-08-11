<?php
# we define the rights available for member
include_once(create_path("member/lg_member_".LANG.".php"));

$right['member']=array(
array('id'=>'view_member','name'=>$lang['member']['view_member'],'default'=>1),
array('id'=>'member_list','name'=>$lang['member']['member_list'],'default'=>1),
array('id'=>'member_job_list','name'=>$lang['member']['member_job_list'],'default'=>1),
array('id'=>'referee_list','name'=>$lang['member']['referee_list'],'default'=>1),
array('id'=>'add_member','name'=>$lang['member']['add_member'],'default'=>0),
array('id'=>'edit_member','name'=>$lang['member']['edit_member'],'default'=>0),
array('id'=>'delete_member','name'=>$lang['member']['delete_member'],'default'=>0),
array('id'=>'import_member','name'=>$lang['member']['import_member'],'default'=>0),
array('id'=>'registration','name'=>$lang['member']['registration'],'default'=>1),
array('id'=>'forgot_pass','name'=>$lang['member']['forgot_pass'],'default'=>0),
array('id'=>'home_member','name'=>$lang['member']['home_member'],'default'=>0),
array('id'=>'profile','name'=>$lang['member']['profile'],'default'=>0),
array('id'=>'registration_list','name'=>$lang['member']['registration_list'],'default'=>0),
array('id'=>'registration_validation','name'=>$lang['member']['form_registration_validation'],'default'=>0),
array('id'=>'country_list','name'=>$lang['member']['country_list'],'default'=>0),
array('id'=>'job_list','name'=>$lang['member']['job_list'],'default'=>0),
array('id'=>'level_list','name'=>$lang['member']['level_list'],'default'=>0),
array('id'=>'sex_list','name'=>$lang['member']['sex_list'],'default'=>0),
array('id'=>'group_list','name'=>$lang['member']['group_list'],'default'=>0)
);

?>