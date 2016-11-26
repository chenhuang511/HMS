<?php

/**
 * Created by PhpStorm.
 * User: VietNH
 * Date: 11/24/2016
 * Time: 3:59 PM
 */
class BaseCollection extends \Phalcon\Mvc\Collection
{
    public function initialize()
    {
        $this->setConnectionService("dbMongo");
        $this->useImplicitObjectIds(false);
    }

}