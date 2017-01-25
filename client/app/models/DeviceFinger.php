<?php

class DeviceFinger extends BaseCollection
{

    /**
     *
     * @var integer
     */
    public $_id;
    public $deviceid;
    public $fingers;

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'devicefinger';
    }

}
