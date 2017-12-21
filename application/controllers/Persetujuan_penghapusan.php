<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Persetujuan_penghapusan extends MY_Controller {

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
		$data['pagination'] = $this->pagination->get_pagination($result['data_count'], $filter, 'persetujuan_penghapusan');
		$data['filter'] = $filter;

		$this->render('modules/persetujuan/penghapusan/index', $data);
	}

	public function detail($id = null) {
		if (empty($id)) {
			show_404();
		}

		$data['hapus'] = $this->hapus->subtitute($this->hapus->get($id));
		$data['organisasi'] = $this->organisasi->get_data(array('jenis' => 4));

		$this->render('modules/persetujuan/penghapusan/detail', $data);
	}

	public function rincian($id = null) {
		$this->load->model('aset/Kiba_temp_model', 'kiba');
		$this->load->model('aset/Kibb_temp_model', 'kibb');
		$this->load->model('aset/Kibc_temp_model', 'kibc');
		$this->load->model('aset/Kibd_temp_model', 'kibd');
		$this->load->model('aset/Kibe_temp_model', 'kibe');

		if (empty($id)) {
			show_404();
		}

		# RINCIAN
		$data['kiba'] = $this->kiba->get_data_hapus($id);
		$data['kibb'] = $this->kibb->get_data_hapus($id);
		$data['kibc'] = $this->kibc->get_data_hapus($id);
		$data['kibd'] = $this->kibd->get_data_hapus($id);
		$data['kibe'] = $this->kibe->get_data_hapus($id);
		$data['hapus'] = $this->hapus->subtitute($this->hapus->get($id));

		$this->render('modules/persetujuan/penghapusan/rincian', $data);
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
				$this->go('persetujuan_penghapusan');
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
		$this->load->model("aset/Kiba_temp_model", "kiba");
		$this->load->model("aset/Kibb_temp_model", "kibb");
		$this->load->model("aset/Kibc_temp_model", "kibc");
		$this->load->model("aset/Kibd_temp_model", "kibd");
		$this->load->model("aset/Kibe_temp_model", "kibe");

		$alfabet = array('a', 'b', 'c', 'd', 'e');

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

    public function get_persetujuan($id) {

        $data = $this->persetujuan->order_by('log_time', 'DESC')->limit(1)->as_array()->get_by('id_hapus', $id);

        if (!empty($data)) {
            $data['log_time'] = datify($data['log_time'], 'd/m/Y h:i');
            $data['status'] = $data['status'] === '2' ? '<span class="badge badge-success">disetujui</span>' : '<span class="badge badge-danger">ditolak</span>';
        }

        echo json_encode($data);
    }
}