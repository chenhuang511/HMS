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
        $uinfo = (object)$this->session->get("uinfo");
        $uid = $uinfo->id;
        $listdevice = UserDevice::find(array(
            "conditions"=>"user_id = :userid:",
            "bind"=>array("userid"=>$uid)
        ));
        $this->view->listdevice = $listdevice;
    }
    public function detailAction(){
        $deviceid = $this->request->get("device","string");
        $uinfo = (object)$this->session->get("uinfo");
        $uid = $uinfo->id;
        $deviceobject = Device::findFirst(array(
            "conditions"=>"deviceid = :deviceid:",
            "bind"=>array("deviceid"=>$deviceid)
        ));
        $obj = UserDevice::findFirst(array(
            "conditions"=>"user_id = :userid: and device_id = :deviceid:",
            "bind"=>array("userid"=>$uid,"deviceid"=>$deviceobject->id)
        ));
        if($obj->id<=0){
            $this->response->redirect("index/index");
            return false;
        }
        $this->view->bp = $this->getBP();
        $this->view->temp = $this->getTemp();
        $this->view->spo2 = $this->getSPO2();
    }

    private function getTemp(){
        global $config;
        $logpath = $config->logpath;
        $date = $this->request->get("date","string");
        $starthour = $this->request->get("starthour","string");
        $endhour = $this->request->get("endhour","string");
        $device = $this->request->get("device","string");
        $date_file = date("Y-m-d",strtotime("$date 00:00:00"));
        $date_file = str_replace("-","\\",$date_file);
        $mintime = strtotime("$date $starthour:00");
        $maxtime = strtotime("$date $endhour:59");
        // TEMP
        $file = "$logpath{$date_file}\\{$device}\\TEMP.txt";
        $lines = file($file);
        $temp = array();
        foreach ($lines as $line_num => $line) {
            list($datetime,$device,$type,$a) = explode(",",$line);
            $datetime = str_replace(array("\\"," "),array("-","T"),$datetime);
            $dint = $this->convertDateToInt($datetime);
            if($dint>=$mintime && $dint<=$maxtime) $temp[] =  array("datestr"=>$datetime,"value"=>$a,"dint"=>$dint);
        }
        return $temp;
    }

    private function getBP(){
        global $config;
        $logpath = $config->logpath;
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
        $temp = array();
        foreach ($lines as $line_num => $line) {
            list($datetime,$device,$type,$a,$b,$c) = explode(",",$line);
            $datetime = str_replace(array("\\"," "),array("-","T"),$datetime);
            $dint = $this->convertDateToInt($datetime);
            if($dint>=$mintime && $dint<=$maxtime)  $temp[] =  array("datestr"=>$datetime,"value_hight"=>$a,"value_low"=>$b,"value_heart"=>$c,"dint"=>$dint);
        }
        return $temp;
    }

    private function getSPO2(){
        global $config;
        $logpath = $config->logpath;
        $date = $this->request->get("date","string");
        $starthour = $this->request->get("starthour","string");
        $endhour = $this->request->get("endhour","string");
        $device = $this->request->get("device","string");
        $date_file = date("Y-m-d",strtotime("$date 00:00:00"));
        $date_file = str_replace("-","\\",$date_file);
        $mintime = strtotime("$date $starthour:00");
        $maxtime = strtotime("$date $endhour:59");
        // SPO2
        $file = "$logpath{$date_file}\\{$device}\\SPO2.txt";
        $lines = file($file);
        $temp = array();
        foreach ($lines as $line_num => $line) {

            list($datetime,$device,$type,$a,$b) = explode(",",$line);
            $datetime = str_replace(array("\\"," "),array("-","T"),$datetime);
            $dint = $this->convertDateToInt($datetime);
            if($dint>=$mintime && $dint<=$maxtime)   $temp[] =  array("datestr"=>$datetime,"value"=>$b,"dint"=>$dint);
        }
        return $temp;
    }

    private function convertDateToInt($strdate){
        $strdate = str_replace("T"," ",$strdate);
        $date = DateTime::createFromFormat('Y-m-d H:i:s', $strdate);
        return strtotime($date->format("d-m-Y H:i:s"));
    }
}