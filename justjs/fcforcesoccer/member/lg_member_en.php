<?php
/*******************************************************************/
/* MEMBER */
/*******************************************************************/

#################################
# member
#################################
# divers
$lang['member']['member']='Member';
$lang['member']['add_member']='Add a member';
$lang['member']['edit_member']='Edit a member'; // new 1.4
$lang['member']['delete_member']='Delete a member'; // new 1.4
$lang['member']['member_list']='Members list';
$lang['member']['view_member']='Member details';
$lang['member']['search']='Search member';
$lang['member']['back_list']='Back to members list';
$lang['member']['back_registration_list']='Back to registrations list';

$lang['member']['identity']='Identity';
$lang['member']['name']='Last name';
$lang['member']['firstname']='First name';
$lang['member']['email']='Email';
$lang['member']['sex']='Sex';
$lang['member']['choose_sex']='Choose a sex';
$lang['member']['date_birth']='Date of birth';
$lang['member']['place_birth']='Place of birth';
$lang['member']['size']='Height';
$lang['member']['size_unit']='cm';
$lang['member']['weight']='Weight';
$lang['member']['weight_unite']='kg';
$lang['member']['nationality']='Nationality';
$lang['member']['comment']='Comments';
$lang['member']['format_date']='yyyy-mm-dd';
$lang['member']['format_date_php']='%B %d, %Y';
$lang['member']['format_date_form']='%Y-%m-%d';
$lang['member']['age']='Age';
$lang['member']['age_unit']="years old";
$lang['member']['year']='Year';
$lang['member']['choose_member']='Choose a member';
$lang['member']['choose_nationality']='Choose a country';
$lang['member']['info_internaute']='Information about the internet user';

$lang['member']['profile']='My profile';
$lang['member']['information']='My information';
$lang['member']['ancien_pass']='Current password';
$lang['member']['nouveau_pass']='New password';
$lang['member']['login']='Login';
$lang['member']['pass']='Password';
$lang['member']['confirm_pass']='Password (confirmation)';
$lang['member']['explication_pass']='Leave the field empty if you do not want to change the password';
$lang['member']['description']='Description';
$lang['member']['photo']='Picture';
$lang['member']['avatar']='Avatar';
$lang['member']['choose_image']='Choose an image';
$lang['member']['status']='Status';
$lang['member']['choose_status']='Choose a status';
$lang['member']['status_0']='Simple member';
$lang['member']['status_1']='Administrator';
$lang['member']['status_2']='Super administrator';
$lang['member']['status_-1']='Blocked';
$lang['member']['status_member_info']='The member have access to his own member zone';
$lang['member']['status_admin_info']='The member can propose news and add matches';
$lang['member']['status_super_admin_info']='The member has access to the whole management zone';
$lang['member']['status_blocked_info']='The member account is blocked, he can not connect to his member zone';

$lang['member']['valid']='Account status';
$lang['member']['valid_0']='The account is not activated';
$lang['member']['valid_1']='The account is activated';
$lang['member']['valid_-1']='The member asks to activate his account';
$lang['member']['valid_-2']='The member must confirm the activation of his account. He received the activation link by email.';
$lang['member']['activation']='Account activation';
$lang['member']['activation_done']='The account is already activated';
$lang['member']['activation_ok']='Your account has been successfully activated. You can now login to your member zone.';
$lang['member']['activation_pbm']='An error occurs while activating the account. If the problem continues, please contact the webmaster.';
$lang['member']['member_a_activer']='These members ask their account activation';
$lang['member']['confirmation_list']='Validated registration waiting for the member confirmation';

$lang['member']['mail_activation_subject']="Registration confirmation";
$lang['member']['mail_activation_message']='Hi {firstname},

You recently registered for the site "{site_title}" ({site_url}) using this email address. To complete your registration and activate your account, please follow the link below:
{link_activation}
(If clicking doesn\'t work, try copying and pasting it into your browser.)

If you did not register for this site, please disregard this message.
Please contact {sender_email} with any questions.

Thanks,
{sender_name}';

$lang['member']['mail_activation_sent']='The confirmation email has been successfully sent to the member';
$lang['member']['E_mail_activation_sent']='An error occurs while sending the confirmation email. Please check that your server is correctly configured to send mails.';

$lang['member']['referee_list']='Referees list';
$lang['member']['manager_list']='Managers list';
$lang['member']['coach_list']='Coaches list';
$lang['member']['player_list']='Players list';

$lang['member']['show_view']='More';
$lang['member']['team_player']='Played in the following teams';
$lang['member']['team_coach']='Coached the following teams';

$lang['member']['stats']='Statistics';

# import
$lang['member']['import_member']='Import a list of members';
$lang['member']['csv_file']='.csv file';
$lang['member']['separator']='Separator';
$lang['member']['column']='Column';
$lang['member']['file_column']='Column of .csv file';
$lang['member']['associated_field']='Associated field';
$lang['member']['first_line']='The first line contains columns\' names';
$lang['member']['step']='Step';
$lang['member']['choose_field']='Choose a field';

$lang['member']['upload_file']='Upload file';
$lang['member']['associate_field']='Fields association';
$lang['member']['associate_value']='Data association';
$lang['member']['check_data']='Check data before importation';

$lang['member']['upload_file_info']='Choose the file containing the list of members to import. It must have a .csv format. At this step, no information will be saved in the database.';
$lang['member']['associate_field_info']='For each column of your list, choose the associated member\'s field. At this step, no information will be saved in the database.';
$lang['member']['associate_value_info']='Some data of your list needs to be associated with existing records of the database. Please select matching information or choose "Add as a new value" if you want to ass a new item. At this step, no information will be saved in the database.';
$lang['member']['check_data_info']='The members of your list will now be saved in the database. Before the importation, please check the information submitted for each member.
If it is a new member, then choose the option "Add as a new member".
If it is an existing member, please choose the option "Merge". The member will then be updated with the new information submitted.
If you don\'t want to import a member, please choose the option "Do not import".';

$lang['member']['no_value_to_associate']='There is no data to associate. You can ignore this step and continue the importation';

$lang['member']['action']='Action';
$lang['member']['import_new_member']='Add as a new member';
$lang['member']['merge_member']='Merge with the member';
$lang['member']['dont_import']='Do not import';
$lang['member']['choose_member']='Choose a member';

$lang['member']['add_new_value']='Add as a new value';

$lang['member']['E_found_member']='Warning, some members with similar information have been found in the database';
$lang['member']['E_empty_file']='Please select a file';
$lang['member']['E_invalid_file_type']='The file must have one of the following extension: {type}';
$lang['member']['E_invalid_file_size']='The file size has to be under {max_file_size}';
$lang['member']['E_empty_separator']='Please choose a separator';
$lang['member']['E_empty_member_lastname_field']='The field "Last name" is required';
$lang['member']['E_empty_member_firstname_field']='The field "First name" is required';
$lang['member']['E_exists_member_field']='You can not have two identical fields';
$lang['member']['E_exist_members']='The following members already exist: {member}';
$lang['member']['E_invalid_member_name']='Two members can not have the same name: {member}';
$lang['member']['E_invalid_email_members']='Emails address of these members are invalid: {member}';
$lang['member']['E_invalid_date_birth_members']='Dates of birth of these members are invalid: {member}';
$lang['member']['E_invalid_login_members']='Logins of these members are invalid : {member}. They must have between 4 and 20 characters, without space or special characters. ';
$lang['member']['E_empty_member_merge']='A member is required if you chose the option "Merge"';
$lang['member']['E_empty_members_name']='Please enter a name for each member';
$lang['member']['E_empty_value_associate']="Please choose an associated value for each record of your list";
$lang['member']['E_empty_season']="Please choose a season";

$lang['member']['import_member_1']='Members have been successfully imported';

# formulaire
$lang['member']['form_member_add']='Add a member';
$lang['member']['form_member_edit']='Edit a member';
$lang['member']['form_member_add_1']='Item successfully added';
$lang['member']['form_member_add_0']='Failed to add';
$lang['member']['form_member_edit_1']='Item successfully modified';
$lang['member']['form_member_edit_0']='Failed to modify';
$lang['member']['form_member_sup_1']='Item successfully removed';
$lang['member']['form_member_sup_0']='Failed to remove';

$lang['member']['form_pass']='Change the password';
$lang['member']['form_pass_edit_1']='Item successfully modified';
$lang['member']['form_pass_edit_0']='Failed to modify';

# erreur
$lang['member']['E_empty_name']='Please enter a last name';
$lang['member']['E_empty_firstname']='Please enter un first name';
$lang['member']['E_empty_email']='Please enter a email';
$lang['member']['E_invalid_email']='The email address is invalid';
$lang['member']['E_choisi_email']='This email is already used by another member';
$lang['member']['E_absent_email']='This email does not match with a member';
$lang['member']['E_empty_sex']='Please choose a sex';
$lang['member']['E_empty_date_birth']='Please enter a date of birth';
$lang['member']['E_invalid_date_birth']='The date of birth is invalid';
$lang['member']['E_invalid_size']='The height is invalid';
$lang['member']['E_invalid_weight']='The weight is invalid';
$lang['member']['E_empty_country']='Please choose a nationality';
$lang['member']['E_exist_member']='This member already exists';
$lang['member']['E_member_not_found']='No member found';
$lang['member']['E_suppression_member_administrateur']='It is not possible to delete the main administrator';
$lang['member']['E_suppression_member_connecte']='You are not allowed to delete your own account';
$lang['member']['E_modification_member_administrateur']='It is not possible to modify the status of the main administrator';
$lang['member']['E_modification_compte_administrateur']='It is not possible to modify the account of the main administrator';
$lang['member']['E_empty_login']='Please enter a login';
$lang['member']['E_invalid_login']='The login is invalid';
$lang['member']['E_choisi_login']='This login is already used by another member';
$lang['member']['E_absent_login']='This login was not found';
$lang['member']['E_empty_pass']='Please enter a password';
$lang['member']['E_invalid_pass']='This password is invalid';
$lang['member']['E_empty_confirm_pass']='Please confirm your password';
$lang['member']['E_pass_different']='Waring your passwrords are different';
$lang['member']['E_empty_ancien_pass']='Please enter your current password';
$lang['member']['E_empty_nouveau_pass']='Please enter a new password';
$lang['member']['E_invalid_ancien_pass']='The current password is invalid';
$lang['member']['E_invalid_avatar']='The avatar web address is invalid';

# member_club
$lang['member']['E_empty_member_club']='Please choose a season and a club';
$lang['member']['member_club']='Club(s)';
$lang['member']['season']='Season';
$lang['member']['choose_season']='Choose a season';
$lang['member']['club']='Club';
$lang['member']['choose_club']='Choose a club';

# member_job
$lang['member']['E_empty_member_job']='Please choose a season and a position';
$lang['member']['member_job']='Position(s)';
$lang['member']['job']='Position';
$lang['member']['choose_job']='Choose a position';
$lang['member']['member_job_list']='Staff';
$lang['member']['dirigeant']='Manager';

# home
$lang['member']['home']='Discover members';

# home_member
$lang['member']['home_member']='My account';
$lang['member']['member_team']='My teams';
$lang['member']['member_next_matches']='My upcoming matches';
$lang['member']['administration']='Administration zone';


#################################
# registration
#################################
# registration
$lang['member']['registration']='Registration';
$lang['member']['form_registration']='Registration form';
$lang['member']['register']='Register';
$lang['member']['registration_list']='New registrations to validate';
$lang['member']['registration_list_info']='member(s) want to activate their account';
$lang['member']['date_registration']='Date of registration';
$lang['member']['form_registration_validation']='Registrations validation';
$lang['member']['registration_info']='To register, please fill in the form below. Your registration request will be sent to the webmaster who will verify the submitted infirmation. Once your account validated, you will be able to login your member zone and leave some messages.';

$lang['member']['form_registration_add_1']='Your registration have been successfully saved. Once your information will be validated by the webmaster, you will be able to login your member zone and leave some messages.';
$lang['member']['form_registration_add_0']='An error occurs while saving your registration. If the problem continues, please contact the webmaster.';

$lang['member']['valid_registration']='This registration is:';
$lang['member']['add_registration']='A new member';
$lang['member']['add_registration_info']='The registration will be validated, the account will be activated and the member will be abe to login his member zone.';
$lang['member']['merge_registration']='An existing member:';
$lang['member']['merge_registration_info']='Submitted data will be merged with the selected member. 
A confirmation email will be sent to the selected member to verify the identity of the person who registered';
$lang['member']['refuse_registration']='An error or an abuse';
$lang['member']['refuse_registration_info']='The registration will be refused, the account will be blocked and the member won\'t be able to login his member zone.';

$lang['member']['form_registration_validation_add_1']='The registration of this new member was successfully validated.';
$lang['member']['form_registration_validation_merge_1']='Submitted data were successfully merged with the existing member\'s information.';
$lang['member']['form_registration_validation_refuse_1']='The registration has been successfully refused.';
$lang['member']['form_registration_validation_0']='An error occurs while validating the registration';

$lang['member']['mail_registration_subject']='Welcome to {site_title}';
$lang['member']['mail_registration_message']='Hi {firstname},

You recently registered for the site "{site_title}" ({site_url}). The information that you submitted will now be verify by the webmaster. Once your account validated, you will be able to loginyour member zone. This is your connection ID: 

Login : {login}
Password : {pass}

If you did not register for this site, please disregard this message.
Please contact {sender_email} with any questions.

Thanks,
{sender_name}';

$lang['member']['E_empty_action']='Please choose an action to perform';
$lang['member']['E_empty_member']='Please choose a member';
$lang['member']['E_registration_validation']='No activation was asked for this account';
$lang['member']['E_different_email']='Warning, the email of the registration requirer is different from the selected member. An email will be sent to the selected member to check the identity of the requirer. Do you want to continue?';
$lang['member']['E_empty_email_merge']='Warning, the member you selected do not have any email address. The confirmation email couldn\'t be sent and the identity of the requirer couldn\'t be verify. Do you still want to merge data and activate the account?';
$lang['member']['E_inactive_mail']='Warning, you didn\'t allowed mail sending in the site configuration. The confirmation email coundn\'t be sent.  L\'email de demande de confirmation ne pourra pas être envoyé. Do you still want to merge  data and activate the account?';
$lang['member']['E_no_registration']='Registrations are not opened. Please contact the webmaster with any questions.';

# forget pass
$lang['member']['forgot_pass']='Forgot pass?';
$lang['member']['forgot_pass_info']='You forgot your password? Fill in this form and receive a new one by email.';
$lang['member']['form_forgot_pass']='New password request form';
$lang['member']['E_no_forgot_pass']='New passord requests are not opened. Please contact the webmaster with any questions.';
$lang['member']['forgot_pass_ok']='You new password has been successfully created. You should received it by email soon.';
$lang['member']['forgot_pass_pbm']='An error occurs while sending your new password. If the problem continues, please contact the webmaster.';
$lang['member']['mail_forgot_pass_subject']='Your new password';
$lang['member']['mail_forgot_pass_message']='Hi {firstname},

You recently requested a new password for the site "{site_title}". Here is your new connection ID:

Login : {login}
Password : {pass}

To login your member zone, please follow this link: {site_url}.

Regards,
{sender_name}';


#################################
# job
#################################
# divers
$lang['member']['add_job']='Add a position';
$lang['member']['job_list']='Positions of managers';

# formulaire
$lang['member']['form_job']='Positions of managers';
$lang['member']['form_job_add_1']='Item successfully added';
$lang['member']['form_job_add_0']='Failed to add';
$lang['member']['form_job_edit_1']='Item successfully modified';
$lang['member']['form_job_edit_0']='Failed to modify';
$lang['member']['form_job_sup_1']='Item successfully removed';
$lang['member']['form_job_sup_0']='Failed to remove';

# erreur
$lang['member']['E_empty_name_job']='Please enter a positionb';
$lang['member']['E_exist_job']='This position already exists';
$lang['member']['E_exist_job_member']='A manager having this position exists';

#################################
# level
#################################
# divers
$lang['member']['level']='Referee level';
$lang['member']['add_level']='Add a level';
$lang['member']['level_list']='Referees levels';
$lang['member']['referee']='Referee';
$lang['member']['choose_level']='No level';

# formulaire
$lang['member']['form_level']='Referees levels';
$lang['member']['form_level_add_1']='Item successfully added';
$lang['member']['form_level_add_0']='Failed to add';
$lang['member']['form_level_edit_1']='Item successfully modified';
$lang['member']['form_level_edit_0']='Failed to modify';
$lang['member']['form_level_sup_1']='Item successfully removed';
$lang['member']['form_level_sup_0']='Failed to remove';

# erreur
$lang['member']['E_empty_name_level']='Please enter a level';
$lang['member']['E_exist_level']='This level already exists';
$lang['member']['E_exist_level_member']='A referee having this level exists';

#################################
# sex
#################################
# divers
$lang['member']['sex']='Sex';
$lang['member']['add_sex']='Add a sex';
$lang['member']['sex_list']='Members sex';
$lang['member']['abbreviation']='Abbreviation';

# formulaire
$lang['member']['form_sex']='Members sex';
$lang['member']['form_sex_add_1']='Item successfully added';
$lang['member']['form_sex_add_0']='Failed to add';
$lang['member']['form_sex_edit_1']='Item successfully modified';
$lang['member']['form_sex_edit_0']='Failed to modify';
$lang['member']['form_sex_sup_1']='Item successfully removed';
$lang['member']['form_sex_sup_0']='Failed to remove';

# erreur
$lang['member']['E_empty_name_sex']='Please enter a sex';
$lang['member']['E_empty_abbreviation_sex']='Please enter a abbreviation';
$lang['member']['E_exist_sex']='This sex already exists';
$lang['member']['E_exist_sex_member']='A member having this sex exists';

#################################
# country
#################################
# divers
$lang['member']['country']='Country';
$lang['member']['add_country']='Add a country';
$lang['member']['country_list']='Countries';

# formulaire
$lang['member']['form_country']='Countries';
$lang['member']['form_country_add_1']='Item successfully added';
$lang['member']['form_country_add_0']='Failed to add';
$lang['member']['form_country_edit_1']='Item successfully modified';
$lang['member']['form_country_edit_0']='Failed to modify';
$lang['member']['form_country_sup_1']='Item successfully removed';
$lang['member']['form_country_sup_0']='Failed to remove';

# erreur
$lang['member']['E_empty_name_country']='Please enter a country';
$lang['member']['E_exist_country']='This country already exists';
$lang['member']['E_exist_country_member']='A member having the nationality of this country exists';


#################################
# group // new 1.4
#################################
# divers
$lang['member']['group']='Group'; // new 1.4
$lang['member']['choose_group']='Choose a group'; // new 1.4
$lang['member']['add_group']='Add a group'; // new 1.4
$lang['member']['group_list']='Groups list'; // new 1.4
$lang['member']['description']='Description'; // new 1.4
$lang['member']['right_management']='Manage users rights'; // new 1.4

# formulaire
$lang['member']['form_group']='Groups Management'; // new 1.4
$lang['member']['form_group_add_1']='Item successfully added'; // new 1.4
$lang['member']['form_group_add_0']='Failed to add'; // new 1.4
$lang['member']['form_group_edit_1']='Item successfully modified'; // new 1.4
$lang['member']['form_group_edit_0']='Failed to modify'; // new 1.4
$lang['member']['form_group_sup_1']='Item successfully removed'; // new 1.4
$lang['member']['form_group_sup_0']='Failed to remove'; // new 1.4

$lang['member']['form_group_right_edit_1']='Rights successfully modified'; // new 1.4
$lang['member']['form_group_right_edit_0']='Failed to modify'; // new 1.4

# erreur
$lang['member']['E_empty_name_group']='Please enter a group name'; // new 1.4
$lang['member']['E_empty_description_group']='Please enter a description'; // new 1.4
$lang['member']['E_exist_group']='This group already exists'; // new 1.4
$lang['member']['E_exist_group_member']='This group has one or more member and can not be deleted'; // new 1.4
$lang['member']['E_cant_delete_default_group']='Default groups can not be deleted'; // new 1.4


#################################
# commun
#################################
# divers
$lang['member']['submit']='Submit';
$lang['member']['cancel']='Cancel';
$lang['member']['edit']='Edit';
$lang['member']['check']='Check';
$lang['member']['delete']='Remove';
$lang['member']['add']='Add';
$lang['member']['order_by']='Order by';

# page
$lang['member']['first_page']='First page';
$lang['member']['previous_page']='Previous';
$lang['member']['next_page']='Next';
$lang['member']['last_page']='Last page';


?>