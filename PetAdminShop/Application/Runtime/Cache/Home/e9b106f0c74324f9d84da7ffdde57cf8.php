<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">

<title>爱宠互联接口说明文档</title>

<xmp theme="united" style="display:none;">
#爱宠互联接口说明文档
## [javascript和app交互文档](http://123.56.76.190:8080/doc.html)

## 用户模块

#### 关于access-token

	{
		登录后的请求都必须携带一个access-token否则返回错误提醒
		{
		    "name": "Unauthorized",
		    "message": "You are requesting with an invalid credential.",  //登录失效
		    "code": 0,
		    "status": 401,
		    "type": "yii\\web\\UnauthorizedHttpException"
		}
	}
####   退出登录
*`URI`*

	http://www.petnet.cc/api/default/logout

	*`EncType | Method`*

	application/json | get
	*`Response`*
	
	{
	    "code": 20001,
	    "msg": "操作失败",
	    "data": {
	    }

	//成功
	{
    "code": 10000,
    "msg": "成功",
    "data": {
       
    }
#### 关于用户个人中心信息展示

	{
		http://www.petnet.cc/api/user/user-detail?fields=id,sex,user_addr
		其中 &fields= 后面 加上需要加载的字段。 直接返回就行。
	}
	
#### 错误返回码code
	
	{
		code:"10000"   //成功
		code:"10001"   //无效的url请求
		code:"10002"   //无效的用户名密码
		code:"10003"   //登录已失效，请重新登录
		code:"10009"   //点过赞了
	
		code:"20000"   //服务器端错误
		code:"20001"   //操作失败
	}
#### 图片存贮路径
	{
	http://www.petnet.cc/eIIg-a/ads  +图片名字 //广告
	http://www.petnet.cc/eIIg-a/middle  +图片名字 //缩略图  求助
	http://www.petnet.cc/eIIg-a/original  +图片名字 //原始图 求助
	http://www.petnet.cc/eIIg-a/small  +图片名字 //小图  求助
	http://www.petnet.cc/upload/common  +图片名字 //头像  相册
    http://www.petnet.cc/eIIg-a/thumb  +图片名字 //头像 相册 缩略
	}

#### 获取融云token

	*`URI`*

	http://www.petnet.cc/api/user/get-token?access-token=value

	*EncType | Method*

	application/josn | get


	*`Response`*

	"{"code":200,"userId":"68","token":"Ez01zv6zPNKis67gMdYOOdEOR8rf3ss5sBrrkYv9at2aldo26IhX5FWVyhwCEHBdFeCuiQAXnTUHT8zwkx7Yag=="}"

#### 获取好友申请数

	*`URI`*

	http://www.petnet.cc/api/user/show-friends?access-token=value

	*EncType | Method*

	application/josn | get


	*`Response`*

	{
	"code": 10000,
	"msg": "成功",
	"data": {
	"count": "2"
	}
	}


####用户注册接口
	*`URI`*

	http://www.petnet.cc/api/register

	*`EncType | Method`*

	application/json | POST

	*`Request`*


	{
		"phone":15101556025,  //手机号   
		验证规则：
		1、不能为空；
		2、/^13[0-9]{1}[0-9]{8}$|14[57]{1}[0-9]{8}|15[012356789]{1}[0-9]{8}$
			|18[0-9]{1}[0-9]{8}$|17[0-9]{1}[0-9]{8}$/手机号码无效
		"password":123456,  //密码
		验证规则：
		1、6-22位数字字母
		2、不能为空
		"re_password":123456,  //确认密码
		验证规则：
		1、必须和password相同
		2、不能为空
		"sms_code": 123456  //验证码
		验证规则：
		1、6位数字否则验证码无效
		2、不能为空
		"cid":WWbJxOjMHz5yhr3RvgYJA5  //用户设备id
	}

	*`Response`*
	
	{
		//注册失败
		"code": 20001,
    	"msg": "操作失败",
    	"data": {
        	"password": [
            	"密码不能为空."
        	],
        	"re_password": [
            	"确认密码不能为空."
        	],
        	"sms_code": [
            	"验证码不能为空."
        	]
    	}
	}
	
	{
		//注册成功
		{
		    "code": 10000,
		    "msg": "成功",
		    "data": {
		        "access-token": "IoRYH9jR2NGOQ1p5Ao8AMiZVcfee4YGJ",
    	}
	}
#### 用户获取验证码

	*`URI`*

	http://www.petnet.cc/api/register/get-code

	*`EncType | Method`*

	application/json | POST

	*`Request`*

	{
		"phone":15101556025  //手机号
		验证规则：
		1、不能为空；
        2、/^13[0-9]{1}[0-9]{8}$|14[57]{1}[0-9]{8}|15[012356789]{1}[0-9]{8}$
            |18[0-9]{1}[0-9]{8}$|17[0-9]{1}[0-9]{8}$/手机号码无效
		"type_id":1 // 1=》 注册    2 =》忘记密码   （不能为空）
		
	}	

	*`Response`*

    {		
		//接收失败
		{    "code": 20001,
	    	 "msg": "操作失败",
	    	 "data": {
	         	"phone": [
	            	"手机号码无效"
	         	]
	    	}  
		}
		
		//发送成功
		{
		    "code": 10000,
		    "msg": "成功",
		    "data": null
		}

    }
#### 登录接口

	*`URI`*

	http://www.petnet.cc/api/login

	*`EncType | Method`*

	application/json | POST

	*`Request`*

	{
	    "username":"1270678",//手机号 
	    验证规则：
	    1、不能为空；
        2、/^13[0-9]{1}[0-9]{8}$|14[57]{1}[0-9]{8}|15[012356789]{1}[0-9]{8}$
            |18[0-9]{1}[0-9]{8}$|17[0-9]{1}[0-9]{8}$/手机号码无效
	    "password":"123456"//登陆密码
		"cid":"123"  //设备识别Id
	    验证规则：
        1、6-22位数字字母
        2、不能为空
	}

	*`Response`*
	
	{
	//密码错误
	    "code": 20001,
	    "msg": "操作失败",
	    "data": {
	        "password": [
	            "用户名或密码错误."
	        ]
	    }

	//登录成功

	{
    "code": 10000,
    "msg": "成功",
    "data": {
        "access-token": "IoRYH9jR2NGOQ1p5Ao8AMiZVcfee4YGJ",
    }

	//账号错误
	{
    "code": 20001,
    "msg": "操作失败",
    "data": {
        "username": [
            "该账号未注册"
        ]
    }

	

	





####用户忘记密码（通过手机号重新设置密码）接口

	*`URI`*

	http://www.petnet.cc/api/register/forget-password

	*`Enctype | Method`*

	application/josn | POST

	*`Request`*

	{
		"phone":15101556025，  //手机号  （必填项）
		"password":123456,  //新密码   （必填项）
		"re_password":123456,  //新密码确认  （必填项）
		"sms_code":222222    //验证码 （必填项）
		验证规则和注册一样
	}

	*`Response`*

	{
		//找回密码失败
		{
		    "code": 20001,
		    "msg": "操作失败",
		    "data": {
		        "password": [
		            "密码不能为空."
		        ],
		        "re_password": [
		            "确认密码不能为空."
		        ],
		        "sms_code": [
		            "验证码不能为空."
		        ],
		        "phone": [
		            "手机号码无效"
		        ]
		    }
		}

		//重置密码成功
		{
		    "code": 10000,
		    "msg": "成功",
		    "data": null
		}
	
	}

#### 个人基本信息添加、修改

	*`URI`*

	http://www.petnet.cc/api/user/edit-user

	*EncType | Method*

	application/josn | POST

	*`Request`*

	{
		"username": 王超  //用户姓名（1-30个字）  （可选项）
		"birth_time":2000-1-1  //出生年月   （可选项）
		"sex":0(1/2)  //0:保密  1：男 ，2:女   （可选项）
		"city_id_":10  //城市id   （可选项）
		"is_accept_sos":0(1)  //不接受一键求助  0  接受  1  不接受   （可选项）
		"is_open_details":0(1)  //不对陌生人公开详细信息  0：  公开  1 ： 不公开  （可选项）
		"is_accept_msg":0(1)  //不接受陌生人消息  0：接受  1：不接受 （可选项）
		"signature": 王超水水水水  //用户个性签名   （1-30个字） （可选项）

	}

	*`Response`*

	{
		//成功
		{
			"code":10000,
			"msg":成功,
			"data":{
				"id":1280210  //成功返回一个 用户Id			
			}
		}

		//失败
		{
			"code":20001,
			"msg":"操作失败",
			"data":{
				"real_name":["请输入1-30个字符"]  //当用户名错误时返回
				"birth_time":["出生日期格式不正确"]  //当出生日期填写错误时返回
				"sex":["性别格式不正确"]  //性别只能上传0或者1 当错误时返回
			}
		}
	}

####个人信息的展示


	*`URI`*

	http://www.petnet.cc/api/user/user-detail

	eg:http://www.petnet.cc/api/user/user-detail

	*EncType | Method*

	application/josn | GET

	*`Response`*
	{
		"code": 10000,
		"msg": "成功",
		{
			"id": 5,
			"username": "等多个等等",
			"phone": "17710379633",
			"sex": 1,
			"birth_time": 1396281600,
			"points": 0,
			"is_accept_sos": 1,
			"is_open_details": 0,
			"signature": "萨法法师为",
			"pet_nums": 0,
			"cid":"eedac3da0056bc6d1a5660b02005f512",
			"user_addr": [
				{
					"id": 1,
					"user_id": 5,
					"area_addr": "ereg",
					"address": "dsfds",
					"receive_name": null,
					"receive_phone": 24214214,
					"is_default": 0,
					"create_time": null,
					"update_time": null
				}
			],
			'city_id':10,
			'city_name':'北京',
			"user_imgs": [
				"user_570393fdd2a10.png"
			],
			"user_head_img": "user_570393fdd2a10.png"
		}
	}
			//失败

		{

		}
	}
#### 城市


	*`URI`*

	http://www.petnet.cc/api/user/city-list

	eg:http://www.petnet.cc/api/user/city-list

	*EncType | Method*

	application/josn | GET
	*`Request`*

		{
			"query":上海  / 字符串  可以是 汉字 拼音   （必填）
		}
	*`Response`*
	{
		"code": 10000,
		"msg": "成功",
		{
			"is_hot": [
				{
					"city_id": "11",
					"city_name": "上海",
					"city_aleph": "s",
					"is_hot": "1"
				}
			],
			"s": [
				{
					"city_id": "1225",
					"city_name": "上饶",
					"city_aleph": "s",
					"is_hot": "0"
				},
				{
					"city_id": "1256",
					"city_name": "商丘",
					"city_aleph": "s",
					"is_hot": "0"
				},
				{
					"city_id": "1410",
					"city_name": "商洛",
					"city_aleph": "s",
					"is_hot": "0"
				},
				{
					"city_id": "11",
					"city_name": "上海",
					"city_aleph": "s",
					"is_hot": "1"
				}
			]
		}
	}
		//失败

		{

		}
	}
#### 用户修改密码


	*`URI`*

	http://www.petnet.cc/api/user/reset-password


	*EncType | Method*

	application/josn | POST

	*`Request`*

	{
		"old_password":123456  / 用户名原密码  （必填）
		"new_password":454645  //新密码   （必填）
		"re_new_password":454645  //确认密码  （必填）
	}

	*`Response`*

	{
	    "code": 10000,
	    "msg": "成功",
	    "data": {
	        "id": 5  //用户id
	    }
	}
		
#### 用户上传头像  添加 修改 删除 多张 最多6张


	*`URI`*

	http://www.petnet.cc/api/user/user-upload


	*EncType | Method*

	application/josn | POST

	*`Request`*

	{
		img0=>'sssss.png'
        文件  img1 => 文件1
        文件  img1 => 文件1
        文件  img1 => 文件1

	}

	*`Response`*

	{
	    "code": 10000,
	    "msg": "成功",
	    "data": {
	        "id": 3   // 头像id
	    }
	}

#### 用户上传收货地址  添加 修改  


	*`URI`*

	http://www.petnet.cc/api/user/edit-addr


	*EncType | Method*

	application/josn | POST

	*`Request`*

	{
		"id":22  //地址id(可选)
		"area_addr":撒地方艾丝凡/ 省市区地址  （必填）
		"address":阿凤飞飞  / 详细地址  （必填）
		"receive_name":说撒  //收货人       （必填）
		"receive_phone":54156516  //手机号  规则 整数就行11位,按照注册手机号验证规则来       （必填）
        "is_default":0  //是否默认   0 不是  1 是   （可选）  

	}

	*`Response`*

	{
	    "code": 10000,
	    "msg": "成功",
	    "data": {
	        "id": 5    //地址Id
	    }
	}
	{
        "code": 20001,
        "msg": "操作失败",
        "data": {
            "area_addr": [
                "省市区地址不能为空"
            ],
            "address": [
                "详细地址不能为空"
            ],
            "receive_name": [
                "收货人姓名不能为空"
            ],
            "receive_phone": [
                "收货人手机号不能为空"
            ]
        }
    }
#### 用户设置默认收货地址


	*`URI`*

	http://www.petnet.cc/api/user/set-addr


	*EncType | Method*

	application/josn | POST

	*`Request`*

    {
        "id":3  / 修改时携带  （必填）
        "is_default":0  //是否默认   0 不是  1 是   （可选）  
    }

	*`Response`*

    {
        "code": 10000,
        "msg": "成功",
        "data": {
            "id": 3    //收货地址id
        }
    }
    
#### 删除收货地址

	*`URI`*

	http://www.petnet.cc/api/user/del-addr


	*EncType | Method*

	application/josn | POST

	*`Request`*

    {
        "id":3  / 收货地址id  （必填）
    }

	*`Response`*

    {
        "code": 10000,
        "msg": "成功",
        "data": {
            "id": 3  //地址id
        }
    }
    
    

#### 用户绑定和修改手机号


	*`URI`*

	http://www.petnet.cc/api/user/bind-phone


	*EncType | Method*

	application/josn | POST

	*`Request`*

    {
        "phone":15101556025  /手机号  （必填）
        验证规则和注册时手机号验证规则一样
        "sms_code":123456  //验证码 （必填）
    }

	*`Response`*

    {
        "code": 10000,
        "msg": "成功",
        "data": {
            "id": 2  //用户id
        }
    }
    
#### 用户好友添加好友申请


	*`URI`*

	http://www.petnet.cc/api/user/add-friend?friend_id=value(1、2)&content=value(30个字)


	*EncType | Method*

	application/josn | GET


	*`Response`*

    {
        "code": 10000,
        "msg": "成功",
        "data": {
            "id": 10,   //列表Id
            "user_id": 5  //用户id
        }
    }
    {
        "code": 20001,
        "msg": "操作失败",
        "data": "对方已经是您好友！"
    }
    
#### 好友申请列表操作


	*`URI`*

	http://www.petnet.cc/api/user/handle-friend?user_id=value&type_id=value&id=value

	eg:http://www.petnet.cc/api/user/handle-friend?user_id=4&type_id=1&id=9
		{
			id：提交好友申请返回的id
			type：1（2） 1：同意好友 2：拒绝好友
			user_id:好友申请返回时的user_id
		}

	*EncType | Method*

	application/josn | GET



	*`Response`*

    {
        "code": 10000,
        "msg": "成功",
        "data": {
            "id": 14,
            "ids": 15
        }
    }

#### 获取好友列表、黑名单


	*`URI`*

	http://www.petnet.cc/api/user/user-friend-list?is_cancel=value

	eg:http://www.petnet.cc/api/user/user-friend-list?is_cancel=1
		{
			好友列表：is_cancel:0
			黑名单：is_cancel:1
		}


	*EncType | Method*

	application/josn | GET


	*`Response`*

    {
        "code": 10000,
        "msg": "成功",
        "data": {
            "items": [
                {
                    "id": 15,  //列表Id
                    "friend_id": 2,  //对方用户Id
                    "remark": null,  //备注
                    "username": "ztsd"  //昵称
					"user_head_img": "user_570393fdd2a10.png"  //用户头像
                }
            ],
            "_links": {
                "self": {
                    "href": "http://localhost/pet/backend/web/api/user/user-friend-list?is_cancel=1&access-token=4zrLwVc_H_m7qPBHE01MZ_SLHkk58u4N&page=1&per-page=500"
                }
            },
            "_meta": {
                "totalCount": 1,
                "pageCount": 1,
                "currentPage": 1,
                "perPage": 500
            }
        }
    }
    
#### 获取申请好友列表
 

	 *`URI`*

	 http://www.petnet.cc/api/user/user-friend-apply-list


	 *EncType | Method*

	 application/josn | GET


	 *`Response`*
 
     {
         "code": 10000,
         "msg": "成功",
         "data": {
             "items": [
                 {
                     "id": 8,  //列表id
                     "user_id": 3,   //用户id
					 "content":"打算打算",
                     "username": "dsavvv"  //昵称
					 "user_head_img": "user_570393fdd2a10.png"  //用户头像
                 }
             ],
             "_links": {
                 "self": {
                     "href": "http://localhost/pet/backend/web/api/user/user-friend-apply-list?access-token=RkMVpqGIMq1M80om2wM3Q1nKy-Uj162L&page=1&per-page=500"
                 }
             },
             "_meta": {
                 "totalCount": 1,
                 "pageCount": 1,
                 "currentPage": 1,
                 "perPage": 500
             }
         }
     }
 
#### 拉黑删除好友
    
    
	*`URI`*

	http://www.petnet.cc/api/user/operate-user-friend?id=value&type_id=value
		http://www.petnet.cc/api/user/operate-user-friend?friend_id=value&type_id=value
	eg:http://www.petnet.cc/api/user/operate-user-friend?id=14&type_id=1
		eg:http://www.petnet.cc/api/user/operate-user-friend?friend_id=31&type_id=1
		{
		id:为列表id   //当在详情页面时 传参数 friend_id ：好友用户的id
		type_id:操作类型 1：删除好友 2：拉黑好友
		}
	*EncType | Method*

	application/josn | GET


	*`Response`*

   {
       "code": 10000,
       "msg": "成功",
       "data": {
           "id": 14  //列表id
       }
   }

#### 恢复拉黑好友


	*`URI`*

	http://www.petnet.cc/api/user/recover-user-friend?id=value
	http://www.petnet.cc/api/user/recover-user-friend?friend_id=value
	eg:http://www.petnet.cc/api/user/recover-user-friend?id=14
	eg:http://www.petnet.cc/api/user/recover-user-friend?friend_id=31
	{
	id:为列表id   //当在详情页面时 传参数 friend_id ：好友用户的id
	}
	*EncType | Method*

	application/josn | GET


	*`Response`*

	{
	"code": 10000,
	"msg": "成功",
	"data": {
	"id": 14  //列表id
	}
	}
#### 修改好友备注
    
    
	*`URI`*

	http://www.petnet.cc/api/user/edit-user-friend


	*EncType | Method*

	application/josn | POST

	*`Request`*

    {
        "id":14  //列表Id  （必填）
		"friend_id":31 //好友用户的id （和id 二选一在详情页面传friend_id）
        "remark": 大大  //备注名字  （可选）
    }

	*`Response`*

    {
        "code": 10000,
        "msg": "成功",
        "data": {
            "id": 6  //列表id
        }
    }
    



   
#### 首页轮播banner


	*`URI`*

	http://www.petnet.cc/api/activity/banner

	eg:http://www.petnet.cc/api/activity/banner


	*EncType | Method*

	application/josn | GET

	*`Response`*
	{
		[
			{
			"id": "347",
			"image": "56fccd709038e.png"
			},
			{
			"id": "330",
			"image": "56fcc7fcd4228.png,"
			},
			{
			"id": "329",
			"image": "56fcc7fcd4228.png,"
			},
			{
			"id": "328",
			"image": "pic_5673b239a9862.jpg"
			}
		]
	}
#### 一键求助-走失-列表


	*`URI`*

	http://www.petnet.cc/api/sos/lose-list

		{
		   当需要搜索时 :get形式拼接url pet_category=value(品种)
		   lose_pick_area=value (丢失地点)
		   start_time=2015-3-1 16:40  (丢失开始时间)
		   end_time=2016-3-1 15:40  (结束时间)
		}

	*EncType | Method*

	application/josn | GET

	*`Response`*

    {
        "code": 10000,
        "msg": "成功",
        "data": {
            "items": [
                {
                    "id": 8,   //列表id
                    "create_user_id": 18,  //创建人id
                    "type_id": 0,  //类型 0：走失1：捡到
                    "status_id": 0,   //状态 0：未找到 1：已找到
                    "comment_times": 0,  //评论次数  
                    "transfer_times": 0,  //转发次数
					“view_times”, //浏览量
					"content": "979528",  //正文
					"contact_phone", //联系电话
                    "title": "1",  //标题
                    "pet_name": "3",  //宠物名字
                    "lose_pick_area": "藏身之处",  //丢失地点
                    "pet_category": "哈士奇",  //宠物品种
                    "lose_pick_time": "15245655465", //丢失时间  时间戳
					"lose_pick_time2": "02-02 00:00", //丢失时间
					"update_time": "13分钟前",  //发布时间
                    "pet_imgs": [
                        "sos_570365614ac38.png",
                        "sos_570365615cd4d.png"
                    ],  //宠物图片
                    "username": "王大锤",  //昵称
                    "user_head": null   //用户头像
                },
            ],
			"_links": {
			"self": {
				"href": "http://pet.com/api/sos/lose-list?access-token=adwD7NwVd9x1u1qg_6FWW38mN8NPF0xz&page=1&per-page=10"
			},
			"next": {
				"href": "http://pet.com/api/sos/lose-list?access-token=adwD7NwVd9x1u1qg_6FWW38mN8NPF0xz&page=2&per-page=10"
			},
			"last": {
				"href": "http://pet.com/api/sos/lose-list?access-token=adwD7NwVd9x1u1qg_6FWW38mN8NPF0xz&page=4&per-page=10"
			}
			},
            "_meta": {
                "totalCount": 8,
                "pageCount": 1,
                "currentPage": 1,
                "perPage": 10
            }
        }
    }

#### 一键求助-捡到-列表
    
    
	*`URI`*

	http://www.petnet.cc/api/sos/pick-list

		{
		   当需要搜索时 :get形式拼接url pet_category=value(品种)
		   lose_pick_area=value (丢失地点)
		   start_time=2015-3-1 16:40  (丢失开始时间)
		   end_time=2016-3-1 15:40  (结束时间)
		}

	*EncType | Method*

	application/josn | GET

	*`Response`*

    {
        "code": 10000,
        "msg": "成功",
        "data": {
            "items": [
                {
                    "id": 1,
                    "create_user_id": 6,
                    "type_id": 0,
                    "status_id": 0,
                    "comment_times": 7,
                    "transfer_times": 3,
                    "content": "212恶趣味的前雾灯",
                    "title": "玩得起的期望",
                    "pet_name": null,
                    "lose_pick_area": null,
                    "pet_category": null,
                    "lose_pick_time": null,
                    "update_time": null,
                    "pet_imgs": null,
                    "username": "哈哈哈111",
                    "user_head": null
                }
            ],
            "_links": {
                "self": {
                    "href": "http://localhost/pet/backend/web/api/sos/lose-list?page=1&per-page=10"
                }
            },
            "_meta": {
                "totalCount": 8,
                "pageCount": 1,
                "currentPage": 1,
                "perPage": 10
            }
        }
    }        

#### 一键求助-我的-列表
    
    
*`URI`*

	http://www.petnet.cc/api/sos/my-list


	*EncType | Method*

	application/josn | GET

	*`Response`*

    {
        "code": 10000,
        "msg": "成功",
        "data": {
            "items": [
                {
                    "id": 3,
                    "create_user_id": 18,
                    "type_id": 0,
                    "status_id": 0,
                    "comment_times": 0,
                    "transfer_times": 0,
                    "content": "979528",
                    "title": "1",
                    "pet_name": "3",
                    "lose_pick_area": "藏身之处",
                    "pet_category": "哈士奇",
                    "lose_pick_time": "02-02 00:00",
                    "update_time": "16分钟前",
                    "pet_imgs": null,
                    "username": "王大锤",
                    "user_head": null
                },
                {
                    "id": 2,
                    "create_user_id": 18,
                    "type_id": 0,
                    "status_id": 0,
                    "comment_times": 0,
                    "transfer_times": 0,
                    "content": "979528",
                    "title": "",
                    "pet_name": null,
                    "lose_pick_area": "",
                    "pet_category": null,
                    "lose_pick_time": null,
                    "update_time": "18分钟前",
                    "pet_imgs": null,
                    "username": "王大锤",
                    "user_head": null
                },
                {
                    "id": 1,
                    "create_user_id": 6,
                    "type_id": 0,
                    "status_id": 0,
                    "comment_times": 7,
                    "transfer_times": 3,
                    "content": "212恶趣味的前雾灯",
                    "title": "玩得起的期望",
                    "pet_name": null,
                    "lose_pick_area": null,
                    "pet_category": null,
                    "lose_pick_time": null,
                    "update_time": null,
                    "pet_imgs": null,
                    "username": "哈哈哈111",
                    "user_head": null
                }
            ],
            "_links": {
                "self": {
                    "href": "http://localhost/pet/backend/web/api/sos/lose-list?page=1&per-page=10"
                }
            },
            "_meta": {
                "totalCount": 8,
                "pageCount": 1,
                "currentPage": 1,
                "perPage": 10
            }
        }
    }
    
#### 一键求助详细信息
    
    
	*`URI`*

	http://www.petnet.cc/api/sos/detail?id=value

	eg:http://www.petnet.cc/api/sos/detail?id=8


	*EncType | Method*

	application/josn | GET

	*`Response`*
	{
		"code": 10000,
		"msg": "成功",
		{
			"id": 8,   //列表Id
			"create_user_id": 18,  //发布人Id
			"type_id": 0,  //类型
			"status_id": 0,  //状态 0：未找到 1：已找到
			"comment_times": 0,  //回复数
			"transfer_times": 0, //转发数
			"view_times",//浏览量
			"contact_phone",//联系电话
			"contact_name":11222  //联系人
			"content": "979528",  //正文
			"title": "1",  //标题
			"pet_name": "3",  //宠物名
			"lose_pick_area": "藏身之处",  //丢失地点
			"pet_category": "哈士奇",  //宠物品种
			"lose_pick_time": "1545522555", //丢失时间  时间戳  到秒
			"lose_pick_time2": "02-02 00:00", //丢失时间
			"update_time": "31分钟前",  //发布时间
			"pet_imgs": [
				"sos_570365614ac38.png",
				"sos_570365615cd4d.png"
			], //宠物照片
			"username": "王大锤",  //昵称
			"user_head_img": null  //头像
		}
	}
#### 一键求助评论列表

    
	*`URI`*

	http://www.petnet.cc/api/sos/comment-list?sos_id=value

	eg:http://www.petnet.cc/api/sos/comment-list?sos_id=8


	*EncType | Method*

	application/josn | GET

	*`Response`*

    {
        "code": 10000,
        "msg": "成功",
        "data": {
            "items": [
                {
                    "id": 8,  //id
                    "create_user_id": 18,  //评论人id
                    "sos_id": 1,  //帖子id
                    "to_user_id": null,  //被评论人id
                    "content": "",  //评论内容
                    "create_time": "2小时前", //评论时间
                    "create_username": "王大锤", //评论人昵称
                    "to_username": null  //被评论人昵称
                },
                {
                    "id": 7,
                    "create_user_id": 18,
                    "sos_id": 1,
                    "to_user_id": null,
                    "content": "",
                    "create_time": "2小时前",
                    "create_username": "王大锤",
                    "to_username": null
                },
                {
                    "id": 6,
                    "create_user_id": 18,
                    "sos_id": 1,
                    "to_user_id": null,
                    "content": "",
                    "create_time": "2小时前",
                    "create_username": "王大锤",
                    "to_username": null
                },
                {
                    "id": 5,
                    "create_user_id": 18,
                    "sos_id": 1,
                    "to_user_id": 3,
                    "content": "979528",
                    "create_time": "2小时前",
                    "create_username": "王大锤",
                    "to_username": null
                },
                {
                    "id": 4,
                    "create_user_id": 18,
                    "sos_id": 1,
                    "to_user_id": null,
                    "content": "979528",
                    "create_time": "2小时前",
                    "create_username": "王大锤",
                    "to_username": null
                },
                {
                    "id": 3,
                    "create_user_id": 18,
                    "sos_id": 1,
                    "to_user_id": null,
                    "content": "979528",
                    "create_time": "2小时前",
                    "create_username": "王大锤",
                    "to_username": null
                },
                {
                    "id": 2,
                    "create_user_id": 18,
                    "sos_id": 1,
                    "to_user_id": null,
                    "content": "",
                    "create_time": "2小时前",
                    "create_username": "王大锤",
                    "to_username": null
                },
                {
                    "id": 1,
                    "create_user_id": 6,
                    "sos_id": 1,
                    "to_user_id": null,
                    "content": "打算打算",
                    "create_time": null,
                    "create_username": "哈哈哈111",
                    "to_username": null
                }
            ],
            "_links": {
                "self": {
                    "href": "http://localhost/pet/backend/web/api/sos/comment-list?sos_id=1&page=1"
                }
            },
            "_meta": {
                "totalCount": 8,
                "pageCount": 1,
                "currentPage": 1,
                "perPage": 20
            }
        }
    }
  
    
#### 一键求助评论
        
        
    *`URI`*
    
    http://www.petnet.cc/api/sos/comment
    
    
    *EncType | Method*
    
    application/josn | POST
    
    *`Request`*
        
            {
                "sos_id":8 //列表Id  （必填）
                "content": 大大  //评论内容  （必填）
                "to_user_id":3  //被评论人id  （可选）
            }
    
    *`Response`*
    
       {
           "code": 10000,
           "msg": "成功",
           "data": {
               "id": 12 
           }
           
            "code": 20001,
                  "msg": "操作失败",
                  "data": {
                      "content": [
                          "评论内容不能为空"
                      ]
                  }
       }


#### 一键求助转发
    
    
	*`URI`*

	http://www.petnet.cc/api/sos/transfer?sos_id=value

	eg:http://www.petnet.cc/api/sos/transfer?sos_id=8

	*EncType | Method*

	application/josn | GET

	*`Response`*

   {
       "code": 10000,
       "msg": "成功",
       "data": {
           "id": 14
       }
       
       {
           "code": 20001,
           "msg": "操作失败",
           "data": {
               "sos_id": [
                   "求助ID不能为空"
               ]
           }
       }
   }
   
#### 发布一键求助
        
        
	*`URI`*

	http://www.petnet.cc/api/sos/edit-sos


	*EncType | Method*

	application/josn | POST

	*`Request`*

    {
        "type_id":0 //发布类型 0:走失 1：捡到  （必填）
        "content": 大大  //正文  （必填）
        "title":3  //标题 （必填）
        "pet_name":笨笨 //宠物昵称 （必填）
        "pet_category":金毛  //宠物品种 （必填）
        "lose_pick_time":2015-3-1 16:00:00  //丢失时间   （必填） 
        "lose_pick_area":北京朝阳 //丢失地点  （必填）
		"contact_phone":111111111 //联系电话  （必填）
		"contact_name":11222  //联系人  (必填)
        "pet_imgs":file   //宠物图片  （可选）
        
    }
    {
        post宠物图片字段时 最多上传九张 每次参数名 需不一样
    }

	*`Response`*

	{
        "code": 10000,
        "msg": "成功",
        "data": {
            "id": 13
        }
    }
    
#### 发布一键我的（更新操作）
        
        
	*`URI`*

	http://www.petnet.cc/api/sos/refresh?id=value

	eg:http://www.petnet.cc/api/sos/refresh?id=10

	*EncType | Method*

	application/josn | GET


	*`Response`*

	{
        "code": 10000,
        "msg": "成功",
        "data": {
            "id": 10
        }
    }
    
#### 发布一键我的（已找到操作）
        
        
*`URI`*

	http://www.petnet.cc/api/sos/found?id=value

	eg:http://www.petnet.cc/api/sos/found?id=10

	*EncType | Method*

	application/josn | GET


	*`Response`*

	{
        "code": 10000,
        "msg": "成功",
        "data": {
            "id": 10
        }
    }
    
#### 首页 获取用户 列表


	*`URI`*

	http://www.petnet.cc/api/default/random-list

	eg:http://www.petnet.cc/api/default/random-list

	*EncType | Method*

	application/josn | GET

	*`Response`*

    {
        "code": 10000,
        "msg": "成功",
        "data": {
            "items": [
                {
                    "id": 18,
                    "username": "王大锤",
					"sex": 1,
                    "signature": null,
					"is_friend":false, //默认 false  是好友 true
                    "user_head_img": "user_570393fdd2a10.png",
                    "pet_head_img": "user_570393fdd2a10.png",
                    "pet_name": "三笔哈斯其"
					"cid": "eedac3da0056bc6d1a5660b02005f512",
					"pet_sex": 1,
					"pet_category": "阿拉斯加雪橇犬大灰狼"
                },
                {
                    "id": 6,
                    "username": "哈哈哈111",
                    "signature": "5129845132",
                    "user_head_img": null,
                    "pet_head_img": null,
                    "pet_name": null
					"cid": "eedac3da0056bc6d1a5660b02005f512",
                },
                {
                    "id": 20,
                    "username": "user3LNR1",
                    "signature": null,
                    "user_head_img": null,
                    "pet_head_img": null,
                    "pet_name": null
					"cid": "eedac3da0056bc6d1a5660b02005f512",
                },
                {
                    "id": 5,
                    "username": "ztsd",
                    "signature": "萨法法师为",
                    "user_head_img": null,
                    "pet_head_img": null,
                    "pet_name": null
					"cid": "eedac3da0056bc6d1a5660b02005f512",
                }
            ],
            "_links": {
                "self": {
                    "href": "http://pet.com/api/default/random-list?access-token=T3tKXR0YJG22e06gUUN0b0IAzzaF_seb&id=18&page=1&per-page=10"
                }
            },
            "_meta": {
                "totalCount": 4,
                "pageCount": 1,
                "currentPage": 1,
                "perPage": 10
            }
        }
    }


#### 首页 获取用户 详情 


	*`URI`*

	http://www.petnet.cc/api/default/random-detail

	eg:http://www.petnet.cc/api/default/random-detail?id=18

	*EncType | Method*

	application/josn | GET

	*`Response`*
	{
		"code": 10000,
		"msg": "成功",
		{
			"id": 18,
			"username": "王大锤",
			"sex": 0,
			"signature": null,
			"pet_nums": 0,
			"is_friend":true;
			"city_id": null,
			"city_name": null,
			"user_imgs": [
				"user_570393fdd2a10.png"
			],
			"user_head_img": "user_570393fdd2a10.png",
			"pet_imgs": [
				{
					"img": "user_570393fdd2a10.png",
					"id": 1
				}
			]
		}
	}
#### 推送好友申请


	*`URI`*

	http://www.petnet.cc/api/push/push-message?cid=value

	eg:http://www.petnet.cc/api/push/push-message?cid=a5fd3b3d9bd2811b5ec6b030a936e802

	*EncType | Method*

	application/josn | GET

	*`Response`*

	{
	{
	"taskId": "OSS-0408_f8fcf4cc9e45dbd319b38faac17fa18c",
	"result": "ok",
	"status": "successed_online"
	}
	}

####宠物信息信息的展示
###宠物信息信息的展示 宠物类型表
	*`URI`*

	http://www.petnet.cc/api/pet/pet-category

	eg:http://www.petnet.cc/api/pet/pet-category?variety_id=1&query=333

	*EncType | Method*

	application/josn | GET
	{
	"variety_id" => 1,  //宠物类型id  （必填） 取自当前宠物的类型  pet_varieties
	"query" => "宠物类型",    // 查询类型
	}
	*`Response`*
	{
	"code": 10000,
	"msg": "成功",
	"data": {
	"is_hot": [3
	{
	"id": "1",
	"cate_name": "哈士奇\r\n",
	"alias_name": null,
	"aleph": "h",
	"is_hot": "1"
	}
	],
	"h": [
	{
	"id": "1",
	"cate_name": "哈士奇\r\n",
	"alias_name": null,
	"aleph": "h",
	"is_hot": "1"
	}
	]
	}
	}

#### 获取宠物品种
*`URI`*&nbsp;
http://www.petnet.cc/api/pet/pet-diff&nbsp;
*EncType | Method*

	application/josn | get

	*`Request`*
	{
	"variety_id":"1",   //1:狗 2:猫 3:鼠 
	}

	*`Response`*
	{
	"code": 10000,
	"msg": "成功",
	"data": {
	"id":18,
	"cate_name":萨摩耶,
	"is_hot":1,
	{"id":"25","cate_name":"哈士奇","is_hot":"1"},
	{"id":"28","cate_name":"阿拉斯加","is_hot":"1"},
	{"id":"50","cate_name":"拉布拉多","is_hot":"1"},
	{"id":"67","cate_name":"雪纳瑞","is_hot":"1"},
	{"id":"76","cate_name":"泰迪","is_hot":"1"},
	{"id":"179","cate_name":"中华田园犬","is_hot":"1"},
	{"id":"437","cate_name":"金毛","is_hot":"1"}
	}
	}

#### 获取所有宠物
*`URI`*&nbsp;

http://www.petnet.cc/api/pet/pet-variety
&nbsp;
*EncType | Method*

	application/josn | get

	*`Request`*
	{
	"variety_id":"1",   //1:狗 2:猫 3:鼠 
	}

	*`Response`*
	{
	"code": 10000,
	"msg": "成功",
	"data": {
	"is_hot":[{"id":"28","cate_name":"阿拉斯加","aleph":"a","is_hot":"1"},
	{"id":"25","cate_name":"哈士奇","aleph":"h","is_hot":"1"}]}
	}
	
###宠物信息信息的展示 详情
	*`URI`*

	http://www.petnet.cc/api/pet/detail

	eg:http://www.petnet.cc/api/pet/detail?id=1

	*EncType | Method*

	application/josn | GET

	*`Response`*
	{
		"code": 10000,
		"msg": "成功",
		"data": {
		"id": 1,
		"pet_name": "三笔哈斯其",
		"pet_sex": 0,
		"pet_category": "额金毛",   //品种
		"pet_varieties": 0,  //种类  0 狗  1 猫 2 其他
		"user_id": 18,  //主人id
		"pet_length": null, //身长 cm
		"pet_weight": 50,  //体重 kg
		"pet_character": null,
		"pet_signature": null,
		"onwer_msg": null,
		"pet_birth_time": "2016-01-01",  //出生日期
		"username": "王大锤",  //主人昵称
		"pet_tags": [
		{
			"id": 1,
			"pet_id": 1,
			"create_user_id": 6,
			"pet_tag": "dasda",  //标签
			"create_time": null,
			"update_time": null
		},
		{
			"id": 2,
			"pet_id": 1,
			"create_user_id": 6,
			"pet_tag": "erewrwr",
			"create_time": null,
			"update_time": null
		}
		],
		"pet_imgs": [
			"user_570393fdd2a10.png" //相册
		],
			"pet_head_img": "user_570393fdd2a10.png"  //头像
		}
	}
###宠物信息信息的展示 列表  我的宠物
	*`URI`*

	http://www.petnet.cc/api/pet/list

	eg:http://www.petnet.cc/api/pet/list

	*EncType | Method*

	application/josn | GET

	*`Response`*
	{
		"code": 10000,
		"msg": "成功",
		"data": {
			"items": [
			{
				"id": 1,
				"pet_name": "三笔哈斯其",
				"pet_sex": 0,
				"pet_category": "额金毛",
				"pet_birth_time": 3个月,
				"pet_varieties": 0,
				"user_id": 18,
				"pet_length": null,
				"pet_weight": 50,
				"pet_character": null,
				"pet_signature": null,
				"onwer_msg": null,
				"pet_imgs": [
					"user_570393fdd2a10.png"
					],
				"pet_head_img": "user_570393fdd2a10.png"
				}
			],
			"_links": {
				"self": {
					"href": "http://pet.com/api/pet/list?access-token=adwD7NwVd9x1u1qg_6FWW38mN8NPF0xz&id=1&page=1&per-page=10"
				},
				"_meta": {
				"totalCount": 1,
				"pageCount": 1,
				"currentPage": 1,
				"perPage": 10
				}
		}
	}
#### 宠物上传头像  添加 修改 删除 多张 最多6张

	*`URI`*

	http://www.petnet.cc/api/pet/pet-upload

	*EncType | Method*

	application/josn | POST

	*`Request`*

	{
		img0=>'sssss.png'
		文件  img1 => 文件1
		文件  img1 => 文件1
		文件  img1 => 文件1

	}

	*`Response`*

	{
		"code": 10000,
		"msg": "成功",
		"data": {
			"id": 3   // 头像id
		}
	}
#### 宠物基本信息添加、修改

	*`URI`*

	http://www.petnet.cc/api/pet/edit-pet

	*EncType | Method*

	application/josn | POST

	*`Request`*

		{
			"id" => "pet_id",  //宠物id  （可选项） 修改时携带
			"pet_varieties" => "宠物类型",    // 0  狗  1 猫  2  其他
			"pet_sex" => "宠物性别",    // 0  公  1 母
			"pet_category" => "宠物次级品种",   //金毛   1-16字
			"pet_name" => "宠物名字",   //金毛   1-16字
			"pet_birth_time" => "宠物年龄",   //2015-02-06
			"pet_length" => "宠物身长",      //100  整数  单位 cm
			"pet_weight" => "宠物重量",    //100  整数  单位 kg
			"pet_tag" =>"宠物标签" ,    //的撒打算的   标签不能超过10个字
			"pet_character" => "宠物性格",  //金毛   1-30字
			"pet_signature" => "宠物签名",  //金毛   1-30字
			"onwer_msg" => "主人留言",    //金毛   1-30字


		}

	*`Response`*

		{
			//成功
			{
			"code":10000,
			"msg":成功,
			"data":{
				"id":1280210  //成功返回一个 用户Id
			}
		}

		//失败
		{
			"code":20001,
			"msg":"操作失败",
			"data":{
				"real_name":["请输入1-30个字符"]  //当用户名错误时返回
				"birth_time":["出生日期格式不正确"]  //当出生日期填写错误时返回
				"sex":["性别格式不正确"]  //性别只能上传0或者1 当错误时返回
				}
		}
	}
#### 删除宠物

	*`URI`*

	http://www.petnet.cc/api/pet/del-pet

	*EncType | Method*

	application/josn | get

	*`Request`*

	{
		"id" => 1,  //宠物id  （必填）

	}

	*`Response`*

	{
	//成功
	{
		"code":10000,
		"msg":成功,
		"data":{
			null
		}
	}

	//失败
	{
		"code":20001,
		"msg":"操作失败",
		"data":{
			}
		}
	}
#### 搜索添加好友


	*`URI`*

	http://www.petnet.cc/api/user/search-user


	*EncType | Method*

	application/josn | POST

	*`Request`*
	{
		"users":郭晓佶  //搜索手机号或者昵称
	}

	*`Response`*

	{
	"code": 10000,
	"msg": "成功",
	"data": {
	"items": [
	{
	"id": 67,
	"username": "郭晓佶",
	"signature": null,
	"cid": null,
	"user_head_img": "user_570c97ef79ff8.jpg"
	},
	{
	"id": 21,
	"username": "郭晓佶",
	"signature": "祝我们的项目可以尽快成功",
	"cid": null,
	"user_head_img": "user_570393fdd2a10.png"
	},
	{
	"id": 22,
	"username": "郭晓佶",
	"signature": "祝我们的项目可以尽快成功",
	"cid": null,
	"user_head_img": "user_570393fdd2a10.png"
	},
	{
	"id": 23,
	"username": "郭晓佶",
	"signature": "祝我们的项目可以尽快成功",
	"cid": null,
	"user_head_img": "user_570393fdd2a10.png"
	},
	{
	"id": 24,
	"username": "郭晓佶",
	"signature": "祝我们的项目可以尽快成功",
	"cid": null,
	"user_head_img": "user_570393fdd2a10.png"
	},
	{
	"id": 25,
	"username": "郭晓佶",
	"signature": "祝我们的项目可以尽快成功",
	"cid": null,
	"user_head_img": "user_570393fdd2a10.png"
	},
	{
	"id": 26,
	"username": "郭晓佶",
	"signature": "祝我们的项目可以尽快成功",
	"cid": null,
	"user_head_img": "user_570393fdd2a10.png"
	},
	{
	"id": 27,
	"username": "郭晓佶",
	"signature": "祝我们的项目可以尽快成功",
	"cid": null,
	"user_head_img": "user_570393fdd2a10.png"
	},
	{
	"id": 28,
	"username": "郭晓佶",
	"signature": "祝我们的项目可以尽快成功",
	"cid": null,
	"user_head_img": "user_570393fdd2a10.png"
	},
	{
	"id": 29,
	"username": "郭晓佶",
	"signature": "祝我们的项目可以尽快成功",
	"cid": null,
	"user_head_img": "user_570393fdd2a10.png"
	}
	],
	"_links": {
	"self": {
	"href": "http://localhost/pet/backend/web/api/user/search-user?access-token=4h-E7nSzeXsnrfUWBy_Y71G_Y59nI62A&page=1&per-page=10"
	},
	"next": {
	"href": "http://localhost/pet/backend/web/api/user/search-user?access-token=4h-E7nSzeXsnrfUWBy_Y71G_Y59nI62A&page=2&per-page=10"
	},
	"last": {
	"href": "http://localhost/pet/backend/web/api/user/search-user?access-token=4h-E7nSzeXsnrfUWBy_Y71G_Y59nI62A&page=3&per-page=10"
	}
	},
	"_meta": {
	"totalCount": 21,
	"pageCount": 3,
	"currentPage": 1,
	"perPage": 10
	}
	}
	}

## 地图模块

	#### 附近的人
	*`URI`*

	tcp://www.petnet.cc:8686
	//信息交互
	*`Request`*  //登录

	{
		"access-token": "dfafafasfasdfasdfafa"   //每次请求必须携带
	}
	*`Request`*  //位置上报  初始进入地图界面   位置改变超过1km  重新提交  将上报位置缓存使用

	{
		"type": 60000,
		"access-token": "dfafafasfasdfasdfafa",*`Request`*  登录
		"lat": "42.545745", //纬度  必须
		"lng": "123.65165165", //经度 必须
	}
	*`Response`*  //位置切换返回数据

	{
		"type": "80000",
		"data":{
			"1":{
				"id":"sa69",  //用户id
				"username":"sa69",
				"sex":"1",  //性别
				"img":"user_573433021c2a4.jpg,user_573433021c2a4.jpg",  //可能多张  也可能一张 或 没有
				"lat":"40.067921610472",
				"lng":"116.2519538455",
			},
			"2":{
				"id":"sa69",  //用户id
				"username":"sa69",
				"sex":"1",  //性别
				"img":"user_573433021c2a4.jpg,user_573433021c2a4.jpg",  //可能多张  也可能一张 或 没有
				"lat":"40.067921610472",
				"lng":"116.2519538455",
			},
		},
	}
	
	#### 附近的宠物
	*`URI`*

	tcp://www.petnet.cc:8686
	//信息交互
	*`Request`*  //登录

	{
		"access-token": "dfafafasfasdfasdfafa"   //每次请求必须携带
	}
	*`Request`*  //位置上报  初始进入地图界面   位置改变超过1km  重新提交  将上报位置缓存使用

	{
		"type": 61004,
		"access-token": "dfafafasfasdfasdfafa",*`Request`*  登录
		"lat": "42.545745", //纬度  必须
		"lng": "123.65165165", //经度 必须
	}
	*`Response`*  //位置切换返回数据

	{
		"type": "81004",
		"data":{
			"1":{
				"id":"sa69",  //用户id
				"pet_name":"大白",  //宠物名字
				"pet_imgs":"pet_573433021c2a4.jpg,pet_573433021c2a4.jpg",  //可能多张  也可能一张 或 没有
				"lat":"40.067921610472",
				"lng":"116.2519538455",
			},
			
		},
	}

	#### 附近的宠物同品种
	*`URI`*

	tcp://www.petnet.cc:8686
	//信息交互
	*`Request`*  //登录

	{
		"access-token": "dfafafasfasdfasdfafa"   //每次请求必须携带
	}
	*`Request`*  //位置上报  初始进入地图界面   位置改变超过1km  重新提交  将上报位置缓存使用

	{
		"type": 61005,
		"access-token": "dfafafasfasdfasdfafa",*`Request`*  登录
		"lat": "42.545745", //纬度  必须
		"lng": "123.65165165", //经度 必须
		"pet_category": "25", //品种id
	}
	*`Response`*  //位置切换返回数据

	{
		"type": "81005",
		"data":{
			"1":{
				"id":"sa69",  //用户id
				"pet_category":"25",//宠物品种id
				"pet_name":"大白",  //宠物名字
				"pet_imgs":"pet_573433021c2a4.jpg,pet_573433021c2a4.jpg",  //可能多张  也可能一张 或 没有
				"lat":"40.067921610472",
				"lng":"116.2519538455",
			},
			
		},
	}
	*`Request`*  //聊天  附近

	{
		"type": 60001,
		"access-token": "dfafafasfasdfasdfafa",*`Request`*  登录
		"message": "撒撒飞洒发生", //消息 必填
		"lat":"40.067921610472",  //必须
		"lng":"116.2519538455",  // 必须
	}
	*`Response`*  //附近用户发言

	{
		"type": 80001 ,
		"data":{
			"from_uid":"33",
			"from_name":"33",
			"from_sex":1,
			"from_head":"user_573433021c2a4.jpg", //单张
			"message":"40沙发上.067921610472",
		},
	}


	*`Request`*  //聊天  私聊

	{
		"type": 60002,
		"access-token": "dfafafasfasdfasdfafa",*`Request`*  登录
		"message": "撒撒飞洒发生", //消息 必填
		"to_uid": 22, //消息 必填
	}
	*`Response`*  //聊天  私聊

	{
		"type": 80002 ,
		"data":{
			"from_uid":"33",
			"from_name":"33",
			"from_sex":1,
			"from_head":"user_573433021c2a4.jpg", //单张
			"to_uid":"33",
			"to_name":"33",
			"to_sex":1,
			"to_head":"user_573433021c2a4.jpg", //单张
			"message":"40沙发上.067921610472",
		},
	}

	*`Request`*  //进入副本
	{
		"type": 61000,
		"access-token": "dfafafasfasdfasdfafa",*`Request`*  登录
		"room_id": "撒撒飞洒发生", //房间号 必填
		"lat": "42.545745", //纬度  必须
		"lng": "123.65165165", //经度 必须
	}
	*`Response`*  //自己进入副本  收到推送

	{
		"type": "81000",
		"data":{
			"33":{  //键  用户id
				"id":"33",  //用户id
				"username":"sa69",
				"sex":"1",  //性别
				"img":"user_573433021c2a4.jpg,user_573433021c2a4.jpg",  //可能多张  也可能一张 或 没有
				"lat":"40.067921610472",
				"lng":"116.2519538455",
				"role":"10",  //  用户队伍角色  10 =》 队长 0 =》普通
			},
			"22":{
				"id":"22",  //用户id
				"username":"sa69",
				"sex":"1",  //性别
				"img":"user_573433021c2a4.jpg,user_573433021c2a4.jpg",  //可能多张  也可能一张 或 没有
				"lat":"40.067921610472",
				"lng":"116.2519538455",
				"role":"10",  //  用户队伍角色  10 =》 队长 0 =》普通
			},
		}
	}
	*`Response`*  //他人进入房间推送  id已存在则更像 不存在添加

	{
		"type": 81001 ,
		"data":{  //数据单条
			"33":{  //键  用户id
				"id":"33",  //用户id
				"username":"sa69",
				"sex":"1",  //性别
				"img":"user_573433021c2a4.jpg,user_573433021c2a4.jpg",  //可能多张  也可能一张 或 没有
				"lat":"40.067921610472",
				"lng":"116.2519538455",
				"role":"10",  //  用户队伍角色  10 =》 队长 0 =》普通
			},
		}
	}

	*`Request`*  //聊天  队伍

	{
		"type": 60003,
		"access-token": "dfafafasfasdfasdfafa",*`Request`*  登录
		"message": "撒撒飞洒发生", //消息 必填
		"room_id": 22, //房间号 必填
	}
	*`Response`*  //聊天  队伍

	{
		"type": 80003 ,
		"data":{
			“room_id":23,
			"from_uid":"33",
			"from_name":"33",
			"from_sex":1,
			"from_head":"user_573433021c2a4.jpg", //单张
			"message":"40沙发上.067921610472",
		},
	}

	*`Request`*  //  队伍内 用户位置信息上报

	{
		"type": 61003 ,
		"data":{
			"room_id": "撒撒飞洒发生", //房间号 必填
			"lat": "42.545745", //纬度  必须
			"lng": "123.65165165", //经度 必须
		},
	}
	*`Response`*  //队伍内 用户位置信息变化推送

	{
		"type": 81003 ,
		"data":{
			“room_id":23,
			"uid":"33",
			"lat": "42.545745", //纬度
			"lng": "123.65165165", //经度
		},
	}





	*`Response`*  //  回复 走失

	{
	"type": 30001 ,
	"sos_id":11
	}
	*`Response`*  //  讨论组推送

	{
		"type": 30002 ,
	}
	*`Response`*  //  同意入群申请推送

	{
	"type": 30003 ,
	}
	*`Response`*  //  踢人 推送

	{
	"type": 30004 ,
	}
	*`Response`*  //  拉人 推送

	{
	"type": 30005 ,
	}
	*`Response`*  //  解散 群 推送

	{
	"type": 30006 ,
	}
	*`Response`*  //  修改资料 群 推送

	{
	"type": 30007 ,
	"data":
	}
	*`Response`*  //  修改名片 群 推送

	{
	"type": 30008 ,
	"data":
	}
	*`Response`*  //  副本 解散 推送

	{
	"type": 31000 ,
	}
	*`Response`*  //  用户申请加入群 推送

	{
	"type": 30009 ,
	}
#### 用户创建群组


	*`URI`*

	http://www.petnet.cc/api/user/create-crowd


	*EncType | Method*

	application/josn | POST

	*`Request`*
	{
		"name":测试一群  //群名
		"introduce":测试看看 //群公告
		"group_type":2  // 1=>需要申请同意入群 2=>自己加群
		"lat":123.333333  //经度
		"lng":22.222222  //纬度
		"group_img":  //file  群头像
		"group_adv": //file  群广告图
		"group_info" :的萨达十大  //群广告文字
		"group_location": 昌平区 //群位置
	}

	*`Response`*

	{
		"code": 10000,
		"msg": "成功",
		"data": {
		"groupId": 36,
		"group_type": "2",
		"groupName": "测ddd"
		}
	}

#### 用户加入群组


	*`URI`*

	http://www.petnet.cc/api/user/join-crowd


	*EncType | Method*

	application/josn | POST

	*`Request`*
	{
		"group_type":1  //群类型  1=>需申请同意加入群 2=>直接加入群
		"group_id":32 //群id
		"name":测试一群  // 群名字
		"apply_msg":飒飒的  //验证消息
	}

	*`Response`*

	{
		"code": 10000,
		"msg": "成功",
		"data": {
			"id": 10
		}
	}

#### 群主修改群类型（是否允许自由加入）


	*`URI`*

	http://www.petnet.cc/api/user/change-crowd-type?group_id=28


	*EncType | Method*

	application/josn | GET

	{
		group_id: 28  //群组id
	}

	*`Response`*

	{
	"code": 10000,
	"msg": "成功",
	"data": {
	"id": 28  //群组id
	}
	}

#### 用户申请入群列表（仅群主和管理员显示）


	*`URI`*

	http://www.petnet.cc/api/user/crowd-apply-list


	*EncType | Method*

	application/josn | GET


	*`Response`*


	{
	"id": "5",   //申请列表id
	"user_id": "10",  //用户id
	"sex": "10",  //性别
	"apply_msg": "爱爱", //申请消息
	"group_id": "28", // 群Id
	"is_accept": "0",  //是否处理  1=> 同意 2=> 拒绝
	"name": "测试三群",  //群名
	"username": "与咯斤", //用户名
	"imgs": "user_57675373013c8.jpg,user_576759b5cf956.jpg",  //用户头像
	"group_img": "group_5705ecdc9fa21.png"  // 群头像
	}


#### 群主或管理员操作入群申请


	*`URI`*

	http://www.petnet.cc/api/user/operate-crowd-apply
	?type=1&user_id=8&group_id=28&group_name=测试一群&apply_id=5


	*EncType | Method*

	application/josn | GET

	{
		type=1 //操作类型  1=>同意 2=>拒绝
		user_id=8  //用户id
		group_id=28  //群id
		name=测试一群 //群名
		apply_id=5  //申请列表id
	}

	*`Response`*

	{
	"code": 10000,
	"msg": "成功",
	"data": {
	"id": 38   //群成员列表id
	}
	}

#### 查看群成员


	*`URI`*

	http://www.petnet.cc/api/user/group-user-query?group_id=28


	*EncType | Method*

	application/josn | GET

	{
		group_id:28  //群id
	}

	*`Response`*

	{
	"id": "14",   // 群成员列表id
	"user_id": "8",  //用户id
	"role": "1",  //群身份 0=> 普通群成员 1=>群主 2=>管理员
	"group_name": "哈哈",  //群名片
	"username": "王超",  //用户名
	"imgs": "user_57675320c9abc.jpg,user_576759520dad5.jpg"  //用户头像
	},
	{
	"id": "20",
	"user_id": "13",
	"role": "2",
	"group_name": null,
	"username": "user86I63Q",
	"imgs": null
	},
	{
	"id": "21",
	"user_id": "9",
	"role": "0",
	"group_name": null,
	"username": "电后果",
	"imgs": "user_576a2c667bdde.jpg,user_576a2d0508503.jpg,user_576a3855ec982.jpg"
	},
	{
	"id": "38",
	"user_id": "10",
	"role": "0",
	"group_name": "测试三群",
	"username": "与咯斤",
	"imgs": "user_57675373013c8.jpg,user_576759b5cf956.jpg"
	}

#### 群主对群成员进行权限操作


	*`URI`*

	http://www.petnet.cc/api/user/operate-users?id=21&type=1&group_id=22


	*EncType | Method*

	{
		id:21  //成员列表id
		group_id:21  //当前操作的群组id
		type:1  // 1=> 设置管理员（群主操作，当不是管理员则设为管理员，已为管理员则取消掉）
					2=> 群主或者管理员踢人
		当身份是管理员的时候 只有 type=2的权限，即踢人权限
	}

	application/josn | GET


	*`Response`*


	{
	"code": 10000,
	"msg": "成功",
	"data": {
	"id": 21  //群成员列表id
	}
	}


#### 群主、管理员拉人进群


	*`URI`*

	http://www.petnet.cc/api/user/join-group?user_id=2&group_id=28&group_name=测试三群


	*EncType | Method*

	{
		user_id:8  //用户id
		group_id:28  //  群id
		group_name:测试三群  //群名
	}

	application/josn | GET


	*`Response`*


	{
	"code": 10000,
	"msg": "成功",
	"data": {
	"id": 36  //成员列表id
	}
	}

#### 群主解散群


	*`URI`*

	http://www.petnet.cc/api/user/group-dismiss?group_id=28


	*EncType | Method*

	{
	group_id:28  //  群id
	}

	application/josn | GET



	*`Response`*


	{
	"code": 10000,
	"msg": "成功",
	"data": {
	"data": "解散成功"
	}
	}

#### 群主修改群资料（群名，公告，广告）


	*`URI`*

	http://www.petnet.cc/api/user/change-group-info?group_id=28


	*EncType | Method*

	{
	group_id:28  //  群id
	}

	application/josn | POST

	*`Request`*

	{
	name:测试  //新群名
	introduce:打算打算的  //群公告
	group_img:file  //群头像
	group_adv:file  //群广告
	}

	*`Response`*


	{
	"code": 10000,
	"msg": "成功",
	"data": {
	"id": 28  //群id
	"group_img":  //群头像
	"group_adv": //群广告
	}
	}

#### 用户查看自己所有的群


	*`URI`*

	http://www.petnet.cc/api/user/group-list


	*EncType | Method*


	application/josn | GET


	*`Response`*

	{
	"create": [  //我创建的群
	{
	"id": "34",  //群id
	"name": "测试二3群",  //群名
	"group_img": "group_5705c6a9e77b4.jpg"  //群头像
	"user_num": 3  //群成员数
	},
	{
	"id": "33",
	"name": "测试二群",
	"group_img": "group_5705c6a9e77b4.jpg"
	"user_num": 3  //群成员数
	},
	{
	"id": "28",
	"name": "测试",
	"group_img": "group_5705c7d29eb86.jpg"
	"user_num": 3  //群成员数
	}
	],
	"admins": [],  //我管理的群
	"users": [  //我加入的群
	{
	"id": "35",
	"name": "测ddd",
	"group_img": "group_5705c6a9e77b4.jpg"
	"user_num": 3  //群成员数
	}
	]
	}

#### 成员修改群名片


	*`URI`*

	http://www.petnet.cc/api/user/group-user-name?group_id=28


	*EncType | Method*

	{
	group_id:28  //  群id
	}

	application/josn | POST

	*`Request`*

	{
	group_name:说的  //群名片
	}

	*`Response`*


	{
	"code": 10000,
	"msg": "成功",
	"data": {
	"id": 14  //群成员列表id
	}
	}

#### 群详情页面


	*`URI`*

	http://www.petnet.cc/api/user/group-detail?group_id=28


	*EncType | Method*

	{
	group_id:28  //  群id
	}

	application/josn | GET


	*`Response`*

	{
		"id": 1 //群id
		"group_location":群位置
		"name": "测试",  //群名
		"introduce": "fgg",  //群公告
		"group_type": "1", //群类型  1=>需要申请同意加入 2=>自由加入
		"group_img": "group_5705c7d29eb86.jpg",  //群头像
		"group_adv": "group_5705ecdc9fa21.png", //群广告
		"create_user_id":8  //群主id
		"user_num":8  //群人数
		"role":8  // 权限
	}

#### 搜索群（根据群名模糊查询）


	*`URI`*

	http://www.petnet.cc/api/user/search-group


	*EncType | Method*

	{
	group_id:28  //  群id
	}

	application/josn | POST

	*`Request`*

	{
		name:大声道  //群名 （模糊查询）
	}

	*`Response`*

	{
	"code": 10000,
	"msg": "成功",
	"data": {
	"items": [
	{
	"id": "42",  //群id
	"name": "测试一群",  //群名
	"group_img": "group_56fccd709038e.png",  //群头像
	"introduce": "张瑜",  //群介绍
	"group_location": "昌平区"；  //群位置
	"user_num":6  //群成员数
	"group_type":2  //群类型
	},
	{
	"id": "33",
	"name": "测试二群",
	"introduce": "测试看看",
	"group_img": "group_5705c6a9e77b4.jpg"
	},
	{
	"id": "28",
	"name": "测试",
	"introduce": "fgg",
	"group_img": "group_5705c7d29eb86.jpg"
	}
	],
	"_links": {
	"self": {
	"href": "http://localhost/pet/backend/web/api/user/search-group?access-token=i-w00whQhM1aUnZFdYcDqVfzA5gUskI7&page=1"
	}
	},
	"_meta": {
	"totalCount": 3,
	"pageCount": 1,
	"currentPage": 1,
	"perPage": 20
	}
	}
	}

#### 首页群列表展示（由近到远排序）


	*`URI`*

	http://www.petnet.cc/api/user/index-group-list?lat=28.3333333&lng=123.3232323


	*EncType | Method*

	{
	 lat: //经度
	lng: //纬度
	}

	application/josn | GET


	*`Response`*

	{
	"code": 10000,
	"msg": "成功",
	"data": {
	"items": [
	{
	"lat": "39.961465",  //经度
	"lng": "116.904151",  //纬度
	"id": "42",  //群id
	"name": "测试一群",  //群名
	"group_img": "group_56fccd709038e.png",  //群头像
	"introduce": "张瑜",  //群介绍
	"distance": "0"
	"group_location": "昌平区"；  //群位置
	"user_num":6  //群成员数
	"group_type":2  //群类型
	},
	{
	"lat": "39.961465",
	"lng": "116.904151",
	"id": "43",
	"name": "测试二群",
	"group_img": "group_56fccd709038e.png",
	"introduce": "宋龙宽",
	"distance": "0"
	}
	],
	"_links": {
	"self": {
	"href": "http://localhost/pet/backend/web/api/user/index-group-list?lat=39.9614650000&lng=116.9041510000&access-token=i-w00whQhM1aUnZFdYcDqVfzA5gUskI7&page=1"
	}
	},
	"_meta": {
	"totalCount": 2,
	"pageCount": 1,
	"currentPage": 1,
	"perPage": 20
	}
	}
	}

#### 用户主动退出群


	*`URI`*

	http://www.petnet.cc/api/user/user-quit-group?group_id=28


	*EncType | Method*

	{
	group_id:28  //  群id
	}

	application/josn | GET


	*`Response`*
	{
	"code": 10000,
	"msg": "成功",
	"data": {
	"id": 60
	}
	}

}


#### 动态附近列表

	*`URI`*

	http://www.petnet.cc/api/moments/near-list


	*EncType | Method*

	application/josn | GET

	*`Request`*
	{
	"location_LON":  必填 //经度
	"location_LAT":  必填 //纬度
	}

	*`Response`*
	{
		"code": 10000,
		"msg": "成功",
		"data": {
			"items": [
				{
				"id": 5,
				"user_id": 10,
				"content": "dfasasfsafaesfas fsdfsdfsdfsdfgsdfsd",
				"comment_times": 0,
				"transfer_times": 0,
				"view_times": 0,
				"praise_times": 0,
				"location_LON": null,
				"location_LAT": null,
				"created_at": "23小时前",
				"images": [
				"sos_576f527d70885.png"
				],
				"username": "与咯斤",
				"user_head_img": "user_57675373013c8.jpg"
				"is_praise": 1
				},
				{
				"id": 2,
				"user_id": 3,
				"content": "dasfafa",
				"comment_times": 0,
				"transfer_times": 0,
				"view_times": 0,
				"praise_times": 0,
				"location_LON": 16.4623186838,
				"location_LAT": 39.7668168166,
				"created_at": "05-17 10:54",
				"images": null,
				"username": "豆包",
				"user_head_img": "user_576751be10f7a.jpg"
				},
			],
			"_links": {
			"self": {
				"href": "http://123.56.76.190/api/moments/near-list?access-token=fbtz2qP0Si_dBmCV6kcvpgLPf5K6mJu9&location_LON=16.4623186838&location_LAT=39.7668168166&page=1"
				}
			},
			"_meta": {
				"totalCount": 5,
				"pageCount": 1,
				"currentPage": 1,
				"perPage": 10
			}
		}
	}
#### 动态附近列表 不需要登陆

	*`URI`*

	http://www.petnet.cc/api/moments/guest-near-list


	*EncType | Method*

	application/josn | GET

	*`Request`*
	{
	"location_LON":  必填 //经度
	"location_LAT":  必填 //纬度
	}

	*`Response`*
	{
	"code": 10000,
	"msg": "成功",
	"data": {
	"items": [
	{
	"id": 5,
	"user_id": 10,
	"content": "dfasasfsafaesfas fsdfsdfsdfsdfgsdfsd",
	"comment_times": 0,
	"transfer_times": 0,
	"view_times": 0,
	"praise_times": 0,
	"location_LON": null,
	"location_LAT": null,
	"created_at": "23小时前",
	"images": [
	"sos_576f527d70885.png"
	],
	"username": "与咯斤",
	"user_head_img": "user_57675373013c8.jpg"
	},
	{
	"id": 2,
	"user_id": 3,
	"content": "dasfafa",
	"comment_times": 0,
	"transfer_times": 0,
	"view_times": 0,
	"praise_times": 0,
	"location_LON": 16.4623186838,
	"location_LAT": 39.7668168166,
	"created_at": "05-17 10:54",
	"images": null,
	"username": "豆包",
	"user_head_img": "user_576751be10f7a.jpg"
	},
	],
	"_links": {
	"self": {
	"href": "http://123.56.76.190/api/moments/near-list?access-token=fbtz2qP0Si_dBmCV6kcvpgLPf5K6mJu9&location_LON=16.4623186838&location_LAT=39.7668168166&page=1"
	}
	},
	"_meta": {
	"totalCount": 5,
	"pageCount": 1,
	"currentPage": 1,
	"perPage": 10
	}
	}
	}
#### 动态列表 默认 登陆验证

	*`URI`*

	http://www.petnet.cc/api/moments/list


	*EncType | Method*

	application/josn | GET

	*`Request`*
	{
	}

	*`Response`*
	{
	"code": 10000,
	"msg": "成功",
	"data": {
		"items": [
			{
				"id": 5,
				"user_id": 10,
				"content": "dfasasfsafaesfas fsdfsdfsdfsdfgsdfsd",
				"comment_times": 0,
				"transfer_times": 0,
				"view_times": 0,
				"praise_times": 0,
				"location_LON": null,
				"location_LAT": null,
				"created_at": "23小时前",
				"images": [
				"sos_576f527d70885.png"
				],
				"username": "与咯斤",
				"user_head_img": "user_57675373013c8.jpg"
				"is_praise": 1 // 1 点过赞  null  未点赞

			},
			{
				"id": 2,
				"user_id": 3,
				"content": "dasfafa",
				"comment_times": 0,
				"transfer_times": 0,
				"view_times": 0,
				"praise_times": 0,
				"location_LON": 16.4623186838,
				"location_LAT": 39.7668168166,
				"created_at": "05-17 10:54",
				"images": null,
				"username": "豆包",
				"user_head_img": "user_576751be10f7a.jpg"
			},
			],
			"_links": {
			"self": {
			"href": "http://123.56.76.190/api/moments/near-list?access-token=fbtz2qP0Si_dBmCV6kcvpgLPf5K6mJu9&location_LON=16.4623186838&location_LAT=39.7668168166&page=1"
			}
			},
			"_meta": {
			"totalCount": 5,
			"pageCount": 1,
			"currentPage": 1,
			"perPage": 10
			}
		}
	}
	#### 动态列表 默认   不需要登陆

	*`URI`*

	http://www.petnet.cc/api/moments/guest-list


	*EncType | Method*

	application/josn | GET

	*`Request`*
	{
	}

	*`Response`*
	{
	"code": 10000,
	"msg": "成功",
	"data": {
	"items": [
	{
	"id": 5,
	"user_id": 10,
	"content": "dfasasfsafaesfas fsdfsdfsdfsdfgsdfsd",
	"comment_times": 0,
	"transfer_times": 0,
	"view_times": 0,
	"praise_times": 0,
	"location_LON": null,
	"location_LAT": null,
	"created_at": "23小时前",
	"images": [
	"sos_576f527d70885.png"
	],
	"username": "与咯斤",
	"user_head_img": "user_57675373013c8.jpg"

	},
	{
	"id": 2,
	"user_id": 3,
	"content": "dasfafa",
	"comment_times": 0,
	"transfer_times": 0,
	"view_times": 0,
	"praise_times": 0,
	"location_LON": 16.4623186838,
	"location_LAT": 39.7668168166,
	"created_at": "05-17 10:54",
	"images": null,
	"username": "豆包",
	"user_head_img": "user_576751be10f7a.jpg"
	},
	],
	"_links": {
	"self": {
	"href": "http://123.56.76.190/api/moments/near-list?access-token=fbtz2qP0Si_dBmCV6kcvpgLPf5K6mJu9&location_LON=16.4623186838&location_LAT=39.7668168166&page=1"
	}
	},
	"_meta": {
	"totalCount": 5,
	"pageCount": 1,
	"currentPage": 1,
	"perPage": 10
	}
	}
	}
#### 动态点赞列表

	*`URI`*

	http://www.petnet.cc/api/moments/praise-list


	*EncType | Method*

	application/josn | GET

	*`Request`*
	{
	"moment_id": 1 必填 //id  动态id
	}

	*`Response`*
	{
	"code": 10000,
	"msg": "成功",
	"data": {
	"items": [
	{
	"create_user_id": 10,
	"created_at": "06-27 10:50",
	"user_head": "user_57675373013c8.jpg",
	"user_name": "与咯斤"
	},
	{
	"create_user_id": 10,
	"created_at": "06-27 10:50",
	"user_head": "user_57675373013c8.jpg",
	"user_name": "与咯斤"
	},
	{
	"create_user_id": 10,
	"created_at": "06-27 10:50",
	"user_head": "user_57675373013c8.jpg",
	"user_name": "与咯斤"
	},
	{
	"create_user_id": 10,
	"created_at": "06-27 10:49",
	"user_head": "user_57675373013c8.jpg",
	"user_name": "与咯斤"
	},
	{
	"create_user_id": 10,
	"created_at": "06-27 10:49",
	"user_head": "user_57675373013c8.jpg",
	"user_name": "与咯斤"
	},
	{
	"create_user_id": 10,
	"created_at": "06-27 10:31",
	"user_head": "user_57675373013c8.jpg",
	"user_name": "与咯斤"
	},
	{
	"create_user_id": 10,
	"created_at": "06-27 10:31",
	"user_head": "user_57675373013c8.jpg",
	"user_name": "与咯斤"
	},
	{
	"create_user_id": 10,
	"created_at": "06-27 10:31",
	"user_head": "user_57675373013c8.jpg",
	"user_name": "与咯斤"
	},
	{
	"create_user_id": 10,
	"created_at": "06-27 10:31",
	"user_head": "user_57675373013c8.jpg",
	"user_name": "与咯斤"
	},
	{
	"create_user_id": 10,
	"created_at": "06-27 10:31",
	"user_head": "user_57675373013c8.jpg",
	"user_name": "与咯斤"
	},
	{
	"create_user_id": 10,
	"created_at": "06-27 10:31",
	"user_head": "user_57675373013c8.jpg",
	"user_name": "与咯斤"
	},
	{
	"create_user_id": 10,
	"created_at": "06-27 10:31",
	"user_head": "user_57675373013c8.jpg",
	"user_name": "与咯斤"
	},
	{
	"create_user_id": 10,
	"created_at": "06-27 10:30",
	"user_head": "user_57675373013c8.jpg",
	"user_name": "与咯斤"
	},
	{
	"create_user_id": 10,
	"created_at": "06-27 10:30",
	"user_head": "user_57675373013c8.jpg",
	"user_name": "与咯斤"
	},
	{
	"create_user_id": 10,
	"created_at": "06-27 10:30",
	"user_head": "user_57675373013c8.jpg",
	"user_name": "与咯斤"
	}
	],
	"_links": {
	"self": {
	"href": "http://pet.com/api/moments/praise-list?moment_id=1&location_LAT=44&access-token=y-9R379a5X8ZaN6npnR74OJ2SIHddY8h&group_id=185&user_id=5&group_name=asassfa&page=1&per-page=50"
	}
	},
	"_meta": {
	"totalCount": 15,
	"pageCount": 1,
	"currentPage": 1,
	"perPage": 50
	}
	}
	}
#### 动态列表 朋友圈

	*`URI`*

	http://www.petnet.cc/api/moments/moment-list


	*EncType | Method*

	application/josn | GET

	*`Request`*
	{
	}

	*`Response`*
	{
		"code": 10000,
		"msg": "成功",
		"data": {
		"items": [
		{
		"id": 5,
		"user_id": 10,
		"content": "dfasasfsafaesfas fsdfsdfsdfsdfgsdfsd",
		"comment_times": 0,
		"transfer_times": 0,
		"view_times": 0,
		"praise_times": 0,
		"location_LON": null,
		"location_LAT": null,
		"created_at": "23小时前",
		"images": [
		"sos_576f527d70885.png"
		],
		"username": "与咯斤",
		"user_head_img": "user_57675373013c8.jpg"
		},
		{
		"id": 2,
		"user_id": 3,
		"content": "dasfafa",
		"comment_times": 0,
		"transfer_times": 0,
		"view_times": 0,
		"praise_times": 0,
		"location_LON": 16.4623186838,
		"location_LAT": 39.7668168166,
		"created_at": "05-17 10:54",
		"images": null,
		"username": "豆包",
		"user_head_img": "user_576751be10f7a.jpg"
		},
		],
		"_links": {
		"self": {
		"href": "http://123.56.76.190/api/moments/near-list?access-token=fbtz2qP0Si_dBmCV6kcvpgLPf5K6mJu9&location_LON=16.4623186838&location_LAT=39.7668168166&page=1"
		}
		},
		"_meta": {
		"totalCount": 5,
		"pageCount": 1,
		"currentPage": 1,
		"perPage": 10
		}
		}
	}
#### 动态列表 我的

	*`URI`*

	http://www.petnet.cc/api/moments/my-list


	*EncType | Method*

	application/josn | GET

	*`Request`*
	{
	}

	*`Response`*
	{
		"code": 10000,
		"msg": "成功",
		"data": {
			"items": [
			{
			"id": 5,
			"user_id": 10,
			"content": "dfasasfsafaesfas fsdfsdfsdfsdfgsdfsd",
			"comment_times": 0,
			"transfer_times": 0,
			"view_times": 0,
			"praise_times": 0,
			"location_LON": null,
			"location_LAT": null,
			"created_at": "23小时前",
			"images": [
			"sos_576f527d70885.png"
			],
			"username": "与咯斤",
			"user_head_img": "user_57675373013c8.jpg"
			},
			{
			"id": 2,
			"user_id": 3,
			"content": "dasfafa",
			"comment_times": 0,
			"transfer_times": 0,
			"view_times": 0,
			"praise_times": 0,
			"location_LON": 16.4623186838,
			"location_LAT": 39.7668168166,
			"created_at": "05-17 10:54",
			"images": null,
			"username": "豆包",
			"user_head_img": "user_576751be10f7a.jpg"
			},
			],
			"_links": {
			"self": {
			"href": "http://123.56.76.190/api/moments/near-list?access-token=fbtz2qP0Si_dBmCV6kcvpgLPf5K6mJu9&location_LON=16.4623186838&location_LAT=39.7668168166&page=1"
			}
			},
			"_meta": {
			"totalCount": 5,
			"pageCount": 1,
			"currentPage": 1,
			"perPage": 10
			}
		}
	}
#### 动态列表 他人的

	*`URI`*

	http://www.petnet.cc/api/moments/other-list


	*EncType | Method*

	application/josn | GET

	*`Request`*
	{
	 	"user_id":10   //用户id'
	}

	*`Response`*
	{
	"code": 10000,
	"msg": "成功",
	"data": {
	"items": [
	{
	"id": 5,
	"user_id": 10,
	"content": "dfasasfsafaesfas fsdfsdfsdfsdfgsdfsd",
	"comment_times": 0,
	"transfer_times": 0,
	"view_times": 0,
	"praise_times": 0,
	"location_LON": null,
	"location_LAT": null,
	"created_at": "23小时前",
	"images": [
	"sos_576f527d70885.png"
	],
	"username": "与咯斤",
	"user_head_img": "user_57675373013c8.jpg"
	},
	{
	"id": 2,
	"user_id": 3,
	"content": "dasfafa",
	"comment_times": 0,
	"transfer_times": 0,
	"view_times": 0,
	"praise_times": 0,
	"location_LON": 16.4623186838,
	"location_LAT": 39.7668168166,
	"created_at": "05-17 10:54",
	"images": null,
	"username": "豆包",
	"user_head_img": "user_576751be10f7a.jpg"
	},
	],
	"_links": {
	"self": {
	"href": "http://123.56.76.190/api/moments/near-list?access-token=fbtz2qP0Si_dBmCV6kcvpgLPf5K6mJu9&location_LON=16.4623186838&location_LAT=39.7668168166&page=1"
	}
	},
	"_meta": {
	"totalCount": 5,
	"pageCount": 1,
	"currentPage": 1,
	"perPage": 10
	}
	}
	}
#### 动态 详情

	*`URI`*

	http://www.petnet.cc/api/moments/detail


	*EncType | Method*

	application/josn | GET

	*`Request`*
	{
		"id":23 // 必填  动态id
	}

	*`Response`*
	{
	"code": 10000,
	"msg": "成功",
	"data": {
	"id": 5,
	"user_id": 10,
	"content": "dfasasfsafaesfas fsdfsdfsdfsdfgsdfsd",
	"comment_times": 0,
	"transfer_times": 0,
	"view_times": 1,
	"praise_times": 0,
	"created_at": "23小时前",
	"images": [
	"sos_576f527d70885.png"
	],
	"username": "与咯斤",
	"user_head_img": "user_57675373013c8.jpg"
	}
	}
#### 动态 评论列表

	*`URI`*

	http://www.petnet.cc/api/moments/comment-list


	*EncType | Method*

	application/josn | GET

	*`Request`*
	{
		"moment_id":23 // 必填  动态id
	}

	*`Response`*
	{
		"code": 10000,
		"msg": "成功",
		"data": {
			"items": [
				{
				"id": 1,
				"moment_id": 1,
				"content": "dsaf",
				"from_user_id": 3,
				"to_user_id": 4,
				"created_at": null,
				"from_user_head": "user_576751be10f7a.jpg",
				"to_user_head": "user_576754fd7701f.jpg",
				"from_user_name": "豆包",
				"to_user_name": "大白"
				}
			],
			"_links": {
			"self": {
			"href": "http://123.56.76.190/api/moments/comment-list?moment_id=1&access-token=fbtz2qP0Si_dBmCV6kcvpgLPf5K6mJu9&location_LON=16.4623186838&location_LAT=39.7668168166&page=1&per-page=10"
			}
			},
			"_meta": {
			"totalCount": 1,
			"pageCount": 1,
			"currentPage": 1,
			"perPage": 10
			}
		}
	}
#### 动态 点赞

	*`URI`*

	http://www.petnet.cc/api/moments/praise


	*EncType | Method*

	application/josn | GET

	*`Request`*
	{
		"moment_id":23 // 必填  动态id
	}

	*`Response`*
	{
		"code": 10000,
		"msg": "成功",
		"data": {
		"id": 10
		}
	}
	//失败
	{
	"code": 20001,
	"msg": "操作失败",
	"data": {
		"moment_id": [
		"已经点过赞了."
		]
		}
	}
#### 动态 转发

	*`URI`*

	http://www.petnet.cc/api/moments/transfer


	*EncType | Method*

	application/josn | GET

	*`Request`*
	{
	"moment_id":23 // 必填  动态id
	}

	*`Response`*
	{
		"code": 10000,
		"msg": "成功",
		"data": {
		"id": 10
		}
	}
#### 动态 评论

	*`URI`*

	http://www.petnet.cc/api/moments/comment


	*EncType | Method*

	application/josn | POST

	*`Request`*
	{
	"moment_id":23 // 必填  动态id
	"content":23 // 必填  评论
	}

	*`Response`*
	{
		"code": 10000,
		"msg": "成功",
		"data": {
		"id": 10
		}
	}
#### 动态 添加动态

	*`URI`*

	http://www.petnet.cc/api/moments/add-moment


	*EncType | Method*

	application/josn | POST

	*`Request`*
	{
		"content":23 // 必填  内容
		"location_LON":23 // 非必填  经度
		"location_LAT":23 // 非必填  纬度
		//文件  最多九个
	}

	*`Response`*
	{
	"code": 10000,
	"msg": "成功",
	"data": {
	"id": 10
	}
	}
	//失败
	{
	"code": 20001,
	"msg": "操作失败",
	"data": {
		"content": [
		"内容不能为空"
		]
		}
	}
#### 动态 删除动态

	*`URI`*

	http://www.petnet.cc/api/moments/del-moment


	*EncType | Method*

	application/josn | POST

	*`Request`*
	{
	"id":23 // 必填  动态ID
	}

	*`Response`*
	{
		"code": 10000,
		"msg": "成功",
		"data": {
		"id": 10
		}
	}

#### 获取群成员个数

	*`URI`*

	http://www.petnet.cc/api/user/get-group-num


	*EncType | Method*

	application/josn | GET


	*`Response`*
	{
	"code": 10000,
	"msg": "成功",
	"data": {
	"nums": "2"   //成员数
	}
	}
### 队伍副本
#### 附近的副本列表
	*`URI`*

	http://www.petnet.cc/api/room/list


	*EncType | Method*

	application/josn | GET

	*`Request`*
	{
		"lng":23 // 必填  动态id
		"lat":23 // 必填  动态id
	}

	*`Response`*
	{
	"code": 10000,
	"msg": "成功",
	"data": {
	"items": [
	{
	"id": 18,
	"name": "打击一起",
	"lng": 20,
	"lat": 22,
	"curr_user": 3,
	"max_num": 12,
	"create_user_id": 5,
	"create_user_name": "张愉",
	"create_user_head": "user_576a3fcc81d7a.jpg"
	},
	{
	"id": 17,
	"name": "打击一起",
	"lng": 20,
	"lat": 22,
	"curr_user": 1,
	"max_num": 12,
	"create_user_id": 10,
	"create_user_name": "与咯斤",
	"create_user_head": "user_57675373013c8.jpg"
	}
	],
	"_links": {
	"self": {
	"href": "http://pet.com/api/room/list?uid=22&lng=22&lat=44&moment_id=1&access-token=ITr0XE0W5vAgNoh6YGW8WCRdwCVkRvnb&group_id=185&user_id=5&group_name=asassfa&page=1"
	}
	},
	"_meta": {
	"totalCount": 2,
	"pageCount": 1,
	"currentPage": 1,
	"perPage": 10
	}
	}
	}
#### 我的的副本队伍
	*`URI`*

	http://www.petnet.cc/api/room/my-team


	*EncType | Method*

	application/josn | GET

	*`Request`*
	{
	}

	*`Response`*
	{
	"code": 10000,
	"msg": "成功",
	"data": {
	"id": "78",
	"name": "我的副本",
	"lng": "116.425162",
	"img": "team_578c52f95d618.png",
	"curr_user": "1",
	"max_num": "100",
	"create_user_id": "5",
	"create_time": "1468814073",
	"create_user_name": "张愉",
	"create_user_head": "user_576a3fcc81d7a.jpg"
	}
	}
#### 创建副本队伍
	*`URI`*

	http://www.petnet.cc/api/room/new-team


	*EncType | Method*

	application/josn | POST

	*`Request`*
	{
	"max_num": 22 //"最大人数不能为空。"  1-100 之间
	"name": gdfgf//"名称不能为空。"
	"lng": 32 //"经度不能为空。"
	"lat": 33 //	"纬度不能为空。"
	"img": sffsfg.jpg //	"图片不能为空。"

	}
	*`Response`*
	{  //失败直接弹出框data
	"code": 20001,
	"msg": "操作失败",
	"data": "操作失败"
	}
	*`Response`*
	{  //失败直接弹出框data
	"code": 20001,
	"msg": "操作失败",
	"data": "操作失败"
	}
	{  //成功后页面跳转  进入副本  建立tcp连接  房间号id=19
	"code": 10000,
	"msg": "成功",
	"data": {
	"id": 19
	}
	}
#### 解散副本队伍
	*`URI`*

	http://www.petnet.cc/api/room/del-team


	*EncType | Method*

	application/josn | get

	*`Request`*
	{
	"room_id": 22 //"必须
	}
	*`Response`*
	{  //失败直接弹出框data
	"code": 20001,
	"msg": "操作失败",
	"data": "操作失败"
	}
	*`Response`*
	{  //失败直接弹出框data
	"code": 20001,
	"msg": "操作失败",
	"data": "操作失败"
	}
	{  //成功后页面跳转  如果在副本 则推出
	"code": 10000,
	"msg": "成功",
	"data": {
	"id": 19
	}
	}
#### 加入队伍 副本
	*`URI`*

	http://www.petnet.cc/api/room/join-team

	*EncType | Method*

	application/josn | GET
	*`Request`*
	{
	"room_id": 22 //"必须
	}
	*`Response`*
	{  //失败直接弹出框data
	"code": 20001,
	"msg": "操作失败",
	"data": "操作失败"
	}
	*`Response`*
	{  //失败直接弹出框data
	"code": 20001,
	"msg": "操作失败",
	"data": "操作失败"
	}
	{  //成功后页面跳转  进入副本  建立tcp连接  房间号id=19
	"code": 10000,
	"msg": "成功",
	"data": {
	"id": 19
	}
	}
#### 离开队伍 副本
	*`URI`*

	http://www.petnet.cc/api/room/leave-team

	*EncType | Method*

	application/josn | GET
	*`Request`*
	{
	}
	*`Response`*
	{  //失败直接弹出框data
	"code": 20001,
	"msg": "操作失败",
	"data": "操作失败"
	}
	*`Response`*
	{  //失败直接弹出框data
	"code": 20001,
	"msg": "操作失败",
	"data": "操作失败"
	}
	{  //成功后页面跳转  如果在副本 则推出
	"code": 10000,
	"msg": "成功",
	"data": {
	"id": 19
	}
	}
#### 队长拉人进入副本 副本
	*`URI`*

	http://www.petnet.cc/api/room/pull-member

	*EncType | Method*

	application/josn | GET
	*`Request`*
	{
	"uid": 22 //"必须  用户id
	}
	*`Response`*
	{  //失败直接弹出框data
	"code": 20001,
	"msg": "操作失败",
	"data": "操作失败"
	}
	*`Response`*
	{  //失败直接弹出框data
	"code": 20001,
	"msg": "操作失败",
	"data": "操作失败"
	}
	{  //成功
	"code": 10000,
	"msg": "成功",
	"data": {
		"id": 19
		}
	}
#### 队长踢人 队伍 副本
	*`URI`*

	http://www.petnet.cc/api/room/push-member

	*EncType | Method*

	application/josn | GET
	*`Request`*
	{
	"uid": 22 //"必须  用户id
	}
	*`Response`*
	{  //失败直接弹出框data
	"code": 20001,
	"msg": "操作失败",
	"data": "操作失败"
	}
	*`Response`*
	{  //失败直接弹出框data
	"code": 20001,
	"msg": "操作失败",
	"data": "操作失败"
	}
	{  //成功后页面跳转
	"code": 10000,
	"msg": "成功",
	"data": {
	"id": 19
	}
	}
#### 留言  发布留言

	*`URI`*

	http://www.petnet.cc/api/message/add-message


	*EncType | Method*

	application/josn | POST

	*`Request`*
	{
	"content":"留言内容不能为空",   //
	"nickname":"昵称不能为空",   //
	}

	*`Response`*
	{
	"code": 10000,
	"msg": "成功",
	"data": {
	"id": 1
	}
	}
#### 留言  留言列表

	*`URI`*

	http://www.petnet.cc/api/message/list


	*EncType | Method*

	application/josn | GET

	*`Request`*
	{
	}

	*`Response`*
	{
	"code": 10000,
	"msg": "成功",
	"data": {
	"items": [
	{
	"id": 1,
	"nickname": "asfaf",
	"content": "asaf",
	"create_time": null
	}
	],
	"_links": {
	"self": {
	"href": "http://pet.com/api/message/list?user_id=5&location_LAT=44&access-token=y-9R379a5X8ZaN6npnR74OJ2SIHddY8h&group_id=185&group_name=asassfa&page=1&per-page=10"
	}
	},
	"_meta": {
	"totalCount": 1,
	"pageCount": 1,
	"currentPage": 1,
	"perPage": 10
	}
	}
	}
#### 删除 一键求助

	*`URI`*

	http://www.petnet.cc/api/sos/del-sos


	*EncType | Method*

	application/josn | get

	*`Request`*
	{
	"id":"1",   // 必填
	}

	*`Response`*
	{
	"code": 10000,
	"msg": "成功",
	"data": {
	"id": 1
	}
	}
#### 首页 获取用户 列表


	*`URI`*

	http://www.petnet.cc/api/user/random-six

	*EncType | Method*

	application/josn | GET

	*`Response`*

    {
        "code": 10000,
        "msg": "成功",
        "data": {
            "items": [
                {
				"id":100005,
				"username":"crush",
				"sex":2,
				"user_head_img":"user_57ab0e0a6b42a.jpg",
				"pet_name":null,
				"pet_category":"爱尔兰水猎犬",
				"pet_head_img":"pet_57cd35be432a0.jpg"
				},
				{
				"id":100006,
				"username":"22222",
				"sex":1,
				"user_head_img":"user_57c3ea7c033b7.jpg",
				"pet_name":null,
				"pet_category":null,
				"pet_head_img":null
				},
				{
				"id":100007,
				"username":"张愉",
				"sex":1,
				"user_head_img":"user_57a98a611eb3b.jpg",
				"pet_name":"哈哈哈",
				"pet_category":"凯利蓝梗",
				"pet_head_img":"pet_57b30f4f65d93.jpg"
				},
				{
				"id":100008,
				"username":"大白",
				"sex":2,
				"user_head_img":"user_57ccee497549b.jpg",
				"pet_name":null,
				"pet_category":"阿富汗猎犬",
				"pet_head_img":null
				},
				{
				"id":100009,
				"username":"1111111",
				"sex":2,
				"user_head_img":"user_57cf7e83a8a04.jpg",
				"pet_name":"Xxxx",
				"pet_category":"爱尔兰红白雪达犬",
				"pet_head_img":null
				},
				{
				"id":100010,
				"username":"张慧下",
				"sex":1,
				"user_head_img":"user_57aaa3ea79c34.jpg",
				"pet_name":"小狗",
				"pet_category":"爱尔兰雪达犬",
				"pet_head_img":"pet_57ad732c086c6.jpg"
				}
            ],
            "_links": {
                "self": {
                    "href": "http://www.petnet.cc/api/user/random-six?access-token=-BD10eOktB0DGRBZ6O3D_1zyq8_yA1sH&page=1&per-page=6"
                }
            },
            "_meta": {
                "totalCount": 78,  //共有78个用户数据
                "pageCount": 13,   //可以换一批13次，传参eg：1~13其中的任意一个数字，不得大于pageCount所显示的数字
                "currentPage": 1,  //当前第一次
                "perPage": 6	   //返回6条数据
            }
        }
    }
	#### 获取宠物品种
*`URI`*&nbsp;
http://www.petnet.cc/api/pet/pet-diff&nbsp;
*EncType | Method*

	application/josn | get

	*`Request`*
	{
	"variety_id":"1",   //1:狗 2:猫 3:鼠 
	}

	*`Response`*
	{
	"code": 10000,
	"msg": "成功",
	"data": {
	"id":18,
	"cate_name":萨摩耶,
	"is_hot":1,
	{"id":"25","cate_name":"哈士奇","is_hot":"1"},
	{"id":"28","cate_name":"阿拉斯加","is_hot":"1"},
	{"id":"50","cate_name":"拉布拉多","is_hot":"1"},
	{"id":"67","cate_name":"雪纳瑞","is_hot":"1"},
	{"id":"76","cate_name":"泰迪","is_hot":"1"},
	{"id":"179","cate_name":"中华田园犬","is_hot":"1"},
	{"id":"437","cate_name":"金毛","is_hot":"1"}
	}
	}

#### 获取所有宠物
*`URI`*&nbsp;

http://www.petnet.cc/api/pet/pet-variety
&nbsp;
*EncType | Method*

	application/josn | get

	*`Request`*
	{
	"variety_id":"1",   //1:狗 2:猫 3:鼠 
	}

	*`Response`*
	{
	"code": 10000,
	"msg": "成功",
	"data": {
	"is_hot":[{"id":"28","cate_name":"阿拉斯加","aleph":"a","is_hot":"1"},
	{"id":"25","cate_name":"哈士奇","aleph":"h","is_hot":"1"}]}
	}


#### 随机获取问答小题

	*`URI`*
	http://www.520m.com.cn/api/question/question-list?access-token=ZXUzL4jwA1SPaJ7oDROCqmRO_-lXbE--&is_pet=1

	*EncType | Method*

	application/json | GET

	*`Request`*
	{
	"is_pet":1.官方2.宠友
	"access-token"
	}

	*`Response`*
	{
		{
		  "code": 10000,
		  "msg": "成功",
		  "data": {
			"id": "3",
			"img": "http://peita.oss-cn-beijing.aliyuncs.com/question/855681479958635.jpg",
			"problem": "图中的宠物属于什么品种？",
			"answer_one": "萨摩耶",
			"answer_two": "泰迪",
			"answer_three": null,
			"answer_four": null,
			"answer_true": "泰迪",
			"fraction": "2",
			"tcount": "0",
			"fcount": "0",
			"user_imgs": "user_584fb5033a5d4.jpg",
			"user_experience": "20",
			"last_experience": "140",
			"user_grade": "1"
		  }
		}
	}

	*`字段说明`*
	  `img` : '问题头像',
	  `problem` : '问题',
	  `answer_one` : '答案一',
	  `answer_two` : '答案二',
	  `answer_three` : '答案三',
	  `answer_four` : '答案四',
	  `answer_true` : '正确答案',
	  `status` : '作为删除或者激活的状态',
	  `fraction` : '分数',
	  `tcount` : '答题正确次数统计',
	  `fcount` : '答题错误次数统计',
	  `user_experience` : '用户经验值',
	  `user_grade` : '用户等级',
	  `user_imgs` : '用户头像',
	  `last_experience` : '总经验值'


#### 我要出题（宠友）
*`URI`*
	http://www.520m.com.cn/api/question/create-question?access-token=ZXUzL4jwA1SPaJ7oDROCqmRO_-lXbE--

	*EncType | Method*

	application/json | POST

	*`Request`*
	{
	"problem":问题
	"answer_one":答案1
	"answer_two":答案2
	"answer_three":答案3
	"answer_four":答案4
	"answer_true":正确答案
	"img":图片
	"access-token"
	}

	*`Response`*
	{
		{
		  "code": 10000,
		  "msg": "成功",
		  "data": null
		}
	}



#### 答题结果处理

*`URI`*
http://www.520m.com.cn/api/question/answer?access-token=ZXUzL4jwA1SPaJ7oDROCqmRO_-lXbE--

*EncType | Method*

	application/josn | POST

	*`Request`*
	{
		"experience", //奖励分数
		"is_true", //1.答对  2.答错
		"question_id"//题id
		"evaluate"评价//1.无聊2.还可以3.好难啊
	}

	*`Response`*
	{
		{
		  "code": 10000,
		  "msg": "成功",
		  "data": null
		}
	}



#### 小题举报

*`URI`*
http://www.520m.com.cn/api/question/add-report?access-token=ZXUzL4jwA1SPaJ7oDROCqmRO_-lXbE--

	application/josn | POST

	*`Request`*
	{
		"report_content", //举报内容
		"email", //预留邮箱
		"question_id"//题id
	}

	*`Response`*
	{
		{
		  "code": 10000,
		  "msg": "成功",
		  "data": null
		}
	}


#### 首页轮播+是否签到判断

*`URI`*
http://www.520m.com.cn/api/register/banner-list?access-token=ZXUzL4jwA1SPaJ7oDROCqmRO_-lXbE--

说明：每次最多只返回4条数据

application/josn | GET

	*`Request`*
	{
	}

	*`Response`*
	{
		{
		  "code": 10000,
		  "msg": "成功",
		  "data": {
			"banner": [
			  {
				"id": "6",
				"img": "http://peita.oss-cn-beijing.aliyuncs.com/question/288671479972047.jpg",
				"html_url": "http://www.peita.net"
			  },
			  {
				"id": "7",
				"img": "http://peita.oss-cn-beijing.aliyuncs.com/question/356931482400398.jpg",
				"html_url": "http://www.baidu.com"
			  },
			  {
				"id": "8",
				"img": "http://peita.oss-cn-beijing.aliyuncs.com/question/164261482400415.jpg",
				"html_url": "http://JD.com"
			  },
			  {
				"id": "9",
				"img": "http://peita.oss-cn-beijing.aliyuncs.com/question/288671479972047.jpg",
				"html_url": "http://www.peita.net"
			  }
			],
			"is_sign": true
		  }
		}
	}


#### 当月排行榜前十名

*`URI`*

	http://www.520m.com.cn/api/question/current-monday-list?access-token=ZXUzL4jwA1SPaJ7oDROCqmRO_-lXbE--

*EncType | Method*

	application/josn | GET

	*`Request`*
	{
	}

	*`Response`*
	{
		{
		  "code": 10000,
		  "msg": "成功",
		  "data": {
			"ten": [
			  {
				"id": "100165",
				"username": "小黑爸爸",
				"img": "user_584fb5033a5d4.jpg",
				"grade": "6",
				"true_count": "68"
			  },
			  {
				"id": "100167",
				"username": "Tttt",
				"img": "user_585b713c7d8c6.jpg",
				"grade": "1",
				"true_count": "54"
			  },
			  {
				"id": "100158",
				"username": "小白",
				"img": "user_58aa588fa43db.jpg",
				"grade": "2",
				"true_count": "33"
			  },
			  {
				"id": "100159",
				"username": "",
				"img": "user_584bd9947e275.jpg",
				"grade": "1",
				"true_count": "32"
			  },
			  {
				"id": "100160",
				"username": "小狗的霸霸",
				"img": "user_589abf5fb44bb.jpg",
				"grade": "1",
				"true_count": "20"
			  },
			  {
				"id": "100170",
				"username": "user8132",
				"img": "user_5800952a5464c.jpg",
				"grade": "1",
				"true_count": "18"
			  },
			  {
				"id": "100161",
				"username": "Seven的霸霸",
				"img": "user_57ff54cf6a1e7.jpg",
				"grade": "1",
				"true_count": "18"
			  },
			  {
				"id": "100171",
				"username": "user",
				"img": "",
				"grade": "1",
				"true_count": "17"
			  },
			  {
				"id": "100172",
				"username": "user7755",
				"img": "",
				"grade": "1",
				"true_count": "15"
			  },
			  {
				"id": "100173",
				"username": "user98",
				"img": "",
				"grade": "1",
				"true_count": "3"
			  }
			],
			"userinfo": {
			  "id": "100165",
			  "username": "小黑爸爸",
			  "img": "user_584fb5033a5d4.jpg",
			  "grade": "6",
			  "true_count": "68"
			}
		  }
		}
			
	}


#### 帮助与反馈

*`URI`*

	http://www.520m.com.cn/api/question/add-help?access-token=ZXUzL4jwA1SPaJ7oDROCqmRO_-lXbE--

	*EncType | Method*

	application/josn | POST

	*`Request`*
	{
	"title":标题
	"proposal":建议内容
	"img":截图（仅限制与一张）
	}

	*`Response`*
	{
		"code": 10000,
		"msg": "成功",
		"data": null
	}


#### 趣闻列表

*`URI`*

	http://www.520m.com.cn/api/register/journalism-list

	*EncType | Method*

	application/josn | GET

	*`Request`*
	{
		page
	}

	*`Response`*
	{
		{
		  "code": 10000,
		  "msg": "成功",
		  "data": {
			"pagedata": [
			  {
				"jid": "441",
				"title": "杀死狗狗的真凶，竟然是这华丽丽的宠物床！",
				"author": "好狗狗 ",
				"create_time": "1487643938",
				"coment_num": "0",
				"img": [
				  "http://peita.oss-cn-beijing.aliyuncs.com/question/374101487643937.jpg",
				  "http://peita.oss-cn-beijing.aliyuncs.com/question/307371487643937.jpg",
				  "http://peita.oss-cn-beijing.aliyuncs.com/question/283551487643937.jpg",
				  "http://peita.oss-cn-beijing.aliyuncs.com/question/237701487643937.jpg",
				  "http://peita.oss-cn-beijing.aliyuncs.com/question/617061487643937.jpg",
				  "http://peita.oss-cn-beijing.aliyuncs.com/question/436151487643938.jpg"
				]
			  },
			  {
				"jid": "440",
				"title": "猫咪艺术摄影之美、国外宠物摄影欣赏",
				"author": "爱宠生活",
				"create_time": "1487643699",
				"coment_num": "0",
				"img": [
				  "http://peita.oss-cn-beijing.aliyuncs.com/question/363031487643697.jpg",
				  "http://peita.oss-cn-beijing.aliyuncs.com/question/276221487643697.jpg",
				  "http://peita.oss-cn-beijing.aliyuncs.com/question/402081487643697.jpg",
				  "http://peita.oss-cn-beijing.aliyuncs.com/question/980821487643697.jpg",
				  "http://peita.oss-cn-beijing.aliyuncs.com/question/571021487643698.jpg",
				  "http://peita.oss-cn-beijing.aliyuncs.com/question/795591487643698.jpg",
				  "http://peita.oss-cn-beijing.aliyuncs.com/question/462081487643698.jpg",
				  "http://peita.oss-cn-beijing.aliyuncs.com/question/392301487643698.jpg"
				]
			  },
			  {
				"jid": "439",
				"title": "母狗被车撞死留下了一只小崽，看它可怜抱回了家，希望能平安幸福",
				"author": "快乐小萌宠 ",
				"create_time": "1487584886",
				"coment_num": "0",
				"img": [
				  "http://peita.oss-cn-beijing.aliyuncs.com/question/731531487584885.jpg",
				  "http://peita.oss-cn-beijing.aliyuncs.com/question/685061487584885.jpg",
				  "http://peita.oss-cn-beijing.aliyuncs.com/question/772111487584885.jpg",
				  "http://peita.oss-cn-beijing.aliyuncs.com/question/945291487584886.jpg",
				  "http://peita.oss-cn-beijing.aliyuncs.com/question/311921487584886.jpg"
				]
			  },
			  {
				"jid": "438",
				"title": "这只狗狗被关在地下室当作繁殖工具，整整十年没见阳光",
				"author": "萌宠小哥",
				"create_time": "1487584806",
				"coment_num": "0",
				"img": [
				  "http://peita.oss-cn-beijing.aliyuncs.com/question/515431487584806.jpg",
				  "http://peita.oss-cn-beijing.aliyuncs.com/question/86091487584806.jpg",
				  "http://peita.oss-cn-beijing.aliyuncs.com/question/539271487584806.jpg"
				]
			  },
			  {
				"jid": "437",
				"title": "狗狗闭眼一瞬间，主人崩溃了",
				"author": "夏凉 ",
				"create_time": "1487584749",
				"coment_num": "0",
				"img": [
				  "http://peita.oss-cn-beijing.aliyuncs.com/question/926611487584737.gif",
				  "http://peita.oss-cn-beijing.aliyuncs.com/question/721401487584744.gif"
				]
			  },
			  {
				"jid": "436",
				"title": "平时像个二货的哈士奇，严肃起来竟然一派正经",
				"author": "宠信 ",
				"create_time": "1487584659",
				"coment_num": "0",
				"img": [
				  "http://peita.oss-cn-beijing.aliyuncs.com/question/847931487584659.jpg",
				  "http://peita.oss-cn-beijing.aliyuncs.com/question/190421487584659.jpg",
				  "http://peita.oss-cn-beijing.aliyuncs.com/question/744571487584659.jpg"
				]
			  }
			],
			"query": {
			  "countpage": 65,
			  "page": 1,
			  "up": "http://www.520m.com.cn/api/question/journalism-list?access-token=ZXUzL4jwA1SPaJ7oDROCqmRO_-lXbE--&page=1",
			  "next": "http://www.520m.com.cn/api/question/journalism-list?access-token=ZXUzL4jwA1SPaJ7oDROCqmRO_-lXbE--&page=2"
			}
		  }
		}
	}


#### 根据id查看趣闻详情

	*`URI`*

	http://www.520m.com.cn/api/register/journalism-list-id?id=441

	*EncType | Method*

	application/josn | GET

	*`Request`*
	{
		id:当前趣闻id
	}

	*`Response`*
	{
		{
		  "code": 10000,
		  "msg": "成功",
		  "data": {
			"jid": 532,
			"title": "网友表示，自己捡了一只脸型复杂的狗狗，我看了眼，果然不一般！",
			"author": "猫猫狗狗的医师",
			"introduction": "2",
			"img1": "http://peita.oss-cn-beijing.aliyuncs.com/question/954831488448403.jpg",
			"content1": "在头条里，有一群人专门能捡狗，昨天捡了只泰迪，今天就能弄条哈士奇出来，本兽医也是羡慕不见，为什么好运都给人家占了，我出门连个毛都碰不见呢？真的是人比人，气死人呐！\r\n\r\n不过捡到狗也不全是好事啊，比如你捡了只哈士奇，你是收留它让它败你的家呢还是把自己捡到的成果送给别人呢？\r\n\r\n兽医小明今天要给大家带来的宠物趣事呢，也是关于捡狗的，这位网友了不得，人家不仅捡到狗了，还是一只脸型复杂的狗狗！\r\n\r\n大家来一睹狗狗的风采吧~",
			"img2": "http://peita.oss-cn-beijing.aliyuncs.com/question/993781488448403.jpg",
			"content2": "不得不说，这脸型果真不一般，一看就是位闲不住的主",
			"img3": "http://peita.oss-cn-beijing.aliyuncs.com/question/574221488448403.jpg",
			"content3": "据大家讨论，这应该是一只换毛期的阿拉斯加，网友很犹豫，是收养它呢还是送人呢？",
			"img4": "http://peita.oss-cn-beijing.aliyuncs.com/question/693321488448403.jpg",
			"content4": "这么不一般的狗狗都被网友捡到了，说明网友跟这狗有缘呀，我相信，这只阿拉斯加一定不会败家滴哈哈！",
			"img5": "",
			"content5": "",
			"img6": "",
			"content6": "",
			"img7": "",
			"content7": "",
			"img8": "",
			"content8": "",
			"img9": "",
			"content9": "",
			"img10": "",
			"content10": "",
			"create_time": "1488448403",
			"coment_num": 0,
			"editer": "萌宠",
			"tags": [
			  "汪星人"
			],
			"froms": "今日头条",
			"video": null,
			"browse_num": 1
		  }
		}
	}



#### 趣闻页面广告轮播

*`URI`*

	http://www.520m.com.cn/api/register/journalismbanner-list

	*EncType | Method*

	application/josn | GET

	*`Request`*
	{
	}

	*`Response`*
	{
		{
		  "code": 10000,
		  "msg": "成功",
		  "data": {
			"banner": [
			  {
				"img": "http://peita.oss-cn-beijing.aliyuncs.com/question/820291487917874.png",
				"html_url": "http://www.yto.net.cn/gw/index/index.html"
			  },
			  {
				"img": "http://peita.oss-cn-beijing.aliyuncs.com/question/666071487917932.jpg",
				"html_url": "http://www.baidu.com"
			  },
			  {
				"img": "http://peita.oss-cn-beijing.aliyuncs.com/question/324091487917994.jpg",
				"html_url": "http://www.dog126.com/"
			  }
			]
		  }
		}
	}


#### 获取用户当前金豆
	*`URI`*
	http://www.520m.com.cn/api/question/current-bean?access-token=ZXUzL4jwA1SPaJ7oDROCqmRO_-lXbE--

	*EncType | Method*

	application/json | GET

	*`Request`*
	{

		"access-token"
	}

	*`Response`*
	{
		{
		  "code": 10000,
		  "msg": "成功",
		  "data": {
			"currency": "6666666"
		  }
		}
	}


#### 百科发帖
*`URI`*
	http://www.520m.com.cn/api/question/add-encyclopedias?access-token=ZXUzL4jwA1SPaJ7oDROCqmRO_-lXbE--

	application/json | POST

	*`Request`*
	{

		"title"：标题
		"content":内容
		"reward":金豆
		"img":图片(1张)
	}

	*`Response`*
	{
		{
		  "code": 10000,
		  "msg": "成功",
		  "data": null
		}
	}


#### 百科详情

	*`URI`*
	http://www.520m.com.cn/api/register/encyclopedias-list-id?id=133
	
	*EncType | Method*

	application/json | GET

	*`Request`*
	{
		id:文章id
	}

	*`Response`*
	{
		{
		  "code": 10000,
		  "msg": "成功",
		  "data": {
			"imgs": "user_5807189a08621.jpg",
			"username": "小白",
			"grade": "3",
			"id": "133",
			"title": "hello world",
			"reward": "0",
			"img": [
			  "http://peita.oss-cn-beijing.aliyuncs.com/question/515431487932201.jpg",
			  "http://peita.oss-cn-beijing.aliyuncs.com/question/415371487932201.jpg"
			],
			"content": "阿萨德法国红酒快乐",
			"reward_status": "3",
			"share_num": "0",
			"create_time": "1487932201",
			"tags": [
			  "耳朵",
			  "皮毛"
			],
			"reply_num": "0"
		  }
		}
	}


#### 百科标签查询
*`URI`*
	http://www.520m.com.cn/api/register/tag-sele?tag=2

	*EncType | Method*

	application/json | GET

	*`Request`*
	{
		"tag":标签类型
		1.耳朵2.眼睛3.皮毛4.肩高5.肠胃6.鼻子7.嘴巴8.四肢9.体型10.排泄11.疾病12.品种13.预防14.血统15.训练16.喂养17.历史18.最新
	}

	*`Response`*
	{
		{
		  "code": 10000,
		  "msg": "成功",
		  "data": {
			"pagedata": [
			  {
				"imgs": "user_57ff54cf6a1e7.jpg",
				"username": "Seven的霸霸",
				"grade": "1",
				"id": "134",
				"title": "测试2",
				"reward": "0",
				"create_time": "1487932228",
				"reply_num": "0"
			  }
			],
			"query": {
			  "countpage": 1,
			  "page": 1,
			  "up": "http://www.520m.com.cn/api/question/tag-sele?access-token=ZXUzL4jwA1SPaJ7oDROCqmRO_-lXbE--&tag=2&page=1",
			  "next": ""
			}
		  }
		}
	}


#### 趣闻评论
*`URI`*
	http://www.520m.com.cn/api/question/journalism-comments?access-token=ZXUzL4jwA1SPaJ7oDROCqmRO_-lXbE--

*EncType | Method*

	application/json | POST

	*`Request`*
	{
		"jid":文章id
		"to_user_id":被评论人id（如果没有传空）
		"content":内容
	}

	*`Response`*
	{
		{
		  "code": 10000,
		  "msg": "成功",
		  "data": null
		}
	}


#### 趣闻评论列表
	*`URI`*
	http://www.520m.com.cn/api/register/journalism-comments-lists?jid=398


	*EncType | Method*

	application/json | GET

	*`Request`*
	{
		"page":分页
		"jid":文章id
	}

	*`Response`*
	{
		{
		  "code": 10000,
		  "msg": "成功",
		  "data": {
			"pagedata": [
			  {
				"imgs": "user_584fb5033a5d4.jpg",
				"username": "小黑爸爸",
				"grade": "6",
				"from_user_id": "100165",
				"to_user_id": null,
				"content": "趣闻评论测试",
				"created_at": "1488187693",
				"to_user_name": null
			  },
			  {
				"imgs": "user_57ff54cf6a1e7.jpg",
				"username": "Seven的霸霸",
				"grade": "1",
				"from_user_id": "100161",
				"to_user_id": null,
				"content": "趣闻评论测试22222",
				"created_at": "1488187730",
				"to_user_name": null
			  },
			  {
				"imgs": "user_584fb5033a5d4.jpg",
				"username": "小黑爸爸",
				"grade": "6",
				"from_user_id": "100165",
				"to_user_id": "100161",
				"content": "被评论人也就是回复测试",
				"created_at": "1488189619",
				"to_user_name": "Seven的霸霸"
			  }
			],
			"query": {
			  "countpage": 1,
			  "page": 1,
			  "up": "http://www.520m.com.cn/api/question/journalism-comments-lists?access-token=ZXUzL4jwA1SPaJ7oDROCqmRO_-lXbE--&jid=398&page=1",
			  "next": ""
			}
		  }
		}
	}


#### 百科评论

	*`URI`*
	http://www.520m.com.cn/api/question/encyclopedias-comments-add?access-token=ZXUzL4jwA1SPaJ7oDROCqmRO_-lXbE--
	
	*EncType | Method*

	application/json | POST

	*`Request`*
	{
		"encyclopedias_id":百科id
		"to_user_id":被评论人id（没有传空）
		"content":内容
	}

	*`Response`*
	{
		"code": 10000,
		"msg": "成功",
		"data": null
	}


#### 百科评论列表

	*`URI`*
	http://www.520m.com.cn/api/register/encyclopedias-comments-list?encyclopedias_id=155


	application/json | GET

	*`Request`*
	{
		"encyclopedias_id":百科id
	}

	*`Response`*
	{
		{
		  "code": 10000,
		  "msg": "成功",
		  "data": {
			"pagedata": [
			  {
				"imgs": "user_584fb5033a5d4.jpg",
				"username": "小黑爸爸",
				"grade": "6",
				"id": "37",
				"from_user_id": "100165",
				"to_user_id": null,
				"content": "百科评论测试1",
				"created_time": "1488267891",
				"to_user_name": "",
				"from_user_grade": "6",
				"create_time": "15天前",
				"isgood": "1"
			  },
			  {
				"imgs": "user_57ff54cf6a1e7.jpg",
				"username": "Seven的霸霸",
				"grade": "3",
				"id": "38",
				"from_user_id": "100161",
				"to_user_id": null,
				"content": "百科评论测试2",
				"created_time": "1488267914",
				"to_user_name": "",
				"from_user_grade": "3",
				"create_time": "15天前",
				"isgood": "2"
			  },
			  {
				"imgs": "user_584fb5033a5d4.jpg",
				"username": "小黑爸爸",
				"grade": "6",
				"id": "39",
				"from_user_id": "100165",
				"to_user_id": "100161",
				"content": "百科评论回复测试",
				"created_time": "1488267939",
				"to_user_name": "Seven的霸霸",
				"from_user_grade": "6",
				"create_time": "15天前",
				"isgood": "2"
			  },
			  {
				"imgs": "user_58afdcafaf619.jpg",
				"username": "Jejahjah",
				"grade": "3",
				"id": "47",
				"from_user_id": "100167",
				"to_user_id": "100165",
				"content": "[好][好][好]",
				"created_time": "1488366782",
				"to_user_name": "小黑爸爸",
				"from_user_grade": "3",
				"create_time": "13天前",
				"isgood": "2"
			  },
			  {
				"imgs": "user_5807189a08621.jpg",
				"username": "小白",
				"grade": "3",
				"id": "56",
				"from_user_id": "100158",
				"to_user_id": "100165",
				"content": "哈哈啦啦",
				"created_time": "1489375717",
				"to_user_name": "小黑爸爸",
				"from_user_grade": "3",
				"create_time": "2天前",
				"isgood": "2"
			  },
			  {
				"imgs": "user_5807189a08621.jpg",
				"username": "小白",
				"grade": "3",
				"id": "57",
				"from_user_id": "100158",
				"to_user_id": null,
				"content": "你好长",
				"created_time": "1489375727",
				"to_user_name": "",
				"from_user_grade": "3",
				"create_time": "2天前",
				"isgood": "2"
			  },
			  {
				"imgs": "user_5807189a08621.jpg",
				"username": "小白",
				"grade": "3",
				"id": "58",
				"from_user_id": "100158",
				"to_user_id": null,
				"content": "邋遢",
				"created_time": "1489385897",
				"to_user_name": "",
				"from_user_grade": "3",
				"create_time": "2天前",
				"isgood": "2"
			  }
			],
			"query": {
			  "countpage": 1,
			  "page": 1,
			  "up": "http://www.520m.com.cn/api/register/encyclopedias-comments-list?encyclopedias_id=155&page=1",
			  "next": ""
			}
		  }
		}
	}



#### 百科设置最佳回复

	*`URI`*
	http://www.520m.com.cn/api/question/encyclopedias-good?access-token=dnWk7syyyc5oT7vSd_BtSA8R8w1xFpL9
	*EncType | Method*

	application/json | POST

	*`Request`*
	{
		"encyclopedias_id":百科文章id
		"comment_id":选定的评论id
	}

	*`Response`*
	{
		"code": 10000,
		"msg": "设定成功"
	}

	有防止重复设定：
	{
	  "code": 20001,
	  "msg": "已经设定"
	}



#### 百科标题搜索
	
	*`URI`*
	http://www.520m.com.cn/api/register/encyclopedias-title

	*EncType | Method*

	application/json | POST

	*`Request`*
	{
		"title":标题内容
	}

	*`Response`*
	{
		{
		  "code": 10000,
		  "msg": "成功",
		  "data": {
			"pagedata": [
			  {
				"imgs": "user_584fb5033a5d4.jpg",
				"username": "小黑爸爸",
				"grade": "6",
				"id": "156",
				"title": "猪到底是不是猪",
				"reward": "5",
				"create_time": "1488011503",
				"reply_num": "0",
				"good_id": null,
				"good_content": null
			  },
			  {
				"imgs": "user_584fb5033a5d4.jpg",
				"username": "小黑爸爸",
				"grade": "6",
				"id": "155",
				"title": "猪到底是不是猪",
				"reward": "0",
				"create_time": "1488011501",
				"reply_num": "0",
				"good_id": "37",
				"good_content": "百科评论测试1"
			  }
			],
			"query": {
			  "countpage": 1,
			  "page": 1,
			  "up": "http://www.520m.com.cn/api/question/encyclopedias-title?access-token=dnWk7syyyc5oT7vSd_BtSA8R8w1xFpL9&page=1",
			  "next": ""
			}
		  }
		}
	}


#### 常见问题列表
	*`URI`*
	http://www.520m.com.cn/api/question/common-problem-lists?access-token=HekaiHQVDEAJ278AZ_5r7w483c7rFDr5
	
	*EncType | Method*

	application/json | GET

	*`Request`*
	{
		
	}

	*`Response`*
	{
		  "code": 10000,
		  "msg": "成功",
		  "data": {
			"pagedata": [
			  {
				"id": "19",
				"title": "如何链接链接蓝牙铃铛？"
			  },
			  {
				"id": "18",
				"title": "为什么发布问答看不到？"
			  },
			  {
				"id": "17",
				"title": "上传视频很慢怎么办？"
			  },
			  {
				"id": "16",
				"title": "如何在地图上隐藏自己？"
			  },
			  {
				"id": "15",
				"title": "地图内如何聊天？"
			  },
			  {
				"id": "14",
				"title": "地图组队功能怎么用？"
			  }
			],
			"query": {
			  "countpage": 3,
			  "page": 1,
			  "up": "http://www.520m.com.cn/api/question/common-problem-lists?access-token=HekaiHQVDEAJ278AZ_5r7w483c7rFDr5&page=1",
			  "next": "http://www.520m.com.cn/api/question/common-problem-lists?access-token=HekaiHQVDEAJ278AZ_5r7w483c7rFDr5&page=2"
			}
		  }
	}

#### 常见问题详情

	*`URI`*
	http://www.520m.com.cn/api/question/common-problem-id?access-token=HekaiHQVDEAJ278AZ_5r7w483c7rFDr5&id=16

	*EncType | Method*

	application/json | GET

	*`Request`*
	{
		"id":常见问题id
	}

	*`Response`*
	{
		  "code": 10000,
		  "msg": "成功",
		  "data": {
			"id": "16",
			"title": "如何在地图上隐藏自己？",
			"content": "点击底边分类栏里面的互动按钮，进入地图模式，左侧第三个按钮可以开启或关闭您的地图位置，关闭地图位置后任何人都不会看到您的所在位置。",
			"create_time": "1488965791",
			"update_time": "1488965791"
		  }
	}


#### 我的百科

	*`URI`*
	http://www.520m.com.cn/api/question/my-baike?access-token=HekaiHQVDEAJ278AZ_5r7w483c7rFDr5
	
	*EncType | Method*

	application/json | GET

	*`Request`*
	{
		"token":用户token
		"status":状态码(1.通过2.待审核3.已拒绝4.我回复的)
	}


	这是1、2、3状态返回的格式

	*`Response`*
	{
		  "code": 10000,
		  "msg": "成功",
		  "data": {
			"pagedata": [
			  {
				"imgs": "user_584fb5033a5d4.jpg",   //头像
				"username": "小黑爸爸",     //昵称
				"grade": "6",    //等级
				"id": "158",   //百科文章id
				"title": "猪到底是不是猪",   //标题
				"reward": "5",   //奖励
				"create_time": "1488167881",     //创建时间
				"reply_num": "0",   //回复数
				"good_id": null,   //最佳评论id
				"content_status": "2",   //文章状态 1.采纳  2.未采纳
				"good_content": null,  //最佳回复内容
				"from_user_grade": "6"    //发表百科的用户的等级
			  },
			  {
				"imgs": "user_584fb5033a5d4.jpg",
				"username": "小黑爸爸",
				"grade": "6",
				"id": "156",
				"title": "猪到底是不是猪",
				"reward": "5",
				"create_time": "1488011503",
				"reply_num": "0",
				"good_id": null,
				"content_status": "1",
				"good_content": null,
				"from_user_grade": "6"
			  },
			  {
				"imgs": "user_584fb5033a5d4.jpg",
				"username": "小黑爸爸",
				"grade": "6",
				"id": "155",
				"title": "猪到底是不是猪",
				"reward": "0",
				"create_time": "1488011501",
				"reply_num": "0",
				"good_id": "37",
				"content_status": "1",
				"good_content": "百科评论测试1",
				"from_user_grade": "6"
			  },
			  {
				"imgs": "user_584fb5033a5d4.jpg",
				"username": "小黑爸爸",
				"grade": "6",
				"id": "154",
				"title": "猪到底是不是猪",
				"reward": "5",
				"create_time": "1488011498",
				"reply_num": "0",
				"good_id": null,
				"content_status": "2",
				"good_content": null,
				"from_user_grade": "6"
			  }
			],
			"query": {
			  "countpage": 1,
			  "page": 1,
			  "up": "http://www.520m.com.cn/api/question/my-baike?access-token=HekaiHQVDEAJ278AZ_5r7w483c7rFDr5&page=1",
			  "next": ""
			}
		  }
	}


	这是状态4返回的格式
	{
	  "code": 10000,
	  "msg": "成功",
	  "data": {
		"pagedata": [
		  {
			"id": "151",
			"encyclopedias_id": "187",
			"content": "！！",
			"created_time": "6天前",
			"title": "测试"
		  },
		  {
			"id": "148",
			"encyclopedias_id": "181",
			"content": "？？？？？？？",
			"created_time": "11天前",
			"title": "这是表情"
		  },
		  {
			"id": "147",
			"encyclopedias_id": "183",
			"content": "呵呵哈哈哈",
			"created_time": "11天前",
			"title": "好几家"
		  },
		  {
			"id": "55",
			"encyclopedias_id": "133",
			"content": "写的蛮不错的",
			"created_time": "18天前",
			"title": "hello world"
		  },
		  {
			"id": "39",
			"encyclopedias_id": "155",
			"content": "百科评论回复测试",
			"created_time": "28天前",
			"title": "猪到底是不是猪"
		  },
		  {
			"id": "37",
			"encyclopedias_id": "155",
			"content": "百科评论测试1",
			"created_time": "28天前",
			"title": "猪到底是不是猪"
		  }
		],
		"query": {
		  "countpage": 1,
		  "page": 1,
		  "up": "http://www.520m.com.cn/api/question/my-baike?access-token=Y-5h2kDHe0DmZuxbpngx0dzHRbHrraAC&status=4&page=1",
		  "next": ""
		}
	  }
	}


#### 百科标签列表
	
	*`URI`*
	http://www.520m.com.cn/api/register/baike-search-tags

	*EncType | Method*

	application/json | GET

	*`Request`*
	{
		
	}

	*`Response`*
	{
		  {
			  "code": 10000,
			  "msg": "成功",
			  "data": {
				"list": [
				  {
					"tag": "历史"
				  },
				  {
					"tag": "测试1"
				  },
				  {
					"tag": "肠胃"
				  },
				  {
					"tag": "测试"
				  },
				  {
					"tag": "耳朵"
				  },
				  {
					"tag": "排泄"
				  },
				  {
					"tag": "嘴巴"
				  }
				]
			  }
			}
	}


#### 趣闻标题搜索
	*`URI`*
	http://www.520m.com.cn/api/register/journalism-title-search
	
	*EncType | Method*

	application/json | POST

	*`Request`*
	{
		"title":标题
	}

	*`Response`*
	{
		  "code": 10000,
		  "msg": "成功",
		  "data": {
			"pagedata": [
			  {
				"jid": "603",
				"title": "刚起床就听到哈士奇在呼救，以为出了啥事，结果过去一看当场笑哭",
				"author": "萌宠也逗逼 ",
				"create_time": "8天前",
				"coment_num": "2",
				"video": null,
				"browse_num": "437",
				"img": [
				  "http://peita.oss-cn-beijing.aliyuncs.com/question/464671488953031.jpg",
				  "http://peita.oss-cn-beijing.aliyuncs.com/question/940291488953031.jpg",
				  "http://peita.oss-cn-beijing.aliyuncs.com/question/178201488953031.jpg",
				  "http://peita.oss-cn-beijing.aliyuncs.com/question/229361488953031.jpg"
				]
			  }
			],
			"query": {
			  "countpage": 1,
			  "page": 1,
			  "up": "http://www.520m.com.cn/api/register/journalism-title-search&page=1",
			  "next": ""
			}
		  }
	}


#### 趣闻标签列表

	*`URI`*

	http://www.520m.com.cn/api/register/journalism-tags-log


	*EncType | Method*

	application/json | GET

	*`Request`*
	{
		
	}

	*`Response`*
	{
		  "code": 10000,
		  "msg": "成功",
		  "data": {
			"list": [
			  {
				"tag": "感人"
			  },
			  {
				"tag": "搞笑"
			  },
			  {
				"tag": "汪星人"
			  },
			  {
				"tag": "生活"
			  }
			]
		  }
	}


#### 蓝牙升级判断

	*`URI`*
	http://www.520m.com.cn/api/question/is-bluetooth-upgrade?access-token=zZ1sr4Spb2k57KekPz0sVIakCmEQwIRV&CurrentEdition=v_3.0.0.9

	*EncType | Method*

	application/json | GET

	*`Request`*
	{
		"access-token"
		"CurrentEdition":当前蓝牙的版本号
	}

	*`Response`*(参数错误的返回)
	{
		 "code": 20001,
		 "msg": "参数不能为空"
	}

	*`Response`*(版本号一致的返回)
	{
		 "code": 20001,
		 "msg": "已更新到最新版本"
	}

	*`Response`*(有新版本需要更新)
	{
		  "code": 10000,
		  "msg": "成功",
		  "data": {
			"id": 1,
			"edition": "v_3.0.0.9",
			"upgrade_file": "http://peita.oss-cn-beijing.aliyuncs.com/question/377721490166493.img"
		  }
	}


#### 闪屏管理(随机一张图片)

	*`URI`*
	http://www.520m.com.cn/api/register/push-screen

	*EncType | Method*

	application/json | GET

	(没有token)
	{
	  "code": 10000,
	  "msg": "成功",
	  "data": {
		"list": {
		  "id": 3,
		  "img": "http://peita.oss-cn-beijing.aliyuncs.com/question/892941490341280.jpg"
		}
	  }
	}

	(有token不是体验官)
	{
	  "code": 10000,
	  "msg": "普通用户"
	}

	(有token是体验官)
	{
	  "code": 10000,
	  "msg": "成功",
	  "data": {
		"list": {
		  "id": 3,
		  "img": "http://peita.oss-cn-beijing.aliyuncs.com/question/892941490341280.jpg"
		}
	  }
	}


#### 宠物当天的体能表查询

	*`URI`*
	http://www.520m.com.cn/api/question/taday-pet-energy?access-token=Y-5h2kDHe0DmZuxbpngx0dzHRbHrraAC&time=2016-11-8

	*`Request`*
	{
		"access-token"
		"time":时间
	}

	*EncType | Method*

	application/json | GET

	{
		"energy_id": 200,
		"time": "2016-11-8",
		"run": 3,
		"go": 3,
		"jump": 3,
		"sleeping": 3,
		"pet_id": 1
	  }


#### 分享内容详情

	*`URI`*
	http://www.520m.com.cn/api/register/question-id-info?question_id=502

	*`Request`*
	{
		"question_id":问答id
	}

	*EncType | Method*

	application/json | GET

	{
	  "code": 10000,
	  "msg": "成功",
	  "data": {
		"id": "502",
		"img": "http://peita.oss-cn-beijing.aliyuncs.com/question/567071490941758.png",
		"problem": "关于狗狗在怀孕期和哺乳期的饮食哪项正确？",
		"answer_one": "碳水化合物是必须的",
		"answer_two": "蛋白质一定要充足",
		"answer_three": "让它多喝水",
		"answer_four": "以上都正确",
		"answer_true": "蛋白质一定要充足",
		"fraction": "5",
		"tcount": "0",
		"fcount": "0",
		"up_count": "2",     上
		"lower_count": "0",  下
		"left_count": "0",   左
		"right_count": "0"   右
	  }
	}

#### 问答分享入库
	*`URI`*
	http://www.520m.com.cn/api/register/add-question-share?question_id=502&user_id=100165

	*`Request`*
	{
		"question_id":问答id
		"user_id":用户id
	}

	*EncType | Method*

	application/json | GET

	{
	  "code": 10000,
	  "msg": "成功",
	  "data": null
	}


#### 分享以后外部用户答题统计
	
	*`URI`*
	http://www.520m.com.cn/api/register/answer-true-count?question_id=502&user_id=100165&direction=1

	*`Request`*
	{
		"question_id":问答id
		"user_id":用户id
		"direction":1上 2下 3左 4右
	}

	*EncType | Method*

	application/json | GET

	{
	  "code": 10000,
	  "msg": "成功",
	  "data": null
	}


#### 我的百科删除
	
	*`URI`*
	http://www.520m.com.cn/api/question/my-baike-dele?access-token=l3cq0R_rKEXdAXIS7qDc8S3OfvB8LBoT&id=6

	*`Request`*
	{
		"access-token"
		"id":百科自增id
	}

	*EncType | Method*

	application/json | GET

	{
	  "code": 10000,
	  "msg": "成功",
	  "data": null
	}


#### 二维码给宠物添加蓝牙设备

	*`URI`*

	http://www.520m.com.cn/api/pet/bluetooth?ak=OTAzMTY3Nzl=A1&pet_id=100470&access-token=sWspJfWTe8h7YpZtLFDV9WbBtopaKMXj


	*EncType | Method*

	application/json | GET

	*`Request`*
	{
	"ak",
	"pet_id",
	"access-token"
	}

	*`Response`*
	{
    "code": 10000,
    "msg": "成功",
    "data": null
	}


#### 解除绑定蓝牙

	*`URI`*

	http://www.520m.com.cn/api/pet/remove-binding?healthy_id=72&pet_id=100477&access-token=YWdqPCWdt3_IqkrTK-U5vS458ZWfcdeT

	*EncType | Method*

	application/josn | GET


	*`Request`*
	{
	"healthy_id",
	"pet_id",
	"access-token"
	}

	*`Response`*
	{
    "code": 10000,
    "msg": "成功",
    "data": null
	}


#### 绑定MAC地址

	*`URI`*

	http://www.520m.com.cn/api/pet/binding-mac?healthy_id=72&pet_id=100477&mac=07-16-76-00-02-86&access-token=YWdqPCWdt3_IqkrTK-U5vS458ZWfcdeT

	*EncType | Method*

	application/josn | GET

	*`Request`*
	{
	"healthy_id",
	"pet_id",
	"mac",
	"access-token"
	}

	*`Response`*
	{
    "code": 10000,
    "msg": "成功",
    "data": null
	}


#### 判断MAC地址是否存在

	*`URI`*

	http://www.520m.com.cn/api/pet/is-mac?mac=07-16-76-00-02-86&access-token=YWdqPCWdt3_IqkrTK-U5vS458ZWfcdeT
	
	*EncType | Method*

	application/josn | GET

	*`Request`*
	{
	"mac",
	"access-token"
	}

	{
    "code": 10000,
    "msg": "成功",
    "data": {
        "pet_name": "小黑",
        "hardware_name": "蓝牙",
        "hardware_color": "白色"
    }
	}

#### 每个用户的蓝牙铃铛历史绑定记录

	*`URI`*

	http://www.520m.com.cn/api/pet/history-binding?access-token=YWdqPCWdt3_IqkrTK-U5vS458ZWfcdeT
	
	*EncType | Method*

	application/josn | GET

	*`Request`*
	{
	"access-token"
	}

	{
    "code": 10000,
    "msg": "成功",
    "data": [
        {
            "healthy_id": "71",
            "pet_name": "小黑",
            "hardware_name": "蓝牙铃铛",
            "hardware_color": "粉色",
            "remove_binding": "1478490900"
        },
        {
            "healthy_id": "72",
            "pet_name": "小黑",
            "hardware_name": "蓝牙铃铛",
            "hardware_color": "黑色",
            "remove_binding": "1478504503"
        }
    ]
}


#### 历史绑定设备重新激活

	*`URI`*

	http://www.520m.com.cn/api/pet/activation?healthy_id=71&access-token=YWdqPCWdt3_IqkrTK-U5vS458ZWfcdeT
	
	*EncType | Method*

	application/josn | GET

	*`Request`*
	{
	"healthy_id",
	"access-token"
	}

#### 如果已经激活会返回
{
    "code": 20001,
    "msg": "操作失败",
    "data": {
        "bluetooth_id": "已经执行激活操作"
    }
}

#### 如果正常返回
{
    "code": 10000,
    "msg": "成功",
    "data": null
}


#### 体能日志添加

	*`URI`*

	http://www.520m.com.cn/api/pet/energy-add?access-token=YWdqPCWdt3_IqkrTK-U5vS458ZWfcdeT
	
	*EncType | Method*

	application/josn | POST

	*`Request`*
	{
	'time':'2016-11-8',
	'run':'123',
	'go':'456',
	'jump':'789',
	'sleeping':'12345',
	'pet_id':'123'
	}

	*`Response`*
	{
    "code": 10000,
    "msg": "成功",
    "data": null
	}


#### 体能日志返回列表

	*`URI`*

	http://www.520m.com.cn/api/pet/energy-list?pet_id=123&access-token=YWdqPCWdt3_IqkrTK-U5vS458ZWfcdeT
	
	*EncType | Method*

	application/josn | GET

	*`Request`*
	{
	'pet_id':'100477'，
	'access-token'
	}

	*`Response`*
	{
    "code": 10000,
    "msg": "成功",
    "data": {
        "healthy": "99",
        "love": "88",
        "motion": "89",
        "social": "77",
        "neat": "67",
        "week": [
            {
                "time": "2016-11-8",
                "run": "123",
                "go": "21",
                "jump": "1234",
                "sleeping": "1234"
            },
            {
                "time": "2016-11-7",
                "run": "123",
                "go": "21",
                "jump": "1234",
                "sleeping": "1234"
            },
            {
                "time": "2016-11-6",
                "run": "123",
                "go": "21",
                "jump": "1234",
                "sleeping": "1234"
            },
            {
                "time": "2016-11-5",
                "run": "123",
                "go": "21",
                "jump": "1234",
                "sleeping": "1234"
            },
            {
                "time": "2016-11-4",
                "run": "123",
                "go": "21",
                "jump": "1234",
                "sleeping": "1234"
            },
            {
                "time": "2016-11-3",
                "run": "123",
                "go": "21",
                "jump": "1234",
                "sleeping": "1234"
            },
            {
                "time": "2016-11-2",
                "run": "123",
                "go": "21",
                "jump": "1234",
                "sleeping": "1234"
            }
        ]
    }
}



############################商家版##############################

####添加店铺

	*`URI`*

	http://test.520m.com.cn/api/shop/add-shop?access-token=YWdqPCWdt3_IqkrTK-U5vS458ZWfcdeT
	
	*EncType | Method*

	application/josn | POST

	*`Request`*
	{
		'in_city':'所在城市',
		'position':'位置',
		'detailed_address':'详细位置',
		'merchant_name':'商户名称',
		'merchant_type':'商户类型',
		'scope':'经营范围',
		'shopkeeper':'店铺联系人',
		'phone':'手机',
		'tel':'座机',
		'user_id':'用户id',
		'id_card':'身份证号码',
		'business_num':'营业执照号码',
		'uid':'地图店铺id',
		'lng':'经度',
		'lat':'纬度',
		'shop_introduce':'店铺介绍',
		'front':'门脸图片',
		'shop_image_one':'店铺环境图1',
		'shop_image_two':'店铺环境图2',
		'shop_image_three':'店铺环境图3',
		'shop_image_four':'店铺环境图4',
		'license_one':'营业执照图片'
	}

	*`Response`*
	{
		"code": 10000,
		"msg": "成功",
		"data": 12
	}

####根据id查看店铺详情
	*`URI`*

	http://test.520m.com.cn/api/shop/shop-id-find?access-token=-63TX3XhZG_JLFS3pFdLEsX0zINIeiYG&s_id=2
	
	*EncType | Method*

	application/josn | GET

	*`Response`*
	{
		"code": 10000,
		"msg": "成功",
		"data": {
		"s_id": 2,
		"in_city": "北京",
		"position": "昌平区",
		"detailed_address": "中滩村二街",
		"merchant_name": "尚美汇",
		"merchant_type": "企业商户",
		"scope": "其他",
		"shopkeeper": "xxx",
		"phone": "13299876657",
		"tel": "010-5233859",
		"front": "Uploads/2016-09-09/57d2435672df7.jpg",
		"shop_image_one": "Uploads/2016-09-09/57d2435678000.jpg",
		"shop_image_two": "Uploads/2016-09-09/57d243567b6b1.jpg",
		"shop_image_three": null,
		"shop_image_four": null,
		"license_one": "Uploads/2016-09-09/57d243567f14a.jpg",
		"status": 1,
		"time": "1473397590",
		"user_id": 1,
		"id_card": null,
		"business_num": "",
		"uid": null,
		"lng": 116.425,
		"lat": 40.0679,
		"shop_introduce": null
		}
	}


####用户的店铺列表
	*`URI`*

	http://test.520m.com.cn/api/shop/user-shop-lists?access-token=Fx3J9YjRJ1QXnaYAgs-8Uwafk8RyZvNW&user_id=123

	*EncType | Method*

	application/josn | GET

	*`Request`*
	{
		'user_id':'用户id'
	}

	*`Response`*
	{
		"code": 10000,
		"msg": "成功",
		"data": [
			{
				"merchant_name": "ewrwt",
				"front": "http://peita.oss-cn-beijing.aliyuncs.com/question/300801499305110.png",
				"shop_introduce": "的路费撒拉"
			},
			{
				"merchant_name": "ewrwt",
				"front": "http://peita.oss-cn-beijing.aliyuncs.com/question/504431499321967.png",
				"shop_introduce": "的路费撒拉"
			},
			{
				"merchant_name": "ewrwt",
				"front": "http://peita.oss-cn-beijing.aliyuncs.com/question/7381499322719.png",
				"shop_introduce": "的路费撒拉"
			}
		]
	}


####用户店铺审核进度

	*`URI`*

	http://test.520m.com.cn/api/shop/user-audit-schedule?access-token=Fx3J9YjRJ1QXnaYAgs-8Uwafk8RyZvNW&user_id=123

	*EncType | Method*

	application/josn | GET

	*`Request`*
	{
		'user_id':'用户id'
	}

	*`Response`*
	{
		"code": 10000,
		"msg": "成功",
		"data": [
			{
				"merchant_name": "ewrwt",
				"status": 1
			},
			{
				"merchant_name": "ewrwt",
				"status": 1
			},
			{
				"merchant_name": "ewrwt",
				"status": 1
			}
		]
	}



####修改店铺信息
	*`URI`*

	http://test.520m.com.cn/api/shop/shop-id-save?access-token=YWdqPCWdt3_IqkrTK-U5vS458ZWfcdeT

	*EncType | Method*

	application/josn | POST

	*`Request`*
	{
	's_id':'店铺自增id',
	'type':'类型'
		1=>'in_city':'所在城市',
		2=>'position':'位置',
		3=>'detailed_address':'详细位置',
		4=>'merchant_name':'商户名称',
		5=>'merchant_type':'商户类型',
		6=>'scope':'经营范围',
		7=>'shopkeeper':'店铺联系人',
		8=>'phone':'手机',
		9=>'tel':'座机',
		10=>'id_card':'身份证号码',
		11=>'business_num':'营业执照号码',
		12=>'shop_introduce':'店铺介绍',
		13=>'front':'门脸图片',
		14=>'shop_image_one':'店铺环境图1',
		15=>'shop_image_two':'店铺环境图2',
		16=>'shop_image_three':'店铺环境图3',
		17=>'shop_image_four':'店铺环境图4',
		18=>'license_one':'营业执照图片'
	
	}

	*`Response`*
	{
	"code": 10000,
	"msg": "成功",
	"data": 12
	}



####商家用户扫描二维码记录

	*`URI`*
	http://test.520m.com.cn/api/shop/shop-user-scan-code?access-token=YWdqPCWdt3_IqkrTK-U5vS458ZWfcdeT

	*EncType | Method*

	application/josn | POST

	*`Request`*
	{
		'user_id':'用户id'
		'ewm':'二维码链接'
	
	}

	*`Response`*
	{
	"code": 10000,
	"msg": "成功",
	"data": 1
	}


####首页广告

	*`URI`*
	http://test.520m.com.cn/api/shop/banner-lists?access-token=Fx3J9YjRJ1QXnaYAgs-8Uwafk8RyZvNW

	application/josn | GET

	*`Request`*
	{
		
	
	}

	*`Response`*
	{
		"code": 10000,
		"msg": "成功",
		"data": [
			{
				"id": 20,
				"img": "http://peita.oss-cn-beijing.aliyuncs.com/question/637791499396776.jpg",
				"html_url": "http://www.peita.net"
			},
			{
				"id": 21,
				"img": "http://peita.oss-cn-beijing.aliyuncs.com/question/587101499396787.jpg",
				"html_url": "http://www.peita.net"
			},
			{
				"id": 19,
				"img": "http://peita.oss-cn-beijing.aliyuncs.com/question/255591499396757.png",
				"html_url": "http://www.peita.net"
			}
		]
	}


####商家发布活动
	
	*`URI`*
	http://test.520m.com.cn/api/shop/add-activity?access-token=Fx3J9YjRJ1QXnaYAgs-8Uwafk8RyZvNW

	application/josn | GET

	*`Request`*
	{
		
		'title':标题
		'content':内容
		'start_time':开始时间（时间戳）
		'end_time':结束时间（时间戳）
		'person_num':人数
		'user_id':用户id
		'img'多张（键值可以用img1  img2  img3  等代替）
	}

	*`Response`*
	{
		"code": 10000,
		"msg": "成功",
		"data": 1
	}


####根据用户id查看活动列表

	*`URI`*
	http://test.520m.com.cn/api/shop/user-activity-lists?access-token=Fx3J9YjRJ1QXnaYAgs-8Uwafk8RyZvNW&user_id=12
	
	application/josn | GET

	*`Request`*
	{
		'user_id':用户id
	}

	*`Response`*
	{
		"code": 10000,
		"msg": "成功",
		"data": [
			{
				"ac_id": "1",
				"title": "活动标题",
				"content": "活动内容",
				"start_time": "13256555555",
				"end_time": "14688888888",
				"person_num": "50",
				"list_img": "question/520091499406930.jpg"
			},
			{
				"ac_id": "2",
				"title": "活动标题2",
				"content": "活动内容2",
				"start_time": "13256555555",
				"end_time": "14688888888",
				"person_num": "23",
				"list_img": "question/888841499408461.jpg"
			},
			{
				"ac_id": "3",
				"title": "活动标题3",
				"content": "活动内容3",
				"start_time": "13256555555",
				"end_time": "14688888888",
				"person_num": "58",
				"list_img": "question/60811499408469.jpg"
			}
		]
	}


####根据活动id查看活动详情

	*`URI`*
	http://test.520m.com.cn/api/shop/activity-id-info?access-token=Fx3J9YjRJ1QXnaYAgs-8Uwafk8RyZvNW&id=1

	application/josn | GET
	

	*`Request`*
	{
		'id':活动id
	}

	*`Response`*
	{
		"code": 10000,
		"msg": "成功",
		"data": {
			"ac_id": 1,
			"title": "活动标题",
			"content": "活动内容",
			"img": [
				"question/520091499406930.jpg",
				"question/64161499406931.png",
				"question/304911499406931.jpg"
			],
			"start_time": "13256555555",
			"end_time": "14688888888",
			"person_num": 50,
			"create_time": "1499406932",
			"user_id": 12
		}
	}

####修改活动

	*`URI`*
	http://test.520m.com.cn/api/shop/activity-id-save?access-token=Fx3J9YjRJ1QXnaYAgs-8Uwafk8RyZvNW

	application/josn | POST
	

	*`Request`*
	{
		'id':自增id
		'type':修改类型
			type=1  title:标题
			type=2  content:内容
			type=3  start_time:开始时间
			type=4  end_time:结束时间
			type=5  person_num:人数
			type=6  img:图片（拼接成字符串，需要组合原数据）
	}

	*`Response`*
	{
		"code": 10000,
		"msg": "成功",
		"data": 1
	}


####统一文件上传
	
	*`URI`*
	http://test.520m.com.cn/api/shop/up-file?access-token=Fx3J9YjRJ1QXnaYAgs-8Uwafk8RyZvNW

	application/josn | POST
	

	*`Request`*
	{
		'img':图片（可以是多张，键值就用img1 img2 img3 ...）
	}

	*`Response`*
	{
		"code": 10000,
		"msg": "成功",
		"data": "1.jpg,2.jpg,3.jpg"
	}
	


####添加活体

	*`URI`*
	http://test.520m.com.cn/api/shop/add-living?access-token=Fx3J9YjRJ1QXnaYAgs-8Uwafk8RyZvNW

	application/josn | POST
	

	*`Request`*
	{
		'img':图片（可以是多张，键值就用img1 img2 img3 ...）
		'month_birth':月龄
		'cate':品种
		'num'：库存
		'num_danger'：库存警戒值
		'price'：价格
		'get_price'：进价
		'user_id'：用户id
		'shop_id':店铺id
	}

	*`Response`*
	{
		"code": 10000,
		"msg": "成功",
		"data": 1
	}


####我发布的活体列表

	*`URI`*

	http://test.520m.com.cn/api/shop/my-living-lists?access-token=Fx3J9YjRJ1QXnaYAgs-8Uwafk8RyZvNW&user_id=12

	application/josn | GET
	

	*`Request`*
	{
		
		'user_id'：用户id
	}

	*`Response`*
	{
		"code": 10000,
		"msg": "成功",
		"data": [
			{
				"sl_img": "question/293681500023926.png",
				"cate": "二哈",
				"num": "5",
				"price": "1200",
				"merchant_name": "ewrwt"
			},
			{
				"sl_img": "question/383801500023958.png",
				"cate": "金毛",
				"num": "5",
				"price": "1200",
				"merchant_name": "ewrwt"
			}
		]
	}


####根据活体id查看详情

	*`URI`*

	http://test.520m.com.cn/api/shop/my-release-living-id-info?access-token=Fx3J9YjRJ1QXnaYAgs-8Uwafk8RyZvNW&sl_id=1


	*`Request`*
	{
		
		'sl_id'：活体id
	}

	*`Response`*
	{
		"code": 10000,
		"msg": "成功",
		"data": [
			{
				"sl_img": "question/293681500023926.png",
				"month_birth": "5",
				"cate": "二哈",
				"num": "5",
				"num_danger": "1",
				"price": "1200",
				"get_price": "800",
				"create_time": "1500023926",
				"is_show": "1",
				"merchant_name": "ewrwt"
			}
		]
	}


####修改活体

	*`URI`*
	http://test.520m.com.cn/api/shop/my-release-living-id-save?access-token=Fx3J9YjRJ1QXnaYAgs-8Uwafk8RyZvNW

	application/josn | POST
	

	*`Request`*
	{
		'sl_d':活体自增id
		'type':修改类型
			type=1  sl_img:图片（字符串）
			type=2  month_birth:月龄
			type=3  cate:品种
			type=4  num:库存
			type=5  num_danger:库存警戒值
			type=6  price:价格
			type=7  get_price:进价
			type=8  is_show:控制活体的上架和下架状态(1.上架2.下架)
			type=9  shop_id:店铺id
	}

	*`Response`*
	{
		"code": 10000,
		"msg": "成功",
		"data": 1
	}

####删除我发布的活体

	*`URI`*

	http://test.520m.com.cn/api/shop/my-release-living-id-del?access-token=Fx3J9YjRJ1QXnaYAgs-8Uwafk8RyZvNW

	application/josn | get
	

	*`Request`*
	{
		'sl_id':活体自增id
	}

	*`Response`*
	{
		"code": 10000,
		"msg": "成功",
		"data": null
	}

####删除我发布的活动

	*`URI`*

	http://test.520m.com.cn/api/shop/activity-id-del?access-token=Fx3J9YjRJ1QXnaYAgs-8Uwafk8RyZvNW

	application/josn | get
	

	*`Request`*
	{
		'ac_id':活动的自增id
	}

	*`Response`*
	{
		"code": 10000,
		"msg": "成功",
		"data": null
	}


####我发布的活体列表排序

	*`URI`*

	http://test.520m.com.cn/api/shop/my-release-living-lists-sort?access-token=Fx3J9YjRJ1QXnaYAgs-8Uwafk8RyZvNW&user_id=12

	application/josn | GET
	

	*`Request`*
	{
		
		'user_id'：用户id
		'type' 类型(1.月龄排序 2.品种排序)
	}

	*`Response`*
	{
		"code": 10000,
		"msg": "成功",
		"data": [
			{
				"sl_img": "question/293681500023926.png",
				"cate": "二哈",
				"num": "5",
				"price": "1200",
				"merchant_name": "ewrwt"
			},
			{
				"sl_img": "question/383801500023958.png",
				"cate": "金毛",
				"num": "5",
				"price": "1200",
				"merchant_name": "ewrwt"
			}
		]
	}

####代办狗证

	*`URI`*
	http://test.520m.com.cn/api/shop/release-agency?access-token=Fx3J9YjRJ1QXnaYAgs-8Uwafk8RyZvNW

	application/josn | POST
	

	*`Request`*
	{
		'img':图片（可以是多张，键值就用img1 img2 img3 ...）
		'technological_process':流程
		'price':办理费用
		'user_id'：用户id
	}

	*`Response`*
	{
		"code": 10000,
		"msg": "成功",
		"data": 1
	}

####代办狗证详情

	*`URI`*
	http://test.520m.com.cn/api/shop/release-agency-id-info?access-token=Fx3J9YjRJ1QXnaYAgs-8Uwafk8RyZvNW

	application/json | GET
	

	*`Request`*
	{
		'id'：自增id
	}

	*`Response`*
	{
		"code": 10000,
		"msg": "成功",
		"data": {
			"id": 1,
			"img": "question/11311500101480.png",
			"technological_process": "流程实例测试数据",
			"price": "500",
			"user_id": 12,
			"create_time": "1500101480"
		}
	}

####修改代办狗证

	*`URI`*

	http://test.520m.com.cn/api/shop/release-agency-id-save?access-token=Fx3J9YjRJ1QXnaYAgs-8Uwafk8RyZvNW

	application/json | POST
	

	*`Request`*
	{
		'id':自增id
		'type':
			1：img 图片
			2：technological_process 流程
			3: price 价格
	}

	*`Response`*
	{
		"code": 10000,
		"msg": "成功",
		"data": 1
	}

####添加商品

	*`URI`*

	http://test.520m.com.cn/api/shop/add-shop-goods?access-token=Fx3J9YjRJ1QXnaYAgs-8Uwafk8RyZvNW

	application/json | POST
	

	*`Request`*
	{
		'img':可以是多张
		'g_cate':品牌
		'g_num':库存
		'g_num_danger':库存警戒值
		'g_price':售价
		'g_get_price':进价
		'user_id':用户id
		'shop_id':店铺id
	}

	*`Response`*
	{
		"code": 10000,
		"msg": "成功",
		"data": 1
	}

####查看商品详情
	
*`URI`*

	http://test.520m.com.cn/api/shop/shop-goods-id-info?access-token=Fx3J9YjRJ1QXnaYAgs-8Uwafk8RyZvNW&g_id=1

	application/json | GET
	

	*`Request`*
	{
		'g_id':自增id
	}

	*`Response`*
	{
		{
			"code": 10000,
			"msg": "成功",
			"data": {
				"g_id": "1",
				"g_img": "question/276891500258777.png",
				"g_cate": "贝多美奶粉",
				"g_num": "100",
				"g_num_danger": "12",
				"g_price": "110",
				"g_get_price": "80",
				"user_id": "12",
				"create_time": "1500258777",
				"shop_id": "5",
				"merchant_name": "一号店铺"
			}
		}
	}


####修改商品信息

	*`URI`*

	http://test.520m.com.cn/api/shop/my-shop-goods-id-save?access-token=Fx3J9YjRJ1QXnaYAgs-8Uwafk8RyZvNW

	application/json | POST
	

	*`Request`*
	{
		'g_id':自增id
		'type':
			1：'img':可以是多张
			2：'g_cate':品牌
			3：'g_num':库存
			4：'g_num_danger':库存警戒值
			5：'g_price':售价
			6：'g_get_price':进价
			7：'shop_id':店铺id
			8：'g_is_show'：是否上架(1.上架2.下架)
	}

	*`Response`*
	{
		"code": 10000,
		"msg": "成功",
		"data": 1
	}


####商品列表
	
*`URI`*

	http://test.520m.com.cn/api/shop/my-shop-goods-lists?access-token=Fx3J9YjRJ1QXnaYAgs-8Uwafk8RyZvNW

	application/json | GET
	

	*`Request`*
	{
		'user_id':用户id  （必传）
		'type':            （可选）
			不传值 :默认ID升序
			1：库存升序
			2：价格升序
			3：价格降序
	}

	*`Response`*
	{
		"code": 10000,
		"msg": "成功",
		"data": [
			{
				"g_id": 1,
				"g_img": "question/276891500258777.png",
				"g_cate": "贝多美奶粉",
				"g_num": 500,
				"g_price": "200"
			},
			{
				"g_id": 2,
				"g_img": "question/935031500260138.jpg",
				"g_cate": "小博美专用成长奶粉",
				"g_num": 300,
				"g_price": "110"
			}
		]
	}


####删除商品信息

	*`URI`*

	http://test.520m.com.cn/api/shop/shop-goods-id-del?access-token=Fx3J9YjRJ1QXnaYAgs-8Uwafk8RyZvNW

	application/json | GET
	

	*`Request`*
	{
		'g_id':自增id
	}

	*`Response`*
	{
		"code": 10000,
		"msg": "成功",
		"data": null
	}

####添加银行卡

	*`URI`*
	http://test.520m.com.cn/api/shop/user-bind-bank-card?access-token=Fx3J9YjRJ1QXnaYAgs-8Uwafk8RyZvNW

	application/json | POST
	

	*`Request`*
	{
		`card_user` :持卡人姓名
		`card_num` ：银行卡号
		`card_type` ：持卡类型
		`opening_bank` ：开户行
		`telephone` ：手机号
		`user_id` ：用户id
	}

	*`Response`*
	{
		"code": 10000,
		"msg": "成功",
		"data": 1
	}


####银行卡列表
	
	*`URI`*
	http://test.520m.com.cn/api/shop/user-bind-bank-lists?access-token=-63TX3XhZG_JLFS3pFdLEsX0zINIeiYG&user_id=142

	application/json | GET
	
	*`Request`*  
	{
		`user_id` : 用户id
	}

	*`Response`*
	{
		"code": 10000,
		"msg": "成功",
		"data": [
			{
				"card_id": 1,
				"card_user": "借贷宝",
				"card_num": "6217000180001087455",
				"card_type": "建设银行-龙卡通-借记卡",
				"opening_bank": "建设银行",
				"telephone": "15510217700",
				"user_id": 142,
				"binding_time": "1501666838"
			},
			{
				"card_id": 2,
				"card_user": "加多宝",
				"card_num": "6217001245681248766",
				"card_type": "建设银行-龙卡通-借记卡",
				"opening_bank": "建设银行",
				"telephone": "13366200290",
				"user_id": 142,
				"binding_time": "1501666897"
			}
		]
	}



####删除银行卡

	*`URI`*
	http://test.520m.com.cn/api/shop/bank-info-del?access-token=Fx3J9YjRJ1QXnaYAgs-8Uwafk8RyZvNW

	application/json | GET
	

	*`Request`*
	{
		`card_id` :自增id
	}

	*`Response`*
	{
		"code": 10000,
		"msg": "成功",
		"data": null
	}
	




</xmp>

<script src="/Public/api/strapdown.js"></script>
</html>