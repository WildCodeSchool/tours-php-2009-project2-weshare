<?php

/**
 * Created by Wcs.
 * User: celia
 * Date: 28/10/2020
 */

namespace App\Model;

class MeasurementManager extends AbstractManager
{
    public const TABLE = 'measurement';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }
}
