<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_admin extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	public function list_admin()
	{
		$this->db->select('id_admin,username,nama,hak_akses,last_login');
		$this->db->from('tbl_admin');
		$q = $this->db->get();
		return $q->result();
	}
	public function get_admin($id_admin)
	{
		$this->db->select('*');
		$this->db->from('tbl_admin');
		$this->db->where('id_admin', $id_admin);

		$q = $this->db->get();
		return $q->row();
	}
	public function insert_admin($data)
	{
		$this->db->insert('tbl_admin', $data);
		return $this->db->insert_id();
	}
	public function update_admin($id_admin,$data)
	{
		$this->db->where('id_admin', $id_admin);
		return $this->db->update('tbl_admin', $data);
	}
	public function delete_admin($id_admin)
	{
		$this->db->where('id_admin', $id_admin);
		return $this->db->delete('tbl_admin');
	}

	public function list_kriteria()
	{
		$query = $this->db->get('tbl_kriteria');
		return $query->result();
	}
	public function get_kriteria($id_kriteria)
	{
		$this->db->select('*');
		$this->db->from('tbl_kriteria');
		$this->db->where('id_kriteria', $id_kriteria);

		$q = $this->db->get();
		return $q->row();
	}
	public function get_kriteria_by_name($name)
	{
		$query = "SELECT * FROM tbl_kriteria WHERE kriteria LIKE '%".$name."%'";
		
		$result = $this->db->query($query);

		return $result->row();
	}
	public function update_kriteria($id_kriteria,$data)
	{
		$this->db->where('id_kriteria', $id_kriteria);
		return $this->db->update('tbl_kriteria', $data);
	}
	public function insert_kriteria($data)
	{
		$this->db->insert('tbl_kriteria',$data);
		return $this->db->insert_id();
	}
	public function delete_kriteria($id)
	{
		$this->db->where('id_kriteria', $id);
		return $this->db->delete('tbl_kriteria');
	}
	public function kriteria_all()
	{
		$this->db->from('tbl_kriteria');
		return $this->db->count_all_results();
	}

	public function list_pertanyaan()
	{
		$this->db->select('id_pertanyaan, pertanyaan, tbl_kriteria.id_kriteria, tbl_kriteria.kriteria');
		$this->db->from('tbl_pertanyaan');
		$this->db->join('tbl_kriteria', 'tbl_pertanyaan.id_kriteria = tbl_kriteria.id_kriteria', 'inner');
		$q = $this->db->get();
		return $q->result();
	}
	public function get_pertanyaan($id_pertanyaan)
	{
		$this->db->select('id_pertanyaan, pertanyaan, tbl_kriteria.id_kriteria, tbl_kriteria.kriteria');
		$this->db->from('tbl_pertanyaan');
		$this->db->join('tbl_kriteria', 'tbl_pertanyaan.id_kriteria = tbl_kriteria.id_kriteria', 'inner');
		$this->db->where('tbl_pertanyaan.id_pertanyaan', $id_pertanyaan);

		$q = $this->db->get();
		return $q->row();
	}
	public function update_pertanyaan($id_pertanyaan,$data)
	{
		$this->db->where('id_pertanyaan', $id_pertanyaan);
		return $this->db->update('tbl_pertanyaan', $data);
	}
	public function pertanyaan_all()
	{
		$this->db->from('tbl_pertanyaan');
		return $this->db->count_all_results();
	}

	public function list_perhitungan()
	{
		$this->db->select('tbl_perhitungan.tanggal, tbl_perusahaan.namap, tbl_perusahaan.bentuk, tbl_detail_perhitungan.id_detail, tbl_detail_perhitungan.id_perhitungan, tbl_detail_perhitungan.skor_akhir, tbl_user.nama');
		$this->db->from('tbl_detail_perhitungan');
		$this->db->join('tbl_perusahaan', 'tbl_detail_perhitungan.id_perusahaan = tbl_perusahaan.id', 'inner');
		$this->db->join('tbl_perhitungan', 'tbl_detail_perhitungan.id_perhitungan = tbl_perhitungan.id_perhitungan', 'inner');
		$this->db->join('tbl_user', 'tbl_detail_perhitungan.id_user = tbl_user.id_user', 'inner');
		$q = $this->db->get();
		return $q->result();
	}
	public function perhitungan_all()
	{
		$this->db->from('tbl_perhitungan');
		return $this->db->count_all_results();
	}
	public function _get_datatables_query()
	{
		$i = 0;
		$order = ['tanggal'=>'asc'];
		$column_order = array(null,'tanggal','namap','skor_akhir','nama');
		$column_search = array('tanggal','namap','bentuk','skor_akhir','nama');
		$this->db->select('tbl_perhitungan.tanggal, tbl_perusahaan.namap, tbl_perusahaan.bentuk, tbl_detail_perhitungan.id_detail, tbl_detail_perhitungan.id_perhitungan, tbl_detail_perhitungan.skor_akhir, tbl_user.nama');
		$this->db->from('tbl_detail_perhitungan');
		$this->db->join('tbl_perusahaan', 'tbl_detail_perhitungan.id_perusahaan = tbl_perusahaan.id', 'inner');
		$this->db->join('tbl_perhitungan', 'tbl_detail_perhitungan.id_perhitungan = tbl_perhitungan.id_perhitungan', 'inner');
		$this->db->join('tbl_user', 'tbl_detail_perhitungan.id_user = tbl_user.id_user', 'inner');
		foreach ($column_search as $item) {
			if ($_POST['search']['value']) {
				if ($i===0) {
					$this->db->group_start();
					$this->db->like($item, $_POST['search']['value']);
				} else {
					$this->db->or_like($item, $_POST['search']['value']);
				}
				if (count($column_search) - 1 == $i) {
					$this->db->group_end();
				}
			}
			$i++;
			if (isset($_POST['order'])) {
				$this->db->order_by($column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
			} elseif (isset($order)) {
				$this->db->order_by(key($order), $order[key($order)]);
			}
		}
	}
	public function detailPerhitungan($id)
	{
		$query = "SELECT a.id_detail,a.normalisasi,a.utilities,b.id_perhitungan,b.id_perusahaan,b.id_user,b.skor_akhir,
		c.namap,c.bentuk,d.nama
		FROM tbl_normalisasi a 
		LEFT JOIN tbl_detail_perhitungan b ON a.id_detail = b.id_detail
		LEFT JOIN tbl_perusahaan c ON b.id_perusahaan = c.id
		LEFT JOIN tbl_user d ON b.id_user = d.id_user
		WHERE a.id_detail = ?";

		$result = $this->db->query($query,$id);

		return $result->result();
	}
	function get_datatables()
	{
		$this->_get_datatables_query();
		if($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}
	function count_filtered()
	{
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}
	public function count_all()
	{
		$this->db->from('tbl_detail_perhitungan');
		return $this->db->count_all_results();
	}

	public function most_frequent()
	{
		$this->db->select('count(tbl_detail_perhitungan.id_perusahaan) as id_perusahaan, tbl_perusahaan.namap, tbl_perusahaan.bentuk');
		$this->db->from('tbl_detail_perhitungan');
		$this->db->join('tbl_perusahaan', 'tbl_detail_perhitungan.id_perusahaan = tbl_perusahaan.id', 'inner');
		$this->db->group_by('tbl_detail_perhitungan.id_perusahaan');
		$this->db->order_by('id_perusahaan', 'desc');
		$this->db->limit(1);
		$q = $this->db->get();
		return $q->row();
	}

	public function list_user()
	{
		$this->db->select('id_user,username,nama,last_login');
		$this->db->from('tbl_user');
		$q = $this->db->get();
		return $q->result();
	}
	public function get_user($id_user)
	{
		$this->db->select('*');
		$this->db->from('tbl_user');
		$this->db->where('id_user', $id_user);

		$q = $this->db->get();
		return $q->row();
	}
	public function insert_user($data)
	{
		$this->db->insert('tbl_user', $data);
		return $this->db->insert_id();
	}
	public function update_user($id_user,$data)
	{
		$this->db->where('id_user', $id_user);
		return $this->db->update('tbl_user', $data);
	}
	public function delete_user($id_user)
	{
		$this->db->where('id_user', $id_user);
		return $this->db->delete('tbl_user');
	}

	public function cekusername_user($username)
	{
		$this->db->select('username');
		$this->db->from('tbl_user');
		$this->db->where('username', $username);
		$q = $this->db->get();
		return $q->row();
	}
	public function cekusername_admin($username)
	{
		$this->db->select('username');
		$this->db->from('tbl_admin');
		$this->db->where('username', $username);
		$q = $this->db->get();
		return $q->row();
	}

	public function chart_data()
	{
		$this->db->select('date_format(tbl_perhitungan.tanggal, "%Y-%m-%d") as tanggal, COUNT(tanggal) as jumlah');
		$this->db->from('tbl_perhitungan');
		$this->db->group_by('date_format(tbl_perhitungan.tanggal, "%Y-%m-%d")');
		$res = $this->db->get();
		return $res->result();
	}

}