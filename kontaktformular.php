<?php

function kontaktformular_anzeigen() {
	if ($_SESSION["level"] <= 3):
		echo '<content>';
		kontakt_formular();
		echo '</content>';
	else:
		login_required();
	endif;
}


function kontakt_formular(){
	if ($_SESSION["level"] <= 3):
		?><h2>Kontaktformular an die Trauzeugen</h2>
		<br>
		<h3>Habt ihr Fragen zum Fest oder einen Beitrag für das Brautpaar?</h3>
		<p>Schreibt uns, und wir beantworten gerne eure Anliegen.</p>
		<br>
		<form method="post">
		<input type="hidden" name="do" value="kontaktformular_senden">
			
			<p>	
			<label for="vorname">Vorname<br></label>
			<input type="text" name="vorname" id="vorname">
			</p>
			<p>	
			<label for="name">Name<br></label>
			<input type="text" name="name" id="name">
			</p>
			<p>	
			<label for="email">E-Mail-Adresse<br></label>
			<input type="email" name="email" id="email">
			</p>
			<p>	
			<label for="telefon">Telefon- oder Handynummer<br></label>
			<input type="text" name="telefon" id="telefon">
			</p>
			<p>	
			<label for="betreff">Betreff<br></label>
			<input type="text" name="betreff" id="betreff">
			</p>
			<p>	
			<label for="nachricht">Deine Nachricht<br></label>
			<textarea type="nachricht" name="nachricht" id="nachricht" placeholder="Schreibe uns deine Nachricht ..."></textarea>
			</p>
			<p>	
			<button type="submit">Abschicken</button>
			</p>
			<p class="klein">Deine Angaben werden vertraulich behandelt und nicht veröffentlicht.</p>
				  
		</form><?php
	endif;
}

function kontaktformular_senden(){
	if ($_SESSION["level"] <= 3) {
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
			'email' => [
				'falsch' => ! filter_var( $_POST[ 'email' ], FILTER_VALIDATE_EMAIL ),
				'meldung' => 'Bitte trage eine korrekte E-Mail-Adresse ein'
			],
			'betreff' => [
				'falsch' => strlen( $_POST[ 'betreff' ] ) < 3,
				'meldung' => 'Bitte trage einen Betreff ein'
			],
			'nachricht' => [
				'falsch' => strlen( $_POST[ 'nachricht' ] ) < 3,
				'meldung' => 'Bitte trage eine Nachricht ein'
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
			$email = filter_input( INPUT_POST, 'email', FILTER_VALIDATE_EMAIL );
			$telefon = filter_input( INPUT_POST, 'telefon', FILTER_SANITIZE_STRING );	
			$betreff = filter_input( INPUT_POST, 'betreff', FILTER_SANITIZE_STRING );	
			$nachricht = filter_input( INPUT_POST, 'nachricht', FILTER_SANITIZE_STRING );	

			// HTML-Inhalt für die E-Mail vorbereiten
			$html = file_get_contents('mailvorlage.html');

			// In der Variable $html die Platzhalter suchen und ersetzen
			$html = str_replace('***VORNAME***', $vorname, $html);
			$html = str_replace('***NAME***', $name, $html);
			$html = str_replace('***EMAIL***', $email, $html);
			$html = str_replace('***TELEFON***', $telefon, $html);
			$html = str_replace('***BETREFF***', $betreff, $html);
			$html = str_replace('***NACHRICHT***', $nachricht, $html);

			// TEXT-Inhalt für die E-Mail vorbereiten
			$txt = file_get_contents('mailvorlage.txt');

			// In der Variable $html die Platzhalter suchen und ersetzen
			$txt = str_replace('***VORNAME***', $vorname, $txt);
			$txt = str_replace('***NAME***', $name, $txt);
			$txt = str_replace('***EMAIL***', $email, $txt);
			$txt = str_replace('***TELEFON***', $telefon, $txt);
			$txt = str_replace('***BETREFF***', $betreff, $txt);
			$txt = str_replace('***NACHRICHT***', $nachricht, $txt);

			include 'classes/PHPMailerAutoload.php';

			$notification = new PHPMailer();
			$notification ->FromName = CONTACT_FROM_NAME;
			$notification ->From = CONTACT_EMAIL;
			$notification ->Subject = CONTACT_SUBJECT;
			$notification ->IsHTML (TRUE);
			$notification ->Body = $html;
			$notification ->AltBody = $txt;
			$notification ->AddAddress(ADMIN_EMAIL, ADMIN_NAME);

			if ($notification ->Send()) {
				meldung_erfassen("Nachricht verschickt.");
			} else {
				meldung_erfassen("Nachricht konnte NICHT verschickt werden.", "fehler");
			}
		}
	}
}

?>