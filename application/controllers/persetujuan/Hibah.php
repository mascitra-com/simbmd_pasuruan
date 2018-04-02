<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hibah extends MY_Controller {

	public $is_superadmin = 1;

	public function __construct() {
		parent::__construct();
		$this->load->model('Hibah_model', 'hibah');
        $this->load->model('Persetujuan_model', 'persetujuan');
        $this->load->model('Organisasi_model', 'organisasi');
    }

	public function index() {
		$this->load->library('Pagination');

		$filter = $this->input->get();
		$filter['status_pengajuan'] = '1';
		$filter['ord_by'] = 'log_time';
		$filter['ord_pos'] = 'DESC';
		$result = $this->hibah->get_data_persetujuan($filter);

		$data['hibah'] = $result['data'];
		$data['pagination'] = $this->pagination->get_pagination($result['data_count'], $filter, 'persetujuan/hibah');
		$data['filter'] = $filter;

		$this->render('modules/persetujuan/hibah/index', $data);
	}

	public function detail($id = null) {
		if (empty($id)) {
			show_404();
		}

		$data['hibah'] = $this->hibah->subtitute($this->hibah->get($id));
		$data['organisasi'] = $this->organisasi->get_data(array('jenis' => 4));

		$this->render('modules/persetujuan/hibah/detail', $data);
	}

	public function rincian($id = null) {
		$this->load->model('aset/Temp_kiba_model', 'kiba');
		$this->load->model('aset/Temp_kibb_model', 'kibb');
		$this->load->model('aset/Temp_kibc_model', 'kibc');
		$this->load->model('aset/Temp_kibd_model', 'kibd');
		$this->load->model('aset/Temp_kibe_model', 'kibe');
		$this->load->model('aset/Temp_kibg_model', 'kibg');
        $this->load->model('Kapitalisasi_model', 'kapitalisasi');

		if (empty($id)) {
			show_404();
		}

		# RINCIAN
		$data['kiba'] = $this->kiba->get_data_hibah($id);
		$data['kibb'] = $this->kibb->get_data_hibah($id);
		$data['kibc'] = $this->kibc->get_data_hibah($id);
		$data['kibd'] = $this->kibd->get_data_hibah($id);
		$data['kibe'] = $this->kibe->get_data_hibah($id);
		$data['kibg'] = $this->kibg->get_data_hibah($id);
        $data['kpt'] = $this->kapitalisasi->get_data_hibah($id);
        $data['hibah'] = $this->hibah->subtitute($this->hibah->get($id));
		$data['total_rincian'] = $this->hibah->get_total_rincian($id);

		$this->render('modules/persetujuan/hibah/rincian', $data);
	}

	public function verifikasi() {
		$data = $this->input->post();
		$sukses = $this->persetujuan->insert($data);

		if ($sukses) {
			# BEGIN TRANSFER
			if ($data['status'] === '2') {
				$this->save($data['id_hibah']);
			}
			$sukses2 = $this->hibah->update($data['id_hibah'], array('status_pengajuan' => $data['status'], 'tanggal_verifikasi' => date('Y-m-d h:i')));
			if ($sukses2) {
				$this->message('Data berhasil diverifikasi', 'success');
				$this->go('persetujuan/hibah');
			} else {
				# ROLL OUT
				$this->transfer->delete($sukses);
			}

		} else {
			$this->message('', 'danger');
			$this->go('');
		}
	}

	private function save($id) {
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
			$data = $this->{$kib_temp}->order_by('id_kategori')->get_many_by('id_hibah', $id);
			$id_kategori = 0;

			# Proses data lebih lanjut
			if (!empty($data)) {
				foreach ($data as $key => $value)
				{
					# Ambil last_reg jika kategori berganti
					if ($id_kategori != $value->id_kategori) {
						$id_kategori = $value->id_kategori;
						$last_reg	 = $this->{$kib_temp}->get_reg_barang($id_kategori);
					}

					# Isi data reg
					$value->reg_barang = $last_reg++;
					$value->reg_induk  = strtoupper(uniqid().'.'.date('dmYhis'));
					# Unset data tidak perlu
					unset($value->id, $value->id_aset, $value->id_hapus, $value->id_transfer, $value->id_koreksi, $value->id_koreksi_detail);
				}

				$this->{$kib}->batch_insert($data);
			}
		}

		# Kapitalisasi
		$this->load->model('Kapitalisasi_model','kapitalisasi');
		$data = $this->kapitalisasi->get_many_by('id_hibah', $id);
		foreach ($data as $item) {
			# Update data pada aset utama
			$kib  = ($item->golongan==='3') ? 'kibc' : 'kibd';
			$temp = $this->{$kib}->get($item->id_aset);
			$nilai_tambah = ($this->nol($item->jumlah) * $this->nol($item->nilai)) + $this->nol($item->nilai_penunjang);
			$total 		  = $nilai_tambah + $temp->nilai_tambah;
			$sukses 	  = $this->{$kib}->update($item->id_aset, array('nilai_tambah'=>$total));
		}

		return 1;
	}

	private function nol($var)
	{
		return (empty($var)) ? 0 : $var;
	}
}