<?php
/*
[F SCHOOL OA] F 校园网络办公系统 2009  php网络硬盘 2008
This is a freeware
Version: 2.2.1
Author: 浪子凡 (nbbufan@163.com)
Powered By:【凡·工作室】 (www.microphp.cn)
Last Modified: 2009/3/31 20:08
*/


 
    $tablepre = 'u_';                     // 表名前缀, 同一数据库安装多个系统请修改此处

   
    $rootpath = 'http://localhost/slcms/u';                        //插件系统根目录
   
    $uppath='upfile/'; //文件上传路径
    $style = 'test';                                                     //当前所选风格
    $maxsize = '3000000000';                                              //允许上传文件的最大值
    $notuptypes = '.php|.asp|.jsp|.cgi|.dll|.htm|.html';                 //禁止上传文件的类型
    $uptypes='.jpg|.jpeg|.txt|.doc|.xls|.bmp|.gif|.ppt|.rar|.zip|.exe|.mp3';
    $sitename = '网络u盘';		                                           // 网站名称  
    
    $sitetitle = '长江中学';		                                         // 网站标题
    $sitedescription = '凤鸣山中小学校网站';                          	// 网站描述
    $sitekeywords = '凤鸣山中学,学校网站,课件,教案,初中,软件,机器人';	  // 网站关键词
    $dirtype="1";//目录保存方式1：年/月/日;2:年/月;3:年;默认:直间存放
    $renamed="1";//是否重命名1表示重命名0表示用原来的文件名
    $overwrite="1";//是否覆盖1表示覆盖0表示不覆盖

?>