<?php

class modelfactory{
    
    function modelfactory(){
        $this->output =& get_output();
        $this->db =& db();
    }
}