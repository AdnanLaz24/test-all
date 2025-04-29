<?php


class Presence
{
    private
        $employes,
        $foto,
        $latitude,
        $longtitude,
        $timestamp,
        $locationValidator;

    public function __construct(Employes $employes, $foto = "path/to/foto.jpg", $latitude = 0, $longtitude = 0, $timestamp = 0, LocationValidator $locationValidator)
    {
        $this->employes = $employes;
        $this->foto = $foto;
        $this->latitude = $latitude;
        $this->longtitude = $longtitude;
        $this->timestamp = $timestamp;
        $this->locationValidator = $locationValidator;
    }

    public function save()
    {
        $str = "INSERT INTO presensi VALUES ('{$this->employes->getId()}','{$this->employes->getName()}','$this->foto','$this->latitude','$this->longtitude','$this->timestamp','{$this->locationValidator->isValidLocation()}')";
        return $str;
    }

    public function getLatitude()
    {
        return $this->latitude;
    }

    public function getLongTitude()
    {
        return $this->longtitude;
    }

    public function getDataPresensi()
    {
        return "{$this->getLatitude()}";
    }
}
