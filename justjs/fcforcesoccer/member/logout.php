<?php


/***************************************************************************
* Human php : generic website [CMS]
*
* copyright       : (C) 2004-2005 Jerome PLACE
* email           : jerome.place@citesport.com
* version         : 1.2
* last updtate    : 09-02-2005
* modification(s) :
* 1.
* - date      :
* - name      :
* - comment   :
*
***************************************************************************/

/***************************************************************************
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
***************************************************************************/


/* deconnection de l'espace member */
session_unset('session_member_id');
session_unset('session_member_status');
session_unset('session_member_sport');
session_unset('session_member_jeu');
session_unset('session_member_site');
session_unset('session_date_connection');
session_unset('session_user_right');

# on supprime les eventuelles cookies
$date_expiration=time()+0;
$path="/";
setCookie("auto_connection","0",$date_expiration,$path);
setCookie("cle","",$date_expiration,$path);

header("location:".ROOT_URL);
exit;
?>