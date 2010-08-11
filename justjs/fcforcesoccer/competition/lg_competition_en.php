<?php
/*******************************************************************/
/* COMPETITION */
/*******************************************************************/

#################################
# competition
#################################
# divers
$lang['competition']['competition']='Competition';
$lang['competition']['name_competition']='Competition name';
$lang['competition']['competition_list']='Competitions list';
$lang['competition']['back_list']='Back to competition list';
$lang['competition']['show_view']='Show matches';
$lang['competition']['show_standings']='Show standings';
$lang['competition']['show_stats']='Statistics';
$lang['competition']['details']='Details';
$lang['competition']['add_competition']='Add a competition';
$lang['competition']['edit_competition']='Edit a compétition'; // new 1.4
$lang['competition']['delete_competition']='Delete a compétition'; // new 1.4
$lang['competition']['view_competition']='Show competition';
$lang['competition']['standings']='Standings';
$lang['competition']['point_system']='Points system';
$lang['competition']['group']='Group';
$lang['competition']['day']='Day';
$lang['competition']['nb_group']='Number of groups';
$lang['competition']['nb_day']='Number of days';
$lang['competition']['at_home']='At home';
$lang['competition']['away']='Away';
$lang['competition']['win']='Win';
$lang['competition']['tie']='Tie';
$lang['competition']['defeat']='Defeat';

$lang['competition']['round_name']='Round name';
$lang['competition']['add_round']='Add a round';
$lang['competition']['choose_round']='Choose a round';
$lang['competition']['order_team']='Sort teams by';
$lang['competition']['order_team_egality']='In case of egality, sort by';
$lang['competition']['point']='Points';
$lang['competition']['nb_match']='Number of matchs played';
$lang['competition']['nb_win']='Number of wins';
$lang['competition']['nb_tie']='Number of ties';
$lang['competition']['nb_defeat']='Number of defeat';
$lang['competition']['goal_average']='Goal average';

$lang['competition']['penality']='Penality points';
$lang['competition']['home']='Home';
$lang['competition']['visitor']='Visitor';

# formulaire
$lang['competition']['form_competition_add']='Add a competition';
$lang['competition']['form_competition_edit']='Edit a competition';
$lang['competition']['form_competition_add_1']='Item successfully added';
$lang['competition']['form_competition_add_0']='Failed to add';
$lang['competition']['form_competition_edit_1']='Item successfully modified';
$lang['competition']['form_competition_edit_0']='Failed to modify';
$lang['competition']['form_competition_sup_1']='Item successfully removed';
$lang['competition']['form_competition_sup_0']='Failed to remove';

# erreur
$lang['competition']['E_empty_name_competition']='Please enter a competition name'; 
$lang['competition']['E_competition_not_found']='No competition found';
$lang['competition']['E_exist_competition']='This competition already exists';
$lang['competition']['E_empty_name_round']='Please enter a name for each round';
$lang['competition']['E_invalid_point']='Points must be integer';
$lang['competition']['E_invalid_group']='The number of groups must be an integer';
$lang['competition']['E_invalid_day']='The number of days must be an integer';
$lang['competition']['E_cant_delete_round']='Ce tour ne peut être supprimé car il contient des matchs'; // new 1.4

#################################
# season
#################################
# divers
$lang['competition']['season']='Season';
$lang['competition']['add_season']='Add a season';
$lang['competition']['season_list']='Seasons list';
$lang['competition']['choose_season']='Choose a season';
$lang['competition']['name']='Name';
$lang['competition']['abbreviation']='Abbreviation';
$lang['competition']['format_date']='yyyy-mm-dd';
$lang['competition']['format_date_form']='%Y-%m-%d';
$lang['competition']['date_start']='Starting date';
$lang['competition']['date_end']='Ending date';

# formulaire
$lang['competition']['form_season']='Add/edit seasons';
$lang['competition']['form_season_add_1']='Item successfully added';
$lang['competition']['form_season_add_0']='Failed to add';
$lang['competition']['form_season_edit_1']='Item successfully modified';
$lang['competition']['form_season_edit_0']='Failed to modify';
$lang['competition']['form_season_sup_1']='Item successfully removed';
$lang['competition']['form_season_sup_0']='Failed to remove';

# erreur
$lang['competition']['E_empty_name_season']='Please enter a season';
$lang['competition']['E_empty_date_start']='Please enter a starting date';
$lang['competition']['E_empty_date_end']='Pleaser enter an ending date';
$lang['competition']['E_invalid_date_start']='The starting date is invalid';
$lang['competition']['E_invalid_date_end']='The ending date is invalid';
$lang['competition']['E_invalid_dates']='The ending date must be after the starting date';
$lang['competition']['E_exist_season']='This season is already registered';
$lang['competition']['E_exist_season_competition']='A competition in this season exists';
$lang['competition']['E_over_season']='The season is over. Would you like to create the new season ?';

#################################
# commun
#################################
# divers
$lang['competition']['submit']='Submit';
$lang['competition']['cancel']='Cancel';
$lang['competition']['edit']='Edit';
$lang['competition']['delete']='Remove';
$lang['competition']['order_by']='Order by';
$lang['competition']['all']='All';

# page
$lang['competition']['first_page']='First page';
$lang['competition']['previous_page']='Previous';
$lang['competition']['next_page']='Next';
$lang['competition']['last_page']='Last page';
?>