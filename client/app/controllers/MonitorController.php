<?php

class MonitorController extends ControllerBase
{
    public function initialize()
    {
        $this->modulename = "home";
        $this->view->activesidebar = "/monitor/index";
        parent::initialize();
    }

    public function indexAction(){


    }
}