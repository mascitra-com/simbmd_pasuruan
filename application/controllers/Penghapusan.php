<?php
/**
 * Created by PhpStorm.
 * User: Rizki Herdatullah
 * Date: 12/12/2017
 * Time: 13.59
 */

class Penghapusan extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Organisasi_model', 'organisasi');
    }

    public function index()
    {
        $filter = $this->input->get();
        $data['organisasi'] = $this->organisasi->get_data_by_auth();

        $filter['id_organisasi'] = 172;
        $data['filter'] = $filter;
        $data['id_organisasi'] = 172;

        $this->render('modules/penghapusan/index', $data);
    }

    public function add($id = null)
    {
        if (empty($id)) {
            $this->message('Pilih UPB Terlebih Dahulu', 'warning');
            $this->go('penghapusan');
        }
        $data['organisasi'] = $this->organisasi->get_data(array('jenis' => 4));
        $data['org'] = $this->organisasi->get($id);
        $data['hapus'] = null;
        $this->render('modules/penghapusan/form', $data);
    }

    public function detail($id = null) {
        if (empty($id)) {
            show_404();
        }

        $data['id_transfer'] = $id;
        $data['id_organisasi'] = 172;
        $data['organisasi'] = $this->organisasi->get_data(array('jenis' => 4));
        $data['org'] = $this->organisasi->get($id);
        $this->render('modules/penghapusan/detail', $data);
    }

    public function rincian($id = null)
    {
        if (empty($id)) {
            show_404();
        }
        # RINCIAN
        $data['kiba'] 	= null;
        $data['kibb'] 	= null;
        $data['kibc'] 	= null;
        $data['kibd'] 	= null;
        $data['kibe'] 	= null;
        $data['kibnon'] = null;
        $data['id_transfer'] = $id;
        $data['id_organisasi'] = 172;
        $this->render('modules/penghapusan/rincian', $data);
    }

    public function rincian_redirect($id_org = null)
    {
        if(empty($id_org))
            show_404();

        $jenis = $this->input->post('jenis');

        switch ($jenis) {
            case 'a':
                $this->go('aset/kiba/add_penghapusan/'.$id_org);
                break;
            case 'b':
                $this->go('aset/kibb/add_penghapusan/'.$id_org);
                break;
            case 'c':
                $this->go('aset/kibc/add_penghapusan/'.$id_org);
                break;
            case 'd':
                $this->go('aset/kibd/add_penghapusan/'.$id_org);
                break;
            case 'e':
                $this->go('aset/kibe/add_penghapusan/'.$id_org);
                break;
            default:
                show_404();
                break;
        }
    }
}