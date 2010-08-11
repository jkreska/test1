<?php
/*******************************************************************/
/* ADMINISTRATION */
/*******************************************************************/

#################################
# administration
#################################
# divers
$lang['administration']['administration']='Administration';
$lang['administration']['administration_zone']='Espace administration';
$lang['administration']['parametre']='Configuration';
$lang['administration']['home_administration']='Tableau de bord';
$lang['administration']['welcome']='Bienvenue dans l\'espace d\'administration. Vous allez pouvoir g�rer l\'ensemble  des donn�es du site (matchs, articles, membres, etc.) gr�ce aux formulaires d\'ajout, et de modification accessible via le menu d\'administration.
Revenez r�guli�rement sur ce tableau de bord o� vous trouverez toutes les actions � faire : ajouter le score d\'un match termin�, �l�ments � mettre � jour, etc...';
$lang['administration']['configuration']='Configuration du site';
$lang['administration']['configuration_text']='La configuration du site ne semble pas �tre termin�e. V�rifier que toutes les informations n�cessaires au bon fonctionnement du site ont bien �t� enregistr�es : ';
$lang['administration']['change_configuration']='Changer le param�trage du site';
$lang['administration']['end_installation']='Attention, pour des raisons de s�curit�, il est n�cessaire de delete le dossier d\'installation pour que le site soit fonctionnel. Une fois supprim�, il vous suffit de rafra�chir cette page.';
$lang['administration']['update']='Une mise � jour du site est en cours.';
$lang['administration']['mettre_a_day']='Lancer la mise � jour';

# configuration
$lang['administration']['information_site']='Information sur le site';
$lang['administration']['information_site_ab']='Le site';
$lang['administration']['title']='Titre du site';
$lang['administration']['url']='Adresse web (url)';
$lang['administration']['root']='Racine (root)';
$lang['administration']['information_mail']='Utilisation des emails';
$lang['administration']['information_mail_ab']='Emails';
$lang['administration']['email']='Email du webmestre';
$lang['administration']['sender_name']='Signature pour les emails';
$lang['administration']['activate_mail']='Autoriser l\'envoi d\'emails';
$lang['administration']['activate_mail_info']='Le site pourra alors envoy� des emails aux membres comme par exemple dans le cas des inscriptions. La fonction mail() de votre serveur doit �tre active.';
$lang['administration']['information_base']='Information sur le serveur et la base de donn�es';
$lang['administration']['information_base_ab']='Base de donn�es';
$lang['administration']['host']='H�te';
$lang['administration']['user']='Nom d\'utilisateur';
$lang['administration']['password']='Mot de passe';
$lang['administration']['base']='Nom de la base';
$lang['administration']['prefix']='Pr�fixe des tables';
$lang['administration']['information_sport']='Information sur le sport';
$lang['administration']['information_sport_ab']='Sport';
$lang['administration']['nb_player']='Nb max de joueurs titulaires dans une �quipe';
$lang['administration']['info_url']='sans / � la fin';
$lang['administration']['url_rewrite']='Activer la r��criture des urls'; 
$lang['administration']['info_url_rewrite']='La r��criture des urls permet de rendre plus lisibles les adresses web comportant des variables. Par exemple, l\'adresse http://www.monsite.com/index.php?lg=fr&r=news&v1=page1 sera affich�e  http://www.monsite.com/fr/news/page1.html. A noter que cela ne change en rien les performances du site.';
$lang['administration']['website_status']='Statut du site'; 
$lang['administration']['site_open']='Le site est ouvert � tous';
$lang['administration']['site_closed']='Le site est en construction. Il est ferm� aux visiteurs et seul l\'administrateur peut se connecter.';
$lang['administration']['language']='Langue';
$lang['administration']['template']='Design';
$lang['administration']['avatar_folder']='Dossier des avatars';
$lang['administration']['info_avatar_folder']='Choisissez le dossier o� les utilisateurs pourront s�lectionner un avatar (Un avatar est une image repr�sentant un utilisateur). Si le dossier comporte des sous-dossiers, alors les utilisateurs y auront aussi acc�s.';

$lang['administration']['example']='Ex.';
$lang['administration']['example_title']='Mon club de sport';
$lang['administration']['example_url']='http://www.monsite.com';
$lang['administration']['example_email']='contact@monsite.com';
$lang['administration']['example_sender_name']='Le webmaster de Mon club de sport';
$lang['administration']['example_root']='/var/www/monsite';
$lang['administration']['example_user']='root';
$lang['administration']['example_host']='localhost';
$lang['administration']['example_base']='mabase';

$lang['administration']['configuration_ok']='Modification r�ussie';

# configuration mini-standings
$lang['administration']['mini_standings']='Mini-classement';
$lang['administration']['mini_standings_ab']='Mini-classement';
$lang['administration']['ms_show']='Afficher le mini-classement';
$lang['administration']['ms_show_all']='Sur toutes les pages';
$lang['administration']['ms_show_home']='Sur la page d\'accueil';
$lang['administration']['ms_show_none']='Ne pas afficher';
$lang['administration']['ms_column']='Colonnes � afficher';
$lang['administration']['ms_default_competition']='Comp�tition par d�faut';
$lang['administration']['ms_nb_club_max']='Nombre maximum de clubs';
$lang['administration']['ms_show_form']='Laissez les visiteurs choisir';

# content settings
$lang['administration']['content_settings']='Affichage du contenu';
$lang['administration']['content_settings_ab']='Contenu';
$lang['administration']['nb_item_page']='Nombre d\'�l�ments par page';
$lang['administration']['nb_item_home_page']='Nombre d\'�l�ments sur la page d\'accueil';
$lang['administration']['E_empty_content_settings']='Attention certains champs de la gestion du contenu sont vides ';
$lang['administration']['E_invalid_content_settings_integer']='Attention certains champs de la gestion du contenu ne sont pas des nombres';
$lang['administration']['E_invalid_content_settings_range']='Attention les champs de la gestion du contenu doivent avoir une valeur comprise entre 1 et 100';

# Registration
$lang['administration']['registration']='Inscription des membres';
$lang['administration']['registration_ab']='Inscription';
$lang['administration']['activate_registration']='Activer les inscriptions';
$lang['administration']['activate_registration_info']='Un lien "S\'incrire" apparaitra sur les pages. Les inscriptions ne seront actives qu\'apr�s validation par le webmaster';
$lang['administration']['registration_mail']='Activer l\'envoi d\'email de confirmation';
$lang['administration']['registration_mail_info']='Lors de l\'inscription, les membres recevront un email avec leurs identifiants de connexion. Lorsque l\'inscription sera valid�e par le webmaster, les membres recevront une confirmation par email.';

# erreur
$lang['administration']['E_creation_conf']='Une erreur s\'est produite lors de la modification des param�tres';
$lang['administration']['E_empty_title']='Veuillez saisir un titre';
$lang['administration']['E_empty_url']='Veuillez saisir l\'url du site';
$lang['administration']['E_invalid_url']='L\'url saisie est invalide. V�rifiez que le site est bien accessible � cette adresse';
$lang['administration']['E_empty_root']='Veuillez saisir l\'adresse du r�pertoire racine du site';
$lang['administration']['E_invalid_root']='L\'adresse du r�pertoire racine du site est invalide. V�rifiez que les fichiers du site sont bien plac�s dans le r�pertoire indiqu�';
$lang['administration']['E_invalid_email']='L\'adresse email saisie est invalide';
$lang['administration']['E_empty_host']='Veuillez saisir un nom d\'h�te';
$lang['administration']['E_empty_user_base']='Veuillez saisir un nom d\'utilisateur pour la base';
$lang['administration']['E_empty_name_base']='Veuillez saisir le nom de la base de donn�es';
$lang['administration']['E_invalid_connection_base']='Impossible de se connecter au serveur MySQL, veuillez v�rifier les informations saisies';
$lang['administration']['E_invalid_selection_base']='Impossible de s�lectionner la base de donn�es, veuillez v�rifier les informations saisies';
$lang['administration']['E_disable_mail']='La fonction mail() de votre serveur est d�sactiv�e. L\'utilisation des emails est donc impossible.'; // new .3
$lang['administration']['E_invalid_registration_mail']='Pour activer l\'envoi d\'emails lors des inscriptions, vous devez auparavant autoriser l\'utilisation des emails dans la configuration des emails.';
$lang['administration']['E_invalid_sender_name']='Pour que l\'envoi d\'emails soit op�rationnel, merci de saisir une adresse email et une signature.';

# plugin 
$lang['administration']['plugin']='Plugin';
$lang['administration']['plugin_list']='Plugins';
$lang['administration']['plugin_to_install']='Certains plugins n\'ont pas encore �t� install�';
$lang['administration']['plugin_install']='installer ce plugin';
$lang['administration']['plugin_management']='Gestion des plugins';  // new 1.4

# menu management // new 1.4
$lang['administration']['menu_management']='Gestion des menus';
$lang['administration']['website_menu']='Menu du site';
$lang['administration']['available_pages']='Pages disponibles';
$lang['administration']['default_pages']='Listes des pages';
$lang['administration']['internal_pages']='Pages internes';
$lang['administration']['external_pages']='Liens externes';
$lang['administration']['page_title']='Titre';
$lang['administration']['page_url']='URL';
$lang['administration']['page_target']='Cible';
$lang['administration']['page_css']="Class CSS";
$lang['administration']['new_window']='Nouvelle fen�tre';
$lang['administration']['same_window']='M�me fen�tre';
$lang['administration']['add_page']='Ajouter';
$lang['administration']['E_no_title']='Veuillez compl�ter les champs';

$lang['administration']['menu_management_info']='Pour ajouter une page dans le menu, s�lectionner une page dans la liste des pages disponibles et d�placez-la dans le menu du site. Pour supprimer une page du menu, d�placer la page vers la liste des pages disponibles. N\'oubliez pas d\'enregistrer une fois termin�.';

$lang['administration']['reset_menu']='R�initialiser (menu par d�faut)';
$lang['administration']['save']='Sauvegarder';
$lang['administration']['cancel']='Annuler';
$lang['administration']['delete']='Supprimer';

# right management // new 1.4
$lang['administration']['right_management']='Gestion des droits utilisateurs';  // new 1.4
$lang['administration']['right']='Droit';  // new 1.4
$lang['administration']['group_list']='G�rer les groupes'; // new 1.4


#################################
# commun
#################################
# divers
$lang['administration']['erreur']='Attention il y a une ou des erreur(s)';
$lang['administration']['submit']='Valider';
$lang['administration']['yes']='Oui';
$lang['administration']['no']='Non';

?>