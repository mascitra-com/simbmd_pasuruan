<?php
/**
 * Created by PhpStorm.
 * User: Rizki Herdatullah
 * Date: 10/12/2017
 * Time: 21.20
 */

class Transfer extends MY_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('Transfer_model', 'transfer');
		$this->load->model('Organisasi_model', 'organisasi');
		$this->load->library('pagination');
	}

	public function index() {
		show_404();
	}

	public function keluar() {
		$filter = $this->input->get();
		$data['organisasi'] 	 = $this->organisasi->get_data(array('jenis' => 4));
		$filter['id_organisasi'] = isset($filter['id_organisasi']) ? $filter['id_organisasi'] : '';

		# Jika bukan superadmin
		if (!$this->auth->get_super_access()) {
			$filter['id_organisasi'] = $this->auth->get_id_organisasi();
			$data['organisasi'] 	 = $this->organisasi->get_many_by('id', $filter['id_organisasi']);
		}

		$result = $this->transfer->get_data($filter);
		$data['transfer'] 	= $result['data'];
		$data['pagination'] = $this->pagination->get_pagination($result['data_count'], $filter, get_class($this));
		$data['filter']   	= $filter;
		$this->render('modules/transfer/keluar', $data);
	}

	public function masuk() {
		$filter = $this->input->get();
		$data['organisasi'] = $this->organisasi->get_data(array('jenis' => 4));
		$filter['id_organisasi'] = isset($filter['id_organisasi']) ? $filter['id_organisasi'] : '';

		# Jika bukan superadmin
		if (!$this->auth->get_super_access()) {
			$filter['id_organisasi'] = $this->auth->get_id_organisasi();
			$data['organisasi'] = $this->organisasi->get_many_by('id', $filter['id_organisasi']);
		}
		$data['filter'] = $filter;
		$this->render('modules/transfer/masuk', $data);
	}

	public function add($id = null) {
		if (empty($id)) {
			$this->message('Pilih UPB Terlebih Dahulu', 'warning');
			$this->go('transfer/keluar');
		}

		$data['organisasi'] = $this->organisasi->get_data(array('jenis' => 4));
		$data['org'] = $this->organisasi->get($id);
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

	public function keluar_rincian($id = null) {
		if (empty($id))
			show_404();

        # RINCIAN
        $data['kiba'] 	  = null;
        $data['kibb'] 	  = null;
        $data['kibc'] 	  = null;
        $data['kibd'] 	  = null;
        $data['kibe']	  = null;
		$data['transfer'] = $this->transfer->subtitute($this->transfer->get($id));
		
		$this->render('modules/transfer/keluar_rincian', $data);
	}


    public function rincian_redirect($id_org = null)
    {
        if(empty($id_org))
            show_404();

        $jenis = $this->input->post('jenis');

        switch ($jenis) {
            case 'a':
                $this->go('aset/kiba/add_transfer/'.$id_org);
                break;
            case 'b':
                $this->go('aset/kibb/add_transfer/'.$id_org);
                break;
            case 'c':
                $this->go('aset/kibc/add_transfer/'.$id_org);
                break;
            case 'd':
                $this->go('aset/kibd/add_transfer/'.$id_org);
                break;
            case 'e':
                $this->go('aset/kibe/add_transfer/'.$id_org);
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
    		$this->go('transfer/add/'.$data['id_organisasi']);
    	}

    	$sukses = $this->transfer->insert($data);
    	if($sukses) {
    		$this->message('Data berhasil ditambah','success');
    		$this->go('transfer/keluar_detail/'.$sukses);
    	} else {
    		$this->message('Terjadi kesalahan', 'danger');
    		$this->go('transfer/add/'.$data['id_organisasi']);
    	}
    }

    public function update()
    {
    	$data = $this->input->post();
    	$id   = $data['id'];
    	unset($data['id']);

    	if (!$this->transfer->form_verify($data)) {
    		$this->message('Isi data yang perlu diisi', 'danger');
    		$this->go('transfer/add/'.$data['id_organisasi']);
    	}

    	$sukses = $this->transfer->update($id, $data);
    	if($sukses) {
    		$this->message('Data berhasil ditambah','success');
    		$this->go('transfer/keluar_detail/'.$id);
    	} else {
    		$this->message('Terjadi kesalahan', 'danger');
    		$this->go('transfer/keluar_detail/'.$id);
    	}
    }
}