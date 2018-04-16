<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kibe extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('aset/Kibe_model', 'kib');
        $this->load->model('Organisasi_model', 'organisasi');
        $this->load->model('Kategori_model', 'kategori');
        $this->load->model('Ruangan_model', 'ruangan');
        $this->load->library('pagination');
    }

    public function index()
    {
        $filter = $this->input->get();
        $filter['id_organisasi'] = isset($filter['id_organisasi']) ? $filter['id_organisasi'] : '';
        if(isset($filter['page']))
            $this->session->set_userdata('inv_page', $filter['page']);
        else
            $this->session->set_userdata('inv_page', '1');
        $data['organisasi'] = $this->organisasi->get_data_by_auth();

        $result = $this->kib->get_data($filter);
        $data['kib'] = $result['data'];
        $data['pagination'] = $this->pagination->get_pagination($result['data_count'], $filter, 'inventarisasi/' . get_class($this));
        $data['filter'] = (!empty($filter) ? $filter : array('id_organisasi' => ''));

        $this->render('modules/aset/saldo_berjalan/kibe/index', $data);
    }

    public function add($id = NULL)
    {
        if (empty($id)) {
            $this->message('Pilih organisasi terlebih dahulu', 'danger');
            $this->go('inventarisasi/kibe');
        }

        $data['org'] = $this->organisasi->get($id);
        //$data['kat'] = $this->kategori->get_data_list(array('sub_dari' => NULL));
        $data['ruangan'] = $this->ruangan->get_many_by('id_organisasi', $id);
        $this->render('modules/aset/saldo_berjalan/kibe/form', $data);
    }

    public function edit($id = NULL)
    {
        if (empty($id)) {
            $this->message('Pilih organisasi terlebih dahulu', 'danger');
            $this->go('inventarisasi/kibe');
        }

        $data['kib'] = $this->kib->get($id);
        $data['kib']->id_kategori = $this->kategori->get($data['kib']->id_kategori);
        $data['org'] = $this->organisasi->get($data['kib']->id_organisasi);
        //$data['kat'] = $this->kategori->get_data_list(array('sub_dari' => NULL));
        $data['ruangan'] = $this->ruangan->get_many_by('id_organisasi', $data['org']->id);
        $this->render('modules/aset/saldo_berjalan/kibe/form', $data);
    }

    public function insert()
    {
        $data = $this->input->post();
        $data['tahun'] = !empty($data['tgl_perolehan']) ? datify($data['tgl_perolehan'], 'Y') : '';
        $data['nilai'] 	= unmonefy($data['nilai']);
        $data['nilai_sisa'] 	= unmonefy($data['nilai_sisa']);

        if (!$this->kib->form_verify($data)) {
            $this->message('Isi data yang wajib diisi', 'danger');
            $this->go('inventarisasi/kibe/add/' . $data['id_organisasi']);
        }
        $data['reg_barang'] = $this->kib->get_reg_barang($data['id_kategori']);
        $data['reg_induk'] = $this->kib->get_reg_induk();

        $sukses = $this->kib->insert($data);
        if ($sukses) {
            $this->message('Data berhasil disimpan', 'success');
            $this->go('inventarisasi/kibe/add/' . $data['id_organisasi']);
        } else {
            $this->message('Data gagal disimpan', 'danger');
            $this->go('inventarisasi/kibe/add/' . $data['id_organisasi']);
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

        // if (!$this->kib->form_verify($data)) {
        //     $this->message('Isi data yang wajib diisi', 'danger');
        //     $this->go('inventarisasi/kibe/edit/' . $id);
        // }

        $sukses = $this->kib->update($id, $data);
        if ($sukses) {
            $this->message('Data berhasil disimpan', 'success');
        } else {
            $this->message('Data gagal disimpan', 'danger');
        }
        $this->go('inventarisasi/kibe/edit/' . $id);
    }

    public function delete($id = NULL)
    {
        if (empty($id)) {
            $this->message('Pilih organisasi terlebih dahulu', 'danger');
            $this->go('inventarisasi/kibe');
        }

        $id_organisasi = $this->kib->get($id)->id_organisasi;

        if (empty($id_organisasi) OR $this->session->auth['is_superadmin'] != 1) {
            $this->message('Aset tidak valid', 'danger');
            $this->go('inventarisasi/kibe');
        }

        $this->load->model('aset/Temp_kibe_model', 'kib_temp');
        $kib = $this->kib->get_by(array('id'=>$id, 'id_spk'=>NULL, 'id_hibah'=>NULL));
        $kib_temp = $this->kib_temp->get_many_by(array('id_aset'=>$id));

        if (empty($kib) OR !empty($kib_temp)) {
            $this->message('Aset yang anda pilih tidak dapat dihapus karena terikat dengan transaksi lain (Pengadaan/Transfer/Hapus/Reklas)', 'danger');
            $this->go('inventarisasi/kibe?id_organisasi='.$id_organisasi);
        }

        $sukses = $this->kib->delete($id);
        if ($sukses) {
            $this->message("Data berhasil dihapus", 'success');
            $this->go('inventarisasi/kibe?id_organisasi='.$id_organisasi);
        } else {
            $this->message('Data gagal dihapus', 'danger');
            $this->go('inventarisasi/kibe?id_organisasi='.$id_organisasi);
        }
    }

    public function get_rincian_widget($id_organisasi = NULL)
    {
        $result = $this->kib->get_rincian_widget($id_organisasi);
        $result->total = monefy($result->total, FALSE);
        $result->nilai = monefy($result->nilai);
        $result->total_rusak = monefy($result->total_rusak, FALSE);
        $result->nilai_rusak = monefy($result->nilai_rusak);
        echo json_encode($result);
    }
}