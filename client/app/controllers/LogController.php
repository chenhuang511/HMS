<?php

/**
 * Created by PhpStorm.
 * User: VietNH
 * Date: 5/25/2016
 * Time: 11:54 AM
 */
class LogController extends ControllerBase
{
    public function testAction(){
        $file = "D:\\Project\\Teca_pro\\Healthcare\\HMS\\socket_server\\server\\data\\2016\\05\\23\\D001\\BP.txt";
        $current = file_get_contents($file);
        $now =  time();
        for($i=0;$i<=4000;$i++){
            $time_sec1 = date("s");
            $time_sec2 = $time_sec1 + 1;
            $datetime=date("Y-m-d H:i:s",$now+$i+2);

            $time = $datetime;
            $hight = rand(100,140);
            $low = rand(60,90);
            $hearbeat = rand(60,90);
            $current .= "$time,D001,BP,$hight,$low,$hearbeat".PHP_EOL;
        }
        file_put_contents($file, $current);
    }
    public function indexAction(){
        
    }
    public function detailAction(){
        $logpath = "D:\\Project\\Teca_pro\\Healthcare\\HMS\\socket_server\\server\\data\\";
        $date = $this->request->get("date","string");
        $starthour = $this->request->get("starthour","string");
        $endhour = $this->request->get("endhour","string");
        $device = $this->request->get("device","string");
        $date_file = date("Y-m-d",strtotime("$date 00:00:00"));
        $date_file = str_replace("-","\\",$date_file);
        $mintime = strtotime("$date $starthour:00");
        $maxtime = strtotime("$date $endhour:59");
        // BP
        $file = "$logpath{$date_file}\\{$device}\\BP.txt";
        $lines = file($file);
        $bp = array();
        foreach ($lines as $line_num => $line) {
            list($datetime,$device,$type,$a,$b,$c) = explode(",",$line);
            $time_convert = $this->getTime($datetime);
            if($time_convert>=$mintime && $time_convert<=$maxtime){
                $datetime = str_replace(array("\\"," "),array("-","T"),$datetime);
                $bp[] = array($datetime,$a,$b,$c);
            }
        }
        $this->view->bp = $bp;
        // TEMP
        $file = "$logpath{$date_file}\\{$device}\\TEMP.txt";
        $lines = file($file);
        $temp = array();
        foreach ($lines as $line_num => $line) {
            list($datetime,$device,$type,$a) = explode(",",$line);
            $time_convert = $this->getTime($datetime);
            if($time_convert>=$mintime && $time_convert<=$maxtime){
                $datetime = str_replace(array("\\"," "),array("-","T"),$datetime);
                $temp[] = array($datetime,$a);
            }
        }
        $this->view->temp = $temp;
        // Oxygen
        

    }
    private function getTime($strdate){
        list($date,$time) = explode(" ",$strdate);
        list($y,$m,$d) = explode("\\",$date);
        return strtotime("$d-$m-$y $time");
    }
}