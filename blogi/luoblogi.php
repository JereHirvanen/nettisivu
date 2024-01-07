<?php
session_start();
if(isset($_SESSION['user']) && $_SESSION['user'] == 'admin') {
?>
<!DOCTYPE html>
<html lang="fi">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  <!-- JQuery-kirjaston lataaminen -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

  <!-- Ulkoasun määrittely CSS-tiedostossa -->
  <link rel="stylesheet" href="../style.css">
  
  <!-- Sivuston faviconin lisääminen -->
  <link rel="icon" type="image/x-icon" href="/pictures/favicon.png">
  
  <!-- Google Fonts -kirjaston lataaminen -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:ital,wght@0,200;0,400;0,600;0,700;1,500&display=swap" rel="stylesheet">

  <!-- Font Awesome -ikonikirjaston lataaminen -->
  <script src="https://kit.fontawesome.com/bf531f895c.js" crossorigin="anonymous"></script>

  <title>Tervetuloa amisjere.comiin!</title>
  <style>

.blogikirjoitus-lomake{
border: 1px solid black;
}

form {
  display: flex;
  flex-direction: column;
  align-items: center;
}
label {
  font-weight: bold;
}
input[type="text"], textarea {
  border: 1px solid #ccc;
  border-radius: 4px;
  padding: 8px;
  margin-bottom: 16px;
  width: 100%;
  box-sizing: border-box;
  background-color: transparent;
}
input[type="submit"] {
  background-color: #4CAF50;
  color: white;
  border: none;
  border-radius: 4px;
  padding: 12px 20px;
  margin-top: 16px;
  cursor: pointer;
  width: 100%;
}
input[type="submit"]:hover {
  background-color: #45a049;
}
</style>
</head>

<body>
<div class="blogikirjoitus-lomake">
	<form action="luoblogi.php" method="post">
	<h2>Luo blogikirjoitus</h2>
		<div class="lomake-kentta">
			<label for="otsikko">Otsikko:</label>
			<input type="text" id="otsikko" name="otsikko">
		</div>
		<div class="lomake-kentta">
			<label for="sisalto">Sisältö:</label>
			<textarea id="sisalto" name="sisalto" rows="10" cols="30"></textarea>
		</div>
		<input type="submit" name="submit" value="Luo blogikirjoitus">
	</form>
</div>

	<?php
	ini_set('display_errors', 1);
	// Tarkistetaan, onko lomakkeelta saatu dataa
	if(isset($_POST['submit'])){
		
		// Yhdistetään tietokantaan config.php-tiedoston avulla
		include '../config.php';
		
		// Haetaan lomakkeen tiedot ja tallennetaan ne muuttujiin
		$otsikko = $_POST['otsikko'];
		$sisalto = $_POST['sisalto'];
		
		$paivamaara = date('j.n.Y H:i');

		// Suojataan syöte ennen tallennusta tietokantaan
		$otsikko = mysqli_real_escape_string($conn, $otsikko);
		$sisalto = mysqli_real_escape_string($conn, $sisalto);
		$paivamaara = mysqli_real_escape_string($conn, $paivamaara);
		
		// Suoritetaan kysely tietokantaan
		$sql = "INSERT INTO blogikirjoitukset (käyttäjä_id, otsikko, sisältö, päivämäärä) VALUES ('1', '$otsikko', '$sisalto', '$paivamaara')";
		
		if (mysqli_query($conn, $sql)) {
			echo "Blogikirjoitus tallennettu onnistuneesti!";
		} else {
			echo "Virhe tallennettaessa blogikirjoitusta: " . mysqli_error($conn);
		}
		
		// Suljetaan tietokantayhteys
		mysqli_close($conn);
	}
} else {
	echo "Sinulla ei ole oikeuksia tälle sivulle.";
}
?>
</body>
</html>
