
<?php
// Määritellään tietokantapalvelimen tiedot
$db_host = '';
$db_user = '';
$db_pass = '';
$db_database = '';

// Yhdistetään tietokantaan
$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_database);

// Funktio kommenttimäärän hakemiseen
function get_comment_count($blog_id) {
    global $conn; // Käytetään globaalia tietokantayhteyttä
    $blog_id = mysqli_real_escape_string($conn, $blog_id); // Suojataan tietoturvan vuoksi SQL-injektioilta
    $query = "SELECT COUNT(*) AS count FROM kommentit WHERE blogikirjoitus_id = '$blog_id'"; // Tehdään kysely kommenttimäärän hakemiseksi
    $result = mysqli_query($conn, $query); // Suoritetaan kysely
    $row = mysqli_fetch_assoc($result); // Haetaan rivit tuloksesta assosiatiiviseen taulukkoon
    return $row['count']; // Palautetaan kommenttimäärä
}
?> 