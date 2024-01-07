<?php
session_start();

if(isset($_POST['submit'])){

  @include 'config.php'; // Tietokantayhteyden tiedot sisältävä tiedosto

  // Puhdistetaan käyttäjän syötteet mahdollisia tietoturvariskejä varten
  $etunimi = mysqli_real_escape_string($conn, $_POST['etunimi']);
  $sukunimi = mysqli_real_escape_string($conn, $_POST['sukunimi']);
  $username = mysqli_real_escape_string($conn, $_POST['username']);
  $pass = md5($_POST['password']); // Hashataan salasana md5-funktiolla
  $cpass = md5($_POST['cpassword']); // Hashataan salasana uudelleen ja verrataan sitä $pass-muuttujaan

  $select = " SELECT * FROM käyttäjätiedot WHERE username = '$username'";

  $result = mysqli_query($conn, $select); // Suoritetaan SQL-kysely
  $row = mysqli_fetch_array($result);

  if(empty($etunimi and $sukunimi and $pass and $cpass)){
     $error[] = 'Täytäthän kaikki kohdat!'; // Virheilmoitus, jos jokin kenttä on jätetty tyhjäksi
  }elseif($username == $row['username']){
     $error[] = 'Käyttäjätunnus on jo olemassa!'; // Virheilmoitus, jos käyttäjätunnus on jo käytössä
  }elseif($pass != $cpass){
    $error[] = 'Salasanat eivät täsmää!'; // Virheilmoitus, jos salasanat eivät täsmää
  }else{
    // Jos kaikki on ok, lisätään käyttäjä tietokantaan
    $insert = "INSERT INTO käyttäjätiedot(etunimi, sukunimi, username, password) VALUES('$etunimi','$sukunimi','$username','$pass')";
    mysqli_query($conn, $insert);

    // Lisätään käyttäjä myös toiseen tauluun
    $user_id = $conn->insert_id;
    $user_id_add = "INSERT into kysely (käyttäjä_id) value ($user_id)";
    mysqli_query($conn, $user_id_add);

    $error[] = 'Tilin luonti onnistui! Kirjaudu sisään.';
    header('location:login.php'); // Siirrytään kirjautumissivulle
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
      </div>
      <!-- Palkki-ikoni, joka avaa navigaatiomenun -->
      <i class="fa-solid fa-bars" onclick="showMenu()"></i>
    </nav>
  </section>

  <div class="form">
  <!-- Lomakkeen otsikko -->
  <h1>Rekisteröidy sivustolle</h1>
  <!-- Lomake, joka lähetetään POST-metodilla -->
  <form method="post" action="#">
    <?php
      // Tarkistetaan, onko $error-muuttuja asetettu (esim. jos lomakkeen tiedoissa on virheitä)
      if(isset($error)){
        // Käydään läpi kaikki virheilmoitukset ja tulostetaan ne näkyviin
        foreach($error as $error){
          echo '<span class="error-msg">'.$error.'</span>';
        };
      };
    ?>
    <!-- Käyttäjän etunimi-kenttä -->
    <div class="txt_field">
      <p>Etunimesi:</p>
      <input type="text" name="etunimi">
    </div>
    <!-- Käyttäjän sukunimi-kenttä -->
    <div class="txt_field">
      <p>Sukunimesi:</p>
      <input type="text" name="sukunimi">
    </div>
    <!-- Käyttäjätunnuksen syöttökenttä -->
    <div class="txt_field">
      <p>Haluamasi käyttäjätunnus:</p>
      <input type="text" name="username">
    </div>
    <!-- Salasanan syöttökenttä -->
    <div class="txt_field">
      <p>Salasana:</p>
      <input type="password" name="password">
    </div>
    <!-- Salasanan vahvistuskenttä -->
    <div class="txt_field">
      <p>Salasana uudelleen:</p>
      <input type="password" name="cpassword">
    </div>
    <!-- Lomakkeen lähetysnappi -->
    <input type="submit" name="submit" value="Luo tili">
  </form>
</div>

<!-- JavaScript-toiminto, joka näyttää/piilottaa mobiililaitteen navigaatiomenua -->
<script>
  // Haetaan HTML-elementti, joka sisältää navigaatiomenu-linkit
  var navLinks = document.getElementById("navLinks");

  // Funktio, joka näyttää navigaatiomenu-linkit
  function showMenu(){
    navLinks.style.right= "0";
  }
  
  // Funktio, joka piilottaa navigaatiomenu-linkit
  function hideMenu(){
    navLinks.style.right= "-200px";
  }
</script>
</body>
</html>