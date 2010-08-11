<?php
if(!defined("SGBD_INCLUDED"))
{
 require(create_path("include/sgbd/sgbd_tables.php"));
 require(create_path("include/sgbd/mysql.php"));
 define("SGBD_INCLUDED","1");
}
?>