<?php
class Api extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Organisasi_model', 'organisasi');
		$this->load->model('Kategori_model', 'kategori');
		$this->load->model('Ruangan_model', 'ruangan');
	}

	public function get_kategori()
	{
		$filter = $this->input->get();
		$filter['jenis'] = 5;

		if (substr($filter['search'], 0, 1) === '$') {
			$kolom = array('kd_golongan','kd_bidang','kd_kelompok','kd_subkelompok','kd_subsubkelompok');
			$tmp = explode('.', substr($filter['search'], 1));

			foreach ($tmp as $key => $value) {
				$filter[$kolom[$key]] = $value;
			}
		}else{
			$filter['nama']  = $filter['search'];
		}

		unset($filter['search']);
		echo json_encode($this->kategori->get_data_list($filter));		
	}

	public function get_organisasi()
	{
		$filter = $this->input->get();
		$filter['jenis'] = 4;

		if (substr($filter['search'], 0, 1) === '$') {
			$kolom = array('kd_bidang','kd_unit','kd_subunit','kd_upb');
			$tmp = explode('.', substr($filter['search'], 1));

			foreach ($tmp as $key => $value) {
				$filter[$kolom[$key]] = $value;
			}
		}else{
			$filter['nama']  = $filter['search'];
		}

		unset($filter['search']);
		echo json_encode($this->organisasi->get_data($filter));		
	}

	public function get_ruangan()
	{
		$filter = $this->input->get();

		$filter['kode'] = $filter['search'];
		$filter['ruangan.nama'] = $filter['search'];
		$filter['penanggung_nama'] = $filter['search'];
		$filter['penanggung_nip'] = $filter['search'];
		$filter['penanggung_jabatan'] = $filter['search'];
		$filter['organisasi.nama'] = $filter['search'];

		unset($filter['search']);
		echo json_encode($this->ruangan->get_data($filter));		
	}
}