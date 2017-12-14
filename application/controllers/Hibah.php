<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hibah extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Hibah_model', 'hibah');
        $this->load->model('Organisasi_model', 'organisasi');
        $this->load->model('Kegiatan_model', 'kegiatan');

        $this->load->model('aset/Kiba_model', 'kiba');
        $this->load->model('aset/Kibb_model', 'kibb');
        $this->load->model('aset/Kibc_model', 'kibc');
        $this->load->model('aset/Kibd_model', 'kibd');
        $this->load->model('aset/Kibe_model', 'kibe');
        $this->load->model('aset/Kibnon_model', 'kibnon');
        $this->load->model('Kapitalisasi_model', 'kapitalisasi');

    }

    public function index()
    {
        $this->load->library('Pagination');

        $filter = $this->input->get();
        $result = $this->hibah->get_data($filter);
        $filter['id_organisasi'] = isset($filter['id_organisasi']) ? $filter['id_organisasi'] : '';

        $data['hibah'] = $result['data'];
        $data['filter'] = $filter;
        $data['organisasi'] = $this->organisasi->get_data_by_auth();
        $data['pagination'] = $this->pagination->get_pagination($result['data_count'], $filter, get_class($this));
        $data['kegiatan'] = $this->kegiatan->get_data_by_organisasi($filter['id_organisasi']);
        $this->render('modules/hibah/index', $data);
    }

    public function add_hibah()
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

    public function insert_hibah()
    {
        $data = $this->input->post();
        if (!$this->hibah->form_verify($data)) {
            $this->message('Isi data yang diperlukan', 'danger');
            $this->go('hibah?id_organisasi=' . $data['id_organisasi']);
        }
        $sukses = $this->hibah->insert($data);
        if ($sukses) {
            $this->message('Data berhasil disimpan', 'success');
            $this->go('hibah/detail/' . $sukses);
        } else {
            $this->message('Terjadi kesalahan', 'danger');
            $this->go('hibah?id_organisasi=' . $data['id_organisasi']);
        }
    }

    public function update_hibah()
    {
        $data = $this->input->post();
        $id = $data['id'];

        unset($data['id']);

        if (!$this->hibah->form_verify($data)) {
            $this->message('Isi data yang diperlukan', 'danger');
            $this->go('hibah/detail/' . $id);
        }

        $sukses = $this->hibah->update($id, $data);
        if ($sukses) {
            $this->message('Data berhasil disunting', 'success');
            $this->go('hibah/detail/' . $id);
        } else {
            $this->message('Terjadi kesalahan', 'danger');
            $this->go('hibah/detail/' . $id);
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
        $data['kpt'] = $this->kapitalisasi->get_data_hibah($data['hibah']->id);

        $this->render('modules/hibah/rincian', $data);
    }

    public function rincian_redirect($id = null)
    {
        if (empty($id))
            show_404();

        $jenis = $this->input->post('jenis');

        switch ($jenis) {
            case 'a':
                $this->go('aset/kiba/add_hibah/' . $id);
                break;
            case 'b':
                $this->go('aset/kibb/add_hibah/' . $id);
                break;
            case 'c':
                $this->go('aset/kibc/add_hibah/' . $id);
                break;
            case 'd':
                $this->go('aset/kibd/add_hibah/' . $id);
                break;
            case 'e':
                $this->go('aset/kibe/add_hibah/' . $id);
                break;
            case 'non':
                $this->go('aset/kib_non/add_hibah/' . $id);
                break;
            case 'tambah':
                $this->go('kapitalisasi/add_hibah/langkah_1/' . $id);
                break;

            default:
                show_404();
                break;
        }
    }
}