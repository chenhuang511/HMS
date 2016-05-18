<?php

class Device extends BaseModel
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var string
     */
    public $name;

    /**
     *
     * @var string
     */
    public $deviceid;

    /**
     *
     * @var string
     */
    public $sim;

    /**
     *
     * @var integer
     */
    public $status;

    /**
     *
     * @var string
     */
    public $note;

    /**
     *
     * @var integer
     */
    public $create_at;

    /**
     *
     * @var integer
     */
    public $usercreate;

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Device[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Device
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'device';
    }

}
