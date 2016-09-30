<?
class File_upload{
	public $upload_path='./upload/';//�ϴ��ļ���·��
	public $allow_type=array();//�����ϴ����ļ�����
	public $max_size='20480';//���������ļ���С
	public $overwrite=false;//�Ƿ����óɸ���ģʽ
	public $renamed=false;//�Ƿ�ֱ��ʹ���ϴ��ļ������ƣ�����ϵͳ�Զ�����

	/**
* ˽�б���
*/
	private $upload_file=array();//�����ϴ��ɹ��ļ�����Ϣ
	private $upload_file_num=0;//�ϴ��ɹ��ļ�����Ŀ
	private $succ_upload_file=array();//�ɹ�������ļ���Ϣ
	/**
* ������
*
* @param string $upload_path
* @param string $allow_type
* @param string $max_size
*/
	public function __construct($upload_path='./upload/',$allow_type='jpg|bmp|png|gif|jpeg|dic|zip|exe|rar|ppt',$max_size='204800')
	{
		$this->set_upload_path($upload_path);
		$this->set_allow_type($allow_type);
		$this->max_size=$max_size;
		$this->get_upload_files();
	}
	/**
* �����ϴ�·�������ж�
*
* @param string $path
*/
public function set_upload_path($dir)
	{
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
        $this->upload_path=$dir;
	}
	//�����ϴ��ļ�����
	public function set_allow_type($types){
		$this->allow_type=explode("|",$types);
	}
	//�ϴ��ļ�
	public function get_upload_files()
	{
		foreach ($_FILES AS $key=>$field)
		{
			$this->get_upload_files_detial($key);
		}
	}
	//�ϴ��ļ����ݴ�ŵ�������
	public function get_upload_files_detial($field){
		if(is_array($_FILES["$field"]['name']))
		{
			for($i=0;$i<count($_FILES[$field]['name']);$i++)
			{
				if(0==$_FILES[$field]['error'][$i])
				{
					$this->upload_file[$this->upload_file_num]['name']=$_FILES[$field]['name'][$i];
					$this->upload_file[$this->upload_file_num]['type']=$_FILES[$field]['type'][$i];
					$this->upload_file[$this->upload_file_num]['size']=$_FILES[$field]['size'][$i];
					$this->upload_file[$this->upload_file_num]['tmp_name']=$_FILES[$field]['tmp_name'][$i];
					$this->upload_file[$this->upload_file_num]['error']=$_FILES[$field]['error'][$i];
					$this->upload_file_num++;
				}
			}
		}
		else {
			if(0==$_FILES["$field"]['error'])
			{
				$this->upload_file[$this->upload_file_num]['name']=$_FILES["$field"]['name'];
				$this->upload_file[$this->upload_file_num]['type']=$_FILES["$field"]['type'];
				$this->upload_file[$this->upload_file_num]['size']=$_FILES["$field"]['size'];
				$this->upload_file[$this->upload_file_num]['tmp_name']=$_FILES["$field"]['tmp_name'];
				$this->upload_file[$this->upload_file_num]['error']=$_FILES["$field"]['error'];
				$this->upload_file_num++;
			}
		}
	}
	/**
* ����ϴ��ļ��ǹ�����ָ������
*
*/
	public function check($i)
	{
		if(!empty($this->upload_file[$i]['name'])){
			//����ļ���С
			if($this->upload_file[$i]['size']>$this->max_size*1024)$this->upload_file[$i]['error']=2;
			//��ȡ�ļ�·����Ϣ
			$file_info=pathinfo($this->upload_file[$i]['name']);
			//��ȡ�ļ���չ��
			$file_ext=$file_info['extension'];
			//��Ҫ��������
			if($this->renamed){
				list($usec, $sec) = explode(" ",microtime());
				$this->upload_file[$i]['name']=$sec.substr($usec,2).'.'.$file_ext;
				unset($usec);
				unset($sec);
			}
			//����Ĭ�Ϸ�����ļ���
			$this->upload_file[$i]['filename']=$this->upload_path.$this->upload_file[$i]['name'];
			//����ļ�����
			if(!in_array($file_ext,$this->allow_type))$this->upload_file[$i]['error']=5;
			//����ļ��Ƿ����
			if(file_exists($this->upload_file[$i]['filename'])){
				if($this->overwrite){
					@unlink($this->upload_file[$i]['filename']);
				}else{
					$j=0;
					do{
						$j++;
						$temp_file=str_replace('.'.$file_ext,'('.$j.').'.$file_ext,$this->upload_file[$i]['filename']);
					}while (file_exists($temp_file));
					$this->upload_file[$i]['filename']=$temp_file;
					unset($temp_file);
					unset($j);
				}
			}
			//������
		} else $this->upload_file[$i]['error']=6;
	}
	/**
* �ϴ��ļ�
*
* @return true
*/
	public function upload()
	{
		$upload_msg='';
		for($i=0;$i<$this->upload_file_num;$i++)
		{
			if(!empty($this->upload_file[$i]['name']))
			{
				//����ļ�
				$this->check($i);
				if (0==$this->upload_file[$i]['error'])
				{
					//�ϴ��ļ�
					if(!@move_uploaded_file($this->upload_file[$i]['tmp_name'],$this->upload_file[$i]['filename']))
					{
						$upload_msg.='�ϴ��ļ�'.$this->upload_file[$i]['name'].' ����:'.$this->error($this->upload_file[$i]['error']).'!<br>';
					}else
					{
						$this->succ_upload_file[]=$this->upload_file[$i]['filename'];
						$upload_msg.='�ϴ��ļ�'.$this->upload_file[$i]['name'].' �ɹ���<br>';
					}
				}else $upload_msg.='�ϴ��ļ�'.$this->upload_file[$i]['name'].' ����:'.$this->error($this->upload_file[$i]['error']).'!<br>';
			}
		}
		echo $upload_msg;
	}
	//������Ϣ
	public function error($error)
	{
		switch ($error) {
			case 1:
				return '�ļ���С����php.ini �� upload_max_filesize ѡ�����Ƶ�ֵ';
				break;
			case 2:
				return '�ļ��Ĵ�С������ HTML ���� MAX_FILE_SIZE ѡ��ָ����ֵ';
				break;
			case 3:
				return '�ļ�ֻ�в��ֱ��ϴ�';
				break;
			case 4:
				return 'û���ļ����ϴ�';
				break;
			case 5:
				return '����ļ��������ϴ�';
				break;
			case 6:
				return '�ļ���Ϊ��';
				break;
			default:
				return '����';
				break;
		}
	}
	//��ȡ�ɹ���������ϢΪ����(����)
	public function get_succ_file(){
		return $this->succ_upload_file;
	}
}
?>