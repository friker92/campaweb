<?php
#############################################################
# If you manually edit this file make a backup of this file #
# this file will be replaced when you upgrade BPS           #
#############################################################

# BEGIN BPS INCLUDE
if ( file_exists( dirname( __FILE__ ) . '/bps-maintenance-values.php' ) ) {
include( dirname( __FILE__ ) . '/bps-maintenance-values.php' );
}
# END BPS INCLUDE

# BEGIN HEADERS
header('HTTP/1.1 503 Service Temporarily Unavailable', true, 503);
header('Status: 503 Service Temporarily Unavailable');
header('Retry-After:' . "$bps_maint_retry_after"); 	
header('Content-type: text/html; charset=UTF-8');
header('Cache-Control: no-store, no-cache, must-revalidate' ); 
header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
header('Pragma: no-cache' );
# END HEADERS
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $_SERVER['SERVER_NAME']; ?></title>

<style type="text/css">
<!--
body { 
	font-family: Verdana, Arial, Helvetica, sans-serif;
	line-height: normal;
	background-color:<?php echo "$bps_maint_background_color"; ?>;
}

p { font-family: Verdana, Arial, Helvetica, sans-serif; background-color: transparent;}

#countdown-container {
	position:relative; top:0px; left:0px;
}

/* Center Table Position: absolute center */
.maintenance-table {
	background:url('<?php echo $bps_maint_center_images; ?>') no-repeat;
	width:500px;
	height:400px;
	padding:20px;
	margin: auto;
	position: absolute;
	top: 0; left: 0; bottom: 0; right: 0;
}

/* Static Table Position: To position the entire maintenance table to a static position instead of centering it on the page */
/* uncomment these 2 styles below and comment out the .maintenance-table style above */
/* Change Static position Example: top:100px; left:100px; */
/*
#bps-mtable-div {
	position:relative; top:0px; left:0px;
	margin:0 auto;
	width:100%;
}

.maintenance-table {
	background:url('<?php echo $bps_maint_center_images; ?>') no-repeat;
	width:500px;
	height:400px;
	position:absolute;
	top:50px;
	left:50px;
	margin:0 auto;
	padding:20px;
}
*/

#center-text {
	position:relative; top:0px; left:0px;
}

#bpscountdowntimer { 
	background-color:black;
	color: <?php echo $bps_maint_countdown_timer_color; ?>;
	font-size: 18px;
	font-weight: bold;
	padding: 4px;
	position:relative; top:0px; left:0px;
}

#footer {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	text-align:center;
}
-->
</style>
</head>

<body background="<?php echo "$bps_maint_background_images"; ?>">
<div id="bps-mtable-div">

<?php
	if ( $bps_maint_countdown_timer != '1' ) { ?>
		<style>
		<!--
        #countdown-container { display:none; }
		-->
		</style>
<?php	
	}

	if ( $bps_maint_show_visitor_ip == '1' ) {
		$bps_maint_show_visitor_ip = 'IP Address: ' . htmlspecialchars($_SERVER['REMOTE_ADDR']);
	} else { 
		$bps_maint_show_visitor_ip = '';
	}
	
	if ( $bps_maint_show_login_link == '1' ) {
		$bps_maint_login_link = ' | '.'<a href="'.$bps_maint_login_link.'" style="text-decoration:none;">Login</a>';
	} else { 
		$bps_maint_login_link = '';
	}

?>

<table border="0" cellpadding="10" cellspacing="0" class="maintenance-table">
  <tr>
    <td>

<p><?php echo '<div id="center-text">' . "$bps_maint_text" . '</div><br>'; ?></p>

<div id="countdown-container">
<p id="bpscountdowntimer"></p>

<?php 
// Send Email Reminder when Maintenance Mode Countdown Timer has completed
function bps_send_mmode_email_alert() {
global $bps_maint_countdown_email, $bps_maint_email_to, $bps_maint_email_from, $bps_maint_email_cc, $bps_maint_email_bcc, $bps_maint_time;

	// -1 minute buffer so that email is not sent prematurely
	if ( $bps_maint_countdown_email == '1' && time() >= $bps_maint_time - 60 ) { 
	
	$uri = preg_replace( '/[^\/][a-zA-Z0-9-]+\/plugins\/bulletproof-security\/admin\/htaccess\/bps-maintenance\.php/', "", htmlspecialchars( $_SERVER['REQUEST_URI'], ENT_QUOTES ) );
	
	if ( isset( $_SERVER['SERVER_NAME'] ) ) {
		$hostname = htmlspecialchars( $_SERVER['SERVER_NAME'], ENT_QUOTES );
	} else {
		$hostname = htmlspecialchars( $_SERVER['HTTP_HOST'], ENT_QUOTES );
	}
	
	$site_link = 'http://' . $hostname . $uri;

	$headers = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
	$headers .= "From: $bps_maint_email_from" . "\r\n";
	$headers .= "Cc: $bps_maint_email_cc" . "\r\n";
	$headers .= "Bcc: $bps_maint_email_bcc" . "\r\n";	
	$subject = " BPS Maintenance Mode Reminder ";
	$message = '<p><font color="blue"><strong>The Maintenance Mode Countdown Timer has completed for:</strong></font></p>';
	$message .= '<p>Website: '.$site_link.'</p>';
	
	$mailed = mail( $bps_maint_email_to, $subject, $message, $headers );
	
	if ( $mailed ) {
		// do something else if/when email is sent
	}
	}
}
?>

</div>
<div id="footer">
<?php echo $bps_maint_show_visitor_ip.$bps_maint_login_link; ?>
</div>

<script type="text/javascript">
/***********************************************************************************************************/
/* Feel free to use this Countdown Timer code.                                                             */
/* Please leave this Kudos here if you use this code.                                                      */
/* Kudos: Ed @ AIT-pro.com                                                                                 */
/* http://forum.ait-pro.com/forums/topic/javascript-countdown-timer-php-countdown-timer-countdown-to-date/ */
/***********************************************************************************************************/
/* <![CDATA[ */
var MMode = setInterval(function(){ MModeTimer() }, 1000);

function MModeTimer() {

	var currentTime = new Date().getTime() / 1000;
	var futureTime = <?php echo $bps_maint_time; ?>;
	var timeRemaining = futureTime - currentTime;
	var minute = 60;
	var hour = 60 * 60;
	var day = 60 * 60 * 24;
	var dayFloor = Math.floor(timeRemaining / day);
	var hourFloor = Math.floor((timeRemaining - dayFloor * day) / hour);
	var minuteFloor = Math.floor((timeRemaining - dayFloor * day - hourFloor * hour) / minute);
	var secondFloor = Math.floor((timeRemaining - dayFloor * day - hourFloor * hour - minuteFloor * minute));
	var countdownCompleted = "<?php bps_send_mmode_email_alert(); ?>";	
    
	if (secondFloor <= 0 && minuteFloor <= 0) {   
		window.location.reload(true);
		clearInterval(MModeTimer);
		document.getElementById("bpscountdowntimer").innerHTML = countdownCompleted;
    
	} else {
		
		if (futureTime > currentTime) {
			document.getElementById("bpscountdowntimer").innerHTML = dayFloor + " Days " + hourFloor + " Hours " + minuteFloor + " Minutes " + secondFloor + " Seconds ";
		}
	}	
}
/* ]]> */
</script>
</td>
</tr>
</table>
</div>
</body>
</html>