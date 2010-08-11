<?php

include_once(create_path("field/sql_field.php"));
include_once(create_path("field/tpl_field.php"));
include_once(create_path("field/lg_field_".LANG.".php"));

if(!isset($_GET['v1']))
{
 include(create_path("field/field_list.php"));
}
else
{
 switch($_GET['v1']) {
 case "form_field" :  include(create_path("field/form_field.php")); break;
 case "field_list" :  include(create_path("field/field_list.php")); break;
 case "view" : include(create_path("field/view_field.php")); break;
 default : include(create_path("field/field_list.php"));
 }
}

?>