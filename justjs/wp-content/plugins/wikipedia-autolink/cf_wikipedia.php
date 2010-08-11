<?PHP

/* 
  Plugin Name: Wikipedia AutoLink
  Plugin URI: http://www.cristianofino.net/post/Wikipedia-Autolink-plugin-anche-per-WordPress.aspx
  Description: Link automatically all the highlighted words with the syntax [w: term] on the definition from Wikipedia. 
  Version: 1.1.01
  Author: Cristiano Fino
  Author URI: http://www.cristianofino.net/
*/

/* 
  Copyright 2008 Cristiano Fino (email: cristiano.fino@bbs.olografix.org)

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 2 of the License, or
  (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
*/


/* Adding plugin if not already exists function */ 

if (function_exists('cf_wikiterms')) 
{
	add_filter('the_content', 'cf_wikiterms');

	/* Adding parameters */
	add_option('cf_wikiterms_icon', '0', 'add link to term (0) or to wiki icon (1)');
	add_option('cf_wikiterms_culture', substr(constant('WPLANG'), 0, 2), 'wikipedia language localization');
	add_option('cf_wikiterms_style', '1', 'switch to activate formatting of wikipedia term');
	add_option('cf_wikiterms_rel','0','activate or deactivate rel=nofollow in hyperlink');

	/* Adding menu and parameters page */
	add_action('admin_menu', 'cf_wikiterms_admin_menu');
	
	/* Loading text domain */
	load_plugin_textdomain('cf_wikipedia', PLUGINDIR.'/'.dirname(plugin_basename(__FILE__)).'/languages', dirname(plugin_basename(__FILE__)).'/languages');
}


/* Adding parameters page */

function cf_wikiterms_admin_menu()
{
	add_submenu_page('plugins.php', 'Wikipedia Autolink Plugin Options', 'Wikipedia', 5, basename(__FILE__),'cf_wikiterms_options_page'); 
}


/* Options page */

function cf_wikiterms_options_page() {

    $hidden_field_name = 'mt_submit_hidden';
    
    $opt_name_culture = 'cf_wikiterms_culture';
    $opt_name_icon = 'cf_wikiterms_icon';
    $opt_name_style = 'cf_wikiterms_style';
    $opt_name_rel = 'cf_wikiterms_rel';

    
    $data_field_name_culture = 'cf_wikiterms_culture';
    $data_field_name_icon = 'cf_wikiterms_icon';
    $data_field_name_style = 'cf_wikiterms_style';
    $data_field_name_rel = 'cf_wikiterms_rel';

    // Read in existing option value from database
    $opt_val_culture = get_option($opt_name_culture);
    $opt_val_icon = get_option($opt_name_icon);
    $opt_val_style = get_option($opt_name_style);
    $opt_val_rel = get_option($opt_name_rel);

    if( $_POST[ $hidden_field_name ] == 'Y' ) {
        $opt_val_culture = $_POST[$data_field_name_culture];
        $opt_val_icon = $_POST[$data_field_name_icon];
        $opt_val_style = $_POST[$data_field_name_style];
        $opt_val_rel = $_POST[$data_field_name_rel];
        
        update_option($opt_name_culture, substr($opt_val_culture, 0, 2));
        update_option($opt_name_icon, $opt_val_icon);
        update_option($opt_name_style, $opt_val_style);
        update_option($opt_name_rel, $opt_val_rel);		
        
?>
	<div id="message" class="updated fade"><p><strong><?php _e('Options saved.', 'cf_wikipedia' ); ?></strong></p></div>

<?php
    }
    echo '<div class="wrap">';
    echo "<h2>" . __( 'Wikipedia Autolink Plugin Options', 'cf_wikipedia' ) . "</h2>";
    ?>

	<form name="form_Wikiterm_Options" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
	<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">
	<p style="padding-left:25px">	
	<table>
	<tr style="vertical-align: middle; height: 40px">
		<td><?php _e("Localization code:", 'cf_wikipedia' ); ?></td>
		<td><input type="text" name="<?php echo $data_field_name_culture; ?>" value="<?php echo $opt_val_culture; ?>" size="2"></td>
	</tr>
	<tr style="vertical-align: middle; height: 40px"">
		<td><?php _e("Autolink Icon:", 'cf_wikipedia' ); ?></td>
		<td>
			<select name="<?php echo $data_field_name_icon; ?>">
				<option value="0" <?php if($opt_val_icon == "0") echo 'selected' ?> ><?php _e("No", 'cf_wikipedia' ); ?></option> 
				<option value="1" <?php if($opt_val_icon == "1") echo 'selected' ?> ><?php _e("Yes", 'cf_wikipedia' ); ?> </option>
			</select>
		</td>
	</tr>
	<tr style="vertical-align: middle; height: 40px"">
		<td><?php _e("Enable default CSS style:", 'cf_wikipedia' ); ?></td>
		<td>
			<select name="<?php echo $data_field_name_style; ?>">
				<option value="0" <?php if($opt_val_style == "0") echo 'selected' ?> ><?php _e("No", 'cf_wikipedia' ); ?></option> 
				<option value="1" <?php if($opt_val_style == "1") echo 'selected' ?> ><?php _e("Yes", 'cf_wikipedia' ); ?></option> 
			</select>
		</td>
	</tr>
	<tr style="vertical-align: middle; height: 40px"">
		<td><?php _e("Enable NOFOLLOW in hyperlink:", 'cf_wikipedia' ); ?></td>
		<td>
			<select name="<?php echo $data_field_name_rel; ?>">
				<option value="0" <?php if($opt_val_rel == "0") echo 'selected' ?> ><?php _e("No", 'cf_wikipedia' ); ?></option> 
				<option value="1" <?php if($opt_val_rel == "1") echo 'selected' ?> ><?php _e("Yes", 'cf_wikipedia' ); ?></option> 
			</select>
		</td>
	</tr>
	</table>
	</p>
	<p class="submit">
	<input type="submit" name="Submit" value="<?php _e('Update Options', 'cf_wikipedia' ) ?>" />
	</p>
	</form>
	</div>

<?php
}

/* Core function of Wikipedia filter */

function cf_wikiterms($body = '')
{
	if (!strpos($body,"[W:")) return $body;

	/* Style definitions */
	$cf_wikiterm = "padding-bottom: 2px; border-bottom: 1px dotted #DD0000";
	$cf_wikiicon = "font-family: Georgia, Times New Roman, Serif; font-weight: bold; color: #AAAAAA";

	/* Apply direct style ? */
	if (intval(get_option('cf_wikiterms_style')) == 1) 
	{
		$css_class_term = "style=\"".$cf_wikiterm."\"";
		$css_class_icon = "style=\"".$cf_wikiicon."\"";
	}
	else {
			$css_class_term = "class=\"wikiterm\"";
			$css_class_icon = "class=\"wikiicon\"";
		 }
	
	/* loading parameters */
	$culture = strtolower(get_option('cf_wikiterms_culture'));
	$wikiIcon = intval(get_option('cf_wikiterms_icon'));
  	$relnofollow = ((intval(get_option('cf_wikiterms_rel')) == 1) ? " rel=\"nofollow\"" : '');
  
	/* if exists, set the wikiicon switch */ 
	if (stripos($body,"[wikiicon]") !== false)
	{
		$wikiIcon = 1;
		$body = str_ireplace("[wikiicon]", "", $body);
	}
	
	if (preg_match_all("@\[W:(.*?)\]@", $body, $Matches) > 0)
	{
		foreach ($Matches[1] as $pos => $Match)
		{
			$wikiTerm = trim($Match);			        
			$wikiDesc = __("From Wikipedia the definition of:",'cf_wikipedia').' '.$wikiTerm;				
			$wikiTermNS = str_replace(" ",  "_", $wikiTerm);
			
			if ($wikiIcon == 0) 
				$link = "<a href=\"http://".$culture.".wikipedia.org/wiki/".$wikiTermNS."\"".$relnofollow." target=\"_blank\" title=\"".$wikiDesc."\" ".$css_class_term." >".$wikiTerm."</a><sup ".$css_class_icon." ><em>W</em></sup>";
		    else
				$link = "<span ".$css_class_term." >".$wikiTerm."</span><sup><a href=\"http://".$culture.".wikipedia.org/wiki/".$wikiTermNS."\"".$relnofollow." target=\"_blank\" title=\"".$wikiDesc."\" ".$css_class_icon." ><em>W</em></a></sup>";
			
			if (strpos($Matches[0][$pos], ":0]") == (strlen($Matches[0][$pos]) - 3))
				$body = str_replace($Matches[0][$pos], str_replace(":0]", "]", $Matches[0][$pos]), $body); 
			else
				$body = str_replace($Matches[0][$pos], $link, $body);
		}
	}
	return $body;	
}

?>
