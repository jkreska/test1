<?php
/*******************************************************************/
/* CLUB */
/*******************************************************************/
#################################
# club
#################################
# divers
$lang['club']['club']='Club';
$lang['club']['add_club']='Add a club';
$lang['club']['edit_club']='Edit a club'; // new 1.4
$lang['club']['delete_club']='Delete a club'; // new 1.4
$lang['club']['view_club']='View club'; // new 1.4
$lang['club']['club_list']='Clubs list';
$lang['club']['club_opponent_list']='Opposing clubs list';
$lang['club']['back_list']='Back to the clubs list';
$lang['club']['name']='Club name';
$lang['club']['abbreviation']='Abbreviation';
$lang['club']['creation_year']='Creation date';
$lang['club']['address']='Address';
$lang['club']['color']='Club colors';
$lang['club']['color_alternative']='Alternative colors';
$lang['club']['telephone']='Telephone';
$lang['club']['fax']='Fax';
$lang['club']['email']='Email';
$lang['club']['url']='Website';
$lang['club']['comment']='Comments';
$lang['club']['format_year']='Format yyyy'; 
$lang['club']['show_view']='More';
$lang['club']['details']='Details';
$lang['club']['view_match']='Show matches';
$lang['club']['view_team']='Show team';
$lang['club']['logo']='Logo';
$lang['club']['choose_image']='Choose an image';

# import
$lang['club']['import_club']='Import a list of clubs';
$lang['club']['csv_file']='.csv file';
$lang['club']['separator']='Separator';
$lang['club']['column']='Column';
$lang['club']['file_column']='Column of the .cvs file';
$lang['club']['associated_field']='Associated field';
$lang['club']['first_line']='The first line contains to columns\' names';
$lang['club']['step']='Step';
$lang['club']['choose_field']='Choose a field';

$lang['club']['upload_file']='Upload file';
$lang['club']['associate_field']='Fields association';
$lang['club']['check_data']='Check data before importation';

$lang['club']['upload_file_info']='Choose the file containing the list of clubs to import. It must have a .csv format. At this step, no information will be saved in the database.';
$lang['club']['associate_field_info']='For each column of your list, choose the associated club\'s field. At this step, no information will be saved in the database.';
$lang['club']['check_data_info']='The clubs of your list will now be saved in the database. Before the importation, please check the information submitted for each club.
If it is a new club, then choose the option "Add as a new club".
If it is an existing club, please choose the option "Merge". The club will then be updated with the new information submitted.
If you don\'t want to import a club, please choose the option "Do not import". ';

$lang['club']['action']='Action';
$lang['club']['import_new_club']='Add as new club';
$lang['club']['merge_club']='Merge with the club';
$lang['club']['dont_import']='Do not import';
$lang['club']['choose_club']='Choose a club';

$lang['club']['E_found_club']='Warning, some clubs with similar information have been found in the database';

$lang['club']['E_empty_file']='Please select a file';
$lang['club']['E_invalid_file_type']='The file must have one of the following extension: {type}';
$lang['club']['E_invalid_file_size']='The file size has to be under {max_file_size}';
$lang['club']['E_empty_separator']='Please choose a separator';
$lang['club']['E_empty_club_name_field']='The field "Club name" is required';
$lang['club']['E_exists_club_field']='You can not have two identical fields';
$lang['club']['E_exist_clubs']='The following clubs already exists: {club}';
$lang['club']['E_invalid_club_name']='Two clubs can not have the same name: {club}';
$lang['club']['E_invalid_email_clubs']='Emails address of these clubs are invalid: {club}';
$lang['club']['E_invalid_url_clubs']='URLs of these clubs are invalid: {club}';
$lang['club']['E_invalid_creation_year_clubs']='Creation years of these clubs are invalid: {club}';
$lang['club']['E_empty_club_merge']='A club is required if you chose the option "Merge"';
$lang['club']['E_empty_clubs_name']='Please enter a name for each club';

$lang['club']['import_club_1']='Clubs have been successfully imported';


# formulaire
$lang['club']['form_club_add']='Add a club';
$lang['club']['form_club_edit']='Edit a club';
$lang['club']['form_club_add_1']='Item successfully added';
$lang['club']['form_club_add_0']='Failed to add';
$lang['club']['form_club_edit_1']='Item successfully modified';
$lang['club']['form_club_edit_0']='Failed to modify';
$lang['club']['form_club_sup_1']='Item successfully removed';
$lang['club']['form_club_sup_0']='Failed to remove';

# erreur
$lang['club']['E_empty_club_name']='Please enter a club name';
$lang['club']['E_invalid_email_club']='The email is invalid';
$lang['club']['E_invalid_url_club']='The website url is invalid';
$lang['club']['E_invalid_creation_year_club']='The creation year is invalid';
$lang['club']['E_club_not_found']='No club found';
$lang['club']['E_exist_club']='This club already exists';
$lang['club']['E_invalid_logo_club']='The logo url is invalid';

#################################
# commun
#################################
# divers
$lang['club']['submit']='Submit';
$lang['club']['cancel']='Cancel';
$lang['club']['edit']='Edit';
$lang['club']['delete']='Remove';
$lang['club']['order_by']='Order by';

# page
$lang['club']['first_page']='First page';
$lang['club']['previous_page']='Previous';
$lang['club']['next_page']='Next';
$lang['club']['last_page']='Last page';

?>