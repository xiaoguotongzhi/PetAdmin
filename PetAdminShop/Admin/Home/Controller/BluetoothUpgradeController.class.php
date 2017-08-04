<?php
namespace Home\Controller;
use Think\Controller;
include("./ThinkPHP/Library/Vendor/oss/index.php");
header("Content-type: text/html; charset=utf-8");
class BluetoothUpgradeController extends LoginController {
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

    //蓝牙升级管理提交页面
    public function BluetoothUpgradeForm(){
        $this->display();
    }

    //处理页面提交信息
    public function BluetoothUpgradeSub(){
        $edition = I('post.edition');

        //文件处理
        $imginfo = $_FILES['upgrade_file'];
        $imgname = $imginfo['name'];
        $oss = new \Oss();//实例化oss类
        $rand = rand(1,99999).time();   //时间戳拼接五位随机数，作为图片名称
        $suffix = substr($imgname,strrpos($imgname,".")+1);   //截取图片的后缀名字
        $object = "question/".$rand.".".$suffix;   //拼接上传到oss 之中的路径 
        $imgpath = $imginfo['tmp_name'];
        $oss -> upload($object,$imgpath);   //调用oss类中的upload方法
        $path = "http://peita.oss-cn-beijing.aliyuncs.com/".$object;   //入数据表表img字段的数据

        //入库
        $model = M('bluetooth_upgrade');
        $data['edition'] = $edition;
        $data['upgrade_file'] = $path;
        if($model->add($data)){
            $this->assign("num",1);
            $this->display("BluetoothUpgrade/BluetoothUpgradeForm");
        }else{
            $this->assign("num",2);
            $this->display("BluetoothUpgrade/BluetoothUpgradeForm");
        }


    }


    //详情
    public function BluetoothUpgradeInfo(){
        $page = $_GET['page']?$_GET['page']:'1';
        $PageSize = 10;

        $model = M("bluetooth_upgrade");
        $data = $model->select();

        $val = $this->page_array($PageSize,$page,$data,0);

        $this->assign('data',$val['PageData']);
        $this->assign('page',$val['LastPage']);
        $this->display();
    }


    //信息修改
    public function BluetoothInfoEdit(){
        $id = $_GET['id'];//ID值
        $NewEdition = $_GET['NewEdition'];
        $data['edition'] = $NewEdition;
        $model = M('bluetooth_upgrade');
        $model->where('id='.$id)->save($data);
    }


    //删除
    public function BlueIdDel()
    {
        $id = $_GET['id'];
        $model = M("bluetooth_upgrade");
        $model->where('id='.$id)->delete();
    }

}