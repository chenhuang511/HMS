<?php

class UserDevice extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var integer
     */
    public $user_id;

    /**
     *
     * @var integer
     */
    public $device_id;

    /**
     *
     * @var string
     */
    public $name;

    /**
     *
     * @var integer
     */
    public $create_at;

    /**
     *
     * @var integer
     */
    public $sorts;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->belongsTo('device_id', 'Device', 'id', array('alias' => 'Device'));
        $this->belongsTo('user_id', 'User', 'id', array('alias' => 'User'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'user_device';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return UserDevice[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return UserDevice
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
