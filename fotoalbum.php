<?php

function fotoalbum_anzeigen(){
	if ($_SESSION["level"] <= 2):
		echo '<content>';

		fotoalbum_formular_anzeigen();

		// Alle vorhandenen Bilder im Ordner "uploads" als IMG einbetten
		$bilder = scandir('uploads');

		// jedes Element in $bilder als IMG schreiben
		foreach( $bilder as $bild ){
			// ist $bild "." oder ".." ?
			if ($bild == '.' || $bild == '..'){
				// gleich den nächsten Durchgang von foreach starten
				continue;
			}
			echo '<a data-fancybox="gallery" href="uploads/' . $bild . '">';
			echo '<img src="uploads/' . $bild . '" alt="" style="height:250px;margin: 10px">';
			echo '</a>';
		}

		echo '</content>';
	else:
		login_required();
	endif;
}

function fotoalbum_verarbeiten() {
	if ($_SESSION["level"] <= 2) {
		// Wurde ein JPG oder PNG hochgeladen?
		if ($_FILES['bild']['type'] == 'image/jpeg' ||
			$_FILES['bild']['type'] == 'image/png' ||
			$_FILES['bild']['type'] == 'image/pjpeg'){

			$tempOrt = ($_FILES['bild']['tmp_name']);
			if ($_FILES['bild']['type'] == 'image/png') {
				$endung = '.png';
			} else {
				$endung = '.jpg';
			}

			$zielOrt = 'uploads/' . uniqid() . $endung;
			move_uploaded_file($tempOrt, $zielOrt);

			$sql = 'INSERT INTO
						photo_album (bildpfad, originalname, datum, userid)
					VALUES (
					"' . $zielOrt . '",
					"' . $_FILES['bild']['name'] . '",
					NOW(),
					"' . $_SESSION['userid'] . '"
					)';

			// ausführen
			$res = db ($sql);
			if ($res) {
				meldung_erfassen("Foto erfolgreich hochgeladen.");
			} else {
				meldung_erfassen("Foto konnte nicht in der Datenbank hinterlegt werden.", "fehler");
			}
		} else {
			meldung_erfassen("Die hochgeladene Datei ist kein Bild vom Typ PNG oder JPG.", "fehler");
		}
	}
}


function fotoalbum_formular_anzeigen(){
	if ($_SESSION["level"] <= 2):
		?><h2>Hochzeits-Fotoalbum</h2>
		<br>
		<h3>Der schönste Tag von Sibylle und Stefan in Bildern.</h3>
		<p>Lade deine eigenen Fotos von unserem Anlass hoch. Für eine vergrösserte Ansicht der Fotos klicke auf ein Bild.</p>
		<br>

		<form method="post" enctype="multipart/form-data">
			<input type="hidden" name="do" value="fotoalbum_verarbeiten">
			
			<label>Datei hochladen:<br>
				<input type="file"
					   name="bild"
					   accept="image/jpeg,image/png">
			</label>	   
			
			<p> 
				<button type ="submit">Hochladen</button>
			</p>
		</form><?php
	endif;
}

// administrative funktionen
function fotoalbum_administration() {
	echo '<content>';
	if ($_SESSION["level"] <= 1):
		$res = db( 'SELECT * FROM photo_album ORDER BY datum DESC' );
		?>

		<h2>Administration der Fotoliste</h2>
		<br>
		<table class="table_admin">
		<tr>
		<th>Bild</th>
		<th>Originalname</th>
		<th>Benutzer</th>
		<th>Datum</th>
		<th>Löschen</th>
		</tr>

		<?php while($row = mysqli_fetch_assoc($res)): ?>
			<tr>

			<td>
			<img src="<?php echo $row['bildpfad']; ?>" alt="" style="height:50px">
			</td>

			<td>
			<?php echo $row['originalname']; ?>
			</td>

			<td>
			<?php echo get_username($row['userid']); ?>
			</td>

			<td>
			<?php echo strftime('%d. %m. %Y', strtotime($row['datum'])); ?>
			</td>

			<form method="post">
			<input type="hidden" name="do" value="fotoalbum_foto_loeschen">
			<input type="hidden" name="id" value="<?php echo $row["ID"]; ?>">
			<td>
			<button type="submit">Löschen</button>
			</td>
			</form>

			</tr>

		<?php endwhile; ?>
		</table>
	<?php endif;
	echo '</content>';
}

function fotoalbum_foto_loeschen() {
	// Löschen-Rechte im Formular (Button), sowie in der db festlegen
	if ($_SESSION["level"] <= 1) {
		
		// Infos zum Datensatz holen, damit wir ggf. das Bild löschen können
		$res = db('SELECT * FROM photo_album WHERE ID = ' . $_POST['id']);
		$row = mysqli_fetch_assoc($res);
		// Hat dieser Datensatz ein Bild?
		if ($row['bildpfad'] && file_exists($row['bildpfad'])){
			// Bild löschen
			unlink($row['bildpfad']);
		}
		
		$sql = 'DELETE FROM photo_album 
				WHERE ID = ' . $_POST['id'];
		$res = db ($sql);
		meldung_erfassen("Foto gelöscht.");
	} else {
		meldung_erfassen("Keine Berechtigung zum Löschen des Fotos.", "fehler");
	}
}


?>
