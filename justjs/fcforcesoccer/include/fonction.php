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


/* convert an PHP url in html
eg : "index.php?lg=fr&r=member&v1=sign_up"
is converted to: /fr/member/sign_up.html
@param string s URL to convert
@param int c if assess to 0 do not rewrite the url in html, if assess to 2 force the url rewriting
*/ 
function convert_url($s,$c=URL_REWRITE)
{
 if(isset($_GET['fen']) AND $_GET['fen']=="pop") { $s.="&fen=pop"; }
 
 //if((ADMIN!=1 AND $c==1) OR (ADMIN==1 AND URL_REWRITE==1 AND $c==2))  // si c'est un admin, pas besoin de convertir
 if(($c==1) OR (URL_REWRITE==1 AND $c==2))
 {
  $urlin=array("'index.php'",
  "'\?r=([a-z]*)'",
   "'&v([0-9]{1})=([-_*a-z0-9]*)'",
   "'&fen=([_*a-z]*)'",
   "'&lettre=([A-Z]{1})'");

  $urlout=array("",
  "\\1",
   "/\\2",
   "/fen_\\1",
   "/\\1/");

  $s = preg_replace($urlin, $urlout, $s);
  $longueur=strlen($s);
  $dernier_car=substr($s,$longueur-1,$longueur);

  if($dernier_car!="/" AND $dernier_car!="") { $s.=".html"; }
 }

 return ROOT_URL."/".$s;
}

/*
Concert an html url to a php url (opposite to convert_url)

@param string s URL to unconvert
@return string unconverted URL
*/
function unconvert_url($s)
{
 $s=eregi_replace(ROOT_URL.'/','',$s);
 $s=eregi_replace('\.html','',$s);
 $elt=explode('/',$s);
 $url='index.php?r=';
 $i=0;
 foreach($elt AS $value) {
	if($i > 0) { $url.='&v'.$i.'='; }
	$url.=$value;
	$i++;
 }
 return $url;
}

/* 
Convert a date in SQL format (yyyy-mm-dd)
@param string date any date in any format
@return string date in format yyyy-mm-dd
*/
function convert_date_sql($date)
{
 $return="";
 if($date=="" OR $date=="00-00-0000" OR $date=="0000-00-00")
 {
  $return="";
 }
 elseif(eregi("([0-9]{4})([\/ .-]{1})([0-9]{1,2})([\/ .-]{1})([0-9]{1,2})", $date))
 {
  $return=eregi_replace("\/|\.| ","-",$date);
 }
 elseif(eregi("([0-9]{1,2})([\/ .-]{1})([0-9]{1,2})([\/ .-]{1})([0-9]{4})", $date))
 {
  $date=eregi_replace("\/|\.| ","-",$date);
  $date=explode("-",$date);
  $return=$date['2']."-".$date['1']."-".$date['0'];
 }
 else
 {
  $return="";
 }
 return $return;
}

/* 
Return the date of the day according a specific format (same as function date()) 
@param string format define the format the date (refer to date() function)
@return string date of the day in format
*/
function date_day($format)
{
 return date($format,time());
}


/*
Convert a SQL date to another format
@param date  date date in sql format (yyyy-mm-dd)
@param string format  refer to strftime function
@return string date converted in format
*/
function convert_date($date,$format) {	
	if($date=='0000-00-00 00:00:00' OR $date=='0000-00-00' OR $date=='' OR $date==NULL) {
		return '';
	}
	else {
		$year=substr($date,0,4);
		if(phpversion() < 5.0 AND $year < 1970) {
			
			$new_date=substr_replace($date,'1980',0,4); # we replace the year by a year after 1970		
			$new_format=eregi_replace('%a|%A|%u','',$format); # we remove days information from the format because they would be wrong
			$new_date=strftime($new_format,strtotime($new_date)); # we convert the date
			$new_date=eregi_replace('1980',$year,$new_date); # we put back the real year
			return $new_date;
		}
		else {
			return strftime($format,strtotime($date));
		}
	}
}


/* 
Calculate the age in year from a date of birth ( format yyyy-mm-dd) 
@param string dob date of birth in yyyy-mm-dd format
@return int age in years from today
*/
function calcul_age($dob)
{
 $year_day=date("Y",time());
 $month_day=date("m",time());
 $day_day=date("d",time());

 $year_nais = substr($dob, 0, 4);
 $month_nais = substr($dob, 3, 2);
 $day_nais = substr($dob, 9, 2);

 $age = $year_day-$year_nais;

 if($month_day < $month_nais) {$age=$age--;}
 elseif($day_day < $day_nais && $month_day==$month_nais) { $age=$age--; }

 return $age;
}

# PAGINATION
/*
Generate the pagination for a list of elements
@param srting url URL of current page containing the list of element 
@param int nb_page number of page in total
@param int page_num number of the current page
@param string end_url extra variables that must be put at the end of the URL
@return array list of pages containing the numbers and the link to these pages
*/
function generate_pagination($url, $nb_page,$page_num,$end_url="")
{

 $page=array();
 if($nb_page==1) { return $page; }
 else
 {
 /* on ne souhaite affiche que 10 number de page maximum, on va donc tronquer le start 
 et la end des numbers lorsqu'il y a plus de 10 pages
 */
  if($nb_page > 10)
  {
   if($page_num <= 5) { $start=1; $end=10; } # ici on affiche les 10 premiers number
   elseif($page_num > $nb_page-5) { $start=$nb_page-9; $end=$nb_page; } # on affiche les 10 derniers numbers
   else { $start=$page_num-5; $end=($page_num+4)> $nb_page ? $nb_page : $page_num+4; } # on affiche les 10 numbers centres sur le number of the current page
  }
  # il y a moins de 10 pages
  else { $start=1; $end=$nb_page; }

  # on parcours nos 10 pages pour pouview affiche les numbers
  for($i = $start,$j=0; $i <= $end ; $i++,$j++)
  {
   if($page_num!=$i)
   {
     # on doit mettre le link
     $page[$j]['link_page']=convert_url($url.$i.$end_url);
     $page[$j]['page']=$i;
   }
   else
   {
    # il s'agit du number de la page courante, pas besoin de link
    $page[$j]['link_page']="";
    $page[$j]['page']=$i;
   }  
  }
  return $page;
 }
}

/* 
Convert a HTML code into a raw text 
@param string text HTML code
@return string text text without HTML tag, points, etc.
*/
function html2txt($text)
{
 if($text!="")
 {
  $text=eregi_replace("&nbsp"," ",$text);
  $text=eregi_replace('"'," ",$text);
  $text=eregi_replace("'"," ",$text);
  $text=eregi_replace("&#([a-z0-9]+);"," ",$text);
  $text=unhtmlentities($text); // replace html characters by text equivalent
  $text=strip_tags($text); // delete all html & php tags
  $text=eregi_replace("[[:punct:]]+"," ",$text);
  $text=ereg_replace("[[:space:]]+"," ", trim( $text ) );
  $text=strtolower($text);
 }
 return $text;
}

/* 
Replace HTML charaters by their text equivalent
@param string html HTML code
@return string code with HTML tag converted
*/
function unhtmlentities($html)
{
 $tmp = get_html_translation_table(HTML_ENTITIES);
 $tmp = array_flip ($tmp);
 $chaineTmp = strtr ($html, $tmp);
 return $chaineTmp; 
}

/*
Format the name of a file so that it does not contain any space or accentuation
@param string name name of the file
@return string name without any space, accent (only 0-9 and a-z accepted)
*/ 
function format_file_name($name)
{
 $name = strtr($name,
     'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ',
     'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy'); 
 $name = preg_replace('/([^.a-z0-9]+)/i', '-', $name);
 return $name;

}

/* 
Replace a code {value} by the corresponding variable $var['value'] 
@param string text text containing one or several code(s) to replace
@param array var variable containing the list of value that will replace the code
@return string text with code replaced by values
 */
function text_replace($text,$var)
{
 return preg_replace('/\{(\w+)\}/e','\$var[\'\\1\']',$text);
}


/* 
Cut a text after a defined number of words or charaters

*/
// si $b est à 1, on force la coupe du mot
function text_tronquer($text,$nb,$b=0)
{
 // Test si la longueur du text dépasse la limite
 if (strlen($text)>$nb)
 {
  $text = substr($text, 0, $nb);
  // Récupération de la position du dernier espace (aend déviter de tronquer un mot)
  if($b) { $text = substr($text, 0, $nb); }
  else {
   $position_espace = strrpos($text, " ");
   $text = substr($text, 0, $position_espace);
  }
  $text = $text."...";
 }
 return $text;
}

/* converti la size d'un fichier en octet */
function return_bytes($val) {
    $val = trim($val);
    $last = strtolower($val{strlen($val)-1});
    switch($last) {
        // Le editieur 'G' est disponible depuis PHP 5.1.0
        case 'g':
            $val *= 1024;
        case 'm':
            $val *= 1024;
        case 'k':
            $val *= 1024;
    }
    return $val;
}

# modifie le format d'affichage de la taille d'un fichier
function filesize_format($bytes, $decimal='.', $spacer=' ', $lowercase=false) {

  $bytes = max(0, (int)$bytes);
  $units = array('YB' => 1208925819614629174706176, // yottabyte
                 'ZB' => 1180591620717411303424,    // zettabyte
                 'EB' => 1152921504606846976,      // exabyte
                 'PB' => 1125899906842624,          // petabyte
                 'TB' => 1099511627776,            // terabyte
                 'GB' => 1073741824,                // gigabyte
                 'MB' => 1048576,                  // megabyte
                 'KB' => 1024,                      // kilobyte
                 'B'  => 0);                        // byte

  foreach ($units as $unit => $qty) {
     if ($bytes >= $qty)
   return number_format(!$qty ? $bytes: $bytes /= $qty, 1, $decimal, $spacer).$spacer.$unit;
  }
} 

# ecart en secondes entre deux dates au format aaaa-mm-jj hh:mm:ss
function ecartDate($date1,$date2) {

$year1=substr($date1,0,4);
$month1=substr($date1,5,2);
$day1=substr($date1,8,2);
$hour1=substr($date1,11,2);
$min1=substr($date1,14,2);
$sec1=substr($date1,17,2);

$year2=substr($date2,0,4);
$month2=substr($date2,5,2);
$day2=substr($date2,8,2);
$hour2=substr($date2,11,2);
$min2=substr($date2,14,2);
$sec2=substr($date2,17,2);

# on transforme la date en timestamp
$timestamp1 = mktime($hour1, $min1, $sec1, $month1, $day1, $year1);
$timestamp2 = mktime($hour2, $min2, $sec2, $month2, $day2, $year2);

# on calcule le number de secondes d'écart entre les deux dates
$ecart_secondes = $timestamp2 - $timestamp1;

# puis on tranforme en days (arrondi inférieur)
//$ecart_days = floor($ecart_secondes / (60*60*24));

return  $ecart_secondes;
}

# send an email
function send_mail($from_name, $from_email, $to, $subject, $message, $type_mime='text/plain') {
 $from = $from_name." <".$from_email.">";
 $headers = "From: ".$from."\n".
 "Reply_to: ".$from_email."\n".
 "Date: ".date("j M. Y G:i")."\n".
 "MIME-Version: 1.0\n".
 "Content-Type: ".$type_mime."; charset=\"iso-8859-1\"\n".
 "Content-Transfer-Encoding: 8bit\n";

 return mail($to, $subject, $message, $headers);
}

/*
Create a random password of 8 charaters
*/
function create_pass() {
 $string= "ABCDEFGHIJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz23456789";
 $password="";
 srand((double)microtime()*1000000);
 for($i=0; $i<8; $i++) {
  $password.=$string{rand()%strlen($string)};
 }
 return $password;
}

?>