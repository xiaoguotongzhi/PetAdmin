<?php
namespace Home\Controller;
use Think\Controller;
header("Content-type:text/html;charset=utf-8");
class LoginController extends Controller {
    /*
     * 登陆页面
     * **/
    public function index()
    {
        $this->display();
    }

    /*
     * 登录验证
     * **/
    public function LoginVerification()
    {
        $username = $_POST['username'];
        $password = base64_encode($_POST['password']);
        $model = M("admin_user");
        $where['username'] = $username;
        $where['password'] = $password;
        $data = $model->where($where)->count();
        if($data==1){
            session('username',$username);  //设置cookie
            echo json_encode(['tip'=>'欢迎登录!','res'=>'ok']);
        }else{
            echo json_encode(['tip'=>'请检查您的登录信息!','res'=>'error']);
        }
    }

    /*
     * 主页
     * **/
    public function Home()
    {
        $username = $_SESSION['username'];
        $where['username'] = $username;
        $AdminUser = M('admin_user');
        $data = $AdminUser->where($where)->find();
        if(!$data){
            echo "<meta charset='utf-8' /><script>alert('重新登录一下吧！');top.location.href='".__MODULE__."/Login/index'</script>";
            die;
        }


        //当日0点的时间
        $dateStr = date('Y-m-d', time());
        $timestamp0 = strtotime($dateStr);
        //当日24点的时间
        $timestamp24 = strtotime($dateStr) + 86400;

        //昨日0点和24点的时间
        $beginYesterday= mktime(0,0,0,date('m'),date('d')-1,date('Y'));
        $endYesterday= mktime(0,0,0,date('m'),date('d'),date('Y'))-1;

        $model = M("orders");
        $model2 = M("home_click_count");
        $model3 = M("help");
        $model4 = M("card");
        $model5 = M("question");
        $model6 = M("encyclopedias");

        $map['create_time']  = array('between',"$timestamp0,$timestamp24");
        $count = $model->where($map)->count();

        $where1['create_time']  = array('between',"$timestamp0,$timestamp24");
        $where1['status'] = 2;
        $is_pay = $model->where($where1)->count();

        $dat['create_time']  = array('between',"$timestamp0,$timestamp24");
        $dat['status'] = 3;
        $is_fa = $model->where($dat)->count();

        $where2['create_time']  = array('between',"$timestamp0,$timestamp24");
        $today_look_count = $model2->where($where2)->count();

        $where3['create_time']  = array('between',"$beginYesterday,$endYesterday");
        $yesterday_look_count = $model2->where($where3)->count();

        $where4['create_time']  = array('between',"$timestamp0,$timestamp24");
        $help_count = $model3->where($where4)->count();

        $where5['create_time']  = array('between',"$timestamp0,$timestamp24");
        $card_count = $model4->where($where5)->count();

        $where6['create_time']  = array('between',"$timestamp0,$timestamp24");
        $where6['is_pet'] = 2;
        $question_count = $model5->where($where6)->count();


        $where7['create_time']  = array('between',"$timestamp0,$timestamp24");
        $where7['content_status'] = 2;
        $encyclopedias_count = $model6->where($where7)->count();



        $res['count'] = $count; //今日订单总数
        $res['is_pay'] = $is_pay; //已付款
        $res['is_fa'] = $is_fa; //已发货
        $res['yesterday_look_count'] = $yesterday_look_count; //昨天访问量
        $res['today_look_count'] = $today_look_count; //今日访问量
        $res['help_count'] = $help_count; //今日帮助与反馈计数
        $res['card_count'] = $card_count; //身份认证数量
        $res['question_count'] = $question_count; //宠友出题
        $res['encyclopedias_count'] = $encyclopedias_count; //百科问答


        $this->assign('data',$res);
        $this->display();
    }

    public function MenuLists()
    {
        //查询一级菜单
        $username = $_SESSION['username'];
        if(empty($username)){
            //echo json_encode(['tip'=>'网络错误，请重新登录']);
            echo "<meta charset='utf-8' /><script>alert('重新登录一下吧！');top.location.href='".__MODULE__."/Login/index'</script>";
            die;
        }
        $sql="select admin_jurisdiction.* from admin_user,admin_user_role,admin_role_jurisdiction,admin_jurisdiction
                where admin_user.id=admin_user_role.user_id
                and admin_user_role.role_id=admin_role_jurisdiction.role_id
                and admin_role_jurisdiction.jurisdiction_id=admin_jurisdiction.j_id
                and admin_user.username='$username'";
        $db3=D();
        $arr3=$db3->query($sql);

        //循环一下根据pid查询二级菜单然后通过判断合并到相应的一级菜单中
        foreach ($arr3 as $k => $v) {
            $sql2 = "SELECT * FROM admin_jurisdiction WHERE pid = ".$v['j_id'];
            $db5 = D();
            $arr5 = $db5->query($sql2);
            $arr3[$k]['child'] = $arr5;
        }
        //print_r($arr3);die;
        echo json_encode(['code'=>200,'data'=>$arr3]);
    }

    /*
     * 退出
     * **/
    public function LogOut()
    {
        session(null);
    }



    /**
     * 数组分页函数  核心函数  array_slice
     * 用此函数之前要先将数据库里面的所有数据按一定的顺序查询出来存入数组中
     * $count   每页多少条数据
     * $page   当前第几页
     * $array   查询出来的所有数组
     * order 0 - 不变     1- 反序
     */

    function page_array($count,$page,$array,$order){
        global $countpage; #定全局变量
        $page=(empty($page))?'1':$page; #判断当前页面是否为空 如果为空就表示为第一页面
        $start=($page-1)*$count; #计算每次分页的开始位置
        if($order==1){
            $array=array_reverse($array);
        }
        $totals=count($array);
        $countpage=ceil($totals/$count); #计算总页面数
        $pagedata=array();
        $pagedata=array_slice($array,$start,$count);
        $LastPage = $this->show_array($countpage);
        return ['PageData'=>$pagedata,'LastPage'=>$LastPage];
        //return $pagedata;  #返回查询数据
    }
    /**
     * 分页及显示函数
     * $countpage 全局变量，照写
     * $url 当前url
     */
    function show_array($countpage){
        $page=empty($_GET['page'])?1:$_GET['page'];
        if($page > 1){
            $uppage=$page-1;

        }else{
            $uppage=1;
        }

        if($page < $countpage){
            $nextpage=$page+1;

        }else{
            $nextpage=$countpage;
        }


        $str="<span style='color: red'>第 {$page} 页 / 共  {$countpage}  页</span>&nbsp;&nbsp;&nbsp;&nbsp;跳转至第<input type='text' id='Tpage' name='Tpage' size='2' style='text-align:center'>页<a href='javascript:void(0);' onclick='tiaozhuan();'>跳转</a>";
        $str.='<ul class="pagination" style="float: right">';
        $str.="<li><a href='?page=1'>   首页  </a></li>";
        $str.="<li><a href='?page={$uppage}'> 上一页  </a></li>";
        $str.="<li><a href='?page={$nextpage}'>下一页  </a></li>";
        $str.="<li><a href='?page={$countpage}'>尾页  </a></li>";
        $str.='</ul>';
        return $str;
    }


    /*
     * 个人中心
     * */
    public function MyInfo()
    {
        $username = $_SESSION['username'];
        $model = M("admin_user");
        $data = $model
            ->join('admin_user_role ON admin_user.id = admin_user_role.user_id')
            ->join('admin_role ON admin_user_role.role_id = admin_role.r_id')
            ->where("admin_user.username = '$username'")
            ->select();

        $arr = array();
        foreach ($data as $key=>$v) {
            $arr[$v['id']]['id']=$v['id'];
            $arr[$v['id']]['username']=$v['username'];
            $arr[$v['id']]['create_time']=$v['create_time'];
            $arr[$v['id']]['role_name'][]=$v['role_name'];
        }
        $this->assign('data',$arr);
        $this->display();
    }

    /*
     * 旧密码验证
     * */
    public function OldPassValidate()
    {
        $OldPass = base64_encode($_GET['OldPass']);
        $username = $_SESSION['username'];
        $model = M("admin_user");

        $where['username'] = $username;
        $where['password'] = $OldPass;
        $count = $model->where($where)->count();
        if($count==0){
            echo json_encode(['code'=>201,'msg'=>'旧密码无效']);
        }else{
            echo json_encode(['code'=>200,'msg'=>'密码验证通过']);
        }
    }


    /*
     * 用户修改密码
     * */
    public function UserSelfInfoSave()
    {
        $NewPass = base64_encode($_GET['NewPass']);
        $username = $_SESSION['username'];
        $model = M("admin_user");
        $data['password'] = $NewPass;
        if($model->where('username='.$username)->save($data))
        {
            echo json_encode(['code'=>200,'msg'=>'密码修改成功，请退出后重新登录！']);
        }else{
            echo json_encode(['code'=>201,'msg'=>'未检测到新密码状态']);
        }
    }


    /*
     * 首页今日订单、已付款、已发货数据
     * */
    public function HomeGoodsInfo(){
        //当日0点的时间
        $dateStr = date('Y-m-d', time());
        $timestamp0 = strtotime($dateStr);
        //当日24点的时间
        $timestamp24 = strtotime($dateStr) + 86400;

        $model = M("orders");
        $where1['create_time']  = array('between',"$timestamp0,$timestamp24");
        $where1['status'] = 2;
        $is_pay = $model->where($where1)->count();
        echo json_encode(['code'=>200,'msg'=>'成功','data'=>$is_pay]);

    }




    /**
     * Search
     * 数组分页函数  核心函数  array_slice
     * 用此函数之前要先将数据库里面的所有数据按一定的顺序查询出来存入数组中
     * $count   每页多少条数据
     * $page   当前第几页
     * $array   查询出来的所有数组
     * order 0 - 不变     1- 反序
     */

    function search_page_array($count,$page,$array,$order,$word){
        global $countpage; #定全局变量
        $page=(empty($page))?'1':$page; #判断当前页面是否为空 如果为空就表示为第一页面
        $start=($page-1)*$count; #计算每次分页的开始位置
        if($order==1){
            $array=array_reverse($array);
        }
        $totals=count($array);
        $countpage=ceil($totals/$count); #计算总页面数
        $pagedata=array();
        $pagedata=array_slice($array,$start,$count);
        $LastPage = $this->search_show_array($countpage,$word);
        return ['PageData'=>$pagedata,'LastPage'=>$LastPage];
        //return $pagedata;  #返回查询数据
    }
    /**
     * Search
     * 分页及显示函数
     * $countpage 全局变量，照写
     * $url 当前url
     */
    function search_show_array($countpage,$word){
        $page=empty($_GET['page'])?1:$_GET['page'];
        if($page > 1){
            $uppage=$page-1;

        }else{
            $uppage=1;
        }

        if($page < $countpage){
            $nextpage=$page+1;

        }else{
            $nextpage=$countpage;
        }


        $str="<span style='color: red'>第 {$page} 页 / 共  {$countpage}  页</span>&nbsp;&nbsp;&nbsp;&nbsp;跳转至第<input type='text' id='Tpage' name='Tpage' size='2' style='text-align:center'>页<a href='javascript:void(0);' onclick='tiaozhuan();'>跳转</a>";
        $str.='<ul class="pagination" style="float: right">';
        $str.="<li><a href='?page=1&word=$word'>   首页  </a></li>";
        $str.="<li><a href='?page={$uppage}&word=$word'> 上一页  </a></li>";
        $str.="<li><a href='?page={$nextpage}&word=$word'>下一页  </a></li>";
        $str.="<li><a href='?page={$countpage}&word=$word'>尾页  </a></li>";
        $str.='</ul>';
        return $str;
    }

}