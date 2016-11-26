<?php

/**
 * Created by PhpStorm.
 * User: VietNH
 * Date: 11/24/2016
 * Time: 3:59 PM
 */
class LogCollection extends BaseCollection
{
    public $_id;
    public function initialize()
    {
        parent::initialize();
    }

    public function getSource()
    {
        return "log";
    }


}