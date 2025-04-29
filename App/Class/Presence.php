<?php

class Presence
{
    private
        $employes,
        $foto,
        $latitude,
        $longitude,
        $timestamp,
        $locationValidator;

    public function __construct($employes, $foto, $latitude, $longitude, $timestamp, ?LocationValidator $locationValidator)
    {
        $this->employes = $employes;
        $this->foto = $foto;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->timestamp = $timestamp;
        $this->locationValidator = $locationValidator;
    }

    public function save()
    {
        $str = "Name: {$this->employes->getName()}, Foto: {$this->foto}, Latitude: {$this->latitude}, Longitude: {$this->longitude}, Timestamp: {$this->timestamp}, Location Valid: {$this->locationValidator->isValidLocation()}";
        if ($this->locationValidator->isValidLocation() == true) {
            return $str . "|| Anda Berhasil Presensi";
        } elseif ($this->locationValidator->isValidLocation() == false) {
            return $str . "|| Gagal Presensi";
        }
    }

    public function getLatitude()
    {
        return $this->latitude;
    }

    public function getLongitude()
    {
        return $this->longitude;
    }

    public function getDataPresensi()
    {
        return "{$this->getLatitude()}";
    }
}
