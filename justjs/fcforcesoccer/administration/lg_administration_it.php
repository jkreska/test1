<?php
/*******************************************************************/
/* AMMINISTRAZIONE */
/*******************************************************************/

#################################
# amministrazione
#################################
# divers
$lang['administration']['administration']='Amministrazione';
$lang['administration']['administration_zone']='Zona Amministrazione';
$lang['administration']['parametre']='Configurazione';
$lang['administration']['home_administration']='Panello di controllo';
$lang['administration']['welcome']='Benvenuti nell\'area d\'amministrazione. Da quì potete gestire tutti i dati del sito web (partite, articoli, membri, etc.) con i diversi moduli accessibili grazie al menu di administrazione.
Questo pannello di controllo regolarmente ricorda tutte le cose che ci sono da fare : aggiungere il risultato di una partita terminata, elementi da aggiornare, etc... Quindi tornate spesso !';
$lang['administration']['configuration']='Configurazione Sito Web';
$lang['administration']['configuration_text']='La configurazione del sito web non sembra essere terminata. Per favore verificare che tutte le informazioni necessarie al buon funzionamento del sito web siano state correttamente eseguite: ';
$lang['administration']['change_configuration']='Modifica la configurazione del sito web';
$lang['administration']['end_installation']='Attenzione, per motivi di sicurezza dovete cancellare la cartella installation per far sì che il sito web possa lavorare correttamente. Dopo cancellata, fate il refresh di questa pagina.';
$lang['administration']['update']='Aggiornamento in corso.';
$lang['administration']['mettre_a_day']='Iniziare aggiornamento';

# configurazione
$lang['administration']['information_site']='Informazioni Sito Web';
$lang['administration']['information_site_ab']='Informazioni Sito Web';
$lang['administration']['title']='Titolo Sito Web';
$lang['administration']['url']='Indirizzo Web (url)';
$lang['administration']['root']='Percorso';
$lang['administration']['information_mail']='Email informazioni';
$lang['administration']['information_mail_ab']='Emails';
$lang['administration']['email']='Email del Webmaster';
$lang['administration']['sender_name']='Firma Email';
$lang['administration']['activate_mail']='Abilitare invio Email';
$lang['administration']['activate_mail_info']='Sarà possibile inviare messaggi email dal sito ai membri, p.e. durante il processo di registrazione. La funzione mail() del server deve essere abilitata.';
$lang['administration']['information_base']='Informazioni Server e Database';
$lang['administration']['information_base_ab']='Database';
$lang['administration']['host']='Host';
$lang['administration']['user']='Utente';
$lang['administration']['password']='Password';
$lang['administration']['base']='Nome del database';
$lang['administration']['prefix']='Prefisso delle tabelle';
$lang['administration']['information_sport']='Informazioni sullo Sport';
$lang['administration']['information_sport_ab']='Sport';
$lang['administration']['nb_player']='Numero massimo di giocatori per ogni squadra';
$lang['administration']['info_url']='senza / finale';
$lang['administration']['url_rewrite']='Attiva URL semplice';
$lang['administration']['info_url_rewrite']='L\'URL semplificato (URL rewriting) rende più leggibile l\'indirizzo web, incluse le varibili. Per esempio, l\'url http://www.miosito.com/index.php?lg=it&r=news&v1=page1 diventerà http://www.miosito.com/it/news/page1.html. Apache rewrite mod deve essere attivo.';
$lang['administration']['website_status']='Stato del sito web';
$lang['administration']['site_open']='Il sito web è aperto';
$lang['administration']['site_closed']='Il sito web è in costruzione. Esso è chiuso ai visitatori è solo il webmaster è in grado di accedere alla sezione membri.';
$lang['administration']['language']='Lingua';
$lang['administration']['template']='Design';
$lang['administration']['avatar_folder']='Cartella Avatars';
$lang['administration']['info_avatar_folder']='Seleziona la cartella dove gli utenti possono scegliere un\'avatar (Un avatar è la rappresentazione grafica di un\'utente su Internet). Se la cartella contiene sottocartelle, gli utenti saranno abilitati ad aprire quest\'ultime.';

$lang['administration']['example']='Es.';
$lang['administration']['example_title']='Il mio club sportivo';
$lang['administration']['example_url']='http://www.miosito.com';
$lang['administration']['example_email']='contatto@miosito.com';
$lang['administration']['example_sender_name']='Webmaster del mio club sportivo';
$lang['administration']['example_root']='/var/www/miosito';
$lang['administration']['example_user']='root';
$lang['administration']['example_host']='localhost';
$lang['administration']['example_base']='miodatabase';

$lang['administration']['configuration_ok']='Elemento modificato con successo';

# configuration mini-standings
$lang['administration']['mini_standings']='Mini classifiche';
$lang['administration']['mini_standings_ab']='Mini classifiche';
$lang['administration']['ms_show']='Visualizza mini classifiche';
$lang['administration']['ms_show_all']='Su tutte le pagine';
$lang['administration']['ms_show_home']='Sulla homepage';
$lang['administration']['ms_show_none']='Non visualizzare';
$lang['administration']['ms_column']='Colonne da visualizzare';
$lang['administration']['ms_default_competition']='Competizione di default';
$lang['administration']['ms_nb_club_max']='Numero massimo di clubs';
$lang['administration']['ms_show_form']='Utente può scegliere';

# content settings
$lang['administration']['content_settings']='Configurazione contenuti';
$lang['administration']['content_settings_ab']='Contenuti';
$lang['administration']['nb_item_page']='Numero di elementi per pagina';
$lang['administration']['nb_item_home_page']='Numero di elementi sulla homepage';
$lang['administration']['E_empty_content_settings']='Attenzione: alcuni campi della configurazione contenuti sono vuoti.';
$lang['administration']['E_invalid_content_settings_integer']='Attenzione: alcuni campi della configurazione contenuti non sono numerici';
$lang['administration']['E_invalid_content_settings_range']='Attenzione: i campi della configurazione contenuti devono avere un valore tra 1 e 100';

# Registration
$lang['administration']['registration']='Registrazione membri';
$lang['administration']['registration_ab']='Registrazione';
$lang['administration']['activate_registration']='Attivare registrazioni';
$lang['administration']['activate_registration_info']='Un link "Registrazione" sarà visualizzato sul sito. Le registrazioni devono essere verificate e attivate dal webmaster.';
$lang['administration']['registration_mail']='Attiva invio email registrazione';
$lang['administration']['registration_mail_info']='Durante il processo di registrazione, i membri riceveranno una email con il loro login e password.  Dopo la validazione del webmaster gli untenti ricevono una email di conferma dal sistema.';

# error
$lang['administration']['E_creation_conf']='C\'è stato un errore durante la modifica dei parametri.';

$lang['administration']['E_empty_title']='Per favore inserire un titolo';
$lang['administration']['E_empty_url']='Per favore inserire l\'indirizzo (url) del sito web';
$lang['administration']['E_invalid_url']='L\'url non è valido. Per favore controllate che il sito web sia accessibile a questo indirizzo web';
$lang['administration']['E_empty_root']='Per favore inserire il percorso';
$lang['administration']['E_invalid_root']='Il percorso non è valido. Per favore controllate che i files del sito web siano nella cartella indicata';
$lang['administration']['E_invalid_email']='L\'indirizzo email non è valido';
$lang['administration']['E_empty_host']='Per favore inserire il nome dell\'host';
$lang['administration']['E_empty_user_base']='Per favore inserire il nome utente per il database';
$lang['administration']['E_empty_name_base']='Per favore inserire il nome del database';
$lang['administration']['E_invalid_connection_base']='La connessione al server MySQL è fallita. Per favore controllate le informazioni che avete inserito';
$lang['administration']['E_invalid_selection_base']='La selezione del database è fallita. Per favore controllate il nome del databas';
$lang['administration']['E_disable_mail']='La funzione mail() del vostro server è disattivata. Non è possibile attivare l\'invio delle email.';
$lang['administration']['E_invalid_registration_mail']='Per attivare l\'invo delle email durante il processo di registrazione, l\'opzione "invio email" deve essere selezionata nelle opzioni di configurazione.';
$lang['administration']['E_invalid_sender_name']='Se volete utilizzare l\'invio email, inserite un indirizzo email e una firma.';

# plugin 
$lang['administration']['plugin']='Plugin';
$lang['administration']['plugin_list']='Plugins';
$lang['administration']['plugin_to_install']='Alcuni plugins non sono stati ancora installati';
$lang['administration']['plugin_install']='Installa questo plugin';



#################################
# commun
#################################
# divers
$lang['administration']['erreur']='Attenzione, ci sono degli errori';
$lang['administration']['submit']='Invia';
$lang['administration']['yes']='Si';
$lang['administration']['no']='No';

?>