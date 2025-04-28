<?php

class Employes
{
    private $id,
        $name;

    public function __construct($id = "id", $name = "name")
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }
}
