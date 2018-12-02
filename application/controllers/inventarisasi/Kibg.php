<?php
class Kibg extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('aset/Temp_kibg_model', 'kib_temp');
        $this->load->model('Organisasi_model', 'organisasi');
        $this->load->model('Kategori_model', 'kategori');
        $this->load->model('Ruangan_model', 'ruangan');
        $this->load->model('Inventarisasi_model', 'inventarisasi');
    }

    public function add($id_inventarisasi = NULL)
    {
        if (empty($id_inventarisasi))
            show_404();

        $data['inventarisasi'] = $this->inventarisasi->get($id_inventarisasi);
        $data['ruangan'] = $this->ruangan->get_many_by('id_organisasi', $data['inventarisasi']->id_organisasi);
        $this->render('modules/inventarisasi/form_kibg', $data);
    }

    public function edit($id = NULL)
    {
        if (empty($id))
            show_404();

        $data['kib'] = $this->kib_temp->get($id);
        $data['kib']->id_kategori = $this->kategori->get($data['kib']->id_kategori);
        $data['inventarisasi'] = $this->inventarisasi->get($data['kib']->id_inventarisasi);
        $data['ruangan'] = $this->ruangan->get_many_by('id_organisasi', $data['inventarisasi']->id_organisasi);
        $this->render('modules/inventarisasi/form_kibg', $data);
    }

    public function insert()
    {
        $data = $this->input->post();
        $data['tahun'] = !empty($data['tgl_perolehan']) ? datify($data['tgl_perolehan'], 'Y') : '';
        $data['nilai'] 	= unmonefy($data['nilai']);
        $data['nilai_sisa'] 	= unmonefy($data['nilai_sisa']);

        if (!$this->kib_temp->form_verify($data)) {
            $this->message('Isi data yang wajib diisi', 'danger');
            $this->go('inventarisasi/kibg/add/' . $data['id_inventarisasi']);
        }

        $data_final = array();
        $kuantitas = !empty($data['kuantitas']) ? $data['kuantitas'] : 1;
        unset($data['kuantitas']);

        for ($i = 0; $i < $kuantitas; $i++) {
            $data_final[$i] = $data;
            $data_final[$i]['reg_barang'] = 0;
            $data_final[$i]['reg_induk'] = 0;
            $data_final[$i]['id_inventarisasi'] = $data['id_inventarisasi'];
        }

        $sukses = $this->kib_temp->batch_insert($data_final);
        if ($sukses) {
            $this->message('Data berhasil disimpan', 'success');
            $this->go('inventarisasi/index/rincian/' . $data['id_inventarisasi']);
        } else {
            $this->message('Data gagal disimpan', 'danger');
            $this->go('inventarisasi/kibg/add/' . $data['id_inventarisasi']);
        }
    }

    public function update()
    {
        $data = $this->input->post();
        $data['tahun'] = !empty($data['tgl_perolehan']) ? datify($data['tgl_perolehan'], 'Y') : NULL;
        $data['nilai'] = unmonefy($data['nilai']);
        $data['nilai_sisa'] = unmonefy($data['nilai_sisa']);
        $id = $data['id'];
        unset($data['id']);

        if (!$this->kib_temp->form_verify($data)) {
            $this->message('Isi data yang wajib diisi', 'danger');
            $this->go('inventarisasi/kibg/edit/' . $id);
        }

        $sukses = $this->kib_temp->update($id, $data);
        if ($sukses) {
            $this->message('Data berhasil disunting', 'success');
            $this->go('inventarisasi/index/rincian/' . $data['id_inventarisasi']);
        } else {
            $this->message('Data gagal disunting', 'danger');
            $this->go('inventarisasi/kibg/edit/' . $id);
        }
    }

    public function delete($id = NULL)
    {
        if (empty($id))
            show_404();

        $id_inventarisasi = $this->kib_temp->get($id)->id_inventarisasi;
        $sukses = $this->kib_temp->delete($id);
        if ($sukses) {
            $this->message("Data berhasil dihapus", 'success');
            $this->go('inventarisasi/index/rincian/' . $id_inventarisasi);
        } else {
            $this->message('Data gagal dihapus', 'danger');
            $this->go('inventarisasi/index/rincian/' . $id_inventarisasi);
        }
    }
}