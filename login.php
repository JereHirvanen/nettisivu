<?php
session_start(); // aloitetaan PHP-istunto, jotta voidaan tallentaa käyttäjän tiedot sessiomuuttujiin
ini_set('display_errors', 1); // näytetään mahdolliset virheilmoitukset käyttäjälle

// Tarkistetaan, onko lomakkeen submit-nappia painettu
if(isset($_POST['submit'])){

   // Otetaan mukaan tietokantayhteys asetustiedostosta
   @include 'config.php';

   // Puhdistetaan käyttäjän syöttämät tiedot, jotta ne eivät aiheuta SQL-injektiota
   $username = mysqli_real_escape_string($conn, $_POST['username']);
   $password = md5($_POST['password']); // salataan salasana md5-menetelmällä

   // Suoritetaan SQL-kysely tietokantaan käyttäjän syöttämien tietojen perusteella
   $select = " SELECT * FROM käyttäjätiedot WHERE username = '$username' && password = '$password' ";

   $result = mysqli_query($conn, $select); // tallennetaan kyselyn tulos

   // Jos löytyi käyttäjä, jolla on samat käyttäjänimi ja salasana
   if(mysqli_num_rows($result) > 0){

      $row = mysqli_fetch_array($result); // tallennetaan käyttäjän tiedot taulukkoon

      // Jos käyttäjän tyyppi on admin
      if($row['user_type'] == 'admin'){
         $_SESSION['id'] = $row['user_id']; // tallennetaan käyttäjän ID sessiomuuttujaan
         $_SESSION['user_name'] = $row['etunimi']; // tallennetaan käyttäjän nimi sessiomuuttujaan
         $_SESSION['user'] = "admin"; // tallennetaan käyttäjän tyyppi sessiomuuttujaan
         header('location:admin'); // ohjataan käyttäjä admin-sivulle

      // Jos käyttäjän tyyppi on user
      }elseif($row['user_type'] == 'user'){
         $_SESSION['id'] = $row['user_id'];
         $_SESSION['user_name'] = $row['etunimi'];
         $_SESSION['user'] = "user";
         header('location:user');
      }
     
   }else{ // Jos käyttäjää ei löytynyt tietokannasta
      $error[] = 'Väärä käyttäjätunnus tai salasana!'; // tallennetaan virheilmoitus taulukkoon
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
  <link rel="stylesheet" href="style.css">
  
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
          <li><a href="about">TIETOJA SIVUSTA</a></li>
          <li><a href="../blogi">BLOGI</a></li>
          <li><a href="">KIRJAUDU SISÄÄN</a></li>
        </ul>
      </div>
      <!-- Palkki-ikoni, joka avaa navigaatiomenun -->
      <i class="fa-solid fa-bars" onclick="showMenu()"></i>
    </nav>
  </section>

  <!-- Lomake kirjautumiselle -->
  <div class="form">
    <h1>Kirjaudu sisään</h1>
    <form method="post" action="#">

      <!-- Virheilmoitukset, jos kirjautuminen epäonnistuu -->
      <?php
        if(isset($error)){
          foreach($error as $error){
            echo '<span class="error-msg">'.$error.'</span>';
          };
        };
      ?>

      <!-- Käyttäjätunnus-kenttä -->
      <div class="txt_field">
        <p>Käyttäjätunnus:</p>
        <input type="text" name="username">
      </div>

      <!-- Salasana-kenttä -->
      <div class="txt_field">
        <p>Salasana:</p>
        <input type="password" name="password">
      </div>

      <!-- Kirjautumisnapin painike -->
      <input type="submit" name="submit" value="Kirjaudu sisään" class="form-btn">

      <!-- Rekisteröitymisen linkki -->
      <div class="signup_link">
        Eikö sinulla ole tiliä? <a href="register.php">Luo tili</a>
      </div>
    </form>
  </div>
    
<!-- JavaScript-ohjelma navigaatiomenun piilottamiseksi ja näyttämiseksi -->
<script>
  
  var navLinks = document.getElementById("navLinks");

  // Funktio näyttää navigaatiomenuun, kun käyttäjä klikkaa menu-nappulaa
  function showMenu(){
    navLinks.style.right= "0";
 }

  // Funktio piilottaa navigaatiomenuun, kun käyttäjä klikkaa ruudun muualla
  function hideMenu(){
    navLinks.style.right= "-200px";
  }

</script>
