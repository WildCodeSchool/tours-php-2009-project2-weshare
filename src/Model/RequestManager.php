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
                            ' ON user.id = fk_requester_id ORDER BY publication_date DESC LIMIT 6')
                            ->fetchAll();
    }


    // Get all demands
    public function selectAllRequests(): ?array
    {
        try {
             $statement = $this->pdo->query('SELECT * FROM ' . self::TABLE .
            ' JOIN ' . UserManager::TABLE . ' ON user.id = fk_requester_id')->fetchAll();
        } catch (\PDOException $error) {
            return null;
        }
        if ($statement !== false) {
            return $statement;
        }
    }

    public function insert(array $request) : void
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . " (title,quantity,
        description,publication_date,fk_requester_id,fk_measurement_id) VALUES (:title,:quantity,
        :description,curdate(),:userId,:measurementId)");

        $statement->bindValue('title', $request['title'], \PDO::PARAM_STR);
        $statement->bindValue('quantity', $request['quantity'], \PDO::PARAM_INT);
        $statement->bindValue('description', $request['description'], \PDO::PARAM_STR);
        $statement->bindValue('userId', $request['userId'], \PDO::PARAM_INT);
        $statement->bindValue('measurementId', $request['measurementId'], \PDO::PARAM_INT);
        $statement->execute();
    }
}
