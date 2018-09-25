<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kapitalisasi extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Kapitalisasi_model', 'kapitalisasi');

        $this->load->model('aset/Kibc_model', 'kibc');
        $this->load->model('aset/Kibd_model', 'kibd');

        $this->load->model('Inventarisasi_model', 'inventarisasi');
    }
    
    public function index()
    {
        show_404();
    }

    public function add($id_inventarisasi = null)
    {
        if (empty($id_inventarisasi)) {
            show_404();
        }

        $data['inventarisasi'] = $this->inventarisasi->get($id_inventarisasi);
        $this->render('modules/inventarisasi/form_kapitalisasi', $data);
    }

    public function edit($id = null)
    {
        if (empty($id)) {
            show_404();
        }

        $data['kpt']   = $this->kapitalisasi->subtitute($this->kapitalisasi->get($id));
        $data['inventarisasi'] = $this->inventarisasi->get($data['kpt']->id_inventarisasi);

        $data['kpt']->id_aset = $data['kpt']->golongan == '3' ? $this->kibc->get($data['kpt']->id_aset) : $this->kibd->get($data['kpt']->id_aset);

        $this->render('modules/inventarisasi/form_kapitalisasi', $data);
    }

    public function insert()
    {
        $data = $this->input->post();
        $data['nilai'] = unmonefy($data['nilai']);
        $data['nilai_penunjang'] = unmonefy($data['nilai_penunjang']);

        if (!$this->kapitalisasi->form_verify($data)) {
            $this->message('Isi data yang wajib diisi');
            $this->go('inventarisasi/kapitalisasi/add/'.$data['id_inventarisasi']);
        }
        
        $sukses = $this->kapitalisasi->insert($data);
        if($sukses) {
            $this->message('Data berhasil disimpan','success');
            $this->go('inventarisasi/index/rincian/'.$data['id_inventarisasi']);
        } else {
            $this->message('Data gagal disimpan');
            $this->go('inventarisasi/kapitalisasi/add/'.$data['id_inventarisasi']);
        }
    }

    public function update()
    {
        $data = $this->input->post();
        $data['nilai'] = unmonefy($data['nilai']);
        $data['nilai_penunjang'] = unmonefy($data['nilai_penunjang']);
        $id = $data['id'];
        unset($data['id']);

        if (!$this->kapitalisasi->form_verify($data)) {
            $this->message('Isi data yang wajib diisi');
            $this->go('inventarisasi/kapitalisasi/edit/'.$id);
        }

        $sukses = $this->kapitalisasi->update($id, $data);
        
        if($sukses) {
            $this->message('Data berhasil disimpan','success');
            $this->go('inventarisasi/index/rincian/'.$data['id_inventarisasi']);
        } else {
            # Rollback update
            $this->message('Data gagal disimpan');
            $this->go('inventarisasi/kapitalisasi/edit/'.$id);
        }
    }

    public function delete($id = null)
    {
        if(empty($id))
            show_404();

        $kpt = $this->kapitalisasi->get($id);

        $sukses = $this->kapitalisasi->delete($id);
        if($sukses) {
            $this->message('Data berhasil dihapus','success');
        } else {
            $this->message('Data gagal dihapus','danger');
        }
        $this->go('inventarisasi/index/rincian/'.$kpt->id_inventarisasi);
    }
}