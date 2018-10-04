<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends MY_Controller
{
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

		$this->load->model('aset/Kibnon_model', 'kibnon');
		$this->load->model('Kapitalisasi_model', 'kapitalisasi');

		$this->load->model('Inventarisasi_model', 'inventarisasi');
		$this->load->model('Organisasi_model', 'organisasi');
	}

	public function index()
	{
		$data['id_organisasi'] = $this->organisasi->get_id_by_auth( $this->input->get('id_organisasi') );
		$data['organisasi'] 	  = $this->organisasi->get_data_by_auth();

		$this->render('modules/inventarisasi/index', $data);
	}

	public function get_inventarisasi($id_organisasi = '')
	{
		if (empty($id_organisasi)) {
			return;
		}

		$id_organisasi = $this->organisasi->get_id_by_auth($id_organisasi);
		$filter = $this->input->get();
		$data   = $this->inventarisasi->api_get_data($id_organisasi, $filter);

		echo json_encode($data);
	}

	public function insert()
	{
		$data = $this->input->post();
		$data['id_organisasi'] = $this->organisasi->get_id_by_auth($data['id_organisasi']);

		if ($_FILES['berkas']['size'] > 0) {
			$config['upload_path']   = realpath(FCPATH.'res/docs/temp/');
			$config['file_name']	 	 = 'inv_'.uniqchar(5);
			$config['allowed_types'] = 'pdf|doc|docx|xls|xlsx';
			$config['max_size']      = 1000;
			$config['overwrite']     = TRUE;

			$this->load->library('upload', $config);
			
			# Jika gagal
			if (!$this->upload->do_upload('berkas')) {
				$this->message($this->upload->display_errors(), 'danger');
				$this->go('inventarisasi/index?id_organisasi='.$data['id_organisasi']);
			}

			$data['dokumen'] = $this->upload->data('file_name');
		}

		$sukses = $this->inventarisasi->insert($data);
		if ($sukses) {
			$this->message('Data berhasil disimpan.');
			$this->go('inventarisasi/index/rincian/'.$sukses);
		}else{
			$this->message('Terjadi kesalahan, data gagal disimpan.', 'danger');
			$this->go('inventarisasi/index?id_organisasi='.$data['id_organisasi']);
		}
	}

	public function update()
	{
		$data = $this->input->post();
		$id   = $data['id'];
		$data['id_organisasi'] = $this->organisasi->get_id_by_auth($data['id_organisasi']);

		unset($data['id']);
		
		# Upload
		$file_name = empty($this->inventarisasi->get($id)->dokumen)?'inv_'.uniqchar(5):explode('.', $this->inventarisasi->get($id)->dokumen)[0];
		if ($_FILES['berkas']['size'] > 0) {
			$config['upload_path']   = realpath(FCPATH.'res/docs/temp/');
			$config['file_name']	 	 = $file_name;
			$config['allowed_types'] = 'pdf|doc|docx|xls|xlsx';
			$config['max_size']      = 1000;
			$config['overwrite']     = TRUE;

			$this->load->library('upload', $config);
			
			# Jika gagal
			if (!$this->upload->do_upload('berkas')) {
				$this->message($this->upload->display_errors(), 'danger');
				$this->go('inventarisasi/index/rincian/'.$id);
			}

			$data['dokumen'] = $this->upload->data('file_name');
		}

		$sukses = $this->inventarisasi->update($id, $data);
		if ($sukses) {
			$this->message('Data berhasil disimpan.');
		}else{
			$this->message('Terjadi kesalahan, data gagal disimpan.', 'danger');
		}
		$this->go('inventarisasi/index/rincian/'.$id);
	}

	public function delete($id = null)
	{
		if(empty($id))
			show_404();

		$id_organisasi = $this->inventarisasi->get($id)->id_organisasi;
		$sukses = $this->inventarisasi->delete($id);

		if($sukses) {
			$this->kiba_temp->delete_by(array('id_inventarisasi'=>$id));
			$this->kibb_temp->delete_by(array('id_inventarisasi'=>$id));
			$this->kibc_temp->delete_by(array('id_inventarisasi'=>$id));
			$this->kibd_temp->delete_by(array('id_inventarisasi'=>$id));
			$this->kibe_temp->delete_by(array('id_inventarisasi'=>$id));
			$this->kibg_temp->delete_by(array('id_inventarisasi'=>$id));
			$this->kibnon->delete_by(array('id_inventarisasi'=>$id));
			$this->kapitalisasi->delete_by(array('id_inventarisasi'=>$id));

			$this->message('Data berhasil dihapus','success');
		} else {
			$this->message('Data gagal dihapus','danger');
		}

		$this->go('inventarisasi/index?id_organisasi='.$id_organisasi);
	}

	public function rincian($id_inventarisasi = null)
	{
		if (empty($id_inventarisasi)) {
			show_404();
		}

		$data['inventarisasi'] = $this->inventarisasi->get($id_inventarisasi);

		$data['kiba']['count'] = $this->kiba_temp->count_by(array('id_inventarisasi'=>$id_inventarisasi));
		$data['kiba']['sum']   = $this->kiba_temp->select("SUM(nilai) AS nilai")->where('id_hapus IS NULL AND id_koreksi IS NULL AND id_transfer IS NULL')->get_many_by(array('id_inventarisasi'=>$id_inventarisasi))[0]->nilai;

		$data['kibb']['count'] = $this->kibb_temp->count_by(array('id_inventarisasi'=>$id_inventarisasi));
		$data['kibb']['sum']   = $this->kibb_temp->select("SUM(nilai) AS nilai")->where('id_hapus IS NULL AND id_koreksi IS NULL AND id_transfer IS NULL')->get_many_by(array('id_inventarisasi'=>$id_inventarisasi))[0]->nilai;

		$data['kibc']['count'] = $this->kibc_temp->count_by(array('id_inventarisasi'=>$id_inventarisasi));
		$data['kibc']['sum']   = $this->kibc_temp->select("SUM(nilai+nilai_tambah) AS nilai")->where('id_hapus IS NULL AND id_koreksi IS NULL AND id_transfer IS NULL')->get_many_by(array('id_inventarisasi'=>$id_inventarisasi))[0]->nilai;

		$data['kibd']['count'] = $this->kibd_temp->count_by(array('id_inventarisasi'=>$id_inventarisasi));
		$data['kibd']['sum']   = $this->kibd_temp->select("SUM(nilai+nilai_tambah) AS nilai")->where('id_hapus IS NULL AND id_koreksi IS NULL AND id_transfer IS NULL')->get_many_by(array('id_inventarisasi'=>$id_inventarisasi))[0]->nilai;

		$data['kibe']['count'] = $this->kibe_temp->count_by(array('id_inventarisasi'=>$id_inventarisasi));
		$data['kibe']['sum']   = $this->kibe_temp->select("SUM(nilai) AS nilai")->where('id_hapus IS NULL AND id_koreksi IS NULL AND id_transfer IS NULL')->get_many_by(array('id_inventarisasi'=>$id_inventarisasi))[0]->nilai;

		$data['kibg']['count'] = $this->kibg_temp->count_by(array('id_inventarisasi'=>$id_inventarisasi));
		$data['kibg']['sum']   = $this->kibg_temp->select("SUM(nilai) AS nilai")->where('id_hapus IS NULL AND id_koreksi IS NULL AND id_transfer IS NULL')->get_many_by(array('id_inventarisasi'=>$id_inventarisasi))[0]->nilai;

		$data['kpt']['count'] = $this->kapitalisasi->count_by(array('id_inventarisasi'=>$id_inventarisasi));
		$data['kpt']['sum']   = $this->kapitalisasi->select("SUM(nilai) AS nilai")->get_many_by(array('id_inventarisasi'=>$id_inventarisasi))[0]->nilai;

		$data['kibnon']['count'] = $this->kibnon->count_by(array('id_inventarisasi'=>$id_inventarisasi));
		$data['kibnon']['sum']   = $this->kibnon->select("SUM(nilai) AS nilai")->get_many_by(array('id_inventarisasi'=>$id_inventarisasi))[0]->nilai;

		$data['ref'] = empty($this->input->get('ref')) ? '' : 'true';

		$this->render('modules/inventarisasi/rincian', $data);
	}

	public function rincian_redirect($id = null)
	{
		if (empty($id))
			show_404();

		$jenis = $this->input->post('jenis');

		switch ($jenis) {
			case 'a':
			$this->go('inventarisasi/kiba/add/' . $id);
			break;
			case 'b':
			$this->go('inventarisasi/kibb/add/' . $id);
			break;
			case 'c':
			$this->go('inventarisasi/kibc/add/' . $id);
			break;
			case 'd':
			$this->go('inventarisasi/kibd/add/' . $id);
			break;
			case 'e':
			$this->go('inventarisasi/kibe/add/' . $id);
			break;
			case 'g':
			$this->go('inventarisasi/kibg/add/' . $id);
			break;
			case 'tambah':
			$this->go('inventarisasi/kapitalisasi/add/' . $id);
			break;
			case 'non':
			$this->go('inventarisasi/kibnon/add/' . $id);
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
		$sukses = $this->inventarisasi->update($id, $data);
		if($sukses) {
			$this->message('Pengajuan Berhasil','success');
			$this->go('inventarisasi/index/rincian/'.$id);
		} else {
			$this->message('Terjadi kesalahan', 'danger');
			$this->go('inventarisasi/index/rincian/'.$id);
		}
	}

	public function cancel_transaction($id = NULL)
	{
		if(empty($id))
			show_404();

		$data   = array('status_pengajuan'=>0);
		$sukses = $this->inventarisasi->update($id, $data);
		if($sukses) {
			$this->message('Pengajuan Berhasil dibatalkan','success');
			$this->go('inventarisasi/index/rincian/'.$id);
		} else {
			$this->message('Terjadi kesalahan', 'danger');
			$this->go('inventarisasi/index/rincian/'.$id);
		}
	}

	public function abort_transaction($id_inventarisasi = NULL)
	{
        # JIKA KOSONG
		if (empty($id_inventarisasi)) {
			$this->message('Pilih data inventarisasi yang akan dibatalkan', 'danger');
			$this->go('inventarisasi/index/');
		}

        # AMBIL DATA inventarisasi
		$inventarisasi = $this->inventarisasi->get($id_inventarisasi);

        # CEK KETERSEDIAAN PEMBATALAN
		$abort_status = $this->check_abort_status($inventarisasi->id);
		if (!$abort_status['status']) {
			$this->message($abort_status['reason'], 'danger');
			$this->go('inventarisasi/index?id_organisasi='.$inventarisasi->id_organisasi);
		}

        # ABOOORT - HAPUS RINCIAN
		$this->kiba->delete_by(array('id_inventarisasi'=>$id_inventarisasi));
		$this->kibb->delete_by(array('id_inventarisasi'=>$id_inventarisasi));
		$this->kibc->delete_by(array('id_inventarisasi'=>$id_inventarisasi));
		$this->kibd->delete_by(array('id_inventarisasi'=>$id_inventarisasi));
		$this->kibe->delete_by(array('id_inventarisasi'=>$id_inventarisasi));
		$this->kibg->delete_by(array('id_inventarisasi'=>$id_inventarisasi));

		# KAPIPTALISASI
		$kap = $this->kapitalisasi->get_many_by('id_hibah', $id_hibah);
		foreach ($kap as $item) {
         # Update data pada aset utama
			$kib  = ($item->golongan==='3') ? 'kibc' : 'kibd';
			$temp = $this->{$kib}->get($item->id_aset);
			$nilai_kurang = $this->nol($item->jumlah) * $this->nol($item->nilai);
			$total = $temp->nilai_tambah - $nilai_kurang;
			$total = $total < 0 ? 0 : $total;

			$this->{$kib}->update($item->id_aset, array('nilai_tambah'=>$total));
		}

		$this->inventarisasi->update($id_inventarisasi, array('status_pengajuan'=>0));

		$this->message('inventarisasi berhasil dibatalkan','success');
		$this->go('inventarisasi/index?id_organisasi='.$inventarisasi->id_organisasi);
	}

	private function check_abort_status($id_inventarisasi = NULL)
	{
		if (empty($id_inventarisasi)) {
			return array('status'=>FALSE, 'reason'=>'id inventarisasi kosong');
		}

		$inventarisasi = $this->inventarisasi->get($id_inventarisasi);

		if (empty($inventarisasi)) {
			return array('status'=>FALSE, 'reason'=>'id inventarisasi tidak valid');
		}

		$alfabet = array('a', 'b', 'c', 'd', 'e', 'g');
		foreach ($alfabet as $item) {
            # SET MODEL
			$model_kib  = "kib{$item}";
			$model_kib_temp  = "kib{$item}_temp";

			$result = $this->{$model_kib}->select("COUNT(id) AS total, SUM(nilai) AS jumlah")->get_by(array('id_inventarisasi'=>$inventarisasi->id, 'id_organisasi'=>$inventarisasi->id_organisasi));
			$result_temp = $this->db->query("SELECT COUNT(id) AS total, SUM(nilai) AS jumlah FROM ".$this->{$model_kib_temp}->_table." WHERE id_aset IN(SELECT id FROM ".$this->{$model_kib}->_table." WHERE id_inventarisasi = {$inventarisasi->id} AND id_organisasi = {$inventarisasi->id_organisasi}) OR id_inventarisasi = {$inventarisasi->id}")->row();

			if ($result->total!==$result_temp->total OR $result->jumlah!==$result_temp->jumlah) {
				return array('status'=>FALSE, 'reason'=>'Rincian inventarisasi terikat dengan transaksi lainnya.');
			}
		}

		return array('status'=>TRUE);
	}

	public function get_abort_status($id_inventarisasi = NULL) {
		if (empty($id_inventarisasi)) {
			echo json_encode(array('status'=>FALSE, 'reason'=>'ID inventarisasi KOSONG'));
		} else {
			echo json_encode($this->check_abort_status($id_inventarisasi));
		}
	}

	private function nol($var)
	{
		return (empty($var)) ? 0 : $var;
	}
}