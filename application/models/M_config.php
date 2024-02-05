<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_config extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	public function det_conf()
	{
		$this->db->select('*');
		$this->db->from('tbl_conf');
		$this->db->where('id_conf', '0');
		$q = $this->db->get();
		return $q;
	}

	public function update_conf($data)
	{
		$this->db->where('id_conf', '0');
		return $this->db->update('tbl_conf', $data);
	}

}
