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

        $date = $this->request->get("date","string");
        $starthour = $this->request->get("starthour","string");
        $endhour = $this->request->get("endhour","string");
        $device = $this->request->get("device","string");
        if(strlen($date)<=0) $date = date("d-m-Y");
        if(strlen($starthour)<=0) $starthour = "00:00";
        if(strlen($endhour)<=0) $endhour = "23:59";

        $this->view->temp = self::getTemp($date,$starthour,$endhour,$device,1);
        $this->view->bp = self::getBP($date,$starthour,$endhour,$device,1);
        $this->view->spo2 = self::getSPO2($date,$starthour,$endhour,$device,1);
    }

    public static function getTemp($date,$starthour,$endhour,$device,$sortflag){
        $mintime = strtotime("$date $starthour:00");
        $maxtime = strtotime("$date $endhour:59");
        $criterial= array(
            "type" => "TEMP",
            "datetime"=>array('$gte'=>$mintime,'$lte'=>$maxtime)
        );
        if(strlen($device)>0) $criterial["deviceid"] = $device;
        $logs = LogCollection::find(
            [
                $criterial,
                "sort"  => [
                    "datetime" => $sortflag,
                ]
            ]
        );
        // TEMP
        $temp = array();
        foreach ($logs as $line_num => $line) {
            $temp[] =  array("value"=>$line->temp,"dint"=>$line->datetime);
        }
        return $temp;
    }

    public static function getBP($date,$starthour,$endhour,$device,$sortflag){
        $mintime = strtotime("$date $starthour:00");
        $maxtime = strtotime("$date $endhour:59");
        $criterial= array(
            "type" => "BP",
            "datetime"=>array('$gte'=>$mintime,'$lte'=>$maxtime)
        );
        if(strlen($device)>0) $criterial["deviceid"] = $device;
        $logs = LogCollection::find(
            [
                $criterial,
                "sort"  => [
                    "datetime" => $sortflag,
                ]
            ]
        );
        $temp = array();
        foreach ($logs as $line_num => $line) {
            $datetime = str_replace(" ","T",date("d-m-Y H:i:s",$line->datetime));
            $temp[] =  array("datestr"=>$datetime,"value_hight"=>$line->highpressure,"value_low"=>$line->lowpressure,"value_heart"=>$line->heartrate,"dint"=>$line->datetime);
        }
        return $temp;
    }

    public static function getSPO2($date,$starthour,$endhour,$device,$sortflag){
        $mintime = strtotime("$date $starthour:00");
        $maxtime = strtotime("$date $endhour:59");
        $criterial= array(
            "type" => "SPO2",
            "datetime"=>array('$gte'=>$mintime,'$lte'=>$maxtime)
        );
        if(strlen($device)>0) $criterial["deviceid"] = $device;
        $logs = LogCollection::find(
            [
                $criterial,
                "sort"  => [
                    "datetime" => $sortflag,
                ]
            ]
        );

        // SPO2
        $temp = array();
        foreach ($logs as $line_num => $line) {
            $datetime = str_replace(" ","T",date("d-m-Y H:i:s",$line->datetime));
            $temp[] =  array("datestr"=>$datetime,"value"=>$line->oxygen,"dint"=>$line->datetime);
        }
        return $temp;
    }

}