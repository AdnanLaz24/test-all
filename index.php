<?php

require_once "App/init.php";


$employes = new Employes("001", "Ahmad");

// Mengatur data presensi
$foto = "path/to/foto.jpg";
$latitude = -6.193373232814059;
$longitude = 106.86313403739301;
$timestamp = time();
$isValidLocation = true;



// Lokasi kantor
$officeLatitude = -6.1937129682507965;
$officeLongitude = 106.86256730984925;

// Aturan Presensi
$maxJarak = 0.1;


$presence = new Presence($employes, $foto, $latitude, $longitude, $timestamp, $isValidLocation);
$distanceCalculator = new LocationValidator($officeLatitude, $officeLongitude, $presence);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>INPUT PRESENSI</h1>

    <form action="" method="POST">
        <label for="latitude">Latitude</label>
        <input type="text" name="latitude">

        <label for="longtitude">Longtitude</label>
        <input type="text" name="longtitude">

        <button type="submit">Kirim</button>
    </form>


</body>

</html>