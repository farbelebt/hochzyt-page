<?php

// Debug funktionen
function debug($message) {
	echo ("DEBUG: " . $message . "\n");
}

function debug_hidden($message) {
	echo ("<!-- DEBUG: " . $message . "-->\n");
}

// Meldungen
function meldung_erfassen($meldung, $typ = "info") {
	if (! is_array($_SESSION["meldungen"])) {
		$_SESSION["meldungen"] = array();
	}

	if (! $_SESSION["meldungen"][$typ]) {
		$_SESSION["meldungen"][$typ] = array();
	}
	
	array_push($_SESSION["meldungen"][$typ], $meldung);
}

function meldungen_anzeigen() {

	if ($_SESSION["meldungen"]) {
		echo '<div class="alle_meldungen">';
		foreach($_SESSION["meldungen"] as $typ => $meldungen) {
			echo '<ul class="fa-ul">';
			foreach($meldungen as $meldung) {
				echo '<li class="' . $typ . '_meldungen"><span class="fa-li"><i class="' . $GLOBALS["message_styles"][$typ] . '"></i></span>' . $meldung . '</li>';
			}
			echo '</ul>';
		}
		echo '</div>';
		$_SESSION["meldungen"] = array();
	}
}

// Datenbank funktionen
function db( $sql ) {
    // Zur Datenbank verbinden
    $verbindung = mysqli_connect( DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME );
    // Charset auf UTF-8 einstellen, damit Sonderzeichen korrekt übernommen werden
    mysqli_set_charset( $verbindung, DB_CHARSET );
    // SQL-Statement an die DB schicken
    $res = mysqli_query( $verbindung, $sql );
	
	// MySQL Fehler abfangen und als Meldung speichern
	if (! $res) {
		meldung_erfassen("MySQL Fehler: " . mysqli_error($verbindung), "fehler");
	}
	
    // Verbindung schliessen
    mysqli_close( $verbindung );
    
    // Zeiger zurückliefern
    return $res;
}

// Benutzer Funktionen
function get_username($userid) {
	return $GLOBALS["users"][$userid]["displayname"];
}

function get_userid($username) {
	foreach ($GLOBALS["users"] as $user) {
		if ($user["login"] == $username) {
			return array_search($user, $GLOBALS["users"]);
		}
	}
	return FALSE;
}

?>
