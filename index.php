<?php
// zeitlimitierte Sitzung. Der Benutzer bleibt angemeldet auf der Homepage, solange er diese nicht beendet/schliesst
session_start();

// Fehlerausgabe aktivieren
//error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

// setzt das level für (nicht angemeldete) gäste der Website
if (!isset($_SESSION["level"])) {
	$_SESSION["level"] = 99;
}

setlocale(LC_ALL, 'de_CH.UTF-8');

//konfiguration einlesen
include("config.php");

//login funktionen einlesen
include("login.php");

//nagivation einlesen
include("navigation.php");

//html funktionen einlesen
include("html.php");

//helfer funktionen einlesen
include("helper.php");

//seiten funktionen einlesen
include("gaestebuch.php");

include("anmeldeformular.php");

include("fotoalbum.php");

include("kontaktformular.php");

include("festprogramm.php");

include("geschenkliste.php");

// Navigation übersteuern, null inizialisiert
$nav_override = null;

// Verzweigung, was wollen wir eigentlich tun mit Formularen?
switch ($_POST["do"]) {
	// Authentifizierungs-Funktionen
	case 'login':
		login($_POST["login"], $_POST["password"]);
		break;

	case 'logout':
		logout();
		break;

	case 'gaestebuch_eintrag':
		gaestebuch_eintrag();
		// Browser nach dem Eintrag ins Gästebuch auf den "normalen" gästebuch anzeigen link schicken
		header("Location: ?do=gaestebuch_anzeigen");
		exit();
		break;
		
	case 'gaestebuch_eintrag_loeschen':
		gaestebuch_eintrag_loeschen();
		$nav_override = 'gaestebuch_anzeigen';
		break;
		
	case 'registrieren_eintrag':
		registrieren_eintrag();
		header("Location: ?do=registrierung_anzeigen");
		exit();
		break;
		
	case 'fotoalbum_verarbeiten':
		fotoalbum_verarbeiten();
		header("Location: ?do=fotoalbum_anzeigen");
		exit();
		break;
		
	case 'fotoalbum_foto_loeschen':
		fotoalbum_foto_loeschen();
		$nav_override = 'fotoalbum_administration';
		break;
		
	case 'kontaktformular_senden':
		kontaktformular_senden();
		header("Location: ?do=kontaktformular_anzeigen");
		exit();
		break;

	case 'geschenkliste_schenken4';
		html_header("Schenken");
		if (geschenkliste_schenken4()) {
			$nav_override = 'geschenkliste_danke';
		} else {
			$nav_override = 'geschenkliste_erfassen';
		}
		break;
}

// verzweigung, was wollen wir eigentlich tun mit Links?
if (! $nav_override) {
	$nav_override = $_GET["do"];
}
switch ($nav_override){
	case 'admin';
		html_header("Administration");
		show_navigation();
		show_admin_navigation();
		html_footer();
		break;
		
	// gästebuch funktionen
	case 'gaestebuch_anzeigen';
		html_header("Gästebuch");
		show_navigation();
		gaestebuch_anzeigen();
		html_footer();
		break;
		
	case 'registrierung_anzeigen';
		html_header("Gäste-Registrierung");
		show_navigation();
		registrierung_anzeigen();
		html_footer();
		break;
		
	case 'anmeldungen_als_csv_herunterladen':
		anmeldungen_als_csv_herunterladen();
		break;
		
	case 'fotoalbum_anzeigen';
		html_header("Foto-Album");
		show_navigation();
		fotoalbum_anzeigen();
		html_footer();
		break;
	
	case 'fotoalbum_administration';
		html_header("Foto-Album Administration");
		show_navigation();
		fotoalbum_administration();
		html_footer();
		break;
		
	case 'kontaktformular_anzeigen';
		html_header("Kontaktformular");
		show_navigation();
		kontaktformular_anzeigen();
		html_footer();
		break;
		
	case 'festprogramm_anzeigen';
		html_header("Festprogramm");
		show_navigation();
		festprogramm_anzeigen();
		html_footer();
		break;

	case 'festprogramm_detailliert_anzeigen';
		html_header("Detailliertes Festprogramm");
		show_navigation();
		festprogramm_detailliert_anzeigen();
		html_footer();
		break;

	case 'geschenkliste_anzeigen';
		html_header("Schenken");
		show_navigation();
		geschenkliste_anzeigen();
		html_footer();
		break;
		
	case 'geschenkliste_erfassen';
		html_header("Schenken");
		show_navigation();
		geschenkliste_erfassen();
		html_footer();
		break;

	case 'geschenkliste_danke';
		html_header("Schenken");
		show_navigation();
		geschenkliste_danke();
		html_footer();
		break;

	case 'geschenkliste_als_csv_herunterladen':
		geschenkliste_als_csv_herunterladen();
		break;
		
	// standard seite
	default:
		default_page();
}

function default_page() {
	html_header("Start Seite");
	show_navigation();
	welcome_page();
	html_footer();

}

?>
