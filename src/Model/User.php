<?php

/**
 * Created by WCS.
 * User: Célia
 * Date : 04/11/2020
 */

namespace App\Model;

class User
{
    /**
     * @var string
     */
    private $firstname;

    /**
     * @var string
     */
    private $lastname;

    private $phone;

    /**
     * @var string
     */
    private $street;

    private $townId;

    /**
     * @var string
     */
    private $email;

    /**
     * @var array
     */
    private $errors = [];

    public const NAME_CHAR_MAX = 50;
    public const MIN_CHAR = 0;

    public function __construct($firstname, $lastname, $phone, $street, $townId, $email)
    {
        $this->setFirstname($firstname);
        $this->setLastname($lastname);
        $this->setPhone($phone);
        $this->setStreet($street);
        $this->setTownId($townId);
        $this->setEmail($email);
    }

    /**
     * return string
     */
    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function setFirstname($firstname)
    {
        $firstname = trim($firstname);

        if (strlen($firstname) > self::NAME_CHAR_MAX) {
            $this->errors['firstname'] = 'Le prénom est trop long, maximum 50 caractères.';
        } elseif (strlen($firstname) <= self::MIN_CHAR) {
            $this->errors['firstname'] = 'Le prénom est trop court, minimum 1 caractère.';
        } else {
            $this->firstname = $firstname;
        }
    }

    /**
     * return string
     */
    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function setLastname($lastname)
    {
        $lastname = trim($lastname);

        if (strlen($lastname) > self::NAME_CHAR_MAX) {
            $this->errors['lastname'] = 'Le nom est trop long, maximum 50 caractères.';
        } elseif (strlen($lastname) <= self::MIN_CHAR) {
            $this->errors['lastname'] = 'Le nom est trop court, minimum 1 caractère.';
        } else {
            $this->lastname = $lastname;
        }
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function setPhone($phone)
    {
        $phone = trim($phone);

        if (strlen($phone) != 10) {
            $this->errors['phone'] = 'Le numéro de téléphone doit avoir 10 caractères.';
        } else {
            $this->phone = $phone;
        }
    }

    /**
     * return string
     */
    public function getStreet(): string
    {
        return $this->street;
    }

    public function setStreet($street)
    {
        $street = trim($street);

        if (strlen($street) > 255) {
            $this->errors['street'] = 'Le nom de la rue est trop long, maximum 255 caractères.';
        } elseif (strlen($street) <= self::MIN_CHAR) {
            $this->errors['street'] = 'Le nom de la rue est trop court, minimum 1 caractère.';
        } else {
            $this->street = $street;
        }
    }

    public function getTownId()
    {
        return $this->townId;
    }

    public function setTownId($townId)
    {
        $townId = trim($townId);

        if ($townId === '-- --') {
            $this->errors['townId'] = 'Merci de choisir une ville dans la liste.';
        } else {
            $this->townId = $townId;
        }
    }

    /**
     * return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $email = trim($email);

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->errors['email'] = 'L\'email est invalide';
        } else {
            $this->email = $email;
        }
    }

    /**
     * return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    public function isValid(): bool
    {
        return empty($this->errors);
    }
}
