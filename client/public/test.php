<?php
/**
 * Created by PhpStorm.
 * User: VietNH
 * Date: 7/1/2016
 * Time: 5:00 PM
 */
ini_set("display_errors",1);
error_reporting(E_ALL);
$mg = new MongoClient("mongodb://1:1@1:27017/1");
$userscl = $mg->selectCollection("1","1");
$l = iterator_to_array($userscl->find(),false);
print_r($l);