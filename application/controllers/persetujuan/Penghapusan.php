<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penghapusan extends MY_Controller {

	public $is_superadmin = 1;

	public function __construct() {
		parent::__construct();
		$this->load->model('Penghapusan_model', 'hapus');
		$this->load->model('Persetujuan_model', 'persetujuan');
	}

	public function index() {
		$this->load->library('Pagination');

		$filter = $this->input->get();
		$filter['status_pengajuan'] = '1';
		$filter['ord_by'] = 'log_time';
		$filter['ord_pos'] = 'DESC';
		$result = $this->hapus->get_data_persetujuan($filter);

		$data['hapus'] = $result['data'];
		$data['pagination'] = $this->pagination->get_pagination($result['data_count'], $filter, 'persetujuan/penghapusan');
		$data['filter'] = $filter;

		$this->render('modules/persetujuan/penghapusan/index', $data);
	}

	public function verifikasi() {
		$data = $this->input->post();
		$sukses = $this->persetujuan->insert($data);

		if ($sukses) {
			# BEGIN TRANSFER
			if ($data['status'] === '2') {
				$this->hapus($data['id_hapus']);
			}
			$sukses2 = $this->hapus->update($data['id_hapus'], array('status_pengajuan' => $data['status'], 'tanggal_verifikasi' => date('Y-m-d h:i')));
			if ($sukses2) {
				$this->message('Data berhasil diverifikasi', 'success');
				$this->go('persetujuan/penghapusan');
			} else {
				# ROLL OUT
				$this->transfer->delete($sukses);
			}

		} else {
			$this->message('', 'danger');
			$this->go('');
		}
	}

	private function hapus($id) {
		$this->load->model("aset/Temp_kiba_model", "kiba");
		$this->load->model("aset/Temp_kibb_model", "kibb");
		$this->load->model("aset/Temp_kibc_model", "kibc");
		$this->load->model("aset/Temp_kibd_model", "kibd");
		$this->load->model("aset/Temp_kibe_model", "kibe");
		$this->load->model("aset/Temp_kibg_model", "kibg");

		$alfabet = array('a', 'b', 'c', 'd', 'e', 'g');

		foreach ($alfabet as $item) {
			$kib = "kib{$item}";

			$where_in = $this->{$kib}->as_array()->get_many_by('id_hapus', $id);
			$where_in = array_column($where_in, 'id_aset');

			if (!empty($where_in)) {
				$this->db->where_in('id', $where_in)->delete("aset_{$item}");
			}
		}

		return 1;
	}
}