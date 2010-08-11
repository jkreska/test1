<?php
/**********/
/* MEMBER */
/**********/
# job
$sql['member']['select_job']="SELECT job_id,job_name FROM ".T_job." ORDER BY job_name ASC";
$sql['member']['insert_job']="INSERT INTO ".T_job." (job_name) VALUES ('{name}');";
$sql['member']['edit_job']="UPDATE ".T_job." SET job_name='{name}' WHERE job_id='{id}';";
$sql['member']['verif_job']="SELECT dirigeant_id FROM `".T_member_job."` WHERE job_id='{id}'";
$sql['member']['verif_presence_job']="SELECT job_id FROM ".T_job." WHERE job_name='{name}' AND job_id!='{id}'";
$sql['member']['sup_job']="DELETE FROM ".T_job." WHERE job_id='{id}'";

# level
$sql['member']['select_level']="SELECT level_id,level_name FROM ".T_level." ORDER BY level_name ASC";
$sql['member']['insert_level']="INSERT INTO ".T_level." (level_name) VALUES ('{name}');";
$sql['member']['edit_level']="UPDATE ".T_level." SET level_name='{name}' WHERE level_id='{id}';";
$sql['member']['verif_level']="SELECT member_id FROM `".T_referee."` WHERE level_id='{id}'";
$sql['member']['verif_presence_level']="SELECT level_id FROM ".T_level." WHERE level_name='{name}' AND level_id!='{id}'";
$sql['member']['sup_level']="DELETE FROM ".T_level." WHERE level_id='{id}'";

# sex
$sql['member']['select_sex']="SELECT * FROM ".T_sex." ORDER BY sex_name ASC";
$sql['member']['select_sex_details']="SELECT * FROM ".T_sex." WHERE sex_id='{id}'";
$sql['member']['insert_sex']="INSERT INTO ".T_sex." (sex_name,sex_abbreviation) VALUES ('{name}','{abbreviation}');";
$sql['member']['edit_sex']="UPDATE ".T_sex." SET sex_name='{name}', sex_abbreviation='{abbreviation}' WHERE sex_id='{id}';";
$sql['member']['verif_sex']="SELECT member_id FROM `".T_member."` WHERE sex_id='{id}'";
$sql['member']['verif_presence_sex']="SELECT sex_id FROM ".T_sex." WHERE sex_name='{name}' AND sex_id!='{id}'";
$sql['member']['sup_sex']="DELETE FROM ".T_sex." WHERE sex_id='{id}'";

# country
$sql['member']['select_country']="SELECT country_id,country_name FROM ".T_country." ORDER BY country_name ASC";
$sql['member']['select_country_details']="SELECT country_id,country_name FROM ".T_country." WHERE country_id='{id}'";
$sql['member']['insert_country']="INSERT INTO ".T_country." (country_name) VALUES ('{name}');";
$sql['member']['edit_country']="UPDATE ".T_country." SET country_name='{name}' WHERE country_id='{id}';";
$sql['member']['verif_country']="SELECT member_id FROM `".T_member."` WHERE country_id='{id}'";
$sql['member']['verif_presence_country']="SELECT country_id FROM ".T_country." WHERE country_name='{name}' AND country_id!='{id}'";
$sql['member']['sup_country']="DELETE FROM ".T_country." WHERE country_id='{id}'";

# member_club
$sql['member']['select_member_club']="SELECT c.club_id, c.club_name, s.season_name, s.season_id
FROM ".T_club." AS c 
INNER JOIN ".T_member_club." AS mc ON mc.club_id=c.club_id
INNER JOIN ".T_season." AS s ON mc.season_id=s.season_id
{condition} {order} {limit}";
$sql['member']['insert_member_club']="INSERT INTO ".T_member_club." (member_id,club_id,season_id) VALUES {values} ";
$sql['member']['sup_member_club']="DELETE FROM ".T_member_club." WHERE member_id='{member}' ";

# member_job
$sql['member']['select_member_job']="SELECT f.job_id, f.job_name, s.season_id, s.season_name, sex.sex_id, sex.sex_name, sex.sex_abbreviation, m.*
FROM ".T_job." AS f 
INNER JOIN ".T_member_job." AS mf ON mf.job_id=f.job_id
INNER JOIN ".T_member." AS m ON m.member_id=mf.member_id
INNER JOIN ".T_season." AS s ON mf.season_id=s.season_id
LEFT JOIN ".T_sex." AS sex on m.sex_id=sex.sex_id
{condition} {order} {limit}";

$sql['member']['select_member_job_club']="SELECT mc.club_id,c.club_name,f.job_id, f.job_name, mf.season_id, s.season_name, sex.sex_id, sex.sex_name, sex.sex_abbreviation, m.*
FROM ".T_job." AS f 
INNER JOIN ".T_member_job." AS mf ON mf.job_id=f.job_id
INNER JOIN ".T_member." AS m ON m.member_id=mf.member_id
INNER JOIN ".T_member_club." AS mc ON mc.member_id=m.member_id
INNER JOIN ".T_club." AS c ON mc.club_id=c.club_id
INNER JOIN ".T_season." AS s ON mf.season_id=s.season_id && mc.season_id=s.season_id
LEFT JOIN ".T_sex." AS sex on m.sex_id=sex.sex_id
{condition} {order} {limit}";

$sql['member']['insert_member_job']="INSERT INTO ".T_member_job." (member_id,job_id,season_id) VALUES {values} ";
$sql['member']['sup_member_job']="DELETE FROM ".T_member_job." WHERE member_id='{member}' ";

# member
$sql['member']['insert_member']="INSERT INTO ".T_member." (country_id,sex_id,level_id,member_lastname,member_firstname,member_email,member_date_birth,member_place_birth,member_size,member_weight,member_comment,member_login,member_description,member_photo,member_avatar,member_status,member_valid) VALUES ('{country}','{sex}','{level}','{name}','{firstname}','{email}','{date_birth}','{place_birth}',{size},{weight},'{comment}','{login}','{description}','{photo}','{avatar}','{status}','{valid}') ";

$sql['member']['insert_member_registration']="INSERT INTO ".T_member." (sex_id,member_lastname,member_firstname,member_email,member_date_birth,member_login,member_pass,member_description,member_avatar,member_status,member_valid,member_date_registration) VALUES ('{sex}','{name}','{firstname}','{email}','{date_birth}','{login}','{pass_md5}','{description}','{avatar}','{status}','{valid}',NOW()) ";

$sql['member']['edit_member']="UPDATE ".T_member." SET country_id='{country}',sex_id='{sex}',level_id='{level}',member_lastname='{name}',member_firstname='{firstname}',member_email='{email}',member_date_birth='{date_birth}',member_place_birth='{place_birth}',member_size={size},member_weight={weight},member_comment='{comment}' WHERE member_id='{id}' ";

$sql['member']['edit_member_profile']="UPDATE ".T_member." SET member_login='{login}',member_email='{email}',member_description='{description}',member_avatar='{avatar}' WHERE member_id='{id}' ";
$sql['member']['edit_member_connection']="UPDATE ".T_member." SET member_connection=member_connection+1, member_date_connection=NOW() WHERE member_id='{id}'";

$sql['member']['edit_member_pass']="UPDATE ".T_member." SET member_pass='{pass_md5}' WHERE member_id='{id}' ";
$sql['member']['edit_member_key']="UPDATE ".T_member." SET member_valid='{valid}' WHERE member_key='{key}'";

$sql['member']['edit_member_admin']="UPDATE ".T_member." SET
country_id='{country}',sex_id='{sex}',level_id='{level}',member_lastname='{name}',member_firstname='{firstname}',member_email='{email}',member_date_birth='{date_birth}',member_place_birth='{place_birth}',member_size={size},member_weight={weight},member_comment='{comment}',member_login='{login}',member_description='{description}',member_photo='{photo}',member_avatar='{avatar}',member_status='{status}',member_valid='{valid}' WHERE member_id='{id}' ";

$sql['member']['edit_member_registration']="UPDATE ".T_member." SET
sex_id='{sex}',member_lastname='{name}',member_firstname='{firstname}',member_email='{email}',member_date_birth='{date_birth}',member_login='{login}',member_description='{description}',member_avatar='{avatar}',member_valid='{valid}',member_status='{status}' WHERE member_id='{id}' ";

$sql['member']['import_member']="INSERT INTO ".T_member." ({field}) VALUES ({values}) ";
$sql['member']['merge_member']="UPDATE ".T_member." SET {field_value} WHERE member_id='{id}'";


$sql['member']['verif_presence_member']="SELECT member_id FROM ".T_member." WHERE member_lastname='{name}' AND member_firstname='{firstname}' AND member_id!='{id}' AND member_valid IN ('0','1') ";
$sql['member']['verif_member_login']="SELECT member_id FROM ".T_member." WHERE member_login='{login}' AND member_id!='{id}' ";
$sql['member']['verif_member_email']="SELECT member_id FROM ".T_member." WHERE member_email='{email}' AND member_id!='{id}' ";
$sql['member']['verif_member_pass']="SELECT member_id FROM ".T_member." WHERE member_pass='{pass}' AND member_id='{id}'";
$sql['member']['verif_member']="SELECT member_id FROM ".T_member_job." WHERE member_id='{id}'";

$sql['member']['select_member']="SELECT member_id,member_lastname, member_firstname FROM ".T_member." ORDER BY member_lastname ASC";
$sql['member']['select_member_condition']="SELECT sex.sex_id,sex.sex_name,sex.sex_abbreviation, m.* FROM ".T_member." AS m 
LEFT JOIN ".T_sex." AS sex on m.sex_id=sex.sex_id {condition} {order} {limit} ";

$sql['member']['select_member_nb']="SELECT COUNT(*) AS nb FROM ".T_member." AS m {condition} ";
$sql['member']['select_member_key']="SELECT * FROM ".T_member." WHERE member_key='{key}' ";
$sql['member']['select_member_login']="SELECT * FROM ".T_member." WHERE member_login='{login}' AND member_pass='{pass_md5}' AND member_valid='1' ";
$sql['member']['select_member_details']="SELECT * FROM ".T_member." AS m WHERE m.member_id='{id}' ";

$sql['member']['select_referee_club']="SELECT mc.club_id,c.club_name, s.season_id, s.season_name, sex.sex_id, sex.sex_name, sex.sex_abbreviation, level.level_name, m.*
FROM ".T_member." AS m
INNER JOIN ".T_member_club." AS mc ON mc.member_id=m.member_id
INNER JOIN ".T_club." AS c ON mc.club_id=c.club_id
INNER JOIN ".T_season." AS s ON mc.season_id=s.season_id
LEFT JOIN ".T_sex." AS sex on m.sex_id=sex.sex_id
LEFT JOIN ".T_level." AS level on m.level_id=level.level_id
{condition} {order} {limit}";

$sql['member']['sup_member']="DELETE FROM ".T_member." WHERE member_id='{id}' ";


# group
$sql['member']['select_group']="SELECT * FROM ".T_group." ORDER BY group_id ASC";
$sql['member']['select_group_details']="SELECT * FROM ".T_group." WHERE group_id='{id}'";
$sql['member']['insert_group']="INSERT INTO ".T_group." (group_name,group_description) VALUES ('{name}','{description}');";
$sql['member']['edit_group']="UPDATE ".T_group." SET group_name='{name}', group_description='{description}' WHERE group_id='{id}';";
$sql['member']['verif_group']="SELECT member_id FROM `".T_member."` WHERE member_status='{id}'";
$sql['member']['verif_presence_group']="SELECT group_id FROM ".T_group." WHERE group_name='{name}' AND group_id!='{id}'";
$sql['member']['sup_group']="DELETE FROM ".T_group." WHERE group_id='{id}'";

$sql['member']['select_group_right']='SELECT gr.* FROM '.T_group_right.' AS gr WHERE gr.group_id={group} ';
$sql['member']['select_group_right_all']='SELECT g.*,gr.right_id,gr.value FROM '.T_group.' AS g LEFT JOIN '.T_group_right.' AS gr ON g.group_id=gr.group_id';
$sql['member']['insert_group_right']="INSERT INTO ".T_group_right." (group_id,right_id,value) VALUES {values} ";
$sql['member']['sup_group_right_all']='DELETE FROM '.T_group_right.' ';
$sql['member']['sup_group_right']='DELETE FROM '.T_group_right.' WHERE group_id={id} ';
?>