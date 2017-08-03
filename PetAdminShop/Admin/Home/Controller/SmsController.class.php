<?php
namespace Home\Controller;
use Think\Controller;
class SmsController extends LoginController
{
    public function __construct()
    {
        parent::__Construct();
        $username = $_SESSION['username'];
        $where['username'] = $username;
        $AdminUser = M('admin_user');
        $data = $AdminUser->where($where)->find();
        if (!$data) {
            echo "<meta charset='utf-8' /><script>alert('重新登录一下吧！');top.location.href='" . __MODULE__ . "/Login/index'</script>";
        }
    }

    /*
     * 短信详情
     * */
    public function SmsInfo()
    {
        $page = $_GET['page']?$_GET['page']:'1';
        $PageSize = 16;

        $model = M("Sms");
        $data = $model->select();

        $val = $this->page_array($PageSize,$page,$data,0);

        $this->assign('data',$val['PageData']);
        $this->assign('page',$val['LastPage']);
        $this->display();
    }
}