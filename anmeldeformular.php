<?php

function dropdown_anzahl($name, $max = 50){
	echo '<select name="' . $name . '">';
	for ($x = 0; $x <= $max; $x++) {
		echo '<option value="' . $x . '">' . $x . '</option>';
	}
	echo '</select>';
}

function registrierung_anzeigen() {
	if ($_SESSION["level"] < 4):
		echo '<content>';
		registrieren_formular();
		echo '</content>';
	else:
		anmeldung_erforderlich();
	endif;
}

function registrieren_eintrag() {
	if ($_SESSION["level"] < 4) {

		// Fehler-Erfassung
		$check = [
			'vorname' => [
				'falsch' => strlen( $_POST[ 'vorname' ] ) < 3,
				'meldung' => 'Bitte trage ein Vorname ein'
			],
			'name' => [
				'falsch' => strlen( $_POST[ 'name' ] ) < 3,
				'meldung' => 'Bitte trage ein Nachname ein'
			],
			'strasse' => [
				'falsch' => strlen( $_POST[ 'strasse' ] ) < 3,
				'meldung' => 'Bitte trage eine Strasse ein'
			],
			'postleitzahl' => [
				'falsch' => strlen( $_POST[ 'postleitzahl' ] ) < 4,
				'meldung' => 'Bitte trage eine gültige Postleitzahl ein'
			],
			'ort' => [
				'falsch' => strlen( $_POST[ 'ort' ] ) < 3,
				'meldung' => 'Bitte trage eine Ortschaft ein'
			],
			'email' => [
				'falsch' => ! filter_var( $_POST[ 'email' ], FILTER_VALIDATE_EMAIL ),
				'meldung' => 'Bitte trage eine korrekte E-Mail-Adresse ein'
			],
		];

		// $check durchgehen und schauen, ob eines der Felder einen
		// Fehler erzeugt hat. Gleichzeitig sammeln wir die entsprechenden
		// Meldungen ein. Wir gehen davon aus, dass alles ok ist.
		$check_ok = TRUE;
		// Stimmt das?
		foreach( $check as $feld ) {
			if ( $feld[ 'falsch' ] ) {
				$check_ok = FALSE;
				meldung_erfassen($feld[ 'meldung' ], "fehler");
			}
		}

		if ($check_ok) {
			// Werte bereinigen
			$vorname = filter_input( INPUT_POST, 'vorname', FILTER_SANITIZE_STRING );
			$name = filter_input( INPUT_POST, 'name', FILTER_SANITIZE_STRING );
			$firma_verein = filter_input( INPUT_POST, 'firma_verein', FILTER_SANITIZE_STRING );
			$strasse = filter_input( INPUT_POST, 'strasse', FILTER_SANITIZE_STRING );
			$postleitzahl = filter_input( INPUT_POST, 'postleitzahl', FILTER_SANITIZE_NUMBER_INT );
			$ort = filter_input( INPUT_POST, 'ort', FILTER_SANITIZE_STRING );
			$email = filter_input( INPUT_POST, 'email', FILTER_VALIDATE_EMAIL );
			$bemerkung = filter_input( INPUT_POST, 'bemerkung', FILTER_SANITIZE_STRING );

			// Angaben in der Datenbank speichern

			if ($_POST['teilnahme'] == "ja") {
				$teilnahme = "Ja";	
			} else {
				$teilnahme = "Nein";
			}

			$sql = 'INSERT INTO
						guest_register (teilnahme, anrede, vorname, name, firma_verein, strasse, postleitzahl, ort, email, erw_apero, erw_fleisch, erw_vegetarisch, erw_kleineportion, kind_apero, kind_fleisch, kind_vegetarisch, kind_kleineportion, bemerkung)
					VALUES (
					"' . $teilnahme . '",
					"' . $_POST['anrede'] . '",
					"' . $vorname . '",
					"' . $name . '",
					"' . $firma_verein . '",
					"' . $strasse . '",
					"' . $postleitzahl . '",
					"' . $ort . '",
					"' . $email . '",
					"' . $_POST['erw_apero'] . '",
					"' . $_POST['erw_fleisch'] . '",
					"' . $_POST['erw_vegetarisch'] . '",
					"' . $_POST['erw_kleineportion'] . '",
					"' . $_POST['kind_apero'] . '",
					"' . $_POST['kind_fleisch'] . '",
					"' . $_POST['kind_vegetarisch'] . '",
					"' . $_POST['kind_kleineportion'] . '",
					"' . $bemerkung . '"
					)';

			// ausführen
			$res = db ($sql);
			if ($res) {
				meldung_erfassen("Anmeldung erfolgreich erfasst.");
			} else {
				meldung_erfassen("Anmeldung war NICHT erfolgreich.", "fehler");
			}
		}
	}
}

function registrieren_formular(){ ?>
<h2>An- und Abmeldung zum Fest</h2>
<br>
<h3>Wir bitten um eure definitive An- oder Abmeldung zu unserem Hochzeitsfest bis spätestens 31. Januar 2019</h3>
<br>
<form method="post">
<script type="text/javascript" language="javascript">
 function toggleVisibility(cb)
 {
  var x = document.getElementById("teilnehmer");
  if(cb.checked==true)
   x.style.display = "block";
  else
   x.style.display = "none";
 }
</script>
	<input type="hidden" name="do" value="registrieren_eintrag">
	<p><input type="checkbox" style="width: auto;" checked="checked" onClick="toggleVisibility(this)" name="teilnahme" value="ja" /> Ja, ich/wir nehmen gerne teil.</p>
	<br>
	<table id="teilnehmer">
		<tr><td colspan="3">Bitte hier die Gesamtanzahl der Personen, entsprechend der Menüauswahl, eintragen. Wichtig: Die Teilnahme an Apéro und/oder Fest separat eintragen.</td></tr>
		<tr>
			<th>Erwachsene</th>
			<th>Kinder</th>
			<th>Menuwahl</th>
		</tr>
		<tr>
			<td><?php dropdown_anzahl("erw_apero"); ?></td>
			<td><?php dropdown_anzahl("kind_apero"); ?></td>
			<td>nehmen am Apéro teil.</td>
		</tr>
	<?php if ($_SESSION["level"] <= 2): ?>
		<tr>
			<td><?php dropdown_anzahl("erw_fleisch"); ?></td>
			<td><?php dropdown_anzahl("kind_fleisch"); ?></td>
			<td>essen das Menu mit Fleisch.</td>
		</tr>
		<tr>
			<td><?php dropdown_anzahl("erw_vegetarisch"); ?></td>
			<td><?php dropdown_anzahl("kind_vegetarisch"); ?></td>
			<td>essen das vegetarische Menu.</td>
		</tr>
		<tr>
			<td><?php dropdown_anzahl("erw_kleineportion"); ?></td>
			<td><?php dropdown_anzahl("kind_kleineportion"); ?></td>
			<td>essen eine kleine Portion.</td>
		</tr>
	<?php else: ?>
		<input type="hidden" name="erw_fleisch" value="0">
		<input type="hidden" name="kind_fleisch" value="0">
		<input type="hidden" name="erw_vegetarisch" value="0">
		<input type="hidden" name="kind_vegetarisch" value="0">
		<input type="hidden" name="erw_kleineportion" value="0">
		<input type="hidden" name="kind_kleineportion" value="0">
	<?php endif; ?>
	</table>

	<p>Anrede</p>
	<p>
		<select name="anrede">
			<option value="Frau">Frau</option>
  			<option value="Herr">Herr</option>
  			<option value="Familie">Familie</option>
 			<option value="Firma">Firma</option>
			<option value="Verein">Verein</option>
		</select> 
	</p>
	
	<p>	
	<label for="vorname">Vorname<br></label>
	<input type="text" name="vorname" id="vorname">
	</p>
	<p>	
	<label for="name">Nachname<br></label>
	<input type="text" name="name" id="name">
	</p>
	<p>	
	<p>	
	<label for="firma_verein">Firma/Verein<br></label>
	<input type="text" name="firma_verein" id="firma_verein">
	</p>
	<p>	
	<label for="strasse">Strasse/Nr.<br></label>
	<input type="text" name="strasse" id="strasse">
	</p>
	<p>	
	<label for="postleitzahl">Postleitzahl<br></label>
	<input type="text" name="postleitzahl" id="postleitzahl">
	</p>
	<p>	
	<label for="ort">Ort<br></label>
	<input type="text" name="ort" id="ort">
	</p>
	<p>	
	<label for="email">E-Mail<br></label>
	<input type="email" name="email" id="email">
	</p>	

	<p>	
	<label for="bemerkung"></label>
	<textarea type="text" name="bemerkung" id="bemerkung" placeholder="Zusätzliche Bemerkungen zu Allergien/Unverträglichkeiten oder Sonstiges ..."></textarea>
	</p>
	
	<p>	
	<button type="submit">Abschicken</button>
	</p>
	<p class="klein">Deine Daten werden nicht veröffentlicht und weitergegeben.</p>
		  
</form>

<?php

}

// administrative funktionen
function registrieren_administration() {
	echo '<content>';
	if ($_SESSION["level"] <= 2): ?>
		
		<h2>Administration der Gäste-Registrierung</h2>
		<p>Hiermit könnt ihr die Gästeliste als csv-Datei (mit dem aktuellen Datum) herunterladen.</p>
		<p><a href="/?do=csv" download target="blank"><i class="fas fa-file-alt fa-2x"></i>&nbsp;Jetzt herunterladen</a></p>
	
		</content>
	<?php endif;
}

function anmeldungen_als_csv_herunterladen() {
		// Alle Anmeldungen holen
		$res = db( 'SELECT * FROM guest_register ORDER BY name, vorname' );
		
		$dateiname = 'anmeldungen-' . date( 'Y-m-d-H:i' ) . '.csv';
		
		header('Content-Type: text/csv');
		header('Content-Disposition: attachment; filename="' . $dateiname . '"');
		
		$fp = fopen( 'php://output', 'w' );
		$titelZeileGeschrieben = FALSE;
		while( $row = mysqli_fetch_assoc( $res ) ) {
			if ( ! $titelZeileGeschrieben ) {
				$spalten = array_keys( $row );
				fputcsv( $fp, $spalten );
				$titelZeileGeschrieben = TRUE;
			}
			
			fputcsv( $fp, $row );
		}
		fclose( $fp );
		exit;
		
	}
?>
