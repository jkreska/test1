<?php
/*
* phpMySport : website for team sport clubs and leagues
*
* Copyright (C) 2006-2009 Jerome PLACE. All rights reserved.
*
* Email           : djayp [at] users.sourceforge.net
* Website         : http://phpmysport.sourceforge.net
* Version         : 1.4
* Last update     : 4 march 2009
*
* This program is free software; you can redistribute it and/or
* modify it under the terms of the GNU General Public License
* as published by the Free Software Foundation; either version 2
* of the License, or (at your option) any later version.
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
*
*/


/* replace a part of the sql code by a variable */
function sql_replace($sql,$var)
{
 return preg_replace('/\{(\w+)\}/e','\$var[\'\\1\']',$sql);
}


/* connection to the server and selection of the database */
function sql_connect()
{
 $id_connection_bd = @mysql_connect(SGBD_HOST, SGBD_USER, SGBD_PWD);
 if(mysql_select_db(SGBD_NAME, $id_connection_bd))
 {
  return $id_connection_bd;
 }
 else
 {
  @mysql_close($bd);
  return false;
 }
}

/* close the connection */
function sql_close($id_connection_bd, $resultat = false)
{
 if(isset($id_connection_bd))
 {
  if(isset($resultat) AND $resultat != false)
  {
   @mysql_free_result($resultat);
  }
  return @mysql_close($id_connection_bd);
 }
 else
 {
  return false;
 }
}

/* execute the query */
function sql_query($sql, $resultat = false)
{
 if($sql != "")
 {
  return mysql_query($sql);
 }
 else
 {
  return false;
 }
}

/* count the number of results */
function sql_num_rows($resultat)
{
 if($resultat != "")
 {
  return @mysql_num_rows($resultat);
 }
 else
 {
  return false;
 }
}

/* return the result of a query */
function sql_result($resultat)
{
 if($resultat != "")
 {
  return mysql_result($resultat);
 }
 else
 {
  return false;
 }
}


/* return a table containing the result */
function sql_fetch_array($resultat)
{
 if($resultat != "")
 {
  return @mysql_fetch_array($resultat);
 }
 else
 {
  return false;
 }
}

/* return the ID of th last inserted data */
function sql_insert_id($sgbd)
{
 return mysql_insert_id($sgbd);
}

/*  */
function sql_free_result($resultat)
{
 if($resultat != "")
 {
  return @mysql_free_result($resultat);
 }
 else
 {
  return false;
 }

}

function sql_error()
{
 return mysql_errno()." ".mysql_error();
}

?>