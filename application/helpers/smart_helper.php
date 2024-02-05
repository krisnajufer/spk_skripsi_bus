<?php
function select_smart($id)
{
	$CI = get_instance();
	$CI->load->model('M_perusahaan','msmart');
	return $CI->msmart->get_perusahaan($id);
}
function select_kriteria($id_kriteria)
{
	$CI = get_instance();
	$CI->load->model('M_admin','madmin');
	return $CI->madmin->get_kriteria($id_kriteria);
}
?>