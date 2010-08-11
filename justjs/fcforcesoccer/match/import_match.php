<?php
##################################
# import match
##################################

# variables
$page['L_message']='';
$nb_error=0;
$page['erreur']=array();
$page['pop']='';


$type_allowed=array('csv');
$type_mime_allowed=array('text/comma-separated-values','application/vnd.ms-excel','application/octet-stream','plain/text');


# form values
$page['value_id']="";
$page['value_club_visitor']="";
$page['value_club_home']="";
$page['value_team_visitor']="";
$page['value_team_home']="";
$page['value_competition']="";
$page['value_round']="";
$page['value_penality_home']="";
$page['value_penality_visitor']="";
$page['value_group']="";
$page['value_day']="";
$page['value_field_state']="";
$page['value_field']="";
$page['value_weather']="";
$page['value_date']="";
$page['value_hour']="";
$page['value_score_visitor']="";
$page['value_score_home']="";
$page['value_spectators']="";
$page['value_comment']="";

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
$page['match_field']=array();

$page['club']=array();
$page['competition']=array();
$page['field_state']=array();
$page['field']=array();
$page['weather']=array();

$page['new_value']=array();

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

# rights
if(!$right_user['import_match']) {
	$page['show_step_1']="";
	$page['num_step']="";
	$page['L_message']=$lang['general']['acces_reserve_admin'];
}

# available match fields
$match_field=array(
"match_date"=>$lang['match']['date'],
"match_hour"=>$lang['match']['hour'],
"club_home_id"=>$lang['match']['home'],
"club_visitor_id"=>$lang['match']['visitor'],
//"match_team_home"=>$lang['match']['home'],
//"match_team_visitor"=>$lang['match']['visitor'],
"competition_id"=>$lang['match']['competition'],
//"round_id"=>$lang['match']['round'],
"match_group"=>$lang['match']['group'],
"match_day"=>$lang['match']['day'],
"match_score_home"=>$lang['match']['score_home'],
"match_score_visitor"=>$lang['match']['score_visitor'],
"field_state_id"=>$lang['match']['field_state'],
"field_id"=>$lang['match']['field'],
"weather_id"=>$lang['match']['weather'],
"penality_home"=>$lang['match']['penality'].' '.$lang['match']['home'],
"penality_visitor"=>$lang['match']['penality'].' '.$lang['match']['visitor'],
"match_spectators"=>$lang['match']['spectators'],
"match_comment"=>$lang['match']['comment']); 
 
$match_field_num=array(); // numero des colonnes correspondants


# required for step 4 : we need existing matchs list
$match_list=array();
//if($page['value_step']=='validation') {	
	$var['condition']=" ";
	$var['order']=" ORDER BY m.match_date DESC ";
	$var['limit']=" ";
	$sql_match=sql_replace($sql['match']['select_match_condition'],$var);	
	$sgbd = sql_connect();
	$res_match = sql_query($sql_match);
	$nb_ligne=sql_num_rows($res_match);
	if($nb_ligne!="0")
	{
		while($ligne = sql_fetch_array($res_match))
		{
			$id=$ligne['match_id'];
	 		$match_list[$id]=convert_date($ligne['match_date'],$lang['match']['format_date_form'])." ".convert_date($ligne['match_date'],$lang['match']['format_hour_form'])." : ";
			if($ligne['club_home_abbreviation']!='') $match_list[$id].=$ligne['club_home_abbreviation'];
			else $match_list[$id].=$ligne['club_home_name'];
			if($ligne['team_home_name']!='') $match_list[$id].=' '.$ligne['team_home_name'];
			if($ligne['sex_home_abbreviation']!='') $match_list[$id].=' ['.$ligne['sex_home_abbreviation'].'] ';
			$match_list[$id].=' - ';
			if($ligne['club_visitor_abbreviation']!='') $match_list[$id].=$ligne['club_visitor_abbreviation'];
			else $match_list[$id].=$ligne['club_visitor_name'];
			if($ligne['team_visitor_name']!='') $match_list[$id].=' '.$ligne['team_visitor_name'];
			if($ligne['sex_visitor_abbreviation']!='') $match_list[$id].=' ['.$ligne['sex_visitor_abbreviation'].'] ';
		}
	}
	
# step 4 : we need seasons list
$season_list=array();
if($page['value_step']=="validation") {	
	include_once(create_path("competition/sql_competition.php"));

	$sql_season=$sql['competition']['select_season'];
	$sgbd = sql_connect();
	$res_season = sql_query($sql_season);
	$nb_ligne = sql_num_rows($res_season);
	if($nb_ligne!="0")
	{
		while($ligne = sql_fetch_array($res_season))
		{
		 $id=$ligne['season_id'];
		 $season_list[$id]['name']=$ligne['season_name'];
		 $season_list[$id]['date_start']=$ligne['season_date_start'];
		 $season_list[$id]['date_end']=$ligne['season_date_end'];	 
		}
	}
}
//}


# weather list : required for step 3
$weather_list=array();
$sql_weather=$sql['match']['select_weather'];
$sgbd = sql_connect();
$res_weather = sql_query($sql_weather);
while($ligne = sql_fetch_array($res_weather)) 
{
	$id=$ligne['weather_id'];
	$weather_list[$id]=$ligne['weather_name'];
}

# field_state list : required for step 3
$field_state_list=array();
$sql_field_state=$sql['match']['select_field_state'];
$sgbd = sql_connect();
$res_field_state = sql_query($sql_field_state);
while($ligne = sql_fetch_array($res_field_state)) 
{
	$id=$ligne['field_state_id'];
	$field_state_list[$id]=$ligne['field_state_name'];
}

# field list : required for step 3
$field_list=array();
include_once(create_path("field/sql_field.php"));
$sql_field=$sql['field']['select_field'];
$sgbd = sql_connect();
$res_field = sql_query($sql_field);
while($ligne = sql_fetch_array($res_field)) 
{
	$id=$ligne['field_id'];
	$field_list[$id]=$ligne['field_name'];
}

# club & team list : required for step 3
$club_list=array();
include_once(create_path("team/sql_team.php"));
$sql_club=$sql['team']['select_club_team_condition'];
$sgbd = sql_connect();
$res_club = sql_query($sql_club);
while($ligne = sql_fetch_array($res_club)) 
{
	$id=$ligne['club_id'].'_'.$ligne['team_id'];
	$club_list[$id]=$ligne['club_name'];
	if(isset($ligne['team_name_name']) AND $ligne['team_name_name']!= NULL) { $club_list[$id].=' - '.$ligne['team_name_name']; }
	if(isset($ligne['sex_abbreviation']) AND $ligne['sex_abbreviation']!= NULL) { $club_list[$id].=' ['.$ligne['sex_abbreviation'].']'; }
}
sql_free_result($res_club);
sql_close($sgbd);

# competition & round list : required for step 3
$competition_list=array();
$var['condition']=" ";
$var['order']=" ";
$var['limit']=" ";
include_once(create_path("competition/sql_competition.php"));
$sql_competition=sql_replace($sql['competition']['select_competition_round_condition'],$var);
$sgbd = sql_connect();
$res_competition = sql_query($sql_competition);
while($ligne = sql_fetch_array($res_competition)) 
{
	$id=$ligne['competition_id'].'_'.$ligne['round_id'];
	$competition_list[$id]=$ligne['competition_name'];
	if(isset($ligne['round_name']) AND $ligne['round_name']!= NULL) { $competition_list[$id].=' - '.$ligne['round_name']; }
}

# form treatment
# step 1 : we upload the data from the .csv team
if(isset($_POST['step']) AND $_POST['step']=="upload" AND $right_user['import_match'])
{	
	# we check submitted data
 	if(!isset($_FILES['file']['name']) OR empty($_FILES['file']['name'])) { $page['erreur'][$nb_error]['message']=$lang['match']['E_empty_file']; $nb_error++; }
	elseif(!in_array($_FILES['file']['type'],$type_mime_allowed)) { 
		
	$var['type']=implode(", ",$type_allowed);
	$page['erreur'][$nb_error]['message']=text_replace($lang['match']['E_invalid_file_type'],$var); $nb_error++; }
 
	if($_FILES['file']['size'] > MAX_FILE_SIZE)  { 
	$var['max_file_size']=filesize_format(MAX_FILE_SIZE);
	$page['erreur'][$nb_error]['message']=text_replace($lang['match']['E_invalid_file_size'],$var); $nb_error++; }		
	
	if(!isset($_POST['separator']) OR empty($_POST['separator'])) { $page['erreur'][$nb_error]['message']=$lang['match']['E_empty_separator']; $nb_error++; }
	
	# there is no error : we upload the file and get its content
	if($nb_error==0)
	{ 	
		if(isset($_POST['first_line'])) $page['value_first_line']=$_POST['first_line'];

		$path_file=ROOT."/".FILE_FOLDER."/import_match.csv";
	   
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
elseif(isset($_POST['step']) AND $_POST['step']=="associate_field" AND $right_user['import_match']) {

	# we check that the match name was choosen
	
	# we check that the column names are not present twice	
	$column=array();
	if(isset($_POST['match_field']) AND is_array($_POST['match_field'])) {				
		
		/*if(!in_array("club_home_id",$_POST['match_field'])) {
			$page['erreur'][$nb_error]['message']=$lang['match']['E_empty_club_home_id_field']; $nb_error++;
		}
		if(!in_array("club_visitor_id",$_POST['match_field'])) {
			$page['erreur'][$nb_error]['message']=$lang['match']['E_empty_club_visitor_id_field']; $nb_error++;
		}
		*/
		if(!in_array("club_home_id",$_POST['match_field'])) {
			$page['erreur'][$nb_error]['message']=$lang['match']['E_empty_club_home_id_field']; $nb_error++;
		}
		if(!in_array("club_visitor_id",$_POST['match_field'])) {
			$page['erreur'][$nb_error]['message']=$lang['match']['E_empty_club_visitor_id_field']; $nb_error++;
		}		
		if(!in_array("match_date",$_POST['match_field'])) {
			$page['erreur'][$nb_error]['message']=$lang['match']['E_empty_match_date_field']; $nb_error++;
		}
		
		foreach($_POST['match_field'] AS $id => $value) {			
			if($value!="") {
				if(in_array($value,$column) AND $nb_error=="0") { 
					$page['erreur'][$nb_error]['message']=$lang['match']['E_exists_match_field']; $nb_error++; 
				}
				array_push($column,$value);
				
				# on enregistre les numeros des colonnes pour faire les correspondances
				foreach($match_field AS $key => $values) {
					if($value==$key) { $match_field_num[$key]=$id; }					
				}				
				
				if($value=="club_home_id") $num_col_club_home=$id; 
				elseif($value=="club_visitor_id") $num_col_club_visitor=$id;
				elseif($value=="weather_id") $num_col_weather=$id;
				elseif($value=="field_state_id") $num_col_field_state=$id;
				elseif($value=="competition_id") $num_col_competition=$id;
				elseif($value=="field_id") $num_col_field=$id;
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
			$page['match_field'][$i]['i']=$i;
			$page['match_field'][$i]['name']='';
			$page['match_field'][$i]['value']=$id;			
		}
		
		# we get data		
		$nb_line=sizeof($_POST['data']);		
		for($i=0; $i < $nb_line; $i++) {					
			$page['data_hidden'][$i]['i']=$i;
			for($j=0; $j < $nb_column; $j++) {
				$id=$column[$j];				
				$k=$match_field_num[$id];
				$page['data_hidden'][$i]['column'][$j]['value']=format_txt($_POST['data'][$i][$k]);
				$page['data_hidden'][$i]['column'][$j]['i']=$i;
				$page['data_hidden'][$i]['column'][$j]['j']=$j;
			}
		}					
		
		# if the column weather, field, competition or club are chosen, we need to associate existing values
		$nb_weather=0;
		$nb_field_state=0;
		$nb_field=0;
		$nb_club=0;
		$nb_competition=0;
		
		if(isset($num_col_weather)) {
			# we get the weather presents in the list
			$nb_line=sizeof($_POST['data']);
			$weather_data=array();
			for($i=0; $i < $nb_line; $i++) {
				if($_POST['data'][$i][$num_col_weather]!="") {
					array_push($weather_data,$_POST['data'][$i][$num_col_weather]);
				}
			}
			# we remove duplicates values from all the weather presents in the list		
			$weather_data=array_unique($weather_data);
			
			$i=0;			
			foreach($weather_data AS $id => $value) {
				$page['weather'][$i]['i']=$i;
				$page['weather'][$i]['value']=$value;				
				$page['weather'][$i]['L_choose_weather']=$lang['match']['choose_weather'];
				$page['weather'][$i]['L_add_new_value']=$lang['match']['add_new_value'];
				$page['weather'][$i]['new_selected']='';
				$page['weather'][$i]['weather_list']=array();
				
				# select list
				$j=0;				
				foreach($weather_list AS $id_weather => $value_weather) {
					$page['weather'][$i]['weather_list'][$j]['id']=$id_weather;
					$page['weather'][$i]['weather_list'][$j]['name']=$value_weather;
					$page['weather'][$i]['weather_list'][$j]['selected']='';
					if($value_weather==$page['weather'][$i]['value']) {
						$page['weather'][$i]['weather_list'][$j]['selected']='selected="selected"';
					}
					$j++;
				}				
				
				$i++;
			}
			$nb_weather=$i;
		}
		
		if(isset($num_col_field_state)) {
			# we get the field_state presents in the list
			$nb_line=sizeof($_POST['data']);
			$field_state_data=array();
			for($i=0; $i < $nb_line; $i++) {
				if($_POST['data'][$i][$num_col_field_state]!="") {
					array_push($field_state_data,$_POST['data'][$i][$num_col_field_state]);
				}
			}
			# we remove duplicates values from all the field_state presents in the list		
			$field_state_data=array_unique($field_state_data);
			
			$i=0;			
			foreach($field_state_data AS $id => $value) {
				$page['field_state'][$i]['i']=$i+$nb_weather;
				$page['field_state'][$i]['value']=$value;				
				$page['field_state'][$i]['L_choose_field_state']=$lang['match']['choose_field_state'];
				$page['field_state'][$i]['L_add_new_value']=$lang['match']['add_new_value'];
				$page['field_state'][$i]['new_selected']='';
				$page['field_state'][$i]['field_state_list']=array();
				
				# select list
				$j=0;				
				foreach($field_state_list AS $id_field_state => $value_field_state) {
					$page['field_state'][$i]['field_state_list'][$j]['id']=$id_field_state;
					$page['field_state'][$i]['field_state_list'][$j]['name']=$value_field_state;
					$page['field_state'][$i]['field_state_list'][$j]['selected']='';
					if($value_field_state==$page['field_state'][$i]['value']) {
						$page['field_state'][$i]['field_state_list'][$j]['selected']='selected="selected"';
					}
					$j++;
				}				
				
				$i++;
			}
			$nb_field_state=$i;
		}
		
		if(isset($num_col_field)) {
			# we get the field presents in the list
			$nb_line=sizeof($_POST['data']);
			$field_data=array();
			for($i=0; $i < $nb_line; $i++) {
				if($_POST['data'][$i][$num_col_field]!="") {
					array_push($field_data,$_POST['data'][$i][$num_col_field]);
				}
			}
			# we remove duplicates values from all the field presents in the list		
			$field_data=array_unique($field_data);
			
			$i=0;			
			foreach($field_data AS $id => $value) {
				$page['field'][$i]['i']=$i+$nb_weather+$nb_field_state;
				$page['field'][$i]['value']=$value;				
				$page['field'][$i]['L_choose_field']=$lang['match']['choose_field'];
				$page['field'][$i]['L_add_new_value']=$lang['match']['add_new_value'];
				$page['field'][$i]['new_selected']='';
				$page['field'][$i]['field_list']=array();
				
				# select list
				$j=0;				
				foreach($field_list AS $id_field => $value_field) {
					$page['field'][$i]['field_list'][$j]['id']=$id_field;
					$page['field'][$i]['field_list'][$j]['name']=$value_field;
					$page['field'][$i]['field_list'][$j]['selected']='';
					if($value_field==$page['field'][$i]['value']) {
						$page['field'][$i]['field_list'][$j]['selected']='selected="selected"';
					}
					$j++;
				}								
				$i++;
			}
			$nb_field=$i;
		}
		
		if(isset($num_col_club_home) OR isset($num_col_club_visitor)) {
			# we get the club presents in the list
			$nb_line=sizeof($_POST['data']);
			$club_data=array();
			for($i=0; $i < $nb_line; $i++) {
				if($_POST['data'][$i][$num_col_club_home]!="") {
					array_push($club_data,$_POST['data'][$i][$num_col_club_home]);
				}
				if($_POST['data'][$i][$num_col_club_visitor]!="") {
					array_push($club_data,$_POST['data'][$i][$num_col_club_visitor]);
				}
			}
			# we remove duplicates values from all the weather presents in the list		
			$club_data=array_unique($club_data);
			
			$i=0;			
			foreach($club_data AS $id => $value) {
				$page['club'][$i]['i']=$i+$nb_weather+$nb_field_state+$nb_field;
				$page['club'][$i]['value']=$value;				
				$page['club'][$i]['L_choose_club']=$lang['match']['choose_club'];
				$page['club'][$i]['L_add_new_value']=$lang['match']['add_new_value'];
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

		if(isset($num_col_competition)) {
			# we get the competition presents in the list
			$nb_line=sizeof($_POST['data']);
			$competition_data=array();
			for($i=0; $i < $nb_line; $i++) {
				if($_POST['data'][$i][$num_col_competition]!="") {
					array_push($competition_data,$_POST['data'][$i][$num_col_competition]);
				}
			}
			# we remove duplicates values from all the weather presents in the list		
			$competition_data=array_unique($competition_data);
			
			$i=0;			
			foreach($competition_data AS $id => $value) {
				$page['competition'][$i]['i']=$i+$nb_weather+$nb_field_state+$nb_field+$nb_club;
				$page['competition'][$i]['value']=$value;				
				$page['competition'][$i]['L_choose_competition']=$lang['match']['choose_competition'];
				$page['competition'][$i]['L_add_new_value']=$lang['match']['add_new_value'];
				$page['competition'][$i]['new_selected']='';
				$page['competition'][$i]['competition_list']=array();
				
				# select list
				$j=0;				
				foreach($competition_list AS $id_competition => $value_competition) {
					$page['competition'][$i]['competition_list'][$j]['id']=$id_competition;
					$page['competition'][$i]['competition_list'][$j]['name']=$value_competition;
					$page['competition'][$i]['competition_list'][$j]['selected']='';					
					if($value_competition==$page['competition'][$i]['value']) {
						$page['competition'][$i]['competition_list'][$j]['selected']='selected="selected"';
					}
					$j++;
				}								
				$i++;
			}
			$nb_competition=$i;
		}	
		
		if(empty($page['weather']) AND empty($page['field_state']) AND empty($page['field']) AND empty($page['club']) AND empty($page['competition'])) {
			$page['L_message']=$lang['match']['no_value_to_associate'];
		}
				
		$page['value_step']="associate_value";
		$page['num_step']="3";
		$page['show_step_1']=''; $page['show_step_2']=''; 
		$page['show_step_3']="1"; $page['show_step_4']='';
	}
	else {
		# there was an error
		$page['nb_column']=sizeof($_POST['match_field']);
						
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

# step 3 : we associate database values to the corresponding data (weather,  field_state, field, competition and club)
elseif(isset($_POST['step']) AND $_POST['step']=="associate_value" AND $right_user['import_match']) {

	# we check submited data	
	# we check that all records have a corresponding value
	if(isset($_POST['value']) AND !empty($_POST['value'])) {
		$nb_value=sizeof($_POST['value']);
		for($i=0; $i < $nb_value; $i++) {	
			if(empty($_POST['value_associate'][$i]) AND $nb_error==0) {
				// error :: each value must be associated
				$page['erreur'][$nb_error]['message']=$lang['match']['E_empty_value_associate'];
				$nb_error++;		
			}
		}
	}
	
	if($nb_error==0) {
		# we introduce hour
		if(!in_array('match_hour',$_POST['match_field'])) {
			array_push($_POST['match_field'],'match_hour');
		}
		
		# we get the name of the field
		$column=$_POST['match_field'];
		$nb_column=sizeof($column);
			
		for($i=0; $i < $nb_column; $i++) {
			$id=$column[$i];
			$page['match_field'][$i]['i']=$i;
			$page['match_field'][$i]['name']=$match_field[$id];
			$page['match_field'][$i]['value']=$id;
			
			foreach($match_field AS $key => $values) {
				if($id==$key) { $match_field_num[$key]=$i; }					
			}					
			
			if($id=="club_home_id") $num_col_club_home=$i; 
			elseif($id=="club_visitor_id") $num_col_club_visitor=$i;
			elseif($id=="match_date") $num_col_date=$i;
			elseif($id=="weather_id") $num_col_weather=$i;
			elseif($id=="field_state_id") $num_col_field_state=$i;
			elseif($id=="competition_id") $num_col_competition=$i;
			elseif($id=="field_id") $num_col_field=$i;
			elseif($id=="club_id") $num_col_club=$i;
		}
		
		
		# we get the associate values		
		$weather_list_associate=array(); // we create an array with weather_id and corresponding value
		$field_state_list_associate=array();
		$field_list_associate=array();
		$club_list_associate=array();
		$competition_list_associate=array();
		
		$new_weather_list=array();
		$new_field_state_list=array();
		$new_field_list=array();
		$new_club_list=array();
		$new_competition_list=array();
		
		if(isset($_POST['value']) AND !empty($_POST['value'])) {
			$nb_value=sizeof($_POST['value']);	
			for($i=0; $i < $nb_value; $i++) {			
				$id=$_POST['value_associate'][$i];
				if($_POST['value_type'][$i]=='weather') { 
					if($id==-1 AND !in_array($_POST['value'][$i],$new_weather_list)) $new_weather_list[]=$_POST['value'][$i];
					else { 	
						$value_associate=$_POST['value'][$i];
						$weather_list_associate[$value_associate]=$id;
					}
				}
				elseif($_POST['value_type'][$i]=='field_state') { 
					if($id==-1 AND !in_array($_POST['value'][$i],$new_field_state_list)) $new_field_state_list[]=$_POST['value'][$i];
					else { 	
						$value_associate=$_POST['value'][$i];
						$field_state_list_associate[$value_associate]=$id;
					}
				}
				elseif($_POST['value_type'][$i]=='field') { 	
					if($id==-1 AND !in_array($_POST['value'][$i],$new_field_list)) $new_field_list[]=$_POST['value'][$i];
					else { 	
						$value_associate=$_POST['value'][$i];
						$field_list_associate[$value_associate]=$id;
					}
				}
				elseif($_POST['value_type'][$i]=='club') { 
					if($id==-1 AND !in_array($_POST['value'][$i],$new_club_list)) $new_club_list[]=$_POST['value'][$i];
					else { 	
						$value_associate=$_POST['value'][$i];
						$club_list_associate[$value_associate]=$id;
					}
				}
				elseif($_POST['value_type'][$i]=='competition') { 
					if($id==-1 AND !in_array($_POST['value'][$i],$new_competition_list)) $new_competition_list[]=$_POST['value'][$i];
					else { 	
						$value_associate=$_POST['value'][$i];
						$competition_list_associate[$value_associate]=$id;
					}
				}
			}
		}
		
		$i=0;
		foreach($new_weather_list AS $id_weather => $value) {
			$page['new_value'][$i]['i']=$i;
			$page['new_value'][$i]['type']='weather';
			$page['new_value'][$i]['value']=$value;
			$i++;
		}
		foreach($new_field_state_list AS $id_field_state => $value) {
			$page['new_value'][$i]['i']=$i;
			$page['new_value'][$i]['type']='field_state';
			$page['new_value'][$i]['value']=$value;
			$i++;
		}
		foreach($new_field_list AS $id_field => $value) {
			$page['new_value'][$i]['i']=$i;
			$page['new_value'][$i]['type']='field';
			$page['new_value'][$i]['value']=$value;
			$i++;
		}
		foreach($new_club_list AS $id_club => $value) {
			$page['new_value'][$i]['i']=$i;
			$page['new_value'][$i]['type']='club';
			$page['new_value'][$i]['value']=$value;
			$i++;
		}
		foreach($new_competition_list AS $id_competition => $value) {
			$page['new_value'][$i]['i']=$i;
			$page['new_value'][$i]['type']='competition';
			$page['new_value'][$i]['value']=$value;
			$i++;
		}
		
		# we get all data		 
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
				$k=$match_field_num[$id];
				
				$page['data'][$i]['column'][$j]['value_list']=array();
				$page['data'][$i]['column'][$j]['value']='';
				$page['data'][$i]['column'][$j]['i']=$i;
				$page['data'][$i]['column'][$j]['j']=$j;
				$page['data'][$i]['column'][$j]['show_value']='';
				
				if($id=="match_date") {		
					// we try to separate date & time if the date format is "dd/mm/yyyy hh:mm"
					$page['data'][$i]['column'][$j]['value']=format_txt($_POST['data'][$i][$k]);
					
					$tmp=explode(" ",$page['data'][$i]['column'][$j]['value']);
					$page['data'][$i]['column'][$j]['value']=$tmp[0];
					if(isset($tmp[1])) { $time[$i]=$tmp[1]; } // we store time in a array
					$page['data'][$i]['column'][$j]['show_value']='1';
				}
				elseif($id=="match_hour") {		
					// we get time from date
					if(isset($time[$i])) {
						$page['data'][$i]['column'][$j]['value']=$time[$i];
					}
					else {
						$page['data'][$i]['column'][$j]['value']=format_txt($_POST['data'][$i][$k]);
					}					
					$page['data'][$i]['column'][$j]['show_value']='1';
				}
				elseif($id=="weather_id") {										
					$z=0;
					$page['data'][$i]['column'][$j]['L_choose']=$lang['match']['choose_weather'];
					foreach($weather_list AS $id_weather => $value) {
						$page['data'][$i]['column'][$j]['value_list'][$z]['id']=$id_weather;
						$page['data'][$i]['column'][$j]['value_list'][$z]['value']=$value;
						$value_associate=$_POST['data'][$i][$k];
						if(isset($weather_list_associate[$value_associate]) AND $weather_list_associate[$value_associate]==$id_weather) {
							$page['data'][$i]['column'][$j]['value_list'][$z]['selected']='selected="selected"';
						}
						else {
						 $page['data'][$i]['column'][$j]['value_list'][$z]['selected']='';
						}
						$z++;
					}

					foreach($new_weather_list AS $id_weather => $value) {
						$page['data'][$i]['column'][$j]['value_list'][$z]['id']=$value;
						$page['data'][$i]['column'][$j]['value_list'][$z]['value']=$value;
						
						if($_POST['data'][$i][$k]==$new_weather_list[$id_weather]) {
							$page['data'][$i]['column'][$j]['value_list'][$z]['selected']='selected="selected"';
						}
						else {
						 $page['data'][$i]['column'][$j]['value_list'][$z]['selected']='';
						}
						$z++;
					}
				}
				elseif($id=="field_state_id") {										
					$z=0;
					$page['data'][$i]['column'][$j]['L_choose']=$lang['match']['choose_field_state'];
					foreach($field_state_list AS $id_field_state => $value) {

						$page['data'][$i]['column'][$j]['value_list'][$z]['id']=$id_field_state;
						$page['data'][$i]['column'][$j]['value_list'][$z]['value']=$value;
						$value_associate=$_POST['data'][$i][$k];
						if(isset($field_state_list_associate[$value_associate]) AND $field_state_list_associate[$value_associate]==$id_field_state) {
							$page['data'][$i]['column'][$j]['value_list'][$z]['selected']='selected="selected"';
						}
						else {
						 $page['data'][$i]['column'][$j]['value_list'][$z]['selected']='';
						}
						$z++;
					}

					foreach($new_field_state_list AS $id_field_state => $value) {
						$page['data'][$i]['column'][$j]['value_list'][$z]['id']=$value;
						$page['data'][$i]['column'][$j]['value_list'][$z]['value']=$value;
						
						if($_POST['data'][$i][$k]==$new_field_state_list[$id_field_state]) {
							$page['data'][$i]['column'][$j]['value_list'][$z]['selected']='selected="selected"';
						}
						else {
						 $page['data'][$i]['column'][$j]['value_list'][$z]['selected']='';
						}
						$z++;
					}
				}
				elseif($id=="field_id") {										
					$z=0;
					$page['data'][$i]['column'][$j]['L_choose']=$lang['match']['choose_field'];
					foreach($field_list AS $id_field => $value) {

						$page['data'][$i]['column'][$j]['value_list'][$z]['id']=$id_field;
						$page['data'][$i]['column'][$j]['value_list'][$z]['value']=$value;
						$value_associate=$_POST['data'][$i][$k];
						if(isset($field_list_associate[$value_associate]) AND $field_list_associate[$value_associate]==$id_field) {
							$page['data'][$i]['column'][$j]['value_list'][$z]['selected']='selected="selected"';
						}
						else {
						 $page['data'][$i]['column'][$j]['value_list'][$z]['selected']='';
						}
						$z++;
					}

					foreach($new_field_list AS $id_field => $value) {
						$page['data'][$i]['column'][$j]['value_list'][$z]['id']=$value;
						$page['data'][$i]['column'][$j]['value_list'][$z]['value']=$value;
						
						if($_POST['data'][$i][$k]==$new_field_list[$id_field]) {
							$page['data'][$i]['column'][$j]['value_list'][$z]['selected']='selected="selected"';
						}
						else {
						 $page['data'][$i]['column'][$j]['value_list'][$z]['selected']='';
						}
						$z++;
					}
				}
				elseif($id=="club_home_id") {					
					$z=0;
					$page['data'][$i]['column'][$j]['L_choose']=$lang['match']['choose_club'];
					$club_home_list[$i]=0;
					$team_home_list[$i]=0;
					foreach($club_list AS $id_club => $value) {
						$page['data'][$i]['column'][$j]['value_list'][$z]['id']=$id_club;
						$page['data'][$i]['column'][$j]['value_list'][$z]['value']=$value;

						$value_associate=$_POST['data'][$i][$k];					
						if(isset($club_list_associate[$value_associate]) AND $club_list_associate[$value_associate]==$id_club) {
							$page['data'][$i]['column'][$j]['value_list'][$z]['selected']='selected="selected"';
							$tmp_club_home=explode('_',$id_club);
							$club_home_list[$i]=$tmp_club_home[0]; // club_home_id
							if($tmp_club_home[1]!='') $team_home_list[$i]=$tmp_club_home[1]; //team_home_id
							else $team_home_list[$i]=0;
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
				elseif($id=="club_visitor_id") {
					$z=0;
					$page['data'][$i]['column'][$j]['L_choose']=$lang['match']['choose_club'];
					$club_visitor_list[$i]=0;
					$team_visitor_list[$i]=0;
					foreach($club_list AS $id_club => $value) {

						$page['data'][$i]['column'][$j]['value_list'][$z]['id']=$id_club;
						$page['data'][$i]['column'][$j]['value_list'][$z]['value']=$value;
						$value_associate=$_POST['data'][$i][$k];
						if(isset($club_list_associate[$value_associate]) AND $club_list_associate[$value_associate]==$id_club) {
							$page['data'][$i]['column'][$j]['value_list'][$z]['selected']='selected="selected"';
							$tmp_club_visitor=explode('_',$id_club);
							$club_visitor_list[$i]=$tmp_club_visitor[0];
							if($tmp_club_visitor[1]!='') $team_visitor_list[$i]=$tmp_club_visitor[1];
							else $team_visitor_list[$i]=0;
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
				elseif($id=="competition_id") {										
					$z=0;
					$page['data'][$i]['column'][$j]['L_choose']=$lang['match']['choose_competition'];
					foreach($competition_list AS $id_competition => $value) {
						$page['data'][$i]['column'][$j]['value_list'][$z]['id']=$id_competition;
						$page['data'][$i]['column'][$j]['value_list'][$z]['value']=$value;
				
						$value_associate=$_POST['data'][$i][$k];
						if(isset($competition_list_associate[$value_associate]) AND $competition_list_associate[$value_associate]==$id_competition) {
							$page['data'][$i]['column'][$j]['value_list'][$z]['selected']='selected="selected"';
						}
						else {
						 $page['data'][$i]['column'][$j]['value_list'][$z]['selected']='';
						}
						$z++;
					}

					foreach($new_competition_list AS $id_competition => $value) {
						$page['data'][$i]['column'][$j]['value_list'][$z]['id']=$value;
						$page['data'][$i]['column'][$j]['value_list'][$z]['value']=$value;
						
						if($_POST['data'][$i][$k]==$new_competition_list[$id_competition]) {
							$page['data'][$i]['column'][$j]['value_list'][$z]['selected']='selected="selected"';
						}
						else {
						 $page['data'][$i]['column'][$j]['value_list'][$z]['selected']='';
						}
						$z++;
					}
				}
				else {					
					$page['data'][$i]['column'][$j]['value']='';
					if(isset($_POST['data'][$i][$k])) { 
						$page['data'][$i]['column'][$j]['value']=format_txt($_POST['data'][$i][$k]);
					}
					$page['data'][$i]['column'][$j]['show_value']='1';
				}
			}
			
			# we check that the match doesn't already exist
			$var['condition']=" WHERE DATE(match_date)='".convert_date_sql($_POST['data'][$i][$num_col_date])."' AND club_home_id='".$club_home_list[$i]."' AND club_visitor_id='".$club_visitor_list[$i]."'
								AND team_home_id='".$team_home_list[$i]."' AND team_visitor_id='".$team_visitor_list[$i]."'	";
			$var['order']='';
			$var['limit']=" LIMIT 1 ";
			$sql_check=sql_replace($sql['match']['select_match_condition'],$var);

			$sgbd = sql_connect();
			$res_check = sql_query($sql_check);
			$ligne=sql_fetch_array($res_check);	
			
			if(sql_num_rows($res_check) !=0) {
				# we found a match, we propose to merge the information				
				$page['data'][$i]['match_id']=$ligne['match_id'];
				$page['data'][$i]['checked_merge']="checked=\"checked\"";				
				$page['L_message']=$lang['match']['E_found_match'];			
			}
			else {
				$page['data'][$i]['match_id']='';
				$page['data'][$i]['checked_import']="checked=\"checked\"";
			}						
			sql_free_result($res_check);
			
			
			# match list
			$page['data'][$i]['match_list']=array();
			$j=0;
			foreach($match_list AS $id => $value) {
				$page['data'][$i]['match_list'][$j]['id']=$id;
				$page['data'][$i]['match_list'][$j]['name']=$value;
				$page['data'][$i]['match_list'][$j]['selected']='';
				if($id==$page['data'][$i]['match_id']) {
					$page['data'][$i]['match_list'][$j]['selected']='selected="selected"';
				}
				$j++;
			}			
			
			$page['data'][$i]['L_choose_match']=$lang['match']['choose_match'];
			$page['data'][$i]['L_import']=$lang['match']['import_new_match'];
			$page['data'][$i]['L_merge']=$lang['match']['merge_match'];
			$page['data'][$i]['L_dont_import']=$lang['match']['dont_import'];			
			
		}		
				
		$page['value_step']="validation";
		$page['num_step']="4";
		$page['show_step_1']=''; $page['show_step_2']='';
		$page['show_step_3']=''; $page['show_step_4']="1";
	
	}
	else {
		# there was an error
		$nb_match_field=sizeof($_POST['match_field']);
		for($i=0; $i < $nb_match_field; $i++) {
			$page['match_field'][$i]['i']=$i;
			$page['match_field'][$i]['name']='';
			$page['match_field'][$i]['value']=$_POST['match_field'][$i];
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
		$nb_weather=0;
		$nb_field_state=0;
		$nb_field=0;
		$nb_club=0;
		$nb_competition=0;						
		
		for($i=0; $i < $nb_value; $i++) {
			if($_POST['value_type'][$i]=="weather") {
				$page['weather'][$nb_weather]['i']=$i;
				$page['weather'][$nb_weather]['value']=$_POST['value'][$i];
				$page['weather'][$nb_weather]['L_choose_weather']=$lang['match']['choose_weather'];
				$page['weather'][$nb_weather]['L_add_new_value']=$lang['match']['add_new_value'];
				$page['weather'][$nb_weather]['weather_list']=array();				
				
				# select list
				$j=0;				
				foreach($weather_list AS $id_list => $value_list) {
					$page['weather'][$nb_weather]['weather_list'][$j]['id']=$id_list;
					$page['weather'][$nb_weather]['weather_list'][$j]['name']=$value_list;
					$page['weather'][$nb_weather]['weather_list'][$j]['selected']='';
					if($id_list==$_POST['value_associate'][$i]) {
						$page['weather'][$nb_weather]['weather_list'][$j]['selected']='selected="selected"';
					}
					$j++;
				}
				if($_POST['value_associate'][$i]==-1) { 
					$page['weather'][$nb_weather]['new_selected']='selected="selected"';		
				}
				else {
					$page['weather'][$nb_weather]['new_selected']='';
				}
				$nb_weather++;
								
			}
			elseif($_POST['value_type'][$i]=="field_state") {
				$page['field_state'][$nb_field_state]['i']=$i;
				$page['field_state'][$nb_field_state]['value']=$_POST['value'][$i];
				$page['field_state'][$nb_field_state]['L_choose_field_state']=$lang['match']['choose_field_state'];
				$page['field_state'][$nb_field_state]['L_add_new_value']=$lang['match']['add_new_value'];
				$page['field_state'][$nb_field_state]['field_state_list']=array();				
				
				# select list
				$j=0;				
				foreach($field_state_list AS $id_list => $value_list) {
					$page['field_state'][$nb_field_state]['field_state_list'][$j]['id']=$id_list;
					$page['field_state'][$nb_field_state]['field_state_list'][$j]['name']=$value_list;
					$page['field_state'][$nb_field_state]['field_state_list'][$j]['selected']='';
					if($id_list==$_POST['value_associate'][$i]) {
						$page['field_state'][$nb_field_state]['field_state_list'][$j]['selected']='selected="selected"';
					}
					$j++;
				}
				if($_POST['value_associate'][$i]==-1) { 
					$page['field_state'][$nb_field_state]['new_selected']='selected="selected"';		
				}
				else {
					$page['field_state'][$nb_field_state]['new_selected']='';
				}
				$nb_field_state++;
								
			}
			elseif($_POST['value_type'][$i]=="field") {
				$page['field'][$nb_field]['i']=$i;
				$page['field'][$nb_field]['value']=$_POST['value'][$i];
				$page['field'][$nb_field]['L_choose_field']=$lang['match']['choose_field'];
				$page['field'][$nb_field]['L_add_new_value']=$lang['match']['add_new_value'];
				$page['field'][$nb_field]['field_list']=array();				
				
				# select list
				$j=0;				
				foreach($field_list AS $id_list => $value_list) {
					$page['field'][$nb_field]['field_list'][$j]['id']=$id_list;
					$page['field'][$nb_field]['field_list'][$j]['name']=$value_list;
					$page['field'][$nb_field]['field_list'][$j]['selected']='';
					if($id_list==$_POST['value_associate'][$i]) {
						$page['field'][$nb_field]['field_list'][$j]['selected']='selected="selected"';
					}
					$j++;
				}
				if($_POST['value_associate'][$i]==-1) { 
					$page['field'][$nb_field]['new_selected']='selected="selected"';		
				}
				else {
					$page['field'][$nb_field]['new_selected']='';
				}				
				$nb_field++;
								
			}
			elseif($_POST['value_type'][$i]=="club") {
				$page['club'][$nb_club]['i']=$i;
				$page['club'][$nb_club]['value']=$_POST['value'][$i];
				$page['club'][$nb_club]['L_choose_club']=$lang['match']['choose_club'];
				$page['club'][$nb_club]['L_add_new_value']=$lang['match']['add_new_value'];
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
			elseif($_POST['value_type'][$i]=="competition") {
				$page['competition'][$nb_competition]['i']=$i;
				$page['competition'][$nb_competition]['value']=$_POST['value'][$i];
				$page['competition'][$nb_competition]['L_choose_competition']=$lang['match']['choose_competition'];
				$page['competition'][$nb_competition]['L_add_new_value']=$lang['match']['add_new_value'];
				$page['competition'][$nb_competition]['competition_list']=array();				
				
				# select list
				$j=0;				
				foreach($competition_list AS $id_list => $value_list) {
					$page['competition'][$nb_competition]['competition_list'][$j]['id']=$id_list;
					$page['competition'][$nb_competition]['competition_list'][$j]['name']=$value_list;
					$page['competition'][$nb_competition]['competition_list'][$j]['selected']='';
					if($id_list==$_POST['value_associate'][$i]) {
						$page['competition'][$nb_competition]['competition_list'][$j]['selected']='selected="selected"';
					}
					$j++;
				}
				if($_POST['value_associate'][$i]==-1) { 
					$page['competition'][$nb_competition]['new_selected']='selected="selected"';		
				}
				else {
					$page['competition'][$nb_competition]['new_selected']='';
				}				
				$nb_competition++;			
			}
			
		}	
			
	}	
}

# step 4 : we checked all datas
elseif(isset($_POST['step']) AND $_POST['step']=="validation" AND $right_user['import_match']) {
	
	$nb_match=sizeof($_POST['data']);
	
	foreach($_POST['match_field'] AS $id => $value) {
		if($value=="club_home_id") { $id_club_home=$id; }
		if($value=="club_visitor_id") { $id_club_visitor=$id; }
		if($value=="match_date") { $id_date=$id; }
	}
	
	# we check that the club_home is not empty
	if(isset($id_club_home)) {
		$nb_match_empty=0;

		for($i=0; $i < $nb_match; $i++) {	
			if(empty($_POST['data'][$i][$id_club_home])) {					
				$nb_match_empty++;					
			}
		}
		if($nb_match_empty!=0) {
			$page['erreur'][$nb_error]['message']=$lang['match']['E_empty_matchs_club_home'];
			$nb_error++;
		}			
	}

	# we check that the club_visitor is not empty
	if(isset($id_club_visitor)) {
		$nb_match_empty=0;

		for($i=0; $i < $nb_match; $i++) {	
			if(empty($_POST['data'][$i][$id_club_visitor])) {					
				$nb_match_empty++;					
			}
		}
		
		if($nb_match_empty!=0) {
			$page['erreur'][$nb_error]['message']=$lang['match']['E_empty_matchs_club_visitor'];
			$nb_error++;
		}			
	}
	
	# we check that the date is not empty
	if(isset($id_date)) {
		$nb_match_empty=0;
		$nb_invalid=0;
		$nb_no_season=0;
		$date_found=array();

		for($i=0; $i < $nb_match; $i++) {				
			# the match has no name			
			if(empty($_POST['data'][$i][$id_date])) {					
				$nb_match_empty++;
			}
			elseif(!check_date($_POST['data'][$i][$id_date])) {
				array_push($date_found, $_POST['data'][$i][$id_date]);
				$nb_invalid++;
			}
			else {
				// we try to match with the season
				foreach($season_list AS $id_season => $value) {
					if(convert_date_sql($_POST['data'][$i][$id_date]) >= $value['date_start'] AND convert_date_sql($_POST['data'][$i][$id_date]) <= $value['date_end']) {
						$season[$i]=$id_season;
					}
				}
				if(!isset($season[$i])) {
					$nb_no_season++;
				}
			}
		}
		
		if($nb_match_empty!=0) {
			$page['erreur'][$nb_error]['message']=$lang['match']['E_empty_matchs_date'];
			$nb_error++;
		}
		if($nb_invalid!=0) {
			$var['date']=implode(', ',$date_found);
			$page['erreur'][$nb_error]['message']=text_replace($lang['match']['E_invalid_date_matchs'], $var);
			$nb_error++;
		}
		if($nb_no_season!=0) {
			$page['erreur'][$nb_error]['message']=$lang['match']['E_empty_matchs_no_season'];
			$nb_error++;
		}		
	}
	
	
	# we check that if the merge option is selected, a match has been chosen
	for($i=0; $i < $nb_match; $i++) {		
		if($_POST['action'][$i]=='merge' AND empty($_POST['match'][$i]) AND $nb_error==0) {
			$page['erreur'][$nb_error]['message']=$lang['match']['E_empty_match_merge'];
			$nb_error++;
		}	
	}
	
	if($nb_error==0) {
		# we add new_value
		$new_weather=array(); // array containing $id_weather => $weather_name
		$new_field_state=array();
		$new_field=array();
		$new_club=array();
		$new_competition=array();

		if(isset($_POST['new_value']) AND !empty($_POST['new_value'])) {
			$nb_value=sizeof($_POST['new_value']);
			$sgbd=sql_connect();
			for($i=0; $i < $nb_value; $i++) {
				if($_POST['new_value_type'][$i]=="weather") {
					$var['name']=$_POST['new_value'][$i];
					$sql_insert_new=sql_replace($sql['match']['insert_weather'],$var);
					sql_query($sql_insert_new,$sgbd);
					$new_id=sql_insert_id($sgbd);
					$new_weather[$new_id]=$_POST['new_value'][$i];
				}
				elseif($_POST['new_value_type'][$i]=="field_state") {
					$var['name']=$_POST['new_value'][$i];
					$sql_insert_new=sql_replace($sql['match']['insert_field_state'],$var);
					sql_query($sql_insert_new,$sgbd);
					$new_id=sql_insert_id($sgbd);
					$new_field_state[$new_id]=$_POST['new_value'][$i];
				}
				elseif($_POST['new_value_type'][$i]=="field") {
					$var['name']=$_POST['new_value'][$i];
					$sql_insert_new=sql_replace($sql['field']['insert_field_name'],$var);
					sql_query($sql_insert_new,$sgbd);
					$new_id=sql_insert_id($sgbd);
					$new_field[$new_id]=$_POST['new_value'][$i];
				}
				elseif($_POST['new_value_type'][$i]=="club") {
					$var['name']=$_POST['new_value'][$i];
					include_once(create_path('club/sql_club.php'));
					$sql_insert_new=sql_replace($sql['club']['insert_club_name'],$var);
					sql_query($sql_insert_new,$sgbd);
					$new_id=sql_insert_id($sgbd);
					$new_club[$new_id]=$_POST['new_value'][$i];
				}
				elseif($_POST['new_value_type'][$i]=="competition") {
					$var['name']=$_POST['new_value'][$i];
					$sql_insert_new=sql_replace($sql['competition']['insert_competition'],$var);
					sql_query($sql_insert_new,$sgbd);
					$new_id=sql_insert_id($sgbd);
					$new_competition[$new_id]=$_POST['new_value'][$i];
				}
			}
		}
	
		# correspondance des colonnes
		$nb_column=sizeof($_POST['match_field']);
		$nb_line=sizeof($_POST['data']);
		$sgbd = sql_connect();		
		for($i=0; $i < $nb_line; $i++) {			
			# on construit la requete
			for($j=0; $j < $nb_column; $j++) {				
				$field_list[$j]=$_POST['match_field'][$j];
				$value_list[$j]=format_txt($_POST['data'][$i][$j]); // we format data

				if($field_list[$j]=='weather_id' AND $id_search=array_search($_POST['data'][$i][$j],$new_weather)) {
					$value_list[$j]=$id_search;
				}
				elseif($field_list[$j]=='field_state_id' AND $id_search=array_search($_POST['data'][$i][$j],$new_field_state)) {
					$value_list[$j]=$id_search;
				}
				elseif($field_list[$j]=='field_id' AND $id_search=array_search($_POST['data'][$i][$j],$new_field)) {
					$value_list[$j]=$id_search;
				}
				elseif($field_list[$j]=='competition_id' AND $id_search=array_search($_POST['data'][$i][$j],$new_competition)) {
					$value_list[$j]=$id_search;
				}
				elseif($field_list[$j]=='club_home_id' AND $id_search=array_search($_POST['data'][$i][$j],$new_club)) {
					$value_list[$j]=$id_search;					
				}
				elseif($field_list[$j]=='club_visitor_id' AND $id_search=array_search($_POST['data'][$i][$j],$new_club)) {
					$value_list[$j]=$id_search;
				}
				
				if($field_list[$j]=='match_date') { 
					$value_list[$j]=convert_date_sql($_POST['data'][$i][$j]);
				}
				
				if($field_list[$j]=='club_home_id') { 
					$tmp_club_home=explode('_',$_POST['data'][$i][$j]);
					$value_list[$j]=$tmp_club_home[0];
					if(isset($tmp_club_home[1]) AND $tmp_club_home[1]!='') {
						$field_list[$nb_column+1]='team_home_id';
						$value_list[$nb_column+1]=$tmp_club_home[1];
						$field_value_list[$nb_column+1]=$field_list[$nb_column+1]."='".$value_list[$nb_column+1]."'";
					}
				}
				
				if($field_list[$j]=='club_visitor_id') { 
					$tmp_club_visitor=explode('_',$_POST['data'][$i][$j]);
					$value_list[$j]=$tmp_club_visitor[0];
					if(isset($tmp_club_visitor[1]) AND $tmp_club_visitor[1]!='') {
						$field_list[$nb_column+2]='team_home_id';
						$value_list[$nb_column+2]=$tmp_club_visitor[1];
						$field_value_list[$nb_column+2]=$field_list[$nb_column+2]."='".$value_list[$nb_column+2]."'";
					}
				}
				if($field_list[$j]=='competition_id') { 
					$tmp_competition=explode('_',$_POST['data'][$i][$j]);
					$value_list[$j]=$tmp_competition[0];
					if(isset($tmp_competition[1]) AND $tmp_competition[1]!='') {
						$field_list[$nb_column+3]='round_id';
						$value_list[$nb_column+3]=$tmp_competition[1];
						$field_value_list[$nb_column+3]=$field_list[$nb_column+3]."='".$value_list[$nb_column+3]."'";
					}
				}
				
				# for merge, we update only non-empty data
				if($value_list[$j]!='') { $field_value_list[$j]=$field_list[$j]."='".$value_list[$j]."'"; }
			}

			if($_POST['action'][$i]=="import") {
				# we add the match
				ksort($field_list);
				ksort($value_list);
				$var['field']=implode(", ",$field_list);
				$var['values']="'".implode("', '",$value_list)."'";
				
				$sql_import=sql_replace($sql['match']['import_match'], $var);				
				sql_query($sql_import);
				$match_id=sql_insert_id($sgbd);
				
			}
			elseif($_POST['action'][$i]=="merge") {
				# we merge the match with the one found (we update only the not empty field)
				$var['field_value']=implode(", ",$field_value_list);
				$var['id']=$_POST['match'][$i];
				
				$sql_merge=sql_replace($sql['match']['merge_match'], $var);
				sql_query($sql_merge);
			}
		}
		sql_close($sgbd);
		$page['value_step']='';
		$page['num_step']='';
		$page['show_step_1']=''; $page['show_step_2']=''; 
		$page['show_step_3']=''; $page['show_step_4']='';
		
		$page['L_message']=$lang['match']['import_match_1'];	
	}
	else {
		# there are some errors
		
		# match_field		
		$column=$_POST['match_field'];
		$nb_column=sizeof($column);
		
		for($i=0; $i < $nb_column; $i++) {
			$id=$column[$i];
			$page['match_field'][$i]['i']=$i;
			$page['match_field'][$i]['name']=$match_field[$id];
			$page['match_field'][$i]['value']=$id;			
		}
		
		# new_value
		$new_weather_list=array();
		$new_field_state_list=array();
		$new_field_list=array();
		$new_club_list=array();
		$new_competition_list=array();
		
		if(isset($_POST['new_value']) AND !empty($_POST['new_value'])) {
			$nb_new_value=sizeof($_POST['new_value']);
			for($i=0; $i < $nb_new_value; $i++) {				
				$page['new_value'][$i]['i']=$i;				
				$page['new_value'][$i]['value']=$_POST['new_value'][$i];
				$page['new_value'][$i]['type']=$_POST['new_value_type'][$i];
				if($_POST['new_value_type'][$i]=="weather") { $new_weather_list[]=$_POST['new_value'][$i]; }
				if($_POST['new_value_type'][$i]=="field_state") { $new_field_state_list[]=$_POST['new_value'][$i]; }
				if($_POST['new_value_type'][$i]=="field") { $new_field_list[]=$_POST['new_value'][$i]; }
				if($_POST['new_value_type'][$i]=="club") { $new_club_list[]=$_POST['new_value'][$i]; }
				if($_POST['new_value_type'][$i]=="competition") { $new_competition_list[]=$_POST['new_value'][$i]; }
			}
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
				
				if($id=="weather_id") {										
					$z=0;
					$page['data'][$i]['column'][$j]['L_choose']=$lang['match']['choose_weather'];
					foreach($weather_list AS $id_weather => $value) {
						$page['data'][$i]['column'][$j]['value_list'][$z]['id']=$id_weather;
						$page['data'][$i]['column'][$j]['value_list'][$z]['value']=$value;				
						if($id_weather==$_POST['data'][$i][$j]) { 
							$page['data'][$i]['column'][$j]['value_list'][$z]['selected']='selected="selected"';
						}
						else {
						 $page['data'][$i]['column'][$j]['value_list'][$z]['selected']='';
						}
						$z++;
					}

					foreach($new_weather_list AS $id_weather => $value) {
						$page['data'][$i]['column'][$j]['value_list'][$z]['id']=$value;
						$page['data'][$i]['column'][$j]['value_list'][$z]['value']=$value;
						
						if($_POST['data'][$i][$j]==$new_weather_list[$id_weather]) {
							$page['data'][$i]['column'][$j]['value_list'][$z]['selected']='selected="selected"';
						}
						else {
						 $page['data'][$i]['column'][$j]['value_list'][$z]['selected']='';
						}
						$z++;
					}
				}
				elseif($id=="field_state_id") {										
					$z=0;
					$page['data'][$i]['column'][$j]['L_choose']=$lang['match']['choose_field_state'];
					foreach($field_state_list AS $id_field_state => $value) {
						$page['data'][$i]['column'][$j]['value_list'][$z]['id']=$id_field_state;
						$page['data'][$i]['column'][$j]['value_list'][$z]['value']=$value;				
						if($id_field_state==$_POST['data'][$i][$j]) { 
							$page['data'][$i]['column'][$j]['value_list'][$z]['selected']='selected="selected"';
						}
						else {
						 $page['data'][$i]['column'][$j]['value_list'][$z]['selected']='';
						}
						$z++;
					}

					foreach($new_field_state_list AS $id_field_state => $value) {
						$page['data'][$i]['column'][$j]['value_list'][$z]['id']=$value;
						$page['data'][$i]['column'][$j]['value_list'][$z]['value']=$value;
						
						if($_POST['data'][$i][$j]==$new_field_state_list[$id_field_state]) {
							$page['data'][$i]['column'][$j]['value_list'][$z]['selected']='selected="selected"';
						}
						else {
						 $page['data'][$i]['column'][$j]['value_list'][$z]['selected']='';
						}
						$z++;
					}
				}
				elseif($id=="field_id") {
					$z=0;
					$page['data'][$i]['column'][$j]['L_choose']=$lang['match']['choose_field'];
					
					foreach($field_list AS $id_field => $value) {
						$page['data'][$i]['column'][$j]['value_list'][$z]['id']=$id_field;
						$page['data'][$i]['column'][$j]['value_list'][$z]['value']=$value;				
						if($id_field==$_POST['data'][$i][$j]) { 
							$page['data'][$i]['column'][$j]['value_list'][$z]['selected']='selected="selected"';
						}
						else {
						 $page['data'][$i]['column'][$j]['value_list'][$z]['selected']='';
						}
						$z++;
					}

					foreach($new_field_list AS $id_field => $value) {
						$page['data'][$i]['column'][$j]['value_list'][$z]['id']=$value;
						$page['data'][$i]['column'][$j]['value_list'][$z]['value']=$value;
						
						if($_POST['data'][$i][$j]==$new_field_list[$id_field]) {
							$page['data'][$i]['column'][$j]['value_list'][$z]['selected']='selected="selected"';
						}
						else {
						 $page['data'][$i]['column'][$j]['value_list'][$z]['selected']='';
						}
						$z++;
					}
				}
				elseif($id=="club_home_id") {
					$z=0;
					$page['data'][$i]['column'][$j]['L_choose']=$lang['match']['choose_club'];
					
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
				elseif($id=="club_visitor_id") {
					$z=0;
					$page['data'][$i]['column'][$j]['L_choose']=$lang['match']['choose_club'];
					
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
				elseif($id=="competition_id") {
					$z=0;
					$page['data'][$i]['column'][$j]['L_choose']=$lang['match']['choose_competition'];
					
					foreach($competition_list AS $id_competition => $value) {
						$page['data'][$i]['column'][$j]['value_list'][$z]['id']=$id_competition;
						$page['data'][$i]['column'][$j]['value_list'][$z]['value']=$value;				
						if($id_competition==$_POST['data'][$i][$j]) { 
							$page['data'][$i]['column'][$j]['value_list'][$z]['selected']='selected="selected"';
						}
						else {
						 $page['data'][$i]['column'][$j]['value_list'][$z]['selected']='';
						}
						$z++;
					}

					foreach($new_competition_list AS $id_competition => $value) {
						$page['data'][$i]['column'][$j]['value_list'][$z]['id']=$value;
						$page['data'][$i]['column'][$j]['value_list'][$z]['value']=$value;
						
						if($_POST['data'][$i][$j]==$new_competition_list[$id_competition]) {
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
			
			$page['data'][$i]['match_list']=array();
			$j=0;
			foreach($match_list AS $id => $value) {
				$page['data'][$i]['match_list'][$j]['id']=$id;
				$page['data'][$i]['match_list'][$j]['name']=$value;
				$page['data'][$i]['match_list'][$j]['selected']='';
				
				if($id==$_POST['match'][$i]) {
					$page['data'][$i]['match_list'][$j]['selected']='selected="selected"';
				}
				$j++;
			}
			
			$page['data'][$i]['L_choose_match']=$lang['match']['choose_match'];
			$page['data'][$i]['L_import']=$lang['match']['import_new_match'];
			$page['data'][$i]['L_merge']=$lang['match']['merge_match'];
			$page['data'][$i]['L_dont_import']=$lang['match']['dont_import'];
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
				$page['column'][$i]['name']=$lang['match']['column']." ".$x;
			}
			$page['column'][$i]['i']=$i;			
			$page['column'][$i]['match_field']=array();
			$page['column'][$i]['L_choose_field']=$lang['match']['choose_field_import'];
			$j=0;
			foreach($match_field AS $id => $value) {
				$page['column'][$i]['match_field'][$j]['name']=$value;
				$page['column'][$i]['match_field'][$j]['id']=$id;
				$page['column'][$i]['match_field'][$j]['selected']='';
				
				if(isset($_POST['match_field'][$i]) AND $_POST['match_field'][$i]==$id) 
				{
					$page['column'][$i]['match_field'][$j]['selected']="selected";
				}
				
				$j++;
			}		
		}
	}	
}



switch($page['num_step']) {
 case 1 : 	$page['L_current_step']=$lang['match']['upload_file']; 
 			$page['L_current_step_info']=$lang['match']['upload_file_info']; 
 			break;
 case 2 : 	$page['L_current_step']=$lang['match']['associate_field'];
 			$page['L_current_step_info']=$lang['match']['associate_field_info'];
			break;
 case 3 : 	$page['L_current_step']=$lang['match']['associate_value'];
 			$page['L_current_step_info']=$lang['match']['associate_value_info'];
			break;			
 case 4 : 	$page['L_current_step']=$lang['match']['check_data'];
 			$page['L_current_step_info']=$lang['match']['check_data_info'];
			break;
 default :  $page['L_current_step']=$lang['match']['upload_file'];
 			$page['L_current_step_info']=$lang['match']['upload_file_info'];
}



if($page['value_first_line']=="1") { $page['first_line_checked']="checked=\"checked\""; }


# link
$page['form_action']=convert_url("index.php?r=".$lang['general']['idurl_match']."&v1=import_match");
$page['link_list']=convert_url("index.php?r=".$lang['general']['idurl_match']."&v1=match_list");

# text
$page['L_title']=$lang['match']['import_match'];
$page['L_step']=$lang['match']['step'];

$page['L_csv_file']=$lang['match']['csv_file'];
$page['L_separator']=$lang['match']['separator'];
$page['L_first_line']=$lang['match']['first_line'];

$page['L_file_column']=$lang['match']['file_column'];
$page['L_associated_field']=$lang['match']['associated_field'];

$page['L_action']=$lang['match']['action'];


$page['L_valider']=$lang['match']['submit'];
$page['L_delete']=$lang['match']['delete'];
$page['L_back_list']=$lang['match']['back_list']; 
$page['L_erreur']=$lang['general']['E_erreur'];
$page['L_field_required']=$lang['general']['field_required'];

$page['L_home']=$lang['match']['home'];
$page['L_visitor']=$lang['match']['visitor'];
$page['L_competition']=$lang['match']['competition'];
$page['L_field_state']=$lang['match']['field_state'];
$page['L_field']=$lang['match']['field'];
$page['L_weather']=$lang['match']['weather'];
$page['L_field_state']=$lang['match']['field_state'];
$page['L_date']=$lang['match']['date'];
$page['L_hour']=$lang['match']['hour'];
$page['L_score']=$lang['match']['score'];
$page['L_spectators']=$lang['match']['spectators'];
$page['L_comment']=$lang['match']['comment'];

$page['L_format_date']=$lang['match']['format_date'];
$page['L_format_hour']=$lang['match']['format_hour'];
$page['L_choose_competition']=$lang['match']['choose_competition'];
$page['L_choose_field_state']=$lang['match']['choose_field_state'];
$page['L_choose_field']=$lang['match']['choose_field'];
$page['L_choose_weather']=$lang['match']['choose_weather'];
$page['L_choose_field_state']=$lang['match']['choose_field_state'];

$page['L_choose_club_home']=$lang['match']['choose_club'];
$page['L_choose_club_visitor']=$lang['match']['choose_club'];
$page['L_choose_team_home']=$lang['match']['choose_team'];
$page['L_choose_team_visitor']=$lang['match']['choose_team'];


$page['L_club']=$lang['match']['club'];

$page['L_comment']=$lang['match']['comment'];
$page['L_format_date']=$lang['match']['format_date'];


$page['meta_title']=$page['L_title'];
$page['template']=$tpl['match']['import_match'];
?>