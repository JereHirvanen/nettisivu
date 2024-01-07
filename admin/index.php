<?php

@include 'config.php';

session_start();

if(!isset($_SESSION['id'])){
   header('location:../login.php');
} elseif ($_SESSION['user'] == "user"){
  header('location:../user');
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
<div class="text-box">
  <h1>Hei <?php echo $_SESSION['user_name']?>!</h1>
  <p>Palaa sivustolle myöhemmin, sillä <br> sivustoa ollaan vasta tekemässä.</p>

  <div class="button_box">

  <input type="submit" value="Tarkastele kyselyn vastauksia" onClick="vastaukset()"/>
  <input type="submit" value="Kirjaudu ulos" onClick="home()"/>
  <input type="submit" value="Luo blogipostaus" onClick="blogi()"/>
  
  </div>

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


<!------------JavaScripts for buttons press------->
<script>
  function kysely() {
    window.location.href="../kysely";
  }

  function vastaukset() {
    window.location.href="../kysely/vastaukset.php";
  }

  function home() {
    window.location.href="..";
  }

  function blogi() {
    window.location.href="../blogi/luoblogi.php";
  }

  function henkkoht() {
    window.location.href="../henkilökohtaiset";
  }
</script>

</body>
</html>