<?php
/**
 * Created by WCS.
 * User: Célia
 * Date : 04/11/2020
 */

namespace App\Model;

/**
 *
 */
class TownManager extends AbstractManager
{
    /**
     *
     */
    const TABLE = 'town';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }
}
