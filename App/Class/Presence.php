<?php


class Presence
{
    private
        $employes,
        $foto,
        $latitude,
        $longtitude,
        $timestamp,
        $isValidLocation;

    public function __construct(Employes $employes, $foto = "foto", $latitude = 0, $longtitude = 0, $timestamp = 0, $isValidLocation = true)
    {
        $this->employes = $employes;
        $this->foto = $foto;
        $this->latitude = $latitude;
        $this->longtitude = $longtitude;
        $this->timestamp = $timestamp;
        $this->isValidLocation = $isValidLocation;
    }

    public function save()
    {
        $str = "INSERT INTO presensi VALUES ('{$this->employes->getId()}','{$this->employes->getName()}','$this->foto','$this->latitude','$this->longtitude','$this->timestamp','$this->isValidLocation')";
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
}
