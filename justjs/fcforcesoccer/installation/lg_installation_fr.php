<?php

# commun
$lang['installation']['installation']='Installation';
$lang['installation']['step']='Etape';
$lang['installation']['submit']='Valider';
$lang['installation']['continue']='Continuer >>';
$lang['installation']['back']='<< Retour';
$lang['installation']['try_again']='Réessayer';
$lang['installation']['ignore']='Ignorer';
$lang['installation']['connecter']='Se connecter';
$lang['installation']['connection']='Connexion à l\'administration du site';
$lang['installation']['erreur']='Attention il y a une ou des erreur(s)';

# message
$lang['installation']['message']='Message';
$lang['installation']['error_folder']='Attention, pour des raisons de sécurité, il est nécessaire de supprimer le dossier d\'installation pour que le site soit fonctionnel. Une fois supprimé, <a href="{root_url}">cliquer ici pour ouvrir votre site</a>';

# welcome
$lang['installation']['welcome']='Bienvenue';
$lang['installation']['welcome_text']='<p>Bienvenue et merci d\'avoir choisi phpMySport !</p>
<p>PhpMySport est un logiciel web complet de gestion de sport collectif. Vous souhaitez créer rapidement un site internet pour votre club ou votre comité, alors phpMySport est fait pour vous. Voici les principales fonctionnalités qui sont incluses :</p>
<ul>
<li>La gestion des membres, des joueurs, des dirigeants et des entraîneurs</li>
<li>La gestion des clubs et de leurs équipes</li>
<li>La gestion des compositions des équipes</li>
<li>La gestion des matchs avec le calendrier, les fiches de match, les actions des joueurs et les compositions des équipes</li>
<li>La gestion des compétitions et des saisons</li>
<li>La gestion de pages de présentation</li>
<li>Une rubrique actualité</li>
<li>Un forum de discussion</li>
</ul>';

$lang['installation']['reglement']='Licence';
$lang['installation']['text_reglement']='PhpMySport est un logiciel libre sous licence GNU/GPL';
$lang['installation']['start_installation']='Commencer l\'installation >>';

# verification
$lang['installation']['verification']='Vérification des paramètres';
$lang['installation']['verification_info']='Les paramètres ci-après sont nécessaires pour l\'installation et l\'utilisation normale de phpMySport. Si certains d\'entres-eux apparaissent en rouge, merci de prendre les mesures appropriées pour les corriger sans quoi le logiciel peut ne pas fonctionner.';
$lang['installation']['php_configuration']='Configuration PHP';
$lang['installation']['php_version']='Version de PHP';
$lang['installation']['php_version_info']='Votre version de PHP doit être supérieure à 4.1.0';
$lang['installation']['file_uploads']='File Uploads';
$lang['installation']['file_uploads_info']='Sans l\'upload de fichiers, vous ne pourrez pas utiliser le gestionnaire de fichiers et d\'images, ni les assistants d\'importations.';
$lang['installation']['disable_functions']='Disable functions';
$lang['installation']['no_disable_functions']='Aucune';
$lang['installation']['disable_functions_info']='Les fonctions fopen(), fputs(), fclose() et chmod() sont requises pour la création du fichier de configuration. La fonction mail() est nécessaire si vous souhaitez activer l\'envoi d\'emails. La fonction exec() est utilisée pour le calcul des statistiques des matchs.';
$lang['installation']['mysql']='MySQL';
$lang['installation']['mysql_info']='Les fonctions permettant de se connecter à une base de données MySQL doivent être disponibles.';

$lang['installation']['folder_permission']='Droits sur les répertoires';
$lang['installation']['include_folder_info']='Le répertoire include/ est utilisé pour la création du fichier de configuration. Il doit être accessible en lecture et en écriture.';
$lang['installation']['upload_folder_info']='Le répertoire upload/ est utilisé pour le téléchargement des images et des fichiers. Il doit être accessible en lecture et en écriture.';
$lang['installation']['writable']='Modifiable';
$lang['installation']['no_permission']='Non modifiable';

# step1
$lang['installation']['mode']='Mode d\'installation';
$lang['installation']['mode_club']='je souhaite installer phpMySport pour mon club de sport';
$lang['installation']['mode_comite']='je souhaite installer phpMySport pour un comité ou une ligue sportive';
$lang['installation']['club_name']='Nom du club';



$lang['installation']['E_empty_mode']='Veuillez choisir un mode d\'installation';
$lang['installation']['E_empty_club_name']='Veuillez saisir un nom de club';
$lang['installation']['E_empty_sport']='Veuillez choisir un sport';

# step2
$lang['installation']['information_site']='Information sur le site';
$lang['installation']['title']='Titre du site';
$lang['installation']['url']='Adresse web (url)';
$lang['installation']['root']='Racine (root)';
$lang['installation']['email']='Email du webmestre';
$lang['installation']['information_base']='Information sur le serveur et la base de données';
$lang['installation']['host']='Hôte';
$lang['installation']['user']='Nom d\'utilisateur';
$lang['installation']['password']='Mot de passe';
$lang['installation']['base']='Nom de la base';
$lang['installation']['prefix']='Préfixe des tables';
$lang['installation']['information_admin']='Information sur l\'administrateur du site';
$lang['installation']['login']='Login';
$lang['installation']['name']='Nom';
$lang['installation']['firstname']='Prénom';
$lang['installation']['confirmation']='Confirmation';
$lang['installation']['info_url']='sans / à la fin';
$lang['installation']['url_rewrite']='Activer les URLs simplifiés'; 
$lang['installation']['info_url_rewrite']='L\'activation des URLs simplifiés (URL rewriting) rend plus lisible les adresses web comportant des variables. Par exemple, l\'adresse http://www.monsite.com/index.php?lg=fr&r=news&v1=page1 sera affichée  http://www.monsite.com/fr/news/page1.html. Pour fonctionner, le mod rewrite d\'Apache doit être activé.';
$lang['installation']['example']='Ex.';
$lang['installation']['example_title']='Mon club de sport';
$lang['installation']['example_url']='http://www.monsite.com';
$lang['installation']['example_email']='contact@monsite.com';
$lang['installation']['example_root']='/var/www/monsite';
$lang['installation']['example_user']='root';
$lang['installation']['example_host']='localhost';
$lang['installation']['example_base']='mabase';
$lang['installation']['example_prefix']='"pms_" ou laisser vide';

$lang['installation']['E_empty_title']='Veuillez saisir un titre';
$lang['installation']['E_empty_url']='Veuillez saisir l\'url du site';
$lang['installation']['E_invalid_url']='L\'url saisie est invalide. Vérifiez que le site est bien accessible à cette adresse';
$lang['installation']['E_empty_root']='Veuillez saisir l\'adresse du répertoire racine du site';
$lang['installation']['E_invalid_root']='L\'adresse du répertoire racine du site est invalide. Vérifiez que les fichiers du site sont bien placés dans le répertoire indiqué';
$lang['installation']['E_invalid_email']='L\'adresse email saisie est invalide';
$lang['installation']['E_empty_host']='Veuillez saisir un nom d\'hôte';
$lang['installation']['E_empty_user_base']='Veuillez saisir un nom d\'utilisateur pour la base';
$lang['installation']['E_empty_name_base']='Veuillez saisir le nom de la base de données';
$lang['installation']['E_empty_user_admin']='Veuillez saisir un login';
$lang['installation']['E_empty_pass_admin']='Veuillez saisir un mot de passe pour l\'administration';
$lang['installation']['E_empty_pass_2_admin']='Veuillez confirmer le mot de passe pour l\'administration';
$lang['installation']['E_invalid_pass_admin']='Les mots de passe saisis sont différents';
$lang['installation']['E_invalid_connection_base']='Impossible de se connecter au serveur MySQL, veuillez vérifier les informations saisies';

# step3
$lang['installation']['create_base']='La base de données "{name_base}" n\'existe pas. Souhaitez vous la créer ?';
$lang['installation']['creation_base_ok']='La base de données a été créée avec succès';
$lang['installation']['base_found']='La base de données "{name_base}" a bien été trouvée';
$lang['installation']['delete_table']='{nb_table} table(s) a/ont été trouvée(s). Souhaitez-vous la/les supprimer ?';
$lang['installation']['suppression_table_ok']='Les tables existantes ont été supprimées avec succès';
$lang['installation']['creation_table_ok']='{nb_table_ok} table(s) ont été crée(s) avec succès';
$lang['installation']['creation_tables_ok']='Toutes les tables ont été crées avec succès';
$lang['installation']['creation_user_ok']='L\'administrateur a été créé avec succès';
$lang['installation']['creation_club_ok']='Le club a été créé avec succès';
$lang['installation']['creation_conf_ok']='Le fichier de configuration a été créé avec succès';
$lang['installation']['insertion_data_ok']='L\'insertion des données s\'est déroulée avec succès';
$lang['installation']['creation_htaccess_ok']='Le fichier .htaccess pour la réécriture des urls a été créé avec succès';
$lang['installation']['yes']='Oui';
$lang['installation']['no']='Non';

$lang['installation']['installation_terminee']='L\'installation est maintenant terminée. Pour des raisons de sécurité, il est nécessaire de delete le dossier d\'installation pour que le site soit fonctionnel.
Une fois supprimé, rendez-vous dans la partie administration pour finir la configuration du site. Vous pourrez vous connecter grâce au formulaire ci-contre avec les login et mot de passe que vous avez fournis lors de l\'installation.';

$lang['installation']['E_creation_base']='Une erreur s\'est produite lors de la création de la base';
$lang['installation']['E_suppression_table']='Une erreur s\'est produite lors de la suppression des tables';
$lang['installation']['E_creation_table']='Une erreur s\'est produite lors de la création des tables. {nb_table_pbm} n\'a/ont pas pu être créee(s). Vérifiez si elle(s) n\'existe(nt) pas déjà';
$lang['installation']['E_creation_user']='Une erreur s\'est produite lors de la création de l\'administrateur';
$lang['installation']['E_creation_club']='Une erreur s\'est produite lors de la création du club';
$lang['installation']['E_creation_conf']='Une erreur s\'est produite lors de la création du fichier de configuration. Vérifiez les droits sur vos fichiers';
$lang['installation']['E_insertion_data']='Une erreur s\'est produite lors de l\'insertion des données. Vérifier si elles n\'existent pas déjà.';
$lang['installation']['E_creation_htaccess']='Une erreur s\'est produite lors de la création du fichier .htaccess pour la réécriture des urls. Vérifiez les droits sur vos fichiers';

# update
$lang['installation']['update']='Mise à jour';
$lang['installation']['available_update']='Mise à jour disponibles';
$lang['installation']['no_update']='Aucune mise à jour n\'est disponible';
$lang['installation']['update_database_ok']='La base de données a été mise à jour avec succès';
$lang['installation']['E_update_database']='Une erreur s\'est produite lors de la mise à jour de la base de données';
$lang['installation']['update_conf_ok']='Le fichier de configuration a été mis  à jour avec succès';
$lang['installation']['E_update_conf']='Une erreur s\'est produite lors de la mise à jour du fichier de configuration';
$lang['installation']['update_ok']='La mise a jour est maintenant finie. Pour terminer, vous devez maintenant supprimer le répertoire d\'installation. Puis, <a href="{root_url}">cliquer ici pour ouvrir votre site web';

# sport
$lang['installation']['sport']='Sport';
$lang['installation']['other_sport']='Autre sport collectif';
$lang['installation']['football']='Football';
$lang['installation']['basket']='Basketball';
$lang['installation']['rugby']='Rugby';
$lang['installation']['handball']='Handball';
$lang['installation']['nb_player_other_sport']='10';
$lang['installation']['nb_player_football']='11';
$lang['installation']['nb_player_basket']='5';
$lang['installation']['nb_player_rugby']='15';
$lang['installation']['nb_player_handball']='7';

# action
$lang['installation']['but']='But';
$lang['installation']['carton_rouge']='Carton rouge';
$lang['installation']['carton_jaune']='Carton jaune';

$lang['installation']['essai']='Essai';
$lang['installation']['transformation']='Transformation';
$lang['installation']['penalite']='Pénalité';
$lang['installation']['drop']='Drop';

$lang['installation']['tir_2_points']='Panier à 2 points';
$lang['installation']['tir_3_points']='Panier à 3 points';
$lang['installation']['lancer_francs']='Lancer francs';
$lang['installation']['rebond']='Rebond';
$lang['installation']['passe']='Passes décisives';
$lang['installation']['interception']='Interception';
$lang['installation']['contre']='Contre';

# field_state
$lang['installation']['terrain_boueux']='Terrain boueux';
$lang['installation']['terrain_sec']='Terrain sec';

$lang['installation']['parquet']='Parquet';
$lang['installation']['goudron']='Goudron';
# job
$lang['installation']['president']='Président';
$lang['installation']['secretaire']='Secrétaire';
$lang['installation']['tresorier']='Trésorier';
$lang['installation']['president_adjoint']='Président adjoint';
# weather
$lang['installation']['temps_sec']='Temps sec';
$lang['installation']['pluie']='Pluie';
$lang['installation']['neige']='Neige';
$lang['installation']['temps_nuageux']='Temps nuageux';
# level
$lang['installation']['departemental']='Départemental';
$lang['installation']['regional']='Régional';
$lang['installation']['national']='National';
$lang['installation']['international']='International';
# team_name
$lang['installation']['poussin']='Poussin';
$lang['installation']['benjamin']='Benjamin';
$lang['installation']['minime']='Minime';
$lang['installation']['cadet']='Cadet';
$lang['installation']['junior']='Junior';
$lang['installation']['senior1']='Sénior 1';
$lang['installation']['senior2']='Sénior 2';
$lang['installation']['senior3']='Sénior 3';
# country
$lang['installation']['france']='France';
$lang['installation']['germany']='Allemagne';
$lang['installation']['england']='Angleterre';
$lang['installation']['spain']='Espagne';
$lang['installation']['italy']='Italie';
# period
$lang['installation']['mi_temps1']='1ère mi-temps';
$lang['installation']['mi_temps2']='2ème mi-temps';
$lang['installation']['prolongation1']='1ère prolongation';
$lang['installation']['prolongation2']='2ème prolongation';
$lang['installation']['tir_penalty']='Tir au pénalty';

$lang['installation']['quart_temps1']='1er quart-temps';
$lang['installation']['quart_temps2']='2ème quart-temps';
$lang['installation']['quart_temps3']='3ème quart-temps';
$lang['installation']['quart_temps4']='4ème quart-temps';

# position
$lang['installation']['gardien']='Gardien';
$lang['installation']['attaquant']='Attaquant';
$lang['installation']['mifield']='Milieu';
$lang['installation']['defenseur']='Défenseur';

$lang['installation']['pilier']='Pilier';
$lang['installation']['talonneur']='Talonneur';
$lang['installation']['deuxieme_ligne']='Deuxième ligne';
$lang['installation']['troisieme_ligne']='Troisième ligne';
$lang['installation']['demi_melee']='Demi de mêlée';
$lang['installation']['demi_ouverture']='Demi d ouverture';
$lang['installation']['centre']='Centre';
$lang['installation']['ailier']='Ailier';
$lang['installation']['arriere']='Arrière';

$lang['installation']['pivot']='Arrière';
$lang['installation']['petit_ailier']='Petit ailier';
$lang['installation']['ailier_fort']='Ailier fort';
$lang['installation']['meneur']='Meneur';

# sex
$lang['installation']['masculin']='Masculin';
$lang['installation']['feminin']='Féminin';

# stats
$lang['installation']['play']='Matchs joués';
$lang['installation']['play_ab']='MJ';
$lang['installation']['win']='Victoires';
$lang['installation']['win_ab']='V';
$lang['installation']['percent_win']='Pourcentage de victoires';
$lang['installation']['percent_win_ab']='%V';
$lang['installation']['tie']='Matchs nuls';
$lang['installation']['tie_ab']='N';
$lang['installation']['percent_tie']='Pourcentage de nuls';
$lang['installation']['percent_tie_ab']='%N';
$lang['installation']['defeat']='Défaites';
$lang['installation']['defeat_ab']='D';
$lang['installation']['percent_defeat']='Pourcentage de défaites';
$lang['installation']['percent_defeat_ab']='%D';
$lang['installation']['point_for']='Points pris';
$lang['installation']['point_for_ab']='PP';
$lang['installation']['point_against']='Points concédés';
$lang['installation']['point_against_ab']='PC';
$lang['installation']['goal_average']='Goal Average';
$lang['installation']['goal_average_ab']='GA';

# stats_player
$lang['installation']['goal']='But';
$lang['installation']['goal_ab']='B';
$lang['installation']['goal_stop']='Arrêts (gardien)';
$lang['installation']['goal_stop_ab']='A';
$lang['installation']['decisive_pass']='Passes décisives';
$lang['installation']['decisive_pass_ab']='PD';
$lang['installation']['ball_win']='Balles gagnées';
$lang['installation']['ball_win_ab']='BG';
$lang['installation']['ball_lose']='Balles perdues';
$lang['installation']['ball_lose_ab']='BP';
$lang['installation']['yellow_card']='Cartons jaunes';
$lang['installation']['yellow_card_ab']='CJ';
$lang['installation']['red_card']='Cartons rouges';
$lang['installation']['red_card_ab']='CR';
$lang['installation']['time_play']='Temps de jeu';
$lang['installation']['time_play_ab']='TJ';

$lang['installation']['try']='Essai';
$lang['installation']['try_ab']='E';
$lang['installation']['conversion']='Transformation';
$lang['installation']['conversion_ab']='T';
$lang['installation']['drop']='Drop';
$lang['installation']['drop_ab']='D';
$lang['installation']['penality']='Pénalité';
$lang['installation']['penality_ab']='P';

$lang['installation']['2_points_try']='Paniers à 2 points tentés';
$lang['installation']['2_points_try_ab']='2T';
$lang['installation']['2_points_marked']='Paniers à 2 points réussis';
$lang['installation']['2_points_marked_ab']='2R';
$lang['installation']['percent_2_points']='Pourcentage de réussite à 2 points';
$lang['installation']['percent_2_points_ab']='%2';
$lang['installation']['3_points_try']='Paniers à 3 points tentés';
$lang['installation']['3_points_try_ab']='3T';
$lang['installation']['3_points_marked']='Paniers à 3 points réussis';
$lang['installation']['3_points_marked_ab']='3R';
$lang['installation']['percent_3_points']='Pourcentage de réussite à 3 points';
$lang['installation']['percent_3_points_ab']='%3';
$lang['installation']['free_throw_try']='Lancers francs tentés';
$lang['installation']['free_throw_try_ab']='LFT';
$lang['installation']['free_throw_marked']='Lancers francs réussis';
$lang['installation']['free_throw_marked_ab']='LFR';
$lang['installation']['percent_free_throw']='Pourcentage de réussite au lancer francs';
$lang['installation']['percent_free_throw_ab']='%LF';
$lang['installation']['rebound_off']='Rebonds offensifs';
$lang['installation']['rebound_off_ab']='R';
$lang['installation']['rebound_def']='Rebonds défensifs';
$lang['installation']['rebound_def_ab']='R';
$lang['installation']['interception']='Interceptions';
$lang['installation']['interception_ab']='I';
$lang['installation']['block']='Contres';
$lang['installation']['block_ab']='C';
$lang['installation']['foul_anti']='Fautes antisportives';
$lang['installation']['foul_anti_ab']='FA';
$lang['installation']['foul_tech']='Fautes techniques';
$lang['installation']['foul_tech_ab']='FT';
$lang['installation']['foul_exp']='Expulsion';
$lang['installation']['foul_exp_ab']='EX';

?>