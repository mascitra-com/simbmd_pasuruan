<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Koreksi_kepemilikan extends MY_Controller {

	public $is_superadmin = 1;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Koreksi_model', 'koreksi');
		$this->load->model('Koreksi_detail_model', 'koreksi_detail');
		$this->load->model('Persetujuan_model', 'persetujuan');
	}

	public function index() {
		$this->load->library('Pagination');

		$filter = $this->input->get();
		$filter['status_pengajuan'] = '1';
		$filter['jenis_koreksi'] 	= '2';
		$filter['ord_by']  = 'log_time';
		$filter['ord_pos'] = 'DESC';
		$result = $this->koreksi->get_data_persetujuan($filter);

		$data['koreksi'] 	= $result['data'];
		$data['pagination'] = $this->pagination->get_pagination($result['data_count'], $filter, 'persetujuan/koreksi_kepemilikan');
		$data['filter'] 	= $filter;

		$this->render('modules/persetujuan/koreksi/kepemilikan/index', $data);
	}

	public function rincian($id = NULL)
    {
        if (empty($id))
            show_404();

        $data['koreksi'] = $this->koreksi->get($id);
        $data['rincian'] = $this->subtitute($this->koreksi->get_data_rincian($id));

        if (empty($data['koreksi'])) {
            show_404();
        }

        $this->render('modules/persetujuan/koreksi/kepemilikan/rincian', $data);
    }

    public function verifikasi() 
	{
		$data   = $this->input->post();
		$sukses = $this->persetujuan->insert($data);

		if ($sukses) {
			# BEGIN KOREKSI
			if ($data['status'] === '2') {
				$this->koreksi($data['id_koreksi']);
			}

			$sukses2 = $this->koreksi->update($data['id_koreksi'], array('status_pengajuan' => $data['status'], 'tanggal_verifikasi' => date('Y-m-d h:i')));
			if ($sukses2) {
				$this->message('Data berhasil diverifikasi', 'success');
				$this->go('persetujuan/koreksi_kepemilikan');
			} else {
				# ROLL OUT
				$this->persetujuan->delete($sukses);
			}

		} else {
			$this->message('Gagal verifikasi', 'danger');
			$this->go('persetujuan/koreksi_kepemilikan');
		}
	}

	private function koreksi($id_koreksi)
	{
		$this->load->model("aset/Temp_kiba_model", "kiba");
		$this->load->model("aset/Temp_kibb_model", "kibb");
		$this->load->model("aset/Temp_kibc_model", "kibc");
		$this->load->model("aset/Temp_kibd_model", "kibd");
		$this->load->model("aset/Temp_kibe_model", "kibe");
		
		$alfabet = array('a','b','c','d','e');
		foreach ($alfabet as $item) {
			# Ambil data
			$temp = $this->{"kib{$item}"}
			->select("temp_aset_{$item}.*, corrected_value")
			->join("koreksi_detail", "temp_aset_{$item}.id_koreksi_detail=koreksi_detail.id")
			->get_many_by('id_koreksi', $id_koreksi);

			# Ubah data ke tabel utama
			foreach ($temp as $kib) {
				$this->db
				->where('id', $kib->id_aset)
				->update("aset_{$item}", array('id_organisasi'=>$kib->corrected_value));
			}
		}
		return 1;
	}

	private function subtitute($data)
    {
		$this->load->model('Organisasi_model', 'organisasi');

    	foreach ($data AS $kib) {
    		foreach ($kib as $item) {
    			$item->corrected_value = $this->organisasi->get($item->corrected_value);
    		}
    	}
    	return $data;
    }
}