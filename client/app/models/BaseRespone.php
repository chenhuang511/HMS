<?php

/**
 * Created by PhpStorm.
 * User: ViviPro
 * Date: 10/29/2016
 * Time: 9:26 PM
 */
class BaseRespone
{
    public $status;
    public $message;
    public $data;

    /**
     * BaseRespone constructor.
     * @param $status
     * @param $message
     * @param $data
     */
    public function __construct($status, $message, $data)
    {
        $this->status = $status;
        $this->message = $message;
        $this->data = $data;
    }


}