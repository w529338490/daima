<?
/**
 * @version		1.0
 * @package		HonoWeb->HonoCart
 * @.
 * @Website		.
 */
 ?>
<?

		
		function FormatDate($str)
		{
		  return (substr($str,0,10));
		}
		function filterTag($str)
		{
		  $search=array("'<script[^>]*?>.*?</script>'si","'<[\/\!]*?[^<>]*?>'si","'([\r\n])[\s]+'");
		  $replace=array("","","\\1");
		   return preg_replace($search,$replace,$str);
		}
		
		
		function cut($Str, $Length) {//$Str为截取字符串，$Length为需要截取的长度 
		
			global $s; 
			$i = 0; 
			$l = 0; 
			$ll = strlen($Str); 
			$s = $Str; 
			$f = true; 
			
			while ($i <= $ll) { 
				if (ord($Str{$i}) < 0x80) { 
					$l++; $i++; 
				} else if (ord($Str{$i}) < 0xe0) { 
					$l++; $i += 2; 
				} else if (ord($Str{$i}) < 0xf0) { 
					$l += 2; $i += 3; 
				} else if (ord($Str{$i}) < 0xf8) {
					$l += 1; $i += 4; 
				} else if (ord($Str{$i}) < 0xfc) { 
					$l += 1; $i += 5; 
				} else if (ord($Str{$i}) < 0xfe) { 
					$l += 1; $i += 6; 
				} 
			
				if (($l >= $Length - 1) && $f) { 
					$s = substr($Str, 0, $i); 
					$f = false; 
				} 
			
				if (($l > $Length) && ($i < $ll)) { 
					$s = $s . '...'; break; //如果进行了截取，字符串末尾加省略符号“...”
				} 
			} 
			return $s;
		}

		
		function substring($string, $length, $start = 0) 
		{ 
			return cut($string, $length);
		}
		
		function writespace($num) 
		{ 
			$str="";
			for($i=1;$i<=$num;$i++)
				$str.="&nbsp;";
			return $str;
			
		}
		
		function substringno($string, $length, $start = 0) 
		{ 
			$str=substr($string,0,$length); 
			$chr=0; 
			for($i=0;$i<strlen($str);$i++)
			{
				if(ord($str[$i])<128)//????????????ASCII???128??? 
					$chr++; 
			} 
			$str2=substr($string,0,$length+1);//????????? 
			//????????ascii???128???????? 
			if ($chr%2==1)
			{ 
				if($length<=strlen($string)) 
					$str2=$str2.="";//????????????????????,??????????... 
				return $str2;
			} 
			if ($chr%2==0)
			{ 
				if($length<=strlen($string)) 
					$str=$str.="";
				return $str;
			}
			
		}
		
		
		function toBr($str)
		{
			 $content=str_replace(Chr(255),"&nbsp;",$str);
			$content=str_replace(Chr(32),"&nbsp;",$content);
			return nl2br($content);
		}

		function nl2br_indent($string, $indent = 1)
		{

		   $string = str_replace("\r", '', $string);

		   if (is_int($indent)) {

			   $indent = str_repeat(' ', (int)$indent);
		   }

		   $string = str_replace("\n", "<br />\n".$indent, $string);

		   $string = $indent.$string;
		   return $string;
		}
		
		function isLogin()
		{
			 if(empty($_SESSION['SessionUser']['username'])||empty($_SESSION['SessionUser']))
			  {
				 return false;
			  }
			  return true;
		}
		
		function isSite($site_id)
		{
			   $b_site=false;
				$site_id_array=explode(',',$_SESSION['SessionAdminUser']['site_id']);
				if(in_array($site_id,$site_id_array))
				{
					$b_site=true;
				}
				return $b_site;
		}
		
		function isAccessPage($menuid)//????????????
		{
			$b=false;
			for($i=0;$i<count($_SESSION['SessionMenu']);$i++)
			{
				if($_SESSION['SessionMenu'][$i]['id']==$menuid)
				{
					$b=true;
					break;
				}
			}
			return $b;
		}
		
	
		
		function isLoginAdmin()
		{
			$b=false;
			if(count($_SESSION['SessionMenu'])>0)
			{
				$b=true;
			}
			return $b;
		}
		
		function isAdmin()
		{ 
			$b=false;
			if(!empty($_SESSION['SessionAdminUser']['UserGrade']))
			{
				$b=true;
			}
			return $b;
		}
		

		function isFunc($func_id)
		{
			$b=false;
			for($i=0;$i<count($_SESSION['SessionMenu']);$i++)
			{
				$func_id_array=explode(',',$_SESSION['SessionMenu'][$i]['authorize']);
				if(in_array($func_id,$func_id_array))
				{
					$b=true;
					break;
				}
			}
			return $b;
		}
		
		function is_Page_Access($item_id,$item_ids)
		{
			$b=false;
			$item_id_array=explode(',',$item_ids);
			if(in_array($item_id,$item_id_array))
			{
				$b=true;
			}
			return $b;
		}
		
		function setMyCookie($name,$value)
		{
			$expire=time()+3600;
			//$path="/";
			//$domain="http://localhost:8084";
			$secure=1;
			setcookie($name,$value,$expire,$path,$domain);
		}
		
		function getMyCookie($name)
		{
			return $_COOKIE[$name];
		}
		
		function getRandomNum()
		{
			$seedarray =microtime(); 
			$seedstr =split(" ",$seedarray,5); 
			$seed =$seedstr[0]*10000;
			$random =rand(10,40);
			$addFileName=date('YnjHis').$random;
			return $addFileName;
		}

		
		
		
		/***********************************************************************
 * 生成缩略图
 *
***********************************************************************/		
		function ImageResize($srcFile,$toW,$toH,$toFile="") 
		{
		   if($toFile==""){ $toFile = $srcFile; }
		   $info = "";
		   $data = GetImageSize($srcFile,$info);
		   switch ($data[2]) 
		   {
			case 1:
			  if(!function_exists("imagecreatefromgif")){
			   echo "你的GD库不能使用GIF格式的图片，请使用Jpeg或PNG格式！<a href='javascript:go(-1);'>返回</a>";
			   exit();
			  }
			  $im = ImageCreateFromGIF($srcFile);
			  break;
			case 2:
			  if(!function_exists("imagecreatefromjpeg")){
			   echo "你的GD库不能使用jpeg格式的图片，请使用其它格式的图片！<a href='javascript:go(-1);'>返回</a>";
			   exit();
			  }
			  $im = ImageCreateFromJpeg($srcFile);    
			  break;
			case 3:
			  $im = ImageCreateFromPNG($srcFile);    
			  break;
			default:
       		  echo "You can upload jpg or gif picture! <a href='javascript:go(-1);'>返回</a>";
			  exit();
		  }
		  $srcW=ImageSX($im);
		  $srcH=ImageSY($im);
		  $toWH=$toW/$toH;
		  $srcWH=$srcW/$srcH;
		  if($toWH<=$srcWH){
			   $ftoW=$toW;
			   $ftoH=$ftoW*($srcH/$srcW);
		  }else{
			  $ftoH=$toH;
			  $ftoW=$ftoH*($srcW/$srcH);
		  }
			 if(function_exists("imagecreatetruecolor")){
				@$ni = ImageCreateTrueColor($ftoW,$ftoH);
				if($ni) ImageCopyResampled($ni,$im,0,0,0,0,$ftoW,$ftoH,$srcW,$srcH);
				else{
				 $ni=ImageCreate($ftoW,$ftoH);
				  ImageCopyResized($ni,$im,0,0,0,0,$ftoW,$ftoH,$srcW,$srcH);
				}
			}else{
				$ni=ImageCreate($ftoW,$ftoH);
				ImageCopyResized($ni,$im,0,0,0,0,$ftoW,$ftoH,$srcW,$srcH);
			}
			 if(function_exists('imagejpeg')) ImageJpeg($ni,$toFile);
			 else ImagePNG($ni,$toFile);
			 ImageDestroy($ni);
		  ImageDestroy($im);
		}
		
		
		
		function makeslug($string) {
			$stringnew = str_replace(" ", "-",$string);
			$stringnew = str_replace("&", "|",$stringnew);
			return $stringnew;
			return $stringnew;
		}
		
		function makeslug1($string) {
			$stringnew = ereg_replace("'", "", stripslashes($string));
			$stringnew = preg_replace('/[^a-z0-9-_]/', '-', strtolower($stringnew));
			$stringnew = ereg_replace("-+", "-", $stringnew);
			$stringnew = ereg_replace("-$", "", $stringnew);
			$stringnew = ereg_replace("^-", "", $stringnew);
			return $stringnew;
		}
		
		function releaseslug($string) {
			$stringnew = str_replace("-", " ",$string);
			$stringnew = str_replace("|", "&",$stringnew);
			return $stringnew;
		}

		
		function checkPost($data)
		{
			if(!get_magic_quotes_gpc()) {
				return is_array($data)?array_map('checkpost',$data):addslashes($data);
			} else {
				Return $data;
			}
		}
		
		$_GET     = checkPost($_GET);
		$_POST    = checkPost($_POST);
		$_COOKIE  = checkPost($_COOKIE);
		$_REQUEST = checkPost($_REQUEST); 
?>