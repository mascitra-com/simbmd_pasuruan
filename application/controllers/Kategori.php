<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Kategori_model', 'kategori');
	}
	
	public function index()
	{
		$data['kategori'] = $this->kategori->get_data_list(array('jenis'=>1));
		$this->render('modules/kategori/index', $data);
	}

	public function bidang($id = null)
	{
		$data['kategori'] = $this->kategori->get_data_list(array('jenis'=>2,'sub_dari'=>$id));
		$data['induk'] 	  = $this->kategori->get($id);
		$this->render('modules/kategori/index_bidang', $data);
	}

	public function kelompok($id = null)
	{
		$data['kategori'] = $this->kategori->get_data_list(array('jenis'=>3,'sub_dari'=>$id));
		$data['induk'] 	  = $this->kategori->get($id);
		$this->render('modules/kategori/index_kelompok', $data);
	}

	public function subkelompok($id = null)
	{
		$data['kategori'] = $this->kategori->get_data_list(array('jenis'=>4,'sub_dari'=>$id));
		$data['induk'] 	  = $this->kategori->get($id);
		$this->render('modules/kategori/index_subkelompok', $data);
	}

	public function subsubkelompok($id = null)
	{
		$data['kategori'] = $this->kategori->get_data_list(array('jenis'=>5,'sub_dari'=>$id));
		$data['induk'] 	  = $this->kategori->get($id);
		$this->render('modules/kategori/index_subsubkelompok', $data);
	}

	public function get_by()
	{
		$data = $this->input->get();
		$result = $this->kategori->get_data_list($data);
		echo json_encode($result);
	}

	public function add($jenis = null)
	{
		switch ($jenis) {
			case '1':
				$this->render('modules/kategori/form_golongan');
				break;

			case '2':
				$data['induk'] = $this->kategori->get($this->input->get('id'));
				$this->render('modules/kategori/form_bidang', $data);
				break;

			case '3':
				$data['induk'] = $this->kategori->get($this->input->get('id'));
				$this->render('modules/kategori/form_kelompok', $data);
				break;

			case '4':
				$data['induk'] = $this->kategori->get($this->input->get('id'));
				$this->render('modules/kategori/form_subkelompok', $data);
				break;

			case '5':
				$data['induk'] = $this->kategori->get($this->input->get('id'));
				$this->render('modules/kategori/form_subsubkelompok', $data);
				break;
			
			default:
				show_404();
				break;
		}
	}

	public function edit($id = null)
	{
		if (empty($id)) {
			show_404();
		}

		$data['kategori'] = $this->kategori->get($id);

		switch ($data['kategori']->jenis) {
			case '1':
				$this->render('modules/kategori/form_golongan', $data);
				break;

			case '2':
				$this->render('modules/kategori/form_bidang', $data);
				break;

			case '3':
				$this->render('modules/kategori/form_kelompok', $data);
				break;

			case '4':
				$this->render('modules/kategori/form_subkelompok', $data);
				break;

			case '5':
				$this->render('modules/kategori/form_subsubkelompok', $data);
				break;
			
			default:
				show_404();
				break;
		}
	}

	public function insert()
	{
		$data = $this->input->post();
		$ref  = $this->input->get('ref');

		$sukses = $this->kategori->insert($data);
		if($sukses) {
			$this->message('Data berhasil ditambah','success');
			$this->go($ref);
		} else {
			$this->message('Data gagal ditambah','danger');
			$this->go($ref);
		}
	}

	public function update()
	{
		$data = $this->input->post();
		$ref  = $this->input->get('ref');
		$id   = $data['id'];

		unset($data['id']); 

		$sukses = $this->kategori->update($id, $data);
		if($sukses) {
			$this->message('Data berhasil disunting','success');
			$this->go($ref);
		} else {
			$this->message('Data gagal disunting','danger');
			$this->go($ref);
		}
	}

	public function delete($id = null)
	{
		if (empty($id)) {
			show_404();
		}

		$ref = $this->input->get('ref');
		if (empty($ref)) {
			$ref = 'kategori';
		}

		$sukses = $this->kategori->delete($id);
		if($sukses) {
			$this->message('Data berhasil dihapus','success');
			$this->go($ref);
		} else {
			$this->message('Data gagal dihapus','danger');
			$this->go($ref);
		}
	}
}