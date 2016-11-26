<?php
ini_set('display_errors', true);
error_reporting(1);
defined('APP_PATH') || define('APP_PATH', realpath('.'));

return new \Phalcon\Config(array(
    'database' => array(
        'adapter'     => 'Mysql',
        'host'        => '127.0.0.1',
        'username'    => 'root',
        'password'    => '123456$',
        'dbname'      => 'healthcare',
        'charset'     => 'utf8',
    ),
    'databaseMongo' => array(
        'host'        => '127.0.0.1',
        'username'    => 'root',
        'password'    => '123456$',
        'dbname'      => 'healthcare',
        'port'      => 27017,
    ),
    'application' => array(
        'controllersDir' => APP_PATH . '/app/controllers/',
        'modelsDir'      => APP_PATH . '/app/models/',
        'migrationsDir'  => APP_PATH . '/app/migrations/',
        'viewsDir'       => APP_PATH . '/app/views/',
        'pluginsDir'     => APP_PATH . '/app/plugins/',
        'libraryDir'     => APP_PATH . '/app/library/',
        'cacheDir'       => APP_PATH . '/app/cache/',
        'vendorDir'       => APP_PATH . '/app/vendor/',
        'cultureDir'       => APP_PATH . '/app/config/i18n/',
        'baseUri'        => '/',
        'baseUrl' => 'http://10.0.0.254:9874/' // web
    ),
    "logpath"=>"D:\\Project\\Teca_pro\\Healthcare\\HMS\\socket_server\\server\\data\\",
    "socket_path"=>"http://10.0.0.254:2999", // listener from socket
    "media"=>array(
        'dir'=>'D:\Project\Teca_pro\Healthcare\admincp\public\\',
        "host"=>"http://localhost:9874/" // web
    )
));
