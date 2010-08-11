<?php
##################################
# import club 
##################################

# variables
$page['L_message']="";
$page['form_action']=convert_url("index.php?r=".$lang['general']['idurl_club']."&v1=import_club");

$nb_erreur="0";
$page['erreur']=array();
$page['pop']="";


$type_allowed=array("csv");
$type_mime_allowed=array('text/comma-separated-values','application/vnd.ms-excel','application/octet-stream','plain/text');


# form values
$page['value_id']="";
$page['value_name']="";
$page['value_abbreviation']="";
$page['value_address']="";
$page['value_logo']="";
$page['value_color']="";
$page['value_color_alternative']="";
$page['value_telephone']="";
$page['value_fax']="";
$page['value_email']="";
$page['value_url']="";
$page['value_creation_year']="";
$page['value_comment']="";

$page['value_separator']=";";
$page['value_first_line']="";
$page['first_line_checked']="";

$page['line']=array();
$page['nb_column']=0;
$column_name=array();
$page['column']=array();


$page['data']=array();
$page['club_field']=array();

$page['value_step']="upload";
$page['num_step']="1";
$page['show_step_1']="1"; $page['show_step_2']=""; $page['show_step_3']="";

if(isset($_POST['step'])) $page['value_step']=$_POST['step'];

switch($page['value_step']) {
 case "upload" : $page['num_step']="1"; $page['show_step_1']="1"; $page['show_step_2']=""; $page['show_step_3']=""; break;
 case "associate_field" : $page['num_step']="2"; $page['show_step_1']=""; $page['show_step_2']="1"; $page['show_step_3']=""; break;
 case "validation" : $page['num_step']="3"; $page['show_step_1']=""; $page['show_step_2']=""; $page['show_step_3']="1"; break;
 default : $page['num_step']="1"; $page['show_step_1']="1"; $page['show_step_2']=""; $page['show_step_3']=""; break;
}


# available club fields
$club_field=array(
"club_name"=>$lang['club']['name'],
"club_abbreviation"=>$lang['club']['abbreviation'],
"club_address"=>$lang['club']['address'],
"club_color"=>$lang['club']['color'],
"club_telephone"=>$lang['club']['telephone'],
"club_fax"=>$lang['club']['fax'],
"club_email"=>$lang['club']['email'],
"club_url"=>$lang['club']['url'],
"club_creation_year"=>$lang['club']['creation_year']);

$club_field_num=array(); // numero des colonnes correspondants

if($right_user['import_club']) {
	$page['show_form']=1; 
}
else {
	$page['show_form']='';
	$page['L_message']=$lang['general']['acces_reserve_admin'];
}

# step 3 : we need existing clubs list
$club_list=array();
//if($page['value_step']=='validation') {	
	$sql_club=$sql['club']['select_club'];	
	$sgbd = sql_connect();
	$res_club = sql_query($sql_club);
	$nb_ligne=sql_num_rows($res_club);
	if($nb_ligne!="0")
	{
		while($ligne = sql_fetch_array($res_club))
		{
			$id=$ligne['club_id'];
	 		$club_list[$id]=$ligne['club_name'];
		}
	}
//}



# form treatment
# step 1 : we upload the data from the .csv file
if(isset($_POST['step']) AND $_POST['step']=="upload" AND $right_user['import_club'])
{	
	# we check submitted data
 	if(!isset($_FILES['file']['name']) OR empty($_FILES['file']['name'])) { $page['erreur'][$nb_erreur]['message']=$lang['club']['E_empty_file']; $nb_erreur++; }
	elseif(!in_array($_FILES['file']['type'],$type_mime_allowed)) { 
		
	$var['type']=implode(", ",$type_allowed);
	$page['erreur'][$nb_erreur]['message']=text_replace($lang['club']['E_invalid_file_type'],$var); $nb_erreur++; }
 
	if($_FILES['file']['size'] > MAX_FILE_SIZE)  { 
	$var['max_file_size']=filesize_format(MAX_FILE_SIZE);
	$page['erreur'][$nb_erreur]['message']=text_replace($lang['club']['E_invalid_file_size'],$var); $nb_erreur++; }		
	
	if(!isset($_POST['separator']) OR empty($_POST['separator'])) { $page['erreur'][$nb_erreur]['message']=$lang['club']['E_empty_separator']; $nb_erreur++; }
	
	# there is no error : we upload the file and get its content
	if($nb_erreur==0)
	{ 	
		if(isset($_POST['first_line'])) $page['value_first_line']=$_POST['first_line'];

		$path_file=ROOT."/".FILE_FOLDER."/import_club.csv";
	   
		$copy_file=move_uploaded_file($_FILES['file']['tmp_name'],$path_file);
	   
		if(!$copy_file) { 
		   # error during copy
		   
		}
		else { 
			# we parse the file and stock the data in a variable				

			$i=0; $k=0;
			$handle = fopen($path_file, "r");
			while (($data = fgetcsv($handle, 1000, $_POST['separator'])) !== FALSE) {
				$nb_column = count($data);					
				if($nb_column > $page['nb_column']) $page['nb_column']=$nb_column;

				$page['line'][$i]['column']=array();
				$page['line'][$i]['mod']=$i%2;
				for ($j=0; $j < $nb_column; $j++) {
					$page['line'][$i]['column'][$j]['value']=format_txt($data[$j]);
					$page['line'][$i]['column'][$j]['example']=text_tronquer($page['line'][$i]['column'][$j]['value'],20,1);
					$page['line'][$i]['column'][$j]['i']=$i;
					$page['line'][$i]['column'][$j]['j']=$j;
					
					if($k==0 AND $page['value_first_line']==1) {
						$column_name[$j]=$data[$j];	
						if($j==$nb_column-1) { $i--; }
					}
				}					
				$i++; $k++;
			}
			fclose($handle);			
			
			# everything worked fine, we can delete the .csv file
			@unlink($path_file);			
						
			$page['value_step']="associate_field";
			$page['num_step']="2";
			$page['show_step_1']=""; $page['show_step_2']="1";	$page['show_step_3']="";			
					
		}  
	}
	else {
		$page['value_separator']=$_POST['separator'];
		if(isset($_POST['first_line'])) $page['value_first_line']=$_POST['first_line'];				
	}	
	
}

# step 2 : we associate datas to the corresponding fields
elseif(isset($_POST['step']) AND $_POST['step']=="associate_field" AND $right_user['import_club']) {

	# we check that the club name was choosen
	
	# we check that the column names are not present twice	
	$column=array();
	if(isset($_POST['club_field']) AND is_array($_POST['club_field'])) {				
		
		if(!in_array("club_name",$_POST['club_field'])) {
			$page['erreur'][$nb_erreur]['message']=$lang['club']['E_empty_club_name_field']; $nb_erreur++;
		}
	
		foreach($_POST['club_field'] AS $id => $value) {			
			if($value!="") {
				if(in_array($value,$column) AND $nb_erreur=="0") { 
					$page['erreur'][$nb_erreur]['message']=$lang['club']['E_exists_club_field']; $nb_erreur++; 
				}
				array_push($column,$value);
				
				# on enregistre les numeros des colonnes pour faire les correspondances								
				
				foreach($club_field AS $key => $values) {
					if($value==$key) { $club_field_num[$key]=$id; }					
				}				
				
				if($value=="club_name") $num_col_name=$id; // index of the colum corresponding to the club name
				if($value=="club_abbreviation") $num_col_abbreviation=$id; // index of the colum corresponding to the club abbreviation												
			}
		}
	}


	if($nb_erreur==0)
	{		
		# we get the name of the field		
		$nb_column=sizeof($column);
		for($i=0; $i < $nb_column; $i++) {
			$id=$column[$i];
			$page['club_field'][$i]['i']=$i;
			if($id!="") {				
				$page['club_field'][$i]['name']=$club_field[$id];
				$page['club_field'][$i]['value']=$id;
			}
			else {
				$page['club_field'][$i]['name']="";
				$page['club_field'][$i]['value']="";			
			}						
		}		
		
		# we get the datas
		$nb_line=sizeof($_POST['data']);
		//$nb_column=sizeof($_POST['data'][0]);
	
		for($i=0; $i < $nb_line; $i++) {		
			$page['data'][$i]['i']=$i;
			$page['data'][$i]['cpt']=$i+1;
			$page['data'][$i]['mod']=$i%2;
			$page['data'][$i]['checked_import']="";
			$page['data'][$i]['checked_merge']="";
			$page['data'][$i]['checked_dont_import']="";
					
			for($j=0; $j < $nb_column; $j++) {
				$id=$column[$j];				
				$k=$club_field_num[$id];
			
				$page['data'][$i]['column'][$j]['value']=format_txt($_POST['data'][$i][$k]);
				$page['data'][$i]['column'][$j]['i']=$i;
				$page['data'][$i]['column'][$j]['j']=$j;
			}
			
			# we check that the club doesn't already exist
			$var['condition']=" WHERE club_name='".$_POST['data'][$i][$num_col_name]."' ";
			if(isset($num_col_abbreviation)) $var['condition'].=" OR club_abbreviation='".$_POST['data'][$i][$num_col_abbreviation]."' ";			
			$var['order']="";
			$var['limit']=" LIMIT 1 ";
			$sql_check=sql_replace($sql['club']['select_club_condition'],$var);
			$sgbd = sql_connect();
			$res_check = sql_query($sql_check);
			$ligne=sql_fetch_array($res_check);	
			
			if(sql_num_rows($res_check) !=0) {
				# we found a club, we propose to merge the information
				$page['data'][$i]['club_name']=$ligne['club_name'];
				$page['data'][$i]['club_id']=$ligne['club_id'];
				$page['data'][$i]['checked_merge']="checked=\"checked\"";				
				$page['L_message']=$lang['club']['E_found_club'];			
			}
			else {
				$page['data'][$i]['club_name']="";
				$page['data'][$i]['club_id']="";
				$page['data'][$i]['checked_import']="checked=\"checked\"";
			}						
			sql_free_result($res_check);
			
			# club list
			$page['data'][$i]['club_list']=array();
			$j=0;
			foreach($club_list AS $id => $value) {
				$page['data'][$i]['club_list'][$j]['id']=$id;
				$page['data'][$i]['club_list'][$j]['name']=$value;
				$page['data'][$i]['club_list'][$j]['selected']='';
				if($id==$page['data'][$i]['club_id']) {
					$page['data'][$i]['club_list'][$j]['selected']='selected="selected"';
				}
				$j++;
			}
			
			$page['data'][$i]['L_choose_club']=$lang['club']['choose_club'];
			$page['data'][$i]['L_import']=$lang['club']['import_new_club'];
			$page['data'][$i]['L_merge']=$lang['club']['merge_club'];
			$page['data'][$i]['L_dont_import']=$lang['club']['dont_import'];			
			
		}
		
		$page['value_step']="validation";
		$page['num_step']="3";
		$page['show_step_1']=""; $page['show_step_2']=""; $page['show_step_3']="1";
	}
	else {
		# there was an error
		$page['nb_column']=sizeof($_POST['club_field']);
						
		$page['nb_line']=sizeof($_POST['data']);
			
		for($i=0; $i < $page['nb_line']; $i++) {			
			$page['line'][$i]['i']=$i;
			$page['line'][$i]['mod']=$i%2;
			$page['line'][$i]['column']=array();

			for($j=0; $j < $page['nb_column']; $j++) {
				$page['line'][$i]['column'][$j]['value']=format_txt($_POST['data'][$i][$j]);
				$page['line'][$i]['column'][$j]['example']=text_tronquer($_POST['data'][$i][$j],20,1);
				$page['line'][$i]['column'][$j]['i']=$i;
				$page['line'][$i]['column'][$j]['j']=$j;												
			}
		}
	}
}
# step 2 : we checked all datas
elseif(isset($_POST['step']) AND $_POST['step']=="validation" AND $right_user['import_club']) {
	
	$nb_club=sizeof($_POST['data']);
	
	foreach($_POST['club_field'] AS $id => $value) {
		if($value=="club_name") { $id_name=$id; }
		if($value=="club_email") { $id_email=$id; }
		if($value=="club_url") { $id_url=$id; }
	}
	
	# we check that the name does not already exists (for new club)
	if(isset($id_name)) {
		$nb_club_found=0;
		$nb_club_same=0;
		$nb_club_empty=0;
		$club_found=array();
		$club_import=array();
		$club_same=array();
		
		for($i=0; $i < $nb_club; $i++) {				
			# the club has no name
			if(empty($_POST['data'][$i][$id_name])) {					
				$nb_club_empty++;					
			}
			
			# the club is new but already exists in the database				
			if($_POST['action'][$i]=='import' AND in_array($_POST['data'][$i][$id_name],$club_list)) {					
				array_push($club_found, $_POST['data'][$i][$id_name]);
				$nb_club_found++;					
			}
			
			# the same club was found in the imported list
			if(in_array($_POST['data'][$i][$id_name],$club_import)) {
				array_push($club_same, $_POST['data'][$i][$id_name]);
				$nb_club_same++;				
			}
			array_push($club_import, $_POST['data'][$i][$id_name]);
		}
		
		if($nb_club_empty!=0) {
			$page['erreur'][$nb_erreur]['message']=$lang['club']['E_empty_clubs_name'];
			$nb_erreur++;
		}
		
		if($nb_club_found!=0) {
			$var['club']=implode(', ',$club_found);
			$page['erreur'][$nb_erreur]['message']=text_replace($lang['club']['E_exist_clubs'], $var);
			$nb_erreur++;
		}
		
		if($nb_club_same!=0) {
			$var['club']=implode(', ',$club_same);
			$page['erreur'][$nb_erreur]['message']=text_replace($lang['club']['E_invalid_club_name'], $var);
			$nb_erreur++;
		}			
	}
		
	# we check that the value format is correct		
	if(isset($id_email)) {
		$nb_invalid=0;
		$club_found=array();
		for($i=0; $i < $nb_club; $i++) {
			if(!empty($_POST['data'][$i][$id_email]) AND !check_email($_POST['data'][$i][$id_email])) {
				array_push($club_found, $_POST['data'][$i][$id_name]);
				$nb_invalid++;
			}			
		}			
		if($nb_invalid!=0) {
			$var['club']=implode(', ',$club_found);
			$page['erreur'][$nb_erreur]['message']=text_replace($lang['club']['E_invalid_email_clubs'], $var);
			$nb_erreur++;
		}		
	}
	
	if(isset($id_url)) {
		$nb_invalid=0;
		$club_found=array();
		for($i=0; $i < $nb_club; $i++) {
			if(!empty($_POST['data'][$i][$id_url]) AND !check_url($_POST['data'][$i][$id_url])) {
				array_push($club_found, $_POST['data'][$i][$id_name]);
				$nb_invalid++;
			}			
		}			
		if($nb_invalid!=0) {
			$var['club']=implode(', ',$club_found);
			$page['erreur'][$nb_erreur]['message']=text_replace($lang['club']['E_invalid_url_clubs'], $var);
			$nb_erreur++;
		}		
	}
		
	if(isset($id_creation_year)) {
		$nb_invalid=0;
		$club_found=array();
		for($i=0; $i < $nb_club; $i++) {
			if(!empty($_POST['data'][$i][$id_creation_year]) AND !check_date("01-01-".$_POST['data'][$i][$id_creation_year])) {
				array_push($club_found, $_POST['data'][$i][$id_name]);
				$nb_invalid++;
			}			
		}			
		if($nb_invalid!=0) {
			$var['club']=implode(', ',$club_found);
			$page['erreur'][$nb_erreur]['message']=text_replace($lang['club']['E_invalid_creation_year_clubs'], $var);
			$nb_erreur++;
		}	
	}	
	
	
	# we check that if the merge option is selected, a club has been chosen
	for($i=0; $i < $nb_club; $i++) {		
		if($_POST['action'][$i]=='merge' AND empty($_POST['club'][$i]) AND $nb_erreur==0) {
			$page['erreur'][$nb_erreur]['message']=$lang['club']['E_empty_club_merge'];
			$nb_erreur++;
		}	
	}
	
	
	if($nb_erreur==0) {
		# correspondance des colonnes
		$nb_column=sizeof($_POST['club_field']);
	
		$nb_line=sizeof($_POST['data']);
		
		$sgbd = sql_connect();		
		for($i=0; $i < $nb_line; $i++) {			
			# on construit la requete
			for($j=0; $j < $nb_column; $j++) {				
				$field_list[$j]=$_POST['club_field'][$j];
				$value_list[$j]=format_txt($_POST['data'][$i][$j]); // we format data
				# for merge, we update only non-empty data
				if($value_list[$j]!="") { $field_value_list[$j]=$field_list[$j]."='".$value_list[$j]."'"; }
			}
		
			if($_POST['action'][$i]=="import") {
				# we add the club
				$var['field']=implode(", ",$field_list);
				$var['values']="'".implode("', '",$value_list)."'";
				
				$sql_import=sql_replace($sql['club']['import_club'], $var);				
				sql_query($sql_import);
			}
			elseif($_POST['action'][$i]=="merge") {
				# we merge the club with the one found (we update only the not empty field)
				$var['field_value']=implode(", ",$field_value_list);
				$var['id']=$_POST['club'][$i];
				
				$sql_merge=sql_replace($sql['club']['merge_club'], $var);
				sql_query($sql_merge);
			}
		}
		sql_close($sgbd);
		
		$page['value_step']="";
		$page['num_step']="";
		$page['show_step_1']=""; $page['show_step_2']=""; $page['show_step_3']="";
		
		$page['L_message']=$lang['club']['import_club_1'];	
	}
	else {
		# there is some errors
		
		# club_field		
		$column=$_POST['club_field'];
		$nb_column=sizeof($column);
		
		for($i=0; $i < $nb_column; $i++) {
			$id=$column[$i];
			$page['club_field'][$i]['i']=$i;
			$page['club_field'][$i]['name']=$club_field[$id];
			$page['club_field'][$i]['value']=$id;			
		}
		
		# data
		$nb_line=sizeof($_POST['data']);
		for($i=0; $i < $nb_line; $i++) {		
			$page['data'][$i]['i']=$i;
			$page['data'][$i]['cpt']=$i+1;
			$page['data'][$i]['mod']=$i%2;
			$page['data'][$i]['checked_import']="";
			$page['data'][$i]['checked_merge']="";
			$page['data'][$i]['checked_dont_import']="";						
			if($_POST['action'][$i]=='import') { $page['data'][$i]['checked_import']='checked="checked"'; }
			if($_POST['action'][$i]=='merge') { $page['data'][$i]['checked_merge']='checked="checked"'; }
			if($_POST['action'][$i]=='dont_import') { $page['data'][$i]['checked_dont_import']='checked="checked"'; }									
					
			for($j=0; $j < $nb_column; $j++) {
				$id=$column[$j];			
				$page['data'][$i]['column'][$j]['value']=format_txt($_POST['data'][$i][$j]);
				$page['data'][$i]['column'][$j]['i']=$i;
				$page['data'][$i]['column'][$j]['j']=$j;
			}
			
			$page['data'][$i]['club_list']=array();
			$j=0;
			foreach($club_list AS $id => $value) {
				$page['data'][$i]['club_list'][$j]['id']=$id;
				$page['data'][$i]['club_list'][$j]['name']=$value;
				$page['data'][$i]['club_list'][$j]['selected']='';
				
				if($id==$_POST['club'][$i]) {
					$page['data'][$i]['club_list'][$j]['selected']='selected="selected"';
				}
				$j++;
			}
			
			$page['data'][$i]['L_choose_club']=$lang['club']['choose_club'];
			$page['data'][$i]['L_import']=$lang['club']['import_new_club'];
			$page['data'][$i]['L_merge']=$lang['club']['merge_club'];
			$page['data'][$i]['L_dont_import']=$lang['club']['dont_import'];
		}
	}
} // end step 3




# step 2 : we need column names
if($page['value_step']=="associate_field") {	
	if(isset($page['nb_column']) AND !empty($page['nb_column'])) {	
		for($i=0, $x="A"; $i < $page['nb_column']; $i++,$x++) {
			
			if($page['value_first_line']==1 AND !empty($column_name)) {
				$page['column'][$i]['name']=$column_name[$i];
			}
			else {		
				$page['column'][$i]['name']=$lang['club']['column']." ".$x;
			}
			$page['column'][$i]['i']=$i;			
			$page['column'][$i]['club_field']=array();
			$page['column'][$i]['L_choose_field']=$lang['club']['choose_field'];
			$j=0;
			foreach($club_field AS $id => $value) {
				$page['column'][$i]['club_field'][$j]['name']=$value;
				$page['column'][$i]['club_field'][$j]['id']=$id;
				$page['column'][$i]['club_field'][$j]['selected']="";
				
				if(isset($_POST['club_field'][$i]) AND $_POST['club_field'][$i]==$id) 
				{
					$page['column'][$i]['club_field'][$j]['selected']="selected";
				}
				
				$j++;
			}		
		}
	}	
}




switch($page['num_step']) {
 case 1 : 	$page['L_current_step']=$lang['club']['upload_file']; 
 			$page['L_current_step_info']=$lang['club']['upload_file_info']; 
 			break;
 case 2 : 	$page['L_current_step']=$lang['club']['associate_field'];
 			$page['L_current_step_info']=$lang['club']['associate_field_info'];
			break;
 case 3 : 	$page['L_current_step']=$lang['club']['check_data'];
 			$page['L_current_step_info']=$lang['club']['check_data_info'];
			break;
 default :  $page['L_current_step']=$lang['club']['upload_file'];
 			$page['L_current_step_info']=$lang['club']['upload_file_info'];
}



if($page['value_first_line']=="1") { $page['first_line_checked']="checked=\"checked\""; }

# link
$page['link_list']=convert_url("index.php?r=".$lang['general']['idurl_club']."&v1=club_list");

# text
$page['L_title']=$lang['club']['import_club'];
$page['L_step']=$lang['club']['step'];

$page['L_csv_file']=$lang['club']['csv_file'];
$page['L_separator']=$lang['club']['separator'];
$page['L_first_line']=$lang['club']['first_line'];

$page['L_file_column']=$lang['club']['file_column'];
$page['L_associated_field']=$lang['club']['associated_field'];

$page['L_action']=$lang['club']['action'];


$page['L_valider']=$lang['club']['submit'];
$page['L_delete']=$lang['club']['delete'];
$page['L_back_list']=$lang['club']['back_list']; 
$page['L_erreur']=$lang['general']['E_erreur'];
$page['L_field_required']=$lang['general']['field_required'];

$page['L_name']=$lang['club']['name'];
$page['L_abbreviation']=$lang['club']['abbreviation'];
$page['L_creation_year']=$lang['club']['creation_year'];
$page['L_color']=$lang['club']['color'];
$page['L_color_alternative']=$lang['club']['color_alternative'];
$page['L_address']=$lang['club']['address'];
$page['L_telephone']=$lang['club']['telephone'];
$page['L_fax']=$lang['club']['fax'];
$page['L_email']=$lang['club']['email'];
$page['L_url']=$lang['club']['url'];
$page['L_comment']=$lang['club']['comment'];
$page['L_format_year']=$lang['club']['format_year'];

$page['L_logo']=$lang['club']['logo'];
$page['L_choose_image']=$lang['club']['choose_image'];

$page['meta_title']=$page['L_title'];
$page['template']=$tpl['club']['import_club'];
?>