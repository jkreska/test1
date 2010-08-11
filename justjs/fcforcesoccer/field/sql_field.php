<?php
/********/
/* field */
/********/
/* selection (liste)*/
$sql['field']['select_field']="SELECT * FROM ".T_field." ORDER BY field_name ASC";
$sql['field']['select_field_nb']="SELECT COUNT(*) AS nb FROM ".T_field." ";
$sql['field']['select_field_condition']="SELECT * FROM ".T_field." {condition} {order} {limit}";

/* selection (details) */
$sql['field']['select_field_details'] = "SELECT * FROM ".T_field." WHERE field_id='{id}'";

/* insertion */
$sql['field']['insert_field']="INSERT INTO ".T_field." (field_name, field_address, field_post_code, field_city, field_number_seat, field_size, field_photo) VALUES ('{name}','{address}','{post_code}','{city}','{number_place}','{size}','{photo}')";  
$sql['field']['insert_field_name']="INSERT INTO ".T_field." (field_name) VALUES ('{name}')";  

# modification
$sql['field']['edit_field']="UPDATE ".T_field." SET field_name='{name}',field_address='{address}', field_post_code='{post_code}', field_city='{city}', field_number_seat='{number_place}', field_size='{size}', field_photo='{photo}'
WHERE field_id='{id}' ";

/* verification */
$sql['field']['verif_field']="SELECT match_id FROM ".T_match." WHERE field_id='{id}'";
$sql['field']['verif_presence_field']="SELECT field_id FROM ".T_field." WHERE field_name='{name}' AND field_id!='{id}'";

/* suppression */
$sql['field']['sup_field']="DELETE FROM ".T_field." WHERE field_id='{id}'";
?>