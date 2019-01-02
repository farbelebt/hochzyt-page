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
		login_required();
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
-			'email' => [
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
			$email = filter_input( INPUT_POST, 'email', FILTER_VALIDATE_EMAIL );
			$bemerkung = filter_input( INPUT_POST, 'bemerkung', FILTER_SANITIZE_STRING );

			// Angaben in der Datenbank speichern

			if ($_POST['teilnahme'] == "ja") {
				$teilnahme = "Ja";	
			} else {
				$teilnahme = "Nein";
			}

			$sql = 'INSERT INTO
						guest_register (teilnahme, vorname, name, firma_verein, email, anz_erwachsene, anz_kinder, bemerkung)
					VALUES (
					"' . $teilnahme . '",
					"' . $vorname . '",
					"' . $name . '",
					"' . $firma_verein . '",
					"' . $email . '",
					"' . $_POST['anz_erwachsene'] . '",
					"' . $_POST['anz_kinder'] . '",
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

function registrieren_formular(){
	if ($_SESSION["level"] < 4):
		?><h2>An- und Abmeldung zum Fest</h2>
		<br>
		<h3>Wir bitten um eure definitive An- oder Abmeldung zu unserem Hochzeitsfest bis spätestens 31. Januar 2019</h3>
		<br>
		<form method="post">
		<script type="text/javascript" language="javascript">
		 function showForm(cb)
		 {
		  var x = document.getElementById("teilnehmer");
		   x.style.display = "block";
		 }

		 function hideForm(cb)
		 {
		  var x = document.getElementById("teilnehmer");
		   x.style.display = "none";
		 }
		</script>
			<input type="hidden" name="do" value="registrieren_eintrag">
			<?php if ($_SESSION["level"] <= 2): ?>
				<p><input type="radio" style="width: auto;" checked onClick="showForm(this)" name="teilnahme" value="ja" /> Ja, ich/wir nehmen gerne teil.</p>
				<p><input type="radio" style="width: auto;" onClick="hideForm(this)" name="teilnahme" value="nein" /> Nein, ich/wir nehmen NICHT teil.</p>
			<?php else: ?>
				<p><input type="radio" style="width: auto;" checked onClick="showForm(this)" name="teilnahme" value="ja" /> Anmeldung JA</p>
				<p><input type="radio" style="width: auto;" onClick="hideForm(this)" name="teilnahme" value="nein" /> Anmeldung NEIN</p>
			<?php endif; ?>
			<br>

			<p>	
			<label for="vorname">Vorname<br></label>
			<input type="text" name="vorname" id="vorname">
			</p>
			<p>	
			<label for="name">Name<br></label>
			<input type="text" name="name" id="name">
			</p>

			<?php if ($_SESSION["level"] <= 2): ?>
				<input type="hidden" name="firma_verein" value="">
			<?php else: ?>
				<p>	
				<label for="firma_verein">Firma/Verein<br></label>
				<input type="text" name="firma_verein" id="firma_verein">
				</p>
			<?php endif; ?>

			<p>	
			<label for="email">E-Mail<br></label>
			<input type="email" name="email" id="email">
			</p>	

			<div id="teilnehmer">
			<?php if ($_SESSION["level"] <= 2): ?>
				<p>	
				<label for="anz_erwachsene">Anzahl Erwachsene<br></label>
				<?php dropdown_anzahl("anz_erwachsene", 10); ?>
				</p>

				<p>	
				<label for="anz_kinder">Anzahl Kinder<br></label>
				<?php dropdown_anzahl("anz_kinder", 10); ?>
				</p>

				<p>	
				<label for="bemerkung"></label>
				<textarea type="text" name="bemerkung" id="bemerkung" placeholder="Zusätzliche Bemerkungen zu Allergien/Unverträglichkeiten oder Sonstiges ..."></textarea>
				</p>
			<?php else: ?>
				<p>	
				<label for="anz_erwachsene">Anzahl Erwachsene<br></label>
				<?php dropdown_anzahl("anz_erwachsene"); ?>
				</p>

				<p>	
				<label for="anz_kinder">Anzahl Kinder<br></label>
				<?php dropdown_anzahl("anz_kinder"); ?>
				</p>

				<input type="hidden" name="bemerkung" value="">
			<?php endif; ?>
			</div>

			<p>	
			<button type="submit">Abschicken</button>
			</p>
			<p class="klein">Deine Daten werden nicht veröffentlicht und weitergegeben.</p>
				  
		</form><?php
	endif;

}

// administrative funktionen
function anmeldungen_als_csv_herunterladen() {
	if ($_SESSION["level"] <= 1):
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
	endif;		
}
?>
