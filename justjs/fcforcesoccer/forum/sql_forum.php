<?php
/**********/
/* FORUM */
/**********/

# forum
$sql['forum']['select_forum']="SELECT * FROM ".T_forum." ORDER BY forum_order ASC";
$sql['forum']['select_forum_condition']="SELECT * FROM ".T_forum." {condition} {order} {limit} ";
$sql['forum']['select_forum_name']="SELECT forum_id,forum_name FROM ".T_forum." ORDER BY forum_order ASC";
$sql['forum']['select_forum_details']="SELECT * FROM ".T_forum." WHERE forum_id='{id}' ";
$sql['forum']['select_forum_details_idurl']="SELECT * FROM ".T_forum." WHERE forum_idurl='{idurl}' ";
$sql['forum']['select_forum_order']="SELECT forum_order FROM ".T_forum." WHERE forum_id='{id}' ";
$sql['forum']['select_forum_nb']="SELECT COUNT(*) AS nb FROM ".T_forum." ";

$sql['forum']['insert_forum']="INSERT INTO ".T_forum." (member_id,forum_idurl,forum_name,forum_description,forum_order,forum_status,forum_date_add)
VALUES ('{member}','{idurl}','{name}','{description}','{order}','{status}',NOW() )";

$sql['forum']['edit_forum']="UPDATE ".T_forum." SET forum_idurl='{idurl}',forum_name='{name}',forum_description='{description}', forum_order='{order}', forum_status='{status}' WHERE forum_id='{id}'";

$sql['forum']['edit_forum_new_order']="UPDATE ".T_forum." SET forum_order='{order}' WHERE forum_order='{new_order}' ";
$sql['forum']['edit_forum_order']="UPDATE ".T_forum." SET forum_order='{new_order}' WHERE forum_id='{id}'";
$sql['forum']['edit_forum_order_insert']="UPDATE ".T_forum." SET forum_order=forum_order+1 WHERE forum_order >= '{order}' AND forum_id!='{id}' ";
$sql['forum']['edit_forum_order_edit']="UPDATE ".T_forum." SET forum_order=forum_order {signe} 1 WHERE forum_order >= '{order_min}' AND forum_order <= '{order_max}' AND forum_id!='{id}' ";


$sql['forum']['verif_forum']="SELECT forum_id FROM ".T_forum." WHERE forum_idurl='{idurl}' AND forum_id!='{id}' ";
$sql['forum']['verif_sup_forum']="SELECT message_id FROM ".T_message." WHERE forum_id='{id}' ";
$sql['forum']['sup_forum']="DELETE FROM ".T_forum." WHERE forum_id='{id}'";


# message
$sql['forum']['select_topic']="SELECT f.forum_name,f.forum_idurl, m.*, dm.message_date_add AS dernier_message_date,
me.member_login, me.member_id, dme.member_login AS member_login_last, dme.member_id AS member_id_last
FROM ".T_forum." AS f
INNER JOIN ".T_message." AS m ON f.forum_id=m.forum_id
LEFT JOIN ".T_message." AS dm ON m.message_last_child=dm.message_id
LEFT JOIN ".T_member." AS me ON me.member_id=m.member_add_id
LEFT JOIN ".T_member." AS dme ON dme.member_id=dm.member_add_id
{condition} {order} {limit}";


$sql['forum']['select_topic_message']="SELECT m.*,me.member_login,me.member_id,me.member_avatar FROM ".T_message." AS m LEFT JOIN ".T_member." AS me ON me.member_id=m.member_add_id WHERE m.message_parent_id='{topic}' OR m.message_id='{topic}' ORDER BY m.message_date_add ASC {limit}";
$sql['forum']['select_topic_message_condition']="SELECT m.*,me.member_login,me.member_id,me.member_avatar FROM ".T_message." AS m LEFT JOIN ".T_member." AS me ON me.member_id=m.member_add_id {condition} {order} {limit}";
$sql['forum']['select_dernier_topic']="SELECT m.*,me.member_login FROM ".T_message." AS m INNER JOIN ".T_member." AS me ON me.member_id=m.member_add_id WHERE m.forum_id='{forum}' AND m.message_parent_id='0' ORDER BY m.message_date_add DESC LIMIT 5";
$sql['forum']['select_nb_message']="SELECT COUNT(*) AS nb_message FROM ".T_message." WHERE  (message_parent_id='{topic}' OR message_id='{topic}') AND forum_id='{id}'";

$sql['forum']['select_message_details']="SELECT * FROM ".T_message." WHERE message_id='{id}' ";
$sql['forum']['insert_message']="INSERT INTO ".T_message." (member_add_id,message_parent_id,forum_id,message_title,message_text,message_date_add,message_last_child,member_ip)
VALUES ('{member}','{topic}','{forum}','{title}','{text}',NOW(),{last_child},'{ip}') ";
$sql['forum']['edit_message']="UPDATE ".T_message." SET member_edit_id='{member}',message_title='{title}',message_text='{text}',message_date_edit=NOW() WHERE message_id='{id}'";
$sql['forum']['edit_message_reponse']="UPDATE ".T_message." SET message_nb_reply=message_nb_reply+1, message_last_child='{last_child}' WHERE message_id='{topic}'";
$sql['forum']['edit_message_reponse_sup']="UPDATE ".T_message." SET message_nb_reply=message_nb_reply-1, message_last_child='{last_child}' WHERE message_id='{topic}'";
$sql['forum']['edit_message_visit']="UPDATE ".T_message." SET message_visit=message_visit+1 WHERE message_id='{topic}'";
$sql['forum']['verif_sup_message']="SELECT message_id FROM ".T_message." WHERE message_parent_id='{id}'";
$sql['forum']['sup_message']="DELETE FROM ".T_message." WHERE message_id='{id}'";

?>