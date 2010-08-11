<?php
/*******************************************************************/
/* MEMBER */
/*******************************************************************/

#################################
# membre
#################################
# divers
$lang['member']['member']='Membre';
$lang['member']['add_member']='Ajouter un membre';
$lang['member']['edit_member']='Modifier un membre'; // new 1.4
$lang['member']['delete_member']='Supprimer un membre'; // new 1.4
$lang['member']['member_list']='Liste des membres';
$lang['member']['view_member']='Fiche du membre';
$lang['member']['search']='Rechercher un membre';
$lang['member']['back_list']='Retour à la liste des membres';
$lang['member']['back_registration_list']='Retour à la liste des demandes d\'inscription';

$lang['member']['identity']='Identité';
$lang['member']['name']='Nom';
$lang['member']['firstname']='Prénom';
$lang['member']['email']='Email';
$lang['member']['sex']='Sexe';
$lang['member']['choose_sex']='Choisir un sexe';
$lang['member']['date_birth']='Date de naissance';
$lang['member']['place_birth']='Lieu de naissance';
$lang['member']['size']='Taille';
$lang['member']['size_unit']='cm';
$lang['member']['weight']='Poids';
$lang['member']['weight_unite']='kg';
$lang['member']['nationality']='Nationalité';
$lang['member']['comment']='Commentaires';
$lang['member']['format_date']='jj-mm-aaaa';
$lang['member']['format_date_php']='%d %B %Y';
$lang['member']['format_date_form']='%d-%m-%Y';
$lang['member']['age']='Age';
$lang['member']['age_unit']="ans";
$lang['member']['year']='Année';
$lang['member']['choose_member']='Choisir un membre';
$lang['member']['choose_nationality']='Choisir un pays';
$lang['member']['info_internaute']='Information sur l\'internaute';

$lang['member']['profile']='Mon profil';
$lang['member']['information']='Mes informations';
$lang['member']['ancien_pass']='Mot de passe actuel';
$lang['member']['nouveau_pass']='Nouveau mot de passe';
$lang['member']['login']='Login';
$lang['member']['pass']='Mot de passe';
$lang['member']['confirm_pass']='Mot de passe (confirmation)';
$lang['member']['explication_pass']='Laissez le champ vide si vous ne souhaitez pas modifier le mot de passe';
$lang['member']['description']='Description';
$lang['member']['photo']='Photo';
$lang['member']['avatar']='Avatar';
$lang['member']['choose_image']='Choisir une image';
$lang['member']['status']='Statut';
$lang['member']['choose_status']='Choisir un statut';
$lang['member']['status_0']='Simple membre';
$lang['member']['status_1']='Administrateur';
$lang['member']['status_2']='Super administrateur';
$lang['member']['status_-1']='Bloqué';
$lang['member']['status_member_info']='Le membre a accès à son espace personnel mais n\'a pas d\'autres droits';
$lang['member']['status_admin_info']='Le membre peut proposer des articles et ajouter des matchs, mais n\'a pas accès à la configuration du site';
$lang['member']['status_super_admin_info']='Le membre a accès à toute la partie administration';
$lang['member']['status_blocked_info']='Le compte du membre est bloqué, il ne peut plus se connecter à son espace personnel';

$lang['member']['valid']='Etat du compte';
$lang['member']['valid_0']='Le compte est inactif';
$lang['member']['valid_1']='Le compte est activé';
$lang['member']['valid_-1']='Le membre a fait une demande d\'activation de son compte';
$lang['member']['valid_-2']='Le membre doit confirmer l\'activation de son compte. Le lien d\'activation lui a été envoyé par email.';
$lang['member']['activation']='Activation de compte';
$lang['member']['activation_done']='Le compte est d\'ors et déjà actif';
$lang['member']['activation_ok']='Le compte a bien été activé. Vous pouvez dès à présent vous connecter à votre espace membre.';
$lang['member']['activation_pbm']='Une erreur s\'est produite lors de l\'activation du compte. Si le problème persiste, merci de contacter le webmaster du site.';
$lang['member']['member_a_activer']='Ces membres ont demandé l\'activation de leur compte';
$lang['member']['confirmation_list']='Inscriptions validées en attente de confirmation du membre';

$lang['member']['mail_activation_subject']="Confirmation de votre inscription";
$lang['member']['mail_activation_message']='Bonjour {firstname},

Vous vous êtes récemment inscrit sur le site "{site_title}" ({site_url}) avec cette adresse email. Pour finaliser votre inscription et activer votre compte, merci de cliquer sur le lien ci-dessous :
{link_activation}
(Si le clic ne fonctionne pas, essayez de faire un copier/coller dans votre navigateur)

Si vous n\'avez fait aucune demande d\'inscription, merci de ne pas tenir compte de ce message.
N\'hésitez pas à contacter {sender_email} si vous avez des questions.

Merci,
{sender_name}';

$lang['member']['mail_activation_sent']='L\'email de demande de confirmation a été envoyé avec succès au membre';
$lang['member']['E_mail_activation_sent']='Une erreur s\'est produite lors de l\'envoi de l\'email de demande de confirmation. Veuillez vérifier que les paramètres de votre vous autorisent à envoyer des emails.';


$lang['member']['referee_list']='Liste des arbitres';
$lang['member']['manager_list']='Liste des dirigeants';
$lang['member']['coach_list']='Liste des entraîneurs';
$lang['member']['player_list']='Liste des joueurs';

$lang['member']['show_view']='Détails';
$lang['member']['team_player']='A joué dans les équipes suivantes';
$lang['member']['team_coach']='A entraîné les équipes suivantes';

$lang['member']['stats']='Statistiques';

# import
$lang['member']['import_member']='Importer une liste de membres';
$lang['member']['csv_file']='Fichier .csv';
$lang['member']['separator']='Caractère séparateur';
$lang['member']['column']='Colonne';
$lang['member']['file_column']='Colonne du fichier .csv';
$lang['member']['associated_field']='Champ correspondant';
$lang['member']['first_line']='La première ligne contient le nom des colonnes';
$lang['member']['step']='Etape';
$lang['member']['choose_field']='Choisir un champ';

$lang['member']['upload_file']='Upload du fichier';
$lang['member']['associate_field']='Correspondance des champs';
$lang['member']['associate_value']='Correspondance des données';
$lang['member']['check_data']='Vérification des données avant importation';

$lang['member']['upload_file_info']='Choisissez le fichier contenant la liste des membres à importer. Attention il doit être au format .csv. A cette étape, aucune information ne sera enregistrée dans la base de données.';
$lang['member']['associate_field_info']='Pour chaque colonne de votre liste, choisissez les champs de membres correspondants. A cette étape, aucune information ne sera enregistrée dans la base de données.';
$lang['member']['associate_value_info']='Certaines données de votre liste ont besoin d\'être associées aux valeurs déjà existantes dans la base de données. Sélectionner les informations correspondantes ou choisissez "Ajouter comme nouvelle valeur" pour que la donnée soit enregistrée comme un nouvel élément. A cette étape, aucune information ne sera enregistrée dans la base de données.';
$lang['member']['check_data_info']='Les membres de votre liste vont maintenant être enregistrés dans la base de données. Avant leur importation, prenez le temps de vérifier les informations soumises. 
S\'il s\'agit d\'un nouveau membre, alors choisissez l\'option "Ajouter comme nouveau membre".
S\'il s\'agit d\'un membre qui existe déjà, alors choisissez l\'option "Fusionner". Le membre sera alors mis à jour avec les nouvelles données soumises.
Si vous ne souhaitez pas importer un membre, alors choisissez l\'option "Ne pas importer." ';

$lang['member']['no_value_to_associate']='Il n\'y a pas de données à associer. Vous pouvez donc ignorer cette étape et continuer l\'importation';

$lang['member']['action']='Action';
$lang['member']['import_new_member']='Ajouter comme nouveau membre';
$lang['member']['merge_member']='Fusionner avec le membre';
$lang['member']['dont_import']='Ne pas importer';
$lang['member']['choose_member']='Choisir un membre';

$lang['member']['add_new_value']='Ajouter comme nouvelle valeur';

$lang['member']['E_found_member']='Attention certains membres comportant des informations similaires ont été trouvés dans la base de données';
$lang['member']['E_empty_file']='Veuillez sélectionner un fichier';
$lang['member']['E_invalid_file_type']='Le fichier doit avoir l\'un des formats suivants : {type}';
$lang['member']['E_invalid_file_size']='Le poids du fichier doit être inférieur à {max_file_size}';
$lang['member']['E_empty_separator']='Veuillez saisir un caractère séparateur';
$lang['member']['E_empty_member_lastname_field']='Le champ "Nom" est obligatoire';
$lang['member']['E_empty_member_firstname_field']='Le champ "Prénom" est obligatoire';
$lang['member']['E_exists_member_field']='Vous ne pouvez pas avoir deux champs identiques';
$lang['member']['E_exist_members']='Les membres suivants existent déjà : {member}';
$lang['member']['E_invalid_member_name']='Deux membres ne peuvent avoir le même nom : {member}';
$lang['member']['E_invalid_email_members']='Les emails de ces membres sont invalides : {member}';
$lang['member']['E_invalid_date_birth_members']='Les dates de naissance de ces membres sont invalides : {member}';
$lang['member']['E_invalid_login_members']='Les logins des membres ci-après sont invalides : {member}. Ils doivent avoir entre 4 et 20 caractères, sans espace ni caractère spécial.';
$lang['member']['E_empty_member_merge']='Pour certaines fusions, vous n\'avez pas choisi de membre';
$lang['member']['E_empty_members_name']='Veuillez saisir un nom pour tous les membres';
$lang['member']['E_empty_value_associate']="Veuillez choisir une valeur associée pour chacune des données de la liste.";
$lang['member']['E_empty_season']="Veuillez choisir une saison";

$lang['member']['import_member_1']='Les membres ont été importés avec succès';


# formulaire
$lang['member']['form_member_add']='Ajouter un membre';
$lang['member']['form_member_edit']='Modifier un membre';
$lang['member']['form_member_add_1']='Insertion réussie';
$lang['member']['form_member_add_0']='Problème lors de l\'insertion';
$lang['member']['form_member_edit_1']='Modification réussie';
$lang['member']['form_member_edit_0']='Problème lors de la modification';
$lang['member']['form_member_sup_1']='Suppression réussie';
$lang['member']['form_member_sup_0']='Problème lors de la suppression';

$lang['member']['form_pass']='Changement de mot de passe';
$lang['member']['form_pass_edit_1']='Modification réussie';
$lang['member']['form_pass_edit_0']='Problème lors de la modification';

# erreur
$lang['member']['E_empty_name']='Veuillez saisir un nom';
$lang['member']['E_empty_firstname']='Veuillez saisir un prénom';
$lang['member']['E_empty_email']='Veuillez saisir un email';
$lang['member']['E_invalid_email']='L\'adresse email saisie est invalide';
$lang['member']['E_choisi_email']='Cet email a déjà été choisi par un autre membre';
$lang['member']['E_absent_email']='Cet email ne correspond à aucun membre';
$lang['member']['E_empty_sex']='Veuillez choisir un sexe';
$lang['member']['E_empty_date_birth']='Veuillez saisir une date de naissance';
$lang['member']['E_invalid_date_birth']='La date de naissance saisie est invalide';
$lang['member']['E_invalid_size']='La taille saisie est invalide';
$lang['member']['E_invalid_weight']='Le poids saisi est invalide';
$lang['member']['E_empty_country']='Veuillez choisir une nationalité';
$lang['member']['E_exist_member']='Ce membre est déjà inscrit';
$lang['member']['E_member_not_found']='Aucun membre n\'a été trouvé';
$lang['member']['E_suppression_member_administrateur']='Vous ne pouvez pas supprimer l\'administrateur principal du site';
$lang['member']['E_suppression_member_connecte']='Vous ne pouvez pas supprimer votre propre compte';
$lang['member']['E_modification_member_administrateur']='Vous ne pouvez pas modifier le status ni l\'état du compte de l\'administrateur principal du site';
$lang['member']['E_modification_compte_administrateur']='Vous ne pouvez pas modifier le compte de l\'administrateur principal du site';
$lang['member']['E_empty_login']='Veuillez saisir un login';
$lang['member']['E_invalid_login']='Le login saisi est invalide';
$lang['member']['E_choisi_login']='Ce login a déjà été choisi par un autre membre';
$lang['member']['E_absent_login']='Ce login n\'est pas présent dans notre base de données';
$lang['member']['E_empty_pass']='Veuillez saisir un mot de passe';
$lang['member']['E_invalid_pass']='Ce mot de passe est invalide';
$lang['member']['E_empty_confirm_pass']='Veuillez confirmer votre mot de passe';
$lang['member']['E_pass_different']='Attention vos mots de passe sont différents';
$lang['member']['E_empty_ancien_pass']='Veuillez saisir votre mot de passe actuel';
$lang['member']['E_empty_nouveau_pass']='Veuillez saisir un nouveau mot de passe';
$lang['member']['E_invalid_ancien_pass']='Le mot de passe actuel saisi est invalide';
$lang['member']['E_invalid_avatar']='L\'adresse web choisie pour l\'avatar est invalide';


# membre_club
$lang['member']['E_empty_member_club']='Veuillez choisir une saison et un club';
$lang['member']['member_club']='Club(s)';
$lang['member']['season']='Saison';
$lang['member']['choose_season']='Choisir une saison';
$lang['member']['club']='Club';
$lang['member']['choose_club']='Choisir un club';

# membre_job
$lang['member']['E_empty_member_job']='Veuillez choisir une saison et une fonction';
$lang['member']['member_job']='Fonction(s)';
$lang['member']['job']='Fonction';
$lang['member']['choose_job']='Choisir une fonction';
$lang['member']['member_job_list']='L\'équipe de direction';
$lang['member']['dirigeant']='Dirigeant';

# home
$lang['member']['home']='Découvrez les membres';

# home member
$lang['member']['home_member']='Mon espace perso';
$lang['member']['member_team']='Mes équipes';
$lang['member']['member_next_matches']='Mes prochains matchs';
$lang['member']['administration']='Espace administration';

#################################
# registration
#################################
# registration
$lang['member']['registration']='Inscription';
$lang['member']['form_registration']='Formulaire d\'inscription';
$lang['member']['register']='S\'inscrire';
$lang['member']['registration_list']='Inscriptions en attente de validation';
$lang['member']['registration_list_info']='membre(s) souhaite(nt) une activation de compte';
$lang['member']['date_registration']='Date d\'inscription';
$lang['member']['form_registration_validation']='Validation des inscriptions';
$lang['member']['registration_info']='Pour effectuer une demande d\'inscription, il vous suffit de remplir le formulaire ci-dessous. Votre demande sera envoyée au webmaster qui vérifiera les informations soumises. Une fois votre compte validé, vous pourrez alors vous connecter à votre espace membre et participer à la vie du site.';

$lang['member']['form_registration_add_1']='Votre inscription s\'est déroulée avec succès. Dès que le webmaster aura validé votre inscription, vous pourrez vous connecter à votre espace membre et participer à la vie du site.';
$lang['member']['form_registration_add_0']='Une erreur s\'est produite lors de l\'inscription. Si le problème persiste, merci de contacter le webmaster du site.';

$lang['member']['valid_registration']='Cette inscription correspond à :';
$lang['member']['add_registration']='Un nouveau membre';
$lang['member']['add_registration_info']='L\'inscription sera validée, le compte sera actif et le membre pourra se connecter au site.';
$lang['member']['merge_registration']='Un membre existant :';
$lang['member']['merge_registration_info']='Les informations soumises seront fusionnées avec le membre sélectionné. 
Une demande de confirmation sera envoyée par email au membre sélectionné afin de vérifier l\'identité du demandeur';
$lang['member']['refuse_registration']='Une erreur ou un abus';
$lang['member']['refuse_registration_info']='L\'inscription sera refusée, le compte sera bloqué et le demandeur ne pourra pas se connecter.';

$lang['member']['form_registration_validation_add_1']='L\'inscription de ce nouveau membre a été validée avec succès';
$lang['member']['form_registration_validation_merge_1']='Les données de cette inscription ont été fusionnées avec succès avec celle du membre existant';
$lang['member']['form_registration_validation_refuse_1']='Cette inscription a bien été refusée.';
$lang['member']['form_registration_validation_0']='Une erreur s\'est produite lors de la validation de cette inscription';

$lang['member']['mail_registration_subject']='Bienvenue sur {site_title}';
$lang['member']['mail_registration_message']='Bonjour {firstname},

Vous vous êtes récemment inscrit sur le site "{site_title}" ({site_url}). Les informations que vous avez soumises vont maintenant être vérifiées par le webmaster. Une fois votre compte validé, vous pourrez vous connecter à votre espace membre. Voici pour rappel vos identifiants de connexion : 

Login : {login}
Mot de passe : {pass}

Si vous n\'avez fait aucune demande d\'inscription, merci de ne pas tenir compte de ce message.
N\'hésitez pas à contacter {sender_email} si vous avez des questions.

Merci,
{sender_name}';

$lang['member']['E_empty_action']='Veuillez choisir l\'action à réaliser';
$lang['member']['E_empty_member']='Veuillez choisir un membre';
$lang['member']['E_registration_validation']='Aucune demande d\'inscription n\'a été faite pour ce compte';
$lang['member']['E_different_email']='Attention, l\'email saisie lors de l\'inscription par le demandeur est different de l\'email du membre sélectionné. Un email va être envoyé au membre sélectionné pour vérifier l\'identité du demandeur. Etes-vous sur de vouloir continuer ?';
$lang['member']['E_empty_email_merge']='Attention, le membre que vous avez sélectionné n\'a pas d\'adresse email. L\'email de demande de confirmation ne pourra pas être envoyé et l\'identité du demandeur ne pourra pas être vérifiée. Souhaitez-vous quand même fusionner les informations et activer le compte ?';
$lang['member']['E_inactive_mail']='Attention, vous n\'avez pas activé l\'envoi d\'email dans la configuration du site. L\'email de demande de confirmation ne pourra pas être envoyé. Souhaitez-vous quand même fusionner les informations et activer le compte ? ';
$lang['member']['E_no_registration']='Les inscriptions au site ne sont pas ouvertes. Si vous avez des questions, merci de contacter le webmaster.';

# forget pass
$lang['member']['forgot_pass']='Mot de passe oublié ?';
$lang['member']['forgot_pass_info']='Vous avez perdu votre mot de passe ? Recevez un nouveau mot de passe par email en complétant le formulaire ci-contre.';
$lang['member']['form_forgot_pass']='Formulaire d\'envoi de nouveau mot de passe';
$lang['member']['E_no_forgot_pass']='L\'envoi de nouveau mot de passe n\'est pas ouvert. Si vous avez des questions, merci de contacter le webmaster.';
$lang['member']['forgot_pass_ok']='Votre nouveau mot de passe a bien été créé. Vous devriez bientôt le recevoir par email.';
$lang['member']['forgot_pass_pbm']='Une erreur s\'est produite lors de l\'envoi du nouveau mot de passe. Si le problème persiste, merci de contacter le webmaster du site.';
$lang['member']['mail_forgot_pass_subject']='Votre nouveau mot de passe';
$lang['member']['mail_forgot_pass_message']='Bonjour {firstname},

Vous avez récemment effectué une demande de nouveau mot de passe sur le site "{site_title}". Voici vos nouveaux identifiants de connexion :

Login : {login}
Mot de passe : {pass}

Pour vous connecter à votre espace membre, rendez-vous sur {site_url}.

A très bientôt,
{sender_name}';




#################################
# job
#################################
# divers
$lang['member']['add_job']='Ajouter une fonction';
$lang['member']['job_list']='Fonctions des dirigeants';

# formulaire
$lang['member']['form_job']='Fonctions des dirigeants';
$lang['member']['form_job_add_1']='Insertion réussie';
$lang['member']['form_job_add_0']='Problème lors de l\'insertion';
$lang['member']['form_job_edit_1']='Modification réussie';
$lang['member']['form_job_edit_0']='Problème lors de la modification';
$lang['member']['form_job_sup_1']='Suppression réussie';
$lang['member']['form_job_sup_0']='Problème lors de la suppression';

# erreur
$lang['member']['E_empty_name_job']='Veuillez saisir une fonction';
$lang['member']['E_exist_job']='Cette fonction est déjà présente';
$lang['member']['E_exist_job_member']='Un dirigeant ayant cette fonction existe';

#################################
# level
#################################
# divers
$lang['member']['level']='Niveau d\'arbitrage';
$lang['member']['add_level']='Ajouter un niveau';
$lang['member']['level_list']='Niveaux des arbitres';
$lang['member']['referee']='Arbitre';
$lang['member']['choose_level']='Aucun niveau';

# formulaire
$lang['member']['form_level']='Niveaux des arbitres';
$lang['member']['form_level_add_1']='Insertion réussie';
$lang['member']['form_level_add_0']='Problème lors de l\'insertion';
$lang['member']['form_level_edit_1']='Modification réussie';
$lang['member']['form_level_edit_0']='Problème lors de la modification';
$lang['member']['form_level_sup_1']='Suppression réussie';
$lang['member']['form_level_sup_0']='Problème lors de la suppression';

# erreur
$lang['member']['E_empty_name_level']='Veuillez saisir un niveau';
$lang['member']['E_exist_level']='Ce niveau est déjà présent';
$lang['member']['E_exist_level_member']='Un arbitre ayant ce niveau existe';

#################################
# sex
#################################
# divers
$lang['member']['sex']='Sexe';
$lang['member']['add_sex']='Ajouter un sexe';
$lang['member']['sex_list']='Sexe des membres';
$lang['member']['abbreviation']='Abréviation';

# formulaire
$lang['member']['form_sex']='Sexe des membres';
$lang['member']['form_sex_add_1']='Insertion réussie';
$lang['member']['form_sex_add_0']='Problème lors de l\'insertion';
$lang['member']['form_sex_edit_1']='Modification réussie';
$lang['member']['form_sex_edit_0']='Problème lors de la modification';
$lang['member']['form_sex_sup_1']='Suppression réussie';
$lang['member']['form_sex_sup_0']='Problème lors de la suppression';

# erreur
$lang['member']['E_empty_name_sex']='Veuillez saisir un sexe';
$lang['member']['E_empty_abbreviation_sex']='Veuillez saisir une abréviation';
$lang['member']['E_exist_sex']='Ce sexe est déjà présent';
$lang['member']['E_exist_sex_member']='Un membre ayant ce sexe existe';

#################################
# country
#################################
# divers
$lang['member']['country']='Pays';
$lang['member']['add_country']='Ajouter un pays';
$lang['member']['country_list']='Pays';

# formulaire
$lang['member']['form_country']='Pays';
$lang['member']['form_country_add_1']='Insertion réussie';
$lang['member']['form_country_add_0']='Problème lors de l\'insertion';
$lang['member']['form_country_edit_1']='Modification réussie';
$lang['member']['form_country_edit_0']='Problème lors de la modification';
$lang['member']['form_country_sup_1']='Suppression réussie';
$lang['member']['form_country_sup_0']='Problème lors de la suppression';

# erreur
$lang['member']['E_empty_name_country']='Veuillez saisir un pays';
$lang['member']['E_exist_country']='Ce pays est déjà présent';
$lang['member']['E_exist_country_member']='Un membre ayant cette nationalité existe';

#################################
# group // new 1.4
#################################
# divers
$lang['member']['group']='Groupe'; // new 1.4
$lang['member']['choose_group']='Choisir un groupe'; // new 1.4
$lang['member']['add_group']='Ajouter un groupe'; // new 1.4
$lang['member']['group_list']='Liste des groupes'; // new 1.4
$lang['member']['description']='Description'; // new 1.4
$lang['member']['right_management']='Gérer les droits des groupes'; // new 1.4

# formulaire
$lang['member']['form_group']='Gestion des groupes'; // new 1.4
$lang['member']['form_group_add_1']='Insertion réussie'; // new 1.4
$lang['member']['form_group_add_0']='Problème lors de l\'insertion'; // new 1.4
$lang['member']['form_group_edit_1']='Modification réussie'; // new 1.4
$lang['member']['form_group_edit_0']='Problème lors de la modification'; // new 1.4
$lang['member']['form_group_sup_1']='Suppression réussie'; // new 1.4
$lang['member']['form_group_sup_0']='Problème lors de la suppression'; // new 1.4

$lang['member']['form_group_right_edit_1']='Modification réussie'; // new 1.4
$lang['member']['form_group_right_edit_0']='Problème lors de la modification'; // new 1.4

# erreur
$lang['member']['E_empty_name_group']='Veuillez saisir un nom de groupe'; // new 1.4
$lang['member']['E_empty_description_group']='Veuillez saisir une description'; // new 1.4
$lang['member']['E_exist_group']='Ce groupe est déjà présent'; // new 1.4
$lang['member']['E_exist_group_member']='Ce groupe possède un membre et ne peut donc être supprimé'; // new 1.4
$lang['member']['E_cant_delete_default_group']='Les groupes par défaut ne peuvent pas être supprimés'; // new 1.4

#################################
# commun
#################################
# divers
$lang['member']['submit']='Valider';
$lang['member']['cancel']='Annuler';
$lang['member']['edit']='Modifier';
$lang['member']['check']='Vérifier';
$lang['member']['delete']='Supprimer';
$lang['member']['add']='Ajouter';
$lang['member']['order_by']='Trier par';

# page
$lang['member']['first_page']='Première page';
$lang['member']['previous_page']='Précédente';
$lang['member']['next_page']='Suivante';
$lang['member']['last_page']='Dernière page';


?>