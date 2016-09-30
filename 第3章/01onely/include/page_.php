<?php
class Page{
    var $pagesize;
    var $numrows;
    var $pages;
    var $page;
    var $offset;
    var $url;
    function pagedate($str1,$str2,$str3){
        global $pagesize,$offset;
        $this->pagesize = $str1;
        $this->numrows = $str2;
        $this->url    = $str3;
        $this->pages    = intval($this->numrows/$this->pagesize);
        if($this->numrows%$this->pagesize){
            $this->pages ++;
        }
        $nPage = $_GET['page'];
        if($nPage != null && !preg_match("/^\d+$/",$nPage)){
            echo("错误的参数类型！");
            return false;
        }
        if(isset($nPage)){
            $this->page = intval($nPage);
        }
        else{
            $this->page = 1;
        }
        if($nPage < 1 || $nPage > $this->pages){
            $this->page = 1;
        }
        $this->offset = $this->pagesize * ($this->page - 1);
        $pagesize = $this->pagesize;
        $offset = $this->offset;
    }
    function pageshow(){
        echo "第[" . $this->page . "/" . $this->pages . "]页　";
        if($this->page > 4){
            echo "<a href='" . $this->url . "=1'><font style='font-family:Webdings;'>7</font></a>";
        }
        if($this->page != 1){
            $pageup = $this->page - 1;
            echo "<a href='" . $this->url . "=" . $pageup . "'><font style='font-family:Webdings;'>3</font></a>";
        }
        if($this->page <= 3){
            for($i = 1 ; $i <= 10 ; $i ++){
                if($i <= $this->pages){
                    if($i == $this->page){
                        echo "<span>".$i."</span>";
                    }
                    else{
                        echo "<a href='" . $this->url . "=" . $i . "'>" . $i . "</a>";
                    }
                }
            }
        }
        else if($this->page >= $this->pages-6){
            for($i = $this->pages-9 ; $i <= $this->pages ; $i ++){
                if($i == $this->page){
                    echo "<span>".$i."</span>";
                }
                else{
                    echo "<a href='" . $this->url . "=" . $i . "'>" . $i . "</a>";
                }
            }
        }
        else{
            for($i = $this->page-3 ; $i <= $this->page+6 ; $i ++){
                if($i == $this->page){
                    echo "<span>".$i."</span>";
                }
                else{
                    echo "<a href='" . $this->url . "=" . $i . "'>" . $i . "</a>";
                }
            }
        }
        if($this->page != $this->pages && $this->pages != 0){
            $pagedown = $this->page + 1;
            echo "<a href='" . $this->url . "=" . $pagedown . "'><font style='font-family:Webdings;'>4</font></a>";
        }
        if($this->page < $this->pages-6){
            echo "<a href='" . $this->url . "=" . $this->pages . "'><font style='font-family:Webdings;'>8</font></a>";
        }
    }
}
?>