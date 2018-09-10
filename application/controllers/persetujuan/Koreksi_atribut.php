<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Koreksi_atribut extends MY_Controller {
	public $is_superadmin = 1;

	public function __construct() {
		parent::__construct();
		$this->load->model('Koreksi_model', 'koreksi');
		$this->load->model('Koreksi_detail_model', 'koreksi_detail');
		$this->load->model('Persetujuan_model', 'persetujuan');
		$this->load->model('Organisasi_model', 'organisasi');
	}

	public function index() {
		$this->render('modules/persetujuan/koreksi/atribut/index');
	}

	public function get_koreksi()
	{
		$filter = $this->input->get();
		$filter['status_pengajuan'] = 1;
		$data   = $this->koreksi->api_get_data_persetujuan(5, $filter);
		echo json_encode($data);
	}

	public function verifikasi() {
		$data = $this->input->post();
		$sukses = $this->persetujuan->insert($data);

		if ($sukses) {
			# BEGIN TRANSFER
			if ($data['status'] === '2') {
				$this->save($data['id_koreksi']);
			}

			$sukses2 = $this->koreksi->update($data['id_koreksi'], array('status_pengajuan' => $data['status'], 'tanggal_verifikasi' => date('Y-m-d h:i')));
			if ($sukses2) {
				$this->message('Data berhasil diverifikasi', 'success');
				$this->go('persetujuan/koreksi_atribut');
			} else {
				# ROLL OUT
				$this->transfer->delete($sukses);
			}
		}
	}

	private function save($id_koreksi) {
		$this->load->model('aset/Kiba_model', 'kiba');
		$this->load->model('aset/Kibb_model', 'kibb');
		$this->load->model('aset/Kibc_model', 'kibc');
		$this->load->model('aset/Kibd_model', 'kibd');
		$this->load->model('aset/Kibe_model', 'kibe');
		$this->load->model('aset/Kibg_model', 'kibg');
		$this->load->model('aset/Temp_kiba_model', 'kiba_temp');
		$this->load->model('aset/Temp_kibb_model', 'kibb_temp');
		$this->load->model('aset/Temp_kibc_model', 'kibc_temp');
		$this->load->model('aset/Temp_kibd_model', 'kibd_temp');
		$this->load->model('aset/Temp_kibe_model', 'kibe_temp');
		$this->load->model('aset/Temp_kibg_model', 'kibg_temp');

		# Pindah dari Temp
		$alfabet = array('a', 'b', 'c', 'd', 'e', 'g');
		foreach ($alfabet as $item) {
			# Set nama model
			$kib = "kib{$item}";
			$kib_temp = "kib{$item}_temp";
			# Ambil data temp

			$temp = $this->{$kib_temp}->get_many_by('id_koreksi', $id_koreksi);
			foreach ($temp as $key => $value) {
				$corrected = $this->koreksi_detail->get($value->id_koreksi_detail)->corrected_value;
				$corrected = (array)json_decode($corrected);

				$this->{$kib}->update($value->id_aset, $corrected);
			}
		}

		return 1;
	}
}