<?php
ini_set('display_errors', 1);

@include '../config.php';

$sql1 = "SELECT * from kysely
         JOIN käyttäjätiedot
         WHERE käyttäjätiedot.user_id = kysely.käyttäjä_id
         AND v1 IS NOT NULL";
$result = $conn-> query($sql1); 
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


<div class="vastaussivu">
  <h1>Alta näet kyselyn vastaukset</h1>


  <div class="vastaukset">
    <table>
        <tr>
            <th>Etu- ja sukunimi</th>
            <th>Mitä mieltä olet nettisivun designista?</th>
            <th>Tuletko käymään sivustolla kyselyn jälkeen?</th>
            <th>Minkä arvosanan antaisit kokonaisuudesta?</th>
            <th>Mitä rakentaisin tulevaisuutta katsellentänne nettisivuille?</th>
        </tr>
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if ($row["v4"] == NULL) {
                $v4 = "ei vastattu";
            } else {
                $v4 = $row["v4"];
            }
            echo "<tr><td>".$row['etunimi']." ". $row['sukunimi'] . "</td><td>" . $row["v1"] . "</td><td>" . $row["v2"] . "</td><td>" . $row["v3"]. "</td><td>" . "$v4" . "</td></tr>";
        }
    }
    ?>
    </table>
</div>


<input type="submit" value="Takaisin" onClick="takaisin()"/>


<!------------JavaScripts for button press------->
<script>
  function takaisin() {
    window.location.href="../admin";
}
</script>


</body>
</html>