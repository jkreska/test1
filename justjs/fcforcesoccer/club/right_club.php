<?php
# we define the rights available for clubs
include_once(create_path("club/lg_club_".LANG.".php"));

$right['club']=array(
array('id'=>'view_club','name'=>$lang['club']['view_club'],'default'=>1),
array('id'=>'club_list','name'=>$lang['club']['club_list'],'default'=>1),
array('id'=>'add_club','name'=>$lang['club']['add_club'],'default'=>0),
array('id'=>'edit_club','name'=>$lang['club']['edit_club'],'default'=>0),
array('id'=>'delete_club','name'=>$lang['club']['delete_club'],'default'=>0),
array('id'=>'import_club','name'=>$lang['club']['import_club'],'default'=>0)
);

?>