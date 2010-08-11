<?php
# we define the rights available for file
include_once(create_path("file/lg_file_".LANG.".php"));

$right['file']=array(
array('id'=>'add_file','name'=>$lang['file']['upload_file'],'default'=>0),
array('id'=>'delete_file','name'=>$lang['file']['delete_file'],'default'=>0),
array('id'=>'add_folder','name'=>$lang['file']['create_folder'],'default'=>1)
);

?>