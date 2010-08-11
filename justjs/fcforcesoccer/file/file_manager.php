<?php

##################################
# file 
##################################

# variables
$page['L_message_file']="";
$nb_erreur="0";
$page['erreur']=array();

# form values
$page['value_file']="";
$page['value_name']="";
$page['value_new_folder']="";
$page['value_thumb_size']="";

$page['form_file_display']="none";
$page['form_folder_display']="none";
$page['show_folder_list']="1";

$page['parent_form']="";
$page['field_name']="";

$page['folder']=""; # define a unique folder for the selection of files. Will not show the list of folders
$page['current_folder']=""; # define the folder that is currently used
$page['parent_folder']=""; # define the folder that is before the current folder

$page['root']=ROOT."/".FILE_FOLDER;
$page['root_url']=ROOT_URL."/".FILE_FOLDER;

if(isset($_GET['file_type'])) {
 if($_GET['file_type']=="image") {
  $type_allowed=$type_allowed_image;
  $type_mime_allowed=$type_mime_allowed_image;
 }
 elseif($_GET['file_type']=="flash")
 {
  $type_allowed=$type_allowed_flash;
  $type_mime_allowed=$type_mime_allowed_flash;  
 }
 else
 {
  $type_allowed=array_merge($type_allowed_image,$type_allowed_video,$type_allowed_text,$type_allowed_flash,$type_allowed_application);
  $type_mime_allowed=array_merge($type_mime_allowed_image,$type_mime_allowed_video,$type_mime_allowed_text,$type_mime_allowed_flash,$type_mime_allowed_application); 
 }
}
else
{
 $type_allowed=array_merge($type_allowed_image,$type_allowed_video,$type_allowed_text,$type_allowed_flash,$type_allowed_application);
 $type_mime_allowed=array_merge($type_mime_allowed_image,$type_mime_allowed_video,$type_mime_allowed_text,$type_mime_allowed_flash,$type_mime_allowed_application);
}

$fin_url="";
if(isset($_GET['parent_form'])) { 
 $page['parent_form']=$_GET['parent_form'];
 $fin_url.="&parent_form=".$page['parent_form'];
}
if(isset($_GET['field_name'])) { 
 $page['field_name']=$_GET['field_name'];
 $fin_url.="&field_name=".$page['field_name'];
}
if(isset($_GET['file_type'])) {
 $fin_url.="&file_type=".$_GET['file_type'];
}

if(!$right_user['add_file'] AND (!isset($_GET['folder']) OR !eregi(AVATAR_FOLDER,$_GET['folder']))) {
	$_GET['folder']=AVATAR_FOLDER;
}

if(isset($_GET['folder'])) {
 $page['root'].="/".$_GET['folder'];
 $page['root_url'].="/".$_GET['folder'];
 $page['folder']=$_GET['folder'];
 if(!$right_user['add_file']) {
  $page['show_root']="";
 }
 $fin_url.="&folder=".$page['folder'];
}

if(isset($_POST['folder'])) { 
 if($_POST['folder']=="") {
  # the user ask for the parent folder
  $page['current_folder']=substr($_POST['folder'],0,strrpos($_POST['folder'],"/"));
 } 
 else {
  $page['current_folder']=$_POST['folder'];   
 } 
 $fin_url.="&current_folder=".$_POST['folder'];
}
elseif(isset($_GET['current_folder'])) { 
 $page['current_folder']=$_GET['current_folder']; 
 $fin_url.="&current_folder=".$page['current_folder'];
}

$page['form_action_insert']=convert_url("index.php?r=".$lang['general']['idurl_file']."&v1=file_manager".$fin_url,0);
$page['form_action_create_folder']=convert_url("index.php?r=".$lang['general']['idurl_file']."&v1=file_manager".$fin_url,0);
$page['form_action_change_folder']=convert_url("index.php?r=".$lang['general']['idurl_file']."&v1=file_manager".$fin_url,0);

# deleting a file or a directory
if(isset($_GET['mode']) AND $_GET['mode']=="delete" AND $right_user['delete_file'])
{
 $rep=$page['root']."/".$_GET['file'];
 if(is_dir($rep)) {
  $delete_rep=@unlink($rep."/index.html"); 
  $delete_rep=@rmdir($rep);
 }
 else
 {
  $delete_rep=@unlink($rep);
 } 
 if($delete_rep) { $page['L_message_file']=$lang['file']['form_file_sup_1']; }
 else { $page['L_message_file']=$lang['file']['form_file_sup_0']; }
}

# create a folder
if(isset($_POST['action']) AND $_POST['action']=="create_folder" AND $right_user['add_folder'])
{
 # we check datas
  if(isset($_POST['new_folder']) AND !empty($_POST['new_folder']) AND !check_file_name($_POST['new_folder'])) { $page['erreur'][$nb_erreur]['message']=$lang['file']['E_invalid_folder_name']; $nb_erreur++; }
  
  if(file_exists(ROOT."/".FILE_FOLDER."/".$_POST['upload_folder'].$_POST['new_folder'])) {
   $page['erreur'][$nb_erreur]['message']=$lang['file']['E_exist_folder']; $nb_erreur++;	
  }
   
   # we check if the folder doesnt already exist
  if($nb_erreur==0 AND isset($_POST['new_folder']) AND !empty($_POST['new_folder'])) 
  {
    if(@mkdir(ROOT."/".FILE_FOLDER."/".$_POST['upload_folder'].$_POST['new_folder'], 0700))
    {
	 # if it works, we create a index.html blank file for security reason
	 @fopen(ROOT."/".FILE_FOLDER."/".$_POST['upload_folder'].$_POST['new_folder']."/index.html","w");
	 $page['L_message_file']=$lang['file']['form_folder_add_1'];
	} 
	else
	{
     $page['erreur'][$nb_erreur]['message']=$lang['file']['E_creation_folder']; $nb_erreur++;	
    }
  }
  else
  {
    $page['value_new_folder']=$_POST['new_folder'];
	$page['form_folder_display']="block"; # we show the form
  }
}

# adding a file
if(isset($_POST['action']) AND $_POST['action']=="upload_file" AND isset($_FILES['file']) AND $right_user['add_file'])
{
 # we format datas
 
 # we check datas
 if(!isset($_FILES['file']['name']) OR empty($_FILES['file']['name'])) { $page['erreur'][$nb_erreur]['message']=$lang['file']['E_empty_file']; $nb_erreur++; }
 elseif(!in_array($_FILES['file']['type'],$type_mime_allowed)) { 
 $var['type']=implode(", ",$type_allowed);
 $page['erreur'][$nb_erreur]['message']=text_replace($lang['file']['E_invalid_file_type'],$var); $nb_erreur++; }
 
 if($_FILES['file']['size'] > MAX_FILE_SIZE)  { 
 $var['max_file_size']=filesize_format(MAX_FILE_SIZE);
 $page['erreur'][$nb_erreur]['message']=text_replace($lang['file']['E_invalid_file_size'],$var); $nb_erreur++; }
  
 # if($_FILES['file']['error']!=0) { $page['erreur'][$nb_erreur]['message']=$lang['file']['E_invalid_file']; $nb_erreur++; }
 
 if(isset($_POST['name']) AND !empty($_POST['name']) AND !check_file_name($_POST['name'])) { $page['erreur'][$nb_erreur]['message']=$lang['file']['E_invalid_name']; $nb_erreur++; }
 
 # we check if the file does not exist
 if($nb_erreur==0)
 {  
  # name of the file
  if(isset($_POST['name']) AND !empty($_POST['name'])) { 
   # we get the extension
   $file_ext = substr($_FILES['file']['name'],strrpos($_FILES['file']['name'],"."));
   $file_name=format_file_name($_POST['name']).$file_ext;   
  }
  else { $file_name=format_file_name($_FILES['file']['name']); }
  
  $path_file=ROOT."/".FILE_FOLDER."/".$_POST['upload_folder']."/".$file_name;
  
  # check
  if(file_exists($path_file)) { 
   $page['erreur'][$nb_erreur]['message']=$lang['file']['E_exist_file']; $nb_erreur++;	
  }
 } 
 
 
 # there is no error, we copy the file
 if($nb_erreur==0)
 { 
  # we try to upload the file    
   $copy_file=@move_uploaded_file($_FILES['file']['tmp_name'],$path_file);
   
   if($copy_file) { $page['L_message_file']=$lang['file']['form_file_add_1']; }
   else { $page['L_message_file']=$lang['file']['form_file_add_0']; }  
 }
 else
 {
  $page['value_name']=$_POST['name'];  
  $page['form_file_display']="block"; # we show the form
 }
}
/* FIN AJOUT file */


# to get the parent folder, we try to delete the last /xxxxxx/ of the current path
$page['parent_folder']=substr($page['current_folder'],0,strrpos($page['current_folder'],"/")); # we delete the last /
$page['parent_folder']=substr($page['parent_folder'],0,strrpos($page['parent_folder'],"/")+1); # we delete the folder /xxxxx

if($page['parent_folder']=="") $page['parent_folder']="/";
if($page['current_folder']=="") $page['current_folder']="/";

$page['show_root']="1";
if($page['parent_folder']==$page['current_folder']) { 
 $page['show_root']="";
}

# folder list
$page['folder_list']=array();

if($page['parent_folder']!="/" OR $page['current_folder']!="/") {
	$i="0";
	$rep = $page['root'].$page['parent_folder'];
	$tab_folder=array();
	chdir($rep);
	$dir = opendir(".");
	
	while ($f = readdir($dir)) { 
	 if($f!="." AND $f!=".." AND is_dir($rep.$f))
	 {
	  $tab_folder[] = $f; 
	 }
	}
	closedir($dir); 
	
	
	sort($tab_folder);
	foreach($tab_folder as $f) 
	{  
	 $page['folder_list'][$i]['name']=$f;
	 $page['folder_list'][$i]['path']=$page['parent_folder'].$f."/";
	 $page['folder_list'][$i]['L_delete']=$lang['file']['delete'];
	 
	 $page['folder_list'][$i]['link_delete']='';
	 
	 if($right_user['delete_file']) {
	 	$page['folder_list'][$i]['link_delete']=convert_url("index.php?r=".$lang['general']['idurl_file']."&v1=file_manager&mode=delete&file=".$page['current_folder'].$f.$fin_url,0);
	 }
	 
	 if($page['current_folder']==$page['parent_folder'].$f."/") {	 
	  $page['folder_list'][$i]['selected']="selected";
	  $page['folder_list'][$i]['class']="folder_open";
	 } 
	 else
	 {
	  $page['folder_list'][$i]['selected']="";
	  $page['folder_list'][$i]['class']="folder";  
	 } 
	 $i++;
	}
}

# subfolder and file list
$page['file']=array();
$tab_file=array();
$tab_subfolder=array();
$j="0";

$rep = $page['root'].$page['current_folder'];

chdir($rep);
$dir = opendir(".");

while ($f = readdir($dir)) { 
 if($f!="." AND $f!=".." AND is_dir($rep.$f))
 {
  $tab_subfolder[] = $f; 
 }
 elseif($f!="." AND $f!=".." AND $f!="index.html")
 {
  $tab_file[] = $f; 
 }
}
closedir($dir); 


if(!empty($tab_subfolder)) sort($tab_subfolder);
$page['subfolder_list']=array();
$i="0";
foreach($tab_subfolder as $f) 
{  
 $page['subfolder_list'][$i]['name']=$f;
 $page['subfolder_list'][$i]['path']=$page['current_folder'].$f."/";
 $page['subfolder_list'][$i]['L_delete']=$lang['file']['delete'];
 $page['subfolder_list'][$i]['link_delete']='';
 if($right_user['delete_file']) {
	$page['subfolder_list'][$i]['link_delete']=convert_url("index.php?r=".$lang['general']['idurl_file']."&v1=file_manager&mode=delete&file=".$page['current_folder'].$f.$fin_url,0); 
 }
 $i++;
}

if(!empty($tab_file)) sort($tab_file);

foreach($tab_file as $f) 
{ 
 $type = strtolower(substr($f,strrpos($f,".")+1));
 
 if(in_array($type,$type_allowed))
  {   
   $page['file'][$j]['i']=$j;
   $page['file'][$j]['name']=$f;
   $page['file'][$j]['url']=$page['root_url'].$page['current_folder'].$f;
   $page['file'][$j]['L_select']=$lang['file']['select_file'];   
   $page['file'][$j]['L_delete']=$lang['file']['delete'];
   
   $page['file'][$j]['link_delete']='';
   if($right_user['delete_file']) {
   	$page['file'][$j]['link_delete']=convert_url("index.php?r=".$lang['general']['idurl_file']."&v1=file_manager&mode=delete&file=".$page['current_folder'].$f.$fin_url,0);
   }
   $page['file'][$j]['size']=filesize_format(@filesize($rep.$f));
   $page['file'][$j]['width']="";
   $page['file'][$j]['height']="";
   if(in_array($type,$type_allowed)) { $page['file'][$j]['type']=$type; }         
   else { $page['file'][$j]['type']="unknown"; }
   
   $page['file'][$j]['L_view']=$lang['file']['view_image'];
   $page['file'][$j]['category']="";
   
   if(in_array($type,$type_allowed_image)) { $page['file'][$j]['category']="image"; }
   if(in_array($type,$type_allowed_video)) { $page['file'][$j]['category']="video"; }
   if(in_array($type,$type_allowed_text)) { $page['file'][$j]['category']="text"; }
   if(in_array($type,$type_allowed_flash)) { $page['file'][$j]['category']="flash"; }
   if(in_array($type,$type_allowed_application)) { $page['file'][$j]['category']="application"; }
   
   switch($type) { 
    case "jpg" : if(function_exists('imagecreatefromjpeg')) $img=@imagecreatefromjpeg($rep.$f); break;
	case "png" : if(function_exists('imagecreatefrompng')) $img=@imagecreatefrompng($rep.$f);  break;
	case "gif" : if(function_exists('imagecreatefromgif')) $img=@imagecreatefromgif($rep.$f); break;
	default : $img=false;
   }
   
   if(isset($img) AND $img!=false)
   {
    $page['file'][$j]['width']=@imagesx($img);
    $page['file'][$j]['height']=@imagesy($img);	
    imagedestroy($img);
   }
   $j++;
  }
}


if($right_user['add_file']) {
$page['show_upload']="1";
}
else { $page['show_upload']=""; }

$page['upload_folder']="/".$page['folder'].$page['current_folder'];

/* element texte */

$page['max_file_size']=MAX_FILE_SIZE;
$page['L_title']=$lang['file']['choose_file'];
$page['L_upload_file']=$lang['file']['upload_file'];
$page['L_file_list']=$lang['file']['file_list'];
$page['L_hide']=$lang['file']['hide'];
$page['L_file']=$lang['file']['file'];
$page['L_folder']=$lang['file']['folder'];
$page['L_new_folder']=$lang['file']['new_folder'];
$page['L_choose_folder']=$lang['file']['choose_folder'];
$page['L_root']=$lang['file']['root'];
$page['L_file_name']=$lang['file']['file_name'];
$page['L_folder_name']=$lang['file']['folder_name'];
$page['L_view_image']=$lang['file']['view_image'];
$page['L_thumb']=$lang['file']['thumb'];
$page['L_select_file']=$lang['file']['select_file'];
$page['L_submit']=$lang['file']['submit'];

$page['L_insert_none']=$lang['file']['insert_none'];
$page['L_erreur']=$lang['general']['E_erreur'];

$page['template']=$tpl['file']['file_manager'];

?>