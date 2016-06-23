<?php

class DeviceController extends ControllerBase
{
    public function initialize()
    {
        $this->modulename = "device";
        $this->view->activesidebar = "/device/index";
        parent::initialize();
    }

    /***
     * Danh sách user
     * @return view
     */
    public function indexAction()
    {
        if (!$this->checkpermission("device_view")) return false;  // Kiểm tra quyền
        // Tính toán tham số phân trang
        $limit = 20;
        $p = $this->request->get("p");
        if ($p <= 1) $p = 1;
        $cp = ($p - 1) * $limit;

        // Khởi tạo các tham số tìm kiếm từ form
        $q = $this->request->getQuery("q", "string");
        $query = "1=1";
        if (!empty($q)) $query .= " and deviceid LIKE '%" . $q . "%'";
        $listdata = Device::find(array(
            "conditions" => $query,
            "order" => "id DESC",
            "limit" => $limit,
            "offset" => $cp
        )); // List

        $this->view->q = $q;
        $this->view->listdata = $listdata;
        $this->view->painginfo = Helper::paginginfo(Device::count($query), $limit, $p);
    }
    
    public function formAction()
    {
        $id = $this->request->get("id");
        // Check permission
        if(!empty($id)){
            if (!$this->checkpermission("device_update")) return false;
        }
        else {
            if (!$this->checkpermission("device_add")) return false;
        }
        if ($this->request->isPost()) {  // If form save
            try {
                $datapost = Helper::post_to_array("name,deviceid,sim,status");// Get data from form
                $datapost['status'] = 1;
                // <editor-fold desc="Validate">
                if ($id > 0) { // Update
                    $o = Device::findFirst($id);
                } else { //insert
                    $o = new Device();
                    $datapost['create_at'] = time();
                    $datapost['usercreate'] = $this->userinfo['id'];
                }
                $o->map_object($datapost);
                // </editor-fold>
                $o->save();
                $this->flash->success("Information saved !");
            } catch (Exception $e) {
                if((int)$e->getCode()==23000) $this->flash->error($this->culture['general.lbl_duplicateuser']);
                else $this->flash->error($e->getMessage());
            }
            $this->response->redirect("device");
        }
        if (!empty($id)) $o = Device::findFirst($id);
        $this->view->object = $o;
        $this->view->backurl = strlen($this->request->getHTTPReferer())<=0? $this->view->activesidebar: $this->request->getHTTPReferer();
    }

    public function importAction(){
        if ($this->request->isPost()) {
            $fileexcel = $this->post_file_key("file", true);
            require $this->config->application['vendorDir'] . 'excel/PHPExcel.php';
            $objReader = PHPExcel_IOFactory::createReader('Excel2007');
            $objPHPExcel = $objReader->load($this->config->media->dir.$fileexcel);
            $worksheet = $objPHPExcel->getActiveSheet();
            $totalrow = $worksheet->getHighestRow();
            try {
                for ($i = 2; $i <= $totalrow; $i++) {
                    $device = new Device();
                    $device->deviceid = $worksheet->getCell("B$i")->getValue();
                    $device->create_at = time();
                    $device->sim = $worksheet->getCell("C$i")->getValue();
                    $device->name = $worksheet->getCell("A$i")->getValue();
                    $device->status = 1;
                    $device->usercreate = $this->userinfo['id'];
                    $device->save();
                }
                $this->flash->success($this->view->labelkey['general.lbl_process_success']);
            } catch (Exception $e) {
                $this->flash->error($e->getMessage());
            }
            unlink($fileexcel);
        }
    }

    public function deleteAction()
    {
        if (!$this->checkpermission("device_delete")) return false;
        $id = $this->request->get("id");
        $o = Device::findFirst($id);
        if ($o) {
            try {
                $o->delete();
                $this->flash->success("Delete Successfully !");
            } catch (Exception $e) {
                $this->flash->error($e->getMessage());
            }
        }
        $this->response->redirect($this->request->getHTTPReferer());
    }

}