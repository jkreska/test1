<?php
/*******************************************************************/
/* ADMINISTRATION */
/*******************************************************************/

#################################
# administration
#################################
# divers
$lang['administration']['administration']='Administration';
$lang['administration']['administration_zone']='Administration zone';
$lang['administration']['parametre']='Configuration';
$lang['administration']['home_administration']='Dashboard';
$lang['administration']['welcome']='Welcome to the administration zone. You can now manage all the website\'s datas (matches, news, members, etc.) with the different forms accessible from the administration menu.
This dashboard tells you what you need to do : add the score if a match is over, items to update, etc... So come here regularly !';
$lang['administration']['configuration']='Website configuration';
$lang['administration']['configuration_text']='The website configuration is apparently not over. Please check that all needed information have been entered : ';
$lang['administration']['change_configuration']='Change the website configuration';
$lang['administration']['end_installation']='Warning, for security reasons you need to delete the installation folder to make the website work properly. One deleted, just refresh this page.';
$lang['administration']['update']='An update is processing.';
$lang['administration']['mettre_a_day']='Begin the update';

# configuration
$lang['administration']['information_site']='Website information';
$lang['administration']['information_site_ab']='Site';
$lang['administration']['title']='Website title';
$lang['administration']['url']='Web address (url)';
$lang['administration']['root']='Root path';
$lang['administration']['information_mail']='Emails utilisation';
$lang['administration']['information_mail_ab']='Emails';
$lang['administration']['email']='Webmaster email';
$lang['administration']['sender_name']='Emails signature';
$lang['administration']['activate_mail']='Allow email sending';
$lang['administration']['activate_mail_info']='The site will be able to send emails to member, for example during the  registration process. The mail() function of your server must be enable.';
$lang['administration']['information_base']='Server and database information';
$lang['administration']['information_base_ab']='Database';
$lang['administration']['host']='Host';
$lang['administration']['user']='User name';
$lang['administration']['password']='Password';
$lang['administration']['base']='Database name';
$lang['administration']['prefix']='Tablenames prefix';
$lang['administration']['information_sport']='Sport information';
$lang['administration']['information_sport_ab']='Sport';
$lang['administration']['nb_player']='Maximum number of player in a team';
$lang['administration']['info_url']='no / at the end';
$lang['administration']['url_rewrite']='Activate url rewriting'; 
$lang['administration']['info_url_rewrite']='Simplified URL (URL rewriting) lake long url user friendly. For example, the url http://www.mysite.com/index.php?lg=en&r=news&v1=page1 will become  http://www.mysite.com/en/news/page1.html. Apache rewrite mod must be on.';
$lang['administration']['website_status']='Website status'; 
$lang['administration']['site_open']='The website is open';
$lang['administration']['site_closed']='The website is in construction. It is close to visitors and only the webmaster is allowed to access the member section.';
$lang['administration']['language']='Language';
$lang['administration']['template']='Design';
$lang['administration']['avatar_folder']='Avatars directory';
$lang['administration']['info_avatar_folder']='Select the folder where users could choose an avatar (An avatar is a graphical representation of an Internet user). If the directory has sub-directory, users will then be able to open them.';

$lang['administration']['example']='Ex.';
$lang['administration']['example_title']='My sport club';
$lang['administration']['example_url']='http://www.mysite.com';
$lang['administration']['example_email']='contact@mysite.com';
$lang['administration']['example_sender_name']='Webmaster of My sport club ';
$lang['administration']['example_root']='/var/www/mysite';
$lang['administration']['example_user']='root';
$lang['administration']['example_host']='localhost';
$lang['administration']['example_base']='mybase';

$lang['administration']['configuration_ok']='Item successfully modified';

# configuration mini-standings
$lang['administration']['mini_standings']='Mini standings';
$lang['administration']['mini_standings_ab']='Mini standings';
$lang['administration']['ms_show']='Show mini standings';
$lang['administration']['ms_show_all']='On every page';
$lang['administration']['ms_show_home']='On the home page';
$lang['administration']['ms_show_none']='Do not show';
$lang['administration']['ms_column']='Column to display';
$lang['administration']['ms_default_competition']='Default competition';
$lang['administration']['ms_nb_club_max']='maximum number of clubs';
$lang['administration']['ms_show_form']='Let users choose';

# content settings
$lang['administration']['content_settings']='Content settings';
$lang['administration']['content_settings_ab']='Content';
$lang['administration']['nb_item_page']='Number of items per page';
$lang['administration']['nb_item_home_page']='Number of items on the home page';
$lang['administration']['E_empty_content_settings']='Warning, some fields of content settings are empty';
$lang['administration']['E_invalid_content_settings_integer']='Warning, some fields of content settings are not numbers';
$lang['administration']['E_invalid_content_settings_range']='Warning, fields of content settings must have a value between 1 and 100';

# Registration
$lang['administration']['registration']='Members registration';
$lang['administration']['registration_ab']='Registration';
$lang['administration']['activate_registration']='Activate registrations';
$lang['administration']['activate_registration_info']='A link "Register" will be displayed on the site. Registrations will be activated after the verification of the webmaster';
$lang['administration']['registration_mail']='Activate registration emails sending';
$lang['administration']['registration_mail_info']='During the registration proces, members will receive an email with their login and password. When the registration will be validated by the webmaster, members will received a confirmation by email.';

# error
$lang['administration']['E_creation_conf']='An error occurs while editing the parameters';

$lang['administration']['E_empty_title']='Please enter a title';
$lang['administration']['E_empty_url']='Please enter the website address (url)';
$lang['administration']['E_invalid_url']='The url is invalid. Please check that your website is available at this address';
$lang['administration']['E_empty_root']='Please enter the root path';
$lang['administration']['E_invalid_root']='The root path is invalid. Please check that your website files are present in the indicated forder';
$lang['administration']['E_invalid_email']='The email address is invalid';
$lang['administration']['E_empty_host']='Please enter a host name';
$lang['administration']['E_empty_user_base']='Please enter a database user name';
$lang['administration']['E_empty_name_base']='Please enter a database name';
$lang['administration']['E_invalid_connection_base']='The connection to MySQL server failed. Please check your information';
$lang['administration']['E_invalid_selection_base']='The selection of database failed. Please check your database name';
$lang['administration']['E_disable_mail']='The mail() function of your server is disable. You are not able to activate email sending.';
$lang['administration']['E_invalid_registration_mail']='To activate emails sending during the registration process, the emails sending option must be checked in the email configuration.';
$lang['administration']['E_invalid_sender_name']='If you wan\'t to allow emails sending, please enter an email address and a signature.';

# plugin 
$lang['administration']['plugin']='Plugin';
$lang['administration']['plugin_list']='Plugins';
$lang['administration']['plugin_to_install']='Certains plugins n\'ont pas encore été installé';
$lang['administration']['plugin_install']='installer ce plugin';
$lang['administration']['plugin_management']='Gestion des plugins';  // new 1.4

# menu management // new 1.4
$lang['administration']['menu_management']='Menu Management';
$lang['administration']['website_menu']='Website menu';
$lang['administration']['available_pages']='Availables pages';
$lang['administration']['default_pages']='Pages list';
$lang['administration']['internal_pages']='Internal pages';
$lang['administration']['external_pages']='External links';
$lang['administration']['page_title']='Title';
$lang['administration']['page_url']='URL';
$lang['administration']['page_target']='Target';
$lang['administration']['page_css']="CSS class";
$lang['administration']['new_window']='New window';
$lang['administration']['same_window']='Same window';
$lang['administration']['add_page']='Add';
$lang['administration']['E_no_title']='Please fill in the fields';

$lang['administration']['menu_management_info']='To add a page in the menu, select a page in the Available pages\' list and drag it to the menu. To delete a page of the menu, drag it to the Available pages\' list. Do not forget to save the menu once done.';

$lang['administration']['reset_menu']='Reset (default menu)';
$lang['administration']['save']='Save';
$lang['administration']['cancel']='Cancel';
$lang['administration']['delete']='Delete';

# right management // new 1.4
$lang['administration']['right_management']='Users Right Management';  // new 1.4
$lang['administration']['right']='Right';  // new 1.4
$lang['administration']['group_list']='Manage groups'; // new 1.4


#################################
# commun
#################################
# divers
$lang['administration']['erreur']='Warning there is an/some error(s)';
$lang['administration']['submit']='Submit';
$lang['administration']['yes']='Yes';
$lang['administration']['no']='No';

?>