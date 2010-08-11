<?php
# installation : message
$nb_erreur="0";

$page['L_title']=$lang['installation']['message'];

$var['root_url']="../";

$page['L_message']=text_replace($lang['installation']['error_folder'],$var);

$page['template']="tpl/message.html";

?>
