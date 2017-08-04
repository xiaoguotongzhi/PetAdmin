<?php
namespace Home\Controller;
use Think\Controller;
class AdminUserController extends LoginController {
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


    /*
     * 新增管理员
     * **/
    public function AddAdminUserForm()
    {
        $model = M("admin_role");
        $data = $model->select();
        $this->assign("data",$data);
        $this->display();
    }

    public function AddAdminUser()
    {
        $username = $_POST['name'];//用户账号
        $boxList = explode(',',$_POST['list']);//权限
        $pwd = '123456';
        $password = base64_encode($pwd);//用户密码

        $model = M("admin_user");
        $arr['username'] = $username;
        $arr['password'] = $password;
        $arr['create_time'] = time();
        $arr['update_time'] = time();
        if($id = $model->add($arr)){

            $arr2 = array();
            foreach ($boxList as $key=>$value){
                $arr2[$key]['user_id'] = $id;
                $arr2[$key]['role_id'] = $value;
            }

            $model2 = M("admin_user_role");
            if($model2->addAll($arr2)){
                echo json_encode(['code'=>200,'msg'=>'管理员信息提交成功!']);
            }else{
                echo json_encode(['code'=>201,'msg'=>'管理员信息提交失败!']);
            }

        }else{
            echo json_encode(['code'=>500,'msg'=>'网络中断,请尝试重新提交!']);
        }
    }

    /*
     * 管理员详情
     * **/
    public function AddAdminUserInfo()
    {

        $page = $_GET['page']?$_GET['page']:'1';
        $PageSize = 8;


        $model = M("admin_user");
        $data = $model
            ->join('admin_user_role ON admin_user.id = admin_user_role.user_id')
            ->join('admin_role ON admin_user_role.role_id = admin_role.r_id')
            ->select();

        $arr = array();
        foreach ($data as $key=>$v) {
            $arr[$v['id']]['id']=$v['id'];
            $arr[$v['id']]['username']=$v['username'];
            $arr[$v['id']]['create_time']=$v['create_time'];
            $arr[$v['id']]['role_name'][]=$v['role_name'];


        }

        $val = $this->page_array($PageSize,$page,$arr,0);
        $this->assign('data',$val['PageData']);
        $this->assign('page',$val['LastPage']);
        $this->display();
    }


    /*
     * 管理员详情修改
     * */
    public function EditAdminUserInfo()
    {
        $id = $_GET['id'];
        $model = M("admin_user");
        $data = $model
            ->join('admin_user_role ON admin_user.id = admin_user_role.user_id')
            ->join('admin_role ON admin_user_role.role_id = admin_role.r_id')
            ->where('admin_user.id='.$id)
            ->select();

        $arr = array();
        foreach ($data as $key=>$v) {
            $arr[$v['id']]['id']=$v['id'];
            $arr[$v['id']]['username']=$v['username'];
            $arr[$v['id']]['create_time']=$v['create_time'];
            $arr[$v['id']]['role_name'][]=$v['role_name'];

        }


        $model2 = M('admin_role');
        $data2 = $model2->select();

        $this->assign('arr',$arr);
        $this->assign('arr2',$data2);
        $this->display();
    }

    /*
     * 修改管理员信息
     * */
    public function EditAdminUserInfoId()
    {
        $UserId = $_POST['UserId'];
        $RoleCheck = explode(',',$_POST['RoleCheck']);

        $model = M("admin_user_role");
        if($model->where('user_id='.$UserId)->delete()){

            $NewArr = array();
            foreach($RoleCheck as $key=>$value){
                $NewArr[$key]['user_id'] = $UserId;
                $NewArr[$key]['role_id'] = $value;
            }

            if($model->addAll($NewArr)){
                echo json_encode(['code'=>200,'msg'=>'管理员信息已经更新']);
            }else{
                echo json_encode(['code'=>201,'msg'=>'管理员信息更新失败']);
            }


        }else{
            echo json_encode(['code'=>500,'msg'=>'网络开小差了，重新提交一下吧！']);
        }

    }

    /*
     * 根据id删除相关的职务信息
     * */
    public function RoleIdDel()
    {
        $user_id = $_GET['UserId'];
        $model = M("admin_user");
        $model2 = M("admin_user_role");
        if($model->where("id=".$user_id)->delete() || $model2->where("user_id=".$user_id)->delete()){

            echo json_encode(['code'=>200,'msg'=>'删除管理员信息成功']);

        }else{
                echo json_encode(['code'=>201,'msg'=>'删除管理员信息失败']);
        }
    }


    /*
     * 用户密码重置
     * */
    public function AdminUserIdPassReset()
    {
        $user_id = $_GET['UserId'];
        $pwd = '123456';
        $password = base64_encode($pwd);
        $model = M("admin_user");
        $data['password'] = $password;
        if($model->where('id='.$user_id)->save($data)){
            echo json_encode(['code'=>200,'msg'=>'已重置为初始密码']);
        }else{
            echo json_encode(['code'=>201,'msg'=>'当前已经是初始密码无需重置']);
        }
    }


    /*
     * 新增职位
     * **/
    public function AddPositionForm()
    {
        $model = M("admin_jurisdiction");
        $data = $model->where('pid=0')->select();
        $this->assign('data',$data);
        $this->display();
    }

    public function PositionLists(){
        $model = M("admin_jurisdiction");
        $data = $model->where('pid=0')->select();
        return $data;
    }

    public function AddPosition()
    {
        if($_SESSION['code']!=$_POST['scode']){
            header('Cache-Control:no-cache,must-revalidat');
            header('Pragma:no-cache');
            $this->assign('num',4);
            $this->assign("data",$this->PositionLists());
            $this->display("AdminUser/AddPositionForm");
            exit;
        }
        $_SESSION['code']=mt_rand(1,1000);


        $PositionName = $_POST['PositionName'];
        $PositionArr = $_POST['PositionArr'];

        $model = M('admin_role');
        $data['role_name'] = $PositionName;
        if($id = $model->add($data)){
            $newArr = array();
            foreach ($PositionArr as $key=>$value){
                $newArr[$key]['role_id'] = $id;
                $newArr[$key]['jurisdiction_id'] = $value;
            }

            $model2 = M('admin_role_jurisdiction');
            if($model2->addAll($newArr)){
                header('Cache-Control:no-cache,must-revalidat');
                header('Pragma:no-cache');
                $this->assign('num',1);
                $this->assign("data",$this->PositionLists());
                $this->display("AdminUser/AddPositionForm");
            }else{
                header('Cache-Control:no-cache,must-revalidat');
                header('Pragma:no-cache');
                $this->assign("num",2);
                $this->assign("data",$this->PositionLists());
                $this->display("AdminUser/AddPositionForm");
            }

        }else{
            $this->assign("num",3);
            $this->assign("data",$this->PositionLists());
            $this->display("AdminUser/AddPositionForm");
        }
    }


    /*
     * 职位详情
     * **/
    public function AddPositionInfo()
    {
        $page = $_GET['page']?$_GET['page']:'1';
        $PageSize = 8;

        $model = M("admin_role");
        $model2 = M("admin_role_jurisdiction");
        $data = $model->select();//父级
        foreach ($data as $key=>$value){
            $data2 = $model2->where('role_id='.$value['r_id'])->join('admin_jurisdiction ON admin_role_jurisdiction.jurisdiction_id = admin_jurisdiction.j_id')->select();
            $data[$key]['child'] = $data2;
        }

        $val = $this->page_array($PageSize,$page,$data,0);

        $this->assign('data',$val['PageData']);
        $this->assign('page',$val['LastPage']);
        $this->display();
    }

    /*
     * 职位详情
     * */
    public function PositionIdInfo()
    {
        $model = M("admin_jurisdiction");
        $data = $model->where('pid=0')->select();//所有的权限

        //根据id找到当前权限名称以及子类权限id
        $model2 = M("admin_role");
        $id = $_GET['id'];
        $data2 = $model2->where('r_id='.$id)->find();

        $model3 = M("admin_role_jurisdiction");
        $data3 = $model3->where('role_id='.$data2['r_id'])->select();

        $data2['child'] = $data3;

        $this->assign('data',$data);
        $this->assign("data2",$data2);
        $this->display();
    }


    public function PositionIdInfoJK($id)
    {
        $model = M("admin_jurisdiction");
        $data = $model->where('pid=0')->select();//所有的权限

        //根据id找到当前权限名称以及子类权限id
        $model2 = M("admin_role");
        $data2 = $model2->where('r_id='.$id)->find();

        $model3 = M("admin_role_jurisdiction");
        $data3 = $model3->where('role_id='.$data2['r_id'])->select();

        $data2['child'] = $data3;

        return ['data'=>$data,'data2'=>$data2];
    }

    /*
     * 修改职位信息
     * */
    public function EditPosition()
    {
        $PositionName = $_POST['PositionName'];
        $PositionArr = $_POST['PositionArr'];
        $r_id = $_POST['r_id'];


        if($_SESSION['code']!=$_POST['scode']){
            $dataArr = $this->PositionIdInfoJK($r_id);//查到相应的数据
            header('Cache-Control:no-cache,must-revalidat');
            header('Pragma:no-cache');
            $this->assign('num',4);
            $this->assign('data',$dataArr['data']);
            $this->assign("data2",$dataArr['data2']);
            $this->display();
            exit;
        }
        $_SESSION['code']=mt_rand(1,1000);

        //根据r_id查到当前职位名称判断要不要修改数据库
        $model = M("admin_role");
        $data = $model->where('r_id='.$r_id)->find();
        if($data['role_name'] != $PositionName)
        {
            $data['role_name'] = $PositionName;
            $model->where('r_id='.$r_id)->save($data);
        }

        //先删除权限在重新添加权限
        $model2 = M("admin_role_jurisdiction");
        if($model2->where('role_id='.$r_id)->delete()){
            $newArr = array();
            foreach ($PositionArr as $k=>$v){
                $newArr[$k]['role_id'] = $r_id;
                $newArr[$k]['jurisdiction_id'] = $v;
            }

            if($model2->addAll($newArr)){
                $dataArr = $this->PositionIdInfoJK($r_id);//查到相应的数据
                header('Cache-Control:no-cache,must-revalidat');
                header('Pragma:no-cache');
                $this->assign('num',1);
                $this->assign('data',$dataArr['data']);
                $this->assign("data2",$dataArr['data2']);
                $this->display();

            }else{

                $dataArr = $this->PositionIdInfoJK($r_id);//查到相应的数据
                header('Cache-Control:no-cache,must-revalidat');
                header('Pragma:no-cache');
                $this->assign('num',2);
                $this->assign('data',$dataArr['data']);
                $this->assign("data2",$dataArr['data2']);
                $this->display();

            }

        }else{

            $dataArr = $this->PositionIdInfoJK($r_id);//查到相应的数据
            header('Cache-Control:no-cache,must-revalidat');
            header('Pragma:no-cache');
            $this->assign('num',3);
            $this->assign('data',$dataArr['data']);
            $this->assign("data2",$dataArr['data2']);
            $this->display();

        }
    }


    /*
     * 根据id删除相应的职务(删除职务的同时还要删除权限表的内容)
     * */
    public function PositionIdDelete()
    {
        $id = $_GET['id'];
        $model = M("admin_role");
        if($model->where('r_id='.$id)->delete()){
            $model2 = M("admin_role_jurisdiction");
            if($model2->where('role_id='.$id)->delete()){
                echo json_encode(['code'=>200,'msg'=>'操作执行成功']);
            }else{
                echo json_encode(['code'=>201,'msg'=>'操作执行失败']);
            }
        }else{
            echo json_encode(['code'=>500,'msg'=>'网络开小差了，重新提交一下吧！']);
        }
    }
}