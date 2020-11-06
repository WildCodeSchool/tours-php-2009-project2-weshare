<?php

/**
 * Created by WCS.
 * User: Kevin
 * Date : 28/10/2020
 */

namespace App\Model;

class RequestManager extends AbstractManager
{
    public const TABLE = 'request';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function selectFirsts(): ?array
    {
        try {
            $statement = $this->pdo->query('SELECT * FROM ' . self::TABLE . ' JOIN ' . UserManager::TABLE .
                            ' ON user.id = fk_requester_id ORDER BY publication_date DESC LIMIT 6')
                            ->fetchAll();
        } catch (\PDOException $error) {
            return null;
        }
        return $statement;
    }


    /* Get all demands; you MUST use an alias otherwise you will have a
    problem with the request (too many identical names)*/
    public function selectAllRequests(): ?array
    {
        try {
             $statement = $this->pdo->query('SELECT request.id AS requestId, user.firstname AS userFirstName, 
              user.lastname AS userLastName,
              request.title AS requestTitle, request.description AS requestDescription,
              request.quantity AS requestQuantity, measurement.name AS measurementName, 
              user.phone AS userPhone, user.email AS userEmail, address.street AS addressStreet, 
              town.name AS townName, 
              town.postal_code AS townPostalCode, request.publication_date AS requestPublicationDate 
              FROM ' . self::TABLE .
            ' LEFT JOIN ' . UserManager::TABLE . ' ON user.id = fk_requester_id ' .
            ' LEFT JOIN ' . AddressManager::TABLE . ' ON address.id = fk_address_id ' .
            ' LEFT JOIN ' . TownManager::TABLE . ' ON town.id = fk_town_id ' .
            ' LEFT JOIN ' . MeasurementManager::TABLE . ' ON measurement.id = fk_measurement_id')->fetchAll();
        } catch (\PDOException $error) {
            return null;
        }
        return $statement;
    }

    public function insert(Request $request): ?bool
    {
        try {
            $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . " (title,quantity,
            description,publication_date,fk_requester_id,fk_measurement_id) VALUES (:title,:quantity,
            :description,curdate(),:userId,:measurementId)");

            $statement->bindValue('title', $request->getTitle(), \PDO::PARAM_STR);
            $statement->bindValue('quantity', $request->getQuantity(), \PDO::PARAM_INT);
            $statement->bindValue('description', $request->getDescription(), \PDO::PARAM_STR);
            $statement->bindValue('userId', $request->getUserId(), \PDO::PARAM_INT);
            $statement->bindValue('measurementId', $request->getmeasurementId(), \PDO::PARAM_INT);
            $result = $statement->execute();
        } catch (\PDOException $error) {
            return null;
        }
        if ($result !== false) {
            return $result;
        }
        return null;
    }
}
