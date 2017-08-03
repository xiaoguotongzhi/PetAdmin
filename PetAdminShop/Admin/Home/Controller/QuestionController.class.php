<?php
namespace Home\Controller;
use Think\Controller;
include("./ThinkPHP/Library/Vendor/oss/index.php");
include("./ThinkPHP/Library/Vendor/phpmailer/class.phpmailer.php");
include("./ThinkPHP/Library/Vendor/phpmailer/class.smtp.php");
class QuestionController extends LoginController
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
     * 新增问答页面
     * */
    public function AddNewQuestionForm()
    {
        $this->display();
    }

    public function AddNewQuestion()
    {

        if($_SESSION['code']!=$_POST['scode']){
            header('Cache-Control:no-cache,must-revalidat');
            header('Pragma:no-cache');
            $this->assign('num',4);
            $this->display("Question/AddNewQuestionForm");
            exit;
        }
        $_SESSION['code']=mt_rand(1,1000);


        $SubInfo = $_POST;
        $problem = $SubInfo['question'];
        $answer_one = $SubInfo['top'];
        $answer_two = $SubInfo['down'];
        $answer_three = $SubInfo['left'];
        $answer_four = $SubInfo['right'];
        $answer_true = $SubInfo['AnswerTrue'];
        $fraction = $SubInfo['fraction'];

        //处理图片
        $imginfo = $_FILES['img'];
        $imgname = $imginfo['name'];
        $oss = new \Oss();//实例化oss类
        $rand = rand(1,99999).time();   //时间戳拼接五位随机数，作为图片名称
        $suffix = substr($imgname,strrpos($imgname,".")+1);   //截取图片的后缀名字
        $object = "question/".$rand.".".$suffix;   //拼接上传到oss 之中的路径
        $imgpath = $imginfo['tmp_name'];
        $oss -> upload($object,$imgpath);   //调用oss类中的upload方法
        $path = "http://peita.oss-cn-beijing.aliyuncs.com/".$object;   //入数据表表img字段的数据


        //实例化model
        $model = D("Question");
        $data['img'] = $path;
        $data['problem'] = $problem;
        $data['answer_one'] = $answer_one;
        $data['answer_two'] = $answer_two;
        $data['answer_three'] = $answer_three;
        $data['answer_four'] = $answer_four;
        $data['answer_true'] = $answer_true;
        $data['status'] = '1';
        $data['fraction'] = $fraction;
        $data['is_pet'] = '1';
        $data['boring'] = '0';
        $data['sure'] = '0';
        $data['hard'] = '0';
        $data['create_time'] = time();
        if($model->add($data)){
            header('Cache-Control:no-cache,must-revalidat');
            header('Pragma:no-cache');
            $this->assign('num',1);
            $this->display("Question/AddNewQuestionForm");
            exit;
        }else{
            header('Cache-Control:no-cache,must-revalidat');
            header('Pragma:no-cache');
            $this->assign('num',2);
            $this->display("Question/AddNewQuestionForm");
            exit;
        }


    }

    /*
     * 问答详情
     * */
    public function QuestionInfo()
    {
        $page = $_GET['page']?$_GET['page']:'1';
        $PageSize = 6;

        $model = M("question");
        $data = $model->where('is_pet=1')->select();
        $val = $this->page_array($PageSize,$page,$data,0);

        $this->assign('data',$val['PageData']);
        $this->assign('page',$val['LastPage']);
        $this->display();
    }

    /*
     * 问答修改页面
     * */
    public function QuestionIdInfo()
    {
        $id = $_GET['id'];
        $model = M("question");
        $data = $model->where('id='.$id)->find();
        $this->assign('data',$data);
        $this->display();
    }

    public function EditQuestionIdInfo()
    {
        $id = $_POST['id'];
        $question = $_POST['question'];
        $top = $_POST['top'];
        $down = $_POST['down'];
        $left = $_POST['left'];
        $right = $_POST['right'];
        $AnswerTrue = $_POST['AnswerTrue'];
        $fraction = $_POST['fraction'];

        $imginfo = $_FILES['upfile'];

        if($imginfo['name']!=null){
            $imgname = $imginfo['name'];
            $oss = new \Oss();//实例化oss类
            $rand = rand(1,99999).time();   //时间戳拼接五位随机数，作为图片名称
            $suffix = substr($imgname,strrpos($imgname,".")+1);   //截取图片的后缀名字
            $object = "question/".$rand.".".$suffix;   //拼接上传到oss 之中的路径
            $imgpath = $imginfo['tmp_name'];
            $oss -> upload($object,$imgpath);   //调用oss类中的upload方法
            $path = "http://peita.oss-cn-beijing.aliyuncs.com/".$object;   //入数据表表img字段的数据
        }else{
            $path = $_POST['oldImg'];
        }


        $model = M("question");
        $data['img'] = $path;
        $data['problem'] = $question;
        $data['answer_one'] = $top;
        $data['answer_two'] = $down;
        $data['answer_three'] = $left;
        $data['answer_four'] = $right;
        $data['answer_true'] = $AnswerTrue;
        $data['fraction'] = $fraction;

        if($model->where('id='.$id)->save($data)){
            $info = $model->where('id='.$id)->find();
            $this->assign("data",$info);
            $this->assign("num",1);
            $this->display("Question/QuestionIdInfo");
        }else{
            $info = $model->where('id='.$id)->find();
            $this->assign("data",$info);
            $this->assign("num",2);
            $this->display("Question/QuestionIdInfo");
        }

    }


    /*
     * 问答信息删除
     * */
    public function QuestionIdDelete()
    {
        $id = $_GET['id'];
        $model = M("question");
        if($model->where('id='.$id)->delete()){
            echo json_encode(['code'=>200,'msg'=>'问答题目已成功删除！']);
        }else{
            echo json_encode(['code'=>201,'msg'=>'网络错误，请重新操作！']);
        }
    }


    /*
     * 宠友出题审核页面
     * */
    public function PetFriendQuestionInfo()
    {
        $page = $_GET['page']?$_GET['page']:'1';
        $PageSize = 6;

        $model = M("question");
        $data = $model->where('is_pet=2')->select();
        $val = $this->page_array($PageSize,$page,$data,0);

        $this->assign('data',$val['PageData']);
        $this->assign('page',$val['LastPage']);
        $this->display();
    }

    /*
     * 通过宠友的问答题目
     * */
    public function QuestionIdAdopt()
    {
        $id = $_GET['id'];
        $question = M('question');
        $data['status'] = 1;
        if($question->where('id = '.$id)->save($data)){
            echo json_encode(['code'=>200,'msg'=>'宠物提出的问答题目已成功加入题目展示库']);
        }else{
            echo json_encode(['code'=>200,'msg'=>'网络开小差了，请您重新提交操作！']);
        }
    }


    /*
     * 问答举报
     * */
    public function QuestionReportInfo()
    {
        $page = $_GET['page']?$_GET['page']:'1';
        $PageSize = 8;

        $model = M("report");
        $data = $model->select();
        $val = $this->page_array($PageSize,$page,$data,0);

        $this->assign('data',$val['PageData']);
        $this->assign('page',$val['LastPage']);
        $this->display();
    }

    /*
     * ID删除举报内容信息
     * */
    public function ReportIdDel()
    {
        $id = $_GET['id'];
        $model = M("report");
        if($model->where('id='.$id)->delete()){
            echo json_encode(['code'=>200,'msg'=>'已成功删除！']);
        }else{
            echo json_encode(['code'=>201,'msg'=>'网络开小差了，请重新提交操作！']);
        }
    }

    /*
     * 邮箱回复
     * */
    public function ReportEmailAnswer()
    {
        $id = $_GET['id'];
        $model = M("report");
        $data = $model
            ->join('question ON report.question_id = question.id')
            ->join('user ON report.user_id = user.id')
            ->where('report.id='.$id)
            ->find();
        $this->assign('report_id',$id);
        $this->assign('data',$data);
        $this->display();
    }

    /*
     * 邮箱回复给用户
     * */
    public function EmailToUser()
    {
        $id = $_POST['report_id'];
        $touser = $_POST['email'];
        $title = $_POST['title'];
        $content = $_POST['content'];

        $mail = new \PHPMailer(true);
        $mail->IsSMTP();
        $mail->CharSet='UTF-8'; //设置邮件的字符编码，这很重要，不然中文乱码
        $mail->SMTPAuth = true; //开启认证
        $mail->Port = 25;
        $mail->Host = "smtp.163.com";
        $mail->Username = "peitanet@163.com";
        $mail->Password = "txhl2016";
        //$mail->IsSendmail(); //如果没有sendmail组件就注释掉，否则出现“Could not execute: /var/qmail/bin/sendmail ”的错误提示
        $mail->AddReplyTo("peitanet@163.com");//回复地址
        $mail->From = "peitanet@163.com";
        $to = $touser;
        $mail->AddAddress($to);
        $mail->Subject = $title;
        $mail->Body = "<h5>".$content."</h5>";
        $mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; //当邮件不支持html时备用显示，可以省略
        $mail->WordWrap = 80; // 设置每行字符串的长度
        //$mail->AddAttachment("f:/test.png"); //可以添加附件
        $mail->IsHTML(true);
        if($mail->Send()){
            $report = M('report');
            $data['status'] = 1;
            $res = $report->where('id='.$id)->save($data);
            if($res){
                echo json_encode(['code'=>200,'msg'=>'邮件已发送！']);
            }else{
                echo json_encode(['code'=>201,'msg'=>'您的网络中途掉线！']);
            }

        }else{
            echo json_encode(['code'=>500,'msg'=>'网络开小差了，请您重新提交请求！']);
        }
    }


    /*
     * 根据id查询内容
     * */
    public function QuestionSearchWord()
    {

        $page = $_GET['page']?$_GET['page']:'1';
        $PageSize = 8;

        $word = $_GET['word'];
        $model = M("question");
        $condition['id'] = $word;
        $condition['problem'] = array('like',"$word%");
        $condition['_logic'] = 'OR';// 把查询条件传入查询方法
        $data = $model->where($condition)->select();

        $val = $this->search_page_array($PageSize,$page,$data,0,$word);

        $this->assign('data',$val['PageData']);
        $this->assign('page',$val['LastPage']);
        $this->assign('word',$word);
        $this->display("Question/QuestionInfo");

    }


    /*
     * 问答月排行
     * */
    public function MonthOrder(){
        $time = date('m',time());//获取当前月份
        $model = M("statistics");
        $data = $model->join('user ON statistics.user_id = user.id')->where('statistics.monday='.$time)->order('statistics.true_count desc')->select();

        //月参与问答人数
        $count = $model->where('monday='.$time)->count();
        $this->assign('data',$data);
        $this->assign('count',$count);
        $this->display();
    }

}