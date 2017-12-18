<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kibd extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('aset/Kibd_model', 'kib');
        $this->load->model('aset/Kibd_temp_model', 'kib_temp');
        $this->load->model('Organisasi_model', 'organisasi');
        $this->load->model('Kategori_model', 'kategori');
        $this->load->model('Spk_model', 'spk');
        $this->load->model('Hibah_model', 'hibah');
        $this->load->model('Penghapusan_model', 'hapus');
        $this->load->library('pagination');
    }

    public function index()
    {
        $filter = $this->input->get();
        $data['organisasi'] = $this->organisasi->get_data(array('jenis' => 4));
        $filter['id_organisasi'] = isset($filter['id_organisasi']) ? $filter['id_organisasi'] : '';
        $filter['is_kdp'] = false;

        # Jika bukan superadmin
        if (!$this->auth->get_super_access()) {
            $filter['id_organisasi'] = $this->auth->get_id_organisasi();
            $data['organisasi'] = $this->organisasi->get_many_by('id', $filter['id_organisasi']);
        }

        $result = $this->kib->get_data($filter);
        $data['kib'] = $result['data'];
        $data['statistic'] = $this->kib->get_statistic($filter['id_organisasi'], $filter['is_kdp']);
        $data['pagination'] = $this->pagination->get_pagination($result['data_count'], $filter, 'aset/' . get_class($this));
        $data['filter'] = (!empty($filter) ? $filter : array('id_organisasi' => ''));

        $this->render('modules/aset/kibd/index', $data);
    }

    public function kdp()
    {
        $filter = $this->input->get();
        $data['organisasi'] = $this->organisasi->get_data(array('jenis' => 4));
        $filter['id_organisasi'] = isset($filter['id_organisasi']) ? $filter['id_organisasi'] : '';
        $filter['is_kdp'] = true;

        # Jika bukan superadmin
        if (!$this->auth->get_super_access()) {
            $filter['id_organisasi'] = $this->auth->get_id_organisasi();
            $data['organisasi'] = $this->organisasi->get_many_by('id', $filter['id_organisasi']);
        }

        $result = $this->kib->get_data($filter);
        $data['kib'] = $result['data'];
        $data['statistic'] = $this->kib->get_statistic($filter['id_organisasi'], $filter['is_kdp']);
        $data['pagination'] = $this->pagination->get_pagination($result['data_count'], $filter, 'aset/' . get_class($this));
        $data['filter'] = (!empty($filter) ? $filter : array('id_organisasi' => ''));

        $this->render('modules/aset/kibd/index', $data);
    }

    public function add($id = NULL)
    {
        if (empty($id)) {
            $this->message('Pilih organisasi terlebih dahulu', 'danger');
            $this->go('aset/kibd');
        }

        $data['org'] = $this->organisasi->get($id);
        $data['kat'] = $this->kategori->get_data_list(array('sub_dari' => NULL));
        $this->render('modules/aset/kibd/form', $data);
    }

    public function add_pengadaan($id_spk = NULL)
    {
        if (empty($id_spk))
            show_404();

        $data['spk'] = $this->spk->get($id_spk);
        $this->render('modules/pengadaan/form_kibd', $data);
    }

    public function add_hibah($id_hibah = NULL)
    {
        if (empty($id_hibah))
            show_404();

        $data['hibah'] = $this->hibah->get($id_hibah);
        $this->render('modules/hibah/form_kibd', $data);
    }

    public function add_transfer($id_organisasi = NULL)
    {
        if (empty($id_organisasi))
            show_404();

        $filter = $this->input->get();
        $filter['is_kdp'] = false;
        $filter['id_organisasi'] = $id_organisasi;

        $result = $this->kib->get_data($filter);
        $data['filter'] = $filter;
        $data['kib'] = $result['data'];
        $data['pagination'] = $this->pagination->get_pagination($result['data_count'], $filter, 'aset/' . get_class($this));
        $this->render('modules/transfer/kibd', $data);
    }

    public function add_penghapusan($id = NULL)
    {
        if (empty($id))
            show_404();

        $filter = $this->input->get();

        $data['hapus'] = $this->hapus->get($id);
        $filter['id_organisasi'] = $data['hapus']->id_organisasi;
        $filter['is_kdp'] = false;

        $aset = $this->db->select('id_aset')->where('id_hapus', $data['hapus']->id)->from('aset_d_temp')->get()->result_array();
        $aset = array_column($aset, 'id_aset');
        if (count($aset))
            $result = $this->kib->where_not_in('aset_d.id', $aset)->get_data($filter);
        else
            $result = $this->kib->get_data($filter);
        $data['aset'] = $aset;

        $data['filter'] = $filter;
        $data['kib'] = $result['data'];
        $data['pagination'] = $this->pagination->get_pagination($result['data_count'], $filter, 'aset/' . get_class($this));
        $this->render('modules/penghapusan/kibd', $data);
    }

    public function edit($id = NULL)
    {
        if (empty($id)) {
            $this->message('Pilih organisasi terlebih dahulu', 'danger');
            $this->go('aset/kibd');
        }

        $data['kib'] = $this->kib->get($id);
        $data['kib']->id_kategori = $this->kategori->get($data['kib']->id_kategori);
        $data['org'] = $this->organisasi->get($data['kib']->id_organisasi);
        $data['kat'] = $this->kategori->get_data_list(array('sub_dari' => NULL));
        $this->render('modules/aset/kibd/form', $data);
    }

    public function edit_pengadaan($id = NULL)
    {
        if (empty($id))
            show_404();

        $data['kib'] = $this->kib->get($id);
        $data['kib']->id_kategori = $this->kategori->get($data['kib']->id_kategori);
        $data['spk'] = $this->spk->get($data['kib']->id_spk);
        $this->render('modules/pengadaan/form_kibd', $data);
    }

    public function edit_hibah($id = NULL)
    {
        if (empty($id))
            show_404();

        $data['kib'] = $this->kib->get($id);
        $data['kib']->id_kategori = $this->kategori->get($data['kib']->id_kategori);
        $data['hibah'] = $this->hibah->get($data['kib']->id_hibah);
        $this->render('modules/hibah/form_kibd', $data);
    }

    public function insert()
    {
        $data = $this->input->post();
        $data['tahun'] = !empty($data['tgl_perolehan']) ? datify($data['tgl_perolehan'], 'Y') : '';
        $data['nilai'] 	= unmonefy($data['nilai']);
        $data['nilai_sisa'] 	= unmonefy($data['nilai_sisa']);

        if (!$this->kib->form_verify($data)) {
            $this->message('Isi data yang wajib diisi', 'danger');
            $this->go('aset/kibd/add/' . $data['id_organisasi']);
        }
        $data['reg_barang'] = $this->kib->get_reg_barang($data['id_kategori']);
        $data['reg_induk'] = $this->kib->get_reg_induk();

        $sukses = $this->kib->insert($data);
        if ($sukses) {
            $this->message('Data berhasil disimpan', 'success');
            $this->go('aset/kibd/add/' . $data['id_organisasi']);
        } else {
            $this->message('Data gagal disimpan', 'danger');
            $this->go('aset/kibd/add/' . $data['id_organisasi']);
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
            $this->go('aset/kibd/add_pengadaan/' . $data['id_spk']);
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
            $this->go('aset/kibd/add_pengadaan/' . $data['id_spk']);
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
            $this->go('aset/kibd/add_hibah/' . $data['id_hibah']);
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
            $this->go('hibah/rincian/' . $data['id_hibah']);
        } else {
            $this->message('Data gagal disimpan', 'danger');
            $this->go('aset/kibd/add_hibah/' . $data['id_hibah']);
        }
    }

    public function insert_penghapusan()
    {
        $input = $this->input->get();
        $kib = $this->kib->get($input['id_aset']);
        $kib->id_aset = $kib->id;
        $kib->id_hapus = $input['id'];
        unset($kib->id);
        if ($this->db->insert('aset_d_temp', $kib)) {
            $this->message('Data berhasil disimpan', 'success');
            $this->go('aset/kibd/add_penghapusan/' . $input['id']);
        } else {
            $this->message('Data Gagal disimpan', 'danger');
            $this->go('aset/kibd/add_penghapusan/' . $input['id']);
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
            $this->go('aset/kibd/edit/' . $id);
        }

        $sukses = $this->kib->update($id, $data);
        if ($sukses) {
            $this->message('Data berhasil disimpan', 'success');
            $this->go('aset/kibd?id_organisasi='.$data['id_organisasi']);
        } else {
            $this->message('Data gagal disimpan', 'danger');
            $this->go('aset/kibd/edit/' . $id);
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
            $this->go('aset/kibd/edit_pengadaan/' . $id);
        }

        $sukses = $this->kib->update($id, $data);
        if ($sukses) {
            $this->message('Data berhasil disunting', 'success');
            $this->go('pengadaan/rincian/' . $data['id_spk']);
        } else {
            $this->message('Data gagal disunting', 'danger');
            $this->go('aset/kibd/edit_pengadaan/' . $id);
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
            $this->go('aset/kibd/edit_hibah/' . $id);
        }

        $sukses = $this->kib->update($id, $data);
        if ($sukses) {
            $this->message('Data berhasil disunting', 'success');
            $this->go('hibah/rincian/' . $data['id_hibah']);
        } else {
            $this->message('Data gagal disunting', 'danger');
            $this->go('aset/kibd/edit_hibah/' . $id);
        }
    }

    public function delete($id = NULL)
    {
        if (empty($id)) {
            $this->message('Pilih organisasi terlebih dahulu', 'danger');
            $this->go('aset/kibd');
        }

        $sukses = $this->kib->update($id, array('is_deleted' => 1));
        if ($sukses) {
            $this->message("Data berhasil dihapus, <a href='" . site_url('aset/kibd/undelete/' . $id) . "'><b>Urungkan!</b></a>", 'success');
            $this->go('aset/kibd');
        } else {
            $this->message('Data gagal dihapus', 'danger');
            $this->go('aset/kibd');
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

        $data = $this->kib->get($id);
        $sukses = $this->kib->delete($id);
        if ($sukses) {
            $this->message("Data berhasil dihapus", 'success');
            $this->go('hibah/rincian/' . $data->id_hibah);
        } else {
            $this->message('Data gagal dihapus', 'danger');
            $this->go('hibah/rincian/' . $data->id_hibah);
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

    public function undelete($id = NULL)
    {
        if (empty($id)) {
            $this->message('Pilih organisasi terlebih dahulu', 'danger');
            $this->go('aset/kibd');
        }

        $sukses = $this->kib->update($id, array('is_deleted' => 0));
        if ($sukses) {
            $this->message("Data dihapus berhasil diurungkan.", 'success');
            $this->go('aset/kibd');
        } else {
            $this->message('Data dihapus gagal diurungkan', 'danger');
            $this->go('aset/kibd');
        }
    }
}