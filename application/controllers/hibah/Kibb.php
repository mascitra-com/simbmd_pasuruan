<?php
/**
 * Created by PhpStorm.
 * User: Rizki Herdatullah
 * Date: 1/8/2018
 * Time: 2:27 PM
 */

class Kibb extends MY_Controller
{


    public function __construct()
    {
        parent::__construct();
        $this->load->model('aset/Kibb_model', 'kib');
        $this->load->model('aset/Temp_kibb_model', 'kib_temp');
        $this->load->model('Organisasi_model', 'organisasi');
        $this->load->model('Kategori_model', 'kategori');
        $this->load->model('Ruangan_model', 'ruangan');
        $this->load->model('Hibah_model', 'hibah');
        $this->load->library('pagination');
    }

    public function add_hibah($id_hibah = NULL)
    {
        if (empty($id_hibah))
            show_404();

        $data['hibah'] = $this->hibah->get($id_hibah);
        $data['ruangan'] = $this->ruangan->get_many_by('id_organisasi', $data['hibah']->id_organisasi);
        $this->render('modules/hibah/form_kibb', $data);
    }

    public function edit($id = NULL)
    {
        if (empty($id))
            show_404();

        $data['kib'] = $this->kib_temp->get($id);
        $data['kib']->id_kategori = $this->kategori->get($data['kib']->id_kategori);
        $data['hibah'] = $this->hibah->get($data['kib']->id_hibah);
        $this->render('modules/hibah/form_kibb', $data);
    }

    public function insert()
    {
        $data = $this->input->post();
        $data['tahun'] = !empty($data['tgl_perolehan']) ? datify($data['tgl_perolehan'], 'Y') : '';
        $data['nilai'] 	= unmonefy($data['nilai']);
        $data['nilai_sisa'] 	= unmonefy($data['nilai_sisa']);

        if (!$this->kib_temp->form_verify($data)) {
            $this->message('Isi data yang wajib diisi', 'danger');
            $this->go('aset/kibb/add_hibah`/' . $data['id_hibah']);
        }

        $data_final = array();
        $kuantitas = !empty($data['kuantitas']) ? $data['kuantitas'] : 1;
        unset($data['kuantitas']);

        for ($i = 0; $i < $kuantitas; $i++) {
            $data_final[$i] = $data;
            $data_final[$i]['reg_barang'] = $this->kib->get_reg_barang($data['id_kategori']) + $i;
            $data_final[$i]['reg_induk'] = $this->kib->get_reg_induk();
            $data_final[$i]['id_hibah'] = $data['id_hibah'];
        }

        $sukses = $this->kib_temp->batch_insert($data_final);
        if ($sukses) {
            $this->message('Data berhasil disimpan', 'success');
            $this->go('hibah/rincian/' . $data['id_hibah']);
        } else {
            $this->message('Data gagal disimpan', 'danger');
            $this->go('aset/kibb/add_hibah/' . $data['id_hibah']);
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
            $this->go('aset/kibb/edit_hibah/' . $id);
        }

        $sukses = $this->kib_temp->update($id, $data);
        if ($sukses) {
            $this->message('Data berhasil disunting', 'success');
            $this->go('hibah/rincian/' . $data['id_hibah']);
        } else {
            $this->message('Data gagal disunting', 'danger');
            $this->go('aset/kibb/edit_hibah/' . $id);
        }
    }

    public function delete($id = NULL)
    {
        if (empty($id))
            show_404();

        $id_hibah = $this->kib->get($id)->id_hibah;
        $sukses = $this->kib->delete($id);
        if ($sukses) {
            $this->message("Data berhasil dihapus", 'success');
            $this->go('hibah/rincian/' . $id_hibah);
        } else {
            $this->message('Data gagal dihapus', 'danger');
            $this->go('hibah/rincian/' . $id_hibah);
        }
    }
}