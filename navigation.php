<?php

function render_navigation_link($url, $name) {
	
	$server_url = substr($_SERVER[REQUEST_URI], (strpos($_SERVER[REQUEST_URI], '?') + 1));
	$request_check = substr($server_url, 0, strlen($url));
	
	if ($request_check === $url) {
		$css_class = ' class="current_page"';
	} else {
		$css_class = "";
	}

	// dirty workaround!
	if (strlen($url) != strlen($server_url) ) {
		$css_class = "";
	}
	
	return "<a href='?" . $url . "'" . $css_class . ">" . $name . "</a>";
}

function show_navigation() {

	echo "<navigation class='nav'><ul>";
	echo "<li>" . render_navigation_link("", "Willkommen") . "</li>";

	if ($_SESSION["level"] <= 1 || $_SESSION["level"] === 99) {
			echo "<li>" . render_navigation_link("do=festprogramm_anzeigen", "Programm") . "</li>";
	}
	if ($_SESSION["level"] <= 2) {
		echo "<li>" . render_navigation_link("do=festprogramm_detailliert_anzeigen", "Detailprogramm") . "</li>";
	}

	echo "<li>" . render_navigation_link("do=registrierung_anzeigen", "An-/Abmeldung") . "</li>";
	if ($_SESSION["level"] <= 3) {
		echo "<li>" . render_navigation_link("do=geschenkliste_anzeigen", "Schenken") . "</li>";
		echo "<li>" . render_navigation_link("do=fotoalbum_anzeigen", "Fotos") . "</li>";
		echo "<li>" . render_navigation_link("do=gaestebuch_anzeigen", "Gästebuch") . "</li>";
		echo "<li>" . render_navigation_link("do=kontaktformular_anzeigen", "Kontakt") . "</li>";
	}
	
	if ($_SESSION["level"] <= 1) {
		echo "<li>" . render_navigation_link("do=admin", "Admin") . "</li>";
	}

	echo "</ul></navigation>";
}

function show_admin_navigation() {
	if ($_SESSION["level"] <= 1) { ?>
		<content>
			<p><a href="?do=fotoalbum_administration"><i class="far fa-arrow-alt-circle-right"></i>Manager Fotoalbum</a></p>
			<p><a href="?do=anmeldungen_als_csv_herunterladen"><i class="far fa-arrow-alt-circle-right"></i>Download Gästeliste</a></p>
			<p><a href="?do=geschenkliste_als_csv_herunterladen"><i class="far fa-arrow-alt-circle-right"></i>Download Geschenkliste</a></p>
		</content>
<?php }
 }
?>