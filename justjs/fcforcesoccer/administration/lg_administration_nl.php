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
$lang['administration']['update']='Une mise à day du site est en cours.';
$lang['administration']['mettre_a_day']='Begin the update';

# configuration
$lang['administration']['information_site']='Website information';
$lang['administration']['information_site_ab']='Site';
$lang['administration']['title']='Website title';
$lang['administration']['url']='Web address (url)';
$lang['administration']['root']='Root path';
$lang['administration']['email']='Webmaster email';
$lang['administration']['information_mail']='E-mail gebruik';
$lang['administration']['information_mail_ab']='E-mail';
$lang['administration']['sender_name']='Email handtekening';
$lang['administration']['activate_mail']='Verzenden e-mail toestaan';
$lang['administration']['activate_mail_info']='De site zal in staat zijn e-mails te verzenden naar leden, bijvoorbeeld tijdens het registratieproces. De mail() functie van uw server moet ingeschakeld zijn.';
$lang['administration']['information_base']='Server and database information';
$lang['administration']['information_base_ab']='Database';
$lang['administration']['host']='Host';
$lang['administration']['user']='User name';
$lang['administration']['password']='Password';
$lang['administration']['base']='Database name';
$lang['administration']['prefix']='Tabelnamen prefix';
$lang['administration']['information_sport']='Sport informatie';
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
$lang['administration']['example_sender_name']='Webmaster van Mijn sport club ';
$lang['administration']['example_root']='/var/www/mysite';
$lang['administration']['example_user']='root';
$lang['administration']['example_host']='localhost';
$lang['administration']['example_base']='mybase';

$lang['administration']['configuration_ok']='Item successfully modified';

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

# plugin 
$lang['administration']['plugin']='Plugin';
$lang['administration']['plugin_list']='Plugins';
$lang['administration']['plugin_to_install']='Some plugins have not yet been installed';
$lang['administration']['plugin_install']='install this plugin';

# configuration mini-standings
$lang['administration']['mini_standings']='Mini standen';
$lang['administration']['mini_standings_ab']='Mini standen';
$lang['administration']['ms_show']='Mini standen weergeven';
$lang['administration']['ms_show_all']='Op iedere pagina';
$lang['administration']['ms_show_home']='Op de beginpagina';
$lang['administration']['ms_show_none']='Niet weergeven';
$lang['administration']['ms_column']='Weergavekolom';
$lang['administration']['ms_default_competition']='Standaard competitie';
$lang['administration']['ms_nb_club_max']='maximum aantal clubs';
$lang['administration']['ms_show_form']='Laat gebruikers kiezen';

# content settings
$lang['administration']['content_settings']='Inhoud instellingen';
$lang['administration']['content_settings_ab']='Inhoud';
$lang['administration']['nb_item_page']='Aantal items per pagina';
$lang['administration']['nb_item_home_page']='Aantal items op de beginpagina';
$lang['administration']['E_empty_content_settings']='Waarschuwing, enkele velden van de inhoud instellingen zijn leeg';
$lang['administration']['E_invalid_content_settings_integer']='Waarschuwing, enkele velden van de inhoud instellingen zijn geen nummers';
$lang['administration']['E_invalid_content_settings_range']='Waarschuwing, velden van de inhoud instellingen moeten een waarde hebben tussen 1 en 100';

# Registration
$lang['administration']['registration']='Ledenregistratie';
$lang['administration']['registration_ab']='Registratie';
$lang['administration']['activate_registration']='Activeer registraties';
$lang['administration']['activate_registration_info']='Een "Register" link zal worden getoond op de site. Registraties zullen worden geactiveerd na goedkeuring van de webmaster';
$lang['administration']['registration_mail']='Activeer registratie e-mail verzending';
$lang['administration']['registration_mail_info']='Tiidens het registratieproces zullen leden een e-mail ontvangen met hun loginnaam en wachtwoord. Wammeer de registratie wordt goedgekeurd door de webmaster, zullen de leden een confirmatie e-mail ontvangen.';
$lang['administration']['E_disable_mail']='The mail() function of your server is disable. You are not able to activate email sending.';
$lang['administration']['E_invalid_registration_mail']='Om e-mailverzending te activeren tijdens het registratieproces dient de e-mail verzend optie te zijn ingeschakeld in de e-mail configuratie.';
$lang['administration']['E_invalid_sender_name']='Wanneer u e-mailverzending wilt toestaan vul dan alstublieft een e-mailadres en handtekening in.';

#################################
# commun
#################################
# divers
$lang['administration']['erreur']='Warning there is an/some error(s)';
$lang['administration']['submit']='Submit';
$lang['administration']['yes']='Yes';
$lang['administration']['no']='No';

?>