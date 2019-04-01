<?php
/**
 * YunPHP4SAE php framework designed for SAE
 *
 * @author heyue <heyue@foxmail.com>
 * @copyright Copyright(C)2010, heyue
 * @link http://code.google.com/p/yunphp4sae/
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @version YunPHP4SAE  version 1.0.0
 * @the class is changed from CodeIgniter
 */
class Page {

 
	var $base_url			= ''; // �������url����ҳ������������ҳ��
	var $total_rows  		= ''; // ����
	var $per_page	 		= 10; // ÿҳ��ʾ������
	var $num_links			=  2; // ��ʾ�ڵ�ǰҳ���ҵ��м��������������о���2��
	var $cur_page	 		=  1; // Ĭ�ϵ�ǰҳ
	
	var $first_link   		= '&lsaquo;&lsaquo; First';  //��һҳ������
	var $next_link			= '&gt;';	//��һҳ������
	var $prev_link			= '&lt;'; 	//��һҳ������
	var $last_link			= 'Last &rsaquo;&rsaquo;'; //���һҳ������
	
	var $full_tag_open		= '';  //���������page�����һ��div��css�ı�ǩ�������
	var $full_tag_close		= '';  //���ǩ
	
	var $first_tag_open		= '';  //��һҳ����ߵ�div css ��ǩ
	var $first_tag_close	= '&nbsp;'; //��һҳ�ұߵ�div css ��ǩ������ͬ
	
	var $last_tag_open		= '&nbsp;'; //���һҳ
	var $last_tag_close		= '';
	
	var $cur_tag_open		= '&nbsp;<span class="current">'; //��ǰҳ
	var $cur_tag_close		= '</span>';
	
	var $next_tag_open		= '&nbsp;'; //��һҳ
	var $next_tag_close		= '&nbsp;';
	var $prev_tag_open		= '&nbsp;';
	var $prev_tag_close		= '';
	
	var $num_tag_open		= '&nbsp;<span>'; //����
	var $num_tag_close		= '</span>';
	
	var $page_tab_open      = '&nbsp;'; //�������ǵ�ǰҳ��ҳ���div css
	var $page_tab_close 	= '';
	
	var $uri_segmentation = ''; //�������ļ��ж�ȡ�ָ���������ҳ��������url������ҳ��
	var $page_uri = ''; //��׼���ɵ�uri
	//����url stu/list/1 /stu-list-2
	function create_links(){
		if($this->total_rows == 0 OR $this->per_page == 0){
			return '';
		}
		$num_pages = ceil($this->total_rows / $this->per_page);
		if($num_pages == 1){
			return '';
		}
				
		$pre_page = $this->cur_page-1;
		$next_page = $this->cur_page +1;
		
		if($this->cur_page >=$num_pages){
			$this->cur_page = $num_pages;
			$next_page = $num_pages;
		}
		if($this->cur_page <= 1){
			$this->cur_page = 1;
			$pre_page = 1;
		}

	$output = '';
	$output .= "$this->full_tag_open";
	$output .= "{$this->first_tag_open}<a href='{$this->base_url}1'>$this->first_link</a>{$this->first_tag_close}";
	$output .="{$this->prev_tag_open}<a href='{$this->base_url}{$pre_page}'>$this->prev_link</a>{$this->prev_tag_close}";
	$show_nums = $this->num_links*2+1;// ��ʾҳ��ĸ���������ǰ��2���������Լ�һ������ 5 ��
	if($num_pages <= $show_nums){
		for($i = 1;$i<=$num_pages;$i++){
			if($i == $this->cur_page){
				$output .= $this->cur_tag_open.$i.$this->cur_tag_close;
			}else{
				$output .= "{$this->page_tab_open}<a href='{$this->base_url}$i'>$i</a>{$this->page_tab_close}";
			}
		}
	}else{
		if($this->cur_page < (1+$this->num_links)){
			for($i = 1;$i<=$show_nums;$i++){
				if($i == $this->cur_page){
					$output .= $this->cur_tag_open.$i.$this->cur_tag_close;
				}else{
					$output .= "{$this->page_tab_open}<a href='{$this->base_url}$i'>$i</a>{$this->page_tab_close}";
				}
			}			
		}else if($this->cur_page >= ($num_pages - $this->num_links)){
			for($i = $num_pages - $show_nums ; $i <= $num_pages ; $i++){
				if($i == $this->cur_page){
					$output .= $this->cur_tag_open.$i.$this->cur_tag_close;
				}else{
					$output .= "{$this->page_tab_open}<a href='{$this->base_url}$i'>$i</a>{$this->page_tab_close}";
				}
			}
		}else{
			$start_page = $this->cur_page - $this->num_links;
			$end_page = $this->cur_page + $this->num_links;
			for($i = $start_page ; $i<=$end_page ; $i++){
				if($i == $this->cur_page){
					$output .= $this->cur_tag_open.$i.$this->cur_tag_close;
				}else{
					$output .= "{$this->page_tab_open}<a href='{$this->base_url}$i'>$i</a>{$this->page_tab_close}";
				}
			}
		}
	}
	
	$output .="{$this->next_tag_open}<a href='{$this->base_url}{$next_page}'>$this->next_link</a>{$this->next_tag_close}";
	$output .= "{$this->last_tag_open}<a href='{$this->base_url}{$num_pages}'>$this->last_link</a>{$this->last_tag_close}";
	//$output .="{$this->num_tag_open}$total_rows{$this->num_tag_close}";
	$output .= $this->full_tag_close;	
	return $output;
	}
	/**
	 * Constructor
	 *
	 * @access	public
	 * @param	array	initialization parameters
	 */
	function __construct($params = array())
	{
		$this->uri_segmentation = '';//Configure::getItem('uri_segmentation','config');
		if (count($params) > 0)
		{
			$this->initialize($params);
		}
	}
	/**
	 * ��ʼ����ҳ����
	 *
	 * @param unknown_type $params
	 */
	function initialize($params = array()){
		if(count($params > 0)){
			foreach ($params as $k => $v){
				if(isset($this->$k)){
					$this->$k = $v;
				}
			}
		}
		if(substr($this->base_url,-1) != $this->uri_segmentation){
			$this->base_url .= $this->uri_segmentation;
		}
	}
	

}
