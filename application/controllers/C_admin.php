<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_admin extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		$this->load->model('M_perusahaan','msmart');
		$this->load->model('M_config','mconfig');
		$this->load->model('M_admin','madmin');
	}

	public function index()
	{
		$sesi = $this->session->userdata('admin');
		if (!$sesi) {
			redirect('beranda');
		}
		$data['jumlah_perusahaan'] = $this->msmart->count_all();
		$data['jumlah_kriteria'] = $this->madmin->kriteria_all();
		$data['jumlah_perhitungan'] = $this->madmin->perhitungan_all();
		$data['most_freq'] = $this->madmin->most_frequent();
		$data['flash'] = $this->session->flashdata('berhasil');
		$data['title'] = 'Recommendation - Admin';
		$this->load->view('template/ad_head', $data);
		$this->load->view('back/dashboard', $data);
		$this->load->view('template/ad_foot', $data);
	}

	public function datakriteria()
	{
		$sesi = $this->session->userdata('admin');
		if (!$sesi) {
			redirect('beranda');
		}
		$data['title'] = 'Admin - Data Kriteria';
		$this->load->view('template/ad_head', $data);
		$this->load->view('back/data_kriteria', $data);
		$this->load->view('modal/mdl_edt_kriteria', $data);
		$this->load->view('modal/mdl_adduser', $data);
		$this->load->view('template/ad_foot', $data);
	}

	public function save_kriteria()
	{
		$postData = $this->input->post();
		$result = 0;

		try
		{
			$getData = $this->madmin->get_kriteria_by_name($postData['kriteria']);
			
			if(empty($getData) && empty($postData['id_kriteria']))
			{
				$insertData = $this->madmin->insert_kriteria($postData);
	
				if(!empty($insertData))
				{
					$result = 1;
				}
			}else{
				$id_kriteria = $postData['id_kriteria'];
				$updateData = $this->madmin->update_kriteria($id_kriteria,$postData);

				print_r($updateData);die;
			}

			echo json_encode($result);
		}catch(\Exception $ex)
		{
			print_r($ex->getMessage());die;
		}
	}

	public function edit_kriteria()
	{
		$postData = $this->input->post('id_kriteria');
		$getDataKriteria = $this->madmin->get_kriteria($postData);
		

		echo json_encode($getDataKriteria);
	}

	public function delete_kriteria()
	{
		$postData = $this->input->post();

		try
		{
			$deleteData = $this->madmin->delete_kriteria($postData['id_kriteria']);

			echo json_encode($deleteData);
		}catch(\Exception $ex)
		{
			print_r($ex->getMessage());die;
		}
	}

	public function datapertanyaan()
	{
		$sesi = $this->session->userdata('admin');
		if (!$sesi) {
			redirect('beranda');
		}
		$data['title'] = 'Admin - Data Pertanyaan';
		
		$this->load->view('template/ad_head', $data);
		$this->load->view('back/data_pertanyaan', $data);
		$this->load->view('modal/mdl_edt_pertanyaan', $data);
		$this->load->view('template/ad_foot', $data);
	}

	public function dataperhitungan()
	{
		$sesi = $this->session->userdata('admin');
		if (!$sesi) {
			redirect('beranda');
		}
		$data['title'] = 'Admin - Data Perhitungan';
		$this->load->view('template/ad_head', $data);
		$this->load->view('back/data_perhitungan', $data);
		$this->load->view('modal/mdl_detail_perhitungan', $data);
		$this->load->view('template/ad_foot', $data);
	}

	public function settings()
	{
		$sesi = $this->session->userdata('admin');
		if (!$sesi) {
			redirect('beranda');
		}
		$data['title'] = 'Admin - Pengaturan';
		$data['detail_con'] = $this->mconfig->det_conf();
		$this->load->view('template/ad_head', $data);
		$this->load->view('back/setting', $data);
		$this->load->view('template/ad_foot', $data);
	}
	public function update_config()
	{
		$data = array(
			'nama_instansi' => $this->input->post('nama_instansi'),
			'nama_aplikasi' => $this->input->post('nama_aplikasi'),
			'alamat_instansi' => $this->input->post('alamat_instansi'),
			'deskripsi' => $this->input->post('deskripsi')
		);
		if ($data['nama_aplikasi'] == "" || $data['nama_instansi'] == "" || $data['alamat_instansi'] == "" || $data['deskripsi'] == "") {
			return false;
		} else {
			$this->mconfig->update_conf($data);
		}
	}
	public function update_help()
	{
		$data = array('halaman_bantuan' => nl2br($this->input->post('note_help')));
		if ($data['halaman_bantuan'] == "") {
			return false;
		} else {
			$this->mconfig->update_conf($data);
		}
	}
	public function reset_help()
	{
		$data = array('halaman_bantuan' => '');
		$this->mconfig->update_conf($data);
	}

	public function adduser()
	{
		$sesi = $this->session->userdata('admin');
		if (!$sesi) {
			redirect('beranda');
		}
		$data['title'] = 'Admin - Pengaturan Admin';
		$this->load->view('template/ad_head', $data);
		$this->load->view('back/data_admin', $data);
		$this->load->view('modal/mdl_addadmin', $data);
		$this->load->view('modal/mdl_adduser', $data);
		$this->load->view('template/ad_foot', $data);
	}
	public function get_admin()
	{
		$sesi = $this->session->userdata('admin');
		if (!$sesi) {
			redirect('beranda');
		}
		$get = $this->madmin->list_admin();
		echo json_encode($get);
	}
	public function select_admin($id_admin)
	{
		$data = $this->madmin->get_admin($id_admin);
		echo json_encode($data);
	}
	public function save_admin()
	{
		$nama = ucwords($this->input->post('nama'), " \t\r\n\f\v'");
		$id_admin = $this->input->post('id_admin');
		if (empty($id_admin)) {
			$data = array(
				'username' => $this->input->post('username'),
				'password' => $this->input->post('password'),
				'nama' => $nama,
				'hak_akses' => 'admin'
			);
			$this->session->set_userdata('admin',$data);
			$result = $this->madmin->insert_admin($data);
			echo json_encode($result);
		} else {
			$data = array(
				'username' => $this->input->post('username'),
				'password' => $this->input->post('password'),
				'nama' => $nama
			);
			$result = $this->madmin->update_admin($id_admin,$data);
			echo json_encode($result);
		}
	}
	public function delete_admin($id_admin)
	{
		$result = $this->madmin->delete_admin($id_admin);
		echo json_encode($result);
	}

	public function get_user()
	{
		$sesi = $this->session->userdata('admin');
		if (!$sesi) {
			redirect('beranda');
		}
		$get = $this->madmin->list_user();
		echo json_encode($get);
	}
	public function select_user($id_user)
	{
		$data = $this->madmin->get_user($id_user);
		echo json_encode($data);
	}
	public function save_user()
	{
		$nama = ucwords($this->input->post('nama_user'), " \t\r\n\f\v'");
		$id_user = $this->input->post('id_user');
		if (empty($id_user)) {
			$data = array(
				'username' => $this->input->post('username_user'),
				'password' => $this->input->post('password_user'),
				'nama' => $nama
			);
			$result = $this->madmin->insert_user($data);
			echo json_encode($result);
		} else {
			$data = array(
				'username' => $this->input->post('username_user'),
				'password' => $this->input->post('password_user'),
				'nama' => $nama
			);
			$result = $this->madmin->update_user($id_user,$data);
			echo json_encode($result);
		}
	}
	public function delete_user($id_user)
	{
		$result = $this->madmin->delete_user($id_user);
		echo json_encode($result);
	}

	public function get_kriteria()
	{
		$sesi = $this->session->userdata('admin');
		if (!$sesi) {
			redirect('beranda');
		}
		$get = $this->madmin->list_kriteria();
		echo json_encode($get);
	}

	public function get_pertanyaan()
	{
		$sesi = $this->session->userdata('admin');
		if (!$sesi) {
			redirect('beranda');
		}
		$get = $this->madmin->list_pertanyaan();
		echo json_encode($get);
	}
	public function select_pertanyaan($id_pertanyaan)
	{
		$result = $this->madmin->get_pertanyaan($id_pertanyaan);
		echo json_encode($result);
	}
	public function save_pertanyaan()
	{
		$id_pertanyaan = $this->input->post('id_pertanyaan');
		$data = array('pertanyaan' => $this->input->post('pertanyaan'));
		$result = $this->madmin->update_pertanyaan($id_pertanyaan,$data);
		echo json_encode($result);
	}

	public function getperhitungan()
	{
		$sesi = $this->session->userdata('admin');
		if (!$sesi) {
			redirect('beranda');
		}
		$get = $this->madmin->list_perhitungan();
		echo json_encode($get);
	}
	public function get_perhitungan()
	{
		$sesi = $this->session->userdata('admin');
		if (!$sesi) {
			redirect('beranda');
		}
		$list = $this->madmin->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $sp) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $sp->tanggal;
			$row[] = $sp->namap.' - '.$sp->bentuk;
			$row[] = $sp->skor_akhir;
			$row[] = $sp->nama;
			$row[] = '<button class="btn btn-sm btn-warning m-1" onclick="detail_perhitungan('.$sp->id_detail.');"><i class="fas fa-pen-square"></i></button>';
			$data[] = $row;
		}
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->madmin->count_all(),
			"recordsFiltered" => $this->madmin->count_filtered(),
			"data" => $data,
		);
		echo json_encode($output);
	}

	public function detail_perhitungan()
	{
		$postData = $this->input->post();

		try
		{
			$getDetailPerhitungan = $this->madmin->detailPerhitungan($postData['id_detail']);

			echo json_encode($getDetailPerhitungan);
		}catch(\Exception $ex)
		{
			print_r($ex->getMessage());die;
		}
	}

	public function cekusername_user()
	{
		$username_user = $this->input->post('username_user');
		$res = $this->madmin->cekusername_user($username_user);
		if ($res) {
			echo json_encode($res);
		} else {
			return false;
		}
	}
	public function cekusername_admin()
	{
		$username = $this->input->post('username');
		$res = $this->madmin->cekusername_admin($username);
		if ($res) {
			echo json_encode($res);
		} else {
			return false;
		}
	}

	public function data_chart()
	{
		$data = $this->madmin->chart_data();
		echo json_encode($data);
	}
}
