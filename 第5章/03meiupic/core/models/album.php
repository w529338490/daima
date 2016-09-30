<?php


class album extends modelfactory{
    
    function get_all_album($page = NULL,$filter_private=false){
        if($filter_private){
            $where = 'private=0';
        }else{
            $where = '';
        }
        $this->db->select('#albums',"*",$where,'id desc');
        if($page){
            $pics = $this->db->toPage($page,PAGE_SET);
        }else{
            $pics = $this->db->getAll();
        }
        return $pics;
    }
    
    function get_albums_assoc($album_id = 0){
        $where = '';
        if($album_id>0){
            $where = 'id <> '.intval($album_id);
        }
        $this->db->select('#albums','id,name',$where);
        return $this->db->getAssoc();
    }
    
    function get_one_album($id){
        $this->db->select('#albums','*','id='.intval($id));
        return $this->db->getRow();
    }
    
    function get_cover($album_id,$cover_id = 0){
        $where = 'album='.intval($album_id).' and status=1';
        if($cover_id >0){
            $where .= ' and id='.intval($cover_id);
        }
        $this->db->select('#imgs',"*",$where,'id asc limit 1');
       $row = $this->db->getRow();
       if($row){
           return $row;
       }else{
           return false;
       }
    }
    
    function set_cover($id,$thumb){
        $this->db->update('#albums','id='.$id,array('cover'=>$thumb));
        return $this->db->query();
    }
    
    function get_album_name($id){
        $this->db->select('#albums',"name",'id='.intval($id));
        return $this->db->getOne();
    }
    
    function del_album($id){
        $this->db->delete('#imgs','album='.intval($id));
        $this->db->query();
        
        $this->db->delete('#albums','id='.intval($id));
        return $this->db->query();
    }
    
    function insert_album($arr){
        $this->db->insert('#albums',$arr);
        return $this->db->query();
    }
    
    function priv_album($id,$private){
        $this->db->update('#albums','id='.$id,array('private'=>$private));
        $ret = $this->db->query();
        if($this->db->affectedRows()){
            $this->db->update('#imgs','album='.$id,array('private'=>$private));
            $this->db->query();
        }
        return $ret;
    }
    
    function update_album($id,$name){
        $this->db->update('#albums','id='.$id,array('name'=>$name));
        return $this->db->query();
    }
    
    function remove_cover($picid){
        $this->db->update('#albums',"cover='".$picid."'",array('cover'=>'0'));
        return $this->db->query();
    }
}