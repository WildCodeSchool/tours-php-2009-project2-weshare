<?php

namespace App\Model;

class Request
{
    private $userId;

    /*
    * @var string
    */
    private $title;

    private $quantity;

    private $measurementId;

    /*
    * @var string
    */
    private $description;

    /*
    * @var array
    */
    private $errors = [];

    public const MIN_CHAR = 0;

    public function __construct($userId, $title, $quantity, $measurementId, $description)
    {
        $this->setUserId($userId);
        $this->setTitle($title);
        $this->setQuantity($quantity);
        $this->setMeasurementId($measurementId);
        $this->setDescription($description);
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId($userId)
    {
        $userId = trim($userId);

        if (strlen($userId) <= self::MIN_CHAR) {
            $this->errors['userId'] = "Veuillez choisir votre nom dans la liste ci-dessous";
        } else {
            $this->userId = $userId;
        }
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $title = trim($title);

        if (strlen($title) <= self::MIN_CHAR) {
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
        $quantity = trim($quantity);

        if ($quantity != null && $quantity <= self::MIN_CHAR) {
            $this->errors['quantity'] = "La quantité ne peut pas être plus petite ou égale à 0.";
        } elseif ($quantity === '') {
            $this->quantity = null;
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
        $measurementId = trim($measurementId);

        if ($measurementId != null && $measurementId <= self::MIN_CHAR) {
            $this->errors['measurementId'] = "Veuillez choisir l'unité dans la list ci-dessous";
        } elseif ($measurementId === '') {
            $this->measurementId = null;
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
        $description = trim($description);

        if ($description === '') {
            $this->description = null;
        } else {
            $this->description = $description;
        }
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function isValid(): bool
    {
        return empty($this->errors);
    }
}
