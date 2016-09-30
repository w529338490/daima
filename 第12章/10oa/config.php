<?php
/*
凤鸣山中小学网络办公室

*/

//[system]
$servername = 'localhost';   	                            // 数据库服务器
$dbusername = 'root';   		                              // 数据库用户名
$dbpassword = '1234';   		                                  // 数据库密码
$dbname = 'oa';		                                        // 数据库名

$charset = 'gbk';                                         //数据库字符编码
$tablepre = 'oa_';                                        // 表名前缀, 同一数据库安装多个系统请修改此处
$dbservertype = 'mysql';		                              // 不能修改此处
$usepconnect = '1';			                                  // 数据库连接方式 0=connect, 1=pconnect

$force_html = 'false';                                    //强制更新 
$showtime = '0';                                            //是否显示页面执行时间
$admin_root='admin';                                      //管理目录
$rootpath = 'http://127.0.0.1/web/10oa';               //系统根目录

$school_name = '凤鸣山中小学网络办公室';                             //学校名称
$school_type = '2';                                         //学校类型1：小学版；2：中学版；12中小学九年制学校；3：高中版但现在没有实现
$register_key = 'school';                                 //邀请码，注册时需要
$style = 'test';                                          //当前所选风格
$dellog_pass = '31';                                      //后台登录和操作记录删除密码

$sitename = '凤鸣山中小学';		                              //网站名称
$siteurl = '#';		                  //网站地址
$sitemaster = '大兵小将';		                                 //网站站长名称
$siteemail = 'shandao@fm.com';		                                      //网站站长邮箱
$sitetitle = '凤鸣山中小学网络办公室2011';		        // 网站标题
$sitedescription = '凤鸣山中小学网络办公室';	                          // 网站描述
$sitekeywords = '学校网站，软件,学校oa系统,学校办公'; // 网站关键词

$uppath = 'upfile/';                                           //文件上传的目录(后面加上/)
$uptemp=$uppath."temp/";                                     //文件上传的临时目录(后面加上/)
$MAX_FILE_SIZE = '100000000';                                     //文件上传大小限制 单位是b
$uptypes = 'jpg|bmp|png|gif|jpeg|txt|rar|jar|exe|xls|doc';                                               //允许上传文件的类型

$perpage = '20';                                             // 翻页文章数
$pagenavpages = '5';                                           //页面浏览数
$strnum = '30';                                            // 标题显示文字数
//set index
$outtypeids = '7,8,9,10';                                   // 首页信息显示栏目
$class_subject_arr = '语文,数学,外语,科学,社会,思想,政治,体育,美术,劳技,电脑,音乐,实践活动,自习,课外活动,综合';
$includepic_arr  = ',[转告],[紧急],[推荐],[注意],[换课],[公开课]';

$ftp_ip = '10.56.20.10';                                      //内网ip地址
$port = '21';                                                 //ftp端口
?>