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
$lang['member']['back_list']='Retour � la liste des membres';
$lang['member']['back_registration_list']='Retour � la liste des demandes d\'inscription';

$lang['member']['identity']='Identit�';
$lang['member']['name']='Nom';
$lang['member']['firstname']='Pr�nom';
$lang['member']['email']='Email';
$lang['member']['sex']='Sexe';
$lang['member']['choose_sex']='Choisir un sexe';
$lang['member']['date_birth']='Date de naissance';
$lang['member']['place_birth']='Lieu de naissance';
$lang['member']['size']='Taille';
$lang['member']['size_unit']='cm';
$lang['member']['weight']='Poids';
$lang['member']['weight_unite']='kg';
$lang['member']['nationality']='Nationalit�';
$lang['member']['comment']='Commentaires';
$lang['member']['format_date']='jj-mm-aaaa';
$lang['member']['format_date_php']='%d %B %Y';
$lang['member']['format_date_form']='%d-%m-%Y';
$lang['member']['age']='Age';
$lang['member']['age_unit']="ans";
$lang['member']['year']='Ann�e';
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
$lang['member']['status_-1']='Bloqu�';
$lang['member']['status_member_info']='Le membre a acc�s � son espace personnel mais n\'a pas d\'autres droits';
$lang['member']['status_admin_info']='Le membre peut proposer des articles et ajouter des matchs, mais n\'a pas acc�s � la configuration du site';
$lang['member']['status_super_admin_info']='Le membre a acc�s � toute la partie administration';
$lang['member']['status_blocked_info']='Le compte du membre est bloqu�, il ne peut plus se connecter � son espace personnel';

$lang['member']['valid']='Etat du compte';
$lang['member']['valid_0']='Le compte est inactif';
$lang['member']['valid_1']='Le compte est activ�';
$lang['member']['valid_-1']='Le membre a fait une demande d\'activation de son compte';
$lang['member']['valid_-2']='Le membre doit confirmer l\'activation de son compte. Le lien d\'activation lui a �t� envoy� par email.';
$lang['member']['activation']='Activation de compte';
$lang['member']['activation_done']='Le compte est d\'ors et d�j� actif';
$lang['member']['activation_ok']='Le compte a bien �t� activ�. Vous pouvez d�s � pr�sent vous connecter � votre espace membre.';
$lang['member']['activation_pbm']='Une erreur s\'est produite lors de l\'activation du compte. Si le probl�me persiste, merci de contacter le webmaster du site.';
$lang['member']['member_a_activer']='Ces membres ont demand� l\'activation de leur compte';
$lang['member']['confirmation_list']='Inscriptions valid�es en attente de confirmation du membre';

$lang['member']['mail_activation_subject']="Confirmation de votre inscription";
$lang['member']['mail_activation_message']='Bonjour {firstname},

Vous vous �tes r�cemment inscrit sur le site "{site_title}" ({site_url}) avec cette adresse email. Pour finaliser votre inscription et activer votre compte, merci de cliquer sur le lien ci-dessous :
{link_activation}
(Si le clic ne fonctionne pas, essayez de faire un copier/coller dans votre navigateur)

Si vous n\'avez fait aucune demande d\'inscription, merci de ne pas tenir compte de ce message.
N\'h�sitez pas � contacter {sender_email} si vous avez des questions.

Merci,
{sender_name}';

$lang['member']['mail_activation_sent']='L\'email de demande de confirmation a �t� envoy� avec succ�s au membre';
$lang['member']['E_mail_activation_sent']='Une erreur s\'est produite lors de l\'envoi de l\'email de demande de confirmation. Veuillez v�rifier que les param�tres de votre vous autorisent � envoyer des emails.';


$lang['member']['referee_list']='Liste des arbitres';
$lang['member']['manager_list']='Liste des dirigeants';
$lang['member']['coach_list']='Liste des entra�neurs';
$lang['member']['player_list']='Liste des joueurs';

$lang['member']['show_view']='D�tails';
$lang['member']['team_player']='A jou� dans les �quipes suivantes';
$lang['member']['team_coach']='A entra�n� les �quipes suivantes';

$lang['member']['stats']='Statistiques';

# import
$lang['member']['import_member']='Importer une liste de membres';
$lang['member']['csv_file']='Fichier .csv';
$lang['member']['separator']='Caract�re s�parateur';
$lang['member']['column']='Colonne';
$lang['member']['file_column']='Colonne du fichier .csv';
$lang['member']['associated_field']='Champ correspondant';
$lang['member']['first_line']='La premi�re ligne contient le nom des colonnes';
$lang['member']['step']='Etape';
$lang['member']['choose_field']='Choisir un champ';

$lang['member']['upload_file']='Upload du fichier';
$lang['member']['associate_field']='Correspondance des champs';
$lang['member']['associate_value']='Correspondance des donn�es';
$lang['member']['check_data']='V�rification des donn�es avant importation';

$lang['member']['upload_file_info']='Choisissez le fichier contenant la liste des membres � importer. Attention il doit �tre au format .csv. A cette �tape, aucune information ne sera enregistr�e dans la base de donn�es.';
$lang['member']['associate_field_info']='Pour chaque colonne de votre liste, choisissez les champs de membres correspondants. A cette �tape, aucune information ne sera enregistr�e dans la base de donn�es.';
$lang['member']['associate_value_info']='Certaines donn�es de votre liste ont besoin d\'�tre associ�es aux valeurs d�j� existantes dans la base de donn�es. S�lectionner les informations correspondantes ou choisissez "Ajouter comme nouvelle valeur" pour que la donn�e soit enregistr�e comme un nouvel �l�ment. A cette �tape, aucune information ne sera enregistr�e dans la base de donn�es.';
$lang['member']['check_data_info']='Les membres de votre liste vont maintenant �tre enregistr�s dans la base de donn�es. Avant leur importation, prenez le temps de v�rifier les informations soumises. 
S\'il s\'agit d\'un nouveau membre, alors choisissez l\'option "Ajouter comme nouveau membre".
S\'il s\'agit d\'un membre qui existe d�j�, alors choisissez l\'option "Fusionner". Le membre sera alors mis � jour avec les nouvelles donn�es soumises.
Si vous ne souhaitez pas importer un membre, alors choisissez l\'option "Ne pas importer." ';

$lang['member']['no_value_to_associate']='Il n\'y a pas de donn�es � associer. Vous pouvez donc ignorer cette �tape et continuer l\'importation';

$lang['member']['action']='Action';
$lang['member']['import_new_member']='Ajouter comme nouveau membre';
$lang['member']['merge_member']='Fusionner avec le membre';
$lang['member']['dont_import']='Ne pas importer';
$lang['member']['choose_member']='Choisir un membre';

$lang['member']['add_new_value']='Ajouter comme nouvelle valeur';

$lang['member']['E_found_member']='Attention certains membres comportant des informations similaires ont �t� trouv�s dans la base de donn�es';
$lang['member']['E_empty_file']='Veuillez s�lectionner un fichier';
$lang['member']['E_invalid_file_type']='Le fichier doit avoir l\'un des formats suivants : {type}';
$lang['member']['E_invalid_file_size']='Le poids du fichier doit �tre inf�rieur � {max_file_size}';
$lang['member']['E_empty_separator']='Veuillez saisir un caract�re s�parateur';
$lang['member']['E_empty_member_lastname_field']='Le champ "Nom" est obligatoire';
$lang['member']['E_empty_member_firstname_field']='Le champ "Pr�nom" est obligatoire';
$lang['member']['E_exists_member_field']='Vous ne pouvez pas avoir deux champs identiques';
$lang['member']['E_exist_members']='Les membres suivants existent d�j� : {member}';
$lang['member']['E_invalid_member_name']='Deux membres ne peuvent avoir le m�me nom : {member}';
$lang['member']['E_invalid_email_members']='Les emails de ces membres sont invalides : {member}';
$lang['member']['E_invalid_date_birth_members']='Les dates de naissance de ces membres sont invalides : {member}';
$lang['member']['E_invalid_login_members']='Les logins des membres ci-apr�s sont invalides : {member}. Ils doivent avoir entre 4 et 20 caract�res, sans espace ni caract�re sp�cial.';
$lang['member']['E_empty_member_merge']='Pour certaines fusions, vous n\'avez pas choisi de membre';
$lang['member']['E_empty_members_name']='Veuillez saisir un nom pour tous les membres';
$lang['member']['E_empty_value_associate']="Veuillez choisir une valeur associ�e pour chacune des donn�es de la liste.";
$lang['member']['E_empty_season']="Veuillez choisir une saison";

$lang['member']['import_member_1']='Les membres ont �t� import�s avec succ�s';


# formulaire
$lang['member']['form_member_add']='Ajouter un membre';
$lang['member']['form_member_edit']='Modifier un membre';
$lang['member']['form_member_add_1']='Insertion r�ussie';
$lang['member']['form_member_add_0']='Probl�me lors de l\'insertion';
$lang['member']['form_member_edit_1']='Modification r�ussie';
$lang['member']['form_member_edit_0']='Probl�me lors de la modification';
$lang['member']['form_member_sup_1']='Suppression r�ussie';
$lang['member']['form_member_sup_0']='Probl�me lors de la suppression';

$lang['member']['form_pass']='Changement de mot de passe';
$lang['member']['form_pass_edit_1']='Modification r�ussie';
$lang['member']['form_pass_edit_0']='Probl�me lors de la modification';

# erreur
$lang['member']['E_empty_name']='Veuillez saisir un nom';
$lang['member']['E_empty_firstname']='Veuillez saisir un pr�nom';
$lang['member']['E_empty_email']='Veuillez saisir un email';
$lang['member']['E_invalid_email']='L\'adresse email saisie est invalide';
$lang['member']['E_choisi_email']='Cet email a d�j� �t� choisi par un autre membre';
$lang['member']['E_absent_email']='Cet email ne correspond � aucun membre';
$lang['member']['E_empty_sex']='Veuillez choisir un sexe';
$lang['member']['E_empty_date_birth']='Veuillez saisir une date de naissance';
$lang['member']['E_invalid_date_birth']='La date de naissance saisie est invalide';
$lang['member']['E_invalid_size']='La taille saisie est invalide';
$lang['member']['E_invalid_weight']='Le poids saisi est invalide';
$lang['member']['E_empty_country']='Veuillez choisir une nationalit�';
$lang['member']['E_exist_member']='Ce membre est d�j� inscrit';
$lang['member']['E_member_not_found']='Aucun membre n\'a �t� trouv�';
$lang['member']['E_suppression_member_administrateur']='Vous ne pouvez pas supprimer l\'administrateur principal du site';
$lang['member']['E_suppression_member_connecte']='Vous ne pouvez pas supprimer votre propre compte';
$lang['member']['E_modification_member_administrateur']='Vous ne pouvez pas modifier le status ni l\'�tat du compte de l\'administrateur principal du site';
$lang['member']['E_modification_compte_administrateur']='Vous ne pouvez pas modifier le compte de l\'administrateur principal du site';
$lang['member']['E_empty_login']='Veuillez saisir un login';
$lang['member']['E_invalid_login']='Le login saisi est invalide';
$lang['member']['E_choisi_login']='Ce login a d�j� �t� choisi par un autre membre';
$lang['member']['E_absent_login']='Ce login n\'est pas pr�sent dans notre base de donn�es';
$lang['member']['E_empty_pass']='Veuillez saisir un mot de passe';
$lang['member']['E_invalid_pass']='Ce mot de passe est invalide';
$lang['member']['E_empty_confirm_pass']='Veuillez confirmer votre mot de passe';
$lang['member']['E_pass_different']='Attention vos mots de passe sont diff�rents';
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
$lang['member']['member_job_list']='L\'�quipe de direction';
$lang['member']['dirigeant']='Dirigeant';

# home
$lang['member']['home']='D�couvrez les membres';

# home member
$lang['member']['home_member']='Mon espace perso';
$lang['member']['member_team']='Mes �quipes';
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
$lang['member']['registration_info']='Pour effectuer une demande d\'inscription, il vous suffit de remplir le formulaire ci-dessous. Votre demande sera envoy�e au webmaster qui v�rifiera les informations soumises. Une fois votre compte valid�, vous pourrez alors vous connecter � votre espace membre et participer � la vie du site.';

$lang['member']['form_registration_add_1']='Votre inscription s\'est d�roul�e avec succ�s. D�s que le webmaster aura valid� votre inscription, vous pourrez vous connecter � votre espace membre et participer � la vie du site.';
$lang['member']['form_registration_add_0']='Une erreur s\'est produite lors de l\'inscription. Si le probl�me persiste, merci de contacter le webmaster du site.';

$lang['member']['valid_registration']='Cette inscription correspond � :';
$lang['member']['add_registration']='Un nouveau membre';
$lang['member']['add_registration_info']='L\'inscription sera valid�e, le compte sera actif et le membre pourra se connecter au site.';
$lang['member']['merge_registration']='Un membre existant :';
$lang['member']['merge_registration_info']='Les informations soumises seront fusionn�es avec le membre s�lectionn�. 
Une demande de confirmation sera envoy�e par email au membre s�lectionn� afin de v�rifier l\'identit� du demandeur';
$lang['member']['refuse_registration']='Une erreur ou un abus';
$lang['member']['refuse_registration_info']='L\'inscription sera refus�e, le compte sera bloqu� et le demandeur ne pourra pas se connecter.';

$lang['member']['form_registration_validation_add_1']='L\'inscription de ce nouveau membre a �t� valid�e avec succ�s';
$lang['member']['form_registration_validation_merge_1']='Les donn�es de cette inscription ont �t� fusionn�es avec succ�s avec celle du membre existant';
$lang['member']['form_registration_validation_refuse_1']='Cette inscription a bien �t� refus�e.';
$lang['member']['form_registration_validation_0']='Une erreur s\'est produite lors de la validation de cette inscription';

$lang['member']['mail_registration_subject']='Bienvenue sur {site_title}';
$lang['member']['mail_registration_message']='Bonjour {firstname},

Vous vous �tes r�cemment inscrit sur le site "{site_title}" ({site_url}). Les informations que vous avez soumises vont maintenant �tre v�rifi�es par le webmaster. Une fois votre compte valid�, vous pourrez vous connecter � votre espace membre. Voici pour rappel vos identifiants de connexion : 

Login : {login}
Mot de passe : {pass}

Si vous n\'avez fait aucune demande d\'inscription, merci de ne pas tenir compte de ce message.
N\'h�sitez pas � contacter {sender_email} si vous avez des questions.

Merci,
{sender_name}';

$lang['member']['E_empty_action']='Veuillez choisir l\'action � r�aliser';
$lang['member']['E_empty_member']='Veuillez choisir un membre';
$lang['member']['E_registration_validation']='Aucune demande d\'inscription n\'a �t� faite pour ce compte';
$lang['member']['E_different_email']='Attention, l\'email saisie lors de l\'inscription par le demandeur est different de l\'email du membre s�lectionn�. Un email va �tre envoy� au membre s�lectionn� pour v�rifier l\'identit� du demandeur. Etes-vous sur de vouloir continuer ?';
$lang['member']['E_empty_email_merge']='Attention, le membre que vous avez s�lectionn� n\'a pas d\'adresse email. L\'email de demande de confirmation ne pourra pas �tre envoy� et l\'identit� du demandeur ne pourra pas �tre v�rifi�e. Souhaitez-vous quand m�me fusionner les informations et activer le compte ?';
$lang['member']['E_inactive_mail']='Attention, vous n\'avez pas activ� l\'envoi d\'email dans la configuration du site. L\'email de demande de confirmation ne pourra pas �tre envoy�. Souhaitez-vous quand m�me fusionner les informations et activer le compte ? ';
$lang['member']['E_no_registration']='Les inscriptions au site ne sont pas ouvertes. Si vous avez des questions, merci de contacter le webmaster.';

# forget pass
$lang['member']['forgot_pass']='Mot de passe oubli� ?';
$lang['member']['forgot_pass_info']='Vous avez perdu votre mot de passe ? Recevez un nouveau mot de passe par email en compl�tant le formulaire ci-contre.';
$lang['member']['form_forgot_pass']='Formulaire d\'envoi de nouveau mot de passe';
$lang['member']['E_no_forgot_pass']='L\'envoi de nouveau mot de passe n\'est pas ouvert. Si vous avez des questions, merci de contacter le webmaster.';
$lang['member']['forgot_pass_ok']='Votre nouveau mot de passe a bien �t� cr��. Vous devriez bient�t le recevoir par email.';
$lang['member']['forgot_pass_pbm']='Une erreur s\'est produite lors de l\'envoi du nouveau mot de passe. Si le probl�me persiste, merci de contacter le webmaster du site.';
$lang['member']['mail_forgot_pass_subject']='Votre nouveau mot de passe';
$lang['member']['mail_forgot_pass_message']='Bonjour {firstname},

Vous avez r�cemment effectu� une demande de nouveau mot de passe sur le site "{site_title}". Voici vos nouveaux identifiants de connexion :

Login : {login}
Mot de passe : {pass}

Pour vous connecter � votre espace membre, rendez-vous sur {site_url}.

A tr�s bient�t,
{sender_name}';




#################################
# job
#################################
# divers
$lang['member']['add_job']='Ajouter une fonction';
$lang['member']['job_list']='Fonctions des dirigeants';

# formulaire
$lang['member']['form_job']='Fonctions des dirigeants';
$lang['member']['form_job_add_1']='Insertion r�ussie';
$lang['member']['form_job_add_0']='Probl�me lors de l\'insertion';
$lang['member']['form_job_edit_1']='Modification r�ussie';
$lang['member']['form_job_edit_0']='Probl�me lors de la modification';
$lang['member']['form_job_sup_1']='Suppression r�ussie';
$lang['member']['form_job_sup_0']='Probl�me lors de la suppression';

# erreur
$lang['member']['E_empty_name_job']='Veuillez saisir une fonction';
$lang['member']['E_exist_job']='Cette fonction est d�j� pr�sente';
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
$lang['member']['form_level_add_1']='Insertion r�ussie';
$lang['member']['form_level_add_0']='Probl�me lors de l\'insertion';
$lang['member']['form_level_edit_1']='Modification r�ussie';
$lang['member']['form_level_edit_0']='Probl�me lors de la modification';
$lang['member']['form_level_sup_1']='Suppression r�ussie';
$lang['member']['form_level_sup_0']='Probl�me lors de la suppression';

# erreur
$lang['member']['E_empty_name_level']='Veuillez saisir un niveau';
$lang['member']['E_exist_level']='Ce niveau est d�j� pr�sent';
$lang['member']['E_exist_level_member']='Un arbitre ayant ce niveau existe';

#################################
# sex
#################################
# divers
$lang['member']['sex']='Sexe';
$lang['member']['add_sex']='Ajouter un sexe';
$lang['member']['sex_list']='Sexe des membres';
$lang['member']['abbreviation']='Abr�viation';

# formulaire
$lang['member']['form_sex']='Sexe des membres';
$lang['member']['form_sex_add_1']='Insertion r�ussie';
$lang['member']['form_sex_add_0']='Probl�me lors de l\'insertion';
$lang['member']['form_sex_edit_1']='Modification r�ussie';
$lang['member']['form_sex_edit_0']='Probl�me lors de la modification';
$lang['member']['form_sex_sup_1']='Suppression r�ussie';
$lang['member']['form_sex_sup_0']='Probl�me lors de la suppression';

# erreur
$lang['member']['E_empty_name_sex']='Veuillez saisir un sexe';
$lang['member']['E_empty_abbreviation_sex']='Veuillez saisir une abr�viation';
$lang['member']['E_exist_sex']='Ce sexe est d�j� pr�sent';
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
$lang['member']['form_country_add_1']='Insertion r�ussie';
$lang['member']['form_country_add_0']='Probl�me lors de l\'insertion';
$lang['member']['form_country_edit_1']='Modification r�ussie';
$lang['member']['form_country_edit_0']='Probl�me lors de la modification';
$lang['member']['form_country_sup_1']='Suppression r�ussie';
$lang['member']['form_country_sup_0']='Probl�me lors de la suppression';

# erreur
$lang['member']['E_empty_name_country']='Veuillez saisir un pays';
$lang['member']['E_exist_country']='Ce pays est d�j� pr�sent';
$lang['member']['E_exist_country_member']='Un membre ayant cette nationalit� existe';

#################################
# group // new 1.4
#################################
# divers
$lang['member']['group']='Groupe'; // new 1.4
$lang['member']['choose_group']='Choisir un groupe'; // new 1.4
$lang['member']['add_group']='Ajouter un groupe'; // new 1.4
$lang['member']['group_list']='Liste des groupes'; // new 1.4
$lang['member']['description']='Description'; // new 1.4
$lang['member']['right_management']='G�rer les droits des groupes'; // new 1.4

# formulaire
$lang['member']['form_group']='Gestion des groupes'; // new 1.4
$lang['member']['form_group_add_1']='Insertion r�ussie'; // new 1.4
$lang['member']['form_group_add_0']='Probl�me lors de l\'insertion'; // new 1.4
$lang['member']['form_group_edit_1']='Modification r�ussie'; // new 1.4
$lang['member']['form_group_edit_0']='Probl�me lors de la modification'; // new 1.4
$lang['member']['form_group_sup_1']='Suppression r�ussie'; // new 1.4
$lang['member']['form_group_sup_0']='Probl�me lors de la suppression'; // new 1.4

$lang['member']['form_group_right_edit_1']='Modification r�ussie'; // new 1.4
$lang['member']['form_group_right_edit_0']='Probl�me lors de la modification'; // new 1.4

# erreur
$lang['member']['E_empty_name_group']='Veuillez saisir un nom de groupe'; // new 1.4
$lang['member']['E_empty_description_group']='Veuillez saisir une description'; // new 1.4
$lang['member']['E_exist_group']='Ce groupe est d�j� pr�sent'; // new 1.4
$lang['member']['E_exist_group_member']='Ce groupe poss�de un membre et ne peut donc �tre supprim�'; // new 1.4
$lang['member']['E_cant_delete_default_group']='Les groupes par d�faut ne peuvent pas �tre supprim�s'; // new 1.4

#################################
# commun
#################################
# divers
$lang['member']['submit']='Valider';
$lang['member']['cancel']='Annuler';
$lang['member']['edit']='Modifier';
$lang['member']['check']='V�rifier';
$lang['member']['delete']='Supprimer';
$lang['member']['add']='Ajouter';
$lang['member']['order_by']='Trier par';

# page
$lang['member']['first_page']='Premi�re page';
$lang['member']['previous_page']='Pr�c�dente';
$lang['member']['next_page']='Suivante';
$lang['member']['last_page']='Derni�re page';


?>