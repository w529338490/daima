<?php
/*
����ɽ��Сѧ����칫��

*/

//[system]
$servername = 'localhost';   	                            // ���ݿ������
$dbusername = 'root';   		                              // ���ݿ��û���
$dbpassword = '1234';   		                                  // ���ݿ�����
$dbname = 'oa';		                                        // ���ݿ���

$charset = 'gbk';                                         //���ݿ��ַ�����
$tablepre = 'oa_';                                        // ����ǰ׺, ͬһ���ݿⰲװ���ϵͳ���޸Ĵ˴�
$dbservertype = 'mysql';		                              // �����޸Ĵ˴�
$usepconnect = '1';			                                  // ���ݿ����ӷ�ʽ 0=connect, 1=pconnect

$force_html = 'false';                                    //ǿ�Ƹ��� 
$showtime = '0';                                            //�Ƿ���ʾҳ��ִ��ʱ��
$admin_root='admin';                                      //����Ŀ¼
$rootpath = 'http://127.0.0.1/web/10oa';               //ϵͳ��Ŀ¼

$school_name = '����ɽ��Сѧ����칫��';                             //ѧУ����
$school_type = '2';                                         //ѧУ����1��Сѧ�棻2����ѧ�棻12��Сѧ������ѧУ��3�����а浫����û��ʵ��
$register_key = 'school';                                 //�����룬ע��ʱ��Ҫ
$style = 'test';                                          //��ǰ��ѡ���
$dellog_pass = '31';                                      //��̨��¼�Ͳ�����¼ɾ������

$sitename = '����ɽ��Сѧ';		                              //��վ����
$siteurl = '#';		                  //��վ��ַ
$sitemaster = '���С��';		                                 //��վվ������
$siteemail = 'shandao@fm.com';		                                      //��վվ������
$sitetitle = '����ɽ��Сѧ����칫��2011';		        // ��վ����
$sitedescription = '����ɽ��Сѧ����칫��';	                          // ��վ����
$sitekeywords = 'ѧУ��վ�����,ѧУoaϵͳ,ѧУ�칫'; // ��վ�ؼ���

$uppath = 'upfile/';                                           //�ļ��ϴ���Ŀ¼(�������/)
$uptemp=$uppath."temp/";                                     //�ļ��ϴ�����ʱĿ¼(�������/)
$MAX_FILE_SIZE = '100000000';                                     //�ļ��ϴ���С���� ��λ��b
$uptypes = 'jpg|bmp|png|gif|jpeg|txt|rar|jar|exe|xls|doc';                                               //�����ϴ��ļ�������

$perpage = '20';                                             // ��ҳ������
$pagenavpages = '5';                                           //ҳ�������
$strnum = '30';                                            // ������ʾ������
//set index
$outtypeids = '7,8,9,10';                                   // ��ҳ��Ϣ��ʾ��Ŀ
$class_subject_arr = '����,��ѧ,����,��ѧ,���,˼��,����,����,����,�ͼ�,����,����,ʵ���,��ϰ,����,�ۺ�';
$includepic_arr  = ',[ת��],[����],[�Ƽ�],[ע��],[����],[������]';

$ftp_ip = '10.56.20.10';                                      //����ip��ַ
$port = '21';                                                 //ftp�˿�
?>