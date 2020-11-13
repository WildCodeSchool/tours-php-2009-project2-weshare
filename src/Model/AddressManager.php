<?php

/**
 * Created by Wcs.
 * User: celia
 * Date: 28/10/2020
 */

namespace App\Model;

class AddressManager extends AbstractManager
{
    public const TABLE = 'address';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }
}
