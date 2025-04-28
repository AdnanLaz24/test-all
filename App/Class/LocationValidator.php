<?php

class LocationValidator
{
    private $officeLatitude,
        $officeLongitude,
        $presence,
        $R = 6371;


    public function __construct($officeLatitude, $officeLongitude, Presence $presence)
    {
        $this->officeLatitude = deg2rad($officeLatitude);
        $this->officeLongitude = deg2rad($officeLongitude);
        $this->presence = $presence;
    }

    public function calculateDistance()
    {
        $lat2 = deg2rad($this->presence->getLatitude());
        $lon2 = deg2rad($this->presence->getLongTitude());

        $dlat = $lat2 - $this->officeLatitude;
        $dlon = $lon2 - $this->officeLongitude;

        // Haversine formula
        $a = sin($dlat / 2) * sin($dlat / 2) +
            cos($this->officeLatitude) * cos($lat2) *
            sin($dlon / 2) * sin($dlon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        // Menghitung jarak dalam kilometer
        $distance = $this->R * $c;

        return $distance;
    }

    public function isValidLocation()
    {
        if ($this->calculateDistance() > 0.1) {
            return 0;
        } elseif ($this->calculateDistance() <= 0.1) {
            return true;
        }
    }
}
