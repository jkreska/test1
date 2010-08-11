<?php
/********/
/* link */
/********/

define("T_link","link");

/* selection (liste)*/
$sql['link']['select_link']="SELECT * FROM ".T_link." ORDER BY link_name ASC";
$sql['link']['select_link_nb']="SELECT COUNT(*) AS nb FROM ".T_link." ";
$sql['link']['select_link_condition']="SELECT * FROM ".T_link." {condition} {order} {limit}";

/* selection (details) */
$sql['link']['select_link_details'] = "SELECT * FROM ".T_link." WHERE link_id='{id}'";

/* insertion */
$sql['link']['insert_link']="INSERT INTO ".T_link." (link_name, link_url,link_description) VALUES ('{name}','{url}','{description}')";  

# modification
$sql['link']['edit_link']="UPDATE ".T_link." SET link_name='{name}',link_url='{url}' , link_description='{description}'
WHERE link_id='{id}' ";

/* verification */
$sql['link']['verif_presence_link']="SELECT link_id FROM ".T_link." WHERE link_url='{url}' AND link_id!='{id}'";

/* suppression */
$sql['link']['sup_link']="DELETE FROM ".T_link." WHERE link_id='{id}'";
?>