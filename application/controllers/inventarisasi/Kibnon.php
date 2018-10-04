<?php
class Kibnon extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('aset/Kibnon_model', 'kib');
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
        $this->render('modules/inventarisasi/form_kibnon', $data);
    }

    public function edit($id = NULL)
    {
        if (empty($id))
            show_404();

        $data['kib'] = $this->kib->get($id);
        $data['inventarisasi'] = $this->inventarisasi->get($data['kib']->id_inventarisasi);
        $this->render('modules/inventarisasi/form_kibnon', $data);
    }

    public function insert()
    {
        $data = $this->input->post();
        $data['nilai'] = unmonefy($data['nilai']);

        if (!$this->kib->form_verify($data)) {
            $this->message('Isi data yang wajib diisi', 'danger');
            $this->go('inventarisasi/kibnon/add/' . $data['id_inventarisasi']);
        }

        $data_final = array();
        $kuantitas = !empty($data['kuantitas']) ? $data['kuantitas'] : 1;
        unset($data['kuantitas']);

        for ($i = 0; $i < $kuantitas; $i++) {
            $data_final[$i] = $data;
            $data_final[$i]['id_inventarisasi'] = $data['id_inventarisasi'];
        }

        $sukses = $this->kib->batch_insert($data_final);
        if ($sukses) {
            $this->message('Data berhasil disimpan', 'success');
            $this->go('inventarisasi/index/rincian/' . $data['id_inventarisasi']);
        } else {
            $this->message('Data gagal disimpan', 'danger');
            $this->go('inventarisasi/kibnon/add/' . $data['id_inventarisasi']);
        }
    }

    public function update()
    {
        $data = $this->input->post();
        $data['nilai'] = unmonefy($data['nilai']);
        $id = $data['id'];
        unset($data['id']);

        if (!$this->kib->form_verify($data)) {
            $this->message('Isi data yang wajib diisi', 'danger');
            $this->go('inventarisasi/kibnon/edit/' . $id);
        }

        $sukses = $this->kib->update($id, $data);
        if ($sukses) {
            $this->message('Data berhasil disunting', 'success');
            $this->go('inventarisasi/index/rincian/' . $data['id_inventarisasi']);
        } else {
            $this->message('Data gagal disunting', 'danger');
            $this->go('inventarisasi/kibnon/edit/' . $id);
        }
    }

    public function delete($id = NULL)
    {
        if (empty($id))
            show_404();

        $id_inventarisasi = $this->kib->get($id)->id_inventarisasi;
        $sukses = $this->kib->delete($id);
        if ($sukses) {
            $this->message("Data berhasil dihapus", 'success');
            $this->go('inventarisasi/index/rincian/' . $id_inventarisasi);
        } else {
            $this->message('Data gagal dihapus', 'danger');
            $this->go('inventarisasi/index/rincian/' . $id_inventarisasi);
        }
    }
}