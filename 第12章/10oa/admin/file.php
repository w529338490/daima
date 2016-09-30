<?php
/*
凤鸣山中小学网络办公室
*/
$dir="./templates/$style/images/menu";
$showfile=list_dir_images($dir);
$showimages=explode("|",$showfile);
$l=sizeof($showimages);
for ($i=1;$i<$l;$i++){
$showimage.="<img src=$dir/$showimages[$i] border=0 width=20 height=20 onclick=\"addimage('$showimages[$i]')\">";
if ($i%10==0) $showimage.="<br>";
}
?>
<script>
function addimage(img){
window.opener.document.form1.typepic.value=img;
}
</script>
<body leftmargin="0" topmargin="0">
<?=$showimage;?>
</body>
