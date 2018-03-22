<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transfer extends MY_Controller 
{

	public $is_superadmin = 1;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Transfer_model', 'transfer');
		$this->load->model('Persetujuan_model', 'persetujuan');
	}

	public function index()
	{
		$this->load->library('Pagination');

		$filter = $this->input->get();
		$filter['status_pengajuan'] = '1';
		$filter['ord_by'] = 'log_time';
		$filter['ord_pos'] = 'DESC';
		$result = $this->transfer->get_data_persetujuan($filter);

		$data['transfer'] = $result['data'];
		$data['pagination'] = $this->pagination->get_pagination($result['data_count'], $filter, 'persetujuan/transfer');
		$data['filter'] = $filter;

		$this->render('modules/persetujuan/transfer/index', $data);
	}

	public function detail($id = null)
	{
		if (empty($id)) {
			show_404();
		}

		$data['transfer'] = $this->transfer->subtitute($this->transfer->get($id));
		$data['organisasi'] = $this->organisasi->get_data(array('jenis' => 4));

		$this->render('modules/persetujuan/transfer/detail', $data);
	}

	public function rincian($id = null)
	{
		$this->load->model('aset/Temp_kiba_model', 'kiba');
		$this->load->model('aset/Temp_kibb_model', 'kibb');
		$this->load->model('aset/Temp_kibc_model', 'kibc');
		$this->load->model('aset/Temp_kibd_model', 'kibd');
		$this->load->model('aset/Temp_kibe_model', 'kibe');

		if (empty($id)) {
			show_404();
		}

		# RINCIAN
		$data['kiba'] = $this->kiba->get_data_transfer($id);
		$data['kibb'] = $this->kibb->get_data_transfer($id);
		$data['kibc'] = $this->kibc->get_data_transfer($id);
		$data['kibd'] = $this->kibd->get_data_transfer($id);
		$data['kibe'] = $this->kibe->get_data_transfer($id);
		$data['transfer'] = $this->transfer->subtitute($this->transfer->get($id));
		$data['total_rincian'] = $this->transfer->get_total_rincian($id);

		$this->render('modules/persetujuan/transfer/rincian', $data);
	}

	public function verifikasi() 
	{
		$data = $this->input->post();
		$sukses = $this->persetujuan->insert($data);

		if ($sukses) {
			# BEGIN TRANSFER

			if ($data['status'] === '2') {
				$this->transfer($data['id_transfer']);
			}

			$sukses2 = $this->transfer->update($data['id_transfer'], array('status_pengajuan' => $data['status'], 'tanggal_verifikasi' => date('Y-m-d h:i')));
			if ($sukses2) {
				$this->message('Data berhasil diverifikasi', 'success');
				$this->go('persetujuan/transfer');
			} else {
				# ROLL OUT
				$this->persetujuan->delete($sukses);
			}

		} else {
			$this->message('Gagal verifikasi', 'danger');
			$this->go('persetujuan/transfer');
		}
	}

	private function transfer($id) 
	{
		$this->load->model("aset/Temp_kiba_model", "kiba");
		$this->load->model("aset/Temp_kibb_model", "kibb");
		$this->load->model("aset/Temp_kibc_model", "kibc");
		$this->load->model("aset/Temp_kibd_model", "kibd");
		$this->load->model("aset/Temp_kibe_model", "kibe");

		$alfabet = array('a', 'b', 'c', 'd', 'e');
		$transfer = $this->transfer->get($id);

		foreach ($alfabet as $item) {
			$kib = "kib{$item}";

			$where_in = $this->{$kib}->as_array()->get_many_by('id_transfer', $id);
			$where_in = array_column($where_in, 'id_aset');

			if (!empty($where_in)) {
				$this->db->where_in('id', $where_in)->update("aset_{$item}", array('id_organisasi' => $transfer->id_tujuan));
			}
		}

		return 1;
	}
}