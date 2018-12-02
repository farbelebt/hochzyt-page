<?php

function wunschliste_anzeigen() {
	if ($_SESSION["level"] < 4):
		echo "<h2>Wunschliste</h2>";

		echo '<content>';

		echo '<div style="float: left; margin: 5px;"><a href="?do=wunsch_erfassen&amount=50"><img src="bilder/wine.jpg" alt="" width=300 height=300></a></div>';
		echo '<div style="float: left; margin: 5px;"><a href="?do=wunsch_erfassen&amount=200"><img src="bilder/wine.jpg" alt="" width=300 height=300></a></div>';
		echo '<div style="float: left; margin: 5px;"><a href="?do=wunsch_erfassen&amount=350"><img src="bilder/wine.jpg" alt="" width=300 height=300></a></div>';

		echo '</content>';
	else:
		anmeldung_erforderlich();
	endif;
}

function wunsch_erfassen() {

$randomId = rand(1000,9999);

?><content>
<h2>Schenken</h2>
<form method="post">

	<p>	
	<label for="name">Name<br></label>
	<input type="hidden" name="do" value="wunsch_schenken">
	<input type="hidden" name="id" value="<?php echo $randomId; ?>">
	<input type="text" name="name" id="name">
	</p>
	<p>	
	<label for="amount">Betrag in CHF<br></label>
	<input type="text" name="amount" id="amount" value="<?php echo $_GET["amount"]; ?>">
	</p>
	<p>	
	<label for="nachricht">Deine Mitteilung<br></label>
	<textarea type="nachricht" name="nachricht" id="nachricht" placeholder="Schreibe hier deinen Kommentar ..."></textarea>
	</p>
	<p>	
	<button type="submit">Schenken</button>
	</p>
	<p class="klein">Deine E-Mail-Adresse wird nicht veröffentlicht.</p>
		  
</form>
</content>
<?php }

function wunsch_schenken() {
echo $randomId;



}

?>