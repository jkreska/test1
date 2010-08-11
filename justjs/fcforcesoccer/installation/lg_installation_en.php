<?php

# commun
$lang['installation']['installation']='Installation';
$lang['installation']['step']='Step';
$lang['installation']['submit']='Submit';
$lang['installation']['continue']='Continue >>';
$lang['installation']['back']='<< Back';
$lang['installation']['try_again']='Try again';
$lang['installation']['ignore']='Pass';
$lang['installation']['connecter']='Sign in';
$lang['installation']['connection']='Access to the website management';
$lang['installation']['erreur']='Warning, there is some errors';

# message
$lang['installation']['message']='Message';
$lang['installation']['error_folder']='Warning, for security reasons you need to delete the installation folder to make the website work properly. Once deleted, <a href="{root_url}">click here to open your website</a>';

# welcome
$lang['installation']['welcome']='Welcome';
$lang['installation']['welcome_text']='<p>Welcome and thank you for choosing phpMySport !</p>
<p>PhpMySport is a content management system that allows you to easily create and manage a website for your team club. These are the main functionnalities :</p>
<ul>
<li>Members, players, coachs management</li>
<li>Clubs and teams management</li>
<li>Team composition management</li>
<li>Matchs, calendar and players actions management</li>
<li>Competitions et des seasons management</li>
<li>Presentation pages management</li>
<li>News section</li>
<li>Forum</li>
</ul>';

$lang['installation']['reglement']='Licence';
$lang['installation']['text_reglement']='PhpMySport is an open source software under GNU/GPL licence';
$lang['installation']['start_installation']='Start installation >>';

# verification
$lang['installation']['verification']='Parameters verification';
$lang['installation']['verification_info']='The following parameters are required for a correct installation and utilisation of phpMySport. If some of them appear in red, please perform the appropriate modifications otherwise the application may not work properly.';
$lang['installation']['php_configuration']='PHP configuration';
$lang['installation']['php_version']='PHP version';
$lang['installation']['php_version_info']='Your PHP version must be superior to 4.1.0';
$lang['installation']['file_uploads']='File Uploads';
$lang['installation']['file_uploads_info']='Without File Uploads turned on, you won\'t be able to use the file/image manager nor the importation assistants.';
$lang['installation']['disable_functions']='Disable functions';
$lang['installation']['no_disable_functions']='None';
$lang['installation']['disable_functions_info']='Functions fopen(), fputs(), fclose() and chmod() are required to create the configuration file. Function mail() is required if you want to allow email sending. Function exec() is used for matches statistics calculation.';
$lang['installation']['mysql']='MySQL';
$lang['installation']['mysql_info']='Functions to connect to a MySQL database are required.';

$lang['installation']['folder_permission']='Directories permissions';
$lang['installation']['include_folder_info']='The include/ directory is used during the creation of the configuration file. It must be readable and writable.';
$lang['installation']['upload_folder_info']='The upload/ directory is used for the upload of files and images. It must be readable and writable.';
$lang['installation']['writable']='Writable';
$lang['installation']['no_permission']='Unwritable';

# step1
$lang['installation']['mode']='Installation type';
$lang['installation']['mode_club']='I want to install phpMySport for my sport club';
$lang['installation']['mode_comite']='I want to install phpMySport for a sport league or committee';
$lang['installation']['club_name']='Club name';



$lang['installation']['E_empty_mode']='Please choose an installation type';
$lang['installation']['E_empty_club_name']='Please choose a club name';
$lang['installation']['E_empty_sport']='Please choose a sport';

# step2
$lang['installation']['information_site']='Website information';
$lang['installation']['title']='Website title';
$lang['installation']['url']='Web address (url)';
$lang['installation']['root']='Root';
$lang['installation']['email']='Webmaster email';
$lang['installation']['information_base']='Server and database information';
$lang['installation']['host']='Host';
$lang['installation']['user']='User';
$lang['installation']['password']='Password';
$lang['installation']['base']='Base name';
$lang['installation']['prefix']='Tablenames prefix';
$lang['installation']['information_admin']='Website manager information';
$lang['installation']['login']='Login';
$lang['installation']['name']='Last name';
$lang['installation']['firstname']='First name';
$lang['installation']['confirmation']='Confirmation';
$lang['installation']['info_url']='no / at the end';
$lang['installation']['url_rewrite']='Set simplified URL'; 
$lang['installation']['info_url_rewrite']='Simplified URL (URL rewriting) make long url user friendly. For example, the url http://www.mysite.com/index.php?lg=en&r=news&v1=page1 will become  http://www.mysite.com/en/news/page1.html. Apache rewrite mod must be on.';
$lang['installation']['example']='Ex.';
$lang['installation']['example_title']='My sport club';
$lang['installation']['example_url']='http://www.mysite.com';
$lang['installation']['example_email']='contact@mysite.com';
$lang['installation']['example_root']='/var/www/mysite';
$lang['installation']['example_user']='root';
$lang['installation']['example_host']='localhost';
$lang['installation']['example_base']='mybase';
$lang['installation']['example_prefix']='"pms_" ou laisser vide';

$lang['installation']['E_empty_title']='Please enter a title';
$lang['installation']['E_empty_url']='Please enter the website url';
$lang['installation']['E_invalid_url']='The url is invalid. Please check that you can access your website at this adress';
$lang['installation']['E_empty_root']='Please enter the root';
$lang['installation']['E_invalid_root']='the root is invalid. Please check that your website files are in the indicated folder';
$lang['installation']['E_invalid_email']='The email address is invalid';
$lang['installation']['E_empty_host']='Please enter a host name';
$lang['installation']['E_empty_user_base']='Please enter a user name for the database';
$lang['installation']['E_empty_name_base']='Please enter a database name';
$lang['installation']['E_empty_user_admin']='Please enter a login';
$lang['installation']['E_empty_pass_admin']='Please enter a password for the webmaster';
$lang['installation']['E_empty_pass_2_admin']='Please confrm the password for the webmaster';
$lang['installation']['E_invalid_pass_admin']='Passwords are differents';
$lang['installation']['E_invalid_connection_base']='It is impossible to connect to MySQL server. Please check the information you entered';

# step3
$lang['installation']['create_base']='Database "{name_base}" does not exist. Do you want to create it ?';
$lang['installation']['creation_base_ok']='Database successfully created';
$lang['installation']['base_found']='Database "{name_base}" has been found';
$lang['installation']['delete_table']='{nb_table} table(s) was/were found. Do you want to delete it/them ?';
$lang['installation']['suppression_table_ok']='Existing tables were successfully deleted';
$lang['installation']['creation_table_ok']='{nb_table_ok} table(s) was/were successfully created';
$lang['installation']['creation_tables_ok']='All tables were successfully created';
$lang['installation']['creation_user_ok']='Webmaster successfully created';
$lang['installation']['creation_club_ok']='Club successfully created';
$lang['installation']['creation_conf_ok']='Configuration file successfully created';
$lang['installation']['insertion_data_ok']='Data insertion successfully done';
$lang['installation']['creation_htaccess_ok']='.htaccess file for url rewriting successfully created';
$lang['installation']['yes']='Yes';
$lang['installation']['no']='No';

$lang['installation']['installation_terminee']='Installation is now finished. For security reasons you need to delete the installation folder to make the website work properly. Once deleted, go to the administration space to end up the website configuration. You can connect using this form and login/password choosen during the installation.';

$lang['installation']['E_creation_base']='An error occurs while creating database';
$lang['installation']['E_suppression_table']='An error occurs while deleting tables';
$lang['installation']['E_creation_table']='An error occurs while creating tables. {nb_table_pbm} was/were not created. Please checked if it/they already exist(s)';
$lang['installation']['E_creation_user']='An error occurs while creating webmaster';
$lang['installation']['E_creation_club']='An error occurs while creating club';
$lang['installation']['E_creation_conf']='An error occurs while creating configuration file. Please check rights (chmod) on your files';
$lang['installation']['E_insertion_data']='An error occurs while insering datas. Please check if they already exist';
$lang['installation']['E_creation_htaccess']='An error occurs while creating .htaccess file. Please check rights (chmod) on your files';

# update
$lang['installation']['update']='Update';
$lang['installation']['available_update']='Available updates';
$lang['installation']['no_update']='No update available';
$lang['installation']['update_database_ok']='Database successfully updated';
$lang['installation']['E_update_database']='An error occurs while updating the database';
$lang['installation']['update_conf_ok']='Configuration file successfully updated';
$lang['installation']['E_update_conf']='An error occurs while updating the configuration file';
$lang['installation']['update_ok']='The update is now finished. For security reasons, you need to delete the installation folder. Then, <a href="{root_url}">click here to open your website</a>. ';


# sport
$lang['installation']['sport']='Sport';
$lang['installation']['other_sport']='Other team sport';
$lang['installation']['football']='Soccer';
$lang['installation']['basket']='Basketball';
$lang['installation']['rugby']='Rugby';
$lang['installation']['handball']='Handball';
$lang['installation']['nb_player_other_sport']='10';
$lang['installation']['nb_player_football']='11';
$lang['installation']['nb_player_basket']='5';
$lang['installation']['nb_player_rugby']='15';
$lang['installation']['nb_player_handball']='7';

# action
$lang['installation']['but']='Goal';
$lang['installation']['carton_rouge']='Red card';
$lang['installation']['carton_jaune']='Yellow card';

$lang['installation']['essai']='Try';
$lang['installation']['transformation']='Conversion';
$lang['installation']['penalite']='Penalty';
$lang['installation']['drop']='Drop';

$lang['installation']['tir_2_points']='2 points shot';
$lang['installation']['tir_3_points']='3 points shot';
$lang['installation']['lancer_francs']='Free throw';
$lang['installation']['rebond']='Bouncing';
$lang['installation']['passe']='Decisive pass';
$lang['installation']['interception']='Interception';
$lang['installation']['contre']='Block';

# field_state
$lang['installation']['terrain_boueux']='Muddy field';
$lang['installation']['terrain_sec']='Dry field';

$lang['installation']['parquet']='Wooden court';
$lang['installation']['goudron']='Bitumen court';
# position
$lang['installation']['president']='President';
$lang['installation']['secretaire']='Secretary';
$lang['installation']['tresorier']='Treasurer';
$lang['installation']['president_adjoint']='Vice president';
# weather
$lang['installation']['temps_sec']='Sunny';
$lang['installation']['pluie']='Rain';
$lang['installation']['neige']='Snow';
$lang['installation']['temps_nuageux']='Cloudy';
# level
$lang['installation']['departemental']='Level 3';
$lang['installation']['regional']='Level 2';
$lang['installation']['national']='Level 1';
$lang['installation']['international']='International';
# team_name
$lang['installation']['poussin']='Under 10';
$lang['installation']['benjamin']='Under 12';
$lang['installation']['minime']='Under 14';
$lang['installation']['cadet']='Under 16';
$lang['installation']['junior']='Under 18';
$lang['installation']['senior1']='Adult 1';
$lang['installation']['senior2']='Adult 2';
$lang['installation']['senior3']='Adult 3';
# country
$lang['installation']['france']='France';
$lang['installation']['germany']='Germany';
$lang['installation']['england']='England';
$lang['installation']['spain']='Spain';
$lang['installation']['italy']='Italy';
# period
$lang['installation']['mi_temps1']='1st halftime';
$lang['installation']['mi_temps2']='2nd halftime';
$lang['installation']['prolongation1']='1st extra time';
$lang['installation']['prolongation2']='2nd extra time';
$lang['installation']['tir_penalty']='Penalty shootouts';

$lang['installation']['quart_temps1']='1st quarter';
$lang['installation']['quart_temps2']='2nd quarter';
$lang['installation']['quart_temps3']='3rd quarter';
$lang['installation']['quart_temps4']='4th quarter';

# position
$lang['installation']['gardien']='Gaolkeeper';
$lang['installation']['attaquant']='Forward';
$lang['installation']['mifield']='Midfielder';
$lang['installation']['defenseur']='Defenders';

$lang['installation']['pilier']='Prop';
$lang['installation']['talonneur']='Hooker';
$lang['installation']['deuxieme_ligne']='Second line';
$lang['installation']['troisieme_ligne']='Third line';
$lang['installation']['demi_melee']='Scrum half';
$lang['installation']['demi_ouverture']='Fly half';
$lang['installation']['centre']='Center';
$lang['installation']['ailier']='Wing';
$lang['installation']['arriere']='Fullback';

$lang['installation']['pivot']='Shooting guard';
$lang['installation']['petit_ailier']='Small forward';
$lang['installation']['ailier_fort']='Power forward';
$lang['installation']['meneur']='Point guard';

# sex
$lang['installation']['masculin']='Men';
$lang['installation']['feminin']='Women';


# stats
$lang['installation']['play']='Matches played';
$lang['installation']['play_ab']='P';
$lang['installation']['win']='Win';
$lang['installation']['win_ab']='W';
$lang['installation']['percent_win']='Win percentage';
$lang['installation']['percent_win_ab']='%W';
$lang['installation']['tie']='Tie';
$lang['installation']['tie_ab']='T';
$lang['installation']['percent_tie']='Tie percentage';
$lang['installation']['percent_tie_ab']='%T';
$lang['installation']['defeat']='Defeat';
$lang['installation']['defeat_ab']='D';
$lang['installation']['percent_defeat']='Defeat percentage';
$lang['installation']['percent_defeat_ab']='%D';
$lang['installation']['point_for']='Point for';
$lang['installation']['point_for_ab']='PF';
$lang['installation']['point_against']='Point against';
$lang['installation']['point_against_ab']='PA';
$lang['installation']['goal_average']='Goal Average';
$lang['installation']['goal_average_ab']='GA';

# stats_player
$lang['installation']['goal']='Goals';
$lang['installation']['goal_ab']='G';
$lang['installation']['goal_stop']='Goals stop';
$lang['installation']['goal_stop_ab']='S';
$lang['installation']['decisive_pass']='Decisives passes';
$lang['installation']['decisive_pass_ab']='DP';
$lang['installation']['ball_win']='Balls win';
$lang['installation']['ball_win_ab']='BW';
$lang['installation']['ball_lose']='Balls lose';
$lang['installation']['ball_lose_ab']='BL';
$lang['installation']['yellow_card']='Yellow card';
$lang['installation']['yellow_card_ab']='YC';
$lang['installation']['red_card']='Red card';
$lang['installation']['red_card_ab']='RC';
$lang['installation']['time_play']='Time played';
$lang['installation']['time_play_ab']='TP';

$lang['installation']['try']='Try';
$lang['installation']['try_ab']='T';
$lang['installation']['conversion']='Conversion';
$lang['installation']['conversion_ab']='C';
$lang['installation']['drop']='Drop';
$lang['installation']['drop_ab']='D';
$lang['installation']['penality']='Penality';
$lang['installation']['penality_ab']='P';

$lang['installation']['2_points_try']='2 points shots tried';
$lang['installation']['2_points_try_ab']='2T';
$lang['installation']['2_points_marked']='2 points shots marked';
$lang['installation']['2_points_marked_ab']='2M';
$lang['installation']['percent_2_points']='2 points shots percentage';
$lang['installation']['percent_2_points_ab']='%2';
$lang['installation']['3_points_try']='3 points shots tried';
$lang['installation']['3_points_try_ab']='3T';
$lang['installation']['3_points_marked']='3 points shots marked';
$lang['installation']['3_points_marked_ab']='3M';
$lang['installation']['percent_3_points']='3 points shots percentage';
$lang['installation']['percent_3_points_ab']='%3';
$lang['installation']['free_throw_try']='Free throw tried';
$lang['installation']['free_throw_try_ab']='FTT';
$lang['installation']['free_throw_marked']='Free throw marked';
$lang['installation']['free_throw_marked_ab']='FTM';
$lang['installation']['percent_free_throw']='Free throw percentage';
$lang['installation']['percent_free_throw_ab']='%FT';
$lang['installation']['rebound_off']='Offensive rebounds';
$lang['installation']['rebound_off_ab']='OB';
$lang['installation']['rebound_def']='Defensive rebounds';
$lang['installation']['rebound_def_ab']='DB';
$lang['installation']['interception']='Interceptions';
$lang['installation']['interception_ab']='I';
$lang['installation']['block']='Blocks';
$lang['installation']['block_ab']='B';
$lang['installation']['foul_anti']='Antigame fouls';
$lang['installation']['foul_anti_ab']='AF';
$lang['installation']['foul_tech']='Technical fouls';
$lang['installation']['foul_tech_ab']='TF';
$lang['installation']['foul_exp']='Expulsion';
$lang['installation']['foul_exp_ab']='EX';


?>