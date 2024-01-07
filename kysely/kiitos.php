<?php
session_start();

if(isset($_POST['submit'])){
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

<div class="kysely">
<h1>Kiitos vastauksistasi!</h1>

<div class="submit">

    <form method="post" action="#">
    <input type="submit" name="submit" value="Palaa edelliselle sivustolle">
    </form>

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
