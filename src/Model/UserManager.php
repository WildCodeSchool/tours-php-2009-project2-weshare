<?php
/**
 * Created by WCS.
 * User: Kevin
 * Date : 28/10/2020
 */

namespace App\Model;

class UserManager extends AbstractManager
{
    /**
     * set the global constant TABLE with the name of the table user in the DB
     */
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
    public function insert(User $user) : void
    {
        $statement1 = $this->pdo->prepare("INSERT INTO address (fk_town_id,street)
        VALUES (:townId,:street)");

        $statement1->bindValue('townId', $user->getTownId(), \PDO::PARAM_INT);
        $statement1->bindValue('street', $user->getStreet(), \PDO::PARAM_STR);
        $statement1->execute();
        $fkAddressId = $this->pdo->lastInsertId();

        $statement2 = $this->pdo->prepare("INSERT INTO " . self::TABLE . " (firstname,lastname,
        phone,email,fk_address_id) VALUES (:firstname,:lastname,:phone,:email,"
        . $fkAddressId . ")");

        $statement2->bindValue('firstname', $user->getFirstname(), \PDO::PARAM_STR);
        $statement2->bindValue('lastname', $user->getLastname(), \PDO::PARAM_STR);
        $statement2->bindValue('phone', $user->getPhone(), \PDO::PARAM_STR);
        $statement2->bindValue('email', $user->getEmail(), \PDO::PARAM_STR);
        $statement2->execute();
    }
}
