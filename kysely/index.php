<?php
session_start(); // Aloittaa istunnon käytön
ini_set('display_errors', 1); // Näyttää virheilmoitukset

@include '../config.php'; // Sisällyttää konfiguraatiotiedoston

$id = $_SESSION['id']; // Tallennetaan käyttäjän id-muuttujaan

// SQL-kysely, joka hakee kyselytiedot käyttäjän id:n perusteella
$select = "SELECT * FROM kysely WHERE käyttäjä_id = '$id'";
$result = mysqli_query($conn, $select); // Suoritetaan kysely
$row = mysqli_fetch_array($result); // Tallennetaan tulos muuttujaan $row

// Jos kysely on jo täytetty, ohjataan käyttäjä virhesivulle
if ($row['täytetty'] == "kyllä") {
   header("Location: virhe.php");
} else {
  // Jos lomake on lähetetty
  if(isset($_POST['submit'])) {
 
  // Tallennetaan vastaukset muuttujiin
  $v1 = $_POST['vastaus1'];
  $v2 = $_POST['vastaus2'];
  $v3 = $_POST['vastaus3'];
  $v4 = $_POST['vastaus4'];

  // SQL-kysely, joka päivittää kyselyn tiedot tietokantaan
  $sql = "UPDATE kysely SET täytetty = 'kyllä', v1 = '$v1', v2 = '$v2', v3 ='$v3', v4='$v4' where käyttäjä_id = '$id'";
  $conn->query($sql); // Suoritetaan kysely
  header("Location: kiitos.php"); // Ohjataan käyttäjä kiitossivulle
}
}
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
</head>

<body>
<!-- HTML-koodin aloitus -->

<div class="kysely">
<!-- Luodaan div, joka sisältää kyselyyn liittyvän lomakkeen ja sen elementit -->

<h1>Kun olet vastannut kyselyyn, paina alla olevaa painiketta</h1>
<!-- Luodaan otsikko -->

    <form action="#" method="post">
    <!-- Luodaan lomake, jonka tietoja lähetetään HTTP POST -metodilla -->

        <div class="question">
        <!-- Luodaan kysymys -->

        <p>Mitä mieltä olet nettisivun designista?</p>
        <!-- Luodaan kysymys -->

        <input type="radio" name="vastaus1" value="Hienot">
        <label for="huey">Hienot</label>

        <input type="radio" name="vastaus1" value="Semi hienot">
        <label for="huey">Semi hienot</label>

        <input type="radio" name="vastaus1" value="En tykkää">
        <label for="huey">En tykkää</label>
        </div>


        <div class="question">
        <!-- Luodaan kysymys -->

        <p>Tuletko käymään sivustolla kyselyn jälkeen?</p>
        <!-- Luodaan kysymys -->

        <input type="radio" name="vastaus2" value="Kyllä">
        <label for="huey">Kyllä</label>

        <input type="radio" name="vastaus2"  value="Ehkä jopa tulen">
        <label for="huey">Ehkä jopa tulen</label>

        <input type="radio" name="vastaus2" value="En">
        <label for="huey">En</label>
        </div>

        <div class="question">
        <!-- Luodaan kysymys -->

        <p>Minkä arvosanan antaisit kokonaisuudesta?</p>
        <!-- Luodaan kysymys -->

        <input type="radio" name="vastaus3" value="1">
        <label for="huey">1</label>

        <input type="radio" name="vastaus3" value="2">
        <label for="huey">2</label>

        <input type="radio" name="vastaus3" value="3">
        <label for="huey">3</label>

        <input type="radio" name="vastaus3" value="4">
        <label for="huey">4</label>

        <input type="radio" name="vastaus3" value="5">
        <label for="huey">5</label>
        </div>

        <div class="question">
        <!-- Luodaan kysymys -->

        <p>Mitä rakentaisin tulevaisuutta katsellen <br>tänne nettisivuille? (ei pakollinen)</p>
        <!-- Luodaan kysymys -->

        <input type="text" name="vastaus4">
        <!-- Luodaan tekstikenttä, johon käyttäjä voi syöttää vastauksensa -->
        </div>
        </div>

    <div class="submit">
    <input type="submit" name="submit" value="Lähetä palaute">
    </div>
    
    </form>
</div>




<!------------JavaScript for Toggle Menu---------->
<script>
  
  var navLinks = document.getElementById("navLinks");

  function showMenu(){
    navLinks.style.right= "0";
 }
  function hideMenu(){
    navLinks.style.right= "-200px";
  }

</script>

</body>
</html>

