<?php

function gaestebuch_anzeigen() {
	if ($_SESSION["level"] <= 3):
		echo '<content>';

		gaestebuch_formular();

		$zeiger = db( 'SELECT * FROM guestbook ORDER BY datum DESC' );

		while($kommentar = mysqli_fetch_assoc($zeiger)){
			$sekunden = strtotime($kommentar['datum']);

			?><div class="blog_background"><?php
			echo '<p class="klein">' . $kommentar["name"] . ' schrieb am ' . strftime('%A, %e. %B %Y', $sekunden) . '</p>';
			echo '<p>' . '<i class="fas fa-quote-left fa-2x" style="color:steelblue"></i>&nbsp;&nbsp;' . str_replace("\n", '<br>', $kommentar["nachricht"]) . '<i class="fas fa-quote-right fa-2x" style="color:steelblue; float:right;"></i>' . '</p>';

			if ($_SESSION["level"] <= 1) {
				echo '<form method="post">';
				echo '<input type="hidden" name="do" value="gaestebuch_eintrag_loeschen">';
				echo '<input type="hidden" name="id" value="' . $kommentar["ID"] . '">';
				echo '<button type="submit">Eintrag löschen</button>';
				echo '</form>';
			}
			echo '</div><br><br>';
		}

		echo '</content>';
	else:
		anmeldung_erforderlich();
	endif;
}

function gaestebuch_eintrag() {
	if ($_SESSION["level"] <= 3) {
		// Fehler-Erfassung
		$check = [
			'name' => [
				'falsch' => strlen( $_POST[ 'name' ] ) < 3,
				'meldung' => 'Bitte trage einen Namen ein'
			],
			'email' => [
				'falsch' => ! filter_var( $_POST[ 'email' ], FILTER_VALIDATE_EMAIL ),
				'meldung' => 'Bitte trage eine korrekte E-Mail-Adresse ein'
			],
			'nachricht' => [
				'falsch' => strlen( $_POST[ 'nachricht' ] ) < 10,
				'meldung' => 'Bitte schreib deinen Kommentar'
			]
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
			$name = filter_input( INPUT_POST, 'name', FILTER_SANITIZE_STRING );
			$email = filter_input( INPUT_POST, 'email', FILTER_VALIDATE_EMAIL );
			$nachricht = filter_input( INPUT_POST, 'nachricht', FILTER_SANITIZE_STRING );

			// Kommentar in der Datenbank speichern
			$sql = 'INSERT INTO
						guestbook (name, email, datum, nachricht)
					VALUES (
					"' . $name . '",
					"' . $email . '",
					NOW(),
					"' . $nachricht . '"
					)';

			// ausführen
			$res = db ($sql);

			meldung_erfassen("Vielen Dank. Dein Gästebucheintrag ist gespeichert.");
		}
	}
}

function gaestebuch_eintrag_loeschen() {
	
	// Löschen-Rechte im Formular (Button), sowie in der db festlegen
	if ($_SESSION["level"] <= 1) {
		$sql = 'DELETE FROM guestbook 
				WHERE ID = ' . $_POST['id'];
		$res = db ($sql);
		meldung_erfassen("Gästebucheintrag gelöscht.");
	} else {
		meldung_erfassen("Keine Berechtigung zum Löschen des Eintrags.", "fehler");
	}
}

function gaestebuch_formular(){
	if ($_SESSION["level"] <= 3):
		?>
		<h2>Gästebuch</h2>
		<br>
		<h3>Wir freuen uns über Wünsche und Feedbacks zu unserer Hochzeit.</h3>
			<p>Für Anfragen etc. benütze bitte das <a href="?do=kontaktformular_anzeigen">Kontaktformular</a> an die Trauzeugen.</p>
			<br>
			

		    <form method="post">
			
			<p>	
			<label for="name">Name<br></label>
			<input type="hidden" name="do" value="gaestebuch_eintrag">
			<input type="text" name="name" id="name">
			</p>
			<p>	
			<label for="email">E-Mail-Adresse<br></label>
			<input type="email" name="email" id="email">
			</p>
			<p>	
			<label for="nachricht">Dein Kommentar<br></label>
			<textarea type="nachricht" name="nachricht" id="nachricht" placeholder="Schreibe hier deinen Kommentar ..."></textarea>
			</p>
			<p>	
			<button type="submit">Abschicken</button>
			</p>
			<p class="klein">Deine E-Mail-Adresse wird nicht veröffentlicht.</p>
				  
		</form>
		<br><?php
	endif;
}	?>