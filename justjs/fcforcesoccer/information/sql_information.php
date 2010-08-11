<?php

/***********/
/* page v2 */
/***********/
/* selection (liste)*/
$sql['information']['select_page']="SELECT * FROM ".T_information." ORDER BY page_order ASC";
$sql['information']['select_page_condition']="select * FROM ".T_information." {condition} ORDER BY page_order ASC";

$sql['information']['select_page_parent']="select a.page_id,a.page_parent,a.page_title FROM ".T_information." AS a
 WHERE page_parent='{id}' ORDER BY page_order ASC";

$sql['information']['select_page_parent_ordre']="SELECT max(page_order) AS max, min(page_order) as min FROM ".T_information." WHERE page_parent='{id}' ";

/* selection (details) */
$sql['information']['select_page_details']="select * FROM ".T_information."  WHERE page_id='{id}' ";
$sql['information']['select_page_details_title']="select page_id,page_idurl,page_title FROM ".T_information." WHERE page_id='{id}' ";
$sql['information']['select_page_details_idurl']="select d.*,m.member_firstname,m.member_lastname,m.member_login FROM ".T_information." AS d INNER JOIN ".T_member." AS m ON m.member_id=d.member_add_id WHERE d.page_idurl='{idurl}' ";

/* insertion */
$sql['information']['insert_page']="INSERT INTO ".T_information."
(member_add_id,page_parent,page_idurl,page_title,page_summary,page_text,page_keyword,page_status,page_order,page_date_add,page_date_edit)
VALUES ('{member}','{page_parent}','{idurl}','{title}','{summary}','{text}','{keyword}','{status}','{ordre}',NOW(),NOW())";

# modification
$sql['information']['edit_page']="UPDATE ".T_information." SET
member_edit_id='{member}',page_parent='{page_parent}',
page_idurl='{idurl}',page_title='{title}',page_summary='{summary}',page_text='{text}',
page_status='{status}',page_date_edit=NOW()
WHERE page_id='{id}' ";
$sql['information']['edit_page_visit']="UPDATE ".T_information." SET page_visit=page_visit+1 WHERE page_id='{id}'";

$sql['information']['edit_page_order']="UPDATE ".T_information." SET page_order='{ordre}' WHERE page_order='{ordre_nouveau}' AND page_parent='{page_parent}'";
$sql['information']['edit_page_order_id']="UPDATE ".T_information." SET page_order='{ordre_nouveau}' WHERE page_id='{id}'";

/* verification */
$sql['information']['verif_page']="select page_id FROM ".T_information." WHERE page_idurl='{idurl}' AND page_id!='{id}'";

/* suppression */
$sql['information']['sup_page']="DELETE FROM ".T_information." WHERE page_id='{id}'";

?>