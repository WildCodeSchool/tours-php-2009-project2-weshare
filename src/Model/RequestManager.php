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

    /*return the last 6 user requests of the dbb */
    public function selectFirsts(): ?array
    {
        try {
            $results = $this->pdo->query('SELECT request.id AS requestId, user.firstname AS userFirstName, 
            user.lastname AS userLastName, request.title AS requestTitle, town.name AS townName, 
            request.publication_date AS requestPublicationDate 
            FROM ' . self::TABLE .
            ' LEFT JOIN ' . UserManager::TABLE . ' ON user.id = fk_requester_id ' .
            ' LEFT JOIN ' . AddressManager::TABLE . ' ON address.id = fk_address_id ' .
            ' LEFT JOIN ' . TownManager::TABLE . ' ON town.id = fk_town_id
            ORDER BY requestPublicationDate DESC LIMIT 6')->fetchAll();
        } catch (\PDOException $error) {
            return null;
        }
        return $results;
    }


    /* Get all demands; you MUST use an alias otherwise you will have a
    problem with the request (too many identical names)*/
    public function selectAllRequests(): ?array
    {
        try {
            $results = $this->pdo->query('SELECT request.id AS requestId, user.firstname AS userFirstName, 
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
            ' LEFT JOIN ' . MeasurementManager::TABLE . ' ON measurement.id = fk_measurement_id
            WHERE fk_answerer_id IS NULL
            ORDER BY requestPublicationDate DESC')->fetchAll();
        } catch (\PDOException $error) {
            return null;
        }

        return $results;
    }

    /*insert in the dbb a new user request, if the sql request fail, return false */
    public function insert(Request $request): bool
    {
        try {
            $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . " (title,quantity,
            description,publication_date,fk_requester_id,fk_measurement_id) VALUES (:title,:quantity,
            :description,curdate(),:userId,:measurementId)");
        } catch (\PDOException $error) {
            return false;
        }

        $statement->bindValue('title', $request->getTitle(), \PDO::PARAM_STR);
        $statement->bindValue('quantity', $request->getQuantity(), \PDO::PARAM_INT);
        $statement->bindValue('description', $request->getDescription(), \PDO::PARAM_STR);
        $statement->bindValue('userId', $request->getUserId(), \PDO::PARAM_INT);
        $statement->bindValue('measurementId', $request->getmeasurementId(), \PDO::PARAM_INT);
        $result = $statement->execute();

        return $result;
    }

    public function selectAllAcceptedRequests(): ?array
    {
        try {
            $result = $this->pdo->query('SELECT request.id AS requestId, user.firstname AS userFirstName,
            user.lastname AS userLastName,
            request.title AS requestTitle, request.description AS requestDescription,
            request.quantity AS requestQuantity, measurement.name AS measurementName, 
            user.phone AS userPhone, user.email AS userEmail, address.street AS addressStreet, 
            town.name AS townName, town.postal_code AS townPostalCode,
            request.publication_date AS requestPublicationDate, fk_answerer_id
            FROM ' . self::TABLE .
            ' LEFT JOIN ' . UserManager::TABLE . ' ON user.id = fk_requester_id ' .
            ' LEFT JOIN ' . AddressManager::TABLE . ' ON address.id = fk_address_id ' .
            ' LEFT JOIN ' . TownManager::TABLE . ' ON town.id = fk_town_id ' .
            ' LEFT JOIN ' . MeasurementManager::TABLE . ' ON measurement.id = fk_measurement_id
            WHERE fk_answerer_id IS NOT NULL')->fetchAll();
        } catch (\PDOException $error) {
            return null;
        }
        return $result;
    }

    public function selectAllAcceptedById(int $answererId): array
    {
        $error = [];
        try {
            $statement = $this->pdo->prepare('SELECT request.id AS requestId, user.firstname AS userFirstName,
            user.lastname AS userLastName,
            request.title AS requestTitle, request.description AS requestDescription,
            request.quantity AS requestQuantity, measurement.name AS measurementName, 
            user.phone AS userPhone, user.email AS userEmail, address.street AS addressStreet, 
            town.name AS townName, town.postal_code AS townPostalCode,
            request.publication_date AS requestPublicationDate, fk_answerer_id
            FROM ' . self::TABLE .
            ' LEFT JOIN ' . UserManager::TABLE . ' ON user.id = fk_requester_id ' .
            ' LEFT JOIN ' . AddressManager::TABLE . ' ON address.id = fk_address_id ' .
            ' LEFT JOIN ' . TownManager::TABLE . ' ON town.id = fk_town_id ' .
            ' LEFT JOIN ' . MeasurementManager::TABLE . ' ON measurement.id = fk_measurement_id
            WHERE fk_answerer_id =:answererId');

            $statement->bindValue('answererId', $answererId, \PDO::PARAM_INT);
            $statement->execute();
            $result = $statement->fetchAll();
        } catch (\PDOException $e) {
            return $error['bdd'] = ["Erreur sur la BDD"];
        }
        return $result;
    }
    /*update a given user request with the id of the user who decide to respond at this user request */
    public function updateOnAnswerer(int $anwererId, int $requestId): bool
    {
        try {
            $statement = $this->pdo->prepare("UPDATE " . self::TABLE .
            " SET fk_answerer_id=:answererId" . " WHERE request.id=:requestId");
        } catch (\PDOException $error) {
            return false;
        }

        $statement->bindValue('answererId', $anwererId, \PDO::PARAM_INT);
        $statement->bindValue('requestId', $requestId, \PDO::PARAM_INT);
        $result = $statement->execute();

        return $result;
    }
}
