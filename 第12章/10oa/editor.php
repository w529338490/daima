<?php
/*
����ɽ��Сѧ����칫��
*/

require './global.php';

switch($action){
case 'upfile':

     if($do){
       if(empty($userfile)){
          exit("�Բ���û���ϴ��ļ���");
       }
       if($userfile_size==0){
          exit("�Բ����ϴ��ļ����ֽ���Ϊ0��");
       }
       if(!is_uploaded_file($userfile)){
          exit("�Բ����ļ��ϴ�ʧ�ܣ�");
       }
       if($userfile_size>$MAX_FILE_SIZE){
         $MAX_FILE_SIZE=$MAX_FILE_SIZE/1000;
         exit("�Բ������ϴ����ļ����ó���$MAX_FILE_SIZE k��");
       }
       $notuptypes=$notuptypes?$notuptypes:'.php|.asp|.jsp|.cgi|.dll';
       if($type=file_type($userfile_name,$notuptypes)){
         exit("�Բ����벻Ҫ�ϴ�".$type."��ʽ���ļ���");
       }
       $ndatey=date("Y",time());
       $ndate=date( "m", time());
       $ndateday=date( "d", time());
       $newfilepath=$ndatey."/".$ndate."/".$ndateday.rand(100,999).$userfile_name;
       $newfile=$uppath."attach/".$newfilepath;
       $savepath=$rootpath.'/'.$newfile;
       $newfile_size=$userfile_size/1000000;
       $newfile_size=number_format($newfile_size,2,".","");
       $newfile_size=$newfile_size."M";
     if (empty($filename)){$tempfile=explode(".",$userfile_name);$filename=$tempfile[0];};
      $updir=$uppath."attach/"."$ndatey/$ndate";
       createdir($updir);
       if(copy($userfile,$newfile)){
       	$hash=getcode();
          $query="INSERT INTO `$table_soft` ( `softid` ,`postid`, `softname` ,`softpath`, `softsize` , `number` , `money` , `other` ) 
                                 VALUES ('','$postid','$filename' ,'$newfilepath', '$newfile_size', '0', '$money', '$hash')";
          $r=$db->query($query); 
          $query_id=$db->insert_id(); 
               $out="<center><FIELDSET align=center><LEGEND align=center><font color=red>�ļ��ϴ��ɹ��� </font></LEGEND><br>[ <a href=# onclick=\"Addfile('$query_id','$filename')\">���������ӵ��༭����</a> ]</fieldset><center>";
          
        }else{
               $out="<center><FIELDSET align=center><LEGEND align=center><font color=red>�ļ��ϴ�ʧ�ܣ� </font></LEGEND></fieldset><center>";
        }

     echo "<html>
     <head>
     <title>�ļ��ϴ�</title>
     <script  language='JavaScript'>
     <!--
     function Addfile(fileid,filename){

        le=window.opener.document.form1.addfile.length++;
        window.opener.document.form1.addfile.options[le].text =filename;
        window.opener.document.form1.addfile.options[le].value =fileid;
       window.close();
      }
    function Addswf(swfPath,width,height){	
       window.opener.frames.message.focus();
       window.opener.frames.message.document.body.innerHTML+='<object classid=clsid:D27CDB6E-AE6D-11cf-96B8-444553540000 codebase=http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0 width='+width+' height='+height+'><param name=movie value='+swfPath+'><param name=quality value=high><param name=wmode value=transparent><embed src='+swfPath+' width='+width+' height='+height+' quality=high pluginspage=http://www.macromedia.com/go/getflashplayer type=application/x-shockwave-flash wmode=transparent></embed></object>';
       window.close();
     }
    function Addpic(imagePath,note){	
	window.opener.frames.message.focus();								
	window.opener.frames.message.document.execCommand('InsertImage', false, imagePath);
        window.opener.frames.message.document.body.innerHTML+='<br>'+note;
        window.close();
     }
     -->
     </script>
     <LINK href=$rootpath/edit/site.css rel=stylesheet>
     </head>
     <BODY bgColor=menu topmargin=15 leftmargin=15 >".$out."</body></html>";

     }else{

     $tsize=$maxsize/1000;

     echo "<html>
     <head>
     <meta http-equiv='Content-Type' content='text/html; charset=gb2312'>
     <title>�ļ��ϴ�</title>
     <LINK href=$rootpath/edit/site.css rel=stylesheet>
     </head>
     <BODY bgColor=menu topmargin=15 leftmargin=15 >
     <CENTER>
     <FIELDSET align=left>
     <LEGEND align=left>�ļ��ϴ�</LEGEND>
     <form name='form' method='post' action='editor.php?action=upfile&do=1&postid=$postid' enctype='multipart/form-data' >
     <input type='hidden' name='MAX_FILE_SIZE' value='$MAX_FILE_SIZE'>
     �ļ���<input type='file' name='userfile' size=23><br> ���֣�<input type='text' name='filename' size=23>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>������<select name=money>
<option value=0>0����</option>
<option value=1>1����</option>
<option value=2>2����</option>
</select>
   &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;  <input type='submit' name='Submit' value='�� ��' ><p>
    ���ƴ�С��".$tsize."K &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;<br>
     </form>
     </fieldset>
 
     </body>
     </html>";

     }

break;

case 'textbox':
     if($table){
          $tablename=${'table_'.$table};
          $result=$db->query("select content from $tablename where articleid='$articleid'");
          if($db->num_rows($result)==1){
             $r=$db->fetch_array($result);
             $content=$r[content];
          }
     }else{

       $content='';

     }

     echo "
       <head>
       <title></title>
       <META HTTP-EQUIV='Pragma' CONTENT='no-cache'>
       <meta http-equiv='Content-Type' content='text/html; charset=gb2312'>
       <LINK href=$rootpath/edit/site.css rel=stylesheet>
       </head>
       <body leftmargin='0' topmargin='0' marginwidth='0' marginheight='0'>
       ".$content."
       </body>
       </html>";
break;

case 'upspecialpic': 
       if($do){
       if(empty($userfile)){
          exit("�Բ���û���ϴ��ļ���");
       }
       if($userfile_size==0){
          exit("�Բ����ϴ��ļ����ֽ���Ϊ0��");
       }
       if(!is_uploaded_file($userfile)){
          exit("�Բ����ļ��ϴ�ʧ�ܣ�");
       }
       if($userfile_size>$MAX_FILE_SIZE){
         $MAX_FILE_SIZE=$MAX_FILE_SIZE/1000;
         exit("�Բ������ϴ����ļ����ó���$MAX_FILE_SIZE k��");
       }
       $notuptypes=$notuptypes?$notuptypes:'.php|.asp|.jsp|.cgi|.dll';
       if($type=file_type($userfile_name,$notuptypes)){
         exit("�Բ����벻Ҫ�ϴ�".$type."��ʽ���ļ���");
       }
       $newfile="./images/".$userfile_name;
       createdir("./images");
       $fileid="asdfsdaf";
      if(copy($userfile,$newfile)){
?>
<script  language='JavaScript'>
     <!--
     function Addfile(fileid){       
       parent.document.form1.typepic.value=fileid;
       redirect("editor.php?action=upspecialpic");
      }
function redirect(url) {
window.location.replace(url);
}
</SCRIPT>
       <script>setTimeout("Addfile('<?=$newfile?>');", 2);</script>
<?      }
exit;
      }
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML><HEAD><TITLE><?=$tilte?></TITLE>
<META content="text/html; charset=gb2312" http-equiv=Content-Type>
<script  language='JavaScript'>
     <!--
function redirect(url) {
window.location.replace(url);
}
</SCRIPT>

<META content="MSHTML 5.00.2614.3500" name=GENERATOR></HEAD>
<BODY>
<TABLE border=0 cellPadding=0 cellSpacing=0 width="100%">
  <FORM action=editor.php?action=upspecialpic encType=multipart/form-data method=post name=upload>
  <TBODY>
  <TR>
    <TD align=right class=tablerow width="60%">
    <INPUT name=userfile size=15 type=file> 
    <INPUT name=MAX_FILE_SIZE type=hidden value=1024000>
    <input name=do type=hidden value=1>
       </TD>
    <TD  class=tablerow>
    <INPUT name=submit type=submit value=�ϴ�>
    </TD>
  </TR>
  </FORM>
  </TBODY>
  </TABLE>
</BODY>
</HTML>

<?
break;
case 'template':
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML><HEAD><TITLE><?=$tilte?>--����ģ��</TITLE>
<META content="text/html; charset=gb2312" http-equiv=Content-Type>
   <LINK href=<?=$rootpath;?>/edit/site.css rel=stylesheet>
<SCRIPT language=JavaScript>

function insert(){  
	 
	if(window.opener.frames.message.document.getElementById('btable')==null)   
  {   
    var str="<TABLE border=1 cellPadding=1 cellSpacing=0 width=100% align=center>"
        +"<tr>"
        +"<td width=20% align=center>�Ͽ���</td>"         
        +"<td width=10% align=center></td>"
        +"<td width=20% align=center>�����</td>"
        +"<td width=10% align=center></td>"
        +"<td width=20% align=center>�༶</td>"
        +"<td width=20% align=center>�δ�</td>"
        +"</tr>"
        +"<tbody id=btable>"
        +"<tr>"
        +"<td width=20% align=center></td>"         
        +"<td width=10% align=center>����</td>"
        +"<td width=20% align=center></td>"
        +"<td width=10% align=center>��</td>"
        +"<td width=20% align=center></td>"
        +"<td width=20% align=center></td>"
        +"</tr>"
        +"</tbody>"
        +"</table>";	
        window.opener.frames.message.document.body.innerHTML+=str;
  }   
  else   
  {   
  	var nowTable=window.opener.frames.message.document.getElementById('btable');  
        var newTr=nowTable.insertRow();

        var newTd=newTr.insertCell(0);
        var newTd1=newTr.insertCell(1);
        var newTd2=newTr.insertCell(2);
        var newTd3=newTr.insertCell(3);
        var newTd4=newTr.insertCell(4);
        var newTd5=newTr.insertCell(5);
        
            newTd.align="center";
            newTd1.align="center";
            newTd2.align="center";
            newTd3.align="center";
            newTd4.align="center";
            newTd5.align="center";
            
            newTd.innerHTML="";
            newTd1.innerHTML="����";
            newTd2.innerHTML="";
            newTd3.innerHTML="��";
            newTd4.innerHTML="";
            newTd5.innerHTML="";
  }
window.opener.frames.message.focus();		
}
function insertg(){  
	 
	if(window.opener.frames.message.document.getElementById('gtable')==null)   
  {   
    var str="<TABLE border=1 cellPadding=1 cellSpacing=0 width=100% align=center>"
        +"<tr>"
        +"<td width=20% align=center>�Ͽ���</td>"         
        +"<td width=10% align=center>�δ�</td>"
        +"<td width=10% align=center>�༶</td>"
        +"<td width=10% align=center>�α�</td>"
        +"<td width=20% align=center>�ص�</td>"
        +"<td width=30% align=center>��ע</td>"
        +"</tr>"
        +"<tbody id=gtable>"
        +"<tr>"
        +"<td width=20% align=center></td>"         
        +"<td width=10% align=center></td>"
        +"<td width=10% align=center></td>"
        +"<td width=10% align=center></td>"
        +"<td width=20% align=center></td>"
        +"<td width=30% align=center></td>"
        +"</tr>"
        +"</tbody>"
        +"</table>";	
        window.opener.frames.message.document.body.innerHTML+=str;
  }   
  else   
  {   
  	var nowTable=window.opener.frames.message.document.getElementById('gtable');  
        var newTr=nowTable.insertRow();

        var newTd=newTr.insertCell(0);
        var newTd1=newTr.insertCell(1);
        var newTd2=newTr.insertCell(2);
        var newTd3=newTr.insertCell(3);
        var newTd4=newTr.insertCell(4);
        var newTd5=newTr.insertCell(5);
        
            newTd.align="center";
            newTd1.align="center";
            newTd2.align="center";
            newTd3.align="center";
            newTd4.align="center";
            newTd5.align="center";
            
            newTd.innerHTML="";
            newTd1.innerHTML="";
            newTd2.innerHTML="";
            newTd3.innerHTML="";
            newTd4.innerHTML="";
            newTd5.innerHTML="";
  }
window.opener.frames.message.focus();		
}
</SCRIPT>
<script  language='JavaScript'>
function redirect(url) {
window.location.replace(url);
}
</SCRIPT>
<META content="MSHTML 5.00.2614.3500" name=GENERATOR></HEAD>
<BODY>
<TABLE border=0 cellPadding=0 cellSpacing=0 width="100%">
  <TBODY>
  <TR>
    <TD align=center class=tablerow valign=middle>
    <a href="#" onclick=insert()>---���뻻��ģ��---</a>	<br>
    <a href="#" onclick=insertg()>---���빫����ģ��---</a>	<br>
    	</TD>
  </TR>
  </TBODY>
  </TABLE>
</BODY>
</HTML>
<?
break;
}
?>
