<?php

# commun
$lang['installation']['installation']='Installation';
$lang['installation']['step']='Etape';
$lang['installation']['submit']='Valider';
$lang['installation']['continue']='Continuer >>';
$lang['installation']['back']='<< Retour';
$lang['installation']['try_again']='R�essayer';
$lang['installation']['ignore']='Ignorer';
$lang['installation']['connecter']='Se connecter';
$lang['installation']['connection']='Connexion � l\'administration du site';
$lang['installation']['erreur']='Attention il y a une ou des erreur(s)';

# message
$lang['installation']['message']='Message';
$lang['installation']['error_folder']='Attention, pour des raisons de s�curit�, il est n�cessaire de supprimer le dossier d\'installation pour que le site soit fonctionnel. Une fois supprim�, <a href="{root_url}">cliquer ici pour ouvrir votre site</a>';

# welcome
$lang['installation']['welcome']='Bienvenue';
$lang['installation']['welcome_text']='<p>Bienvenue et merci d\'avoir choisi phpMySport !</p>
<p>PhpMySport est un logiciel web complet de gestion de sport collectif. Vous souhaitez cr�er rapidement un site internet pour votre club ou votre comit�, alors phpMySport est fait pour vous. Voici les principales fonctionnalit�s qui sont incluses :</p>
<ul>
<li>La gestion des membres, des joueurs, des dirigeants et des entra�neurs</li>
<li>La gestion des clubs et de leurs �quipes</li>
<li>La gestion des compositions des �quipes</li>
<li>La gestion des matchs avec le calendrier, les fiches de match, les actions des joueurs et les compositions des �quipes</li>
<li>La gestion des comp�titions et des saisons</li>
<li>La gestion de pages de pr�sentation</li>
<li>Une rubrique actualit�</li>
<li>Un forum de discussion</li>
</ul>';

$lang['installation']['reglement']='Licence';
$lang['installation']['text_reglement']='PhpMySport est un logiciel libre sous licence GNU/GPL';
$lang['installation']['start_installation']='Commencer l\'installation >>';

# verification
$lang['installation']['verification']='V�rification des param�tres';
$lang['installation']['verification_info']='Les param�tres ci-apr�s sont n�cessaires pour l\'installation et l\'utilisation normale de phpMySport. Si certains d\'entres-eux apparaissent en rouge, merci de prendre les mesures appropri�es pour les corriger sans quoi le logiciel peut ne pas fonctionner.';
$lang['installation']['php_configuration']='Configuration PHP';
$lang['installation']['php_version']='Version de PHP';
$lang['installation']['php_version_info']='Votre version de PHP doit �tre sup�rieure � 4.1.0';
$lang['installation']['file_uploads']='File Uploads';
$lang['installation']['file_uploads_info']='Sans l\'upload de fichiers, vous ne pourrez pas utiliser le gestionnaire de fichiers et d\'images, ni les assistants d\'importations.';
$lang['installation']['disable_functions']='Disable functions';
$lang['installation']['no_disable_functions']='Aucune';
$lang['installation']['disable_functions_info']='Les fonctions fopen(), fputs(), fclose() et chmod() sont requises pour la cr�ation du fichier de configuration. La fonction mail() est n�cessaire si vous souhaitez activer l\'envoi d\'emails. La fonction exec() est utilis�e pour le calcul des statistiques des matchs.';
$lang['installation']['mysql']='MySQL';
$lang['installation']['mysql_info']='Les fonctions permettant de se connecter � une base de donn�es MySQL doivent �tre disponibles.';

$lang['installation']['folder_permission']='Droits sur les r�pertoires';
$lang['installation']['include_folder_info']='Le r�pertoire include/ est utilis� pour la cr�ation du fichier de configuration. Il doit �tre accessible en lecture et en �criture.';
$lang['installation']['upload_folder_info']='Le r�pertoire upload/ est utilis� pour le t�l�chargement des images et des fichiers. Il doit �tre accessible en lecture et en �criture.';
$lang['installation']['writable']='Modifiable';
$lang['installation']['no_permission']='Non modifiable';

# step1
$lang['installation']['mode']='Mode d\'installation';
$lang['installation']['mode_club']='je souhaite installer phpMySport pour mon club de sport';
$lang['installation']['mode_comite']='je souhaite installer phpMySport pour un comit� ou une ligue sportive';
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
$lang['installation']['information_base']='Information sur le serveur et la base de donn�es';
$lang['installation']['host']='H�te';
$lang['installation']['user']='Nom d\'utilisateur';
$lang['installation']['password']='Mot de passe';
$lang['installation']['base']='Nom de la base';
$lang['installation']['prefix']='Pr�fixe des tables';
$lang['installation']['information_admin']='Information sur l\'administrateur du site';
$lang['installation']['login']='Login';
$lang['installation']['name']='Nom';
$lang['installation']['firstname']='Pr�nom';
$lang['installation']['confirmation']='Confirmation';
$lang['installation']['info_url']='sans / � la fin';
$lang['installation']['url_rewrite']='Activer les URLs simplifi�s'; 
$lang['installation']['info_url_rewrite']='L\'activation des URLs simplifi�s (URL rewriting) rend plus lisible les adresses web comportant des variables. Par exemple, l\'adresse http://www.monsite.com/index.php?lg=fr&r=news&v1=page1 sera affich�e  http://www.monsite.com/fr/news/page1.html. Pour fonctionner, le mod rewrite d\'Apache doit �tre activ�.';
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
$lang['installation']['E_invalid_url']='L\'url saisie est invalide. V�rifiez que le site est bien accessible � cette adresse';
$lang['installation']['E_empty_root']='Veuillez saisir l\'adresse du r�pertoire racine du site';
$lang['installation']['E_invalid_root']='L\'adresse du r�pertoire racine du site est invalide. V�rifiez que les fichiers du site sont bien plac�s dans le r�pertoire indiqu�';
$lang['installation']['E_invalid_email']='L\'adresse email saisie est invalide';
$lang['installation']['E_empty_host']='Veuillez saisir un nom d\'h�te';
$lang['installation']['E_empty_user_base']='Veuillez saisir un nom d\'utilisateur pour la base';
$lang['installation']['E_empty_name_base']='Veuillez saisir le nom de la base de donn�es';
$lang['installation']['E_empty_user_admin']='Veuillez saisir un login';
$lang['installation']['E_empty_pass_admin']='Veuillez saisir un mot de passe pour l\'administration';
$lang['installation']['E_empty_pass_2_admin']='Veuillez confirmer le mot de passe pour l\'administration';
$lang['installation']['E_invalid_pass_admin']='Les mots de passe saisis sont diff�rents';
$lang['installation']['E_invalid_connection_base']='Impossible de se connecter au serveur MySQL, veuillez v�rifier les informations saisies';

# step3
$lang['installation']['create_base']='La base de donn�es "{name_base}" n\'existe pas. Souhaitez vous la cr�er ?';
$lang['installation']['creation_base_ok']='La base de donn�es a �t� cr��e avec succ�s';
$lang['installation']['base_found']='La base de donn�es "{name_base}" a bien �t� trouv�e';
$lang['installation']['delete_table']='{nb_table} table(s) a/ont �t� trouv�e(s). Souhaitez-vous la/les supprimer ?';
$lang['installation']['suppression_table_ok']='Les tables existantes ont �t� supprim�es avec succ�s';
$lang['installation']['creation_table_ok']='{nb_table_ok} table(s) ont �t� cr�e(s) avec succ�s';
$lang['installation']['creation_tables_ok']='Toutes les tables ont �t� cr�es avec succ�s';
$lang['installation']['creation_user_ok']='L\'administrateur a �t� cr�� avec succ�s';
$lang['installation']['creation_club_ok']='Le club a �t� cr�� avec succ�s';
$lang['installation']['creation_conf_ok']='Le fichier de configuration a �t� cr�� avec succ�s';
$lang['installation']['insertion_data_ok']='L\'insertion des donn�es s\'est d�roul�e avec succ�s';
$lang['installation']['creation_htaccess_ok']='Le fichier .htaccess pour la r��criture des urls a �t� cr�� avec succ�s';
$lang['installation']['yes']='Oui';
$lang['installation']['no']='Non';

$lang['installation']['installation_terminee']='L\'installation est maintenant termin�e. Pour des raisons de s�curit�, il est n�cessaire de delete le dossier d\'installation pour que le site soit fonctionnel.
Une fois supprim�, rendez-vous dans la partie administration pour finir la configuration du site. Vous pourrez vous connecter gr�ce au formulaire ci-contre avec les login et mot de passe que vous avez fournis lors de l\'installation.';

$lang['installation']['E_creation_base']='Une erreur s\'est produite lors de la cr�ation de la base';
$lang['installation']['E_suppression_table']='Une erreur s\'est produite lors de la suppression des tables';
$lang['installation']['E_creation_table']='Une erreur s\'est produite lors de la cr�ation des tables. {nb_table_pbm} n\'a/ont pas pu �tre cr�ee(s). V�rifiez si elle(s) n\'existe(nt) pas d�j�';
$lang['installation']['E_creation_user']='Une erreur s\'est produite lors de la cr�ation de l\'administrateur';
$lang['installation']['E_creation_club']='Une erreur s\'est produite lors de la cr�ation du club';
$lang['installation']['E_creation_conf']='Une erreur s\'est produite lors de la cr�ation du fichier de configuration. V�rifiez les droits sur vos fichiers';
$lang['installation']['E_insertion_data']='Une erreur s\'est produite lors de l\'insertion des donn�es. V�rifier si elles n\'existent pas d�j�.';
$lang['installation']['E_creation_htaccess']='Une erreur s\'est produite lors de la cr�ation du fichier .htaccess pour la r��criture des urls. V�rifiez les droits sur vos fichiers';

# update
$lang['installation']['update']='Mise � jour';
$lang['installation']['available_update']='Mise � jour disponibles';
$lang['installation']['no_update']='Aucune mise � jour n\'est disponible';
$lang['installation']['update_database_ok']='La base de donn�es a �t� mise � jour avec succ�s';
$lang['installation']['E_update_database']='Une erreur s\'est produite lors de la mise � jour de la base de donn�es';
$lang['installation']['update_conf_ok']='Le fichier de configuration a �t� mis  � jour avec succ�s';
$lang['installation']['E_update_conf']='Une erreur s\'est produite lors de la mise � jour du fichier de configuration';
$lang['installation']['update_ok']='La mise a jour est maintenant finie. Pour terminer, vous devez maintenant supprimer le r�pertoire d\'installation. Puis, <a href="{root_url}">cliquer ici pour ouvrir votre site web';

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
$lang['installation']['penalite']='P�nalit�';
$lang['installation']['drop']='Drop';

$lang['installation']['tir_2_points']='Panier � 2 points';
$lang['installation']['tir_3_points']='Panier � 3 points';
$lang['installation']['lancer_francs']='Lancer francs';
$lang['installation']['rebond']='Rebond';
$lang['installation']['passe']='Passes d�cisives';
$lang['installation']['interception']='Interception';
$lang['installation']['contre']='Contre';

# field_state
$lang['installation']['terrain_boueux']='Terrain boueux';
$lang['installation']['terrain_sec']='Terrain sec';

$lang['installation']['parquet']='Parquet';
$lang['installation']['goudron']='Goudron';
# job
$lang['installation']['president']='Pr�sident';
$lang['installation']['secretaire']='Secr�taire';
$lang['installation']['tresorier']='Tr�sorier';
$lang['installation']['president_adjoint']='Pr�sident adjoint';
# weather
$lang['installation']['temps_sec']='Temps sec';
$lang['installation']['pluie']='Pluie';
$lang['installation']['neige']='Neige';
$lang['installation']['temps_nuageux']='Temps nuageux';
# level
$lang['installation']['departemental']='D�partemental';
$lang['installation']['regional']='R�gional';
$lang['installation']['national']='National';
$lang['installation']['international']='International';
# team_name
$lang['installation']['poussin']='Poussin';
$lang['installation']['benjamin']='Benjamin';
$lang['installation']['minime']='Minime';
$lang['installation']['cadet']='Cadet';
$lang['installation']['junior']='Junior';
$lang['installation']['senior1']='S�nior 1';
$lang['installation']['senior2']='S�nior 2';
$lang['installation']['senior3']='S�nior 3';
# country
$lang['installation']['france']='France';
$lang['installation']['germany']='Allemagne';
$lang['installation']['england']='Angleterre';
$lang['installation']['spain']='Espagne';
$lang['installation']['italy']='Italie';
# period
$lang['installation']['mi_temps1']='1�re mi-temps';
$lang['installation']['mi_temps2']='2�me mi-temps';
$lang['installation']['prolongation1']='1�re prolongation';
$lang['installation']['prolongation2']='2�me prolongation';
$lang['installation']['tir_penalty']='Tir au p�nalty';

$lang['installation']['quart_temps1']='1er quart-temps';
$lang['installation']['quart_temps2']='2�me quart-temps';
$lang['installation']['quart_temps3']='3�me quart-temps';
$lang['installation']['quart_temps4']='4�me quart-temps';

# position
$lang['installation']['gardien']='Gardien';
$lang['installation']['attaquant']='Attaquant';
$lang['installation']['mifield']='Milieu';
$lang['installation']['defenseur']='D�fenseur';

$lang['installation']['pilier']='Pilier';
$lang['installation']['talonneur']='Talonneur';
$lang['installation']['deuxieme_ligne']='Deuxi�me ligne';
$lang['installation']['troisieme_ligne']='Troisi�me ligne';
$lang['installation']['demi_melee']='Demi de m�l�e';
$lang['installation']['demi_ouverture']='Demi d ouverture';
$lang['installation']['centre']='Centre';
$lang['installation']['ailier']='Ailier';
$lang['installation']['arriere']='Arri�re';

$lang['installation']['pivot']='Arri�re';
$lang['installation']['petit_ailier']='Petit ailier';
$lang['installation']['ailier_fort']='Ailier fort';
$lang['installation']['meneur']='Meneur';

# sex
$lang['installation']['masculin']='Masculin';
$lang['installation']['feminin']='F�minin';

# stats
$lang['installation']['play']='Matchs jou�s';
$lang['installation']['play_ab']='MJ';
$lang['installation']['win']='Victoires';
$lang['installation']['win_ab']='V';
$lang['installation']['percent_win']='Pourcentage de victoires';
$lang['installation']['percent_win_ab']='%V';
$lang['installation']['tie']='Matchs nuls';
$lang['installation']['tie_ab']='N';
$lang['installation']['percent_tie']='Pourcentage de nuls';
$lang['installation']['percent_tie_ab']='%N';
$lang['installation']['defeat']='D�faites';
$lang['installation']['defeat_ab']='D';
$lang['installation']['percent_defeat']='Pourcentage de d�faites';
$lang['installation']['percent_defeat_ab']='%D';
$lang['installation']['point_for']='Points pris';
$lang['installation']['point_for_ab']='PP';
$lang['installation']['point_against']='Points conc�d�s';
$lang['installation']['point_against_ab']='PC';
$lang['installation']['goal_average']='Goal Average';
$lang['installation']['goal_average_ab']='GA';

# stats_player
$lang['installation']['goal']='But';
$lang['installation']['goal_ab']='B';
$lang['installation']['goal_stop']='Arr�ts (gardien)';
$lang['installation']['goal_stop_ab']='A';
$lang['installation']['decisive_pass']='Passes d�cisives';
$lang['installation']['decisive_pass_ab']='PD';
$lang['installation']['ball_win']='Balles gagn�es';
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
$lang['installation']['penality']='P�nalit�';
$lang['installation']['penality_ab']='P';

$lang['installation']['2_points_try']='Paniers � 2 points tent�s';
$lang['installation']['2_points_try_ab']='2T';
$lang['installation']['2_points_marked']='Paniers � 2 points r�ussis';
$lang['installation']['2_points_marked_ab']='2R';
$lang['installation']['percent_2_points']='Pourcentage de r�ussite � 2 points';
$lang['installation']['percent_2_points_ab']='%2';
$lang['installation']['3_points_try']='Paniers � 3 points tent�s';
$lang['installation']['3_points_try_ab']='3T';
$lang['installation']['3_points_marked']='Paniers � 3 points r�ussis';
$lang['installation']['3_points_marked_ab']='3R';
$lang['installation']['percent_3_points']='Pourcentage de r�ussite � 3 points';
$lang['installation']['percent_3_points_ab']='%3';
$lang['installation']['free_throw_try']='Lancers francs tent�s';
$lang['installation']['free_throw_try_ab']='LFT';
$lang['installation']['free_throw_marked']='Lancers francs r�ussis';
$lang['installation']['free_throw_marked_ab']='LFR';
$lang['installation']['percent_free_throw']='Pourcentage de r�ussite au lancer francs';
$lang['installation']['percent_free_throw_ab']='%LF';
$lang['installation']['rebound_off']='Rebonds offensifs';
$lang['installation']['rebound_off_ab']='R';
$lang['installation']['rebound_def']='Rebonds d�fensifs';
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