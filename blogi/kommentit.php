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
  <section class="header">
    <nav>
      <div class="nav-links" id="navLinks">
        <i class="fa-solid fa-xmark" onclick="hideMenu()"></i>
        <ul>
          <li><a href="../index.php">KOTI</a></li>
          <li><a href="../about">TIETOJA SIVUSTA</a></li>
          <li><a href="">BLOGI</a></li>
          <li><a href="../login.php">KIRJAUDU SISÄÄN</a></li>
        </ul>
      </div>
      <i class="fa-solid fa-bars" onclick="showMenu()"></i>
    </nav>
  </section>

<?php
session_start();
include '../config.php';
ini_set('display_errors', 1);

// Tarkistetaan, että blogipostauksen id on määritetty URL-parametrina
if (!isset($_GET['id'])) {
  die("Blogipostauksen id ei ole määritetty.");
}

// Tallennetaan blogipostauksen id SESSION-muuttujaan
$_SESSION['blog_id'] = $_GET['id'];

// Haetaan blogipostaus tietokannasta
$blog_id = mysqli_real_escape_string($conn, $_GET['id']);
$sql = "SELECT * FROM blogikirjoitukset WHERE blog_id='$blog_id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

// Haetaan kommentit tietokannasta
$sql = "SELECT * FROM kommentit WHERE blogikirjoitus_id='$blog_id' ORDER BY päivämäärä DESC";
$kommentti_result = mysqli_query($conn, $sql);

// Tulostetaan blogipostaus ja kommentit
echo "<div class='blogipostaus' id='blogipostaus-" . $row["blog_id"] . "'><h2>" . $row["otsikko"] . "</h2><p>" . $row["sisältö"] . "</p><p> Julkaistu " . $row["päivämäärä"] . "</p></div>";

echo "<a href='kommentoi.php'>Lisää kommentti</a>";

echo "<h3>Kommentit</h3>";
if (mysqli_num_rows($kommentti_result) > 0) {
    while($kommentti_row = mysqli_fetch_assoc($kommentti_result)) {
        echo "<div class='kommentti'>";
        echo "<p><strong>" . $kommentti_row["nimi"] . "</strong> kirjoitti " . $kommentti_row["päivämäärä"] . ":</p>";
        echo "<p>" . $kommentti_row["kommentti"] . "</p>";
        echo "</div>";
    }
} else {
    echo "Ei vielä kommentteja!";
}
