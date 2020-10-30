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
             $statement = $this->pdo->query('SELECT * FROM ' . self::TABLE .
            ' JOIN ' . UserManager::TABLE . ' ON user.id = fk_requester_id')->fetchAll();
        } catch (\PDOException $error) {
            return null;
        }
        if ($statement !== false) {
            return $statement;
        }
    }
}
