<?php
require "App/init.php";
$latitude = '';
if (!empty($_POST)) {
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $timestamp = $_POST['timestamp'];

    $dataEmploye = new Employes('1', 'Adnan');

    // Buat objek Presence tanpa validator dulu
    $dataPresensi = new Presence($dataEmploye, 'foto', $latitude, $longitude, $timestamp, null);

    // Buat LocationValidator dengan reference ke Presence
    $locationValidator = new LocationValidator(-6.1935, 106.8625, 0.1, $dataPresensi);

    // Masukkan kembali validator ke Presence (karena awalnya null)
    $reflection = new ReflectionClass($dataPresensi);
    $property = $reflection->getProperty('locationValidator');
    $property->setAccessible(true);
    $property->setValue($dataPresensi, $locationValidator);

    // Tampilkan hasil save
    echo $locationValidator->calculatedDistance();
}
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
        <input type="text" name="latitude" id="latitude" value="<?= htmlspecialchars($latitude) ?>">

        <label for="longitude">Longitude</label>
        <input type="text" name="longitude" id="longitude" value="<?= htmlspecialchars($longitude) ?>">

        <input type="file" accept="image/*, video/*" capture="user">

        <label for="timestamp">Time Stamp Foto</label>
        <input type="text" name="timestamp" value="<?php date_default_timezone_set('Asia/Jakarta');
                                                    echo date('H:i:s') ?>" readonly>

        <button type="submit" name="kirim">Presensi</button>
    </form>
    <hr>
</body>

<script>
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            function(position) {
                const latitude = position.coords.latitude;
                const longitude = position.coords.longitude;
                console.log("Latitude: " + latitude + ", Longitude: " + longitude);
                document.getElementById("latitude").value = latitude;
                document.getElementById("longitude").value = longitude;
            },
            function(error) {
                console.log("Error getting location: " + error.message);
            }, {
                enableHighAccuracy: true,
                timeout: 10000,
                maximumAge: 10000
            }
        );
    } else {
        console.log("Geolocation is not supported by this browser.");
    }
</script>

</html>