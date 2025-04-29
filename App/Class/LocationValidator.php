<?php

class LocationValidator
{
    private $officeLatitude,
        $officeLongitude,
        $allowedRadius,
        $R = 6371,
        $presence;

    public function __construct($officeLatitude = -6.193499644016029, $officeLongitude = 106.86258876751998, $allowedRadius = 0.1, Presence $presence)
    {
        $this->presence = $presence;
        $this->officeLatitude = $officeLatitude;
        $this->officeLongitude = $officeLongitude;
        $this->allowedRadius = $allowedRadius;
    }

    public function calculatedDistance()
    {
        $latUser = deg2rad($this->presence->getLatitude());
        $lonUser = deg2rad($this->presence->getLongitude());
        $latOffice = deg2rad($this->officeLatitude);
        $lonOffice = deg2rad($this->officeLongitude);


        $dlat = $latUser - $latOffice;
        $dlon = $lonUser - $lonOffice;

        // Haversine formula
        $a = sin($dlat / 2) * sin($dlat / 2) +
            cos($this->officeLatitude) * cos($latUser) *
            sin($dlon / 2) * sin($dlon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        // Menghitung jarak dalam kilometer
        $distance = $this->R * $c;

        if ($distance <= $this->allowedRadius) {
            return "Berhasil Presensi";
        } else if ($distance > $this->allowedRadius) {
            return "Gagal Presensi";
        }
    }

    public function isValidLocation()
    {
        // contoh: pakai calculatedDistance()
        return true; // logika validasi bisa ditambahkan nanti
    }
}
