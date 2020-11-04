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
            $this->errors['firstname'] = 'The firstname is too long, maximum 50 characters';
        } elseif (strlen($firstname) <= self::MIN_CHAR) {
            $this->errors['firstname'] = 'The firstname is too short, minimum 1 character';
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
            $this->errors['lastname'] = 'The lastname is too long, maximum 50 characters';
        } elseif (strlen($lastname) <= self::MIN_CHAR) {
            $this->errors['lastname'] = 'The lastname is too short, minimum 1 character';
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
            $this->errors['phone'] = 'The phone number has to be 10 numbers';
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
            $this->errors['street'] = 'The street is too long, maximum 255 characters';
        } elseif (strlen($street) <= self::MIN_CHAR) {
            $this->errors['street'] = 'The street is too short, minimum 1 character';
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
            $this->errors['townId'] = 'Choose a town in the list';
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
            $this->errors['email'] = 'L\'email est invalide';
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

    public function isIncomplete()
    {
    }
}
