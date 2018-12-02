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
	echo "<li>" . render_navigation_link("do=festprogramm_anzeigen", "Festprogramm") . "</li>";
	echo "<li>" . render_navigation_link("do=fotoalbum_anzeigen", "Fotoalbum") . "</li>";
	echo "<li>" . render_navigation_link("do=gaestebuch_anzeigen", "Gästebuch") . "</li>";
	echo "<li>" . render_navigation_link("do=kontaktformular_anzeigen", "Kontakt") . "</li>";
	echo "<li>" . render_navigation_link("do=registrierung_anzeigen", "Registrierung Gäste") . "</li>";
	echo "<li>" . render_navigation_link("do=wunschliste_anzeigen", "Wunschliste") . "</li>";
	
	if ($_SESSION["level"] === 0) {
		echo "<li>" . render_navigation_link("do=admin", "Administration") . "</li>";
	}

	echo "</ul></navigation>";
}

function show_admin_navigation() { ?>
	<content>
		<p><a href="?do=fotoalbum_administration"><i class="far fa-arrow-alt-circle-right"></i>&nbsp;Manager Fotoalbum</a></p>

		<p><a href="?do=registrieren_administration"><i class="far fa-arrow-alt-circle-right"></i>&nbsp;Download Gästeliste</a></p>
	
	</content>

<?php }
?>