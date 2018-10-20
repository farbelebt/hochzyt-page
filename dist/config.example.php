<?php

// DB Settings
define( 'DB_HOST', 'localhost' );
define( 'DB_NAME', 'dbname' );
define( 'DB_USERNAME', 'dbuser' );
define( 'DB_PASSWORD', '' );
define( 'DB_CHARSET', 'UTF8' );

// Site Settings
define ( 'ADMIN_EMAIL', 'info@yourdomain.tld' );
define ( 'ADMIN_HOMEPAGE', 'https://yourdomain.tld' );
define ( 'ADMIN_NAME', 'Your name' );
define ( 'CONTACT_EMAIL', 'donotreply@yourdomain.tld' );
define ( 'CONTACT_FROM_NAME', 'Hochzeit von Braut und Bräutigam' );
define ( 'CONTACT_SUBJECT', 'Betreff der Mail' );


// Google Maps
define ( 'GOOGLE_MAPS_API_KEY', '' );
	
// Social Links
define ( 'SOCIAL_PINTEREST', 'https://www.pinterest.com/.../' );

// passwort_erstellen.php?pw=wechslemich

$users[1] = array(
	'login' => 'brautpaar',
	'password' => '',
	'level' => 1,
	'displayname' => 'Braut und Bräutigam'
);

$users[2] = array(
	'login' => 'admin',
	'password' => '',
	'level' => 0,
	'displayname' => 'Administrator'
);

$users[3] = array(
	'login' => 'gast',
	'password' => '',
	'level' => 2,
	'displayname' => 'Hochzeitsgast'
);

$users[4] = array(
	'login' => 'verein',
	'password' => '',
	'level' => 3,
	'displayname' => 'Verein'
);

$GLOBALS["users"] = $users;


$GLOBALS["message_styles"] = array();
$GLOBALS["message_styles"]['info'] = "far fa-check-circle";
$GLOBALS["message_styles"]['fehler'] = "fas fa-exclamation-triangle";

?>
