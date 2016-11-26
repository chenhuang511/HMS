<?php

/**
 * Created by PhpStorm.
 * User: VietNH
 * Date: 11/25/2016
 * Time: 10:53 AM
 */
class ApiController extends \Phalcon\Mvc\Controller
{
    public function initialize()
    {
        header("Content-Type:application/json;charset=utf-8");
        $this->view->disable();
        if($this->request->has("token")) {
            $this->session->destroy();
            $this->session->setId($this->request->get("token"));
            $this->session->start();
        }
    }
    public function authAction(){
        $baseRS = new BaseRespone(1,"Success",null);
        
        $datapost = Helper::post_to_array("username,password");
        $datapost['password'] = Helper::encryptpassword($datapost['password']);
        $o = User::findFirst(array(
            "columns"=>"id,username,firstname,lastname,avatar,email,address,phone",
            "conditions"=>"username = :u: and password = :p:",
            "bind"=>array("u"=>$datapost['username'],"p"=>$datapost['password'])
        ));
        if($o->id>0) {
            $object= $o->toArray();
            $object['token'] = $this->session->getId();
            $baseRS->data = $object;
            $this->session->set("auth",$object);
        }
        else{
            $baseRS->status = 0;
            $baseRS->message = "Account not available";
        }
        echo json_encode($baseRS);
        return;
    }
    public function getlogAction(){
        if(!$this->session->has("auth")) return;
        $baseRS = new BaseRespone(1,"Success",null);
        $date = $this->request->get("date","string");
        $starthour = $this->request->get("starthour","string");
        $endhour = $this->request->get("endhour","string");
        $device = $this->request->get("deviceid","string");
        $type = $this->request->get("type","string");

        if(strlen($date)<=0) $date = date("d-m-Y");
        if(strlen($starthour)<=0) $starthour = "00:00";
        if(strlen($endhour)<=0) $endhour = "23:59";
        if($type=="temp") $data['temp'] = LogController::getTemp($date,$starthour,$endhour,$device,1);
        else  if($type=="spo2") $data['spo2'] = LogController::getSPO2($date,$starthour,$endhour,$device,1);
        else  if($type=="bp")  $data['bp']  = LogController::getBP($date,$starthour,$endhour,$device,1);
        else{
            $data['temp'] = LogController::getTemp($date,$starthour,$endhour,$device,1);
            $data['spo2'] = LogController::getSPO2($date,$starthour,$endhour,$device,1);
            $data['bp']  = LogController::getBP($date,$starthour,$endhour,$device,1);
        }
        $baseRS->data = $data;
        echo json_encode($baseRS);
        return;
    }
}