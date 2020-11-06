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

    const NAME_CHAR_MAX = 50;
    const MIN_CHAR = 0;
    
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
    public function getFirstname() : string
    {
        return $this->firstname;
    }

    public function setFirstname($firstname)
    {
        $firstname = trim($firstname);

        if (strlen($firstname) > self::NAME_CHAR_MAX) {
            $this->errors['firstname'] = 'Le prénom est trop long, merci de mettre au maximum 50 charactères.';
        } elseif (strlen($firstname) <= self::MIN_CHAR) {
            $this->errors['firstname'] = 'Le prénom est trop court, merci de mettre au minimum 1 charactère.';
        } else {
            $this->firstname = $firstname;
        }
    }

    /**
     * return string
     */
    public function getLastname() : string
    {
        return $this->lastname;
    }

    public function setLastname($lastname)
    {
        $lastname = trim($lastname);

        if (strlen($lastname) > self::NAME_CHAR_MAX) {
            $this->errors['lastname'] = 'Le nom est trop long, merci de mettre au maximum 50 charactères.';
        } elseif (strlen($lastname) <= self::MIN_CHAR) {
            $this->errors['lastname'] = 'Le nom est trop court, merci de mettre au minimum 1 charactère.';
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
            $this->errors['phone'] = 'Le numéro de téléphone doit être composé de 10 chiffres au format 0612345678.';
        } else {
            $this->phone = $phone;
        }
    }

    /**
     * return string
     */
    public function getStreet() : string
    {
        return $this->street;
    }

    public function setStreet($street)
    {
        $street = trim($street);

        if (strlen($street) > 255) {
            $this->errors['street'] = 'Le nom de la rue est trop long, merci de mettre au maximum 255 charactères.';
        } elseif (strlen($street) <= self::MIN_CHAR) {
            $this->errors['street'] = 'Le nom de la rue est trop court, merci de mettre au minimum 1 charactère.';
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

        if (strlen($townId) <= self::MIN_CHAR) {
            $this->errors['townId'] = 'Veuillez choisir une ville dans la liste déroulante.';
        } else {
            $this->townId = $townId;
        }
    }

    /**
     * return string
     */
    public function getEmail() : string
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $email = trim($email);

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->errors['email'] = 'L\'email est invalide.';
        } else {
            $this->email = $email;
        }
    }

    /**
     * return array
     */
    public function getErrors() : array
    {
        return $this->errors;
    }

    public function isValid() : bool
    {
        return empty($this->errors);
    }
}
