<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_proses extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		$this->load->model('M_perusahaan', 'msmart');
		$this->load->model('M_admin', 'madmin');
		$this->load->model('M_proses', 'mproses');
		$this->load->helper('smart');
	}

	public function index()
	{
		$sesi = $this->session->userdata('user');
		if (!$sesi) {
			redirect('login');
		}
		$data['title'] = 'Recommendation - Cari Rekomendasi';
		$this->load->view('template/us_head', $data);
		$this->load->view('front/find_rekomendasi', $data);
		$this->load->view('modal/mdl_adduser', $data);
		$this->load->view('template/us_foot', $data);
	}
	public function options()
	{
		$sesi = $this->session->userdata('user');
		if (!$sesi) {
			redirect('login');
		}
		$data['title'] = 'Recommendation - Cari Rekomendasi';
		$data['perusahaan'] = $this->show_perusahaan();
		$this->load->view('template/us_head', $data);
		$this->load->view('front/opsi', $data);
		$this->load->view('modal/mdl_adduser', $data);
		$this->load->view('template/us_foot', $data);
	}
	public function splithigh($value)
	{
		$val = explode("+", $value);
		return max($val);
	}
	public function bobot()
	{
		$hp = $this->input->post('hp');
		if (count($hp) < 2) {
			redirect('opsi');
		}
		$data['hp'] = $hp;
		$data['perusahaan'] = $this->show_perusahaan();
		$data['pertanyaan'] = $this->madmin->list_pertanyaan();
		$data['title'] = 'Recommendation - Pembobotan';
		$this->load->view('template/us_head', $data);
		$this->load->view('front/bobot', $data);
		$this->load->view('modal/mdl_adduser', $data);
		$this->load->view('template/us_foot', $data);
	}

	public function select_smart($id)
	{
		return $this->msmart->get_perusahaan($id);
	}
	public function select_kriteria($id_kriteria)
	{
		return $this->madmin->get_kriteria($id_kriteria);
	}
	public function show_perusahaan()
	{
		return $this->msmart->list_perusahaan();
	}

	// Memberikan bobot pada masing masing kriteria
	public function setbobot($id_kriteria, $bobot)
	{
		$result = array(
			'id_kriteria' => $id_kriteria,
			'bobot' => $bobot
		);
		return $result;
	}
	// Menghitung Normalisasi Bobot
	public function normalisasi($id_kriteria, $bobot)
	{
		$data = $this->setbobot($id_kriteria, $bobot);
		$jum = 0;
		$normalisasi = array();
		for ($i = 0; $i < sizeof($data['bobot']); $i++) {
			$jum += $data['bobot'][$i];
		}
		for ($i = 0; $i < sizeof($data['bobot']); $i++) {
			$temp_normal = 0;
			$temp_normal = $data['bobot'][$i] / $jum;
			array_push($normalisasi, $temp_normal);
		}
		$result = array(
			'id_kriteria' => $id_kriteria,
			'bobot' => $bobot,
			'normalisasi' => $normalisasi
		);
		return $result;
	}
	// Menentukan nilai Sub Kriteria sesuai dengan value kriteria
	public function setsubkriteria($id_kriteria, $hp)
	{
		$dataset = $this->msmart->getanysmart($hp);
		$subKriteria = array();

		// Looping sebanyak jumlah perusahaan yang dipilih
		for ($i = 0; $i < sizeof($dataset); $i++) {
			// Looping sebanyak jumlah kriteria
			for ($j = 0; $j < sizeof($id_kriteria); $j++) {
				// Kriteria Tipe Karoseri
				$subKriteria[$dataset[$i]->id]['subkriteria'][0] = $dataset[$i]->nilai_tipe;
				$subKriteria[$dataset[$i]->id]['subkriteria'][1] = $dataset[$i]->nilai_toilet;
				$subKriteria[$dataset[$i]->id]['subkriteria'][2] = $dataset[$i]->nilai_smoking;
				$subKriteria[$dataset[$i]->id]['subkriteria'][3] = $dataset[$i]->nilai_tseat;
				$subKriteria[$dataset[$i]->id]['subkriteria'][4] = $dataset[$i]->nilai_kapasitas;
				$subKriteria[$dataset[$i]->id]['subkriteria'][5] = $dataset[$i]->nilai_cepat;
				$subKriteria[$dataset[$i]->id]['subkriteria'][6] = $dataset[$i]->nilai_tahun;
				$subKriteria[$dataset[$i]->id]['subkriteria'][7] = $dataset[$i]->nilai_jbus;
				$subKriteria[$dataset[$i]->id]['subkriteria'][8] = $dataset[$i]->nilai_harga;
			}
		}

		return $subKriteria;
	}
	// Menghitung Utilities Score dengan Rumus = (Cout-Cmin)/(Cmax-Cmin)
	public function getValueUtilities($id_kriteria, $hp)
	{
		$data = $this->setsubkriteria($id_kriteria, $hp);
		$temp_data = array();
		foreach ($id_kriteria as $key => $value) {
			$temp_data[] =  $key;
		}
		for ($i = 0; $i < sizeof($data); $i++) {
			$max = max($data[$hp[$i]]['subkriteria']);
			$min = min($data[$hp[$i]]['subkriteria']);
			for ($j = 0; $j < sizeof($id_kriteria); $j++) {
				if ($j == $temp_data[$j]) {
					if ($data[$hp[$i]]['subkriteria'][$j] - $min !== 0 || $max - $min !== 0) {
						$cout = ($data[$hp[$i]]['subkriteria'][$j] - $min) / (($max - $min));
						$data[$hp[$i]]['value_utilities'][$j] = $cout;
					} else {
						$cout = 0;
						$data[$hp[$i]]['value_utilities'][$j] = $cout;
					}
				}
			}
		}

		return $data;
	}
	// Mengalikan Utilities Score dengan Normalisasi
	public function getScore($id_kriteria, $hp, $bobot)
	{
		$data = $this->getValueUtilities($id_kriteria, $hp);
		$normalisasi = $this->normalisasi($id_kriteria, $bobot);
		$temp_data = array();
		foreach ($id_kriteria as $key => $value) {
			$temp_data[] =  $key;
		}
		for ($i = 0; $i < sizeof($data); $i++) {
			for ($j = 0; $j < sizeof($id_kriteria); $j++) {
				if ($j == $temp_data[$j]) {
					$total = $data[$hp[$i]]['value_utilities'][$j] * $normalisasi['normalisasi'][$j];
					$data[$hp[$i]]['normalisasi'][$j] = $normalisasi['normalisasi'][$j];
					$data[$hp[$i]]['total'][$j] = $total;
				}
			}
		}
		return $data;
	}
	// Mendapatkan Score Akhir Perhitungan
	public function getTotalScore($id_kriteria, $hp, $bobot)
	{
		$data = $this->getScore($id_kriteria, $hp, $bobot);
		$temp_data = array();
		for ($i = 0; $i < sizeof($data); $i++) {
			$temp_data[] =  $i;
		}
		for ($i = 0; $i < sizeof($data); $i++) {
			if ($i == $temp_data[$i]) {
				$score = array_sum($data[$hp[$i]]['total']);
				$data[$hp[$i]]['final_score'][0] = $score;
			}
		}
		return $data;
	}
	// Proses Perhitungan
	public function insertPerhitungan($id_kriteria, $hp, $bobot)
	{
		$createPerhitungan = $this->mproses->createPerhitungan();
		if ($createPerhitungan) {
			$getLastIdPerhitungan = $this->mproses->getLastIdPerhitungan();
			$id_perhitungan = $getLastIdPerhitungan->id_perhitungan;
			$perhitungan = $this->getTotalScore($id_kriteria, $hp, $bobot);
			$isInsert = false;
			$isInsertNormal = false;


			for ($i = 0; $i < sizeof($perhitungan); $i++) {
				$temp_hp = $hp[$i];
				$temp_score = $perhitungan[$hp[$i]]['final_score'][0];
				$val = array(
					'id_perhitungan' => $id_perhitungan,
					'id_perusahaan' => $temp_hp,
					'skor_akhir' => $temp_score,
					'id_user' => $this->session->userdata('user')['id_user']
				);
				$data = $this->mproses->insertDetailPerhitungan($val);
				$isInsert = $data ? true : false;

				if ($isInsert) {
					$getLastIdDetailPerhitungan = $this->mproses->getLastIdDetailPerhitungan();
					$id_detail = $getLastIdDetailPerhitungan->id_detail;
					for ($j = 0; $j < sizeof($id_kriteria); $j++) {
						$temp_normalisasi = $perhitungan[$hp[$i]]['normalisasi'][$j];
						$temp_utility = $perhitungan[$hp[$i]]['value_utilities'][$j];
						$normal = array(
							'id_detail' => $id_detail,
							'normalisasi' => $temp_normalisasi,
							'utilities' => $temp_utility
						);
						$dataNormal = $this->mproses->insertNormalisasi($normal);
						$isInsertNormal = $dataNormal ? true : false;
						if (!$isInsertNormal) {
							return false;
						}
					}
				} else {
					return false;
				}
			}
			$SMART = array(
				'id_perusahaan' => $hp,
				'id_kriteria' => $id_kriteria,
				'bobot' => $bobot,
				'perhitungan' => $perhitungan
			);
			return $SMART;
		} else {
			return false;
		}
	}
	// Trying Ajax
	public function countdata()
	{
		$bobot = array();
		for ($i = 1; $i <= $this->madmin->pertanyaan_all(); $i++) {
			$bbt = $this->input->post('bobot' . $i);
			$bobot[] .= $bbt;
		}
		$id_kriteria = $this->input->post('id_kriteria');
		$hp = $this->input->post('hp');
		$perusahaan = $this->show_perusahaan();
		$createPerhitungan = $this->mproses->createPerhitungan();
		if ($createPerhitungan) {
			$getLastIdPerhitungan = $this->mproses->getLastIdPerhitungan();
			$id_perhitungan = $getLastIdPerhitungan->id_perhitungan;
			$perhitungan = $this->getTotalScore($id_kriteria, $hp, $bobot);
			$isInsert = false;
			$isInsertNormal = false;


			for ($i = 0; $i < sizeof($perhitungan); $i++) {
				$temp_hp = $hp[$i];
				$temp_score = $perhitungan[$hp[$i]]['final_score'][0];
				$val = array(
					'id_perhitungan' => $id_perhitungan,
					'id_perusahaan' => $temp_hp,
					'skor_akhir' => $temp_score
				);
				$data = $this->mproses->insertDetailPerhitungan($val);
				$isInsert = $data ? true : false;

				if ($isInsert) {
					$getLastIdDetailPerhitungan = $this->mproses->getLastIdDetailPerhitungan();
					$id_detail = $getLastIdDetailPerhitungan->id_detail;
					for ($j = 0; $j < sizeof($id_kriteria); $j++) {
						$temp_normalisasi = $perhitungan[$hp[$i]]['normalisasi'][$j];
						$temp_utility = $perhitungan[$hp[$i]]['value_utilities'][$j];
						$normal = array(
							'id_detail' => $id_detail,
							'normalisasi' => $temp_normalisasi,
							'utilities' => $temp_utility
						);
						$dataNormal = $this->mproses->insertNormalisasi($normal);
						$isInsertNormal = $dataNormal ? true : false;
						if (!$isInsertNormal) {
							return false;
						}
					}
				} else {
					return false;
				}
			}
			$SMART = array(
				'id_perusahaan' => $hp,
				'id_kriteria' => $id_kriteria,
				'bobot' => $bobot,
				'perhitungan' => $perhitungan
			);
			echo json_encode($SMART);
		} else {
			return false;
		}
	}
	public function PerhitunganTerakhir()
	{
	}

	public function result()
	{
		$bobot = array();
		for ($i = 1; $i <= $this->madmin->pertanyaan_all(); $i++) {
			$bbt = $this->input->post('bobot' . $i);
			$bobot[] .= $bbt;
		}
		$id_kriteria = $this->input->post('id_kriteria');
		$hp = $this->input->post('hp');
		$perusahaan = $this->show_perusahaan();
		if (empty($bobot) || empty($hp)) {
			redirect('pembobotan');
		}
		if (count($hp) == sizeof($perusahaan)) {
			$limit = 8;
		} else {
			$limit = count($hp);
		}
		if ($hp || $id_kriteria) {
			$data['hasil'] = $this->insertPerhitungan($id_kriteria, $hp, $bobot);
		}
		$data['title'] = 'Hasil Rekomendasi';
		$data['limit'] = $limit;
		$this->load->view('template/us_head', $data);
		$this->load->view('front/hasil', $data);
		$this->load->view('modal/mdl_adduser', $data);
		$this->load->view('template/us_foot', $data);
	}

	public function pushdata()
	{
		$id = $this->input->post('hp');
		$arr = array();
		if (false !== $key = array_search($id, $arr)) {
			unset($arr[$key]);
		} else {
			array_push($arr, $id);
		}
		// return $arr;
		echo json_encode($arr);
	}

	public function getdata()
	{
		$hp = $this->input->post('hp');
		if ($hp) {
			for ($i = 0; $i < count($hp); $i++) {
				$data = $this->msmart->get_perusahaan($hp[$i]);
				$get[] = $data;
			}
			echo json_encode($get);
		} else {
			echo "Tidak Ada Pilihan";
		}
	}

	public function olahdata()
	{
		$numbers = preg_replace('/[^0-9]/', '', $str);
		$decimal = preg_replace('/[^0-9\.,]/', '', $str);
		$letters = preg_replace('/[^a-zA-Z]/', '', $str);
	}

	public function get_log()
	{
		$id_user = $this->session->userdata('user')['id_user'];
		$data = $this->mproses->search_log($id_user);
		echo json_encode($data);
	}

	public function history()
	{
		$sesi = $this->session->userdata('user');
		if (!$sesi) {
			redirect('login');
		}
		if ($this->mproses->search_log($this->session->userdata('user')['id_user'])) {
			$status = TRUE;
		} else {
			$status = FALSE;
		}
		$data['title'] = 'Recommendation - Riwayat Pencarian';
		$data['status'] = $status;
		$this->load->view('template/us_head', $data);
		$this->load->view('front/riwayat', $data);
		$this->load->view('modal/mdl_adduser', $data);
		$this->load->view('template/us_foot', $data);
	}
}
