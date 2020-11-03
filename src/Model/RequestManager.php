<?php
/**
 * Created by WCS.
 * User: Kevin
 * Date : 28/10/2020
 */

namespace App\Model;

class RequestManager extends AbstractManager
{
    const TABLE = 'request';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function selectFirsts(): array
    {
        return $this->pdo->query('SELECT * FROM ' . self::TABLE . ' JOIN ' . UserManager::TABLE .
                            ' ON user.id = fk_requester_id LIMIT 6')->fetchAll();
    }


    // Get all demands
    public function selectAllRequests(): ?array
    {
        try {
             $statement = $this->pdo->query('SELECT request.id AS requestId, user.firstname AS userFirstName, user.lastname AS userLastName,
              request.title AS requestTitle, request.description AS requestDescription,
              request.quantity AS requestQuantity, measurement.name AS measurementName, 
              user.phone AS userPhone, user.email AS userEmail, address.street AS addressStreet, town.name AS townName,
              town.postal_code AS townPostalCode, request.publication_date AS requestPublicationDate FROM ' . self::TABLE .
            ' JOIN ' . UserManager::TABLE . ' ON user.id = fk_requester_id ' . 
            ' JOIN ' . AddressManager::TABLE . ' ON address.id = fk_town_id ' .
            ' JOIN ' . TownManager::TABLE . ' ON town.id = fk_address_id ' .
            ' JOIN ' . MeasurementManager::TABLE . ' ON measurement.id = fk_measurement_id')->fetchAll();

        } catch (\PDOException $error) {
            return null;
        }
        if ($statement !== false) {
            return $statement;
        }
    }
}
