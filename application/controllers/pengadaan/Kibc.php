<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kibc extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('aset/Kibc_model', 'kib');
        $this->load->model('aset/Temp_kibc_model', 'kib_temp');
        $this->load->model('Organisasi_model', 'organisasi');
        $this->load->model('Kategori_model', 'kategori');
        $this->load->model('Spk_model', 'spk');
        $this->load->model('Sp2d_model', 'sp2d');
        $this->load->library('pagination');
    }

    public function get()
    {
        $filter = $this->input->get();

        if (isset($filter['search'])) {
            foreach ($this->kib->_kolom as $kolom) {
                $filter[$kolom] = $filter['search'];
            }
            unset($filter['search']);
        }

        echo json_encode($this->kib->get_data_aset($filter));
    }

    public function add($id_spk = NULL)
    {
        if (empty($id_spk))
            show_404();

        $data['spk'] = $this->spk->get($id_spk);
        $data['total_rincian'] = $this->spk->get_total_rincian($id_spk);
        $data['sp2d'] = $this->sp2d->get_many_by('id_spk', $id_spk);
        
        $mode = ($this->config->item('mode')==='pasuruan') ? '' : '_jember';
        $this->render('modules/pengadaan/form_kibc'.$mode, $data);
    }

    public function edit($id = NULL)
    {
        if (empty($id))
            show_404();

        $data['kib'] = $this->kib_temp->get($id);
        $data['kib']->id_kategori = $this->kategori->get($data['kib']->id_kategori);
        $data['spk'] = $this->spk->get($data['kib']->id_spk);
        $data['total_rincian'] = $this->spk->get_total_rincian($data['kib']->id_spk);
        $data['sp2d'] = $this->sp2d->get_many_by('id_spk', $data['kib']->id_spk);
        
        $mode = ($this->config->item('mode')==='pasuruan') ? '' : '_jember';
        $this->render('modules/pengadaan/form_kibc'.$mode, $data);
    }

    public function insert()
    {
        $data = $this->input->post();
        $data['tahun'] = !empty($data['tgl_perolehan']) ? datify($data['tgl_perolehan'], 'Y') : '';
        $data['nilai'] 	= unmonefy($data['nilai']);
        $data['nilai_sisa'] 	= unmonefy($data['nilai_sisa']);

        if (!$this->kib_temp->form_verify($data)) {
            $this->message('Isi data yang wajib diisi', 'danger');
            $this->go('pengadaan/kibc/add/' . $data['id_spk']);
        }

        $data_final = array();
        $kuantitas = !empty($data['kuantitas']) ? $data['kuantitas'] : 1;
        unset($data['kuantitas']);

        for ($i = 0; $i < $kuantitas; $i++) {
            $data_final[$i] = $data;
            $data_final[$i]['reg_barang'] = 0;
            $data_final[$i]['reg_induk'] = 0;
        }

        $sukses = $this->kib_temp->batch_insert($data_final);
        if ($sukses) {
            $this->message('Data berhasil disimpan', 'success');
            $this->go('pengadaan/index/rincian/' . $data['id_spk']);
        } else {
            $this->message('Data gagal disimpan', 'danger');
            $this->go('pengadaan/kibc/add/' . $data['id_spk']);
        }
    }

    public function update()
    {
        $data = $this->input->post();
        $data['tahun'] = !empty($data['tgl_perolehan']) ? datify($data['tgl_perolehan'], 'Y') : NULL;
        $data['nilai'] 	= unmonefy($data['nilai']);
        $data['nilai_sisa'] 	= unmonefy($data['nilai_sisa']);
        $id = $data['id'];
        unset($data['id']);

        if (!$this->kib_temp->form_verify($data)) {
            $this->message('Isi data yang wajib diisi', 'danger');
            $this->go('pengadaan/kibc/edit/' . $id);
        }

        $sukses = $this->kib_temp->update($id, $data);
        if ($sukses) {
            $this->message('Data berhasil disunting', 'success');
            $this->go('pengadaan/index/rincian/' . $data['id_spk']);
        } else {
            $this->message('Data gagal disunting', 'danger');
            $this->go('pengadaan/kibc/edit/' . $id);
        }
    }

    public function delete($id = NULL)
    {
        if (empty($id))
            show_404();

        $data = $this->kib_temp->get($id);
        $sukses = $this->kib_temp->delete($id);
        if ($sukses) {
            $this->message("Data berhasil dihapus", 'success');
            $this->go('pengadaan/index/rincian/' . $data->id_spk);
        } else {
            $this->message('Data gagal dihapus', 'danger');
            $this->go('pengadaan/index/rincian/' . $data->id_spk);
        }
    }
}