<?php


require_once(LIBDIR.'view.class.php');
require_once(LIBDIR.'auth.class.php');
require_once(INCDIR.'pagecore.php');
class adminpage extends pagecore{
    
    function adminpage(){
        global $setting;
        $this->setting = $setting;
        $this->output =& get_output();
        $this->view = new View();
        $this->db =& db();
        $this->auth = new auth();
        
        $this->output->set('open_photo_setting',$this->setting['open_photo']);
    }
}