<?php
require_once '../login/login_check.php';
if($met_webhtm==1){

if($index=="index"){
if($met_index_type){
$fromurl=$met_weburl."/index.php?en=en";
$filename="../../index.htm";
createhtm($fromurl,$filename);
if($met_en_lang==1){
$fromurl=$met_weburl."/index.php?ch=ch";
$filename="../../index_ch.htm";
createhtm($fromurl,$filename);
}
}else{
$fromurl=$met_weburl."/index.php";
$filename="../../index.htm";
createhtm($fromurl,$filename);
if($met_en_lang==1){
$fromurl=$met_weburl."/index.php?en=en";
$filename="../../index_en.htm";
createhtm($fromurl,$filename);
}
}
okinfo('htm.php',$lang[htm]);
}

if($module==1){
    $folder=$db->get_one("select * from $met_column where id='$class1'");
    $query="select * from $met_column where foldername='$folder[foldername]'";
	$result= $db->query($query);
	while($list = $db->fetch_array($result)){
	$class_list[]=$list;
	}
if($en=="en"){
foreach($class_list as $key=>$val){
$fromurl=$met_weburl.$val[foldername]."/show.php?en=en&id=".$val[id];
$filename="../../".$val[foldername]."/".$val[filename]."_en.htm";
createhtm($fromurl,$filename);
}
}else{
foreach($class_list as $key=>$val){
$fromurl=$met_weburl.$val[foldername]."/show.php?id=".$val[id];
$filename="../../".$val[foldername]."/".$val[filename].".htm";
createhtm($fromurl,$filename);
}
}
okinfo('htm.php',$lang[htm]);
}

if($module==2){
    $folder=$db->get_one("select * from $met_column where id='$class1'");
    $query="select * from $met_news where class1='$class1'";
	$result= $db->query($query);
	while($list = $db->fetch_array($result)){
	$class_list[]=$list;
	}
if($en=="en"){
foreach($class_list as $key=>$val){
$fromurl=$met_weburl.$folder[foldername]."/shownews.php?&en=en&id=".$val[id];
$filename="../../".$folder[foldername]."/shownews".$val[id]."_en.htm";
createhtm($fromurl,$filename);
}
}else{
foreach($class_list as $key=>$val){
$fromurl=$met_weburl.$folder[foldername]."/shownews.php?id=".$val[id];
$filename="../../".$folder[foldername]."/shownews".$val[id].".htm";
createhtm($fromurl,$filename);
}
}
okinfo('htm.php',$lang[htm]);
}

if($module==3){
    $folder=$db->get_one("select * from $met_column where id='$class1'");
    $query="select * from $met_product where class1='$class1'";
	$result= $db->query($query);
	while($list = $db->fetch_array($result)){
	$class_list[]=$list;
	}
if($en=="en"){
foreach($class_list as $key=>$val){
$fromurl=$met_weburl.$folder[foldername]."/showproduct.php?&en=en&id=".$val[id];
$filename="../../".$folder[foldername]."/showproduct".$val[id]."_en.htm";
createhtm($fromurl,$filename);
}
}else{
foreach($class_list as $key=>$val){
$fromurl=$met_weburl.$folder[foldername]."/showproduct.php?id=".$val[id];
$filename="../../".$folder[foldername]."/showproduct".$val[id].".htm";
createhtm($fromurl,$filename);
}
}
okinfo('htm.php',$lang[htm]);
}

if($module==4){
    $folder=$db->get_one("select * from $met_column where id='$class1'");
    $query="select * from $met_download where class1='$class1'";
	$result= $db->query($query);
	while($list = $db->fetch_array($result)){
	$class_list[]=$list;
	}
if($en=="en"){
foreach($class_list as $key=>$val){
$fromurl=$met_weburl.$folder[foldername]."/showdownload.php?&en=en&id=".$val[id];
$filename="../../".$folder[foldername]."/showdownload".$val[id]."_en.htm";
createhtm($fromurl,$filename);
}
}else{
foreach($class_list as $key=>$val){
$fromurl=$met_weburl.$folder[foldername]."/showdownload.php?id=".$val[id];
$filename="../../".$folder[foldername]."/showdownload".$val[id].".htm";
createhtm($fromurl,$filename);
}
}
okinfo('htm.php',$lang[htm]);
}

if($module==5){
    $folder=$db->get_one("select * from $met_column where id='$class1'");
    $query="select * from $met_img where class1='$class1'";
	$result= $db->query($query);
	while($list = $db->fetch_array($result)){
	$class_list[]=$list;
	}
if($en=="en"){
foreach($class_list as $key=>$val){
$fromurl=$met_weburl.$folder[foldername]."/showimg.php?&en=en&id=".$val[id];
$filename="../../".$folder[foldername]."/showimg".$val[id]."_en.htm";
createhtm($fromurl,$filename);
}
}else{
foreach($class_list as $key=>$val){
$fromurl=$met_weburl.$folder[foldername]."/showimg.php?id=".$val[id];
$filename="../../".$folder[foldername]."/showimg".$val[id].".htm";
createhtm($fromurl,$filename);
}
}
okinfo('htm.php',$lang[htm]);
}


$query="select * from $met_column where bigclass='0' and if_in='0' order by no_order";
	$result= $db->query($query);
	while($list = $db->fetch_array($result)){
	$class_list[]=$list;
	}
$css_url="../templates/".$met_skin."/css";
$img_url="../templates/".$met_skin."/images";
include template('htm');
footer();
}else{
okinfo('basic.php',$lang[htm_if]);
}
?>