<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hapus extends MY_Controller {

    public $is_superadmin = 1;
    public $jenis_koreksi = 4;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Koreksi_model', 'koreksi');
        $this->load->model('Koreksi_detail_model', 'koreksi_detail');
        $this->load->model('Organisasi_model', 'organisasi');
        $this->load->library('pagination');
    }

    public function index()
    {
        $filter = $this->input->get();
        $filter['id_organisasi'] = isset($filter['id_organisasi']) ? $filter['id_organisasi'] : '';
        $filter['jenis_koreksi'] = $this->jenis_koreksi;
        $filter['ord_by']  		 = 'log_time';

        $result = $this->koreksi->get_data($filter);

        $data['koreksi'] 	= $result['data'];
        $data['organisasi'] = $this->organisasi->get_data_by_auth();
        $data['filter'] 	= !empty($filter) ? $filter : array('id_organisasi' => '');
        $data['pagination'] = $this->pagination->get_pagination($result['data_count'], $filter, 'koreksi/' . get_class($this));

        $this->render('modules/koreksi/hapus/index', $data);
    }

    public function rincian($id = NULL)
    {
        if (empty($id))
            show_404();

        $data['koreksi'] = $this->koreksi->get($id);
        $data['rincian'] = $this->koreksi->get_data_rincian($id);

        if (empty($data['koreksi'])) {
            show_404();
        }

        $this->render('modules/koreksi/hapus/rincian', $data);
    }

    public function rincian_redirect()
    {
        $jenis = $this->input->post('jenis');
        $id    = $this->input->post('id');

        if(empty($id))
            show_404();

        switch ($jenis) {
            case 'a':
            $this->go('koreksi/aset/kiba/koreksi_hapus/'.$id);
            break;
            case 'b':
            $this->go('koreksi/aset/kibb/koreksi_hapus/'.$id);
            break;
            case 'c':
            $this->go('koreksi/aset/kibc/koreksi_hapus/'.$id);
            break;
            case 'd':
            $this->go('koreksi/aset/kibd/koreksi_hapus/'.$id);
            break;
            case 'e':
            $this->go('koreksi/aset/kibe/koreksi_hapus/'.$id);
            break;

            default:
            show_404();
            break;
        }
    }

    public function insert()
    {
        $data = $this->input->post();

        if (!$this->koreksi->form_verify($data)) {
            $this->message('Isi data yang perlu diisi.', 'warning');
            $this->go('koreksi/hapus?id_organisasi='.$data['id_organisasi']);
        }

        $data['jenis_koreksi'] = $this->jenis_koreksi;
        $sukses = $this->koreksi->insert($data);

        if($sukses) {
            $this->message('Data berhasil disimpan','success');
            $this->go('koreksi/hapus/rincian/'.$sukses);
        } else {
            $this->message('Data gagal disimpan','danger');
            $this->go('koreksi/hapus?id_organisasi='.$data['id_organisasi']);
        }
    }

    public function update()
    {
        $data = $this->input->post();
        $id   = $data['id'];
        unset($data['id']);

        if(empty($id))
            show_404();

        if (!$this->koreksi->form_verify($data)) {
            $this->message('Isi data yang perlu diisi.', 'warning');
            $this->go('koreksi/hapus/rincian/'.$id);
        }

        $sukses = $this->koreksi->update($id, $data);

        if($sukses) {
            $this->message('Data berhasil disunting','success');
        } else {
            $this->message('Data gagal disunting','danger');
        }

        $this->go('koreksi/hapus/rincian/'.$id);
    }

    public function delete($id = null)
    {
        $this->load->model('aset/Temp_kiba_model', 'kiba');
        $this->load->model('aset/Temp_kibb_model', 'kibb');
        $this->load->model('aset/Temp_kibc_model', 'kibc');
        $this->load->model('aset/Temp_kibd_model', 'kibd');
        $this->load->model('aset/Temp_kibe_model', 'kibe');

        if(empty($id))
            show_404();

        $id_organisasi = $this->koreksi->get($id)->id_organisasi;
        $sukses        = $this->koreksi->delete($id);
        if($sukses) {
            $this->kiba->delete_by(array('id_koreksi'=>$id));
            $this->kibb->delete_by(array('id_koreksi'=>$id));
            $this->kibc->delete_by(array('id_koreksi'=>$id));
            $this->kibd->delete_by(array('id_koreksi'=>$id));
            $this->kibe->delete_by(array('id_koreksi'=>$id));

            $this->message('Data berhasil dihapus','success');
        } else {
            $this->message('Data gagal dihapus','danger');
        }

        $this->go('koreksi/hapus?id_organisasi='.$id_organisasi);
    }

    public function finish_transaction($id = NULL)
    {
        if(empty($id))
            show_404();

        $data   = array('status_pengajuan'=>1);
        $sukses = $this->koreksi->update($id, $data);
        if($sukses) {
            $this->message('Data berhasil diajukan','success');
        } else {
            $this->message('Terjadi kesalahan', 'danger');
        }
        $this->go('koreksi/hapus/rincian/'.$id);
    }

    public function cancel_transaction($id = NULL)
    {
        if(empty($id))
            show_404();

        $data   = array('status_pengajuan'=>0);
        $sukses = $this->koreksi->update($id, $data);
        if($sukses) {
            $this->message('Data berhasil dibatalkan','success');
        } else {
            $this->message('Terjadi kesalahan', 'danger');
        }
        $this->go('koreksi/hapus/rincian/'.$id);
    }
}