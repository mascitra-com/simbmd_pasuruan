<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengadaan extends MY_Controller {

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
	}
	
	public function index()
	{
		$this->load->library('Pagination');

		$filter = $this->input->get();
		$result = $this->spk->get_data($filter);
		$filter['id_organisasi'] = isset($filter['id_organisasi']) ? $filter['id_organisasi'] : '';

		$data['spks'] 		= $result['data'];
		$data['filter']  	= $filter;
		$data['organisasi'] = $this->organisasi->get_data_by_auth();
		$data['pagination'] = $this->pagination->get_pagination($result['data_count'], $filter, get_class($this));
		$data['kegiatan']   = $this->kegiatan->get_data_by_organisasi($filter['id_organisasi']);

		$this->render('modules/pengadaan/index', $data);
	}

	public function insert_spk()
	{
		$data = $this->input->post();
		if (!$this->spk->form_verify($data)) {
			$this->message('Isi data yang diperlukan', 'danger');
			$this->go('pengadaan?id_organisasi='.$data['id_organisasi']);
		}

		$sukses = $this->spk->insert($data);
		if($sukses) {
			$this->message('Data berhasil disimpan','success');
			$this->go('pengadaan/detail/'.$sukses);
		} else {
			$this->message('Terjadi kesalahan','danger');
			$this->go('pengadaan?id_organisasi='.$data['id_organisasi']);
		}
	}

	public function update_spk()
	{
		$data = $this->input->post();
		$id   = $data['id'];

		unset($data['id']);

		if (!$this->spk->form_verify($data)) {
			$this->message('Isi data yang diperlukan', 'danger');
			$this->go('pengadaan/detail/'.$id);
		}

		$sukses = $this->spk->update($id, $data);
		if($sukses) {
			$this->message('Data berhasil disunting','success');
			$this->go('pengadaan/detail/'.$id);
		} else {
			$this->message('Terjadi kesalahan','danger');
			$this->go('pengadaan/detail/'.$id);
		}
	}

	public function detail($id = null)
	{
		if(empty($id))
			show_404();

		$data['spk']	  		= $this->spk->get($id);
		$data['sp2d']['data']	= $this->sp2d->get_many_by(array('id_spk'=>$id));
		$data['sp2d']['total']	= $this->sp2d->total($data['sp2d']['data']);
		$data['kegiatan'] 		= $this->kegiatan->get_data_by_organisasi($data['spk']->id_organisasi);
		$this->render('modules/pengadaan/detail', $data);
	}

	public function rincian($id = null)
	{
		if(empty($id))
			show_404();

		$data['spk']	  		= $this->spk->get($id);
		$data['sp2d']['data']	= $this->sp2d->get_many_by(array('id_spk'=>$id));
		$data['sp2d']['total']	= $this->sp2d->total($data['sp2d']['data']);

		# RINCIAN
		$data['kiba'] 	= $this->kiba->get_data_pengajuan($data['spk']->id);
		$data['kibb'] 	= $this->kibb->get_data_pengajuan($data['spk']->id);
		$data['kibc'] 	= $this->kibc->get_data_pengajuan($data['spk']->id);
		$data['kibd'] 	= $this->kibd->get_data_pengajuan($data['spk']->id);
		$data['kibe'] 	= $this->kibe->get_data_pengajuan($data['spk']->id);
		$data['kibnon'] = $this->kibnon->get_data_pengajuan($data['spk']->id);
		$data['kdpc'] 	= $this->kibc->get_data_pengajuan($data['spk']->id, TRUE);
		$data['kdpd'] 	= $this->kibd->get_data_pengajuan($data['spk']->id, TRUE);

		$this->render('modules/pengadaan/rincian', $data);
	}

	public function rincian_redirect($id = null)
	{
		if(empty($id))
			show_404();

		$jenis = $this->input->post('jenis');

		switch ($jenis) {
			case 'a':
				$this->go('aset/kiba/add_pengadaan/'.$id);
				break;
			case 'b':
				$this->go('aset/kibb/add_pengadaan/'.$id);
				break;
			case 'c':
				$this->go('aset/kibc/add_pengadaan/'.$id);
				break;
			case 'd':
				$this->go('aset/kibd/add_pengadaan/'.$id);
				break;
			case 'e':
				$this->go('aset/kibe/add_pengadaan/'.$id);
				break;
			case 'non':
				$this->go('aset/kib_non/add_pengadaan/'.$id);
				break;
			case 'c_kdp':
				$this->go('aset/kdpc/add_pengadaan/'.$id);
				break;
			case 'd_kdp':
				$this->go('aset/kdpd/add_pengadaan/'.$id);
				break;
		
			default:
				show_404();
				break;
		}
	}

	public function sp2d($id = null)
	{
		if(empty($id))
			show_404();
		
		$data['spk']	  		= $this->spk->get($id);
		$data['sp2d']['data']	= $this->sp2d->get_many_by(array('id_spk'=>$id));
		$data['sp2d']['total']	= $this->sp2d->total($data['sp2d']['data']);
		$this->render('modules/pengadaan/sp2d', $data);
	}

	public function insert_sp2d()
	{
		$data = $this->input->post();
		if (!$this->sp2d->form_verify($data)) {
			$this->message('Isi data yang perlu diisi', 'danger');
			$this->go('pengadaan/sp2d/'.$data['id_spk']);
		}

		$sukses = $this->sp2d->insert($data);
		if($sukses) {
			$this->message('Data berhasil ditambah','success');
			$this->go('pengadaan/sp2d/'.$data['id_spk']);
		} else {
			$this->message('Terjadi kesalahan','danger');
			$this->go('pengadaan/sp2d/'.$data['id_spk']);
		}
	}

	public function delete_sp2d($id = null)
	{
		if(empty($id))
			show_404();

		$result = $this->sp2d->get($id);
		$sukses = $this->sp2d->delete($id);

		if($sukses) {
			$this->message('Data berhasil Dihapus','success');
			$this->go('pengadaan/sp2d/'.$result->id_spk);
		} else {
			$this->message('Terjadi kesalahan','danger');
			$this->go('pengadaan/sp2d/'.$result->id_spk);
		}
	}
}