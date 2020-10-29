<?php
/**
 * Created by WCS.
 * User: Kevin
 * Date : 28/10/2020
 */

namespace App\Model;

class UserManager extends AbstractManager
{
    const TABLE = 'user';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    /**
     * Function for adding a new user in our database
     */
    public function insert(array $user) : void
    {
        $statement1 = $this->pdo->prepare("INSERT INTO address (fk_town_id,street)
        VALUES (:townId,:street)");

        $statement1->bindValue('townId', $user['townId'], \PDO::PARAM_INT);
        $statement1->bindValue('street', $user['street'], \PDO::PARAM_STR);
        $statement1->execute();
        $fkAddressId = $this->pdo->lastInsertId();

        $statement2 = $this->pdo->prepare("INSERT INTO " . self::TABLE . " (firstname,lastname,
        civility,phone,email,fk_address_id) VALUES (:firstname,:lastname,:civility,:phone,:email,"
        . $fkAddressId . ")");

        $statement2->bindValue('firstname', $user['firstname'], \PDO::PARAM_STR);
        $statement2->bindValue('lastname', $user['lastname'], \PDO::PARAM_STR);
        $statement2->bindValue('civility', $user['civility'], \PDO::PARAM_STR);
        $statement2->bindValue('phone', $user['phone'], \PDO::PARAM_STR);
        $statement2->bindValue('email', $user['email'], \PDO::PARAM_STR);
        $statement2->execute();
    }
}
