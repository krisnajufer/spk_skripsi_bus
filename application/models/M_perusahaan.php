<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_perusahaan extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	function _get_datatables_query()
	{
		$table = 'tbl_perusahaan';
		$order = array('namap' => 'asc');
		$column_order = array(null,'namap','bentuk','tipe','toilet','smoking','kapasitas','cepat','jenis','tahun','jbus','harga');
		$column_search = array('namap','bentuk','tipe','toilet','smoking','kapasitas','tseat','cepat','jenis','tahun','jbus','harga');

		$this->db->from('tbl_perusahaan');
		$i = 0;
		foreach ($column_search as $item) 
		{
			if($_POST['search']['value']) 
			{
				if($i===0) 
				{
					$this->db->group_start();
					$this->db->like($item, $_POST['search']['value']);
				}
				else
				{
					$this->db->or_like($item, $_POST['search']['value']);
				}
				if(count($column_search) - 1 == $i) 
				{
					$this->db->group_end(); 
				}
			}
			$i++;
		}
		if(isset($_POST['order'])) 
		{
			$this->db->order_by($column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		}
		else if(isset($order))
		{
			$this->db->order_by(key($order), $order[key($order)]);
		}
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
		$this->db->from('tbl_perusahaan');
		return $this->db->count_all_results();
	}
	public function get_by_id($id)
	{
		$this->db->from('tbl_perusahaan');
		$this->db->where('id',$id);
		$query = $this->db->get();

		return $query->row();
	}
	public function seg($rowperpage,$rowno)
	{
		$this->db->from('tbl_perusahaan')->limit($rowperpage,$rowno);
		$this->db->order_by('namap', 'ASC');
		$this->db->order_by('bentuk', 'ASC');
		$this->db->order_by('toilet', 'ASC');
		$this->db->order_by('smoking', 'ASC');
		$q = $this->db->get();
		return $q->result_array();
	}
	public function getanysmart($id)
	{
		$this->db->select('*');
		$this->db->from('tbl_perusahaan');
		$this->db->where_in('id', $id);
		$query = $this->db->get();

		return $query->result();
	}

	public function list_perusahaan()
	{
		$this->db->select('*');
		$this->db->from('tbl_perusahaan');
		$this->db->order_by('namap', 'ASC');
		$this->db->order_by('bentuk', 'ASC');
		$this->db->order_by('toilet', 'ASC');
		$this->db->order_by('smoking', 'ASC');
		$query = $this->db->get();
		return $query->result();
	}

	public function get_perusahaan($id)
	{
		$this->db->select('*');
		$this->db->from('tbl_perusahaan');
		$this->db->where('id', $id);

		$q = $this->db->get();
		return $q->row();
	}

	public function insert_perusahaan($data)
	{
		$this->db->insert('tbl_perusahaan', $data);
		return $this->db->insert_id();
	}

	public function update_perusahaan($id,$data)
	{
		$this->db->where('id', $id);
		return $this->db->update('tbl_perusahaan', $data);
	}

	public function delete_perusahaan($id)
	{
		$this->db->where('id', $id);
		return $this->db->delete('tbl_perusahaan');
	}

	public function count_perusahaan()
	{
		$this->db->select('*');
		$this->db->from('tbl_perusahaan');
		$r = $this->db->get();
		return $r->num_rows();
	}

	public function get_foto($id)
	{
		$this->db->select('foto');
		$this->db->from('tbl_perusahaan');
		$this->db->where('id', $id);

		$q = $this->db->get();
		return $q->row();
	}

	public function filter_smart($param,$cari_namap,$rowperpage,$rowno)
	{
		$this->db->select('*')->limit($rowperpage,$rowno);;
		$this->db->from('tbl_perusahaan');
		if ($param == "harga_rendah") {
			$sort = $this->db->order_by('harga', 'asc');
		} elseif ($param == "harga_tinggi") {
			$sort = $this->db->order_by('harga', 'desc');
		} elseif ($param == "toilet_tinggi") {
			$sort = $this->db->order_by('toilet', 'desc');
		} elseif ($param == "toilet_rendah") {
			$sort = $this->db->order_by('toilet', 'asc');
		} elseif ($param == "smoking_tinggi") {
			$sort = $this->db->order_by('smoking', 'desc');
		} elseif ($param == "smoking_rendah") {
			$sort = $this->db->order_by('smoking', 'asc');
		}
		if (empty($cari_namap)) {
			$by_namap = '';
		} else {
			$by_namap = $this->db->where('namap', $cari_namap);
		}
		
		$sort;
		$query = $this->db->get();
		return $query->result();
	}

	public function bynamap()
	{
		$this->db->select('namap');
		$this->db->from('tbl_perusahaan');
		$this->db->group_by('namap');
		$query = $this->db->get();
		return $query->result();
	}

	public function count_all_by_namap($namap)
	{
		$this->db->select('*');
		$this->db->from('tbl_perusahaan');
		$this->db->where('namap', $namap);
		$r = $this->db->get();
		return $r->num_rows();
	}

}
