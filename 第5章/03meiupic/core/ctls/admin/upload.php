<?php
/**
 * $Id: upload.php 83 2010-07-21 09:19:45Z lingter $
 * 
 * @author : Lingter
 * @support : http://www.meiu.cn
 * @copyright : (c)2010 meiu.cn lingter@gmail.com
 */

class controller extends adminpage{

    function controller(){
        parent::adminpage();
        $this->mdl_album = & load_model('album');
        $this->mdl_upload = & load_model('upload');
        $this->mdl_picture = & load_model('picture');
        $this->allow_img_type = 'jpg,jpeg,gif,png';
        
        if(!$this->auth->isLogedin()){
            redirect_c('default','login');
        }
        $this->output->set('current_nav','upload');
    }
    
    function index(){
        $this->output->set('albums_list',$this->mdl_album->get_all_album());
        $this->view->display('admin/upload_step1.php');
    }
    
    function step2(){
        $album_id = $this->getGet('album_id');
        if($album_id){
            $this->output->set('album_id',$album_id);
            $this->output->set('open_pre_resize',$this->setting['open_pre_resize']);
            $this->output->set('resize_img_width',$this->setting['resize_img_width']);
            $this->output->set('resize_img_height',$this->setting['resize_img_height']);
            $this->output->set('resize_quality',$this->setting['resize_quality']);
            $this->view->display('admin/upload_step2.php');
        }else{
            showInfo('非法参数:album_id不能为空！',false);
        }
    }
    
    function step2_1(){
        $album_id = $this->getGet('album_id');
        if($album_id){
            $this->output->set('album_id',$album_id);
            $this->view->display('admin/upload_step2_1.php');
        }else{
            showInfo('非法参数:album_id不能为空！',false);
        }
    }
    
    function process(){
        $this->mdl_upload->plupload();
    }
    
    function dopicupload(){
        $open_watermark = true;
        $watermark_path = ROOTDIR.'img/logo.png';
        $watermark_pos = 1;

        set_time_limit(0);
        $date = get_updir_name($this->setting['imgdir_type']);
        if(!is_dir(DATADIR.$date)){
            @mkdir(DATADIR.$date);
            @chmod(DATADIR.$date,0755);
        }
        
        $album_id = intval($this->getGet('album'));
        $album_arr = $this->mdl_album->get_one_album($album_id);
        $this->output->set('album',$album_id);
        if($album_arr){
            $photo_private = $album_arr['private'];
        }else{
            $photo_private = 1;
        }

        if($this->setting['demand_resize']){
            $pic_status = 1;
        }else{
            $pic_status = 3;
        }
        
        $empty_num = 0;
        
        foreach($_FILES['imgs']['name'] as $k=>$upfile){
            $tmpfile = $_FILES['imgs']['tmp_name'][$k];
            if (!empty($upfile)) {
                $filename = $upfile;
                $fileext = strtolower(end(explode('.',$filename)));
                if(!in_array($fileext,explode(',',$this->allow_img_type))){
                    showInfo('不支持的图片格式！',false);
                    exit;
                }
                if($_FILES['imgs']['size'][$k] > $this->setting['size_allow']){
                    showInfo('上传图片过大！不得大于'.$this->setting['size_allow'].'字节！',false);
                    exit;
                }
                $key = md5(str_replace('.','',microtime(true)).mt_rand(10,99));
                $realpath = ROOTDIR.mkImgLink($date,$key,$fileext,'orig');
                
                if(@move_uploaded_file($tmpfile,$realpath)){
                    $this->mdl_upload->addwater($realpath);
                    @chmod($realpath,0755);
                    $this->mdl_picture->insert_pic(array('album'=>$album_id,
                                                    'name'=>$filename,
                                                    'dir'=>$date,
                                                    'pickey'=>$key,
                                                    'ext'=>$fileext,
                                                    'author'=>$this->auth->getInfo('id'),
                                                    'create_time'=>time(),
                                                    'private' => $photo_private,
                                                    'status' => $pic_status
                                                    ));
                }else{
                    showInfo('文件上传失败！',false);
                    exit;
                }
            }else{
                $empty_num++;
            }
        }
        if($empty_num == count($_FILES['imgs']['name'])){
            showInfo('您没有选择图片上传，请重新上传！',false);
            exit;
        }
        $this->view->display('admin/upload_step3.php');
    }
    function doupload(){
        set_time_limit(0);
        $this->output->set('album',$this->getGet('album'));
        $this->_save_and_resize();

        $this->view->display('admin/upload_step3.php');
    }
    
    function _save_and_resize(){
        $tmp_dir = where_is_tmp();
        $targetDir =  $tmp_dir. DIRECTORY_SEPARATOR . "plupload";
        
        $album_id = intval($this->getGet('album'));
        $album_arr = $this->mdl_album->get_one_album($album_id);
        if($album_arr){
            $photo_private = $album_arr['private'];
        }else{
            $photo_private = 1;
        }
        
        $date = get_updir_name($this->setting['imgdir_type']);
        if(!is_dir(DATADIR.$date)){
            @mkdir(DATADIR.$date);
            @chmod(DATADIR.$date,0755);
        }

        if($this->setting['demand_resize']){
            $pic_status = 1;
        }else{
            $pic_status = 3;
        }

        $files_count = intval($this->getPost('flash_uploader_count'));
        for($i=0;$i<$files_count;$i++){
            $tmpfile = $targetDir . DIRECTORY_SEPARATOR . $this->getPost("flash_uploader_{$i}_tmpname");
            $filename = $this->getPost("flash_uploader_{$i}_name");
            $status =  $this->getPost("flash_uploader_{$i}_status");
            $fileext = strtolower(end(explode('.',$filename)));
            $key = md5(str_replace('.','',microtime(true)).mt_rand(10,99));
            $realpath = ROOTDIR.mkImgLink($date,$key,$fileext,'orig');
            if($status == 'done' && file_exists($tmpfile)){
                if(@copy($tmpfile,$realpath)){

                    $this->mdl_upload->addwater($realpath);

                    @chmod($realpath,0755);
                    $this->mdl_picture->insert_pic(array('album'=>$album_id,
                                                    'name'=>$filename,
                                                    'dir'=>$date,
                                                    'pickey'=>$key,
                                                    'ext'=>$fileext,
                                                    'author'=>$this->auth->getInfo('id'),
                                                    'create_time'=>time(),
                                                    'private' => $photo_private,
                                                    'status' => $pic_status
                                                    ));
                }
            }
        }
    }
    
    function reupload(){
        $id = intval($this->getGet('id'));
    
        $row = $this->mdl_picture->get_one_pic($id);
        if(!$row){
            echo '<script> top.reupload_alert("此照片不存在或已被删除!");</script>';
            exit;
        }
        if(empty($_FILES['imgs']['name'])){
            echo '<script> top.reupload_alert("请先选择要上传的图片!");</script>';
            exit;
        }
        
        $filename = $_FILES['imgs']['name'];
        $tmpfile = $_FILES['imgs']['tmp_name'];
        $fileext = strtolower(end(explode('.',$filename)));
        $oldext = $row['ext'];
        if($fileext != $oldext){
            echo '<script> top.reupload_alert("上传的文件的格式必须跟原图片一致!");</script>';
            exit;
        }
        if($_FILES['imgs']['size'] > $this->setting['size_allow']){
            echo '<script> top.reupload_alert("上传图片过大！不得大于'.$this->setting['size_allow'].'字节！");</script>';
            exit;
        }
        $realpath = ROOTDIR.mkImgLink($row['dir'],$row['pickey'],$row['ext'],'orig');
        
        $this->mdl_upload->delpicfile($row['dir'],$row['pickey'],$row['ext']);
        if(@move_uploaded_file($tmpfile,$realpath)){
            $this->mdl_upload->addwater($realpath);
            if(!$this->setting['demand_resize']){
                $this->mdl_upload->generatepic($row['dir'],$row['pickey'],$row['ext']);
            }
            @chmod($realpath,0755);
            echo '<script> top.reupload_ok("'.$id.'","'.mkImgLink($row['dir'],$row['pickey'],$row['ext'],'orig').'","'.mkImgLink($row['dir'],$row['pickey'],$row['ext'],'thumb').'");</script>';
        }else{
            echo '<script> top.reupload_alert("文件上传失败!");</script>';
        }
    }
}