<?php
/*******************************************************************/
/* MATCH */
/*******************************************************************/

#################################
# match
#################################
# divers
$lang['match']['match']='Match';
$lang['match']['match_list']='Matches list';
$lang['match']['view_match']='Match details';
$lang['match']['view_list']='All matches';
$lang['match']['show_view']='More';
$lang['match']['back_list']='Back to matches list';
$lang['match']['add_match']='Add a match';
$lang['match']['edit_match']='Edit a match'; // new 1.4
$lang['match']['delete_match']='Delete a match'; // new 1.4
$lang['match']['score']='Score';
$lang['match']['score_home']='Home score'; // new 1.4
$lang['match']['score_visitor']='Visitor score'; // new 1.4
$lang['match']['field']='Place';
$lang['match']['competition']='Competition';
$lang['match']['group']='Group';
$lang['match']['day']='Day';
$lang['match']['penality']='Penality points';
$lang['match']['team']='Team';
$lang['match']['club']='Club';
$lang['match']['season']='Season';
$lang['match']['date']='Date';
$lang['match']['hour']='Time';
$lang['match']['format_date']='yyyy-mm-dd';
$lang['match']['format_hour']='hh:mm';
$lang['match']['format_date_php']='%a %b %d';
$lang['match']['format_date_sql']='%Y-%m-%d';
$lang['match']['format_date_form']='%Y-%m-%d';
$lang['match']['format_hour_php']='%H:%M';
$lang['match']['format_hour_form']='%H:%M';
$lang['match']['spectators']='Nb of spectators';
$lang['match']['comment']='Comments';
$lang['match']['composition_team']='Teams composition';
$lang['match']['choose_team']='Choose a team';
$lang['match']['choose_club']='Choose a club';
$lang['match']['choose_season']='Choose a season';
$lang['match']['choose_team_club']='Choose the club team';
$lang['match']['choose_team_adverse']='Choose the opponent team';
$lang['match']['choose_field']='Choose a place';
$lang['match']['choose_weather']='Choose the weather';
$lang['match']['choose_field_state']='Choose the field condition';
$lang['match']['choose_competition']='Choose a competition';
$lang['match']['choose_action']='Choose an action';
$lang['match']['choose_player']='Choose a player';
$lang['match']['choose_referee']='Choose a referee';
$lang['match']['details']='Details';
$lang['match']['next_matches']='Next matches';
$lang['match']['last_matches']='Last results';

# formulaire
$lang['match']['form_match_add']='Add a match';
$lang['match']['form_match_edit']='Edit a match';
$lang['match']['form_match_add_1']='Item successfully added';
$lang['match']['form_match_add_0']='Failed to add';
$lang['match']['form_match_edit_1']='Item successfully modified';
$lang['match']['form_match_edit_0']='Failed to modify';
$lang['match']['form_match_sup_1']='Item successfully removed';
$lang['match']['form_match_sup_0']='Failed to remove';

# erreur
$lang['match']['E_empty_club_home_match']='Please choose a home club';
$lang['match']['E_empty_club_visitor_match']='Please choose a visitor club';
$lang['match']['E_invalid_club_defaut']='You have to choose your club as a home or visitor club';
$lang['match']['E_empty_date']='Please enter a date';
$lang['match']['E_invalid_date']='The date is invalid';
$lang['match']['E_invalid_hour']='The time is invalid';
$lang['match']['E_invalid_spectators']='The number of spectator is invalid';
$lang['match']['E_match_not_found']='No match found';
$lang['match']['E_team_same']='Teams can not be the same';
$lang['match']['E_empty_season']='This date does not fit to any season stored. Please <a href="javascript:pop(\'{link_season}\',\'650\',\'500\');">add a new season</a>.';
$lang['match']['E_empty_score']='The following matches are over but their score has not yet been added :';
$lang['match']['E_exist_match']='This match is already registered';

# player_substitute
$lang['match']['substitute']='Substitutes';
$lang['match']['player_out']='Out';
$lang['match']['player_in']='In';
$lang['match']['E_empty_substitute']='Please choose a out player, his substitute and the out minute';

# player_match_player
$lang['match']['match_player']='Match players';
$lang['mem']['number']='#';
$lang['match']['position']='Position';
$lang['match']['captain']='Capitain';
$lang['match']['player_available']='Available players';
$lang['match']['E_empty_match_player']='Please choose a player';
$lang['match']['E_invalid_nb_match_player']='The maximum number of title holder was reached';

# import // new 1.4
$lang['match']['import_match']='Import a matches list'; // new 1.4
$lang['match']['csv_file']='.csv file'; // new 1.4
$lang['match']['separator']='Separator'; // new 1.4
$lang['match']['column']='Column'; // new 1.4
$lang['match']['file_column']='Column of the .cvs file'; // new 1.4
$lang['match']['associated_field']='Associated field'; // new 1.4
$lang['match']['first_line']='The first line contains to columns\' names'; // new 1.4
$lang['match']['step']='Step'; // new 1.4
$lang['match']['choose_field_import']='Choisir un champ'; // new 1.4

$lang['match']['upload_file']='Upload file'; // new 1.4
$lang['match']['associate_field']='Fields association'; // new 1.4
$lang['match']['associate_value']='Values association'; // new 1.4
$lang['match']['check_data']='Check data before importation'; // new 1.4

$lang['match']['upload_file_info']='Choose the file containing the list of matches to import. It must have a .csv format. At this step, no information will be saved in the database.'; // new 1.4
$lang['match']['associate_field_info']='For each column of your list, choose the associated match\'s field. At this step, no information will be saved in the database.'; // new 1.4
$lang['match']['associate_value_info']='Some data of your list needs to be associated with existing records of the database. Please select matching information or choose "Add as a new value" if you want to ass a new item. At this step, no information will be saved in the database.'; // new 1.4
$lang['match']['check_data_info']='The matches of your list will now be saved in the database. Before the importation, please check the information submitted for each match.
If it is a new match, then choose the option "Add as a new match".
If it is an existing match, please choose the option "Merge". The match will then be updated with the new information submitted.
If you don\'t want to import a match, please choose the option "Do not import".'; // new 1.4

$lang['match']['no_value_to_associate']='There is no data to associate. You can ignore this step and continue the importation'; // new 1.4

$lang['match']['action']='Action'; // new 1.4
$lang['match']['import_new_match']='Add as a new match'; // new 1.4
$lang['match']['merge_match']='Merge with the match'; // new 1.4
$lang['match']['dont_import']='Do not import'; // new 1.4
$lang['match']['choose_match']='Choose a match'; // new 1.4

$lang['match']['add_new_value']='Add as a new value'; // new 1.4

$lang['match']['E_found_match']='Warning, some matches with similar information have been found in the database'; // new 1.4
$lang['match']['E_empty_file']='Please select a file'; // new 1.4
$lang['match']['E_invalid_file_type']='The file must have one of the following extension: {type}'; // new 1.4
$lang['match']['E_invalid_file_size']='The file size has to be under {max_file_size}'; // new 1.4
$lang['match']['E_empty_separator']='Please choose a separator'; // new 1.4
$lang['match']['E_empty_match_date_field']='The field "Date" is required'; // new 1.4
$lang['match']['E_empty_club_home_id_field']='The field "Home" is required'; // new 1.4
$lang['match']['E_empty_club_visitor_id_field']='The field "Visitor" is required'; // new 1.4
$lang['match']['E_exists_match_field']='You can not have two identical fields'; // new 1.4
$lang['match']['E_invalid_date_matchs']='Dates of several matches are invalid: {date}'; // new 1.4
$lang['match']['E_empty_match_merge']='A match is required if you chose the option "Merge"'; // new 1.4
$lang['match']['E_empty_matchs_date']='Please enter a date for each match'; // new 1.4
$lang['match']['E_empty_matchs_club_home']='Please choose a home club for each match'; // new 1.4
$lang['match']['E_empty_matchs_club_visitor']='Please choose a visitor club for each match'; // new 1.4
$lang['match']['E_empty_matchs_no_season']='Dates of several matches are not linked to a season. Please add new seasons if necessary.';
$lang['match']['E_empty_value_associate']="Please choose an associated value for each record of your list."; // new 1.4

$lang['match']['import_match_1']='Matches have been successfully imported'; // new 1.4

#################################
# match_referee
#################################
# divers
$lang['match']['match_referee']='Match referee(s)';
$lang['match']['referee']='Referee';
$lang['match']['choose_referee']='Choose a referee';

# erreur
$lang['match']['E_empty_match_referee']='Please choose a referee';

#################################
# action_match
#################################
# divers
$lang['match']['action_match']='Match action';
$lang['match']['action']='Action';
$lang['match']['player']='Player';
$lang['match']['minute']='Minute';


# erreur
$lang['match']['E_empty_action_match']='Please choose an action and a player';

#################################
# action
#################################
# divers
$lang['match']['add_action']='Add an action';
$lang['match']['action_list']='Match actions';

# formulaire
$lang['match']['form_action']='Match actions';
$lang['match']['form_action_add_1']='Item successfully added';
$lang['match']['form_action_add_0']='Failed to add';
$lang['match']['form_action_edit_1']='Item successfully modified';
$lang['match']['form_action_edit_0']='Failed to modify';
$lang['match']['form_action_sup_1']='Item successfully removed';
$lang['match']['form_action_sup_0']='Failed to remove';

# erreur
$lang['match']['E_empty_name_action']='Please enter an action';
$lang['match']['E_exist_action']='This action already exists';
$lang['match']['E_exist_action_match']='A match having this action exists';

#################################
# field_state
#################################
# divers
$lang['match']['field_state']='Field state';
$lang['match']['field_state_list']='Field states';
$lang['match']['add_field_state']='Add a field state';

# formulaire
$lang['match']['form_field_state']='Field state';
$lang['match']['form_field_state_add_1']='Item successfully added';
$lang['match']['form_field_state_add_0']='Failed to add';
$lang['match']['form_field_state_edit_1']='Item successfully modified';
$lang['match']['form_field_state_edit_0']='Failed to modify';
$lang['match']['form_field_state_sup_1']='Item successfully removed';
$lang['match']['form_field_state_sup_0']='Failed to remove';

# erreur
$lang['match']['E_empty_name_field_state']='Please enter a field state';
$lang['match']['E_exist_field_state']='This field state already exists';
$lang['match']['E_exist_field_state_match']='A match having this field state exists';

#################################
# weather
#################################
# divers
$lang['match']['weather']='Weather';
$lang['match']['weather_list']='Weather';
$lang['match']['add_weather']='Add a forecast';

# formulaire
$lang['match']['form_weather']='Weather';
$lang['match']['form_weather_add_1']='Item successfully added';
$lang['match']['form_weather_add_0']='Failed to add';
$lang['match']['form_weather_edit_1']='Item successfully modified';
$lang['match']['form_weather_edit_0']='Failed to modify';
$lang['match']['form_weather_sup_1']='Item successfully removed';
$lang['match']['form_weather_sup_0']='Failed to remove';

# erreur
$lang['match']['E_empty_weather_name']='Please enter a forecast';
$lang['match']['E_exist_weather']='This forecast already exists';
$lang['match']['E_exist_weather_match']='A match having this weather exists';

#################################
# period
#################################
# divers
$lang['match']['period']='Period';
$lang['match']['name']='Name';
$lang['match']['duration']='Length';
$lang['match']['add_period']='Add a period';
$lang['match']['period_list']='Periods list';
$lang['match']['format_duration']='minutes';
$lang['match']['required']='required';
$lang['match']['details_period']='Score details';

# formulaire
$lang['match']['form_period']='Period';
$lang['match']['form_period_add_1']='Item successfully added';
$lang['match']['form_period_add_0']='Failed to add';
$lang['match']['form_period_edit_1']='Item successfully modified';
$lang['match']['form_period_edit_0']='Failed to modify';
$lang['match']['form_period_sup_1']='Item successfully removed';
$lang['match']['form_period_sup_0']='Failed to remove';

# erreur
$lang['match']['E_empty_period_name']='Please enter a period';
$lang['match']['E_exist_period']='This period already exists';
$lang['match']['E_exist_period_match']='A match using this period exists';


#################################
# stats
#################################
# divers
$lang['match']['stats']='Statistics';
$lang['match']['abbreviation']='Abbreviation';
$lang['match']['code']='Code';
$lang['match']['type']='Type';
$lang['match']['value']='Value to enter';
$lang['match']['formula']='Formula';
$lang['match']['explication_formula']='It corresponds to a mathematic formula that uses statistics code. By default, 7 predefined codes exist : PLAY, WIN, TIE, DEFEAT, POINT_FOR, POINT_AGAINST and GOAL_AVERAGE. If you want to create new statistics, you have the possibility to use them for your calcul. You can indeed use codes in your formula. Only predefined codes, statistics codes, numbers and the symbols  "+ - * / ( )" are allowed. Here is an example to get the percentage of victories: (WIN/PLAY)*100 ';
$lang['match']['add_stats']='Add a statistics';
$lang['match']['stats_list']='Statictics list';

# formulaire
$lang['match']['form_stats']='Statistics';
$lang['match']['form_stats_add_1']='Item successfully added';
$lang['match']['form_stats_add_0']='Failed to add';
$lang['match']['form_stats_edit_1']='Item successfully modified';
$lang['match']['form_stats_edit_0']='Failed to modify';
$lang['match']['form_stats_sup_1']='Item successfully removed';
$lang['match']['form_stats_sup_0']='Failed to remove';

# erreur
$lang['match']['E_empty_stats_name']='Please enter a name';
$lang['match']['E_empty_stats_abbreviation']='Please enter an abbreviation';
$lang['match']['E_empty_stats_code']='Please enter a code';
$lang['match']['E_invalid_stats_formula']='The formula is not valid';
$lang['match']['E_exist_stats']='This statistics already exists';
$lang['match']['E_exist_stats_match']='A match using this statistics exists.';

#################################
# stats_player
#################################
# divers
$lang['match']['stats_player']='Player statistics';
$lang['match']['show_stats_player']='See full statistics';
$lang['match']['explication_formula_player']='It corresponds to a mathematic formula that uses statistics code. By default, 4 predefined codes exist : PLAY, WIN, TIE and DEFEAT. If you want to create new statistics, you have the possibility to use them for your calcul. You can indeed use codes in your formula. Only predefined codes, statistics code, number and the symbols  "+ - * / ( )" are allowed. Here is an example to obtain the percentage of matches win: (WIN/PLAY)*100 ';
$lang['match']['add_stats_player']='Add a statistics';
$lang['match']['stats_player_list']='Player stats list';

# formulaire
$lang['match']['form_stats_player']='Player statistics';
$lang['match']['form_stats_player_add_1']='Item successfully added';
$lang['match']['form_stats_player_add_0']='Failed to add';
$lang['match']['form_stats_player_edit_1']='Item successfully modified';
$lang['match']['form_stats_player_edit_0']='Failed to modify';
$lang['match']['form_stats_player_sup_1']='Item successfully removed';
$lang['match']['form_stats_player_sup_0']='Failed to remove';

# erreur
$lang['match']['E_empty_stats_player_name']='Please enter a name';
$lang['match']['E_empty_stats_player_abbreviation']='Please enter an abbreviation';
$lang['match']['E_empty_stats_player_code']='Please enter a code';
$lang['match']['E_invalid_stats_player_formula']='The formula is not valid';
$lang['match']['E_exist_stats_player']='This statistics already exists';
$lang['match']['E_exist_stats_player_match']='A match using this statistics exists.';

#################################
# standings
#################################
# divers
$lang['match']['standings']='Standings/statistics';
$lang['match']['show_standings']='See all the statistics';
$lang['match']['total']='Total';
$lang['match']['at_home']='At home';
$lang['match']['away']='Away';

$lang['match']['place']='Place';
$lang['match']['place_ab']='#';
$lang['match']['nb_point']='Points';
$lang['match']['nb_match']='Number of match played';
$lang['match']['nb_win']='Number of win';
$lang['match']['nb_defeat']='Number of defeat';
$lang['match']['nb_tie']='Number of ties';
$lang['match']['point_for']='Scored points';
$lang['match']['point_against']='Conceaded points';
$lang['match']['goal_average']='Goal average';

$lang['match']['nb_point_ab']='Pts';

$lang['match']['E_unavailable_standings']='Statistics are unavailable';


#################################
# commun
#################################
#divers
$lang['match']['submit']='Submit';
$lang['match']['cancel']='Cancel';
$lang['match']['edit']='Edit';
$lang['match']['delete']='Remove';
$lang['match']['add']='Add';
$lang['match']['up']='Up';
$lang['match']['down']='Down';
$lang['match']['order_by']='Order by';
$lang['match']['yes']='Yes';
$lang['match']['no']='No';
$lang['match']['home']='Home';
$lang['match']['visitor']='Visitor';

# page
$lang['match']['first_page']='First page';
$lang['match']['previous_page']='Previous';
$lang['match']['next_page']='Next';
$lang['match']['last_page']='Last page';


# Statistiques
$lang['match']['statistics']='Statistics';
$lang['match']['domicile']='At home';
$lang['match']['exterieur']='Away';
$lang['match']['victoire']='Victories';
$lang['match']['nul']='Ties';
$lang['match']['defaite']='Defeats';
$lang['match']['point_marque']='Scored points';
$lang['match']['point_encaisse']='Conceaded points';
$lang['match']['pourcentage']='%';

?>