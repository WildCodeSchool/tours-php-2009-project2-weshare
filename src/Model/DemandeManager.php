<?php
/**
 * Created by WCS.
 * User: Kevin
 * Date : 28/10/2020
 */

namespace App\Model;

class DemandeManager extends AbstractManager
{
    const TABLE = 'demande';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function selectFirsts(string $tableUtilisateur): array
    {
        return $this->pdo->query('SELECT ' . $this->table . '.*, ' . $tableUtilisateur . '.* FROM ' . $this->table .
                            ' JOIN ' . $tableUtilisateur . ' ON utilisateur_id = fk_demandeur_id LIMIT 6')->fetchAll();
    }

    /**
     * @param array $item
     * @return int
     */
    /*public function insert(array $item): int
    {
        // prepared request
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . " (`title`) VALUES (:title)");
        $statement->bindValue('title', $item['title'], \PDO::PARAM_STR);

        if ($statement->execute()) {
            return (int)$this->pdo->lastInsertId();
        }
    }*/


    /**
     * @param int $id
     */
    /*public function delete(int $id): void
    {
        // prepared request
        $statement = $this->pdo->prepare("DELETE FROM " . self::TABLE . " WHERE id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();
    }*/


    /**
     * @param array $item
     * @return bool
     */
    /*public function update(array $item):bool
    {

        // prepared request
        $statement = $this->pdo->prepare("UPDATE " . self::TABLE . " SET `title` = :title WHERE id=:id");
        $statement->bindValue('id', $item['id'], \PDO::PARAM_INT);
        $statement->bindValue('title', $item['title'], \PDO::PARAM_STR);

        return $statement->execute();
    }*/
}
