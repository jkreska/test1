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

/* En récursif */
function parse_template($tpl,$var)
{
 if(!file_exists($tpl))
 {
 	# we try with defaut folder
	$tpl_defaut=eregi_replace(TPL_URL,ROOT.'/template/defaut/',$tpl);
	if(TPL_DOSSIER!='defaut' AND file_exists($tpl_defaut)) {
		$tpl=$tpl_defaut;
	}
	else {
		die("Le fichier \"".$tpl."\"n'existe pas - création du template impossible");
	} 	
 }
 $ligne=file($tpl);

 return parse_html($ligne,$var);
}

function parse_html($code,$var)
{
 $bloc=array();
 $boucle=false;
 $option=false;
 $name_bloc="";
 $name="";
 $name_option="";
 $name_op=array();
 $nb_option=0;
 $html="";
 $affichage=true;

 $size_code=sizeof($code);

 for($i="0";$i<$size_code;$i++)
 {
  $affichage=true;
  // remplacement du path des images 
  if(preg_match("`=\"(\.\.\/)*tpl_image/([-_a-zA-Z0-9\/\{\}]+).([a-zA-Z]{2,3})\"`",$code[$i],$catch)) {   
	  if(TPL_DOSSIER!='defaut' AND file_exists(ROOT."/template/".TPL_DOSSIER."/tpl_image/".$catch[2].".".$catch[3])) {  	
		$code[$i]=eregi_replace("=\"(\.\.\/)*tpl_image/","=\"".ROOT_URL."/template/".TPL_DOSSIER."/tpl_image/",$code[$i]);
	  }
	  else {
		$code[$i]=eregi_replace("=\"(\.\.\/)*tpl_image/","=\"".ROOT_URL."/template/defaut/tpl_image/",$code[$i]);
	  }  
  }

  // si on trouve une boucle
  if($boucle==false AND preg_match("<!-- LOOP (\w+) -->",$code[$i],$name_bloc))
  {
    $name=$name_bloc['1'];
    $boucle=true;
    $nb=sizeof($var[$name]);
    $i++;
  }

   // on arrive à la end de la boucle
  if($boucle==true AND preg_match("<!-- END LOOP ".$name." -->",$code[$i]))
  {
    for($j="0";$j<$nb;$j++) // defini le number de bloc a afficher
    {
     $html.=parse_html($bloc[$name],$var[$name][$j]); // recursif
    }
    $boucle=false;
    $bloc=array();
    $affichage=false;
    $code[$i]="";
  }

  /* si on trouve du text optionnel */
  if(preg_match("<!-- OPTION (\w+) -->",$code[$i],$name_option))
  {
   if(isset($var[$name_option['1']]) AND (empty($var[$name_option['1']]) OR $var[$name_option['1']]==NULL))
   {
    array_push($name_op,$name_option['1']);
    $option=true;
	$nb_option++;	
   }
   $affichage=false;
  }
	
  if($option==true)
  {
   if(preg_match("<!-- END OPTION ".$name_op[$nb_option-1]." -->",$code[$i]))
   {
    $code[$i]="";   
	array_pop($name_op);
	$nb_option--;
	if($nb_option==0) { $option=false; }
   }
   $affichage=false;
  }

  // si on est dans une boucle, on enregistre le code dans un bloc
  if($boucle==true)
  {
   $bloc[$name][]=$code[$i];
   $affichage=false;
  }

  if($affichage==true)
  {
   $html.=preg_replace('/\{(\w+)\}/e','\$var[\'\\1\']',$code[$i]);
  }
 }
 return $html;
}

?>