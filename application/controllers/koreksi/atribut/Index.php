<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends MY_Controller {

	public $is_superadmin = 1;
	public $jenis_koreksi = 5;

	public function __construct()
	{
		parent::__construct();

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

		$this->load->model('Koreksi_model', 'koreksi');
		$this->load->model('Koreksi_detail_model', 'koreksi_detail');
		$this->load->model('Organisasi_model', 'organisasi');
	}

	public function index()
	{
		$data['id_organisasi'] = $this->organisasi->get_id_by_auth( $this->input->get('id_organisasi') );
		$data['organisasi'] 	  = $this->organisasi->get_data_by_auth();

		$this->render('modules/koreksi/atribut/index', $data);
	}

	public function get($id_organisasi = '')
	{
		if (empty($id_organisasi)) {
			return;
		}

		$id_organisasi = $this->organisasi->get_id_by_auth($id_organisasi);
		$filter = $this->input->get();
		$data   = $this->koreksi->api_get_data($id_organisasi, 5, $filter);

		echo json_encode($data);
	}

	public function insert()
	{
		$data = $this->input->post();
		$data['jenis_koreksi'] = 5;

		$sukses = $this->koreksi->insert($data);

		if ($sukses) {
			$this->message('Data berhasil ditambah');
			$this->go('koreksi/atribut/index/rincian/'.$sukses);
		}else{
			$this->message('Data gagal ditambah');
			$this->go('koreksi/atribut/index?id_organisasi='.$data['id_organisasi']);
		}
	}

	public function update()
	{
		$data = $this->input->post();
		$id   = $data['id'];

		unset($data['id']); 

		$sukses = $this->koreksi->update($id, $data);

		if ($sukses) {
			$this->message('Data berhasil disunting');
		}else{
			$this->message('Data gagal disunting');
		}
		$this->go('koreksi/atribut/index/rincian/'.$id);
	}

	public function delete($id_koreksi = null)
	{
		if (empty($id_koreksi)) {
			show_404();
		}

		$koreksi = $this->koreksi->get($id_koreksi);

		if ($koreksi->status_pengajuan == 1 OR $koreksi->status_pengajuan == 2) {
			$this->message('data menunggu atau telah disetujui', 'warning');
			$this->go('koreksi/atribut/index?id_organisasi='.$koreksi->id_organisasi);
			die();
		}

		$model = array('kiba_temp','kibb_temp','kibc_temp','kibd_temp','kibe_temp','kibg_temp');
		foreach ($model as $m) {
			$temp = $this->{$m}->get_many_by('id_koreksi', $id_koreksi);
			foreach ($temp as $key => $value) {
				$this->koreksi_detail->delete($value->id_koreksi_detail);
			}
			$this->{$m}->delete_by('id_koreksi', $id_koreksi);
		}

		$this->koreksi->delete($id_koreksi);
		$this->message('data berhasil dihapus', 'success');
		$this->go('koreksi/atribut/index?id_organisasi='.$koreksi->id_organisasi);
	}

	public function rincian($id_koreksi = null)
	{
		if (empty($id_koreksi)) {
			show_404();
		}

		$data['kiba']['count'] = $this->kiba_temp->count_by(array('id_koreksi'=>$id_koreksi));
		$data['kiba']['sum']   = $this->kiba_temp->select("SUM(nilai) AS nilai")->get_many_by(array('id_koreksi'=>$id_koreksi))[0]->nilai;

		$data['kibb']['count'] = $this->kibb_temp->count_by(array('id_koreksi'=>$id_koreksi));
		$data['kibb']['sum']   = $this->kibb_temp->select("SUM(nilai) AS nilai")->get_many_by(array('id_koreksi'=>$id_koreksi))[0]->nilai;

		$data['kibc']['count'] = $this->kibc_temp->count_by(array('id_koreksi'=>$id_koreksi));
		$data['kibc']['sum']   = $this->kibc_temp->select("SUM(nilai+nilai_tambah) AS nilai")->get_many_by(array('id_koreksi'=>$id_koreksi))[0]->nilai;

		$data['kibd']['count'] = $this->kibd_temp->count_by(array('id_koreksi'=>$id_koreksi));
		$data['kibd']['sum']   = $this->kibd_temp->select("SUM(nilai+nilai_tambah) AS nilai")->get_many_by(array('id_koreksi'=>$id_koreksi))[0]->nilai;

		$data['kibe']['count'] = $this->kibe_temp->count_by(array('id_koreksi'=>$id_koreksi));
		$data['kibe']['sum']   = $this->kibe_temp->select("SUM(nilai) AS nilai")->get_many_by(array('id_koreksi'=>$id_koreksi))[0]->nilai;

		$data['kibg']['count'] = $this->kibg_temp->count_by(array('id_koreksi'=>$id_koreksi));
		$data['kibg']['sum']   = $this->kibg_temp->select("SUM(nilai) AS nilai")->get_many_by(array('id_koreksi'=>$id_koreksi))[0]->nilai;

		$data['koreksi'] = $this->koreksi->get($id_koreksi);
		$data['ref']     = $this->input->get('ref');

		$this->render('modules/koreksi/atribut/rincian', $data);
	}

	public function rincian_redirect($id = null)
	{
		if (empty($id))
			show_404();

		$jenis = $this->input->post('jenis');

		switch ($jenis) {
			case 'a':
			$this->go('koreksi/atribut/kiba/index/' . $id);
			break;
			case 'b':
			$this->go('koreksi/atribut/kibb/index/' . $id);
			break;
			case 'c':
			$this->go('koreksi/atribut/kibc/index/' . $id);
			break;
			case 'd':
			$this->go('koreksi/atribut/kibd/index/' . $id);
			break;
			case 'e':
			$this->go('koreksi/atribut/kibe/index/' . $id);
			break;
			case 'g':
			$this->go('koreksi/atribut/kibg/index/' . $id);
			break;

			default:
			show_404();
			break;
		}
	}

	public function finish_transaction($id = NULL)
	{
		if(empty($id))
			show_404();

		$data   = array('status_pengajuan'=>1);
		$sukses = $this->koreksi->update($id, $data);
		if($sukses) {
			$this->message('Pengajuan Berhasil','success');
			$this->go('koreksi/atribut/index/rincian/'.$id);
		} else {
			$this->message('Terjadi kesalahan', 'danger');
			$this->go('koreksi/atribut/index/rincian/'.$id);
		}
	}

	public function cancel_transaction($id = NULL)
	{
		if(empty($id))
			show_404();

		$data   = array('status_pengajuan'=>0);
		$sukses = $this->koreksi->update($id, $data);
		if($sukses) {
			$this->message('Pengajuan Berhasil dibatalkan','success');
			$this->go('koreksi/atribut/index/rincian/'.$id);
		} else {
			$this->message('Terjadi kesalahan', 'danger');
			$this->go('koreksi/atribut/index/rincian/'.$id);
		}
	}

	public function abort_transaction($id_koreksi = NULL)
	{
        # JIKA KOSONG
		if (empty($id_koreksi)) {
			$this->message('Pilih data koreksi yang akan dibatalkan', 'danger');
			$this->go('koreksi/atribut/index/');
		}

        # AMBIL DATA koreksi
		$koreksi = $this->koreksi->get($id_koreksi);

        # CEK KETERSEDIAAN PEMBATALAN
		$abort_status = $this->check_abort_status($koreksi->id);
		if (!$abort_status['status']) {
			$this->message($abort_status['reason'], 'danger');
			$this->go('koreksi/atribut/index?id_organisasi='.$koreksi->id_organisasi);
		}

      # ABOOORT - HAPUS RINCIAN
		$alfabet = array('a', 'b', 'c', 'd', 'e', 'g');
		foreach ($alfabet as $item) {
			# Set nama model
			$kib = "kib{$item}";
			$kib_temp = "kib{$item}_temp";
			# Ambil data temp
			$temp = $this->{$kib_temp}->get_many_by('id_koreksi', $id_koreksi);
			foreach ($temp as $key => $value) {
				$original = $this->koreksi_detail->get($value->id_koreksi_detail)->original_value;
				$original = (array)json_decode($original);

				$this->{$kib}->update($value->id_aset, $original);
			}
		}

		$this->koreksi->update($id_koreksi, array('status_pengajuan'=>0));

		$this->message('koreksi berhasil dibatalkan','success');
		$this->go('koreksi/atribut/index?id_organisasi='.$koreksi->id_organisasi);
	}

	private function check_abort_status($id_koreksi = NULL)
	{
		return array('status'=>TRUE);
	}

	public function get_abort_status($id_koreksi = NULL) {
		if (empty($id_koreksi)) {
			echo json_encode(array('status'=>FALSE, 'reason'=>'ID koreksi KOSONG'));
		} else {
			echo json_encode($this->check_abort_status($id_koreksi));
		}
	}

	private function nol($var)
	{
		return (empty($var)) ? 0 : $var;
	}
}