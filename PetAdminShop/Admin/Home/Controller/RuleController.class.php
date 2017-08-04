<?php
namespace Home\Controller;
use Think\Controller;
header("Content-type:text/html;charset=utf-8");
class RuleController extends Controller {
    public function __construct()
    {
        parent::__Construct();
        $username = $_SESSION['username'];
        $where['username'] = $username;
        $AdminUser = M('admin_user');
        $data = $AdminUser->where($where)->find();
        if(!$data){
            echo "<meta charset='utf-8' /><script>alert('重新登录一下吧！');top.location.href='".__MODULE__."/Login/index'</script>";
        }
    }
}