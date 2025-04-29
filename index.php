<?php
require "App/init.php";

if (!empty($_POST)) {
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $timestamp = $_POST['timestamp'];

    // Simpan foto snapshot dari webcam jika tersedia (laptop)
    if (!empty($_POST['webcamImage'])) {
        $imgData = $_POST['webcamImage'];
        $imgData = str_replace('data:image/png;base64,', '', $imgData);
        $imgData = str_replace(' ', '+', $imgData);
        $imgDecoded = base64_decode($imgData);

        $fileName = 'uploads/foto_' . time() . '.png';
        file_put_contents($fileName, $imgDecoded);
        $fotoPath = $fileName;
    } elseif (!empty($_FILES['foto']['tmp_name'])) {
        // Simpan file dari kamera HP
        $targetDir = "uploads/";
        $fotoPath = $targetDir . basename($_FILES["foto"]["name"]);
        move_uploaded_file($_FILES["foto"]["tmp_name"], $fotoPath);
    } else {
        $fotoPath = null;
    }

    $dataEmploye = new Employes('1', 'Adnan');
    $dataPresensi = new Presence($dataEmploye, $fotoPath, $latitude, $longitude, $timestamp, null);

    $locationValidator = new LocationValidator(-6.1935, 106.8625, 0.1, $dataPresensi);

    $reflection = new ReflectionClass($dataPresensi);
    $property = $reflection->getProperty('locationValidator');
    $property->setAccessible(true);
    $property->setValue($dataPresensi, $locationValidator);

    echo "Jarak: " . $locationValidator->calculatedDistance() . " km";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Presensi</title>
</head>

<body>
    <h1>Input Presensi</h1>
    <form id="presensiForm" action="" method="POST" enctype="multipart/form-data">
        <label for="latitude">Latitude</label>
        <input type="text" name="latitude" id="latitude" required>

        <label for="longitude">Longitude</label>
        <input type="text" name="longitude" id="longitude" required>

        <div id="mobile-input" style="display: none;">
            <h3>Ambil Foto Selfie (Ponsel)</h3>
            <input type="file" name="foto" accept="image/*" capture="user" required>
        </div>

        <div id="desktop-input" style="display: none;">
            <h3>Ambil Foto Selfie (Laptop)</h3>
            <video id="video" width="320" height="240" autoplay></video><br>
            <button type="button" onclick="takeSnapshot()">Ambil Foto</button><br>
            <canvas id="canvas" width="320" height="240" style="display: none;"></canvas>
            <img id="snapshot" src="" style="display: none;">
            <input type="hidden" name="webcamImage" id="webcamImage">
        </div>

        <label for="timestamp">Time Stamp Foto</label>
        <input type="text" name="timestamp" value="<?= date('H:i:s') ?>" readonly>

        <button type="submit" name="kirim">Presensi</button>
    </form>

    <script>
        // Isi lokasi secara otomatis
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    document.getElementById("latitude").value = position.coords.latitude;
                    document.getElementById("longitude").value = position.coords.longitude;
                },
                function(error) {
                    console.log("Error getting location: " + error.message);
                }, {
                    enableHighAccuracy: true,
                    timeout: 10000,
                    maximumAge: 10000
                }
            );
        }

        // Deteksi perangkat
        function isMobile() {
            return /Mobi|Android/i.test(navigator.userAgent);
        }

        if (isMobile()) {
            document.getElementById('mobile-input').style.display = 'block';
        } else {
            document.getElementById('desktop-input').style.display = 'block';

            // Aktifkan webcam
            navigator.mediaDevices.getUserMedia({
                    video: true
                })
                .then(stream => {
                    document.getElementById('video').srcObject = stream;
                })
                .catch(err => {
                    console.error("Webcam tidak bisa diakses:", err);
                });
        }

        // Ambil snapshot webcam
        function takeSnapshot() {
            const video = document.getElementById('video');
            const canvas = document.getElementById('canvas');
            const context = canvas.getContext('2d');
            context.drawImage(video, 0, 0, canvas.width, canvas.height);

            const dataURL = canvas.toDataURL('image/png');
            document.getElementById('snapshot').src = dataURL;
            document.getElementById('snapshot').style.display = 'block';
            document.getElementById('webcamImage').value = dataURL;
        }

        // Validasi sebelum submit
        document.getElementById('presensiForm').addEventListener('submit', function(e) {
            if (!isMobile()) {
                const webcamImg = document.getElementById('webcamImage').value;
                if (!webcamImg) {
                    e.preventDefault();
                    alert("Silakan ambil foto terlebih dahulu.");
                }
            }
        });
    </script>
</body>

</html>