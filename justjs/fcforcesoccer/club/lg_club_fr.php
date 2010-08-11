<?php
/*******************************************************************/
/* CLUB */
/*******************************************************************/
#################################
# club
#################################
# divers
$lang['club']['club']='Club';
$lang['club']['add_club']='Ajouter un club';
$lang['club']['edit_club']='Modifier un club'; // new 1.4
$lang['club']['delete_club']='Supprimer un club'; // new 1.4
$lang['club']['view_club']='Voir le club'; // new 1.4
$lang['club']['club_list']='Liste des clubs';
$lang['club']['club_opponent_list']='Listes des clubs adverses';
$lang['club']['back_list']='Retour à la liste des clubs';
$lang['club']['name']='Nom du club';
$lang['club']['abbreviation']='Sigle';
$lang['club']['creation_year']='Année de création';
$lang['club']['address']='Adresse postale';
$lang['club']['color']='Couleurs du club';
$lang['club']['color_alternative']='Couleurs de rechange';
$lang['club']['telephone']='Téléphone';
$lang['club']['fax']='Télécopie';
$lang['club']['email']='Adresse email';
$lang['club']['url']='Site internet';
$lang['club']['comment']='Commentaires';
$lang['club']['format_year']='Format aaaa'; 
$lang['club']['show_view']='Détails';
$lang['club']['details']='Détails';
$lang['club']['view_match']='Voir les matchs';
$lang['club']['view_team']='Voir équipe';
$lang['club']['logo']='Logo'; 
$lang['club']['choose_image']='Choisir une image'; 

# import
$lang['club']['import_club']='Importer une liste de clubs';
$lang['club']['csv_file']='Fichier .csv';
$lang['club']['separator']='Caractère séparateur';
$lang['club']['column']='Colonne';
$lang['club']['file_column']='Colonne du fichier .csv';
$lang['club']['associated_field']='Champ correspondant';
$lang['club']['first_line']='La première ligne contient le nom des colonnes';
$lang['club']['step']='Etape';
$lang['club']['choose_field']='Choisir un champ';

$lang['club']['upload_file']='Upload du fichier';
$lang['club']['associate_field']='Correspondance des champs';
$lang['club']['check_data']='Vérification des données avant importation';

$lang['club']['upload_file_info']='Choisissez le fichier contenant la liste des clubs à importer. Attention il doit être au format .csv. A cette étape, aucune information ne sera enregistrée dans la base de données.';
$lang['club']['associate_field_info']='Pour chaque colonne de votre liste, choisissez les champs de clubs correspondants. A cette étape, aucune information ne sera enregistrée dans la base de données.';
$lang['club']['check_data_info']='Les clubs de votre liste vont maintenant être enregistrés dans la base de données. Avant leur importation, prenez le temps de vérifier les informations soumises. 
S\'il s\'agit d\'un nouveau club, alors choisissez l\'option "Ajouter comme nouveau club".
S\'il s\'agit d\'un club qui existe déjà, alors choisissez l\'option "Fusionner". Le club sera alors mis à jour avec les nouvelles données soumises.
Si vous ne souhaitez pas importer un club, alors choisissez l\'option "Ne pas importer." ';

$lang['club']['action']='Action';
$lang['club']['import_new_club']='Ajouter comme nouveau club';
$lang['club']['merge_club']='Fusionner avec le club';
$lang['club']['dont_import']='Ne pas importer';
$lang['club']['choose_club']='Choisir un club';

$lang['club']['E_found_club']='Attention certains clubs comportant des informations similaires ont été trouvés dans la base de données';

$lang['club']['E_empty_file']='Veuillez sélectionner un fichier';
$lang['club']['E_invalid_file_type']='Le fichier doit avoir l\'un des formats suivants : {type}';
$lang['club']['E_invalid_file_size']='Le poids du fichier doit être inférieur à {max_file_size}';
$lang['club']['E_empty_separator']='Veuillez saisir un caractère séparateur';
$lang['club']['E_empty_club_name_field']='Le champ "Nom du club" est obligatoire';
$lang['club']['E_exists_club_field']='Vous ne pouvez pas avoir deux champs identiques';
$lang['club']['E_exist_clubs']='Les clubs suivants existent déjà : {club}';
$lang['club']['E_invalid_club_name']='Deux clubs ne peuvent avoir le même nom : {club}';
$lang['club']['E_invalid_email_clubs']='Les emails de ces clubs sont invalides : {club}';
$lang['club']['E_invalid_url_clubs']='Les urls de ces clubs sont invalides : {club}';
$lang['club']['E_invalid_creation_year_clubs']='Les années de création de ces clubs sont invalides : {club}';
$lang['club']['E_empty_club_merge']='Pour certaines fusions, vous n\'avez pas choisi de club';
$lang['club']['E_empty_clubs_name']='Veuillez saisir un nom pour tous les clubs';

$lang['club']['import_club_1']='Les clubs ont été importés avec succès';

# formulaire
$lang['club']['form_club_add']='Ajouter un club';
$lang['club']['form_club_edit']='Modifier un club';
$lang['club']['form_club_add_1']='Insertion réussie';
$lang['club']['form_club_add_0']='Problème lors de l\'insertion';
$lang['club']['form_club_edit_1']='Modification réussie';
$lang['club']['form_club_edit_0']='Problème lors de la modification';
$lang['club']['form_club_sup_1']='Suppression réussie';
$lang['club']['form_club_sup_0']='Suppression impossible';

# erreur
$lang['club']['E_empty_club_name']='Veuillez saisir un nom de club';
$lang['club']['E_invalid_email_club']='L\'email saisi est invalide';
$lang['club']['E_invalid_url_club']='L\'url saisie est invalide';
$lang['club']['E_invalid_creation_year_club']='L\'année saisie est invalide';
$lang['club']['E_club_not_found']='Aucun club n\'a été trouvé';
$lang['club']['E_exist_club']='Ce club existe déjà';
$lang['club']['E_invalid_logo_club']='L\'url du logo est invalide'; 

#################################
# commun
#################################
# divers
$lang['club']['submit']='Valider';
$lang['club']['cancel']='Annuler';
$lang['club']['edit']='Modifier';
$lang['club']['delete']='Supprimer';
$lang['club']['order_by']='Trier par';

# page
$lang['club']['first_page']='Première page';
$lang['club']['previous_page']='Précédente';
$lang['club']['next_page']='Suivante';
$lang['club']['last_page']='Dernière page';

?>