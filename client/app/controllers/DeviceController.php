<?php

/**
 * Created by PhpStorm.
 * User: VietNH
 * Date: 6/1/2016
 * Time: 8:07 AM
 */
class DeviceController extends ControllerBase
{
    public function initialize()
    {
        $this->modulename = "home";
        $this->view->activesidebar = "/device/index";
        parent::initialize();
    }

    public function indexAction(){
        $uinfo = (object)$this->session->get("uinfo");
        $listdevice = UserDevice::find(array(
           "conditions"=>"user_id = :uid:",
            "bind"=>array("uid"=>$uinfo->id)
        ));
        $this->view->listdevice = $listdevice;
    }
    public function formAction(){
        $uinfo = (object)$this->session->get("uinfo");
        $id = $this->request->get("id","int");
        if($this->request->isPost()){
            $data = Helper::post_to_array("imei,simid,name");
            $o = Device::findFirst(array(
                "conditions"=>"deviceid = :dvid: and sim = :sim:",
                "bind"=>array("dvid"=>$data['imei'],"sim"=>$data['simid'])
            ));
            if($o->id>0){
                if(!empty($id)){
                    $udev = UserDevice::findFirst($id);
                }
                else{
                    $udev =  new UserDevice();
                    $udev->create_at = time();
                }
                $udev->device_id = $o->id;
                $udev->name = $data['name'];
                $udev->user_id = $uinfo->id;
                $udev->save();
                $this->response->redirect("device/index");
            }
            else {
                $this->flash->error("Không tìm thấy thiết bị tương ứng");
            }
        }
        if(!empty($id)){            
            $object = UserDevice::findFirst($id);
            $this->view->object = $object;
        }
    }
}