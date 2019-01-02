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
	<div>
		<img src="bilder/kopfzeile_paartext_wir-01.svg" alt="Wir" height="200" width="700" class="paartext-1">
		<img src="bilder/kopfzeile_paartext_namen-01.svg" alt="Sibylle&Stefan" height="200" width="700" class="paartext-2">
	<!--<img src="bilder/kopfzeile_paartext_wir.png" class="paartext-1" > <img src="bilder/kopfzeile_paartext_namen.png" class="paartext-2">-->
	</div>	
	</logo>
		
	<date>
	<div> <img src="bilder/schiefertafel_datum_frei.png" alt="Schiefertafel" class="datumtafel"></div>	
	</date>

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
	
	<div><h1>Herzlich willkommen auf unserer Hochzeits-Website</h1></div>
		
	<div><img src="bilder/paar_foto_1.jpg" alt="Paar" class="welcome_image" id="slideshow"></div>
	   
		<script>
		   function changeImage()
    {
        var img = document.getElementById("slideshow");
        img.src = bilder[x];
        x++;

        if(x >= bilder.length){
            x = 0;
        } 

        setTimeout("changeImage()", 5000);
    }

    x = 1;

     var bilder = ["bilder/paar_foto_1.jpg",
				   "bilder/paar_foto_2.jpg",
                   "bilder/paar_foto_3.jpg",
                   "bilder/paar_foto_4.jpg",
				   "bilder/paar_foto_5.jpg",
				   "bilder/paar_foto_6.jpg",
				   "bilder/paar_foto_7.jpg"];
			
	 setTimeout("changeImage()", 5000);
			
		</script>
		
	</content>
<?php } 

function html_footer() { ?>
	<footer>
	
	<div id="impressum">
	<p>Alle Inhalte &copy; 2019 <a href="<?php echo ADMIN_HOMEPAGE; ?>" target="_blank"><?php echo ADMIN_HOMEPAGE; ?></a>
	<a href="mailto:<?php echo ADMIN_EMAIL; ?>"> | E-Mail</a></p>
	</div>
	
	</footer>

	<div id="totop">
	<a href="#top"><i class="fas fa-arrow-circle-up fa-2x" aria-hidden="true"></i></a>
	</div>
	</body>
	</html>
<?php } 

function login_required() { ?>
	<content>
	<h2>Du bist nicht eingeloggt!</h2>
	<br>
	<p>Um diesen Inhalt zu sehen, musst du dich einloggen.</p>
	</content>
<?php } 

?>