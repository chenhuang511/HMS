<?php

/**
 * Created by PhpStorm.
 * User: VietNH
 * Date: 5/25/2016
 * Time: 11:54 AM
 */
class LogController extends ControllerBase
{
    public function loginAction(){
        $file = "D:\\Project\\Teca_pro\\Healthcare\\HMS\\socket_server\\server\\data\\2016\\05\\23\\D001\\BP.txt";
        $lines = file($file);
        $bp = array();
        foreach ($lines as $line_num => $line) {
            list($datetime,$device,$type,$a,$b,$c) = explode(",",$line);
            $bp[] = array($a,$b,$c);
        }
    }
}