<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '/home/amisjere/phpmailer/vendor/phpmailer/phpmailer/src/Exception.php';
require '/home/amisjere/phpmailer/vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '/home/amisjere/phpmailer/vendor/phpmailer/phpmailer/src/SMTP.php';

session_start();
include '../config.php';
ini_set('display_errors', 1);

if(isset($_POST['laheta'])){

  // Tarkistetaan, että blogipostauksen id on määritetty URL-parametrina
  if (!isset($_SESSION['blog_id'])) {
    die("Blogipostauksen id ei ole määritetty.");
  }

  // Tallennetaan blogipostauksen id SESSION-muuttujaan
  $id = $_SESSION['blog_id'];

  // Haetaan blogipostaus tietokannasta
  $blog_id = mysqli_real_escape_string($conn, $id);

  // Tarkistetaan, onko lomaketta lähetetty
  if(isset($_POST['laheta'])) {
      // Haetaan lomakkeesta syötetyt tiedot
      $nimi = $_POST['nimi'];
      $teksti = $_POST['kommentti'];

      // Tarkistetaan, että nimi ja teksti eivät ole tyhjiä
      if(!empty($nimi) && !empty($teksti)) {
          // Lisätään uusi kommentti tietokantaan
          $lisays_sql = "INSERT INTO kommentit (blogikirjoitus_id, nimi, kommentti, päivämäärä) VALUES ('$blog_id', '$nimi', '$teksti', NOW())";
          if(mysqli_query($conn, $lisays_sql)) {
              echo "<p class='viesti'>Kommentti lisättiin onnistuneesti!</p>";

          } else {
              echo "<p class='virhe'>Kommentin lisääminen epäonnistui.</p>";
          }
      } else {
          echo "<p class='virhe'>Nimi ja teksti eivät saa olla tyhjiä.</p>";
      }
  }
}
?>

<div id="kommenttilomake">
  <h2>Lisää kommentti</h2>
  <form method="post" action="">
    <input type="hidden" name="blog_id" value="<?php echo $blog_id; ?>">
    <label for="nimi">Nimi:</label>
    <input type="text" name="nimi" required>
    <br>
    <label for="kommentti">Kommentti:</label>
    <textarea name="kommentti" required></textarea>
    <br>
    <input type="submit" value="Lähetä" name="laheta">
  </form>
</div>
