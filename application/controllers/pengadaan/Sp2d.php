<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sp2d extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Spk_model', 'spk');
		$this->load->model('Sp2d_model', 'sp2d');
		$this->load->model('Organisasi_model', 'organisasi');
		$this->load->model('Kegiatan_model', 'kegiatan');

		$this->load->model('aset/Kiba_model','kiba');
		$this->load->model('aset/Kibb_model','kibb');
		$this->load->model('aset/Kibc_model','kibc');
		$this->load->model('aset/Kibd_model','kibd');
		$this->load->model('aset/Kibe_model','kibe');
		$this->load->model('aset/Kibnon_model','kibnon');
		$this->load->model('Kapitalisasi_model','kapitalisasi');
	}
	
	public function index($id = null)
	{
		if(empty($id))
			show_404();
		
		$data['spk']	  		= $this->spk->get($id);
		$data['sp2d']['data']	= $this->sp2d->get_many_by(array('id_spk'=>$id));
		$data['sp2d']['total']	= $this->sp2d->total($data['sp2d']['data']);
		$this->render('modules/pengadaan/sp2d', $data);
	}

	public function get($id = null)
	{
		$data = $this->sp2d->get($id);

		if ($data) {
			$data->tanggal = datify($data->tanggal, 'Y-m-d');
			$data->nilai = monefy($data->nilai);
		}

		echo json_encode($data);
	}

	public function insert()
	{
		$data = $this->input->post();
		if (!$this->sp2d->form_verify($data)) {
			$this->message('Isi data yang perlu diisi', 'danger');
			$this->go('pengadaan/sp2d/index/'.$data['id_spk']);
		}

		$data['nilai'] = unmonefy($data['nilai']);

		$sukses = $this->sp2d->insert($data);
		if($sukses) {
			$this->message('Data berhasil ditambah','success');
			$this->go('pengadaan/sp2d/index/'.$data['id_spk']);
		} else {
			$this->message('Terjadi kesalahan','danger');
			$this->go('pengadaan/sp2d/index/'.$data['id_spk']);
		}
	}

	public function update()
	{
		$data = $this->input->post();
		$id   = $data['id'];
		unset($data['id']);

		if (!$this->sp2d->form_verify($data)) {
			$this->message('Isi data yang perlu diisi', 'danger');
			$this->go('pengadaan/sp2d/index/'.$data['id_spk']);
		}

		$data['nilai'] = unmonefy($data['nilai']);
		
		$sukses = $this->sp2d->update($id, $data);
		if($sukses) {
			$this->message('Data berhasil disunting','success');
			$this->go('pengadaan/sp2d/index/'.$data['id_spk']);
		} else {
			$this->message('Terjadi kesalahan','danger');
			$this->go('pengadaan/sp2d/index/'.$data['id_spk']);
		}
	}

	public function delete($id = null)
	{
		if(empty($id))
			show_404();

		$result = $this->sp2d->get($id);
		$sukses = $this->sp2d->delete($id);

		if($sukses) {
			$this->message('Data berhasil Dihapus','success');
			$this->go('pengadaan/sp2d/index/'.$result->id_spk);
		} else {
			$this->message('Terjadi kesalahan','danger');
			$this->go('pengadaan/sp2d/index/'.$result->id_spk);
		}
	}
}