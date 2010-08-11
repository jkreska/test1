<?php
/***********/
/* news */
/***********/

/* selection (liste)*/
$sql['news']['select_news']="SELECT * FROM ".T_news." ORDER BY news_release DESC";
$sql['news']['select_last_news']="SELECT news_summary,news_id,news_idurl,news_title,news_release FROM ".T_news." WHERE news_release <= NOW() ORDER BY news_release DESC LIMIT 5";
$sql['news']['select_news_populaire']="SELECT news_visit,news_summary,news_id,news_idurl,news_title,news_release FROM ".T_news." WHERE news_release <= NOW() ORDER BY news_visit DESC LIMIT 10";
$sql['news']['select_news_in']="SELECT news_summary,news_id,news_idurl,news_title,news_release FROM ".T_news." WHERE news_release <= NOW() AND news_id IN ('{news}') ";
$sql['news']['select_news_condition']="SELECT * FROM ".T_news." {condition} {order} {limit}";
$sql['news']['select_nb_news']="SELECT COUNT(*) AS nb FROM ".T_news." {condition}";


/* selection (details) */
$sql['news']['select_news_details']="SELECT d.* FROM ".T_news." AS d  WHERE d.news_id='{id}' ";
$sql['news']['select_news_details_idurl']="SELECT * FROM ".T_news." WHERE news_idurl='{idurl}' ";

/* insertion */
$sql['news']['insert_news']="INSERT INTO ".T_news."
(member_add_id,news_idurl,news_subhead,news_title,news_subtitle,news_summary,news_text,news_ps,news_keyword,news_release,news_status,news_date_add)
VALUES ('{member}','{idurl}','{subhead}','{title}','{subtitle}','{summary}','{text}','{ps}','{keyword}','{release}','{status}',NOW())";

# modification
$sql['news']['edit_news']="UPDATE ".T_news." SET
member_edit_id='{member}',news_idurl='{idurl}',news_subhead='{subhead}',
news_title='{title}',news_subtitle='{subtitle}',news_summary='{summary}',news_text='{text}',news_ps='{ps}',
news_keyword='{keyword}',news_release='{release}',news_status='{status}',news_date_edit=NOW()
WHERE news_id='{id}' ";
$sql['news']['edit_news_visit']="UPDATE ".T_news." SET news_visit=news_visit+1 WHERE news_id='{id}'";

/* verification */
$sql['news']['verif_news']="SELECT news_id FROM ".T_news." WHERE news_idurl='{idurl}' AND news_id!='{id}'";

/* suppression */
$sql['news']['sup_news']="DELETE FROM ".T_news." WHERE news_id='{id}'";

?>