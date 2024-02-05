<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_list extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		$this->load->model('M_perusahaan','msmart');
		$this->load->library('pagination');
	}

	public function index()
	{
		$data['title'] = 'Recommendation - List Perusahaan';
		$this->load->view('template/us_head', $data);
		$this->load->view('front/list_perusahaan', $data);
		$this->load->view('modal/mdl_adduser', $data);
		$this->load->view('template/us_foot', $data);
	}

	public function bynamap()
	{
		$data = $this->msmart->bynamap();
		echo json_encode($data);
	}

	public function listpage($rowno=0)
	{
		$platform = $this->agent->platform();
		if ($platform=="Android" | $platform=="iOS") {
			$size = 'small';
		} else {
			$size = '';
		}
		$rowperpage = 12;
		if($rowno != 0){
			$rowno = ($rowno-1) * $rowperpage;
		}
		$param = $this->input->post('filter');
		$cari_namap = $this->input->post('cari_namap');
		if (empty($param) && empty($cari_namap)) {
			$record = $this->msmart->seg($rowperpage,$rowno);
		} else {
			$record = $this->msmart->filter_smart($param,$cari_namap,$rowperpage,$rowno);
		}
		if (empty($cari_namap)) {
			$total_rows = $this->msmart->count_all();
		} else {
			$total_rows = $this->msmart->count_all_by_namap($cari_namap);
		}
		
		$config['base_url'] = base_url();
		$config['use_page_numbers'] = TRUE;
		$config['total_rows'] = $total_rows;
		$config['per_page'] = $rowperpage;
		$config['first_link'] = '&laquo;';
		$config['first_tag_open'] = '<div>';
		$config['first_tag_close'] = '</div>';
		$config['last_link'] = '&raquo;';
		$config['last_tag_open'] = '<div>';
		$config['last_tag_close'] = '</div>';
		$config['next_link'] = '&rsaquo;';
		$config['prev_link'] = '&lsaquo;';
		$config['full_tag_open'] = '<div class="pagging '.$size.' text-center"><nav><ul class="pagination">';
		$config['full_tag_close'] = '</ul></nav></div>';
		$config['num_tag_open'] = '<li class="page-item"><span class="page-link">';
		$config['num_tag_close'] = '</span></li>';
		$config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
		$config['cur_tag_close'] = '<span class="sr-only">(current)</span></span></li>';
		$config['next_tag_open'] = '<li class="page-item"><span class="page-link">';
		$config['next_tag_close'] = '<span aria-hidden="true"></span></span></li>';
		$config['prev_tag_open'] = '<li class="page-item"><span class="page-link">';
		$config['prev_tag_close'] = '</span></li>';
		$config['first_tag_open'] = '<li class="page-item"><span class="page-link">';
		$config['first_tag_close'] = '</span></li>';
		$config['last_tag_open'] = '<li class="page-item"><span class="page-link">';
		$config['last_tag_close'] = '</span></li>';
		
		$this->pagination->initialize($config);
		
		$data['pagination'] = $this->pagination->create_links();
		$data['result'] = $record;
		$data['row'] = $rowno;
		$data['param'] = $param;
		$data['namap'] = $cari_namap;

		echo json_encode($data);
	}

}
