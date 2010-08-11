<?php
/********/
/* CLUB */
/********/
/* selection (liste)*/
$sql['club']['select_club']="SELECT * FROM ".T_club." ORDER BY club_name ASC";
$sql['club']['select_club_nb']="SELECT COUNT(*) AS nb FROM ".T_club." ";
$sql['club']['select_club_condition']="SELECT * FROM ".T_club." {condition} {order} {limit}";

/* selection (details) */
$sql['club']['select_club_details'] = "SELECT * FROM ".T_club." WHERE club_id='{id}'";

/* insertion */
$sql['club']['insert_club_name']="INSERT INTO ".T_club." (club_name) VALUES ('{name}')"; 
$sql['club']['insert_club']="INSERT INTO ".T_club." (club_name, club_abbreviation, club_logo, club_address, club_color, club_color_alternative, club_telephone, club_fax, club_email, club_url, club_creation_year, club_comment) VALUES ('{name}','{abbreviation}','{logo}','{address}','{color}','{color_alternative}','{telephone}','{fax}','{email}','{url}',{creation_year},'{comment}')"; 

$sql['club']['import_club']="INSERT INTO ".T_club." ({field}) VALUES ({values}) ";
$sql['club']['merge_club']="UPDATE ".T_club." SET {field_value} WHERE club_id='{id}'";

# modification
$sql['club']['edit_club']="UPDATE ".T_club." SET club_name='{name}',club_abbreviation='{abbreviation}',club_logo='{logo}',club_address='{address}', club_color='{color}', club_color_alternative='{color_alternative}', club_telephone='{telephone}', club_fax='{fax}', club_email='{email}', club_url='{url}', club_creation_year={creation_year}, club_comment='{comment}' WHERE club_id='{id}' ";

/* verification */
$sql['club']['verif_club']="(SELECT member_id FROM ".T_member." WHERE club_depart_id='{id}' OR club_arrive_id='{id}')
UNION (SELECT team_a_id FROM ".T_team." WHERE club_id='{id}')";
$sql['club']['verif_presence_club']="SELECT club_id FROM ".T_club." WHERE club_name='{name}' AND club_id!='{id}'";

/* suppression */
$sql['club']['sup_club']="DELETE FROM ".T_club." WHERE club_id='{id}'";
?>