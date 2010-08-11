<?php
/*******************************************************************/
/* ADMINISTRATION */
/*******************************************************************/

#################################
# administration
#################################
# divers
$lang['administration']['administration']='Administração';
$lang['administration']['administration_zone']='Zona de Administração';
$lang['administration']['parametre']='Configuração';
$lang['administration']['home_administration']='Painel';
$lang['administration']['welcome']='Bem-vindos a zona de administração. Você pode agora gereciar dados de todo o web site (disputas, notícias, membros, etc.) com os formuláios diferentes acessíveis do menu de administração.
Este painel diz-lhe o que você tem de fazer: acrescentar um resultado se o jogo já acabou, itens para atualizar, etc.... Visite esta página regularmente !';

$lang['administration']['configuration']='Configuração do Website';
$lang['administration']['configuration_text']='A configuração do web site aparentemente não está acabada. Por favor verifique se todas as informações necessárias foram introduzidas : ';
$lang['administration']['change_configuration']='Modificar a configuração do web site';
$lang['administration']['end_installation']='Aviso, por razões de segurança você tem de eliminar a pasta de instalação para ter seu web site trabalhando propriamente. Uma vez eliminado, somente recarregue esta página.';
$lang['administration']['update']='Une mise ï¿½day du site est en cours.';
$lang['administration']['mettre_a_day']='Iniciar atualização';

# configuration
$lang['administration']['information_site']='Informações do Website';
$lang['administration']['information_site_ab']='Site';
$lang['administration']['title']='Título do Website';
$lang['administration']['url']='Endereço do WebSite (url)';
$lang['administration']['root']='Diretóio raiz';
$lang['administration']['information_mail']='Utilização de Emails';
$lang['administration']['information_mail_ab']='Emails';
$lang['administration']['email']='E-mail do Webmaster';
$lang['administration']['sender_name']='Assinatura de Emails';
$lang['administration']['activate_mail']='Permitir envio de email';
$lang['administration']['activate_mail_info']='O site será capaz de enviar emails ao membro, por exemplo durante o processo de registro. A função mail() do seu servidor deve ser habilitada.';
$lang['administration']['information_base']='Informações do Servidor e Banco de Dados';
$lang['administration']['information_base_ab']='Banco de Dados';
$lang['administration']['host']='Host';
$lang['administration']['user']='Nome do Usuáio';
$lang['administration']['password']='Senha';
$lang['administration']['base']='Nome do banco de dados';
$lang['administration']['prefix']='Prefixo do nome das tabelas';
$lang['administration']['information_sport']='Esporte Informações';
$lang['administration']['information_sport_ab']='Esporte';
$lang['administration']['nb_player']='Máximo número de jogadores em um time';
$lang['administration']['info_url']='nï¿½ / no final';
$lang['administration']['url_rewrite']='Ativar reescrever url'; 
$lang['administration']['info_url_rewrite']='URL simplificada (URL reescrita) de fácil leitura. Por exemplo, a url http://www.mysite.com/index.php?lg=en&r=news&v1=page1 iria se transformar em  http://www.mysite.com/en/news/page1.html. Modo de reescrita do Apache deve estar ligado.';
$lang['administration']['website_status']='Estado do Website'; 
$lang['administration']['site_open']='O website está aberto';
$lang['administration']['site_closed']='O web site está em construção. Está fechado para visitantes e só se permite que o webmaster acesse a serviço de membros.';
$lang['administration']['language']='Idioma';
$lang['administration']['template']='Design';
$lang['administration']['avatar_folder']='Diretório de Avatars';
$lang['administration']['info_avatar_folder']='Selecione a pasta onde os usuários podem escolher um avatar (um avatar é uma representação gráfica de um usuário de Internet). Se o diretório tiver o sub-diretório, os usuários então serão capazes de abri-los.';
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
$lang['administration']['mini_standings']='Mini Posições';
$lang['administration']['mini_standings_ab']='Mini Posições';
$lang['administration']['ms_show']='Mostrar mini posições';
$lang['administration']['ms_show_all']='Em cada página';
$lang['administration']['ms_show_home']='Na página principal';
$lang['administration']['ms_show_none']='Não mostrar';
$lang['administration']['ms_column']='Coluna para ser mostrada';
$lang['administration']['ms_default_competition']='Competição padrão';
$lang['administration']['ms_nb_club_max']='máximo número de clubes';
$lang['administration']['ms_show_form']='Deixar usuário escolher';

# content settings
$lang['administration']['content_settings']='Conteúdo de configurações';
$lang['administration']['content_settings_ab']='Conteúdo';
$lang['administration']['nb_item_page']='Número de itens por página';
$lang['administration']['nb_item_home_page']='Número de itens na página principal';
$lang['administration']['E_empty_content_settings']='Aviso, alguns campos de configuração de conteúdo estão vazios';
$lang['administration']['E_invalid_content_settings_integer']='Aviso, alguns campos de configuração de conteúdo não são números';
$lang['administration']['E_invalid_content_settings_range']='Aviso, campos de configuração de conteúdo tem que ter um valor entre 1 e 100';

# Registration
$lang['administration']['registration']='Registro de membros';
$lang['administration']['registration_ab']='Registro';
$lang['administration']['activate_registration']='Ativar registros';
$lang['administration']['activate_registration_info']='Um link "Registro" será mostrado no site. Registros serão ativados depois da verificação pelo webmaster';
$lang['administration']['registration_mail']='Ative o envio de emails de registro';
$lang['administration']['registration_mail_info']='Durante o processo de registro, os membros receberão um email com o seu login de entrada e senha. Quando o registro for validado pelo webmaster, os membros receberão uma confirmação por email.';

# error
$lang['administration']['E_creation_conf']='Um erro ocorreu enquanto editava os parametros';

$lang['administration']['E_empty_title']='Favor entrar um título';
$lang['administration']['E_empty_url']='Favor entrar o endereço (url) do website';
$lang['administration']['E_invalid_url']='url inválida. Favor checar se seu website está disponível neste endereço';
$lang['administration']['E_empty_root']='Favor entrar o maminho do raiz';
$lang['administration']['E_invalid_root']='Caminho do raiz inválido. Por favor verifique se os seus arquivos do web site estão presentes na pasta indicada';
$lang['administration']['E_invalid_email']='Endereço de e-mail inválido';
$lang['administration']['E_empty_host']='Favor entrar o nome do host';
$lang['administration']['E_empty_user_base']='Favor entrar o nome do usuário do banco de dados';
$lang['administration']['E_empty_name_base']='Favor entrar o nome do banco de dados';
$lang['administration']['E_invalid_connection_base']='A conecção com o servidor MySQL falhou. Favor verificar suas informações';
$lang['administration']['E_invalid_selection_base']='A seleção do banco de dados falhou. Favor verificar o nome do banco de dados';
$lang['administration']['E_disable_mail']='The mail() function of your server is disable. You are not able to activate email sending.';
$lang['administration']['E_invalid_registration_mail']='Para ativar o envio de emails durante o processo de registro, a opção de envio de emails deve ser marcado na configuração de emails.';
$lang['administration']['E_invalid_sender_name']='Se você quer permitir envio de emails, por favor introduza um endereço de email e uma assinatura.';

# plugin 
$lang['administration']['plugin']='Plugin';
$lang['administration']['plugin_list']='Plugins';
$lang['administration']['plugin_to_install']='Alguns plugins não foram ainda instalados';
$lang['administration']['plugin_install']='instalar este plugin';



#################################
# commun
#################################
# divers
$lang['administration']['erreur']='Aviso, existe um/alguns erro(s)';
$lang['administration']['submit']='Submeter';
$lang['administration']['yes']='Sim';
$lang['administration']['no']='Não';

?>