<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pelunasan extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Organisasi_model', 'organisasi');
		$this->load->model('Pelunasan_model', 'pelunasan');
	}
	
	public function index()
	{
		$filter = $this->input->get();
		$filter['id_organisasi'] = isset($filter['id_organisasi']) ? $filter['id_organisasi'] : '';

		$data['pelunasan']  = $this->pelunasan->get_data($filter);
		$data['organisasi'] = $this->organisasi->get_data_by_auth();
		$data['filter'] 	= $filter;
		
		$this->render('modules/pelunasan/index', $data);
	}

	public function add($id_organisasi = null)
	{
		if(empty($id_organisasi)){
			$this->message('pilih organisasi terlebih dahulu', 'danger');
			$this->go('pelunasan');
		}

		$data['id_organisasi'] = $id_organisasi;
		$this->render('modules/pelunasan/form', $data);
	}

	public function insert()
	{
		$data = $this->input->post();

		if (!$this->pelunasan->form_verify($data)) {
			$this->message('Isi data yang wajib diisi');
			$this->go('pelunasan/add/'.$data['id_organisasi']);
		}

		$this->load->model("aset/Kib{$data['kib']}_model", "kib");
		$this->load->model("aset/Temp_kib{$data['kib']}_model", "kib_temp");

		$aset = $this->kib->get($data['id_aset']);
		$kdp  = $this->kib->get($data['id_kdp']);


		# INSERT PELUNASAN
		$data['id_kdp_spk']   = $kdp->id_spk;
		$data['id_kdp_sp2d']  = $kdp->id_sp2d;
		$data['id_kdp_hibah'] = $kdp->id_hibah;
		$sukses = $this->pelunasan->insert($data);

		if($sukses) {

			# Pindah KDP ke TEMP
			$kdp->id_aset = $kdp->id;
			unset($kdp->id, $kdp->id_spk, $kdp->id_sp2d, $kdp->id_hibah, $kdp->log_action, $kdp->log_user, $kdp->log_time);
			$sukses_2a = $this->kib_temp->insert((array)$kdp);

			# Update nilai ASET
			$sukses_2b = TRUE;
			if (isset($data['akumulasi_kdp']) AND $data['akumulasi_kdp'] === '1') {
				$nilai_tambah = $aset->nilai + $kdp->nilai;
				$sukses_2b = $this->kib->update($aset->id, array('nilai'=>$nilai_tambah));
			}

			if($sukses_2a && $sukses_2b) {
				# HAPUS KDP
				$sukses_3 = $this->kib->delete($data['id_kdp']);
				if($sukses_3) {
					$this->message('Pelunasan Berhasil Disimpan','success');
					$this->go('pelunasan/add/'.$data['id_organisasi']);
				} else {
					# ROLLBACK
					$this->pelunasan->delete($sukses);
					$this->kib_temp->delete($sukses_2a);
					$this->kib->update($aset->id, array('nilai'=>$aset->nilai));
				}
			} else {
				# ROLLBACK
				$this->pelunasan->delete($sukses);
			}
		}

		$this->message('Terjadi kesalahan');
		$this->go('pelunasan/add/'.$data['id_organisasi']);
	}

	public function cancel()
	{
		$id = $this->input->get('id');
		$id_organisasi = $this->input->get('id_organisasi');

		if(empty($id))
			show_404();

		$data = $this->pelunasan->get($id);

		if ($data->id_organisasi !== $id_organisasi) {
			$this->message('Data tidak match dengan organisasi', 'danger');
			$this->go('pelunasan?id_organisasi='.$id_organisasi);
		}

		# LOAD MODEL
		$this->load->model("aset/Kib{$data->kib}_model", "kib");
		$this->load->model("aset/Temp_kib{$data->kib}_model", "kib_temp");

		$aset = $this->kib->get($data->id_aset);
		$kdp  = $this->kib_temp->order_by('id', 'DESC')->get_by('id_aset', $data->id_kdp);
		# ROLL BACK
		$kdp->id = $kdp->id_aset;
		$kdp->id_spk = $data->id_kdp_spk;
		$kdp->id_sp2d = $data->id_kdp_sp2d;
		$kdp->id_hibah = $data->id_kdp_hibah;
		unset($kdp->id_aset, $kdp->id_transfer, $kdp->id_hapus, $kdp->id_koreksi, $kdp->id_koreksi_detail);

		$sukses_a = $this->kib->insert((array)$kdp);
		
		$sukses_b = TRUE;
		if ($data->akumulasi_kdp == '1') {
			$nilai_asli = $aset->nilai - $kdp->nilai;
			$sukses_b = $this->kib->update($aset->id, array('nilai'=>$nilai_asli));
		}

		if($sukses_a && $sukses_b) {
			$this->pelunasan->delete($id);
			$this->message('Transaski berhasil dibatalkan','success');
		} else {
			$this->message('Transaksi gagal dibatalkan','danger');
		}

		$this->go('pelunasan?id_organisasi='.$id_organisasi);
	}

	public function json()
	{
		$conf = $this->input->get();

		if (empty($conf['aset']))
			die();

		$data = $this->pelunasan->get_json($conf);
		echo json_encode($data);
	}
}