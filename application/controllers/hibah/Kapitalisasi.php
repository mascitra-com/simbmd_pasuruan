<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kapitalisasi extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Kapitalisasi_model', 'kapitalisasi');

        $this->load->model('aset/Kibc_model', 'kibc');
        $this->load->model('aset/Kibd_model', 'kibd');

        $this->load->model('Hibah_model', 'hibah');
    }
    
    public function index()
    {
        show_404();
    }

    public function add($id_hibah = null)
    {
        if (empty($id_hibah)) {
            show_404();
        }

        $data['hibah'] = $this->hibah->get($id_hibah);
        $this->render('modules/hibah/form_kapitalisasi', $data);
    }

    public function edit($id = null)
    {
        if (empty($id)) {
            show_404();
        }

        $data['kpt']   = $this->kapitalisasi->subtitute($this->kapitalisasi->get($id));
        $data['hibah'] = $this->hibah->get($data['kpt']->id_hibah);

        $data['kpt']->id_aset = $data['kpt']->golongan == '3' ? $this->kibc->get($data['kpt']->id_aset) : $this->kibd->get($data['kpt']->id_aset);

        $this->render('modules/hibah/form_kapitalisasi', $data);
    }

    public function insert()
    {
        $data = $this->input->post();
        $data['nilai'] = unmonefy($data['nilai']);
        $data['nilai_penunjang'] = unmonefy($data['nilai_penunjang']);

        if (!$this->kapitalisasi->form_verify($data)) {
            $this->message('Isi data yang wajib diisi');
            $this->go('hibah/kapitalisasi/add/'.$data['id_hibah']);
        }
        
        $sukses = $this->kapitalisasi->insert($data);
        if($sukses) {
            $this->message('Data berhasil disimpan','success');
            $this->go('hibah/index/rincian/'.$data['id_hibah']);
        } else {
            $this->message('Data gagal disimpan');
            $this->go('hibah/kapitalisasi/add/'.$data['id_hibah']);
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
            $this->go('hibah/kapitalisasi/edit/'.$id);
        }

        $sukses = $this->kapitalisasi->update($id, $data);
        
        if($sukses) {
            $this->message('Data berhasil disimpan','success');
            $this->go('hibah/index/rincian/'.$data['id_hibah']);
        } else {
            # Rollback update
            $this->message('Data gagal disimpan');
            $this->go('hibah/kapitalisasi/edit/'.$id);
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
        $this->go('hibah/index/rincian/'.$kpt->id_hibah);
    }
}