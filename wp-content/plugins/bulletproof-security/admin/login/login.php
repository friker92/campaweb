<?php
// Direct calls to this file are Forbidden when core files are not present
if ( !current_user_can('manage_options') ) { 
		header('Status: 403 Forbidden');
		header('HTTP/1.1 403 Forbidden');
		exit();
}
?>

<div class="wrap" style="margin-top:45px;">

<?php
if ( function_exists('get_transient') ) {
require_once( ABSPATH . 'wp-admin/includes/plugin-install.php' );

	if ( false === ( $bps_api = get_transient('bulletproof-security_info') ) ) {
		$bps_api = plugins_api( 'plugin_information', array( 'slug' => stripslashes( 'bulletproof-security' ) ) );
		
	if ( !is_wp_error( $bps_api ) ) {
		$bps_expire = 60 * 30; // Cache downloads data for 30 minutes
		$bps_downloaded = array( 'downloaded' => $bps_api->downloaded );
		maybe_serialize( $bps_downloaded );
		set_transient( 'bulletproof-security_info', $bps_downloaded, $bps_expire );
	}
	}

		$bps_transient = get_transient( 'bulletproof-security_info' );
    	
		echo '<div class="bps-star-container" style="float:right;position:relative;top:-40px;left:0px;margin:0px 0px -40px 0px;font-weight:bold;">';
		echo '<div class="bps-star"><img src="'.plugins_url('/bulletproof-security/admin/images/star.png').'" /></div>';
		echo '<div class="bps-downloaded">';
		
		foreach ( $bps_transient as $key => $value ) {
			echo number_format_i18n( $value ) .' '. str_replace( 'downloaded', "Downloads", $key );
		}
		
		echo '<div class="bps-star-link"><a href="http://wordpress.org/support/view/plugin-reviews/bulletproof-security" target="_blank" title="Add your own BPS Plugin Review">'.__('Add a Review', 'bulletproof-security').'</a><br><a href="http://affiliates.ait-pro.com/po/" target="_blank" title="Upgrade to BulletProof Security Pro">Upgrade to Pro</a></div>';
		echo '</div>';
		echo '</div>';
}
?>

<h2 style="margin-left:70px;"><?php _e('BulletProof Security ~ Login Security & Monitoring', 'bulletproof-security'); ?></h2>
<div id="message" class="updated" style="border:1px solid #999999; margin-left:70px;background-color: #000;">

<?php
// HUD - Heads Up Display - Warnings and Error messages
echo bps_check_php_version_error();
echo bps_hud_check_bpsbackup();
echo bps_check_safemode();
echo @bps_w3tc_htaccess_check($plugin_var);
echo @bps_wpsc_htaccess_check($plugin_var);
bps_delete_language_files();

// General all purpose "Settings Saved." message for forms
if ( current_user_can('manage_options') && wp_script_is( 'bps-accordion', $list = 'queue' ) ) {
if ( @$_GET['settings-updated'] == true) {
	$text = '<p style="background-color:#ffffe0;font-size:1em;font-weight:bold;padding:5px;margin:0px;"><font color="green"><strong>'.__('Settings Saved', 'bulletproof-security').'</strong></font></p>';
	echo $text;
	}
}

$bpsSpacePop = '-------------------------------------------------------------';

// Replace ABSPATH = wp-content/plugins
$bps_plugin_dir = str_replace( ABSPATH, '', WP_PLUGIN_DIR );
// Replace ABSPATH = wp-content
$bps_wpcontent_dir = str_replace( ABSPATH, '', WP_CONTENT_DIR );
// Top div & bottom div echo
$bps_topDiv = '<div id="message" class="updated" style="background-color:#ffffe0;font-size:1em;font-weight:bold;border:1px solid #999999; margin-left:70px;"><p>';
$bps_bottomDiv = '</p></div>';

?>
</div>

<!-- jQuery UI Tab Menu -->
<div id="bps-container">
	<div id="bps-tabs" class="bps-menu">
    <div id="bpsHead" style="position:relative; top:0px; left:0px;"><img src="<?php echo plugins_url('/bulletproof-security/admin/images/bps-security-shield.png'); ?>" style="float:left; padding:0px 8px 0px 0px; margin:-72px 0px 0px 0px;" /></div>
		<ul>
			<li><a href="#bps-tabs-1"><?php _e('Login Security & Monitoring', 'bulletproof-security'); ?></a></li>
			<li><a href="#bps-tabs-2"><?php _e('Help &amp; FAQ', 'bulletproof-security'); ?></a></li>
		</ul>
            
<div id="bps-tabs-1" class="bps-tab-page">
<h2><?php _e('Login Security & Monitoring (LSM) ~ ', 'bulletproof-security'); ?><span style="font-size:.75em;"><?php _e('Log All Account Logins or Log Only Account Lockouts ~ Brute Force Login Protection', 'bulletproof-security'); ?></span></h2>

<?php
	$BPS_wpadmin_Options = get_option('bulletproof_security_options_htaccess_res');
	
	if ( $BPS_wpadmin_Options['bps_wpadmin_restriction'] == 'disabled' ) {
		$text = '<h3><strong><span style="font-size:1em;"><font color="blue">'.__('Notice: ', 'bulletproof-security').'</font></span><span style="font-size:.75em;">'.__('You have disabled wp-admin BulletProof Mode on the Security Modes page.', 'bulletproof-security').'<br>'.__('If you have Go Daddy "Managed WordPress Hosting" click this link: ', 'bulletproof-security').'<a href="http://forum.ait-pro.com/forums/topic/gdmw/" target="_blank" title="Link opens in a new Browser window">'.__('Go Daddy Managed WordPress Hosting', 'bulletproof-security').'</a>.</span></strong></h3>';
		echo $text;
	}
?>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="bps-help_faq_table">
  <tr>
    <td class="bps-table_title">&nbsp;</td>
  </tr>
  <tr>
    <td class="bps-table_cell_help" style="max-width:800px;">

<h3 style="margin:0px 0px 10px 0px;"><?php _e('Login Security & Monitoring', 'bulletproof-security'); ?>  <button id="bps-open-modal1" class="button bps-modal-button"><?php _e('Read Me', 'bulletproof-security'); ?></button></h3>

<div id="bps-modal-content1" title="<?php _e('Login Security & Monitoring', 'bulletproof-security'); ?>">
	<p><?php $text = '<strong>'.__('This Read Me Help window is draggable (top) and resizable (bottom right corner)', 'bulletproof-security').'</strong><br><br><strong>'.__('Click both Save Options buttons to save the best pre-selected Login Security settings or choose your own Login Security option settings.', 'bulletproof-security').'</strong><br><br><strong>'.__('What to do if your User Account is locked and you are unable to login to your website', 'bulletproof-security').'</strong><br>'.__('Use FTP or your web host control panel file manager and rename the /bulletproof-security plugin folder name to /_bulletproof-security. Log into your website. Rename the /_bulletproof-security plugin folder name back to /bulletproof-security. Go to the BPS Login Security page and unlock your User Account.', 'bulletproof-security').'<br><br><strong>'.__('NOTE: ', 'bulletproof-security').'</strong>'.__('Email Alerting and Log file options are located in S-Monitor in BPS Pro instead of being on the Login Security page, Security Log & DB Backup Log pages. The Email Alerting & Log File Options Form is identical on the Login Security, Security Log & DB Backup Log pages in BPS free. You can change and save your email alerting and log file options on any of these pages.', 'bulletproof-security').'<br><br><strong>'.__('Max Login Attempts: ', 'bulletproof-security').'</strong><br>'.__('Type in the maximum number of failed login attempts allowed before a User Account is automatically Locked out. After making any setting changes click the Save Options button to save your new option settings.', 'bulletproof-security').'<br><br><strong>'.__('NOTE: ', 'bulletproof-security').'</strong>'.__('The Max Login Attempts setting range is from 1 - 10. Minimum is 1 failed login attempt - Maximum is 10 failed login attempts. Setting this to 1 failed login attempt is NOT recommended. The default is 3 failed login attempts before locking the User Account.', 'bulletproof-security').'<br><br><strong>'.__('Automatic Lockout Time: ', 'bulletproof-security').'</strong><br>'.__('Type in the number of minutes that you would like the User Account to be locked out for when the maximum number of failed login attempts have been made. After making any setting changes click the Save Options button to save your new option settings.', 'bulletproof-security').'<br><br><strong>'.__('Manual Lockout Time: ', 'bulletproof-security').'</strong><br>'.__('Type in the number of minutes that you would like the User Account to be locked out for when you manually lock a User Account using Lock checkbox options in the Dynamic Login Security form. After making any setting changes click the Save Options button to save your new option settings.', 'bulletproof-security').'<br><br><strong>'.__('Max DB Rows To Show: ', 'bulletproof-security').'</strong><br>'.__('Type in the maximum number of database rows that you would like to display in the Dynamic Login Security form. Leaving this text box blank means display all database rows. After making any setting changes click the Save Options button to save your new option settings.', 'bulletproof-security').'<br><br><strong>'.__('Turn On|Turn Off: ', 'bulletproof-security').'</strong><br>'.__('Turn On Login Security or Turn Off Login Security or Turn Off Login Security and Use the Password Reset Option ONLY. The Turn Off Login Security|Use Password Reset Option ONLY setting means that all Login Security features are turned Off except for the Password Reset Option, which can be used independently by itself. After making any setting changes click the Save Options button to save your new option settings.', 'bulletproof-security').'<br><br><strong>'.__('Logging Options: ', 'bulletproof-security').'</strong><br>'.__('You can choose to Log All User Account Logins or Log Only User Account Lockouts. Recommended Setting: Log Only Account Lockouts.  After making any setting changes click the Save Options button to save your new option settings.', 'bulletproof-security').'<br><br><strong>'.__('Error Messages: ', 'bulletproof-security').'</strong><br><br><strong>'.__('Standard WP Login Errors: ', 'bulletproof-security').'</strong>'.__('will display the normal WP login errors. Example1: ERROR: The password you entered for the username X is incorrect. BPS Example2: ERROR: This user account has been locked until May 14, 2013 9:31 am due to too many failed login attempts. You can login again after the Lockout Time above has expired.', 'bulletproof-security').'<br><br><strong>'.__('User|Pass Invalid Entry Error: ', 'bulletproof-security').'</strong>'.__('will display a generic Invalid Entry error message instead of displaying normal WP login errors for incorrect username or incorrect password, but if a user account is locked out then the BPS timestamp and Lockout Time error message will be displayed. Example: ERROR: Invalid Entry for either incorrect username or incorrect password. BPS Example2: ERROR: This user account has been locked until May 14, 2013 9:31 am due to too many failed login attempts. You can login again after the Lockout Time above has expired.', 'bulletproof-security').'<br><br><strong>'.__('User|Pass|Lock Invalid Entry Error: ', 'bulletproof-security').'</strong>'.__('will display a generic Invalid Entry error message instead of displaying normal WP login errors for incorrect username, incorrect password and when the user account is locked out - the BPS Lockout Time error message will NOT be displayed. ', 'bulletproof-security').'<br><strong>'.__('CAUTION: ', 'bulletproof-security').'</strong>'.__('If the user account is locked out then no indication will be given that the user account is locked out and only a generic ERROR: Invalid Entry message will be displayed.', 'bulletproof-security').'<br><br><strong>'.__('Password Reset: ', 'bulletproof-security').'</strong><br>'.__('The Enable Password Reset option will allow the normal WP Lost Password link to be displayed and allow locked out users to reset their passwords. The Disable Password Reset Frontend Only option disables the WP Login reset password feature and displays this error message - Password reset is not allowed for this user. This error message is displayed for valid or invalid user accounts or email addresses. In other words, there is no indication of whether or not a valid username or email address is being entered. This of course disables a lot of cool WordPress login features, but if you want complete Login Stealth Mode then this is the option for you. Disable Password Reset Frontend & Backend disables password reset on the frontend and backend (WP Dashboard) of your website.', 'bulletproof-security').'<br><br><strong>'.__('Sort DB Rows: ', 'bulletproof-security').'</strong><br>'.__('The Ascending Show Oldest Login First option displays logins from the oldest logins to your site to the newest logins to your site. The Descending Show Newest Login First option displays logins from the newest logins to your site to the oldest logins to your site. Example usage: Enter 50 for the Max DB Rows To Show option, which will show a maximum of 50 database rows/logins to your site and set Sort DB Rows option to Descending Show Newest Login First. You will see the last 50 most current/newest logins to your site in descending order.', 'bulletproof-security').'<br><br><strong>'.__('Search feature: ', 'bulletproof-security').'</strong><br>'.__('The search feature allows you to search all of the Login Security database rows. To search for all Locked User accounts enter Locked, to search for a username enter that username, to search for an IP address enter that IP address, etc.', 'bulletproof-security').'<br><br><strong>'.__('The Dynamic Login Security Form: ', 'bulletproof-security').'</strong><br>'.__('You have 3 options: Lock, Unlock or Delete database rows. The Login Security database table is hooked into the WordPress Users database table, but they are 2 completely separate database tables. If you lock a User Account then BPS Pro will enforce that lock on that User Account and the User will not be able to log in. If you unlock a User Account then the User will be able to login. Deleting database rows in the Login Security database table does NOT delete the User Account from the WordPress Users database table. When you delete a User Account it is pretty much the same thing as unlocking a User Account. To delete actual User Accounts you would go to the WordPress Users page and delete that User Account.', 'bulletproof-security').'<br><br><strong>'.__('BPS Pro Video Tutorial links can be found in the Help & FAQ pages.', 'bulletproof-security').'</strong>'; echo $text; ?></p>
</div>

<?php if ( !current_user_can('manage_options') ) { _e('Permission Denied', 'bulletproof-security'); } else { ?>

<table width="900px" border="0">
  <tr>
    <td style="vertical-align:top;">
    
    <div id="LoginSecurityOptions" style="width:100%;">

<form name="LoginSecurityOptions" action="options.php" method="post">
	<?php settings_fields('bulletproof_security_options_login_security'); ?> 
	<?php $BPSoptions = get_option('bulletproof_security_options_login_security'); ?>
 
<table border="0">
  <tr>
    <td><label for="LSLog"><?php _e('Max Login Attempts:', 'bulletproof-security'); ?></label></td>
    <td><input type="text" name="bulletproof_security_options_login_security[bps_max_logins]" class="regular-text-50-fixed" value="<?php if ( $BPSoptions['bps_max_logins'] != '' ) { echo $BPSoptions['bps_max_logins']; } else { echo '3'; } ?>" /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><label for="LSLog"><?php _e('Automatic Lockout Time:', 'bulletproof-security'); ?></label></td>
    <td><input type="text" name="bulletproof_security_options_login_security[bps_lockout_duration]" class="regular-text-50-fixed" value="<?php if ( $BPSoptions['bps_lockout_duration'] != '' ) { echo $BPSoptions['bps_lockout_duration']; } else { echo '60'; } ?>" /></td>
    <td><label for="LSLog" style="margin:0px 0px 0px 5px;"><strong><?php _e('Minutes', 'bulletproof-security'); ?></strong></label></td>
  </tr>
  <tr>
    <td><label for="LSLog"><?php _e('Manual Lockout Time:', 'bulletproof-security'); ?></label></td>
    <td><input type="text" name="bulletproof_security_options_login_security[bps_manual_lockout_duration]" class="regular-text-50-fixed" value="<?php if ( $BPSoptions['bps_manual_lockout_duration'] != '' ) { echo $BPSoptions['bps_manual_lockout_duration']; } else { echo '60'; } ?>" /></td>
    <td><label for="LSLog" style="margin:0px 0px 0px 5px;"><strong><?php _e('Minutes', 'bulletproof-security'); ?></strong></label></td>
  </tr>
  <tr>
    <td><label for="LSLog"><?php _e('Max DB Rows To Show:', 'bulletproof-security'); ?></label></td>
    <td><input type="text" name="bulletproof_security_options_login_security[bps_max_db_rows_display]" class="regular-text-50-fixed" value="<?php if ( $BPSoptions['bps_max_db_rows_display'] != '' ) { echo $BPSoptions['bps_max_db_rows_display']; } else { echo ''; } ?>" /></td>
    <td><label for="LSLog" style="margin:0px 0px 0px 5px;"><strong><?php _e('Blank = Show All Rows', 'bulletproof-security'); ?></strong></label></td>
  </tr>
</table>
<br />

<table border="0">
  <tr>
    <td><label for="LSLog"><?php _e('Turn On|Turn Off:', 'bulletproof-security'); ?></label></td>
    <td><select name="bulletproof_security_options_login_security[bps_login_security_OnOff]" style="width:220px;">
<option value="On" <?php selected('On', $BPSoptions['bps_login_security_OnOff']); ?>><?php _e('Turn On Login Security', 'bulletproof-security'); ?></option>
<option value="Off" <?php selected('Off', $BPSoptions['bps_login_security_OnOff']); ?>><?php _e('Turn Off Login Security', 'bulletproof-security'); ?></option>
<option value="pwreset" <?php selected('pwreset', $BPSoptions['bps_login_security_OnOff']); ?>><?php _e('Turn Off Login Security|Use Password Reset Option ONLY', 'bulletproof-security'); ?></option>
</select>
	</td>
  </tr>
  <tr>
    <td><label for="LSLog"><?php _e('Logging Options:', 'bulletproof-security'); ?></label></td>
    <td><select name="bulletproof_security_options_login_security[bps_login_security_logging]" style="width:220px;">
<option value="logLockouts" <?php selected('logLockouts', $BPSoptions['bps_login_security_logging']); ?>><?php _e('Log Only Account Lockouts', 'bulletproof-security'); ?></option>
<option value="logAll" <?php selected('logAll', $BPSoptions['bps_login_security_logging']); ?>><?php _e('Log All Account Logins', 'bulletproof-security'); ?></option>
</select>
	</td>
  </tr>
  <tr>
    <td><label for="LSLog"><?php _e('Error Messages:', 'bulletproof-security'); ?></label></td>
    <td><select name="bulletproof_security_options_login_security[bps_login_security_errors]" style="width:220px;">
<option value="wpErrors" <?php @selected('wpErrors', $BPSoptions['bps_login_security_errors']); ?>><?php _e('Standard WP Login Errors', 'bulletproof-security'); ?></option>
<option value="generic" <?php @selected('generic', $BPSoptions['bps_login_security_errors']); ?>><?php _e('User|Pass Invalid Entry Error', 'bulletproof-security'); ?></option>
<option value="genericAll" <?php @selected('genericAll', $BPSoptions['bps_login_security_errors']); ?>><?php _e('User|Pass|Lock Invalid Entry Error', 'bulletproof-security'); ?></option>
</select>
	</td>
  </tr>
  <tr>
    <td><label for="LSLog"><?php _e('Password Reset:', 'bulletproof-security'); ?></label></td>
    <td><select name="bulletproof_security_options_login_security[bps_login_security_pw_reset]" style="width:220px;">
<option value="enable" <?php @selected('enable', $BPSoptions['bps_login_security_pw_reset']); ?>><?php _e('Enable Password Reset', 'bulletproof-security'); ?></option>
<option value="disableFrontend" <?php @selected('disableFrontend', $BPSoptions['bps_login_security_pw_reset']); ?>><?php _e('Disable Password Reset Frontend Only', 'bulletproof-security'); ?></option>
<option value="disable" <?php @selected('disable', $BPSoptions['bps_login_security_pw_reset']); ?>><?php _e('Disable Password Reset Frontend & Backend', 'bulletproof-security'); ?></option>
</select>
	</td>
  </tr>
  <tr>
    <td><label for="LSLog"><?php _e('Sort DB Rows:', 'bulletproof-security'); ?></label></td>
    <td><select name="bulletproof_security_options_login_security[bps_login_security_sort]" style="width:220px;">
<option value="ascending" <?php @selected('ascending', $BPSoptions['bps_login_security_sort']); ?>><?php _e('Ascending - Show Oldest Login First', 'bulletproof-security'); ?></option>
<option value="descending" <?php @selected('descending', $BPSoptions['bps_login_security_sort']); ?>><?php _e('Descending - Show Newest Login First', 'bulletproof-security'); ?></option>
</select>
	</td>
  </tr>
</table>

<input type="submit" name="Submit-Security-Log-Options" class="button bps-button" style="margin:10px 0px 0px 0px;" value="<?php esc_attr_e('Save Options', 'bulletproof-security') ?>" />
</form>
</div>

</td>
    <td style="vertical-align:top;">
 
<?php if ( is_multisite() && $blog_id != 1 ) { echo '<div style="margin:10px 0px 0px 0px;"></div>'; } else { ?>

	<div id="LoginSecurityEmailOptions" style="width:100%;">   

<form name="bpsEmailAlerts" action="options.php" method="post">
    <?php settings_fields('bulletproof_security_options_email'); ?>
	<?php $options = get_option('bulletproof_security_options_email'); ?>
	<?php $admin_email = get_option('admin_email'); ?>

<table border="0">
  <tr>
    <td><label for="bps-monitor-email"><?php _e('Send Email Alerts & Log Files To:', 'bulletproof-security'); ?> </label></td>
    <td><input type="text" name="bulletproof_security_options_email[bps_send_email_to]" class="regular-text-long-fixed" style="width:200px;" value="<?php if ( $options['bps_send_email_to'] != '' ) { echo $options['bps_send_email_to']; } else { echo $admin_email; } ?>" /></td>
  </tr>
  <tr>
    <td><label for="bps-monitor-email"><?php _e('Send Email Alerts & Log Files From:', 'bulletproof-security'); ?> </label></td>
    <td><input type="text" name="bulletproof_security_options_email[bps_send_email_from]" class="regular-text-long-fixed" style="width:200px;" value="<?php if ( $options['bps_send_email_from'] != '' ) { echo $options['bps_send_email_from']; } else { echo $admin_email; } ?>" /></td>
  </tr>
  <tr>
    <td><label for="bps-monitor-email"><?php _e('Send Email Alerts & Log Files Cc:', 'bulletproof-security'); ?> </label></td>
    <td><input type="text" name="bulletproof_security_options_email[bps_send_email_cc]" class="regular-text-long-fixed" style="width:200px;" value="<?php echo $options['bps_send_email_cc']; ?>" /></td>
  </tr>
  <tr>
    <td><label for="bps-monitor-email"><?php _e('Send Email Alerts & Log Files Bcc:', 'bulletproof-security'); ?> </label></td>
    <td><input type="text" name="bulletproof_security_options_email[bps_send_email_bcc]" class="regular-text-long-fixed" style="width:200px;" value="<?php echo $options['bps_send_email_bcc']; ?>" /></td>
  </tr>
</table>
<br />

<table border="0">
  <tr>
    <td><strong><label for="bps-monitor-email"><?php _e('Login Security: Send Login Security Email Alert When...', 'bulletproof-security'); ?></label></strong><br />
<select name="bulletproof_security_options_email[bps_login_security_email]" style="width:340px;">
<option value="lockoutOnly" <?php selected( $options['bps_login_security_email'], 'lockoutOnly'); ?>><?php _e('A User Account Is Locked Out', 'bulletproof-security'); ?></option>
<option value="adminLoginOnly" <?php selected( $options['bps_login_security_email'], 'adminLoginOnly'); ?>><?php _e('An Administrator Logs In', 'bulletproof-security'); ?></option>
<option value="adminLoginLock" <?php selected( $options['bps_login_security_email'], 'adminLoginLock'); ?>><?php _e('An Administrator Logs In & A User Account is Locked Out', 'bulletproof-security'); ?></option>
<option value="anyUserLoginLock" <?php selected( $options['bps_login_security_email'], 'anyUserLoginLock'); ?>><?php _e('Any User Logs In & A User Account is Locked Out', 'bulletproof-security'); ?></option>
<option value="no" <?php selected( $options['bps_login_security_email'], 'no'); ?>><?php _e('Do Not Send Email Alerts', 'bulletproof-security'); ?></option>
</select></td>
  </tr>
  <tr>
    <td style="padding-top:5px;"><strong><label for="bps-monitor-email-log"><?php _e('Security Log: Email|Delete Security Log File When...', 'bulletproof-security'); ?></label></strong><br />
<select name="bulletproof_security_options_email[bps_security_log_size]" style="width:80px;">
<option value="500KB" <?php selected( $options['bps_security_log_size'], '500KB' ); ?>><?php _e('500KB', 'bulletproof-security'); ?></option>
<option value="256KB" <?php selected( $options['bps_security_log_size'], '256KB'); ?>><?php _e('256KB', 'bulletproof-security'); ?></option>
<option value="1MB" <?php selected( $options['bps_security_log_size'], '1MB' ); ?>><?php _e('1MB', 'bulletproof-security'); ?></option>
</select>
<select name="bulletproof_security_options_email[bps_security_log_emailL]" style="width:255px;">
<option value="email" <?php selected( $options['bps_security_log_emailL'], 'email' ); ?>><?php _e('Email Log & Then Delete Log File', 'bulletproof-security'); ?></option>
<option value="delete" <?php selected( $options['bps_security_log_emailL'], 'delete' ); ?>><?php _e('Delete Log File', 'bulletproof-security'); ?></option>
</select></td>
  </tr>
  <tr>
    <td style="padding-top:5px;"><strong><label for="bps-monitor-email-log"><?php _e('DB Backup Log: Email|Delete DB Backup Log File When...', 'bulletproof-security'); ?></label></strong><br />
<select name="bulletproof_security_options_email[bps_dbb_log_size]" style="width:80px;">
<option value="500KB" <?php selected( $options['bps_dbb_log_size'], '500KB' ); ?>><?php _e('500KB', 'bulletproof-security'); ?></option>
<option value="256KB" <?php selected( $options['bps_dbb_log_size'], '256KB'); ?>><?php _e('256KB', 'bulletproof-security'); ?></option>
<option value="1MB" <?php selected( $options['bps_dbb_log_size'], '1MB' ); ?>><?php _e('1MB', 'bulletproof-security'); ?></option>
</select>
<select name="bulletproof_security_options_email[bps_dbb_log_email]" style="width:255px;">
<option value="email" <?php selected( $options['bps_dbb_log_email'], 'email' ); ?>><?php _e('Email Log & Then Delete Log File', 'bulletproof-security'); ?></option>
<option value="delete" <?php selected( $options['bps_dbb_log_email'], 'delete' ); ?>><?php _e('Delete Log File', 'bulletproof-security'); ?></option>
</select></td>
  </tr>
</table>

<!-- <strong><label for="bps-monitor-email" style="margin:0px 0px 0px 0px;"><?php //_e('BPS Plugin Upgrade Email Notification', 'bulletproof-security'); ?></label></strong><br />
<select name="bulletproof_security_options_email[bps_upgrade_email]" style="width:340px;">
<option value="yes" <?php //selected( @$options['bps_upgrade_email'], 'yes'); ?>><?php //_e('Send Email Alerts', 'bulletproof-security'); ?></option>
<option value="no" <?php //selected( @$options['bps_upgrade_email'], 'no'); ?>><?php //_e('Do Not Send Email Alerts', 'bulletproof-security'); ?></option>
</select><br /><br /> -->

<input type="hidden" name="bpsEMA" value="bps-EMA" />
<input type="submit" name="bpsEmailAlertSubmit" class="button bps-button" style="margin:15px 0px 0px 0px;" value="<?php esc_attr_e('Save Options', 'bulletproof-security') ?>" />
</form>
</div>

<?php } ?>

</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

<?php

	// DB Login Security Search Form
	echo '<div id="LoginSecuritySearch" style="float:right;margin:-30px 110px 0px 0px;>';
	echo '<form name="LoginSecuritySearchForm" action="admin.php?page=bulletproof-security/admin/login/login.php" method="post">';
	wp_nonce_field('bulletproof_security_login_security_search');
	echo '<input type="text" name="LSSearch" class="regular-text-short-fixed" style="margin: 0px 5px 0px 0px; "value="" />';
	echo '<input type="submit" name="Submit-Login-Security-search" value="'.esc_attr('Search', 'bulletproof-security').'" class="button bps-button" />';
	echo '</form>';
	echo '</div>';

function bpsDBRowCount() {
global $wpdb;
$bpspro_login_table = $wpdb->prefix . "bpspro_login_security";
$id = '0';
$DB_row_count = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM $bpspro_login_table WHERE id != %d", $id ) );
$BPSoptions = get_option('bulletproof_security_options_login_security');
$Max_db_rows = $BPSoptions['bps_max_db_rows_display'];

	if ( wp_script_is( 'bps-accordion', $list = 'queue' ) ) {

	echo '<div id="LoginSecurityDBRowCount" style="position:relative; left:0px; bottom:5px;color:#2ea2cc;font-weight:bold;font-size:14px;">';
	
	if ( $BPSoptions['bps_max_db_rows_display'] != '') {
		$text = $Max_db_rows.__(' out of ', 'bulletproof-security')."{$DB_row_count}".__(' Database Rows are currently being displayed', 'bulletproof-security');
		echo $text;
	} else {
		$text = __('Total number of Database Rows is: ', 'bulletproof-security')."{$DB_row_count}";
		echo $text;	
	}
	echo '</div>';
	}
}
echo bpsDBRowCount();

// Login Security Search Form
if ( isset( $_POST['Submit-Login-Security-search'] ) && current_user_can('manage_options') ) {
	check_admin_referer('bulletproof_security_login_security_search');
	
	if ( wp_script_is( 'bps-accordion', $list = 'queue' ) ) {

		$bpspro_login_table = $wpdb->prefix . "bpspro_login_security";
		$search = $_POST['LSSearch'];

		$getLoginSecurityTable = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $bpspro_login_table WHERE (status = %s) OR (user_id = %s) OR (username LIKE %s) OR (public_name LIKE %s) OR (email LIKE %s) OR (role LIKE %s) OR (ip_address LIKE %s) OR (hostname LIKE %s) OR (request_uri LIKE %s)", $search, $search, "%$search%", "%$search%", "%$search%", "%$search%", "%$search%", "%$search%", "%$search%" ) );

		echo '<form name="bpsLoginSecuritySearchDBRadio" action="admin.php?page=bulletproof-security/admin/login/login.php" method="post">';
		wp_nonce_field('bulletproof_security_login_security_search');

		echo '<div id="LoginSecurityCheckall" style="max-height:600px;">';
		echo '<table class="widefat" style="margin-bottom:20px;">';
		echo '<thead>';
		echo '<tr>';
		echo '<th scope="col" style="width:10%;font-size:16px;"><strong>'.__('Login Status', 'bulletproof-security').'</strong></th>';
		echo '<th scope="col" style="width:5%;font-size:12px;"><input type="checkbox" class="checkallLock" style="text-align:left; margin-left:2px;" /><br><strong>'.__('Lock', 'bulletproof-security').'</strong></th>';
		echo '<th scope="col" style="width:5%;font-size:12px;"><input type="checkbox" class="checkallUnlock" style="text-align:left; margin-left:2px;" /><br><strong>'.__('Unlock', 'bulletproof-security').'</strong></th>';
		echo '<th scope="col" style="width:5%;font-size:12px;"><input type="checkbox" class="checkallDelete" style="text-align:left; margin-left:2px;" /><br><strong>'.__('Delete', 'bulletproof-security').'</strong></th>';
		echo '<th scope="col" style="width:5%;font-size:12px;"><strong>'.__('User ID', 'bulletproof-security').'</strong></th>';
		echo '<th scope="col" style="width:5%;font-size:12px;"><strong>'.__('Username', 'bulletproof-security').'</strong></th>';
		echo '<th scope="col" style="width:5%;font-size:12px;"><strong>'.__('Display Name', 'bulletproof-security').'</strong></th>';
		echo '<th scope="col" style="width:5%;font-size:12px;"><strong>'.__('Email', 'bulletproof-security').'</strong></th>';
		echo '<th scope="col" style="width:5%;font-size:12px;"><strong>'.__('Role', 'bulletproof-security').'</strong></th>';
		echo '<th scope="col" style="width:5%;font-size:12px;"><strong>'.__('Login Time', 'bulletproof-security').'</strong></th>';
		echo '<th scope="col" style="width:5%;font-size:12px;"><strong>'.__('Lockout Expires', 'bulletproof-security').'</strong></th>';
		echo '<th scope="col" style="width:5%;font-size:12px;"><strong>'.__('IP Address', 'bulletproof-security').'</strong></th>';
		echo '<th scope="col" style="width:5%;font-size:12px;"><strong>'.__('Hostname', 'bulletproof-security').'</strong></th>';
		echo '<th scope="col" style="width:5%;font-size:12px;"><strong>'.__('Request URI', 'bulletproof-security').'</strong></th>';
		echo '</tr>';
		echo '</thead>';
		echo '<tbody>';
		echo '<tr>';
		
		foreach ( $getLoginSecurityTable as $row ) {

		if ( $wpdb->num_rows != 0 ) {
			$gmt_offset = get_option( 'gmt_offset' ) * 3600;
		
			if ( $row->status == 'Locked' ) {
				echo '<th scope="row" style="border-bottom:none;color:red;font-weight:bold;">'.$row->status.'</th>';
			} else {
				echo '<th scope="row" style="border-bottom:none;">'.$row->status.'</th>';
			}

		echo "<td><input type=\"checkbox\" id=\"lockuser\" name=\"LSradio[$row->user_id]\" value=\"lockuser\" class=\"lockuserALL\" /><br><span style=\"font-size:10px;\">".__('Lock', 'bulletproof-security')."</span></td>";
		echo "<td><input type=\"checkbox\" id=\"unlockuser\" name=\"LSradio[$row->user_id]\" value=\"unlockuser\" class=\"unlockuserALL\" /><br><span style=\"font-size:10px;\">".__('Unlock', 'bulletproof-security')."</span></td>";
		echo "<td><input type=\"checkbox\" id=\"deleteuser\" name=\"LSradio[$row->user_id]\" value=\"deleteuser\" class=\"deleteuserALL\" /><br><span style=\"font-size:10px;\">".__('Delete', 'bulletproof-security')."</span></td>";

		echo '<td>'.$row->user_id.'</td>';
		echo '<td>'.$row->username.'</td>';
		echo '<td>'.$row->public_name.'</td>';	
		echo '<td>'.$row->email.'</td>';	
		echo '<td>'.$row->role.'</td>';	
		echo '<td>'.date_i18n(get_option('date_format').' '.get_option('time_format'), $row->login_time + $gmt_offset).'</td>';
		if ( $row->lockout_time == 0 ) { 
		echo '<td>'.__('NA', 'bulletproof-security').'</td>';
		} else {
		echo '<td>'.date_i18n(get_option('date_format').' '.get_option('time_format'), $row->lockout_time + $gmt_offset).'</td>';
		}
		echo '<td>'.$row->ip_address.'</td>';	
		echo '<td>'.$row->hostname.'</td>';
		echo '<td>'.$row->request_uri.'</td>';	
		echo '</tr>';			
		}
		} 
		
		if ( $wpdb->num_rows == 0 ) {		
		echo '<th scope="row" style="border-bottom:none;">'.__('No Logins|Locked', 'bulletproof-security').'</th>';
		echo "<td></td>";
		echo "<td></td>";
		echo "<td></td>";
		echo '<td></td>';		
		echo '<td></td>'; 
		echo '<td></td>';		
		echo '<td></td>'; 
		echo '<td></td>';
		echo '<td></td>';		
		echo '<td></td>'; 
		echo '</tr>';		
		}
		echo '</tbody>';
		echo '</table>';
		echo '</div>';	

		echo "<input type=\"submit\" name=\"Submit-Login-Search-Radio\" value=\"".__('Submit', 'bulletproof-security')."\" class=\"button bps-button\" onclick=\"return confirm('".__('Locking and Unlocking a User is reversible, but Deleting a User is not.\n\n-------------------------------------------------------------\n\nWhen you delete a User you are deleting that User database row from the BPS Login Security Database Table and not from the WordPress User Database Table.\n\n-------------------------------------------------------------\n\nTo delete a User Account from your WordPress website use the standard/normal WordPress Users page.\n\n-------------------------------------------------------------\n\nClick OK to proceed or click Cancel', 'bulletproof-security')."')\" />&nbsp;&nbsp;<input type=\"button\" name=\"cancel\" value=\"".__('Clear|Refresh', 'bulletproof-security')."\" class=\"button bps-button\" onclick=\"javascript:history.go(0)\" /></form>";
	}
	} else {

	if ( is_admin() && wp_script_is( 'bps-accordion', $list = 'queue' ) && current_user_can('manage_options') ) {
	
		echo '<form name="bpsLoginSecurityDBRadio" action="admin.php?page=bulletproof-security/admin/login/login.php" method="post">';
		wp_nonce_field('bulletproof_security_login_security');

		$bpspro_login_table = $wpdb->prefix . "bpspro_login_security";
		$searchAll = ''; // return all rows
		$BPSoptions = get_option('bulletproof_security_options_login_security');
	
		if ( !$BPSoptions['bps_login_security_sort'] || $BPSoptions['bps_login_security_sort'] == 'ascending' ) {
			$sorting = 'ASC';
		} else {
			$sorting = 'DESC';
		}
	
		if ( $BPSoptions['bps_max_db_rows_display'] != '' ) {
			$db_row_limit = 'LIMIT '. $BPSoptions['bps_max_db_rows_display'];
			$getLoginSecurityTable = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $bpspro_login_table WHERE login_time != %s ORDER BY login_time $sorting $db_row_limit", "%$searchAll%" ) );
	
		} else {
			$getLoginSecurityTable = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $bpspro_login_table WHERE login_time != %s ORDER BY login_time $sorting", "%$searchAll%" ) );	
		}

		echo '<div id="LoginSecurityCheckall" style="max-height:600px;">';
		echo '<table class="widefat" style="margin-bottom:20px;">';
		echo '<thead>';
		echo '<tr>';
		echo '<th scope="col" style="width:10%;font-size:16px;"><strong>'.__('Login Status', 'bulletproof-security').'</strong></th>';
		echo '<th scope="col" style="width:5%;font-size:12px;"><input type="checkbox" class="checkallLock" style="text-align:left;margin-left:2px;" /><br><strong>'.__('Lock', 'bulletproof-security').'</strong></th>';
		echo '<th scope="col" style="width:5%;font-size:12px;"><input type="checkbox" class="checkallUnlock" style="text-align:left;margin-left:2px;" /><br><strong>'.__('Unlock', 'bulletproof-security').'</strong></th>';
		echo '<th scope="col" style="width:5%;font-size:12px;"><input type="checkbox" class="checkallDelete" style="text-align:left;margin-left:2px;" /><br><strong>'.__('Delete', 'bulletproof-security').'</strong></th>';
		echo '<th scope="col" style="width:5%;font-size:12px;"><strong>'.__('User ID', 'bulletproof-security').'</strong></th>';
		echo '<th scope="col" style="width:5%;font-size:12px;"><strong>'.__('Username', 'bulletproof-security').'</strong></th>';
		echo '<th scope="col" style="width:5%;font-size:12px;"><strong>'.__('Display Name', 'bulletproof-security').'</strong></th>';
		echo '<th scope="col" style="width:5%;font-size:12px;"><strong>'.__('Email', 'bulletproof-security').'</strong></th>';
		echo '<th scope="col" style="width:5%;font-size:12px;"><strong>'.__('Role', 'bulletproof-security').'</strong></th>';
		echo '<th scope="col" style="width:5%;font-size:12px;"><strong>'.__('Login Time', 'bulletproof-security').'</strong></th>';
		echo '<th scope="col" style="width:5%;font-size:12px;"><strong>'.__('Lockout Expires', 'bulletproof-security').'</strong></th>';
		echo '<th scope="col" style="width:5%;font-size:12px;"><strong>'.__('IP Address', 'bulletproof-security').'</strong></th>';
		echo '<th scope="col" style="width:5%;font-size:12px;"><strong>'.__('Hostname', 'bulletproof-security').'</strong></th>';
		echo '<th scope="col" style="width:5%;font-size:12px;"><strong>'.__('Request URI', 'bulletproof-security').'</strong></th>';
		echo '</tr>';
		echo '</thead>';
		echo '<tbody>';
		echo '<tr>';
		
		foreach ( $getLoginSecurityTable as $row ) {

		if ( $wpdb->num_rows != 0 ) {
			$gmt_offset = get_option( 'gmt_offset' ) * 3600;
			
			if ( $row->status == 'Locked' ) {
				echo '<th scope="row" style="border-bottom:none;color:red;font-weight:bold;">'.$row->status.'</th>';
			} else {
				echo '<th scope="row" style="border-bottom:none;">'.$row->status.'</th>';
			}

		echo "<td><input type=\"checkbox\" id=\"lockuser\" name=\"LSradio[$row->user_id]\" value=\"lockuser\" class=\"lockuserALL\" /><br><span style=\"font-size:10px;\">".__('Lock', 'bulletproof-security')."</span></td>";
		echo "<td><input type=\"checkbox\" id=\"unlockuser\" name=\"LSradio[$row->user_id]\" value=\"unlockuser\" class=\"unlockuserALL\" /><br><span style=\"font-size:10px;\">".__('Unlock', 'bulletproof-security')."</span></td>";
		echo "<td><input type=\"checkbox\" id=\"deleteuser\" name=\"LSradio[$row->user_id]\" value=\"deleteuser\" class=\"deleteuserALL\" /><br><span style=\"font-size:10px;\">".__('Delete', 'bulletproof-security')."</span></td>";

		echo '<td>'.$row->user_id.'</td>';
		echo '<td>'.$row->username.'</td>';
		echo '<td>'.$row->public_name.'</td>';	
		echo '<td>'.$row->email.'</td>';	
		echo '<td>'.$row->role.'</td>';	
		echo '<td>'.date_i18n(get_option('date_format').' '.get_option('time_format'), $row->login_time + $gmt_offset).'</td>';
		if ( $row->lockout_time == 0 ) { 
		echo '<td>'.__('NA', 'bulletproof-security').'</td>';
		} else {
		echo '<td>'.date_i18n(get_option('date_format').' '.get_option('time_format'), $row->lockout_time + $gmt_offset).'</td>';
		}
		echo '<td>'.$row->ip_address.'</td>';	
		echo '<td>'.$row->hostname.'</td>';
		echo '<td>'.$row->request_uri.'</td>';	
		echo '</tr>';			
		}
		} 
		
		if ( $wpdb->num_rows == 0 ) {		
		echo '<th scope="row" style="border-bottom:none;">'.__('No Logins|Locked', 'bulletproof-security').'</th>';
		echo "<td></td>";
		echo "<td></td>";
		echo "<td></td>";
		echo '<td></td>';		
		echo '<td></td>'; 
		echo '<td></td>';		
		echo '<td></td>'; 
		echo '<td></td>';
		echo '<td></td>';		
		echo '<td></td>'; 
		echo '</tr>';		
		}
		echo '</tbody>';
		echo '</table>';
		echo '</div>';	

		echo "<input type=\"submit\" name=\"Submit-Login-Security-Radio\" value=\"".__('Submit', 'bulletproof-security')."\" class=\"button bps-button\" onclick=\"return confirm('".__('Locking and Unlocking a User is reversible, but Deleting a User is not.\n\n-------------------------------------------------------------\n\nWhen you delete a User you are deleting that User database row from the BPS Login Security Database Table and not from the WordPress User Database Table.\n\n-------------------------------------------------------------\n\nTo delete a User Account from your WordPress website use the standard/normal WordPress Users page.\n\n-------------------------------------------------------------\n\nClick OK to proceed or click Cancel', 'bulletproof-security')."')\" />&nbsp;&nbsp;<input type=\"button\" name=\"cancel\" value=\"".__('Clear|Refresh', 'bulletproof-security')."\" class=\"button bps-button\" onclick=\"javascript:history.go(0)\" /></form>";
	}
	}
?>
<br />

<script type="text/javascript">
/* <![CDATA[ */
jQuery(document).ready(function($){
//jQuery(function() {
    $('.checkallLock').click(function() {
        $(this).parents('#LoginSecurityCheckall:eq(0)').find('.lockuserALL:checkbox').attr('checked', this.checked);
    });
});
/* ]]> */
</script>

<script type="text/javascript">
/* <![CDATA[ */
jQuery(document).ready(function($){
//jQuery(function() {
    $('.checkallUnlock').click(function() {
        $(this).parents('#LoginSecurityCheckall:eq(0)').find('.unlockuserALL:checkbox').attr('checked', this.checked);
    });
});
/* ]]> */
</script>

<script type="text/javascript">
/* <![CDATA[ */
jQuery(document).ready(function($){
//jQuery(function() {
    $('.checkallDelete').click(function() {
        $(this).parents('#LoginSecurityCheckall:eq(0)').find('.deleteuserALL:checkbox').attr('checked', this.checked);
    });
});
/* ]]> */
</script>

<?php 
// Standard Visible Login Security form proccessing - Lock, Unlock or Delete user login status from DB
if ( isset($_POST['Submit-Login-Security-Radio'] ) && current_user_can('manage_options') ) {
	check_admin_referer('bulletproof_security_login_security');
	
	$LSradio = $_POST['LSradio'];
	$bpspro_login_table = $wpdb->prefix . "bpspro_login_security";

	switch( $_POST['Submit-Login-Security-Radio'] ) {
		case __('Submit', 'bulletproof-security'):
		
		$delete_users = array();
		$unlock_users = array();
		$lock_users = array();		
		
		if ( !empty($LSradio) ) {
			
			foreach ( $LSradio as $key => $value ) {
				
				if ( $value == 'deleteuser' ) {
					$delete_users[] = $key;
				
				} elseif ( $value == 'unlockuser' ) {
					$unlock_users[] = $key;
				
				} elseif ( $value == 'lockuser' ) {
					$lock_users[] = $key;
				}
			}
		}
			
		if ( !empty($delete_users) ) {
			
			foreach ( $delete_users as $delete_user ) {
				$LoginSecurityRows = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $bpspro_login_table WHERE user_id = %s", $delete_user ) );
			
				foreach ( $LoginSecurityRows as $row ) {
					$delete_row = $wpdb->query( $wpdb->prepare( "DELETE FROM $bpspro_login_table WHERE user_id = %s", $delete_user ) );
				
				echo $bps_topDiv;
				$textDelete = '<font color="green">'.$row->username.__(' has been deleted from the Login Security Database Table.', 'bulletproof-security').'</font><br><div class="bps-message-button" style="width:90px;"><a href="admin.php?page=bulletproof-security/admin/login/login.php">'.__('Refresh Status', 'bulletproof-security').'</a></div>';
				echo $textDelete;
				echo $bps_bottomDiv;	
				}
			}
		}
		
		if ( !empty($unlock_users) ) {
			
			foreach ( $unlock_users as $unlock_user ) {
				$LoginSecurityRows = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $bpspro_login_table WHERE user_id = %s", $unlock_user ) );
			
				foreach ( $LoginSecurityRows as $row ) {
					$NLstatus = 'Not Locked';
					$lockout_time = '0';		
					$failed_logins ='0';

					$update_rows = $wpdb->update( $bpspro_login_table, array( 'status' => $NLstatus, 'user_id' => $row->user_id, 'username' => $row->username, 'public_name' => $row->public_name, 'email' => $row->email, 'role' => $row->role, 'human_time' => current_time('mysql'), 'login_time' => $row->login_time, 'lockout_time' => $lockout_time, 'failed_logins' => $failed_logins, 'ip_address' => $row->ip_address, 'hostname' => $row->hostname, 'request_uri' => $row->request_uri ), array( 'user_id' => $row->user_id ) );
				
				echo $bps_topDiv;
				$textUnlock = '<font color="green">'.$row->username.__(' has been Unlocked.', 'bulletproof-security').'</font><br><div class="bps-message-button" style="width:90px;"><a href="admin.php?page=bulletproof-security/admin/login/login.php">'.__('Refresh Status', 'bulletproof-security').'</a></div>';
				echo $textUnlock;
				echo $bps_bottomDiv;	
				}			
			}
		}

		if ( !empty($lock_users) ) {
			
			foreach ( $lock_users as $lock_user ) {
				$LoginSecurityRows = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $bpspro_login_table WHERE user_id = %s", $lock_user ) );
			
				foreach ( $LoginSecurityRows as $row ) {
					$Lstatus = 'Locked';
					$manual_lockout_time = time() + (60 * $BPSoptions['bps_manual_lockout_duration']); // default is 1 hour/3600 seconds
					$BPSoptions = get_option('bulletproof_security_options_login_security');
					$failed_logins = $BPSoptions['bps_max_logins'];	

					$update_rows = $wpdb->update( $bpspro_login_table, array( 'status' => $Lstatus, 'user_id' => $row->user_id, 'username' => $row->username, 'public_name' => $row->public_name, 'email' => $row->email, 'role' => $row->role, 'human_time' => current_time('mysql'), 'login_time' => $row->login_time, 'lockout_time' => $manual_lockout_time, 'failed_logins' => $failed_logins, 'ip_address' => $row->ip_address, 'hostname' => $row->hostname, 'request_uri' => $row->request_uri ), array( 'user_id' => $row->user_id ) );

				echo $bps_topDiv;
				$textLock = '<font color="green">'.$row->username.__(' has been Locked.', 'bulletproof-security').'</font><br><div class="bps-message-button" style="width:90px;"><a href="admin.php?page=bulletproof-security/admin/login/login.php">'.__('Refresh Status', 'bulletproof-security').'</a></div>';
				echo $textLock;
				echo $bps_bottomDiv;
				}			
			}
		}
		break;
	} // end Switch
}

// Search Form - Login Security form proccessing - Lock, Unlock or Delete user login status from DB
if ( isset($_POST['Submit-Login-Search-Radio'] ) && current_user_can('manage_options') ) {
	check_admin_referer('bulletproof_security_login_security_search');
	
	$LSradio = $_POST['LSradio'];
	$bpspro_login_table = $wpdb->prefix . "bpspro_login_security";
	
	switch( $_POST['Submit-Login-Search-Radio'] ) {
		case __('Submit', 'bulletproof-security'):
		
		$delete_users = array();
		$unlock_users = array();
		$lock_users = array();		
		
		if ( !empty($LSradio) ) {
			
			foreach ( $LSradio as $key => $value ) {
				
				if ( $value == 'deleteuser' ) {
					$delete_users[] = $key;
				
				} elseif ( $value == 'unlockuser' ) {
					$unlock_users[] = $key;
				
				} elseif ( $value == 'lockuser' ) {
					$lock_users[] = $key;
				}
			}
		}
			
		if ( !empty($delete_users) ) {
			
			foreach ( $delete_users as $delete_user ) {
				$LoginSecurityRows = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $bpspro_login_table WHERE user_id = %s", $delete_user ) );
			
				foreach ( $LoginSecurityRows as $row ) {
					$delete_row = $wpdb->query( $wpdb->prepare( "DELETE FROM $bpspro_login_table WHERE user_id = %s", $delete_user ) );
				
				echo $bps_topDiv;
				$textDelete = '<font color="green">'.$row->username.__(' has been deleted from the Login Security Database Table.', 'bulletproof-security').'</font><br><div class="bps-message-button" style="width:90px;"><a href="admin.php?page=bulletproof-security/admin/login/login.php">'.__('Refresh Status', 'bulletproof-security').'</a></div>';
				echo $textDelete;
				echo $bps_bottomDiv;
				}
			}
		}
		
		if ( !empty($unlock_users) ) {
			
			foreach ( $unlock_users as $unlock_user ) {
				$LoginSecurityRows = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $bpspro_login_table WHERE user_id = %s", $unlock_user ) );
			
				foreach ( $LoginSecurityRows as $row ) {
					$NLstatus = 'Not Locked';
					$lockout_time = '0';		
					$failed_logins ='0';						
					
					$update_rows = $wpdb->update( $bpspro_login_table, array( 'status' => $NLstatus, 'user_id' => $row->user_id, 'username' => $row->username, 'public_name' => $row->public_name, 'email' => $row->email, 'role' => $row->role, 'human_time' => current_time('mysql'), 'login_time' => $row->login_time, 'lockout_time' => $lockout_time, 'failed_logins' => $failed_logins, 'ip_address' => $row->ip_address, 'hostname' => $row->hostname, 'request_uri' => $row->request_uri ), array( 'user_id' => $row->user_id ) );
				
				echo $bps_topDiv;
				$textUnlock = '<font color="green">'.$row->username.__(' has been Unlocked.', 'bulletproof-security').'</font><br><div class="bps-message-button" style="width:90px;"><a href="admin.php?page=bulletproof-security/admin/login/login.php">'.__('Refresh Status', 'bulletproof-security').'</a></div>';
				echo $textUnlock;
				echo $bps_bottomDiv;	
				}			
			}
		}

		if ( !empty($lock_users) ) {
			
			foreach ( $lock_users as $lock_user ) {
				$LoginSecurityRows = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $bpspro_login_table WHERE user_id = %s", $lock_user ) );
			
				foreach ( $LoginSecurityRows as $row ) {
					$Lstatus = 'Locked';
					$manual_lockout_time = time() + (60 * $BPSoptions['bps_manual_lockout_duration']); // default is 1 hour/3600 seconds 	
					$BPSoptions = get_option('bulletproof_security_options_login_security');
					$failed_logins = $BPSoptions['bps_max_logins'];

					$update_rows = $wpdb->update( $bpspro_login_table, array( 'status' => $Lstatus, 'user_id' => $row->user_id, 'username' => $row->username, 'public_name' => $row->public_name, 'email' => $row->email, 'role' => $row->role, 'human_time' => current_time('mysql'), 'login_time' => $row->login_time, 'lockout_time' => $manual_lockout_time, 'failed_logins' => $failed_logins, 'ip_address' => $row->ip_address, 'hostname' => $row->hostname, 'request_uri' => $row->request_uri ), array( 'user_id' => $row->user_id ) );

				echo $bps_topDiv;
				$textLock = '<font color="green">'.$row->username.__(' has been Locked.', 'bulletproof-security').'</font><br><div class="bps-message-button" style="width:90px;"><a href="admin.php?page=bulletproof-security/admin/login/login.php">'.__('Refresh Status', 'bulletproof-security').'</a></div>';
				echo $textLock;
				echo $bps_bottomDiv;
				}			
			}
		}
		break;
	} // end Switch
}
} // end if current_user_can('manage_options') - forms are not displayed to non-administrators
?>
</td>
  </tr>
  <tr>
    <td class="bps-table_cell_bottom">&nbsp;</td>
  </tr>
</table>
</div>

<div id="bps-tabs-2" class="bps-tab-page">
<h2><?php _e('BulletProof Security Help &amp; FAQ', 'bulletproof-security'); ?></h2>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="bps-help_faq_table">
   <tr>
    <td colspan="2" class="bps-table_title">&nbsp;</td>
  </tr>
  <tr>
    <td width="50%" class="bps-table_cell_help_links"><a href="http://forum.ait-pro.com/forums/topic/security-log-event-codes/" target="_blank"><?php _e('Security Log Event Codes', 'bulletproof-security'); ?></a></td>
    <td width="50%" class="bps-table_cell_help_links"><a href="http://www.ait-pro.com/aitpro-blog/category/bulletproof-security-contributors/" target="_blank"><?php _e('Contributors Page', 'bulletproof-security'); ?></a></td>
  </tr>
  <tr>
    <td class="bps-table_cell_help_links"><a href="http://forum.ait-pro.com/forums/topic/plugin-conflicts-actively-blocked-plugins-plugin-compatibility/" target="_blank"><?php _e('Forum: Search, Troubleshooting Steps & Post Questions For Assistance', 'bulletproof-security'); ?></a></td>
    <td class="bps-table_cell_help_links">&nbsp;</td>
  </tr>
  <tr>
    <td class="bps-table_cell_help_links">&nbsp;</td>
    <td class="bps-table_cell_help_links">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" class="bps-table_cell_bottom">&nbsp;</td>
  </tr>
</table>
</div>
         
<div id="AITpro-link">BulletProof Security <?php echo BULLETPROOF_VERSION; ?> Plugin by <a href="http://www.ait-pro.com/" target="_blank" title="AITpro Website Security">AITpro Website Security</a>
</div>
</div>
</div>
</div>