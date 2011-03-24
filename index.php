<?php 
define('ROOT',$_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR);
define('INCLUDES',ROOT.'includes'.DIRECTORY_SEPARATOR);
define('CONFIG',ROOT.'Connections'.DIRECTORY_SEPARATOR);
define('SECTIONS',ROOT.'sections'.DIRECTORY_SEPARATOR);
define('ADMIN',ROOT.'admin'.DIRECTORY_SEPARATOR);
define('TEMPLATES',ROOT.'templates'.DIRECTORY_SEPARATOR);

require(CONFIG.'config.php');
require(INCLUDES.'functions.inc.php');

// Check to see if initial setup has taken place 
if (check_setup()) { header ("Location: setup.php?section=step1"); } 

// If all setup has taken place, run normally
else 
{
require(INCLUDES.'authentication_nav.inc.php');  session_start(); 
require(INCLUDES.'url_variables.inc.php');
require(INCLUDES.'db_connect.inc.php');
require(INCLUDES.'version.inc.php');
require(INCLUDES.'headers.inc.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $row_contest_info['contestName']; ?> Organized By <?php echo $row_contest_info['contestHost']." | ".$header_output; ?></title>
<link href="css/bruxellensis.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js_includes/jquery.js"></script>
<script type="text/javascript" src="js_includes/thickbox.js"></script>
<script type="text/javascript" src="js_includes/delete.js"></script>
<script type="text/javascript" src="js_includes/calendar_control.js" ></script>
<script type="text/javascript" src="js_includes/jump_menu.js" ></script>
<script type="text/javascript" src="js_includes/smoothscroll.js" ></script>
<?php if ((isset($_SESSION["loginUsername"])) && ($row_user['userLevel'] == "1")) { ?>
<script type="text/javascript" src="js_includes/menu.js"></script>
<?php } 
if ($section == "admin") { ?>
<script type="text/javascript" src="js_includes/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="js_includes/tinymce.init.js"></script>
<?php } 
if (($section == "admin") || ($section == "brew") || ($section == "brewer") || ($section == "user")  || ($section == "register") || ($section == "contact")) include(INCLUDES.'form_check.inc.php'); ?>
</head>
<body>
<a name="top"></a>
<div id="container">
<div id="navigation">
	<div id="navigation-inner"><?php include (SECTIONS.'nav.sec.php'); ?></div>
</div>
<div id="content">
  <div id="content-inner">
  <?php 
	//echo "<p>Registration Open: ".$row_contest_info['contestRegistrationOpen']."</p>";
	//echo "<p>Registration Deadline: ".$row_contest_info['contestRegistrationDeadline']."</p>";
	//if (greaterDate($today,$row_contest_info['contestRegistrationDeadline'])) echo "<p>Yes.</p>"; else echo "<p>No.</p>"
?>
  
  <?php if ($section != "admin") { ?>
  <div id="header">	
	<div id="header-inner"><h1><?php echo $header_output; ?></h1></div>
  </div>
  <?php }
  
  // Check if registration open date has passed. If so, display "registration not open yet" message.
  if (!greaterDate($today,$row_contest_info['contestRegistrationOpen'])) { 
  	if ($section != "admin") {
  	?>
    <div class="closed">Registration will open <?php echo dateconvert($row_contest_info['contestRegistrationOpen'], 2); ?>.</div>
	<?php }
	if ($section == "default") 		include (SECTIONS.'default.sec.php');
	if ($section == "login")		include (SECTIONS.'login.sec.php');
	if ($section == "rules") 		include (SECTIONS.'rules.sec.php');
	if ($section == "entry") 		include (SECTIONS.'entry_info.sec.php');
	if ($section == "sponsors") 	include (SECTIONS.'sponsors.sec.php');
	if ($section == "past_winners") include (SECTIONS.'past_winners.sec.php');
	if ($section == "contact") 		include (SECTIONS.'contact.sec.php');
	if (isset($_SESSION['loginUsername'])) {
		if ($row_user['userLevel'] == "1") {
			if ($section == "list") 	include (SECTIONS.'list.sec.php');
			if ($section == "pay") 		include (SECTIONS.'pay.sec.php');
			if ($section == "admin")	include (ADMIN.'default.admin.php');
			if ($section == "brewer") 	include (SECTIONS.'brewer.sec.php');
			if ($section == "brew") 	include (SECTIONS.'brew.sec.php');
			if ($section == "judge") 	include (SECTIONS.'judge.sec.php');
			if ($section == "user") 	include (SECTIONS.'user.sec.php');
			if ($section == "beerxml")	include (SECTIONS.'beerxml.sec.php');
			}
		}
  }
  // Check if registration close date has passed. If so, display "registration end" message.
  elseif (greaterDate($today,$row_contest_info['contestRegistrationDeadline'])) {
	if ((($section != "admin") || ($row_user['userLevel'] != "1")) && (judging_date_return())) { ?>
    <div class="closed">Registration has closed.</div>
	<?php }  
	if ($section == "default") 		include (SECTIONS.'default.sec.php');
	if ($section == "login")		include (SECTIONS.'login.sec.php');
	if ($section == "rules") 		include (SECTIONS.'rules.sec.php');
	if ($section == "entry") 		include (SECTIONS.'entry_info.sec.php');
	if ($section == "sponsors") 	include (SECTIONS.'sponsors.sec.php');
	if ($section == "past_winners") include (SECTIONS.'past_winners.sec.php');
	if ($section == "contact") 		include (SECTIONS.'contact.sec.php');
	if (isset($_SESSION['loginUsername'])) {
		if ($section == "list") 	include (SECTIONS.'list.sec.php');
		if ($section == "pay") 		include (SECTIONS.'pay.sec.php');
		if ($row_user['userLevel'] == "1") {
			if ($section == "admin")	include (ADMIN.'default.admin.php');
			if ($section == "brewer") 	include (SECTIONS.'brewer.sec.php');
			if ($section == "brew") 	include (SECTIONS.'brew.sec.php');
			if ($section == "judge") 	include (SECTIONS.'judge.sec.php');
			if ($section == "user") 	include (SECTIONS.'user.sec.php');
			if ($section == "beerxml")	include (SECTIONS.'beerxml.sec.php');
			}
		}
  } else { // If registration is not closed
	if ($section == "register") 	include (SECTIONS.'register.sec.php');
	if ($section == "login")		include (SECTIONS.'login.sec.php');
	if ($section == "rules") 		include (SECTIONS.'rules.sec.php');
	if ($section == "entry") 		include (SECTIONS.'entry_info.sec.php');
	if ($section == "default") 		include (SECTIONS.'default.sec.php');
	if ($section == "sponsors") 	include (SECTIONS.'sponsors.sec.php');
	if ($section == "past_winners") include (SECTIONS.'past_winners.sec.php');
	if ($section == "contact") 		include (SECTIONS.'contact.sec.php');
	if (isset($_SESSION['loginUsername'])) {
		if ($row_user['userLevel'] == "1") { if ($section == "admin")	include (ADMIN.'default.admin.php'); }
		if ($section == "brewer") 	include (SECTIONS.'brewer.sec.php');
		if ($section == "brew") 	include (SECTIONS.'brew.sec.php');
		if ($section == "pay") 		include (SECTIONS.'pay.sec.php');
		if ($section == "list") 	include (SECTIONS.'list.sec.php');
		if ($section == "judge") 	include (SECTIONS.'judge.sec.php');
		if ($section == "user") 	include (SECTIONS.'user.sec.php');
		if ($section == "beerxml")	include (SECTIONS.'beerxml.sec.php');
	}
  } // End registration date check.
  if ((!isset($_SESSION['loginUsername'])) && (($section == "admin") || ($section == "brewer") || ($section == "brew") || ($section == "user") || ($section == "judge") || ($section == "list") || ($section == "pay") || ($section == "beerXML"))) { ?>  
  <div id="header">	
	<div id="header-inner"><h1><?php echo $header_output; ?></h1></div>
  </div>
  <div class="error">Please register or log in to access this area.</div>
  <?php } ?>
  </div>
</div>
</div>
<a name="bottom"></a>
<div id="footer">
	<div id="footer-inner"><?php include (SECTIONS.'footer.sec.php'); ?></div>
</div>
</body>
</html>
<?php } ?>