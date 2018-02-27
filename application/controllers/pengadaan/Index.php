<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Spk_model', 'spk');
		$this->load->model('Sp2d_model', 'sp2d');
		$this->load->model('Organisasi_model', 'organisasi');
		$this->load->model('Kegiatan_model', 'kegiatan');

		$this->load->model('aset/Temp_kiba_model','kiba');
		$this->load->model('aset/Temp_kibb_model','kibb');
		$this->load->model('aset/Temp_kibc_model','kibc');
		$this->load->model('aset/Temp_kibd_model','kibd');
		$this->load->model('aset/Temp_kibe_model','kibe');
		$this->load->model('aset/Kibnon_model','kibnon');
		$this->load->model('Kapitalisasi_model','kapitalisasi');
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
		$data['pagination'] = $this->pagination->get_pagination($result['data_count'], $filter, 'pengadaan/' . get_class($this));
		$data['kegiatan']   = $this->kegiatan->get_data_by_organisasi($filter['id_organisasi']);

		$this->render('modules/pengadaan/index', $data);
	}

	public function insert()
	{
		$data = $this->input->post();
        $data['nilai'] 	= unmonefy($data['nilai']);
        $data['addendum_nilai'] 	= unmonefy($data['addendum_nilai']);
		if (!$this->spk->form_verify($data)) {
			$this->message('Isi data yang diperlukan', 'danger');
			$this->go('pengadaan?id_organisasi='.$data['id_organisasi']);
		}

		$sukses = $this->spk->insert($data);
		if($sukses) {
			$this->message('Data berhasil disimpan','success');
			$this->go('pengadaan/index/detail/'.$sukses);
		} else {
			$this->message('Terjadi kesalahan','danger');
			$this->go('pengadaan?id_organisasi='.$data['id_organisasi']);
		}
	}

	public function update()
	{
		$data = $this->input->post();
        $data['nilai'] 	= unmonefy($data['nilai']);
        $data['addendum_nilai'] 	= unmonefy($data['addendum_nilai']);
		$id   = $data['id'];
		unset($data['id']);

		if (!$this->spk->form_verify($data)) {
			$this->message('Isi data yang diperlukan', 'danger');
			$this->go('pengadaan/index/detail/'.$id);
		}

		$sukses = $this->spk->update($id, $data);
		if($sukses) {
			$this->message('Data berhasil disunting','success');
			$this->go('pengadaan/index/detail/'.$id);
		} else {
			$this->message('Terjadi kesalahan','danger');
			$this->go('pengadaan/index/detail/'.$id);
		}
	}

	public function delete($id = null)
	{
		if(empty($id))
			show_404();

		$id_organisasi = $this->spk->get($id)->id_organisasi;
		$sukses 	   = $this->spk->delete($id);
		if($sukses) {
			$this->kiba->delete_by(array('id_spk'=>$id));
			$this->kibb->delete_by(array('id_spk'=>$id));
			$this->kibc->delete_by(array('id_spk'=>$id));
			$this->kibd->delete_by(array('id_spk'=>$id));
			$this->kibe->delete_by(array('id_spk'=>$id));
			$this->kibnon->delete_by(array('id_spk'=>$id));
			$this->kapitalisasi->delete_by(array('id_spk'=>$id));
			$this->sp2d->delete_by(array('id_spk'=>$id));

			$this->message('Data berhasil dihapus','success');
			$this->go('pengadaan/index?id_organisasi='.$id_organisasi);
		} else {
			$this->message('Data gagal dihapus','danger');
			$this->go('pengadaan/index?id_organisasi='.$id_organisasi);
		}

	}

	public function detail($id = null)
	{
		if(empty($id))
			show_404();

		$data['spk']	  	   = $this->spk->get($id);
		$data['sp2d']['data']  = $this->sp2d->get_many_by(array('id_spk'=>$id));
		$data['sp2d']['total'] = $this->sp2d->total($data['sp2d']['data']);
		$data['kegiatan'] 	   = $this->kegiatan->get_data_by_organisasi($data['spk']->id_organisasi);
		$this->render('modules/pengadaan/detail', $data);
	}

	public function rincian($id = null)
	{
		if(empty($id))
			show_404();

		$data['spk']	  		= $this->spk->get($id);
		$data['sp2d']['data']	= $this->sp2d->get_many_by(array('id_spk'=>$id));
		$data['sp2d']['total']	= $this->sp2d->total($data['sp2d']['data']);
		$data['total_rincian']  = $this->spk->get_total_rincian($id);

		# RINCIAN
		$data['kiba'] 	= $this->kiba->get_data_pengajuan($data['spk']->id);
		$data['kibb'] 	= $this->kibb->get_data_pengajuan($data['spk']->id);
		$data['kibc'] 	= $this->kibc->get_data_pengajuan($data['spk']->id);
		$data['kibd'] 	= $this->kibd->get_data_pengajuan($data['spk']->id);
		$data['kibe'] 	= $this->kibe->get_data_pengajuan($data['spk']->id);
		$data['kibnon'] = $this->kibnon->get_data_pengajuan($data['spk']->id);
		$data['kdpc'] 	= $this->kibc->get_data_pengajuan($data['spk']->id, TRUE);
		$data['kdpd'] 	= $this->kibd->get_data_pengajuan($data['spk']->id, TRUE);
		$data['kpt'] 	= $this->kapitalisasi->get_data_pengajuan($data['spk']->id);

		$this->render('modules/pengadaan/rincian', $data);
	}

	public function rincian_redirect($id = null)
	{
		if(empty($id))
			show_404();

		$jenis = $this->input->post('jenis');

		switch ($jenis) {
			case 'a':
			$this->go('pengadaan/kiba/add/'.$id);
			break;
			case 'b':
			$this->go('pengadaan/kibb/add/'.$id);
			break;
			case 'c':
			$this->go('pengadaan/kibc/add/'.$id);
			break;
			case 'd':
			$this->go('pengadaan/kibd/add/'.$id);
			break;
			case 'e':
			$this->go('pengadaan/kibe/add/'.$id);
			break;
			case 'non':
			$this->go('pengadaan/kibnon/add/'.$id);
			break;
			case 'c_kdp':
			$this->go('pengadaan/kdpc/add/'.$id);
			break;
			case 'd_kdp':
			$this->go('pengadaan/kdpd/add/'.$id);
			break;
			case 'tambah':
			$this->go('pengadaan/kapitalisasi/add/langkah_1/'.$id);
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
        $sukses = $this->spk->update($id, $data);
        if($sukses) {
            $this->message('Data berhasil diajukan','success');
            $this->go('pengadaan/index/detail/'.$id);
        } else {
            $this->message('Terjadi kesalahan', 'danger');
            $this->go('pengadaan/index/detail/'.$id);
        }
    }

    public function cancel_transaction($id = NULL)
    {
        if(empty($id))
            show_404();

        $data   = array('status_pengajuan'=>0);
        $sukses = $this->spk->update($id, $data);
        if($sukses) {
            $this->message('Data berhasil dibatalkan','success');
            $this->go('pengadaan/index/detail/'.$id);
        } else {
            $this->message('Terjadi kesalahan', 'danger');
            $this->go('pengadaan/index/detail/'.$id);
        }
    }
}