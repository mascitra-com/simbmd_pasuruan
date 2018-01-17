<?php
/**
 * Created by PhpStorm.
 * User: Rizki Herdatullah
 * Date: 12/12/2017
 * Time: 13.59
 */

class Index extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('aset/Temp_kiba_model', 'kiba');
        $this->load->model('aset/Temp_kibb_model', 'kibb');
        $this->load->model('aset/Temp_kibc_model', 'kibc');
        $this->load->model('aset/Temp_kibd_model', 'kibd');
        $this->load->model('aset/Temp_kibe_model', 'kibe');
        $this->load->model('Organisasi_model', 'organisasi');
        $this->load->model('Penghapusan_model', 'hapus');
    }

    public function index()
    {
        $this->load->library('Pagination');
        $filter = $this->input->get();
        $filter['id_organisasi'] = isset($filter['id_organisasi']) ? $filter['id_organisasi'] : '';

        $result = $this->hapus->get_data($filter);

        $data['hapus'] = $result['data'];
        $data['filter'] = $filter;
        $data['organisasi'] = $this->organisasi->get_data_by_auth();
        $data['pagination'] = $this->pagination->get_pagination($result['data_count'], $filter, get_class($this));
        $this->render('modules/penghapusan/index', $data);
    }

    public function insert()
    {
        $data = $this->input->post();
        if (!$this->hapus->form_verify($data)) {
            $this->message('Isi data yang diperlukan', 'danger');
            $this->go('penghapusan?id_organisasi='.$data['id_organisasi']);
        }

        $id_insert = $this->hapus->insert($data);
        if($id_insert) {
            $this->message('Data berhasil disimpan','success');
            $this->go('penghapusan/index/detail/'.$id_insert);
        } else {
            $this->message('Terjadi kesalahan','danger');
            $this->go('penghapusan/index?id_organisasi='.$data['id_organisasi']);
        }
    }

    public function update()
    {
        $data = $this->input->post();
        if (!$this->hapus->form_verify($data)) {
            $this->message('Isi data yang diperlukan', 'danger');
            $this->go('penghapusan/index?id_organisasi='.$data['id_organisasi']);
        }

        $sukses = $this->hapus->update($data['id'], $data);
        if($sukses) {
            $this->message('Data berhasil disimpan','success');
            $this->go('penghapusan/index/detail/'.$data['id']);
        } else {
            $this->message('Terjadi kesalahan','danger');
            $this->go('penghapusan/index?id_organisasi='.$data['id']);
        }
    }

    public function detail($id = null) {
        if (empty($id)) {
            show_404();
        }

        $data['hapus'] = $this->hapus->subtitute($this->hapus->get($id));
        $this->render('modules/penghapusan/detail', $data);
    }

    public function rincian($id = null)
    {
        if (empty($id)) {
            show_404();
        }
        $data['hapus'] = $this->hapus->subtitute($this->hapus->get($id));

        # RINCIAN
        $data['kiba'] = $this->kiba->get_data_hapus($data['hapus']->id);
        $data['kibb'] = $this->kibb->get_data_hapus($data['hapus']->id);
        $data['kibc'] = $this->kibc->get_data_hapus($data['hapus']->id);
        $data['kibd'] = $this->kibd->get_data_hapus($data['hapus']->id);
        $data['kibe'] = $this->kibe->get_data_hapus($data['hapus']->id);

        $this->session->unset_userdata('hapus_aset');
        $this->render('modules/penghapusan/rincian', $data);
    }

    public function delete($id = null)
    {
        if(empty($id))
            show_404();

        $sukses = $this->hapus->delete($id);
        if($sukses) {
            $this->kiba->delete_by(array('id_hapus'=>$id));
            $this->kibb->delete_by(array('id_hapus'=>$id));
            $this->kibc->delete_by(array('id_hapus'=>$id));
            $this->kibd->delete_by(array('id_hapus'=>$id));
            $this->kibe->delete_by(array('id_hapus'=>$id));

            $this->message('Data berhasil dihapus','success');
            $this->go('penghapusan');
        } else {
            $this->message('Data gagal dihapus','danger');
            $this->go('penghapusan');
        }

    }

    public function rincian_redirect($id_hapus = null)
    {
        if(empty($id_hapus))
            show_404();

        $jenis = $this->input->post('jenis');

        switch ($jenis) {
            case 'a':
                $this->go('penghapusan/kiba/add/'.$id_hapus);
                break;
            case 'b':
                $this->go('penghapusan/kibb/add/'.$id_hapus);
                break;
            case 'c':
                $this->go('penghapusan/kibc/add/'.$id_hapus);
                break;
            case 'd':
                $this->go('penghapusan/kibd/add/'.$id_hapus);
                break;
            case 'e':
                $this->go('penghapusan/kibe/add/'.$id_hapus);
                break;
            default:
                show_404();
                break;
        }
    }
    public function finish_transaction($id = NULL)
    {
        if(empty($id))
            show_404();

        $data   = array('status_pengajuan'=>1);
        $sukses = $this->hapus->update($id, $data);
        if($sukses) {
            $this->message('Pengajuan Berhasil','success');
            $this->go('penghapusan/index/detail/'.$id);
        } else {
            $this->message('Terjadi kesalahan', 'danger');
            $this->go('penghapusan/index/detail/'.$id);
        }
    }

    public function cancel_transaction($id = NULL)
    {
        if(empty($id))
            show_404();

        $data   = array('status_pengajuan'=>0);
        $sukses = $this->hapus->update($id, $data);
        if($sukses) {
            $this->message('Pengajuan Berhasil dibatalkan','success');
            $this->go('penghapusan/index/detail/'.$id);
        } else {
            $this->message('Terjadi kesalahan', 'danger');
            $this->go('penghapusan/index/detail/'.$id);
        }
    }
}