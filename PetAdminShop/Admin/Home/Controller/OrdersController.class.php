<?php
namespace Home\Controller;
use Think\Controller;
include("./ThinkPHP/Library/Vendor/oss/index.php");
class OrdersController extends LoginController
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
     * 订单列表
     * */
    public function OrdersLists(){
        $page = $_GET['page']?$_GET['page']:'1';
        $PageSize = 11;

        $model = M("orders");
        $data = $model->select();

        $val = $this->page_array($PageSize,$page,$data,0);

        $this->assign('data',$val['PageData']);
        $this->assign('page',$val['LastPage']);
        $this->display();
    }

    /*
     * 根据id查看订单详情
     * */
    public function OrdersIdInfo(){
        $id = $_GET['id'];
        $model = M("orders");
        $data = $model->where('orders_id='.$id)->find();
        $arr['admin_operation'] = 2;
        $model->where('orders_id='.$id)->save($arr);
        $model2 = M('user');
        $data2 = $model2->field('username')->where('id='.$data['user_id'])->find();
        $this->assign('data',$data);
        $this->assign('username',$data2['username']);
        $this->display();
    }

    /*
     * 根据id删除订单
     * */
    public function OrdersDel(){
        $id = $_GET['id'];
        $model = M("orders");
        if($model->where('orders_id='.$id)->delete()){
            echo json_encode(['code'=>200,'msg'=>'操作成功']);
        }else{
            echo json_encode(['code'=>201,'msg'=>'操作失败']);
        }
    }

    /*
     * 发货
     * */
    public function SendGoods(){
        $orders_id = $_POST['id'];
        $data['status'] = 3;
        $data['delivery_sn'] = $_POST['delivery_sn'];
        $data['com'] = $_POST['com'];
        $data['admin_operation'] = 3;
        $model = M("orders");
        if($model->where('orders_id='.$orders_id)->save($data)){
            echo json_encode(['code'=>200,'msg'=>'操作成功']);
        }else{
            echo json_encode(['code'=>201,'msg'=>'操作失败']);
        }
    }


    /*
     * 商家版首页的广告
     * */
    public function AddShopBannerForm(){
        $this->display();
    }

    /*
     * 商家版首页广告新增
     * */
    public function AddNewBanner()
    {
        if($_SESSION['code']!=$_POST['scode']){
            header('Cache-Control:no-cache,must-revalidat');
            header('Pragma:no-cache');
            $this->assign('num',4);
            $this->display("Orders/AddShopBannerForm");
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
            $this->display("Orders/AddShopBannerForm");
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

        $model = M("banner_shop");
        if($model->add($arr)){
            $this->assign('num',1);
            $this->display("Orders/AddShopBannerForm");
        }else{
            $this->assign('num',2);
            $this->display("Orders/AddShopBannerForm");
        }

    }

    /*
     * 序号验证
     * */
    public function OrderYz()
    {
        $banner_order = $_GET['banner_order'];
        $model = M("banner_shop");
        $count = $model->where('banner_order='.$banner_order)->count();
        if($count>=1){
            echo json_encode(['code'=>201,'msg'=>'您填写的顺序号已存在，请您重新填写！']);
        }else{
            echo json_encode(['code'=>200,'msg'=>'顺序号通过验证！']);
        }
    }


    /*
     * 商家版新增广告详情
     * */
    public function ShopBannerInfo(){
        $page = $_GET['page']?$_GET['page']:'1';
        $PageSize = 8;

        $model = M("banner_shop");
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
        $model = M("banner_shop");
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
        $model = M("banner_shop");
        $data = $model->where('id='.$id)->find();
        $this->assign('data',$data);
        $this->display();
    }

    public function EditBanner()
    {
        $id = $_POST['id'];
        $data['html_url'] = $_POST['url'];
        $data['status'] = $_POST['status'];
        $model = M("banner_shop");
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
        $model = M("banner_shop");
        if($model->where('id='.$id)->delete()){
            echo json_encode(['code'=>200,'msg'=>'已成功删除广告！']);
        }else{
            echo json_encode(['code'=>201,'msg'=>'您的网络开小差了,请您重新提交请求！']);
        }
    }


    /*
     * 店铺审核
     * */
    public function ShopExamine(){
        $page = $_GET['page']?$_GET['page']:'1';
        $PageSize = 8;

        $model = M("shop");
        $data = $model->select();
        $val = $this->page_array($PageSize,$page,$data,0);

        $this->assign('data',$val['PageData']);
        $this->assign('page',$val['LastPage']);
        $this->display();
    }

    /*
     * 根据id查看店铺详情
     * */
    public function ShopIdInfo(){
        $s_id = $_GET['s_id'];
        $model = M("shop");
        $data = $model->where('s_id='.$s_id)->find();
        $this->assign('data',$data);
        $this->display();
    }

    /*
     * 通过店铺审核
     * */
    public function ShopOk(){
        $s_id = $_GET['s_id'];
        $model = M("shop");
        $data['status'] = 2;
        if($model->where('s_id='.$s_id)->save($data)){
            echo json_encode(['code'=>200,'msg'=>'操作成功']);
        }else{
            echo json_encode(['code'=>201,'msg'=>'操作失败']);
        }
    }

    /*
     * 拒绝店铺审核
     * */
    public function ShopNo(){
        $s_id = $_GET['s_id'];
        $failure_reason = $_GET['failure_reason'];
        $model = M("shop");
        $data['status'] = 3;
        $data['failure_reason'] = $failure_reason;
        if($model->where('s_id='.$s_id)->save($data)){
            echo json_encode(['code'=>200,'msg'=>'操作成功']);
        }else{
            echo json_encode(['code'=>201,'msg'=>'操作失败']);
        }
    }

    /*
     * 根据id删除店铺信息
     * */
    public function ShopExamineDel(){
        $s_id = $_GET['s_id'];
        $model = M("shop");
        if($model->where('s_id='.$s_id)->delete()){
            echo json_encode(['code'=>200,'msg'=>'操作成功']);
        }else{
            echo json_encode(['code'=>201,'msg'=>'操作失败']);
        }
    }


    /*
     * 订单号查询
     * */
    public function OrdersSearchWord(){
        $page = $_GET['page']?$_GET['page']:'1';
        $PageSize = 8;

        $word = $_GET['word'];
        $model = M("orders");
        $condition['order_sn'] = array('like',"$word%");
        $data = $model->where($condition)->select();

        $val = $this->search_page_array($PageSize,$page,$data,0,$word);

        $this->assign('data',$val['PageData']);
        $this->assign('page',$val['LastPage']);
        $this->assign('word',$word);
        $this->display("Orders/OrdersLists");
    }
}