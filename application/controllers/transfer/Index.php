<?php
/**
* Created by PhpStorm.
* User: Rizki Herdatullah
* Date: 10/12/2017
* Time: 21.20
*/

class Index extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Transfer_model', 'transfer');
        $this->load->model('Organisasi_model', 'organisasi');
        $this->load->model('aset/Temp_kiba_model', 'kiba');
        $this->load->model('aset/Temp_kibb_model', 'kibb');
        $this->load->model('aset/Temp_kibc_model', 'kibc');
        $this->load->model('aset/Temp_kibd_model', 'kibd');
        $this->load->model('aset/Temp_kibe_model', 'kibe');
    }

    public function index() {
        show_404();
    }

    public function keluar() {
        $this->load->library('pagination');

        $filter = $this->input->get();
        $filter['id_organisasi'] = isset($filter['id_organisasi']) ? $filter['id_organisasi'] : '';

        $data['organisasi'] = $this->organisasi->get_data_by_auth();

        $result = $this->transfer->get_data($filter);
        $data['transfer'] 	= $result['data'];
        $data['pagination'] = $this->pagination->get_pagination($result['data_count'],$filter,'transfer/keluar?id_organisasi='.$filter['id_organisasi']);
        $data['filter']   	= $filter;
        $this->render('modules/transfer/keluar', $data);
    }

    public function masuk() {
        $this->load->library('pagination');

        $filter = $this->input->get();
        $data['organisasi']  = $this->organisasi->get_data(array('jenis' => 4));
        $filter['id_tujuan'] = isset($filter['id_tujuan']) ? $filter['id_tujuan'] : '';

        # Jika bukan superadmin
        if (!$this->auth->get_super_access()) {
            $filter['id_tujuan'] = $this->auth->get_id_organisasi();
            $data['organisasi']  = $this->organisasi->get_many_by('id', $filter['id_tujuan']);
        }

        $result = $this->transfer->get_data_masuk($filter);
        $data['transfer']   = $result['data'];
        $data['pagination'] = $this->pagination->get_pagination($result['data_count'],$filter,'transfer/masuk?id_organisasi='.$filter['id_tujuan']);
        $data['filter']     = $filter;
        $this->render('modules/transfer/masuk', $data);
    }

    public function add($id = null) {
        if (empty($id)) {
            $this->message('Pilih UPB Terlebih Dahulu', 'warning');
            $this->go('transfer/index/keluar');
        }
        $data['organisasi'] = $this->organisasi->get_data(array('jenis' => 4));
        $data['org'] = $this->organisasi->get($id);
        $this->load->model('pegawai_model', 'pegawai');
        $data = array_merge($data, $this->pegawai->get_cookie_pegawai(array('penerima_transfer', 'penyerah_transfer', 'atasan_transfer')));
        $this->render('modules/transfer/form', $data);
    }

    public function keluar_detail($id = null) {
        if (empty($id)) {
            show_404();
        }

        $data['transfer']	= $this->transfer->subtitute($this->transfer->get($id));
        $data['organisasi'] = $this->organisasi->get_data(array('jenis' => 4));

        $this->render('modules/transfer/keluar_detail', $data);
    }

    public function masuk_detail($id = null) {
        if (empty($id)) {
            show_404();
        }

        $data['transfer']   = $this->transfer->subtitute($this->transfer->get($id));
        $data['organisasi'] = $this->organisasi->get_data(array('jenis' => 4));

        $this->render('modules/transfer/masuk_detail', $data);
    }

    public function keluar_rincian($id = null) {
        if (empty($id))
            show_404();

        # RINCIAN
        $data['kiba'] 	  = $this->kiba->get_data_transfer($id);
        $data['kibb'] 	  = $this->kibb->get_data_transfer($id);
        $data['kibc'] 	  = $this->kibc->get_data_transfer($id);
        $data['kibd'] 	  = $this->kibd->get_data_transfer($id);
        $data['kibe']	  = $this->kibe->get_data_transfer($id);
        $data['transfer'] = $this->transfer->subtitute($this->transfer->get($id));

        $this->render('modules/transfer/keluar_rincian', $data);
    }

    public function masuk_rincian($id = null) {
        if (empty($id))
            show_404();

        # RINCIAN
        $data['kiba']     = $this->kiba->get_data_transfer($id);
        $data['kibb']     = $this->kibb->get_data_transfer($id);
        $data['kibc']     = $this->kibc->get_data_transfer($id);
        $data['kibd']     = $this->kibd->get_data_transfer($id);
        $data['kibe']     = $this->kibe->get_data_transfer($id);
        $data['transfer'] = $this->transfer->subtitute($this->transfer->get($id));

        $this->render('modules/transfer/masuk_rincian', $data);
    }

    public function rincian_redirect($id = null)
    {
        if(empty($id))
            show_404();

        $jenis = $this->input->post('jenis');

        switch ($jenis) {
            case 'a':
            $this->go('transfer/kiba/add/'.$id);
            break;
            case 'b':
            $this->go('transfer/kibb/add/'.$id);
            break;
            case 'c':
            $this->go('transfer/kibc/add/'.$id);
            break;
            case 'd':
            $this->go('transfer/kibd/add/'.$id);
            break;
            case 'e':
            $this->go('transfer/kibe/add/'.$id);
            break;
            default:
            show_404();
            break;
        }
    }

    public function insert()
    {
        $data = $this->input->post();

        if (!$this->transfer->form_verify($data)) {
            $this->message('Isi data yang perlu diisi', 'danger');
            $this->go('transfer/index/add/'.$data['idanisasi']);
        }

        $sukses = $this->transfer->insert($data);
        if($sukses) {
            $this->message('Data berhasil ditambah','success');
            $this->go('transfer/index/keluar_detail/'.$sukses);
        } else {
            $this->message('Terjadi kesalahan', 'danger');
            $this->go('transfer/index/add/'.$data['id_organisasi']);
        }
    }

    public function update()
    {
        $data = $this->input->post();
        $id   = $data['id'];
        unset($data['id']);

        if (!$this->transfer->form_verify($data)) {
            $this->message('Isi data yang perlu diisi', 'danger');
            $this->go('transfer/index/add/'.$data['id_organisasi']);
        }

        $sukses = $this->transfer->update($id, $data);
        if($sukses) {
            $this->message('Data berhasil ditambah','success');
            $this->go('transfer/index/keluar_detail/'.$id);
        } else {
            $this->message('Terjadi kesalahan', 'danger');
            $this->go('transfer/index/keluar_detail/'.$id);
        }
    }

    public function delete($id = null)
    {
        if(empty($id))
            show_404();

        $id_organisasi = $this->transfer->get($id)->id_organisasi;
        $sukses        = $this->transfer->delete($id);
        if($sukses) {
            $this->kiba->delete_by(array('id_transfer'=>$id));
            $this->kibb->delete_by(array('id_transfer'=>$id));
            $this->kibc->delete_by(array('id_transfer'=>$id));
            $this->kibd->delete_by(array('id_transfer'=>$id));
            $this->kibe->delete_by(array('id_transfer'=>$id));

            $this->message('Data berhasil dihapus','success');
            $this->go('transfer/index/keluar?id_organisasi='.$id_organisasi);
        } else {
            $this->message('Data gagal dihapus','danger');
            $this->go('transfer/index/keluar?id_organisasi='.$id_organisasi);
        }

    }

    public function finish_transaction($id = NULL)
    {
        if(empty($id))
            show_404();

        $data   = array('status_pengajuan'=>1);
        $sukses = $this->transfer->update($id, $data);
        if($sukses) {
            $this->message('Data berhasil diajukan','success');
            $this->go('transfer/index/keluar_detail/'.$id);
        } else {
            $this->message('Terjadi kesalahan', 'danger');
            $this->go('transfer/index/keluar_detail/'.$id);
        }
    }

    public function cancel_transaction($id = NULL)
    {
        if(empty($id))
            show_404();

        $data   = array('status_pengajuan'=>0);
        $sukses = $this->transfer->update($id, $data);
        if($sukses) {
            $this->message('Data berhasil dibatalkan','success');
            $this->go('transfer/index/keluar_detail/'.$id);
        } else {
            $this->message('Terjadi kesalahan', 'danger');
            $this->go('transfer/index/keluar_detail/'.$id);
        }
    }
}