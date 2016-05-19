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


    }
    public function detailAction(){
        $deviceid = $this->request->get("id","string");
        $this->view->deviceid = $deviceid;
    }
}