<?php

namespace App\Model;

class Request
{
    private $userId;
    private $title;
    private $quantity;
    private $measurementId;
    private $description;
    private $errors = [];

    public function __construct($userId, $title, $quantity, $measurementId, $description)
    {
        $this->setUserId(trim($userId));
        $this->setTitle(trim($title));
        $this->setQuantity(trim($quantity));
        $this->setMeasurementId(trim($measurementId));
        $this->setDescription(trim($description));
    }

    public function getUserId() : int
    {
        return $this->userId;
    }

    public function setUserId($userId)
    {
        if (strlen($userId) <= 0) {
            $this->errors['userId'] = "Veuillez choisir votre nom dans la list ci-dessous";
        } else {
            $this->userId = $userId;
        }
    }

    public function getTitle() : string
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        if (strlen($title) <= 0) {
            $this->errors['title'] = "Le titre doit contenir au moins 1 caractère.";
        } elseif (strlen($title) > 40) {
            $this->errors['title'] = "Le titre doit contenir au maximum 40 caractères.";
        } else {
            $this->title = $title;
        }
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function setQuantity($quantity)
    {
        if ($quantity != null && $quantity <= 0) {
            $this->errors['quantity'] = "La quantité ne peut pas être plus petite ou égale à 0.";
        } else {
            $this->quantity = $quantity;
        }
    }

    public function getMeasurementId()
    {
        return $this->measurementId;
    }

    public function setMeasurementId($measurementId)
    {
        if ($measurementId != null && $measurementId <= 0) {
            $this->errors['measurementId'] = "Veuillez choisir l'unité dans la list ci-dessous";
        } else {
            $this->measurementId = $measurementId;
        }
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function isOk() : array
    {
        return $this->errors;
    }
}
