<?php

include_once(create_path("news/sql_news.php"));
include_once(create_path("news/tpl_news.php"));
include_once(create_path("news/lg_news_".LANG.".php"));

if(!isset($_GET['v1']) OR $_GET['v1']=="")
{
 include(create_path("news/news_list.php"));
}
else
{
 switch($_GET['v1']) {
 case "form_news" :  include(create_path("news/form_news.php")); break;
 case "news_list" :  include(create_path("news/news_list.php")); break;
 default : include(create_path("news/view_news.php"));
 }
}

?>