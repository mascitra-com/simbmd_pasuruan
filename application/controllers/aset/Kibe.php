<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kibe extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('aset/Kibe_model', 'kib');
        $this->load->model('aset/Temp_kibe_model', 'kib_temp');
        $this->load->model('Organisasi_model', 'organisasi');
        $this->load->model('Kategori_model', 'kategori');
        $this->load->model('Ruangan_model', 'ruangan');
        $this->load->model('Spk_model', 'spk');
        $this->load->model('Penghapusan_model', 'hapus');
        $this->load->model('Hibah_model', 'hibah');
        $this->load->library('pagination');
    }

    public function index()
    {
        $filter = $this->input->get();
        $data['organisasi'] = $this->organisasi->get_data(array('jenis' => 4));
        $filter['id_organisasi'] = isset($filter['id_organisasi']) ? $filter['id_organisasi'] : '';

        # Jika bukan superadmin
        if (!$this->auth->get_super_access()) {
            $filter['id_organisasi'] = $this->auth->get_id_organisasi();
            $data['organisasi'] = $this->organisasi->get_many_by('id', $filter['id_organisasi']);
        }

        $result = $this->kib->get_data($filter);
        $data['kib'] = $result['data'];
        $data['pagination'] = $this->pagination->get_pagination($result['data_count'], $filter, 'aset/' . get_class($this));
        $data['filter'] = (!empty($filter) ? $filter : array('id_organisasi' => ''));

        $this->render('modules/aset/kibe/index', $data);
    }

    public function add($id = NULL)
    {
        if (empty($id)) {
            $this->message('Pilih organisasi terlebih dahulu', 'danger');
            $this->go('aset/kibe');
        }

        $data['org'] = $this->organisasi->get($id);
        $data['kat'] = $this->kategori->get_data_list(array('sub_dari' => NULL));
        $data['ruangan'] = $this->ruangan->get_many_by('id_organisasi', $id);
        $this->render('modules/aset/kibe/form', $data);
    }

    public function add_pengadaan($id_spk = NULL)
    {
        if (empty($id_spk))
            show_404();

        $data['spk'] = $this->spk->get($id_spk);
        $data['ruangan'] = $this->ruangan->get_many_by('id_organisasi', $data['spk']->id_organisasi);
        $this->render('modules/pengadaan/form_kibe', $data);
    }

    public function add_hibah($id_hibah = NULL)
    {
        if (empty($id_hibah))
            show_404();

        $data['hibah'] = $this->hibah->get($id_hibah);
        $data['ruangan'] = $this->ruangan->get_many_by('id_organisasi', $data['hibah']->id_organisasi);
        $this->render('modules/hibah/form_kibe', $data);
    }

    public function add_transfer($id_transfer = NULL)
    {
        $this->load->model('Transfer_model', 'transfer');
        $this->load->model('aset/Temp_kibe_model', 'kib_temp');

        if (empty($id_transfer))
            show_404();

        $data['transfer'] = $this->transfer->get($id_transfer);
        $where_not_in     = $this->kib_temp->select('id_aset')->as_array()->get_many_by('id_transfer', $id_transfer);
        $where_not_in     = array_column($where_not_in, 'id_aset');
        
        # FILTER
        $filter = $this->input->get();
        $filter['id_organisasi'] =  $data['transfer']->id_organisasi;

        $result = $this->kib->where_not_in('id', !empty($where_not_in)?$where_not_in:'')->get_data($filter);

        $data['filter']         = $filter;
        $data['kib']            = $result['data'];
        $data['terpilih_count'] = count($where_not_in);
        $data['pagination']     = $this->pagination->get_pagination($result['data_count'], $filter, 'aset/kibe/add_transfer/'.$data['transfer']->id);
        $this->render('modules/transfer/kibe', $data);
    }

    public function add_penghapusan($id_hapus = NULL)
    {
        $this->load->model('Penghapusan_model', 'hapus');
        if (empty($id_hapus))
            show_404();

        $data['hapus'] = $this->hapus->get($id_hapus);
        $where_not_in = $this->kib_temp->select('id_aset')->as_array()->get_many_by('id_hapus', $id_hapus);
        $where_not_in = array_column($where_not_in, 'id_aset');

        $filter = $this->input->get();
        $filter['id_organisasi'] = $data['hapus']->id_organisasi;

        $result = $this->kib->where_not_in('id', !empty($where_not_in) ? $where_not_in : "")->get_data($filter);

        $data['filter'] = $filter;
        $data['kib'] = $result['data'];
        $data['terpilih_count'] = count($where_not_in);
        $data['pagination'] = $this->pagination->get_pagination($result['data_count'], $filter, 'aset/' . get_class($this) . '/add_penghapusan');
        $this->render('modules/penghapusan/kibe', $data);
    }

    public function edit($id = NULL)
    {
        if (empty($id)) {
            $this->message('Pilih organisasi terlebih dahulu', 'danger');
            $this->go('aset/kibe');
        }

        $data['kib'] = $this->kib->get($id);
        $data['kib']->id_kategori = $this->kategori->get($data['kib']->id_kategori);
        $data['org'] = $this->organisasi->get($data['kib']->id_organisasi);
        $data['kat'] = $this->kategori->get_data_list(array('sub_dari' => NULL));
        $data['ruangan'] = $this->ruangan->get_many_by('id_organisasi', $id);
        $this->render('modules/aset/kibe/form', $data);
    }

    public function edit_pengadaan($id = NULL)
    {
        if (empty($id))
            show_404();

        $data['kib'] = $this->kib->get($id);
        $data['kib']->id_kategori = $this->kategori->get($data['kib']->id_kategori);
        $data['spk'] = $this->spk->get($data['kib']->id_spk);
        $this->render('modules/pengadaan/form_kibe', $data);
    }

    public function edit_hibah($id = NULL)
    {
        if (empty($id))
            show_404();

        $data['kib'] = $this->kib->get($id);
        $data['kib']->id_kategori = $this->kategori->get($data['kib']->id_kategori);
        $data['hibah'] = $this->hibah->get($data['kib']->id_hibah);
        $this->render('modules/hibah/form_kibe', $data);
    }

    public function insert()
    {
        $data = $this->input->post();
        $data['tahun'] = !empty($data['tgl_perolehan']) ? datify($data['tgl_perolehan'], 'Y') : '';
        $data['nilai'] 	= unmonefy($data['nilai']);
        $data['nilai_sisa'] 	= unmonefy($data['nilai_sisa']);

        if (!$this->kib->form_verify($data)) {
            $this->message('Isi data yang wajib diisi', 'danger');
            $this->go('aset/kibe/add/' . $data['id_organisasi']);
        }
        $data['reg_barang'] = $this->kib->get_reg_barang($data['id_kategori']);
        $data['reg_induk'] = $this->kib->get_reg_induk();

        $sukses = $this->kib->insert($data);
        if ($sukses) {
            $this->message('Data berhasil disimpan', 'success');
            $this->go('aset/kibe/add/' . $data['id_organisasi']);
        } else {
            $this->message('Data gagal disimpan', 'danger');
            $this->go('aset/kibe/add/' . $data['id_organisasi']);
        }
    }

    public function insert_pengadaan()
    {
        $data = $this->input->post();
        $data['tahun'] = !empty($data['tgl_perolehan']) ? datify($data['tgl_perolehan'], 'Y') : '';
        $data['nilai'] 	= unmonefy($data['nilai']);
        $data['nilai_sisa'] 	= unmonefy($data['nilai_sisa']);

        if (!$this->kib->form_verify($data)) {
            $this->message('Isi data yang wajib diisi', 'danger');
            $this->go('aset/kibe/add_pengadaan/' . $data['id_spk']);
        }

        $data_final = array();
        $kuantitas = !empty($data['kuantitas']) ? $data['kuantitas'] : 1;
        unset($data['kuantitas']);

        for ($i = 0; $i < $kuantitas; $i++) {
            $data_final[$i] = $data;
            $data_final[$i]['reg_barang'] = $this->kib->get_reg_barang($data['id_kategori']) + $i;
            $data_final[$i]['reg_induk'] = $this->kib->get_reg_induk();
        }

        $sukses = $this->kib->batch_insert($data_final);
        if ($sukses) {
            $this->message('Data berhasil disimpan', 'success');
            $this->go('pengadaan/rincian/' . $data['id_spk']);
        } else {
            $this->message('Data gagal disimpan', 'danger');
            $this->go('aset/kibe/add_pengadaan/' . $data['id_spk']);
        }
    }

    public function insert_hibah()
    {
        $data = $this->input->post();
        $data['tahun'] = !empty($data['tgl_perolehan']) ? datify($data['tgl_perolehan'], 'Y') : '';
        $data['nilai'] 	= unmonefy($data['nilai']);
        $data['nilai_sisa'] 	= unmonefy($data['nilai_sisa']);

        if (!$this->kib->form_verify($data)) {
            $this->message('Isi data yang wajib diisi', 'danger');
            $this->go('aset/kibe/add_hibah/' . $data['id_hibah']);
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

        $sukses = $this->kib->batch_insert($data_final);
        if ($sukses) {
            $this->message('Data berhasil disimpan', 'success');
            $this->go('hibah/rincian/' . $data['id_hibah']);
        } else {
            $this->message('Data gagal disimpan', 'danger');
            $this->go('aset/kibe/add_hibah/' . $data['id_hibah']);
        }
    }

    public function insert_transfer()
    {
        $this->load->model('aset/Temp_kibe_model', 'kib_temp');

        $data = $this->input->post();
        $kib  = $this->kib->as_array()->get($data['id_aset']);

        $kib['id_transfer'] = $data['id_transfer'];
        $kib['id_aset']     = $data['id_aset'];

        unset($kib['id']);

        $sukses = $this->kib_temp->insert($kib);
        if($sukses) {
            $terpilih_count = $this->kib_temp->count_by('id_transfer', $data['id_transfer']);
            echo json_encode(array('status'=>'sukses', 'terpilih_count'=> $terpilih_count));
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

        if (!$this->kib->form_verify($data)) {
            $this->message('Isi data yang wajib diisi', 'danger');
            $this->go('aset/kibe/edit/' . $id);
        }

        $sukses = $this->kib->update($id, $data);
        if ($sukses) {
            $this->message('Data berhasil disimpan', 'success');
            $this->go('aset/kibd?id_organisasi='.$data['id_organisasi']);
        } else {
            $this->message('Data gagal disimpan', 'danger');
            $this->go('aset/kibe/edit/' . $id);
        }
    }

    public function update_pengadaan()
    {
        $data = $this->input->post();
        $data['tahun'] = !empty($data['tgl_perolehan']) ? datify($data['tgl_perolehan'], 'Y') : NULL;
        $data['nilai'] 	= unmonefy($data['nilai']);
        $data['nilai_sisa'] 	= unmonefy($data['nilai_sisa']);
        $id = $data['id'];
        unset($data['id']);

        if (!$this->kib->form_verify($data)) {
            $this->message('Isi data yang wajib diisi', 'danger');
            $this->go('aset/kibe/edit_pengadaan/' . $id);
        }

        $sukses = $this->kib->update($id, $data);
        if ($sukses) {
            $this->message('Data berhasil disunting', 'success');
            $this->go('pengadaan/rincian/' . $data['id_spk']);
        } else {
            $this->message('Data gagal disunting', 'danger');
            $this->go('aset/kibe/edit_pengadaan/' . $id);
        }
    }

    public function update_hibah()
    {
        $data = $this->input->post();
        $data['tahun'] = !empty($data['tgl_perolehan']) ? datify($data['tgl_perolehan'], 'Y') : NULL;
        $data['nilai'] 	= unmonefy($data['nilai']);
        $data['nilai_sisa'] 	= unmonefy($data['nilai_sisa']);
        $id = $data['id'];
        unset($data['id']);

        if (!$this->kib->form_verify($data)) {
            $this->message('Isi data yang wajib diisi', 'danger');
            $this->go('aset/kibe/edit_hibah/' . $id);
        }

        $sukses = $this->kib->update($id, $data);
        if ($sukses) {
            $this->message('Data berhasil disunting', 'success');
            $this->go('hibah/rincian/' . $data['id_hibah']);
        } else {
            $this->message('Data gagal disunting', 'danger');
            $this->go('aset/kibe/edit_hibah/' . $id);
        }
    }

    public function insert_penghapusan()
    {
        $input = $this->input->post();
        $kib = $this->kib->as_array()->get($input['id_aset']);
        $kib['id_hapus'] = $input['id_hapus'];
        $kib['id_aset']  = $input['id_aset'];
        unset($kib['id']);
        $sukses = $this->kib_temp->insert($kib);
        if($sukses) {
            $terpilih_count = $this->kib_temp->count_by('id_hapus', $input['id_hapus']);
            echo json_encode(array('status'=>'sukses', 'terpilih_count'=> $terpilih_count));
        }
    }

    public function delete($id = NULL)
    {
        if (empty($id)) {
            $this->message('Pilih organisasi terlebih dahulu', 'danger');
            $this->go('aset/kibe');
        }

        $sukses = $this->kib->update($id, array('is_deleted' => 1));
        if ($sukses) {
            $this->message("Data berhasil dihapus, <a href='" . site_url('aset/kibe/undelete/' . $id) . "'><b>Urungkan!</b></a>", 'success');
            $this->go('aset/kibe');
        } else {
            $this->message('Data gagal dihapus', 'danger');
            $this->go('aset/kibe');
        }
    }

    public function delete_pengadaan($id = NULL)
    {
        if (empty($id))
            show_404();

        $data = $this->kib->get($id);
        $sukses = $this->kib->delete($id);
        if ($sukses) {
            $this->message("Data berhasil dihapus", 'success');
            $this->go('pengadaan/rincian/' . $data->id_spk);
        } else {
            $this->message('Data gagal dihapus', 'danger');
            $this->go('pengadaan/rincian/' . $data->id_spk);
        }
    }

    public function delete_hibah($id = NULL)
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

    public function delete_penghapusan($id = NULL)
    {
        if (empty($id))
            show_404();

        $id_hapus = $this->kib_temp->get($id)->id_hapus;
        $sukses = $this->kib_temp->delete($id);
        if ($sukses) {
            $this->message("Data berhasil dihapus", 'success');
            $this->go('penghapusan/rincian/' . $id_hapus);
        } else {
            $this->message('Data gagal dihapus', 'danger');
            $this->go('penghapusan/rincian/' . $id_hapus);
        }
    }

    public function delete_transfer($id = NULL)
    {
        $this->load->model('aset/Temp_kibe_model', 'kib_temp');

        if (empty($id))
            show_404();

        $id_transfer = $this->kib_temp->get($id)->id_transfer;
        $sukses      = $this->kib_temp->delete($id);
        if ($sukses) {
            $this->message("Data berhasil dihapus", 'success');
            $this->go('transfer/keluar_rincian/' . $id_transfer);
        } else {
            $this->message('Data gagal dihapus', 'danger');
            $this->go('transfer/keluar_rincian/' . $id_transfer);
        }
    }

    public function undelete($id = NULL)
    {
        if (empty($id)) {
            $this->message('Pilih organisasi terlebih dahulu', 'danger');
            $this->go('aset/kibe');
        }

        $sukses = $this->kib->update($id, array('is_deleted' => 0));
        if ($sukses) {
            $this->message("Data dihapus berhasil diurungkan.", 'success');
            $this->go('aset/kibe');
        } else {
            $this->message('Data dihapus gagal diurungkan', 'danger');
            $this->go('aset/kibe');
        }
    }
}