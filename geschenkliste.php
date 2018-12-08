<?php

function geschenkliste_anzeigen() {
	if ($_SESSION["level"] < 4):
		echo "<h2>Schenken</h2>";

		echo '<content>';

		echo '<div style="float: left; margin: 5px;"><a href="?do=geschenkliste_erfassen&amount=50"><img src="bilder/wine.jpg" alt="CHF 50" width=300 height=300></a></div>';
		echo '<div style="float: left; margin: 5px;"><a href="?do=geschenkliste_erfassen&amount=100"><img src="bilder/wine.jpg" alt="CHF 100" width=300 height=300></a></div>';
		echo '<div style="float: left; margin: 5px;"><a href="?do=geschenkliste_erfassen&amount=150"><img src="bilder/wine.jpg" alt="CHF 150" width=300 height=300></a></div>';
		echo '<div style="float: left; margin: 5px;"><a href="?do=geschenkliste_erfassen&amount=0"><img src="bilder/wine.jpg" alt="Freier Betrag" width=300 height=300></a></div>';

		echo '</content>';
	else:
		anmeldung_erforderlich();
	endif;
}

function geschenkliste_erfassen() {

$randomId = rand(1000,9999);

?><content>
<h2>Schenken</h2>
<form method="post">

	<p>	
	<label for="name">Name<br></label>
	<input type="hidden" name="do" value="geschenkliste_schenken4">
	<input type="hidden" name="randomId" value="<?php echo $randomId; ?>">
	<input type="text" name="name" id="name">
	</p>
	<p>	
	<label for="email">E-Mail-Adresse<br></label>
	<input type="email" name="email" id="email">
	</p>
	<p>	
	<label for="amount">Betrag in CHF<br></label>
	<input type="text" name="amount" id="amount" value="<?php echo $_GET["amount"]; ?>">
	</p>
	<p>	
	<label for="message">Deine Mitteilung<br></label>
	<textarea type="text" name="message" id="message" placeholder="Schreibe hier deinen Kommentar ..."></textarea>
	</p>
	<p>	
	<button type="submit">Schenken</button>
	</p>
		  
</form>
</content>
<?php }

function geschenkliste_schenken4() {
	if ($_SESSION["level"] < 4) {
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
			'amount' => [
				'falsch' => strlen( $_POST[ 'amount' ] ) < 1,
				'meldung' => 'Bitte trage einen Betrag ein'
			]
		];

		$check_ok = TRUE;
		foreach( $check as $feld ) {
			if ( $feld[ 'falsch' ] ) {
				$check_ok = FALSE;
				meldung_erfassen($feld[ 'meldung' ], "fehler");
			}
		}

		if ($check_ok) {
			// Werte bereinigen
			$randomId = filter_input(INPUT_POST, 'randomId', FILTER_SANITIZE_NUMBER_INT);
			$amount = filter_input(INPUT_POST, 'amount', FILTER_SANITIZE_STRING);
			$message = filter_input( INPUT_POST, 'message', FILTER_SANITIZE_STRING );
			$name = filter_input( INPUT_POST, 'name', FILTER_SANITIZE_STRING );
			$email = filter_input( INPUT_POST, 'email', FILTER_VALIDATE_EMAIL );

			// Kommentar in der Datenbank speichern
			$sql = 'INSERT INTO
						gift (name, bemerkung, betrag, randomid, email)
					VALUES (
					"' . $name . '",
					"' . $message . '",
					"' . $amount . '",
					"' . $randomId . '",
					"' . $email . '"
					)';

			// ausführen
			$res = db ($sql);

			meldung_erfassen("Vielen Dank für deinen Beitrag.");
			return TRUE;

		} else {
			meldung_erfassen("Bitte fülle das Formular korrekt aus.");
			return FALSE;
		}
	}
}

function geschenkliste_danke() {
	?><content>
	<h2>Schenken</h2>
	Bitte tätige eine Überweisung an die IBAN: <strong><?php echo IBAN; ?></strong><br />
	Wichtig ist, dass du bei der Bemerkung die Zahl <strong><?php echo $_POST[ 'randomId' ]; ?></strong> eingibst.<br />
	<br />
	Diese Angaben werden zusätzlich an die angegebene E-Mailadresse versendet, falls die Zahlung später erfolgen wird.
	</content>
<?php }

function geschenkliste_als_csv_herunterladen() {
		// Alle Geschenke holen
		$res = db( 'SELECT * FROM gift ORDER BY name' );
		
		$dateiname = 'geschenkliste-' . date( 'Y-m-d-H:i' ) . '.csv';
		
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