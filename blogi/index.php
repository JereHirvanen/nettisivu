<?php
session_start();
include '../config.php';
ini_set('display_errors', 1);

// Haetaan kaikki blogikirjoitukset tietokannasta, järjestetty päivämäärän ja blog_id:n perusteella laskevassa järjestyksessä
$sql = "SELECT * FROM blogikirjoitukset ORDER BY päivämäärä DESC, blog_id DESC";
$result = mysqli_query($conn, $sql);
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
  <section class="header">
    <nav>
      <!-- Navigaatiomenun sisältö -->
      <div class="nav-links" id="navLinks">
        <!-- Rasti-ikoni, joka piilottaa navigaatiomenun -->
        <i class="fa-solid fa-xmark" onclick="hideMenu()"></i>
        <!-- Navigaatiomenun linkkilista -->
        <ul>
          <li><a href="../">KOTI</a></li>
          <li><a href="../about">TIETOJA SIVUSTA</a></li>
          <li><a href="">BLOGI</a></li>
          <li><a href="../login.php">KIRJAUDU SISÄÄN</a></li>
        </ul>
      </div>
      <!-- Palkki-ikoni, joka avaa navigaatiomenun -->
      <i class="fa-solid fa-bars" onclick="showMenu()"></i>
    </nav>
  </section>

  <div class="blog-post">
    <?php
    // Tarkistetaan, onko haussa onnistuttu
    if (mysqli_num_rows($result) > 0) {
        echo "<table>";
        while($row = mysqli_fetch_assoc($result)) {
            echo "<div class='blogipostaus' id='blogipostaus-" . $row["blog_id"] . "'><h2>" . $row["otsikko"] . "</h2><p>" . $row["sisältö"] . "</p><p>Julkaistu " . $row["päivämäärä"] . "</p>";

            // Haetaan kommenttien lukumäärä tietokannasta
            $kommenttilkm_sql = "SELECT COUNT(*) AS kommenttilkm FROM kommentit WHERE blogikirjoitus_id = " . $row["blog_id"];
            $kommenttilkm_result = mysqli_query($conn, $kommenttilkm_sql);
            $kommenttilkm_row = mysqli_fetch_assoc($kommenttilkm_result);
            $kommenttilkm = $kommenttilkm_row['kommenttilkm'];

            echo "<a href='kommentit.php?id=" . $row["blog_id"] . "'>Kommentit ($kommenttilkm)</a>";
            echo "</div>";
        }
        echo "</table>";
    } else {
        echo "Ei blogikirjoituksia.";
    }
    mysqli_close($conn);
    ?>
  </div>
</body>
</html>