<?php
##################################
# import member 
##################################

# variables
$page['L_message']='';
$nb_error=0;
$page['erreur']=array();
$page['pop']='';


$type_allowed=array('csv');
$type_mime_allowed=array('text/comma-separated-values','application/vnd.ms-excel','application/octet-stream','plain/text');


# form values
$page['value_id']='';
$page['value_name']='';
$page['value_abbreviation']='';
$page['value_address']='';
$page['value_logo']='';
$page['value_color']='';
$page['value_color_alternative']='';
$page['value_telephone']='';
$page['value_fax']='';
$page['value_email']='';
$page['value_url']='';
$page['value_creation_year']='';
$page['value_comment']='';

$page['value_separator']=";";
$page['value_first_line']='';
$page['first_line_checked']='';
$page['value_season']='';

$page['line']=array();
$page['nb_column']=0;
$column_name=array();
$page['column']=array();


$page['data']=array();
$page['data_hidden']=array();
$page['member_field']=array();
$page['sex']=array();
$page['club']=array();
$page['country']=array();
$page['level']=array();
$page['new_value']=array();
$page['season']=array();
$season_needed=0;

$page['value_step']="upload";
$page['num_step']="1";
$page['show_step_1']="1"; $page['show_step_2']=''; 
$page['show_step_3']=''; $page['show_step_4']='';


if(isset($_POST['step'])) $page['value_step']=$_POST['step'];

switch($page['value_step']) {
 case "upload" : $page['num_step']="1"; $page['show_step_1']="1"; $page['show_step_2']=''; $page['show_step_3']=''; $page['show_step_4']=''; break;
 case "associate_field" : $page['num_step']="2"; $page['show_step_1']=''; $page['show_step_2']="1"; $page['show_step_3']=''; $page['show_step_4']=''; break;
 case "associate_value" : $page['num_step']="3"; $page['show_step_1']=''; $page['show_step_2']=''; $page['show_step_3']="1"; $page['show_step_4']=''; break;
 case "validation" : $page['num_step']="4"; $page['show_step_1']=''; $page['show_step_2']=''; $page['show_step_3']=''; $page['show_step_4']="1"; break;
 default : $page['num_step']="1"; $page['show_step_1']="1"; $page['show_step_2']=''; $page['show_step_3']=''; $page['show_step_4']=''; break;
}


# available member fields
$member_field=array(
"member_lastname"=>$lang['member']['name'],
"member_firstname"=>$lang['member']['firstname'],
"sex_id"=>$lang['member']['sex'],
"member_date_birth"=>$lang['member']['date_birth'],
"member_place_birth"=>$lang['member']['place_birth'],
"country_id"=>$lang['member']['nationality'],
"member_size"=>$lang['member']['size'],
"member_weight"=>$lang['member']['weight'],
"member_email"=>$lang['member']['email'],
"member_login"=>$lang['member']['login'],
"club_id"=>$lang['member']['club'],
"level_id"=>$lang['member']['level'],
"member_comment"=>$lang['member']['comment']); 
  
$member_field_num=array(); // numero des colonnes correspondants


# required for step 4 : we need existing members list
$member_list=array();
//if($page['value_step']=='validation') {	
	$sql_member=$sql['member']['select_member'];	
	$sgbd = sql_connect();
	$res_member = sql_query($sql_member);
	$nb_ligne=sql_num_rows($res_member);
	if($nb_ligne!="0")
	{
		while($ligne = sql_fetch_array($res_member))
		{
			$id=$ligne['member_id'];
	 		$member_list[$id]=$ligne['member_firstname']." ".$ligne['member_lastname'];
		}
	}
//}


# sex list : required for step 3
$sex_list=array();
$sql_sex=$sql['member']['select_sex'];
$sgbd = sql_connect();
$res_sex = sql_query($sql_sex);
while($ligne = sql_fetch_array($res_sex)) 
{
	$id=$ligne['sex_id'];
	$sex_list[$id]=$ligne['sex_name'];
}

# country list : required for step 3
$country_list=array();
$sql_country=$sql['member']['select_country'];
$sgbd = sql_connect();
$res_country = sql_query($sql_country);
while($ligne = sql_fetch_array($res_country)) 
{
	$id=$ligne['country_id'];
	$country_list[$id]=$ligne['country_name'];
}

# club list : required for step 3
$club_list=array();
include_once(create_path("club/sql_club.php"));
$sql_club=$sql['club']['select_club'];
$sgbd = sql_connect();
$res_club = sql_query($sql_club);
while($ligne = sql_fetch_array($res_club)) 
{
	$id=$ligne['club_id'];
	$club_list[$id]=$ligne['club_name'];
}
sql_free_result($res_club);
sql_close($sgbd);

# level list : required for step 3
$level_list=array();
$sql_level=$sql['member']['select_level'];
$sgbd = sql_connect();
$res_level = sql_query($sql_level);
while($ligne = sql_fetch_array($res_level)) 
{
	$id=$ligne['level_id'];
	$level_list[$id]=$ligne['level_name'];
}

# form treatment
# step 1 : we upload the data from the .csv file
if(isset($_POST['step']) AND $_POST['step']=="upload")
{	
	# we check submitted data
 	if(!isset($_FILES['file']['name']) OR empty($_FILES['file']['name'])) { $page['erreur'][$nb_error]['message']=$lang['member']['E_empty_file']; $nb_error++; }
	elseif(!in_array($_FILES['file']['type'],$type_mime_allowed)) { 
		
	$var['type']=implode(", ",$type_allowed);
	$page['erreur'][$nb_error]['message']=text_replace($lang['member']['E_invalid_file_type'],$var); $nb_error++; }
 
	if($_FILES['file']['size'] > MAX_FILE_SIZE)  { 
	$var['max_file_size']=filesize_format(MAX_FILE_SIZE);
	$page['erreur'][$nb_error]['message']=text_replace($lang['member']['E_invalid_file_size'],$var); $nb_error++; }		
	
	if(!isset($_POST['separator']) OR empty($_POST['separator'])) { $page['erreur'][$nb_error]['message']=$lang['member']['E_empty_separator']; $nb_error++; }
	
	# there is no error : we upload the file and get its content
	if($nb_error==0)
	{ 	
		if(isset($_POST['first_line'])) $page['value_first_line']=$_POST['first_line'];

		$path_file=ROOT."/".FILE_FOLDER."/import_member.csv";
	   
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
			$page['show_step_1']=''; $page['show_step_2']="1"; 
			$page['show_step_3']=''; $page['show_step_4']='';			
					
		}  
	}
	else {
		$page['value_separator']=$_POST['separator'];
		if(isset($_POST['first_line'])) $page['value_first_line']=$_POST['first_line'];				
	}	
	
}

# step 2 : we associate datas to the corresponding fields
elseif(isset($_POST['step']) AND $_POST['step']=="associate_field") {

	# we check that the member name was choosen
	
	# we check that the column names are not present twice	
	$column=array();
	if(isset($_POST['member_field']) AND is_array($_POST['member_field'])) {				
		
		if(!in_array("member_lastname",$_POST['member_field'])) {
			$page['erreur'][$nb_error]['message']=$lang['member']['E_empty_member_lastname_field']; $nb_error++;
		}
		
		if(!in_array("member_firstname",$_POST['member_field'])) {
			$page['erreur'][$nb_error]['message']=$lang['member']['E_empty_member_firstname_field']; $nb_error++;
		}		
	
		foreach($_POST['member_field'] AS $id => $value) {			
			if($value!="") {
				if(in_array($value,$column) AND $nb_error=="0") { 
					$page['erreur'][$nb_error]['message']=$lang['member']['E_exists_member_field']; $nb_error++; 
				}
				array_push($column,$value);
				
				# on enregistre les numeros des colonnes pour faire les correspondances								
				
				foreach($member_field AS $key => $values) {
					if($value==$key) { $member_field_num[$key]=$id; }					
				}				
				
				if($value=="member_lastname") $num_col_lastname=$id; 
				elseif($value=="member_firstname") $num_col_firstname=$id;
				elseif($value=="sex_id") $num_col_sex=$id;
				elseif($value=="level_id") $num_col_level=$id;
				elseif($value=="country_id") $num_col_country=$id;
				elseif($value=="club_id") $num_col_club=$id;
			}
		}
	}


	if($nb_error==0)
	{		
		# we get fields
		$nb_column=sizeof($column);
		for($i=0; $i < $nb_column; $i++) {
			$id=$column[$i];			
			$page['member_field'][$i]['i']=$i;
			$page['member_field'][$i]['name']='';
			$page['member_field'][$i]['value']=$id;			
		}		
		
		# we get data		
		$nb_line=sizeof($_POST['data']);		
		for($i=0; $i < $nb_line; $i++) {					
			$page['data_hidden'][$i]['i']=$i;
			for($j=0; $j < $nb_column; $j++) {
				$id=$column[$j];				
				$k=$member_field_num[$id];							
				$page['data_hidden'][$i]['column'][$j]['value']=format_txt($_POST['data'][$i][$k]);
				$page['data_hidden'][$i]['column'][$j]['i']=$i;
				$page['data_hidden'][$i]['column'][$j]['j']=$j;
			}
		}					
		
		# if the column sex, country, level or club are chosen, we need to associate existing values
		$nb_sex=0;
		$nb_country=0;
		$nb_club=0;
		$nb_level=0;
		
		if(isset($num_col_sex)) {
			# we get the sex presents in the list
			$nb_line=sizeof($_POST['data']);
			$sex_data=array();
			for($i=0; $i < $nb_line; $i++) {
				if($_POST['data'][$i][$num_col_sex]!="") {
					array_push($sex_data,$_POST['data'][$i][$num_col_sex]);
				}
			}
			# we remove duplicates values from all the sex presents in the list		
			$sex_data=array_unique($sex_data);
			
			$i=0;			
			foreach($sex_data AS $id => $value) {
				$page['sex'][$i]['i']=$i;
				$page['sex'][$i]['value']=$value;				
				$page['sex'][$i]['L_choose_sex']=$lang['member']['choose_sex'];
				$page['sex'][$i]['L_add_new_value']=$lang['member']['add_new_value'];
				$page['sex'][$i]['new_selected']='';
				$page['sex'][$i]['sex_list']=array();
				
				# select list
				$j=0;				
				foreach($sex_list AS $id_sex => $value_sex) {
					$page['sex'][$i]['sex_list'][$j]['id']=$id_sex;
					$page['sex'][$i]['sex_list'][$j]['name']=$value_sex;
					$page['sex'][$i]['sex_list'][$j]['selected']='';
					if($value_sex==$page['sex'][$i]['value']) {
						$page['sex'][$i]['sex_list'][$j]['selected']='selected="selected"';
					}
					$j++;
				}				
				
				$i++;
			}
			$nb_sex=$i;
		}
		
		if(isset($num_col_country)) {
			# we get the country presents in the list
			$nb_line=sizeof($_POST['data']);
			$country_data=array();
			for($i=0; $i < $nb_line; $i++) {
				if($_POST['data'][$i][$num_col_country]!="") {
					array_push($country_data,$_POST['data'][$i][$num_col_country]);
				}
			}
			# we remove duplicates values from all the sex presents in the list		
			$country_data=array_unique($country_data);
			
			$i=0;			
			foreach($country_data AS $id => $value) {
				$page['country'][$i]['i']=$i+$nb_sex;
				$page['country'][$i]['value']=$value;				
				$page['country'][$i]['L_choose_country']=$lang['member']['choose_nationality'];
				$page['country'][$i]['L_add_new_value']=$lang['member']['add_new_value'];
				$page['country'][$i]['new_selected']='';
				$page['country'][$i]['country_list']=array();
				
				# select list
				$j=0;				
				foreach($country_list AS $id_country => $value_country) {
					$page['country'][$i]['country_list'][$j]['id']=$id_country;
					$page['country'][$i]['country_list'][$j]['name']=$value_country;
					$page['country'][$i]['country_list'][$j]['selected']='';
					if($value_country==$page['country'][$i]['value']) {
						$page['country'][$i]['country_list'][$j]['selected']='selected="selected"';
					}
					$j++;
				}								
				$i++;
			}
			$nb_country=$i;
		}
		
		if(isset($num_col_club)) {
			# we get the club presents in the list
			$nb_line=sizeof($_POST['data']);
			$club_data=array();
			for($i=0; $i < $nb_line; $i++) {
				if($_POST['data'][$i][$num_col_club]!="") {
					array_push($club_data,$_POST['data'][$i][$num_col_club]);
				}
			}
			# we remove duplicates values from all the sex presents in the list		
			$club_data=array_unique($club_data);
			
			$i=0;			
			foreach($club_data AS $id => $value) {
				$page['club'][$i]['i']=$i+$nb_sex+$nb_country;
				$page['club'][$i]['value']=$value;				
				$page['club'][$i]['L_choose_club']=$lang['member']['choose_club'];
				$page['club'][$i]['L_add_new_value']=$lang['member']['add_new_value'];
				$page['club'][$i]['new_selected']='';
				$page['club'][$i]['club_list']=array();
				
				# select list
				$j=0;				
				foreach($club_list AS $id_club => $value_club) {
					$page['club'][$i]['club_list'][$j]['id']=$id_club;
					$page['club'][$i]['club_list'][$j]['name']=$value_club;
					$page['club'][$i]['club_list'][$j]['selected']='';
					if($value_club==$page['club'][$i]['value']) {
						$page['club'][$i]['club_list'][$j]['selected']='selected="selected"';
					}
					$j++;
				}				
				
				$i++;
			}
			$nb_club=$i;
		}

		if(isset($num_col_level)) {
			# we get the level presents in the list
			$nb_line=sizeof($_POST['data']);
			$level_data=array();
			for($i=0; $i < $nb_line; $i++) {
				if($_POST['data'][$i][$num_col_level]!="") {
					array_push($level_data,$_POST['data'][$i][$num_col_level]);
				}
			}
			# we remove duplicates values from all the sex presents in the list		
			$level_data=array_unique($level_data);
			
			$i=0;			
			foreach($level_data AS $id => $value) {
				$page['level'][$i]['i']=$i+$nb_sex+$nb_country+$nb_club;
				$page['level'][$i]['value']=$value;				
				$page['level'][$i]['L_choose_level']=$lang['member']['choose_nationality'];
				$page['level'][$i]['L_add_new_value']=$lang['member']['add_new_value'];
				$page['level'][$i]['new_selected']='';
				$page['level'][$i]['level_list']=array();
				
				# select list
				$j=0;				
				foreach($level_list AS $id_level => $value_level) {
					$page['level'][$i]['level_list'][$j]['id']=$id_level;
					$page['level'][$i]['level_list'][$j]['name']=$value_level;
					$page['level'][$i]['level_list'][$j]['selected']='';					
					if($value_level==$page['level'][$i]['value']) {
						$page['level'][$i]['level_list'][$j]['selected']='selected="selected"';
					}
					$j++;
				}								
				$i++;
			}
			$nb_level=$i;
		}	
		
		if(empty($page['sex']) AND empty($page['country']) AND empty($page['club']) AND empty($page['level'])) {
			$page['L_message']=$lang['member']['no_value_to_associate'];
		}
				
		$page['value_step']="associate_value";
		$page['num_step']="3";
		$page['show_step_1']=''; $page['show_step_2']=''; 
		$page['show_step_3']="1"; $page['show_step_4']='';
	}
	else {
		# there was an error
		$page['nb_column']=sizeof($_POST['member_field']);
						
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

# step 3 : we associate database values to the corresponding data (sex, country, level and club)
elseif(isset($_POST['step']) AND $_POST['step']=="associate_value") {

	# we check submited data	
	# we check that all records have a corresponding value
	if(isset($_POST['value']) AND !empty($_POST['value'])) {
		$nb_value=sizeof($_POST['value']);
		for($i=0; $i < $nb_value; $i++) {	
			if(empty($_POST['value_associate'][$i]) AND $nb_error==0) {
				// error :: each value must be associated
				$page['erreur'][$nb_error]['message']=$lang['member']['E_empty_value_associate'];
				$nb_error++;		
			}
		}
	}
	
	if($nb_error==0) {
		
		# we get the name of the field		
		$column=$_POST['member_field'];		
		$nb_column=sizeof($column);
			
		for($i=0; $i < $nb_column; $i++) {
			$id=$column[$i];
			$page['member_field'][$i]['i']=$i;
			$page['member_field'][$i]['name']=$member_field[$id];
			$page['member_field'][$i]['value']=$id;
			
			foreach($member_field AS $key => $values) {
				if($id==$key) { $member_field_num[$key]=$i; }					
			}					
			
			if($id=="member_lastname") $num_col_lastname=$i; 
			elseif($id=="member_firstname") $num_col_firstname=$i;
			elseif($id=="sex_id") $num_col_sex=$i;
			elseif($id=="level_id") $num_col_level=$i;
			elseif($id=="country_id") $num_col_country=$i;
			elseif($id=="club_id") $num_col_club=$i;
		}
		
		
		# we get the associate values		
		$sex_list_associate=array(); // we create an array with sex_id and corresponding value
		$country_list_associate=array();
		$club_list_associate=array();
		$level_list_associate=array();
		
		$new_sex_list=array();
		$new_country_list=array();
		$new_club_list=array();
		$new_level_list=array();
		
		if(isset($_POST['value']) AND !empty($_POST['value'])) {
			$nb_value=sizeof($_POST['value']);	
			for($i=0; $i < $nb_value; $i++) {			
				$id=$_POST['value_associate'][$i];
				if($_POST['value_type'][$i]=='sex') { 
					if($id==-1 AND !in_array($_POST['value'][$i],$new_sex_list)) $new_sex_list[]=$_POST['value'][$i];
					else { $sex_list_associate[$id]=$_POST['value'][$i]; }
				}
				elseif($_POST['value_type'][$i]=='country') { 	
					if($id==-1 AND !in_array($_POST['value'][$i],$new_country_list)) $new_country_list[]=$_POST['value'][$i];
					else { $country_list_associate[$id]=$_POST['value'][$i]; }
				}
				elseif($_POST['value_type'][$i]=='club') { 
					if($id==-1 AND !in_array($_POST['value'][$i],$new_club_list)) $new_club_list[]=$_POST['value'][$i];
					else { $club_list_associate[$id]=$_POST['value'][$i]; }
				}
				elseif($_POST['value_type'][$i]=='level') { 
					if($id==-1 AND !in_array($_POST['value'][$i],$new_level_list)) $new_level_list[]=$_POST['value'][$i];
					else { $level_list_associate[$id]=$_POST['value'][$i]; }
				}
			}
		}		
		
		
		$i=0;
		foreach($new_sex_list AS $id_sex => $value) {
			$page['new_value'][$i]['i']=$i;
			$page['new_value'][$i]['type']='sex';
			$page['new_value'][$i]['value']=$value;
			$i++;
		}
		foreach($new_country_list AS $id_country => $value) {
			$page['new_value'][$i]['i']=$i;
			$page['new_value'][$i]['type']='country';
			$page['new_value'][$i]['value']=$value;
			$i++;
		}
		foreach($new_club_list AS $id_club => $value) {
			$page['new_value'][$i]['i']=$i;
			$page['new_value'][$i]['type']='club';
			$page['new_value'][$i]['value']=$value;
			$i++;
		}
		foreach($new_level_list AS $id_level => $value) {
			$page['new_value'][$i]['i']=$i;
			$page['new_value'][$i]['type']='level';
			$page['new_value'][$i]['value']=$value;
			$i++;
		}
		
		# we get the datas		 
		$nb_line=sizeof($_POST['data']);
		//$nb_column=sizeof($_POST['data'][0]);
	
		for($i=0; $i < $nb_line; $i++) {		
			$page['data'][$i]['i']=$i;
			$page['data'][$i]['cpt']=$i+1;
			$page['data'][$i]['mod']=$i%2;
			$page['data'][$i]['checked_import']='';
			$page['data'][$i]['checked_merge']='';
			$page['data'][$i]['checked_dont_import']='';
					
			for($j=0; $j < $nb_column; $j++) {
				$id=$column[$j];				
				$k=$member_field_num[$id];
				
				$page['data'][$i]['column'][$j]['value_list']=array();
				$page['data'][$i]['column'][$j]['value']='';
				$page['data'][$i]['column'][$j]['i']=$i;
				$page['data'][$i]['column'][$j]['j']=$j;
				$page['data'][$i]['column'][$j]['show_value']='';
				if($id=="sex_id") {										
					$z=0;
					$page['data'][$i]['column'][$j]['L_choose']=$lang['member']['choose_sex'];
					foreach($sex_list AS $id_sex => $value) {

						$page['data'][$i]['column'][$j]['value_list'][$z]['id']=$id_sex;
						$page['data'][$i]['column'][$j]['value_list'][$z]['value']=$value;
				
						if(isset($sex_list_associate[$id_sex]) AND $_POST['data'][$i][$k]==$sex_list_associate[$id_sex]) {
							$page['data'][$i]['column'][$j]['value_list'][$z]['selected']='selected="selected"';
						}
						else {
						 $page['data'][$i]['column'][$j]['value_list'][$z]['selected']='';
						}
						$z++;
					}

					foreach($new_sex_list AS $id_sex => $value) {
						$page['data'][$i]['column'][$j]['value_list'][$z]['id']=$value;
						$page['data'][$i]['column'][$j]['value_list'][$z]['value']=$value;
						
						if($_POST['data'][$i][$k]==$new_sex_list[$id_sex]) {
							$page['data'][$i]['column'][$j]['value_list'][$z]['selected']='selected="selected"';
						}
						else {
						 $page['data'][$i]['column'][$j]['value_list'][$z]['selected']='';
						}
						$z++;
					}
				}
				elseif($id=="country_id") {										
					$z=0;
					$page['data'][$i]['column'][$j]['L_choose']=$lang['member']['choose_nationality'];
					foreach($country_list AS $id_country => $value) {

						$page['data'][$i]['column'][$j]['value_list'][$z]['id']=$id_country;
						$page['data'][$i]['column'][$j]['value_list'][$z]['value']=$value;
				
						if(isset($country_list_associate[$id_country]) AND $_POST['data'][$i][$k]==$country_list_associate[$id_country]) {
							$page['data'][$i]['column'][$j]['value_list'][$z]['selected']='selected="selected"';
						}
						else {
						 $page['data'][$i]['column'][$j]['value_list'][$z]['selected']='';
						}
						$z++;
					}

					foreach($new_country_list AS $id_country => $value) {
						$page['data'][$i]['column'][$j]['value_list'][$z]['id']=$value;
						$page['data'][$i]['column'][$j]['value_list'][$z]['value']=$value;
						
						if($_POST['data'][$i][$k]==$new_country_list[$id_country]) {
							$page['data'][$i]['column'][$j]['value_list'][$z]['selected']='selected="selected"';
						}
						else {
						 $page['data'][$i]['column'][$j]['value_list'][$z]['selected']='';
						}
						$z++;
					}
				}
				elseif($id=="club_id") {
					$season_needed=1; // if we have clubs, we need to get the season
					$z=0;
					$page['data'][$i]['column'][$j]['L_choose']=$lang['member']['choose_club'];
					foreach($club_list AS $id_club => $value) {

						$page['data'][$i]['column'][$j]['value_list'][$z]['id']=$id_club;
						$page['data'][$i]['column'][$j]['value_list'][$z]['value']=$value;
				
						if(isset($club_list_associate[$id_club]) AND $_POST['data'][$i][$k]==$club_list_associate[$id_club]) {
							$page['data'][$i]['column'][$j]['value_list'][$z]['selected']='selected="selected"';
						}
						else {
						 $page['data'][$i]['column'][$j]['value_list'][$z]['selected']='';
						}
						$z++;
					}

					foreach($new_club_list AS $id_club => $value) {
						$page['data'][$i]['column'][$j]['value_list'][$z]['id']=$value;
						$page['data'][$i]['column'][$j]['value_list'][$z]['value']=$value;
						
						if($_POST['data'][$i][$k]==$new_club_list[$id_club]) {
							$page['data'][$i]['column'][$j]['value_list'][$z]['selected']='selected="selected"';
						}
						else {
						 $page['data'][$i]['column'][$j]['value_list'][$z]['selected']='';
						}
						$z++;
					}
				}
				elseif($id=="level_id") {										
					$z=0;
					$page['data'][$i]['column'][$j]['L_choose']=$lang['member']['choose_level'];
					foreach($level_list AS $id_level => $value) {

						$page['data'][$i]['column'][$j]['value_list'][$z]['id']=$id_level;
						$page['data'][$i]['column'][$j]['value_list'][$z]['value']=$value;
				
						if(isset($level_list_associate[$id_level]) AND $_POST['data'][$i][$k]==$level_list_associate[$id_level]) {
							$page['data'][$i]['column'][$j]['value_list'][$z]['selected']='selected="selected"';
						}
						else {
						 $page['data'][$i]['column'][$j]['value_list'][$z]['selected']='';
						}
						$z++;
					}

					foreach($new_level_list AS $id_level => $value) {
						$page['data'][$i]['column'][$j]['value_list'][$z]['id']=$value;
						$page['data'][$i]['column'][$j]['value_list'][$z]['value']=$value;
						
						if($_POST['data'][$i][$k]==$new_level_list[$id_level]) {
							$page['data'][$i]['column'][$j]['value_list'][$z]['selected']='selected="selected"';
						}
						else {
						 $page['data'][$i]['column'][$j]['value_list'][$z]['selected']='';
						}
						$z++;
					}
				}
				else {					
					$page['data'][$i]['column'][$j]['value']=format_txt($_POST['data'][$i][$k]);
					$page['data'][$i]['column'][$j]['show_value']='1';
				}
			}
			
			# we check that the member doesn't already exist
			$var['condition']=" WHERE member_lastname='".$_POST['data'][$i][$num_col_lastname]."' AND member_firstname='".$_POST['data'][$i][$num_col_firstname]."' ";			
			$var['order']='';
			$var['limit']=" LIMIT 1 ";
			$sql_check=sql_replace($sql['member']['select_member_condition'],$var);
			$sgbd = sql_connect();
			$res_check = sql_query($sql_check);
			$ligne=sql_fetch_array($res_check);	
			
			if(sql_num_rows($res_check) !=0) {
				# we found a member, we propose to merge the information				
				$page['data'][$i]['member_id']=$ligne['member_id'];
				$page['data'][$i]['checked_merge']="checked=\"checked\"";				
				$page['L_message']=$lang['member']['E_found_member'];			
			}
			else {
				$page['data'][$i]['member_id']='';
				$page['data'][$i]['checked_import']="checked=\"checked\"";
			}						
			sql_free_result($res_check);
			
			
			# member list
			$page['data'][$i]['member_list']=array();
			$j=0;
			foreach($member_list AS $id => $value) {
				$page['data'][$i]['member_list'][$j]['id']=$id;
				$page['data'][$i]['member_list'][$j]['name']=$value;
				$page['data'][$i]['member_list'][$j]['selected']='';
				if($id==$page['data'][$i]['member_id']) {
					$page['data'][$i]['member_list'][$j]['selected']='selected="selected"';
				}
				$j++;
			}			
			
			$page['data'][$i]['L_choose_member']=$lang['member']['choose_member'];
			$page['data'][$i]['L_import']=$lang['member']['import_new_member'];
			$page['data'][$i]['L_merge']=$lang['member']['merge_member'];
			$page['data'][$i]['L_dont_import']=$lang['member']['dont_import'];			
			
		}		
				
		$page['value_step']="validation";
		$page['num_step']="4";
		$page['show_step_1']=''; $page['show_step_2']='';
		$page['show_step_3']=''; $page['show_step_4']="1";
	
	}
	else {
		# there was an error
		$nb_member_field=sizeof($_POST['member_field']);
		for($i=0; $i < $nb_member_field; $i++) {
			$page['member_field'][$i]['i']=$i;
			$page['member_field'][$i]['name']='';
			$page['member_field'][$i]['value']=$_POST['member_field'][$i];
		}
		
		$nb_data_hidden=sizeof($_POST['data']);
		for($i=0; $i < $nb_data_hidden; $i++) {
			$page['data_hidden'][$i]['column']=array();			
			$nb_column=sizeof($_POST['data'][$i]);			
			for($j=0; $j < $nb_column; $j++) {
				$page['data_hidden'][$i]['column'][$j]['i']=$i;
				$page['data_hidden'][$i]['column'][$j]['j']=$j;
				$page['data_hidden'][$i]['column'][$j]['value']=$_POST['data'][$i][$j];
			}
		}		
				
		$nb_value=sizeof($_POST['value']);
		$nb_sex=0;
		$nb_country=0;
		$nb_club=0;
		$nb_level=0;						
		
		for($i=0; $i < $nb_value; $i++) {
			if($_POST['value_type'][$i]=="sex") {
				$page['sex'][$nb_sex]['i']=$i;
				$page['sex'][$nb_sex]['value']=$_POST['value'][$i];
				$page['sex'][$nb_sex]['L_choose_sex']=$lang['member']['choose_sex'];
				$page['sex'][$nb_sex]['L_add_new_value']=$lang['member']['add_new_value'];
				$page['sex'][$nb_sex]['sex_list']=array();				
				
				# select list
				$j=0;				
				foreach($sex_list AS $id_list => $value_list) {
					$page['sex'][$nb_sex]['sex_list'][$j]['id']=$id_list;
					$page['sex'][$nb_sex]['sex_list'][$j]['name']=$value_list;
					$page['sex'][$nb_sex]['sex_list'][$j]['selected']='';
					if($id_list==$_POST['value_associate'][$i]) {
						$page['sex'][$nb_sex]['sex_list'][$j]['selected']='selected="selected"';
					}
					$j++;
				}
				if($_POST['value_associate'][$i]==-1) { 
					$page['sex'][$nb_sex]['new_selected']='selected="selected"';		
				}
				else {
					$page['sex'][$nb_sex]['new_selected']='';
				}
				$nb_sex++;
								
			}
			elseif($_POST['value_type'][$i]=="country") {
				$page['country'][$nb_country]['i']=$i;
				$page['country'][$nb_country]['value']=$_POST['value'][$i];
				$page['country'][$nb_country]['L_choose_country']=$lang['member']['choose_nationality'];
				$page['country'][$nb_country]['L_add_new_value']=$lang['member']['add_new_value'];
				$page['country'][$nb_country]['country_list']=array();				
				
				# select list
				$j=0;				
				foreach($country_list AS $id_list => $value_list) {
					$page['country'][$nb_country]['country_list'][$j]['id']=$id_list;
					$page['country'][$nb_country]['country_list'][$j]['name']=$value_list;
					$page['country'][$nb_country]['country_list'][$j]['selected']='';
					if($id_list==$_POST['value_associate'][$i]) {
						$page['country'][$nb_country]['country_list'][$j]['selected']='selected="selected"';
					}
					$j++;
				}
				if($_POST['value_associate'][$i]==-1) { 
					$page['country'][$nb_country]['new_selected']='selected="selected"';		
				}
				else {
					$page['country'][$nb_country]['new_selected']='';
				}				
				$nb_country++;
								
			}
			elseif($_POST['value_type'][$i]=="club") {
				$page['club'][$nb_club]['i']=$i;
				$page['club'][$nb_club]['value']=$_POST['value'][$i];
				$page['club'][$nb_club]['L_choose_club']=$lang['member']['choose_club'];
				$page['club'][$nb_club]['L_add_new_value']=$lang['member']['add_new_value'];
				$page['club'][$nb_club]['club_list']=array();				
				
				# select list
				$j=0;				
				foreach($club_list AS $id_list => $value_list) {
					$page['club'][$nb_club]['club_list'][$j]['id']=$id_list;
					$page['club'][$nb_club]['club_list'][$j]['name']=$value_list;
					$page['club'][$nb_club]['club_list'][$j]['selected']='';
					if($id_list==$_POST['value_associate'][$i]) {
						$page['club'][$nb_club]['club_list'][$j]['selected']='selected="selected"';
					}
					$j++;
				}
				if($_POST['value_associate'][$i]==-1) { 
					$page['club'][$nb_club]['new_selected']='selected="selected"';		
				}
				else {
					$page['club'][$nb_club]['new_selected']='';
				}				
				$nb_club++;
								
			}
			elseif($_POST['value_type'][$i]=="level") {
				$page['level'][$nb_level]['i']=$i;
				$page['level'][$nb_level]['value']=$_POST['value'][$i];
				$page['level'][$nb_level]['L_choose_level']=$lang['member']['choose_level'];
				$page['level'][$nb_level]['L_add_new_value']=$lang['member']['add_new_value'];
				$page['level'][$nb_level]['level_list']=array();				
				
				# select list
				$j=0;				
				foreach($level_list AS $id_list => $value_list) {
					$page['level'][$nb_level]['level_list'][$j]['id']=$id_list;
					$page['level'][$nb_level]['level_list'][$j]['name']=$value_list;
					$page['level'][$nb_level]['level_list'][$j]['selected']='';
					if($id_list==$_POST['value_associate'][$i]) {
						$page['level'][$nb_level]['level_list'][$j]['selected']='selected="selected"';
					}
					$j++;
				}
				if($_POST['value_associate'][$i]==-1) { 
					$page['level'][$nb_level]['new_selected']='selected="selected"';		
				}
				else {
					$page['level'][$nb_level]['new_selected']='';
				}				
				$nb_level++;			
			}
			
		}	
			
	}	
}

# step 4 : we checked all datas
elseif(isset($_POST['step']) AND $_POST['step']=="validation") {
	
	$nb_member=sizeof($_POST['data']);
	
	foreach($_POST['member_field'] AS $id => $value) {
		if($value=="member_lastname") { $id_name=$id; }
		if($value=="member_firstname") { $id_firstname=$id; }
		if($value=="member_email") { $id_email=$id; }
		if($value=="member_date_birth") { $id_date_birth=$id; }
		if($value=="member_login") { $id_login=$id; }
		if($value=="club_id") { $id_club=$id; }
	}
	
	
	# we check that the name does not already exists (for new member)
	if(isset($id_name)) {
		$nb_member_found=0;
		$nb_member_same=0;
		$nb_member_empty=0;
		$member_found=array();
		$member_import=array();
		$member_same=array();

		for($i=0; $i < $nb_member; $i++) {				
			# the member has no name			
			if(empty($_POST['data'][$i][$id_name])) {					
				$nb_member_empty++;					
			}
			
			# the member is new but already exists in the database				
			if($_POST['action'][$i]=='import' AND in_array($_POST['data'][$i][$id_firstname]." ".$_POST['data'][$i][$id_name],$member_list)) {					
				array_push($member_found, $_POST['data'][$i][$id_firstname]." ".$_POST['data'][$i][$id_name]);
				$nb_member_found++;					
			}
			
			# the same member was found in the imported list
			if(in_array($_POST['data'][$i][$id_name],$member_import)) {
				array_push($member_same, $_POST['data'][$i][$id_firstname]." ".$_POST['data'][$i][$id_name]);
				$nb_member_same++;				
			}
			array_push($member_import, $_POST['data'][$i][$id_firstname]." ".$_POST['data'][$i][$id_name]);
		}
		
		if($nb_member_empty!=0) {
			$page['erreur'][$nb_error]['message']=$lang['member']['E_empty_members_name'];
			$nb_error++;
		}
		
		if($nb_member_found!=0) {
			$var['member']=implode(', ',$member_found);
			$page['erreur'][$nb_error]['message']=text_replace($lang['member']['E_exist_members'], $var);
			$nb_error++;
		}
		
		if($nb_member_same!=0) {
			$var['member']=implode(', ',$member_same);
			$page['erreur'][$nb_error]['message']=text_replace($lang['member']['E_invalid_member_name'], $var);
			$nb_error++;
		}			
	}
		
	# we check that the value format is correct		
	if(isset($id_email)) {
		$nb_invalid=0;
		$member_found=array();
		for($i=0; $i < $nb_member; $i++) {
			if(!empty($_POST['data'][$i][$id_email]) AND !check_email($_POST['data'][$i][$id_email])) {
				array_push($member_found, $_POST['data'][$i][$id_name]);
				$nb_invalid++;
			}			
		}			
		if($nb_invalid!=0) {
			$var['member']=implode(', ',$member_found);
			$page['erreur'][$nb_error]['message']=text_replace($lang['member']['E_invalid_email_members'], $var);
			$nb_error++;
		}		
	}
	
	if(isset($id_date_birth)) {
		$nb_invalid=0;
		$member_found=array();
		for($i=0; $i < $nb_member; $i++) {
			if(!empty($_POST['data'][$i][$id_date_birth]) AND !check_date($_POST['data'][$i][$id_date_birth])) {
				array_push($member_found, $_POST['data'][$i][$id_name]);
				$nb_invalid++;
			}			
		}			
		if($nb_invalid!=0) {
			$var['member']=implode(', ',$member_found);
			$page['erreur'][$nb_error]['message']=text_replace($lang['member']['E_invalid_date_birth_members'], $var);
			$nb_error++;
		}		
	}
	
	if(isset($id_login)) {
		$nb_invalid=0;
		$member_found=array();
		for($i=0; $i < $nb_member; $i++) {
			if(!empty($_POST['data'][$i][$id_login]) AND !check_login($_POST['data'][$i][$id_login])) {
				array_push($member_found, $_POST['data'][$i][$id_login]);
				$nb_invalid++;
			}			
		}			
		if($nb_invalid!=0) {
			$var['member']=implode(', ',$member_found);
			$page['erreur'][$nb_error]['message']=text_replace($lang['member']['E_invalid_login_members'], $var);
			$nb_error++;
		}		
	}
	
	
	# we check that if the merge option is selected, a member has been chosen
	for($i=0; $i < $nb_member; $i++) {		
		if($_POST['action'][$i]=='merge' AND empty($_POST['member'][$i]) AND $nb_error==0) {
			$page['erreur'][$nb_error]['message']=$lang['member']['E_empty_member_merge'];
			$nb_error++;
		}	
	}
	
	# we check that a season is selected if club are specified
	if(isset($id_club)) {
		if(!isset($_POST['season']) OR empty($_POST['season'])) {
			$page['erreur'][$nb_error]['message']=$lang['member']['E_empty_season'];
			$nb_error++;
		}
	}
	
	
	if($nb_error==0) {
		# we add new_value
		$new_sex=array(); // array containing $id_sex => $sex_name
		$new_country=array();
		$new_club=array();
		$new_level=array();

		if(isset($_POST['new_value']) AND !empty($_POST['new_value'])) {
			$nb_value=sizeof($_POST['new_value']);
			$sgbd=sql_connect();
			for($i=0; $i < $nb_value; $i++) {
				if($_POST['new_value_type'][$i]=="sex") {
					$var['name']=$_POST['new_value'][$i];
					$var['abbreviation']=$_POST['new_value'][$i];
					$sql_insert_new=sql_replace($sql['member']['insert_sex'],$var);
					sql_query($sql_insert_new,$sgbd);
					$new_id=sql_insert_id($sgbd);
					$new_sex[$new_id]=$_POST['new_value'][$i];
				}
				elseif($_POST['new_value_type'][$i]=="country") {
					$var['name']=$_POST['new_value'][$i];
					$sql_insert_new=sql_replace($sql['member']['insert_country'],$var);
					sql_query($sql_insert_new,$sgbd);
					$new_id=sql_insert_id($sgbd);
					$new_country[$new_id]=$_POST['new_value'][$i];
				}
				elseif($_POST['new_value_type'][$i]=="club") {
					$var['name']=$_POST['new_value'][$i];
					$sql_insert_new=sql_replace($sql['club']['insert_club_name'],$var);
					sql_query($sql_insert_new,$sgbd);
					$new_id=sql_insert_id($sgbd);
					$new_club[$new_id]=$_POST['new_value'][$i];
				}
				elseif($_POST['new_value_type'][$i]=="level") {
					$var['name']=$_POST['new_value'][$i];
					$sql_insert_new=sql_replace($sql['member']['insert_level'],$var);
					sql_query($sql_insert_new,$sgbd);
					$new_id=sql_insert_id($sgbd);
					$new_level[$new_id]=$_POST['new_value'][$i];
				}
			}
		}	
	
	
		# correspondance des colonnes
		$nb_column=sizeof($_POST['member_field']);
	
		$nb_line=sizeof($_POST['data']);
		
		$sgbd = sql_connect();		
		for($i=0; $i < $nb_line; $i++) {			
			# on construit la requete
			$j_club=0;
			for($j=0; $j < $nb_column; $j++) {				
				$field_list[$j]=$_POST['member_field'][$j];
				$value_list[$j]=format_txt($_POST['data'][$i][$j]); // we format data

				if($field_list[$j]=='sex_id' AND $id_search=array_search($_POST['data'][$i][$j],$new_sex)) {
					$value_list[$j]=$id_search;
				}
				elseif($field_list[$j]=='country_id' AND $id_search=array_search($_POST['data'][$i][$j],$new_country)) {
					$value_list[$j]=$id_search;
				}
				elseif($field_list[$j]=='level_id' AND $id_search=array_search($_POST['data'][$i][$j],$new_level)) {
					$value_list[$j]=$id_search;
				}
				elseif($field_list[$j]=='club_id' AND $id_search=array_search($_POST['data'][$i][$j],$new_club)) {
					$value_list[$j]=$id_search;
				}
				
				if($field_list[$j]=='member_date_birth') { 
					$value_list[$j]=convert_date_sql($_POST['data'][$i][$j]);
				}
				
				if($field_list[$j]=='club_id') {
					$j_club=$j; // we stock the id of to extract it from the request
				}

				# for merge, we update only non-empty data
				if($value_list[$j]!='') { $field_value_list[$j]=$field_list[$j]."='".$value_list[$j]."'"; }
			}


			if($_POST['action'][$i]=="import") {
				# we extract the club
				if($j_club!=0) {
					$var_club=$value_list[$j_club];
					unset($value_list[$j_club]);
					unset($field_list[$j_club]);
				}

				# we add the member
				$var['field']=implode(", ",$field_list);
				$var['values']="'".implode("', '",$value_list)."'";
				
				$sql_import=sql_replace($sql['member']['import_member'], $var);				
				sql_query($sql_import);
				$member_id=sql_insert_id($sgbd);
				
				# member_club
				if($j_club!=0 AND $var_club!='') {
					$var['values']='('.$member_id.','.$var_club.','.$_POST['season'].')';
					$sql_member_club=sql_replace($sql['member']['insert_member_club'],$var);
					sql_query($sql_member_club);					
				}
				
			}
			elseif($_POST['action'][$i]=="merge") {
				# we extract the club
				if($j_club!=0) {
					$var_club=$value_list[$j_club];
					unset($field_value_list[$j_club]);
				}

				# we merge the member with the one found (we update only the not empty field)
				$var['field_value']=implode(", ",$field_value_list);
				$var['id']=$_POST['member'][$i];
				
				$sql_merge=sql_replace($sql['member']['merge_member'], $var);
				sql_query($sql_merge);				

				# member_club
				if($j_club!=0 AND $var_club!='') {
					$var['values']='('.$var['id'].','.$var_club.','.$_POST['season'].')';
					$sql_member_club=sql_replace($sql['member']['insert_member_club'],$var);
					sql_query($sql_member_club);					
				}
		
			}
		}
		sql_close($sgbd);
		
		$page['value_step']='';
		$page['num_step']='';
		$page['show_step_1']=''; $page['show_step_2']=''; 
		$page['show_step_3']=''; $page['show_step_4']='';
		
		$page['L_message']=$lang['member']['import_member_1'];	
	}
	else {
		# there is some errors
		
		# member_field		
		$column=$_POST['member_field'];
		$nb_column=sizeof($column);
		
		for($i=0; $i < $nb_column; $i++) {
			$id=$column[$i];
			$page['member_field'][$i]['i']=$i;
			$page['member_field'][$i]['name']=$member_field[$id];
			$page['member_field'][$i]['value']=$id;			
		}
		
		# new_value
		$new_sex_list=array();
		$new_country_list=array();
		$new_club_list=array();
		$new_level_list=array();
		
		if(isset($_POST['new_value']) AND !empty($_POST['new_value'])) {
			$nb_new_value=sizeof($_POST['new_value']);
			for($i=0; $i < $nb_new_value; $i++) {				
				$page['new_value'][$i]['i']=$i;				
				$page['new_value'][$i]['value']=$_POST['new_value'][$i];
				$page['new_value'][$i]['type']=$_POST['new_value_type'][$i];
				if($_POST['new_value_type'][$i]=="sex") { $new_sex_list[]=$_POST['new_value'][$i]; }
				if($_POST['new_value_type'][$i]=="country") { $new_country_list[]=$_POST['new_value'][$i]; }
				if($_POST['new_value_type'][$i]=="club") { $new_club_list[]=$_POST['new_value'][$i]; }
				if($_POST['new_value_type'][$i]=="level") { $new_level_list[]=$_POST['new_value'][$i]; }
			}
		}
		
		# season
		if(isset($_POST['season'])) {
			$page['value_season']=$_POST['season'];	
			$season_needed=1;
		}
		
		# data
		$nb_line=sizeof($_POST['data']);
		for($i=0; $i < $nb_line; $i++) {		
			$page['data'][$i]['i']=$i;
			$page['data'][$i]['cpt']=$i+1;
			$page['data'][$i]['mod']=$i%2;
			$page['data'][$i]['checked_import']='';
			$page['data'][$i]['checked_merge']='';
			$page['data'][$i]['checked_dont_import']='';
			if($_POST['action'][$i]=='import') { $page['data'][$i]['checked_import']='checked="checked"'; }
			if($_POST['action'][$i]=='merge') { $page['data'][$i]['checked_merge']='checked="checked"'; }
			if($_POST['action'][$i]=='dont_import') { $page['data'][$i]['checked_dont_import']='checked="checked"'; }									
					
			for($j=0; $j < $nb_column; $j++) {
				$id=$column[$j];			
				$page['data'][$i]['column'][$j]['value']=format_txt($_POST['data'][$i][$j]);
				$page['data'][$i]['column'][$j]['i']=$i;
				$page['data'][$i]['column'][$j]['j']=$j;
				$page['data'][$i]['column'][$j]['value_list']=array();
				$page['data'][$i]['column'][$j]['show_value']='';
				
				if($id=="sex_id") {										
					$z=0;
					$page['data'][$i]['column'][$j]['L_choose']=$lang['member']['choose_sex'];
					foreach($sex_list AS $id_sex => $value) {
						$page['data'][$i]['column'][$j]['value_list'][$z]['id']=$id_sex;
						$page['data'][$i]['column'][$j]['value_list'][$z]['value']=$value;				
						if($id_sex==$_POST['data'][$i][$j]) { 
							$page['data'][$i]['column'][$j]['value_list'][$z]['selected']='selected="selected"';
						}
						else {
						 $page['data'][$i]['column'][$j]['value_list'][$z]['selected']='';
						}
						$z++;
					}

					foreach($new_sex_list AS $id_sex => $value) {
						$page['data'][$i]['column'][$j]['value_list'][$z]['id']=$value;
						$page['data'][$i]['column'][$j]['value_list'][$z]['value']=$value;
						
						if($_POST['data'][$i][$j]==$new_sex_list[$id_sex]) {
							$page['data'][$i]['column'][$j]['value_list'][$z]['selected']='selected="selected"';
						}
						else {
						 $page['data'][$i]['column'][$j]['value_list'][$z]['selected']='';
						}
						$z++;
					}
				}
				elseif($id=="country_id") {
					$z=0;
					$page['data'][$i]['column'][$j]['L_choose']=$lang['member']['choose_nationality'];
					
					foreach($country_list AS $id_country => $value) {
						$page['data'][$i]['column'][$j]['value_list'][$z]['id']=$id_country;
						$page['data'][$i]['column'][$j]['value_list'][$z]['value']=$value;				
						if($id_country==$_POST['data'][$i][$j]) { 
							$page['data'][$i]['column'][$j]['value_list'][$z]['selected']='selected="selected"';
						}
						else {
						 $page['data'][$i]['column'][$j]['value_list'][$z]['selected']='';
						}
						$z++;
					}

					foreach($new_country_list AS $id_country => $value) {
						$page['data'][$i]['column'][$j]['value_list'][$z]['id']=$value;
						$page['data'][$i]['column'][$j]['value_list'][$z]['value']=$value;
						
						if($_POST['data'][$i][$j]==$new_country_list[$id_country]) {
							$page['data'][$i]['column'][$j]['value_list'][$z]['selected']='selected="selected"';
						}
						else {
						 $page['data'][$i]['column'][$j]['value_list'][$z]['selected']='';
						}
						$z++;
					}
				}
				elseif($id=="club_id") {
					$season_needed=1;
					$z=0;
					$page['data'][$i]['column'][$j]['L_choose']=$lang['member']['choose_club'];
					
					foreach($club_list AS $id_club => $value) {
						$page['data'][$i]['column'][$j]['value_list'][$z]['id']=$id_club;
						$page['data'][$i]['column'][$j]['value_list'][$z]['value']=$value;				
						if($id_club==$_POST['data'][$i][$j]) { 
							$page['data'][$i]['column'][$j]['value_list'][$z]['selected']='selected="selected"';
						}
						else {
						 $page['data'][$i]['column'][$j]['value_list'][$z]['selected']='';
						}
						$z++;
					}

					foreach($new_club_list AS $id_club => $value) {
						$page['data'][$i]['column'][$j]['value_list'][$z]['id']=$value;
						$page['data'][$i]['column'][$j]['value_list'][$z]['value']=$value;
						
						if($_POST['data'][$i][$j]==$new_club_list[$id_club]) {
							$page['data'][$i]['column'][$j]['value_list'][$z]['selected']='selected="selected"';
						}
						else {
						 $page['data'][$i]['column'][$j]['value_list'][$z]['selected']='';
						}
						$z++;
					}
				}
				elseif($id=="level_id") {
					$z=0;
					$page['data'][$i]['column'][$j]['L_choose']=$lang['member']['choose_level'];
					
					foreach($level_list AS $id_level => $value) {
						$page['data'][$i]['column'][$j]['value_list'][$z]['id']=$id_level;
						$page['data'][$i]['column'][$j]['value_list'][$z]['value']=$value;				
						if($id_level==$_POST['data'][$i][$j]) { 
							$page['data'][$i]['column'][$j]['value_list'][$z]['selected']='selected="selected"';
						}
						else {
						 $page['data'][$i]['column'][$j]['value_list'][$z]['selected']='';
						}
						$z++;
					}

					foreach($new_level_list AS $id_level => $value) {
						$page['data'][$i]['column'][$j]['value_list'][$z]['id']=$value;
						$page['data'][$i]['column'][$j]['value_list'][$z]['value']=$value;
						
						if($_POST['data'][$i][$j]==$new_level_list[$id_level]) {
							$page['data'][$i]['column'][$j]['value_list'][$z]['selected']='selected="selected"';
						}
						else {
						 $page['data'][$i]['column'][$j]['value_list'][$z]['selected']='';
						}
						$z++;
					}
				}
				else {
					$page['data'][$i]['column'][$j]['show_value']='1';
				}
				
				
				
			}
			
			$page['data'][$i]['member_list']=array();
			$j=0;
			foreach($member_list AS $id => $value) {
				$page['data'][$i]['member_list'][$j]['id']=$id;
				$page['data'][$i]['member_list'][$j]['name']=$value;
				$page['data'][$i]['member_list'][$j]['selected']='';
				
				if($id==$_POST['member'][$i]) {
					$page['data'][$i]['member_list'][$j]['selected']='selected="selected"';
				}
				$j++;
			}
			
			$page['data'][$i]['L_choose_member']=$lang['member']['choose_member'];
			$page['data'][$i]['L_import']=$lang['member']['import_new_member'];
			$page['data'][$i]['L_merge']=$lang['member']['merge_member'];
			$page['data'][$i]['L_dont_import']=$lang['member']['dont_import'];
		}
	}
} // end step 4




# step 2 : we need column names
if($page['value_step']=="associate_field") {	
	if(isset($page['nb_column']) AND !empty($page['nb_column'])) {	
		for($i=0, $x="A"; $i < $page['nb_column']; $i++,$x++) {
			
			if($page['value_first_line']==1 AND !empty($column_name)) {
				$page['column'][$i]['name']=$column_name[$i];
			}
			else {		
				$page['column'][$i]['name']=$lang['member']['column']." ".$x;
			}
			$page['column'][$i]['i']=$i;			
			$page['column'][$i]['member_field']=array();
			$page['column'][$i]['L_choose_field']=$lang['member']['choose_field'];
			$j=0;
			foreach($member_field AS $id => $value) {
				$page['column'][$i]['member_field'][$j]['name']=$value;
				$page['column'][$i]['member_field'][$j]['id']=$id;
				$page['column'][$i]['member_field'][$j]['selected']='';
				
				if(isset($_POST['member_field'][$i]) AND $_POST['member_field'][$i]==$id) 
				{
					$page['column'][$i]['member_field'][$j]['selected']="selected";
				}
				
				$j++;
			}		
		}
	}	
}


# step 4 : we need seasons list
if($page['value_step']=="validation" AND $season_needed==1) {	
	include_once(create_path("competition/sql_competition.php"));

	$sql_liste=$sql['competition']['select_season'];
	$sgbd = sql_connect();
	$res_liste = sql_query($sql_liste);
	$nb_ligne = sql_num_rows($res_liste);
	$i="0";
	while($ligne = sql_fetch_array($res_liste))
	{
	 $page['season'][$i]['id']=$ligne['season_id'];
	 $page['season'][$i]['name']=$ligne['season_name'];
	 $page['season'][$i]['abbreviation']=$ligne['season_abbreviation'];
	
	 if($page['value_season']==$ligne['season_id']) { $page['season'][$i]['selected']="selected"; $var['value_season']=$ligne['season_id']; }
	 else { $page['season'][$i]['selected']=""; }
	 	  
	 $i++;
	}
	sql_free_result($res_liste);
	sql_close($sgbd);
}


switch($page['num_step']) {
 case 1 : 	$page['L_current_step']=$lang['member']['upload_file']; 
 			$page['L_current_step_info']=$lang['member']['upload_file_info']; 
 			break;
 case 2 : 	$page['L_current_step']=$lang['member']['associate_field'];
 			$page['L_current_step_info']=$lang['member']['associate_field_info'];
			break;
 case 3 : 	$page['L_current_step']=$lang['member']['associate_value'];
 			$page['L_current_step_info']=$lang['member']['associate_value_info'];
			break;			
 case 4 : 	$page['L_current_step']=$lang['member']['check_data'];
 			$page['L_current_step_info']=$lang['member']['check_data_info'];
			break;
 default :  $page['L_current_step']=$lang['member']['upload_file'];
 			$page['L_current_step_info']=$lang['member']['upload_file_info'];
}



if($page['value_first_line']=="1") { $page['first_line_checked']="checked=\"checked\""; }


# link
$page['form_action']=convert_url("index.php?r=".$lang['general']['idurl_member']."&v1=import_member");
$page['link_list']=convert_url("index.php?r=".$lang['general']['idurl_member']."&v1=member_list");

# text
$page['L_title']=$lang['member']['import_member'];
$page['L_step']=$lang['member']['step'];

$page['L_csv_file']=$lang['member']['csv_file'];
$page['L_separator']=$lang['member']['separator'];
$page['L_first_line']=$lang['member']['first_line'];

$page['L_file_column']=$lang['member']['file_column'];
$page['L_associated_field']=$lang['member']['associated_field'];

$page['L_action']=$lang['member']['action'];


$page['L_valider']=$lang['member']['submit'];
$page['L_delete']=$lang['member']['delete'];
$page['L_back_list']=$lang['member']['back_list']; 
$page['L_erreur']=$lang['general']['E_erreur'];
$page['L_field_required']=$lang['general']['field_required'];

$page['L_identity']=$lang['member']['identity'];
$page['L_name']=$lang['member']['name'];
$page['L_firstname']=$lang['member']['firstname'];
$page['L_date_birth']=$lang['member']['date_birth'];
$page['L_place_birth']=$lang['member']['place_birth'];
$page['L_email']=$lang['member']['email'];
$page['L_size']=$lang['member']['size'];
$page['L_size_unit']=$lang['member']['size_unit'];
$page['L_weight']=$lang['member']['weight'];
$page['L_weight_unite']=$lang['member']['weight_unite'];
$page['L_sex']=$lang['member']['sex'];
$page['L_country']=$lang['member']['nationality'];
$page['L_choose_country']=$lang['member']['choose_nationality'];
$page['L_referee']=$lang['member']['referee'];
$page['L_level']=$lang['member']['level'];
$page['L_choose_level']=$lang['member']['choose_level'];

$page['L_club']=$lang['member']['club'];
$page['L_season']=$lang['member']['season'];
$page['L_choose_season']=$lang['member']['choose_season'];

$page['L_info_internaute']=$lang['member']['info_internaute'];
$page['L_login']=$lang['member']['login'];
$page['L_description']=$lang['member']['description'];
$page['L_photo']=$lang['member']['photo'];
$page['L_avatar']=$lang['member']['avatar'];
$page['L_choose_image']=$lang['member']['choose_image'];
$page['L_pass']=$lang['member']['pass'];
$page['L_explication_pass']=$lang['member']['explication_pass'];
$page['L_confirm_pass']=$lang['member']['confirm_pass'];
$page['L_status']=$lang['member']['status'];
$page['L_choose_status']=$lang['member']['choose_status'];
$page['L_valid']=$lang['member']['valid'];

$page['L_comment']=$lang['member']['comment'];
$page['L_format_date']=$lang['member']['format_date'];


$page['meta_title']=$page['L_title'];
$page['template']=$tpl['member']['import_member'];
?>