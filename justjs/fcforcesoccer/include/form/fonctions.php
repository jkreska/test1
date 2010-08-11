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


/* FUNCTIONS TO FORMAT DATAS */
/* Format the text : replace special chars by equivalents in html */
function format_txt($txt)
{
 return htmlspecialchars(stripcslashes(trim($txt)),ENT_QUOTES);
}


/* FUNCTIONS TO CHECK DATAS */
# check if a text does not have numbers
function check_text($text)
{
 return !eregi("[0-9]",$text);
}

# check if a number has no text
function check_integer($nb)
{
 return eregi("^[0-9]",$nb);
}

# check if the syntax of an email is correct
function check_email($email)
{
 return eregi("^[_\.0-9a-z-]+@([0-9a-z-]+\.)+[a-z]{2,4}$",$email);
/*
  list($user, $domaine) = split("@", $email, 2);
  $domain_ok = @checkdnsrr($domaine, "MX");
*/
}

# check if a date is in a correct format jj-mm-aaaa or jj/mm/aaaa or jj.mm.aaaa or aaaa/mm/jj */
function check_date($date)
{
 if(eregi("([0-9]{4})([\/ .-]{1})([0-9]{1,2})([\/ .-]{1})([0-9]{1,2})", $date))
 {
  $date=eregi_replace("\/|\.| ","-",$date);
  $date=explode("-",$date);
  $day=$date['2'];
  $month=$date['1'];
  $year=$date['0']; 

  return checkdate($month, $day, $year);  
 }
 elseif(eregi("([0-9]{1,2})([\/ .-]{1})([0-9]{1,2})([\/ .-]{1})([0-9]{4})", $date))
 {
  $date=eregi_replace("\/|\.| ","-",$date);
  $date=explode("-",$date);
  $day=$date['0'];
  $month=$date['1'];
  $year=$date['2'];

  return checkdate($month, $day, $year);
 }
 else
 {
  return false;
 }
}


# check if the format of a time is correct hh:mm:ss */
function check_hour($hour)
{
 if(eregi("([0-9]{1,2}):([0-9]{0,2})", $hour))
 {
  $tmp=explode(":",$hour);
  $hour=$tmp['0'];
  $minute=$tmp['1'];
  return true;
 }
 else
 {
  return false;
 }
}

# check the format of a login (no space, no accents, between 4 and 10 characters)
function check_login($text)
{
 $longueur=strlen($text);
 if($longueur < 4 OR $longueur > 20 )
 {
  return false;
 }
 elseif(eregi("[^0-9a-z_\.-@]",$text))
 {
  return false;
 }
 else
 {
  return true;
 }
}

# check the format of a file name (no space, no accents, between 1 and 100 characters)
function check_file_name($text)
{
 $longueur=strlen($text);
 if($longueur < 1 OR $longueur > 100 )
 {
  return false;
 }
 elseif(eregi("[^0-9a-z_\.-]",$text))
 {
  return false;
 }
 else
 {
  return true;
 }
}

# check if the syntax of a url is correct
function check_url($url)
{
 return eregi("^http://[_A-Z0-9-]+[._A-Z0-9-]+[.A-Z0-9-]*(/~|/?)[/_.A-Z0-9#?&=+-\% ]*$",$url);
}

#check if the syntax of a formula is correct
function check_formula($formula) {
 return !preg_match("#[^A-Za-z0-9\+\(\)\*\/_-]#",$formula);
}

?>