<?php
/**
 * Created by WCS.
 * User: Célia
 * Date : 04/11/2020
 */
namespace App\Model;

class User
{
    private $firstname;
    private $lastname;
    private $phone;
    private $street;
    private $townId;
    private $email;
    private $errors = [];
    
    public function __construct($firstname, $lastname, $phone, $street, $townId, $email)
    {
        $this->setFirstname($firstname);
        $this->setLastname($lastname);
        $this->setPhone($phone);
        $this->setStreet($street);
        $this->setTownId($townId);
        $this->setEmail($email);
    }

    public function getFirstname() : string
    {
        return $this->firstname;
    }

    public function setFirstname($firstname)
    {
        $firstname = trim($firstname);

        if (strlen($firstname) > 50) {
            $this->errors['firstname'] = 'The firstname is too long, maximum 50 characters';
        } elseif (strlen($firstname) <= 0) {
            $this->errors['firstname'] = 'The firstname is too short, minimum 1 character';
        } else {
            $this->firstname = $firstname;
        }
    }

    public function getLastname() : string
    {
        return $this->lastname;
    }

    public function setLastname($lastname)
    {
        $lastname = trim($lastname);

        if (strlen($lastname) > 50) {
            $this->errors['lastname'] = 'The lastname is too long, maximum 50 characters';
        } elseif (strlen($lastname) <= 0) {
            $this->errors['lastname'] = 'The lastname is too short, minimum 1 character';
        } else {
            $this->lastname = $lastname;
        }
    }

    public function getPhone() : int
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

    public function getStreet() : string
    {
        return $this->street;
    }

    public function setStreet($street)
    {
        $street = trim($street);

        if (strlen($street) > 255) {
            $this->errors['street'] = 'The street is too long, maximum 255 characters';
        } elseif (strlen($street) <= 0) {
            $this->errors['street'] = 'The street is too short, minimum 1 character';
        } else {
            $this->street = $street;
        }
    }

    public function getTownId() : int
    {
        return $this->townId;
    }

    public function setTownId($townId)
    {
        $townId = trim($townId);

        if (strlen($townId) <= 0) {
            $this->errors['townId'] = 'Choose a town in the list';
        } else {
            $this->townId = $townId;
        }
    }

    public function getEmail()
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

    public function getErrors() : array
    {
        return $this->errors;
    }
}
