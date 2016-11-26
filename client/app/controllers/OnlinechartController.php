<?php

class OnlinechartController extends ControllerBase
{
    public function initialize()
    {
        $this->modulename = "home";
        $this->view->activesidebar = "/onlinechart/index";
        parent::initialize();
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
        $deviceid = $this->request->get("id","string");
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
        $this->view->deviceid = $deviceobject->deviceid;

        $this->view->temp = $this->loadOldTemp($deviceid);;
        $this->view->oxygen = $this->loadOldOxygen($deviceid);
        $this->view->bp = $this->loadOldBp($deviceid);
    }
    private function loadOldTemp($deviceid){
        $logs = LogCollection::find(
            [
                [
                    "type" => "TEMP",
                    "deviceid"=>$deviceid
                ],
                "sort"  => [
                    "datetime" => -1,
                ],
                "limit" => 15,
            ]
        );
        $temp = array();
        for($i=0;$i<15;$i++) {
            $dint = strtotime("-$i seconds");
            $temp[$i] = array("datestr"=>date("Y-m-d",$dint)."T".date("H:i:s",$dint),"value"=>0,"dint"=>$dint);
        }
        foreach ($logs as $line_num => $line) {
            $datetime = date("Y-m-d H:i:s",$line->datetime);
            $a = $line->temp;
            if(strlen($datetime)>2){
                $datetime = str_replace(" ","T",$datetime);
                $dint = $this->convertDateToInt($datetime);
                $temp[$line_num] =  array("datestr"=>$datetime,"value"=>$a,"dint"=>$dint);
            }
        }
        usort($temp, function($a, $b) {
            return $a['dint'] - $b['dint'];
        });
        $lasttemp= 0;
        foreach($temp as $key=>$val){
            if($val['value']==0) $val['value'] = $lasttemp;
            else{
                $lasttemp = $val['value'];
            }
            $temp[$key] = $val;
        }
        return $temp;
    }
    private function loadOldOxygen($deviceid){
        $logs = LogCollection::find(
            [
                [
                    "type" => "SPO2",
                    "deviceid"=>$deviceid
                ],
                "sort"  => [
                    "datetime" => -1,
                ],
                "limit" => 15,
            ]
        );
        $temp = array();
        for($i=0;$i<15;$i++) {
            $dint = strtotime("-$i seconds");
            $temp[$i] = array("datestr"=>date("Y-m-d",$dint)."T".date("H:i:s",$dint),"value"=>0,"dint"=>$dint);
        }

        foreach ($logs as $line_num => $line) {
            $datetime = date("Y-m-d H:i:s",$line->datetime);
            $b = $line->oxygen;
            if(strlen($datetime)>2){
                $datetime = str_replace(" ","T",$datetime);
                $dint = $this->convertDateToInt($datetime);
                $temp[$line_num] =  array("datestr"=>$datetime,"value"=>$b,"dint"=>$dint);
            }
        }
        usort($temp, function($a, $b) {
            return $a['dint'] - $b['dint'];
        });
        $lasttemp= 0;
        foreach($temp as $key=>$val){
            if($val['value']==0) $val['value'] = $lasttemp;
            else{
                $lasttemp = $val['value'];
            }
            $temp[$key] = $val;
        }
        return $temp;
    }
    private function loadOldBp($deviceid){
        $logs = LogCollection::find(
            [
                [
                    "type" => "BP",
                    "deviceid"=>$deviceid
                ],
                "sort"  => [
                    "datetime" => -1,
                ],
                "limit" => 15,
            ]
        );

        $temp = array();
        for($i=0;$i<15;$i++) {
            $dint = strtotime("-$i seconds");
            $temp[$i] = array("datestr"=>date("Y-m-d",$dint)."T".date("H:i:s",$dint),"value_hight"=>0,"value_low"=>0,"value_heart"=>0,"dint"=>$dint);
        }
        foreach ($logs as $line_num => $line) {
            $datetime = date("Y-m-d H:i:s",$line->datetime);
            $a = $line->highpressure;
            $b = $line->lowpressure;
            $c = $line->heartrate;
            if(strlen($datetime)>2){
                $datetime = str_replace(" ","T",$datetime);
                $dint = $this->convertDateToInt($datetime);
                $temp[$line_num] =  array("datestr"=>$datetime,"value_hight"=>$a,"value_low"=>$b,"value_heart"=>$c,"dint"=>$dint);
            }
        }
        usort($temp, function($a, $b) {
            return $a['dint'] - $b['dint'];
        });
        $lasttemp_hight = $lasttemp_low = $lasttemp_heart = 0;
        foreach($temp as $key=>$val){
            if($val['value_hight']==0) $val['value_hight'] = $lasttemp_hight;
            else $lasttemp_hight = $val['value_hight'];
            if($val['value_low']==0) $val['value_low'] = $lasttemp_low;
            else $lasttemp_low = $val['value_low'];
            if($val['value_heart']==0) $val['value_heart'] = $lasttemp_heart;
            else $lasttemp_heart = $val['value_heart'];
            $temp[$key] = $val;
        }
        return $temp;
    }
    private function convertDateToInt($strdate){
        $strdate = str_replace("T"," ",$strdate);
        $date = DateTime::createFromFormat('Y-m-d H:i:s', $strdate);
        return strtotime($date->format("d-m-Y H:i:s"));
    }

    public function deleteAction(){
        global $config;
        $type = $this->request->get("type");
        $deviceid = $this->request->get("deviceid");
        switch ($type){
            case 'temp':
                $type = "TEMP";
                break;
            case 'spo2':
                $type = "SPO2";
                break;
            case 'bp':
                $type = "BP";
                break;
        }
        $lists = LogCollection::find(
            [
                [
                    "type" => "$type",
                    "deviceid"=>$deviceid
                ],
                "sort"  => [
                    "datetime" => -1,
                ],
                "limit" => 15,
            ]
        );
        foreach($lists as $doc) $doc->delete();
        $this->response->redirect("onlinechart/detail?id=$deviceid");
    }
}