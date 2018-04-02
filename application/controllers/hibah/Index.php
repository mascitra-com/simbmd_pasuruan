<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Hibah_model', 'hibah');
        $this->load->model('Organisasi_model', 'organisasi');
        $this->load->model('Kegiatan_model', 'kegiatan');

        $this->load->model('aset/Temp_kiba_model', 'kiba');
        $this->load->model('aset/Temp_kibb_model', 'kibb');
        $this->load->model('aset/Temp_kibc_model', 'kibc');
        $this->load->model('aset/Temp_kibd_model', 'kibd');
        $this->load->model('aset/Temp_kibe_model', 'kibe');
        $this->load->model('aset/Temp_kibg_model', 'kibg');
        $this->load->model('Kapitalisasi_model', 'kapitalisasi');

    }

    public function index()
    {
        $this->load->library('Pagination');

        $filter = $this->input->get();
        $result = $this->hibah->get_data($filter);
        $filter['id_organisasi'] = isset($filter['id_organisasi']) ? $filter['id_organisasi'] : '';
        
        if(isset($filter['page']))
            $this->session->set_userdata('hibah_page', $filter['page']);
        else
            $this->session->set_userdata('hibah_page', '1');

        $data['hibah'] = $result['data'];
        $data['filter'] = $filter;
        $data['organisasi'] = $this->organisasi->get_data_by_auth();
        $data['pagination'] = $this->pagination->get_pagination($result['data_count'], $filter, 'hibah/'.get_class($this));
        $data['kegiatan'] = $this->kegiatan->get_data_by_organisasi($filter['id_organisasi']);
        $this->render('modules/hibah/index', $data);
    }

    public function add()
    {
        $data['organisasi'] = $this->organisasi->get_data(array('jenis'=>4));
        $filter['id_organisasi'] = isset($filter['id_organisasi'])?$filter['id_organisasi']:'';

        # Jika bukan superadmin
        if (!$this->auth->get_super_access()) {
            $filter['id_organisasi'] = $this->auth->get_id_organisasi();
            $data['organisasi'] 	 = $this->organisasi->get_many_by('id', $filter['id_organisasi']);
        }
        $this->render('modules/hibah/form', $data);
    }

    public function insert()
    {
        $data = $this->input->post();
        if (!$this->hibah->form_verify($data)) {
            $this->message('Isi data yang diperlukan', 'danger');
            $this->go('hibah/index?id_organisasi=' . $data['id_organisasi']);
        }
        $sukses = $this->hibah->insert($data);
        if ($sukses) {
            $this->message('Data berhasil disimpan', 'success');
            $this->go('hibah/index/detail/' . $sukses);
        } else {
            $this->message('Terjadi kesalahan', 'danger');
            $this->go('hibah/index?id_organisasi=' . $data['id_organisasi']);
        }
    }

    public function update()
    {
        $data = $this->input->post();
        $id = $data['id'];

        unset($data['id']);

        if (!$this->hibah->form_verify($data)) {
            $this->message('Isi data yang diperlukan', 'danger');
            $this->go('hibah/index/detail/' . $id);
        }

        $sukses = $this->hibah->update($id, $data);
        if ($sukses) {
            $this->message('Data berhasil disunting', 'success');
            $this->go('hibah/index/detail/' . $id);
        } else {
            $this->message('Terjadi kesalahan', 'danger');
            $this->go('hibah/index/detail/' . $id);
        }
    }

    public function detail($id = NULL)
    {
        if (empty($id))
            show_404();

        $data['hibah'] = $this->hibah->get($id);
        $data['kegiatan'] = $this->kegiatan->get_data_by_organisasi($data['hibah']->id_organisasi);
        $this->render('modules/hibah/detail', $data);
    }

    public function rincian($id = NULL)
    {
        $data['hibah'] = $this->hibah->get($id);
        # RINCIAN
        $data['kiba'] = $this->kiba->get_data_hibah($data['hibah']->id);
        $data['kibb'] = $this->kibb->get_data_hibah($data['hibah']->id);
        $data['kibc'] = $this->kibc->get_data_hibah($data['hibah']->id);
        $data['kibd'] = $this->kibd->get_data_hibah($data['hibah']->id);
        $data['kibe'] = $this->kibe->get_data_hibah($data['hibah']->id);
        $data['kibg'] = $this->kibg->get_data_hibah($data['hibah']->id);
        $data['kpt'] = $this->kapitalisasi->get_data_hibah($data['hibah']->id);
        $data['total_rincian'] = $this->hibah->get_total_rincian($id);

        $this->render('modules/hibah/rincian', $data);
    }

    public function delete($id = null)
    {
        if(empty($id))
            show_404();

        $sukses = $this->hibah->delete($id);
        if($sukses) {
            $this->kiba->delete_by(array('id_hibah'=>$id));
            $this->kibb->delete_by(array('id_hibah'=>$id));
            $this->kibc->delete_by(array('id_hibah'=>$id));
            $this->kibd->delete_by(array('id_hibah'=>$id));
            $this->kibe->delete_by(array('id_hibah'=>$id));
            $this->kibg->delete_by(array('id_hibah'=>$id));
            $this->kapitalisasi->delete_by(array('id_hibah'=>$id));

            $this->message('Data berhasil dihapus','success');
            $this->go('hibah/index');
        } else {
            $this->message('Data gagal dihapus','danger');
            $this->go('hibah/index');
        }
    }

    public function rincian_redirect($id = null)
    {
        if (empty($id))
            show_404();

        $jenis = $this->input->post('jenis');

        switch ($jenis) {
            case 'a':
                $this->go('hibah/kiba/add/' . $id);
                break;
            case 'b':
                $this->go('hibah/kibb/add/' . $id);
                break;
            case 'c':
                $this->go('hibah/kibc/add/' . $id);
                break;
            case 'd':
                $this->go('hibah/kibd/add/' . $id);
                break;
            case 'e':
                $this->go('hibah/kibe/add/' . $id);
                break;
            case 'g':
                $this->go('hibah/kibg/add/' . $id);
                break;
            case 'tambah':
                $this->go('hibah/kapitalisasi/add/langkah_1/' . $id);
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
        $sukses = $this->hibah->update($id, $data);
        if($sukses) {
            $this->message('Pengajuan Berhasil','success');
            $this->go('hibah/index/detail/'.$id);
        } else {
            $this->message('Terjadi kesalahan', 'danger');
            $this->go('hibah/index/detail/'.$id);
        }
    }

    public function cancel_transaction($id = NULL)
    {
        if(empty($id))
            show_404();

        $data   = array('status_pengajuan'=>0);
        $sukses = $this->hibah->update($id, $data);
        if($sukses) {
            $this->message('Pengajuan Berhasil dibatalkan','success');
            $this->go('hibah/index/detail/'.$id);
        } else {
            $this->message('Terjadi kesalahan', 'danger');
            $this->go('hibah/index/detail/'.$id);
        }
    }
}