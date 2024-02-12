<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_perusahaan extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		$this->load->model('M_perusahaan', 'msmart');
	}

	public function index()
	{
		$sesi = $this->session->userdata('admin');
		if (!$sesi) {
			redirect('beranda');
		}
		$data['title'] = 'Admin - Data Perusahaan';
		$this->load->view('template/ad_head', $data);
		$this->load->view('back/data_perusahaan', $data);
		$this->load->view('modal/mdl_smart', $data);
		$this->load->view('modal/mdl_smart_del', $data);
		$this->load->view('template/ad_foot', $data);
	}

	public function ajax()
	{
		$list = $this->msmart->get_datatables();
		$data = array();
		$no = $_POST['start'];
		$pop_det = 'data-toggle="tooltip" data-placement="top" title="Detail Data"';
		$pop_edt = 'data-toggle="tooltip" data-placement="top" title="Edit Data"';
		$pop_del = 'data-toggle="tooltip" data-placement="top" title="Delete Data"';
		foreach ($list as $sp) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $sp->namap;
			$row[] = $sp->bentuk;
			$row[] = $sp->tipe . '"';
			$row[] = $sp->toilet;
			$row[] = $sp->smoking;
			$row[] = $sp->kapasitas . ' Seat / ' . $sp->tseat . ' Seat';
			$row[] = $sp->cepat . ' KMJ';
			$row[] = $sp->jenis;
			$row[] = $sp->tahun;
			$row[] = $sp->jbus . ' Bus';
			$row[] = 'Rp ' . number_format($sp->harga, 0, ',', '.');
			//add html for action
			$row[] = '<td class="text-center">' .
				'<div class="btn-group m-1" role="group">' .
				'<button class="btn btn-sm btn-primary" onclick="det_smart(' .
				$sp->id .
				');" ' . $pop_det . '><i class="fas fa-info-circle"></i></button>' .
				'<button class="btn btn-sm btn-warning" onclick="edt_smart(' .
				$sp->id .
				');" ' . $pop_edt . '><i class="fas fa-pen-square"></i></button>' .
				'<button class="btn btn-sm btn-danger" onclick="del_smart(' .
				$sp->id .
				');" ' . $pop_del . '><i class="fas fa-trash"></i></button>' .
				'</div>' .
				'</td>';

			$data[] = $row;
		}
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->msmart->count_all(),
			"recordsFiltered" => $this->msmart->count_filtered(),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_user()
	{
		$list = $this->msmart->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $sp) {
			$no++;
			$row = array();
			$row[] = '<input value="" type="checkbox" id="chk_boxes1"  name="hp[]" onchange=""/>';
			$row[] = $sp->namap . " " . $sp->bentuk;
			$row[] = $sp->toilet . ' - ' . $sp->smoking;
			$row[] = $sp->kapasitas . ' Seat / ' . $sp->tseat . ' Seat';
			$row[] = $sp->tipe . '"';
			$row[] = $sp->cepat . ' KMJ';
			$row[] = $sp->jenis;
			$row[] = $sp->tahun;
			$row[] = $sp->jbus . ' Bus';
			$row[] = 'Rp ' . number_format($sp->harga, 0, ',', '.');

			$data[] = $row;
		}
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->msmart->count_all(),
			"recordsFiltered" => $this->msmart->count_filtered(),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}

	public function get_perusahaan()
	{
		$data = $this->msmart->list_perusahaan();
		echo json_encode($data);
	}

	public function select_smart($id)
	{
		$data = $this->msmart->get_perusahaan($id);
		echo json_encode($data);
	}

	public function save_perusahaan()
	{
		$id = $this->input->post('id');
		$namap = strtoupper($this->input->post('namap'));
		$bentuk = ucwords($this->input->post('bentuk'), " \t\r\n\f\v'");
		$jenis = ucwords($this->input->post('jenis'), " \t\r\n\f\v'");
		$cepat = ucwords($this->input->post('cepat'), " \t\r\n\f\v'");
		$namap_bentuk = $namap . "_" . $bentuk;
		$title = str_replace(' ', '_', $namap_bentuk);

		$config['upload_path'] = './assets/img/perusahaan/';
		$config['allowed_types'] = 'jpg|png|jpeg';
		$config['max_size']  = '3072'; // 3MB
		$config['overwrite'] = TRUE;
		$config['file_name'] = $title;

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('foto')) {
			if (empty($id)) {
				$isi = array(
					'namap' => $namap,
					'bentuk' => $bentuk,
					'tipe' => $this->input->post('tipe'),
					'tseat' => $this->input->post('tseat'),
					'kapasitas' => $this->input->post('kapasitas'),
					'toilet' => $this->input->post('toilet'),
					'smoking' => $this->input->post('smoking'),
					'cepat' => $cepat,
					'jenis' => $jenis,
					'tahun' => $this->input->post('tahun'),
					'jbus' => $this->input->post('jbus'),
					'harga' => $this->input->post('harga'),
					'nilai_tseat' => $this->input->post('nilai_tseat'),
					'nilai_kapasitas' => $this->input->post('nilai_kapasitas'),
					'nilai_toilet' => $this->input->post('nilai_toilet'),
					'nilai_smoking' => $this->input->post('nilai_smoking'),
					'nilai_cepat' => $this->input->post('nilai_cepat'),
					'nilai_tipe' => $this->input->post('nilai_tipe'),
					'nilai_tahun' => $this->input->post('nilai_tahun'),
					'nilai_jbus' => $this->input->post('nilai_jbus'),
					'nilai_harga' => $this->input->post('nilai_harga'),
					'foto' => 'sp1.jpeg'
				);
				$result = $this->msmart->insert_perusahaan($isi);
				echo json_encode($isi);
			} else {
				$get_old_image = $this->msmart->get_foto($id);
				$old_image = $get_old_image->foto;
				$isi = array(
					'namap' => $namap,
					'bentuk' => $bentuk,
					'tipe' => $this->input->post('tipe'),
					'tseat' => $this->input->post('tseat'),
					'kapasitas' => $this->input->post('kapasitas'),
					'toilet' => $this->input->post('toilet'),
					'smoking' => $this->input->post('smoking'),
					'cepat' => $cepat,
					'jenis' => $jenis,
					'tahun' => $this->input->post('tahun'),
					'jbus' => $this->input->post('jbus'),
					'harga' => $this->input->post('harga'),
					'nilai_tseat' => $this->input->post('nilai_tseat'),
					'nilai_kapasitas' => $this->input->post('nilai_kapasitas'),
					'nilai_toilet' => $this->input->post('nilai_toilet'),
					'nilai_smoking' => $this->input->post('nilai_smoking'),
					'nilai_cepat' => $this->input->post('nilai_cepat'),
					'nilai_tipe' => $this->input->post('nilai_tipe'),
					'nilai_tahun' => $this->input->post('nilai_tahun'),
					'nilai_jbus' => $this->input->post('nilai_jbus'),
					'nilai_harga' => $this->input->post('nilai_harga'),
					'foto' => $old_image
				);
				$result = $this->msmart->update_perusahaan($id, $isi);
				echo json_encode($isi);
			}
		} else {
			$data = array('upload_data' => $this->upload->data());
			$ext = $data['upload_data']['file_ext'];
			if (empty($id)) {
				$isi = array(
					'namap' => $namap,
					'bentuk' => $bentuk,
					'tipe' => $this->input->post('tipe'),
					'tseat' => $this->input->post('tseat'),
					'kapasitas' => $this->input->post('kapasitas'),
					'toilet' => $this->input->post('toilet'),
					'smoking' => $this->input->post('smoking'),
					'cepat' => $cepat,
					'jenis' => $jenis,
					'tahun' => $this->input->post('tahun'),
					'jbus' => $this->input->post('jbus'),
					'harga' => $this->input->post('harga'),
					'nilai_tseat' => $this->input->post('nilai_tseat'),
					'nilai_kapasitas' => $this->input->post('nilai_kapasitas'),
					'nilai_toilet' => $this->input->post('nilai_toilet'),
					'nilai_smoking' => $this->input->post('nilai_smoking'),
					'nilai_cepat' => $this->input->post('nilai_cepat'),
					'nilai_tipe' => $this->input->post('nilai_tipe'),
					'nilai_tahun' => $this->input->post('nilai_tahun'),
					'nilai_jbus' => $this->input->post('nilai_jbus'),
					'nilai_harga' => $this->input->post('nilai_harga'),
					'foto' => $title . $ext
				);
				$result = $this->msmart->insert_perusahaan($isi);
				echo json_encode($isi);
			} else {
				$get_old_image = $this->msmart->get_foto($id);
				$old_image = $get_old_image->foto;
				$isi = array(
					'namap' => $namap,
					'bentuk' => $bentuk,
					'tipe' => $this->input->post('tipe'),
					'tseat' => $this->input->post('tseat'),
					'kapasitas' => $this->input->post('kapasitas'),
					'toilet' => $this->input->post('toilet'),
					'smoking' => $this->input->post('smoking'),
					'cepat' => $cepat,
					'jenis' => $jenis,
					'tahun' => $this->input->post('tahun'),
					'jbus' => $this->input->post('jbus'),
					'harga' => $this->input->post('harga'),
					'nilai_tseat' => $this->input->post('nilai_tseat'),
					'nilai_kapasitas' => $this->input->post('nilai_kapasitas'),
					'nilai_toilet' => $this->input->post('nilai_toilet'),
					'nilai_smoking' => $this->input->post('nilai_smoking'),
					'nilai_cepat' => $this->input->post('nilai_cepat'),
					'nilai_tipe' => $this->input->post('nilai_tipe'),
					'nilai_tahun' => $this->input->post('nilai_tahun'),
					'nilai_jbus' => $this->input->post('nilai_jbus'),
					'nilai_harga' => $this->input->post('nilai_harga'),
					'foto' => $title . $ext
				);
				if ($old_image != "sp1.png") {
					if ($old_image != "") {
						unlink('./assets/img/perusahaan/' . $old_image);
					}
				}
				$result = $this->msmart->update_perusahaan($id, $isi);
				echo json_encode($isi);
			}
		}
	}

	public function delete_perusahaan()
	{
		$id = $this->input->post('id');
		$get_old_image = $this->msmart->get_foto($id);
		$old_image = $get_old_image->foto;
		unlink('./assets/img/perusahaan/' . $old_image);
		$result = $this->msmart->delete_perusahaan($id);
		echo json_encode($result);
	}

	public function jumlah_perusahaan()
	{
		return $this->msmart->count_perusahaan();
	}
}
