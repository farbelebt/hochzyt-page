<?php

function html_header($titel = "") {
	?><!DOCTYPE html>
	<html>
	<head>
	<meta charset="UTF-8">
	<title>Hochzyt Sibylle&amp;Stefan</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.4.1/jquery.fancybox.min.css" />
	<link rel="stylesheet" type="text/css" href="style.css">

	<script src="//code.jquery.com/jquery-3.3.1.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.4.1/jquery.fancybox.min.js"></script>
	<script src="js/totop.js"></script>
	
	<link rel="icon" href="bilder/favicon.png" sizes="32x32" />

	</head>
	
	<body>
		
	<logo>
	<div class="heading_text"><img src="bilder/herz.png" alt="Baumherz" class="herzlogo"></div>	
	</logo>

	<aside>
	<div>
	<?php show_login_form(); ?>
	</div>
	<div>
	<?php meldungen_anzeigen(); ?>
	</div>
	</aside>
<?php } 

function welcome_page() { ?>
	<content>
	
	<div>
	<h1>Herzlich willkommen auf unserer Hochzeits-Website</h1>
	</div>
	
	<div>
	<img src="bilder/Depositphotos_121292774_web.jpg" alt="Paarbild" class="welcome_image">
	</div>
	
	</content>
<?php } 

function html_footer() { ?>
	<footer>
	<div id="socialmedia">	
	<a href="<?php echo SOCIAL_PINTEREST; ?>" target="_blank"><i class="fab fa-pinterest-square fa-2x" aria-hidden="true"></i></a>
	</div>
	
	<div id="impressum">
	<p>Alle Inhalte &copy; 2018 <a href="<?php echo ADMIN_HOMEPAGE; ?>" target="_blank"><?php echo ADMIN_HOMEPAGE; ?></a>
	<a href="mailto:<?php echo ADMIN_EMAIL; ?>"> | E-Mail</a></p>
	</div>
	
	</footer>

	<div id="totop">
	<a href="#top"><i class="fas fa-arrow-circle-up fa-2x" aria-hidden="true"></i></a>
	</div>
	</body>
	</html>
<?php } 

function anmeldung_erforderlich() { ?>
	<content>
	<h2>Du bist nicht angemeldet!</h2>
	<br>
	<p>Um diesen Inhalt zu sehen, musst du dich einloggen.</p>
	</content>
<?php } 

?>