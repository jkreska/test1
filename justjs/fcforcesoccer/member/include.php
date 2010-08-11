<?php

include_once(create_path("member/sql_member.php"));
include_once(create_path("member/tpl_member.php"));
include_once(create_path("member/lg_member_".LANG.".php"));


if(!isset($_GET['v1']))
{
 if(isset($_SESSION['session_member_id']) AND $_SESSION['session_member_id']!="")
 {
  include_once(create_path("member/home_member.php"));
 }
 else
 {
  include_once(create_path("member/member_list.php"));
 }
}
else
{
 switch($_GET['v1']) {
 case "form_member" :  include(create_path("member/form_member.php")); break;
 case "view" :  include(create_path("member/view_member.php")); break;
 case "import_member" :  include(create_path("member/import_member.php")); break; 
 case "manager_list" :  include(create_path("member/member_job_list.php")); break;
 case "referee_list" :  include(create_path("member/referee_list.php")); break;
 case "job_list" :  include(create_path("member/job_list.php")); break;
 case "member_list" :  include(create_path("member/member_list.php")); break;
 case "level_list" :  include(create_path("member/level_list.php")); break;
 case "sex_list" :  include(create_path("member/sex_list.php")); break;
 case "country_list" :  include(create_path("member/country_list.php")); break;
 case "group_list" :  include(create_path("member/group_list.php")); break;
 case "search_member" :  include(create_path("member/search_member.php")); break;
 case "view_member" :  include(create_path("member/view_member.php")); break;
 case "select_member" :  include(create_path("member/select_member.php")); break;
 case "form_connection" :  include(create_path("member/form_connection.php"));
   $page=array_merge($index,$page);
   $page['template']=$tpl['member']['form_connection']; 
   $page['L_title']=$lang['general']['form_connection'];
 break; 
 case "registration" :  include(create_path("member/registration.php")); break;
 case "registration_list" :  include(create_path("member/registration_list.php")); break;
 case "registration_validation" :  include(create_path("member/registration_validation.php")); break;
 case "activation" :  include(create_path("member/activation.php")); break;
 case "login" :  include(create_path("member/login.php")); break; 
 case "logout" :  include(create_path("member/logout.php")); break; 
 case "profile" :  include(create_path("member/profile.php")); break; 
 case "forgot_pass" :  include(create_path("member/forgot_pass.php")); break;  
// case "home" :  include_once(create_path("member/home.php")); break;
 case "home_member" :  include_once(create_path("member/home_member.php")); break;
 default : include(create_path("member/member_list.php"));
 }
}

?>