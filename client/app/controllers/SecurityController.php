<?php

class SecurityController extends ControllerBase {
    public function beforeExecuteRoute($dispatcher)
    {
        $this->view->activesidebar = "/sercurity/login";
    }

    /***
     * Login
     */
    public function loginAction(){
        $this->view->setMainView("login");
        if($this->request->isPost()){
            $datapost = Helper::post_to_array("username,password");
            $datapost['password'] = Helper::encryptpassword($datapost['password']);
            $o = User::findFirst(array(
                "conditions"=>"username = :u: and password = :p:",
                "bind"=>array("u"=>$datapost['username'],"p"=>$datapost['password'])
            ));
            if($o->id>0){
                $o = $o->toArray();
                // Check permission
                $tmp = UserRole::find("userid = {$o['id']}"); // Lấy danh sách quyền mà user đó đc cấp
                $permission = ""; // khởi tạo các quyền ban đầu
                $manageroleid = ""; // khởi tạo danh sách quyền được quản trị ban đầu
                foreach($tmp as $item){ // lặp danh sách các quyền lấy được để lấy đc permission mà quyền đó có
                    $roleitem = $item->RoleGroup->toArray();
                    if(strlen($roleitem['permissions'])>0) $permission .= $roleitem['permissions'].","; // nối các quyền đó với quyền ban đầu, thêm dấu ,
                    if(strlen($roleitem['manageid'])>0) $manageroleid .= $roleitem['manageid'].","; // nối các role đó với role ban đầu, thêm dấu ,
                }
                $permission .= $o['private_permission']; // nối các quyền trong role với quyền hạn đặc biệt
                $permission = rtrim($permission,","); // xóa bỏ dấu , cuối cùng của chuỗi quyền đc ghép lại
                $o['listpermission'] = explode(",",$permission); // đưa tất cả các quyền (permission) lấy đc thành mảng. Set vào session nếu muốn
                $o['listrole'] = explode(",",$manageroleid); // đưa tất cả các Role lấy đc thành mảng. Set vào session nếu muốn



                if(!in_array("loginsystem",$o['listpermission'])) {
                    $this->flash->error("You cannot login to system by policy");
                }
                else{
                    $this->session->set("uinfo",$o); // Đưa thông tin người dùng vào SESSION
                    $this->response->redirect("index/index");
                }
            }
            else{
                $this->flash->error("User not available");
            }
        }
    }

    public function logoutAction(){
        $this->session->destroy();
        $this->response->redirect("security/login");
    }

    public function messageAction(){
        $this->view->setMainView("index");
    }
}
?>