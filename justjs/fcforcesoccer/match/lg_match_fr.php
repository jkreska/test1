<?php
/*******************************************************************/
/* MATCH */
/*******************************************************************/

#################################
# match
#################################
# divers
$lang['match']['match']='Match';
$lang['match']['match_list']='Calendrier des matchs';
$lang['match']['view_match']='Fiche de match';
$lang['match']['view_list']='Voir tous les matchs';
$lang['match']['show_view']='Détails';
$lang['match']['back_list']='Retour au calendrier des matchs';
$lang['match']['add_match']='Ajouter un match';
$lang['match']['edit_match']='Modifier un match'; // new 1.4
$lang['match']['delete_match']='Supprimer un match'; // new 1.4
$lang['match']['score']='Score';
$lang['match']['score_home']='Score recevant'; // new 1.4
$lang['match']['score_visitor']='Score visiteur'; // new 1.4
$lang['match']['field']='Lieu';
$lang['match']['competition']='Compétition';
$lang['match']['group']='Groupe';
$lang['match']['day']='Journée';
$lang['match']['penality']='Points de pénalité';
$lang['match']['team']='Equipe';
$lang['match']['club']='Club';
$lang['match']['season']='Saison';
$lang['match']['date']='Date';
$lang['match']['hour']='Heure';
$lang['match']['format_date']='jj-mm-aaaa';
$lang['match']['format_hour']='hh:mm';
$lang['match']['format_date_php']='%d %B %Y';
$lang['match']['format_date_sql']='%Y-%m-%d';
$lang['match']['format_date_form']='%d-%m-%Y';
$lang['match']['format_hour_php']='%H:%M';
$lang['match']['format_hour_form']='%H:%M';
$lang['match']['spectators']='Nb de spectateurs';
$lang['match']['comment']='Commentaires';
$lang['match']['composition_team']='Composition des équipes';
$lang['match']['choose_team']='Choisir une équipe';
$lang['match']['choose_club']='Choisir un club';
$lang['match']['choose_season']='Choisir une saison';
$lang['match']['choose_team_club']='Choisir l\'équipe du club';
$lang['match']['choose_team_adverse']='Choisir l\'équipe adverse';
$lang['match']['choose_field']='Choisir un lieu';
$lang['match']['choose_weather']='Choisir la météo';
$lang['match']['choose_field_state']='Choisir l\'état du terrain';
$lang['match']['choose_competition']='Choisir la compétition';
$lang['match']['choose_action']='Choisir une action';
$lang['match']['choose_player']='Choisir un joueur';
$lang['match']['choose_referee']='Choisir un article';
$lang['match']['details']='Détails';
$lang['match']['next_matches']='Les prochains matchs';
$lang['match']['last_matches']='Les derniers résultats';

# formulaire
$lang['match']['form_match_add']='Ajouter un match';
$lang['match']['form_match_edit']='Modifier un match';
$lang['match']['form_match_add_1']='Insertion réussie';
$lang['match']['form_match_add_0']='Problème lors de l\'insertion';
$lang['match']['form_match_edit_1']='Modification réussie';
$lang['match']['form_match_edit_0']='Problème lors de la modification';
$lang['match']['form_match_sup_1']='Suppression réussie';
$lang['match']['form_match_sup_0']='Suppression impossible';

# erreur
$lang['match']['E_empty_club_home_match']='Veuillez choisir un club recevant';
$lang['match']['E_empty_club_visitor_match']='Veuillez choisir un club visiteur';
$lang['match']['E_invalid_club_defaut']='Vous devez choisir votre club en tant que recevant ou visiteur';
$lang['match']['E_empty_date']='Veuillez saisir une date';
$lang['match']['E_invalid_date']='La date saisie est invalide';
$lang['match']['E_invalid_hour']='L\'heure saisie est invalide';
$lang['match']['E_invalid_spectators']='Le nombre de spectateurs saisi est invalide';
$lang['match']['E_match_not_found']='Aucun match n\'a été trouvé';
$lang['match']['E_team_same']='Les équipes sont identiques';
$lang['match']['E_empty_season']='Cette date ne correspond à aucune saison enregistrée. Veuillez <a href="javascript:pop(\'{link_season}\',\'650\',\'500\');">ajouter une saison</a>.';
$lang['match']['E_empty_score']='Les matchs suivants ont été joués mais leur score n\'a pas encore été enregistré :';
$lang['match']['E_exist_match']='Ce match est déjà enregistré';

# player_substitute
$lang['match']['substitute']='Remplaçants';
$lang['match']['player_out']='Sortie';
$lang['match']['player_in']='Entrée';
$lang['match']['E_empty_substitute']='Veuillez choisir un joueur sortant, son remplaçant et saisir la minute de sortie';

# player_match_player
$lang['match']['match_player']='Titulaires';
$lang['mem']['number']='N°';
$lang['match']['position']='Poste';
$lang['match']['captain']='Capitaine';
$lang['match']['player_available']='Joueurs disponibles';
$lang['match']['E_empty_match_player']='Veuillez choisir un joueur';
$lang['match']['E_invalid_nb_match_player']='Le nombre maximum de titulaires est atteint';


# import // new 1.4
$lang['match']['import_match']='Importer une liste de matchs'; // new 1.4
$lang['match']['csv_file']='Fichier .csv'; // new 1.4
$lang['match']['separator']='Caractère séparateur'; // new 1.4
$lang['match']['column']='Colonne'; // new 1.4
$lang['match']['file_column']='Colonne du fichier .csv'; // new 1.4
$lang['match']['associated_field']='Champ correspondant'; // new 1.4
$lang['match']['first_line']='La première ligne contient le nom des colonnes'; // new 1.4
$lang['match']['step']='Etape'; // new 1.4
$lang['match']['choose_field_import']='Choisir un champ'; // new 1.4

$lang['match']['upload_file']='Upload du fichier'; // new 1.4
$lang['match']['associate_field']='Correspondance des champs'; // new 1.4
$lang['match']['associate_value']='Correspondance des données'; // new 1.4
$lang['match']['check_data']='Vérification des données avant importation'; // new 1.4

$lang['match']['upload_file_info']='Choisissez le fichier contenant la liste des matchs à importer. Attention il doit être au format .csv. A cette étape, aucune information ne sera enregistrée dans la base de données.'; // new 1.4
$lang['match']['associate_field_info']='Pour chaque colonne de votre liste, choisissez les champs de matchs correspondants. A cette étape, aucune information ne sera enregistrée dans la base de données.'; // new 1.4
$lang['match']['associate_value_info']='Certaines données de votre liste ont besoin d\'être associées aux valeurs déjà existantes dans la base de données. Sélectionner les informations correspondantes ou choisissez "Ajouter comme nouvelle valeur" pour que la donnée soit enregistrée comme un nouvel élément. A cette étape, aucune information ne sera enregistrée dans la base de données.'; // new 1.4
$lang['match']['check_data_info']='Les matchs de votre liste vont maintenant être enregistrés dans la base de données. Avant leur importation, prenez le temps de vérifier les informations soumises. 
S\'il s\'agit d\'un nouveau match, alors choisissez l\'option "Ajouter comme nouveau match".
S\'il s\'agit d\'un match qui existe déjà, alors choisissez l\'option "Fusionner". Le match sera alors mis à jour avec les nouvelles données soumises.
Si vous ne souhaitez pas importer un match, alors choisissez l\'option "Ne pas importer." '; // new 1.4

$lang['match']['no_value_to_associate']='Il n\'y a pas de données à associer. Vous pouvez donc ignorer cette étape et continuer l\'importation'; // new 1.4

$lang['match']['action']='Action'; // new 1.4
$lang['match']['import_new_match']='Ajouter comme nouveau match'; // new 1.4
$lang['match']['merge_match']='Fusionner avec le match'; // new 1.4
$lang['match']['dont_import']='Ne pas importer'; // new 1.4
$lang['match']['choose_match']='Choisir un match'; // new 1.4

$lang['match']['add_new_value']='Ajouter comme nouvelle valeur'; // new 1.4

$lang['match']['E_found_match']='Attention certains matchs comportant des informations similaires ont été trouvés dans la base de données'; // new 1.4
$lang['match']['E_empty_file']='Veuillez sélectionner un fichier'; // new 1.4
$lang['match']['E_invalid_file_type']='Le fichier doit avoir l\'un des formats suivants : {type}'; // new 1.4
$lang['match']['E_invalid_file_size']='Le poids du fichier doit être inférieur à {max_file_size}'; // new 1.4
$lang['match']['E_empty_separator']='Veuillez saisir un caractère séparateur'; // new 1.4
$lang['match']['E_empty_club_home_id_field']='Le champ "Recevant" est obligatoire'; // new 1.4
$lang['match']['E_empty_club_visitor_id_field']='Le champ "Visiteur" est obligatoire'; // new 1.4
$lang['match']['E_empty_match_date_field']='Le champ "Date" est obligatoire'; // new 1.4
$lang['match']['E_exists_match_field']='Vous ne pouvez pas avoir deux champs identiques'; // new 1.4
$lang['match']['E_invalid_date_matchs']='Les dates de certains matchs sont invalides : {date}'; // new 1.4
$lang['match']['E_empty_match_merge']='Pour certaines fusions, vous n\'avez pas choisi de match'; // new 1.4
$lang['match']['E_empty_matchs_date']='Veuillez saisir une date pour tous les matchs'; // new 1.4
$lang['match']['E_empty_matchs_club_home']='Veuillez saisir un club recevant pour tous les matchs'; // new 1.4
$lang['match']['E_empty_matchs_club_visitor']='Veuillez choisir un club visiteur pour tous les matchs'; // new 1.4
$lang['match']['E_empty_matchs_no_season']='Attention les dates de certains matchs ne correspondent à aucune saison. Veuillez ajouter des saisons si nécessaire.';
$lang['match']['E_empty_value_associate']="Veuillez choisir une valeur associée pour chacune des données de la liste."; // new 1.4

$lang['match']['import_match_1']='Les matchs ont été importés avec succès'; // new 1.4


#################################
# match_referee
#################################
# divers
$lang['match']['match_referee']='Arbitre(s) du match';
$lang['match']['referee']='Arbitre';
$lang['match']['choose_referee']='Choisir un arbitre';

# erreur
$lang['match']['E_empty_match_referee']='Veuillez choisir un arbitre';

#################################
# action_match
#################################
# divers
$lang['match']['action_match']='Actions du match';
$lang['match']['action']='Action';
$lang['match']['player']='Joueur';
$lang['match']['minute']='Minute';


# erreur
$lang['match']['E_empty_action_match']='Veuillez choisir une action et un joueur';

#################################
# action
#################################
# divers
$lang['match']['add_action']='Ajouter une action';
$lang['match']['action_list']='Actions de match';

# formulaire
$lang['match']['form_action']='Actions de match';
$lang['match']['form_action_add_1']='Insertion réussie';
$lang['match']['form_action_add_0']='Problème lors de l\'insertion';
$lang['match']['form_action_edit_1']='Modification réussie';
$lang['match']['form_action_edit_0']='Problème lors de la modification';
$lang['match']['form_action_sup_1']='Suppression réussie';
$lang['match']['form_action_sup_0']='Suppression impossible';

# erreur
$lang['match']['E_empty_name_action']='Veuillez saisir une action';
$lang['match']['E_exist_action']='Cette action est déjà présente';
$lang['match']['E_exist_action_match']='Un match comportant cette action existe';

#################################
# field_state
#################################
# divers
$lang['match']['field_state']='Etat du terrain';
$lang['match']['field_state_list']='Etat du terrain lors des matchs';
$lang['match']['add_field_state']='Ajouter un état de terrain';

# formulaire
$lang['match']['form_field_state']='Etat du terrain';
$lang['match']['form_field_state_add_1']='Insertion réussie';
$lang['match']['form_field_state_add_0']='Problème lors de l\'insertion';
$lang['match']['form_field_state_edit_1']='Modification réussie';
$lang['match']['form_field_state_edit_0']='Problème lors de la modification';
$lang['match']['form_field_state_sup_1']='Suppression réussie';
$lang['match']['form_field_state_sup_0']='Suppression impossible';

# erreur
$lang['match']['E_empty_name_field_state']='Veuillez saisir un état du terrain';
$lang['match']['E_exist_field_state']='Cet état de terrain est déjà présent';
$lang['match']['E_exist_field_state_match']='Un match comportant cet état de terrain existe';

#################################
# weather
#################################
# divers
$lang['match']['weather']='Météo';
$lang['match']['weather_list']='Météo des matchs';
$lang['match']['add_weather']='Ajouter une météo';

# formulaire
$lang['match']['form_weather']='Météo';
$lang['match']['form_weather_add_1']='Insertion réussie';
$lang['match']['form_weather_add_0']='Problème lors de l\'insertion';
$lang['match']['form_weather_edit_1']='Modification réussie';
$lang['match']['form_weather_edit_0']='Problème lors de la modification';
$lang['match']['form_weather_sup_1']='Suppression réussie';
$lang['match']['form_weather_sup_0']='Suppression impossible';

# erreur
$lang['match']['E_empty_weather_name']='Veuillez saisir une météo';
$lang['match']['E_exist_weather']='Cette météo est déjà présente';
$lang['match']['E_exist_weather_match']='Un match comportant cette météo existe';

#################################
# period
#################################
# divers
$lang['match']['period']='Période';
$lang['match']['name']='Nom';
$lang['match']['duration']='Durée';
$lang['match']['add_period']='Ajouter une période';
$lang['match']['period_list']='Liste des périodes';
$lang['match']['format_duration']='minutes';
$lang['match']['required']='Obligatoire';
$lang['match']['details_period']='Détails des scores';

# formulaire
$lang['match']['form_period']='Période';
$lang['match']['form_period_add_1']='Insertion réussie';
$lang['match']['form_period_add_0']='Problème lors de l\'insertion';
$lang['match']['form_period_edit_1']='Modification réussie';
$lang['match']['form_period_edit_0']='Problème lors de la modification';
$lang['match']['form_period_sup_1']='Suppression réussie';
$lang['match']['form_period_sup_0']='Suppression impossible';

# erreur
$lang['match']['E_empty_period_name']='Veuillez saisir une période';
$lang['match']['E_exist_period']='Cette période est déjà présente';
$lang['match']['E_exist_period_match']='Un match utilisant cette période existe';


#################################
# stats
#################################
# divers
$lang['match']['stats']='Statistiques';
$lang['match']['abbreviation']='Abréviation';
$lang['match']['code']='Code';
$lang['match']['type']='Type';
$lang['match']['value']='Valeur à saisir';
$lang['match']['formula']='Formule';
$lang['match']['explication_formula']='Il s\'agit d\'une formule mathématique utilisant les codes des statistiques. Il existe par défaut 7 codes prédéfinies : PLAY, WIN, TIE, DEFEAT, POINT_FOR, POINT_AGAINST et GOAL_AVERAGE. Si vous créez de nouvelles statistiques, il est alors possible de les utiliser pour des calculs. Pour cela, il faut utiliser les codes que vous avez définis. Seuls les codes prédéfinis, les codes des statistiques, les chiffres et les symboles "+ - * / ( )" sont autorisés. Voici un exemple qui donne le pourcentage de matchs gagnés : (WIN/PLAY)*100 ';
$lang['match']['add_stats']='Ajouter une statistique';
$lang['match']['stats_list']='Liste des statistiques';

# formulaire
$lang['match']['form_stats']='Statistiques';
$lang['match']['form_stats_add_1']='Insertion réussie';
$lang['match']['form_stats_add_0']='Problème lors de l\'insertion';
$lang['match']['form_stats_edit_1']='Modification réussie';
$lang['match']['form_stats_edit_0']='Problème lors de la modification';
$lang['match']['form_stats_sup_1']='Suppression réussie';
$lang['match']['form_stats_sup_0']='Suppression impossible';

# erreur
$lang['match']['E_empty_stats_name']='Veuillez saisir un nom';
$lang['match']['E_empty_stats_abbreviation']='Veuillez saisir une abréviation';
$lang['match']['E_empty_stats_code']='Veuillez saisir un code';
$lang['match']['E_invalid_stats_formula']='La formule est invalide';
$lang['match']['E_exist_stats']='Cette statistique est déjà présente';
$lang['match']['E_exist_stats_match']='Un match utilisant cette statitique existe';

#################################
# stats_player
#################################
# divers
$lang['match']['stats_player']='Statistiques des joueurs';
$lang['match']['show_stats_player']='Voir les statistiques complètes';
$lang['match']['explication_formula_player']='Il s\'agit d\'une formule mathématique utilisant les codes des statistiques. Il existe par défaut 4 codes prédéfinies : PLAY, WIN, TIE et DEFEAT. Si vous créez de nouvelles statistiques, il est alors possible de les utiliser pour des calculs. Pour cela, il faut utiliser les codes que vous avez définis. Seuls les codes prédéfinis, les codes des statistiques, les chiffres et les symboles "+ - * / ( )" sont autorisés. Voici un exemple qui donne le pourcentage de matchs gagnés : (WIN/PLAY)*100 ';
$lang['match']['add_stats_player']='Ajouter une statistique';
$lang['match']['stats_player_list']='Liste des statistiques des joueurs';

# formulaire
$lang['match']['form_stats_player']='Statistiques';
$lang['match']['form_stats_player_add_1']='Insertion réussie';
$lang['match']['form_stats_player_add_0']='Problème lors de l\'insertion';
$lang['match']['form_stats_player_edit_1']='Modification réussie';
$lang['match']['form_stats_player_edit_0']='Problème lors de la modification';
$lang['match']['form_stats_player_sup_1']='Suppression réussie';
$lang['match']['form_stats_player_sup_0']='Suppression impossible';

# erreur
$lang['match']['E_empty_stats_player_name']='Veuillez saisir un nom';
$lang['match']['E_empty_stats_player_abbreviation']='Veuillez saisir une abréviation';
$lang['match']['E_empty_stats_player_code']='Veuillez saisir un code';
$lang['match']['E_invalid_stats_player_formula']='La formule est invalide';
$lang['match']['E_exist_stats_player']='Cette statistique est déjà présente';
$lang['match']['E_exist_stats_player_match']='Un match utilisant cette statitique existe';


#################################
# standings
#################################
# divers
$lang['match']['standings']='Classement/Statistiques';
$lang['match']['show_standings']='Voir toutes les statistiques';
$lang['match']['total']='Total';
$lang['match']['at_home']='A domicile';
$lang['match']['away']='A l\'extérieur';

$lang['match']['place']='Place';
$lang['match']['place_ab']='#';
$lang['match']['nb_point']='Points';
$lang['match']['nb_match']='Nombre de matchs joués';
$lang['match']['nb_win']='Nombre de victoires';
$lang['match']['nb_defeat']='Nombre de défaites';
$lang['match']['nb_tie']='Nombre de nuls';
$lang['match']['point_for']='Points marqués';
$lang['match']['point_against']='Points concédés';
$lang['match']['goal_average']='Goal average';

$lang['match']['nb_point_ab']='Pts';

$lang['match']['E_unavailable_standings']='Statistiques non disponibles';

#################################
# commun
#################################
#divers
$lang['match']['submit']='Valider';
$lang['match']['cancel']='Annuler';
$lang['match']['edit']='Modifier';
$lang['match']['delete']='Supprimer';
$lang['match']['add']='Ajouter';
$lang['match']['up']='Monter';
$lang['match']['down']='Descendre';
$lang['match']['order_by']='Trier par';
$lang['match']['yes']='Oui';
$lang['match']['no']='Non';
$lang['match']['home']='Recevant';
$lang['match']['visitor']='Visiteur';

# page
$lang['match']['first_page']='Première page';
$lang['match']['previous_page']='Précédente';
$lang['match']['next_page']='Suivante';
$lang['match']['last_page']='Dernière page';


# Statistiques
$lang['match']['statistics']='Statistiques';
$lang['match']['domicile']='A domicile';
$lang['match']['exterieur']='A l\'exterieur';
$lang['match']['victoire']='Victoires';
$lang['match']['nul']='Nuls';
$lang['match']['defaite']='Défaites';
$lang['match']['point_marque']='Points marqués';
$lang['match']['point_encaisse']='Points encaissés';

$lang['match']['pourcentage']='%';

?>