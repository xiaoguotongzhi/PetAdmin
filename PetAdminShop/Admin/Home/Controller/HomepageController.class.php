<?php
namespace Home\Controller;
use Think\Controller;
include("./ThinkPHP/Library/Vendor/oss/index.php");
class HomepageController extends LoginController
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
     * 新增广告
     * */
    public function AddNewBannerForm()
    {
        $this->display();
    }

    public function AddNewBanner()
    {
        if($_SESSION['code']!=$_POST['scode']){
            header('Cache-Control:no-cache,must-revalidat');
            header('Pragma:no-cache');
            $this->assign('num',4);
            $this->display("Homepage/AddNewBannerForm");
            exit;
        }
        $_SESSION['code']=mt_rand(1,1000);

        $html_url = $_POST['html_url'];
        $banner_order = $_POST['banner_order'];

        //处理图片
        $imginfo = $_FILES['img'];
        $imgname = $imginfo['name'];

        if(empty($imgname)){
            header('Cache-Control:no-cache,must-revalidat');
            header('Pragma:no-cache');
            $this->assign('num',5);
            $this->display("Homepage/AddNewBannerForm");
            exit;

        }

        $oss = new \Oss();//实例化oss类
        $rand = rand(1,99999).time();   //时间戳拼接五位随机数，作为图片名称
        $suffix = substr($imgname,strrpos($imgname,".")+1);   //截取图片的后缀名字
        $object = "question/".$rand.".".$suffix;   //拼接上传到oss 之中的路径
        $imgpath = $imginfo['tmp_name'];
        $oss -> upload($object,$imgpath);   //调用oss类中的upload方法
        $path = "http://peita.oss-cn-beijing.aliyuncs.com/".$object;   //入数据表表img字段的数据


        $arr['img'] = $path;
        $arr['html_url'] = $html_url;
        $arr['status'] = '1';
        $arr['create_time'] = time();
        $arr['banner_order'] = $banner_order;

        $model = M("banner");
        if($model->add($arr)){
            $this->assign('num',1);
            $this->display("Homepage/AddNewBannerForm");
        }else{
            $this->assign('num',2);
            $this->display("Homepage/AddNewBannerForm");
        }

    }


    /*
     * 序号验证
     * */
    public function OrderYz()
    {
        $banner_order = $_GET['banner_order'];
        $model = M("banner");
        $count = $model->where('banner_order='.$banner_order)->count();
        if($count>=1){
            echo json_encode(['code'=>201,'msg'=>'您填写的顺序号已存在，请您重新填写！']);
        }else{
            echo json_encode(['code'=>200,'msg'=>'顺序号通过验证！']);
        }
    }


    /*
     * 广告详情
     * */
    public function BannerInfo()
    {
        $page = $_GET['page']?$_GET['page']:'1';
        $PageSize = 8;

        $model = M("banner");
        $data = $model->select();
        $val = $this->page_array($PageSize,$page,$data,0);

        $this->assign('data',$val['PageData']);
        $this->assign('page',$val['LastPage']);
        $this->display();
    }


    /*
     * 修改广告排列序号
     * */
    public function AdminOrderSave()
    {
        $id = $_GET['id'];
        $data['banner_order'] = $_GET['banner_order'];
        $model = M("banner");
        if($model->where('id='.$id)->save($data)){
            echo json_encode(['code'=>200,'msg'=>'排列序号修改成功！']);
        }else{
            echo json_encode(['code'=>201,'msg'=>'排列序号修改失败！']);
        }

    }


    /*
     * 修改广告信息
     * */
    public function EditBannerIdInfo()
    {
        $id = $_GET['id'];
        $model = M("banner");
        $data = $model->where('id='.$id)->find();
        $this->assign('data',$data);
        $this->display();
    }

    public function EditBanner()
    {
        $id = $_POST['id'];
        $data['html_url'] = $_POST['url'];
        $data['status'] = $_POST['status'];
        $model = M("banner");
        if($model->where('id='.$id)->save($data)){
            echo json_encode(['code'=>200,'msg'=>'广告信息修改成功！']);
        }else{
            echo json_encode(['code'=>201,'msg'=>'未检测到当前信息有变化！']);
        }
    }


    /*
     * ID删除广告
     * */
    public function BannerIdDel()
    {
        $id = $_GET['id'];
        $model = M("banner");
        if($model->where('id='.$id)->delete()){
            echo json_encode(['code'=>200,'msg'=>'已成功删除广告！']);
        }else{
            echo json_encode(['code'=>201,'msg'=>'您的网络开小差了,请您重新提交请求！']);
        }
    }


    /*
     * 新增闪屏页面
     * */
    public function AddNewScreenForm()
    {
        $this->display();
    }

    public function AddNewScreen()
    {
        if($_SESSION['code']!=$_POST['scode']){
            header('Cache-Control:no-cache,must-revalidat');
            header('Pragma:no-cache');
            $this->assign('num',4);
            $this->display("Homepage/AddNewBannerForm");
            exit;
        }
        $_SESSION['code']=mt_rand(1,1000);

        //处理图片
        $imginfo = $_FILES['img'];
        $imgname = $imginfo['name'];

        if(empty($imgname)){
            header('Cache-Control:no-cache,must-revalidat');
            header('Pragma:no-cache');
            $this->assign('num',5);
            $this->display("Homepage/AddNewBannerForm");
            exit;

        }

        $oss = new \Oss();//实例化oss类
        $rand = rand(1,99999).time();   //时间戳拼接五位随机数，作为图片名称
        $suffix = substr($imgname,strrpos($imgname,".")+1);   //截取图片的后缀名字
        $object = "question/".$rand.".".$suffix;   //拼接上传到oss 之中的路径
        $imgpath = $imginfo['tmp_name'];
        $oss -> upload($object,$imgpath);   //调用oss类中的upload方法
        $path = "http://peita.oss-cn-beijing.aliyuncs.com/".$object;   //入数据表表img字段的数据

        $model = M("screen");
        $data['img'] = $path;
        if($model->add($data)){
            header('Cache-Control:no-cache,must-revalidat');
            header('Pragma:no-cache');
            $this->assign('num',1);
            $this->display("Homepage/AddNewBannerForm");
            exit;
        }else{
            header('Cache-Control:no-cache,must-revalidat');
            header('Pragma:no-cache');
            $this->assign('num',2);
            $this->display("Homepage/AddNewBannerForm");
            exit;
        }

    }


    /*
     * 闪屏详情
     * */
    public function ScreenInfo()
    {
        $model = M("screen");
        $data = $model->select();
        $this->assign('data',$data);
        $this->display();
    }

    /*
     * 删除闪屏文件
     * */
    public function ScreenIdDel()
    {
        $id = $_GET['id'];
        $model = M("screen");
        if($model->where('id='.$id)->delete()){
            echo json_encode(['code'=>200,'msg'=>'闪屏文件删除成功!']);
        }else{
            echo json_encode(['code'=>201,'msg'=>'网络延迟，请重新提交操作！']);
        }
    }

}