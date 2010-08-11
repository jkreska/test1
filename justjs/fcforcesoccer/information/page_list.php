<?php
$page['page']=array();
$form_invalid=0;
$page['template']="";
$page['erreur']=array();
$page['form_action']=convert_url("index.php?r=".$lang['general']['idurl_information']."&v1=page_list");
$page['value_id']="";
$page['value_idurl']="";
$page['value_page_parent']="";
$page['value_name']="";
$page['L_message_information']="";

/* suppression */
if($right_user['delete_information'] AND isset($_GET['v2']) AND $_GET['v2']=="delete" AND isset($_GET['v3']) AND !empty($_GET['v3']) AND (!isset($included) OR $included==0))
{
 $var['id']=$_GET['v3'];
 $sql_sup=sql_replace($sql['information']['sup_page'],$var);
 $sgbd = sql_connect();
 if(sql_query($sql_sup) != false) { $page['L_message_information']=$lang['information']['form_page_sup_1']; }
 else { $page['L_message_information']=$lang['information']['form_page_sup_0']; }
 sql_close($sgbd);
}

/* modification de l'ordre */
if($right_user['edit_information'] AND isset($_GET['v2']) AND $_GET['v2']=="order" AND isset($_GET['v3']) AND isset($_GET['v4']) AND !empty($_GET['v4']) AND (!isset($included) OR $included==0))
{
 $var['mode']=$_GET['v2'];
 $var['action']=$_GET['v3'];
 $var['id']=$_GET['v4'];
 
 /* on selectionne l'ordre correspondant à l'identifiant */
 $sql_ordre=sql_replace($sql['information']['select_page_details'],$var);
 $sgbd = sql_connect();
 $res = sql_query($sql_ordre);

 if($res!=false)
 {
  $result = sql_fetch_array($res);
  $var['ordre']=$result['page_order'];
  $var['page_parent']=$result['page_parent'];
  //$var['lang']=$result['lang_id'];

  sql_free_result($res);

  /* on selectionne l'ordre le plus grand et le plus petit */
  $var2['id']=$result['page_parent'];
  $sql_max=sql_replace($sql['information']['select_page_parent_ordre'],$var2);
  $res=sql_query($sql_max);
  $ordre=sql_fetch_array($res);
  sql_free_result($res);
  $max=$ordre['max'];
  $min=$ordre['min'];

   /* on verifie que l'on peut bien ordonner */
   $ordonner="";
   if($var['action']=="up" AND $var['ordre']!=$min)
   {
    $ordonner="ok";
    $var['ordre_nouveau']=$var['ordre'] - 1;
   }
   elseif($var['action']=="down" AND $var['ordre']!=$max)
   {
    $ordonner="ok";
    $var['ordre_nouveau']=$var['ordre'] + 1;
   }


   if($ordonner=="ok") /* on echange la ligne courrante avec la ligne ayant le meme ordre */
   {
    $sql_ordre_nouveau=sql_replace($sql['information']['edit_page_order'],$var);
    sql_query($sql_ordre_nouveau);
    $sql_ordre=sql_replace($sql['information']['edit_page_order_id'],$var);
    sql_query($sql_ordre);
   }
  sql_close($sgbd);
 }
 header("location:".$page['form_action']);
 exit;
}

$var['condition']="WHERE page_parent='0' ";

if(!$right_user['edit_information'])
{
 $var['condition'].=" AND page_status='1' ";
}

$sql_page=sql_replace($sql['information']['select_page_condition'],$var);

$sgbd = sql_connect();
$res_page = sql_query($sql_page);
$nb_ligne=sql_num_rows($res_page);

if(!$right_user['information_list']) {
	$page['L_message_information']=$lang['general']['acces_reserve_admin'];
}
elseif($nb_ligne=="0")
{
 $page['L_message_information']=$lang['information']['E_page_not_found'];
}
else
{
 $i="0";
 $j="0";
 $tmp="";
 while($ligne = sql_fetch_array($res_page))
 {
  $page['page'][$i]['id']=$ligne['page_id'];
  $page['page'][$i]['title']=$ligne['page_title'];
  $page['page'][$i]['summary']=stripslashes($ligne['page_summary']);
  $page['page'][$i]['link']=convert_url("index.php?r=".$lang['general']['idurl_information']."&v1=".$ligne['page_idurl']);


  $page['page'][$i]['L_up']=$lang['information']['up'];
  $page['page'][$i]['L_down']=$lang['information']['down'];

  if($i=="0")
  {
   $page['page'][$i]['link_up']="";
   $page['page'][$i]['link_down']=convert_url("index.php?r=".$lang['general']['idurl_information']."&v1=page_list&v2=order&v3=down&v4=".$ligne['page_id']);
  }
  elseif($i==$nb_ligne-1)
  {
   $page['page'][$i]['link_up']=convert_url("index.php?r=".$lang['general']['idurl_information']."&v1=page_list&v2=order&v3=up&v4=".$ligne['page_id']);
   $page['page'][$i]['link_down']="";
  }
  else
  {
   $page['page'][$i]['link_up']=convert_url("index.php?r=".$lang['general']['idurl_information']."&v1=page_list&v2=order&v3=up&v4=".$ligne['page_id']);
   $page['page'][$i]['link_down']=convert_url("index.php?r=".$lang['general']['idurl_information']."&v1=page_list&v2=order&v3=down&v4=".$ligne['page_id']);
  }

  $page['page'][$i]['L_edit']=$lang['information']['edit'];
  $page['page'][$i]['L_delete']=$lang['information']['delete'];

   $page['page'][$i]['link_delete']="";
   $page['page'][$i]['link_edit']="";
   
  if($right_user['edit_information']) {
  	$page['page'][$i]['link_edit']=convert_url("index.php?r=".$lang['general']['idurl_information']."&v1=form_page&v2=".$ligne['page_id']);  
  }
  else {
	$page['page'][$i]['link_up']="";
  	$page['page'][$i]['link_down']="";
  }
  
  if($right_user['delete_information']) {
  	$page['page'][$i]['link_delete']=convert_url("index.php?r=".$lang['general']['idurl_information']."&v1=page_list&v2=delete&v3=".$ligne['page_id']);
  }
 
  /* selection de l'image si elle existe */
  /*
  if($ligne['image_id']!="" AND $ligne['image_id']!="0")
  {
    $var['id']=$ligne['image_id'];
    $sql_image=sql_replace($sql['image']['select_image_details'],$var);
    $sgbd = sql_connect();
    $res_image = sql_query($sql_image);
    $ligne_image = sql_fetch_array($res_image);
    sql_free_result($res_image);
    $page['page'][$i]['image_url']=ROOT_URL."/".IMG_DOSSIER."/".$ligne_image['image_dossier']."/".$ligne_image['image_url'];
    $page['page'][$i]['image_largeur']=$ligne_image['image_largeur'];
    $page['page'][$i]['image_hauteur']=$ligne_image['image_hauteur'];
    $page['page'][$i]['vignette_url']=ROOT_URL."/".IMG_DOSSIER."/".$ligne_image['vignette_dossier']."/".$ligne_image['vignette_url'];
    $page['page'][$i]['vignette_largeur']=$ligne_image['vignette_largeur'];
    $page['page'][$i]['vignette_hauteur']=$ligne_image['vignette_hauteur'];
  }
  else
  {
    $page['page'][$i]['image_url']="";
    $page['page'][$i]['image_largeur']="";
    $page['page'][$i]['image_hauteur']="";
    $page['page'][$i]['vignette_url']="";
    $page['page'][$i]['vignette_largeur']="";
    $page['page'][$i]['vignette_hauteur']="";
  }
  */


  /* selection des sous pages */
  $var['id']=$ligne['page_id'];
  $var['condition']="WHERE page_parent='".$var['id']."' ";

  if(!$right_user['edit_information'])
  {
   $var['condition'].=" AND page_status='1' ";
  }

  $sql_sous_page=sql_replace($sql['information']['select_page_condition'],$var);

  $res_2 = sql_query($sql_sous_page);
  $nb_ligne_2=sql_num_rows($res_2);
  $j="0";
  if($nb_ligne_2!="0")
  {
   while($ligne_2 = sql_fetch_array($res_2))
   {
    $page['page'][$i]['souspage'][$j]['title']=$ligne_2['page_title'];
    $page['page'][$i]['souspage'][$j]['summary']=stripslashes($ligne_2['page_summary']);
    $page['page'][$i]['souspage'][$j]['link']=convert_url("index.php?r=".$lang['general']['idurl_information']."&v1=".$ligne_2['page_idurl']);


    $page['page'][$i]['souspage'][$j]['L_up']=$lang['information']['up'];
    $page['page'][$i]['souspage'][$j]['L_down']=$lang['information']['down'];

    if($j=="0")
    {
     $page['page'][$i]['souspage'][$j]['link_up']="";
     $page['page'][$i]['souspage'][$j]['link_down']=convert_url("index.php?r=".$lang['general']['idurl_information']."&v1=page_list&v2=order&v3=down&v4=".$ligne_2['page_id']);
    }
    elseif($j==$nb_ligne_2-1)
    {
     $page['page'][$i]['souspage'][$j]['link_up']=convert_url("index.php?r=".$lang['general']['idurl_information']."&v1=page_list&v2=order&v3=up&v4=".$ligne_2['page_id']);
     $page['page'][$i]['souspage'][$j]['link_down']="";
    }
    else
    {
     $page['page'][$i]['souspage'][$j]['link_up']=convert_url("index.php?r=".$lang['general']['idurl_information']."&v1=page_list&v2=order&v3=up&v4=".$ligne_2['page_id']);
     $page['page'][$i]['souspage'][$j]['link_down']=convert_url("index.php?r=".$lang['general']['idurl_information']."&v1=page_list&v2=order&v3=down&v4=".$ligne_2['page_id']);
    }

    $page['page'][$i]['souspage'][$j]['L_edit']=$lang['information']['edit'];
	$page['page'][$i]['souspage'][$j]['L_delete']=$lang['information']['delete'];
    
	$page['page'][$i]['souspage'][$j]['link_delete']="";
	$page['page'][$i]['souspage'][$j]['link_edit']="";
    
	if($right_user['edit_information']) {	
   	 	$page['page'][$i][$i]['souspage'][$j]['link_edit']=convert_url("index.php?r=".$lang['general']['idurl_information']."&v1=form_page&v2=".$ligne_2['page_id']);	
	 
	}
	else {
	 $page['page'][$i]['souspage'][$j]['link_up']="";
     $page['page'][$i]['souspage'][$j]['link_down']="";
	}
	
	if($right_user['delete_information']) {
  		$page['page'][$i][$i]['souspage'][$j]['link_delete']=convert_url("index.php?r=".$lang['general']['idurl_information']."&v1=page_list&v2=delete&v3=".$ligne_2['page_id']);
	}

    $page['page'][$i]['souspage'][$j]['image_url']="";
    $page['page'][$i]['souspage'][$j]['image_largeur']="";
    $page['page'][$i]['souspage'][$j]['image_hauteur']="";
    $page['page'][$i]['souspage'][$j]['vignette_url']="";
    $page['page'][$i]['souspage'][$j]['vignette_largeur']="";
    $page['page'][$i]['souspage'][$j]['vignette_hauteur']="";

    $j++;
   }
  }
  else
  {
   $page['page'][$i]['souspage']=array();
  }

  /* on recupere les infos de la premiere page pour les balises meta */
  if($i=="0")
  {
   $page['meta_description']=html2txt($ligne['page_summary']);
   $page['meta_keyword']=html2txt($ligne['page_title']." ".$ligne['page_summary']);
   $page['meta_date']=$ligne['page_date_edit'];
  }

  $i++;
 }
}
sql_free_result($res_page);
sql_close($sgbd);

if($right_user['add_information']) 
 {
  $page['link_add']=convert_url("index.php?r=".$lang['general']['idurl_information']."&v1=form_page");
 }
else
{
 $page['link_add']="";
}

$_SESSION['menu_information']=$page['page'];

$page['L_add']=$lang['information']['add_page'];
$page['L_title']=$lang['information']['information'];

# meta
$page['meta_title']=$lang['information']['information'];


$page['template']=$tpl['information']['page_list'];


?>