<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Koreksi_nilai extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Koreksi_model', 'koreksi');
		$this->load->model('Organisasi_model', 'organisasi');
	}
	
	public function index()
	{
		$data['organisasi'] = $this->organisasi->get_many_by(array('jenis'=>4));
		$this->render('modules/koreksi/nilai/index', $data);
	}

	public function rincian()
	{
		$this->render('modules/koreksi/nilai/rincian');
	}

	public function rincian_redirect()
    {
        $jenis = $this->input->post('jenis');
        $id    = $this->input->post('id');

        if(empty($id))
            show_404();

        switch ($jenis) {
            case 'a':
            $this->go('koreksi/koreksi_nilai/add_kiba/'.$id);
            break;

            default:
            show_404();
            break;
        }
    }

    public function add_kiba()
    {
		$this->render('modules/koreksi/nilai/kiba');
    }
}