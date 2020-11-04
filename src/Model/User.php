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
        $this->setFirstname(trim($firstname));
        $this->setLastname(trim($lastname));
        $this->setPhone(trim($phone));
        $this->setStreet(trim($street));
        $this->setTownId(trim($townId));
        $this->setEmail(trim($email));
    }

    public function getFirstname() : string
    {
        return $this->firstname;
    }

    public function setFirstname($firstname)
    {
        if (strlen($firstname) > 50) {
            $this->errors['firstname'] = 'The firstname is too long, maximum 50 characters';
        } elseif (strlen($firstname) <= 0) {
            $this->errors['firstname'] = 'The firstname is too short, minimum 1 character';
        } else {
            $this->firstname = $firstname;
        }
    }

    public function getLastname()
    {
        return $this->lastname;
    }

    public function setLastname($lastname)
    {
        if (strlen($lastname) > 50) {
            $this->errors['lastname'] = 'The lastname is too long, maximum 50 characters';
        } elseif (strlen($lastname) <= 0) {
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
        if (strlen($phone) != 10) {
            $this->errors['phone'] = 'The phone number has to be 10 numbers';
        } else {
            $this->phone = $phone;
        }
    }

    public function getStreet()
    {
        return $this->street;
    }

    public function setStreet($street)
    {
        if (strlen($street) > 255) {
            $this->errors['street'] = 'The street is too long, maximum 255 characters';
        } elseif (strlen($street) <= 0) {
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
        if (!preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#i", $email)) {
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
