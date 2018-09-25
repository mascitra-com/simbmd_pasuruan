<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inventarisasi extends MY_Controller {
	public $is_superadmin = 1;

	public function __construct() {
		parent::__construct();
		$this->load->model('Inventarisasi_model', 'inventarisasi');
		$this->load->model('Persetujuan_model', 'persetujuan');
		$this->load->model('Organisasi_model', 'organisasi');
	}

	public function index() {
		$this->render('modules/persetujuan/inventarisasi/index');
	}

	public function get_inventarisasi()
	{
		$filter = $this->input->get();
		$data   = $this->inventarisasi->api_get_data_persetujuan($filter);
		echo json_encode($data);
	}

	public function verifikasi() {
		$data = $this->input->post();
		$sukses = $this->persetujuan->insert($data);

		if ($sukses) {
			# BEGIN TRANSFER
			if ($data['status'] === '2') {
				$this->save($data['id_inventarisasi']);
			}

			$sukses2 = $this->inventarisasi->update($data['id_inventarisasi'], array('status_pengajuan' => $data['status'], 'tanggal_verifikasi' => date('Y-m-d h:i')));
			if ($sukses2) {
				$this->message('Data berhasil diverifikasi', 'success');
				$this->go('persetujuan/inventarisasi');
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
			$data = $this->{$kib_temp}->order_by('id_kategori')->get_many_by('id_inventarisasi', $id);
			$id_kategori = 0;

			# Proses data lebih lanjut
			if (!empty($data)) {
				foreach ($data as $key => $value)
				{
					# Ambil last_reg jika kategori berganti
					if ($id_kategori != $value->id_kategori) {
						$id_kategori = $value->id_kategori;
						$last_reg	 = $this->{$kib_temp}->get_regBarang($id_kategori);
					}

					# Isi data reg
					$value->reg_barang = $last_reg++;
					$value->reg_induk  = $this->{$kib_temp}->get_regInduk();
					# Unset data tidak perlu
					unset($value->id, $value->id_aset, $value->id_spk, $value->id_sp2d, $value->id_hibah, $value->id_hapus, $value->id_transfer, $value->id_koreksi, $value->id_koreksi_detail);
				}

				$this->{$kib}->batch_insert($data);
			}
		}

		# Kapitalisasi
		$this->load->model('Kapitalisasi_model','kapitalisasi');
		$data = $this->kapitalisasi->get_many_by('id_inventarisasi', $id);
		foreach ($data as $item) {
			# Update data pada aset utama
			$kib  = ($item->golongan=='3') ? 'kibc' : 'kibd';
			$temp = $this->{$kib}->get($item->id_aset);
			$nilai_tambah = ($this->nol($item->jumlah) * $this->nol($item->nilai)) + $this->nol($item->nilai_penunjang);
			$total 		  = $nilai_tambah + $temp->nilai_tambah;
			# Update nilai_tambah pada KIB terkait			
			$this->{$kib}->update($item->id_aset, array('nilai_tambah'=>$total));
			# Update reg_induk pada kapitalisasi
			$this->kapitalisasi->update($item->id, array('reg_induk'=>$this->kapitalisasi->get_regInduk()));
		}

		return 1;
	}

	private function nol($var)
	{
		return (empty($var)) ? 0 : $var;
	}
}