<?php
/*
Plugin Name: AskApache Password Protect
Plugin URI: http://www.askapache.com/htaccess/htaccess-security-block-spam-hackers.html
Description: Advanced Security: Password Protection, Anti-Spam, Anti-Exploits, more to come...
Version: 4.6.5.2
Author: AskApache
Author URI: http://www.askapache.com/
*/

/**
 *   AskApache Password Protect WordPress Plugin for .htaccess Files
 * 	 Copyright (C) 2008  AskApache.comi
 *
 * 	 This program is free software: you can redistribute it and/or modify
 * 	 it under the terms of the GNU General Public License as published by
 * 	 the Free Software Foundation, either version 3 of the License, or
 * 	 (at your option) any later version.
 *
 * 	 This program is distributed in the hope that it will be useful,
 * 	 but WITHOUT ANY WARRANTY; without even the implied warranty of
 * 	 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * 	 GNU General Public License for more details.
 *
 * 	 You should have received a copy of the GNU General Public License
 * 	 along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

if ( defined( 'AA_PP_DEBUG' ) ) return;

// define( 'AA_PP_LOG_FILE', ABSPATH.'/askapache-passpro-log.txt' );  // set this to any file to log to
define( 'AA_PP_DEBUG', false ); // set this to 1 for verbose debugging
define( 'AA_PP_NET_DEBUG', false ); // set this to 1 for verbose network debugging

register_activation_hook( __FILE__, 'aa_pp_activate' );
register_deactivation_hook( __FILE__, 'aa_pp_deactivate' );

add_action( 'admin_menu', 'aa_pp_setup_options' );

if ( strpos( $_SERVER['REQUEST_URI'], basename( __FILE__ ) ) !== false ) add_action( 'admin_head', 'aa_pp_admin_header' );

if ( !defined('WP_CONTENT_DIR') ) define( 'WP_CONTENT_DIR', ABSPATH . 'wp-content' );


/**
* aa_pp_setup_options()
 *
 * @return
 */
function aa_pp_setup_options()
{
	add_filter( 'plugin_action_links', 'aa_pp_plugin_settings', 10, 2 );
	add_options_page( __( 'AskApache Password Protection', 'askapache-password-protection' ), __( 'AA PassPro', 'askapache-password-protection' ), 8, basename( __FILE__ ), 'aa_pp_main_page' );
}



/**
* aa_pp_plugin_settings()
 *
 * @param mixed $links
 * @param mixed $file
 * @return
 */
function aa_pp_plugin_settings( $links, $file )
{
	static $this_plugin;
	if ( !$this_plugin ) $this_plugin = plugin_basename( __FILE__ );
	if ( $file == $this_plugin ) $links = array_merge( array( '<a href="' . attribute_escape( 'options-general.php?page=askapache-password-protect.php' ) . '">Settings</a>' ), $links );
	return $links;
}



/**
* aa_pp_deactivate()
 *
 * @return
 */
function aa_pp_deactivate()
{
	global $aa_PP, $aa_SIDS;
	$aa_PP = get_option( 'askapache_password_protect' );
	$aa_SIDS = get_option( 'askapache_password_protect_sids' );

	aa_pp_deactivate_sid( 'PASSPRO', 'ASKAPACHE ', $aa_PP['root_htaccess'] );
	aa_pp_deactivate_sid( 'PASSPRO', 'ASKAPACHE ', $aa_PP['admin_htaccess'] );

	delete_option( 'askapache_password_protect' );
	delete_option( 'askapache_password_protect_sids' );
}



/**
* aa_pp_activate()
 *
 * @return
 */
function aa_pp_activate()
{
	global $wpdb, $aa_PP, $aa_SIDS;
	$aa_PP = $s = $aa_SIDS = array();

	foreach ( array( 'home_folder', 'wpadmin_folder', 'htpasswd_file', 'htaccess_file', 'original_htpasswd', 'original_htaccess', 'plugin_message', 'plugin_version', 'home', 'wpadmin', 'htpasswd_f', 'htaccess_f', 'user', 'plugin_message', 'home_folder', 'wpadmin_folder', 'htpasswd_file', 'htaccess_file', 'original_htpasswd', 'original_htaccess', 'plugin_message', 'plugin_version', 'pp_docroot_htaccess', 'pp_wp_includes_htaccess', 'pp_wp_content_htaccess', 'pp_wp_includes_htaccess', 'pp_main_base64', 'pp_ok' ) as $option )	delete_option( 'aa_'.$option );

	$home = get_option( 'siteurl' );
	aa_pp_notify( __FUNCTION__ . ":" . __LINE__ . ' ' . "home: $home" );
	$su = parse_url( $home );
	$path = ( !isset( $su['path'] ) || empty( $su['path'] ) ) ? '/' : rtrim( $su['path'], '/' ) . '/';
	aa_pp_notify( __FUNCTION__ . ":" . __LINE__ . ' ' . "path: $path" );
	$scheme = ( isset( $_SERVER['HTTPS'] ) && strtolower( $_SERVER['HTTPS'] ) == 'on' && $su['scheme'] == 'https' ) ? 'https' : 'http';
	$home_path = rtrim( get_home_path(), '/' ) . '/';
	$hu = str_replace( $scheme . '://', '', $home );
	aa_pp_notify( __FUNCTION__ . ":" . __LINE__ . ' ' . "hu: $hu" );
	$url = $scheme . '://' . rtrim( str_replace( rtrim( $path, '/' ), '', $hu ), '/' );
	aa_pp_notify( __FUNCTION__ . ":" . __LINE__ . ' ' . "url: $url" );
	$authdomain = "/ {$url}/";

	update_option( 'askapache_password_protect', array( 
			'step' => 'welcome',
			'setup_complete' => 0,
			'scheme' => $scheme,
			'host' => $su['host'],
			'root_path' => $path,
			'home_path' => $home_path,
			'test_dir' => WP_CONTENT_DIR.'/askapache',
			'root_htaccess' => $home_path . '.htaccess',
			'admin_htaccess' => $home_path . 'wp-admin/.htaccess',
			'admin_mail' => get_option( 'admin_email' ),
			'authdomain' => $authdomain,
			'authname' => 'Protected By AskApache',
			'authuserfile' => $home_path . '.htpasswda3',
			'authuserdigest' => 'AuthDigestFile',
			'algorithm' => 'md5',
			'key' => wp_hash_password( wp_generate_password() ),
			'htaccess_support' => 0,
			'mod_alias_support' => 0,
			'mod_rewrite_support' => 0,
			'mod_security_support' => 0,
			'mod_auth_digest_support' => 0,
			'basic_support' => 0,
			'digest_support' => 0,
			'crypt_support' => 0,
			'sha1_support' => 0,
			'md5_support' => 0,
			'revision_support' => 0,
			'apache_version' => '',
			'revisions' => array(),
			'plugin_data' => get_plugin_data( __FILE__ ),
			) );
			
	update_option( 'askapache_password_protect_sids', array( 
			60000001 => array( 'Version' => '1.3',
				'Name' => 'Directory Protection',
				'Description' => 'Enable the DirectoryIndex Protection, preventing directory index listings and defaulting.',
				'Rules' =>
				'Options -Indexes%n%' . 
				'DirectoryIndex index.html index.php %relative_root%index.php'
				),

			60000002 => array( 'Version' => '1.0',
				'Name' => 'Loop Stopping Code',
				'Description' => 'Stops Internal Redirect Loops',
				'Rules' =>
				'RewriteCond %{ENV:REDIRECT_STATUS} 200%n%' . 
				'RewriteRule .* - [L]%n%'
				),

			10140001 => array( 'Version' => '1.1',
				'Name' => 'Stop Hotlinking',
				'Description' => 'Denies any request for static files (images, css, etc) if referrer is not local site or empty.',
				'Rules' =>
				'RewriteCond %{HTTP_REFERER} !^$%n%' . 
				'RewriteCond %{REQUEST_URI} !^%relative_root%(wp-login.php|wp-admin/|wp-content/plugins/|wp-includes/).* [NC]%n%' . 
				'RewriteCond %{HTTP_REFERER} !^%scheme%://%host%.*$ [NC]%n%' . 
				'RewriteRule \.(ico|pdf|flv|jpg|jpeg|mp3|mpg|mp4|mov|wav|wmv|png|gif|swf|css|js)$ - [F,NS,L]'
				),

			20030001 => array( 'Version' => '1.3',
				'Name' => 'Password Protect wp-login.php',
				'Description' => 'Requires a valid user/pass to access the login page..',
				'Rules' =>
				'<Files wp-login.php>%n%' . 
				'Satisfy Any%n%' . 
				'%generate_auth%%n%' . 
				'</Files>'
				),

			21030002 => array( 'Version' => '1.3',
				'Name' => 'Password Protect wp-admin',
				'Description' => 'Requires a valid user/pass to access any non-static (css, js, images) file in this directory...',
				'Rules' =>
				'%generate_auth%%n%' . 
				'<FilesMatch "\.(ico|pdf|flv|jpg|jpeg|mp3|mpg|mp4|mov|wav|wmv|png|gif|swf|css|js)$">%n%' . 
				'Allow from All%n%' . 
				'</FilesMatch>%n%' . 
				'<FilesMatch "(async-upload|admin-ajax)\.php$">%n%' . 
				'<IfModule mod_security.c>%n%' . 
				'SecFilterEngine Off%n%' . 
				'</IfModule>%n%' . 
				'Allow from All%n%' . 
				'</FilesMatch>'
				),

			30140003 => array( 'Version' => '1.1',
				'Name' => 'Forbid Proxies',
				'Description' => 'Denies POST Request using a Proxy Server. Can access site, but not comment. See <a href="http://perishablepress.com/press/2008/04/20/how-to-block-proxy-servers-via-htaccess/">Perishable Press</a>',
				'Rules' =>
				'RewriteCond %{HTTP:VIA}%{HTTP:FORWARDED}%{HTTP:USERAGENT_VIA}%{HTTP:X_FORWARDED_FOR}%{HTTP:PROXY_CONNECTION} !^$ [OR]%n%' . 
				'RewriteCond %{HTTP:XPROXY_CONNECTION}%{HTTP:HTTP_PC_REMOTE_ADDR}%{HTTP:HTTP_CLIENT_IP} !^$%n%' . 
				'RewriteCond %{REQUEST_URI} !^%relative_root%(wp-login.php|wp-admin/|wp-content/plugins/|wp-includes/).* [NC]%n%' . 
				'RewriteCond %{REQUEST_METHOD} =POST%n%' . 
				'RewriteRule .* - [F,NS,L]'
				),

			30140004 => array( 'Version' => '1.1',
				'Name' => 'Real wp-comments-post.php',
				'Description' => 'Denies any POST attempt made to a non-existing wp-comments-post.php..',
				'Rules' =>
				'RewriteCond %{THE_REQUEST} ^[A-Z]{3,9}\ %relative_root%.*/wp-comments-post\.php.*\ HTTP/ [NC]%n%' . 
				'RewriteRule .* - [F,NS,L]'
				),

			30140005 => array( 'Version' => '1.1',
				'Name' => 'BAD Content Length',
				'Description' => 'Denies any POST request that doesnt have a Content-Length Header..',
				'Rules' =>
				'RewriteCond %{REQUEST_METHOD} =POST%n%' . 
				'RewriteCond %{REQUEST_URI} !^%relative_root%(wp-admin/|wp-content/plugins/|wp-includes/).* [NC]%n%' . 
				'RewriteCond %{HTTP:Content-Length} ^$%n%' . 
				'RewriteRule .* - [F,NS,L]'
				),

			30140006 => array( 'Version' => '1.1',
				'Name' => 'BAD Content Type',
				'Description' => 'Denies any POST request with a content type other than application/x-www-form-urlencoded|multipart/form-data..',
				'Rules' =>
				'RewriteCond %{REQUEST_METHOD} =POST%n%' . 
				'RewriteCond %{REQUEST_URI} !^%relative_root%(wp-login.php|wp-admin/|wp-content/plugins/|wp-includes/).* [NC]%n%' . 
				'RewriteCond %{HTTP:Content-Type} !^(application/x-www-form-urlencoded|multipart/form-data.*(boundary.*)?)$ [NC]%n%' . 
				'RewriteRule .* - [F,NS,L]'
				),

			30140007 => array( 'Version' => '1.1',
				'Name' => 'NO HOST:',
				'Description' => 'Denies requests that dont contain a HTTP HOST Header...',
				'Rules' =>
				'RewriteCond %{REQUEST_URI} !^%relative_root%(wp-login.php|wp-admin/|wp-content/plugins/|wp-includes/).* [NC]%n%' . 
				'RewriteCond %{HTTP_HOST} ^$%n%' . 
				'RewriteRule .* - [F,NS,L]'
				),

			30140008 => array( 'Version' => '1.1',
				'Name' => 'No UserAgent, No Post',
				'Description' => 'Denies POST requests by blank user-agents. May prevent a small number of visitors from POSTING.',
				'Rules' =>
				'RewriteCond %{REQUEST_METHOD} =POST%n%' . 
				'RewriteCond %{REQUEST_URI} !^%relative_root%(wp-login.php|wp-admin/|wp-content/plugins/|wp-includes/).* [NC]%n%' . 
				'RewriteCond %{HTTP_USER_AGENT} ^-?$%n%' . 
				'RewriteRule .* - [F,NS,L]'
				),

			30140009 => array( 'Version' => '1.1',
				'Name' => 'No Referer, No Comment',
				'Description' => 'Denies any comment attempt with a blank HTTP_REFERER field, highly indicative of spam. May prevent some visitors from POSTING.',
				'Rules' =>
				'RewriteCond %{THE_REQUEST} ^[A-Z]{3,9}\ /.*/wp-comments-post\.php.*\ HTTP/ [NC]%n%' . 
				'RewriteCond %{HTTP_REFERER} ^-?$%n%' . 
				'RewriteRule .* - [F,NS,L]'
				),

			30140010 => array( 'Version' => '1.1',
				'Name' => 'Trackback Spam',
				'Description' => 'Denies obvious trackback spam.  See <a href="http://ocaoimh.ie/2008/07/03/more-ways-to-stop-spammers-and-unwanted-traffic/">Holy Shmoly!</a>',
				'Rules' =>
				'RewriteCond %{HTTP_USER_AGENT} ^.*(opera|mozilla|firefox|msie|safari).*$ [NC,OR]%n%' . 
				'RewriteCond %{HTTP_USER_AGENT} ^-?$%n%' . 
				'RewriteCond %{THE_REQUEST} ^[A-Z]{3,9}\ /.+/trackback/?\ HTTP/ [NC]%n%' . 
				'RewriteCond %{REQUEST_METHOD} =POST%n%' . 
				'RewriteRule .* - [F,NS,L]'
				),

			40140011 => array( 'Version' => '1.2',
				'Name' => 'Protect wp-content',
				'Description' => 'Denies any Direct request for files ending in .php with a 403 Forbidden.. May break plugins/themes',
				'Rules' =>
				'RewriteCond %{THE_REQUEST} ^[A-Z]{3,9}\ %relative_root%wp-content/.*$ [NC]%n%' . 
				'RewriteCond %{REQUEST_FILENAME} !^.+(flexible-upload-wp25js|media)\.php$%n%' . 
				'RewriteCond %{REQUEST_FILENAME} ^.+\.(php|html|htm|txt)$%n%' . 
				'RewriteRule .* - [F,NS,L]'
				),

			40140012 => array( 'Version' => '1.2',
				'Name' => 'Protect wp-includes',
				'Description' => 'Denies any Direct request for files ending in .php with a 403 Forbidden.. May break plugins/themes',
				'Rules' =>
				'RewriteCond %{THE_REQUEST} ^[A-Z]{3,9}\ %relative_root%wp-includes/.*$ [NC]%n%' . 
				'RewriteCond %{THE_REQUEST} !^[A-Z]{3,9}\ %relative_root%wp-includes/js/.+/.+\ HTTP/ [NC]%n%' . 
				'RewriteCond %{REQUEST_FILENAME} ^.+\.php$%n%' . 
				'RewriteRule .* - [F,NS,L]'
				),

			40140013 => array( 'Version' => '1.1',
				'Name' => 'Common Exploit',
				'Description' => 'Block common exploit requests with 403 Forbidden. These can help alot, may break some plugins.',
				'Rules' =>
				'RewriteCond %{REQUEST_URI} !^%relative_root%(wp-login.php|wp-admin/|wp-content/plugins/|wp-includes/).* [NC]%n%' . 
				'RewriteCond %{THE_REQUEST} ^[A-Z]{3,9}\ ///.*\ HTTP/ [NC,OR]%n%' . 
				'RewriteCond %{THE_REQUEST} ^[A-Z]{3,9}\ /.+\?\=?(http|ftp|ssl|https):/.*\ HTTP/ [NC,OR]%n%' . 
				'RewriteCond %{THE_REQUEST} ^[A-Z]{3,9}\ /.*\?\?.*\ HTTP/ [NC,OR]%n%' . 
				'RewriteCond %{THE_REQUEST} ^[A-Z]{3,9}\ /.*\.(asp|ini|dll).*\ HTTP/ [NC,OR]%n%' . 
				'RewriteCond %{THE_REQUEST} ^[A-Z]{3,9}\ /.*\.(htpasswd|htaccess|aahtpasswd).*\ HTTP/ [NC]%n%' . 
				'RewriteRule .* - [F,NS,L]'
				),

			50140001 => array( 'Version' => '1.1',
				'Name' => 'Safe Request Methods',
				'Description' => 'Denies any request not using <a href="/online-tools/request-method-scanner/">GET,PROPFIND,POST,OPTIONS,PUT,HEAD</a>..',
				'Rules' =>
				'RewriteCond %{REQUEST_METHOD} !^(GET|HEAD|POST|PROPFIND|OPTIONS|PUT)$ [NC]%n%' . 
				'RewriteRule .* - [F,NS,L]'
				),

			50140002 => array( 'Version' => '1.1',
				'Name' => 'HTTP PROTOCOL',
				'Description' => 'Denies any badly formed HTTP PROTOCOL in the request, 0.9, 1.0, and 1.1 only..',
				'Rules' =>
				'RewriteCond %{THE_REQUEST} !^[A-Z]{3,9}\ .+\ HTTP/(0\.9|1\.0|1\.1) [NC]%n%' . 
				'RewriteRule .* - [F,NS,L]'
				),

			50140003 => array( 'Version' => '1.1',
				'Name' => 'SPECIFIC CHARACTERS',
				'Description' => 'Denies any request for a url containing characters other than "a-zA-Z0-9.+/-?=&" - REALLY helps but may break your site depending on your links.',
				'Rules' =>
				'RewriteCond %{REQUEST_URI} !^%relative_root%(wp-login.php|wp-admin/|wp-content/plugins/|wp-includes/).* [NC]%n%' . 
				'RewriteCond %{THE_REQUEST} !^[A-Z]{3,9}\ [A-Z0-9\.\+_/\-\?\=\&\%\#]+\ HTTP/ [NC]%n%' . 
				'RewriteRule .* - [F,NS,L]'
				),

			50140004 => array( 'Version' => '1.1',
				'Name' => 'Directory Traversal',
				'Description' => 'Denies Requests containing ../ or ./. which is a directory traversal exploit attempt..',
				'Rules' =>
				'RewriteCond %{THE_REQUEST} !^[A-Z]{3,9}\ .*([\.]+[\.]+).*\ HTTP/ [NC]%n%' . 
				'RewriteRule .* - [F,NS,L]'
				),

			50140005 => array( 'Version' => '1.1',
				'Name' => 'PHPSESSID Cookie',
				'Description' => 'Only blocks when a PHPSESSID cookie is sent by the user and it contains characters other than 0-9a-z..',
				'Rules' =>
				'RewriteCond %{HTTP_COOKIE} ^.*PHPSESS?ID.*$%n%' . 
				'RewriteCond %{HTTP_COOKIE} !^.*PHPSESS?ID=([0-9a-z]+);.*$%n%' . 
				'RewriteRule .* - [F,NS,L]'
				),

			50140006 => array( 'Version' => '1.1',
				'Name' => 'Bogus Graphics Exploit',
				'Description' => 'Denies obvious exploit using bogus graphics..',
				'Rules' =>
				'RewriteCond %{HTTP:Content-Disposition} \.php [NC]%n%' . 
				'RewriteCond %{HTTP:Content-Type} image/.+ [NC]%n%' . 
				'RewriteRule .* - [F,NS,L]' )
			)
		);

	$aa_SIDS = get_option( 'askapache_password_protect_sids' );
	$sids = array_keys( $aa_SIDS );
	foreach ( $sids as $sid )
	{
		$newinfo = aa_pp_sid_info( $sid );
		$aa_SIDS[$sid] = array_merge( $aa_SIDS[$sid], $newinfo );
	}

	update_option( 'askapache_password_protect_sids', $aa_SIDS );
}



/**
* aa_pp_admin_header()
 *
 * @return
 */
function aa_pp_admin_header()
{
	global $wpdb, $aa_PP, $aa_SIDS;

	if ( !user_can_access_admin_page() ) wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	if ( !current_user_can( 8 ) )wp_die( __( "You are not allowed to be here without upload permissions" ) );

	$aa_PP = get_option( 'askapache_password_protect' );
	$aa_SIDS = get_option( 'askapache_password_protect_sids' );

	@set_time_limit( 60 );
	@set_magic_quotes_runtime( 0 );
}



/**
* aa_pp_get_post_values()
 *
 * @param mixed $v
 * @return
 */
function aa_pp_get_post_values( $v )
{
	global $aa_PP, $aa_SIDS;
	$errors = new WP_Error;

	$action = 'none';
	foreach( array( 'a_htaccess_support', 'a_mod_alias_support', 'a_mod_rewrite_support', 'a_mod_security_support', 'a_mod_auth_digest_support', 'a_digest_support', 'a_basic_support' ) as $k )
	{
		if ( isset( $_POST[$k] ) && $v[$k] != 1 )
		{
			check_admin_referer( 'askapache-passpro-form' );
			$v[substr( $k, 2 )] = 1;
		}
	}

	foreach( array( 'a_user', 'a_authdomain', 'a_authtype', 'a_algorithm', 'a_authname', 'a_authuserfile', 'a_step', 'a_admin_email', 'a_root_htaccess', ) as $k )
	{
		if ( isset( $_POST[$k] ) && !empty( $_POST[$k] ) && $_POST[$k] != $v[$k] )
		{
			check_admin_referer( 'askapache-passpro-form' );
			$v[substr( $k, 2 )] = $_POST[$k];
		}
	}

	foreach ( array( 'activate-selected', 'deactivate-selected', 'delete-selected', 'm_move' ) as $action_key )
	{
		if ( isset( $_POST[$action_key] ) )
		{
			aa_pp_notify( __FUNCTION__ . ":" . __LINE__ . ' ' . "Setting action to {$action_key}" );
			$action = $action_key;
			break;
		}
	}

	if ( $action == 'm_move' )
	{
		check_admin_referer( 'askapache-move-area' );
		foreach( array( 'm_read', 'm_reset', 'm_sid', 'm_setup', 'm_test', 'm_welcome', 'm_contact' ) as $where )
		{
			if ( isset( $_POST[$where] ) )
			{
				$aa_PP['step'] = substr( $where, 2 );
				aa_pp_notify( __FUNCTION__ . ":" . __LINE__ . ' ' . "Setting step to {$aa_PP['step']}" );
				break;
			}
		}
		return true;
	}

	foreach ( array( 'deactivate-sid', 'activate-sid', 'view-revision', 'activate-revision', 'delete-revision' ) as $ak )
	{
		if ( isset( $_GET[$ak] ) )
		{
			$action = $ak;
			break;
		}
	}

	if ( isset( $_POST['a_pass1'] ) && isset( $_POST['a_pass2'] ) )
	{
		if ( empty( $_POST['a_pass1'] ) || empty( $_POST['a_pass2'] ) )$errors->add( 'password-required', __( '<strong>ERROR</strong>: A password is required' ) );
		if ( $_POST['a_pass1'] != $_POST['a_pass2'] )$errors->add( 'passwords-notsame', __( '<strong>ERROR</strong>: The passwords do not match.' ) );
		else $pass = $_POST['a_pass1'];
	}

	if ( isset( $_POST['a_user'] ) && isset( $_POST['a_admin_email'] ) )
	{
		if ( empty( $_POST['a_user'] ) )$errors->add( 'username-required', __( '<strong>ERROR</strong>: A username is required.' ) );
		if ( empty( $_POST['a_admin_email'] ) )$errors->add( 'adminemail-required', __( '<strong>ERROR</strong>: An admin email is required.' ) );
		if ( !is_email( $_POST['a_admin_email'] ) )$errors->add( 'adminemail-bad', __( '<strong>ERROR</strong>: A valid admin email is required.' ) );
	}

	if ( isset( $v['authtype'] ) && !in_array( $v['authtype'], array( 'Digest', 'Basic' ) ) ) $errors->add( 'bad-authtype', __( '<strong>ERROR</strong>: Incorrect authtype' ) );

	if ( isset( $v['algorithm'] ) && !in_array( $v['algorithm'], array( 'crypt', 'md5', 'sha1' ) ) ) $errors->add( 'bad-algorithm', __( '<strong>ERROR</strong>: Incorrect algorithm' ) );

	if ( isset($v['user']) && strpos( $v['user'], ':' ) !== false ) $errors->add( 'bad-username', __( '<strong>ERROR</strong>: Username cannot contain the : character' ) );

	if ( isset($v['authname']) && strlen( $v['authname'] ) > 65 ) $errors->add( 'bad-authname', __( '<strong>ERROR</strong>: Authname cannot exceed 65 characters, yours was ' . strlen( $v['authname'] ) . ' characters' ) );

	if ( isset($v['authtype']) && $v['authtype'] == 'Digest' && $v['algorithm'] != 'md5' ) $errors->add( 'algorithm-authtype-mismatch', __( '<strong>ERROR</strong>: Digest Authentication can only use the md5 algorithm' ) );

	foreach( array( $v['authuserfile'], $v['admin_htaccess'], $v['root_htaccess'] ) as $f )
	{
		if ( strpos( basename( $f ), '.ht' ) === false ) $errors->add( 'bad-authuserfilename', __( '<strong>ERROR</strong>: File names must start with .ht like .htaccess or .htpasswd-new3' ) );
		if ( (int)$v['setup_complete'] != 0 )
		{
			if ( aa_pp_htaccess_file_init() && !@touch($f) || !@is_writable( $f ) ) $errors->add( 'unwritable-file', __( '<strong>ERROR</strong>: Please make ' . $f . ' writable and readable' ) );
		}
	}

	if ( count( $errors->errors ) == 0 )
	{
		$aa_PP = $v;

		switch ( $action )
		{
			case 'activate-revision':
				$file = $_GET['activate-revision'];
				check_admin_referer( 'activate-revision_' . $file );
				break;
			case 'view-revision':
				$file = $_GET['view-revision'];
				check_admin_referer( 'view-revision_' . $file );
				break;
			case 'delete-revision':
				$file = $_GET['delete-revision'];
				check_admin_referer( 'delete-revision_' . $file );
				$g = array();
				foreach( $aa_PP['revisions'] as $item )if ( $item['id'] != $file )$g[] = $item;
				$v['revisions'] = $g;
				break;
			case 'activate-sid':
				$sid = ( int )$_GET['activate-sid'];
				check_admin_referer( 'activate-sid_' . $sid );
				if ( !aa_pp_activate_sid( $sid ) ) $errors->add( 'sid-activation-failed', __( "Failed to activate sid {$sid}" ) );
				echo '<img src="askapache-reset.bmp?' . rand( 1, 1000 ) . '" style="width:1px;height:1px;" />';
				break;
			case 'deactivate-sid':
				$sid = ( int )$_GET['deactivate-sid'];
				check_admin_referer( 'deactivate-sid_' . $sid );
				if ( !aa_pp_deactivate_sid( $sid ) ) $errors->add( 'sid-deactivation-failed', __( "Failed to deactivate sid {$sid}" ) );
				break;
			case 'activate-selected':
			case 'deactivate-selected':
				check_admin_referer( 'askapache-bulk-sids' );
				break;
		}

		if ( isset( $pass ) && count( $errors->errors ) == 0 )
		{
			$message_headers = 'From: "' . $blog_title . '" <wordpress@' . str_replace( 'www.', '', $aa_PP['host'] ) . '>';
			$message = sprintf( __( "Your new username and password has been successfully set up at:\n\n%1\$s\n\nYou can log in to the administrator area with the following information:\n\n\nUsername: %2\$s\nPassword: %3\$s\n\nWe hope you enjoy your new protection. Thanks!\n\n--The AskApache Team\nhttp://www.askapache.com/" ), get_option( 'siteurl' ) . '/wp-admin/', $v['user'], $pass );

			if ( !aa_pp_file_put_c( $v['authuserfile'], aa_pp_hashit( $v['authtype'], $v['user'], $pass, $v['authname'] ), false ) )
				$errors->add( 'failed-create-authuserfile', __( '<strong>ERROR</strong>: Failed to create ' . $v['authuserfile'] ) );
				
			else if ( !wp_mail( $aa_PP['admin_email'], __( '__New AskApache User' ), $message, $message_headers ) )
				$errors->add( 'failed-wp-mail', __( '<strong>ERROR</strong>: Failed to mail to ' . $aa_PP['admin_email'] ) );
		}
	}

	if ( count( $errors->errors ) > 0 ) $v['step'] = $aa_PP['step'];

	if ( $v['step'] == 'sid' && (int)$v['setup_complete'] != 1 )$v['setup_complete'] = 1;

	$aa_PP = $v;

	if ( count( $errors->errors ) > 0 ) return $errors;
	else return true;
}



/**
* aa_pp_main_page()
 *
 * @return
 */
function aa_pp_main_page()
{
	global $aa_PP, $aa_SIDS;
	
	$aa_PP = get_option( 'askapache_password_protect' );
	$aa_SIDS = get_option( 'askapache_password_protect_sids' );

	?>
<form method="post" action="options-general.php?page=askapache-password-protect.php"><?php wp_nonce_field( 'askapache-move-area' );
	?>
<div class="tablenav">
<div class="alignleft">
<?php if ( $aa_PP['setup_complete'] != 0 )	{?>
<input type="submit" name="m_test" id="m_test" value="Self-Diagnostics" class="button-secondary" />
<input type="submit" name="m_read" id="m_read" value="Htaccess Files" class="button-secondary" />
<input type="submit" name="m_setup" id="m_setup" value="Password Configuration" class="button-secondary" />
<input type="submit" name="m_sid" id="m_sid" value="SID Module Management" class="button-secondary" />
<input type="submit" name="m_contact" id="m_contact" value="Improvements" class="button-secondary" />
<input type="hidden" name="m_move" id="m_move" value="m_move" />
<?php } ?>
</div>
<p style="float:right; margin-top:0;padding-top:0;"><a href="http://www.askapache.com/htaccess/apache-htaccess.html">AskApache .htaccess Tutorial</a></p>
</div>
<br class="clear" />
</form>
<?php

	$errors = aa_pp_get_post_values( $aa_PP );
	aa_pp_errors( $errors );

	if ( (int)$aa_PP['setup_complete'] != 0 )
	{
		$errors = aa_pp_update_revisions( $aa_PP['admin_htaccess'] );
		aa_pp_errors( $errors );

		$errors = aa_pp_update_revisions( $aa_PP['root_htaccess'] );
		aa_pp_errors( $errors );
	}


	update_option( 'askapache_password_protect', $aa_PP );

	if ( isset( $_POST['notice'] ) ) echo '<div id="message" class="updated fade"><p>' . $_POST['notice'] . '</p></div>';


	
	if ( (bool)AA_PP_DEBUG === true )
	{
		echo '<pre>';
		print_r( $aa_PP );
		print_r(aa_pp_active_sids());
		//print_r(get_defined_constants());
		echo '</pre>';
	}
	


	switch ( $aa_PP['step'] )
	{
		case 'contact':
			?>
<div class="wrap" style="max-width:95%;">
<h3>Bug Fixes</h3>
<p>10/17/08 - Fixed known bugs..  Improved Testing with debug output automatically for failed tests.</p>
<p><br class="clear" /></p>

<h3>Backups and Revisioning</h3>
<p>8/19/08 - Ok so version 4.6 has some nice automatic revisioning/backup features... the next release will let us compare the new .htaccess file with the old .htaccess files just like wikis.  (based once again on wordpress core)..</p>
<p>So now that the SID module system is pretty stable and there is now decent backups going on, the next thing I'll be adding is multi-user and group management.  And much more access control by IP address and other ids.</p>
<p>The point of doing all that is so the plugin will be stable enough code-wise so we can focus in on developing custom SIDs for protecting wordpress blogs.. Mod_Security rules are on the way....</p>
<p><br class="clear" /></p>

<h3>The SID Module Redesigned</h3>
<p>8/14/08 - I'm finally mostly happy with the system now used by this plugin to update/modify/and use the different modules.  The old code just wasn't future-proofed enough.  This new version is based very much off of the WordPress Plugins code, so it is future proofed.</p>
<p>This "Improvements" page is the start of whats to come, Basically each of the security modules (and there are a LOT of great mod_security ones coming) will have their own very Basic settings.  So you can tweak the settings.  If someone finds an improvement they can send it for review.  New ideas and modules can be submitted here also.</p>
</div>
<?php
			break;
		case 'welcome':
			aa_pp_welcome_form();
			break;
		case 'test':
			aa_pp_run_tests();
			break;
		case 'setup':
			aa_pp_setup_form();
			break;
		case 'sid':
			aa_pp_sid_management();
			break;
		case 'reset':
			aa_pp_activate();
			break;
		case 'read':
			aa_pp_htaccess_history();
			break;
		default:
			aa_pp_welcome_form();
			break;
	}

	update_option( 'askapache_password_protect', $aa_PP );
}








/**
* aa_pp_welcome_form()
 *
 * @return
 */
function aa_pp_welcome_form()
{
	global $aa_PP, $aa_SIDS;?>
<div class="wrap" style="max-width:95%;">
<h2>Test for Compatibility and Capability</h2>
<form action="options-general.php?page=askapache-password-protect.php" method="post"><?php wp_nonce_field( 'askapache-passpro-form' );?>
<input type="hidden" id="a_step" name="a_step" value="test" />
<p>First we need to run a series of tests on your server to determine what capabilities your site has and also to locate any potential installation problems.</p>
<p>The tests will be run on temporary files I'll create in your /wp-content/askapache/ folder.  They will create .htaccess and .htpasswd files in that temp location and then use fsockopen networking functions to query those files.  This tells us exactly how your server handles .htaccess configurations, HTTP authentication schemes, Apache Module capability, etc..</p></p>

<table class="form-table">
<tr valign="top">
<th scope="row">Known Support<br /><p>Only check these if you are 100% sure your server supports them.  This bypasses auto-detecting support.</p></th>
<td><label for="a_htaccess_support"><input type="checkbox" name="a_htaccess_support" id="a_htaccess_support" <?php if ( $aa_PP['htaccess_support'] != 0 )echo 'checked="checked"';?> /> .htaccess file support</label><br />
<label for="a_mod_alias_support"><input type="checkbox" name="a_mod_alias_support" id="a_mod_alias_support" <?php if ( $aa_PP['mod_alias_support'] != 0 )echo 'checked="checked"';?> /> mod_alias Redirects supported</label><br />
<label for="a_mod_rewrite_support"><input type="checkbox" name="a_mod_rewrite_support" id="a_mod_rewrite_support" <?php if ( $aa_PP['mod_rewrite_support'] != 0 )echo 'checked="checked"';?> /> mod_rewrite supported</label><br />
<label for="a_mod_security_support"><input type="checkbox" name="a_mod_security_support" id="a_mod_security_support" <?php if ( $aa_PP['mod_security_support'] != 0 )echo 'checked="checked"';?> /> mod_security supported</label><br />
<label for="a_mod_auth_digest_support"><input type="checkbox" name="a_mod_auth_digest_support" id="a_mod_auth_digest_support" <?php if ( $aa_PP['mod_auth_digest_support'] != 0 )echo 'checked="checked"';?> /> mod_auth_digest supported</label><br />
<label for="a_digest_support"><input type="checkbox" name="a_digest_support" id="a_digest_support" <?php if ( $aa_PP['digest_support'] != 0 )echo 'checked="checked"';?> /> digest authentication supported</label><br />
<label for="a_basic_support"><input type="checkbox" name="a_basic_support" id="a_basic_support" <?php if ( $aa_PP['basic_support'] != 0 )echo 'checked="checked"';?> /> basic authentication supported</label></td>
</tr>
<!--<tr valign="top">
<th scope="row"><label for="a_root_htaccess">Root .htaccess Location</label></th>
<td><input size="70" style="width: 85%;" class="wide code" name="a_root_htaccess" id="a_root_htaccess" type="text" value="<?php echo $aa_PP['root_htaccess'];?>" /><br />
Check to make sure that this is the correct location of your .htaccess file.  Getting this wrong could fudge the whole plugin.</td>
</tr>-->
</table>
<p>Several tests send specially crafted HTTP requests which are designed to elicit very specific HTTP Protocol Responses to accurately determine your servers capabilities.</p>
<p>Other important checks will run:  file permissions, function availability, much more boring testing.  The tests are fast and you can re-run them whenever you want.   If you'd like to see the action, define AA_PP_DEBUG to 1 in the source of this file. Good Luck!</p>
<p class="submit"><input name="sub" type="submit" id="sub" value="Initiate Tests &raquo;" /></p>
</form>
</div>
<?php
}



/**
* aa_pp_setup_form()
 *
 * @return
 */
function aa_pp_setup_form()
{
	global $aa_PP, $aa_SIDS;
	aa_pp_htaccess_file_init();?>
<div class="wrap" style="max-width:95%;">
<h2>Setup Password Protection</h2>

<form action="options-general.php?page=askapache-password-protect.php" method="post"><?php wp_nonce_field( 'askapache-passpro-form' );?>
<input type="hidden" id="a_step" name="a_step" value="sid" />
<h3>Create User</h3>
<table class="form-table">
<tbody>
<tr valign="top">
<th scope="row"><label for="a_admin_email">Admin Email</label><br />Username and Password sent here in case you forget it.</th>
<td><input size="40" name="a_admin_email" type="text" id="a_admin_email" value="<?php echo $aa_PP['admin_mail'];?>" /></td>
</tr>
<tr valign="top">
<th scope="row"><label for="a_user">Username</label></th>
<td><input size="40" name="a_user" type="text" id="a_user" value="<?php echo $aa_PP['user'];?>" /></td>
</tr>
<tr valign="top">
<th><label for="a_pass">Password (twice)</label></th>
<td><input size="40" type="password" name="a_pass1" id="a_pass1" value="<?php if ( isset( $_POST['a_pass1'] ) && !empty( $_POST['a_pass1'] ) ) echo htmlentities( $_POST['a_pass1'] );?>" /><br />
<input size="40" type="password" name="a_pass2" id="a_pass2" value="<?php if ( isset( $_POST['a_pass2'] ) && !empty( $_POST['a_pass2'] ) ) echo htmlentities( $_POST['a_pass2'] );?>" /><br /></td>
</tr>
</tbody>
</table>
<h3>Authentication Scheme</h3>
<table class="form-table">
<tr valign="top">
<th scope="row">Choose Scheme </th>
<td><fieldset>
<p>
<label><input name="a_authtype"  type="radio" value="Digest" <?php echo ( $aa_PP['digest_support'] != 1 ) ? ' disabled="disabled"' : ' checked="checked"';?> /> <strong>Digest</strong> &#8212; Much better than Basic, MD5 crypto hashing with nonce's to prevent cryptanalysis.</label>
<br />
<label><input name="a_authtype" type="radio" value="Basic" <?php if ( $aa_PP['basic_support'] != 1 ) echo ' disabled="disabled"';
	else if ( $aa_PP['digest_support'] != 1 ) echo ' checked="checked"';?> /> <strong>Basic</strong> &#8212; Cleartext authentication using a user-ID and a password for each authname.</label>
<br /><br /> This is the mechanism by which your credentials are authenticated (Digest is <a href="http://tools.ietf.org/html/rfc2617">strongly preferred</a>) </p>
</fieldset></td>
</tr>
</tbody>

</table>
<h3>Authentication Settings</h3>
<table class="form-table">
<tbody>
<tr valign="top">
<th scope="row"><label for="a_authuserfile">Password File Location</label></th>
<td><input size="70" style="width: 85%;" class="wide code" name="a_authuserfile" id="a_authuserfile" type="text" value="<?php echo $aa_PP['authuserfile'];?>" /><br />
Use a location inaccessible from a web-browser if possible. Do not put it in the directory that it protects. </td>
</tr>
<tr valign="top">
<th scope="row"><label for="a_authname">Realm Name</label></th>
<td><input size="70" style="width: 85%;" class="wide code"  name="a_authname" id="a_authname" type="text" value="<?php echo $aa_PP['authname'];?>" /><br />
The authname or "Realm" serves two major functions. Part of the password dialog box. Second, it is used by the client to determine what password to send for a given authenticated area. </td>
</tr>
<tr valign="top">
<th scope="row"><label for="a_authdomain">Protection Space Domains</label></th>
<td><input size="70" style="width: 85%;" class="wide code" name="a_authdomain" id="a_authdomain" type="text" value="<?php echo $aa_PP['authdomain'];?>" /><br />
One or more URIs in the same protection space (i.e. use the same authname and username/password info).  The URIs may be either absolute or relative URIs.  Omitting causes client to send Authorization header for every request. </td>
</tr>
</tbody>
</table>
<h3>Encryption Preferences</h3>
<table class="form-table">
<tbody>
<tr valign="top">
<th scope="row">Password File Algorithm</th>
<td><fieldset>
<label><input type="radio" name="a_algorithm" value="crypt" id="a_algorithm_crypt"<?php if ( $aa_PP['crypt_support'] != 1 )
		echo ' disabled="disabled"';
	else if ( $aa_PP['algorithm'] == 'crypt' && $aa_PP['authtype'] != 'Digest' )
		echo ' checked="checked"';?> /> <strong>CRYPT</strong> &#8212; Unix only. Uses the traditional Unix crypt(3) function with a randomly-generated 32-bit salt (only 12 bits used) and the first 8 characters of the password.</label>
<br />
<label><input type="radio" name="a_algorithm" value="md5" id="a_algorithm_md5"<?php if ( $aa_PP['md5_support'] != 1 )
		echo ' disabled="disabled"';
	else if ( $aa_PP['algorithm'] == 'md5' )
		echo ' checked="checked"';?> /> <strong>MD5</strong> &#8212; Apache-specific algorithm using an iterated (1,000 times) MD5 Digest of various combinations of a random 32-bit salt and the password.</label>
<br />
<label><input type="radio" name="a_algorithm" value="sha1" id="a_algorithm_sha1"<?php if ( $aa_PP['sha1_support'] != 1 )
		echo ' disabled="disabled"';
	else if ( $aa_PP['algorithm'] == 'sha1' && $aa_PP['authtype'] != 'Digest' )
		echo ' checked="checked"';?> /> <strong>SHA1</strong> &#8212; Base64-encoded SHA-1 Digest of the password.</label>
<br />
</fieldset></td>
</tr>
</tbody>
</table>
<p>Note I do not store or save your password anywhere, so you will need to type it in each time you update this page.. for now.</p>
<p class="submit"><input name="sub" type="submit" id="sub" value="Save Settings &raquo;" /></p>
</form>
</div>
<?php
}


/**
* aa_pp_update_revisions()
 *
 * @param mixed $file
 * @return
 */
function aa_pp_update_revisions( $file )
{
	global $aa_PP;
	clearstatcache();

	if ( !file_exists( $file ) || filesize( $file ) < 5 )return;
	$md5_val = md5_file( $file );
	$md5s = array();
	foreach( $aa_PP['revisions'] as $f ) $md5s[] = $f['md5'];
	if ( in_array( $md5_val, $md5s ) )return;

	aa_pp_notify( __FUNCTION__ . ":" . __LINE__ . ' ' . "Creating new revision for {$file}" );

	$data = aa_pp_readfile( $file );
	if ( $aa_PP['gzip_support'] != 1 )$data_compress = base64_encode( $data );
	else $data_compress = base64_encode( gzcompress( $data, 9 ) );

	$tag = ( strpos( $file, 'wp-admin' ) !== false )?1:0;
	$aa_PP['revisions'][] =
	array( 
		'file' => $file,
		'id' => $tag . count( $aa_PP['revisions'] ),
		'md5' => $md5_val,
		'time' => current_time( 'timestamp', 1 ),
		'size' => filesize( $file ),
		'data' => $data_compress,
		);
}



/**
* aa_pp_htaccess_history()
 *
 * @return
 */
function aa_pp_htaccess_history()
{
	global $aa_PP;
?>
<div class="wrap" style="max-width:95%;">
<h2>.htaccess File Revisions</h2>
<p><br class="clear" /></p>
<?php
	if ( isset( $_GET['view-revision'] ) )aa_pp_view_revision( $_GET['view-revision'] );
	else aa_pp_print_history( $aa_PP['revisions'], 'root' );
?>
</div>
<?php
}



/**
* aa_pp_view_revision()
 *
 * @param mixed $id
 * @return
 */
function aa_pp_view_revision( $id )
{
	global $aa_PP;
	$ids = array();
	foreach( $aa_PP['revisions'] as $n => $revs )
	{
		if ( $revs['id'] == $id )
		{
			$file = $revs;
			break;
		}
	}

	if ( !current_user_can( 'edit_plugins' ) )
		wp_die( '<p>' . __( 'You do not have sufficient permissions to edit templates for this blog.' ) . '</p>' );

	if ( $aa_PP['gzip_support'] != 1 )$content = base64_decode( $file['data'] );
	else $content = gzuncompress( base64_decode( $file['data'] ) );

	echo '<pre style="border:3px solid #CCC; padding:1em;font-family:"Andale Mono","Lucida Console","Bitstream Vera Sans Mono","Courier New",monospace;*font-size:108%;line-height:99%;">';
	echo htmlspecialchars( $content );
	echo '</pre>';
}



/**
* aa_pp_print_history()
 *
 * @param mixed $revision_files
 * @param mixed $context
 * @return
 */
function aa_pp_print_history( $revision_files, $context )
{
	global $aa_PP, $aa_SIDS;
	if ( sizeof( $revision_files ) < 1 )return;
	?>
<form method="post" action="options-general.php?page=askapache-password-protect.php"><?php wp_nonce_field( 'askapache-bulk-sids' );	?>
<div class="tablenav">
<h3 style="text-align:right; width:70%; line-height:2em; margin:0;float:right;padding-right:30px;" id="current-<?php echo $context;?>">.htaccess File Revisions</h3>
<br class="clear" />
</div>
<br class="clear" />
<table class="widefat" id="revisions-table">
<thead>
<tr>
<th scope="col">ID</th>
<th scope="col">Created</th>
<th scope="col">Size</th>
<th scope="col">Compressed Size</th>
<th scope="col">File Location</th>
<th scope="col">MD5 Hash</th>
<th scope="col" class="action-links"><?php _e( 'Action' );?></th>
</tr>
</thead>
<tbody class="plugins">
<?php
	foreach ( $revision_files as $file )
	{
		$fi = $file['file'];
		$ts = $file['time'];
		$id = $file['id'];
		$hash = $file['md5'];
		$created = sprintf( '%s at %s', date( get_option( 'date_format' ), $ts ), date( get_option( 'time_format' ), $ts ) );
		$size = $file['size'];
		$datasize = strlen( $file['data'] );

		$action_links = array();
		$action_links[] = '<a href="' . wp_nonce_url( 'options-general.php?page=askapache-password-protect.php&amp;view-revision=' . $id, 'view-revision_' . $id ) . '" class="view">' . __( 'View' ) . '</a>';
		$action_links[] = '<a href="' . wp_nonce_url( 'options-general.php?page=askapache-password-protect.php&amp;delete-revision=' . $id, 'delete-revision_' . $id ) . '" class="delete">' . __( 'Delete' ) . '</a>';

		echo "<tr>
<td class='id' style='width:75px;'>{$id}</td>
<td class='created'>{$created}</td>
<td class='size' style='width:75px;'>{$size}</td>
<td class='datasize' style='width:75px;'>{$datasize}</td>
<td class='file'>{$fi}</td>
<td class='md5'>{$hash}</td>
<td class='togl action-links'>";
		if ( !empty( $action_links ) ) echo implode( ' | ', $action_links );
		echo '</td>
</tr>';
	}

	?>
</tbody>
</table>
</form>
<p><br class="clear" /></p>
<?php
}




/**
* aa_pp_sid_management()
 *
 * @return
 */
function aa_pp_sid_management()
{
	global $aa_PP, $aa_SIDS;

	$sids = array_keys( $aa_SIDS );
	$sid_table = array();
	$active_sids = aa_pp_active_sids();

	$sid_table['password'] = $sid_table['general'] = $sid_table['antispam'] = $sid_table['wordpress_exploit'] = $sid_table['general_exploit'] = $sid_table['protection'] = array();
	$sid_table['active'] = array_values( $active_sids );

	foreach ( $sids as $sid )
	{
		$s = ( string )$sid;
		switch ( ( int )$s{0} )
		{
			case 1:
				$sid_table['protection'][] = $sid;
				break;
			case 2:
				$sid_table['password'][] = $sid;
				break;
			case 3:
				$sid_table['antispam'][] = $sid;
				break;
			case 4:
				$sid_table['wordpress_exploit'][] = $sid;
				break;
			case 5:
				$sid_table['general_exploit'][] = $sid;
				break;
			case 6:
				$sid_table['general'][] = $sid;
				break;
		}
	}

	?>

<div class="wrap" style="max-width:95%;">
<h2>Manage Security Modules</h2>
<p>Modules are inserted into your server .htaccess configuration files.  Once a module is installed, you may activate it or deactivate it here.</p>
<p><br class="clear" /></p>
<?php foreach( array_reverse( $sid_table ) as $n => $arr ) aa_pp_print_sids_table( $arr, $n );?>
</div>
<?php
}



/**
* aa_pp_print_sids_table()
 *
 * @param mixed $sids
 * @param mixed $context
 * @return
 */
function aa_pp_print_sids_table( $sids, $context )
{
	global $aa_PP, $aa_SIDS;
	$aa_SIDS_Active = aa_pp_active_sids();
	if ( $context !== 'active' )
	{
		$ns = array();
		$active = array_values( $aa_SIDS_Active );
		foreach ( $sids as $sid )
		{
			if ( !in_array( $sid, $active ) )
				$ns[] = $sid;
		}
		$sids = $ns;
	}
	if ( sizeof( $sids ) < 1 )return;

	$ti = str_replace( '_', ' ', $context );
	if ( strpos( $ti, ' ' ) !== false )
	{
		$word = '';
		foreach( explode( " ", $ti ) as $wrd )
			$word .= substr_replace( $wrd, strtoupper( substr( $wrd, 0, 1 ) ), 0, 1 ) . " ";

		$ti = rtrim( $word, " " );
	}
	else $ti = substr_replace( $ti, strtoupper( substr( $ti, 0, 1 ) ), 0, 1 );

	?>
<form method="post" action="options-general.php?page=askapache-password-protect.php"><?php wp_nonce_field( 'askapache-bulk-sids' );?>
<div class="tablenav">
<h3 style="text-align:right; width:70%; line-height:2em; margin:0;float:right;padding-right:30px;" id="current-<?php echo $context;?>"><?php echo $ti; ?></h3>
<br class="clear" />
</div>
<br class="clear" />
<table class="widefat" id="<?php echo $context;?>-plugins-table">
<thead>
<tr>
<th scope="col">Name</th>
<th scope="col">Description</th>
<th scope="col">Response</th>
<th scope="col">Apache Modules</th>
<th scope="col">File</th>
<th scope="col" class="action-links">Action</th>
</tr>
</thead>
<tbody class="plugins">
<?php
	foreach ( $sids as $sid )
	{
		$st = $oya = '';
		$the_sid = $aa_SIDS[$sid];
		$file_title = ( $the_sid['File'] == 'root' ) ? $aa_PP['root_htaccess'] : $aa_PP['admin_htaccess'];

		if ( $context == 'active' )
		{
			$st = 'active';
			$oya = $the_sid['Type'] . '<br />';
			$action_links = '<a href="' . wp_nonce_url( 'options-general.php?page=askapache-password-protect.php&amp;deactivate-sid=' . $sid, 'deactivate-sid_' . $sid ) . '" class="delete">' . __( 'Deactivate' ) . '</a>';
		}
		else $action_links = '<a href="' . wp_nonce_url( 'options-general.php?page=askapache-password-protect.php&amp;activate-sid=' . $sid, 'activate-sid_' . $sid ) . '" class="edit">' . __( 'Activate' ) . '</a>';

		echo "<tr class='{$st}'>
<td class='name' style='width:200px;'>" . $oya . "<dfn style='font-style:normal;color:#3366CC;' title='SID: " . $sid . " Version: " . $the_sid['Version'] . "'>" . $the_sid['Name'] . "</dfn></td>
<td class='desc' style='width:450px;'><p>" . $the_sid['Description'] . "</p></td>
<td class='vers'>" . $the_sid['Response'] . "</td>
<td class='file'>" . $the_sid['Module'] . "</td>
<td class='file'><dfn style='font-style:normal;color:#9999DD;' title='" . $file_title . "'>" . $the_sid['File'] . "</dfn></td>
<td class='action-links'>" . $action_links . '</td></tr>';
	}

	?>
</tbody>
</table>
</form>
<p><br class="clear" /></p>
<?php
}



/**
* aa_pp_active_sids()
 *
 * @param mixed $file
 * @return
 */
function aa_pp_active_sids( $file = false )
{
	global $aa_PP, $aa_SIDS;

	$result = array();
	$files = array( $aa_PP['root_htaccess'], $aa_PP['admin_htaccess'] );
	foreach ( $files as $f )
	{
		if ( !is_readable( $f ) )return new WP_Error( 'not-readable', __( "aa_pp_active_sids cant read from {$f}" ) );
		if ( $markerdata = @explode( "\n", @implode( '', @file( $f ) ) ) )
		{
			foreach ( $markerdata as $line )
			{
				if ( strpos( $line, "# +SID " ) !== false ) $result[] = ( int )str_replace( '# +SID ', '', rtrim( $line ) );
			}
		}
	}

	return array_unique( $result );
}



/**
* aa_pp_gen_sid()
 *
 * @param mixed $incoming
 * @return
 */
function aa_pp_gen_sid( $incoming )
{
	global $aa_PP, $aa_SIDS;

	if ( $aa_PP['authtype'] == 'Basic' ) $replacement = 'AuthType %authtype%%n%AuthName "%authname%"%n%AuthUserFile %authuserfile%%n%Require user %user%';
	else $replacement = 'AuthType %authtype%%n%AuthName "%authname%"%n%AuthDigestDomain %authdomain%%n%'.$aa_PP['authuserdigest'].' %authuserfile%%n%Require valid-user';

	if ( strpos( $aa_PP['apache_version'], '2.2' ) !== false && $aa_PP['authtype'] != 'Basic' )$replacement = str_replace( 'AuthDigestFile', 'AuthUserFile', $replacement );

	$aa_S = array( '%n%', '%authname%', '%user%', '%authuserfile%', '%relative_root%', '%scheme%', '%authdomain%', '%host%', '%authtype%', '%generate_auth%' );

	$aa_R = array( "\n", $aa_PP['authname'], $aa_PP['user'], $aa_PP['authuserfile'], $aa_PP['root_path'], $aa_PP['scheme'], $aa_PP['authdomain'], $aa_PP['host'], $aa_PP['authtype'], $replacement );

	return str_replace( $aa_S, $aa_R, str_replace( $aa_S, $aa_R, $incoming ) );
}



/**
* aa_pp_deactivate_sid()
 *
 * @param mixed $sid
 * @param string $mark
 * @param mixed $file
 * @return
 */
function aa_pp_deactivate_sid( $sid, $mark = 'SID ', $file = false )
{
	global $aa_PP, $aa_SIDS;

	if ( !$file )
	{
		$the_sid = $aa_SIDS[( int )$sid];
		$file = ( $the_sid['File'] == 'root' ) ? $aa_PP['root_htaccess'] : $aa_PP['admin_htaccess'];
	}

	$file = ( @is_readable( $file ) ) ? realpath( rtrim( $file, '/' ) ) : rtrim( $file, '/' );
	if ( !is_readable( $file ) || !is_writable( $file ) ) return new WP_Error( 'sid-deactivation-failed', __( "{$file} not readable/writable by aa_pp_deactivate_sid for {$the_sid['Name']}" ) );

	aa_pp_notify( __FUNCTION__ . ":" . __LINE__ . ' ' . "Deleting {$the_sid['Name']} from {$file}" );

	$result = array();
	if ( $markerdata = @explode( "\n", @implode( '', @file( $file ) ) ) )
	{
		$state = false;
		if ( !$f = @fopen( $file, 'w' ) ) return new WP_Error( 'fopen-failed', __( "aa_pp_deactivate_sid couldnt fopen {$file}" ) );

		foreach ( $markerdata as $n => $line )
		{
			if ( strpos( $line, "# +{$mark}{$sid}" ) !== false ) $state = true;
			if ( !$state ) fwrite( $f, $line . "\n" );
			if ( strpos( $line, "# -{$mark}{$sid}" ) !== false ) $state = false;
		}
	}

	@$_POST['notice'] = "Successfully Deactivated {$the_sid['Name']}";

	if ( !fclose( $f ) )return new WP_Error( 'fclose-failed', __( "fclose failed to close {$file} in aa_pp_deactivate_sid" ) );

	return true;
}



/**
* aa_pp_activate_sid()
 *
 * @param mixed $sid
 * @param mixed $file
 * @return
 */
function aa_pp_activate_sid( $sid, $file = false )
{
	global $aa_PP, $aa_SIDS;
	$the_sid = $aa_SIDS[( int )$sid];

	if ( !$file ) $file = ( $the_sid['File'] == 'root' ) ? $aa_PP['root_htaccess'] : $aa_PP['admin_htaccess'];

	$file = ( @is_readable( $file ) ) ? realpath( rtrim( $file, '/' ) ) : rtrim( $file, '/' );
	if ( !is_readable( $file ) || !is_writable( $file ) ) return new WP_Error( 'not-writable', __( "{$file} not readable/writable by aa_pp_activate_sid for {$the_sid['Name']}" ) );

	aa_pp_notify( __FUNCTION__ . ":" . __LINE__ . ' ' . "Activating {$the_sid['Name']} to {$file}" );

	$rules = aa_pp_gen_sid( explode( "\n", $the_sid['Rules'] ) );

	if ( !aa_pp_insert_sids( $file, $sid, $rules ) ) return new WP_Error( 'sid-activation-failed', __( "Failed to Activate {$the_sid['Name']}" ) );
	else
	{
		@$_POST['notice'] = "Successfully Activated {$sid}: &quot;{$the_sid['Name']}&quot;<br /><pre>";
		foreach( $rules as $line )@$_POST['notice'] .= htmlentities( $line );
		@$_POST['notice'] .= '</pre>';
	}
	return true;
}



/**
* aa_pp_htaccess_file_init()
 *
 * @param mixed $file
 * @return
 */
function aa_pp_htaccess_file_init( $file = false )
{
	global $aa_PP;

	if ( !$file ) $files = array( $aa_PP['admin_htaccess'], $aa_PP['root_htaccess'] );
	else $files = array( $file );

	foreach( $files as $file )
	{
		$wordp = $new = $jot = array();
		$aapasspro = $wpg = $s = false;
		$l1 = str_repeat( '#', 55 );
		$l2 = '# - - - - - - - - - - - - - - - - - - - - - - - - - - -';
        $logo = array(
		'#               __                          __', 
		'#   ____ ______/ /______ _____  ____ ______/ /_  ___', 
		'#  / __ `/ ___/ //_/ __ `/ __ \/ __ `/ ___/ __ \/ _ \ ', 
		'# / /_/ (__  ) ,< / /_/ / /_/ / /_/ / /__/ / / /  __/', 
		'# \__,_/____/_/|_|\__,_/ .___/\__,_/\___/_/ /_/\___/', 
		'#                     /_/'
		);

		$ot = array_merge( array( '# +ASKAPACHE PASSPRO ' . $aa_PP['plugin_data']['Version'], $l1 ), $logo );
		$ot = array_merge( $ot, array( $l2, '# +APRO SIDS' ) );
		$ot = array_merge( $ot, array( '# -APRO SIDS', $l2 ), $logo );
		$ot = array_merge( $ot, array( $l1, '# -ASKAPACHE PASSPRO ' . $aa_PP['plugin_data']['Version'], '' ) );

		$markerdata = ( is_writable( dirname( $file ) ) && touch( $file ) ) ? @explode( "\n", @implode( '', @file( $file ) ) ) : false;
		if ( $markerdata )
		{
			foreach ( $markerdata as $line )
			{
				if ( strpos( $line, '# BEGIN WordPress' ) !== false )
				{
					$s = $wpg = true;
					$wordp[] = "";
				}
				if ( $s === true ) $wordp[] = $line;
				if ( strpos( $line, '# END WordPress' ) !== false )
				{
					$s = false;
					continue;
				}

				if ( !$s ) $new[] = $line;

				if ( strpos( $line, '# +ASKAPACHE PASSPRO' ) !== false ) $aapasspro = true;
			}
		}

		if ( !$aapasspro )
		{
			$jot = ( $wpg ) ? array_merge( $new, $ot, $wordp ) : array_merge( $markerdata, $ot );

			if ( !$f = @fopen( $file, 'w' ) ) return new WP_Error( 'fopen-failed', __( "aa_pp_htaccess_file_init couldnt fopen {$file}" ) );
			$pr = join( "\n", $jot );
			if ( !@fwrite( $f, $pr, strlen( $pr ) ) ) return new WP_Error( 'aa_pp_htaccess_file_init', __( "aa_pp_insert_mark couldnt fwrite {$file}" ) );
			if ( !@fclose( $f ) ) return new WP_Error( 'fclose-failed', __( "Couldnt fclose {$file}" ) );
		}
	}

	return true;
}



/**
* aa_pp_insert_mark()
 *
 * @param mixed $file
 * @param mixed $marker
 * @param mixed $insertion
 * @param mixed $backup
 * @return
 */
function aa_pp_insert_mark( $file, $marker, $insertion, $backup = false )
{
	global $aa_PP;

	$file = ( @is_readable( $file ) ) ? realpath( rtrim( $file, '/' ) ) : rtrim( $file, '/' );
	if ( !is_writable( $file ) && @!chmod( $file, 0666 ) && !@touch( $file ) ) return new WP_Error( 'creation-failed', __( "aa_pp_insert_mark could not write, create, or touch {$file}" ) );
	if ( $backup ) $backedup = aa_pp_backup( $file, $file . '-' . time() );

	aa_pp_notify( __FUNCTION__ . ":" . __LINE__ . ' ' . "Inserting {$marker} array to {$file}" );
	$oldone = $foundit = false;
	$out = array();
	if ( !is_array( $insertion ) || ( is_array( $insertion ) && count( $insertion ) < 1 ) )
	{
		aa_pp_notify( __FUNCTION__ . ":" . __LINE__ . ' ' . "aa_pp_insert_mark1 called without array, creating one for {$marker}" );
		$my = array( "# +{$marker}", "", "# -{$marker}" );
	}
	else
	{
		$my = array();
		$my[] = "# +{$marker}";
		foreach ( $insertion as $l ) $my[] = $l;
		$my[] = "# -{$marker}";
	}

	if ( !$f = @fopen( $file, 'w' ) ) return new WP_Error( 'fopen-failed', __( "aa_pp_insert_mark couldnt fopen {$file}" ) );
	$pr = join( "\n", $my );
	if ( !@fwrite( $f, $pr, strlen( $pr ) ) ) return new WP_Error( 'fwrite-failed', __( "aa_pp_insert_mark couldnt fwrite {$file}" ) );
	if ( !@fwrite( $f, $out, strlen( $out ) ) ) return new WP_Error( 'fwrite-failed', __( "aa_pp_insert_mark couldnt fwrite {$file}" ) );
	if ( !@fclose( $f ) ) return new WP_Error( 'fclose-failed', __( "Couldnt fclose {$file}" ) );
	return true;
}



/**
* aa_pp_insert_sids()
 *
 * @param mixed $file
 * @param mixed $marker
 * @param mixed $insertion
 * @param mixed $backup
 * @return
 */
function aa_pp_insert_sids( $file, $marker, $insertion, $backup = false )
{
	global $aa_PP;

	$file = ( @is_readable( $file ) ) ? realpath( rtrim( $file, '/' ) ) : rtrim( $file, '/' );
	if ( !is_writable( $file ) && @!chmod( $file, 0666 ) && !@touch( $file ) ) return new WP_Error( 'creation-failed', __( "aa_pp_insert_sids could not write, create, or touch {$file}" ) );
	if ( $backup ) $backedup = aa_pp_backup( $file, $file . '-' . time() );

	aa_pp_notify( __FUNCTION__ . ":" . __LINE__ . ' ' . "Inserting {$marker} array to {$file}" );
	$foundit = false;
	$out = array();
	if ( !is_array( $insertion ) || ( is_array( $insertion ) && count( $insertion ) < 1 ) )
	{
		aa_pp_notify( __FUNCTION__ . ":" . __LINE__ . ' ' . "aa_pp_insert_sids called without array, creating one for {$marker}" );
		$my = array( "# +SID {$marker}", "", "# -SID {$marker}" );
	}
	else
	{
		$my = array();
		$my[] = "# +SID {$marker}";
		foreach ( $insertion as $l ) $my[] = $l;
		$my[] = "# -SID {$marker}";
	}

	if ( $markerdata = @explode( "\n", @implode( '', @file( $file ) ) ) )
	{
		if ( !$f = @fopen( $file, 'w' ) ) return new WP_Error( 'fopen-failed', __( "aa_pp_insert_sids couldnt fopen {$file}" ) );

		$state = $s = $found = false;
		foreach ( $markerdata as $line )
		{
			if ( strpos( $line, '-ASKAPACHE PASSPRO' ) !== false )
			{
				fwrite( $f, $line . "\n" );
				continue;
			}

			if ( strpos( $line, "# +APRO SIDS" ) !== false )
			{
				$s = true;
				fwrite( $f, $line . "\n" );
				continue;
			}

			if ( strpos( $line, "# -APRO SIDS" ) !== false )
			{
				$s = false;
				if ( !$found )
				{
					foreach ( $my as $in ) fwrite( $f, $in . "\n" );
				}
				fwrite( $f, $line . "\n" );
				continue;
			}

			if ( !$s ) fwrite( $f, $line . "\n" );
			else
			{
				if ( strpos( $line, "# +SID {$marker}" ) !== false ) $state = true;
				if ( !$state )fwrite( $f, $line . "\n" );
				if ( strpos( $line, "# -SID {$marker}" ) !== false )
				{
					$state = false;
					$found = true;
					foreach ( $my as $in ) fwrite( $f, $in . "\n" );
				}
			}
		}
		fclose( $f );
	}

	return true;
}





/**
* aa_pp_hashit()
 *
 * @param mixed $algorithm
 * @param string $user
 * @param string $pass
 * @param string $authname
 * @return
 */
function aa_pp_hashit( $algorithm, $user = '', $pass = '', $authname = '' )
{
	global $aa_PP, $aa_SIDS;

	$hash = $tmp = '';
	aa_pp_notify( __FUNCTION__ . ":" . __LINE__ . ' ' . 'Creating ' . $algorithm . ' Hash in aa_pp_hashit' );

	switch ( strtoupper( $algorithm ) )
	{
		case 'DIGEST':
			$hash = $user . ":" . $authname . ":" . md5( $user . ":" . $authname . ":" . $pass );
			break;
		case 'CRYPT':
			$seed = null;
			for ( $i = 0; $i < 8; $i++ ) $seed .= substr( '0123456789abcdef', rand( 0, 15 ), 1 );
			$hash = "{$user}:" . crypt( $pass, "$" . $seed );
			break;
		case 'SHA1':
			$hash = $user . ':{SHA}' . base64_encode( pack( "H*", sha1( $pass ) ) );
			break;
		case 'MD5':
			$saltt = substr( str_shuffle( "abcdefghijklmnopqrstuvwxyz0123456789" ), 0, 8 );
			$len = strlen( $pass );
			$text = $pass . '$apr1$' . $saltt;
			$bin = pack( "H32", md5( $pass . $saltt . $pass ) );
			for ( $i = $len; $i > 0; $i -= 16 ) $text .= substr( $bin, 0, min( 16, $i ) );
			for ( $i = $len; $i > 0; $i >>= 1 ) $text .= ( $i &1 ) ? chr( 0 ) : $pass{0};
			$bin = pack( "H32", md5( $text ) );
			for ( $i = 0; $i < 1000; $i++ )
			{
				$new = ( $i &1 ) ? $pass : $bin;
				if ( $i % 3 ) $new .= $saltt;
				if ( $i % 7 ) $new .= $pass;
				$new .= ( $i &1 ) ? $bin : $pass;
				$bin = pack( "H32", md5( $new ) );
			}
			for ( $i = 0; $i < 5; $i++ )
			{
				$k = $i + 6;
				$j = $i + 12;
				if ( $j == 16 ) $j = 5;
				$tmp = $bin[$i] . $bin[$k] . $bin[$j] . $tmp;
			}
			$tmp = chr( 0 ) . chr( 0 ) . $bin[11] . $tmp;
			$tmp = strtr( strrev( substr( base64_encode( $tmp ), 2 ) ), "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/", "./0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz" );
			$hash = $user . ':$apr1$' . $saltt . '$' . $tmp;
			break;
	}

	return $hash;
}



/**
* aa_pp_run_tests()
 *
 * @return
 */
function aa_pp_run_tests()
{
	global $wpdb, $wp_version, $aa_PP, $aa_SIDS;
	require_once ( dirname( __FILE__ ) . '/class-askapache-net.php' );

	$ap = array();
	$ap = $aa_PP;

	$home = get_option( 'siteurl' );
	$hu = str_replace( $ap['scheme'] . '://', '', $home );
	$uri = $ap['scheme'] . '://' . rtrim( str_replace( rtrim( $ap['root_path'], '/' ), '', $hu ), '/' );
	$test_root_path = $ap['root_path'] . 'wp-content/' . basename( $ap['test_dir'] ) . '/';
	$test_url_base = $uri . $test_root_path;
	$home_path = rtrim( get_home_path(), '/' ) . '/';
	$basic_authuserfile = $ap['test_dir'] . '/.htpasswd-basic';
	$digest_authuserfile = $ap['test_dir'] . '/.htpasswd-digest';

	$img = pack( "H*", "47494638396101000100910000000000ffffffffffff00000021f90405140002002c00000000010001000002025401003b" );
	$aok = '<strong style="color:#319F52;background-color:#319F52;">[  ]</strong> ';
	$fail = '<strong style="color:#CC0000;background-color:#CC0000;">[  ]</strong> ';
	$info = '<strong style="color:#9999DD;background-color:#9999DD;">[  ]</strong> ';
	$warn = '<strong style="color:#E6DB55;background-color:#E6DB55;">[  ]</strong> ';
	$m_s = '<h4 style="font-weight:normal">';
	$m_e = '</h4>';

	$test_htaccess_rules = array( 
		"ErrorDocument 401 {$test_root_path}test.gif",
		"ErrorDocument 403 {$test_root_path}test.gif",
		"ErrorDocument 404 {$test_root_path}test.gif",
		"ErrorDocument 500 {$test_root_path}test.gif",

		"<IfModule mod_alias.c>",
		'RedirectMatch 305 ^.*modaliastest$ ' . $home,
		"</IfModule>",

		"<IfModule mod_rewrite.c>",
		"RewriteEngine On",
		"RewriteBase /",
		'RewriteCond %{QUERY_STRING} modrewritetest [NC]',
		'RewriteRule .* ' . $home . ' [R=307,L]',
		"</IfModule>",

		'<Files modsec_check.gif>',
		"<IfModule mod_security.c>",
		'SetEnv MODSEC_ENABLE On',
		"SecFilterEngine On",
		'SecFilterDefaultAction "nolog,noauditlog,pass"',
		'SecAuditEngine Off',
		'SecFilterInheritance Off',
		'SecFilter modsecuritytest "deny,nolog,noauditlog,status:503"',
		'Deny from All',
		"</IfModule>",
		'</Files>',

		'<Files basic_auth_test.gif>',
		"AuthType Basic",
		'AuthName "askapache test"',
		"AuthUserFile " . $basic_authuserfile,
		"Require valid-user",
		'</Files>',

		'<Files digest_check.gif>',
		'AuthType Digest',
		'AuthName "askapache test"',
		"AuthDigestDomain {$test_root_path} {$test_url_base}",
		"AuthUserFile " . $digest_authuserfile,
		'Require none',
		'</Files>',

		'<Files authuserfile_test.gif>',
		'AuthType Digest',
		'AuthName "askapache test"',
		"AuthDigestDomain {$test_root_path} {$test_url_base}",
		"AuthUserFile " . $digest_authuserfile,
		'Require valid-user',
		'</Files>',

		'<Files authdigestfile_test.gif>',
		'AuthType Digest',
		'AuthName "askapache test"',
		"AuthDigestDomain {$test_root_path} {$test_url_base}",
		"AuthDigestFile " . $digest_authuserfile,
		'Require valid-user',
		'</Files>'
		);
		
		?>
<div class="wrap" style="max-width:95%;">
<h2>Test Results</h2>

<br /><br /><h2 style="font-size:16px;">Required Checks</h2>
<p>The tests performed by this page are currently required to determine your servers capabilities to make sure we don't crash your server.  The utmost care was taken to make these tests work for everyone running Apache, which is crazy hard because we are testing server configuration settings programmatically from a php binary without access to server configuration settings.</p>
<p>So we achieve this by modifying your server's .htaccess configuration file and then making special HTTP requests to your server which result in specific HTTP responses which tell us if the configuration changes failed or succeeded.  The most widely allowed (by web hosts) and compatible 4+5 php function that provides access to sockets is fsockopen, so it is required.  The next version will fallback to curl, but if your web host has disabled fsockopen you can bet you don't have curl.</p>
<?php
	$netok = $atest = ( aa_pp_checkfunction( 'fsockopen' ) ) ? 1 : 0;
	$msg = ( $atest ) ? $aok : $fail;
	echo $m_s . $msg . " Fsockopen Networking Functionality" . $m_e;?>


<br /><br /><h2 style="font-size:16px;">File Permission Tests</h2>
<p>If any of these checks fail this plugin will not work.  Both your /.htaccess and /wp-admin/.htaccess files must be writable for this plugin, those are the only 2 files this plugin absolutely must be able to modify.  If any of the other checks fail you will need to manually create a folder named askapache in your /wp-content/ folder and make it writable.</p>
<?php
	$htaccess_test1 = $atest = ( @is_writable( $ap['admin_htaccess'] ) || @touch( $ap['admin_htaccess'] ) ) ? 1 : 0;
	$msg = ( $atest ) ? $aok : $fail;
	echo $m_s . $msg . " /wp-admin/.htaccess file writable" . $m_e;

	$htaccess_test2 = $atest = ( @is_writable( $ap['root_htaccess'] ) || @touch( $ap['root_htaccess'] ) ) ? 1 : 0;
	$msg = ( $atest ) ? $aok : $fail;
	echo $m_s . $msg . " /wp-admin/.htaccess file writable" . $m_e;

	$atest = ( @is_writable( dirname( dirname( $ap['root_htaccess'] ) ) . '/.htpasswda3' ) || @touch( dirname( dirname( $ap['root_htaccess'] ) ) . '/.htpasswda3' ) ) ? 1 : 0;
	$msg = ( $atest ) ? $aok : $fail;
	echo $m_s . $msg . dirname( dirname( $ap['root_htaccess'] ) ) . '/.htpasswda3' . " file writable" . $m_e;

	if ( !$atest )
	{
		$atest = ( @is_writable( $ap['authuserfile'] ) || @touch( $ap['authuserfile'] ) ) ? 1 : 0;
		$msg = ( $atest ) ? $aok : $fail;
		echo $m_s . $msg . $ap['authuserfile'] . " file writable" . $m_e;
	}
	else $ap['authuserfile'] = dirname( dirname( $ap['root_htaccess'] ) ) . '/.htpasswda3';


	$atest = ( aa_pp_mkdir( $ap['test_dir'] ) ) ? 1 : 0;
	$msg = ( $atest ) ? $aok : $fail;
	echo $m_s . $msg . " Creating test folder" . $m_e;
	if( (bool)$atest ===false ) wp_die("Couldnt create test folder {$ap['test_dir']}!");

	$atest = ( @is_writable( $ap['test_dir'] ) || @chmod( $ap['test_dir'], 766 ) ) ? 1 : 0;
	$msg = ( $atest ) ? $aok : $fail;
	echo $m_s . $msg . " Test folder writable" . $m_e;

	$atest = ( aa_pp_insert_mark( $ap['test_dir'] . '/.htpasswd-basic', 'AskApache PassPro', array() ) ) ? 1 : 0;
	$msg = ( $atest ) ? $aok : $fail;
	echo $m_s . $msg . " Basic Auth htpasswd file writable" . $m_e;

	$msg = ( $atest ) ? $aok : $fail;
	$atest = ( aa_pp_insert_mark( $ap['test_dir'] . '/.htpasswd-digest', 'AskApache PassPro', array() ) ) ? 1 : 0;
	echo $m_s . $msg . " Digest Auth htpasswd file writable" . $m_e;

	aa_pp_htaccess_file_init( $ap['test_dir'] . '/.htaccess' );
	$atest = ( aa_pp_insert_sids( $ap['test_dir'] . '/.htaccess', 'Test', $test_htaccess_rules ) ) ? 1 : 0;
	echo $m_s . $msg . " .htaccess test file writable" . $m_e;?>



<br /><br /><h2 style="font-size:16px;">Encryption Function Tests</h2>
<p>Your php installation should have all of these.  The md5 is the only one absolutely required, otherwise I can't create the neccessary password files for you.</p>
<?php
	$ap['crypt_support'] = $atest = ( aa_pp_checkfunction( 'crypt' ) ) ? 1 : 0;
	$msg = ( $atest ) ? $aok : $warn;
	echo $m_s . $msg . " CRYPT Encryption Function Available" . $m_e;

	$ap['md5_support'] = $atest = ( aa_pp_checkfunction( 'md5' ) ) ? 1 : 0;
	$msg = ( $atest ) ? $aok : $fail;
	echo $m_s . $msg . " MD5 Encryption Function Available" . $m_e;

	$ap['sha1_support'] = $atest = ( aa_pp_checkfunction( 'sha1' ) ) ? 1 : 0;
	$msg = ( $atest ) ? $aok : $warn;
	echo $m_s . $msg . " SHA1 Encryption Function Available" . $m_e;

	$atest = ( aa_pp_checkfunction( 'pack' ) ) ? 1 : 0;
	$msg = ( $atest ) ? $aok : $warn;
	echo $m_s . $msg . " pack Function Available" . $m_e;

	$atest = ( aa_pp_checkfunction( 'md5_file' ) ) ? 1 : 0;
	$msg = ( $atest ) ? $aok : $warn;
	echo $m_s . $msg . " md5_file Function Available" . $m_e;?>




<br /><br /><h2 style="font-size:16px;">Revision Tests</h2>
<p>This checks for the neccessary file permissions and functions needed to utilize the .htaccess file revision support.</p>
<?php

	$atest = ( aa_pp_checkfunction( 'base64_encode' ) && aa_pp_checkfunction( 'base64_decode' ) ) ? 1 : 0;
	$msg = ( $atest ) ? $aok : $warn;
	echo $m_s . $msg . " base64_encode/base64_decode Functions Available" . $m_e;

	$ap['gzip_support'] = $atest = ( aa_pp_checkfunction( 'gzuncompress' ) && aa_pp_checkfunction( 'gzcompress' ) ) ? 1 : 0;
	$msg = ( $atest ) ? $aok : $warn;
	echo $m_s . $msg . " gzuncompress/gzcompress Functions Available" . $m_e;

	if ( $atest )
	{
		$data = aa_pp_readfile( $ap['test_dir'] . '/.htaccess' );
		$data_md5 = md5_file( $ap['test_dir'] . '/.htaccess' );

		$data_compress = base64_encode( gzcompress( $data, 9 ) );
		aa_pp_file_put_c( $ap['test_dir'] . '/.htaccess-compress', $data_compress );

		$data_decompress = gzuncompress( base64_decode( aa_pp_readfile( $ap['test_dir'] . '/.htaccess-compress' ) ) );
		aa_pp_file_put_c( $ap['test_dir'] . '/.htaccess-decompress', $data_decompress );

		$data_decompress_md5 = md5_file( $ap['test_dir'] . '/.htaccess-decompress' );

		$atest = ( $data_decompress_md5 == $data_md5 ) ? 1 : 0;
		$msg = ( $atest ) ? $aok : $fail;
		echo $m_s . $msg . " Revisions Enabled" . $m_e;
		echo "<p>Decompressed MD5: " . $data_decompress_md5 . "<br />Compressed MD5: " . $data_md5 . "</p>";
	}

	?>


<br /><br /><h2 style="font-size:16px;">.htaccess Capabilities</h2>
<p>These tests determine with a high degree of accuracy whether or not your server is able to handle .htaccess files, and also checks for various Apache modules that extend the functionality of this plugin.  The 2 modules you really want to have are mod_rewrite and mod_auth_digest.  In future versions of this plugin, we will be utilizing the advanced security features of mod_security more and more, so if you don't have it, bug your web host about it non-stop ;)</p>
<?php
	$atest = (  aa_pp_file_put_c( $ap['test_dir'] . "/test.gif", $img ) 
				&& aa_pp_file_put_c( $ap['test_dir'] . "/basic_auth_test.gif", $img ) 
				&& aa_pp_file_put_c( $ap['test_dir'] . "/authuserfile_test.gif", $img ) 
				&& aa_pp_file_put_c( $ap['test_dir'] . "/authdigestfile_test.gif", $img ) 
				&& aa_pp_file_put_c( $ap['test_dir'] . "/modsec_check.gif", $img ) 
				&& aa_pp_file_put_c( $ap['test_dir'] . "/digest_check.gif", $img )  ) ? 1 : 0;
	$msg = ( $atest ) ? $aok : $fail;
	echo $m_s . $msg . " Creating .htaccess test files" . $m_e;
	

	if ( (bool)AA_PP_DEBUG === true ) {
		echo $m_s . $msg . " Test .htaccess Contents" . $m_e;
		echo '<pre style="padding:5px;width:auto;border:1px dotted #CCC;">';
		foreach ( $test_htaccess_rules as $l )
			echo htmlentities($l)."\n";
		echo '</pre>';
	}
	
	$tester = new AskApacheNet;
	$ap['htaccess_support'] = $atest = ( $tester->sockit( "{$test_url_base}test.gif" ) == 200 ) ? 1 : 0;
	$msg = ( $atest ) ? $aok : $fail;
	echo $m_s . $msg . " .htaccess files allowed [200]" . $m_e;
	if ( (bool)AA_PP_DEBUG === true || !$atest )$tester->print_tcp_trace();

	$tester = new AskApacheNet;
	$ap['mod_alias_support'] = $atest = ( $tester->sockit( "{$test_url_base}modaliastest" ) == 305 ) ? 1 : 0;
	$msg = ( $atest ) ? $aok : $warn;
	echo $m_s . $msg . " mod_alias detection [305]" . $m_e;
	if ( (bool)AA_PP_DEBUG === true || !$atest )$tester->print_tcp_trace();

	$tester = new AskApacheNet;
	$ap['mod_rewrite_support'] = $atest = ( $tester->sockit( "{$test_url_base}test.gif?modrewritetest=1" ) == 307 ) ? 1 : 0;
	$msg = ( $atest ) ? $aok : $warn;
	echo $m_s . $msg . " mod_rewrite detection [307]" . $m_e;
	if ( (bool)AA_PP_DEBUG === true || !$atest )$tester->print_tcp_trace();

	$tester = new AskApacheNet;
	$ap['mod_security_support'] = $atest = ( $tester->sockit( "{$test_url_base}modsec_check.gif?modsecuritytest" ) != 200 ) ? 1 : 0;
	$msg = ( $atest ) ? $aok : $warn;
	echo $m_s . $msg . " mod_security detection [!200]" . $m_e;
	if ( (bool)AA_PP_DEBUG === true || !$atest )$tester->print_tcp_trace();

	$tester = new AskApacheNet;
	$ap['mod_auth_digest_support'] = $atest = ( $tester->sockit( "{$test_url_base}digest_check.gif" ) == 401 ) ? 1 : 0;
	$msg = ( $atest ) ? $aok : $warn;
	echo $m_s . $msg . " mod_auth_digest detection [401]" . $m_e;
	if ( (bool)AA_PP_DEBUG === true || !$atest )$tester->print_tcp_trace();

?>



<br /><br /><h2 style="font-size:16px;">HTTP Digest Authentication</h2>
<p>Now we know the encryption and apache module capabilities of your site.  This test literally logs in to your server using Digest Authenticationts, providing the ultimate answer as to if your server supports this scheme.</p>
<?php
	if ( $ap['mod_auth_digest_support'] != 0 && $ap['md5_support'] != 0 )
	{
		$digest_htpasswds = array();
		$digest_htpasswds[] = aa_pp_hashit( 'DIGEST', "testDIGEST", "testDIGEST", "askapache test" );
		$atest = ( aa_pp_insert_mark( $digest_authuserfile, 'AskApache PassPro Test', $digest_htpasswds ) ) ? 1 : 0;
		$msg = ( $atest ) ? $aok : $fail;
		echo $m_s . $msg . " Creating Digest htpasswd test file" . $m_e;

		$tester = new AskApacheNet;
		$tester->authtype = '';
		$rb = ( $tester->sockit( $test_url_base . 'authdigestfile_test.gif' ) == 401 ) ? 1 : 0;
		
		$tester->sockit( str_replace( '://', '://testDIGEST:testDIGEST@', $test_url_base ) . 'authdigestfile_test.gif' );
		$tester->authtype = 'Digest';
		$rg = ( $tester->sockit( str_replace( '://', '://testDIGEST:testDIGEST@', $test_url_base ) . 'authdigestfile_test.gif' ) == 200 ) ? 1 : 0;

		$ap['digest_support'] = $atest = ( $rb && $rg ) ? 1 : 0;
		$msg = ( $atest ) ? $aok : $fail;
		echo $m_s . $msg . " Digest Authentication Attempt" . $m_e;
		if ( (bool)AA_PP_DEBUG === true || !$atest )$tester->print_tcp_trace();
		
		if ( !$atest )
		{
			$tester = new AskApacheNet;
			$tester->authtype = '';
			$rb = ( $tester->sockit( $test_url_base . 'authuserfile_test.gif' ) == 401 ) ? 1 : 0;
			
			$tester->sockit( str_replace( '://', '://testDIGEST:testDIGEST@', $test_url_base ) . 'authuserfile_test.gif' );
			$tester->authtype = 'Digest';
			$rg = ( $tester->sockit( str_replace( '://', '://testDIGEST:testDIGEST@', $test_url_base ) . 'authuserfile_test.gif' ) == 200 ) ? 1 : 0;
			
			$ap['digest_support'] = $a1test = ( $rb && $rg ) ? 1 : 0;
			$msg = ( $a1test ) ? $aok : $fail;
			echo $m_s . $msg . "2nd Digest Authentication Attempt" . $m_e;
			if ( (bool)AA_PP_DEBUG === true || !$a1test )$tester->print_tcp_trace();
		}
		
		if ( (bool)$ap['digest_support'] !== false ) $ap['authuserdigest'] = ( $atest ) ? 'AuthDigestFile' : 'AuthUserFile';
	}
	else echo $m_s . $msg . $fail . " Bummer... you don't have digest capabilities." . $m_e;?>


<br /><br /><h2 style="font-size:16px;">Basic Authentication Encryption Algorithms</h2>
<p>Basic Authentication uses the .htpasswd file to store your encrypted password.  These checks perform actual logins to your server using a different .htpasswd encryption each time.</p>
<?php
	$basic_htpasswds = array();
	if ( $ap['crypt_support'] != 0 ) $basic_htpasswds[] = aa_pp_hashit( 'CRYPT', 'testCRYPT', 'testCRYPT' );
	if ( $ap['md5_support'] != 0 ) $basic_htpasswds[] = aa_pp_hashit( 'MD5', 'testMD5', 'testMD5' );
	if ( $ap['sha1_support'] != 0 ) $basic_htpasswds[] = aa_pp_hashit( 'SHA1', 'testSHA1', 'testSHA1' );

	$atest = ( aa_pp_insert_mark( $basic_authuserfile, 'AskApache PassPro Test', $basic_htpasswds ) ) ? 1 : 0;
	$msg = ( $atest ) ? $aok : $fail;
	echo $m_s . $msg . " Creating Basic htpasswd test file" . $m_e;

	$tester = new AskApacheNet;
	$rb = ( $tester->sockit( $test_url_base . 'basic_auth_test.gif' ) == 401 ) ? 1 : 0;

	if ( $ap['crypt_support'] != 0 )
	{
		$tester = new AskApacheNet;
		$rg = ( $tester->sockit( str_replace( '://', '://testCRYPT:testCRYPT@', $test_url_base ) . 'basic_auth_test.gif' ) == 200 ) ? 1 : 0;
		$ap['crypt_support'] = $atest = ( $rb && $rg ) ? 1 : 0;
		$msg = ( $atest ) ? $aok : $fail;
		echo $m_s . $msg . " Basic Authentication Attempt using Crypt Encryption" . $m_e;
		if ( (bool)AA_PP_DEBUG === true || !$atest )$tester->print_tcp_trace();
	}

	if ( $ap['md5_support'] != 0 )
	{
		$tester = new AskApacheNet;
		$rg = ( $tester->sockit( str_replace( '://', '://testMD5:testMD5@', $test_url_base ) . 'basic_auth_test.gif' ) == 200 ) ? 1 : 0;
		$ap['md5_support'] = $atest = ( $rb && $rg ) ? 1 : 0;
		$msg = ( $atest ) ? $aok : $fail;
		echo $m_s . $msg . " Basic Authentication Attempt using MD5 Encryption" . $m_e;
		if ( (bool)AA_PP_DEBUG === true || !$atest )$tester->print_tcp_trace();
	}

	if ( $ap['sha1_support'] != 0 )
	{
		$tester = new AskApacheNet;
		$rg = ( $tester->sockit( str_replace( '://', '://testSHA1:testSHA1@', $test_url_base ) . 'basic_auth_test.gif' ) == 200 ) ? 1 : 0;
		$ap['sha1_support'] = $atest = ( $rb && $rg ) ? 1 : 0;
		$msg = ( $atest ) ? $aok : $fail;
		echo $m_s . $msg . " Basic Authentication Attempt using SHA1 Encryption" . $m_e;
		if ( (bool)AA_PP_DEBUG === true || !$atest )$tester->print_tcp_trace();
	}

	$ap['basic_support'] = $atest = ( $ap['sha1_support'] != 0 || $ap['md5_support'] != 0 || $ap['crypt_support'] != 0 ) ? 1 : 0;
	$msg = ( $atest ) ? $aok : $warn;
	echo $m_s . $msg . " Basic Authentication Access Scheme Supported" . $m_e;?>


<br /><h2 style="font-size:16px;">Compatibility Checks</h2>
<p>Checks different software to make sure its compatible with this plugin.</p>
<?php
	$msg = ( $wp_version < 2.6 ) ? $info : $aok;
	echo $m_s . $msg . " WordPress Version " . $wp_version . $m_e;

	$ap['apache_version'] = $apache_version = preg_replace( '|Apache/?([0-9.-]*?) (.*)|i', '\\1', $_SERVER['SERVER_SOFTWARE'] );
	$msg = ( strlen( $apache_version ) == 0 ) ? $info : $aok;
	echo $m_s . $msg . " Apache Version:  " . $apache_version . $m_e;

	$msg = ( @version_compare( phpversion(), '4.2.0', '=<' ) ) ? $info : $aok;
	echo $m_s . $msg . " PHP Version " . phpversion() . $m_e;?>


<br /><br /><h2 style="font-size:16px;">PHP.ini Information</h2>
<p>Some information about your php.ini settings.  The following settings <strong>may</strong> need to be tweaked.  Likely they are fine.</p>
<?php

	$time = abs( intval( @ini_get( "max_execution_time" ) ) );
	echo $m_s . $info . " Max Execution Time: " . $time . $m_e;

	$memm = 10;
	if ( function_exists( "memory_get_peak_usage" ) )$memm = memory_get_peak_usage( true );
	else if ( function_exists( "memory_get_usage" ) )$memm = memory_get_usage( true );
	echo $m_s . $info . "Memory Usage: " . round( $memm / 1024 / 1024, 2 ) . $m_e;

	$mem = abs( intval( @ini_get( 'memory_limit' ) ) );
	echo $m_s . $info . 'Memory Limit: ' . "{$mem}" . $m_e;
	if ( $mem && $mem < abs( intval( 32 ) ) )@ini_set( 'memory_limit', 64 );

	$phpini = @get_cfg_var( 'cfg_file_path' );
	echo $m_s . $info . "php.ini " . $phpini . $m_e;

	$open_basedir = @ini_get( 'open_basedir' );
	$msg = ( empty( $open_basedir ) ) ? $info : $warn;
	echo $m_s . $msg . " open_basedir on/off {$open_basedir}" . $m_e;

	$safe_mode = @ini_get( 'safe_mode' );
	$msg = ( empty( $safe_mode ) ) ? $info : $warn;
	echo $m_s . $msg . " safe_mode on/off {$safe_mode}" . $m_e;

	$disabled_functions = @ini_get( 'disable_functions' );
	$msg = ( empty( $disabled_functions ) ) ? $info : $warn;
	echo $m_s . $msg . " disable_functions {$disabled_functions}" . $m_e;

	foreach( array( 'htaccess_support', 'mod_alias_support', 'mod_rewrite_support', 'mod_security_support', 'mod_auth_digest_support', 'digest_support', 'basic_support' ) as $k )
	{
		if ( $aa_PP[$k] == 1 && $ap[$k] != 1 )
		{
			aa_pp_notify( __FUNCTION__ . ":" . __LINE__ . ' ' . "You preset {$k} to on even though it failed the test." );
			$ap[$k] = 1;
		}
	}

	$aa_PP = $ap;
	update_option( 'askapache_password_protect', $aa_PP );

	echo '<br class="clear" /><form action="options-general.php?page=askapache-password-protect.php" method="post">';
	wp_nonce_field( 'askapache-passpro-form' );
	if ( !$htaccess_test1 || !$htaccess_test2 || !$netok || $aa_PP['htaccess_support'] != 1 )
	{
		echo '<p>Im very sorry, but unless you can resolve the failed requirements above you cannot utilize this plugin at this time. :( </p>';
		echo '<p>Change the AA_PP_DEBUG to 1 in the source code of this plugin for verbose reasons why these tests failed.</p>';
		echo '<input type="hidden" id="a_step" name="a_step" value="test" />';
		echo '<p class="submit"><input name="sub" type="submit" id="sub" value="Run Tests Again &raquo;" /></p>';
	}
	else
	{
		echo '<input type="hidden" id="a_step" name="a_step" value="setup" />';
		echo '<p class="submit"><input name="sub" type="submit" id="sub" value="Continue to Setup &raquo;" /></p>';
	}
	echo '</form><br class="clear" /><br class="clear" /><br class="clear" />';
	echo '</div>';
	
	sleep(1);
	foreach ( array( '.htaccess', '.htaccess-compress', '.htaccess-decompress', '.htpasswd-basic', '.htpasswd-digest', 'basic_auth_test.gif', 'authuserfile_test.gif', 'authdigestfile_test.gif', 'digest_check.gif', 'modsec_check.gif', 'test.gif' ) as $f )
		aa_pp_unlink( $aa_PP['test_dir'] . '/' . $f );
		
	@rmdir( $aa_PP['test_dir'] );
}





/**
* aa_pp_list_files()
 *
 * @param mixed $dir
 * @return
 */
function aa_pp_list_files( $dir )
{
	$files = array();
	if ( is_dir( $dir ) && !is_link( $dir ) )
	{
		$d = dir( $dir );
		while ( false !== ( $r = $d->read() ) )
		{
			if ( strpos( $r, '.htaccess-' ) === false )continue;
			else $files[] = $r;
		}
		$d->close();
		ksort( $files );
	}
	return $files;
}


/**
* aa_pp_mkdir()
 *
 * @param mixed $dirname
 * @return
 */
function aa_pp_mkdir( $dir )
{
	@umask( 0 );
	$dirname = ( @is_readable( $dir ) ) ? realpath( rtrim( $dir, '/' ) ) : rtrim( $dir, '/' );
	$dirname = str_replace( '//', '/', $dirname );
	aa_pp_notify( __FUNCTION__ . ":" . __LINE__ . ' ' . "Creating directory {$dirname}" );

	if ( is_dir( $dirname ) || @wp_mkdir_p( $dirname ) ) return $dirname;
	elseif ( is_writable( $dirname ) && @wp_mkdir_p( $dirname ) ) return $dirname;
	else return( @mkdir( $dirname, 0777 ) ) ? $dirname : new WP_Error( 'mkdir-failed', __( "Failed to create directory {$dirname}" ) );
}



/**
* aa_pp_unlink()
 *
 * @param mixed $f
 * @param mixed $backup
 * @return
 */
function aa_pp_unlink( $f, $backup = false )
{
	@umask( 0 );
	$f = ( @is_readable( $f ) ) ? realpath( rtrim( $f, '/' ) ) : rtrim( $f, '/' );
	$f = str_replace( '//', '/', $f );

	if ( !@file_exists( $f ) ) return true;
	if ( $backup ) $backedup = aa_pp_backup( $f, $f . '-' . time() );

	aa_pp_notify( __FUNCTION__ . ":" . __LINE__ . ' ' . "Deleted {$f}" );

	if ( is_dir( $f ) ) return aa_pp_rmdir( $f );
	else @unlink( $f );

	if ( !@file_exists( $f ) ) return true;
	return( @chmod( $f, 0777 ) && @unlink( $f ) ) ? true : ( @chmod( dirname( $f ), 0777 ) && @unlink( $f ) ) ? true : new WP_Error( 'delete-failed', __( "Failed to delete {$f} in aa_pp_unlink" ) );
}



/**
* aa_pp_backup()
 *
 * @param mixed $f
 * @param mixed $bf
 * @return
 */
function aa_pp_backup( $f, $bf = 0 )
{
	if ( !$bf || $f == $bf )$bf = dirname( $f ) . '/' . basename( $f ) . '.AABK-' . time();

	aa_pp_notify( __FUNCTION__ . ":" . __LINE__ . ' ' . "Backing up {$f} to {$bf}" );

	if ( !@copy( $f, $bf ) ) aa_pp_notify( __FUNCTION__ . ":" . __LINE__ . ' ' . "Failed to backup {$f} to {$bf} using copy" );
	elseif ( !@rename( $f, $bf ) ) return new WP_Error( 'rename-failed', __( "Couldnt rename {$f} to {$bf}" ) );
	else return $bf;
}



/**
* aa_pp_bytes()
 *
 * @param mixed $bytes
 * @return
 */
function aa_pp_bytes( $bytes )
{
	$s = array( 'B', 'Kb', 'MB', 'GB', 'TB', 'PB' );
	$e = floor( log( $bytes ) / log( 1024 ) );

	return sprintf( '%.2f ' . $s[$e], ( $bytes / pow( 1024, floor( $e ) ) ) ) . "<br /> {$bytes} B";
}



/**
* aa_pp_file_put_c()
 *
 * @param mixed $file
 * @param mixed $content
 * @param mixed $backup
 * @return
 */
function aa_pp_file_put_c( $file, $content, $backup = false )
{
	@umask( 0 );
	$f = ( @is_readable( $file ) ) ? realpath( rtrim( $file, '/' ) ) : rtrim( $file, '/' );
	aa_pp_notify( __FUNCTION__ . ":" . __LINE__ . ' ' . "Creating {$f}" );
	if ( !is_dir( dirname( $f ) ) ) aa_pp_mkdir( dirname( $f ) );

	if ( file_exists( $f ) && is_readable( $f ) && $backup ) $backedup = aa_pp_backup( $f );

	if ( aa_pp_checkfunction( "file_put_contents" ) ) return @file_put_contents( $f, $content );

	if ( !$fh = @fopen( $f, 'wb' ) ) return new WP_Error( 'fopen-failed', __( "Couldnt fopen {$f}" ) );
	if ( !@fwrite( $fh, $content, strlen( $content ) ) ) return new WP_Error( 'fwrite-failed', __( "Couldnt fwrite {$f}" ) );
	if ( !@fclose( $fh ) ) return new WP_Error( 'fclose-failed', __( "Couldnt fclose {$f}" ) );

	return true;
}



/**
* aa_pp_readfile()
 *
 * @param mixed $file
 * @return
 */
function aa_pp_readfile( $file )
{
	@umask( 0 );
	$f = ( @is_readable( $file ) ) ? realpath( rtrim( $file, '/' ) ) : rtrim( $file, '/' );
	aa_pp_notify( __FUNCTION__ . ":" . __LINE__ . ' ' . "Reading {$f}" );

	if ( !$fh = @fopen( $f, 'rb' ) ) return new WP_Error( 'fopen-failed', __( "Couldnt fopen {$f}" ) );
	if ( !$filecontent = @fread( $fh, @filesize( $f ) ) ) return new WP_Error( 'fread-failed', __( "Couldnt fread {$f}" ) );
	if ( !@fclose( $fh ) ) return new WP_Error( 'fclose-failed', __( "Couldnt fclose {$f}" ) );

	return $filecontent;
}






/**
* aa_pp_sid_info()
 *
 * @param mixed $sid
 * @return
 */
function aa_pp_sid_info( $sid )
{
	$sid = ( string )$sid;

	$types = array( 
		1 => 'Protection',
		2 => 'Password',
		3 => 'Anti-Spam',
		4 => 'WordPress Exploit',
		5 => 'General Exploit',
		6 => 'General'
		);

	$files = array( 0 => 'root',
		1 => 'wp-admin',
		2 => 'other'
		);

	$modules = array( 0 => 'core',
		1 => 'mod_rewrite',
		2 => 'mod_alias',
		3 => 'mod_security',
		4 => 'mod_setenv' );

	$response = array( 0 => 'none',
		1 => '503 Service Temporarily Unavailable',
		2 => '505 HTTP Version Not Supported',
		3 => '401 Authorization Required',
		4 => '403 Forbidden',
		5 => '405 Method Not Allowed'
		);

	return array( 'Type' => $types[$sid{0}], 'File' => $files[$sid{1}], 'Module' => $modules[$sid{2}], 'Response' => $response[$sid{3}] );
}



/**
* aa_pp_errors()
 *
 * @param mixed $message
 * @param string $title
 * @return
 */
function aa_pp_errors( $message, $title = '' )
{
	$class = 'id="message" class="updated fade"';
	if ( aa_pp_checkfunction( 'is_wp_error' ) && is_wp_error( $message ) )
	{
		$class = 'class="error"';

		if ( empty( $title ) )
		{
			$error_data = $message->get_error_data();
			if ( is_array( $error_data ) && isset( $error_data['title'] ) ) $title = $error_data['title'];
		}

		$errors = $message->get_error_messages();
		switch ( count( $errors ) )
		{
			case 0 :
				$g = '';
				break;
			case 1 :
				$g = "<p>{$errors[0]}</p>";
				break;
			default :
				$g = '<ul>';
				foreach( $errors as $mess )$g .= "<li>{$mess}</li>\n";
				$g .= '</ul>';
				break;
		}
	} elseif ( is_string( $message ) ) $g = "<p>{$message}</p>";
	if ( !empty( $g ) )echo "<br /><div {$class} style='max-width:95%;'>{$g}</div><br />";
}



/**
* aa_pp_checkfunction()
 *
 * @param mixed $func
 * @return
 */
function aa_pp_checkfunction( $func )
{
	return( !function_exists( $func ) || @in_array( $func, @explode( ',', @ini_get( 'disable_functions' ) ) ) ) ? aa_pp_debug( "{$func} disabled or not found" ) : true;
}






/**
* aa_pp_debug()
 *
 * @param string $message
 * @return
 */
function aa_pp_debug( $message = '' )
{
	@error_log( ltrim( "PHP AAPP Error: {$message}" ), 0 );
	return false;
}



/**
* aa_pp_notify()
 *
 * @param string $message
 * @return
 */
function aa_pp_notify( $message = '' )
{
	if ( (bool)AA_PP_DEBUG === true ) @error_log( ltrim( "PHP AAPP Info: {$message}" ), 0 );
}



/**
* wp_die()
*
* @param mixed $message
* @return
*/
if ( !function_exists( 'wp_die' ) ) :
function wp_die ( $message = 'wp_die' )
{
	die( $message );
}
endif;


?>
