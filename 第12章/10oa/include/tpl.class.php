<?php
/*********************************************
*
����ɽ��Сѧ����칫��
*
*********************************************/
class MicroTpl{
	//�󶨽��
	public  $left_delimiter = '{';
	//�Ҷ����
	public  $right_delimiter = '}';
	//ģ���ļ�����Ŀ¼
	public  $template_dir = './templates';
	//�����ļ�����Ŀ¼
	public  $compile_dir = './cache';
	//��̬����ļ�Ŀ¼
	public  $html_dir='./cache/html';
	// ǿ�Ʊ���
	public  $force_compile = false;
	//ǿ������html
	public  $force_html =false;
	//�����ļ�����ʱ�� 0 ��ʾû����
	public  $exp_time = 0;
	//����HTML����ʱ�� 0 ��ʾû����
	public  $html_time = 0;
	//�ж��Ƿ�ֱ�����htmlʱ��
	public  $d_time=0;
	//����ģ�����
	private $ftpl_var = array();
	//����section����
	private $_sections = array();
	/*
	��������
	*/
	public function __construct($template_dir="",$compile_dir="",$html_dir="",$left_tag="",$right_tag=""){
		if(!empty($left_tag)&&!empty($right_tag)){
			$this->left_delimiter=$left_tag;
			$this->right_delimiter=$right_tag;
		}
		if (!empty($template_dir)){
			$this->template_dir=$template_dir;
		}
		if (!empty($compile_dir)&&!empty($html_dir))
		{
			$this->compile_dir=$compile_dir;
			$this->html_dir=$html_dir;
		}
		$this->create($this->compile_dir);
		$this->create($this->html_dir);
	}
	/*
	*
	*/
	public function __destruct(){
		unset($this->_sections,$this->ftpl_var);
	}
	/*
	Ŀ¼��������
	*/
	public function create($dir){
		if (!is_dir($dir))
		{
			$temp = explode('/',$dir);
			$cur_dir = '';
			for($i=0;$i<count($temp);$i++)
			{
				$cur_dir .= $temp[$i].'/';
				if (!is_dir($cur_dir))
				{
					@mkdir($cur_dir,0777);
					@fopen("$cur_dir/index.htm","a");
				}
			}
		}
	}
	/*
	* ģ�������ֵ
	*/
	public function assign($vars,$value=null){
		if(is_array($vars)){
			foreach($vars as $key => $val){
				if($key != ''){
					$this->ftpl_var[$key] = $val;
				}
			}
		}
		else{
			if($vars != ''){
				$this->ftpl_var[$vars] = $value;
			}
		}
	}

	/*
	* �������
	*/
	public function display($file_name){
		error_reporting(E_ALL ^ E_NOTICE);
		echo($this->fetch($file_name));
		$this->outtime();
	}
	/*
	* ����������
	*/
	public function fetch($file_name){
		$compiledfile_url = $this->get_compiledfile_url($file_name);
		ob_start();
		$this->compile($file_name);
		include($compiledfile_url);
		$content = ob_get_contents();
		ob_end_clean();
		return $content;
	}

	/*
	����HTML�ļ�
	*/
	public function to_html($filename,$addname="",$pagenumber=1){
		$compiledfile_url = $this->get_compiledfile_url($filename);
		$this->compile($filename);
		if(!$this->is_html($filename,$addname)){
			ob_start();#�򿪻�����
			if (!empty($addname))$filename.="_".$addname;
			if ($pagenumber>1)$filename.="_".$pagenumber;
			$fn=$this->get_html_url($filename);//�����ļ���
			include($compiledfile_url);#����Ҫ���ɾ�̬ҳ���ļ�����Ϊ��̨��ob_clean()�����ڲ�����ʾ����
			$fs=fopen($fn,'wb');#�򿪾�̬ҳ�ļ�
			fwrite($fs,ob_get_contents());#���ɾ�̬�ļ�
			fclose($fs);#�رվ�̬ҳ�ļ�
			ob_clean();#��ջ���
			chmod($fn,0777);
		}else{
			if (!empty($addname))$filename.="_".$addname;
			if ($pagenumber>1)$filename.="_".$pagenumber;
		}
		include($this->get_html_url($filename));
		$this->outtime();
	}
	/*
	*ֱ�����html
	*/
	public function get_html($filename,$addname="",$pagenumber=1){
		if ($this->is_compiled($filename) && $this->is_html($filename,$addname,$pagenumber)) {
			if (!empty($addname))$filename.="_".$addname;
			if ($pagenumber>1)$filename.="_".$pagenumber;
			include($this->get_html_url($filename));
			$this->outtime();
			exit;
		}else{
			$this->force_html=1;
		}
	}
	//�������ʱ��
	public function outtime(){
		global $start;
		$end = explode(" ",microtime());
		$end=$end[1] + $end[0];
		if ($start>0) echo 'ִ��ʱ��Ϊ:'.number_format(($end-$start)*1000,1).'����';
	}
	/*
	* ģ���ļ�·��
	*/
	public function get_sourcefile_url($file_name){
		return preg_match('/\/$/',$this->template_dir)?$this->template_dir.$file_name:$this->template_dir.'/'.$file_name;
	}

	/*
	* �����ļ�·��
	*/
	public function get_compiledfile_url($file_name){
		return preg_match('/\/$/',$this->compile_dir)?$this->compile_dir.$file_name.'.php':$this->compile_dir.'/'.$file_name.'.php';
	}

	//��̬�ļ�·��
	public function get_html_url($file_name){
		return preg_match('/\/$/',$this->html_dir)?$this->html_dir.$file_name.'.html':$this->html_dir.'/'.$file_name.'.html';
	}
	/*
	* �����ַ�ת��
	*/
	public function _quote($val){
		return preg_quote($val,'/');
	}

	/*
	* �ж���������
	*/
	public function is_compiled($file_name){
		if($this->force_compile){
			return false;
		}
		else{
			$sourcefile_url = $this->get_sourcefile_url($file_name);
			$compiledfile_url = $this->get_compiledfile_url($file_name);
			if(!file_exists($compiledfile_url) || filemtime($sourcefile_url) > filemtime($compiledfile_url)){
				return false;
			}
			elseif($this->exp_time && time()-filemtime($compiledfile_url)>$this->exp_time){
				return false;
			}
			else {
				return true;
			}
		}
	}
	/*
	�ж�HTML��������
	*/
	public function is_html($file_name,$addname='',$pagenumber=1){
		if($this->force_html){
			return false;
		}
		else{
			$html_name=(empty($addname))?$file_name:$file_name."_".$addname;
			$html_name=($pagenumber>1)?$html_name."_".$pagenumber:$html_name;
			$compiledfile_url = $this->get_compiledfile_url($file_name);
			$html_url=$this->get_html_url($html_name);
			if(!file_exists($html_url) || (filemtime($html_url) < filemtime($compiledfile_url))){
				return false;
			}
			elseif($this->html_time && time()-filemtime($html_url)>$this->html_time){
				return false;
			}
			elseif ($this->d_time && $this->d_time > filemtime($html_url)){
				return false;
			}
			else{
				return true;
			}
		}
	}

	/*
	* ����
	*/
	public function compile($file_name){
		$content = $this->get_contents($file_name);
		$content = $this->parse_include($content);
		if(!$this->is_compiled($file_name)){
			$content = $this->parse_assign($content);
			$content = $this->parse_variable($content);
			$content = $this->parse_include_php($content);
			$content = $this->parse_php($content);
			$content = $this->parse_code($content);
			$content = $this->parse_if($content);
			$content = $this->parse_elseif($content);
			$content = $this->parse_else($content);
			$content = $this->parse_section($content);
			$content = $this->parse_sectionelse($content);
			$content = $this->parse_foreach($content);
			$content = $this->parse_foreachelse($content);
			$content = $this->parse_cycle($content);
			$content = $this->parse_html($content);
			$content = $this->parse_end($content);
			$this->write_file($file_name,$content);
		}
	}

	/*
	* ��ȡģ��
	*/
	public function get_contents($file_name){
		$sourcefile_url = $this->get_sourcefile_url($file_name);
		if(!file_exists($sourcefile_url) || !($content = file_get_contents($sourcefile_url))) {
			$this->show_messages("�޷���ȡģ���ļ�{$file_name}�������ļ��Ƿ���ڡ�");
		}
		return $content;
	}
	/*
	* ���� code ���
	*/
	function parse_code($content){
		$code_regular = '/'.$this->_quote($this->left_delimiter).'code'.$this->_quote($this->right_delimiter).'(.+?)'.$this->_quote($this->left_delimiter).'\/code'.$this->_quote($this->right_delimiter).'/is';
		if(preg_match_all($code_regular,$content,$code_arr)){
			$content = preg_replace($code_regular,'<?php\\1?>',$content);
			$ext_arr = $code_arr[1];
			foreach ($code_arr[1] as $key=>$value){
				if(preg_match_all('/\$\w([\w\.\[\]]*[\w\]])?/',$value,$code_arr1)){
					foreach ($code_arr1[0] as $key1 => $value1){
						$ext_arr[$key] = preg_replace('/'.$this->_quote($value1).'/',$this->parse_vars($value1),$ext_arr[$key],1);
					}
					$content = preg_replace('/'.$this->_quote($code_arr[1][$key]).'/',$ext_arr[$key],$content,1);
				}
			}
		}
		return $content;
	}

	/*
	* ���� php ���
	*/
	function parse_php($content){
		$php_regular = '/'.$this->_quote($this->left_delimiter).'php'.$this->_quote($this->right_delimiter).'(.+?)'.$this->_quote($this->left_delimiter).'\/php'.$this->_quote($this->right_delimiter).'/is';
		$content = preg_replace($php_regular,"<?php\\1?>",$content);
		return $content;
	}
	/*
	* ģ���������
	*/
	public function parse_vars($vars){
		$vars_arr = explode('.',$vars);
		foreach ($vars_arr as $key=>$value){
			$len_n=strspn("[",$value);
			$len_s=strrpos($value,"[");
			if($key == 0){
				if(preg_match_all('/(\w+)(\[\w+\])*?/',$value,$vars_arr1)){
					foreach ($vars_arr1[0] as $key2=>$value2) {
						if($key2 == 0) {
							$rep[] = '$this->ftpl_var[\''.$value2.'\']';
						}
						else{
							$rep[] = '[\$this->ftpl_var[\''.$value2.'\']]';
						}
					}
				}
			}
			else{
				if(preg_match_all('/(\w+)(\[\w+\])*?/',$value,$vars_arr1)){
					foreach ($vars_arr1[0] as $key2=>$value2) {
						if($key2 == 0) {
							$rep[] = ($len_n>0 && $len_s<1)?'[$this->ftpl_var[\''.$value2.'\']]':'[\''.$value2.'\']';
						}
						else{
							$rep[] = '[\$this->ftpl_var[\''.$value2.'\']]';
						}
					}
				}
			}
		}
		$replace = implode('',$rep);
		return $replace;
	}

	/*
	* ���� ģ�����
	*/
	public function parse_variable($content){
		$variable_regular = '/'.$this->_quote($this->left_delimiter).'\$(\w([\w\.\[\]]*[\w\]])?)'.$this->_quote($this->right_delimiter).'/';
		if(preg_match_all($variable_regular,$content,$variable_arr)){
			foreach ($variable_arr[1] as $key=>$value){
				$rep = "<?php echo ";
				$rep .= $this->parse_vars($value);
				$rep .= ";?>";
				$content = preg_replace('/'.$this->_quote($variable_arr[0][$key]).'/',$rep,$content,1);
			}
		}
		return $content;
	}

	/*
	* ���� assign
	*/
	function parse_assign($content){
		$assign_regular = '/'.$this->_quote($this->left_delimiter).'assign\s+var\s*=\s*[\'"](\w+)[\'"]\s+value\s*=\s*[\'"](.+?)[\'"]'.$this->_quote($this->right_delimiter).'/';
		$content = preg_replace($assign_regular,'<?php $this->assign(\'\\1\',\'\\2\');?>',$content);
		return $content;
	}

	/*
	* cycle ����
	*/
	public function _cycle($value){
		static $cycle_index;
		if(!isset($cycle_index)) $cycle_index = 0;
		$cycle_arr = explode(',',$value);
		$cycle_value = $cycle_arr[$cycle_index];
		if($cycle_index >= count($cycle_arr)-1) $cycle_index = 0;
		else $cycle_index++;
		return $cycle_value;
	}

	/*
	* ���� cycle
	*/
	public function parse_cycle($content){
		$cyle_regular = '/'.$this->_quote($this->left_delimiter).'cycle\s+values\s*=\s*[\'"](.+?)[\'"]'.$this->_quote($this->right_delimiter).'/i';
		$content = preg_replace($cyle_regular,'<?php echo $this->_cycle(\'\\1\');?>',$content);
		return $content;
	}
	/*
	* option ����
	*/
	public function _html($html,$name,$options,$selected,$separator=''){
		switch ($html){
			case 'options':
				$select="<select name=$name>";
				if (is_array($options)){
					foreach ($options as $key=>$value){
						$isselected=($selected==$key)?'selected':'';
						$select.="<option value=$key $isselected>$value</option>";
					}
				}
				$select.="</select>";
				return $select;
				break;
			case 'checkboxes':
				$i=1;
				if (is_array($options)){
					foreach ($options as $key=>$value){
						if ($separator>0) $separator_out=($i%$separator==0)?'<br>':'';
						if (!is_array($selected) && !is_object($selected)) { settype($selected, 'array');};
						$isselected=in_array($key,$selected)?'checked':'';
						$check.="<input type=checkbox name=$name value=$key $isselected />$value $separator_out";
						$i++;
					}
				}
				return $check;
				break;
			case 'radios':
				$i=1;
				if (is_array($options)){
					foreach ($options as $key=>$value){
						if ($separator>0) $separator_out=($i%$separator==0)?'<br>':'';
						$isselected=($selected==$key)?'checked':'';
						$check.="<input type=radio name=$name value=$key $isselected />$value $separator_out";
						$i++;
					}
				}
				return $check;
				break;
		}
	}
	/*
	* ���� option
	*/
	public function parse_html($content){
		$option_regular = '/'.$this->_quote($this->left_delimiter).'html_(\w+)\s+name\s*=\s*\$([\w\[\]\.]+)\s+options\s*=\s*\$([\w\[\]\.]+)\s+(selected|checked)\s*=\s*\$([\w\[\]\.]+)\s*(separator=)?(\d*)?\s*'.$this->_quote($this->right_delimiter).'/isU';
		if(preg_match_all($option_regular,$content,$option_arr)){//print_r($option_arr);
			foreach ($option_arr[0] as $key=>$value){
				$name = $this->parse_vars($option_arr[2][$key]);
				$options = $this->parse_vars($option_arr[3][$key]);
				$selected = $this->parse_vars($option_arr[5][$key]);
				switch ($option_arr[1][$key]){
					case 'options':
						$rep = 	"<?php\r\n echo \$this->_html('".$option_arr[1][$key]."',".$name.",".$options.",".$selected.");\r\n?>";
						$content = preg_replace('/'.$this->_quote($value).'/',$rep,$content,1);
						break;
					case 'checkboxes':
						$rep = 	"<?php\r\n echo \$this->_html('".$option_arr[1][$key]."',".$name.",".$options.",".$selected.",'".$option_arr[7][$key]."');\r\n?>";
						$content = preg_replace('/'.$this->_quote($value).'/',$rep,$content,1);
						break;
					case 'radios':
						$rep = 	"<?php\r\n echo \$this->_html('".$option_arr[1][$key]."',".$name.",".$options.",".$selected.",'".$option_arr[7][$key]."');\r\n?>";
						$content = preg_replace('/'.$this->_quote($value).'/',$rep,$content,1);
						break;
				}
			}
		}
		return $content;
	}
	/*
	* ���� if ���
	*/
	public function parse_if($content){
		$if_regular = '/'.$this->_quote($this->left_delimiter).'if\s+((!?\(*\s*\$([\w\.\[\]]+)\s*\)*\s*((==|<|>|>=|<=|!=|<>|===)\s*(\d+|[\'"](.*)[\'"])\)*)*\s*(or|and|&&|\|\|)\s*)*!?\(*\s*\$([\w\.\[\]]+)\s*((==|<|>|>=|<=|!=|<>|===)\s*(\d+|[\'"](.*)[\'"])\)*)*)'.$this->_quote($this->right_delimiter).'/isU';
		if(preg_match_all($if_regular,$content,$if_arr)){
			foreach ($if_arr[0] as $key=>$value){
				if(preg_match_all('/\$[\w\.\[\]]+/',$value,$if_arr1)){
					foreach ($if_arr1[0] as $key1=>$value1){
						$if_arr[1][$key] = preg_replace('/'.$this->_quote($value1).'/',$this->parse_vars($value1),$if_arr[1][$key],1);
					}
					$rep = 	"<?php\r\nif(".$if_arr[1][$key]."){\r\n?>";
					$content = preg_replace('/'.$this->_quote($value).'/',$rep,$content,1);
				}
			}
		}
		return $content;
	}

	/*
	* ���� elseif ���
	*/
	public function parse_elseif($content){
		$if_regular = '/'.$this->_quote($this->left_delimiter).'elseif\s+((!?\(*\s*\$([\w\.\[\]]+)\s*\)*\s*((==|<|>|>=|<=|!=|<>|===)\s*(\d+|[\'"](.*)[\'"])\)*)*\s*(or|and|&&|\|\|)\s*)*!?\(*\s*\$([\w\.\[\]]+)\s*((==|<|>|>=|<=|!=|<>|===)\s*(\d+|[\'"](.*)[\'"])\)*)*)'.$this->_quote($this->right_delimiter).'/isU';
		if(preg_match_all($if_regular,$content,$if_arr)){
			foreach ($if_arr[0] as $key=>$value){
				if(preg_match_all('/\$[\w\.\[\]]+/',$value,$if_arr1)){
					foreach ($if_arr1[0] as $key1=>$value1){
						$if_arr[1][$key] = preg_replace('/'.$this->_quote($value1).'/',$this->parse_vars($value1),$if_arr[1][$key],1);
					}
					$rep = 	"<?php\r\n}\r\nelseif(".$if_arr[1][$key]."){\r\n?>";
					$content = preg_replace('/'.$this->_quote($value).'/',$rep,$content,1);
				}
			}
		}
		return $content;
	}

	/*
	* ���� else ���
	*/
	public function parse_else($content){
		$else_regular = '/'.$this->_quote($this->left_delimiter).'else'.$this->_quote($this->right_delimiter).'/i';
		$rep = "<?php\r\n}\r\nelse\r\n{\r\n?>";
		$content = preg_replace($else_regular,$rep,$content);
		return $content;
	}

	/*
	* ���� section ���
	*/
	public function parse_section($content){
		$section_regular =  '/'.$this->_quote($this->left_delimiter).'section\s+name\s*=\s*(\w+)\s+loop\s*=\s*\$([\w\[\]\.]+)(\s+start\s*=\s*(\d+))?(\s+step\s*=\s*(\d+))?'.$this->_quote($this->right_delimiter).'/';
		if(preg_match_all($section_regular,$content,$section_arr)){	//print_r($section_arr);exit;
			foreach($section_arr[2] as $key=>$val){
				preg_match_all('/loop=\$([\w\.]+)/i',$section_arr[0][$key],$output1);
				$output = $this->parse_vars($output1[1][0]);
				$tag_val = "\$this->ftpl_var['".$section_arr[1][$key]."']";
				$section_val = "\$this->ftpl_var['".$section_arr[1][$key]."']";
				if(!empty($section_arr[4][$key])) $start_value = $section_arr[4][$key];
				else $start_value = 0;
				if(!empty($section_arr[6][$key])) $step_value = $section_arr[6][$key];
				else $step_value = 1;
				$rep = array();
				$rep[] = "<?php";
				$rep[] = "unset({$tag_val},\$this->ftpl_var['start'],\$this->ftpl_var['step'],\$this->ftpl_var['total'],\$this->ftpl_var['loop']);";
				$rep[] = "{$tag_val}['name']  = '\\1';";
				$rep[] = "\$this->ftpl_var['start'] = {$start_value};";
				$rep[] = "\$this->ftpl_var['step'] = {$step_value};";
				$rep[] = "\$this->ftpl_var['loop'] = is_array({$output})?count({$output}):0;";
				$rep[] = "\$this->ftpl_var['total'] = ceil((\$this->ftpl_var['loop']-\$this->ftpl_var['start'])/\$this->ftpl_var['step']);";
				$rep[] = "if(\$this->ftpl_var['total'] > 0){";
				$rep[] = "    for(\$this->ftpl_var['index'] = \$this->ftpl_var['start'],\$this->ftpl_var['iteration'] = 1;";
				$rep[] = "        \$this->ftpl_var['index'] < \$this->ftpl_var['loop'];";
				$rep[] = "        \$this->ftpl_var['index'] += \$this->ftpl_var['step'],\$this->ftpl_var['iteration']++)";
				$rep[] = "    {";
				$rep[] = "        \$this->ftpl_var['index_prev'] = \$this->ftpl_var['index'] - \$this->ftpl_var['step'];";
				$rep[] = "        \$this->ftpl_var['index_next'] = \$this->ftpl_var['index'] + \$this->ftpl_var['step'];";
				$rep[] = "        \$this->ftpl_var['first'] = (\$this->ftpl_var['iteration'] == 1);";
				$rep[] = "        \$this->ftpl_var['last'] = (\$this->ftpl_var['iteration'] == \$this->ftpl_var['total']);";
				$rep[] = "        \$this->ftpl_var['rownum'] = \$this->ftpl_var['iteration'];";
				$rep[] = "?>";
				$rs = implode("\r\n",$rep);
				$content = preg_replace('/'.$this->_quote($section_arr[0][$key]).'/s',$rs,$content,1);
				unset($rs);
			}
		}
		return $content;
	}

	/*
	* ���� sectionelse ���
	*/
	public function parse_sectionelse($content){
		$sectionelse_regular = '/'.$this->_quote($this->left_delimiter).'sectionelse'.$this->_quote($this->right_delimiter).'(.+?)'.$this->_quote($this->left_delimiter).'\/section'.$this->_quote($this->right_delimiter).'/is';
		$content = preg_replace($sectionelse_regular,"<?php\r\n    }\r\n}\r\nelse{\r\n?>\\1<?php\r\n}\r\n?>",$content);
		return $content;
	}

	/*
	*���� foreach ���
	*/
	public function parse_foreach($content){

		$foreach_regular =  '/'.$this->_quote($this->left_delimiter).'foreach\s+(name\s*=\s*(\w+)\s*)?(key\s*=\s*(\w+)\s*)?item\s*=\s*([\w\[\]\.]+)\s+from\s*=\s*\$([\w\[\]\.]+)\s*'.$this->_quote($this->right_delimiter).'/';
		if(preg_match_all($foreach_regular,$content,$foreach_arr)){
			foreach($foreach_arr[6] as $key=>$val){
				$key2=$foreach_arr[6][$key];
				preg_match_all('/\s*from\s*=\s*\$([\w\.\]\[]+)\s*/i',$foreach_arr[0][$key],$output1);
				$from = $this->parse_vars($output1[1][0]);
				$key2=null;
				if (!empty($foreach_arr[4][$key])) {
					$key1  = $foreach_arr[4][$key];
					$key_part = "\$this->ftpl_var['$key1'] => ";
				} else {
					$key1=null;
					$key_part = '';
				}
				$name=$foreach_arr[2][$key];
				$item=$foreach_arr[5][$key];
				$rep = array();
				$rep[] = '<?php ';
				$rep[]= "\$_from = $from; if (!is_array(\$_from) && !is_object(\$_from)) { settype(\$_from, 'array');}";
				if (!empty($name)) {
					$foreach_props = "\$this->ftpl_var['foreach']['$name']";
					$rep[]= "{$foreach_props} = array('total' => count(\$_from), 'iteration' => 0);";
					$rep[]= "if ({$foreach_props}['total'] > 0){";
					$rep[]= "    foreach (\$_from as $key_part\$this->ftpl_var['$item']){";
					$rep[]= "        {$foreach_props}['iteration']++;";
				} else {
					$rep[]= "if (count(\$_from)){";
					$rep[]= "    foreach (\$_from as $key_part\$this->ftpl_var['$item']){";
				}
				$rep[]= '?>';
				$rs = implode("\r\n",$rep);
				$content = preg_replace('/'.$this->_quote($foreach_arr[0][$key]).'/s',$rs,$content,1);
				unset($rs,$key2,$name,$item,$from,$key_part);
			}
		}
		return $content;
	}
	/*
	*���� foreachelse ���
	*/
	public function parse_foreachelse($content){
		$sectionelse_regular = '/'.$this->_quote($this->left_delimiter).'foreachelse'.$this->_quote($this->right_delimiter).'(.+?)'.$this->_quote($this->left_delimiter).'\/foreach'.$this->_quote($this->right_delimiter).'/is';
		$content = preg_replace($sectionelse_regular,"<?php\r\n    }\r\n}\r\nelse{\r\n unset(\$_form);?>\\1<?php  \r\n}\r\n?>",$content);
		return $content;
	}
	/*
	* ���� section �� if �������
	*/
	public function parse_end($content){
		$section_end_regular = '/'.$this->_quote($this->left_delimiter).'\/section'.$this->_quote($this->right_delimiter).'/';
		$section_rep = "<?php\r\n    }\r\n}\r\n?>";
		$content = preg_replace($section_end_regular,$section_rep,$content);
		$if_end_regular = '/'.$this->_quote($this->left_delimiter).'\/if'.$this->_quote($this->right_delimiter).'/';
		$if_rep = "<?php\r\n}\r\n?>";
		$content = preg_replace($if_end_regular,$if_rep,$content);
		$if_end_regular = '/'.$this->_quote($this->left_delimiter).'\/foreach'.$this->_quote($this->right_delimiter).'/';
		$if_rep = "<?php\r\n}
		unset(\$_form);
		\r\n} ?>";
		$content = preg_replace($if_end_regular,$if_rep,$content);
		return $content;
	}

	/*
	* ���� include ���
	*/
	public function parse_include($content){
		$include_regular = '/'.$this->_quote($this->left_delimiter).'include\s+file\s*=\s*["\']([\w\.]+?)["\']'.$this->_quote($this->right_delimiter).'/i';
		if(preg_match_all($include_regular,$content,$include_arr)){
			foreach ($include_arr[1] as $key=>$value){
				$this->compile($value);
			}
			$content = preg_replace($include_regular,"<?php\r\ninclude('\\1.php');\r\n?>",$content);
		}
		return $content;
	}

	/*
	* ���� include_php ���
	*/
	public function parse_include_php($content){
		$include_php_regular = '/'.$this->_quote($this->left_delimiter).'include_php\s+file\s*=\s*["\']([\w\.\/]+?)["\']'.$this->_quote($this->right_delimiter).'/i';
		$content = preg_replace($include_php_regular,"<?php include_once('\\1');?>",$content);
		return $content;
	}

	/*
	* д�����ļ�
	*/
	public function write_file($file_name,$content){
		$compiledfile_url = $this->get_compiledfile_url($file_name);
		if(!is_dir($this->compile_dir)){
			$this->create($this->compile_dir);
		}
		if(!is_writable($this->compile_dir)){
			$this->show_messages("���Ƚ������ļ���".$this->compile_dir."�͸��ļ����е������ļ������Ըĳ�777��");
		}
		$fp = fopen($compiledfile_url,'wb');
		fwrite($fp,$content);
		fclose($fp);
		chmod($compiledfile_url,0777);
	}

	/*
	* ��Ϣ��ʾ
	*/
	public function show_messages($message){
		echo $message;
		exit;
	}
}
?>
