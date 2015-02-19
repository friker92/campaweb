<?php
/*
Plugin Name: BulletProof Security
Plugin URI: http://forum.ait-pro.com/read-me-first/
Text Domain: bulletproof-security
Domain Path: /languages/
Description: Website Security Protection: BulletProof Security protects your website against 100,000's of different hacking attempts/attacks. Built-in .htaccess file Editor. Security Logging|HTTP Error Logging. Login Security|Login Monitoring: Log All Account Logins or Log Only Account Lockouts. DB Backup: Database Backup. Website FrontEnd|BackEnd Maintenance Mode. System Info: PHP|MySQL|OS|Server|Memory Usage|IP|SAPI|WP Filesystem API Method|DNS|Max Upload|Zend Engine Version|Zend Guard|Loader|Optimizer|ionCube Loader|Suhosin|APC|eAccelerator|XCache|Varnish|cURL|Memcache|Memcached...
Version: .51.6
Author: AITpro | Edward Alexander
Author URI: http://forum.ait-pro.com/read-me-first/
*/

/*  Copyright (C) 2010 Edward Alexander | AITpro.com

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

// BPS variables
define( 'BULLETPROOF_VERSION', '.51.6' );
$bps_last_version = '.51.5';
$bps_version = '.51.6';
$bps_readme_install_ver = '1';
$aitpro_bullet = '<img src="'.plugins_url('/bulletproof-security/admin/images/aitpro-bullet.png').'" style="padding:0px 3px 0px 3px;" />';

// Load BPS Global class - not doing anything with this Class in BPS Free
//require_once( WP_PLUGIN_DIR . '/bulletproof-security/includes/class.php' );

add_action( 'init', 'bulletproof_security_load_plugin_textdomain' );

// Load i18n Language Translation
function bulletproof_security_load_plugin_textdomain() {
	load_plugin_textdomain('bulletproof-security', FALSE, dirname(plugin_basename(__FILE__)).'/languages/');
}

// Load BPS functions.php
require_once( WP_PLUGIN_DIR . '/bulletproof-security/includes/functions.php' );
	remove_action('wp_head', 'wp_generator');
	
// BPS Login Security
require_once( WP_PLUGIN_DIR . '/bulletproof-security/includes/login-security.php' );

// BPS DB Backup
require_once( WP_PLUGIN_DIR . '/bulletproof-security/includes/db-security.php' );

// If in WP Admin Dashboard
if ( is_admin() ) {
    require_once( WP_PLUGIN_DIR . '/bulletproof-security/admin/includes/admin.php' );
	
	//$bps_complete_uninstallation = WP_PLUGIN_DIR . '/bulletproof-security/uninstall.php';
	
	register_activation_hook(__FILE__, 'bulletproof_security_install');
	register_deactivation_hook(__FILE__, 'bulletproof_security_deactivation');
    register_uninstall_hook(__FILE__, 'bulletproof_security_uninstall');
	//register_uninstall_hook(__FILE__, 'bulletproof_security_complete_uninstall');
	//register_uninstall_hook($bps_complete_uninstallation, $bps_uninstallation_callback);

	add_action( 'admin_init', 'bulletproof_security_admin_init' );
    add_action( 'admin_menu', 'bulletproof_security_admin_menu' );
}

// "Settings" link on Plugins Options Page 
function bps_plugin_actlinks( $links, $file ) {
static $this_plugin;
	if ( ! $this_plugin ) $this_plugin = plugin_basename(__FILE__);
	if ( $file == $this_plugin ) {
		$settings_link = '<a href="admin.php?page=bulletproof-security/admin/core/options.php" title="htaccess Core Setup Steps">'.__('Setup Steps', 'bulletproof-security').'</a>';
		array_unshift( $links, $settings_link );
	}
	return $links;
}
	add_filter( "plugin_action_links", 'bps_plugin_actlinks', 10, 2 );

// Add links on plugins page
function bps_plugin_extra_links($links, $file) {
static $this_plugin;
	if ( !current_user_can('install_plugins') )
		return $links;
	if ( ! $this_plugin ) $this_plugin = plugin_basename(__FILE__);
	if ( $file == $this_plugin ) {
		$links[] = '<a href="http://forum.ait-pro.com/forums/topic/plugin-conflicts-actively-blocked-plugins-plugin-compatibility/" title="BulletProof Security Forum" target="_blank">'.__('Forum - Support', 'bulleproof-security').'</a>';
		$links[] = '<a href="http://affiliates.ait-pro.com/po/" title="Upgrade to BPS Pro" target="_blank">'.__('Upgrade', 'bulleproof-security').'</a>';
		$links[] = '<a href="http://www.ait-pro.com/bulletproof-security-pro-flash/bulletproof.html" title="BulletProof Security Flash Movie" target="_blank">'.__('Flash Movie', 'bulleproof-security').'</a>';
	}
	return $links;
}
	add_filter('plugin_row_meta', 'bps_plugin_extra_links', 10, 2);
?>