<?php
namespace Home\Controller;
use Think\Controller;
include("./ThinkPHP/Library/Vendor/oss/index.php");
header("Content-type: text/html; charset=utf-8");
class HelpController extends LoginController
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

    //反馈详情
    public function HelpLists()
    {
        $page = $_GET['page']?$_GET['page']:'1';
        $PageSize = 6;

        $model = M("help");
        $data = $model->field('help.id,help.title,help.proposal,help.img,help.create_time,user.username')->join('user ON help.user_id = user.id')->select();

        $val = $this->page_array($PageSize,$page,$data,0);

        $this->assign('data',$val['PageData']);
        $this->assign('page',$val['LastPage']);
        $this->display();
    }

    //删除反馈
    public function HelpIdDel()
    {
        $id = $_GET['id'];
        $model = M("help");
        $model->where('id='.$id)->delete();
    }


    //新增常见问题
    public function AddNewProblem()
    {
        $this->display();
    }

    /*
     * 新增常见问题
     * */
    public function AddNewProblemSub()
    {
        $model = M("common_problem");
        $data['title'] = $_POST['title'];
        $data['content'] = $_POST['content'];
        $data['create_time'] = time();
        $data['update_time'] = time();
        if($model->add($data)){
            echo json_encode(['code'=>200,'msg'=>'成功添加问题']);
        }else{
            echo json_encode(['code'=>201,'msg'=>'添加问题失败']);
        }
    }

    /*
     * 常见问题详情
     * */
    public function ProblemInfo(){
        $page = $_GET['page']?$_GET['page']:'1';
        $PageSize = 10;

        $model = M("common_problem");
        $data = $model->select();

        $val = $this->page_array($PageSize,$page,$data,0);

        $this->assign('data',$val['PageData']);
        $this->assign('page',$val['LastPage']);
        $this->display();
    }


    /*
     * 常见问题详情
     * */
    public function EditProblemIdInfo(){
        $id = $_GET['id'];
        $model = M("common_problem");
        $data = $model->where('id='.$id)->find();
        $this->assign("data",$data);
        $this->display();
    }

    /*
     * 信息修改
     * */
    public function SaveProblemSub()
    {
        $id = $_POST['id'];

        $data['title'] = $_POST['title'];
        $data['content'] = $_POST['content'];

        $model = M("common_problem");
        if($model->where('id='.$id)->save($data))
        {
            echo json_encode(['code'=>200,'msg'=>'信息修改成功']);
        }else{
            echo json_encode(['code'=>201,'msg'=>'信息修改失败']);
        }
    }

    /*
     * 常见问题删除
     * */
    public function ProblemIdDel()
    {
        $id = $_GET['id'];
        $model = M("common_problem");
        $model->where('id='.$id)->delete();
    }
}