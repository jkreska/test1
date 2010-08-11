<?php
/*******************************************************************/
/* ADMINISTRATION */
/*******************************************************************/

#################################
# administration
#################################
# divers
$lang['administration']['administration']='Administra��o';
$lang['administration']['administration_zone']='Zona de Administra��o';
$lang['administration']['parametre']='Configura��o';
$lang['administration']['home_administration']='Painel';
$lang['administration']['welcome']='Bem-vindos a zona de administra��o. Voc� pode agora gereciar dados de todo o web site (disputas, not�cias, membros, etc.) com os formul�ios diferentes acess�veis do menu de administra��o.
Este painel diz-lhe o que voc� tem de fazer: acrescentar um resultado se o jogo j� acabou, itens para atualizar, etc.... Visite esta p�gina regularmente !';

$lang['administration']['configuration']='Configura��o do Website';
$lang['administration']['configuration_text']='A configura��o do web site aparentemente n�o est� acabada. Por favor verifique se todas as informa��es necess�rias foram introduzidas : ';
$lang['administration']['change_configuration']='Modificar a configura��o do web site';
$lang['administration']['end_installation']='Aviso, por raz�es de seguran�a voc� tem de eliminar a pasta de instala��o para ter seu web site trabalhando propriamente. Uma vez eliminado, somente recarregue esta p�gina.';
$lang['administration']['update']='Une mise �day du site est en cours.';
$lang['administration']['mettre_a_day']='Iniciar atualiza��o';

# configuration
$lang['administration']['information_site']='Informa��es do Website';
$lang['administration']['information_site_ab']='Site';
$lang['administration']['title']='T�tulo do Website';
$lang['administration']['url']='Endere�o do WebSite (url)';
$lang['administration']['root']='Diret�io raiz';
$lang['administration']['information_mail']='Utiliza��o de Emails';
$lang['administration']['information_mail_ab']='Emails';
$lang['administration']['email']='E-mail do Webmaster';
$lang['administration']['sender_name']='Assinatura de Emails';
$lang['administration']['activate_mail']='Permitir envio de email';
$lang['administration']['activate_mail_info']='O site ser� capaz de enviar emails ao membro, por exemplo durante o processo de registro. A fun��o mail() do seu servidor deve ser habilitada.';
$lang['administration']['information_base']='Informa��es do Servidor e Banco de Dados';
$lang['administration']['information_base_ab']='Banco de Dados';
$lang['administration']['host']='Host';
$lang['administration']['user']='Nome do Usu�io';
$lang['administration']['password']='Senha';
$lang['administration']['base']='Nome do banco de dados';
$lang['administration']['prefix']='Prefixo do nome das tabelas';
$lang['administration']['information_sport']='Esporte Informa��es';
$lang['administration']['information_sport_ab']='Esporte';
$lang['administration']['nb_player']='M�ximo n�mero de jogadores em um time';
$lang['administration']['info_url']='n� / no final';
$lang['administration']['url_rewrite']='Ativar reescrever url'; 
$lang['administration']['info_url_rewrite']='URL simplificada (URL reescrita) de f�cil leitura. Por exemplo, a url http://www.mysite.com/index.php?lg=en&r=news&v1=page1 iria se transformar em  http://www.mysite.com/en/news/page1.html. Modo de reescrita do Apache deve estar ligado.';
$lang['administration']['website_status']='Estado do Website'; 
$lang['administration']['site_open']='O website est� aberto';
$lang['administration']['site_closed']='O web site est� em constru��o. Est� fechado para visitantes e s� se permite que o webmaster acesse a servi�o de membros.';
$lang['administration']['language']='Idioma';
$lang['administration']['template']='Design';
$lang['administration']['avatar_folder']='Diret�rio de Avatars';
$lang['administration']['info_avatar_folder']='Selecione a pasta onde os usu�rios podem escolher um avatar (um avatar � uma representa��o gr�fica de um usu�rio de Internet). Se o diret�rio tiver o sub-diret�rio, os usu�rios ent�o ser�o capazes de abri-los.';
$lang['administration']['example']='Ex.';
$lang['administration']['example_title']='Meu Clube de Esportes';
$lang['administration']['example_url']='http://www.mysite.com';
$lang['administration']['example_email']='contact@mysite.com';
$lang['administration']['example_sender_name']='Webmaster do meu clube de esporte ';
$lang['administration']['example_root']='/var/www/mysite';
$lang['administration']['example_user']='root';
$lang['administration']['example_host']='localhost';
$lang['administration']['example_base']='mybase';

$lang['administration']['configuration_ok']='Item modificado com sucesso';

# configuration mini-standings
$lang['administration']['mini_standings']='Mini Posi��es';
$lang['administration']['mini_standings_ab']='Mini Posi��es';
$lang['administration']['ms_show']='Mostrar mini posi��es';
$lang['administration']['ms_show_all']='Em cada p�gina';
$lang['administration']['ms_show_home']='Na p�gina principal';
$lang['administration']['ms_show_none']='N�o mostrar';
$lang['administration']['ms_column']='Coluna para ser mostrada';
$lang['administration']['ms_default_competition']='Competi��o padr�o';
$lang['administration']['ms_nb_club_max']='m�ximo n�mero de clubes';
$lang['administration']['ms_show_form']='Deixar usu�rio escolher';

# content settings
$lang['administration']['content_settings']='Conte�do de configura��es';
$lang['administration']['content_settings_ab']='Conte�do';
$lang['administration']['nb_item_page']='N�mero de itens por p�gina';
$lang['administration']['nb_item_home_page']='N�mero de itens na p�gina principal';
$lang['administration']['E_empty_content_settings']='Aviso, alguns campos de configura��o de conte�do est�o vazios';
$lang['administration']['E_invalid_content_settings_integer']='Aviso, alguns campos de configura��o de conte�do n�o s�o n�meros';
$lang['administration']['E_invalid_content_settings_range']='Aviso, campos de configura��o de conte�do tem que ter um valor entre 1 e 100';

# Registration
$lang['administration']['registration']='Registro de membros';
$lang['administration']['registration_ab']='Registro';
$lang['administration']['activate_registration']='Ativar registros';
$lang['administration']['activate_registration_info']='Um link "Registro" ser� mostrado no site. Registros ser�o ativados depois da verifica��o pelo webmaster';
$lang['administration']['registration_mail']='Ative o envio de emails de registro';
$lang['administration']['registration_mail_info']='Durante o processo de registro, os membros receber�o um email com o seu login de entrada e senha. Quando o registro for validado pelo webmaster, os membros receber�o uma confirma��o por email.';

# error
$lang['administration']['E_creation_conf']='Um erro ocorreu enquanto editava os parametros';

$lang['administration']['E_empty_title']='Favor entrar um t�tulo';
$lang['administration']['E_empty_url']='Favor entrar o endere�o (url) do website';
$lang['administration']['E_invalid_url']='url inv�lida. Favor checar se seu website est� dispon�vel neste endere�o';
$lang['administration']['E_empty_root']='Favor entrar o maminho do raiz';
$lang['administration']['E_invalid_root']='Caminho do raiz inv�lido. Por favor verifique se os seus arquivos do web site est�o presentes na pasta indicada';
$lang['administration']['E_invalid_email']='Endere�o de e-mail inv�lido';
$lang['administration']['E_empty_host']='Favor entrar o nome do host';
$lang['administration']['E_empty_user_base']='Favor entrar o nome do usu�rio do banco de dados';
$lang['administration']['E_empty_name_base']='Favor entrar o nome do banco de dados';
$lang['administration']['E_invalid_connection_base']='A conec��o com o servidor MySQL falhou. Favor verificar suas informa��es';
$lang['administration']['E_invalid_selection_base']='A sele��o do banco de dados falhou. Favor verificar o nome do banco de dados';
$lang['administration']['E_disable_mail']='The mail() function of your server is disable. You are not able to activate email sending.';
$lang['administration']['E_invalid_registration_mail']='Para ativar o envio de emails durante o processo de registro, a op��o de envio de emails deve ser marcado na configura��o de emails.';
$lang['administration']['E_invalid_sender_name']='Se voc� quer permitir envio de emails, por favor introduza um endere�o de email e uma assinatura.';

# plugin 
$lang['administration']['plugin']='Plugin';
$lang['administration']['plugin_list']='Plugins';
$lang['administration']['plugin_to_install']='Alguns plugins n�o foram ainda instalados';
$lang['administration']['plugin_install']='instalar este plugin';



#################################
# commun
#################################
# divers
$lang['administration']['erreur']='Aviso, existe um/alguns erro(s)';
$lang['administration']['submit']='Submeter';
$lang['administration']['yes']='Sim';
$lang['administration']['no']='N�o';

?>