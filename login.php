<?php

function login($login, $password) {
	foreach ($GLOBALS["users"] as $user) {
		if (strtolower($user["login"]) == strtolower($login)) {
			
			if (password_verify($password, $user["password"])) {
				// korrekte benutzer anmeldung, speichern in die SESSION
				$_SESSION["login"] = $user["login"];
				$_SESSION["level"] = $user["level"];
				$_SESSION["userid"] = get_userid($user["login"]);
				$_SESSION["displayname"] = $user["displayname"];

				meldung_erfassen("Anmeldung erfolgreich!");

				return true; // bricht das foreach ab
			}
		}
	}

	meldung_erfassen("Anmeldung nicht erfolgreich!", "fehler");
}

function logout() {
	session_destroy();
	$_SESSION = array();
	header("Location: ?");
	exit();
}

function show_login_form() {
	if (!isset($_SESSION["login"])): ?>
		<div class="form_background"><form action="" method="POST">
		<h2>Login</h2>
		<input type="hidden" name="do" value="login">
		Benutzername<br>
		<input type="text" name="login"><br>
		Passwort<br>
		<input type="password" name="password"><br><br>
		<button type="submit" value="Anmelden">Anmelden</button>
		</form>
	<?php else: ?>
		<div class="form_background"><form action="" method="POST">
		Angemeldet als: <?php echo ($_SESSION["displayname"]); ?><br>
		<input type="hidden" name="do" value="logout">
		<button type="submit" value="Abmelden">Abmelden</button>
		</form></div>
	<?php endif;
}
?>